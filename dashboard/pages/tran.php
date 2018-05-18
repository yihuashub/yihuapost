<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 8/7/2017
 * Time: 2:58 AM
 */
include_once('../../config/config.php');


$db = new Database();



$result = $db->query("SELECT * FROM `dichan` ORDER BY `dichan`.`dichanid` ASC");

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result))
    {

        $a = $b = $c = $d = $e =$f=$g =$h = $i = "";

        $title =  $row["title"];

        $desc =  $row["description"];

        $idSold=0;
        $price =0;
        if (strpos($row["price"], 'SOLD') !== false || strpos($row["price"], 'sold') !== false) {
            $idSold = 1;
        }
        else{
            $price= filter_var($row["price"], FILTER_SANITIZE_NUMBER_INT);

        }

        $size= filter_var($row["size"], FILTER_SANITIZE_NUMBER_INT);

        $year= filter_var($row["houseage"], FILTER_SANITIZE_NUMBER_INT);

        $add =  multiexplode(array(" ","-"),$row["address"]);
        print_r($add);

        $length = count($add);
        $isAPT = 0;
        $aptNu = '';
        $addname = '';
        $addnumber = '';
        $addsuff = '';
        $houseType=0;

        if($length > 1)
        {
            if(is_numeric($add[0]) && is_numeric($add[1]))
            {
                $isAPT = 1;
                $houseType=1;

                if($length  == 3)
                {
                    $aptNu = $add[0];
                    $addnumber = $add[1];
                    $addname = ziti($add[2]);
                    echo "length == 3";
                }
                else
                {
                    $aptNu = $add[0];
                    $addnumber = $add[1];
                    $addname = ziti($add[2]).' '.ziti($add[3]);

                }

            }
            else{
                if($length == 1)
                {
                    $str = $add[0];
                    $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$str);

                    $addnumber = $arr[0];
                    $addname = ziti($arr[1]);
                }

                if($length  == 2)
                {
                    $addnumber = $add[0];
                    $addname = ziti($add[1]);
                    echo "length == 2";
                }
                if($length  == 3)
                {
                    $addnumber = $add[0];
                    $addname = ziti($add[1]);
                    $addsuff = ziti($add[2]);
                    echo "length == 3";
                }

            }
        }
        else{

            if($length == 1)
            {
                $str = $add[0];
                $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$str);

                $addnumber = $arr[0];
                $addname = ziti($arr[1]);

            }

            if($length  == 2)
            {
                $addnumber = $add[0];
                $addname = ziti($add[1]);
                echo "length == 2";
            }
            if($length  == 3)
            {
                $addnumber = $add[0];
                $addname = ziti($add[1]);
                $addsuff = ziti($add[2]);
                echo "length == 3";
            }

        }

        $parking = '';

        if(strpos($row["carhouse"], '单车') != false)
        {
            $parking=21;
        }
        else if(strpos($row["carhouse"], '双车') != false){
            $parking=22;
        }
        $date='';
        $mID ='';


        if(strtotime($row['date'])> 0){

            $date=$row['date'];


            $phpdate = strtotime( $row["date"] );
            $mysqldate = date( 'Ym', $phpdate );
            $mID=  (int)$mysqldate.$row['dichanid'].rand(10,100);

            echo $mID;
        }else{
            $mID= rand(2014,2016).rand(10,12).$row['dichanid'].rand(10,100);
        }



        $sql ="INSERT INTO web_house(`ID`, `house_ID`,`house_type`, `type`, `is_apt`, `title`, `price`, `apt_number`, `add_number`, `add_name`, `add_suffix`, `city`, `province`, `country`, `post_code`, `lat`, `long`, `house_bedroom`, `house_bathroom`, `house_sqft`, `house_year`, `description_cn`, `description_en`, `main_pic`, `status`, `date`) VALUES (NULL, '$mID', '$houseType','$idSold', '$isAPT', '$title', '$price', '$aptNu', '$addnumber', '$addname', '$addsuff', 'Winnipeg', 'Manitoba', 'Canada', '0', '0', '0', '0', '0', '$size', '$year', '$desc', NULL, '0', '0', '$date')";

        if ($db->query($sql) === TRUE)
        {
            echo "ok";
        }
        else
        {
            echo "no";
        }







    }
}


function multiexplode ($delimiters,$string) {

    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

function ziti($text)
{
    $new = strtolower($text);

    return ucfirst($new);
}