<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="alert<? echo $type == 'alert' ? '' : " alert-$type"; ?>">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<? echo $text; ?>
</div>