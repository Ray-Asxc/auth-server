<?php
/**
 * 获取密码
**/
include("../includes/common.php");
$title='获取密码';
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
          <li>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cloud"></span> 授权管理<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="./list.php">授权列表</a></li>
              <li><a href="./add.php">添加授权</a><li>
			  <li><a href="./addsite.php">添加站点</a><li>
			  <li><a href="./search.php">搜索授权</a><li>
            </ul>
          </li>
		  <li><a href="./downfile.php"><span class="glyphicon glyphicon-thumbs-up"></span> 下载管理</a></li>
		  <li class="active">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-globe"></span> 盗版管理<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="./pirate.php">站点列表</a></li>
              <li class="active"><a href="./getpwd.php">获取密码</a><li>
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
if($udata['per_db']==0) {
	showmsg('您的账号没有权限使用此功能',3);
	exit;
}

$url = daddslashes($_GET['url']);
$domain = parse_url($url);
$domain = $domain['host'];

$row=$DB->get_row("SELECT * FROM auth_site WHERE url='{$domain}' limit 1");
if($row==''){}else exit("<script language='javascript'>alert('此站点位于正版列表内！');history.go(-1);</script>");

if($_GET["m"]==1)
{
	$msg='未查询到该站点账号信息';
}
?>
      <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">获取密码</h3></div>
          <ul class="list-group">
            <li class="list-group-item"><span class="glyphicon glyphicon-tint"></span> <b>站点网址：</b> <a href="/jump.php?url=<?=urlencode($url)?>" target="_blank"><?=$url?></a></li>
            <li class="list-group-item"><span class="glyphicon glyphicon-user"></span> <b>账号信息：</b> <?=$msg?></li>
            <li class="list-group-item"><span class="glyphicon glyphicon-list"></span> <b>功能操作：</b>
              <a href="/jump.php?url=<?=urlencode($url)?>" class="btn btn-xs btn-success" target="_blank">进入网站</a>
            </li>
          </ul>
      </div>

      <div class="panel panel-primary">
        <div class="panel-body">
          <form action="./getpwd.php" method="GET" class="form-horizontal" role="form">
            <div class="input-group">
              <span class="input-group-addon">网址</span>
              <input type="text" name="url" value="<?=$url?>" class="form-control" placeholder="http://www.aliapp.com/" autocomplete="off" required/>
            </div><br/>
			<div class="input-group">
              <span class="input-group-addon">方式</span>
              <select class="form-control" name="m">
			  <option value="1">1_获取密码</option>
			  </select>
            </div><br/>
            <div class="form-group">
              <div class="col-sm-12"><input type="submit" value="获取密码" class="btn btn-primary form-control"/></div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>