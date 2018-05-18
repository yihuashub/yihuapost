<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yihua
 * Date: 11/19/2017
 * Time: 1:57 PM
 */

class UserController
{
    private $db;
    private $error;


    public function __construct() {
        $this->db = new Database();
    }

    public function enrollUserCheckCode($code)
    {
        $result = $this->db->query("SELECT * FROM `site_user_invite` WHERE `status` = 0 AND `code` LIKE '$code' ");

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result))
            {
                return true;
            }
        }
        else{
            return false;
        }
    }

    public function enrollUser($inviteId, $userName, $nickName, $passcode)
    {
        if($this->enrollUserCheckCode($inviteId))
        {
            if(!$this->checkHasUser($nickName)) {
                $result = $this->db->query("INSERT INTO `yihua_users` (`ID`, `username`, `passcode`, `nick_name`) VALUES (NULL, '$userName', '$passcode', '$nickName')");
                if ($result === TRUE) {
                    $newUserId = $this->db->insert_id();

                    if(!$this->updateInviteCode($inviteId,$newUserId)) {
                        $this->error = "系统错误:update error";
                        return false;
                    }
                    else{
                        return $this->initNewUser($newUserId);
                    }
                } else {
                    $this->error = "请尝试更换用户名";
                    return false;
                }
            }
            $this->error = "用户名已被注册";
            return false;
        }

        $this->error = "邀请码已失效";
        return false;


    }
    private function checkHasUser($nickName)
    {
        $result = $this->db->query("SELECT * FROM `yihua_users` WHERE `username` LIKE '$nickName' ");

        if ($result && mysqli_num_rows($result) > 0) {
            return true;
        }
        else{
            return false;
        }
    }

    private function updateInviteCode($code,$id)
    {
        $update = "UPDATE site_user_invite SET status = 1 ,link_id = $id  WHERE `code` LIKE '$code' ";

        if ($this->db->query($update) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function createNewUser()
    {
        $newCode =  uniqid();
        $result = $this->db->query("INSERT INTO `site_user_invite` (`ID`, `code`, `link_id`, `status`) VALUES (NULL, '$newCode', '0', '0');");

        if ($result === TRUE) {
            return $newCode;
        } else {
            $this->error = "初始化失败 ";
            return false;
        }
    }

    public function banUser($id)
    {
        $update = "UPDATE yihua_users SET status = '1' WHERE `ID` = $id ";

        if ($this->db->query($update) === TRUE) {
            $update2 = "UPDATE yihua_users_profile SET status = '1' WHERE `ID` = $id ";
            if ($this->db->query($update2) === TRUE) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function resetPassword($id)
    {
        $newPassword = $this->uniquePassword();
        $update = "UPDATE yihua_users SET passcode = '$newPassword' WHERE `ID` = $id ";

        if ($this->db->query($update) === TRUE) {
            return $newPassword;
        } else {
            return false;
        }
    }

    private  function uniquePassword($l = 8) {
        return substr(md5(uniqid(mt_rand(), true)), 0, $l);
    }

    public function getErrorMessage()
    {
        return $this->error;
    }

    private function initNewUser($id)
    {
        $date = date("Y-m-d");

        $result = $this->db->query("INSERT INTO `yihua_users_profile` (`ID`,`join_time`) VALUES ($id,'$date')");

        if ($result === TRUE) {
            return true;
        } else {
            $this->error = "用户初始化失败 ";
            return false;
        }
    }

}