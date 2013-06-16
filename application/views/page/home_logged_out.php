<div>
	<div class="content">
		<h3 class="hidden">"Verveel jij je ook zo?</h3>
		<p>
			<img src="<?=site_url('images/stop.png')?>" alt="">
		</p>
		<p class="intro">Zit jij vaak online, maar verveel je je eigenlijk zelfs daar? Offf! is de oplossing.
		</p>
		<p>Offf! is een internet applicatie die het internet weer boeiend maakt. Je vindt er nieuwe, frisse ide&euml;en om te doen. Proberen kan heel eenvoudig zonder account: offf you go!</p>
		<p>&nbsp;</p>
		<p>
			<a href="<?=site_url('start/home')?>" class="large offf button">Meteen beginnen</a>
			<a href="http://apps.facebook.com/offf_app" class="large facebook button">Via Facebook</a>
			<div class="clear"></div>
		</p>
		<div id="submissions" style="margin-top: 75px;">
	        <h3>De laatste inzendingen</h3>
	        <p>De laatste inzendingen, geplaatst door andere jongeren.</p>
	        <?php foreach($latest_submissions as $_submission) {
	            $this->load->view('submission/load', $_submission);
	        } ?>
        	<div class="clear"></div>
    	</div>
	</div>
	<div class="sidebar">
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
		<a href="<?=site_url('activity/index')?>" class="blue button pull-right">&Aacute;lle activiteiten</a>
		<div class="clear"></div>
		<div style="margin-top: 50px;">
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
				</ol>
			</p>
			<p>Registreer een account om in het klassement opgenomen te worden.</p>
		</div>
	</div>
</div>