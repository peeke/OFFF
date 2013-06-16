<a id="repeat" class="repeat button" href="<?=site_url('start');?>"></a>
<div id="activity-background"></div>
<div id="activity">
    <div class="header">
        <div class="like-controls">
            
            <a class="explore large button white activity-color-dark" href="#">Verken deze actie!</a>
            <div class="like-count">x<?php echo $likes; ?></div>
        </div>
    </div>
    <div class="title">
        <h1 class="activity-color"><?php echo $title; ?></h1>
    </div>
    <div class="description-wrapper">
        <div class="description pull-left">
            <h4 class="pull-left">Wat is het?</h4>
            <a class="explore small button activity-color-button pull-left" href="#" style="margin-left: 50px; position: relative; top: -2px;">Ontdek meer</a>
            <div class="clear"></div>
            <?=$description?><br>
            <span class="clear"></span>
        </div>
        <div class="social pull-right">
            <?php $share_url = site_url('activity/'.$slug); ?>
            <a class="small button twitter" href="https://twitter.com/intent/tweet?text=<?=rawurlencode(substr($description, 0, (104-strlen($slug))).'...')?>&hashtags=offf,<?=str_replace('_', '', $slug)?>&url=<?=$share_url?>" title="">Delen op Twitter</a> 
            <a class="small button facebook" href="https://www.facebook.com/dialog/feed?app_id=172229782938829&link=<?=$share_url?>&picture=<?=$this->config->base_url().$cover?>&name=<?=$title?>&caption=Offf!&description=<?=$description?>&redirect_uri=http://www.peekekuepers.nl/sandbox/afst/" target="_blank">Delen op Facebook</a>
        </div>
    </div>
</div>
<div id="main-wrapper">
    <div class="header activity-color-block">
        <h2><?php echo $title; ?></h2>
    </div>
    <div id="main">
        <div class="content">

            <?php $this->load->view('activity/body/'.$slug) ?>

            <h4>Punten claimen</h4>
            <p>Toon je meester over deze actie en upload hieronder de foto's. De eerste keer verdien je hier <?=$value?>@ punten voor!</p>
            <div id="add-submission">
                <?php $this->load->view('submission/add', array('activity_id'=>$id)); ?>
            </div>

        </div>
        <div class="sidebar">

            <div id="reward" class="box activity-color-block margin-bottom">
                <p class="large-text white center-text"><span class="activity-color-dark">Deze actie is </span><br><?=$value?> @-punten<span class="activity-color-dark"> waard.</span></p>
                <p class="small-text white center-text">Door je foto's van deze actie in te zenden verdien je punten. Wordt de beste speler van de week!</p>
            </div>
            <div id="invite" class="margins">
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
                        ?>
                        </p><p>
                            <form>
                                <input id="invite-name" class="full" type="text" placeholder="Twitter naam of emailadres">
                            </form>
                            </p></p>
                                <a id="invite-twitter" class="small button twitter" href="#" data-hashtags="offf,<?=str_replace('_', '', $slug)?>">Uitnodigen via Twitter</a>
                            <div class="clear"></div>
                    <?php } ?>
                </p>
            </div>
            <div id="ingredients" class="margins">
                <h4>Wat heb je nodig?</h4>
                <p><ul>
                    <?php foreach($ingredients as $_ingredient) {
                        echo '<li>'.$_ingredient.'</li>';
                    } ?>
                </ul></p>
            </div>
            <div id="follow-ups" class="margins">
                <h4>Dit vind je ook leuk</h4>
                <p>Vond je dit wel wat? Bekijk dan ook onderstaande acties eens!</p>    
            </div>
        </div>
        <div class="clear"></div>
        
    </div>
    
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