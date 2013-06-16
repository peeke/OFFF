<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" media="screen" href="<?=$this->config->base_url();?>stylesheets/css/main.css">
	<?php if (isset($load['activity_styles']) && $load['activity_styles'] == true) { $this->load->view('templates/css_activity_styles'); } ?>

	<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
	<!-- jQuery scripts -->
	<script src="//code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>   
	<script src="<?=$this->config->base_url();?>javascripts/plugins/jquery.form.js" type="text/javascript"></script>
	<script src="<?=$this->config->base_url();?>javascripts/plugins/jquery.slides.min.js" type="text/javascript"></script>
	<script src="<?=$this->config->base_url();?>javascripts/plugins/jquery.scrollTo-min.js" type="text/javascript"></script>
	<script src="<?=$this->config->base_url();?>javascripts/main.js" type="text/javascript"></script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-13178611-10', 'offf.nl');
	  ga('send', 'pageview');

	</script>
	<!-- [x] jQuery scripts -->

	<title><?php if (isset($title)) { echo $title.' | ' ; } ?>Site titel</title>


	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>
<body>
	<input id="prevent-space" type="text" name="" value="" placeholder="" style="position: absolute; top: -50px;">
	<?php $this->load->view('templates/queue') ?>
<div id="small-header">
	<a href="<?=site_url('start/small_logo_button')?>" class="large button offf"></a>
	<ul class="main-navigation">
	    <a href="<?=site_url('')?>" class="button hide-on-mobile">Home</a>
	    <a href="<?=site_url('activity/index')?>" class="button hide-on-mobile">&Aacute;lle acties</a>
	</ul>
	<?php $this->load->view('templates/profile_controls'); ?>
</div>
<div id="mobile-menu" class="mobile-only large-text">
    <ul>
        <li><a href="<?=site_url('')?>" class="">Home</a></li>
        <li><a href="<?=site_url('start/mobile_menu')?>" class="">Nieuwe actie</a></li>
        <li><a href="<?=site_url('activity/index')?>" class="">&Aacute;lle acties</a></li>
        <?php if ($this->session->userdata('logged_in')) { ?><li><a href="<?=site_url('profile')?>" class="">Profiel</a></li>
        <li><a href="<?=site_url('page/ranking')?>" class="">Prestaties</a></li><?php } ?>
        <li><?php if ($this->session->userdata('logged_in')) { ?><a href="<?=site_url('user/logout')?>" class="">Uitloggen</a>
        <?php } else { ?><a href="<?=site_url('user/login')?>" >Inloggen</a><?php } ?></li>
    </ul>
    <p>&nbsp;</p>
    <ul>
        <li><a class="toggle-mobile-menu" href="#" class="">Terug</a></li>
    </ul>
</div>