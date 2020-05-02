<?php
/**
 * 代理管理
**/
include("../includes/common.php");
$title='代理管理';
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
<div class="modal fade" align="left" id="search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">搜索代理</h4>
      </div>
      <div class="modal-body">
      <form action="ulist.php" method="GET">
<input type="text" class="form-control" name="kw" placeholder="请输入用户名或QQ"><br/>
<input type="submit" class="btn btn-primary btn-block" value="搜索"></form>
</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php
if($udata['per_set']==0) {
	showmsg('您的账号没有权限使用此功能',3);
	exit;
}

$my=isset($_GET['my'])?$_GET['my']:null;

if($my=='add')
{
echo '<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">添加代理用户</h3></div>';
echo '<div class="panel-body">';
echo '<form action="./ulist.php?my=add_submit" method="POST">
<div class="form-group">
<label>用户名:</label><br>
<input type="text" class="form-control" name="user" value="" required>
</div>
<div class="form-group">
<label>密码:</label><br>
<input type="text" class="form-control" name="pwd" value="" required>
</div>
<div class="form-group">
<label>联系QQ:</label><br>
<input type="text" class="form-control" name="qq" value="">
</div>
<div class="form-group">
<label>状态:</label>
<select name="active" class="form-control"><option value="1">1_激活</option><option value="0">0_封禁</option></select>
</div>
<input type="submit" class="btn btn-primary btn-block" value="确定添加"></form>';
echo '<br/><a href="./ulist.php">>>返回代理列表</a>';
echo '</div></div>';
}
elseif($my=='edit')
{
$id=intval($_GET['id']);
$row=$DB->get_row("select * from auth_daili where uid='$id' limit 1");
echo '<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">修改代理用户信息</h3></div>';
echo '<div class="panel-body">';
echo '<form action="./ulist.php?my=edit_submit&id='.$id.'" method="POST">
<div class="form-group">
<label>用户名:</label><br>
<input type="text" class="form-control" name="user" value="'.$row['user'].'" required>
</div>
<div class="form-group">
<label>密码:</label><br>
<input type="text" class="form-control" name="pwd" value="'.$row['pass'].'" required>
</div>
<div class="form-group">
<label>联系QQ:</label><br>
<input type="text" class="form-control" name="qq" value="'.$row['qq'].'">
</div>
<div class="form-group">
<label>常用登陆地:</label><br>
<input type="text" class="form-control" name="citylist" value="'.$row['citylist'].'" placeholder="多个登录地用,隔开">
</div>
<div class="form-group">
<label>状态:</label>
<select name="active" class="form-control" default="'.$row['active'].'"><option value="1">1_激活</option><option value="0">0_封禁</option></select>
</div>
<input type="submit" class="btn btn-primary btn-block" value="确定修改"></form>';
echo '<br/><a href="./ulist.php">>>返回代理列表</a>';
echo '</div></div>';
}
elseif($my=='add_submit')
{
$user=$_POST['user'];
$pwd=$_POST['pwd'];
$qq=$_POST['qq'];
$active=$_POST['active'];
if($user==NULL or $pwd==NULL or $active==NULL){
showmsg('保存错误,请确保每项都不为空!',3);
} else {
$rows=$DB->get_row("select * from auth_daili where user='$user' limit 1");
if($rows)
	showmsg('用户名已存在！',3);
$sql="insert into `auth_daili` (`user`,`pass`,`qq`,`active`) values ('".$user."','".$pwd."','".$qq."','".$active."')";
if($DB->query($sql)){
	showmsg('添加代理成功！<br/><br/><a href="./ulist.php">>>返回代理列表</a>',1);
}else
	showmsg('添加代理失败！'.$DB->error(),4);
}
}
elseif($my=='edit_submit')
{
$id=intval($_GET['id']);
$rows=$DB->get_row("select * from auth_daili where uid='$id' limit 1");
if(!$rows)
	showmsg('当前记录不存在！',3);
$user=$_POST['user'];
$pwd=$_POST['pwd'];
$qq=$_POST['qq'];
$citylist=$_POST['citylist'];
$active=$_POST['active'];
if($user==NULL or $pwd==NULL or $active==NULL){
showmsg('保存错误,请确保每项都不为空!',3);
} else {
if($DB->query("update auth_daili set user='$user',pass='$pwd',qq='$qq',citylist='$citylist',active='$active' where uid='{$id}'"))
	showmsg('修改代理成功！<br/><br/><a href="./ulist.php">>>返回代理列表</a>',1);
else
	showmsg('修改代理失败！'.$DB->error(),4);
}
}
elseif($my=='delete')
{
$id=intval($_GET['id']);
$sql="DELETE FROM auth_daili WHERE uid='$id'";
if($DB->query($sql))
	showmsg('删除成功！<br/><br/><a href="./ulist.php">>>返回代理列表</a>',1);
else
	showmsg('删除失败！'.$DB->error(),4);
}
else
{

$numrows=$DB->count("SELECT count(*) from auth_daili");
if(isset($_GET['id'])){
	$sql = " uid={$_GET['id']}";
}elseif(isset($_GET['kw'])){
	$sql = " user='{$_GET['kw']}' or qq='{$_GET['kw']}'";
}else{
	$sql = " 1";
}
$con='系统共有 <b>'.$numrows.'</b> 个代理用户<br/><a href="./ulist.php?my=add" class="btn btn-primary">添加用户</a>&nbsp;<a href="#" data-toggle="modal" data-target="#search" id="search" class="btn btn-success">搜索</a>';

echo '<div class="alert alert-info">';
echo $con;
echo '</div>';

?>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>UID</th><th>用户名</th><th>QQ</th><th>上次登录</th><th>状态</th><th>操作</th></tr></thead>
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

$rs=$DB->query("SELECT * FROM auth_daili WHERE{$sql} order by uid desc limit $offset,$pagesize");
while($res = $DB->fetch($rs))
{
echo '<tr><td><b>'.$res['uid'].'</b></td><td>'.$res['user'].'</td><td><a href="tencent://message/?uin='.$res['qq'].'&amp;Site=qq&amp;Menu=yes">'.$res['qq'].'</a></td><td>'.$res['last'].'</td><td>'.$res['active'].'</td><td><a href="./ulist.php?my=edit&id='.$res['uid'].'" class="btn btn-info btn-xs">编辑</a>&nbsp;<a href="./list.php?uid='.$res['uid'].'" class="btn btn-warning btn-xs">域名</a>&nbsp;<a href="./log.php?my=search&column=uid&value='.$res['user'].'" class="btn btn-success btn-xs">日志</a>&nbsp;<a href="./ulist.php?my=delete&id='.$res['uid'].'" class="btn btn-xs btn-danger" onclick="return confirm(\'你确实要删除此代理用户吗？\');">删除</a></td></tr>';
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
echo '<li><a href="ulist.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="ulist.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="ulist.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
if($pages>=10)$pages=10;
for ($i=$page+1;$i<=$pages;$i++)
echo '<li><a href="ulist.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li><a href="ulist.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="ulist.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
#分页
}
?>
    </div>
  </div>