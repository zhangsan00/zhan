<!DOCTYPE html> 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="title" content="播放器">
<meta name="apple-touch-fullscreen" content="YES">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=no">

<title>播放器</title>
<style>
	body{
		margin: 0;
}
@media (max-width: 440px){
	.web_size{
		height: 200px !important;
	}
}
.b-videobottom {width:100%;height:30px;background:transparent;position:fixed;text-align:center;left:0;z-index:100;}
      .b-adicon {font-size:12px;color:#555;line-height:30px;margin-left:5px;display:none;}

</style>
</head>
<body>
<div style="width:100%;height:100vh" class="web_size">

<div class="b-videobottom">
        <span class="b-adicon" style="display: inline;">文字广告</span>
	</div>										<video id='myVideo'  class="video-js" ></video>
											<link rel="stylesheet" type="text/css" href="video.min.css?v=3">
											<script type="text/javascript" src="video.min.js?v=1" charset="utf-8" > </script>
												<script type="text/javascript" src="video-conrtib-ads.js?v=1" charset="utf-8" > </script>
												<script type="text/javascript" src="myVideo.js?v=6" charset="utf-8" > </script>
												<script type="text/javascript">

                                                    var vPath = '<?php include('../../../Php/Public/Helper.php'); echo safeRequest($_GET['Play']);?>';

												var logo = '';
												var myVideo=initVideo({
                                                    id:'myVideo',
                                                    url:vPath,
													ad:{
                                                      pre:{
                                                          url:'',
                                                          link:'',
                                                      },
												  	},
                                                  	logo:{
                                                        url:'https://ae01.alicdn.com/kf/H992d7055cfcb41049f5d50f215a95e16W.jpg',
                                                        width:'30%'

                                                    },
												});
												</script>
</div>
</body>
</html>
