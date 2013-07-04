<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? echo form_open($url, 'class="form-horizontal"', isset($key_id) ? array('key_id' => $key_id) : NULL); ?>
	<table class="table table-striped">
		<colgroup>
			<col width="35%" />
			<col width="*" />
		</colgroup>
		<thead>
			<tr>
				<th colspan="2">Access key details</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><label for="key">Identifier</label></td>
				<td><? echo form_input('key', $key, 'maxlength="24" id="key"'); ?></td>
			</tr>
			<tr>
				<td><label for="name">Key name</label></td>
				<td><? echo form_input('name', $name, 'maxlength="32" id="name"'); ?></td>
			</tr>
			<tr>
				<td><label for="description">Description</label></td>
				<td><? echo form_textarea('description', $description, 'id="description"'); ?></td>
			</tr>
		</tbody>
	</table>

	<div class="pull-left"><? echo form_reset('', 'Reset', 'class="btn"'); ?></div>
	<div class="pull-right"><? echo form_submit('submit', $submit, 'class="btn btn-success"'); ?></div>

	<div class="clearfix"></div>
<? echo form_close(); ?>