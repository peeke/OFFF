<?php if ($this->session->userdata('logged_in')) { ?>
<div class="profile">
    <!--a href="<?=site_url('profile')?>" class="button activity-color-button"><?=$user['name']?></a-->
    <a href="<?=site_url('profile')?>" class="edit button hide-on-mobile"></a>
    <a href="<?=site_url('user/logout')?>" class="logout button hide-on-mobile"></a>
    <a href="<?=site_url('profile')?>" class="avatar" style="padding: 0;">
        <img src="<?=site_url($user['avatar'])?>">
    </a>
    <?php if (isset($user['level'])) { ?>
    <a href="<?=site_url('page/ranking')?>" id="level" class="center-text" style="padding: 0;">
        <div class="progress-bar hide-on-mobile" style="width: <?=$user['progress_bar_start']; ?>%;" data-target="<?php $t = ($user['points']/($user['level']*11-6))*100; if ($t>100) { echo 100; } else { echo $t; } ?>"></div>
        <div style="position: relative; z-index: 10;">Level<br><span class="large-text"><?php echo isset($user['level']) ? $user['level'] : 0; ?></span><br><?=$user['points']?>/<?=($user['level']*11-6)?>@</div>
    </a>
    <?php } ?>
</div>

<!-- login controls when logged in -->
<div class="profile-related hide-on-mobile">
    <a href="<?=site_url('page/ranking')?>" class="button">Prestaties</a> 
    <!--a href="<?=site_url('page/achieved')?>" class="button">Voltooide acties</a-->
</div>
<?php } else { ?>
<div class="profile mobile-only">
    <a href="<?=site_url('user/login')?>" style="padding: 0;">Inloggen</a><span style="float:left; line-height:30px;">&nbsp;of&nbsp;</span><a href="<?=site_url('user/upgrade')?>"  style="padding: 0; margin-right: 15px;">Registreren</a>
    
</div>
<!-- full login controls -->
<div class="profile-related hide-on-mobile hide-below-1000">
    <?php 
        echo validation_errors();

        $hidden = array('ref'=>current_url());
        echo form_open('user/login', '', $hidden);
    ?>
        <div class="pull-right">
            <input class="small dark pull-left" type="text" name="email" value="" placeholder="Emailadres">
            <input class="small dark pull-left" type="password" name="password" value="" placeholder="Wachtwoord">
            <input class="hidden" type="submit" name="submit" value="">
            <a class="button submit blue" href="#" title="">Login!</a>
            <a class="button" href="<?=site_url('user/upgrade');?>" title="">Registreren</a>
        </div>
        

        <div class="clear"></div>
    <?php 
        echo form_close();
    ?>
</div>

<!-- reduced login controls below 1000px -->
<div class="profile-related hide-on-mobile show-below-1000">
    <a class="button blue" href="<?=site_url('user/login')?>" title="">Login!</a>
    <a class="button" href="<?=site_url('user/upgrade');?>" title="">Registreren</a>
</div>
<?php } ?>
