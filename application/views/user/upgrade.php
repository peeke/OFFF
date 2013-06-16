<div class="content">
	<h3>Profiel aanmaken</h3>

	<div id="upgrade-form" class="page-form" style="margin-top: 50px;">
		<?php 
			echo validation_errors();
			echo form_open('user/upgrade');
		?>
			<p>
				<label for="name">Naam</label>
				<input id="name" type="text" name="name" value="" placeholder="">
			</p>
			<p>
				<label for="email">Email</label>
				<input id="email" type="text" name="email" value="" placeholder="">
			</p>
			<p>
				<label for="password">Wachtwoord</label>
				<input id="password" type="password" name="password" value="" placeholder="">
			</p>
			<p>
				<label for="age">Leeftijd</label>
				<input id="age" type="number" name="age" value="" placeholder="">
			</p>
			<input type="submit" name="submit" class="hidden">
			<p><a href="#" class="submit blue button">Registreren!</a></p>
			<div class="clear"></div>
		<?php 
			echo form_close();
		?>
		<p><a href="<?=site_url('user/login');?>" title="">Inloggen</a></p>
	</div>
</div>
