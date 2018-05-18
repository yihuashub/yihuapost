<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 11/14/2017
 * Time: 10:17 PM
 */

class HouseSearch
{
    private $lang;
    private $phone;
    private $db;

    private $totalCount;
    private $totalPageCount;
    private $currentPageIndex;

    public function __construct($db)
    {
        (empty($db)) ? $this->db = new Database() : $this->db = $db;
    }

    public function getResult($name,$bathroom,$bedroom,$min,$max)
    {
        $base = "SELECT ID FROM `web_house` WHERE `type` > 1 ";
        $check = false;
        if(!empty($min) && !empty($max)) {
            $base .= " AND `price` BETWEEN $min AND $max ";
        }else{
            $check = true;
        }

        if(!empty($bathroom)) {
            $base .= " AND `house_bathroom` =$bathroom ";
        }else{
            $check = true;
        }

        if(!empty($bedroom)) {
            $base .= " AND `house_bedroom` ='$bedroom' ";
        }else{
            $check = true;
        }

        if(!empty($name)) {
            $base .= " AND (`add_name` LIKE '%$name%' OR `add_number` = '$name' OR `apt_number` = '$name') ";
        }else{
            $check = true;
        }


        $base .=" ORDER BY `type` DESC, `ID` DESC";

        if($check) {
            $result = $this->db->query($base);
            $resultArray = array();

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($resultArray, $row['ID']);
                }
                return $resultArray;
            } else {
                return false;
            }
        }
        return false;

    }
}