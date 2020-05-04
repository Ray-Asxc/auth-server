<?php
//error_reporting(E_ALL); ini_set("display_errors", 1);
error_reporting(0);
define('IN_CRONLITE', true);
define('SYSTEM_ROOT', dirname(__FILE__).'/');
define('ROOT', dirname(SYSTEM_ROOT).'/');
define('SYS_KEY', 'authentication');

date_default_timezone_set("PRC");
$date = date("Y-m-d H:i:s");
session_start();

if(is_file(SYSTEM_ROOT.'360safe/360webscan.php')){//360网站卫士
    require_once(SYSTEM_ROOT.'360safe/360webscan.php');
}

$scriptpath=str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$sitepath.'/';

require SYSTEM_ROOT.'config.php';

//连接数据库
include_once(SYSTEM_ROOT."db.class.php");
$DB=new DB($dbconfig['host'],$dbconfig['user'],$dbconfig['pwd'],$dbconfig['dbname'],$dbconfig['port']);

$password_hash='!@#%!s!';
include SYSTEM_ROOT."function.php";
include SYSTEM_ROOT."member.php";

?>
