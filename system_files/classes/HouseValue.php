<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 11/11/2017
 * Time: 10:17 PM
 */


class HouseValue
{

    private $db;

    public function __construct($db) {
        (empty($db)) ? $this->db = new Database() : $this->db =$db;
    }

    public function getBathroomArray()
    {
        $mArray = $this->getSelectArrayFromDB('bathroom');

        if($mArray)
        {
            return $mArray;
        }

        return false;
    }

    public function getBedroomArray()
    {
        $mArray = $this->getSelectArrayFromDB('bedroom');

        if($mArray)
        {
            return $mArray;
        }

        return false;
    }

    public function getBasementArray()
    {
        $mArray = $this->getSelectArrayFromDB('basement');

        if($mArray)
        {
            return $mArray;
        }

        return false;
    }

    public function getIncludeArray()
    {
        $mArray = $this->getSelectArrayFromDB('include');

        if($mArray)
        {
            return $mArray;
        }

        return false;
    }

    public function getDevelopmentArray()
    {
        $mArray = $this->getSelectArrayFromDB('development');

        if($mArray)
        {
            return $mArray;
        }

        return false;
    }

    public function getParkingArray()
    {
        $mArray = $this->getSelectArrayFromDB('parking');

        if($mArray)
        {
            return $mArray;
        }

        return false;
    }

    public function getHouseTypeArray()
    {
        $mArray = $this->getSelectArrayFromDB('house-type');

        if($mArray)
        {
            return $mArray;
        }

        return false;
    }

    private function getSelectArrayFromDB($optionsString)
    {
        $result = $this->db->query("SELECT * FROM `web_house_options` WHERE `option_name` LIKE '$optionsString' ORDER BY `ord` ASC");

        $resultRow = array();

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result))
            {
                array_push($resultRow,$row);
            }
        }
        else{
            return false;
        }

        return $resultRow;
    }

}