<div class="content">
	<img src="<?=site_url($avatar)?>" class="inline-avatar">
	<h3 style="margin-top: 15px;"><?=$name?></h3>
	<p class="intro"><?=$name?> is level <?=$level?> met <?=$points?> punten. In totaal heeft <?=$name?> <?php 
		$points_total = $points;
		for ($i=1; $i<=$level-1; $i+=1) {
			$points_total += ($level-1)*11-6;
		}
		echo $points_total;
	?> punten moeten scoren om dit level te bereiken.</p>
	<div id="submissions" class="margins" style="margin-top: 50px;">
        <div>
            <h3>Inzendingen</h3>
            <?php if (!count($submissions)) { ?>
            <p><?=$name?> heeft nog geen inzendingen gedaan.</p>
            <?php } ?>
        </div>
        <?php foreach($submissions as $_submission) {
            $this->load->view('submission/load', $_submission);
        } ?>
        
        <div class="clear"></div>
    </div>
</div>
<div class="sidebar">
	<?php if ($this->session->userdata('logged_in') && $this->session->userdata('logged_in_user') == $id) { ?>
	<h4>Instellingen</h4>
	<div id="form-error" class="error"></div>
	<?php 
		echo form_open_multipart('user/update_avatar', array('id'=>'update-avatar'));
	?>
		<p id="preview">
			<img src="<?=site_url($avatar); ?>" class="avatar" style="width: 50%; height: auto;">
			<input id="file-upload" type="file" name="userfile">
		</p>
		<div class="clear"></div>
	<?php 
		echo form_close();
	?>
	<p class="red"><?=validation_errors()?></p>
	<?php 
        $hidden = array('ref'=>current_url(), 'email'=>$email);
        echo form_open('profile', '', $hidden)
	?>
		<p>
			<label for="name">Naam</label>
			<input id="name" name="name" type="text" value="<?=validation_errors()?set_value('name'):$name?>">
		</p>
		<p>
			<label for="password">Nieuw wachtwoord</label>
			<input id="password" name="password" type="password">
			<br>Wachtwoord herhalen
			<input name="password_check" type="password">
		</p>
		<p>
			<label for="age">Leeftijd</label>
			<input id="age" name="age" type="number" value="<?=validation_errors()?set_value('age'):$age?>">
		</p>
		<p>
			<label for="interests">Interesses (komma's ertussen)</label>
			<input id="interests" name="interests" type="text" value="<?=validation_errors()?set_value('interests'):$interests?>">
		</p>

		<p>
			<a class="submit button blue" href="#">Opslaan</a>
		</p>

		<input class="hidden" type="submit">

	</form>
	<?php } ?>
</div>