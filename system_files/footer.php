<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 10/9/2017
 * Time: 10:01 PM
 */

function echoFooter($siteProfile)
{
    echo "
    
    <footer class=\"footer clearfix section footerStyle5 deepBlueSection\" id=\"footer5\">
        <div class=\"container\">
            <div class=\"row\">
                <div class=\"col-sm-12\">
                    <div class=\"copyright text-center\">
                    ".$siteProfile->getCopyright()." Powered By <a target=\"_blank\" href=\"//yihuapost.yihua.ca\" class=\"theme_color\">YIHUA POST</a>
                    </div><!-- end of copyright -->
                </div><!-- end of col12 -->
            </div><!-- end of row -->
        </div><!-- end of container -->
    </footer><!-- end of footer -->";

}