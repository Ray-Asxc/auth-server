<?php
/**
 * 系统日志
**/
include("../includes/common.php");
$title='系统日志';
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
              <li class="active"><a href="./list.php">授权列表</a></li>
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
    <div class="col-sm-12 col-md-10 center-block" style="float: none;">
<?php
if($udata['per_set']==0) {
	showmsg('您的账号没有权限使用此功能',3);
	exit;
}
$my=isset($_GET['my'])?$_GET['my']:null;

echo '<form action="log.php" method="GET" class="form-inline"><input type="hidden" name="my" value="search">
  <div class="form-group">
    <label>搜索</label>
	<select name="column" class="form-control"><option value="uid">操作用户</option><option value="type">操作类型</option><option value="data">操作数据</option></select>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" name="value" placeholder="搜索内容">
  </div>
  <button type="submit" class="btn btn-primary">搜索</button>
</form>';

if($my=='search') {
	if($_GET['column']=='data'){
		$sql=" `data` LIKE '%{$_GET['value']}%'";
	}else{
		$sql=" `{$_GET['column']}`='{$_GET['value']}'";
	}
	$numrows=$DB->count("SELECT count(*) from auth_log WHERE{$sql}");
	$con='包含 '.$_GET['value'].' 的共有 <b>'.$numrows.'</b> 条记录';
	$link='&my=search&column='.$_GET['column'].'&value='.$_GET['value'];
}else{
	$numrows=$DB->count("SELECT count(*) from auth_log");
	$sql=" 1";
	$con='共有 <b>'.$numrows.'</b> 条记录';
}
echo $con;

?>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>操作用户</th><th>操作类型</th><th>时间</th><th>城市</th><th>数据</th></tr></thead>
          <tbody>
<?php
$pagesize=30;
$pages=intval($numrows/$pagesize);
if ($numrows%$pagesize)
{
 $pages++;
 }
if (isset($_GET['page'])){
$page=intval($_GET['page']);
}
else{
$page=1;
}
$offset=$pagesize*($page - 1);

$rs=$DB->query("SELECT * FROM auth_log WHERE{$sql} order by date desc limit $offset,$pagesize");
while($res = $DB->fetch($rs))
{
echo '<tr><td><b>'.$res['uid'].'</b></td><td>'.$res['type'].'</td><td>'.$res['date'].'</td><td>'.$res['city'].'</td><td>'.$res['data'].'</td></tr>';
}
?>
          </tbody>
        </table>
      </div>
<?php
echo'<ul class="pagination">';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo '<li><a href="log.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="log.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="log.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
if($pages>=10)$pages=10;
for ($i=$page+1;$i<=$pages;$i++)
echo '<li><a href="log.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li><a href="log.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="log.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
#分页
?>
    </div>
  </div>