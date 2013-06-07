<h4>
	Edit user

	<small>User-ID: <? echo $user->id; ?></small>

	<div class="pull-right">
		<? echo single_button_form(CodeFire::ADMINCP . 'users/manage/delete', array('value' => 'Delete user', 'class' => 'btn-danger btn-small'), array('user_id' => $user->id)); ?>
	</div>
</h4>

<div class="row-fluid">
	<!-- General information -->
	<div class="span6">
		<? echo $this->auth->view('forms/user', array(
			'url' => CodeFire::ADMINCP . 'users/manage/edit/' . $user->id,
			'submit' => 'Save changes',

			'admin' => true,

			'username' => $user->username,
			'email' => $user->email,
			'activated' => $user->activated,
			'banned' => $user->banned,
			'ban_reason' => $user->ban_reason,

			'group' => $user->group_id,
			'groups' => $groups,

			'data' => $data
		)); ?>
	</div>

	<!-- Access keys -->
	<div class="span6">
		<table class="table table-striped table-hover">
			<colgroup>
				<col width="5" />
				<col width="*" />
				<col width="25%" />
			</colgroup>
			<thead>
				<tr>
					<th colspan="3">Access Keys</th>
				</tr>
			</thead>
			<tbody><?php foreach($keys as $key): ?>
				<tr>
					<td><?php echo single_checkbox_form(CodeFire::ADMINCP . 'users/access/set',
						$key->allow == 1 ? true : false,
						$key->group > 0,
						array(
							'id' => $user->id,
							'key_id' => $key->key_id
						));
					?></td>

					<td>
						<? echo anchor(CodeFire::ADMINCP . 'users/access/edit/' . $key->key_id, $key->key); ?>
					</td>

					<td><? if($key->group == 0): ?>
							<? echo single_button_form(CodeFire::ADMINCP . 'users/access/revoke',
								array('value' => 'Revoke', 'class' => 'btn-small btn-link'),
								array('user_id' => $user->id, 'key_id' => $key->key_id)
							); ?>
						<? else: ?>
							<small class="muted">Group priv.</small>
						<? endif; ?>
					</td>
				</tr>
			<? endforeach; ?></tbody>
		</table>

		<h5>Add access key</h5>
		<? echo form_open(CodeFire::ADMINCP . 'users/access/add/' . $user->id, '', array('id' => $user->id)); ?>
			<div class="input-append">
				<? echo form_input('key', '', 'maxlength="24" placeholder="Enter access key identifier"'); ?>
				<? echo form_submit('action', 'Grant', 'class="btn btn-success"'); ?>
				<? echo form_submit('action', 'Deny', 'class="btn btn-danger"'); ?>
			</div>
		<? echo form_close(); ?>
	</div>
</div>