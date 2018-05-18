<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 7/3/2017
 * Time: 7:28 PM
 */

define("pageName","编辑站点信息");
$requiredLevel = 10;

require_once ("../admin_files/webUI.php");
require_once("../admin_files/classes/User.php");
require_once ("../admin_files/user_function.php");
$db = new Database();


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php getTitle(pageName) ?>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php importLink("
<!-- blueimp Gallery styles -->
<link rel=\"stylesheet\" href=\"//blueimp.github.io/Gallery/css/blueimp-gallery.min.css\">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload.css\">
<link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload-ui.css\">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload-noscript.css\"></noscript>
<noscript><link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload-ui-noscript.css\"></noscript>
    ")?>


</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">


    <?php echoheader() ?>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <?php echoNavBarHtml(9) ?>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo pageName; ?>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> 主页</a></li>
                <li class="active"><?php echo pageName; ?></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <?php
            // define variables and set to empty values
            $siteName = $siteKeywords = $siteDescription = $coptrightInfo = $phoneInfo = $phoneInfo2 = "";
            $siteNameEn = $siteKeywordsEn = $siteDescriptionEn = $address = $email = "";
            $configName=array("site_name","keywords","description","copyright","phone","site_name_en","keywords_en","description_en","address","email","phone2");
            $newConfig=array();


            $check = true;
            $permission = false;


            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if($_POST["request-code"]== 2)
                {
                    if (empty($_POST["site-name"])) {
                        $imgErr = "site-name is required";
                        $check = false;
                    }
                    else{
                        $siteName = $_POST["site-name"];
                        array_push($newConfig,$siteName);
                    }

                    if (empty($_POST["site-keywords"])) {
                        $nameErr = "site-keywords is required";
                        $check = false;
                    }
                    else{
                        $siteKeywords = $_POST["site-keywords"];
                        array_push($newConfig,$siteKeywords);
                    }

                    if (empty($_POST["site-description"])) {
                        $priceErr = "site-description is required";
                        $check = false;
                    }
                    else{
                        $siteDescription = $_POST["site-description"];
                        array_push($newConfig,$siteDescription);
                    }

                    if (empty($_POST["copyright-info"])) {
                        $urlErr = "copyright-info is required";
                        $check = false;
                    }
                    else{
                        $coptrightInfo = $_POST["copyright-info"];
                        array_push($newConfig,$coptrightInfo);
                    }

                    if (empty($_POST["phone-info"])) {
                        $urlErr = "phone-info is required";
                        $check = false;
                    }
                    else{
                        $phoneInfo = $_POST["phone-info"];
                        array_push($newConfig,$phoneInfo);
                    }

                    if (empty($_POST["site-name-en"])) {
                        $urlErr = "site-name-en is required";
                        $check = false;
                    }
                    else{
                        $siteNameEn = $_POST["site-name-en"];
                        array_push($newConfig,$siteNameEn);
                    }

                    if (empty($_POST["site-keywords-en"])) {
                        $urlErr = "site-keywords-en is required";
                        $check = false;
                    }
                    else{
                        $siteKeywordsEn = $_POST["site-keywords-en"];
                        array_push($newConfig,$siteKeywordsEn);
                    }

                    if (empty($_POST["site-description-en"])) {
                        $urlErr = "site-description-en is required";
                        $check = false;
                    }
                    else{
                        $siteDescriptionEn = $_POST["site-description-en"];
                        array_push($newConfig,$siteDescriptionEn);
                    }

                    if (empty($_POST["address"])) {
                        $urlErr = "address is required";
                        $check = false;
                    }
                    else{
                        $address = $_POST["address"];
                        array_push($newConfig,$address);
                    }

                    if (empty($_POST["email"])) {
                        $urlErr = "email is required";
                        $check = false;
                    }
                    else{
                        $email = $_POST["email"];
                        array_push($newConfig,$email);
                    }

                    $phoneInfo2 = $_POST["phone2"];
                    array_push($newConfig,$phoneInfo2);

                    if($check)
                    {

                        $boolean = true;
                        foreach($configName as $index => $config ) {

                            $sql ="UPDATE site_profile SET config='".$db->mysqli_real_escape_string($newConfig[$index])."' WHERE config_name LIKE '$config'";

                            if ($db->query($sql) === TRUE)
                            {
                            }
                            else
                            {
                                $boolean = false;
                                $dangerMessage = "Error: " . $sql . "<br>" . $db->error();
                                echoErrorMessage($dangerMessage."修改失败。");
                            }

                        }

                        if($boolean)
                        {
                            echoSuccessMessage(" 修改成功");
                        }

                    }
                    else{
                        //echoErrorMessage("请检查是否全部输入".$nameErr.$iconErr.$listErr.$priceErr.$urlErr);
                    }
                }
                else{
                    echoErrorMessage("请求错误..CrsID Missing");
                }
            }


            function echoSuccessMessage($message)
            {
                echo "              <div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                <h4><i class=\"icon fa fa-check\"></i> 成功！</h4>
                ".$message." .
              </div>";
            }

            function echoErrorMessage($message)
            {
                echo "              <div class=\"alert alert-danger alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                <h4><i class=\"icon fa fa-ban\"></i> 错误！</h4>
                ".$message." .
              </div>";
            }

            ?>


            <?php

            $sql = "SELECT * FROM site_profile";
            $result = $db->query($sql);

            if (!$result) {
                die($db->error());
            }

            if (mysqli_num_rows($result) > 0)
            {
                while ($row = mysqli_fetch_assoc($result))
                {
                    if(strcmp($row['config_name'],$configName[0]) == 0)
                    {
                        $siteName = $row['config'];
                    }
                    if(strcmp($row['config_name'],$configName[1]) == 0)
                    {
                        $siteKeywords = $row['config'];
                    }
                    if(strcmp($row['config_name'],$configName[2]) == 0)
                    {
                        $siteDescription = $row['config'];
                    }
                    if(strcmp($row['config_name'],$configName[3]) == 0)
                    {
                        $coptrightInfo = $row['config'];
                    }
                    if(strcmp($row['config_name'],$configName[4]) == 0)
                    {
                        $phoneInfo = $row['config'];
                    }
                    if(strcmp($row['config_name'],$configName[5]) == 0)
                    {
                        $siteNameEn = $row['config'];
                    }
                    if(strcmp($row['config_name'],$configName[6]) == 0)
                    {
                        $siteKeywordsEn = $row['config'];
                    }
                    if(strcmp($row['config_name'],$configName[7]) == 0)
                    {
                        $siteDescriptionEn = $row['config'];
                    }
                    if(strcmp($row['config_name'],$configName[8]) == 0)
                    {
                        $address = $row['config'];
                    }
                    if(strcmp($row['config_name'],$configName[9]) == 0)
                    {
                        $email = $row['config'];
                    }
                    if(strcmp($row['config_name'],$configName[10]) == 0)
                    {
                        $phoneInfo2 = $row['config'];
                    }
                }
            }

            echoBoxHeader();

            echoEditer($siteName,$siteKeywords,$siteDescription,$coptrightInfo,$phoneInfo,$siteNameEn,$siteKeywordsEn,$siteDescriptionEn,$address,$email,$phoneInfo2);

            echoBoxFooter();



            function echoEditer($siteName,$siteKeywords,$siteDescription,$coptrightInfo,$phoneInfo,$siteNameEn,$siteKeywordsEn,$siteDescriptionEn,$address,$email,$phoneInfo2)
            {
                echo "
                      <form class=\"form-horizontal\" method=\"post\" action=\"".htmlspecialchars($_SERVER["PHP_SELF"])."\">
                        <input class=\"form-control\" name=\"request-code\" type = \"hidden\" value=\"2\">
   
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">站点名称</label>
                            <div class=\"col-sm-10\">
                                <input class=\"form-control\" name=\"site-name\" type=\"text\" placeholder=\"请输入名称...\" value=\"".$siteName."\">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">站点名称(英文)</label>
                            <div class=\"col-sm-10\">
                                <input class=\"form-control\" name=\"site-name-en\" type=\"text\" placeholder=\"请输入名称...\" value=\"".$siteNameEn."\">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">站点关键词</label>
                            <div class=\"col-sm-10\">
                                <input class=\"form-control\" name=\"site-keywords\" type=\"text\" value=\"".$siteKeywords."\">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">站点关键词(英文)</label>
                            <div class=\"col-sm-10\">
                                <input class=\"form-control\" name=\"site-keywords-en\" type=\"text\" value=\"".$siteKeywordsEn."\">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">站点介绍</label>
                            <div class=\"col-sm-10\">
                                <input class=\"form-control\" name=\"site-description\" type=\"text\" value=\"".$siteDescription."\">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">站点介绍(英文)</label>
                            <div class=\"col-sm-10\">
                                <input class=\"form-control\" name=\"site-description-en\" type=\"text\" value=\"".$siteDescriptionEn."\">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">版权声明</label>
                            <div class=\"col-sm-10\">
                                <input class=\"form-control\" name=\"copyright-info\" type=\"text\" value=\"".$coptrightInfo."\">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">联系电话</label>
                            <div class=\"col-sm-10\">
                                <input class=\"form-control\" name=\"phone-info\" type=\"text\" value=\"".$phoneInfo."\" >
                            </div>
                        </div >
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">联系电话2</label>
                            <div class=\"col-sm-10\">
                                <input class=\"form-control\" name=\"phone2\" type=\"text\" value=\"".$phoneInfo2."\" >
                            </div>
                        </div >
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">公司地址</label>
                            <div class=\"col-sm-10\">
                                <input class=\"form-control\" name=\"address\" type=\"text\" value=\"".$address."\" >
                            </div>
                        </div >
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">公司邮箱</label>
                            <div class=\"col-sm-10\">
                                <input class=\"form-control\" name=\"email\" type=\"text\" value=\"".$email."\" >
                            </div>
                        </div >
                        <div class=\"form-group\">
                            <div class=\"col-sm-offset-11 col-sm-1\">
                                <button type=\"submit\" class=\"btn btn-default\">提交修改</button>
                            </div>
                        </div>
                    </form>";
            }


            function echoBoxHeader()
            {
                echo"
                <!-- Default box -->
            <div class=\"box\">
                <div class=\"box-header with-border\">
                    <h3 class=\"box-title\">站点信息</h3>

                    <div class=\"box-tools pull-right\">
                        <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\" data-toggle=\"tooltip\"
                                title=\"Collapse\">
                            <i class=\"fa fa-minus\"></i></button>
                        <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"remove\" data-toggle=\"tooltip\" title=\"Remove\">
                            <i class=\"fa fa-times\"></i></button>
                    </div>
                </div>
                <div class=\"box-body\">";
            }

            function echoBoxFooter()
            {
                echo "
                                </div>
                <!-- /.box-body -->
                <div class=\"box-footer\">

                </div>
                <!-- /.box-footer-->


            </div>
            <!-- /.box -->
                ";
            }
            ?>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php getFooter() ?>

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3.1.1 -->
<script src="../plugins/jQuery/jquery-3.1.1.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>


<script>
    $(document).ready(function () {
        $('.sidebar-menu').tree()
    })
</script>

</body>
</html>
