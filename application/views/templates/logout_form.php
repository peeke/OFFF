<div id="logout-form">
	<?php 
		$hidden = array('ref'=>current_url());
		echo form_open('user/logout', '', $hidden);
		echo form_submit('submit','Logout...');
		echo form_close();
	?>
</div>