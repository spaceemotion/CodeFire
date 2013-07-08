<?php
	// Add stylesheets
	Assets::add_css('bootstrap.min.css', $this->template);
	Assets::add_css('template.css', $this->template);

	// Add javascript
	Assets::add_script('bootstrap.min.js', $this->template);

?><!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<? echo $this->template->meta; ?>

		<title><? echo $this->template->title; ?></title>

		<? echo $this->template->stylesheet; ?>
	</head>
	<body>
		<!-- Header -->
		<div class="header container">
			<div class="row">
				<? echo anchor('admin', 'CodeFire', 'class="span4 logo"'); ?>

				<div class="span8">
					<div class="user">
						Welcome back, <? echo username(); ?> :: <? echo anchor('logout', 'Logout &raquo;', 'class="red"'); ?>
					</div>

					<ul class="inline"><?
						$navbar = array(
							'dashboard' => array('Dashboard', 'home'),
							'pages' => array('Pages', 'book'),
							'users/manage' => array('Users', 'user'),
							'templates' => array('Templates', 'picture'),
							'extensions' => array('Modules', 'file'),
							'settings' => array('Settings', 'cog')
						);

						foreach($navbar as $element => $config) {
							$active = isset($page) ? startsWith($element, $page[0]) : false;

							echo '<li' . ($active ? ' class="active"' : '') . '>';
							echo anchor(CodeFire::ADMINCP . $element, '<i class="icon-' . $config[1] . ($active ? '' : ' icon-white') . '"></i> <span>' . $config[0] . '</span>');
							echo '</li>';
						}
					?></ul>
				</div>
			</div>
		</div>

		<? echo $this->template->layout; ?>

		<!-- Footer -->
		<div class="footer muted container">
			&copy; 2013 by SpaceEmotion - Site rendered in {elapsed_time} seconds.
		</div>

		<!-- jQuery -->
		<script src="<? echo Assets::get_script('jquery-2.0.1.min.js', $this->template); ?>"></script>

		<!-- Custom Javascript -->
		<?php echo $this->template->javascript; ?>
	</body>
</html>