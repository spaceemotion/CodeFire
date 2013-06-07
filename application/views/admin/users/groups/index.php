<div class="tabbable tabs-left">
	<ul class="nav nav-tabs">
		<li <? _checkActive('list', 'tab'); ?>><a href="#list" data-toggle="tab">Group list</a></li>
		<li <? _checkActive('create', 'tab'); ?>><a href="#create" data-toggle="tab">Create group</a></li>
	</ul>

	<div class="tab-content">
		<? echo $this->template->notice; ?>
		
		<div class="tab-pane <? _checkActive('list', 'tab', 'active'); ?>" id="list">
			<table class="table table-striped table-condensed table-hover no-margin">
				<colgroup>
					<col width="20" />
					<col width="7%" />
					<col width="25%" />
					<col width="*" />
				</colgroup>
				<thead>
					<tr>
						<th></th>
						<th>Rank</th>
						<th>Title</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody><?php

					foreach($groups as $group)
					{
						echo '<tr>';

						echo '<td>';
						if($group->id == '' . CodeFire::getSetting('user', 'defaultGroup'))
						{
							echo '<i class="icon icon-star" title="Default user group"></i>';
						}
						elseif ($group->id == '' . CodeFire::getSetting('user', 'guestGroup'))
						{
							echo '<i class="icon icon-eye-open" title="Guest group"></i>';
						}
						echo '</td>';

						echo '<td>' . $group->rank . '</td>';
						echo '<td>' . anchor(CodeFire::ADMINCP . 'users/groups/edit/' . $group->id, $group->title) . '</td>';
						echo '<td>' . $group->description . '</td>';
						echo '</tr>';
					}

				?></tbody>
				<tfoot>
					<tr>
						<td colspan="4"><small>Total groups listed: <? echo count($groups); ?></small></td>
					</tr>
				</tfoot>
			</table>
		</div>

		<div class="tab-pane <? _checkActive('create', 'tab', 'active'); ?>" id="create">
			<? echo $this->auth->view('forms/group', array(
				'url' => CodeFire::ADMINCP . 'users/groups/create',
				'submit' => 'Create group',

				'title' => set_value('name'),
				'rank' => set_value('rank'),
				'description' => set_value('description')
			)); ?>
		</div>
	</div>
</div>