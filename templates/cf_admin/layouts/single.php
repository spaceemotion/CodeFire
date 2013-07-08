<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- Wrapper -->
<div class="wrapper container">
	<!-- Breadcrump -->
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

	<!-- Content -->
	<?php echo $content; ?>
</div>
