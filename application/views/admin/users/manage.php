<ul class="nav nav-tabbed" id="myTab"><?php
	$tabs = array(
		'Manage' => 'manage',
		'Groups' => 'groups',
		'Access keys' => 'access',
		'User fields' => 'fields',
		'Configuration' => 'config'
	);

	foreach($tabs as $name => $site) {
		echo '<li' . (startsWith($active, $site) ? ' class="active"' : '') . '>';
		echo anchor(CodeFire::ADMINCP . 'users/' . $site, $name);
		echo '</li>';
	}
?></ul>

<div class="tab-content tabbed"><?php echo $content; ?></div>