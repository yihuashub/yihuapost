<?php

require_once ("profile.php");


function echoNavbar($sideId,$langArray,$siteProfile)
{
    $rootUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
    $hostUrl = $_SERVER[HTTP_HOST];

    $url=strtok($_SERVER["REQUEST_URI"],'?');
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$url";

    echo "
        <div class=\"topHead clearfix dichanjingjiGraySection\" id=\"topHeader\">
        <div class=\"topHeaderInfo\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-sm-6 text-left\">
                        <div class=\"topContactInfo\">
                            <ul class=\"topInfolist\">
                                <li class=\"tele\">
                                    <i class=\"fa fa-phone\" aria-hidden=\"true\"></i>
                                    <a href=\"tele:".$siteProfile->getPhone()."\">".$siteProfile->getPhone()."</a>
                                </li>
                                <li class=\"mail\">
                                    <i class=\"fa fa-envelope\" aria-hidden=\"true\"></i>
                                    <a href=\"mailto:".$siteProfile->getEmail()."\">".$siteProfile->getEmail()."</a>
                                </li>
                            </ul><!-- end of topContactlist -->
                        </div><!-- end of topContact -->
                    </div><!-- end of col6 -->

                    <div class=\"col-sm-6\">
                        <ul class=\"topSocial socialNav\">
                            <li><a href=\"$actual_link?hl=en\">English</a></li>
                            <li><a href=\"$actual_link?hl=zh\">中文</a></li>
                        </ul><!-- end of topSocial -->
                    </div><!-- end of col6 -->
                </div><!-- end of row -->
            </div><!-- end of container -->
        </div><!-- end of topHeaderInfo -->
    </div><!-- end of topHead -->

    <!-- Header -->
    <header class=\"header headerStyle6 blackSection\" id=\"header\">
        <div class=\"sticky scrollHeaderWrapper navbar\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-sm-3\">
                        <div class=\"logoWrapper text-left\">
                            <div class=\"logo\">
                                <a href=\"$rootUrl\"><img src=\"".$rootUrl."site_files/images/logos/logo.jpg\" alt=\"site Logo\" style=\"max-height: 127px;max-width: 127px; z-index: 99;position: absolute\"></a>
                            </div><!-- end of logo -->
                        </div><!-- end of logoWrapper -->
                    </div><!-- end of col3 -->

                    <div class=\"col-sm-9\">
                        <nav class=\"mainMenu mainNav clearfix\" id=\"mainNav\">
                            <ul class=\"navTabs\">";
                            getEachItem($langArray,$sideId);

    echo "
                                <li class=\"searchNavPopup\">
                                    <a href=\"javascript:void(0);\" class=\"btn searchTrigger navsearchBtn\">
                                        <img src=\"".$rootUrl."site_files/images/icons/searchIcon.png\" alt=\"Search Icon\">
                                    </a>
                                </li>
                            </ul><!-- end of navTabs -->
                        </nav><!-- end of main nav -->

                        <div class=\"search_popup\">
                            <i class=\"fa fa-times header-search-close\"></i>
                            <div class=\"search-overlay\"></div>
                            <div class=\"search\">
                                <form method=\"GET\" action=\"".$rootUrl."search\">
                                    <label>".$langArray['navbarString7']."</label>
                                    <input type=\"search\" value=\"".$langArray['navbarString6']."\" onblur=\"if(this.value=='')this.value='".$langArray['navbarString6']."'\" onfocus=\"if(this.value=='".$langArray['navbarString6']."')this.value=''\" name=\"search-name\" id=\"popupSearch\" class=\"popupSearch\">
                                    <input type=\"hidden\" name=\"search-type\" value=\"house\">
                                    <button><i class=\"fa fa-search\"></i></button>
                                </form><!-- end of form -->
                            </div><!-- end of search -->
                        </div><!-- end of search popup -->

                    </div><!-- end of col9-->

                </div><!-- end of row -->
            </div><!-- end of container -->
        </div><!-- end of sticky -->
    </header><!-- end of header -->";
}


function echoNavbarMobile($langArray,$sideId)
{
    $rootUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
    $hostUrl = $_SERVER[HTTP_HOST];

    $url=strtok($_SERVER["REQUEST_URI"],'?');
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$url";

    echo "
    <ul id=\"menu\" class=\"hidden\">";
        getEachItem($langArray,$sideId);
           echo"
        <li><a href=\"$actual_link?hl=en\">English</a></li>
        <li><a href=\"$actual_link?hl=zh\">中文</a></li>
        <!-- end of li -->
    </ul>
    <!-- Off-Canvas View Only -->";
}

function getEachItem($langArray,$sideId)
{
    $db = new Database();

    $sql = "SELECT ID, title,url FROM web_navbar";

    $result = $db->query($sql);


    if (mysqli_num_rows($result) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {

            if($row["ID"] == $sideId)
{
    $activeTag = 'active';
}
else{
    $activeTag = '';
}

$title = $row["title"];
$url = $row["url"];
echoNavItemNoIcon($langArray,$activeTag,$title,$url);
}

}
}


function echoNavItemNoIcon($langArray,$activeTag,$title,$url)
{
    $rootUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";

    echo "
          <li>
            <a href=\"".$rootUrl.$url."\" class=\"$activeTag\">".$langArray[''.$title.'']."</a>
          </li><!-- end of li -->";

}