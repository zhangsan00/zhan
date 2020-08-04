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
                <li>广告设置</li>
				<li>头部横幅广告</li>
				 <li class="am-active">修改</li>
				 
            </ol>
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 修改
                    </div>
                </div>
<?php
$AdminTop = json_decode(file_get_contents("../JCSQL/Admin/Ad/AdminTop.php"),true);
array_multisort(array_column($AdminTop,'TopId'),SORT_DESC,$AdminTop);//SOTR_ASC,SOTR_DESC
function post_input($data){$data = stripslashes($data);$data = htmlspecialchars($data);return $data;}
$Id = post_input($_GET["Id"]);
$Top		=	$AdminTop[$Id];	
$TopId	=	$Top['TopId'];//广告链接
$TopWebUrl	=	$Top['TopWebUrl'];//广告链接
$TopRemarks =	$Top['TopRemarks'];//广告备注
$TopPicUrl	=	$Top['TopPicUrl'];//广告图片
$TopState	=	$Top['TopState'];//到期时间
$TopPicUrlWidth =	$Top['TopPicUrlWidth'];//广告图片宽度
$TopPicUrlHeight =	$Top['TopPicUrlHeight'];//广告图片高度

?>


				
                <div class="tpl-block ">

                    <div class="am-g tpl-amazeui-form">


                        <div class="am-u-sm-12 am-u-md-9">
                            <form method="post"  class="am-form am-form-horizontal">
								<input type="hidden" name="Id"  value="<?php echo  $Id;?>" />
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">广告排序</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" name="TopId"  value="<?php echo  $TopId;?>" placeholder="广告排序">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">广告链接URL</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" name="TopWebUrl"  value="<?php echo  $TopWebUrl;?>" placeholder="广告链接URL">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">	广告图片URL</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" name="TopPicUrl"  value="<?php echo  $TopPicUrl;?>" placeholder="广告图片">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">	广告图片宽度</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" name="TopPicUrlWidth"  value="<?php echo  $TopPicUrlWidth;?>" placeholder="广告图片宽度">
                                    </div>
									<div class="am-u-sm-9"><a style="color: #E91E63;">说明：尺寸有百分比与px格式的，100%代表自适应宽度，默认100%</a></div>						
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">	广告图片高度</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" name="TopPicUrlHeight"  value="<?php echo  $TopPicUrlHeight;?>" placeholder="广告图片高度">
                                    </div>
									<div class="am-u-sm-9"><a style="color: #E91E63;">说明：尺寸有百分比与px格式的，100%代表自适应高度，默认100px</a>
									 </div>									
                                </div>	
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">	广告到期时间</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" name="TopState"  value="<?php echo  $TopState;?>" placeholder="广告图片高度">
                                    </div>
									<div class="am-u-sm-9"><a style="color: #E91E63;">说明：20190627代表的就是2019年6月27日，请按照格式填写</a>
									 </div>
                                </div>
								
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">广告费/联系方式</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" name="TopRemarks"  value="<?php echo  $TopRemarks;?>" placeholder="如12/8~1/8广告费100元">
                                    </div>
									<div class="am-u-sm-9"><a style="color: #E91E63;">说明：最好按照官方格式来写，格式：【1000元，邮箱：123@qq.com】【1000元，QQ：123456】 </a></div>	
                                </div>								
                                <div class="am-form-group">
                                    <div class="am-u-sm-9 am-u-sm-push-3">
                                        <button name="submit" type="submit" class="am-btn am-btn-primary">修改</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php


if (isset($_POST['submit']) && isset($_POST['Id'])&& isset($_POST['TopId']) && isset($_POST['TopWebUrl']) && isset($_POST['TopRemarks'])  && isset($_POST['TopPicUrl'])  && isset($_POST['TopState'])&& isset($_POST['TopPicUrlWidth'])&& isset($_POST['TopPicUrlHeight'])) {

$Id = post_input($_POST["Id"]);
$TopId			=	post_input($_POST["TopId"]);//广告链接
$TopWebUrl			=	post_input($_POST["TopWebUrl"]);//广告链接
$TopRemarks			=	post_input($_POST["TopRemarks"]);//广告备注
$TopPicUrl			=	post_input($_POST["TopPicUrl"]);//广告图片
$TopState			=	post_input($_POST["TopState"]);//到期时间
$TopPicUrlWidth 	=	post_input($_POST["TopPicUrlWidth"]);//广告图片宽度
$TopPicUrlHeight 	=	post_input($_POST["TopPicUrlHeight"]);//广告图片高度
if ($Id ==null) { echo'<script language="javascript">alert("广告Id不可为空"); </script>';exit();}
if ($TopWebUrl ==null) { echo'<script language="javascript">alert("广告链接URL不可为空"); </script>';exit();}
if ($TopPicUrl ==null) { echo'<script language="javascript">alert("广告图片不可为空"); </script>';exit();}
if ($TopPicUrlWidth ==null) { echo'<script language="javascript">alert("广告图片宽度不可为空"); </script>';exit();}
if ($TopPicUrlHeight ==null) { echo'<script language="javascript">alert("广告图片高度不可为空"); </script>';exit();}
if ($TopRemarks ==null) { echo'<script language="javascript">alert("广告费/联系方式不可为空"); </script>';exit();}	
if ($TopState ==null) { echo'<script language="javascript">alert("广告到期时间不可为空"); </script>';exit();}	
include('../Php/Public/Mysql.php');	
$AdminTopMod['TopId'] = $TopId;
$AdminTopMod['TopWebUrl'] = $TopWebUrl;
$AdminTopMod['TopRemarks'] = $TopRemarks;
$AdminTopMod['TopPicUrl'] = $TopPicUrl;
$AdminTopMod['TopState'] = $TopState;
$AdminTopMod['TopPicUrlWidth'] = $TopPicUrlWidth;
$AdminTopMod['TopPicUrlHeight'] = $TopPicUrlHeight;	
$UPDATE=UPDATE($AdminTop,$Id,$AdminTopMod); 
$file = fopen("../JCSQL/Admin/Ad/AdminTop.php","w");
fwrite($file,json_encode($UPDATE));
fclose($file);  

?>
<script language="javascript"> 
<!-- 

alert("恭喜修改成功！"); 
window.location.href="?Php=Home/Ad/TopMod&Id=<?php echo $Id;?>" 

--> 
</script> 
<?php

}

?>	
	<?php include('../Php/Admin/footer.php');?>
    </div>
  <script src="../Static/Admin/Js/jquery.min.js"></script>
  <script src="../Static/Admin/Js/amazeui.min.js"></script>
  <script src="../Static/Admin/Js/app.js"></script>
  </body>

</html>