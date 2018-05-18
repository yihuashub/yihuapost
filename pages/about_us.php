<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 11/13/2017
 * Time: 11:57 AM
 */

include_once ("./system_files/language.php");
require_once ("./system_files/general.php");


require_once ("./config/config.php");

echoHader('',$langArray['contactUsTitle'],$langArray['contactUsDescription'],$langArray['contactUsKeywords'],$siteProfile); ?>

<body class="contactPage  style6 homeStyleSix">


<div class="allWrapper">
    <!-- Header -->
    <?php echoNavbar(5,$langArray,$siteProfile); ?>


    <div class="pageInfo clearfix PageInfoBg2">
        <div class="bgOverly"></div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="pageTitle">
                        <h2><?php echo $langArray['contactUsString1']?></h2>
                    </div><!-- end of pageTitle -->
                    <ul class="breadcrumb">
                        <li><a href="#"><?php echo $langArray['contactUsString2']?></a></li>
                        <li class="active"><?php echo $langArray['contactUsString3']?></li>
                    </ul><!-- end of breadcrumb -->
                </div><!-- end of col12 -->
            </div><!-- end of row -->
        </div><!-- end of container -->
    </div><!-- end of pageInfo -->

    <section class="aboutHistory section clearfix lightSection" id="AboutUs">
        <div class="sectionWrapper">
            <div class="container">
                <div class="row">
                    <div class=" tab-content aboutHistoryTab">
                        <div role="tabpanel" class="tab-pane fade in aboutTab active" id="about">

                            <div class="col-sm-7 ">
                                <div class="aboutUsWrapper">
                                    <div class="sectionTitle text-left">
                                        <h6><?php echo $langArray['contactUsString4']?></h6>
                                        <h1 class="sectionHeader"><?php echo $langArray['contactUsString5']?><span class="generalBorder"></span></h1>
                                        <?php echo $langArray['contactUsString6']?>

                                    </div><!-- end of sectionTitle -->
                                </div><!-- end of aboutUsWrapper-->
                            </div><!-- end of col6 -->

                            <div class="col-sm-5 noPaddingLeft">
                                <div class="aboutMidea">
                                    <img src="<?php echo $hostUrl?>/site_files/images/media/aboutPropertyImg.png" alt="About Property Image">
                                </div><!-- end of aboutMidea -->
                            </div><!-- end of col5 -->

                        </div><!-- end of aboutTab -->

                        <div role="tabpanel" class="tab-pane historyTab fade" id="history">

                            <div class="col-sm-5">
                                <div class="aboutMidea">
                                    <img src="<?php echo $hostUrl?>/site_files/images/media/aboutPropertyImg.png" alt="About Property Image">
                                </div><!-- end of aboutMidea -->
                            </div><!-- end of col5 -->

                            <div class="col-sm-7">
                                <div class="aboutUsWrapper">
                                    <div class="sectionTitle text-left">
                                        <h6><?php echo $langArray['contactUsString7']?></h6>
                                        <h1 class="sectionHeader"><?php echo $langArray['contactUsString8']?><span class="generalBorder"></span></h1>
                                        <?php echo $langArray['contactUsString9']?>
                                    </div><!-- end of sectionTitle -->
                                </div><!-- end of aboutUsWrapper-->
                            </div><!-- end of col6 -->

                        </div><!-- end of historyTab -->
                    </div><!-- end of aboutHistoryTab -->
                </div><!-- end of row -->

                <div class="row">
                    <div class="col-sm-12">
                        <!-- Nav tabs -->
                        <hr>
                        <ul class="nav nav-tabs navTabAbHis" role="tablist">
                            <li role="presentation" class="active"><a href="#about" aria-controls="about" role="tab" data-toggle="tab"><?php echo $langArray['contactUsString10']?></a></li>
                            <li role="presentation"><a href="#history" aria-controls="history" role="tab" data-toggle="tab"><?php echo $langArray['contactUsString11']?></a></li>
                        </ul>
                    </div><!-- end of col12 -->
                </div><!-- end of row -->

            </div><!-- end of container -->
        </div><!-- end of sectoinWrapper -->
    </section><!-- end of aboutUs-->

    <section class="estretoAds section clearfix adsaboutBg2" id="BuyTemplate">
        <div class="bgOverly"></div><!-- end of bgOverly -->
        <div class="sectionWrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="adsWrapper text-center">
                            <h1><?php echo $langArray['contactUsString22']?></h1>
                            <p class="whiteTxt"><?php echo $langArray['contactUsString12']?></p>
                            <img src="<?php echo $hostUrl?>site_files/images/media/wechat-qr-code.png" alt="Wechat QRcode">
                        </div><!-- end of adsWrapper -->
                    </div><!-- end of col12 -->
                </div><!-- end of row -->
            </div><!-- end of container -->
        </div><!-- end of sectionWrapper -->
    </section><!-- end of estretoAds -->

    <section class="contactInformation section clearfix graySectoin2" id="contactInfo">
        <div class="sectionWrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="singlecontactInfo text-center">
                            <div class="infoIcon">
                                <img src="<?php echo $hostUrl?>/site_files/images/icons/locationIcon04.png" alt="Map Icon">
                            </div><!--end of infoIcon-->
                            <div class="infometa">
                                <h2><?php echo $langArray['contactUsString14']?></h2>
                                <p><?php echo  $siteProfile->getAddress();?></p>
                            </div><!--end of contactContent-->
                        </div><!-- end of single contactinfo -->
                    </div><!-- end of col3 -->

                    <div class="col-sm-4">
                        <div class="singlecontactInfo text-center">
                            <div class="infoIcon">
                                <img src="<?php echo $hostUrl?>/site_files/images/icons/mailBoxIcon04.png" alt="Mail Icon">
                            </div><!--end of infoIcon-->
                            <div class="infometa">
                                <h2><?php echo $langArray['contactUsString15']?></h2>
                                <p><?php echo  $siteProfile->getEmail();?></p>
                            </div><!--end of contactContent-->
                        </div><!-- end of single contactinfo -->
                    </div><!-- end of col3 -->

                    <div class="col-sm-4">
                        <div class="singlecontactInfo text-center">
                            <div class="infoIcon">
                                <img src="<?php echo $hostUrl?>/site_files/images/icons/phoneIcon04.png" alt="Telephone Icon">
                            </div><!--end of infoIcon-->
                            <div class="infometa">
                                <h2><?php echo $langArray['contactUsString16']?></h2>
                                <p><?php echo  $siteProfile->getPhone();$phone2 = $siteProfile->getPhone2();echo ($phone2)?'<br>'.$phone2:'';?></p>
                            </div><!--end of contactContent-->
                        </div><!-- end of single contactinfo -->
                    </div><!-- end of col3 -->

                </div><!-- end of row -->
            </div><!-- end of container -->
        </div><!-- end of sectionWrapper -->
    </section><!-- end of contactinfo -->

    <div class="gMap clearfix">
        <div class="fullWidthMap">
            <div id="googleMap7" class="gmap3"></div>
        </div><!-- end of fullWidthMap -->
    </div><!-- end of gMap -->

    <section class="ContactFormInfo clearfix section contactBg" id="Contactpage">
        <div class="bgOverly"></div>
        <div class="sectionWrapper">
            <div class="container">
                <div class="row Contact">
                    <div class="col-sm-12">
                        <div class="EstContactForm lightSection">
                            <div class="sectionTitle text-center">
                                <h3><?php echo $langArray['contactUsString23']?><span class="TitleBorder"></span></h3>
                            </div>

                            <div id="message"></div>
                            <form method="post" action="mail.php" name="cform" id="cform" class="formArea clearfix contactStyle4">
                                <ul class="row">
                                    <li class="col-xs-12 col-sm-6">
                                        <input value="<?php echo $langArray['contactUsString17']?>" onblur="if(this.value=='')this.value='<?php echo $langArray["contactUsString17"]?>'" onfocus="if(this.value=='<?php echo $langArray["contactUsString17"]?>')this.value=''" name="name" id="name" type="text" required="">
                                    </li>
                                    <li class="col-xs-12 col-sm-6 NoPaddingRight">
                                        <input value="<?php echo $langArray['contactUsString18']?>" onblur="if(this.value=='')this.value='<?php echo $langArray["contactUsString18"]?>'" onfocus="if(this.value=='<?php echo $langArray["contactUsString18"]?>')this.value=''" name="email" id="email" type="email" required="">
                                    </li>

                                    <li class="col-xs-12 col-sm-12">
                                        <input value="<?php echo $langArray['contactUsString19']?>" onblur="if(this.value=='')this.value='<?php echo $langArray["contactUsString19"]?>'" onfocus="if(this.value=='<?php echo $langArray["contactUsString19"]?>')this.value=''" name="mobile" id="number" type="text" required="">
                                    </li>
                                    <li class="col-xs-12 col-sm-12">
                                        <textarea name="message" id="comments" placeholder="<?php echo $langArray['contactUsString20']?>"></textarea>
                                    </li>
                                    <li class="submitmessage text-center"><input type="submit" id="submit" name="send" class="submitBtn" value="<?php echo $langArray['contactUsString21']?>"></li>
                                </ul><!-- end of ul -->
                                <div id="simple-msg"></div>
                            </form><!-- end of conform -->
                        </div><!-- end of conForm  -->
                    </div><!-- end of col12  -->

                </div><!-- end of row -->
            </div><!-- end of container -->
        </div><!-- end of sectionWrapper -->
    </section><!-- end of ContactFormInfo -->

    <!-- Main Footer -->
    <?php echoFooter($siteProfile); ?>

    <!-- Off-Canvas View Only -->
    <?php echoNavbarMobile($langArray,5); ?>

    <div id="toTop" class="hidden-xs">
        <i class="fa fa-chevron-up"></i>
    </div> <!-- totop -->

</div><!-- end of allWrapper -->

<!-- JavaScript Files ========================== -->
<?php echoScript("
<script>
        // Google-map-Two / Four / Seven
        function mapStyle2() {
            if ($('#googleMap4').length || $('#googleMap7').length) {

                var pos = [49.8497006,-97.1522921];

                var contentString = '<div id=\"content\">'+
                    '<div id=\"siteNotice\">'+
                    '</div>'+
                    '<h1 id=\"firstHeading\" class=\"firstHeading\">".$langArray["contactUsString24"]."'+
                    '<div id=\"bodyContent\">'+
                    '<p>1060 Pembina Hwy</p>'+
                    '</div>'+
                    '</div>';

                $('#googleMap4,#googleMap7')
                    .gmap3({
                        zoom: 11,
                        address: '1060 Pembina Hwy, Winnipeg, MB R3T 1Z8',
                    })
                    .marker({
                        address: '1060 Pembina Hwy, Winnipeg, MB R3T 1Z8',
                        icon: \"".$hostUrl."site_files/images/map.png\"
                    })
                    .infowindow({
                        content: contentString
                    })
                    .then(function (infowindow) {
                        var map = this.get(0);
                        var marker = this.get(1);
                        marker.addListener('click', function() {
                            infowindow.open(map, marker);
                        });
                    });
            }
        }
        
 $(window).on(\"load\", function() {
        mapStyle2();
    });
    
    </script>
    ",$siteLanguage); ?>


</body>
</html>