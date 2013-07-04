<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<ul class="nav nav-tabbed" id="myTab"><?php
	$tabs = array(
		'Install' => 'install',
		'Templates' => 'templates',
		'Modules' => 'modules'
	);

	foreach($tabs as $name => $site) {
		echo '<li' . (startsWith($active, $site) ? ' class="active"' : '') . '>';
		echo anchor(CodeFire::ADMINCP . 'extensions/' . $site, $name);
		echo '</li>';
	}
?></ul>

<div class="tab-content tabbed"><?php echo $content; ?></div>