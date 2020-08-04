<?php
if (isset($ADMINKEY)) { }else{ exit('404');   }   include('../Php/Admin/cookie.php');?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>久草CMS管理中心</title>
    <meta name="description" content="这是一个 index 页面">
    <meta name="keywords" content="index">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <link rel="icon" type="image/png" href="../Static/Admin/Pic/favicon.png">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="apple-mobile-web-app-title" content="Amaze UI" />
    <link rel="stylesheet" href="../Static/Admin/Css/amazeui.min.css" />
    <link rel="stylesheet" href="../Static/Admin/Css/admin.css">
    <link rel="stylesheet" href="../Static/Admin/Css/app.css">
    <!--    <script src="../Static/Admin/Css/echarts.min.js"></script>-->
</head>
<body data-type="index">
<?php include('../Php/Admin/header.php');?>
<div class="tpl-page-container tpl-page-header-fixed">
    <?php include('../Php/Admin/list.php');?>
    <div class="tpl-content-wrapper">
        <ol class="am-breadcrumb">
            <li><a href="#" class="am-icon-home">首页</a></li>
            <li class="am-active">公告管理</li>
        </ol>
        <div class="tpl-portlet-components">
            <div class="portlet-title">
                <div class="caption font-green bold">
                    <span class="am-icon-code"></span> 公告管理
                </div>
            </div>
            <div class="tpl-block ">

                <div class="am-g tpl-amazeui-form">
                    <?php
                    /***读取数据库中的数据并且给予变量中***/
                    $file = '../Plug/Plug_Gonggao/Plug_data/AdminGonggao.php';
                    if (file_exists($file)){
                        $AdminGonggao = json_decode(file_get_contents($file),true);
                        $WebGongao	=	trim($AdminGonggao['WebGongao']);
                        $WebGongaoOpen	=	$AdminGonggao['WebGongaoOpen'];
                        $WebGonggaoImg		=	$AdminGonggao['WebGonggaoImg'];
                        $WebGonggaoApp		=	$AdminGonggao['WebGonggaoApp'];
//                        $WebGonggaoEmail		=	$AdminGonggao['WebGonggaoEmail'];
                    }else {
                        $AdminGonggao['WebGongao'] = '';
                        $AdminGonggao['WebGongaoOpen'] = 1;
                        $AdminGonggao['WebGonggaoImg'] = '';
                        $AdminGonggao['WebGonggaoApp'] = '';
//                        $AdminGonggao['WebGonggaoEmail'] = '';
                        file_put_contents($file,$AdminGonggao);
                    }
                    $WebGongao	=	trim($AdminGonggao['WebGongao']);
                    $WebGongaoOpen	=	$AdminGonggao['WebGongaoOpen'];
                    $WebGonggaoImg		=	$AdminGonggao['WebGonggaoImg'];
                    $WebGonggaoApp		=	$AdminGonggao['WebGonggaoApp'];
//                    $WebGonggaoEmail		=	$AdminGonggao['WebGonggaoEmail'];

                    ?>

                    <?php
                    /***修改系统设置数据库***/
                    if (isset($_POST['submit']) && isset($_POST['WebGongao']) && isset($_POST['WebGongaoOpen'])  ) {
                        function post_input($data){$data = stripslashes($data);$data = htmlspecialchars($data);return $data;}
                        $Gonggao						=NULL;

                        if(!empty($_FILES['WebGonggaoImg']['name'])){
                            include_once "../Php/Public/Upload.php";
                            $upload = new Upload(['path'=>'/Plug/Plug_Gonggao/Plug_img/']);
                            $WebGonggaoImg = $upload->uploadFile("WebGonggaoImg");
                            if (!$WebGonggaoImg) {
                                echo '<script language="javascript">alert("'.$upload->errorInfo.'");window.history.go(-1);</script>';exit;
                            }
                        }

                        $Gonggao['WebGongao']		=	trim(post_input($_POST['WebGongao']));
                        $Gonggao['WebGongaoOpen']		=	post_input($_POST['WebGongaoOpen']);
                        $Gonggao['WebGonggaoApp']		=	post_input($_POST['WebGonggaoApp']);
//                        $Gonggao['WebGonggaoEmail']		=	post_input($_POST['WebGonggaoEmail']);
                        $Gonggao['WebGonggaoImg']			=	post_input($WebGonggaoImg?$WebGonggaoImg:$AdminGonggao['WebGonggaoImg']);
                        $file = fopen("../Plug/Plug_Gonggao/Plug_data/AdminGonggao.php","w");
                        fwrite($file,json_encode($Gonggao));
                        fclose($file);
                        ?>
                        <script language="javascript">
                            <!--
                            alert("恭喜修改成功！");
                            window.location.href="?Php=Plug/Plug_Gonggao/Plug_admin/index.php"
                            -->
                        </script>
                    <?php	}	?>
                    <div class="am-u-sm-12 am-u-md-9">
                        <form method="post" enctype="multipart/form-data" class="am-form am-form-horizontal">

                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">公告开关</label>
                                <div class="am-u-sm-9">

                                    <input type="radio" name="WebGongaoOpen" value="1" <?php if ($WebGongaoOpen==1)echo 'checked'?> id="open"><label for="open">打开</label>
                                    <input type="radio" name="WebGongaoOpen" value="2" <?php if ($WebGongaoOpen==2)echo 'checked'?> id="close"><label for="close">关闭</label>

                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">公告说明文字</label>
                                <div class="am-u-sm-9">
                                    <textarea name="WebGongao" id="WebGongao" cols="30" rows="10"><?php echo $WebGongao;?></textarea>
<!--                                    <input style="width: 65%;display: inline-block;float: left;margin-right: 2%;" type="text" value="--><?php //echo $WebGongao;?><!--" name="WebGongao" placeholder="公告说明文字">-->
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">app下载地址</label>
                                <div class="am-u-sm-9">
                                    <input style="width: 65%;display: inline-block;float: left;margin-right: 2%;" type="text" value="<?php echo $WebGonggaoApp;?>" name="WebGonggaoApp" placeholder="公告说明文字">
                                </div>
                            </div>
<!--                            <div class="am-form-group">-->
<!--                                <label for="user-name" class="am-u-sm-3 am-form-label">防封邮箱</label>-->
<!--                                <div class="am-u-sm-9">-->
<!--                                    <input style="width: 65%;display: inline-block;float: left;margin-right: 2%;" type="text" value="--><?php //echo $WebGonggaoEmail;?><!--" name="WebGonggaoEmail" placeholder="公告说明文字">-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">公告图片</label>
                                <div class="am-u-sm-9">
                                    <input type="file" name="WebGonggaoImg" >
                                    <img style="max-width: 400px;max-height: 400px;" src="<?php echo $WebGonggaoImg;?>" alt="">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3">
                                    <button type="name" name="submit" class="am-btn am-btn-primary">保存修改</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('../Php/Admin/footer.php');?>
</div>
<script src="../Static/Admin/Js/jquery.min.js"></script>
<script src="../Static/Admin/Js/amazeui.min.js"></script>
<script src="../Static/Admin/Js/app.js"></script>
</body>

</html>