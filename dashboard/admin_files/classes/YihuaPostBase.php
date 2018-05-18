<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 11/4/2017
 * Time: 10:36 PM
 */

class YihuaPostBase
{
    private $db;
    private $error;


    public function __construct() {
        $this->db = new Database();
    }

    public function checkUserPermissions($userName,$userPassword)
    {
        $result = $this->db->query("SELECT status FROM yihua_users WHERE username = '$userName' and passcode = '$userPassword'");


        if ($result) {
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            if($row['status'] == 1) {
                $this->message = "您无权登录";

            }
            else{
                if (mysqli_num_rows($result) == 1)  {
                    return true;
                }else {
                    $this->message = "用户名或密码错误";
                }
            }
        }


        return false;
    }

}