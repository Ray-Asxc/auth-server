<?php
$mod='blank';
include("./includes/common.php");
$get_token=isset($_SESSION['get_token'])?$_SESSION['get_token']:exit;
$uin=daddslashes($_GET['qq']);

if(!$get_token || !$uin){exit();}

$tokenid=base64_encode(md5($uin.md5($uin.'*$$*').'23132'.md5(date("Y-m-d-H"))));

if($tokenid!=$get_token)exit("<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
<script language='javascript'>alert('验证信息已过期，请返回重新扫码验证。');history.go(-1);</script>");

$row=$DB->get_row("SELECT * FROM auth_site WHERE uid='$uin' limit 1");
$authcode=$row['authcode'];
$sign=$row['sign'];
if(!$authcode || !$sign){exit();}

require_once(SYSTEM_ROOT.'pclzip.php');
$file_real=substr($authcode,0,16).'.zip';
$file=CACHE_DIR."/{$file_real}";

if($_GET['my']=='installer') {
$file_path=ROOT.PACKAGE_DIR.'/release6000/';

$file_str=file_get_contents(ROOT.PACKAGE_DIR.'/authcode.php');
$file_str=str_replace('1000000001',$authcode,$file_str);
file_put_contents($file_path.$conf['authfile'],$file_str);

$file_name=$conf['installer_name'].'.zip';

$DB->query("insert into `auth_down` (`type`,`authcode`,`sign`,`date`,`ip`) values ('扫码获取|安装包','".$authcode."','".$sign."','".$date."','".$clientip."')");

}elseif($_GET['my']=='updater') {
$file_path=ROOT.PACKAGE_DIR.'/update6000/';

$file_str=file_get_contents(ROOT.PACKAGE_DIR.'/authcode.php');
$file_str=str_replace('1000000001',$authcode,$file_str);
file_put_contents($file_path.$conf['authfile'],$file_str);

$file_name=$conf['updater_name'].'.zip';

$DB->query("insert into `auth_down` (`type`,`authcode`,`sign`,`date`,`ip`) values ('扫码获取|更新包','".$authcode."','".$sign."','".$date."','".$clientip."')");
}

if(file_exists($file))unlink($file);
$zip = new PclZip($file);
$v_list = $zip->create($file_path ,PCLZIP_OPT_REMOVE_PATH,$file_path);

$file_size=filesize("$file");
header("Content-Description: File Transfer");
header("Content-Type:application/force-download");
header("Content-Length: {$file_size}");
header("Content-Disposition:attachment; filename={$file_name}");
readfile("$file");
?>