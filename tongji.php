<?php
include("./includes/common.php");

if(!$_GET['url']){exit();}
$url=str_ireplace("install/index.php","",daddslashes($_GET['url']));

$referer = parse_url($url);
$rehost=$referer['host'];

$row=$DB->get_row("SELECT * FROM auth_site WHERE url='$rehost' limit 1");
if ($row['active']==1) {
} else {
	$DB->query("insert into `auth_block` (`url`,`date`,`authcode`) values ('".$rehost."','".$date."','mzrz')");
}
$DB->close();

header('HTTP/1.0 404 Not Found');
?>