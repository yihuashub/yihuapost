<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yihua
 * Date: 11/18/2017
 * Time: 4:31 PM
 */


include("../../config/config.php");
include("../admin_files/classes/UserController.php");


// define variables and set to empty values
$userName = $nickName = $passcode = $rePasscode = "";

$error = "";
$step = 1;
$inviteId = 0;
$check = true;
$errorMsg =array();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUser= new UserController();

    if($_POST["post-type"] == 1)
    {
        if(!empty($_POST["invite-code"])) {

            $inviteId = $_POST["invite-code"];
            if($newUser->enrollUserCheckCode($inviteId))
            {
                $step = 2;
            }
            else{
                $error = "邀请码不存在或已被注册";
            }
        }
    }
    else if($_POST["post-type"] == 2)
    {
        $step = 2;

        $inviteId = $_POST["invite-code"];

        if (empty($_POST["username"])) {
            array_push($errorMsg,"请输入用户名");
            $check = false;
        }
        else{
            $userName = $_POST["username"];

            if(strlen($userName) < 5)
            {
                array_push($errorMsg,"用户名需要大于5位");
                $check = false;
            }
        }

        if (empty($_POST["nickname"])) {
            array_push($errorMsg,"请输入全名");
            $check = false;
        } else{
            $nickName = $_POST["nickname"];
        }

        if (empty($_POST["password"])) {
            array_push($errorMsg,"请输入密码");
            $check = false;
        }
        else{
            $passcode = $_POST["password"];
        }

        if (empty($_POST["re-password"])) {
            array_push($errorMsg,"请确认输入密码");
            $check = false;
        }
        else{
            $rePasscode = $_POST["re-password"];
        }

        if ($rePasscode != $passcode) {
            array_push($errorMsg,"两次密码输入不一致");
            $check = false;

            if(strlen($passcode) < 5)
            {
                array_push($errorMsg,"密码需要大于5位");
                $check = false;
            }
        }

        if($check)
        {
            if($newUser->enrollUser($inviteId, $userName, $nickName, $passcode))
            {
                $step = 3;
            }
            else{
                $error = "注册失败 ".$newUser->getErrorMessage();
            }
        }
        else{
            $arrlength=count($errorMsg);

            for($x=0;$x<$arrlength;$x++)
            {
                if(1!=$errorMsg[$x])
                {
                    $error .= $errorMsg[$x].'</br>';
                }
            }
        }
    }

    else{
        $error = "请输入邀请码";
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>平方米地产</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
        <a href="./login.php"><b>平方米地产</b></a>
    </div>
    <?php

    if($error != null) {
        echoErrorMessage($error);
    }

    if($step == 2)
    {
        getRegisterHtml($inviteId);
    }
    else if($step == 1)
    {
        getInviteHtml();

    }
    else if($step == 3)
    {
        echSuccess();
    }

    ?>
    <div class="text-center">
        <a href="login.php">返回</a>
    </div>
        <div class="lockscreen-footer text-center">
        <b><a href="http://yihuapost.yihua.ca" class="text-black"> Powered By YIHUA POST </a></b>
    </div>
</div>
<!-- /.center -->

<!-- jQuery 3 -->
<script src="../plugins/jQuery/jquery-3.1.1.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

<?php

function getInviteHtml()
{
    echo "
    <!-- User name -->
    <div class=\"lockscreen-name\">请输入邀请码</div>

    <!-- START LOCK SCREEN ITEM -->
    <div class=\"lockscreen-item\">
        <!-- lockscreen image -->
        <div class=\"lockscreen-image\">
            <img src=\"../dist/img/logo.jpg\" alt=\"User Image\">
        </div>
        <!-- /.lockscreen-image -->

        <!-- lockscreen credentials (contains the form) -->
        <form  class=\"lockscreen-credentials\" role=\"form\" method = \"post\">
            <div class=\"input-group\">
                <input type=\"text\" name=\"invite-code\" class=\"form-control\" placeholder=\"邀请码\">

                <div class=\"input-group-btn\">
                <input type=\"text\" name=\"post-type\" value=\"1\" hidden>
                    <button type=\"submit\" class=\"btn\"><i class=\"fa fa-arrow-right text-muted\"></i></button>
                </div>
            </div>
        </form>
        <!-- /.lockscreen credentials -->

    </div>
    <!-- /.lockscreen-item -->
    <div class=\"help-block text-center\">
        请联系管理员获取邀请码
    </div>";


}


function getRegisterHtml($inviteId)
{
    echo "
<div class=\"register-box-body\">

<p class=\"login-box-msg\">欢迎您加入平方米地产</p>

    <form role=\"form\" method = \"post\">
      <div class=\"form-group has-feedback\">
        <input type=\"text\" name=\"username\" class=\"form-control\" placeholder=\"系统登录名 至少5位\">
        <span class=\"glyphicon glyphicon-user form-control-feedback\"></span>
      </div>
      <div class=\"form-group has-feedback\">
        <input type=\"text\" name=\"nickname\" class=\"form-control\" placeholder=\"全名\">
        <span class=\"glyphicon glyphicon-user form-control-feedback\"></span>
      </div>
      <div class=\"form-group has-feedback\">
        <input type=\"password\" name=\"password\" class=\"form-control\" placeholder=\"输入密码 至少5位\">
        <span class=\"glyphicon glyphicon-log-in form-control-feedback\"></span>
      </div>
      <div class=\"form-group has-feedback\">
        <input type=\"password\" name=\"re-password\" class=\"form-control\" placeholder=\"确认密码 至少5位\">
        <span class=\"glyphicon glyphicon-log-in form-control-feedback\"></span>
      </div>
      <div class=\"row\">
        <div class=\"col-xs-8\">

        </div>
        <!-- /.col -->
        <div class=\"col-xs-4\">
          <input type=\"text\" name=\"post-type\" value=\"2\" hidden>
          <input type=\"text\" name=\"invite-code\" value=\"$inviteId\" hidden>

          <button type=\"submit\" class=\"btn btn-primary btn-block btn-flat\">注册</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
</div>";
}

function echoErrorMessage($message)
{
    echo "
       <div class=\"alert alert-danger alert-dismissable\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
    echo $message;
    echo " </div>";
}

function echSuccess()
{
    echo "
       <div class=\"alert alert-success alert-dismissable\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
    echo "<h1>您已成功注册，欢迎您加入平方米地产</h1>";
    echo " </div>";
}
?>