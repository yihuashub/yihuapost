<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 10/31/2017
 * Time: 3:44 PM
 */

require_once ("../admin_files/webUI.php");
require_once("../admin_files/classes/HouseAddSystem.php");

define("pageName","添加房源");

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

<!-- CSS to style the Jquery-Confirm -->
<link rel=\"stylesheet\" href=\"../plugins/jquery-confirm/dist/jquery-confirm.min.css\">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload-noscript.css\"></noscript>
<noscript><link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload-ui-noscript.css\"></noscript>
    <style>

        #map {
            width: 100%; height: 400px; margin-top: 40px; margin-bottom: 40px;
        }

    </style>
    ")?>


</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">


    <?php echoheader() ?>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <?php echoNavBarHtml(4) ?>

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

            function getUniqueID($postID,$mysqldate)
            {
                return $mysqldate.$postID.rand(10,100);
            }

            $ifTypeCorrect=true;


            // define variables and set to empty values
            $options = array(
                "houseID"=>"",
                "title"=>"",
                "titleEn"=>"",
                "price"=>"",
                "houseYear"=>"",
                "houseType"=>"",
                "houseSqft"=>"",
                "houseBedroom"=>"",
                "houseBathroom"=>"",
                "houseBasement"=>"",
                "address"=>"",
                "addNumber"=>"",
                "addSuffix"=>"",
                "city"=>"",
                "province"=>"",
                "country"=>"",
                "postCode"=>"",
                "latitude"=>"",
                "longitude"=>"",
                "parking"=>"",
                "include"=>"",
                "development"=>"",
                "descriptionEn"=>"",
                "descriptionCn"=>"",
                "mainPic"=>"",
                "date"=>"",
                "isApt"=>0,
                "aptNumber"=>0,
                "sellType"=>0,
                "houseStatus"=>0,

            );

            $check = true;
            $dangerMessage = "";
            $errorMsg =array();
            $stepStatus = 1;

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if (!empty($_POST["post-type"])) {

                    if($_POST["post-type"]==1)
                    {
                        if (empty($_POST["price"])) {
                            array_push($errorMsg,"请输入价格");
                            $check = false;
                        }
                        else{
                            $options["price"] = $_POST["price"];
                        }

                        if (empty($_POST["sqft"])) {
                            array_push($errorMsg,"请输入面积信息");
                            $check = false;
                        }
                        else{
                            $options["houseSqft"] = $_POST["sqft"];
                        }

                        if (empty($_POST["add-number"]) || empty($_POST["add-name"]) || empty($_POST["add-suffix"]) ) {
                            array_push($errorMsg,"请输入完整地址信息");
                            $check = false;
                        }
                        else{
                            $options["addNumber"] = $_POST["add-number"];
                            $options["addName"] = $_POST["add-name"];
                            $options["addSuffix"] = $_POST["add-suffix"];
                        }

                        if (empty($_POST["latitude"]) || empty($_POST["longitude"])) {
                            array_push($errorMsg,"请获取经纬度信息");
                            $check = false;
                        }
                        else{
                            $options["latitude"] = $_POST["latitude"];
                            $options["longitude"] = $_POST["longitude"];
                        }

                        if (!empty($_POST["apt"])) {
                            $options["aptNumber"] = $_POST["apt"];
                            $options["isApt"] = 1;
                        }

                        if (empty($_POST["description-cn"])) {
                            array_push($errorMsg,"请输入中文介绍");
                            $check = false;
                        }
                        else{
                            $options["descriptionCn"] = $_POST["description-cn"];
                        }

                        if (empty($_POST["description-en"])) {
                            array_push($errorMsg,"请输入英文介绍");
                            $check = false;
                        }
                        else{
                            $options["descriptionEn"] = $_POST["description-en"];
                        }

                        $options["title"] = $_POST["title"];
                        $options["titleEn"] = $_POST["title-en"];
                        $options["sellType"] = $_POST["sell-type"];
                        $options["city"]= $_POST["city"];
                        $options["country"]= $_POST["country"];
                        $options["houseYear"] = $_POST["year"];
                        $options["province"] = $_POST["province"];
                        $options["postCode"] = $_POST["post-code"];
                        $options["houseType"] =  $_POST["house-type"];
                        $options["houseBathroom"] = $_POST["bathroom"];
                        $options["houseBedroom"] = $_POST["bedroom"];
                        $options["parking"] = $_POST["parking"];
                        $options["houseBasement"]= $_POST["basement"];
                        $options["include"] = $_POST["include"];
                        //TODO for index of development in late version
                        //$options["development"] = $_POST["development"];

                        $date = date("Y-m-d");

                        if($check)
                        {
                            $descriptionCn = $db->mysqli_real_escape_string($descriptionCn);
                            $descriptionEn = $db->mysqli_real_escape_string($descriptionEn);

                            $sql = sprintf("INSERT INTO web_house (`ID`, `house_ID`, `type`, 
`is_apt`, `title`, `title_en`, `price`, `apt_number`, `add_number`, `add_name`, `add_suffix`, `city`, `province`, 
`country`, `post_code`, `lat`, `long`, `basement`, `parking`, `include`, `house_type`, `house_bedroom`, 
`house_bathroom`, `house_sqft`, `house_year`, `description_cn`, `description_en`, `main_pic`, `status`, `date`) 
VALUES (NULL, '0', '%s', '%u', '$title', '$titleEn', '$price', '$aptNumber', '$addNumber', '$addName', 
'$addSuffix', '$city', '$province', '$country', '$postCode', '$latitude', 
'$longitude', '$houseBasement', '$parking', '$include', '$houseType', '$houseBedroom', '$houseBathroom', '$houseSqft', 
'$houseYear', '$descriptionCn', '$descriptionEn', '0', '0', '$date')",$options["sellType"],$options["isApt"]);


                            if ($db->query($sql) === TRUE)
                            {
                                $last_id = $db->insert_id();
                                $houseID = $last_id;
                                echoInfoMessage("系统编号：".$houseID." 已成功存为草稿，请继续完成第二步。");
                                $stepStatus = 2;
                            }
                            else
                            {
                                $dangerMessage = "Error: " . $sql . "<br>" . $db->error();
                                echoErrorMessage($dangerMessage);
                            }
                        }
                        else{
                            $arrlength=count($errorMsg);

                            for($x=0;$x<$arrlength;$x++)
                            {
                                if(1!=$errorMsg[$x])
                                {
                                    $dangerMessage .= $errorMsg[$x].'</br>';
                                }
                            }
                            echoErrorMessage("请检查以下信息是否全部输入<br>".$dangerMessage);
                        }
                    }
                    else if($_POST["post-type"]==3)
                    {
                        $stepStatus = 3;

                        if (empty($_POST["house-id"])) {
                            array_push($errorMsg,"house-id is required");
                            $check = false;
                        }
                        else{
                            $houseID = $_POST["house-id"];
                        }

                        if (empty($_POST["main-pic"])) {
                            array_push($errorMsg,"main-pic is required");
                            $check = false;
                        }
                        else{
                            $mainPic = $_POST["main-pic"];
                        }

                        $houseStatus = $_POST["status"];

                        $sql = "SELECT * FROM web_house WHERE ID = $houseID";
                        $result = $db->query($sql);

                        $uniqueID = 0;
                        if ($result && mysqli_num_rows($result) > 0) {
                            while($rows = mysqli_fetch_assoc($result)) {
                                $mysqlDate = date( 'Ym', strtotime( $rows["date"]) );
                                $uniqueID = getUniqueID($houseID,$mysqlDate);
                            }
                        }

                        if($check)
                        {

                            $sql ="UPDATE web_house SET `main_pic`= $mainPic, `status`= $houseStatus,  `house_ID`='".$uniqueID."'  WHERE ID = $houseID";
                            if ($db->query($sql) === TRUE)
                            {
                                echoSuccessMessage("系统编号：".$houseID." 平方米ID：".$uniqueID." 创建成功。");
                            }
                            else
                            {
                                $dangerMessage = "Error: " . $sql . "<br>" . $db->error();
                                echoErrorMessage($dangerMessage);

                            }
                        }
                        else{
                            $arrlength=count($errorMsg);

                            for($x=0;$x<$arrlength;$x++)
                            {
                                if(1!=$errorMsg[$x])
                                {
                                    $dangerMessage .= $errorMsg[$x].'</br>';
                                }
                            }
                            echoErrorMessage("请检查以下信息是否全部输入<br>".$dangerMessage);
                        }

                    }

                }
            }


            function echoSuccessMessage($message)
            {
                echo "              <div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                <h4><i class=\"icon fa fa-check\"></i> 成功！</h4>
                ".$message."
              </div>";
            }

            function echoInfoMessage($message)
            {
                echo "              <div class=\"alert alert-info alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                <h4><i class=\"icon fa fa-check\"></i> 消息</h4>
                ".$message."
              </div>";
            }

            function echoErrorMessage($message)
            {
                echo "              <div class=\"alert alert-danger alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                <h4><i class=\"icon fa fa-ban\"></i> 错误！</h4>
                ".$message."
              </div>";
            }

            ?>



            <?php



            //check status
            if($stepStatus == 1)
            {
                stepOne();
            }
            else if($stepStatus == 2)
            {
                stepTwo($houseID);
            }





            function stepTwo($houseID)
            {
                $server = htmlspecialchars($_SERVER["PHP_SELF"]);

                echo "
                <!-- Default box -->
            <div class=\"box\">
                <div class=\"box-header with-border\">
                    <h3 class=\"box-title\">第二步 · 上传照片</h3>

                    <div class=\"box-tools pull-right\">
                        <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\" data-toggle=\"tooltip\"
                                title=\"Collapse\">
                            <i class=\"fa fa-minus\"></i></button>
                        <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"remove\" data-toggle=\"tooltip\" title=\"Remove\">
                            <i class=\"fa fa-times\"></i></button>
                    </div>
                </div>
                <div class=\"box-body\">";

                echo "
                    <div class=\"form-horizontal\">
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">房屋照片</label>
                            <div class=\"col-sm-10\">
                                <!-- The file upload form used as target for the file upload widget -->
                                <form id=\"fileupload\" action=\"../../upload\" method=\"POST\" enctype=\"multipart/form-data\">
                                    <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                    <noscript><input type=\"hidden\" name=\"redirect\" value=\"https://blueimp.github.io/jQuery-File-Upload/\"></noscript>
                                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                    <div class=\"row fileupload-buttonbar\">
                                        <div class=\"col-lg-7\">
                                            <!-- The fileinput-button span is used to style the file input field as button -->
                                            <span class=\"btn btn-success fileinput-button\">
                                                <i class=\"glyphicon glyphicon-plus\"></i>
                                                <span>选择一个文件</span>
                                                <input type=\"file\" name=\"files[]\" multiple>
                                            </span>
                                            <button type=\"submit\" class=\"btn btn-primary start\">
                                                <i class=\"glyphicon glyphicon-upload\"></i>
                                                <span>开始上传</span>
                                            </button>
                                            <button type=\"reset\" class=\"btn btn-warning cancel\">
                                                <i class=\"glyphicon glyphicon-ban-circle\"></i>
                                                <span>取消上传</span>
                                            </button>
                                            <button type=\"button\" class=\"btn btn-danger delete\">
                                                <i class=\"glyphicon glyphicon-trash\"></i>
                                                <span>删除</span>
                                            </button>
                                            <input type=\"checkbox\" class=\"toggle\">
                                            <!-- The global file processing state -->
                                            <span class=\"fileupload-process\"></span>
                                        </div>
                                        <!-- The global progress state -->
                                        <div class=\"col-lg-5 fileupload-progress fade\">
                                            <!-- The global progress bar -->
                                            <div class=\"progress progress-striped active\" role=\"progressbar\" aria-valuemin=\"0\" aria-valuemax=\"100\">
                                                <div class=\"progress-bar progress-bar-success\" style=\"width:0%;\"></div>
                                            </div>
                                            <!-- The extended global progress state -->
                                            <div class=\"progress-extended\">&nbsp;</div>
                                        </div>
                                    </div>
                                    <!-- The table listing the files available for upload/download -->
                                    <table role=\"presentation\" class=\"table table-striped\">
                                        <tbody class=\"files\">
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                            <form method=\"post\" action=\"$server\">
                            <div class=\"form-group\">
                                <label class=\"col-sm-2 control-label\">封面照片ID</label>
                                <div class=\"col-sm-10\">
                                    <input class=\"form-control\" id=\"main-pic\" type=\"number\">
                                </div>
                            </div>
                            <div class=\"form-group\">
                                <label class=\"col-sm-2 control-label\">是否发布</label>
                                <div class=\"col-sm-10\">
                                    <label class=\"radio-inline\"><input class=\"minimal\" type=\"radio\" name=\"status\" value=\"1\" checked >立即发布</label>
                                    <label class=\"radio-inline\"><input class=\"minimal\" type=\"radio\" name=\"status\" value=\"0\">存为草稿稍后发布</label>
                                </div>
                            </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class=\"box-footer\">
                    <div class=\"form-group\">
                        <div class=\"col-sm-offset-11 col-sm-1\">
                            <input class=\"form-control\" name=\"main-pic\" id=\"main-image\" type=\"hidden\">
                            <input type=\"hidden\" name=\"post-type\" value=\"3\">
                            <input type=\"hidden\" name=\"house-id\" value=\"".$houseID."\">
                            <button type=\"submit\" class=\"btn btn-default\">完成发布</button>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->";


            }


            function stepOne()
            {
                $db = new Database();
                $addHouse = new HouseAddSystem();

                $server = htmlspecialchars($_SERVER["PHP_SELF"]);

                echo "
                <!-- Default box -->
            <div class=\"box\">
                <div class=\"box-header with-border\">
                    <h3 class=\"box-title\">第一步 · 输入基本信息</h3>

                    <div class=\"box-tools pull-right\">
                        <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"collapse\" data-toggle=\"tooltip\"
                                title=\"Collapse\">
                            <i class=\"fa fa-minus\"></i></button>
                        <button type=\"button\" class=\"btn btn-box-tool\" data-widget=\"remove\" data-toggle=\"tooltip\" title=\"Remove\">
                            <i class=\"fa fa-times\"></i></button>
                    </div>
                </div>
                <div class=\"box-body\">
                <div id =\"get-post-code-status\" ></div>";


                echo "
                <form class=\"form-horizontal\" method=\"post\" action=\"$server\">
                        <input type=\"hidden\" name=\"post-type\" value=\"1\">

                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">状态</label>
                            <div class=\"col-sm-10\">
                                <select class=\"form-control\" name=\"sell-type\">
                                    <option value=\"1\" >出售(For Sell)</option>
                                    <option value=\"2\" >促销(Promotion)</option>
                                    <option value=\"3\" >已售(Sold)</option>
                                </select>
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">副标题</label>
                            <div class=\"col-sm-10\">
                                <input class=\"form-control\" name=\"title\" type=\"text\">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">副标题(英文)</label>
                            <div class=\"col-sm-10\">
                                <input class=\"form-control\" name=\"title-en\" type=\"text\">
                            </div>
                        </div>
                         <div class=\"form-group\">
                            <label for=\"apt-name\" class=\"col-sm-2 control-label\">地址信息</label>

                            <div class=\"col-sm-10\">
                                <div class=\"form-inline\"> 
                                    <label for=\"apt-name\">公寓单元：</label>                               
                                    <input type=\"text\" id=\"apt-name\" class=\"form-control\" name=\"apt\" placeholder=\"Apt\" />
                                </div>
                            </div>
                         </div>

                        <div class=\"form-group\">
                            <label for=\"apt-name\" class=\"col-sm-2 control-label\"></label>
                            <div class=\"col-sm-10\">
                                <div class=\"form-inline\">
                                    <label for=\"city-list\">详细地址：</label>
                                    <input type=\"text\" class=\"form-control\" id=\"address-number\" name=\"add-number\" placeholder=\"Add. number\" />
                                    <input type=\"text\" class=\"form-control\" id=\"address-name\" name=\"add-name\" placeholder=\"Add. name\" />
                                    <input type=\"text\" class=\"form-control\" id=\"address-suffix\" name=\"add-suffix\" placeholder=\"Add. suffix\" data-provide=\"typeahead\" data-items=\"4\" />
                                </div>
                            </div>
                        </div>
                        
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\"></label>
                            <div class=\"col-sm-10\">
                                <div class=\"form-inline\">
                                    <label for=\"city-list\">城市：</label>
                                    <input value=\"Winnipeg\" type=\"text\" class=\"form-control\"  name=\"city\" placeholder=\"City\" id=\"city-list\" data-provide=\"typeahead\" data-items=\"4\" />
                                    <label for=\"province-list\">省/州：</label>
                                    <input value=\"Manitoba\"type=\"text\" class=\"form-control\" name=\"province\" placeholder=\"Province / State\" id=\"province-list\" data-provide=\"typeahead\" data-items=\"4\" />
                                </div>
                            </div>
                        </div>
                        
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\"></label>
                            <div class=\"col-sm-10\">
                                <div class=\"form-inline\">
                                    <label for=\"city-list\">国家：</label>
                                    <input value=\"Canada\" type=\"text\" class=\"form-control\" name=\"country\" placeholder=\"Country\" id=\"country-list\" data-provide=\"typeahead\" data-items=\"4\" />
                                    <label for=\"province-list\">邮编：</label>
                                    <input type=\"text\" id=\"post-code\" class=\"form-control\" name=\"post-code\" placeholder=\"Post Code\" />
                                </div>
                            </div>
                        </div>

                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\"></label>
                            <div class=\"col-sm-10\">
                                <div class=\"form-inline\">
                                    <label for=\"city-list\">经度：</label>
                                    <input type=\"text\" id=\"latitude\" class=\"form-control\"  name=\"latitude\" placeholder=\"Latitude\" >
                                    <label for=\"province-list\">纬度：</label>
                                    <input type=\"text\" id=\"longitude\" class=\"form-control\"  name=\"longitude\" placeholder=\"Longitude\">
                                </div>
                            </div>
                        </div>

                        <div class=\"form-group \">
                            <div class=\"col-sm-12\">
                                <div class=\"form-inline pull-right\">
                                    <button type=\"button\" id=\"get-post-code\" class=\"btn btn-primary\">检查与自动补全地址</button>
                                    <button type=\"button\" id=\"get-map\" class=\"btn btn-info\" title=\"在Google地图中检查地址\">在Google地图中检查地址</button>
                                </div>
                            </div>

                        </div>

                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\"></label>
                            <div class=\"col-sm-10\">
                                <div class=\"form-inline\">
                                    <div class=\"well\" id=\"map\"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">价格</label>
                            <div class=\"col-sm-10\">
                                <input class=\"form-control\" name=\"price\" type=\"number\">
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">面积(sqft)</label>
                            <div class=\"col-sm-10\">
                                <input class=\"form-control\" name=\"sqft\" type=\"number\">
                            </div>
                        </div>";

                echo "       <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">年份</label>
                            <div class=\"col-sm-10\">
                               <select class=\"form-control\" name=\"year\">";


                $already_selected_value = date('Y');
                $earliest_year = 1950;
                foreach (range(date('Y'), $earliest_year) as $x) {
                    print '<option value="'.$x.'"'.(($x === $already_selected_value) ? ' selected="selected"' : '').'>'.$x.'</option>';
                }
                echo"</select>
                            </div>
                        </div>";
                echo "
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">房屋类型</label>
                            <div class=\"col-sm-10\">
                                <select class=\"form-control\" name=\"house-type\">
                                ";
                $mArray= $addHouse->getHouseTypeArray();

                foreach ($mArray as $row) {
                    echo "<option value=\"".$row['value']."\" >".$row['name_cn']."</option>";
                }
                echo"</select>
                            </div>
                        </div>";
                echo "
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">卫生间</label>
                            <div class=\"col-sm-10\">
                                <select class=\"form-control\" name=\"bathroom\">
                                ";
                $mArray = $addHouse->getBathroomArray();

                foreach ($mArray as $row) {
                    echo "<option value=\"".$row['value']."\" >".$row['name_cn']."</option>";
                }
                echo"</select>
                            </div>
                        </div>";
                echo "<div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">卧室</label>
                            <div class=\"col-sm-10\">
                                <select class=\"form-control\" name=\"bedroom\" >";
                $mArray = $addHouse->getBedroomArray();

                foreach ($mArray as $row) {
                    echo "<option value=\"".$row['value']."\" >".$row['name_cn']."</option>";
                }
                echo" </select>
                            </div>
                        </div>";
                echo "<div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">停车位</label>
                            <div class=\"col-sm-10\">
                                <select class=\"form-control\" name=\"parking\" >";
                $mArray = $addHouse->getParkingArray();

                foreach ($mArray as $row) {
                    echo "<option value=\"".$row['value']."\" >".$row['name_cn']."</option>";
                }
                echo" </select>
                            </div>
                        </div>";
                echo "<div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">地下室</label>
                            <div class=\"col-sm-10\">
                                <select class=\"form-control\" name=\"basement\" >";
                $mArray = $addHouse->getBasementArray();

                foreach ($mArray as $row) {
                    echo "<option value=\"".$row['value']."\" >".$row['name_cn']."</option>";
                }
                echo" </select>
                            </div>
                        </div>";
                echo "<div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">升级</label>
                            <div class=\"col-sm-10\">
                                <select class=\"form-control\" name=\"include\" >";
                $mArray = $addHouse->getIncludeArray();

                foreach ($mArray as $row) {
                    echo "<option value=\"".$row['value']."\" >".$row['name_cn']."</option>";
                }
                echo" </select>
                            </div>
                        </div>";
                echo "<div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">完成度</label>
                            <div class=\"col-sm-10\">
                                <select class=\"form-control\" name=\"development\" >";
                $mArray = $addHouse->getDevelopmentArray();

                foreach ($mArray as $row) {
                    echo "<option value=\"".$row['value']."\" >".$row['name_cn']."</option>";
                }
                echo" </select>
                            </div>
                        </div>";
                echo  "
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">中文介绍</label>
                            <div class=\"col-sm-10\">
                                <textarea class=\"form-control\" id=\"note\" name=\"description-cn\" rows=\"3\"></textarea>
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <label class=\"col-sm-2 control-label\">英文介绍</label>
                            <div class=\"col-sm-10\">
                                <textarea class=\"form-control\" id=\"note\" name=\"description-en\" rows=\"3\"></textarea>
                            </div>
                        </div>
                <!-- /.box-body -->
                <div class=\"box-footer\">
                    <div class=\"form-group\">
                        <div class=\"col-sm-offset-11 col-sm-1\">
                            <button type=\"submit\" class=\"btn btn-default\">下一步</button>
                        </div>
                    </div>
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

<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>f
    <ol class="indicator"></ol>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <label class="介绍">
                <span>Description:</span><br>
            <input name="description[]" class="form-control">

            </label>
            <input name="pid[]" class="form-control" type="hidden" value="<?php echo $houseID; ?>">

        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>上传</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>取消</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <p>简介:{%=file.description||''%}</p>
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <a id="myLink" type="button" class="btn btn-primary" href="#" onclick="myFunction('{%=file.id%}','{%=file.url%}');return false;">
                    <i class="glyphicon glyphicon-eye-open"></i>
                    <span>设为封面图片</span></a>

                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>删除</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>取消</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>

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

<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="../plugins/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="../plugins/jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="../plugins/jQuery-File-Upload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="../plugins/jQuery-File-Upload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="../plugins/jQuery-File-Upload/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="../plugins/jQuery-File-Upload/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="../plugins/jQuery-File-Upload/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="../plugins/jQuery-File-Upload/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="../plugins/jQuery-File-Upload/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<!-- JavaScript to the Jquery-Confirm -->
<script src="../plugins/jquery-confirm/dist/jquery-confirm.min.js"></script>


<!-- yihua Main JavaScript -->
<script src="../yihua/js/yihuaMain.js" ></script>

<!-- yihua Main JavaScript -->
<script src="../yihua/js/varabile.js" ></script>

<!-- typeahead JavaScript -->
<script src="../yihua/js/bootstrap3-typeahead.min.js" ></script>

<script>
    var addressSuffix = ['ABBEY', 'ACRES', 'ALLÉE', 'ALLEY', 'AUT', 'AVE', 'AV', 'BAY', 'BEACH', 'BEND', 'BLVD', 'BOUL', 'BYPASS', 'BYWAY', 'CAMPUS',
        'CAPE', 'CAR', 'CARREF', 'CTR', 'C', 'CERCLE', 'CHASE', 'CH', 'CIR', 'CIRCT', 'CLOSE', 'COMMON', 'CONC', 'CRNRS', 'CÔTE', 'COUR', 'COURS', 'CRT',
        'COVE', 'CRES', 'CROIS', 'CROSS', 'CDS', 'DALE', 'DELL', 'DIVERS', 'DOWNS', 'DR', 'ÉCH', 'END', 'ESPL', 'ESTATE', 'EXPY', 'EXTEN', 'FARM', 'FIELD',
        'FOREST', 'FWY', 'FRONT', 'GDNS', 'GATE', 'GLADE', 'GLEN', 'GREEN', 'GRNDS', 'GROVE', 'HARBR', 'HEATH', 'HTS', 'HGHLDS', 'HWY', 'HILL', 'HOLLOW', 'ÎLE', 'IMP',
        'INLET', 'ISLAND' ,'KEY', 'KNOLL' ,'KNOLL', 'LANE' ,'LMTS', 'LINE' ,'LINE', 'LINE' ,'LOOP', 'MALL' ,'MANOR', 'MAZE' ,'MEADOW', 'MEWS' ,'MONTÉE', 'MOOR' ,'MOUNT', 'MTN',
        'ORCH', 'PARADE' ,'PARC', 'PK' ,'PKY', 'PASS' ,'PATH', 'PTWAY' ,'PINES', 'PL' ,'PLACE', 'PLAT' ,'PLAZA', 'PT' ,'POINTE', 'PORT' ,'PVT', 'PROM' ,'QUAI', 'QUAY' ,'RAMP',
        'RANG' ,'RG', 'RIDGE' ,'RISE', 'RD', 'RDPT', 'RTE', 'ROW', 'RUE', 'RLE', 'RUN', 'SENT', 'SQ', 'ST', 'SUBDIV', 'TERR', 'TSSE', 'THICK', 'TOWERS',
        'TLINE', 'TRAIL', 'TRNABT', 'VALE', 'VIA', 'VIEW', 'VILLGE', 'VILLAS', 'VISTA', 'VOIE', 'WALK', 'WAY', 'WHARF', 'WOOD', 'WYND'];
    $('#address-suffix').typeahead({source: addressSuffix})

    var cityList = ["Toronto", "Montreal", "Vancouver", "Calgary", "Edmonton", "Ottawa","Gatineau", "Winnipeg", "Hamilton", "Kitchener",
        "London", "Victoria", "St. Catharines–Niagara", "Halifax", "Oshawa", "Windsor", "Saskatoon", "Regina", "Barrie","St. John's",
        "Newfoundland and Labrador", "Abbotsford", "Kelowna", "Sherbrooke", "Trois-Rivières", "Guelph", "Kingston", "Moncton", "Sudbury",
        "Chicoutimi-Jonquière", "Thunder Bay", "Kanata", "Saint John", "Brantford", "Red Deer", "Nanaimo", "Lethbridge", "Saint-Jean-sur-Richelieu",
        "White Rock", "Peterborough", "Sarnia", "Milton", "Kamloops", "Châteauguay", "Sault Ste. Marie", "Chilliwack", "Drummondville",
        "Saint-Jérôme", "Medicine Hat", "Prince George", "Belleville", "Fredericton","Fort McMurray","Granby","Grande Prairie", "North Bay",
        "Beloeil", "Cornwall", "Saint-Hyacinthe", "Shawinigan", "Brandon", "Vernon", "Chatham", "Bowmanville-Newcastle", "Joliette", "Charlottetown",
        "Prince Edward Island", "Airdrie", "Victoriaville", "St. Thomas", "Courtenay", "Georgetown", "Salaberry-de-Valleyfield",
        "Rimouski", "Woodstock", "Sorel-Tracy", "Penticton", "Prince Albert", "Campbell River", "Moose Jaw", "Cape Breton-Sydney",
        "Midland", "Leamington", "Stratford", "Orangeville", "Timmins", "Orillia", "Walnut Grove", "Spruce Grove", "Lloydminster", "Alma", "Bolton",
        "Saint-Georges", "Keswick-Elmhurst Beach", "Stouffville", "Okotoks", "Duncan", "Parksville", "Leduc", "Val-d'Or", "Rouyn-Noranda", "Buckingham"

    ];
    $('#city-list').typeahead({source: cityList})


    var  provinceList= ['Ontario', 'Quebec', 'British Columbia', 'Alberta', 'Manitoba', 'Saskatchewan', 'Nova Scotia','New Brunswick','Newfoundland and Labrador','Prince Edward Island','Northwest Territories',
        'Nunavut', 'Yukon'];
    $('#province-list').typeahead({source: provinceList})


    document.getElementById('get-post-code').addEventListener('click', function() {
        getPostCode();
    });


    function getPostCode() {
        var addNumber = document.getElementById('address-number').value;
        var addName = document.getElementById('address-name').value;
        var addSuffix = document.getElementById('address-suffix').value;
        var googleMapApi = 'https://maps.googleapis.com/maps/api/geocode/json?address='+addNumber+'+'+addName+'+'+addSuffix+'&key=AIzaSyDsysFwG-PM0RRhTpnyWKVr8iVdr1zNcks&language=en&region=CA';

        $.getJSON(googleMapApi, function(data)
        {
            console.log(data);
            if (data.status === 'OK')
            {

                var postCodeCheck, countryCodeCheck,ProvCodeCheck,cityCodeCheck=false;
                for (var i = 0; i < data.results[0].address_components.length; i++) {
                    for (var j = 0; j < data.results[0].address_components[i].types.length; j++) {
                        if (data.results[0].address_components[i].types[j] == "postal_code") {
                            document.getElementById("post-code").value = data.results[0].address_components[i].long_name;
                            postCodeCheck = true;
                        }
                        if (data.results[0].address_components[i].types[j] == "country") {
                            document.getElementById("country-list").value = data.results[0].address_components[i].long_name;
                            countryCodeCheck = true;
                        }
                        if (data.results[0].address_components[i].types[j] == "administrative_area_level_1") {
                            document.getElementById("province-list").value = data.results[0].address_components[i].long_name;
                            ProvCodeCheck = true;
                        }
                        if (data.results[0].address_components[i].types[j] == "locality") {
                            document.getElementById("city-list").value = data.results[0].address_components[i].long_name;
                            cityCodeCheck = true;
                        }
                    }
                }

                if(data.results[0].geometry.location.lat != null)
                {
                    document.getElementById("latitude").value = data.results[0].geometry.location.lat;
                }

                if(data.results[0].geometry.location.lng != null)
                {
                    document.getElementById("longitude").value = data.results[0].geometry.location.lng;
                }

                if(postCodeCheck && countryCodeCheck && ProvCodeCheck &&cityCodeCheck )
                {
                    $.confirm({
                        closeIcon: true,
                        theme: 'Modern',
                        title: '消息',
                        content: '已成功获取数据，请再次核实准确性。',
                        type: 'green',
                        typeAnimated: true,
                        buttons: {
                            tryAgain: {
                                text: '好的',
                                btnClass: 'btn-green',
                                action: function(){
                                }
                            }
                        }
                    });

                }
                else
                {
                    $.confirm({
                        closeIcon: true,
                        theme: 'Modern',
                        title: '抱歉',
                        content: '信息获取失败，请检查填写是否有误。',
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                            tryAgain: {
                                text: '好的',
                                btnClass: 'btn-red',
                                action: function(){
                                }
                            }
                        }
                    });
                }


            }
            else
            {
                $.confirm({
                    closeIcon: true,
                    theme: 'Modern',
                    title: '抱歉',
                    content: '错误：'+data.status,
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: '好的',
                            btnClass: 'btn-red',
                            action: function(){
                            }
                        }
                    }
                });
            }

        });

    }

</script>

<!-- Google Api -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsysFwG-PM0RRhTpnyWKVr8iVdr1zNcks&callback=initMap&language=ZH-ch&region=CN"
        async defer></script>

<script>

    /*
     * jQuery File Upload Plugin JS Example
     * https://github.com/blueimp/jQuery-File-Upload
     *
     * Copyright 2010, Sebastian Tschan
     * https://blueimp.net
     *
     * Licensed under the MIT license:
     * https://opensource.org/licenses/MIT
     */

    /* global $, window */


    $(function () {
        'use strict';

        // Initialize the jQuery File Upload widget:
        $('#fileupload').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: '../../upload/',
            autoUpload: false,
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent)
        }).on('fileuploadsubmit', function (e, data) {
            data.formData = data.context.find(':input').serializeArray();
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
            });
        });

    });

</script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="../plugins/jQuery-File-Upload/js/cors/jquery.xdr-transport.js"></script>
<![endif]-->

<script>
    $(document).ready(function () {
        $('.sidebar-menu').tree()
    })

    function myFunction(intValue,imgUrl) {


        $.confirm({
            title: '确认使用这张照片作为封面吗？',
            content: '<br><img src="'+imgUrl+'">',
            animation: 'zoom',
            animationClose: 'top',
            buttons: {
                confirm: {
                    text: '确认',
                    btnClass: 'btn-blue',
                    action: function () {
                        $.alert('设置成功!');

                        $('#main-pic').val(intValue);
                        $('#main-image').val(intValue);
                    }
                },
                取消: function () {
                    // lets the user close the modal.
                }
            },
        });

    }
</script>


</body>
</html>
