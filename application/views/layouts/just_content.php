
<?php $this->load->view('templates/header'); ?>
<div id="main-wrapper">
	<div class="header activity-color-block">
        <h2><?php if (isset($title)) { echo $title.' | ' ; } ?>Offf!</h2>
        <a id="start" class="button" href="<?=site_url('start')?>">Ontdek!</a>
    </div>
	<div id="main">
	    <div class="content">
	    	<h3><?=$title?></h3>
	    	<?php $this->load->view($view); ?>
	    </div>
	    <div class="clear"></div>
	</div>
</div>
<?php $this->load->view('templates/footer'); ?>