<?php
/**
 * Copyright (C) 2018 yihua. GNU General Public License
 * User: Yihua
 * Date: 11/6/2017
 * Time: 2:12 AM
 */
define("pageName", "添加文章");
$requiredLevel = 10;

require_once("../admin_files/webUI.php");
require_once("../admin_files/classes/YihuaPost.php");
require_once("../admin_files/classes/YihuaPostTime.php");
require_once("../admin_files/classes/User.php");
require_once("../admin_files/user_function.php");


$db = new Database();

$server = htmlspecialchars($_SERVER["PHP_SELF"]);

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
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel=\"stylesheet\" href=\"../plugins/iCheck/all.css\">

    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload.css\">
    <link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload-ui.css\">
    
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload-noscript.css\"></noscript>
    <noscript><link rel=\"stylesheet\" href=\"../plugins/jQuery-File-Upload/css/jquery.fileupload-ui-noscript.css\"></noscript>
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
    <?php echoNavBarHtml(7) ?>

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
            $options = array(
                "postTitle" => "",
                "postText" => "",
                "postSummaryText" => "",
                "postLang" => "cn",
                "postCate" => 0,
                "postStatus" => 1,
                "postAuthor" => 0,
                "postMainImage" => 0
            );
            $successPost = 0;
            $newPost = new YihuaPost();

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (!empty($_POST["post-type"])) {

                    if ($_POST["post-type"] == 1) {
                        $options["postTitle"] = $_POST["title"];
                        $options["postMainImage"] = $_POST["main-pic"];
                        $options["postText"] = $_POST["mainEditor"];
                        $options["postSummaryText"] = $_POST["summary"];
                        $options["postLang"] = $_POST["lang"];
                        $options["postStatus"] = $_POST["status"];
                        $options["postCate"] = $_POST["post-cate"];
                        $options["postAuthor"] = $user->getId();


                        if ($newPost->createPost($options)) {
                            $successPost = 1;
                            echoSuccessMessage($newPost->getMessage());
                        } else {
                            $errorMsg = $newPost->getErrorMessage();
                            $dangerMessage = "";
                            $arrlength = count($errorMsg);

                            for ($x = 0; $x < $arrlength; $x++) {
                                if (1 != $errorMsg[$x]) {
                                    $dangerMessage .= $errorMsg[$x] . '</br>';
                                }
                            }
                            echoErrorMessage("请检查以下信息是否全部输入<br>" . $dangerMessage);
                        }
                        $options = $newPost->getOptions();
                    }
                }
            }

            function echoSuccessMessage($message)
            {
                echo "              <div class=\"alert alert-success alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                <h4><i class=\"icon fa fa-check\"></i> 成功！</h4>
                " . $message . "
              </div>";
            }

            function echoInfoMessage($message)
            {
                echo "              <div class=\"alert alert-info alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                <h4><i class=\"icon fa fa-check\"></i> 消息</h4>
                " . $message . "
              </div>";
            }

            function echoErrorMessage($message)
            {
                echo "              <div class=\"alert alert-danger alert-dismissible\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                <h4><i class=\"icon fa fa-ban\"></i> 错误！</h4>
                " . $message . "
              </div>";
            }

            ?>
            <!-- Default box -->
            <div class="box" id="post-edit">
                <div class="box-header with-border">
                    <h3 class="box-title">添加文章</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-horizontal">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">封面照片</label>
                            <div class="col-sm-10">
                                <!-- The file upload form used as target for the file upload widget -->
                                <form id="fileupload" action="../../upload" method="POST" enctype="multipart/form-data">
                                    <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                    <noscript><input type="hidden" name="redirect"
                                                     value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
                                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                    <div class="row fileupload-buttonbar">
                                        <div class="col-lg-7">
                                            <!-- The fileinput-button span is used to style the file input field as button -->
                                            <span class="btn btn-success fileinput-button">
                                                        <i class="glyphicon glyphicon-plus"></i>
                                                        <span>选择一张图片</span>
                                                        <input type="file" name="files[]" multiple>
                                                    </span>
                                            <!-- The global file processing state -->
                                            <span class="fileupload-process"></span>
                                        </div>
                                        <!-- The global progress state -->
                                        <div class="col-lg-5 fileupload-progress fade">
                                            <!-- The global progress bar -->
                                            <div class="progress progress-striped active" role="progressbar"
                                                 aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
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
                        <form method="post" id="saveForm" action="<?php echo $server; ?>">
                            <input class="form-control" name="main-pic" id="main-image" type="hidden" value="<?php echo $options["postMainImage"]; ?>">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">语言</label>
                                <div class="col-sm-10">
                                    <label class="radio-inline"><input id="cn-check" class="minimal" type="radio" name="lang"
                                                                       value="cn" <?php if(strcmp($options['postLang'],'cn')==0){echo "checked";} ?>>中文</label>
                                    <label class="radio-inline"><input id="en-check" class="minimal" type="radio" name="lang"
                                                                       value="en" <?php if(strcmp($options['postLang'],'en')==0){echo "checked";} ?>>英文</label>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">分类</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="post-cate" id="post-select">
                                        <option value="0" >无</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">标题</label>
                                <div class="col-sm-10">
                                    <input name="title" class="form-control" placeholder="标题"
                                           value="<?php echo $options["postTitle"] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">文章正文</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="8"
                                              name="mainEditor"><?php echo $options["postText"] ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">文章简介</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="3" name="summary"
                                              placeholder="简介不要大于50个字符（25个中文字），可手工输入或从文章中自动提取。"><?php echo $options["postSummaryText"] ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">是否发布</label>
                                <div class="col-sm-10">
                                    <label class="radio-inline"><input class="minimal" type="radio" name="status"
                                                                       value="1" <?php if($options['postStatus']==1){echo "checked";} ?>>立即发布</label>
                                    <label class="radio-inline"><input class="minimal" type="radio" name="status"
                                                                       value="0" <?php if($options['postStatus']==0){echo "checked";} ?>>存为草稿稍后发布</label>
                                </div>
                            </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-offset-11 col-sm-1">
                            <input type="hidden" name="post-type" value="1">
                            <button type="submit" class="btn btn-primary" form="saveForm">发布文章</button>
                        </div>
                    </div>
                </div>
                </form>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

            <!-- post-view box -->
            <div class="box" id="post-view">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $options["postTitle"] ?></h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <?php echo $options["postText"] ?>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">

                </div>
                <!-- /.box-footer-->
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
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="../plugins/datatables/extensions/Responsive/js/dataTables.responsive.js"></script>
<!-- JavaScript to the Jquery-Confirm -->
<script src="../plugins/jquery-confirm/dist/jquery-confirm.min.js"></script>

<!-- iCheck 1.0.1 -->
<script src="../plugins/iCheck/icheck.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="../plugins/jquery.ui.touch-punch/jquery.ui.touch-punch.min.js"></script>

<script>
    $(document).ready(function () {
        $('.sidebar-menu').tree();
        $("#post-view").hide();

        var show = <?php echo $successPost; ?>;

        if(show === 1)
        {
            $("#post-edit").hide();
            $("#post-view").show();
        }

        loadTypeOptions('<?php echo $options["postLang"]; ?>');
    })
</script>

<!-- editor -->
<script src="../plugins/ckeditor/ckeditor.js"></script>


<script type="text/javascript"> window.onload = function () {
        CKEDITOR.replace('mainEditor');
    }
</script>

<script>

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    })

    $("#cn-check").on('ifChecked', function(event){
        loadTypeOptions('cn');
    });

    $("#en-check").on('ifChecked', function(event){
        loadTypeOptions('en');
    });
</script>

<script>
    function loadTypeOptions($lang) {
        $.ajax({
            url: 'ajax/posttype.php',
            type: 'POST',
            dataType: 'json',
            data: {
                type: $lang
            },
            context: $('#fileupload')[0]
        }).fail(function () {
            $('#post-select')
                .empty()
                .append('<option selected="selected" value="0">加载失败</option>')
            ;
        }).always(function () {
            $('#post-select')
                .empty()
                .append('<option selected="selected" value="0">加载中</option>')
            ;
        }).done(function (result) {
            var array = result;
            if (array)
            {
                var sleceted = <?php echo $options["postCate"]; ?>;
                $('#post-select')
                    .empty()
                    .append('<option value="0">无(none)</option>');
                for (var i = 0;i<array.length;i++) {
                        $('#post-select')
                            .append($('<option>', {
                                value: array[i].value,
                                text: array[i].name
                            }));
                }
                $("#post-select").val(sleceted);
            }
        });
    }
</script>

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
            <input name="pid[]" class="form-control" type="hidden" value="<?php echo 0; ?>">

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
            <p>上传成功，封面图片ID:{%=file.id%}</p>
        </td>
        <td>
            <p>简介:{%=file.description||''%}</p>
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button onclick="resetId()"; class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
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

    var mainPic = <?php echo $options["postMainImage"]; ?>;

    $(function () {
        'use strict';

        // Initialize the jQuery File Upload widget:
        $('#fileupload').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: '../../upload/',
            autoUpload: true,
            maxNumberOfFiles: 1,
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(jpe?g|png)$/i,
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent)
        }).on('fileuploadsubmit', function (e, data) {
            data.formData = data.context.find(':input').serializeArray();
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('#main-image').val(file.id);
            });
        });


        if (mainPic !== 0) {
            // Load existing files:
            $('#fileupload').addClass('fileupload-processing');

            $.ajax({
                url: 'ajax/getid.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: mainPic,
                    type: 'single'
                },
                context: $('#fileupload')[0]
            }).fail(function () {
                $('<div class=\"alert alert-danger\"/>')
                    .text('Upload server currently unavailable - ' +
                        new Date())
                    .appendTo('#fileupload');
            }).always(function () {
                $(this).removeClass('fileupload-processing');
            }).done(function (result) {
                $(this).fileupload('option', 'done')
                    .call(this, $.Event('done'), {result: result});
            });
        }

    });

    function resetId() {
        mainPic = 0;
        $('#main-image').val("");

    }


</script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="../plugins/jQuery-File-Upload/js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
</body>
</html>
