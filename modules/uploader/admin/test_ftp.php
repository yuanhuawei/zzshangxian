<?php
//$this_controller->check_admin_action('test_ftp') or message('no_privilege');

if(REQUEST_METHOD == 'POST'){

define('NO_ADMIN_LOG', true);

$host = isset($_POST['host']) ? $_POST['host'] : '';
$port = isset($_POST['port']) ? $_POST['port'] : 21;
$user = isset($_POST['user']) ? $_POST['user'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$dir = isset($_POST['dir']) ? $_POST['dir'] : '';
$timeout = isset($_POST['timeout']) ? $_POST['timeout'] : 0;
$ssl = isset($_POST['ssl']) ? $_POST['ssl'] : false;

require_once PHP168_PATH .'inc/ftp.class.php';

$ftp = new P8_Ftp(
	$host,
	$port,
	$user,
	$password,
	$dir,
	$timeout,
	$ssl
);

$connect = $ftp->connect();

$mkdir = $ftp->mkdir($dir .'__test/');

$put = $ftp->put($this_module->path .'index.html', $dir .'__test/__test.html');

$delete = $ftp->delete($dir .'__test/__test.html');

$rmdir = $ftp->rmdir($dir .'__test/');

header('Content-type: text/json; charset=utf-8');
echo <<<EOT
{"connect":"$connect","mkdir":"$mkdir","put":"$put","delete":"$delete","rmdir":"$rmdir"}
EOT;
exit;

}
exit;