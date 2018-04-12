<?php
defined('PHP168_PATH') or die();
$step = empty($_GET['step'])? 0 : intval($_GET['step']);

function _poster($hash,$num = 0){
	global $this_url, $P8LANG;
	$form = <<<EOT
{$P8LANG['uc']['traning']} $num
<form action="$this_url" method="get" id="form">
<input type="hidden" name="step" value="1"/>
<input type="hidden" name="type" value="uc"/>
<input type="hidden" name="p" value="$num"/>
<input type="hidden" name="hash" value="$hash"/>
</form>
<script type="text/javascript">
setTimeout(function(){ document.getElementById('form').submit(); }, 1);
</script>
EOT;
	message($form);
}
if(!$step){
	$hash = unique_id(16);
	$config = $_POST['config']['uc'];
	$config['fromto'] = $_POST['fromto'];
	$CACHE->write('core/modules/'. $MODULE, 'transition', $hash, $config, 'serialize');
	_poster($hash);
	exit;
}
$hash = $_GET['hash'];
$config = $CACHE->read('core/modules/'. $MODULE, 'transition', $hash, 'serialize');

$p = empty($_GET['p'])? 0 : intval($_GET['p']);

$conn = mysql_connect($config['db_host'], $config['db_user'], $config['db_password'], true) or die('can not connect');
mysql_select_db($config['db_name'], $conn);
mysql_query("SET NAMES '$config[db_charset]';");

$uc_member = $config['db_table_prefix'].'members';

$offect = $p;
$limit = 1000;
if($config['fromto']==1){
	if($p==0)
		mysql_query("TRUNCATE TABLE $uc_member");
	
	$SQL = "SELECT * FROM {$core->TABLE_}member LIMIT $offect,$limit";
	
	$query = $core->DB_slave->fetch_all($SQL);
	
	$insert = "INSERT INTO $uc_member (uid,username,password,email,regip,regdate,salt) VALUES";
	$count = 0;
	foreach($query as $key => $detail){
		$insertSql = "$insert ('$detail[id]','$detail[username]','$detail[password]','$detail[email]','$detail[register_ip]','$detail[register_time]','$detail[salt]')";
		mysql_query($insertSql);
		$count++;
	}
	
	if($count<$limit)
		message('done',$this_router.'-integrate');
	else{
		_poster($hash,$p+$limit);
		exit;
	}	

}elseif($config['fromto']==2){
	$role_id = $core->CONFIG['member_role'];
	$role_gid = $core->CONFIG['person_role_group'];
	if($offect==0)$offect=1;
	$sql = "SELECT uid,username,password, email, regip, regdate, salt FROM $uc_member LIMIT $offect,$limit";
	$result = mysql_query($sql);
	$insert = "INSERT INTO {$core->TABLE_}member (`id`,`username`,`password`,`email`,`register_ip`,`register_time`,`salt`,`memo`,`homepage`, `role_id`, `role_gid`) VALUES";
	$count = 0;
	while($row = mysql_fetch_array($result)){

		$insertSql = "$insert ('".addslashes($row['uid'])."','".addslashes($row['username'])."','".addslashes($row['password'])."','".addslashes($row['email'])."','".addslashes($row['regip'])."','".addslashes($row['regdate'])."','".addslashes($row['salt'])."','','','$role_id','$role_gid')";
		$core->DB_slave->query($insertSql);
		$core->DB_slave->query("INSERT INTO {$core->TABLE_}role_group_{$role_gid}_data VALUES({$row['uid']})");
		$count++;
	}
	if($count<$limit)
		message('done',$this_router.'-integrate');
	else{
		_poster($hash,$p+$limit);
		exit;
	}	
}






