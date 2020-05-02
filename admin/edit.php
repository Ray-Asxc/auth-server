<?php
/**
 * 编辑授权
**/
include("../includes/common.php");
$title='编辑授权';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
  <nav class="navbar navbar-fixed-top navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">导航按钮</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="./">授权平台</a>
      </div><!-- /.navbar-header -->
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="./"><span class="glyphicon glyphicon-user"></span> 平台首页</a>
          </li>
          <li class="active">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cloud"></span> 授权管理<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="./list.php">授权列表</a></li>
              <li><a href="./add.php">添加授权</a><li>
			  <li><a href="./addsite.php">添加站点</a><li>
			  <li><a href="./search.php">搜索授权</a><li>
            </ul>
          </li>
		  <li><a href="./downfile.php"><span class="glyphicon glyphicon-thumbs-up"></span> 下载管理</a></li>
		  <li>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-globe"></span> 盗版管理<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="./pirate.php">站点列表</a></li>
              <li><a href="./getpwd.php">获取密码</a><li>
            </ul>
          </li>
          <li><a href="./login.php?logout"><span class="glyphicon glyphicon-log-out"></span> 退出登陆</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav><!-- /.navbar -->
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<?php
if($udata['per_sq']==0) {
	showmsg('您的账号没有权限使用此功能',3);
	exit;
}
if($_GET['my']=='edit') {
$id=intval($_GET['id']);
$row=$DB->get_row("SELECT * FROM auth_site WHERE id='{$id}' limit 1");
if($row=='')exit("<script language='javascript'>alert('授权平台不存在该记录！');history.go(-1);</script>");
if(isset($_POST['submit'])) {
	$uid=daddslashes($_POST['uid']);
	$url=daddslashes($_POST['url']);
	$authcode=daddslashes($_POST['authcode']);
	$sign=daddslashes($_POST['sign']);
	$active=intval($_POST['active']);
	$ip=daddslashes($_POST['ip']);
	if(strlen($authcode)!=32)showmsg('授权码格式错误！');
	else{
		$sql="update `auth_site` set `uid` ='{$uid}',`url` ='{$url}',`authcode` ='{$authcode}',`sign` ='{$sign}',`active` ='{$active}',`ip` ='{$ip}' where `id`='{$id}'";
		if($DB->query($sql))showmsg('修改成功！',1,$_POST['backurl']);
		else showmsg('修改失败！<br/>'.$DB->error(),4,$_POST['backurl']);
	}
}else{
?>
      <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">编辑授权</h3></div>
        <div class="panel-body">
          <form action="./edit.php?my=edit&id=<?php echo $id; ?>" method="post" class="form-horizontal" role="form">
		  <input type="hidden" name="backurl" value="<?php echo $_SERVER['HTTP_REFERER']; ?>"/>
            <div class="form-group">
              <label class="col-sm-2 control-label">授权ＱＱ</label>
              <div class="col-sm-10"><input type="text" name="uid" value="<?php echo $row['uid']; ?>" class="form-control" required/></div>
            </div><br/>
			<div class="form-group">
              <label class="col-sm-2 control-label">授权域名</label>
              <div class="col-sm-10"><input type="text" name="url" value="<?php echo $row['url']; ?>" class="form-control" required/></div>
            </div><br/>
			<?php if($conf['ipauth']==1){?>
			<div class="form-group">
              <label class="col-sm-2 control-label">授权IP</label>
              <div class="col-sm-10"><input type="text" name="ip" value="<?php echo $row['ip']; ?>" class="form-control" placeholder="留空则自动获取并记录"/></div>
            </div><br/>
			<?php }?>
			<div class="form-group">
              <label class="col-sm-2 control-label">授权码</label>
              <div class="col-sm-10"><input type="text" name="authcode" value="<?php echo $row['authcode']; ?>" class="form-control"/></div>
            </div><br/>
			<div class="form-group">
              <label class="col-sm-2 control-label">特征码</label>
              <div class="col-sm-10"><input type="text" name="sign" value="<?php echo $row['sign']; ?>" class="form-control"/></div>
            </div><br/>
			<div class="form-group">
              <label class="col-sm-2 control-label">授权状态</label>
              <div class="col-sm-10"><select name="active" class="form-control">
				<?php if($row['active']==1){?>
                <option value="1">1_激活</option>
                <option value="0">0_封禁</option>
				<?php }else{?>
				<option value="0">0_封禁</option>
				<option value="1">1_激活</option>
				<?php }?>
              </select></div>
            </div><br/>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
			  <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">返回授权列表</a></div>
            </div>
          </form>
        </div>
      </div>
<?php
}
}elseif($_GET['my']=='del'){
	$id=intval($_GET['id']);
	$row=$DB->get_row("SELECT * FROM auth_site WHERE id='{$id}' limit 1");
	$sql="DELETE FROM auth_site WHERE id='$id' limit 1";
	if($DB->query($sql)){showmsg('删除成功！',1,$_SERVER['HTTP_REFERER']);
		$city=get_ip_city($clientip);
		$DB->query("insert into `auth_log` (`uid`,`type`,`date`,`city`,`data`) values ('".$user."','删除站点','".$date."','".$city."','".$row['uid']."|".$row['url']."|".$row['authcode']."|".$row['sign']."')");
		if(!$_SESSION['del_times_'.date("Ymd")])$_SESSION['del_times_'.date("Ymd")]=0;
		else $_SESSION['del_times_'.date("Ymd")]++;
		if($_SESSION['del_times_'.date("Ymd")]>=30)
			$DB->query("update auth_daili set active='0' where uid='{$udata['uid']}'");
	}
	else showmsg('删除失败！<br/>'.$DB->error(),4,$_SERVER['HTTP_REFERER']);
}elseif($_GET['my']=='delpirate'){
	$url=daddslashes($_GET['url']);
	$sql="DELETE FROM auth_block WHERE url='$url' limit 1";
	if($DB->query($sql))showmsg('删除成功！',1,$_SERVER['HTTP_REFERER']);
	else showmsg('删除失败！<br/>'.$DB->error(),4,$_SERVER['HTTP_REFERER']);
}?>

    </div>
  </div>