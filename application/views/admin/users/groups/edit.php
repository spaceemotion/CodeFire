<?php
	// constants
	$URL = CodeFire::ADMINCP . 'users/edit/'.$group->id;
?>
<div class="tabbable tabs-left">
	<ul class="nav nav-tabs">
		<li><? echo anchor(CodeFire::ADMINCP . 'users/groups', 'Group list'); ?></li>
		<li><? echo anchor(CodeFire::ADMINCP . 'users/groups/create', 'Create group'); ?></li>
		<li class="active"><a href="#list" data-toggle="tab">Edit group</a></li>
	</ul>

	<div class="tab-content">
		<? echo $this->template->notice; ?>
		
		<h4>
			Edit group

			<small>Group-ID: <? echo $group->id; ?></small>

			<div class="pull-right">
				<? echo single_button_form(CodeFire::ADMINCP . 'users/groups/delete', array('value' => 'Delete group', 'class' => 'btn-danger btn-small'), array('group_id' => $group->id)); ?>
			</div>
		</h4>

		<div class="row-fluid">
			<!-- General information -->
			<div class="span6">
				<? echo $this->auth->view('forms/group', array(
					'url' => null,
					'submit' => 'Save changes',

					'title' => $group->title,
					'rank' => $group->rank,
					'description' => $group->description
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
								false,
								array(
									'id' => $group->id,
									'key_id' => $key->key_id,
									'group' => true
								));
							?></td>

							<td>
								<? echo anchor(CodeFire::ADMINCP . 'users/access/edit/' . $key->key_id, $key->key); ?>
							</td>

							<td>
								<? echo single_button_form(CodeFire::ADMINCP . 'users/access/revoke',
									array('value' => 'Revoke', 'class' => 'btn-small btn-link'),
									array('user_id' => $group->id, 'key_id' => $key->key_id)
								); ?>
							</td>
						</tr>
					<? endforeach; ?></tbody>
				</table>

				<h5>Add access key</h5>
				<? echo form_open(CodeFire::ADMINCP . 'users/access/add/' . $group->id, '', array('id' => $group->id, 'group' => true)); ?>
					<div class="input-append">
						<? echo form_input('key', '', 'maxlength="24" placeholder="Enter access key identifier"'); ?>
						<? echo form_submit('action', 'Grant', 'class="btn btn-success"'); ?>
						<? echo form_submit('action', 'Deny', 'class="btn btn-danger"'); ?>
					</div>
				<? echo form_close(); ?>
			</div>
		</div>
	</div>
</div>