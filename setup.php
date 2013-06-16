<?php 
include('hax0r.php');
$index = rand(0,count($data)-1);
$data = $data[$index];
?> <!-- database connection will be here -->
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta charset=utf-8>
        <link rel="stylesheet" type="text/css" media="screen" href="stylesheets/css/main.css">
        <style type="text/css" media="screen">
            #activity-background {
                background-image: url('images/activities/<?php echo $data[1]; ?>');
            }
            .activity-color {
                color: <?php echo $data[2]; ?> !important;
            }
            .activity-color-block {
                color: <?php echo $data[4]; ?>;
                background-color: <?php echo $data[2]; ?> !important;
                background-color: <?php echo $data[3]; ?> !important;
                border-color: <?php echo $data[4]; ?> !important;
            }
            .avatar-background {
                background-image: url(../../images/avatar.png) !important;
            }
            .progress {
                background-color: <?php echo $data[4]; ?> !important;
            }
            .level {
                background-color: <?php echo $data[2]; ?> !important;
            }
        </style>   
        <script src="//code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>   
        <script src="javascripts/plugins/jquery.scrollTo-min.js" type="text/javascript"></script>     
        <script src="javascripts/main.js" type="text/javascript"></script>
        <title><?php echo $data[0]; ?></title>
 
        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
 
    </head>
    <body>
        <div id="details">
            <div class="header activity-color-block">
                <h2 style="bottom: 40px;">Setup</h2>
            </div>
            <div class="content">
                <h3>Setup</h3>
                <p>Door de onderstaande informatie in te vullen kunnen wij uw kind aan het begin van het traject zoon passend mogelijke activiteiten aanbieden. Dit maakt de kans dat hij of zij het traject afmaakt het grootst.</p>
                <form action="index.php" method="post" accept-charset="utf-8">
                    <h4>Geslacht</h4>
                    <p>
                        <input type="radio" name="geslacht" value="man" placeholder="man"> Man
                        <input type="radio" name="geslacht" value="vrouw" placeholder="vrouw"> Vrouw
                    </p>
                    <h4>Interesses</h4>
                    <p>Gescheiden met een komma ,</p>
                    <p><input type="text" name="interests" value="" placeholder="Welke sites, games, hobbies, sporten etc." style="width: 300px;"></p>
                    <h4>Mate van internet gebruik</h4>
                    <p>Normaal <input type="radio" name="piu" value="1"> <input type="radio" name="piu" value="2"> <input type="radio" name="piu" value="3"> <input type="radio" name="piu" value="4"> <input type="radio" name="piu" value="5"> Erg veel</p>
                </form>
            </div>
        </div>
    </body>
</html>