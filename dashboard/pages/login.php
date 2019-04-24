<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 7/1/2017
 * Time: 1:31 AM
 */

include("../../config/config.php");
include("../admin_files/classes/YihuaPostBase.php");
include("../admin_files/classes/User.php");

session_start();

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_POST["action"]=="submit") {
        if($_SESSION["verification"]==$_POST["in"]) {

            $yihua = new YihuaPostBase();

            $result = $yihua->checkUserPermissions($_POST['username'],$_POST['password']);

            if($result)
            {
                $_SESSION['login_user'] = $_POST['username'];

                header("location: panel.php");
            }
            else{
                $error = "用户名或密码错误";

            }
        }
        else{
            $error = "验证码错误";
        }

    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>平方米地产 - YIHUA POST</title>
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
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>平方米地产</b>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <?php

        if($error != null)
        {
            echo "
                                               <div class=\"alert alert-danger alert-dismissable\">
                                               <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo $error;
            echo " </div>";
        }
        ?>
        <form role="form" method = "post">
            <div class="form-group has-feedback">
                <input name="username" type="text" class="form-control" placeholder="用户名" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input name="password" type="password" class="form-control" placeholder="密码" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group has-feedback">
                        <input type="text" name="in" class="form-control" placeholder="区分大小写" required>
                        <input type="hidden" name="action" value="submit">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <img src="../plugins/verifphp/verification.php" class="img-rounded" alt="Cinque Terre" width="auto" height="50">
                    </div>
                </div>


                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> 记住我
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat"> 登录</button>
                </div>
                <!-- /.col -->
            </div>
        </form>


        <a href="#">忘记密码</a><br>
        <a href="enroll.php" class="text-center">注册</a>
    </div>
    <!-- /.login-box-body -->
    <div class="lockscreen-footer text-center">
        <b><a href="http://yihuapost.yihua.ca" class="text-black"> Powered By YIHUA POST </a></b>
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery 3.1.1 -->
<script src="../plugins/jQuery/jquery-3.1.1.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>

