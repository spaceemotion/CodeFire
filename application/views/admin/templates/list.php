<div class="content">
	<table class="table table-striped table-condensed table-hover no-margin">
		<colgroup>
			<col width="20" />
			<col width="25%" />
			<col width="10%" />
			<col width="20%" />
			<col width="*" />
		</colgroup>
		<thead>
			<tr>
				<th></th>
				<th>Name</th>
				<th>Version</th>
				<th>Author</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody><?php

			foreach($templates as $name => $template)
			{
				echo '<tr>';
				echo '<td></td>';
				echo '<td>' . anchor(CodeFire::ADMINCP . 'templates/view/'. $name, $template['name']) . '</td>';
				echo '<td>' . $template['version'] . '</td>';
				echo '<td>' . $template['author'] . '</td>';
				echo '<td>' . $template['description'] . '</td>';
				echo '</tr>';
			}

		?></tbody>
		<tfoot>
			<tr>
				<td colspan="5"><small>Total templates installed: <? echo count($templates); ?></small></td>
			</tr>
		</tfoot>
	</table>
</div>