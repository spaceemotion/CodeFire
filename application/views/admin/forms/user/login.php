<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php echo form_open(); ?>
	Username/Email:<br />
	<input type="text" name="username" value="<?php echo set_value('username'); ?>" size="50" class="form" /><?php echo form_error('username'); ?><br /><br />
	
	Password:<br />
	<input type="password" name="password" value="<?php echo set_value('password'); ?>" size="50" class="form" /><?php echo form_error('password'); ?><br /><br />
	
	<input type="submit" value="Login" name="login" /> Not a member yet? <? echo anchor('users/register', 'Register now!'); ?>
<? echo form_close(); ?>