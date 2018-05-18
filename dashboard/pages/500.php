<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 11/5/2017
 * Time: 3:29 PM
 */

require_once ("../admin_files/webUI.php");
define("pageName", "500 服务器内部错误");

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
            <div class="error-page">
                <h2 class="headline text-red"> 500</h2>

                <div class="error-content">
                    <h3><i class="fa fa-warning text-red"></i> Oops! 服务器内部错误.</h3>

                    <p>
                       抱歉，服务器内部错误。如有疑问请联系管理员账号和技术支持。 <a href="./panel.php">点击这里返回控制面板</a>
                    </p>

                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->
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

</body>
</html>
