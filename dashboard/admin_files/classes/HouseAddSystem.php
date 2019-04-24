<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 10/28/2017
 * Time: 10:11 PM
 */

class HouseAddSystem
{

    private $db;

    private $id;
    private $houseID;
    private $type;
    private $title;
    private $titleEn;
    private $price;
    private $houseYear;
    private $houseType;
    private $houseSqft;
    private $houseBedroom;
    private $houseBathroom;
    private $houseParking;
    private $isApt;
    private $addNumber;
    private $addName;
    private $addSuffix;
    private $city;
    private $province;
    private $country;
    private $postCode;
    private $latitude;
    private $longitude;
    private $houseDoor;
    private $houseSeat;
    private $descriptionEn;
    private $descriptionCn;
    private $mainPic;
    private $date;



    public function __construct() {
        $this->db = new Database();
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
        $result = $this->db->query("SELECT * FROM `web_house_options` WHERE `option_name` LIKE '$optionsString' ORDER BY `web_house_options`.`ord` ASC");

        $resultRow = array();

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result))
            {
                array_push($resultRow,$row);
            }
        }

        return $resultRow;
    }

}