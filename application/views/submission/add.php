<div class="page-form">
	<div id="form-error" class="error"></div>
	<?php 
		echo form_open_multipart('submission/upload_images', array('id'=>'submission-images', 'style'=>'padding-top: 4px;'));
	?>

		<!--p class="drag-and-drop"-->
			<a class="file-upload large button" href="#"><span class="icon camera">Foto's uitkiezen</span></a>
			<div class="clear"></div>
			<input id="file-upload" type="file" name="userfile[]" multiple="" class="hidden">
		<!--/p-->
		<p id="preview"><span id="status"></span></p>
		<div class="clear"></div>
	<?php 
		echo form_close();
	?>
	<?php 
		echo form_open_multipart('submission/add_for/'.$activity_id, array('id'=>'submission-form'));
	?>
		<input id="images" type="hidden" name="images" value="">

		<input type="hidden" name="default_title" value="<?=$user['name']?> @ <?=$title?>" class="pull-right">
		<p>
			<label for="submission-title" class="pull-left">Titel</label><input id="submission-title" type="text" name="title" value="<?=validation_errors() ? set_value('title') : $user['name'].' @ '.$title?>" class="full-mobile-only">
		</p>
		<!--p>
			<label for="youtube">youtube video</label> <input id="youtube" class="right" type="text" name="youtube" value="" placeholder="http://www.youtube.com/watch?v=316AzLYfAzw">
		</p--> 
		<p>
			<textarea name="body"><?php echo set_value('body'); ?></textarea>
			<span class="white small">Tags: 
				<span class="tag">&lt;h4&gt;</span>Titel<span class="tag">&lt;/h4&gt;</span>, 
				<span class="tag">&lt;b&gt;</span>Bold<span class="tag">&lt;/b&gt;</span>, 
				<span class="tag">&lt;i&gt;</span>Italic<span class="tag">&lt;/i&gt;</span>, 
			</span>
		</p>
		<p>
			<input class="hidden" type="submit" name="submit" value="">
        	<a class="button submit offf" href="#" title="">Inzenden!</a>
		</p>
	<?php 
		echo form_close();
	?>
</div>