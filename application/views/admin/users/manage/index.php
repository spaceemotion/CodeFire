<div class="tabbable tabs-left">
	<ul class="nav nav-tabs">
		<li <? _checkActive('list', 'tab'); ?>><? echo anchor(CodeFire::ADMINCP . 'users/manage', 'User list'); ?></li>
		<li <? _checkActive('create', 'tab'); ?>><? echo anchor(CodeFire::ADMINCP . 'users/manage/create', 'Create user'); ?></li>

		<? _checkActive('edit', 'tab', '<li class="active">' . anchor($this->uri->uri_string(), 'Edit user') . '</li>'); ?>
	</ul>

	<div class="tab-content">
		<? echo $this->template->notice; ?>
		
		<div class="tab-pane active">
			<? echo $content; ?>
		</div>
	</div>
</div>