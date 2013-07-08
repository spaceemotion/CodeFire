<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="content">
	<? if (isset($name)): ?>
		<h3>View template <span class="pull-right">Make default</span></h3>
		<div class="row-fluid">
			<!-- General information -->
			<div class="span6">
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
						<? if(isset($name)): ?>
							<tr>
								<th>Name</th>
								<td><? echo $name; ?></td>
							</tr>
						<? endif; ?>

						<? if(isset($description)): ?>
							<tr>
								<th>Description</th>
								<td><? echo $description; ?></td>
							</tr>
						<? endif; ?>

						<? if(isset($version)): ?>
							<tr>
								<th>Version</th>
								<td><? echo $version; ?></td>
							</tr>
						<? endif; ?>

						<? if(isset($author)): ?>
							<tr>
								<th>Author</th>
								<td><? echo $author; ?></td>
							</tr>
						<? endif; ?>

						<? if(isset($website)): ?>
							<tr>
								<th>Website</th>
								<td><? echo anchor($website, $website); ?></td>
							</tr>
						<? endif; ?>
					</tbody>
				</table>
			</div>

			<!-- Layout information -->
			<div class="span6">
				<table class="table table-striped">
					<colgroup>
						<col width="25%" />
						<col width="*" />
					</colgroup>
					<thead>
						<tr>
							<th colspan="2">Layout information</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ($layouts as $layout => $positions): ?>
							<tr>
								<th><? echo $layout; ?></th>
								<td>
									<? for ($i = 0; $i < count($positions); $i++): ?>
										<? echo $positions[$i]['name']; ?><br />
									<? endfor; ?>
								</td>
							</tr>
						<? endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	<? else: ?>
		<h3>Invalid template</h3>
		<p>The requested template could not be found.</p>
	<? endif; ?>
</div>