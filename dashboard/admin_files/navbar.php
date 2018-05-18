<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 2017-06-19
 * Time: 5:59 PM
 */


function echoNavBarHtml($barID)
{
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

    echo "
        <aside class=\"main-sidebar\">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class=\"sidebar\">
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class=\"sidebar-menu\" data-widget=\"tree\">
                <li class=\"header\">导航栏</li>";
    echo (!$user->checkUserLevel(0))?"":"<li".checkBarID($barID,3)."><a href=\"edit_house_list.php\"><i class=\"fa fa-circle-o text-red\"></i> <span>房源管理</span></a></li>";
    echo (!$user->checkUserLevel(0))?"":"<li".checkBarID($barID,4)."><a href=\"add_house.php\"><i class=\"fa fa-circle-o text-red\"></i> <span>发布房源</span></a></li>";
    echo (!$user->checkUserLevel(10))?"":"<li".checkBarID($barID,5)."><a href=\"edit_hot_post.php\"><i class=\"fa fa-circle-o text-red\"></i> <span>头条管理</span></a></li>";
    echo (!$user->checkUserLevel(0))?"":"<li".checkBarID($barID,8)."><a href=\"edit_post_list.php\"><i class=\"fa fa-circle-o text-blue\"></i> <span>文章管理</span></a></li>";
    echo (!$user->checkUserLevel(0))?"":"<li".checkBarID($barID,7)."><a href=\"add_post.php\"><i class=\"fa fa-circle-o text-blue\"></i> <span>发布文章</span></a></li>";
    echo (!$user->checkUserLevel(10))?"":"<li".checkBarID($barID,13)."><a href=\"edit_post_category.php\"><i class=\"fa fa-circle-o text-blue\"></i> <span>文章分类管理</span></a></li>";
    echo (!$user->checkUserLevel(10))?"":"<li".checkBarID($barID,6)."><a href=\"edit_house_options.php\"><i class=\"fa fa-circle-o text-green\"></i> <span>房屋选项管理</span></a></li>";
    echo (!$user->checkUserLevel(10))?"":"<li".checkBarID($barID,10)."><a href=\"edit_user_list.php\"><i class=\"fa fa-user-circle\"></i> <span>用户管理</span></a></li>";

    echo (!$user->checkUserLevel(10))?"":"<li".checkBarID($barID,9)."><a href=\"edit_site_profile.php\"><i class=\"fa fa-book\"></i> <span>站点信息设置</span></a></li>";
    echo (!$user->checkUserLevel(10))?"":"<li".checkBarID($barID,14)."><a href=\"site_special_setting.php\"><i class=\"fa fa-book\"></i> <span>站点特殊信息编辑</span></a></li>";


    echo "
                <li class=\"header\">技术支持</li>";
    echo (!$user->checkUserLevel(10))?"":"<li".checkBarID($barID,11)."><a href=\"system_info.php\"><i class=\"fa fa-circle-o text-red\"></i> <span>网站版本</span></a></li>";
    echo (!$user->checkUserLevel(0))?"":"<li".checkBarID($barID,12)."><a href=\"system_about.php\"><i class=\"fa fa-circle-o text-yellow\"></i> <span>关于系统</span></a></li>";

    echo"        </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    ";
}

function checkBarID($id,$builtID)
{
    if($id === $builtID)
    {
        return " class='active' ";
    }
}

function checkBarFatherID($ifActive)
{
    if($ifActive === true)
    {
        return "active";
    }
}

