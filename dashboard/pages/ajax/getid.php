<?php

/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 7/3/2017
 * Time: 12:05 AM
 */

include('../../../config/config.php');



if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['type']))
    {
        if(strcmp($_POST['type'],'single') == 0)
        {
            if(!empty($_POST['id']))
            {
                $db = new Database();
                $finaldata = array();

                if($db) {
                    $imageID = $_POST['id']; //array of items in the Unordered List

                    $sql = "SELECT * FROM image_files WHERE id=$imageID";

                    $result = $db->query($sql);

                    $mRows = array();
                    $data = array();


                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $mRows = array(
                                'name' => $row['name'],
                                'size' => (int)$row['size'],
                                'url' => $actual_link. "/upload/files/" . urlencode($row['name']),
                                'thumbnailUrl' => $actual_link. "/upload/files/thumbnail/" . urlencode($row['name']),
                                'deleteUrl' => $actual_link. "/upload/index.php?file=" . urlencode($row['name']) . "&_method=DELETE",
                                "deleteType" => "POST",
                                "id" => (int)$row['id'],
                                "type" => $row['type'],
                                "title" => $row['title'],
                                "description" => $row['description']);

                            array_push($data, $mRows);

                        }
                        $finaldata= array("files" => $data);
                    }
                    else {
                        $mRows = 'File does not exist';
                    }
                }
                else{
                    $data[] = 'Connection error';
                }
                header('Access-Control-Allow-Credentials:false');
                header('Access-Control-Allow-Headers:Content-Type, Content-Range, Content-Disposition');
                header('Access-Control-Allow-Methods:OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
                header('Access-Control-Allow-Origin:*');
                header('Cache-Control:no-store, no-cache, must-revalidate');
                header('Content-Type: application/json');

                print json_encode($finaldata);
            }
        }
        else if(strcmp($_POST['type'],'group') == 0)
        {
            if(!empty($_POST['id'])) {
                $db = new Database();
                $finaldata = array();

                $pid = $_POST['id'];
                $mRows = array();
                $data = array();

                $sql = "SELECT * FROM image_files WHERE pid = $pid";

                $result = $db->query($sql);

                $resultArray = array();


                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                        $mRows = array(
                            'name' => $row['name'],
                            'size' => (int)$row['size'],
                            'url' => $actual_link. "/upload/files/" . urlencode($row['name']),
                            'thumbnailUrl' => $actual_link. "/upload/files/thumbnail/" . urlencode($row['name']),
                            'deleteUrl' => $actual_link. "/upload/index.php?file=" . urlencode($row['name']) . "&_method=DELETE",
                            "deleteType" => "POST",
                            "id" => (int)$row['id'],
                            "type" => $row['type'],
                            "title" => $row['title'],
                            "description" => $row['description']);

                        array_push($data, $mRows);
                    }
                    $finaldata = array("files" => $data);

                } else {
                    $data[] = 'Connection error';
                }

                header('Access-Control-Allow-Credentials:false');
                header('Access-Control-Allow-Headers:Content-Type, Content-Range, Content-Disposition');
                header('Access-Control-Allow-Methods:OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
                header('Access-Control-Allow-Origin:*');
                header('Cache-Control:no-store, no-cache, must-revalidate');
                header('Content-Type: application/json');

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



