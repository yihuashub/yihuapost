<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yihua
 * Date: 11/17/2017
 * Time: 4:35 PM
 */

class HouseAgent
{
    private $lang;
    private $db;

    private $langCode;
    private $id;

    private $firstNameCn;
    private $lastNameCn;
    private $firstNameEn;
    private $lastNameEn;
    private $email;
    private $phone;
    private $joinTime;
    private $descriptionCn;
    private $descroptionEn;
    private $shortUrl;
    private $mainImage;
    private $standImage;
    private $backgroundImage;

    public function __construct($lang,$db) {
        (empty($db)) ? $this->db = new Database() : $this->db =$db;
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
        return $this->selectData(1);
    }

    public function createDataByUrl($url)
    {
        $this->shortUrl = $url;
        return $this->selectData(2);
    }


    private function selectData($case)
    {

        $sql = ($case == 1) ? "SELECT * FROM yihua_users_profile WHERE ID = $this->id" : "SELECT * FROM yihua_users_profile WHERE short_url LIKE '$this->shortUrl'";

        $result = $this->db->query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->id = $row['ID'];
                $this->firstNameCn = $row['first_name_cn'];
                $this->lastNameCn = $row['last_name_cn'];
                $this->firstNameEn = $row['first_name_en'];
                $this->lastNameEn = $row['last_name_en'];
                $this->email = $row['email'];
                $this->phone = $row['phone'];
                $this->joinTime = $row['join_time'];
                $this->descriptionCn = $row['description_cn'];
                $this->descroptionEn = $row['description_en'];
                $this->mainImage = $row['pic_main'];
                $this->standImage = $row['pic_stand'];
                $this->backgroundImage = $row['pic_background'];
                $this->shortUrl = $row['short_url'];
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

    public function getNameString(){
        if($this->langCode == 0) {
            return $this->lastNameCn.$this->firstNameCn;
        }
        else{
            return $this->firstNameEn." ".$this->lastNameEn;
        }
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getDescription() {
        if($this->langCode == 0) {
            if(empty($this->descriptionCn)) {
                return "您好，我是平方米地产经纪 ".$this->getNameString().", 欢迎您访问我的主页。";
            }
            else{
                return $this->descriptionCn;
            }
        }
        else{
            if(empty($this->descroptionEn)) {
                return "Hi there, My name is ".$this->getNameString().", a realty agent at Square Meter Realty. Welcome to visit my homepage.";
            }
            else{
                return $this->descroptionEn;
            }
        }
    }

    public function getDescriptionText()
    {
        return strip_tags($this->getDescription());
    }

    public function getUrlLink()
    {
        $rootUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";

        return $rootUrl.$this->shortUrl;
    }

    public function getMainPic()
    {
        if($this->mainImage != 0)
        {
            return $this->mainImage;
        }
        return false;
    }

    public function getMainPicUrl()
    {
        if(!empty($this->mainImage) && $this->mainImage != 0) {
            $image = new YihuaPostImage($this->db);

            if($image->getSingleImage($this->mainImage)) {
                return $image->getFilePath();
            }
        }
        $rootUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";

        return $rootUrl."site_files/images/default-user.jpg";
    }

    public function getStandPicUrl()
    {
        if(!empty($this->standImage) && $this->mainImage != 0) {
            $image = new YihuaPostImage($this->db);

            if($image->getSingleImage($this->standImage)) {
                return $image->getFilePath();
            }
        }

        return "";
    }

    public function getBackgroundPicUrl()
    {
        if(!empty($this->backgroundImage) && $this->mainImage != 0) {
            $image = new YihuaPostImage($this->db);

            if($image->getSingleImage($this->backgroundImage)) {
                return $image->getFilePath();
            }
        }
        $rootUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";

        return $rootUrl."site_files/images/background/PageInfo_Bg6.jpg";
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