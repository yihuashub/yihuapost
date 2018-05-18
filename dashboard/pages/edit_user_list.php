<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yihua
 * Date: 11/19/2017
 * Time: 2:13 AM
 */


require_once ("../admin_files/webUI.php");
require_once("../admin_files/classes/HouseSystem.php");

define("pageName","用户管理");
$requiredLevel = 10;
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
    <?php echoNavBarHtml(10) ?>

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



            <div class="box">
                <div class="box-header">
                    <button class="btn btn-info btn-lg" onclick="getNewCode();">添加新用户</button>

                </div>

                <!-- /.box-header -->
                <div class="box-body">

                    <table id="user-list" width="100%" class="table table-striped table-bordered table-hover" >
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>邀请码</th>
                            <th>关联账号</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT * FROM site_user_invite";
                        $result = $db->query($sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($rows = mysqli_fetch_assoc($result)) {
                                echo "
                                <tr>
                                    <td>".$rows['ID']."</td>

                                    ";
                                echo "<td>".$rows['code']."</td>";

                                if($rows['link_id'] == 0)
                                {
                                    echo "<td>未关联</td>";
                                }
                                else{
                                    $mId = $rows['link_id'];
                                    $sql2 = "SELECT * FROM yihua_users WHERE ID = $mId";
                                    $result2 = $db->query($sql2);

                                    if (mysqli_num_rows($result2) > 0) {
                                        while ($rows2 = mysqli_fetch_assoc($result2)) {
                                            echo "<td>用户名:".$rows2['username']." 全名:".$rows2['nick_name']."</td>";
                                        }
                                    }
                                }
                                echo ($rows['status'] == 0)?"<td>未激活</td>":"<td>已激活</td>";

                                if($rows['link_id'] == 0)
                                {
                                    echo "<td></td>";
                                }
                                else{
                                    echo "
                                <td>
                                    <div class=\"form-group\">
                                    <button onclick=\"restPassword(".$rows['link_id'].")\" class=\"btn btn-primary \">
                                        <i class=\"glyphicon glyphicon-pencil\"></i>
                                        <span>重置密码</span>
                                    </button>
                                    </div>
                                    <button onclick=\"banAccount(".$rows['link_id'].")\" class=\"btn btn-danger \">
                                        <i class=\"glyphicon glyphicon-trash\"></i>
                                        <span>锁定账号</span>
                                    </button>
                                </td>";
                                }

                                echo"</tr>";
                            }
                        }

                        function checkIfEmpty($inputString)
                        {
                            if(empty($inputString))
                            {
                                return "";
                            }
                            else{
                                return$inputString;
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

<!-- JavaScript to the Jquery-Confirm -->
<script src="../plugins/jquery-confirm/dist/jquery-confirm.min.js"></script>

<script>
    $(document).ready(function () {
        $('.sidebar-menu').tree()
    })
</script>


<!-- page script -->
<script>
    $(document).ready(function() {
        $('#user-list').DataTable({
            responsive: true
        });
    });
</script>
<script>

    function banAccount(userId) {
        $.confirm({
            title: '确认要冻结账号吗？',
            content: '',
            type: 'red',
            typeAnimated: true,
            buttons: {
                danger: {
                    text: '确认',
                    action: function () {
                        $.confirm({
                            houseClose: 'confirm|3000',
                            buttons: {
                                confirm: {
                                    text: '确定',
                                }
                            },
                            content: function () {
                                var self = this;
                                return $.ajax({
                                    url: 'ajax/users.php',
                                    dataType: 'json',
                                    method: 'POST',
                                    data: {
                                        id: userId,
                                        type: 'ban-user'
                                    }
                                }).done(function (response) {
                                    var result = response.result;
                                    if (result) {
                                        self.setTitle('冻结成功');
                                        self.setContent(response.message + ' 冻结成功');
                                        self.setType('green');
                                    }
                                    else {
                                        self.setTitle('冻结失败');
                                        self.setContent(response.message + ' 冻结失败');
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

    function restPassword(userId) {
        $.confirm({
            title: '确认重置密码吗？',
            content: '',
            type: 'red',
            typeAnimated: true,
            buttons: {
                danger: {
                    text: '确认',
                    action: function () {
                        $.confirm({
                            houseClose: 'confirm|3000',
                            buttons: {
                                confirm: {
                                    text: '确定',
                                }
                            },
                            content: function () {
                                var self = this;
                                return $.ajax({
                                    url: 'ajax/users.php',
                                    dataType: 'json',
                                    method: 'POST',
                                    data: {
                                        id: userId,
                                        type: 'reset-user-password'
                                    }
                                }).done(function (response) {
                                    var result = response.result;
                                    if (result) {
                                        self.setTitle('重置成功');
                                        self.setContent(response.message + ' 重置成功');
                                        self.setType('green');
                                    }
                                    else {
                                        self.setTitle('重置失败');
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

    function getNewCode() {
        $.confirm({
            title: '确认创建一个新的邀请码吗？',
            content: '',
            typeAnimated: true,
            buttons: {
                danger: {
                    text: '确认',
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
                                    url: 'ajax/users.php',
                                    dataType: 'json',
                                    method: 'POST',
                                    data: {
                                        type: 'add-new-user'
                                    }
                                }).done(function (response) {
                                    var result = response.result;
                                    if (result) {
                                        self.setTitle('创建成功！');
                                        self.setContent(response.message + ' 创建成功');
                                        self.setType('green');
                                    }
                                    else {
                                        self.setTitle('创建失败');
                                        self.setContent(response.message + ' 创建失败');
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
