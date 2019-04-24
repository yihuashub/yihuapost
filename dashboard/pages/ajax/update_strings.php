<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 2/11/2018
 * Time: 9:38 PM
 */



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['type'])) {
        if (strcmp($_POST['type'], 'cn') == 0) {
            require '../../../system_files/lang/Chinese.php';

            $result = true;
            $message = "";
            $key = $_POST['key'];
            $value =$_POST['value'];

            $org = $langArray;

            $org[$key] = $value;

            $fp = fopen('../../../system_files/lang/Chinese.php', 'w');

            fwrite($fp, "<?php  " . "\xA");

            fwrite($fp, "/**" . "\xA");
            fwrite($fp, " * YIHUA POST v1.0, YIHUA HUANG ALL RIGHT RESERVED." . "\xA");
            fwrite($fp, " * Modified on " .date("Y/m/d h:i:sa") . "\xA");
            fwrite($fp, "*/" . "\xA");

            fwrite($fp, "$"."langArray = ");
            fwrite($fp, var_export($org, TRUE));

            fwrite($fp, " ?>");

            fclose($fp);

            $message = $key;

            header('Access-Control-Allow-Credentials:false');
            header('Access-Control-Allow-Headers:Content-Type, Content-Range, Content-Disposition');
            header('Access-Control-Allow-Methods:OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
            header('Access-Control-Allow-Origin:*');
            header('Cache-Control:no-store, no-cache, must-revalidate');
            header('Content-Type: application/json');

            $finaldata = array("message" => "$message", "result" => $result);

            print json_encode($finaldata);
        } else if (strcmp($_POST['type'], 'en') == 0){
            require '../../../system_files/lang/English.php';

            $result = true;
            $message = "";
            $key = $_POST['key'];
            $value =$_POST['value'];

            $org = $langArray;

            $org[$key] = $value;

            $fp = fopen('../../../system_files/lang/English.php', 'w');

            fwrite($fp, "<?php  " . "\xA");

            fwrite($fp, "/**" . "\xA");
            fwrite($fp, " * YIHUA POST v1.0, YIHUA HUANG ALL RIGHT RESERVED." . "\xA");
            fwrite($fp, " * Modified on " .date("Y/m/d h:i:sa") . "\xA");
            fwrite($fp, "*/" . "\xA");

            fwrite($fp, "$"."langArray = ");
            fwrite($fp, var_export($org, TRUE));

            fwrite($fp, " ?>");

            fclose($fp);

            $message = $key;

            header('Access-Control-Allow-Credentials:false');
            header('Access-Control-Allow-Headers:Content-Type, Content-Range, Content-Disposition');
            header('Access-Control-Allow-Methods:OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
            header('Access-Control-Allow-Origin:*');
            header('Cache-Control:no-store, no-cache, must-revalidate');
            header('Content-Type: application/json');

            $finaldata = array("message" => "$message", "result" => $result);

            print json_encode($finaldata);
        } else if (strcmp($_POST['type'], 'restore') == 0){

            $result = true;
            $message = "";

            if (strcmp($_POST['lang'], 'cn') == 0)
            {
                require '../../../system_files/lang/Chinese_backup.php';
                $fp = fopen('../../../system_files/lang/Chinese.php', 'w');
            }
            else if (strcmp($_POST['lang'], 'en') == 0)
            {
                require '../../../system_files/lang/English_backup.php';
                $fp = fopen('../../../system_files/lang/English.php', 'w');
            }


            $org = $langArray;


            fwrite($fp, "<?php  " . "\xA");

            fwrite($fp, "/**" . "\xA");
            fwrite($fp, " * YIHUA POST v1.0, YIHUA HUANG ALL RIGHT RESERVED." . "\xA");
            fwrite($fp, " * Modified on " .date("Y/m/d h:i:sa") . "\xA");
            fwrite($fp, "*/" . "\xA");

            fwrite($fp, "$"."langArray = ");
            fwrite($fp, var_export($org, TRUE));

            fwrite($fp, " ?>");

            fclose($fp);

            $message = "";

            header('Access-Control-Allow-Credentials:false');
            header('Access-Control-Allow-Headers:Content-Type, Content-Range, Content-Disposition');
            header('Access-Control-Allow-Methods:OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
            header('Access-Control-Allow-Origin:*');
            header('Cache-Control:no-store, no-cache, must-revalidate');
            header('Content-Type: application/json');

            $finaldata = array("message" => "$message", "result" => $result);

            print json_encode($finaldata);
        }else {
            echo "Powered by YIHUA POST. Error no type";
        }


    } else {
        echo "Powered by YIHUA POST";
    }
}else {
    echo "Powered by YIHUA POST";
}
