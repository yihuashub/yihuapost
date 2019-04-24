<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 11/19/2017
 * Time: 2:23 AM
 */

class UserList
{
    private $db;
    private $hasUserInfo;

    private $id;
    private $nickNmae;
    private $firstName;
    private $lastName;
    private $level;
    private $userName;
    private $userPassword;
    private $userEmail;
    private $userPhone;
    private $userDescriptionCn;
    private $userDescriptionEn;
    private $userJoinTime;

    private $message;



    public function __construct() {
        $this->db = new Database();
    }

    public function existUser($mUserName,$mUserPassword) {
        $this->userName = $mUserName;
        $this->userPassword = $mUserPassword;
    }

    public function getUserList()
    {
        $result = $this->db->query("SELECT * FROM site_user_invite");

        if ($result && mysqli_num_rows($result) > 0)  {
            while ($row = mysqli_fetch_assoc($result))
            {
                $this->id = $row['ID'];
                $this->nickNmae = $row['code'];
                $this->level = $row['link_id'];
            }
            return true;

        }else {
            $this->message = "用户名错误,无此用户。";
            return false;
        }
    }

}