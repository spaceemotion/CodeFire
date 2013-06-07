<? echo form_open(null, 'class="form-horizontal big"'); ?>
<div class="tabbable tabs-left">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#general" data-toggle="tab">General</a></li>
		<li><a href="#defaults" data-toggle="tab">Defaults</a></li>
	</ul>

	<div class="tab-content">
		<? echo $this->template->notice; ?>
		
		<div class="tab-pane active" id="general">
			<h4>Site registration</h4>
		
			<div class="control-group">
				<label class="control-label" for="allowed">
					<b>Users can register</b><br />
					<small>If this option is disabled, no new users can register</small>
				</label>
				<div class="controls">
					<? echo form_checkbox(array('id' => 'allowed', 'placeholder' => 'Email')); ?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="activation">
					<b>Account activation</b><br />
					<small>Users need to click on a link in an activation mail to activate their account on the first time</small>
				</label>
				<div class="controls">
					<? echo form_checkbox(array('id' => 'activation', 'placeholder' => 'Email')); ?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="captcha">
					<b>Captcha</b><br />
					<small>Displays an image displaying random text the user has to enter to verify his humanity.</small>
				</label>
				<div class="controls">
					<? echo form_dropdown('captcha', array(
						'none' => 'No captcha',
						'image' => 'Basic image'
					), 'image'); ?>
				</div>
			</div>
		</div>

		<div class="tab-pane" id="defaults">
			<h4>User defaults</h4>

			<div class="control-group">
				<label class="control-label" for="allowed">
					<b>Default guest group</b><br />
					<small>Default group assigned to not registered users</small>
				</label>
				<div class="controls">
					<? echo form_dropdown('guestGroup', array(
						'none' => 'No captcha',
						'image' => 'Basic image'
					), 'image'); ?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="allowed">
					<b>Default registered group</b><br />
					<small>Default group assigned to registered users</small>
				</label>
				<div class="controls">
					<? echo form_dropdown('defaultGroup', array(
						'none' => 'No captcha',
						'image' => 'Basic image'
					), 'image'); ?>
				</div>
			</div>
		</div>

		<div class="control-group">
			<div class="control-label">
				<? echo form_reset('', 'Reset', 'class="btn"'); ?>
			</div>
			
			<div class="controls">
				<? echo form_submit('', 'Save changes', 'class="btn btn-success"'); ?>
			</div>
		</div>
	</div>
</div>

<? echo form_close(); ?>
