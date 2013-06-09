<div class="tabbable tabs-left">
	<ul class="nav nav-tabs">
		<li <? _checkActive('list', 'tab'); ?>><a href="#list" data-toggle="tab">Key list</a></li>
		<li <? _checkActive('create', 'tab'); ?>><a href="#create" data-toggle="tab">Create key</a></li>
	</ul>

	<div class="tab-content">
		<? echo $this->template->notice; ?>
		
		<div class="tab-pane <? _checkActive('list', 'tab', 'active'); ?>" id="list">
			<table class="table table-striped table-condensed table-hover no-margin">
				<colgroup>
					<col width="25%" />
					<col width="25%" />
					<col width="*" />
				</colgroup>
				<thead>
					<tr>
						<th>Identifier</th>
						<th>Name</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody><?php

					foreach($keys as $key)
					{
						echo '<tr>';
						echo '<td>' . anchor(CodeFire::ADMINCP . 'users/access/edit/' . $key->id, $key->key) . '</td>';
						echo '<td>' . $key->name . '</td>';
						echo '<td>' . $key->description . '</td>';
						echo '</tr>';
					}

				?></tbody>
				<tfoot>
					<tr>
						<td colspan="4"><small>Total keys listed: <? echo count($keys); ?></small></td>
					</tr>
				</tfoot>
			</table>
		</div>

		<div class="tab-pane <? _checkActive('create', 'tab', 'active'); ?>" id="create">
			<? echo $this->auth->view('forms/access/create', array(
				'url' => CodeFire::ADMINCP . 'users/access/create',
				'submit' => 'Create key',

				'key' => set_value('key'),
				'name' => set_value('name'),
				'description' => set_value('description')
			)); ?>
		</div>
	</div>
</div>