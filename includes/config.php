<?php
/*数据库配置*/
$dbconfig=array(
	'host' => '127.0.0.1', //数据库服务器
	'port' => 3306, //数据库端口
	'user' => 'root', //数据库用户名
	'pwd' => 'root', //数据库密码
	'dbname' => 'auth' //数据库名
);

/*目录配置*/
define("CACHE_DIR",'cache'); //下载缓存目录
define("PACKAGE_DIR",'package'); //程序安装包目录

/*系统设置*/
$conf=array(
	'switch' => 1, //是否开启验证授权
	'ipauth' => 0, //是否同时验证IP
	'update' => 1, //是否开启更新
	'addblock' => 1, //是否记录未授权域名
	'authfile' => 'includes/authcode.php', //授权码文件路径
	'installer_name' => 'release_'.rand(111111,999999), //安装包下载文件名
	'updater_name' => 'update_'.rand(111111,999999), //更新包下载文件名
	'qq' => '1277180438', //站长QQ
	'version' => '1001', //最新版本号（更新判断用）
	'ver' => 'V1.0.1', //最新版本号（显示用）
	'content' => '您的网站未授权！购买正版请联系QQ：1277180438', //未授权显示内容
	'uplog' => '
此处显示更新记录。<br/>
',
);
?>