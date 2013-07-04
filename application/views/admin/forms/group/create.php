<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<? echo form_open($url, 'class="row-fluid"', array('type' => 'details')); ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th colspan="2">Group information</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><label for="title">Title</label></td>
				<td><? echo form_input('title', $title, 'id="title"'); ?></td>
			</tr>
			<tr>
				<td><label for="rank">Rank</label></td>
				<td><? echo form_input('rank', $rank, 'id="rank"'); ?></td>
			</tr>
			<tr>
				<td><label for="description">Description</label></td>
				<td><? echo form_textarea('description', $description, 'id="description"'); ?></td>
			</tr>
		</tbody>
	</table>

	<div class="pull-left"><? echo form_reset('', 'Reset', 'class="btn btn-small pull-right"'); ?></div>
	<div class="pull-right"><? echo form_submit('submit', $submit, 'class="btn btn-small btn-success pull-right"'); ?></div>
<? echo form_close(); ?>
