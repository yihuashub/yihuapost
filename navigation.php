<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 11/9/2017
 * Time: 9:39 PM
 */
require_once ("./config/config.php");
include_once ("./system_files/classes/YihuaPost.php");
include_once ("./system_files/classes/YihuaPostProfile.php");

$checkRewrite = false;
$siteLanguage = '';
$rootUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
//$rootUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]/";

$hostUrl = "//".$_SERVER['HTTP_HOST']."/";

$url=strtok($_SERVER["REQUEST_URI"],'?');
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$url";
$yihuapost = new YihuaPost();

if($yihuapost->initialization()){
    if ($_SERVER["REQUEST_METHOD"] == "GET" || $_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_GET['url']) || isset($_POST['url'])) {

            if(isset($_GET['url']))
            {
                $request = $_GET['url'];
            }
            else{
                $request = $_POST['url'];
            }

            include_once ("./system_files/language.php");
            $siteProfile = new YihuaPostProfile($siteLanguage,$yihuapost->getCurrentDB());

            if(empty($request))
            {
                $checkRewrite = true;
                require("pages/home.php");
            }
            else{
                $urlArray = (explode("/",$request));

                if(count($urlArray) > 0)
                {
                    $model = $yihuapost->getRewriteUrlModel($urlArray[0]);

                    if(count($urlArray) <= $yihuapost->getRewriteSize())
                    {
                        if($model)
                        {
                            $checkRewrite = true;
                            require("pages/".$model.".php");
                        }
                    }
                }
            }
            if(!$checkRewrite)
            {
                require ("pages/404.php");
            }


        } else {
            require("pages/home.php");
        }
    }
}else{
    require("config/install.php");
}

