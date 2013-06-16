<div id="queue">
	<?php $points = isset($user['points']) ? $user['points'] : 0; ?>	
	<?php foreach($queues as $_queue) { ?>

	<div class="message">
		<?php if ($_queue['value']) { ?><div class="points activity-color-block fade-out"><?=$_queue['value']?>@</div><?php } ?>
		<div class="description-wrapper fade-out">
			<div class="arrow"></div>
			<div class="description">
				<h3 class="activity-color"><?=$_queue['title']?></h3>
				<p><?=$_queue['description']?></p>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>

	<?php $points -= $_queue['value']; if ($points<=0) { $points = 9999999999; ?>
	<div class="message">
		<div class="description-wrapper fade-out level-up">
			<div class="arrow"></div>
			<div class="description">
				<h4>Level up!</h4>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<?php } ?>

	<?php } ?>

</div>