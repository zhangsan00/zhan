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
            <li class="am-active">扩展管理</li>
        </ol>
        <div class="tpl-portlet-components">
            <div class="portlet-title">
                <div class="caption font-green bold">
                    <span class="am-icon-code"></span> 站群插件-修改
                </div>
            </div>
            <div class="tpl-block ">

                <div class="am-g tpl-amazeui-form">


                    <div class="am-u-sm-12 am-u-md-9">
                        <form method="post" name='form'  class="am-form am-form-horizontal">
                            <?php
                            /***检测模板文件夹里的模板名称并且给予输出***/
                            $Template=NULL;
                            $Templates = scandir("../Template/");
                            $bakpc = array();
                            foreach ($Templates as $name) {
                                if(strpos($name,'.') !==false || strpos($name,'-') !==false ){
                                }else{
                                    $Template .='<option value="'.$name.'">'.$name.'</option>';
                                    $bakpc[] =$name;
                                }
                            }

                            $pcsuiji1=$bakpc[array_rand($bakpc)];
                            $tmpsuiji1='<option value="'.$pcsuiji1.'">'.$pcsuiji1.'</option>';
                            $pcsuiji2=$bakpc[array_rand($bakpc)];
                            $tmpsuiji2='<option value="'.$pcsuiji2.'">'.$pcsuiji2.'</option>';

                            ?>


                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">网站域名</label>
                                <div class="am-u-sm-9">
                                    <input type="text" value="" name="WebDomain" placeholder="网站域名不带前缀与带前缀为两个站点">
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">网站名称</label>
                                <div class="am-u-sm-6">
                                    <input type="text" value="" name="WebTitle" placeholder="网站名称">
                                </div>
                                <div class="am-u-sm-3">
                                    <bas onclick="WebTitle()" class="am-btn am-btn-primary" style="color: #ffe000;">随机抽取</bas>
                                </div>

                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">关键字</label>
                                <div class="am-u-sm-6">
                                    <input type="text" value="" name="WebKeywords" placeholder="关键字">
                                </div>
                                <div class="am-u-sm-3">
                                    <bas onclick="WebKeywords()" class="am-btn am-btn-primary" style="color: #ffe000;">随机抽取</bas>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">关键描述</label>
                                <div class="am-u-sm-6">
                                    <input type="text" value="" name="WebDescription" placeholder="关键描述">
                                </div>
                                <div class="am-u-sm-3">
                                    <bas onclick="WebDescription()" class="am-btn am-btn-primary" style="color: #ffe000;">随机抽取</bas>
                                </div>
                            </div>



                            <div class="am-form-group">
                                <label for="user-phone"  class="am-u-sm-3 am-form-label">PC模板选择</label>
                                <div class="am-u-sm-9">
                                    <select name="WebMobanPC" data-am-selected="{searchBox: 1}" >
                                        <?php echo $tmpsuiji1;?>
                                        <?php echo $Template;?>


                                    </select>
                                    <bas class="am-btn am-btn-primary" style="color: #ffe000;">默认随机抽取可手动选择</bas>
                                    <a href="https://bbs.9ccms.net/?thread-5.htm" target="_blank">
                                        <bas class="am-btn am-btn-primary">模板预览图</bas>
                                    </a>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-phone"  class="am-u-sm-3 am-form-label">WAP模板选择 </label>
                                <div class="am-u-sm-9">
                                    <select name="WebMobanWAP" data-am-selected="{searchBox: 1}" >
                                        <?php echo $tmpsuiji2;?>
                                        <?php echo $Template;?>
                                    </select>
                                    <bas class="am-btn am-btn-primary" style="color: #ffe000;">默认随机抽取可手动选择</bas>
                                    <a href="https://bbs.9ccms.net/?thread-5.htm" target="_blank">
                                        <bas class="am-btn am-btn-primary">模板预览图</bas>
                                    </a>
                                </div>
                            </div>


                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">网站logoURL</label>
                                <div class="am-u-sm-9">
                                    <input type="text" value="" name="WebLogo" placeholder="网站logoURL">
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="user-email" class="am-u-sm-3 am-form-label">广告邮箱</label>
                                <div class="am-u-sm-9">
                                    <input type="email" value="" name="WebEmail" placeholder="广告邮箱">
                                </div>
                            </div>


                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3">
                                    <button type="name" name="submit" class="am-btn am-btn-primary">添加</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php


if (isset($_POST['submit']) && isset($_POST['WebDomain']) && isset($_POST['WebTitle']) && isset($_POST['WebKeywords'])  && isset($_POST['WebDescription'])  && isset($_POST['WebMobanPC'])&& isset($_POST['WebMobanWAP'])&& isset($_POST['WebLogo'])&& isset($_POST['WebEmail'])) {
    $Zhanqun = json_decode(file_get_contents("../JCSQL/Admin/Plug/Zhanqun/index.php"),true);
    function post_input($data){$data = stripslashes($data);$data = trim(htmlspecialchars($data));return $data;}
    $WebDomain			=	post_input($_POST["WebDomain"]);
    $WebTitle			=	post_input($_POST["WebTitle"]);
    $WebKeywords		=	post_input($_POST["WebKeywords"]);
    $WebDescription		=	post_input($_POST["WebDescription"]);
    $WebMobanPC			=	post_input($_POST["WebMobanPC"]);
    $WebMobanWAP		=	post_input($_POST["WebMobanWAP"]);
    $WebLogo			=	post_input($_POST["WebLogo"]);
    $WebEmail			=	post_input($_POST["WebEmail"]);
    if ($WebDomain ==null) { echo'<script language="javascript">alert("域名不可为空"); </script>';exit();}
    if ($WebTitle ==null) { echo'<script language="javascript">alert("标题不可为空"); </script>';exit();}
    if ($WebKeywords ==null) { echo'<script language="javascript">alert("关键词不可为空"); </script>';exit();}
    if ($WebDescription ==null) { echo'<script language="javascript">alert("介绍不可为空"); </script>';exit();}
    if ($WebMobanPC ==null) { echo'<script language="javascript">alert("PC模板不可为空"); </script>';exit();}
    if ($WebMobanWAP ==null) { echo'<script language="javascript">alert("WAP模板不可为空"); </script>';exit();}
    if ($WebLogo ==null) { echo'<script language="javascript">alert("网站LOGO不可为空"); </script>';exit();}
    if ($WebEmail ==null) { echo'<script language="javascript">alert("网站邮箱不可为空"); </script>';exit();}
    include('../Php/Public/Mysql.php');
    $Zhanqunadd['WebDomain']=$WebDomain;
    $Zhanqunadd['WebTitle']=$WebTitle;
    $Zhanqunadd['WebKeywords']=$WebKeywords;
    $Zhanqunadd['WebDescription']=$WebDescription;
    $Zhanqunadd['WebMobanPC']=$WebMobanPC;
    $Zhanqunadd['WebMobanWAP']=$WebMobanWAP;
    $Zhanqunadd['WebLogo']=$WebLogo;
    $Zhanqunadd['WebEmail']=$WebEmail;
    $UPDATE=INSERT($Zhanqun,$Zhanqunadd);
    $file = fopen("../JCSQL/Admin/Plug/Zhanqun/index.php","w");
    fwrite($file,json_encode($UPDATE));
    fclose($file);

    ?>
    <script language="javascript">
        <!--

        alert("恭喜添加成功！");
        window.location.href="?Php=Plug/Plug_Zhanqun/Plug_admin/add.php"

        -->
    </script>
    <?php

}

?>
﻿<script language="javascript">
    function WebTitle(){
        $.post("?Php=Plug/Plug_Zhanqun/Plug_admin/SEO.php",{fl:'title'},
            function(data){
                form.WebTitle.value =data;
            },
            "text");
    }
    function WebKeywords(){
        $.post("?Php=Plug/Plug_Zhanqun/Plug_admin/SEO.php",{fl:'keywords'},
            function(data){
                form.WebKeywords.value =data;
            },
            "text");
    }
    function WebDescription(){
        $.post("?Php=Plug/Plug_Zhanqun/Plug_admin/SEO.php",{fl:'description'},
            function(data){
                form.WebDescription.value =data;
            },
            "text");
    }

    form.submit.focus();
</script>
<?php include('../Php/Admin/footer.php');?>

<script src="../Static/Admin/Js/jquery.min.js"></script>
<script src="../Static/Admin/Js/amazeui.min.js"></script>
<script src="../Static/Admin/Js/app.js"></script>
</body>

</html>