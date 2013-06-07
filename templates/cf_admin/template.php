<?php
	// Add stylesheets
	Assets::add_css('bootstrap.min.css', $this->template);
	Assets::add_css('template.css', $this->template);

	// Add javascript
	Assets::add_script('jquery-2.0.1.min.js', $this->template);
	Assets::add_script('bootstrap.min.js', $this->template);
	// Assets::add_script('holder.js', $this->template));

	$this->load->helper('html');

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
							//'pages' => array('Pages', 'book'),
							'users/manage' => array('Users', 'user'),
							//'extensions' => array('Modules', 'file'),
							//'settings' => array('Settings', 'cog')
						);

						foreach($navbar as $element => $config) {
							$active = $element == (isset($page) ? startsWith($element, $page[0]) : false);

							echo '<li' . ($active ? ' class="active"' : '') . '>';
							echo anchor(CodeFire::ADMINCP . $element, '<i class="icon-' . $config[1] . ($active ? '' : ' icon-white') . '"></i> <span>' . $config[0] . '</span>');
							echo '</li>';
						}
					?></ul>
				</div>
			</div>
		</div>

		<!-- Content -->
		<div class="wrapper container">
			<ul class="muted breadcrumb">
				<li>You are here: </li>
				<?php
					$link = substr(CodeFire::ADMINCP, 0, -1);

					for($i = 0, $s = count($page); $i < $s; $i++) {
						$link .= '/' . $page[$i];

						echo $i == $s - 1 ? '<li class="active">' : '<li>';
						echo anchor($link, ucfirst($page[$i]));

						if($i < $s - 1) echo '<span class="divider">/</span>';
						
						echo '</li>';
					}
				?>
			</ul>

			<?php echo $this->template->content; ?>
		</div>

		<!-- Footer -->
		<div class="footer muted container">
			&copy; 2013 by SpaceEmotion - Site rendered in {elapsed_time} seconds.
			Powered by <? echo anchor('http://ellislab.com/codeigniter/', 'CodeIgniter', 'class="red"'); ?>
		</div>

		<!-- Javascript -->
		<?php echo $this->template->javascript; ?>
		<script type="text/javascript">
			$('#tooltip').each().tooltip();
		</script>
	</body>
</html>