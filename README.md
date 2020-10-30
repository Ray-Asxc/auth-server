# auth-server
v1.0
使用方法：修改config.php里的数据库信息，导入install.sql到数据库
然后在数据库的auth_user表内添加授权平台管理员用户
源码就放到package/里面的这两个文件夹分别是安装包和更新包


你可以修改download里面的源码


自定义授权  II  自己不会用没办法，不提供技术支持。

<h4>if(!isset($_SESSION['authcode'])) {
	$query=file_get_contents('http://你的域名/check.php?url='.$_SERVER['HTTP_HOST'].'&authcode='.$authcode);
	if($query=json_decode($query,true)) {
		if($query['code']==1)$_SESSION['authcode']=$authcode;
		else exit('<h3>'.$query['msg'].'</h3>');
	}
}
</h4>


把这串代码放到源码全局的PHP文件即可

压缩包缓存目录：/cache
源码存放目录：/package
