<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yihua
 * Date: 2/11/2018
 * Time: 8:40 PM
 */

define("pageName", "站点特殊信息编辑");
$requiredLevel = 10;
require_once ("../admin_files/webUI.php");
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
    <!-- DataTables -->
    <link rel=\"stylesheet\" href=\"../plugins/datatables/dataTables.bootstrap.css\">
    <!-- DataTables Responsive CSS -->
    <link href=\"../plugins/datatables/extensions/Responsive/css/dataTables.responsive.css\" rel=\"stylesheet\">
    <!-- blueimp Gallery styles -->
    <link rel=\"stylesheet\" href=\"//blueimp.github.io/Gallery/css/blueimp-gallery.min.css\">
    <!-- CSS to style the Jquery-Confirm -->
    <link rel=\"stylesheet\" href=\"../plugins/jquery-confirm/dist/jquery-confirm.min.css\">

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
    <?php echoNavBarHtml(14) ?>

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
            <style>
                #sortable {
                    list-style-type: none;
                    margin: 0;
                    padding: 0;
                    width: 60%;
                }

                #sortable li {
                    margin: 0 3px 3px 3px;
                    padding: 0.4em;
                    padding-left: 1.5em;
                    font-size: 1.4em;
                }

                #sortable li span {
                    position: absolute;
                    margin-left: -1.3em;
                }
            </style>

            <?php
            if(isset($_GET['lang'])) {
                if (strcmp($_GET['lang'], 'cn') == 0) {
                    require '../../system_files/lang/Chinese.php';
                    $lang = 'cn';
                }
                else if (strcmp($_GET['lang'], 'en') == 0) {
                    require '../../system_files/lang/English.php';
                    $lang = 'en';
                }

                echo "
                    <div class=\"alert alert-danger alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                <h4><i class=\"icon fa fa-warning\"></i> 警告！</h4>
                因涉及网站核心配置，需谨慎修改。不正确的修改可能导致网站无法打开！<br>
                <strong>如果出现意外情况，请点击【一键重置】还原所有配置信息。</strong><br>
                <strong>部分字符</strong>支持格式编辑 <a href=\"http://kindeditor.net/demo.php\" target=\"_blank\">点击这里进入在线编辑器</a> 编辑完成后点击左上角【HTML代码】复制粘贴在下面的文本框中即可。
            </div>
            <div class=\"box\">
                <div class=\"box-header\">
                    <h3 class=\"box-title\">编辑列表</h3>
                    <button onclick=\"restore()\" class=\"btn btn-danger\">一键重置</button>
                </div>

                <!-- /.box-header -->
                <div class=\"box-body\">
                    <table id=\"setting-list\" width=\"100%\" class=\"table table-striped table-bordered table-hover\">
                        <thead>
                        <tr>
                            <th>字符串ID</th>
                            <th>实际效果</th>
                            <th>配置内容</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>";



                foreach($langArray as $key => $value) {
                    echo "
                                <tr>";
                    echo "
                                <td>$key</td><td>$value</td>
                                <td><textarea rows=\"3\" id=\"$key\" cols=\"20\">$value</textarea></td>
                                <td><button onclick=\"updateSetting('$key')\" class=\"btn btn-success\">保存</button></td>";
                    echo "
                                </tr>";
                }



                echo"</tbody>
                    </table>

                    <!-- /.box-body -->
                    <div class=\"box-footer\">
                        <div class=\"form-group\">
                            <div class=\"col-sm-offset-10 col-sm-2\">
                            </div>
                            <div class=\"col-sm-offset-11 col-sm-1\">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-footer-->
                </div>
                <!-- /.box -->";
            }
            else{
                $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                echo "
                <div class=\"box\">
                <a href='$actual_link?lang=cn' type=\"button\" class=\"btn btn-primary btn-lg\">修改中文配置</a>
                <a href=\"$actual_link?lang=en\" type=\"button\" class=\"btn btn-primary btn-lg\">修改英文配置</a>

                </div>";
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
<!-- JavaScript to the Jquery-Confirm -->
<script src="../plugins/jquery-confirm/dist/jquery-confirm.min.js"></script>


<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="../plugins/jquery.ui.touch-punch/jquery.ui.touch-punch.min.js"></script>

<script>
    $(document).ready(function () {
        $('.sidebar-menu').tree()
    })
</script>

<!-- page script -->
<script>
    $(document).ready(function () {
        $('#setting-list').DataTable({
            responsive: true
        });
    });

    function updateSetting(key) {
        var value = document.getElementById(key).value;

        $.confirm({
            title: '确认更新保存吗？',
            content: "修改 " + key + " 参数吗？",
            typeAnimated: true,
            buttons: {
                primary: {
                    text: '保存',
                    action: function () {
                        $.confirm({
                            houseClose: 'confirm|3000',
                            buttons: {
                                confirm: {
                                    text: '确定',
                                    action: function () {
                                        //location.reload();
                                    }
                                }
                            },
                            content: function () {
                                var self = this;
                                return $.ajax({
                                    url: 'ajax/update_strings.php',
                                    dataType: 'json',
                                    method: 'POST',
                                    data: {
                                        key: key,
                                        value: value,
                                        type: '<?php echo $lang;?>'
                                    }
                                }).done(function (response) {
                                    var result = response.result;
                                    if (result === true) {
                                        self.setTitle('更新成功');
                                        self.setContent(response.message + ' 更新成功');
                                        self.setType('green');
                                    }
                                    else {
                                        self.setTitle('更新失败');
                                        self.setContent(response.message + ' 更新失败');
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

    function restore() {
        $.confirm({
            title: '确认要一键还原吗？',
            content: "这将重置所有内容至默认状态",
            typeAnimated: true,
            buttons: {
                primary: {
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
                                    url: 'ajax/update_strings.php',
                                    dataType: 'json',
                                    method: 'POST',
                                    data: {
                                        lang: '<?php echo $lang;?>',
                                        type: 'restore'
                                    }
                                }).done(function (response) {
                                    var result = response.result;
                                    if (result === true) {
                                        self.setTitle('重置成功');
                                        self.setContent(response.message + ' 重置成功');
                                        self.setType('green');
                                    }
                                    else {
                                        self.setTitle('更新失败');
                                        self.setContent(response.message + ' 重置失败');
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
