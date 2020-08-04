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
            <li class="am-active">通用插件</li>
        </ol>
        <div class="tpl-portlet-components">
            <div class="portlet-title">
                <div class="caption font-green bold">
                    <span class="am-icon-code"></span> 通用插件
                </div>
            </div>
            <div class="tpl-block ">

                <div class="am-g tpl-amazeui-form">
                    <?php

                    /***网站地图***/
                    if (isset($_POST['map'])) {
                        include '../Php/Public/sitemap.php';
                        /*
                         * 生成sitemap地图
                         */
                        function mainMap()
                        {
                            libxml_disable_entity_loader(false);

                            $AdminBasic = json_decode(file_get_contents("../Plug/Plug_Public/Plug_data/AdminPublic.php"), true);
                            $WebWeiJingTai = (int)$AdminBasic['WebWeiJingTai'];
                            $domain = curPageURL();
                            $dataFiles = getDataFiles('../JCSQL/Home');
                            $sitemap = new Sitemap($domain);
                            $xmlFileName = '../sitemap';
                            $sitemap->setXmlFile($xmlFileName);            // 设置xml文件（可选）

                            foreach ($dataFiles as $key => $value) {
                                $type = (int)trim($value, '.txt');
                                //区分展示类型视频图片种子书本
                                switch ($type) {
                                    case $type <= 18:
                                        $media = 'video';
                                        break;
                                    case $type > 18 && $type <= 24:
                                        $media = 'book';
                                        break;
                                    case $type > 25 && $type <= 30:
                                        $media = 'pic';
                                        break;
                                    case $type > 31 && $type <= 36:
                                        $media = 'bt';
                                        break;
                                    default:
                                        $media = 'video';
                                        break;
                                }

                                if ($type <= 36) {
                                    $sitemap->addItem('/', '1.0', 'daily', 'Today');
                                    $MYSQLVODS = json_decode(file_get_contents('../JCSQL/Home/' . $type . '.txt'), true);
                                    if (!empty($MYSQLVODS)) {

                                        foreach ($MYSQLVODS as $k => $v) {
                                            $new_arr = array();
                                            foreach ($v as $key => $value) {
                                                list($dummy, $newkey) = explode('_', $key);
                                                $new_arr[$newkey] = $value;
                                            }

                                            //只记录三天前的数据
                                            if (strtotime($new_arr['time']) <= strtotime("-4 day")) {
                                                continue;
                                            };

                                            if ($WebWeiJingTai) {
                                                if ($k % 9 == 0) {
                                                    $sitemap->addItem('/' . $media . '_list/' . $type . '/' . ((int)($k / 9 + 1)) . '/index.html', '1', $media . '_list', $new_arr['time']);
                                                }

                                                $sitemap->addItem('/' . $media . '_detail/' . $new_arr['id'] . '/' . ($type) . '/index.html', '0.8', $media . '_detail', $new_arr['time']);
                                                $sitemap->addItem('/' . $media . '_conter/' . $new_arr['id'] . '/' . ($type) . '/index.html', '0.5', $media . '_conter', $new_arr['time']);

                                            } else {
                                                if ($k % 9 == 0) {
                                                    $sitemap->addItem('/?m=' . $media . '_list*' . $type . '*' . ((int)($k / 9 + 1)), '1', $media . '_list', $new_arr['time']);
                                                }

                                                $sitemap->addItem('/?m=' . $media . '_detail*' . $new_arr['id'] . '*' . ($type), '0.8', $media . '_detail', $new_arr['time']);
                                                $sitemap->addItem('/?m=' . $media . '_conter*' . $new_arr['id'] . '*' . ($type), '0.5', $media . '_conter', $new_arr['time']);

                                            }
                                        }
                                    }
                                }
                            }
//                                    header("Content-Type: text/html; charset=UTF-8");
                            $sitemap->endSitemap();
                            $xml = new DOMDocument();
                            $xmlFile = '../sitemap.xml';
                            $xml->Load($xmlFile);

//                                    echo '<script>alert("生成成功");window.history.back()</script>';
                        }

                        //获取所有的数据文件路径
                        function getDataFiles($path_base)
                        {
                            $max_depth = 0;//最大递归1级子目录
                            $ext_name_contain = array('txt');//仅找php文件
                            $except_fname_full = array();//排除在外的文件 全路径
                            return getFiles($path_base, $max_depth, $ext_name_contain, $except_fname_full);
                        }

                        function getFiles($path_base, $max_depth = 0, $ext_name_contain = array(), $except_fname_full = array())
                        {
                            static $depth = 0;//当前层级深度
                            static $file_list = array();
                            $max_depth = max(0, $max_depth);//最大层级深度 >= 0级
                            $op = opendir($path_base);

                            while ($fname = readdir($op)) {
                                if ($fname == '.' || $fname == '..') {
                                    continue;
                                }
                                //排除隐藏文件
                                if (preg_match('/^\./', $fname)) {
                                    continue;
                                }
                                $fname_full = $path_base . '/' . $fname;
                                if (is_dir($fname_full)) {
                                    //是目录
                                    if ($depth < $max_depth) {
                                        //未达到最大深度 递归
                                        getFiles($fname_full, $max_depth, $ext_name_contain, $except_fname_full);
                                    }
                                } else if (!in_array($fname_full, $except_fname_full)) {
                                    //是文件 不在排除名单中 则获取扩展名
                                    $ext_name = getExtnameFromFname($fname);
                                    $ext_name = strtolower($ext_name);
                                    if (!$ext_name_contain || in_array($ext_name, $ext_name_contain)) {
                                        //扩展名数组为空 或者 该文件扩展名在要找的数组中
                                        $file_list[] = $fname;
                                    }
                                }
                            }
                            return $file_list;
                        }

                        function getExtnameFromFname($fname)
                        {
                            $pathinfo = pathinfo($fname);
                            $ext = strtolower($pathinfo['extension']);//后缀名
                            return empty($ext) ? '' : $ext;
                        }

                        function curPageURL()
                        {
                            $pageURL = 'http';
                            if (isset($_SERVER["HTTPS"])) {
                                $HTTPS = $_SERVER["HTTPS"];
                            } else {
                                $HTTPS = NULL;
                            }
                            if ($HTTPS == "on") {
                                $pageURL .= "s";
                            }
                            $pageURL .= "://";

                            if ($_SERVER["SERVER_PORT"] != "80") {
                                $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"];
                            } else {
                                $pageURL .= $_SERVER["SERVER_NAME"];
                            }
                            return $pageURL;
                        }

                        mainMap();

                        echo '<script language="javascript"> alert("生成成功！");
                            window.location.href="?Php=Plug/Plug_Public/Plug_admin/index.php"
                        </script>';
                    }

                    /***读取数据库中的数据并且给予变量中***/
                    $file = '../Plug/Plug_Public/Plug_data/AdminPublic.php';

                    $AdminPublic = json_decode(file_get_contents($file),true);

                    $WebWeiJingTai	=	isset($AdminPublic['WebWeiJingTai'])?$AdminPublic['WebWeiJingTai']:'';
                    $WebYuyan	=	isset($AdminPublic['WebYuyan'])?$AdminPublic['WebYuyan']:'';
                    $WebRandIndex	=	isset($AdminPublic['WebRandIndex'])?$AdminPublic['WebRandIndex']:'';

                    ?>

                    <?php
                    /***修改系统设置数据库***/
                    if (isset($_POST['submit'])  && isset($_POST['WebWeiJingTai']) && isset($_POST['WebYuyan'])   && isset($_POST['WebRandIndex'])) {
                        function post_input($data){$data = stripslashes($data);$data = htmlspecialchars($data);return $data;}
                        $Public						=NULL;

                        $Public['WebWeiJingTai']		=	post_input($_POST['WebWeiJingTai']);
                        $Public['WebYuyan']		=	post_input($_POST['WebYuyan']);
                        $Public['WebRandIndex']			=	post_input($_POST['WebRandIndex']);

                        $file = fopen($file,"w");
                        fwrite($file,json_encode($Public));
                        fclose($file);
                        ?>
                        <script language="javascript">
                            <!--

                            alert("恭喜修改成功！");
                            window.location.href="?Php=Plug/Plug_Public/Plug_admin/index.php"

                            -->
                        </script>
                    <?php	}	?>
                    <div class="am-u-sm-12 am-u-md-9">
                        <form method="post"  class="am-form am-form-horizontal">
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">是否开启静态缓存</label>
                                <div class="am-u-sm-9">
                                    <input type="radio" name="WebWeiJingTai" value="0" <?php if ($WebWeiJingTai==0 || !$WebWeiJingTai)echo 'checked'?> id="close"><label for="close">关闭</label>
                                    <input type="radio" name="WebWeiJingTai" value="1" <?php if ($WebWeiJingTai==1)echo 'checked'?> id="open"><label for="open">打开</label>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">模板语言字体</label>
                                <div class="am-u-sm-9">
                                    <input type="radio" name="WebYuyan" value="0" <?php if ($WebYuyan==0 || !$WebYuyan)echo 'checked'?> id="closeyuyan"><label for="closeyuyan">简体字</label>
                                    <input type="radio" name="WebYuyan" value="1" <?php if ($WebYuyan==1)echo 'checked'?> id="openyuyan"><label for="openyuyan">繁体字</label>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">首页随机视频</label>
                                <div class="am-u-sm-9">
                                    <input type="radio" name="WebRandIndex" value="0" <?php if ($WebRandIndex==0 || !$WebRandIndex)echo 'checked'?> id="closerand"><label for="closerand">关闭</label>
                                    <input type="radio" name="WebRandIndex" value="1" <?php if ($WebRandIndex==1)echo 'checked'?> id="openrand"><label for="openrand">打开</label>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3">
                                    <button type="name" name="submit" class="am-btn am-btn-primary">保存修改</button>
                                    <div type="name" id="submap" class="am-btn am-btn-primary">生成网站地图</div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <form id="map" method="post" enctype="multipart/form-data" class="am-form am-form-horizontal">
                        <input type="hidden" name="map" value="1">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include('../Php/Admin/footer.php');?>
</div>
<script src="../Static/Admin/Js/jquery.min.js"></script>
<script src="../Static/Admin/Js/amazeui.min.js"></script>
<script src="../Static/Admin/Js/app.js"></script>
<script>
    $('#submap').click(function () {
        $("#map").submit();
    })
</script>
</body>

</html>