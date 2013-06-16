<style type="text/css" media="screen">
    #activity-background {
        background-image: url(<?php echo $this->config->base_url(); ?><?php echo $cover; ?>);
    }
    @media (max-width:720px){
        #activity {
            background-image: url(<?=$this->config->base_url()?><?=str_replace('activities','activities_m',$cover)?>);
            background-position: 85% 20%;
        }
    }
    .activity-color {
        color: <?php echo $light_color; ?> !important;
    }
    .activity-color-dark {
        color: <?=$dark_color?> !important;
        text-shadow: none;
    }
    .activity-color-block {
        background-color: <?php echo $light_color; ?> !important;
        background-image: url(<?=site_url('images/gradient2.png')?>) !important;
        background-position: top;
        background-repeat: repeat-x;
        border-color: <?php echo $dark_color; ?> !important;
        text-shadow: 0px 0px 3px rgba(0,0,0,0.7);
    }
    @media (min-width:721px){
        .activity-color-block {
            background-color: <?php echo $light_color_rgba; ?> !important;
            background-image: none !important;
        }
    }
    .activity-color-block-dark {
        background-color: <?php echo $dark_color; ?> !important;
        background-image: none !important;
        border-color: #000 !important;
        text-shadow: 0px 0px 3px rgba(0,0,0,0.7);
    }
    .avatar-background {
        background-image: url(<?php echo $this->config->base_url(); ?>/images/avatar.png) !important;
    }
    @media (min-width:721px){
        .progress-bar {
    		background-color: <?php echo $light_color; ?> !important;
        }
        #level {
            background-color: <?php echo $dark_color; ?> !important;
        }
    }
    .level {
        border: 1px solid <?php echo $dark_color; ?> !important;
        text-shadow: 0px 0px 3px rgba(0,0,0,0.7);
    }
    .activity-color-button {
        background-image: url('@{imagePath}icons/16x16.png');
        background-repeat: no-repeat;
        background-position: 7px 50%;
        background-color: <?php echo $light_color; ?>;
        box-shadow: inset 1px 1px 0px rgba(255,255,255,0.40), inset -1px -1px 0px rgba(255,255,255,0.40), 0px 2px 0px <?php echo $dark_color; ?>;
    }
    .activity-color-button:hover {
        background-color: <?php echo $light_color; ?>;
        box-shadow: inset 1px 1px 7px rgba(255,255,255,0.75), inset -1px -1px 7px rgba(255,255,255,0.75), 0px 2px 0px <?php echo $dark_color; ?>;
    }
    .activity-color-button:active {
        box-shadow: inset 1px 1px 3px rgba(0,0,0,0.25), inset -1px -1px 3px rgba(0,0,0,0.25);
        background-color: <?php echo $dark_color; ?>;
    }
    
    #submit-wrapper {
        background-color: <?php echo $dark_color; ?>;
    }
    a.activity-color:hover {
        color: <?php echo $light_color; ?>;
    }
    a.activity-color:active {
        color: <?php echo $dark_color; ?>;
    }
    #small-header a:hover {
        color: <?php echo $light_color; ?>;
    }
    #small-header a:active {
        color: <?php echo $dark_color; ?>;
    }

    #small-header a.button:hover, #small-header a.button:active {
        color: white;
    }
</style>  