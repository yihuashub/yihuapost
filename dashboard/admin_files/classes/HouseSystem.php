<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yihua
 * Date: 10/27/2017
 * Time: 5:29 PM
 */

class HouseSystem
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


    public function __construct($postID) {
        $this->db = new Database();

        $this->id = $postID;

        $this->getHouseInfo();
    }



    private function getHouseInfo()
    {
        $sql = "SELECT * FROM web_house WHERE ID = $this->id";

        $result = $this->db->query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->houseID = $row['house_ID'];
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

        }
    }


    public function getStatus()
    {
        return $this->status;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getSystemTitle() {
        if($this->isApt != 0)
        {
            return $this->aptNumber."-".$this->addNumber." ".$this->addName." ".$this->addSuffix.", ".$this->city.", ".$this->province.", ".$this->postCode;
        }
        else{
            return $this->addNumber." ".$this->addName." ".$this->addSuffix.", ".$this->city.", ".$this->province.", ".$this->postCode;
        }
    }

    public function getHouseId() {
        return $this->houseID;
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

    public function getPrice() {
        return $this->price;
    }

    public function getFormatPrice() {
        return $english_format_number = number_format($this->price);
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

    public function getHouseBedroom() {
        return $this->houseBedroom;
    }

    public function getHouseBathroom() {
        return $this->houseBathroom;
    }

    public function getHouseBasement() {
        return $this->houseBasement;
    }

    public function getHouseParking() {
        return $this->houseParking;
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

    public function hasImages()
    {
        $result = true;

        $sql = "SELECT * FROM image_files WHERE pid = $this->id";

        $sqlResult = $this->db->query($sql);

        if (mysqli_num_rows($sqlResult) > 0) {

        }
        else{
            $result = false;

        }
        return $result;

    }

    private function deleteAllImages()
    {
        $result = true;

        $sql = "SELECT * FROM image_files WHERE pid = $this->id";

        $sqlResult = $this->db->query($sql);

        if (mysqli_num_rows($sqlResult) > 0) {
            while ($row = mysqli_fetch_assoc($sqlResult)) {
                $mImageId = $row['id'];
                $result = $this->deleteImg($row['name']);

                if($result)
                {
                    $deleteSql = "DELETE FROM image_files WHERE id =$mImageId";

                    if (!$this->db->query($deleteSql))
                    {
                        $result = false;
                    }
                }

            }
        }
        return $result;

    }

    private function deleteImg($file)
    {
        $result = $this->deleteSystemImg('../../../upload/files/',$file);
        if($result)
        {
            return $this->deleteSystemImg('../../../upload/files/thumbnail/',$file);
        }
        return $result;
    }

    private function deleteSystemImg($path,$file)
    {
        $result = true;
        $filename = $path.$file;
        if(file_exists($filename))
        {
            if(!unlink($filename))
            {
                $result = false;
            }
        }
        else{
            $result = false;
        }
        return $result;
    }

    public function deleteSelf()
    {
        $result = true;

        if($this->hasImages())
        {
            $result = $this->deleteAllImages();
        }

        if($result)
        {
            $deleteSql = "DELETE FROM web_house WHERE ID =$this->id";

            if (!$this->db->query($deleteSql))
            {
                $result = false;
            }
        }

        return $result;
    }

}