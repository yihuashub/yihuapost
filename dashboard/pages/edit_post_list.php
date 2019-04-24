<?php
/**
 * Copyright (C) 2018-2019 yihua. MIT License
 * User: Yihua
 * Date: 11/8/2017
 * Time: 9:49 PM
 */

define("pageName","文章管理");
$requiredLevel = 10;

require_once ("../admin_files/webUI.php");
require_once("../admin_files/classes/User.php");
require_once ("../admin_files/user_function.php");
require_once("../admin_files/classes/YihuaPost.php");


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
    <!-- blueimp Gallery styles -->
    <link rel=\"stylesheet\" href=\"//blueimp.github.io/Gallery/css/blueimp-gallery.min.css\">
    <!-- DataTables Responsive CSS -->
    <link href=\"../plugins/datatables/extensions/Responsive/css/dataTables.responsive.css\" rel=\"stylesheet\">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload.css\">
    <link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload-ui.css\">
    <!-- CSS to style the Jquery-Confirm -->
    <link rel=\"stylesheet\" href=\"../plugins/jquery-confirm/dist/jquery-confirm.min.css\">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload-noscript.css\"></noscript>
    <noscript><link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload-ui-noscript.css\"></noscript>
    
          <style>
        #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
        #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
        #sortable li span { position: absolute; margin-left: -1.3em; }
        </style>

    ") ?>


</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">


    <?php echoheader() ?>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <?php echoNavBarHtml(8) ?>

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
            $houseID = $houseStatus = $sellType = $title = $price = $houseYear = $houseMark = "...";
            $houseModel = $houseTrims = $houseKilometre = $houseTransmission = "...";
            $houseColor = $houseDrivetrain = $houseCondition = $houseFuel = "...";


            $houseDoor = $houseSeat = $houseBodyType = $description = $mainPic = "";

            $nameErr = $iconErr = $listErr = $priceErr = $urlErr = $imgErr = "";
            $name = $price = $icon = $listID = $url = $img ="";

            $check = true;

            function echoSuccessMessage($message)
            {
                echo "              <div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                <h4><i class=\"icon fa fa-check\"></i> 成功！</h4>
                ".$message."  成功添加.
              </div>";
            }

            function echErrorMessage($message)
            {
                echo "              <div class=\"alert alert-danger alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                <h4><i class=\"icon fa fa-ban\"></i> 错误！</h4>
                ".$message."  添加失败.
              </div>";
            }

            ?>

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">编辑列表</h3>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <table id="house-list" width="100%" class="table table-striped table-bordered table-hover" >
                        <thead>
                        <tr>
                            <th>文章ID</th>
                            <th>是否发布</th>
                            <th>标题</th>
                            <th>摘要</th>
                            <th>语言</th>
                            <th>添加日期</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $newPost = new YihuaPost();

                        $postArray = $newPost->getPostList();

                        if($postArray)
                        {
                            foreach ($postArray as $item) {
                                echo "
                                <tr>
                                    <td>".$item['ID']."</td>";
                                echo ($item['postStatus'] == '1') ? '<td>已发布</td>' : '<td>未发布</td>';

                                echo "
                                    <td>".$item['postTitle']."</td>
                                    <td>".$item['postSummaryText']."</td>
                                    <td>".$item['postLang']."</td>
                                    <td>".$item['postDate']."</td>
                                <td>
                                    <div class=\"form-group\">
                                        <form action=\"./edit_post.php\" method=\"post\">
                                            <input type=\"hidden\" name=\"post-id\" value=\"".$item['ID']."\">
                                            <input type=\"hidden\" name=\"post-type\" value=\"2\">
                                            <button type=\"submit\" class=\"btn btn-primary\">
                                            <i class=\"glyphicon glyphicon-pencil\"></i>
                                            <span>编辑</span>
                                            </button>
                                        </form>
                                    </div>
                                    <button onclick=\"deletePost('".$item['ID']."','".$item['postTitle']."')\" class=\"btn btn-danger \">
                                    <i class=\"glyphicon glyphicon-trash\"></i>
                                    <span>删除</span>
                                    </button>
                                </td>
                                </tr>";
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
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
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="../plugins/datatables/extensions/Responsive/js/dataTables.responsive.js"></script>
<!-- The main application script -->
<!-- JavaScript to the Jquery-Confirm -->
<script src="../plugins/jquery-confirm/dist/jquery-confirm.min.js"></script>

<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="../plugins/jQuery-File-Upload/js/cors/jquery.xdr-transport.js"></script>
<![endif]-->

<script>
    $(document).ready(function () {
        $('.sidebar-menu').tree()
    })
</script>


<!-- page script -->
<script>
    $(document).ready(function() {
        $('#house-list').DataTable({
            responsive: true
        });
    });
</script>
<script>

    function deletePost(postID, postTitle) {
        $.confirm({
            title: '确认删除吗？',
            content: postTitle,
            type: 'red',
            typeAnimated: true,
            buttons: {
                danger: {
                    text: '删除',
                    action: function () {
                        $.confirm({
                            houseClose: 'confirm|3000',
                            buttons: {
                                confirm: {
                                    text: '确定',
                                    action: function () {
                                        location.reload();
                                    }
                                }
                            },
                            content: function () {
                                var self = this;
                                return $.ajax({
                                    url: 'ajax/delete.php',
                                    dataType: 'json',
                                    method: 'POST',
                                    data: {
                                        id: postID,
                                        type: 'delete-post-from-list'
                                    }
                                }).done(function (response) {
                                    var result = response.result;
                                    if (result === 1) {
                                        self.setTitle('删除成功');
                                        self.setContent(response.title + ' 删除成功');
                                        self.setType('green');
                                    }
                                    else {
                                        self.setTitle('删除失败');
                                        self.setContent(response.title + ' 删除失败');
                                        self.setContentAppend('<br>' + '抱歉！内部数据错误，请稍后重试。');
                                        self.setType('red');
                                    }

                                }).fail(function () {
                                    self.setTitle('服务器连接失败');
                                    self.setContent('抱歉！服务器连接失败，请检查网络后重试。');
                                    self.setType('red');
                                });
                            }
                        });
                    }
                },
                cancel: {
                    text: '取消',
                    btnClass: 'btn-red',
                    action: function () {
                    }
                }
            }
        });
    }
</script>
</body>
</html>
