<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 11/9/2017
 * Time: 10:17 PM
 */

require_once("./system_files/general.php");
require_once("./system_files/classes/HomeClass.php");
require_once("./system_files/classes/House.php");
require_once("./system_files/classes/HouseValue.php");
require_once("./system_files/classes/YihuaPostImage.php");
require_once("./system_files/classes/HouseController.php");
require_once("./system_files/classes/HouseAgent.php");
require_once("./system_files/classes/AgentController.php");

require_once("./config/config.php");


$mHome = new HomeClass($siteLanguage, $yihuapost->getCurrentDB());
?>

<?php echoHader('
<style>
.soldImages
{
    position: relative;
    overflow: hidden;
    height: 150px;
}
@media screen and (max-width: 1024px){
    .soldImages
    {
        height: 250px;
    }
}
.soldImages img {
    display: block;
    height: 100%;
    width: 100%;
}

.promoBox aside {
    z-index: 20;
    position: absolute;
    width: 230px;
    left: 0;
    margin: 0 0 -185px -50px;
    -webkit-transform: rotate(-35deg);
    -khtml-transform: rotate(-35deg);
    -moz-transform: rotate(-35deg);
    -ms-transform: rotate(-35deg);
    transform: rotate(-35deg);
    -webkit-box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.2);
    box-shadow: 0px 3px 5px 0px rgba(0,0,0,0.2);
    text-align: center;
    text-transform: uppercase;
    font-size: 10px;

    color: #fff;
    background: #ff3019;
    background: -moz-linear-gradient(45deg, #ff3019 0%, #cf0404 100%);
    background: -webkit-gradient(linear, left bottom, right top, color-stop(0%,#ff3019), color-stop(100%,#cf0404));
    background: -webkit-linear-gradient(45deg, #ff3019 0%,#cf0404 100%);
    background: -o-linear-gradient(45deg, #ff3019 0%,#cf0404 100%);
    background: -ms-linear-gradient(45deg, #ff3019 0%,#cf0404 100%);
    background: linear-gradient(45deg, #ff3019 0%,#cf0404 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ff3019\', endColorstr=\'#cf0404\',GradientType=1 );

}

.promoBox aside p { padding: 1px 80px 1px 30px; margin: 0; }
.promoBox h4 {
    font-size: 25px;
    margin: 0;
    padding: 0 35% 10px 0;
    line-height: 25px;
    border-bottom: 1px solid #ddd;

}
.promoBox p {
    color: white; 
    font-size: 18px;
    font-weight: bold;
    text-shadow: 2px 2px #3a3a3a;
}



.cd-hero .bgOverly:hover {
    background: rgba(0,0,0,0.5);
}
</style>

', false, false, false, $siteProfile); ?>

<body id="top" class="homeStyleSix style6  pace-done">


<!-- allWrapper-->
<div class="allWrapper">
    <!-- Header -->
    <?php echoNavbar(1, $langArray, $siteProfile); ?>

    <style>
        <?php
            $hotIndexArray = $mHome->getHotIndex();

            if($hotIndexArray)
            {
                $index = 1;
                foreach ($hotIndexArray as $item)
                {
                    echo ($index > 1) ? '.cd-hero-slider li:nth-of-type('.$index.')' : '.cd-hero-slider li:first-of-type';

                    $image = new YihuaPostImage($yihuapost->getCurrentDB());

                    if($image->getSingleImage($item->getMainPic()))
                    {
                     echo "
                    {
                        background-color: black;
                        background-image:url(\"".$image->getFilePath()."\");
                    }";
                    $index++;
                    }
                }
            }
        ?>
    </style>

    <!-- Slider Section Start -->
    <section class="cd-hero">
        <ul class="cd-hero-slider  autoplay">

            <?php
            if ($hotIndexArray) {
                $selected = true;
                foreach ($hotIndexArray as $item) {
                    echo ($selected) ? '<li class="selected">' : '<li>';
                    echo "
                        <div class=\"cd-full-width bgOverly\">
                            <div class=\"container\">
                                <a href='" . $item->getUrlLink() . "'>
                                    <div class=\"BannerCaption text-center\">
                                        <h2>" . $item->getAddress() . "</h2>
                                        <p>" . $item->getTitle() . "</p>
                                        <div class=\"BannerFeature\">
                                            <ul class=\"FeatureList\">
                                                <li><img src=\"site_files/images/icons/bedroom.png\" alt=\"BedRoom Icon\"><span class=\"featureTitle\">" . $item->getBedroomString() . "</span></li>
                                                <li><img src=\"site_files/images/icons/bathrooms.png\" alt=\"Bathrooms Icon\"><span class=\"featureTitle\">" . $item->getBathroomString() . "</span></li>
                                                <li><img src=\"site_files/images/icons/sq-ft.png\" alt=\"sp ft Icon\"><span class=\"featureTitle\">" . $item->getSqftString() . "</span></li>
                                            </ul><!-- end of FeatureList -->
                                        </div><!-- end of BannerFeature -->
                                        <a href=\"" . $item->getUrlLink() . "\" target=\"_blank\" class=\"btn generalBtn\" data-text=\"" . $item->getKstylePrice() . "\">" . $item->getKstylePrice() . "</a>
                                    </div><!-- end of BannerCaption -->
                                </a>
                            </div><!-- .cd-full-width -->
                        </div><!-- end of container -->
                    </li>";

                    $selected = false;
                }
            }

            ?>

        </ul> <!-- .cd-hero-slider -->

        <div class="cd-slider-nav">
            <nav class="container-fluid">
                <span class="cd-marker item-1"></span>
                <ul>
                    <?php
                    if ($hotIndexArray) {
                        $selected = true;
                        $index = 1;
                        foreach ($hotIndexArray as $item) {
                            echo ($selected) ? '<li class="selected">' : '<li>';
                            echo "<a href=\"#0\"><h5><span class=\"slideNumber\">0$index.</span> " . $item->getAddress() . "</h5><p>" . $item->getFormatPrice() . "</p></a></li>";
                            $index++;
                            $selected = false;
                        }
                    }
                    ?>
                </ul>
            </nav><!-- end of nav -->
        </div> <!-- end of cd-slider-nav -->
    </section><!-- end of cd-hero -->

    <!-- main-slider -->

    <section class="propertiesArea clearfix section lightGraypratten" id="latestProperties">
        <div class="sectionWrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="sectionTitle text-center featureTitleTw">
                            <h6><?php echo $langArray['homeString1'] ?></h6>
                            <h1 class="sectionHeader"><?php echo $langArray['homeString2'] ?><span
                                        class="generalBorder"></span></h1>
                        </div><!-- end of sectionTitle -->
                    </div><!-- end of col12 -->
                </div><!-- end of row -->
                <div class="row">
                    <div class="propertyWrapper">
                        <?php
                        $mHouseController = new HouseController($yihuapost->getCurrentDB());

                        $newListing = $mHouseController->getNewListing(6);
                        if ($newListing) {
                            foreach ($newListing as $item) {
                                $mHouse = new House($siteLanguage, $yihuapost->getCurrentDB());

                                if ($mHouse->createDataById($item)) {
                                    $imageId = $mHouse->getMainPic();
                                    $image = new YihuaPostImage($yihuapost->getCurrentDB());

                                    if ($image->getSingleImage($imageId)) {
                                        echo "
                        <div class=\"col-sm-4 propertyPost2 wow zoomIn\"  data-wow-delay=\"0ms\" data-wow-duration=\"1500ms\">
                            <div class=\"propertySingleFeature text-center\">
                                <div class=\"itemMedia\">
                                    <img src=\"" . $image->getFilePath() . "\" alt=\"Properly Image\">
                                    <div class=\"status statusStyletw\">
                                        <a href=\"" . $mHouse->getUrlLink() . "\">
                                            <button>" . $mHouse->getTypeString() . "</button>
                                        </a>
                                    </div>
                                </div><!-- end of itemMedia -->

                                <div class=\"featurePropertyContent\">
                                    <div class=\"featureSectionTitle text-center\">
                                        <h2>" . $mHouse->getAddress() . "</h2>
                                        <p>" . $mHouse->getHouseTypeString() . "</p>
                                        <span class=\"generalBorder smallBorder\"></span>
                                    </div><!-- end of featureSectoinTitle -->

                                    <div class=\"propertyFeatureDetails text-center\">
                                        <ul class=\"pfList inlineListItem\">
                                            <li><img src=\"site_files/images/icons/money_roundIcon.png\" alt=\"Money Icon\">" . $mHouse->getFormatPrice() . "</li>
                                            <li><img src=\"site_files/images/icons/md_sqftIcon.png\" alt=\"sq ft Icon\">" . $mHouse->getSqftString() . "</li>
                                        </ul>
                                    </div><!-- end of propertyFeatureDetails -->

                                    <a href=\"" . $mHouse->getUrlLink() . "\" class=\"viewDetails\"><img src=\"site_files/images/icons/md_rightArrow.png\" alt=\"Right Arrow\"></a>

                                </div><!-- end of featurePorpertyContent -->
                            </div><!-- end of propertySingleFeature -->
                        </div><!-- end of col4 -->
                                ";
                                    }
                                }
                            }
                        }
                        ?>
                    </div><!-- end of  propertyWrapper -->
                </div><!-- end of row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="viewCottage clearfix text-center">
                            <a href="/houses?mod=all-for-sell-list">
                                <button class="viewCottageBtn"><?php echo $langArray['homeString3'] ?></button>
                            </a>
                        </div><!-- end of viewCottage -->
                    </div><!-- end of col12 -->
                </div><!-- end of row -->

            </div><!-- end of container -->
        </div><!-- end of sectionWrapper -->
    </section><!-- end of moreProperties -->

    <section class="estertoCount section clearfix" id="dichanjingjiSold">
        <div class="sectionWrapper counterBg estetoCounterCount">
            <div class="bgOverly"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-6">
                        <div class="row">
                            <div class="featurePorjectTitle sectionTitle text-left">
                                <h1 class="sectionHeader whiteTxt"><?php echo $langArray['homeString4'] ?><span
                                            class="generalBorderLine"></span></h1>
                            </div><!-- end of sectionTitle -->
                            <div class="architectsMember clearfix promoBox">
                                <?php
                                $randomSoldList = $mHouseController->getNewSoldList(18);
                                if ($randomSoldList) {
                                    foreach ($randomSoldList as $item) {
                                        $mHouse = new House($siteLanguage, $yihuapost->getCurrentDB());

                                        if ($mHouse->createDataById($item)) {
                                            $imageId = $mHouse->getMainPic();
                                            $image = new YihuaPostImage($yihuapost->getCurrentDB());

                                            if ($image->getSingleImage($imageId)) {
                                                echo "
                               <div class=\"col-sm-4\">
                                    <div class=\"architectsSingle\">
                                    <a href=\"" . $mHouse->getUrlLink() . "\">
                                        <div class=\"soldImages\">
                                            <aside><p>" . $mHouse->getTypeString() . "</p></aside>
                                            <img src=\"" . $image->getFilePath() . "\" alt=\"sold \">
                                        </div><!-- end of architectsAvater -->
                                    </div><!-- end of -->
                                </div><!-- end of col4 -->";
                                            }
                                        }
                                    }
                                } ?>
                            </div><!-- end of architectsMember -->
                        </div><!-- end of row -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="viewCottage clearfix text-center">
                                    <a href="/houses?mod=all-sold-list">
                                        <button class="viewCottageBtn"><?php echo $langArray['homeString5'] ?></button>
                                    </a>
                                </div><!-- end of viewCottage -->
                            </div><!-- end of col12 -->
                        </div><!-- end of row -->
                    </div><!-- end of col7 -->
                </div><!-- end of row -->
            </div><!-- end of container -->
        </div><!-- end of sectionWrapper -->
    </section><!-- end of EstretoCount -->

    <section class="OurArchitects clearfix section lightSection" id="architects">
        <div class="sectionWrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="archWrapperTitle">
                            <div class="architectsTitle">
                                <h2><?php echo $langArray['homeString6'] ?></h2>
                            </div><!-- end of architectsTitle -->
                            <p class="archPara"><?php echo $langArray['homeString7'] ?></p>
                        </div><!-- end of archWrapperTitle -->
                    </div><!-- end of col4 -->

                    <div class="col-md-7 col-md-offset-1">
                        <div class="row">
                            <div class="architectsMember clearfix">
                                <?php
                                $mAgentController = new AgentController($yihuapost->getCurrentDB());
                                $randomAgentList = $mAgentController->getRandomAgentList(6);
                                if ($randomAgentList) {
                                    foreach ($randomAgentList as $item) {
                                        $mAgent = new HouseAgent($siteLanguage, $yihuapost->getCurrentDB());

                                        if ($mAgent->createDataById($item)) {
                                            $imageId = $mAgent->getMainPic();
                                            $image = new YihuaPostImage($yihuapost->getCurrentDB());

                                            if ($image->getSingleImage($imageId)) {
                                                echo "
                                <div class=\"col-sm-4\">
                                    <div class=\"architectsSingle\">
                                        <div class=\"architectsAvater\">
                                            <img src=\"" . $image->getFilePath() . "\" alt=\"Architects Member \">
                                            <ul class=\"socialNav archSocialNav\">
                                                <li><a href=\"" . $mAgent->getUrlLink() . "\"><button>" . $langArray['homeString17'] . $mAgent->getNameString() . $langArray['homeString18'] . "</button></a></li>
                                            </ul>

                                        </div><!-- end of architectsAvater -->
                                    </div><!-- end of -->
                                </div><!-- end of col4 -->";
                                            }
                                        }
                                    }
                                } else {
                                    echo "<p>Our Agents are on the way.</p>";
                                } ?>


                            </div><!-- end of architectsMember -->
                        </div><!-- end of row -->
                    </div><!-- end of col7 -->
                </div><!-- end of row -->
            </div><!-- end of container -->
        </div><!-- end of sectionWrapper  -->
    </section><!-- end of OurArchitects -->


    <div class="googleMapstyle5 section clearfix" id="gMap5">
        <div class="bgOverlyImg bgOverly"></div>
        <div class="googleMapstyle5">
            <div id="googleMap5" class="gmap3"></div><!-- end of googleMap -->
        </div><!-- end of googleMap -->
    </div><!-- end of googleMapStyle5 -->

    <section class="contactUs sections clearfix" id="contactStyle2">
        <div class="sectionWrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="sectionlgTitletw sectionTitle">
                            <h1 class="whiteTxt"><?php echo $langArray['homeString8'] ?></h1>
                            <p><?php echo $langArray['homeString9'] ?></p>
                        </div><!-- end of sectonlgTitletw -->
                    </div><!-- end of col12 -->
                </div><!-- end of row -->

                <div class="row">
                    <div class="col-md-8 noPaddingRight">
                        <div class="contactWrapper">
                            <div class="sectionlgTitle">
                                <h2><?php echo $langArray['homeString10'] ?></h2>
                                <img src="site_files/images/icons/trianglesIcon.png" alt="Traingles ">
                            </div><!-- end of sectonlgTitletw -->

                            <div id="message"></div>
                            <form method="post" action="http://themexriver.com/estreto/mail.php" name="cform" id="cform"
                                  class="sendMessage formArea fromStyle2 clearfix">
                                <ul class="row contactFormArea">
                                    <li class="col-xs-12 col-sm-6 paddrtl">
                                        <input value="<?php echo $langArray['homeString11'] ?>"
                                               onblur="if(this.value=='')this.value='<?php echo $langArray['homeString11'] ?>'"
                                               onfocus="if(this.value=='<?php echo $langArray["homeString11"] ?>')this.value=''"
                                               name="name" id="FullName" type="text" required="">
                                    </li>
                                    <li class="col-xs-12 col-sm-6 paddlft">
                                        <input value="<?php echo $langArray['homeString12'] ?>"
                                               onblur="if(this.value=='')this.value='<?php echo $langArray["homeString12"] ?>'"
                                               onfocus="if(this.value=='<?php echo $langArray["homeString12"] ?>')this.value=''"
                                               name="email" id="Email" type="email" required="">
                                    </li>
                                    <li class="col-xs-12 col-sm-6 paddrtl">
                                        <input value="<?php echo $langArray['homeString13'] ?>"
                                               onblur="if(this.value=='')this.value='<?php echo $langArray["homeString13"] ?>'"
                                               onfocus="if(this.value=='<?php echo $langArray["homeString13"] ?>')this.value=''"
                                               name="mobile" id="Phone" type="text" required="">
                                    </li>
                                    <li class="col-xs-12 col-sm-6 paddlft">
                                        <input value="<?php echo $langArray['homeString14'] ?>"
                                               onblur="if(this.value=='')this.value='<?php echo $langArray["homeString14"] ?>'"
                                               onfocus="if(this.value=='<?php echo $langArray["homeString14"] ?>')this.value=''"
                                               id="Wbsite" type="text">
                                    </li>
                                    <li class="col-xs-12 col-sm-12 MessageSubmit">
                                        <textarea name="message" id="comments"
                                                  placeholder="<?php echo $langArray['homeString16'] ?>"></textarea>
                                        <button class="submitBtn"><img src="site_files/images/icons/sendIcon.png"
                                                                       alt="Send Icon"></button>
                                    </li>
                                </ul><!-- end of ul -->
                                <div id="simple-msg"></div>
                            </form><!-- end of conform -->

                        </div><!-- end of contactWrapper -->
                    </div><!-- end of col8  -->

                    <div class="col-md-4 noPaddingLeft">
                        <div class="contactInform deepBlueSection clearfix">
                            <h2><?php echo $langArray["homeString15"] ?></h2>
                            <ul class="getInTouchList">
                                <li>
                                    <img src="site_files/images/icons/roundLocation.png" alt="Round Location">
                                    <span class="text"><?php echo $siteProfile->getAddress() ?></span>
                                </li><!-- end of li -->

                                <li>
                                    <img src="site_files/images/icons/tabIcon.png" alt="Tab Icon">
                                    <span class="text"><?php echo $siteProfile->getPhone() ?><?php $phone2 = $siteProfile->getPhone2();
                                        echo ($phone2) ? '<br>' . $phone2 : ''; ?></span>
                                </li><!-- end of li -->

                                <li>
                                    <img src="site_files/images/icons/maibBox.png" alt="Mail Box Icon">
                                    <span class="text"><?php echo $siteProfile->getEmail() ?></span>
                                </li><!-- end of li -->

                            </ul><!-- end of getInTouchList -->

                            <ul class="socialNav contactInformSocial">
                                <li class="facebook"><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                </li>
                                <li class="twitter"><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                </li>
                                <li class="instagram"><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                </li>
                            </ul>

                        </div><!-- end of contactInform  -->
                    </div><!-- end of col4  -->
                </div><!-- end of row -->
            </div><!-- end of container -->
        </div><!-- end of sectionWrapper -->
    </section><!-- end of contactUs -->

    <!-- Main Footer -->
    <?php echoFooter($siteProfile); ?>

    <!-- Off-Canvas View Only -->
    <?php echoNavbarMobile($langArray, 1); ?>


    <div id="toTop" class="hidden-xs">
        <i class="fa fa-chevron-up"></i>
    </div> <!-- totop -->

</div><!-- end of allWrapper -->

<!-- JavaScript Files ========================== -->
<?php echoScript("    
    <script>
        // Google-map-Five
        function mapStyle3() {
            if ($('#googleMap5').length) {
                var pos = [49.8497006,-97.1522921];
                var center = [49.8450616,-97.1695305];

                $('#googleMap5')
                    .gmap3({
                        center: center,
                        zoom: 13,
                        mapTypeId : google.maps.MapTypeId.ROADMAP
                    })

                    .marker(function (map) {
                        return {
                            position: pos,
                            icon: '" . $hostUrl . "site_files/images/map6.png'
                        };
                    });
            }
        }
        
    $(window).on(\"load\", function() {
        mapStyle3();
    });
    </script>", $siteLanguage); ?>


</body>

</html>
