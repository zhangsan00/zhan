<?php

/**
* 模板引擎基础类
*/
class Template
{
    private $config = array(
        'suffix' => '.html',      // 设置模板文件的后缀
        'templateDir' => 'Template/',    // 设置模板所在的文件夹
        'compileDir' => 'cache/',    // 设置编译后存放的目录
        'cache_html' => false,    // 是否需要编译成静态的HTML文件false  true
        'suffix_cache' => '.html',    // 设置编译文件的后缀
        'cache_time' => 3600,    //  多长时间自动更新，单位秒
        'php_turn' => false,   // 是否支持原生PHP代码
        'cache_control' => 'control.dat',
        'WEB_PC_MO' => 'PC',
        'WebYuyan' => 1,//1简体字,0繁体字
        'debug' => false,
    );
    private static $instance = null;
    private $value = array();   // 值栈
    private $compileTool;   // 编译器
    public $file;     // 模板文件名，不带路径
    public $debug = array();   // 调试信息
    private $controlData = array();
    public function __construct($config = array())
    {
        $this->debug['begin'] = microtime(true);
        $this->config = array_merge($this->config,$config);
        if (! is_dir($this->config['compileDir'])) {
            mkdir($this->config['compileDir'], 0770);
        }
        $this->config['compileDir']=$this->config['compileDir'].$this->config['WEB_PC_MO'].'/';

        if (! is_dir($this->config['templateDir'])) {
            exit("模板目录不存在！");
        }
        if (! is_dir($this->config['compileDir'])) {
            mkdir($this->config['compileDir'], 0770);
        }
        $this->getPath();

        include_once './Php/Home/Compile.php';

    }
    /**
    *获取绝对路径
    */
    public function getPath() {
        $this->config['templateDir'] = strtr(realpath($this->config['templateDir']), '\\', '/').'/';
        $this->config['compileDir'] = strtr(realpath($this->config['compileDir']), '\\', '/').'/';
    }
    /**
    *取得模板引擎的实例
    */
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    /* 设置模板引擎参数 */
    public function setConfig($key, $value = null) {
        if (is_array($key)) {
            $this->config = $key + $this->config;
        }else {
            $this->config[$key] = $value;
        }
    }
    /* 获取当前模板引擎配置，仅供调试使用 */
    public function getConfig($key = null) {
        if ($key) {
            return $this->config[$key];
        }else {
            return $this->config;
        }
    }
    /**
    *注入单个变量
    */
    public function assign($key, $value) {
        $this->value[$key] = $value;
    }
    /**
    *注入数组变量
    */
    public function assignArray($array) {
        if (is_array($array)) {
            foreach($array as $k => $v) {
                $this->value[$k] = $v;
            }
        }
    }
    /**
     * 获取模板文件完整路径
     */
    public function path() {
        return $this->config['templateDir'].$this->file.$this->config['suffix'];
    }
    /**
    *判断是否开启了缓存
    */
    public function needCache() {
        return $this->config['cache_html'];
    }
    /**
    *是否需要重新生成静态文件
    */
    public function reCache() {
        $flag = true;
        $cacheFile = $this->config['compileDir'].md5($this->get_url()).$this->config['suffix_cache'];
        $isRewriteFile = $this->config['compileDir'].'isrewrite';
        $cacheFileDir = dirname($cacheFile);
        if ($this->config['cache_html'] === true) {
            $timeFlag = (time() - @filemtime($cacheFile)) < $this->config['cache_time'] ? true : false;
            if (is_file($cacheFile) && filesize($cacheFile) > 1 && $timeFlag && @filemtime($cacheFile)>0) {
                $flag = false;
            }else {
                $flag = true;
            }
        }
        return $flag;
    }
    /**
    *显示模板
    */
    public function show($file) {
        $this->file = $file;
        if (! is_file($this->path())) {
            exit('找不到对应的模板！');
        }
		/***伪静态配置数据***/
        $WebWeiJingTai = $this->config['cache_html'];
		include('./Php/Home/Host.php');
        $compileFile = $this->config['compileDir'].md5($file).'.php';
        $this->compileTool = new Compile($this->path(), $compileFile, $this->config);
        $this->compileTool->value = $this->value;
        $this->compileTool->compile();
        include $compileFile;

        $this->debug['spend'] = microtime(true) - $this->debug['begin'];
        $this->debug['count'] = count($this->value);
        //$this->debug_info();
    }
    public function debug_info() {
        if ($this->config['debug'] === true) {
            echo PHP_EOL, '---------debug info---------', PHP_EOL;
            echo "程序运行日期：", date("Y-m-d H:i:s"), PHP_EOL;
            echo "模板解析耗时：", $this->debug['spend'], '秒', PHP_EOL;
            echo '模板包含标签数目：', $this->debug['count'], PHP_EOL;
            echo '是否使用静态缓存：', $this->debug['cached'], PHP_EOL;
            echo '模板引擎实例参数：', var_dump($this->getConfig());
        }
    }
    /**
    *清理缓存的HTML文件
    */
    public function clean($path = null) {
        $delCache =$this->config['compileDir'];
        $this->delCache($delCache);
    }

    /**
     * 删除缓存目录
     * @param $dirname
     * @return bool
     */
    function delCache($dirname)
    {
        $result = false;
        if (!is_dir($dirname)) {
            echo " $dirname is not a dir!";
            exit(0);
        }
        $handle = opendir($dirname); //打开目录
        while (($file = readdir($handle)) !== false) {
            if ($file != '.' && $file != '..') {
                //排除"."和"."
                $dir = $dirname .'/' . $file;
                is_dir($dir) ? delCache($dir) : unlink($dir);
            }
        }
        closedir($handle);
        $result = rmdir($dirname) ? true : false;
        return $result;
    }

    /**
     * 获取当前页面内容
     */
    public function getCurCache() {
        $file = $this->config['compileDir'].md5($this->get_url()).$this->config['suffix_cache'];
        return file_get_contents($file);
    }

    /**
     * 获取当前页面内容
     */
    public function setCurCache() {
        $file = $this->config['compileDir'].md5($this->get_url()).$this->config['suffix_cache'];
        file_put_contents($file,ob_get_contents());
    }


    /**
     * 得到当前网址后缀
     */
    public function get_url() {
        $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
        $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
        if(strpos($_SERVER ['HTTP_HOST'],'www.') !== false){
            preg_match("#\.(.*)#i","http://".$_SERVER ['HTTP_HOST'],$webss);$webss = $webss[1];
        }else{
            $webss=$_SERVER['HTTP_HOST'];
        }

        return $webss.$relate_url;
    }

}

?>