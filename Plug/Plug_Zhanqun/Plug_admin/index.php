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
                <li>扩展管理</li>
				 <li class="am-active">站群中心</li>
            </ol>
<div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span>站群中心
                    </div>


                </div>
                <div class="tpl-block">
                    <div class="am-g">
                        <div class="am-u-sm-12 am-u-md-6">
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
									 <a href="?Php=Plug/Plug_Zhanqun/Plug_admin/add.php"><button type="button" class="am-btn am-btn-default am-btn-success"><span class="am-icon-plus"></span> 添加域名</button></a>
                                </div>
                            </div>
                        </div>

                        <div class="am-u-sm-12">
                            <form class="am-form">
                                <table class="am-table am-table-striped am-table-hover table-main">
                                    <thead>
                                        <tr>
                                            <th class="table-title">域名</th>
											<th class="table-title">名称</th>
											<th class="table-title">关键字</th>
                                            <th class="table-type">PC</th>
                                            <th class="table-date am-hide-sm-only">MO</th>
                                            <th class="table-set">操作</th>
                                        </tr>
                                    </thead>
                                    <tbody style="word-break: break-all;">	
<?php

$Zhanqun = json_decode(file_get_contents("../JCSQL/Admin/Plug/Zhanqun/index.php"),true);

$count 	= count($Zhanqun);


for ($x=0; $x<=$count-1; $x++) {
	

$Zhanquns		=	$Zhanqun[$x];	
$WebDomain		=	$Zhanquns['WebDomain'];
$WebTitle		=	$Zhanquns['WebTitle'];
$WebKeywords	=	$Zhanquns['WebKeywords'];
$WebDescription	=	$Zhanquns['WebDescription'];
$WebMobanPC		=	$Zhanquns['WebMobanPC'];
$WebMobanWAP	=	$Zhanquns['WebMobanWAP'];
$WebLogo		=	$Zhanquns['WebLogo'];
$WebEmail		=	$Zhanquns['WebEmail'];


?>
<tr>
	<td><a href="http://<?php echo $WebDomain ?>" target="_blank"><?php echo $WebDomain ?></a></td>
	<td><?php echo $WebTitle ;?></td>
	<td><?php echo $WebKeywords ;?></td>
	<td><?php echo $WebMobanPC ;?></td>
	<td class="am-hide-sm-only"><?php echo $WebMobanWAP ;?></td>
	<td>
		<div class="am-btn-toolbar">
			<div class="am-btn-group am-btn-group-xs">
				<a href="?Php=Plug/Plug_Zhanqun/Plug_admin/mod.php&Id=<?php echo $x?>" class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 详细设置</a>
				<a href="?Php=Plug/Plug_Zhanqun/Plug_admin/index.php&Id=<?php echo $x?>" onclick="return confirm('确定要删除吗？')" target="_blank" class="am-btn am-btn-default am-btn-xs am-text-danger _am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</a>
			</div>
		</div>
	</td>
</tr>
<?php
}

?>






                                    </tbody>
                                </table>
                                <hr>

                            </form>
                        </div>

                    </div>
                </div>

<?php
if (isset($_GET['Php']) && isset($_GET['Id']) ) {	
function post_input($data){$data = stripslashes($data);$data = htmlspecialchars($data);return $data;}	
$Php = post_input($_GET["Php"]);	
$Id = post_input($_GET["Id"]);	
if($Php =="Plug/Plug_Zhanqun/Plug_admin/index" || $Id !== NULL ){
$AdminTop = json_decode(file_get_contents("../JCSQL/Admin/Plug/Zhanqun/index.php"),true);
include('../Php/Public/Mysql.php');	
$file = fopen("../JCSQL/Admin/Plug/Zhanqun/index.php","w");
fwrite($file,json_encode(DELETE($AdminTop,$Id)));
fclose($file);  
?>
	<script language="javascript"> 
	<!-- 

	alert("恭喜删除成功！"); 
	window.location.href="?Php=Plug/Plug_Zhanqun/Plug_admin/index.php"

	--> 
	</script> 
<?php
	}
}	
?>	





	<?php include('../Php/Admin/footer.php');?>
    </div>
  <script src="../Static/Admin/Js/jquery.min.js"></script>
  <script src="../Static/Admin/Js/amazeui.min.js"></script>
  <script src="../Static/Admin/Js/app.js"></script>
  </body>

</html>