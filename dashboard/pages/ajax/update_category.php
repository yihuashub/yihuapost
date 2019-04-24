<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 11/17/2017
 * Time: 1:13 PM
 */


include('../../../config/config.php');
require_once("../../admin_files/classes/YihuaPostCategory.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['type'])) {
        if (strcmp($_POST['type'], 'add-option') == 0) {
            $typeName = $lang =  "";
            $result = true;
            $message = "";

            if (!empty($_POST['name'])) {
                $typeName = $_POST['name'];
            } else {
                $result = false;
                $message = $message . " 缺少名称";
            }

            $lang = $_POST['lang'];
    

            if ($result) {
                $mHotIndex = new YihuaPostCategory();

                if ($mHotIndex->addIndex($typeName, $lang)) {
                } else {
                    $result = false;
                    $message = $mHotIndex->getErrorMessage();
                }
            }


            header('Access-Control-Allow-Credentials:false');
            header('Access-Control-Allow-Headers:Content-Type, Content-Range, Content-Disposition');
            header('Access-Control-Allow-Methods:OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
            header('Access-Control-Allow-Origin:*');
            header('Cache-Control:no-store, no-cache, must-revalidate');
            header('Content-Type: application/json');

            $finaldata = array("message" => "$message", "result" => $result);

            print json_encode($finaldata);
        } else if (strcmp($_POST['type'], 'delete-option') == 0) {
            if (!empty($_POST['id'])) {
                $indexId = $_POST['id'];
                $result = false;
                $message = "";

                $mHotIndex = new YihuaPostCategory();

                if ($mHotIndex->deleteIndex($indexId)) {
                    $result = true;
                }


                header('Access-Control-Allow-Credentials:false');
                header('Access-Control-Allow-Headers:Content-Type, Content-Range, Content-Disposition');
                header('Access-Control-Allow-Methods:OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
                header('Access-Control-Allow-Origin:*');
                header('Cache-Control:no-store, no-cache, must-revalidate');
                header('Content-Type: application/json');

                $finaldata = array("message" => "$message", "result" => $result);

                print json_encode($finaldata);
            }
        }
    } else if (isset($_POST['item'])) {
        $array_items = $_POST['item']; //array of items in the Unordered List
        $result = false;
        $message = "";

        $mHotIndex = new YihuaPostCategory();

        if ($mHotIndex->updateIndex($array_items)) {
            $result = true;
        }


        header('Access-Control-Allow-Credentials:false');
        header('Access-Control-Allow-Headers:Content-Type, Content-Range, Content-Disposition');
        header('Access-Control-Allow-Methods:OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
        header('Access-Control-Allow-Origin:*');
        header('Cache-Control:no-store, no-cache, must-revalidate');
        header('Content-Type: application/json');

        $finaldata = array("result" => $result);

        print json_encode($finaldata);
    } else {
        echo "Powered by YIHUA POST. Error no type";
    }


} else {
    echo "Powered by YIHUA POST";
}