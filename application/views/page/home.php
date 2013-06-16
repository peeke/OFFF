<div class="content">
	<h3>Featured</h3>
	<p class="intro">Iedere week wordt er een ingezonden actie uitgelicht. De inzending van deze week komt van <?=$featured_submission['author']['name']?>.</p>
	<?php $this->load->view('submission/load', $featured_submission); ?>
    
    <h3>Nieuw!</h3>
    <p class="intro">De officiele Offf! button.</p>
    <p>Hang hem via USB aan je computer en geef hem een ram zodra je de verveling aan voelt komen!</p>
    <p>
    	<img src="<?=site_url('images/box.jpg')?>">
    </p>
	
	<div id="submissions">
        <h3>Nieuwste inzendingen</h3>
        <p>Het is niet bij te houden. Dit zijn de laatste inzendingen:</p>
        <?php foreach($latest_submissions as $_submission) {
            $this->load->view('submission/load', $_submission);
        } ?>
        
        <div class="clear"></div>
    </div>
</div>


<div class="sidebar">
	<h4>Topspelers</h4>
	<p>Neem het in het klassement op tegen andere spelers.</p>
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
	<p>
		<a href="<?=site_url('page/ranking')?>" class="pull-right blue button">Het klassement</a>
		<div class="clear"></div>
	</p>
	<div style="margin-top: 50px;">
		<h4>Nieuwste acties</h4>
		<p>Iedere dag komen er nieuwe acties bij. Dit zijn de laatste.</p>
		<?php foreach($latest_activities as $_activity) { ?>
		<p>	
			<a href="<?=site_url('activity/'.$_activity['slug'])?>" class="activity-thumb image-button">
				<span class="title" style="color: <?=$_activity['light_color']?>"><?=$_activity['title']?></span>
				<img src="<?=site_url(str_replace('activities','activities_m',$_activity['cover']))?>">
			</a>
			<div class="clear"></div>
		</p>
		<?php } ?>
		<a href="<?=site_url('activity/index')?>" class="pull-right blue button">&Aacute;lle activiteiten</a>
	</div>

</div>