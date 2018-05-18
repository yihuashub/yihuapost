<?php

include_once ("database.php");
$debug = false;
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

if($debug)
{
    define('DB_SERVER', '');

    define('DB_USERNAME', '');

    define('DB_PASSWORD', '');

    define('DB_DATABASE', '');
}
else
{
    define('DB_SERVER', '');

    define('DB_USERNAME', '');

    define('DB_PASSWORD', '');

    define('DB_DATABASE', '');
}


