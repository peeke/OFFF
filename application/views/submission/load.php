<div id="submission<?=$id?>" class="submission margins">
	<img src="<?=site_url($author['avatar'])?>" class="inline-avatar">
	<h4><?=$title?></h4>
	<p style="margin-top: -10px;">
		Door <a href="<?=site_url('profile/'.$user_id);?>"><?=$author['name']; ?> (<?=$author['level']; ?>)</a>
	</p>
	<div class="clear"></div>
	<div class="like-wrapper clear">
		<?php if ($user_id == $this->session->userdata('logged_in_user')) { ?> 
		<div class="center-text">
			<a class="icon pencil pull-right" href="<?=site_url('submission/edit/'.$id)?>" title="">Bewerken</a><br>
			<span class="small-text">+<?=$likes?>@</span>
		</div>
	<?php } else { ?>
		<div class="center-text">
			<?php if (isset($liked) && $liked) { ?>
			<a class="small button toggled" href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><br>
			<span class="small-text">+<?=$likes?>@</span>
			<?php } else { ?>
			<a class="ajaxSubmit like small button" href="#" data-like-counter="like-counter-<?=$id?>" data-ajax="<?=site_url('like/set/'.$id)?>">+1@</a><br>
			<span id="like-counter-<?=$id?>" class="small-text">+<?=$likes?>@</span>
			<?php } ?>
		</div>
	<?php } ?>
	</div>
	<div class="slides">
		<?php 
		foreach($images as $_image) {
			$size = getimagesize(site_url($_image['url']));
			echo '<img src="'.site_url($_image['url']).'" width="'.$size[0].'" height="'.$size[1].'">';
		}
		?>
	</div>

	<!--p><?=$iembed?></p-->
	<p><?=$body?></p>
	<div class="disqus-comments">
		<?php if (isset($slug)) { ?>
		<a class="small button foldout" href="#" title="">Comments</a>
		<?php $share_url = site_url('activity/'.$slug).urlencode('#submission'.$id); ?>
		<a class="icon facebook" href="https://www.facebook.com/dialog/feed?app_id=172229782938829&link=<?=$share_url?>&picture=<?=$this->config->base_url().$cover?>&name=<?=$title?>&caption=Offf!&description=<?=$description?>&redirect_uri=http://www.peekekuepers.nl/sandbox/afst/" target="_blank" style="margin-right: 10px;">Delen</a>
		<a class="icon twitter" href="https://twitter.com/intent/tweet?text=<?=rawurlencode(substr($description, 0, (104-strlen($slug))).'...')?>&hashtags=offf,<?=str_replace('_', '', $slug)?>&url=<?=$share_url?>" title="">Tweeten</a> 
		<?php } else if (isset($activity)) { ?>
		<p>
			<a href="<?=site_url('activity/'.$activity['slug'])?>" class="blue button">Dit lijkt mij ook wel wat</a>
		</p>
		<?php } ?>
		<div class="widget">
			<iframe class="auto-height" src="<?=site_url('widget/disqus/'.$id);?>"></iframe>
		</div>
	</div>
</div>
