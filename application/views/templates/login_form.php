<div id="login-form">
	<?php 
		echo validation_errors();

		$hidden = array('ref'=>current_url());
		echo form_open('user/login', '', $hidden);
	?>
		<p>
			<input type="text" name="email" value="" placeholder="Emailadres">
		</p>
		<p>
			<input type="password" name="password" value="" placeholder="Wachtwoord">
		</p>
		<p>
			<?=form_submit('submit','Login!')?>
		</p>
	<?php 
		echo form_close();
	?>
	<a href="<?=site_url('user/upgrade');?>" title="">Registreren</a> <a href="<?=site_url('user/forgot_password');?>" title="">Wachtwoord vergeten?</a>
</div>
