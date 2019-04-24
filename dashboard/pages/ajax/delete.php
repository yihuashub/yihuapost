<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 10/22/2017
 * Time: 4:02 PM
 */

include('../../../config/config.php');
require_once("../../admin_files/classes/HouseSystem.php");
require_once("../../admin_files/classes/YihuaPost.php");



if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['type']))
    {
        if(strcmp($_POST['type'],'delete-from-list') == 0)
        {
            if(!empty($_POST['id'])) {

                $finaldata = array();

                $mAuto = new HouseSystem($_POST['id']);

                $title = $mAuto->getSystemTitle();

                $result = 0;

                if($mAuto->deleteSelf())
                {
                    $result = 1;
                }

                header('Access-Control-Allow-Credentials:false');
                header('Access-Control-Allow-Headers:Content-Type, Content-Range, Content-Disposition');
                header('Access-Control-Allow-Methods:OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
                header('Access-Control-Allow-Origin:*');
                header('Cache-Control:no-store, no-cache, must-revalidate');
                header('Content-Type: application/json');

                $finaldata= array("title" => "$title","result" => $result);

                print json_encode($finaldata);
            }
        }
        else if(strcmp($_POST['type'],'delete-post-from-list') == 0)
        {
            if(!empty($_POST['id'])) {

                $finaldata = array();

                $mPost = new YihuaPost();
                $post = $mPost->newPostById($_POST['id']);
                $title = "Unknown";

                $result = 0;

                if($post)
                {
                    $title = $mPost->getTitle();

                    if($mPost->deleteSelf())
                    {
                        $result = 1;
                    }
                }

                header('Access-Control-Allow-Credentials:false');
                header('Access-Control-Allow-Headers:Content-Type, Content-Range, Content-Disposition');
                header('Access-Control-Allow-Methods:OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
                header('Access-Control-Allow-Origin:*');
                header('Cache-Control:no-store, no-cache, must-revalidate');
                header('Content-Type: application/json');

                $finaldata= array("title" => "$title","result" => $result);

                print json_encode($finaldata);
            }
        }
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