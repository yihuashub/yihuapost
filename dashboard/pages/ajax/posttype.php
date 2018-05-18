<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 11/8/2017
 * Time: 4:11 PM
 */

include_once ("../../admin_files/classes/YihuaPost.php");
include_once ("../../../config/config.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['type']))
    {
        $lang = $_POST['type'];
        $finaldata = array();

        $newPost = new YihuaPost();

        $finaldata = $newPost->getPostType($lang);

        header('Access-Control-Allow-Credentials:false');
        header('Access-Control-Allow-Headers:Content-Type, Content-Range, Content-Disposition');
        header('Access-Control-Allow-Methods:OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
        header('Access-Control-Allow-Origin:*');
        header('Cache-Control:no-store, no-cache, must-revalidate');
        header('Content-Type: application/json');

        print json_encode($finaldata);
    }
    else
    {
        echo "Powered by YIHUA POST";
    }



}
else
{
    echo "Powered by YIHUA POST";
}



