<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yihua
 * Date: 2017-06-13
 * Time: 3:11 PM
 */

function echoHader($css,$title,$description,$keyword,$siteProfile)
{
    $hostUrl = $_SERVER[HTTP_HOST];
    $rootUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";

    echo "
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class=\"no-js IE lt-ie9 lt-ie8 lt-ie7\"></html>
<![endif]-->
<!--[if IE 7]>
<html class=\"no-js IE lt-ie9 lt-ie8\"></html>
<![endif]-->
<!--[if IE 8]>
<html class=\"no-js IE lt-ie9\"></html>
<![endif]-->
<!--[if gt IE 8]>
<html class=\"no-js IE gt-ie8\"></html>
<![endif]-->
<!--[if !IE]><!-->
<html class=\"no-js\" lang=\"UTF-8\">
<!--<![endif]-->

<head>
    <!-- title -->";
    echoTitle($title,$siteProfile);
    echo "
    <!-- meta tags -->
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta content=\"width=device-width,initial-scale=1,maximum-scale=1\" name=\"viewport\">
    <link href=\"".$rootUrl."site_files/images/logos/logo_57x57.jpg\" rel=\"apple-touch-icon-precomposed\">
    <link href=\"".$rootUrl."site_files/images/logos/logo_114x114.jpg\" sizes=\"114x114\" rel=\"apple-touch-icon-precomposed\">
    ";
    echoDescription($description,$siteProfile);
    echoKeywords($keyword,$siteProfile);

    echo "
    <!-- fav icon -->
    <link href=\"//$hostUrl/site_files/images/favicon.ico\" rel=\"shortcut icon\">

    <!-- css => Pretty Photo Style -->
    <link href=\"//$hostUrl/site_files/prettyphoto/prettyPhoto.css\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\">

    <!-- css => Off-canvas Menu Style -->
    <link href=\"//$hostUrl/site_files/css/off-canvas.css\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\">

    <!-- Slider-css =>  Style -->
    <link href=\"//$hostUrl/site_files/slider/css/style.css\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\">
    <link href=\"//$hostUrl/site_files/slider/css/normalize.css\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\">

    <!-- css => Style sheet -->
    <link href=\"//$hostUrl/site_files/style.css\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\">

    <!-- css => Responsive sheet -->
    <link href=\"//$hostUrl/site_files/css/responsive.css\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\">

    <!-- css => FlexSlider 2 -->
    <link href=\"//$hostUrl/site_files/css/flexslider.css\" media=\"screen\" rel=\"stylesheet\" type=\"text/css\">

    <!-- Revolution slider css -->
    <link rel=\"stylesheet\" href=\"//$hostUrl/site_files/rs-plugin/css/settings.css\"/>
    <link rel=\"stylesheet\" href=\"//$hostUrl/site_files/rs-plugin/css/revolution.css\"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src=\"https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js\"></script>
    <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
    <![endif]-->
    <!-- The page required css -->";
    echo $css;
    echo "
</head>";
}



function echoTitle($pageTitle,$siteProfile)
{
    if($pageTitle)
    {
        echo "\r\n"."    <title>$pageTitle - ".$siteProfile->getGoableSiteName()."</title>";
}
else{
    echo "\r\n"."    <title>".$siteProfile->getGoableSiteName()."</title>";
}
}

function echoKeywords($keyword,$siteProfile)
{
    if($keyword)
    {
        echo "\r\n".'    <meta name="keywords" content="'.$keyword.','.$siteProfile->getSiteKeywords().'">'."\n";
    }
    else{
        echo "\r\n".'    <meta name="keywords" content="'.$siteProfile->getSiteKeywords().'">'."\n";
    }
}

function echoDescription($description,$siteProfile)
{
    if($description)
    {
        echo "\r\n".'    <meta name="description" content="'.$description.'">'."\n";
    }
    else{
        echo "\r\n".'    <meta name="description" content="'.$siteProfile->getSiteDescription().'">'."\n";
    }
}


function echoScript($script,$siteProfile)
{
    $hostUrl = $_SERVER[HTTP_HOST];

    echo "
<!-- JavaScript Files ========================== -->
<script src=\"//$hostUrl/site_files/js/jquery-3.1.1.min.js\"></script>
<script src=\"//$hostUrl/site_files/js/jquery-migrate.min.js\"></script>
<script type=\"text/javascript\" src=\"//$hostUrl/site_files/js/jquery-ui-1.12.0.min.js\"></script>

<!-- BootStrap JavaScript ====================== -->
<script src=\"//$hostUrl/site_files/js/bootstrap.min.js\" type=\"text/javascript\"></script>

<!-- isotope Script =============================== -->
<script src=\"//$hostUrl/site_files/js/jquery.isotope.js\"></script>

<!-- Pace Script =============================== -->
<script type=\"text/javascript\" src=\"//$hostUrl/site_files/js/pace.js\"></script>

<!-- Revulation Script =============================== -->
<script src=\"//$hostUrl/site_files/rs-plugin/js/jquery.themepunch.tools.min.js\"></script>
<script src=\"//$hostUrl/site_files/rs-plugin/js/jquery.themepunch.revolution.min.js\"></script>

<script type=\"text/javascript\">
    $('.banner').revolution({
        delay: 16000,
        startwidth: 1170,
        startheight: 891,
        hideThumbs: 200,
        fullWidth: \"on\",
        forceFullWidth: \"on\",
        onHoverStop: \"off\",
        navigationType: \"none\",
        hideTimerBar: \"on\",
        navigationStyle: \"preview2\"
    });

    // Can also be used with $(document).ready()
    $(window).load(function () {
        $('.flexslider').flexslider({
            animation: \"slide\",
            controlNav: \"thumbnails\"
        });
    });
</script>

<!-- Owl Carousel JavaScript =================== -->
<script src=\"//$hostUrl/site_files/js/owl.carousel.min.js\" type=\"text/javascript\"></script>

<!-- Nouislider Script =============================== -->
<script src=\"//$hostUrl/site_files/js/jquery.nouislider.min.js\"></script>

<!-- Hero Slider Script =============================== -->
<script src=\"//$hostUrl/site_files/js/hero-slider.js\"></script>

<!-- slick Script =============================== -->
<script src=\"//$hostUrl/site_files/js/slick.min.js\"></script>

<!-- Slider Script =============================== -->
<script src=\"//$hostUrl/site_files/slider/js/slider.js\"></script>

<!-- slick Script =============================== -->
<script src=\"//$hostUrl/site_files/js/masonry.pkgd.min.js\"></script>

<!-- Pretty Photo Script =============================== -->
<script src=\"//$hostUrl/site_files/prettyphoto/jquery.prettyPhoto.js\"></script>

<!-- Portfolio Script =============================== -->
<script type=\"text/javascript\" src=\"//$hostUrl/site_files/js/portfolio.js\"></script>

<!-- Wow Script =============================== -->
<script src=\"//$hostUrl/site_files/js/wow.js\"></script>

<!-- Parallax Script =============================== -->
<script type=\"text/javascript\" src=\"//$hostUrl/site_files/js/parallax.min.js\"></script>

<!-- Google MAp =============================== -->
<script type=\"text/javascript\" src='//$hostUrl/site_files/js/jquery.mapit.js'></script>
<script type=\"text/javascript\" src='//$hostUrl/site_files/js/gmap3.min.js'></script>

<!-- Offcanvas-Menu Script =============================== -->
<script type=\"text/javascript\" src='//$hostUrl/site_files/js/off-canvas.js'></script>
<script type=\"text/javascript\" src='//$hostUrl/site_files/js/off-canvas-call.js'></script>

<!-- Jquery flexslider2 Script =============================== -->
<script type=\"text/javascript\" src='//$hostUrl/site_files/js/jquery.flexslider-min.js'></script>

<!-- Main Script =============================== -->
<script src=\"//$hostUrl/site_files/js/script.js\" type=\"text/javascript\"></script>

<!-- This Page required Script =============================== -->
$script
";
}