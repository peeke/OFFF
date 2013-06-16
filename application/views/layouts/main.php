<?php $this->load->view('templates/header'); ?>
<div id="main-wrapper" class="main-layout">
	<div id="main">
	    <?php $this->load->view($view); ?>
	    <div class="clear"></div>
	</div>
</div>
<?php $this->load->view('templates/footer'); ?>