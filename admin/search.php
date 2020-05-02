<?php
/**
 * 搜索授权
**/
include("../includes/common.php");
$title='搜索授权';
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
			  <li class="active"><a href="./search.php">搜索授权</a><li>
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
if(isset($_POST['kw']) && isset($_POST['type'])){
	exit("<script language='javascript'>window.location.href='./list.php?type=".$_POST['type']."&kw=".urlencode(base64_encode($_POST['kw']))."&method=".$_POST['method']."';</script>");
}
?>
      <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">搜索授权</h3></div>
        <div class="panel-body">
          <form action="./search.php" method="post" class="form-inline" role="form">
            <div class="form-group">
              <label>类别</label>
              <select name="type" class="form-control">
			    <option value="0">全部</option>
                <option value="1">ＱＱ</option>
                <option value="2">域名</option>
                <option value="3">授权码</option>
                <option value="4">特征码</option>
              </select>
            </div>
            <div class="form-group">
              <label>内容</label>
              <input type="text" name="kw" value="" class="form-control" autocomplete="off" required/>
            </div>
			<div class="form-group">
              <select name="method" class="form-control">
                <option value="0">精确搜索</option>
                <option value="1">模糊搜索</option>
              </select>
            </div>
            <input type="submit" value="查询" class="btn btn-primary form-control"/>
          </form>
        </div>
      </div>
    </div>
  </div>