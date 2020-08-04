var hash = {'32' : '\u3000'}; 
// °ë½Ç×ªÈ«½Ç 
function sbc2dbc(str) { 
    var ret = [], i = 0, len = str.length, code, chr; 
    for (; i < len; ++i) { 
        code = str.charCodeAt(i); 
        chr = hash[code]; 
        if (!chr && code > 31 && code < 127) { 
            chr = hash[code] = String.fromCharCode(code + 65248); 
        } 
        ret[i] = chr ? chr : str.charAt(i); 
    } 
    return ret.join(''); 
} 
var hostname;
var hostname2;
var hostnametxt;
var lf=window.location.host.toLowerCase().split(".");
hostname2=sbc2dbc(window.location.host.toUpperCase());
if (lf.length>1){
	hostname=lf[lf.length-2] + "." + lf[lf.length-1]
	hostnametxt="www." + hostname.substring(0,3) + hostname.substring(3,hostname.length);
	document.title=document.title+hostname2;
	if (document.getElementById("WebUrl")){
		document.getElementById("WebUrl").innerHTML=hostname2;
	}
	if (document.getElementById("logo")){
		document.getElementById("logo").innerHTML=hostnametxt;
	}
}
window.status=hostname2;

function StayPosition(speed){
	this.objs = [];
	this.speed = speed || 0.1;
	this.timer = this.round = this.obj = this.end = null;
	if(StayPosition.initialize !== true){
		function correct(func, obj){
			return function(){
				func.call(obj);
			}
		}
		StayPosition.prototype.start = function(){
			this.timer = setInterval(correct(this.run, this), 33);
		}
		StayPosition.prototype.stop = function(){
			clearInterval(this.timer);
		}
		StayPosition.prototype.capitalize = function(prop){return prop.replace(/^[a-z]/, function(a){return a.toUpperCase();})}
		StayPosition.prototype.add = function(dom, prop){
			var offset = prop ? "offset" + this.capitalize(prop) : "offsetTop";
			var scroll = prop ? "scroll" + this.capitalize(prop) : "scrollTop";
			prop = prop ? prop : this.offset.slice(6).toLowerCase();
			this.objs.push({"dom": dom, "prop": {"size": dom[offset], "name": prop, "offset": offset, "scroll": scroll}});
		}
		StayPosition.prototype.run = function(){
			for(var i = 0, l = this.objs.length; i < l; i++){
				this.obj = this.objs[i];
				this.end = (document.documentElement[this.obj.prop.scroll] || document.body[this.obj.prop.scroll]) + this.obj.prop.size;
				if(this.end != this.obj.dom[this.obj.prop.offset]){
					this.round = this.end - this.obj.dom[this.obj.prop.offset] > 0 ? Math.ceil : Math.floor;
					this.obj.dom.style[this.obj.prop.name] = this.obj.dom[this.obj.prop.offset] + this.round((this.end - this.obj.dom[this.obj.prop.offset]) * this.speed) + "px";
				}
			}
		}
	}
	StayPosition.initialize = true;
}
//标志
var mobile=false;
var ua = navigator.userAgent.toLowerCase();
if (/android/i.test(ua)) {
	mobile=true;
}
if (/ipad|iphone|ipod/.test(ua) && !window.MSStream) {
	mobile=true;
}

function create(c) {
	var b = document.createDocumentFragment(),
		a = document.createElement("div");
	for (a.innerHTML = c; a.firstChild;) b.appendChild(a.firstChild);
	return b
}

function closeAd() {
	var adBlock = document.getElementById('download_dibu');
	adBlock.style.display = 'none';
}


if (mobile) {
	var fragment = create('<style>@media only screen { html { font-size: 13px; } }@media only screen and (min-width:360px) and (max-width: 399px) { html { font-size: 15px; } }@media only screen and (min-width: 400px)and(max-width: 479px) { html { font-size: 16px; } }@media only screen and (min-width: 480px) and (max-width:719px) { html { font-size: 20px; } }@media only screen and (min-width: 720px) { html { font-size: 30px;} } .global_video_bottom_dbtc { margin: 0 auto; text-align: center; }.global_video_bottom_dbtc > p, dl, dt, dd,table, td, th, input, img, form, div, span, ul, ol, li, h1, h2, h3, h4, h5, h6, select, input { margin: 0;padding: 0; font-weight: normal; }.global_video_bottom_dbtc > img, iframe { border: none; }.global_video_bottom_dbtc { background: rgba(0,0,0, 0.85); padding: 0.5rem 0; position: fixed; bottom: 0; left: 0; width: 100%; z-index: 300; height:4rem;overflow: hidden; text-align: left; }.global_video_bottom_dbtc .iLogo { background-position: 0 0;background-repeat: no-repeat; background-size: 3rem 3rem; width: 3rem; height: 4rem; display: block; overflow:hidden; position: absolute; z-index: 5; top: 0.5rem; left: 1.33rem; }.global_video_bottom_dbtc .pTxt {color: #fff; line-height: 1.5rem; padding: 0 0rem 0 5rem; }.global_video_bottom_dbtc .pTxt span { display:block; height: 1.5rem; overflow: hidden; }.global_video_bottom_dbtc .pTxt span.sTit { font-size: 1.13rem; } .global_video_bottom_dbtc .pTxt span.sDes { font-size: 0.93rem; } .global_video_bottom_dbtc .downloadBtn { width: 6.33rem; height: 2.07rem; line-height: 2.07rem; text-align: center; color: #fff; font-size: 1rem; background: #33aaff; border-radius: 0.1rem; -moz-border-radius: 0.1rem; -webkit-border-radius: 0.1rem; -ms-border-radius: 0.1rem; -o-border-radius: 0.1rem; box-shadow: 0 2px 2px #2988cc; -moz-box-shadow: 0 2px 2px #2988cc; -webkit-box-shadow: 0 2px 2px #2988cc; -ms-box-shadow: 0 2px 2px #2988cc; -o-box-shadow: 0 2px 2px #2988cc; position: absolute; top: 0.9rem; right: 2.33rem; }.global_video_bottom_dbtc .aCloseBtn { width: 2.67rem; height:1.67rem; line-height: 2.5rem; overflow: hidden; color: #ff0000; position: absolute; top: 0; right: 0;text-align: center; font-size: 1.67rem; z-index: 10; }.global_video_bottom_dbtc .maskBtn { position: absolute;z-index: 10; width: 100%; height: 100%; overflow: hidden; top: 0; left: 0; } </style><section class="global_video_bottom_dbtc" id="download_dibu"><i class="iLogo" style="background-image: url(/css/images/icon.png)"></i><p class="pTxt"><span class="sTit">注意!添加四虎网站到手机，预防丢失!</span><span class="sDes">收藏四虎，免安装APP！保护手机隐私！</span></p><i target="_blank" class="downloadBtn">\u67e5\u770b\u5e2e\u52a9</i><a class="maskBtn runAppHome" target="_blank" href="https://dizhi.i4hu.com"></a><i class="aCloseBtn" id="foot_down_close" onclick="closeAd()">\u00d7</i></section>');
	document.body.insertBefore(fragment, document.body.childNodes[-1])
};