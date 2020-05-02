<?php
/**
 * 登录
**/
include("../includes/common.php");
if(isset($_POST['user']) && isset($_POST['pass'])){
	if(!$_SESSION['pass_error'])$_SESSION['pass_error']=0;
	$user=daddslashes($_POST['user']);
	$pass=daddslashes($_POST['pass']);
	$row = $DB->get_row("SELECT * FROM auth_user WHERE user='$user' limit 1");
	if($_SESSION['pass_error']>5) {
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('用户名或密码不正确！');history.go(-1);</script>");
	}elseif($row['user']=='') {
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('用户名或密码不正确！');history.go(-1);</script>");
	}elseif ($pass != $row['pass']) {
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('用户名或密码不正确！');history.go(-1);</script>");
	}elseif ($row['active']==0) {
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('您的授权平台账号已被封禁！');history.go(-1);</script>");
	}elseif($row['user']==$user && $row['pass']==$pass){
		$citylist=explode(',',$row['citylist']);
		$city=get_ip_city($clientip);
		if($row['citylist'] && !in_array($city,$citylist)){
			$DB->query("update auth_user set active='0' where uid='{$row['uid']}'");
			$DB->query("insert into `auth_log` (`uid`,`type`,`date`,`city`,`data`) values ('".$user."','异常登陆','".$date."','".$city."','IP:".$clientip."')");
			@header('Content-Type: text/html; charset=UTF-8');
			exit("<script language='javascript'>alert('系统检测到您有异常登录，账号已封禁！');history.go(-1);</script>");
		}
		$session=md5($user.$pass.$password_hash);
		$token=authcode("{$user}\t{$session}", 'ENCODE', SYS_KEY);
		setcookie("auth_token", $token, time() + 604800);
		@header('Content-Type: text/html; charset=UTF-8');
		$city=get_ip_city($clientip);
		$DB->query("insert into `auth_log` (`uid`,`type`,`date`,`city`,`data`) values ('".$user."','登陆平台','".$date."','".$city."','IP:".$clientip."')");
		exit("<script language='javascript'>alert('登陆授权平台成功！');window.location.href='./';</script>");
	}
}elseif(isset($_GET['logout'])){
	setcookie("auth_token", "", time() - 604800);
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已成功注销本次登陆！');window.location.href='./login.php';</script>");
}elseif($islogin==1){
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已登陆！');window.location.href='./';</script>");
}
$title='用户登录';
?>
<!DOCTYPE HTML>
<html>
<head>
<title>授权平台-管理系统登陆</title>
<!-- Custom Theme files -->
<link href="../static/style/css/style.css" rel="stylesheet" type="text/css" media="all"/>
<!-- Custom Theme files -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<body>
<div class="login">
	<h2>授权平台-管理系统登陆</h2>
<form action="./login.php" method="post" role="form">
    <div class="login-top">
       <input type="text" value="请输入管理账号" name="user" value="<?php echo @$_POST['user'];?>" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '请输入管理帐号';}" style="margin-bottom:25px;">
        <input type="password" value="请输入管理密码" name="pass" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '请输入管理密码';}">
	</div>
    <div class="forgot">
        <input type="submit" value="Login" >
    </div>
    </form>
</div>	

</body>
</html>
