<?php
/**
 * 盗版站点列表
**/
include("../includes/common.php");
$title='盗版站点列表';
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
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-globe"></span> 盗版站点<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li class="active"><a href="./pirate.php">站点列表</a></li>
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
if($udata['per_db']==0) {
	showmsg('您的账号没有权限使用此功能',3);
	exit;
}
$gls=$DB->count("SELECT count(*) from auth_block WHERE 1");
$pagesize=30;
if (!isset($_GET['page'])) {
	$page = 1;
	$pageu = $page - 1;
} else {
	$page = $_GET['page'];
	$pageu = ($page - 1) * $pagesize;
}

if(isset($_POST['qq']) && isset($_POST['url'])){

} ?>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>域名</th><th>入库时间</th><th>类型</th><th>操作</th></tr></thead>
          <tbody>
<?php
$rs=$DB->query("SELECT * FROM auth_block order by date desc limit $pageu,$pagesize");
while($res = $DB->fetch($rs))
{
$type='<font color="orange">正常</font>';
$url=urlencode('http://'.$res['url'].'/');
echo '<tr><td><a href="/jump.php?url='.urlencode('http://'.$res['url'].'/').'" target="_blank">'.$res['url'].'</a>&nbsp;<a href="/jump.php?url='.urlencode('http://'.$res['url'].'/api.php?my=siteinfo').'" target="_blank">[*]</a></td><td>'.$res['date'].'</td><td onclick="alert(\'授权码：'.$res['authcode'].'\')">'.$type.'</td><td><a href="./getpwd.php?url='.$url.'&m=1" class="btn btn-xs btn-primary">获取密码</a> <a href="./edit.php?my=delpirate&url='.$res['url'].'" class="btn btn-xs btn-danger" onclick="return confirm(\'你确实要删除此条记录吗？\');">删除</a></td></tr>';
}
?>
          </tbody>
        </table>
      </div>
<?php
echo'<ul class="pagination">';
$s = ceil($gls / $pagesize);
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$s;
if ($page>1)
{
echo '<li><a href="pirate.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="pirate.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="pirate.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$s;$i++)
echo '<li><a href="pirate.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$s)
{
echo '<li><a href="pirate.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="pirate.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
#分页
?>
    </div>
  </div>