<div>
	<h3>Alle acties</h3>
	<p class="intro">&Aacute;lle acties op een rijtje, handig!</p>
	<?php echo form_open('activity/index'); ?>
	<input type="submit" name="submit" class="hidden">
	<p>
		<input type="text" name="query" class="small pull-left" value="<?=set_value('query');?>" placeholder="Zoeken" style="margin-right: 5px;">
		<a href="#" class="submit blue button">Zoeken</a>
		<?php if ($this->input->post('query')) { ?>
			<a href="<?=site_url('activity/index')?>" class="button">Zoekopdracht wissen</a>
		<?php } ?>
	</p>
	<div class="clear"></div>
	<?php echo form_close(); ?>
</div>

<div style="margin-top: 50px;">
	<?php foreach($activities as $_activity) { ?>

	<div class="pull-left" style="max-width: 282px; margin-right: 1px; overflow: hidden;"> 
		<a href="<?=site_url('activity/'.$_activity['slug'])?>" class="activity-thumb image-button">
			<span class="title" style="color: <?=$_activity['light_color']?>"><?=$_activity['title']?></span>
			<img src="<?=site_url(str_replace('activities','activities_m',$_activity['cover']))?>">
		</a>
	</div>

	<?php } ?>
</div>