<?php

// Including the check_permission file, don't delete the following row!
require('./check_permission.php');

if(isset($_POST["username"]) or isset($_POST["password"])){
    $tmpusername = strip_tags($_POST["username"]);
    $tmpusername = htmlspecialchars($tmpusername, ENT_QUOTES);
    $tmppassword = md5($_POST["password"]);
    $data = '$username = "'.$tmpusername.'"; $password = \''.$tmppassword.'\';'.PHP_EOL;
    $fp = fopen('./pluginconfig.php', 'a');
    fwrite($fp, $data);
    unlink("./new.php");
    unlink("./create.php");
    header("Location: imgbrowser.php");
} 

