<div class="tabbable tabs-left">
	<ul class="nav nav-tabs">
		<li><? echo anchor(CodeFire::ADMINCP . 'users/access', 'Key list'); ?></li>
		<li><? echo anchor(CodeFire::ADMINCP . 'users/access/create', 'Create key'); ?></li>
		<li class="active"><a href="#list" data-toggle="tab">Edit Key</a></li>
	</ul>

	<div class="tab-content">
		<? echo $this->template->notice; ?>

		<h4 class="no-margin">
			Edit access key

			<small>Key-ID: <? echo $key->id; ?></small>

			<div class="pull-right">
				<? echo single_button_form(CodeFire::ADMINCP . 'users/access/delete', array('value' => 'Delete key', 'class' => 'btn-danger btn-small'), array('key_id' => $key->id)); ?>
			</div>
		</h4>

		<? echo $this->auth->view('forms/access', array(
			'url' => CodeFire::ADMINCP . 'users/access/edit/' . $key->id,
			'submit' => 'Save',

			'key' => $key->key,
			'name' => $key->name,
			'description' => $key->description,

			'key_id' => $key->id
		)); ?>

		<div class="row-fluid">
			<div class="span6">
				<table class="table table-striped table-hover no-margin">
					<colgroup>
						<col width="5" />
						<col width="*" />
						<col width="25%" />
					</colgroup>
					<thead>
						<tr>
							<th colspan="3">Used by groups</th>
						</tr>
					</thead>
					<tbody><?php foreach($groups as $group): ?>
						<tr>
							<td><?php echo single_checkbox_form(null, $group->allow == 1 ? true : false, false, array(
									'id' => $group->id,
									'key_id' => $key->id,
									'group' => 1
								));
							?></td>

							<td style="padding-top: 11px">
								<? echo anchor(CodeFire::ADMINCP . 'users/groups/edit/' . $group->id, $group->title); ?>
							</td>

							<td>
								<? echo single_button_form(CodeFire::ADMINCP . 'users/access/revoke',
									array('value' => 'Revoke', 'class' => 'btn-small btn-link'),
									array('user_id' => $group->id, 'key_id' => $key->id)
								); ?>
							</td>
						</tr>
					<? endforeach; ?></tbody>
					<tfoot>
						<tr>
							<td colspan="4"><small>Total groups listed: <? echo count($groups); ?></small></td>
						</tr>
					</tfoot>
				</table>
			</div>

			<div class="span6">
				<table class="table table-striped table-hover no-margin">
					<colgroup>
						<col width="5" />
						<col width="*" />
						<col width="25%" />
					</colgroup>
					<thead>
						<tr>
							<th colspan="3">Used by users</th>
						</tr>
					</thead>
					<tbody><?php foreach($users as $user): ?>
						<tr>
							<td><?php echo single_checkbox_form(CodeFire::ADMINCP . 'users/access/set',
								$user->allow == 1 ? true : false,
								false,
								array(
									'id' => $user->id,
									'key_id' => $key->id,
									'key' => true
								));
							?></td>
							
							<td style="padding-top: 11px">
								<? echo anchor(CodeFire::ADMINCP . 'users/manage/edit/' . $user->id, $user->username); ?>
							</td>

							<td>
								<? echo single_button_form(CodeFire::ADMINCP . 'users/access/revoke',
									array('value' => 'Revoke', 'class' => 'btn-small btn-link'),
									array('user_id' => $user->id, 'key_id' => $key->id, 'key' => TRUE)
								); ?>
							</td>
						</tr>
					<? endforeach; ?></tbody>
					<tfoot>
						<tr>
							<td colspan="4"><small>Total users listed: <? echo count($users); ?></small></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>