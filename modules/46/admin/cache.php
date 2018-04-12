<?php
defined('PHP168_PATH') or die();

/**
* 广告缓存
*/

$this_controller->check_admin_action('ad') or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	//confirm
	
	$form = <<<EOT
<form id="form" method="post" action="$this_url">
<input type="hidden" name="_referer" value="$HTTP_REFERER" />
</form>

<script type="text/javascript">
if(confirm('$P8LANG[confirm_to_do]')){
	document.getElementById('form').submit();
}else{
	window.location.href = '$HTTP_REFERER';
}
</script>
EOT;
	
	message($form);
	
}else if(REQUEST_METHOD == 'POST'){
	
	function _poster($msg = ''){
		global $this_url;
		
		$fields = '';
		foreach($_POST as $k => $v){
			$fields .= '<input type="hidden" name="'. $k .'" value="'. $v .'" />';
		}
		
		$form = <<<EOT
$msg
<form action="$this_url" method="post" id="form">
$fields
</form>
<script type="text/javascript">
setTimeout(function(){ document.getElementById('form').submit(); }, 1);
</script>
EOT;
		message($form);
	}
	
	$where = ' WHERE 1 ';
	$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	
	if(empty($_POST['start'])){
		
		$_POST['start'] = 1;
		$_POST['offset'] = 0;
		$_POST['per'] = 5;
		
		
		if($id){
			$where .= ' AND id IN('. implode(',', $id) .')';
		}
		
		
		//删除所有旧缓存
		rm($this_module->path .'js/', true);
		
		$_POST['_referer'] = $HTTP_REFERER;
		
		$count = $DB_master->fetch_one("SELECT COUNT(*) AS `count` FROM $this_module->table $where");
		$_POST['count'] = $count['count'];
		
		_poster($P8LANG['ad_cache_init']);
	}
	
	if(!empty($_POST['done'])){
		
		//跳回总缓存
		!empty($_POST['_all_cache_']) && message($BACKTO_ALL_CACHE);
		
		message('done', $this_router .'-list');
	}
	
	//log once
	define('NO_ADMIN_LOG', true);
	
	$per = 5;
	
	$offset = $per * intval($_POST['offset']);
	
	$query = $DB_master->query("SELECT * FROM $this_module->table $where LIMIT $offset,$per");
	
	$i = 0;
	while($arr = $DB_master->fetch_array($query)){
		
		$this_module->js($arr['id'], '');
		
		//取得所有投放广告的后缀
		$_query = $DB_master->query("SELECT aid, postfix FROM $this_module->buy_table
			WHERE aid = '$arr[id]' AND showing = '1' AND verified = '1' AND postfix != '' GROUP BY postfix
			LIMIT $offset,$per");
		
		//生成缓存
		$j = 0;
		while($_arr = $DB_master->fetch_array($_query)){
			
			$this_module->js($_arr['aid'], $_arr['postfix']);
			$j++;
		}
		
		$i++;
	}
	
	if(!$i){
		//if no result, done
		$_POST['done'] = 1;
		
		_poster();
	}
	
	//next
	$_POST['offset']++;
	
	_poster(p8lang($P8LANG['ad_cache_process'], $offset, $_POST['count']));
	
}