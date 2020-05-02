<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <title>正版查询</title>
    <!-- Bootstrap -->
  <link href="//lib.baomitu.com/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
  <script src="//lib.baomitu.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!--[if lt IE 9]>
    <script src="//lib.baomitu.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//lib.baomitu.com/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
	<style>
	body{
		margin: 0 auto;
		text-align: center;
	}
	.container {
	  max-width: 580px;
	  padding: 15px;
	  margin: 0 auto;
	}
	</style>
<script type="text/javascript">
function getValue(obj,str){
	var input=window.document.getElementById(obj);
	input.value=str;
}
function checkURL()
{
	var url;
	url = document.auth.url.value;

	if (url.indexOf(" ")>=0){
		url = url.replace(/ /g,"");
		document.auth.url.value = url;
	}
	if (url.toLowerCase().indexOf("http://")==0){
		url = url.slice(7);
		document.auth.url.value = url;
	}
	if (url.toLowerCase().indexOf("https://")==0){
		url = url.slice(8);
		document.auth.url.value = url;
	}
	if (url.slice(url.length-1)=="/"){
		url = url.slice(0,url.length-1);
		document.auth.url.value = url;
	}
}
</script>
</head>
<body background="static/bj.png">
<div class="container">    <div class="header">
        <ul class="nav nav-pills pull-right" role="tablist">
          <li role="presentation" class="active"><a href="index.php">正版查询</a></li>
          <li role="presentation"><a href="http://wpa.qq.com/msgrd?v=3&uin=1277180438&site=qq&menu=yes">购买程序</a></li>
        </ul>
        <h3 class="text-muted" align="left">正版查询</h3>
     </div><hr>
	 <h3 class="form-signin-heading">输入域名查询</h3>
	 <form action="?" class="form-sign" method="get">
	 (不要带http://)
	 <input type="text" class="form-control" name="url" value=""><br>
	 <input type="submit" class="btn btn-primary btn-block" name="submit" value="点击查询"><br/>
	 
<?php
$mod='blank';
include("./includes/common.php");

if($url=daddslashes($_GET['url'])) {
	echo '<label>查询域名：</label>'.$url.'<br>';
	if(checkauth2($url)) {
		echo '<div class="alert alert-success"><img src="static/ico_success.png">查询结果：正版授权！</div>';
	}else{
		echo '<div class="alert alert-danger"><img src="static/ico_tip.png">查询结果：该网站未授权！</div>';
	}
}
$DB->close();
?>
	 <hr><div class="container-fluid">
  <a href="http://wpa.qq.com/msgrd?v=3&uin=1277180438&site=qq&menu=yes" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-credit-card"></span>购买</a>
  <a href="./get/" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-exclamation-sign"></span> 下载</a> 
  <button type="button" class="btn btn-info btn-sm" data-toggle="collapse" data-target="#lxkf-1"><span class="glyphicon glyphicon-user"></span> 客服</button> 
  <a href="http://wpa.qq.com/msgrd?v=3&uin=1277180438&site=qq&menu=yes" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span> 反馈</a>
   <p></p>
<a href="http://wazhuti.com/" class="btn-slide2" target="_blank"> <span class="circle2"><i class="fa fa-user"></i>WordPress付费主题限时免费送啦！</span></a>
</div>
<p style="text-align:center"><br>&copy; Powered by <a href="http://wazhuti.com/">彩虹</a>!</p></div>
</body>
</html>
