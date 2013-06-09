<? echo form_open($url, null, array('id' => $id, 'group' => isset($group), 'redirect' => $redirect)); ?>
	<div class="input-append">
		<? if(isset($select_data)): ?>
			<? echo form_dropdown('key', $select_data); ?>
		<? else: ?>
			<? echo form_input(array(
				'style' => 'margin-top: 0',
				
				'name' => 'key',
				'maxlength' => "24",
				'placeholder' => $placeholder
			)); ?>
		<? endif; ?>
		<? echo form_submit('action', 'Grant', 'class="btn btn-success"'); ?>
		<? echo form_submit('action', 'Deny', 'class="btn btn-danger"'); ?>
	</div>
<? echo form_close();?>