<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yihua
 * Date: 11/5/2017
 * Time: 11:26 PM
 */


$user = new User();

$user_check = (isset($_SESSION['login_user']) ? $_SESSION['login_user'] : null);

if ($user_check != null) {
    if($user->getUserInfo($user_check)) {
        if ($user->getUserDetails()) {
        }
        else {
            header("location:500.php");
        }
    }
    else {
        header("location:500.php");
    }
}else {
    header("location:500.php");
}


if(!empty($requiredLevel))
{
    if(!$user->checkUserLevel($requiredLevel))
    {
        header("location:403.php");
    }
}

