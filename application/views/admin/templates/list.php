<div class="content">
	<table class="table table-striped table-condensed table-hover no-margin">
		<colgroup>
			<col width="20" />
			<col width="40%" />
			<col width="*" />
		</colgroup>
		<thead>
			<tr>
				<th></th>
				<th>Name</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody><?php

			foreach($templates as $entry)
			{
				/*echo '<tr>';
				echo '<td>' . anchor(CodeFire::ADMINCP . 'users/access/edit/' . $key->id, $key->key) . '</td>';
				echo '<td>' . $key->name . '</td>';
				echo '<td>' . $key->description . '</td>';
				echo '</tr>';*/
			}

		?></tbody>
		<tfoot>
			<tr>
				<td colspan="4"><small>Total templates installed: <? echo count($templates); ?></small></td>
			</tr>
		</tfoot>
	</table>
</div>