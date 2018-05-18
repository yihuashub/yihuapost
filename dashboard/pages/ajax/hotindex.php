<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yihua
 * Date: 10/24/2017
 * Time: 5:48 PM
 */


include('../../../config/config.php');
require_once("../../admin_files/classes/HotIndexSystem.php");



if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['type']))
    {
        if(strcmp($_POST['type'],'add-list-index') == 0)
        {
            if(!empty($_POST['id'])) {

                $containerId = $_POST['id'];
                $result = false;
                $message ="";

                $mHotIndex = new HotIndexSystem();
                $mHotIndex->withContainerID($containerId);

                if($mHotIndex->addIndex())
                {
                    $result = true;
                }
                else{
                    $message = $mHotIndex->getErrorMessage();
                }


                header('Access-Control-Allow-Credentials:false');
                header('Access-Control-Allow-Headers:Content-Type, Content-Range, Content-Disposition');
                header('Access-Control-Allow-Methods:OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
                header('Access-Control-Allow-Origin:*');
                header('Cache-Control:no-store, no-cache, must-revalidate');
                header('Content-Type: application/json');

                $finaldata= array("message" => "$message","result" => $result);

                print json_encode($finaldata);
            }
        }
        else if(strcmp($_POST['type'],'delete-list-index') == 0)
        {
            if(!empty($_POST['id'])) {
                $indexId = $_POST['id'];
                $result = false;
                $message ="";

                $mHotIndex = new HotIndexSystem();

                if($mHotIndex->deleteIndex($indexId))
                {
                    $result = true;
                }


                header('Access-Control-Allow-Credentials:false');
                header('Access-Control-Allow-Headers:Content-Type, Content-Range, Content-Disposition');
                header('Access-Control-Allow-Methods:OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
                header('Access-Control-Allow-Origin:*');
                header('Cache-Control:no-store, no-cache, must-revalidate');
                header('Content-Type: application/json');

                $finaldata= array("message" => "$message","result" => $result);

                print json_encode($finaldata);
            }
        }
        else if(strcmp($_POST['type'],'delete-list-all') == 0)
        {
            $result = false;
            $message ="";

            $mHotIndex = new HotIndexSystem();

            if($mHotIndex->deleteSelf())
            {
                $result = true;
            }

            header('Access-Control-Allow-Credentials:false');
            header('Access-Control-Allow-Headers:Content-Type, Content-Range, Content-Disposition');
            header('Access-Control-Allow-Methods:OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
            header('Access-Control-Allow-Origin:*');
            header('Cache-Control:no-store, no-cache, must-revalidate');
            header('Content-Type: application/json');

            $finaldata= array("message" => "$message","result" => $result);

            print json_encode($finaldata);
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