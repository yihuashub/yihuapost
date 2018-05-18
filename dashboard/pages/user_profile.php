<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 11/5/2017
 * Time: 2:14 PM
 */
define("pageName", "个人资料设置");

require_once("../admin_files/webUI.php");
require_once("../admin_files/classes/User.php");
require_once("../admin_files/user_function.php");

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
    <!-- DataTables -->
    <link rel=\"stylesheet\" href=\"../plugins/datatables/dataTables.bootstrap.css\">
    <!-- DataTables Responsive CSS -->
    <link href=\"../plugins/datatables/extensions/Responsive/css/dataTables.responsive.css\" rel=\"stylesheet\">
    <!-- blueimp Gallery styles -->
    <link rel=\"stylesheet\" href=\"//blueimp.github.io/Gallery/css/blueimp-gallery.min.css\">
    <!-- CSS to style the Jquery-Confirm -->
    <link rel=\"stylesheet\" href=\"../plugins/jquery-confirm/dist/jquery-confirm.min.css\">
    
    <!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload-noscript.css\"></noscript>
<noscript><link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload-ui-noscript.css\"></noscript>
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload.css\">
<link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload-ui.css\">
<style>
.ui-state-highlight
{
height: 42px;
}
</style>
    ") ?>

    <link href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/css/base/jquery.ui.all.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.2/css/lightness/jquery-ui-1.10.2.custom.min.css"
          rel="stylesheet">

</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">


    <?php echoheader() ?>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <?php echoNavBarHtml(0) ?>

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
            $url = $email = $phone = "";
            $houseSqft = $houseBedroom = $houseBathroom = $houseBasement = "";
            $address = $addNumber = $addName = $addSuffix = "";
            $city = $province = $country = $postCode = $latitude = $longitude = "";
            $parking = $include = $development = "";
            $descriptionEn = $descriptionCn = $mainPic = $uniqueID ="";
            $isApt = 0;
            $aptNumber = 0;
            $sellType = 0;
            $check = true;
            $dangerMessage = "";
            $errorMsg =array();
            $stepStatus = 1;
            $houseStatus = 0;
            $author = 1;

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if (!empty($_POST["post-type"])) {

                    if ($_POST["post-type"] == 1) {


                        $check = $user->updateSortUrl($_POST["short-url"]);
                        $check = $user->updatePhone($_POST["phone"]);
                        $check = $user->updateEmail($_POST["email"]);


                        if($check)
                        {
                            echoSuccessMessage("修改成功");
                        }
                    }else if ($_POST["post-type"] == 2) {


                        $check = $user->updateFirstNameCn($_POST["first-name-cn"]);
                        $check = $user->updateLastNameCn($_POST["last-name-cn"]);
                        $check = $user->updateDescriptionCn($_POST["description-cn"]);


                        if($check)
                        {
                            echoSuccessMessage("修改成功");
                        }
                    }else if ($_POST["post-type"] == 3) {


                        $check = $user->updateFirstNameEn($_POST["first-name-en"]);
                        $check = $user->updateLastNameEn($_POST["last-name-en"]);
                        $check = $user->updateDescriptionEn($_POST["description-en"]);


                        if($check)
                        {
                            echoSuccessMessage("修改成功");
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


            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="profile-user-img img-responsive img-circle"
                                 src="<?php echo $user->getProfileImageS() ?>" alt="User profile picture">

                            <h3 class="profile-username text-center"><?php echo $user->getNameCn() ?></h3>

                            <p class="text-muted text-center"><?php echo $user->getJoinTime() ?></p>

                            <!--ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>已发布房源</b> <a class="pull-right">1,322</a>
                                </li>
                                <li class="list-group-item">
                                    <b>未发布发布房源</b> <a class="pull-right">543</a>
                                </li>
                            </ul-->

                            <a href="http://www.dichanjingji.com/<?php echo $user->getShortUrl() ?>" class="btn btn-primary btn-block"><b>查看我的主页</b></a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- About Me Box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">关于我</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <strong><i class="fa fa-book margin-r-5"></i> 电话</strong>

                            <p class="text-muted">
                                <?php echo $user->getPhone() ?>
                            </p>

                            <hr>

                            <strong><i class="fa fa-map-marker margin-r-5"></i> 邮箱</strong>

                            <p class="text-muted">
                                <?php echo $user->getEmaill() ?>
                            </p>

                            <hr>

                            <strong><i class="fa fa-file-text-o margin-r-5"></i> 个性域名</strong>

                            <p>
                                dichanjingji.com/<?php echo $user->getShortUrl() ?>
                            </p>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#activity" data-toggle="tab">基本信息设置</a></li>
                            <li><a href="#settings-photo" data-toggle="tab">图片资料管理</a></li>
                            <li><a href="#settings-cn" data-toggle="tab">中文资料设置</a></li>
                            <li><a href="#settings" data-toggle="tab">英文资料设置</a></li>
                            <li><a href="#settings-password" data-toggle="tab">修改密码</a></li>

                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <form class="form-horizontal" method="post">
                                    <div class="form-group">
                                        <label for="url" class="col-sm-2 control-label">个性域名</label>
                                        <label for="url" class="col-sm-2 control-label">dichanjingji.com/</label>

                                        <div class="col-sm-8">
                                            <input type="text" name="short-url" class="form-control" id="inputName" placeholder="url"
                                                   value="<?php echo $user->getShortUrl() ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">Email</label>

                                        <div class="col-sm-10">
                                            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email"
                                                   value="<?php echo $user->getEmaill() ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="col-sm-2 control-label">电话</label>

                                        <div class="col-sm-10">
                                            <input type="number" name="phone" class="form-control" id="inputName" placeholder="phone"
                                                   value="<?php echo $user->getPhone() ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <input name="post-type" value="1" hidden>
                                            <button type="submit" class="btn btn-danger">保存修改</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="settings-photo">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-2 control-label">主照片 最佳(295 x 380)</label>

                                        <div class="col-sm-10">
                                            <form id="mainimage" action="../../upload" method="POST"
                                                  enctype="multipart/form-data">
                                                <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                                <noscript><input type="hidden" name="redirect"></noscript>
                                                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                                <div class="row fileupload-buttonbar">
                                                    <div class="col-lg-7">
                                                        <!-- The fileinput-button span is used to style the file input field as button -->
                                                        <span class="btn btn-success fileinput-button">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span>选择一个文件</span>
                                                <input type="file" name="files[]" multiple>
                                            </span>
                                                        <input type="checkbox" class="toggle">
                                                        <!-- The global file processing state -->
                                                        <span class="fileupload-process"></span>
                                                    </div>
                                                    <!-- The global progress state -->
                                                    <div class="col-lg-5 fileupload-progress fade">
                                                        <!-- The global progress bar -->
                                                        <div class="progress progress-striped active" role="progressbar"
                                                             aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar progress-bar-success"
                                                                 style="width:0%;"></div>
                                                        </div>
                                                        <!-- The extended global progress state -->
                                                        <div class="progress-extended">&nbsp;</div>
                                                    </div>
                                                </div>
                                                <!-- The table listing the files available for upload/download -->
                                                <table role="presentation" class="table table-striped">
                                                    <tbody class="files">
                                                    </tbody>
                                                </table>
                                            </form>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail" class="col-sm-2 control-label">站立图 最佳(472 x 834)</label>

                                        <div class="col-sm-10">
                                            <form id="standimage" action="../../upload" method="POST"
                                                  enctype="multipart/form-data">
                                                <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                                <noscript><input type="hidden" name="redirect"></noscript>
                                                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                                <div class="row fileupload-buttonbar">
                                                    <div class="col-lg-7">
                                                        <!-- The fileinput-button span is used to style the file input field as button -->
                                                        <span class="btn btn-success fileinput-button">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span>选择一个文件</span>
                                                <input type="file" name="files[]" multiple>
                                            </span>
                                                        <input type="checkbox" class="toggle">
                                                        <!-- The global file processing state -->
                                                        <span class="fileupload-process"></span>
                                                    </div>
                                                    <!-- The global progress state -->
                                                    <div class="col-lg-5 fileupload-progress fade">
                                                        <!-- The global progress bar -->
                                                        <div class="progress progress-striped active" role="progressbar"
                                                             aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar progress-bar-success"
                                                                 style="width:0%;"></div>
                                                        </div>
                                                        <!-- The extended global progress state -->
                                                        <div class="progress-extended">&nbsp;</div>
                                                    </div>
                                                </div>
                                                <!-- The table listing the files available for upload/download -->
                                                <table role="presentation" class="table table-striped">
                                                    <tbody class="files">
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail" class="col-sm-2 control-label">背景图片 最佳(1920 x 753)</label>

                                        <div class="col-sm-10">
                                            <form id="backgroundimage" action="../../upload" method="POST"
                                                  enctype="multipart/form-data">
                                                <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                                <noscript><input type="hidden" name="redirect"></noscript>
                                                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                                <div class="row fileupload-buttonbar">
                                                    <div class="col-lg-7">
                                                        <!-- The fileinput-button span is used to style the file input field as button -->
                                                        <span class="btn btn-success fileinput-button">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span>选择一个文件</span>
                                                <input type="file" name="files[]" multiple>
                                            </span>
                                                        <input type="checkbox" class="toggle">
                                                        <!-- The global file processing state -->
                                                        <span class="fileupload-process"></span>
                                                    </div>
                                                    <!-- The global progress state -->
                                                    <div class="col-lg-5 fileupload-progress fade">
                                                        <!-- The global progress bar -->
                                                        <div class="progress progress-striped active" role="progressbar"
                                                             aria-valuemin="0" aria-valuemax="100">
                                                            <div class="progress-bar progress-bar-success"
                                                                 style="width:0%;"></div>
                                                        </div>
                                                        <!-- The extended global progress state -->
                                                        <div class="progress-extended">&nbsp;</div>
                                                    </div>
                                                </div>
                                                <!-- The table listing the files available for upload/download -->
                                                <table role="presentation" class="table table-striped">
                                                    <tbody class="files">
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="settings-cn">
                                <form class="form-horizontal" method="post">
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-2 control-label">姓</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="last-name-cn" placeholder="姓" value="<?php echo $user->getLastNameCn() ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail" class="col-sm-2 control-label">名</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="first-name-cn" placeholder="名" value="<?php echo $user->getFirstNameCn() ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputExperience" class="col-sm-2 control-label">中文介绍</label>

                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="description-cn" rows="5"
                                                      placeholder="中文介绍"><?php echo $user->getDescriptionCn() ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <input name="post-type" value="2" hidden>
                                            <button type="submit" class="btn btn-danger">保存修改</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="settings">
                                <form class="form-horizontal" method="post">
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-2 control-label">First Name</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="first-name-en" placeholder="First name" value="<?php echo $user->getFirstNameEn() ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail" class="col-sm-2 control-label">Last Name</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="last-name-en" placeholder="Last name" value="<?php echo $user->getLastNameEn() ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="en" class="col-sm-2 control-label">英文介绍</label>

                                        <div class="col-sm-10">
                                            <textarea class="form-control" rows="5" name="description-en"
                                                      placeholder="英文介绍"><?php echo $user->getDescriptionEn() ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <input name="post-type" value="3" hidden>
                                            <button type="submit" class="btn btn-danger">保存修改</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="settings-password">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-2 control-label">原密码</label>

                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="inputName" placeholder="Name" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-2 control-label">新密码</label>

                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="inputName" placeholder="Name" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">保存修改</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

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
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="../plugins/jQuery-File-Upload/js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
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
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="../plugins/datatables/extensions/Responsive/js/dataTables.responsive.js"></script>


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


<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="../plugins/jquery.ui.touch-punch/jquery.ui.touch-punch.min.js"></script>

<script>
    $(document).ready(function () {
        $('.sidebar-menu').tree()
    })
</script>

<!-- editor -->
<script src="../plugins/ckeditor/ckeditor.js"></script>


<script type="text/javascript"> window.onload = function () {
        CKEDITOR.replace('description-cn');
        CKEDITOR.replace('description-en');

    }
</script>

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
        $('#mainimage').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: '../../upload/',
            maxNumberOfFiles: 1,
            autoUpload: true,
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent)
        }).on('fileuploadsubmit', function (e, data) {
            data.formData = data.context.find(':input').serializeArray();
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                var picId = file.id;
                $.confirm({
                    content: function () {
                        var self = this;
                        return $.ajax({
                            url: 'ajax/users.php',
                            dataType: 'json',
                            method: 'POST',
                            data: {
                                pic: picId,
                                user:<?php echo $user->getId() ?>,
                                type: 'upload-main-pic'
                            }
                        }).done(function (response) {
                            var result = response.result;
                            if (result) {
                                self.setTitle('更新成功');
                                self.setContent(response.message + ' 更新成功');
                                self.setType('green');
                            }
                            else {
                                self.setTitle('更新失败');
                                self.setContent(response.message + ' 更新失败');
                                self.setType('red');
                            }

                        }).fail(function () {
                            self.setTitle('服务器连接失败');
                            self.setContent('抱歉！服务器连接失败，请检查网络后重试。');
                            self.setType('red');
                        });
                    }
                });
            });
        }).on('fileuploaddestroyed', function (e, data) {
            $.confirm({
                content: function () {
                    var self = this;
                    return $.ajax({
                        url: 'ajax/users.php',
                        dataType: 'json',
                        method: 'POST',
                        data: {
                            user:<?php echo $user->getId() ?>,
                            type: 'destroy-main-pic'
                        }
                    }).done(function (response) {
                        var result = response.result;
                        if (result) {
                            self.setTitle('删除成功');
                            self.setContent(response.message + ' 删除成功');
                            self.setType('green');
                        }
                        else {
                            self.setTitle('删除失败');
                            self.setContent(response.message + ' 删除失败');
                            self.setType('red');
                        }

                    }).fail(function () {
                        self.setTitle('服务器连接失败');
                        self.setContent('抱歉！服务器连接失败，请检查网络后重试。');
                        self.setType('red');
                    });
                }
            });
        });
        var mainPic = <?php echo $user->getMainPic(); ?>;


        if (mainPic !== 0) {
            // Load existing files:
            $('#mainimage').addClass('fileupload-processing');

            $.ajax({
                url: 'ajax/getid.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: mainPic,
                    type: 'single'
                },
                context: $('#mainimage')[0]
            }).fail(function () {
                $('<div class=\"alert alert-danger\"/>')
                    .text('Upload server currently unavailable - ' +
                        new Date())
                    .appendTo('#mainimage');
            }).always(function () {
                $(this).removeClass('fileupload-processing');
            }).done(function (result) {
                $(this).fileupload('option', 'done')
                    .call(this, $.Event('done'), {result: result});
            });
        }

    });

    $(function () {
        'use strict';

        // Initialize the jQuery File Upload widget:
        $('#standimage').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: '../../upload/',
            maxNumberOfFiles: 1,
            autoUpload: true,
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent)
        }).on('fileuploadsubmit', function (e, data) {
            data.formData = data.context.find(':input').serializeArray();
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                var picId = file.id;
                $.confirm({
                    content: function () {
                        var self = this;
                        return $.ajax({
                            url: 'ajax/users.php',
                            dataType: 'json',
                            method: 'POST',
                            data: {
                                pic: picId,
                                user:<?php echo $user->getId() ?>,
                                type: 'upload-stand-pic'
                            }
                        }).done(function (response) {
                            var result = response.result;
                            if (result) {
                                self.setTitle('更新成功');
                                self.setContent(response.message + ' 更新成功');
                                self.setType('green');
                            }
                            else {
                                self.setTitle('更新失败');
                                self.setContent(response.message + ' 更新失败');
                                self.setType('red');
                            }

                        }).fail(function () {
                            self.setTitle('服务器连接失败');
                            self.setContent('抱歉！服务器连接失败，请检查网络后重试。');
                            self.setType('red');
                        });
                    }
                });
            });
        }).on('fileuploaddestroyed', function (e, data) {
            $.confirm({
                content: function () {
                    var self = this;
                    return $.ajax({
                        url: 'ajax/users.php',
                        dataType: 'json',
                        method: 'POST',
                        data: {
                            user:<?php echo $user->getId() ?>,
                            type: 'destroy-stand-pic'
                        }
                    }).done(function (response) {
                        var result = response.result;
                        if (result) {
                            self.setTitle('删除成功');
                            self.setContent(response.message + ' 删除成功');
                            self.setType('green');
                        }
                        else {
                            self.setTitle('删除失败');
                            self.setContent(response.message + ' 删除失败');
                            self.setType('red');
                        }

                    }).fail(function () {
                        self.setTitle('服务器连接失败');
                        self.setContent('抱歉！服务器连接失败，请检查网络后重试。');
                        self.setType('red');
                    });
                }
            });
        });
        var thisPic = <?php echo $user->getStandPic(); ?>;


        if (thisPic !== 0) {
            // Load existing files:
            $('#standimage').addClass('fileupload-processing');

            $.ajax({
                url: 'ajax/getid.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: thisPic,
                    type: 'single'
                },
                context: $('#standimage')[0]
            }).fail(function () {
                $('<div class=\"alert alert-danger\"/>')
                    .text('Upload server currently unavailable - ' +
                        new Date())
                    .appendTo('#standimage');
            }).always(function () {
                $(this).removeClass('fileupload-processing');
            }).done(function (result) {
                $(this).fileupload('option', 'done')
                    .call(this, $.Event('done'), {result: result});
            });
        }

    });

    $(function () {
        'use strict';

        // Initialize the jQuery File Upload widget:
        $('#backgroundimage').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: '../../upload/',
            maxNumberOfFiles: 1,
            autoUpload: true,
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent)
        }).on('fileuploadsubmit', function (e, data) {
            data.formData = data.context.find(':input').serializeArray();
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                var picId = file.id;
                $.confirm({
                    content: function () {
                        var self = this;
                        return $.ajax({
                            url: 'ajax/users.php',
                            dataType: 'json',
                            method: 'POST',
                            data: {
                                pic: picId,
                                user:<?php echo $user->getId() ?>,
                                type: 'upload-background-pic'
                            }
                        }).done(function (response) {
                            var result = response.result;
                            if (result) {
                                self.setTitle('更新成功');
                                self.setContent(response.message + ' 更新成功');
                                self.setType('green');
                            }
                            else {
                                self.setTitle('更新失败');
                                self.setContent(response.message + ' 更新失败');
                                self.setType('red');
                            }

                        }).fail(function () {
                            self.setTitle('服务器连接失败');
                            self.setContent('抱歉！服务器连接失败，请检查网络后重试。');
                            self.setType('red');
                        });
                    }
                });
            });
        }).on('fileuploaddestroyed', function (e, data) {
            $.confirm({
                content: function () {
                    var self = this;
                    return $.ajax({
                        url: 'ajax/users.php',
                        dataType: 'json',
                        method: 'POST',
                        data: {
                            user:<?php echo $user->getId() ?>,
                            type: 'destroy-background-pic'
                        }
                    }).done(function (response) {
                        var result = response.result;
                        if (result) {
                            self.setTitle('删除成功');
                            self.setContent(response.message + ' 删除成功');
                            self.setType('green');
                        }
                        else {
                            self.setTitle('删除失败');
                            self.setContent(response.message + ' 删除失败');
                            self.setType('red');
                        }

                    }).fail(function () {
                        self.setTitle('服务器连接失败');
                        self.setContent('抱歉！服务器连接失败，请检查网络后重试。');
                        self.setType('red');
                    });
                }
            });
        });
        var backgroundPic = <?php echo $user->getBackgroundPic(); ?>;


        if (backgroundPic !== 0) {
            // Load existing files:
            $('#backgroundimage').addClass('fileupload-processing');

            $.ajax({
                url: 'ajax/getid.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: backgroundPic,
                    type: 'single'
                },
                context: $('#backgroundimage')[0]
            }).fail(function () {
                $('<div class=\"alert alert-danger\"/>')
                    .text('Upload server currently unavailable - ' +
                        new Date())
                    .appendTo('#backgroundimage');
            }).always(function () {
                $(this).removeClass('fileupload-processing');
            }).done(function (result) {
                $(this).fileupload('option', 'done')
                    .call(this, $.Event('done'), {result: result});
            });
        }

    });

</script>

<script>


</script>

</body>
</html>
