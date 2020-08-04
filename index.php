<?php
date_default_timezone_set('PRC'); //设置中国时区
error_reporting(E_ALL ^E_NOTICE ^E_WARNING);
define('JCCMS',$_SERVER['DOCUMENT_ROOT']);
define('JCCMS_PLUG',JCCMS.'/Plug/');

/***引入数组处理类文件***/
include('./Php/Public/Mysql.php');
/***检测当日数据是否更新***/
include('./Php/Home/JCSQL.php');
/***验证终端-$WEB_PC_MO PC or MO***/
include('./Php/Home/PCorwap.php');
/***读取系统后台系统配置数据***/
include('./Php/Home/mysql.php');
/***解析GET路由URL***/
include('./Php/Home/GET.php');

/***前端路由解析入口***/
include('./Php/Home/index.php');
/***
//终端参数				$WEB_PC_MO
//PC模版				$WebMobanPC
//手机模版				$WebMobanWAP
//网站标题				$WebTitle
//网站关键字			$WebKeywords
//网站描述				$WebDescription
//网站logo链接			$WebLogo
//网站邮箱				$WebEmail
//网站统计				$WebCnzz
//友链数组				$AdminIeUrl
//头部横幅广告数组		$AdminTop
//播放横幅广告数组		$AdminVideo
//对联广告数组			$AdminCouplets
//MO底部浮漂广告数组    $AdminFloat
//联盟JS广告			$AdminAdJs
***/

?>