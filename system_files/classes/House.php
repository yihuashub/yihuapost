<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 11/11/2017
 * Time: 6:47 PM
 */

class House
{
    private $lang;
    private $db;

    private $langCode;
    private $houseValue;
    private $id;

    private $uniqueID;
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
    private $houseBasement;
    private $isApt;
    private $aptNumber;
    private $addNumber;
    private $addName;
    private $addSuffix;
    private $city;
    private $province;
    private $country;
    private $postCode;
    private $latitude;
    private $longitude;
    private $include;
    private $development;
    private $descriptionEn;
    private $descriptionCn;
    private $mainPic;
    private $status;
    private $author;
    private $date;

    public function __construct($lang,$db) {
        (empty($db)) ? $this->db = new Database() : $this->db =$db;

        $this->houseValue = new HouseValue($this->db);
        $this->lang = $lang;

        if(strcmp($lang,'zh') == 0)
        {
            $this->langCode = 0;
        }
        else{
            $this->langCode = 1;
        }
    }

    public function createDataById($id)
    {
        $this->id = $id;
        return $this->selectDataById();
    }

    public function getDateByUniqueID($uniqueID)
    {
        $this->uniqueID = $uniqueID;
        return $this->selectDataByUniqueID();
    }

    private function selectDataById()
    {
        $sql = "SELECT * FROM web_house WHERE ID = $this->id";

        $result = $this->db->query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->uniqueID = $row['house_ID'];
                $this->type = $row['type'];
                $this->title = $row['title'];
                $this->titleEn = $row['title_en'];
                $this->price = $row['price'];
                $this->houseYear = $row['house_year'];
                $this->houseType = $row['house_type'];
                $this->houseSqft = $row['house_sqft'];
                $this->houseBedroom = $row['house_bedroom'];
                $this->houseBathroom = $row['house_bathroom'];
                $this->houseParking = $row['parking'];
                $this->houseBasement = $row['basement'];
                $this->isApt = $row['is_apt'];
                $this->aptNumber = $row['apt_number'];
                $this->addNumber = $row['add_number'];
                $this->addName = $row['add_name'];
                $this->addSuffix = $row['add_suffix'];
                $this->city = $row['city'];
                $this->province = $row['province'];
                $this->country = $row['country'];
                $this->postCode = $row['post_code'];
                $this->latitude = $row['lat'];
                $this->longitude = $row['long'];
                $this->include = $row['include'];
                $this->development = $row['development'];
                $this->descriptionEn = $row['description_en'];
                $this->descriptionCn = $row['description_cn'];
                $this->mainPic = $row['main_pic'];
                $this->status = $row['status'];
                $this->author = $row['author'];
                $this->date = $row['date'];
            }
            return true;
        }
        else{
            return false;
        }
    }

    private function selectDataByUniqueID()
    {
        $sql = "SELECT * FROM web_house WHERE house_ID LIKE $this->uniqueID";

        $result = $this->db->query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->id = $row['ID'];
                $this->type = $row['type'];
                $this->title = $row['title'];
                $this->titleEn = $row['title_en'];
                $this->price = $row['price'];
                $this->houseYear = $row['house_year'];
                $this->houseType = $row['house_type'];
                $this->houseSqft = $row['house_sqft'];
                $this->houseBedroom = $row['house_bedroom'];
                $this->houseBathroom = $row['house_bathroom'];
                $this->houseParking = $row['parking'];
                $this->houseBasement = $row['basement'];
                $this->isApt = $row['is_apt'];
                $this->aptNumber = $row['apt_number'];
                $this->addNumber = $row['add_number'];
                $this->addName = $row['add_name'];
                $this->addSuffix = $row['add_suffix'];
                $this->city = $row['city'];
                $this->province = $row['province'];
                $this->country = $row['country'];
                $this->postCode = $row['post_code'];
                $this->latitude = $row['lat'];
                $this->longitude = $row['long'];
                $this->include = $row['include'];
                $this->development = $row['development'];
                $this->descriptionEn = $row['description_en'];
                $this->descriptionCn = $row['description_cn'];
                $this->mainPic = $row['main_pic'];
                $this->status = $row['status'];
                $this->author = $row['author'];
                $this->date = $row['date'];
            }
            return true;
        }
        else{
            return false;
        }
    }


    //Get key data
    public function getId()
    {
        return $this->id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getTitle() {

        if($this->langCode == 0)
        {
            return $this->title;

        }
        else{
            return $this->titleEn;
        }
    }

    public function getSystemTitle() {
        if($this->isApt != 0)
        {
            return $this->aptNumber."-".$this->addNumber." ".$this->addName." ".$this->addSuffix.", ".$this->city;
        }
        else{
            return $this->addNumber." ".$this->addName." ".$this->addSuffix.", ".$this->city;
        }
    }

    public function getPageTitle() {
        return $this->getSystemTitle()." - ".$this->getTypeString();
    }

    public function getUniqueID() {
        return $this->uniqueID;
    }

    public function getDate() {
        return $this->date;
    }

    public function getAddress() {
        if($this->getAptNumber() === '0')
        {
            $address= $this->getAddNumber().' '.$this->getAddName().' '.$this->getAddSuffix();
        }
        else{
            $address= $this->getAptNumber().'-'.$this->getAddNumber().' '.$this->getAddName().' '.$this->getAddSuffix();

        }

        return $address;
    }

    public function getUnitPrice()
    {
        if($this->isSold())
        {
            if($this->langCode == 0)
            {
                return "已售房源不适用";
            }
            else{
                return "N/A";
            }
        }
        else{
            if(!empty($this->getPrice()) && !empty($this->getHouseSqft())){
                return "$".floor($this->getPrice()/$this->getHouseSqft());
            }
            else{
                return "N/A";
            }
        }
    }

    public function getPrice() {
        return $this->price;
    }

    public function getFormatPrice() {
        if($this->isSold())
        {
            return $this->getTypeString();
        }
        else{
            return "$".$english_format_number = number_format($this->price);
        }
    }

    public function getKstylePrice()
    {
        if($this->isSold())
        {
            return $this->getTypeString();
        }
        else{
            if ($this->price > 999 && $this->price <= 999999) {
                $result = "$".floor($this->price / 1000) . ' K';
            } elseif ($this->price > 999999) {
                $result = "$".floor($this->price / 1000000) . ' M';
            } else {
                $result = $this->getFormatPrice();
            }

            return $result;
        }
    }
    public function getYear() {
        return $this->houseYear;
    }

    public function getType() {
        return $this->type;
    }

    public function getTitleEn() {
        return $this->titleEn;
    }

    public function getAptNumber() {
        return $this->aptNumber;
    }

    public function getHouseSqft() {
        return $this->houseSqft;
    }

    public function getFormatHouseSqft() {
        return $english_format_number = number_format($this->houseSqft);
    }

    public function getHouseType() {
        return $this->houseType;
    }

    public function getAddNumber() {
        return $this->addNumber;
    }

    public function getAddName() {
        return $this->addName;
    }

    public function getAddSuffix() {
        return $this->addSuffix;
    }

    public function getCity() {
        return $this->city;
    }

    public function getProvince() {
        return $this->province;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getPostcode() {
        return $this->postCode;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function getInclude() {
        return $this->include;
    }

    public function getDevelopment() {
        return $this->development;
    }

    public function getDescriptionEn() {
        return $this->descriptionEn;
    }

    public function getDescriptionCn() {
        return $this->descriptionCn;
    }

    public function getDescription(){
        if($this->langCode == 0) {
            return $this->getDescriptionCn();
        }
        else{
            return $this->getDescriptionEn();
        }
    }

    public function getAuthor(){
        return $this->author;
    }

    public function isApt()
    {
        if($this->isApt == 1)
        {
            return true;
        }

        return false;

    }
    public function getMainPic()
    {
        if($this->mainPic != 0)
        {
            return $this->mainPic;
        }
        return false;
    }

    public function getBedroomString()
    {
        $mArray = $this->houseValue->getBedroomArray();

        if($this->langCode == 0)
        {
            foreach ($mArray as $row) {
                if(strcmp($this->houseBedroom,$row['value']) == 0) {
                    return $row['name_cn'];
                }
            }
        }
        else{
            foreach ($mArray as $row) {
                if(strcmp($this->houseBedroom,$row['value']) == 0) {
                    return $row['name_en'];
                }
            }
        }
    }

    public function getBathroomString()
    {
        $mArray = $this->houseValue->getBathroomArray();

        if($this->langCode == 0)
        {
            foreach ($mArray as $row) {
                if(strcmp($this->houseBathroom,$row['value']) == 0) {
                    return $row['name_cn'];
                }
            }
        }
        else{
            foreach ($mArray as $row) {
                if(strcmp($this->houseBathroom,$row['value']) == 0) {
                    return $row['name_en'];
                }
            }
        }
    }

    public function getHouseTypeString()
    {
        $mArray = $this->houseValue->getHouseTypeArray();

        if($this->langCode == 0)
        {
            foreach ($mArray as $row) {
                if(strcmp($this->houseType,$row['value']) == 0) {
                    return $row['name_cn'];
                }
            }
        }
        else{
            foreach ($mArray as $row) {
                if(strcmp($this->houseType,$row['value']) == 0) {
                    return $row['name_en'];
                }
            }
        }
    }

    public function getHouseParkingString()
    {
        $mArray = $this->houseValue->getParkingArray();

        if($this->langCode == 0)
        {
            foreach ($mArray as $row) {
                if(strcmp($this->houseParking,$row['value']) == 0) {
                    return $row['name_cn'];
                }
            }
        }
        else{
            foreach ($mArray as $row) {
                if(strcmp($this->houseParking,$row['value']) == 0) {
                    return $row['name_en'];
                }
            }
        }
    }


    public function getHouseBasementString() {
        $mArray = $this->houseValue->getBasementArray();

        if($this->langCode == 0)
        {
            foreach ($mArray as $row) {
                if(strcmp($this->houseBasement,$row['value']) == 0) {
                    return $row['name_cn'];
                }
            }
        }
        else{
            foreach ($mArray as $row) {
                if(strcmp($this->houseBasement,$row['value']) == 0) {
                    return $row['name_en'];
                }
            }
        }
    }

    public function getDevelopmentString() {
        $mArray = $this->houseValue->getDevelopmentArray();

        if($this->langCode == 0)
        {
            foreach ($mArray as $row) {
                if(strcmp($this->development,$row['value']) == 0) {
                    return $row['name_cn'];
                }
            }
        }
        else{
            foreach ($mArray as $row) {
                if(strcmp($this->development,$row['value']) == 0) {
                    return $row['name_en'];
                }
            }
        }
    }

    public function getIncludeString() {
        $mArray = $this->houseValue->getIncludeArray();

        if($this->langCode == 0)
        {
            foreach ($mArray as $row) {
                if(strcmp($this->include,$row['value']) == 0) {
                    return $row['name_cn'];
                }
            }
        }
        else{
            foreach ($mArray as $row) {
                if(strcmp($this->include,$row['value']) == 0) {
                    return $row['name_en'];
                }
            }
        }
    }

    public function getHouseBedroom() {
        $mArray = $this->houseValue->getBedroomArray();

        if($this->langCode == 0)
        {
            foreach ($mArray as $row) {
                if(strcmp($this->houseBedroom,$row['value']) == 0) {
                    return $this->trimNumberFromString($row['name_cn']);
                }
            }
        }
        else{
            foreach ($mArray as $row) {
                if(strcmp($this->houseBedroom,$row['value']) == 0) {
                    return $this->trimNumberFromString($row['name_en']);
                }
            }
        }    }

    public function getHouseBathroom() {
        $mArray = $this->houseValue->getBathroomArray();

        if($this->langCode == 0)
        {
            foreach ($mArray as $row) {
                if(strcmp($this->houseBathroom,$row['value']) == 0) {
                    return $this->trimNumberFromString($row['name_cn']);
                }
            }
        }
        else{
            foreach ($mArray as $row) {
                if(strcmp($this->houseBathroom,$row['value']) == 0) {
                    return $this->trimNumberFromString($row['name_en']);
                }
            }
        }
    }

    public function getHouseBedroomArray() {
        $mArray = $this->houseValue->getBedroomArray();
        $result = array();

        if($this->langCode == 0)
        {
            foreach ($mArray as $row) {
                array_push($result,array('value'=>$row['value'],'string'=>$row['name_cn']));
            }
            return $result;
        }
        else{
            foreach ($mArray as $row) {
                array_push($result,array('value'=>$row['value'],'string'=>$row['name_en']));
            }
            return $result;
        }
    }

    public function getHouseBathroomArray() {
        $mArray = $this->houseValue->getBathroomArray();
        $result = array();

        if($this->langCode == 0)
        {
            foreach ($mArray as $row) {
                array_push($result,array('value'=>$row['value'],'string'=>$row['name_cn']));
            }
            return $result;
        }
        else{
            foreach ($mArray as $row) {
                array_push($result,array('value'=>$row['value'],'string'=>$row['name_en']));
            }
            return $result;
        }
    }

    public function getSqftString()
    {
        if($this->langCode == 0)
        {
            return $english_format_number = number_format($this->houseSqft)." 平方英尺";

        }
        else{
            return $english_format_number = number_format($this->houseSqft)." sq / ft";
        }
    }

    public function getTypeString()
    {
        if($this->langCode == 0)
        {
            if($this->type == 1)
            {
                return "已售";
            }
            else if($this->type == 2)
            {
                return "出售中";
            }
            else if($this->type == 3)
            {
                return "特价";
            }
            else
            {
                return "其他";
            }
        }
        else{
            if($this->type == 1)
            {
                return "SOLD";
            }
            else if($this->type == 2)
            {
                return "For Sale";
            }
            else if($this->type == 3)
            {
                return "Special offer";
            }
            else
            {
                return "Other";
            }
        }
    }

    public function isSold()
    {
        return ($this->type == 1) ? true:false;
    }

    public function getUrlLink()
    {
        $rootUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";

        return $rootUrl."house/".$this->uniqueID;
    }

    private function trimNumberFromString($string)
    {
        $str=trim($string);

        if(empty($str)){return '';}
        $temp=array('1','2','3','4','5','6','7','8','9','0','.');
        $mumList = array();
        $result='';
        $maxNum = 0;
        for($i=0;$i<strlen($str);$i++){
            if(in_array($str[$i],$temp)){

                if(is_numeric($str[$i])){
                    $result.=$str[$i];
                }
                if($str[$i]=='.' && is_numeric($str[$i-1])&&is_numeric($str[$i-1])){
                    $result.=$str[$i];
                }
                if(($i+1)==strlen($str)){

                    if($maxNum==0||$maxNum < $result){
                        $maxNum = $result;
                    }

                    $mumList[] = $result;
                    $result = '';
                }
            }else{
                if($maxNum==0||$maxNum < $result){
                    $maxNum = $result;
                }
                $mumList[] = $result;
                $result = '';
            }
        }
        $mumList = array_values(array_filter($mumList));

        return $mumList[0];
    }


}