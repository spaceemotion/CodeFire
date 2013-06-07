<table class="table table-striped table-condensed table-hover no-margin">
	<colgroup>
		<col width="35%" />
		<col width="35%" />
		<col width="20%" />
		<col width="10%" />
	</colgroup>
	<thead>
		<tr>
			<th>Username</th>
			<th>Email</th>
			<th>Group</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody><? foreach($users as $user): ?>
		<tr>
			<td><? echo anchor(CodeFire::ADMINCP . 'users/manage/edit/' . $user->id, $user->username); ?></td>
			<td><? echo $user->email; ?></td>
			<td></td>

			<!-- User status -->
			<td>
				<? if($user->activated < 1) echo '<i class="icon icon-lock" title="User not activated"></i>'; ?>
				<? if($user->banned > 0) echo '<i class="icon icon-ban-circle" title="User is banned"></i>'; ?>
			</td>
		</tr>
	<? endforeach; ?></tbody>
	<tfoot>
		<tr>
			<td colspan="4"><small>Total users listed: <? echo count($users); ?></small></td>
		</tr>
	</tfoot>
</table>