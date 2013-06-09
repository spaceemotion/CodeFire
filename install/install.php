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
		</style>
	</head>

	<body>
		<div class="container box">
			<?php

			if(empty($_POST)) : ?>
				
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

						<p>&nbsp;</p>
						
						<input type="submit" class="btn btn-primary" value="I am ready to install!" />
						<input type="reset" class="btn" value="Reset all entered data" />
					</fieldset>
				</form>
			
			<? else:

				function s($txt) { echo '<dd><span class="label label-success">Success</span> ' . $txt . '</dd>'; }
				function e($txt) { echo '<dd><span class="label label-important">Error</span> ' . $txt . '</dd>'; }

				$host = $_POST["host"];
				$user = $_POST["user"];
				$pass = $_POST["pass"];
				$db = $_POST["db"];
				$prefix = $_POST["prefix"];

				try {
					echo '<dl>';
					echo '<dt>Connecting to database...</dt>';

					$conn = new PDO("mysql:dbname=$db;host=$host", $user, $pass);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					s("Connected to database!");

					echo '<br /><dt>Executing mysql queries...</dt>';
					$conn->query(str_replace('%prefix%', $prefix, file_get_contents(BASE . 'install.tmpl.sql')));
					s("Added tables and default values!");

					echo '<br /><dt>Writing configuration file...</dt>';
					$file = file_get_contents(BASE . 'config.tmpl.php');
					$file = str_replace('%host%', $host, $file);
					$file = str_replace('%user%', $user, $file);
					$file = str_replace('%pass%', $pass, $file);
					$file = str_replace('%db%', $db, $file);
					$file = str_replace('%prefix%', $prefix, $file);

					if(!@file_put_contents(BASE . '../application/config/database.php', $file)) {
						throw new Exception("Error writing file. Please check permissions!");
					}

					s("Wrote database details to config file!");

					echo '</dl><div class="alert alert-info">';
						echo '<strong>Success!</strong><br />';
						echo 'To completely finish the installation, please remove the <code>install</code> folder and reload the page!';
					echo '</div>';

				} catch(Exception $ex) {
					e("Something went wrong: " . $ex->getMessage());

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
