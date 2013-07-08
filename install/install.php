<?php
	// CodeFire install script
	define('BASE', dirname(__FILE__) . '/');

	// Get base url
	if (isset($_SERVER['HTTP_HOST']))
	{
		$base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
		$base_url .= '://'. $_SERVER['HTTP_HOST'];
		$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
	}
	else
	{
		$base_url = 'http://localhost/';
	}

?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Installation :: CodeFire</title>

		<!-- Le styles -->
		<link href="<? echo $base_url . 'templates/cf_admin/assets/css/bootstrap.min.css'; ?>" rel="stylesheet">
		<link href="<? echo $base_url . 'templates/cf_admin/assets/css/template.css'; ?>" rel="stylesheet">
		<style type="text/css">
			body {
				padding-top: 40px;
				padding-bottom: 40px;
				background-image: none;
				background-color: #f5f5f5;
			}

			.box {
				width: 640px;
				padding: 19px 29px;
				margin: 0 auto 20px;
				background-color: #fff;
				border: 1px solid #e5e5e5;
			}

			.footer {
				width: 640px;
				margin: 0 auto;
				font-size: 12px;
				text-align: center;
			}

			legend { margin-bottom: 0; }
		</style>
	</head>

	<body>
		<div class="container box">
			<?php if(empty($_POST)) : ?>
				<p class="lead"><strong>Welcome to CodeFire!</strong><br />Enter the neccessarry information and hit the install button to get started. It's that simple!</p>

				<form action="<? echo $base_url . 'index.php'; ?>" method="post" class="form-horizontal">
					<fieldset>
						<legend>MySQL login details</legend>
						
						<div class="control-group">
							<label class="control-label" for="host">Host:</label>
							<div class="controls">
								<input type="text" id="host" name="host" value="localhost">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="user">Username:</label>
							<div class="controls">
								<input type="text" id="user" name="user" placeholder="root">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="pass">Password:</label>
							<div class="controls">
								<input type="password" name="pass" id="pass">
								<span class="muted">&nbsp;Can be blank for local installlations</span>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="db">DB-Name:</label>
							<div class="controls">
								<input type="text" id="db" name="db" placeholder="codefire">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="prefix">Table-prefix:</label>
							<div class="controls">
								<input type="text" id="prefix" name="prefix" value="cf_">
							</div>
						</div>
					</fieldset>

					<fieldset>
						<legend>Admin user details</legend>

						<div class="control-group">
							<label class="control-label" for="admin_user">Username:</label>
							<div class="controls">
								<input type="text" id="admin_user" name="admin_user" value="administrator">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="admin_mail">E-Mail:</label>
							<div class="controls">
								<input type="text" id="admin_mail" name="admin_mail">
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="admin_pass">Password:</label>
							<div class="controls">
								<input type="password" name="admin_pass" id="admin_pass">
							</div>
						</div>
					</fieldset>

					<p>&nbsp;</p>
					
					<input type="submit" class="btn btn-primary" value="I am ready to install!" />
					<input type="reset" class="btn pull-right" value="Reset all entered data" />
				</form>
			
			<? else:

				function s($txt) { echo '<dd><span class="label label-success">Success</span> ' . $txt . '</dd>'; }

				function generateRandomString($length = 10) {
					$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$randomString = '';

					for ($i = 0; $i < $length; $i++) {
						$randomString .= $characters[rand(0, strlen($characters) - 1)];
					}

					return $randomString;
				}

				// Database
				$host = $_POST["host"];
				$user = $_POST["user"];
				$pass = $_POST["pass"];
				$db   = $_POST["db"];
				$prefix = $_POST["prefix"];

				// Admin user
				$admin_user = $_POST["admin_user"];
				$admin_pass = $_POST["admin_pass"];
				$admin_mail = $_POST["admin_mail"];

				// Encrypt password
				require_once __DIR__ . '/../application/vendor/PasswordHash.php';
				$pHash = new PasswordHash(8, FALSE);
				$admin_pass = $pHash->HashPassword($admin_pass);

				try {
					echo '<dl>';

					// Check user
					echo '<dt>Checking install conditions...</dt>';
					if(strlen($admin_user) < 6) {
						throw new Exception("The username has to be at least 6 characters long!");
					} else {
						s("Everything seems to be okay!");
					}

					// Database work
					echo '<br /><dt>Connecting to database...</dt>';

					$conn = new PDO("mysql:dbname=$db;host=$host", $user, $pass);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					s("Connected to database!");

					echo '<br /><dt>Executing mysql queries...</dt>';
					$conn->query(str_replace('%prefix%', $prefix, file_get_contents(BASE . 'install.tmpl.sql')));
					s("Added tables and default values!");

					echo '<br /><dt>Writing configuration file...</dt>';

					$dbfile = file_get_contents(BASE . 'database.tmpl.php');
					$dbfile = str_replace('%host%', $host, $dbfile);
					$dbfile = str_replace('%user%', $user, $dbfile);
					$dbfile = str_replace('%pass%', $pass, $dbfile);
					$dbfile = str_replace('%db%', $db, $dbfile);
					$dbfile = str_replace('%prefix%', $prefix, $dbfile);

					if(!@file_put_contents(BASE . '../application/config/database.php', $dbfile)) {
						throw new Exception("Error database writing file. Please check permissions!");
					} else {
						s("Wrote database details to config file!");
					}

					$cfgfile = file_get_contents(BASE . 'config.tmpl.php');
					$cfgfile = str_replace('%key%', generateRandomString(32), $cfgfile);

					if(!@file_put_contents(BASE . '../application/config/config.php', $cfgfile)) {
						throw new Exception("Error config writing file. Please check permissions!");
					} else {
						s("Wrote general config file!");
					}

					

					echo '<br /><dt>Registering admin user...</dt>';
					$conn->query("INSERT INTO ${prefix}users (username, email, password, group_id, activated) VALUES(
						'$admin_user',
						'$admin_mail',
						'$admin_pass',
						1,
						1
					)");

					s("Added admin user!");

					echo '</dl><div class="alert alert-info">';
						echo '<strong>Success!</strong><br />';
						echo 'To completely finish the installation, please remove the <code>install</code> folder and reload the page!';
					echo '</div>';

				} catch(Exception $ex) {
					echo '<dd><span class="label label-important">Error</span> ' . "Something went wrong: " . $ex->getMessage() . '</dd>';

					echo '</dl><div class="alert">';
						echo '<strong>Warning!</strong><br />';
						echo 'Something went wrong during the installation. Please check your details!';
					echo '</div>';
				}

			endif;
		?></div>

		<div class="footer muted">
			&copy; 2013 by SpaceEmotion
		</div>
	</body>
</html>
