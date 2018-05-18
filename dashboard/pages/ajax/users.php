<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 11/19/2017
 * Time: 1:55 PM
 */

include('../../../config/config.php');
require_once("../../admin_files/classes/UserController.php");
require_once("../../admin_files/classes/User.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['type'])) {
        if (strcmp($_POST['type'], 'add-new-user') == 0) {
            $typeName = $lang =  "";
            $result = true;
            $message = "";


            $mUser = new UserController();

            $code = $mUser->createNewUser();

            if ($code) {
                $result = true;
                $message = '邀请码： '.$code;

            } else {
                $result = false;
                $message = $mUser->getErrorMessage();
            }


            header('Access-Control-Allow-Credentials:false');
            header('Access-Control-Allow-Headers:Content-Type, Content-Range, Content-Disposition');
            header('Access-Control-Allow-Methods:OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
            header('Access-Control-Allow-Origin:*');
            header('Cache-Control:no-store, no-cache, must-revalidate');
            header('Content-Type: application/json');

            $finaldata = array("message" => "$message", "result" => $result);

            print json_encode($finaldata);
        } else if (strcmp($_POST['type'], 'reset-user-password') == 0) {
            if (!empty($_POST['id'])) {
                $userId = $_POST['id'];
                $result = false;
                $message = "";

                $mUser = new UserController();

                $newPassword = $mUser->resetPassword($userId);

                if ($newPassword) {
                    $result = true;
                    $message = '新密码： '.$newPassword;

                } else {
                    $result = false;
                    $message = $mUser->getErrorMessage();
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
        } else if (strcmp($_POST['type'], 'ban-user') == 0) {
            if (!empty($_POST['id'])) {
                $userId = $_POST['id'];
                $result = false;
                $message = "";

                $mUser = new UserController();

                $newPassword = $mUser->banUser($userId);

                if ($newPassword) {
                    $result = true;
                } else {
                    $result = false;
                    $message = $mUser->getErrorMessage();
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
        } else if (strcmp($_POST['type'], 'upload-stand-pic') == 0) {
            if (!empty($_POST['pic']) && !empty($_POST['user'])) {
                $userId = $_POST['user'];
                $picId = $_POST['pic'];

                $result = false;
                $message = "";

                $mUser = new User();

                $newStandPic = $mUser->uploadStandPic($picId,$userId);

                if ($newStandPic) {
                    $result = true;
                } else {
                    $result = false;
                    $message = $mUser->getErrorMessage();
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
        }else if (strcmp($_POST['type'], 'destroy-stand-pic') == 0) {
            if (!empty($_POST['user'])) {
                $userId = $_POST['user'];

                $result = false;
                $message = "";

                $mUser = new User();

                $newStandPic = $mUser->destroyStandPic($userId);

                if ($newStandPic) {
                    $result = true;
                } else {
                    $result = false;
                    $message = $mUser->getErrorMessage();
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
        } else if (strcmp($_POST['type'], 'upload-main-pic') == 0) {
            if (!empty($_POST['pic']) && !empty($_POST['user'])) {
                $userId = $_POST['user'];
                $picId = $_POST['pic'];

                $result = false;
                $message = "";

                $mUser = new User();

                $newStandPic = $mUser->uploadMainPic($picId,$userId);

                if ($newStandPic) {
                    $result = true;
                } else {
                    $result = false;
                    $message = $mUser->getErrorMessage();
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
        }else if (strcmp($_POST['type'], 'destroy-main-pic') == 0) {
            if (!empty($_POST['user'])) {
                $userId = $_POST['user'];

                $result = false;
                $message = "";

                $mUser = new User();

                $newStandPic = $mUser->destroyMainPic($userId);

                if ($newStandPic) {
                    $result = true;
                } else {
                    $result = false;
                    $message = $mUser->getErrorMessage();
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
        } else if (strcmp($_POST['type'], 'upload-background-pic') == 0) {
            if (!empty($_POST['pic']) && !empty($_POST['user'])) {
                $userId = $_POST['user'];
                $picId = $_POST['pic'];

                $result = false;
                $message = "";

                $mUser = new User();

                $newStandPic = $mUser->uploadBackgroundPic($picId,$userId);

                if ($newStandPic) {
                    $result = true;
                } else {
                    $result = false;
                    $message = $mUser->getErrorMessage();
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
        }else if (strcmp($_POST['type'], 'destroy-background-pic') == 0) {
            if (!empty($_POST['user'])) {
                $userId = $_POST['user'];

                $result = false;
                $message = "";

                $mUser = new User();

                $newStandPic = $mUser->destroyBackgroundPic($userId);

                if ($newStandPic) {
                    $result = true;
                } else {
                    $result = false;
                    $message = $mUser->getErrorMessage();
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