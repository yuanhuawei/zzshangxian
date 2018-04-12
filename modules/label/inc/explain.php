<?php
defined('PHP168_PATH') or die();

/**
* 解析SQL并返回结果
**/

if(REQUEST_METHOD == 'POST'){
	
	define('NO_ADMIN_LOG', true);
	
	if(isset($select) && is_object($select)){
		$SQL = $select->build_sql();
	}
	echo $SQL;
	
	$query = $DB_slave->query('EXPLAIN '. $SQL);
	
	$s = <<<EOT
<table width="100%" border="1">
<tr>
	<td>{$P8LANG['table']}</td>
	<td>{$P8LANG['type']}</td>
	<td>{$P8LANG['explain_sql_possible_key']}</td>
	<td>{$P8LANG['explain_sql_key']}</td>
	<td>{$P8LANG['explain_sql_ref']}</td>
	<td>{$P8LANG['explain_sql_rows']}</td>
	<td>{$P8LANG['explain_sql_extra']}</td>
</tr>
EOT;
	
	if($query){
		while($v = $DB_slave->fetch_array($query)){
			$s .= <<<EOT
<tr>
	<td>$v[table]</td>
	<td>$v[type]</td>
	<td>$v[possible_keys]</td>
	<td>$v[key]</td>
	<td>$v[ref]</td>
	<td>$v[rows]</td>
	<td>$v[Extra]</td>
</tr>
EOT;
		}
		
		$s .= '</table><br />'. $P8LANG['explain_sql_note'];
	}
	
	exit($s);
}