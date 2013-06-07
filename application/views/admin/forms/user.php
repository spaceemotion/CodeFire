<? echo form_open($url, 'class="row-fluid"', array('type' => 'details')); ?>
	<table class="table table-striped">
		<colgroup>
			<col width="35%" />
			<col width="*" />
		</colgroup>
		<thead>
			<tr>
				<th colspan="2">General information</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><label for="username">Username *</label></td>
				<td><? echo form_input('username', $username, 'id="username"'); ?></td>
			</tr>
			<tr>
				<td><label for="email">Email *</label></td>
				<td><? echo form_input('email', $email, 'id="email"'); ?></td>
			</tr>
			<tr>
				<td><label for="password">Password *</label></td>
				<td><? echo form_password('password', '', 'id="password"'); ?></td>
			</tr>

			<? if(!isset($admin)): ?>
				<tr>
					<td><label for="password_conf">Password confirmation *</label></td>
					<td><? echo form_password('password_conf', '', 'id="password_conf"'); ?></td>
				</tr>
			<? else: ?>
				<tr>
					<td><label for="group">User group *</label></td>
					<td><? echo form_dropdown('group', $groups, $group, 'id="group"'); ?></td>
				</tr>
			<? endif; ?>
			
			<? if(isset($admin) && !isset($create)): ?>
				<tr>
					<td><label for="activated">Activated</label></td>
					<td><? echo form_checkbox('activated', null, $activated != 0, 'id="activated"'); ?></td>
				</tr>
				<tr>
					<td><label for="banned">Banned</label></td>
					<td><? echo form_checkbox('banned', null, $banned != 0, 'id="banned"'); ?></td>
				</tr>
				<tr>
					<td><label for="ban_reason">Ban-Reason</label></td>
					<td><? echo form_textarea('ban_reason', $ban_reason, 'id="ban_reason"'); ?></td>
				</tr>
			<? endif; ?>
		</tbody>
	</table>

	<? if(count($fields) > 0): ?>
		<table class="table table-striped">
			<colgroup>
				<col width="35%" />
				<col width="*" />
			</colgroup>
			<thead>
				<tr>
					<th colspan="2">Additional information</th>
				</tr>
			</thead>
			<tbody><? foreach($fields as $field): ?>
				<tr>
					<td><? echo $field->name . ($field->required ? ' *' : ''); ?></td>
					<td><? echo form_input($field->key, isset($data) ? $data[$field->id - 1]->data : set_value($field->key, $field->default)); ?></td>
				</tr>
			<? endforeach; ?></tbody>
		</table>
	<? endif; ?>

	<div class="pull-left"><? echo form_reset('', 'Reset', 'class="btn btn-small pull-right"'); ?></div>
	<div class="pull-right"><? echo form_submit('submit', $submit, 'class="btn btn-small btn-success pull-right"'); ?></div>
<? echo form_close(); ?>
