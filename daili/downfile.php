<?php
/**
 * 下载管理
**/
include("../includes/common.php");
$title='下载管理';
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
          <li>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cloud"></span> 授权管理<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="./list.php">授权列表</a></li>
              <li><a href="./add.php">添加授权</a><li>
			  <li><a href="./addsite.php">添加站点</a><li>
			  <li><a href="./search.php">搜索授权</a><li>
            </ul>
          </li>
		  <li class="active"><a href="./downfile.php"><span class="glyphicon glyphicon-thumbs-up"></span> 下载管理</a></li>
          <li><a href="./login.php?logout"><span class="glyphicon glyphicon-log-out"></span> 退出登陆</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav><!-- /.navbar -->
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<?php
if(isset($_GET['qq'])) {
$qq=daddslashes($_GET['qq']);
$row=$DB->get_row("SELECT * FROM auth_site WHERE uid='{$qq}' and daili='{$daili_id}' order by id desc limit 1");
if($row=='')exit("<script language='javascript'>alert('授权平台不存在该QQ！');history.go(-1);</script>");
if($row['active']==0)exit("<script language='javascript'>alert('此QQ的授权已被封禁！');history.go(-1);</script>");
$authcode=$row['authcode'];
$sign=$row['sign'];
?>
      <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">下载管理</h3></div>
          <ul class="list-group">
            <li class="list-group-item"><span class="glyphicon glyphicon-stats"></span> <b>授权ＱＱ：</b> <?=$qq?>&nbsp;<a href="tencent://message/?uin=<?=$qq?>&amp;Site=授权平台&amp;Menu=yes"><img src="http://wpa.qq.com/pa?p=1:<?=$qq?>:1" border=0></a></li>
            <li class="list-group-item"><span class="glyphicon glyphicon-time"></span> <b>授权代码：</b> <?=$authcode?></li>
            <li class="list-group-item"><span class="glyphicon glyphicon-tint"></span> <b>特征代码：</b> <?=$sign?></li>
            <li class="list-group-item"><span class="glyphicon glyphicon-list"></span> <b>下载类型：</b> 
              <a href="download.php?my=installer&authcode=<?=$authcode?>&sign=<?=$sign?>&r=<?=time()?>" class="btn btn-xs btn-success">完整安装包</a>&nbsp;
              <a href="download.php?my=updater&authcode=<?=$authcode?>&sign=<?=$sign?>&r=<?=time()?>" class="btn btn-xs btn-primary">更新包</a>
            </li>
          </ul>
		  <div class="panel-footer">
          <span class="glyphicon glyphicon-info-sign"></span> 新购用户请下载完整安装包！
        </div>
      </div>
<?php }else{?>
      <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">下载管理</h3></div>
        <div class="panel-body">
          <form action="./downfile.php" method="GET" class="form-horizontal" role="form">
            <div class="input-group">
              <span class="input-group-addon">ＱＱ</span>
              <input type="text" name="qq" value="<?=@$_GET['qq']?>" class="form-control" placeholder="购买授权的QQ" autocomplete="off" autofocus="autofocus" required/>
            </div><br/>
            <div class="form-group">
              <div class="col-sm-12"><input type="submit" value="获取下载地址" class="btn btn-primary form-control"/></div>
            </div>
          </form>
        </div>
      </div>
<?php }?>

    </div>
  </div>