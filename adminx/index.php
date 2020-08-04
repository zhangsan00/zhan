<?php
error_reporting(E_ALL ^E_NOTICE ^E_WARNING);
date_default_timezone_set('PRC'); //设置中国时区

define('JCCMS',$_SERVER['DOCUMENT_ROOT']);
define('JCCMS_PLUG',JCCMS.'/Plug/');

$ADMINKEY='9CCMS18';
//引入公共辅助函数
include("../Php/Public/Helper.php");
if(isset($_GET['Php'])){
	$Php = safeRequest($_GET['Php']);
}else{
	$Php = NULL;
}
//插件菜单模块
if (is_dir(JCCMS_PLUG)){
    $plug_dir = scandir(JCCMS_PLUG);
    if ($plug_dir){
        if (is_array($plug_dir)){
            unset($plug_dir[0],$plug_dir[1]);
            foreach ($plug_dir as $v){
                $confFile =JCCMS_PLUG.$v.'/version.json';
                if (file_exists($confFile)){
                    $plug_menu[] = json_decode(file_get_contents($confFile),true);
                }
            }
        }
    }
}

if($Php ==NULL){
//登录路由入口
include('../Php/Admin/Login.php'); 
}
if(strpos($Php,'Home') !== false){
//后台路由入口
include("../Php/Public/Home.php");
include('../Php/Admin/'.$C_T_0.'.php'); 
}
if(strpos($Php,'Cancellation') !== false){ 
//注销路由入口
include("../Php/Public/Cancellation.php");
include('../Php/Admin/'.$C_T_0.'.php'); 
}
if(strpos($Php,'Plug') !== false){
//插件路由入口
include("../Php/Public/Plug.php");
}

?>