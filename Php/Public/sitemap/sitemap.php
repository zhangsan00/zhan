<?php
error_reporting(E_ALL);
/*
 * 生成sitemap地图
 */
function mainMap() {
    $WebWeiJingTai		=	0;
    $file = '../../../Plug/Plug_Public/Plug_data/AdminPublic.php';
    if (file_exists($file)){
        $Public = json_decode(file_get_contents($file),true);
        //是否开启静态缓存
        $WebWeiJingTai		=	(int)$Public['WebWeiJingTai'];
    };

    $domain = curPageURL();
    $dataFiles = getDataFiles('../../../JCSQL/Home');
    foreach ($dataFiles as $key => $value){
        $sitemap = new Sitemap($domain);
        $type = (int)trim($value,'.txt');
            $xmlFileName = 'sitemap'.$type;
            $sitemap->setXmlFile($xmlFileName);			// 设置xml文件（可选）

        if ($type<= 18){}

        //区分展示类型视频图片种子书本
        switch($type){
            case $type<=18:$media = 'video';break;
            case $type>18&&$type<=24:$media = 'book';break;
            case $type>25&&$type<=30:$media = 'pic';break;
            case $type>31&&$type<=36:$media = 'bt';break;
            default:$media = 'video';break;
        }

        if ($type <=36){
            $sitemap->addItem('/', '1.0', 'daily', 'Today');
            $MYSQLVODS = json_decode(file_get_contents('../../../JCSQL/Home/'.$type.'.txt'),true);
            if (!empty($MYSQLVODS)){

                foreach ($MYSQLVODS as $k=> $v){
                        $new_arr = array();
                        foreach($v as $key => $value) {
                            list($dummy, $newkey) = explode('_', $key);
                            $new_arr[$newkey] = $value;
                        }

                        if ($WebWeiJingTai){
                            if ($k%9 == 0){
                                $sitemap->addItem('/'.$media.'_list/'.$type.'/'.((int)($k/9+1)).'/index.html', '1', $media.'_list', $new_arr['time']);
                            }

                            $sitemap->addItem('/'.$media.'_detail/'.$new_arr['id'].'/'.($type).'/index.html', '0.8', $media.'_detail', $new_arr['time']);
                            $sitemap->addItem('/'.$media.'_conter*'.$new_arr['id'].'/'.($type).'/index.html', '0.5', $media.'_conter', $new_arr['time']);

                        }else {
                            if ($k%9 == 0){
                                $sitemap->addItem('/?m='.$media.'_list*'.$type.'*'.((int)($k/9+1)), '1', $media.'_list', $new_arr['time']);
                            }

                            $sitemap->addItem('/?m='.$media.'_detail*'.$new_arr['id'].'*'.($type), '0.8', $media.'_detail', $new_arr['time']);
                            $sitemap->addItem('/?m='.$media.'_conter*'.$new_arr['id'].'*'.($type), '0.5', $media.'_conter', $new_arr['time']);

                        }
                       }
            }

            header("Content-Type: text/html; charset=UTF-8");
            $sitemap->endSitemap();
            $xml = new DOMDocument();
            $xmlFile = './sitemap'.$type.'.xml';
            $xml->Load($xmlFile);
        }
    }

    echo '<script>alert("生成成功");window.history.back()</script>';
}


//获取所有的数据文件路径
function getDataFiles($path_base){
    $max_depth = 0;//最大递归1级子目录
    $ext_name_contain = array('txt');//仅找php文件
    $except_fname_full = array();//排除在外的文件 全路径
    return getFiles($path_base,$max_depth,$ext_name_contain,$except_fname_full);
}
function getFiles($path_base,$max_depth = 0,$ext_name_contain=array(),$except_fname_full = array()){
    static $depth = 0;//当前层级深度
    static $file_list = array();
    $max_depth = max(0,$max_depth);//最大层级深度 >= 0级
    $op = opendir($path_base);

    while($fname = readdir($op)){
        if($fname == '.' || $fname == '..'){
            continue;
        }
        //排除隐藏文件
        if(preg_match('/^\./',$fname)){
            continue;
        }
        $fname_full = $path_base.'/'.$fname;
        if(is_dir($fname_full)){
            //是目录
            if($depth < $max_depth){
                //未达到最大深度 递归
                getFiles($fname_full,$max_depth,$ext_name_contain,$except_fname_full);
            }
        }else if(!in_array($fname_full,$except_fname_full)){
            //是文件 不在排除名单中 则获取扩展名
            $ext_name = getExtnameFromFname($fname);
            $ext_name = strtolower($ext_name);
            if(!$ext_name_contain || in_array($ext_name,$ext_name_contain)){
                //扩展名数组为空 或者 该文件扩展名在要找的数组中
                $file_list[] = $fname;
            }
        }
    }
    return $file_list;
}
function getExtnameFromFname($fname){
    $pathinfo = pathinfo($fname);
    $ext = strtolower($pathinfo['extension']);//后缀名
    return empty($ext) ? '' : $ext ;
}
function curPageURL()
{
    $pageURL = 'http';
    if(isset($_SERVER["HTTPS"])){		$HTTPS =$_SERVER["HTTPS"];}else{		$HTTPS = NULL;}
    if ($HTTPS == "on")
    {
        $pageURL .= "s";
    }
    $pageURL .= "://";

    if ($_SERVER["SERVER_PORT"] != "80")
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] ;
    }
    else
    {
        $pageURL .= $_SERVER["SERVER_NAME"];
    }
    return $pageURL;
}

mainMap();

/**
 * 创建sitemap.xml
 * @param array $itemsArray2
 */
function createSitemap() {
	global $GCONFIG;
	global $GIncludeArray;
	global $GExcludeArray;
	global $GPriorityArray;
	
	//  是否扫描当前根目录
	$scanRootPathArray = array();
	if($GCONFIG['isscanrootpath']) {
		$scanRootPathArray = scanRootPath();
		var_dump($scanRootPathArray);
	}
	// 合并多个数组
	$itemsArray2 = mergeItems($GIncludeArray, $GExcludeArray, $scanRootPathArray);
	
	$sitemap = new Sitemap($GCONFIG['domain']);			// http://mimvp.com
	$sitemap->setXmlFile($GCONFIG['xmlfile']);			// 设置xml文件（可选）
	$sitemap->setDomain($GCONFIG['domain']);				// 设置自定义的根域名（可选）
	$sitemap->setIsChemaMore($GCONFIG['isschemamore']);	// 设置是否写入额外的Schema头信息（可选）
	
	
	// 生成sitemap item
	$idx = 0;
	foreach ($itemsArray2 as $item) {
		$idx += 1;
		echo "$idx  ---  $item<br>";
		$priority = $GPriorityArray[substr_count($item, "/")];
		$sitemap->addItem($item, $priority, "daily", time());
	}
	
	$sitemap->endSitemap();
	
	// 是否打开生成的文件： sitemap.xml
	if($GCONFIG['isopen_xmlfile']) {
		echo "<script>window.open('".$sitemap->getCurrXmlFileFullPath()."')</script>";
		echo "<br>Create sitemap.xml Success";
	}
	
	// 是否xml转html文件
	if($GCONFIG['isxsl2html']) {
		createXSL2Html($sitemap->getCurrXmlFileFullPath(), $GCONFIG['xslfile'], $GCONFIG['htmlfile']);
	}
	
	// 是否打开生成的文件 sitemap.html
	if($GCONFIG['isopen_htmlfile']) {
		echo "<script>window.open('".$GCONFIG['htmlfile']."')</script>";
		echo "<br>Create sitemap.html Success";
	}
}


/**
 * 转化 xml + xsl 为 html 
 * @param unknown $xmlFile		sitemap.xml 源文件
 * @param unknown $xslFile		sitemap-xml.xsl 源文件
 * @param unknown $htmlFile		sitemap.html 生成文件
 * @param string $isopen_htmlfile	是否打开生成文件 sitemap.html
 */
function createXSL2Html($xmlFile, $xslFile, $htmlFile, $isopen_htmlfile=false) {
	
	header("Content-Type: text/html; charset=UTF-8");
//	if (!file_exists($xmlFile)) file_put_contents($xmlFile,'');
//	if (!file_exists($xslFile)) file_put_contents($xslFile,'');
//	if (!file_exists($htmlFile)) file_put_contents($htmlFile,'');
	$xml = new DOMDocument();
	$xml->Load($xmlFile);
//	$xsl = new DOMDocument();
//	$xsl->Load($xslFile);
//	$xslproc = new XSLTProcessor();
//	$xslproc->importStylesheet($xsl);
// 	echo $xslproc->transformToXML($xml);
	
//	$f = fopen($htmlFile, 'w+');
//	fwrite($f, $xslproc->transformToXML($xml));
//	fclose($f);
//
//	 是否打开生成的文件 sitemap.html
//	if($isopen_htmlfile) {
//		echo "<script>window.open('".$htmlFile."')</script>";
//		echo "<br>Create sitemap.html Success";
//	}
}






/**
 * Sitemap
 *
 * 生成 Google Sitemap files (sitemap.xml)
 *
 * @package    Sitemap
 * @author     Sandy <sandy@mimvp.com>
 * @copyright  2009-2017 mimvp.com
 * @license    http://opensource.org/licenses/MIT MIT License
 * @link       http://github.com/mimvp/sitemap-php
 */
class Sitemap {
	
	private $writer;		// XMLWriter对象
	private $domain = "http://mimvp.com";			// 网站地图根域名
	private $xmlFile = "sitemap";					// 网站地图xml文件（不含后缀.xml）
	private $xmlFileFolder = "";					// 网站地图xml文件夹
	private $currXmlFileFullPath = "";				// 网站地图xml文件当前全路径
	private $isSchemaMore= true;					// 网站地图是否添加额外的schema
	private $current_item = 0;						// 网站地图item个数（序号）
	private $current_sitemap = 0;					// 网站地图的个数（序号）
	
	const SCHEMA_XMLNS = '';
	const SCHEMA_XMLNS_XSI = 'http://www.w3.org/2001/XMLSchema-instance';
	const SCHEMA_XSI_SCHEMALOCATION = '';
	const DEFAULT_PRIORITY = 0.5;
	const SITEMAP_ITEMS = 50000;
	const SITEMAP_SEPERATOR = '-';
	const INDEX_SUFFIX = 'index';
	const SITEMAP_EXT = '.xml';
	
	/**
	 * @param string $domain	：	初始化网站地图根域名
	 */
	public function __construct($domain) {
		$this->setDomain($domain);
	}
	
	/**
	 * 设置网站地图根域名，开头用 http:// or https://, 结尾不要反斜杠/
	 * @param string $domain	：	网站地图根域名 <br>例如: http://mimvp.com
	 */
	public function setDomain($domain) {
		if(substr($domain, -1) == "/") {
			$domain = substr($domain, 0, strlen($domain)-1);
		}
		$this->domain = $domain;
		return $this;
	}
	
	/**
	 * 返回网站根域名
	 */
	private function getDomain() {
		return $this->domain;
	}
	
	/**
	 * 设置网站地图的xml文件名
	 */
	public function setXmlFile($xmlFile) {
		$base = basename($xmlFile);
		$dir = dirname($xmlFile);
		if(!is_dir($dir)) {
			$res = mkdir(iconv("UTF-8", "GBK", $dir), 0777, true);
			if($res) {
				echo "mkdir $dir success";
			} else {
				echo "mkdir $dir fail.";
			}
		}
		$this->xmlFile = $xmlFile;
		return $this;
	}
	
	/**
	 * 返回网站地图的xml文件名
	 */
	private function getXmlFile() {
		return $this->xmlFile;
	}
	
	public function setIsChemaMore($isSchemaMore) {
		$this->isSchemaMore = $isSchemaMore;
	}
	
	private function getIsSchemaMore() {
		return $this->isSchemaMore;
	}
	
	/**
	 * 设置XMLWriter对象
	 */
	private function setWriter(XMLWriter $writer) {
		$this->writer = $writer;
	}
	
	/**
	 * 返回XMLWriter对象
	 */
	private function getWriter() {
		return $this->writer;
	}
	
	/**
	 * 返回网站地图的当前item
	 * @return int
	 */
	private function getCurrentItem() {
		return $this->current_item;
	}
	
	/**
	 * 设置网站地图的item个数加1
	 */
	private function incCurrentItem() {
		$this->current_item = $this->current_item + 1;
	}
	
	/**
	 * 返回当前网站地图（默认50000个item则新建一个网站地图）
	 * @return int
	 */
	private function getCurrentSitemap() {
		return $this->current_sitemap;
	}
	
	/**
	 * 设置网站地图个数加1
	 */
	private function incCurrentSitemap() {
		$this->current_sitemap = $this->current_sitemap + 1;
	}
	
	private function getXMLFileFullPath() {
        $xmlfileFullPath = "";
		if ($this->getCurrentSitemap()) {
			$xmlfileFullPath = $this->getXmlFile() . self::SITEMAP_SEPERATOR . $this->getCurrentSitemap() . self::SITEMAP_EXT;	// 第n个网站地图xml文件名 + -n + 后缀.xml
		} else {
			$xmlfileFullPath = $this->getXmlFile() . self::SITEMAP_EXT;	// 第一个网站地图xml文件名 + 后缀.xml
		}
		$this->setCurrXmlFileFullPath($xmlfileFullPath);		// 保存当前xml文件全路径
		return $xmlfileFullPath;
	}
	
	public function getCurrXmlFileFullPath() {
		return $this->currXmlFileFullPath;
	}
	
	private function setCurrXmlFileFullPath($currXmlFileFullPath) {
		$this->currXmlFileFullPath = $currXmlFileFullPath;
	}
	
	/**
	 * Prepares sitemap XML document
	 */
	private function startSitemap() {
		$this->setWriter(new XMLWriter());
		$this->getWriter()->openURI($this->getXMLFileFullPath());	// 获取xml文件全路径
		
		$this->getWriter()->startDocument('1.0', 'UTF-8');
		$this->getWriter()->setIndentString("\t");
		$this->getWriter()->setIndent(true);
		$this->getWriter()->startElement('urlset');
		if($this->getIsSchemaMore()) {
			$this->getWriter()->writeAttribute('xmlns:xsi', self::SCHEMA_XMLNS_XSI);
			$this->getWriter()->writeAttribute('xsi:schemaLocation', self::SCHEMA_XSI_SCHEMALOCATION);
		}
		$this->getWriter()->writeAttribute('xmlns', self::SCHEMA_XMLNS);
	}
	
	/**
	 * 写入item元素，url、loc、priority字段必选，changefreq、lastmod可选
	 */
	public function addItem($loc, $priority = self::DEFAULT_PRIORITY, $changefreq = NULL, $lastmod = NULL) {
		if (($this->getCurrentItem() % self::SITEMAP_ITEMS) == 0) {
			if ($this->getWriter() instanceof XMLWriter) {
				$this->endSitemap();
			}
			$this->startSitemap();
			$this->incCurrentSitemap();
		}
		$this->incCurrentItem();
		$this->getWriter()->startElement('url');
		$this->getWriter()->writeElement('loc', $this->getDomain() . $loc);			// 必选
		$this->getWriter()->writeElement('priority', $priority);					// 必选
		if ($changefreq) {
			$this->getWriter()->writeElement('changefreq', $changefreq);			// 可选
		}
		if ($lastmod) {
			$this->getWriter()->writeElement('lastmod', $this->getLastModifiedDate($lastmod));	// 可选
		}
		$this->getWriter()->endElement();
		return $this;
	}
	
	/**
	 * 转义时间格式，返回时间格式为 2016-09-12
	 */
	private function getLastModifiedDate($date=null) {
		if(null == $date) {
			$date = time();
		}
		if (ctype_digit($date)) {
			return date('c', $date);	// Y-m-d
		} else {
			$date = strtotime($date);
			return date('c', $date);
		}
	}
	
	/**
	 * 结束网站xml文档，配合开始xml文档使用
	 */
	public function endSitemap() {
		if (!$this->getWriter()) {
			$this->startSitemap();
		}
		$this->getWriter()->endElement();
		$this->getWriter()->endDocument();
		$this->getWriter()->flush();
	}
	
	/**
	 * Writes Google sitemap index for generated sitemap files
	 *
	 * @param string $loc Accessible URL path of sitemaps
	 * @param string|int $lastmod The date of last modification of sitemap. Unix timestamp or any English textual datetime description.
	 */
	public function createSitemapIndex($loc, $lastmod = 'Today') {
		$indexwriter = new XMLWriter();
		$indexwriter->openURI($this->getXmlFile() . self::SITEMAP_SEPERATOR . self::INDEX_SUFFIX . self::SITEMAP_EXT);
		$indexwriter->startDocument('1.0', 'UTF-8');
		$indexwriter->setIndent(true);
		$indexwriter->startElement('sitemapindex');
		$indexwriter->writeAttribute('xmlns:xsi', self::SCHEMA_XMLNS_XSI);
		$indexwriter->writeAttribute('xsi:schemaLocation', self::SCHEMA_XSI_SCHEMALOCATION);
		$indexwriter->writeAttribute('xmlns', self::SCHEMA_XMLNS);
		for ($index = 0; $index < $this->getCurrentSitemap(); $index++) {
			$indexwriter->startElement('sitemap');
			$indexwriter->writeElement('loc', $loc . $this->getFilename() . ($index ? self::SITEMAP_SEPERATOR . $index : '') . self::SITEMAP_EXT);
			$indexwriter->writeElement('lastmod', $this->getLastModifiedDate($lastmod));
			$indexwriter->endElement();
		}
		$indexwriter->endElement();
		$indexwriter->endDocument();
	}
	
}
