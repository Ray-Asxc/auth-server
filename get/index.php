<?php
error_reporting(0);
if($_SERVER['HTTP_HOST']=='daishua.cccyun.cc'){
	header("Location: /bin/get/");
	exit;
}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'QQ/')!==false || strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
	if($_GET['open']==1 && strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
		header("Content-Disposition: attachment; filename=\"load.doc\"");
		header("Content-Type: application/vnd.ms-word;charset=utf-8");
	}else{
		header('Content-type:text/html;charset=utf-8');
	}
	include 'jump.php';
	exit;
}
@header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>扫码自助下载最新源码</title>
  <link href="//lib.baomitu.com/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
  <script src="//lib.baomitu.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!--[if lt IE 9]>
    <script src="//lib.baomitu.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//lib.baomitu.com/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
<script src="qrlogin.js?ver=1004"></script>
</head>
<body>
<div class="container">
<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
<div class="panel panel-primary">
	<div class="panel-heading" style="text-align: center;"><h3 class="panel-title">
		扫码自助下载最新源码
	</div>
	<div class="panel-body" style="text-align: center;">
		<div class="list-group">
			<div class="list-group-item">请使用你购买授权时的QQ扫描以下二维码，通过验证后即可下载最新版源码</div>
			<div class="list-group-item list-group-item-info" style="font-weight: bold;" id="login">
				<span id="loginmsg">使用QQ手机版扫描二维码</span><span id="loginload" style="padding-left: 10px;color: #790909;">.</span>
			</div>
			<div class="list-group-item" id="qrimg">
			</div>
			<div class="list-group-item" id="mobile" style="display:none;"><button type="button" id="mlogin" onclick="mloginurl()" class="btn btn-warning btn-block">跳转QQ快捷登录</button></div>
			<div class="list-group-item" id="submit"><a href="#" onclick="loadScript();" class="btn btn-block btn-primary">点此验证</a></div>
		</div>
	</div>
</div>
</div>
</div>
</body>
</html>
