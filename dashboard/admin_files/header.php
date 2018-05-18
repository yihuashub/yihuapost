<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 6/19/2017
 * Time: 9:28 PM
 */
include_once('../admin_files/classes/User.php');

function echoheader()
{

    $user = new User();
    $user_check = isset($_SESSION['login_user']) ? $_SESSION['login_user'] : '';

    if ($user->getUserInfo($user_check))
    {
        $nickName = $user->getNickNmae();
    } else {
        header("location:500.php");
    }


    echo "
        <header class=\"main-header\">

        <!-- Logo -->
        <a href=\"panel.php\" class=\"logo\">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class=\"logo-mini\"><i class=\"fa fa-ravelry fa-lg\"></i></span>
            <!-- logo for regular state and mobile devices -->
            <span class=\"logo-lg\"><b>平方米地产</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class=\"navbar navbar-static-top\">
            <!-- Sidebar toggle button-->
            <a href=\"#\" class=\"sidebar-toggle\" data-toggle=\"push-menu\" role=\"button\">
                <span class=\"sr-only\">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class=\"navbar-custom-menu\">
                <ul class=\"nav navbar-nav\">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class=\"dropdown messages-menu\">

                        <!-- User Account: style can be found in dropdown.less -->
                    <li class=\"dropdown user user-menu\">
                        <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">
                            <img src=\"../dist/img/user.jpg\" class=\"user-image\" alt=\"User Image\">
                            <span class=\"hidden-xs\">".$nickName."</span>
                        </a>
                        <ul class=\"dropdown-menu\">
                            <!-- User image -->
                            <li class=\"user-header\">
                                <img src=\"../dist/img/user.jpg\" class=\"img-circle\" alt=\"User Image\">
                                <p>
                                    ".$nickName."
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class=\"user-footer\">
                                <div class=\"pull-left\">
                                  <a href=\"../pages/user_profile.php\" class=\"btn btn-default btn-flat\">资料设置</a>
                                </div>
                                <div class=\"pull-right\">
                                    <a href=\"../admin_files/logout.php\" class=\"btn btn-default btn-flat\">登出</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>";
}

function importLink($inComingLink)
{

    echo "
        <!-- Bootstrap 3.3.7 -->
    <link rel=\"stylesheet\" href=\"../bootstrap/css/bootstrap.min.css\">
    <!-- Font Awesome -->
    <link rel=\"stylesheet\" href=\"../plugins/font-awesome/css/font-awesome.min.css\">
    <!-- Ionicons -->
    <link rel=\"stylesheet\" href=\"../plugins/ionicons/css/ionicons.min.css\">
    <!-- Theme style -->
    <link rel=\"stylesheet\" href=\"../dist/css/AdminLTE.min.css\">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel=\"stylesheet\" href=\"../dist/css/skins/_all-skins.min.css\">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src=\"https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js\"></script>
    <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel=\"stylesheet\" href=\"https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic\">
    ";

    echo $inComingLink;
}