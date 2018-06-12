<?php
/**
 * Copyright  2018 YIHUA
 * User: yihuahuang
 * Date: 2018-05-18
 * Time: 2:36 PM
 */


$step = 0;

$rootUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$error;

$host;
$username;
$password;
$database;

if(isset($_POST['step']))
{
    if(strcmp($_POST['step'],'step0') == 0)
    {
        $step = 1;
    }
    else if(strcmp($_POST['step'],'step1') == 0)
    {
        $step = 1;
        if(isset($_POST['host']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['database']))
        {
            if(!empty($_POST['host']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['database'])) {
                $host = $_POST['host'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $database = $_POST['database'];

                $conn = new mysqli($host, $username, $password);
                if(mysqli_connect_errno()) {
                    $error= "There was a problem connecting to the database: ".mysqli_connect_error();
                }

                $sql = "CREATE DATABASE IF NOT EXISTS `$database`";
                if ($conn->query($sql) === TRUE) {
                        $myfile = fopen("config/config.php", "w+") or die("config/config.php Unable to open file!");
                        $txt = "<?php
    include_once (\"database.php\");

    define('DB_SERVER', '$host');

    define('DB_USERNAME', '$username');

    define('DB_PASSWORD', '$password');

    define('DB_DATABASE', '$database');";

                        fwrite($myfile, $txt);
                        fclose($myfile);
                        $step = 2;
                }
                else {
                    $error = "There was a problem connecting to the database: " . $conn->error;
                }
            }
            else{
                $error= "(MySQL host) or (MySQL username) or (MySQL password) or (MySQL database) are missing.";
            }
        }
        else{
            $error= "(MySQL host) or (MySQL username) or (MySQL password) or (MySQL database) are missing.";
        }
    }
    else if(strcmp($_POST['step'],'step2') == 0)
    {
        $step = 2;
        $continue = true;
        $sqlName = 'config/web.sql';
        $webUrl = '';

        if(!empty($_POST['rooturl']))
        {
            $webUrl = $_POST['rooturl'];
        }
        else{
            $currentUrl = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }

        if(!empty($_FILES['sqlfile']))
        {
            $path_parts = pathinfo($_FILES["sqlfile"]["name"]);
            $extension = $path_parts['extension'];

            if(!empty($_FILES['sqlfile']['size']))
            {
                if(strcmp($extension,'sql') == 0 || strcmp($extension,'SQL') == 0)
                {

                    move_uploaded_file($_FILES["sqlfile"]["tmp_name"],
                        "config/upload_sql.sql");
                    $sqlName = "config/upload_sql.sql";
                }
                else{
                    $continue = false;
                    $error= "Error:file not allowed.";
                }
            }
        }

        if($continue)
        {
            require_once ("config/config.php");
            $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

            if($conn->connect_error) {
                $error= "There was a problem connecting to the database: ".$conn->connect_error;
            }
            else{
                $templine = '';
                $lines = file($sqlName);
                foreach ($lines as $line)
                {
                    if (substr($line, 0, 2) == '--' || $line == '')
                        continue;

                    $templine .= $line;
                    if (substr(trim($line), -1, 1) == ';')
                    {
                        mysqli_query($conn,$templine) or $error.+('Error performing query \'<strong>' . $templine . '\': ' . mysqli_connect_errno() . '<br/><br/>');
                        $templine = '';
                    }
                }



                $sql = "UPDATE  `site_profile` SET  `config` =  '$webUrl' WHERE `config_name` LIKE  'root_url'";
                if ($conn->query($sql) === TRUE) {
                    $step = 3;
                }
                else {
                    $error = "There was a problem connecting to the database: " . $conn->error;
                }

            }
        }

    }
    else if(strcmp($_POST['step'],'step3') == 0)
    {
        require_once ("config/config.php");
        $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if($conn->connect_error) {
            $error= "There was a problem connecting to the database: ".$conn->connect_error;
        }
        else{
            $sql = "UPDATE  `site_profile` SET  `config` =  '1' WHERE `config_name` LIKE  'site_status'";
            if ($conn->query($sql) === TRUE) {
                $step = 3;
            }
            else {
                $error = "There was a problem connecting to the database: " . $conn->error;
            }
        }

    }
}
function echoStepStart()
{
    $rootUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    echo "
    <div class=\"container\">
    <div class=\"row\">
        <div class=\"leftcolumn\">
            <div class=\"card\">
                <ul>
                    <li class=\"current\">Welcome<br><small>
                            <i>Server Environmental Check</i><br>
                        </small></li>
                    <li>Step 1</li>
                    <li>Step 2</li>
                    <li>Done</li>
                </ul>
            </div>
        </div>
        <div class=\"rightcolumn\">
            <div class=\"card\">
                <h2>Web Environmental Check</h2>";

    $indicesServer = array('PHP_SELF',
        'argv',
        'argc',
        'GATEWAY_INTERFACE',
        'SERVER_ADDR',
        'SERVER_NAME',
        'SERVER_SOFTWARE',
        'SERVER_PROTOCOL',
        'REQUEST_METHOD',
        'REQUEST_TIME',
        'REQUEST_TIME_FLOAT',
        'QUERY_STRING',
        'DOCUMENT_ROOT',
        'HTTP_ACCEPT',
        'HTTP_ACCEPT_CHARSET',
        'HTTP_ACCEPT_ENCODING',
        'HTTP_ACCEPT_LANGUAGE',
        'HTTP_CONNECTION',
        'HTTP_HOST',
        'HTTP_REFERER',
        'HTTP_USER_AGENT',
        'HTTPS',
        'REMOTE_ADDR',
        'REMOTE_HOST',
        'REMOTE_PORT',
        'REMOTE_USER',
        'REDIRECT_REMOTE_USER',
        'SCRIPT_FILENAME',
        'SERVER_ADMIN',
        'SERVER_PORT',
        'SERVER_SIGNATURE',
        'PATH_TRANSLATED',
        'SCRIPT_NAME',
        'REQUEST_URI',
        'PHP_AUTH_DIGEST',
        'PHP_AUTH_USER',
        'PHP_AUTH_PW',
        'AUTH_TYPE',
        'PATH_INFO',
        'ORIG_PATH_INFO') ;

    echo '<div class="filediv">
<table class="filetable">
<tbody>' ;
    foreach ($indicesServer as $arg) {
        if (isset($_SERVER[$arg])) {
            echo '<tr><label><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></label></tr>' ;
        }
        else {
            echo '<tr><label><td>'.$arg.'</td><td>-</td></label></tr>' ;
        }
    }
    echo '</</tbody></table></div>' ;

    echo"



                <h3>Operating System:".PHP_OS."</h3>
                <h3>PHP Version:".PHP_VERSION."</h3>
                <h3>Server API for this build of PHP.:".PHP_SAPI."</h3>
                <h3>Server Software Version:".$_SERVER['SERVER_SOFTWARE']."</h3>

                <form action=\"".$rootUrl."\" method=\"post\">
                    <input hidden name=\"step\" value=\"step0\">
                    <input type=\"submit\" value=\"Next Step\">
                </form>
            </div>
        </div>
    </div>
</div>";
}


function echoStepOne($error)
{
    $rootUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    echo "
    <div class=\"container\">
    <div class=\"row\">
        <div class=\"leftcolumn\">
            <div class=\"card\">
                <ul>
                    <li class=\"passed\">Welcome</li>
                    <li class=\"current\">Step 1<br><small>
                            <i>Web Environmental Settings</i><br>
                            <i>MySQL Initialization</i><br>
                        </small></li>
                    <li>Step 2</li>
                    <li>Done</li>
                </ul>
            </div>
        </div>
        <div class=\"rightcolumn\">
            <div class=\"card\">
                <h2>Web Environmental Settings</h2>";
    if($error){echo "<h3 style='color: red'>$error</h3>";}
    echo"       <form action=\"".$rootUrl."\" method=\"post\">
                    <input hidden name=\"step\" value=\"step1\">
                    <label for=\"host\">MySQL host</label>
                    <input type=\"text\" id=\"hostn\" name=\"host\" value=\"localhost\" placeholder=\"Please enter MySQL host..\">

                    <label for=\"username\">MySQL username</label>
                    <input type=\"text\" id=\"usern\" name=\"username\" placeholder=\"Please enter MySQL username..\">

                    <label for=\"password\">MySQL password</label>
                    <input type=\"password\" id=\"userp\" name=\"password\" placeholder=\"Please enter MySQL password..\">

                    <label for=\"database\">MySQL database</label>
                    <input type=\"text\" id=\"datab\" name=\"database\" placeholder=\"Please enter MySQL database..\">

                    <input type=\"submit\" value=\"Next Step\">
                </form>
            </div>
        </div>
    </div>
</div>";
}

function echoStepTwo($error,$database)
{
    $rootUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $currentUrl = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    echo "
    <div class=\"container\">
    <div class=\"row\">
        <div class=\"leftcolumn\">
            <div class=\"card\">
                <ul>
                    <li class=\"passed\">Welcome</li>
                    <li class=\"passed\">Step 1</li>
                    <li class=\"current\">Step 2<br><small>
                            <i>Website System Settings</i><br>
                            <i>Data Initialization</i><br>
                        </small></li>
                    <li>Done</li>
                </ul>
            </div>
        </div>
        <div class=\"rightcolumn\">
            <div class=\"card\">
                <h2>Website System Settings</h2>";
    if($error){echo "<h3 style='color: red'>$error</h3>";}
    echo"           <form action=\"".$rootUrl."\" method=\"post\" enctype=\"multipart/form-data\">
                    <input hidden name=\"step\" value=\"step2\">
                    
                    <p>System will be install to here:</p>
                    <label for=\"database\">MySQL database</label>
                    <input type=\"text\" id=\"datab\" name=\"database\" value=\"".$database."\" disabled>
                    <label for=\"rooturl\">Website root url:</label>
                    <input type=\"text\" id=\"url\" name=\"rooturl\" value=\"".$currentUrl."\" >
                    <hr>
                    <p>Use default data OR Import a site database</p>
                    <input type=\"file\" name=\"sqlfile\" id=\"sqlfile\" class=\"inputfile inputsqlfile\" data-multiple-caption=\"{count} files selected\">
                    <label for=\"sqlfile\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"17\" viewBox=\"0 0 20 17\"><path d=\"M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z\"></path></svg> <span>Choose a SQL file...</span></label>
                    <hr>
                    <input type=\"submit\" value=\"Next Step\">
                </form>
            </div>
        </div>
    </div>
</div>";
}

function echoStepDone($error)
{
    echo "
    <div class=\"container\">
    <div class=\"row\">
        <div class=\"leftcolumn\">
            <div class=\"card\">
                <ul>
                    <li class=\"passed\">Welcome</li>
                    <li class=\"passed\">Step 1</li>
                    <li class=\"passed\">Step 2</li>
                    <li class=\"current\">Done</li>
                </ul>
            </div>
        </div>
        <div class=\"rightcolumn\">
            <div class=\"card\">";
    if($error){echo "<h3 style='color: red'>$error</h3>";}
echo "
    <h2>The system has been installed successfully</h2>
                <h5>Thank you for using YIHUA POST</h5>
                <input type=\"button\" value=\"Go to Homepage\" onClick=\"window.location.reload()\">
            </div>
        </div>
    </div>
</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>YIHUA POST V1.1</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
        }

        input[type=text], select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=password], select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input:focus {
            border: 3px solid #555;
        }

        input[type=submit] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        .container, .panel {
            padding: 0.01em 16px;
        }

        /* Header/Blog Title */
        .header {
            padding: 30px;
            text-align: center;
            background: white;
        }

        .header h1 {
            font-size: 50px;
        }

        /* Style the top navigation bar */
        .topnav {
            overflow: hidden;
            background-color: #333;
        }

        /* Style the topnav links */
        .topnav a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        /* Change color on hover */
        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        /* Create two unequal columns that floats next to each other */
        /* Left column */
        .leftcolumn {
            float: left;
            width: 25%;
        }

        /* Right column */
        .rightcolumn {
            float: left;
            width: 75%;
            background-color: #f1f1f1;
            padding-left: 20px;
        }

        /* Fake image */
        .fakeimg {
            background-color: #aaa;
            width: 100%;
            padding: 20px;
        }

        /* Add a card effect for articles */
        .card {
            background-color: white;
            padding: 20px;
            margin-top: 20px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Footer */
        .footer {
            padding: 20px;
            text-align: center;
            background: #ddd;
            margin-top: 20px;
        }

        /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 800px) {
            .leftcolumn, .rightcolumn {
                width: 100%;
                padding: 0;
            }
        }

        /* Responsive layout - when the screen is less than 400px wide, make the navigation links stack on top of each other instead of next to each other */
        @media screen and (max-width: 400px) {
            .topnav a {
                float: none;
                width: 100%;
            }
        }

        ul {
            list-style: none;
            margin: 50px;
            padding: 0;
            font: normal 16px/22px Arial;
            color: #999;
        }
        li {
            overflow: hidden;
            position: relative;
            padding: 0 0 10px 35px;
        }
        li::before {
            content: '';
            position: absolute;
            left: 9px;
            top: 9px;
            width: 20px;
            height: 999px;
            border: 2px solid lightblue;
            border-width: 2px 0 0 2px;
        }
        li:last-child::before {
            border-width: 2px 0 0;
        }
        li::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 16px;
            height: 16px;
            background: #fff;
            border: 2px solid lightblue;
            border-radius: 50%;
        }
        li.current,
        li.passed {
            color: #000;
        }
        li.current::before {
            border-top-color: dodgerblue;
        }
        li.current::after {
            border-color: dodgerblue;
            background: dodgerblue;
        }
        li.passed::before,
        li.passed::after {
            border-color: dodgerblue;
        }


        .inputfile {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            /* position: absolute; */
            /* z-index: -1; */
        }

        .inputfile + label {
            max-width: 80%;
            font-size: 1.25rem;
            /* 20px */
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
            cursor: pointer;
            display: inline-block;
            overflow: hidden;
            padding: 0.625rem 1.25rem;
            /* 10px 20px */
        }

        .no-js .inputfile + label {
            display: none;
        }

        .inputfile:focus + label,
        .inputfile.has-focus + label {
            outline: 1px dotted #000;
            outline: -webkit-focus-ring-color auto 5px;
        }

        .inputfile + label * {
            /* pointer-events: none; */
            /* in case of FastClick lib use */
        }

        .inputfile + label svg {
            width: 1em;
            height: 1em;
            vertical-align: middle;
            fill: currentColor;
            margin-top: -0.25em;
            /* 4px */
            margin-right: 0.25em;
            /* 4px */
        }


        /* style 1 */

        .inputsqlfile + label {
            color: #f1e5e6;
            background-color: #d3394c;
        }

        .inputsqlfile:focus + label,
        .inputsqlfile.has-focus + label,
        .inputsqlfile + label:hover {
            background-color: #722040;
        }

        /* style-start*/
        div.filediv {
            background: rgba(255, 255, 225, 0.5);
            margin: 2px;
            width: 100%;
            height: 300px;
            border: 1px dotted black;
            overflow-x: scroll;
            overflow-y: scroll;
        }


        .filetable {
            border-collapse: collapse;
            width: 100%;
        }

        .filetable th, .filetable td {
            text-align: left;
            padding: 8px;
        }

        .filetable tr:nth-child(even){background-color: #dad7df
        }
        .filetable tr:nth-child(odd){background-color: #fbf9ff
        }

    </style>
</head>
<body>
<div class="header">
    <h1>Install & Repair Program</h1>
    <p>Powered By YIHUA POST v1.1</p>
</div>

<div class="topnav">
    <a href="http://yihuapost.yihua.ca" style="float:right">Learn more about YIHUA POST</a>
</div>

<?php

switch ($step) {
    case 1:
        echoStepOne($error);
        break;
    case 2:
        echoStepTwo($error,$database);
        break;
    case 3:
        echoStepDone($error);
        break;
    default:
        echoStepStart();
}


?>

<div class="footer">
    <h2>YIHUA POST v1.1 Build 20180527011</h2>
</div>

</body>

<script>
    'use strict';

    ;( function ( document, window, index )
    {
        var inputs = document.querySelectorAll( '.inputfile' );
        Array.prototype.forEach.call( inputs, function( input )
        {
            var label	 = input.nextElementSibling,
                labelVal = label.innerHTML;

            input.addEventListener( 'change', function( e )
            {
                var fileName = '';
                if( this.files && this.files.length > 1 )
                    fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
                else
                    fileName = e.target.value.split( '\\' ).pop();

                if( fileName )
                    label.querySelector( 'span' ).innerHTML = fileName;
                else
                    label.innerHTML = labelVal;
            });

            // Firefox bug fix
            input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
            input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
        });
    }( document, window, 0 ));
</script>
</html>
