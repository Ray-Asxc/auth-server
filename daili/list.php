<?php
/**
 * 授权列表
**/
include("../includes/common.php");
$title='授权列表';
include './head.php';
if($islogins==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
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
          <li><a href="./login.php?logout"><span class="glyphicon glyphicon-log-out"></span> 退出登陆</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav><!-- /.navbar -->
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<?php
if(isset($_GET['kw'])) {
	$kw = daddslashes(base64_decode($_GET['kw']));
	if($_GET['type']==1)
		$sql=($_GET['method']==1)?" `uid` LIKE '%{$kw}%'":" `uid`='{$kw}'";
	elseif($_GET['type']==2)
		$sql=($_GET['method']==1)?" `url` LIKE '%{$kw}%'":" `url`='{$kw}'";
	elseif($_GET['type']==3)
		$sql=($_GET['method']==1)?" `authcode` LIKE '%{$kw}%'":" `authcode`='{$kw}'";
	elseif($_GET['type']==4)
		$sql=($_GET['method']==1)?" `sign` LIKE '%{$kw}%'":" `sign`='{$kw}'";
	else{
		if(is_numeric($kw))$column='uid';
		elseif(strpos($kw,'.')!==false)$column='url';
		else $column='authcode';
		$sql=($_GET['method']==1)?" `{$column}` LIKE '%{$kw}%'":" `{$column}`='{$kw}'";
	}
	$gls=$DB->count("SELECT count(*) from auth_site WHERE{$sql} and daili='{$daili_id}'");
	$con='包含 '.$kw.' 的共有 <b>'.$gls.'</b> 个域名';
	$link='&kw='.$_GET['kw'];
}elseif(isset($_GET['qq'])) {
	$qq=daddslashes($_GET['qq']);
	$sql=" `uid`='{$qq}'";
	$gls=$DB->count("SELECT count(*) from auth_site WHERE{$sql} and daili='{$daili_id}'");
	$con='QQ '.$_GET['qq'].' 共有 <b>'.$gls.'</b> 个域名';
	$link='&qq='.$_GET['qq'];
}else{
	$gls=$DB->count("SELECT count(*) from auth_site WHERE daili='{$daili_id}'");
	$sql=" 1";
	$con='授权平台代理用户(UID:'.$daili_id.')共有 <b>'.$gls.'</b> 个域名';
}

$pagesize=30;
if (!isset($_GET['page'])) {
	$page = 1;
	$pageu = $page - 1;
} else {
	$page = $_GET['page'];
	$pageu = ($page - 1) * $pagesize;
}

echo $con;
?>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>ID</th><th>ＱＱ</th><th>域名</th><th>时间</th><th>状态</th><th>操作</th></tr></thead>
          <tbody>
<?php
$rs=$DB->query("SELECT * FROM auth_site WHERE{$sql} and daili='{$daili_id}' order by id desc limit $pageu,$pagesize");
while($res = $DB->fetch($rs))
{
echo '<tr><td>'.$res['id'].'</td><td><a href="list.php?qq='.$res['uid'].'">'.$res['uid'].'</a>&nbsp;<a href="tencent://message/?uin='.$res['uid'].'&Site=%E6%8E%88%E6%9D%83%E5%B9%B3%E5%8F%B0&Menu=yes">[?]</a></td><td><a href="/jump.php?url='.urlencode(base64_encode('http://'.$res['url'].'/')).'" target="_blank">'.$res['url'].'</a></td><td>'.$res['date'].'</td><td onclick="alert(\'授权码：'.$res['authcode'].'\n\r特征码：'.$res['sign'].'\')">'.$res['active'].'</td><td><a href="./edit.php?my=edit&id='.$res['id'].'" class="btn btn-xs btn-info">编辑</a> <a href="./edit.php?my=del&id='.$res['id'].'" class="btn btn-xs btn-danger" onclick="return confirm(\'你确实要删除此条授权记录吗？\');">删除</a></td></tr>';
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
echo '<li><a href="list.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="list.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="list.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$s;$i++)
echo '<li><a href="list.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$s)
{
echo '<li><a href="list.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="list.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
#分页
?>
    </div>
  </div>