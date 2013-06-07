<div class="tabbable tabs-left">
	<ul class="nav nav-tabs">
		<li <? _checkActive('list', 'tab'); ?>><a href="#list" data-toggle="tab">Custom field list</a></li>
		<li <? _checkActive('create', 'tab'); ?>><a href="#create" data-toggle="tab">Create field</a></li>
	</ul>

	<div class="tab-content">
		<? echo $this->template->notice; ?>
		
		<div class="tab-pane <? _checkActive('list', 'tab', 'active'); ?>" id="list">
			<table class="table table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th>Row ID</th>
						<th>Name</th>
						<th>Default value</th>
					</tr>
				</thead>
				<tbody><? foreach ($fields as $field): ?>
					<tr>
						<td><? echo anchor(CodeFire::ADMINCP . 'users/custom/edit/' . $field->id, $field->key); ?></td>
						<td><? echo $field->name; ?></td>
						<td class="muted"><? echo $field->required ? '<span class="label label-info">required</span>' : $field->default; ?></td>
					</tr>
				<? endforeach; ?></tbody>
				<tfoot>
					<tr>
						<td colspan="4"><small>Total fields listed: <? echo count($fields); ?></small></td>
					</tr>
				</tfoot>
			</table>
		</div>

		<div class="tab-pane <? _checkActive('create', 'tab', 'active'); ?>" id="create">
			<? /*echo $this->auth->view('forms/group', array(
				'url' => CodeFire::ADMINCP . 'users/groups/create',
				'submit' => 'Create group',

				'title' => set_value('name'),
				'rank' => set_value('rank'),
				'description' => set_value('description')
			));*/ ?>
		</div>
	</div>
</div>