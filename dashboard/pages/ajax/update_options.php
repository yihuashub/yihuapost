<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 10/29/2017
 * Time: 4:17 AM
 */


include('../../../config/config.php');
require_once("../../admin_files/classes/HouseOptionSystem.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['type'])) {
        if (strcmp($_POST['type'], 'add-option') == 0) {
            $optionEN = $optionCN = $optionValue = $optionName = "";
            $result = true;
            $message = "";

            if (!empty($_POST['name'])) {
                $optionName = $_POST['name'];
            } else {
                $result = false;
                $message = $message . " 缺少选项";
            }

            if (!empty($_POST['value'])) {
                $optionValue = $_POST['value'];
                if (preg_match('/[^A-Z0-9]/', $optionValue)) // '/[^a-z\d]/i' should also work.
                {
                    $result = false;
                    $message = $message . " 【值】只能包含大写英文或数字";
                }
            } else {
                $result = false;
                $message = $message . " 缺少值";
            }

            if (!empty($_POST['cn'])) {
                $optionCN = $_POST['cn'];
            } else {
                $result = false;
                $message = $message . " 缺少中文介绍";
            }

            if (!empty($_POST['en'])) {
                $optionEN = $_POST['en'];
            } else {
                $result = false;
                $message = $message . " 缺少英文介绍";
            }

            if ($result) {
                $mHotIndex = new HouseOptionSystem();

                if ($mHotIndex->addIndex($optionName, $optionValue, $optionCN, $optionEN)) {
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

                $mHotIndex = new HouseOptionSystem();

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

        $mHotIndex = new HouseOptionSystem();

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