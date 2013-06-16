<?php $this->load->view('templates/small_header'); ?>
<div id="activity-background"></div>
<div id="activity">
    <div class="credits">Credits komen hier</div>
    <div class="title">
        <h1 class="activity-color"><?php echo $title; ?></h1>
        <p class="mobile-only white"><?=$value?>@ punten.</p>
        <p>
            <a class="explore large button activity-color-button" href="#main-anchor">Verken deze actie!</a>
            <a class="deny large button" href="<?=site_url('start/re_run')?>">Dit vind ik niks</a> 
            <a class="menu mobile-only toggle-mobile-menu" href="#"><span class="icon dots"></span></a>
        </p>
    </div>
    <div class="clear"></div>
    <div class="description-wrapper hide-on-mobile">
        <div class="description pull-left">
            <div class="arrow"></div>
            <h4>Wat is het?</h4>
            <p>
                <?=$description?>
                <?php $share_url = site_url('activity/'.$slug); ?>
                <a class="icon twitter pull-right" href="https://twitter.com/intent/tweet?text=<?=rawurlencode(substr($description, 0, (104-strlen($slug))).'...')?>&hashtags=offf,<?=str_replace('_', '', $slug)?>&url=<?=$share_url?>" title="" style="margin-left: 10px; margin-top: 16px;">Tweeten</a> 
                <a class="icon facebook pull-right" href="https://www.facebook.com/dialog/feed?app_id=172229782938829&link=<?=$share_url?>&picture=<?=$this->config->base_url().$cover?>&name=<?=$title?>&caption=Offf!&description=<?=$description?>&redirect_uri=http://www.peekekuepers.nl/sandbox/afst/" target="_blank" style="margin-top: 16px;">Delen</a>
            </p>

        </div>
        <!--div class="social pull-right">
            <?php $share_url = site_url('activity/'.$slug); ?>
            <a class="button twitter" href="https://twitter.com/intent/tweet?text=<?=rawurlencode(substr($description, 0, (104-strlen($slug))).'...')?>&hashtags=offf,<?=str_replace('_', '', $slug)?>&url=<?=$share_url?>" title="" style="margin-right: 10px;">Delen op Twitter</a> 
            <a class="button facebook" href="https://www.facebook.com/dialog/feed?app_id=172229782938829&link=<?=$share_url?>&picture=<?=$this->config->base_url().$cover?>&name=<?=$title?>&caption=Offf!&description=<?=$description?>&redirect_uri=http://www.peekekuepers.nl/sandbox/afst/" target="_blank">Delen op Facebook</a>
        </div-->
        <div class="clear"></div>
    </div>
</div>
<div id="main-anchor" class="clear"></div>
<div id="main-wrapper">
    <div class="header activity-color-block">
        <h2><?php echo $title; ?></h2>
    </div>
    <div id="main">
        <div class="content">

            <?php $this->load->view('activity/body/'.$slug) ?>

        </div>
        <div class="sidebar">

            <div id="invite">
                <h4>Aantal personen</h4>
                <p>
                    <?php if ($player_count[count($player_count)-1] == 1) {
                        echo 'Deze actie is voor &eacute;&eacute;n persoon.';
                    } else { 
                        if (count($player_count)>1) {
                            echo 'Deze actie is voor '.$player_count[0].' - '.$player_count[count($player_count)-1].' personen.';
                        } else {
                            echo 'Deze actie is voor '.$player_count[0].' personen';
                        }
                        ?> Nodig iemand uit via twitter!
                        </p><p>
                            <form>
                                <input id="invite-name" class="full" type="text" placeholder="Twitter naam of emailadres">
                            </form>
                            </p></p>
                                <a id="invite-twitter" class="button twitter" href="#" data-hashtags="offf,<?=str_replace('_', '', $slug)?>"><span class="icon twitter-white">Uitnodigen</span></a>
                            <div class="clear"></div>
                    <?php } ?>
                </p>
            </div>
            <!--div id="ingredients" class="margins">
                <h4>Wat heb je nodig?</h4>
                <p><ul>
                    <?php foreach($ingredients as $_ingredient) {
                        echo '<li>'.$_ingredient.'</li>';
                    } ?>
                </ul></p>
            </div-->
            <?php if (count($related)) { ?>
            <div id="follow-ups" class="margins">
                <h4>Dit vind je ook leuk</h4>
                <p>Vond je dit wel wat? Bekijk dan ook onderstaande acties eens!</p>
                <?php foreach($related as $_activity) { ?>
                <p> 
                    <a href="<?=site_url('activity/'.$_activity['slug'])?>" class="activity-thumb image-button">
                        <span class="title" style="color: <?=$_activity['light_color']?>"><?=$_activity['title']?></span>
                        <img src="<?=site_url($_activity['cover'])?>">
                    </a>
                    <div class="clear"></div>
                </p>
                <?php } ?> 
            </div>
            <?php } ?>
        </div>
        <div class="clear"></div>
        <p>
            <a href="#submissions-wrapper" class="button activity-color-button">Ingezonden acties bekijken</a>
        </p>
        <div class="clear"></div>
    </div>
    
</div>
<div id="submit-wrapper">
    <div id="submit">
        <h3 style="margin-bottom: 0.5em;">Inzending doen</h3>
        <div>
            <p>Door je foto's van deze actie in te zenden verdien je punten. Wordt de beste speler van de week! Upload snel hieronder je foto's. </p>
            <div id="add-submission">
                <?php $this->load->view('submission/add', array('activity_id'=>$id)); ?>
            </div>
        </div>
    </div>
    <div id="value">
        <?=$value?>@
    </div>
    <div class="clear"></div>
</div>


<div id="submissions-wrapper">
    <div id="submissions">
        <div>
            <h3>Inzendingen</h3>
            <?php if (!count($submissions)) { ?>
            <p>Doe de eerste inzending en verdien een bonus van 50@-punten!</p>
            <?php } ?>
        </div>
        <?php foreach($submissions as $_submission) {
            $this->load->view('submission/load', $_submission);
        } ?>
        <div class="clear"></div>
    </div>
</div>
<?php $this->load->view('templates/footer'); ?>