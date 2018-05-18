<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 7/3/2017
 * Time: 6:18 PM
 */

include_once('../../config/config.php');
session_start();
$db = new Database();

//Initializing variable
$user_check = "";

$user_check = isset($_SESSION['login_user']) ? $_SESSION['login_user'] : '';


$ses_sql = $db->query("select username from yihua_users where username = '$user_check'");

$row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

$login_session = $row['username'];

if(!isset($_SESSION['login_user'])){
    header("location:../pages/login.php");
}
