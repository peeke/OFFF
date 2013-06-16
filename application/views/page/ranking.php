<div class="content">
	<img src="<?=site_url($ranked_user['avatar'])?>" class="inline-avatar">
	<h3 style="margin-top: 5px;"><?=$ranked_user['name']?></h3>
	<p class="intro"><?=$ranked_user['name']?> is level <?=$ranked_user['level']?> met <?=$ranked_user['points']?> punten. In totaal heeft <?=$ranked_user['name']?> <?php 
		$points_total = $ranked_user['points'];
		for ($i=1; $i<=$ranked_user['level']-1; $i+=1) {
			$points_total += ($ranked_user['level']-1)*11-6;
		}
		echo $points_total;
	?> punten moeten scoren om dit level te bereiken.</p>
	<h3>Verdiende privileges</h3>
	<p>Privileges zijn unieke handelingen die je kunt vrijspelen door je level te vergroten</p>
	<div id="privileges">
		<div class="requirement clear"><span>Level 2</span></div>
		<div class="achievement pull-left"></div>
		<div class="privilege pull-left">
			<h4 style="margin-left: 10px; margin-top: 15px;">Comments geven op inzendingen</h4>
		</div>

		<div class="requirement clear"><span>Level 3</span></div>
		<div class="achievement pull-left"></div>
		<div class="privilege pull-left">
			<h4 style="margin-left: 10px; margin-top: 15px;">&Aacute;lle beschikbare activiteiten bekijken</h4>
		</div>

		<div class="requirement clear"><span>Level 4</span></div>
		<div class="achievement pull-left"></div>
		<div class="privilege pull-left">
			<h4 style="margin-left: 10px; margin-top: 15px;">Suggesties doen voor nieuwe activiteiten</h4>
		</div>

		<div class="requirement clear"><span>Level 5</span></div>
		<div class="achievement pull-left"></div>
		<div class="privilege pull-left">
			<h4 style="margin-left: 10px; margin-top: 15px;">Z&eacute;lf nieuwe activiteiten toevoegen!</h4>
		</div>

		<div class="requirement clear"><span>Level 6</span></div>
		<div class="achievement pull-left"></div>
		<div class="privilege pull-left">
			<h4 style="margin-left: 10px; margin-top: 15px;">Meestemmen voor de wekelijkse feature</h4>
		</div>

		<div class="requirement clear"><span>Level 7</span></div>
		<div class="achievement pull-left"></div>
		<div class="privilege pull-left">
			<h4 style="margin-left: 10px; margin-top: 15px;">???</h4>
		</div>

		<div class="clear"></div>
	</div>
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
	<h4>Erebadges</h4>
	<p>Je hebt nog geen erebadges verdient.</p>
	<h4>Prestaties</h4>
	<div class="achievements">
		<?php foreach($achievements as $_achievement) { ?>
		<div class="achievement">
			<?php if ($_achievement['completed']) { ?>
			<?php if ($_achievement['activity_id']>0) { ?><a href="<?=site_url('activity/'.$_achievement['slug'])?>" title=""><?php } ?>
				<img src="<?=site_url('images/achievements/'.$_achievement['slug'].'.jpg')?>" title="<?=$_achievement['title']?>">
			<?php if ($_achievement['activity_id']>0) { ?></a><?php } ?>
			<?php } ?>
		</div>
		<?php } ?>
	</div>
	<div class="clear"></div>
	<div class="margins">
		<h4>Topspelers</h4>
		<p>Jouw positie in het klassement</p>
		<p>
			<ol>
				<?php $i=0; foreach($top_players as $_top_player) { $i+=1; ?>
				<li>
					<img src="<?=site_url($_top_player['avatar'])?>" style="width: 20px; height: 20px; margin-right: 10px;" class="pull-left">
					<a href="<?=site_url('profile/'.$_top_player['id'])?>">#<?=$i?> <?=$_top_player['name']?></a>
					<div class="pull-right"><?=$_top_player['level']?></div>
				</li>
				<?php } ?>
				<?php if($ranking>3) { ?>
				<li>
					<img src="<?=site_url($user['avatar'])?>" style="width: 20px; height: 20px; margin-right: 10px;" class="pull-left">
					<a href="<?=site_url('profile/'.$user['id'])?>">#<?=$ranking?> <?php echo $user['name']; ?></a>
					<div class="pull-right"><?=$user['level']?></div>
				</li>
				<?php } ?>
			</ol>
		</p>
	</div>
</div>