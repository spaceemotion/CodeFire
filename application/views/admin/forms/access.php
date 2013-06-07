<? echo form_open($url, 'class="form-horizontal" style="margin-top:10px"', isset($key_id) ? array('key_id' => $key_id) : NULL); ?>
	<div class="control-group">
		<label class="control-label" for="key">Identifier</label>
		<div class="controls">
			<? echo form_input('key', $key, 'maxlength="24" class="input-xlarge" id="key"'); ?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="name">Key name</label>
		<div class="controls">
			<? echo form_input('name', $name, 'maxlength="32" class="input-xlarge" id="name"'); ?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="description">Description</label>
		<div class="controls">
			<? echo form_input('description', $description, 'maxlength="64" class="input-xxlarge" id="description"'); ?>
		</div>
	</div>

	<div class="control-group">
		<div class="control-label">
			<? echo form_reset('', 'Reset', 'class="btn"'); ?>
		</div>
		<div class="controls">
			<? echo form_submit('submit', $submit, 'class="btn btn-success"'); ?>
		</div>
	</div>
<? echo form_close(); ?>