<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 11/5/2017
 * Time: 1:48 PM
 */

class User
{
    private $db;
    private $hasUserInfo;

    private $id;
    private $nickNmae;
    private $firstNameEn;
    private $lastNameEn;
    private $firstNameCn;
    private $lastNameCn;
    private $level;
    private $userName;
    private $userPassword;
    private $userEmail;
    private $userPhone;
    private $userDescriptionCn;
    private $userDescriptionEn;
    private $userJoinTime;
    private $userShortUrl;
    private $userMainImage;
    private $userStandImage;
    private $userBackgroundImage;


    private $message;
    private $status;


    public function __construct()
    {
        $this->db = new Database();
        $this->hasUserInfo = false;
    }

    public function existUser($mUserName, $mUserPassword)
    {
        $this->userName = $mUserName;
        $this->userPassword = $mUserPassword;
    }

    public function getUserInfo($mUserName)
    {
        $myusername = $this->db->mysqli_real_escape_string($mUserName);

        $result = $this->db->query("SELECT * FROM yihua_users WHERE username LIKE '$myusername'");

        if (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->id = $row['ID'];
                $this->nickNmae = $row['nick_name'];
                $this->level = $row['user_level'];
            }
            return true;

        } else {
            $this->message = "用户名错误,无此用户。";
            return false;
        }
    }

    public function getUserDetails()
    {
        $result = $this->db->query("SELECT * FROM yihua_users_profile WHERE ID = '$this->id'");

        if (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->userEmail = $row['email'];
                $this->userPhone = $row['phone'];
                $this->userDescriptionCn = $row['description_cn'];
                $this->userDescriptionEn = $row['description_en'];
                $this->status = $row['status'];
                $this->userJoinTime = $row['join_time'];
                $this->firstNameCn = $row['first_name_cn'];
                $this->lastNameCn = $row['last_name_cn'];
                $this->firstNameEn = $row['first_name_en'];
                $this->lastNameEn = $row['last_name_en'];
                $this->userMainImage = $row['pic_main'];
                $this->userStandImage = $row['pic_stand'];
                $this->userBackgroundImage = $row['pic_background'];
                $this->userShortUrl = $row['short_url'];
            }
            return true;

        } else {
            $this->message = "用户名错误,无此用户。";
            return false;
        }
    }

    public function updateSortUrl($inUrl)
    {
        $url = preg_replace("/[^a-zA-Z0-9]+/", "", $inUrl);

        $result = $this->db->query("UPDATE `yihua_users_profile` SET `short_url` = '$url' WHERE `ID` = $this->id");

        if ($result === TRUE) {

            if($this->checkRewriteEngine())
            {
                return $this->updateRewriteEngine($url);
            }else{
                return $this->insertRewriteEngine($url);
            }
        } else {
            return false;
        }
    }

    private function checkRewriteEngine()
    {
        $sql = "SELECT * FROM `site_rewrite_url` WHERE `url` LIKE '$this->userShortUrl'";
        $result = $this->db->query($sql);

        return (mysqli_num_rows($result)) ? true : false;
    }

    private function insertRewriteEngine($url)
    {
        $result = $this->db->query("INSERT INTO `site_rewrite_url` (`ID`, `rewrite_size`, `url`, `rewrite`) VALUES (NULL, '1', '$url', 'agent_home')");

        if ($result === TRUE) {
            $this->userShortUrl;
            return true;
        } else {
            return false;
        }

    }


    private function updateRewriteEngine($url)
    {
        $update = "UPDATE `site_rewrite_url` SET `url` = '$url' WHERE `url` LIKE '$this->userShortUrl'";

        if ($this->db->query($update) === TRUE) {
            $this->userShortUrl;
            return true;
        } else {
            return false;
        }

    }

    public function uploadStandPic($picId, $userId)
    {
        $result = $this->db->query("UPDATE `yihua_users_profile` SET `pic_stand` = '$picId' WHERE `ID` = $userId");

        if ($result === TRUE) {
            $this->userStandImage = $picId;
            return true;
        } else {
            return false;
        }
    }

    public function destroyStandPic($userId)
    {
        $result = $this->db->query("UPDATE `yihua_users_profile` SET `pic_stand` = '0' WHERE `ID` = $userId");

        if ($result === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function uploadMainPic($picId, $userId)
    {
        $result = $this->db->query("UPDATE `yihua_users_profile` SET `pic_main` = '$picId' WHERE `ID` = $userId");

        if ($result === TRUE) {
            $this->userMainImage = $picId;
            return true;
        } else {
            return false;
        }
    }

    public function destroyMainPic($userId)
    {
        $result = $this->db->query("UPDATE `yihua_users_profile` SET `pic_main` = '0' WHERE `ID` = $userId");

        if ($result === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function uploadBackgroundPic($picId, $userId)
    {
        $result = $this->db->query("UPDATE `yihua_users_profile` SET `pic_background` = '$picId' WHERE `ID` = $userId");

        if ($result === TRUE) {
            $this->userBackgroundImage = $picId;
            return true;
        } else {
            return false;
        }
    }

    public function destroyBackgroundPic($userId)
    {
        $result = $this->db->query("UPDATE `yihua_users_profile` SET `pic_background` = '0' WHERE `ID` = $userId");

        if ($result === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function getStandPic()
    {
        return $this->userStandImage;
    }

    public function getMainPic()
    {
        return $this->userMainImage;
    }

    public function getBackgroundPic()
    {
        return $this->userBackgroundImage;
    }

    public function getNickNmae()
    {
        return $this->nickNmae;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLastNameEn()
    {
        return $this->lastNameEn;
    }

    public function getLastNameCn()
    {
        return $this->lastNameCn;
    }

    public function getFirstNameCn()
    {
        return $this->firstNameCn;
    }

    public function getFirstNameEn()
    {
        return $this->firstNameEn;
    }
    public function getNameCn()
    {
        return $this->lastNameCn . $this->firstNameCn;
    }

    public function getNameEn()
    {
        return $this->lastNameEn . ", " . $this->firstNameEn;
    }

    public function getPhone()
    {
        return $this->userPhone;
    }

    public function getEmaill()
    {
        return $this->userEmail;
    }

    public function getDescriptionCn()
    {
        return $this->userDescriptionCn;
    }

    public function getDescriptionEn()
    {
        return $this->userDescriptionEn;
    }

    public function getJoinTime()
    {
        return $this->userJoinTime;
    }

    public function getProfileImageS()
    {
        return "../dist/img/user.jpg";
    }

    public function getShortUrl()
    {
        return $this->userShortUrl;
    }

    public function checkUserLevel($requiredLevel)
    {
        if ($this->level < $requiredLevel) {
            return false;
        } else {
            return true;
        }
    }

    public function updateEmail($newEmail)
    {
        $result = $this->db->query("UPDATE `yihua_users_profile` SET `email` = '$newEmail' WHERE `ID` = $this->id");

        if ($result === TRUE) {
            $this->userEmail = $newEmail;
            return true;
        } else {
            return false;
        }
    }

    public function updatePhone($newPhone)
    {
        $result = $this->db->query("UPDATE `yihua_users_profile` SET `phone` = '$newPhone' WHERE `ID` =  $this->id");

        if ($result === TRUE) {
            $this->userPhone = $newPhone;
            return true;
        } else {
            return false;
        }
    }

    public function updateFirstNameCn($comingData)
    {
        $result = $this->db->query("UPDATE `yihua_users_profile` SET `first_name_cn` = '$comingData' WHERE `ID` =  $this->id");

        if ($result === TRUE) {
            $this->firstNameCn = $comingData;
            return true;
        } else {
            return false;
        }
    }

    public function updateLastNameCn($comingData)
    {
        $result = $this->db->query("UPDATE `yihua_users_profile` SET `last_name_cn` = '$comingData' WHERE `ID` =  $this->id");

        if ($result === TRUE) {
            $this->lastNameCn = $comingData;
            return true;
        } else {
            return false;
        }
    }

    public function updateDescriptionCn($comingData)
    {
        $result = $this->db->query("UPDATE `yihua_users_profile` SET `description_cn` = '$comingData' WHERE `ID` =  $this->id");

        if ($result === TRUE) {
            $this->userDescriptionCn = $comingData;
            return true;
        } else {
            return false;
        }
    }

    public function updateFirstNameEn($comingData)
    {
        $result = $this->db->query("UPDATE `yihua_users_profile` SET `first_name_en` = '$comingData' WHERE `ID` =  $this->id");

        if ($result === TRUE) {
            $this->firstNameEn = $comingData;
            return true;
        } else {
            return false;
        }
    }

    public function updateLastNameEn($comingData)
    {
        $result = $this->db->query("UPDATE `yihua_users_profile` SET `last_name_en` = '$comingData' WHERE `ID` =  $this->id");

        if ($result === TRUE) {
            $this->lastNameEn = $comingData;
            return true;
        } else {
            return false;
        }
    }

    public function updateDescriptionEn($comingData)
    {
        $result = $this->db->query("UPDATE `yihua_users_profile` SET `description_en` = '$comingData' WHERE `ID` =  $this->id");

        if ($result === TRUE) {
            $this->userDescriptionEn = $comingData;
            return true;
        } else {
            return false;
        }
    }

    public function getErrorMessage()
    {
        return $this->message;
    }

}