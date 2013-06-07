<div id="register">
	<h2>Register</h2>
	<div class="box"><? echo $this->auth->view('forms/user', array(
		'url' => null,
		'submit' => 'Register',

		'username' => set_value('username'),
		'email' => set_value('email')
	)); ?></div>
</div>