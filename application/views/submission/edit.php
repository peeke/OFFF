<div class="page-form">
	<div id="form-error" class="error"></div>
	<?php 
		echo form_open_multipart('submission/ajax_image_upload', array('id'=>'submission-images'));
	?>
		<p class="drag-and-drop">
			<input id="file-upload" type="file" name="userfile[]" multiple="" title="Klik, of drop je foto's in dit veld">
		</p>
		<div id="preview">
			<?php foreach($images as $_image) { ?>
			<div id="thumb<?=$_image['id']; ?>" class="thumb" data-id="<?=$_image['id']; ?>">
				<img src="<?php echo site_url($_image['url']); ?>">
				<div class="close-button-wrapper">
					<a href="#" class="close-button" data-id="<?=$_image['id']; ?>">X</a>
				</div>
			</div>
			<?php } ?>
		</div>
		<div class="clear"></div>
	<?php 
		echo form_close();
	?>
	<?php 
		echo form_open_multipart('submission/edit/'.$id, array('id'=>'submission-form'));
	?>
		<input id="images" type="hidden" name="images" value="<?php $f = true; foreach($images as $_image) { if(!$f) { echo ','; } echo $_image['id']; $f=false; } ?>">
		<!--p>
			<label for="youtube">youtube video</label> <input id="youtube" class="right" type="text" name="youtube" value="<?php echo set_value('iembed') ? set_value('iembed') : $iembed ; ?>" placeholder="http://www.youtube.com/watch?v=316AzLYfAzw">
		</p--> 
		<p>
			<textarea name="body"><?php echo set_value('body') ? set_value('body') : $body ; ?></textarea>
			<span class="legenda small">Tags: 
				<span class="tag">&lt;h4&gt;</span>Titel<span class="tag">&lt;/h4&gt;</span>, 
				<span class="tag">&lt;b&gt;</span>Bold<span class="tag">&lt;/b&gt;</span>, 
				<span class="tag">&lt;i&gt;</span>Italic<span class="tag">&lt;/i&gt;</span>, 
			</span>
		</p>
	<?php 
		echo form_submit('submit','Plaatsen');
		echo form_close();
	?>
</div>