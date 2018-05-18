<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yihua
 * Date: 11/11/2017
 * Time: 5:29 PM
 */

include_once("./system_files/language.php");
require_once("./system_files/general.php");
require_once("./config/config.php");

$hostUrl = $_SERVER[HTTP_HOST];

?>

<?php echoHader('
<style>
.error-template {padding: 40px 15px;text-align: center;height: 51vh}
.error-template h1{color: white !important;}
.error-template p{color: white !important;}
.error-template h2 {color: red}
.error-actions {margin-top:15px;margin-bottom:15px;}
.error-actions .btn { margin-right:10px; }</style>
', false, false, false,$siteProfile); ?>

<body id="top" class="homeStyleSix style6">


<!-- allWrapper-->
<div class="allWrapper">

    <?php echoNavbar(0,$langArray,$siteProfile); ?>


    <div class="errorBody clearfix section errorBg" id="errorBody">
        <div class="sectionWrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="error-template errorContents text-center">
                            <img src="//<?php echo $hostUrl?>/site_files/images/media/page-not-found.png" alt="Error Image">
                            <h1><?php echo $langArray['error404String1'];?></h1>
                            <h2><?php echo $langArray['error404String2'];?></h2>
                            <p><?php $actualLink = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                echo  $actualLink ?></p>
                            <h4><?php echo $langArray['error404String3'];?></h4>
                            <a href="<?php echo $rootUrl ?>" class="goback">
                                <i class="fa fa-long-arrow-left" aria-hidden="true"></i><?php echo $langArray['error404String4'];?></a>
                        </div><!--end of fourOfourimage-->
                    </div><!--end of col12-->
                </div><!--end of error404contents-->
            </div><!--end of container-->
        </div><!--end of sectionWrapper-->
    </div><!--end of erorr404-->


    <!-- Main Footer -->
    <?php echoFooter($siteProfile); ?>

    <!-- Off-Canvas View Only -->
    <?php echoNavbarMobile($langArray,0); ?>


    <div id="toTop" class="hidden-xs">
        <i class="fa fa-chevron-up"></i>
    </div> <!-- totop -->

</div><!-- end of allWrapper -->

<?php echoScript("",$siteLanguage); ?>


</body>

</html>
