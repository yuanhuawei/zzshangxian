<?php
defined('PHP168_PATH') or die();

class P8_46 extends P8_Module{

var $table;
var $buy_table;
var $click_log_table;
var $types;
var $expense_types;

function __construct(&$system, $name){
	
	$this->system = &$system;
	$this->configurable = false;
	//不可配置
	parent::__construct($name);
	$this->table = $this->TABLE_;
	$this->buy_table = $this->TABLE_ .'buy';
	$this->click_log_table = $this->TABLE_ .'click_log';
	
	$this->types = array(
		'text'		=> 'ad_type_text',
		'image'		=> 'ad_type_image',
		'flash'		=> 'ad_type_flash',
		'scroll'	=> 'ad_type_scroll',
		'effect'	=> 'ad_type_effect',
		'diy'		=> 'ad_type_diy',
		'fly'		=> 'ad_type_fly',
		'windows'	=> 'ad_type_windows',
	);
	
	$this->expense_types = array(
		'none'	=> 'ad_expense_none',
		'click'	=> 'ad_expense_click',
		'day'	=> 'ad_expense_day',
	);
}

function P8_46(&$system, $name){
	$this->__construct($system, $name);
}

/**
* 取得一条广告
**/
function get($id, $cache = true){
	if($cache){
		$ret = $this->core->CACHE->read('core/modules', $this->name, (int)$id);
	}
	
	if(empty($ret)){
		$ret = $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE id = '$id'");
		
		$query = $this->DB_master->query("SELECT uid, postfix FROM $this->buy_table WHERE aid = '$id' AND showing = '1' AND verified = '1'
			GROUP BY postfix");
		
		while($arr = $this->DB_master->fetch_array($query)){
			$ret['uid'][$arr['postfix']] = $arr['uid'];
		}
		
		$this->core->CACHE->write('core/modules', $this->name, (int)$id, $ret);
	}
	
	return $ret;
}

function get_buy($id){
	
	if($ret = $this->DB_slave->fetch_one("SELECT * FROM $this->buy_table WHERE id = '$id'")){
		$ret['data'] = attachment_url(unserialize($ret['data']));
	}
	
	return $ret;
}

/**
* 添加广告
**/
function add(&$data){
	
	$data['timestamp'] = P8_TIME;
	
	if(
		$id = $this->DB_master->insert(
			$this->table,
			$data,
			array('return_id' => true)
		)
	){
		//$this->js($id, '');
	}
	
	return $id;
}

/**
* 修改广告
**/
function update($id, &$data){
	
	if(
		$status = $this->DB_master->update(
			$this->table,
			$data,
			"id = '$id'"
		)
	){
		//$this->js($id, '');
	}
	
	return $status;
}

/**
* 删除广告
**/
function delete($data){
	
	$query = $this->DB_master->query("SELECT id FROM $this->table WHERE $data[where]");
	$ids = $comma = '';
	while($arr = $this->DB_master->fetch_array($query)){
		$ids .= $comma . $arr['id'];
		$comma = ',';
		
		$this->core->CACHE->delete('core/modules', $this->name, (int)$arr['id']);
	}
	
	if(
		$ids && $this->DB_master->delete(
			$this->table,
			"id IN ($ids)"
		)
	){
		
		$this->delete_buy(array(
			'where' => "aid IN ($ids)"
		));
		
		//删除挂钩模块数据
		$this->delete_hook_module_item($ids);
		
		return true;
	}
	
	return false;
}

/**
* 删除投放投放记录
**/
function delete_buy($data){
	//购买记录
	
	$query = $this->DB_master->query("SELECT id, aid, postfix FROM $this->buy_table WHERE $data[where]");
	$ids = $comma = '';
	$count = array();
	while($arr = $this->DB_master->fetch_array($query)){
		$ids .= $comma . $arr['id'];
		$comma = ',';
		
		$count[$arr['aid']] = isset($count[$arr['aid']]) ? $count[$arr['aid']] +1 : 1;
		
		rm($this->path .'js/'. $this->js_file($arr['aid'], $arr['postfix']));
	}
	
	if(
		$ids && $this->DB_master->delete(
			$this->buy_table,
			"id IN ($ids)"
		)
	){
		$this->DB_master->delete(
			$this->click_log_table,
			"bid IN ($ids)"
		);
		
		//减少投放次数
		foreach($count['aid'] as $aid => $count){
			$this->DB_master->update(
				$this->table,
				array('buy_count' => 'buy_count -'. $count),
				"id = '$aid'",
				false
			);
		}
		
		return true;
	}
	
	return false;
}

/**
* 投放广告
**/
function add_buy(&$data){
	
	$data['data'] = $this->DB_master->escape_string(serialize(attachment_url($data['data'], true)));
	$data['timestamp'] = P8_TIME;
	
	$attachment_hash = $data['attachment_hash'];
	unset($data['attachment_hash']);
	
	if(
		$id = $this->DB_master->insert(
			$this->buy_table,
			$data,
			array('return_id' => true)
		)
	){
		
		uploaded_attachments($this, $data['aid'], $attachment_hash);
		
		$this->DB_master->update(
			$this->table,
			array('buy_count' => 'buy_count +1'),
			"id = $data[aid]",
			false
		);
		
		$this->js($id, $data['postfix']);
	}
	
	return $id;
}

/**
* 修改投放
**/
function update_buy(&$data){
	
	//不允许修改广告ID
	$aid = $data['aid'];
	unset($data['aid']);
	
	$attachment_hash = $data['attachment_hash'];
	unset($data['attachment_hash']);
	
	$data['data'] = $this->DB_master->escape_string(serialize(attachment_url($data['data'], true)));
	
	if(
		$status = $this->DB_master->update(
			$this->buy_table,
			$data,
			"id = '$data[id]'"
		)
	){
		uploaded_attachments($this, $aid, $attachment_hash);
		
		$this->js($aid, $data['postfix']);
	}
	
	return $status;
}

/**
* JS文件的前缀
**/
function js_file($id, $postfix = ''){
	$file = intval($id / 50) .'/'. $id .($postfix ? '@'. $postfix : '');
	
	return $file;
}

/**
* 生成广告JS缓存
* @param int $id 广告ID
* @param string $postfix 广告投放的后缀
**/
function js($id = 0, $postfix = ''){
	
	static $_cache;
	
	if(!isset($_cache[$id])){
		$_cache[$id] = $this->DB_master->fetch_one("SELECT * FROM $this->table AS a WHERE id = '$id'");
		
		if(empty($_cache[$id])){
			return '';
		}
		
		//已经过期的
		$this->DB_master->update(
			$this->buy_table,
			array('showing' => 0),
			"aid = '$id' AND expire < ". P8_TIME ." AND expire != 0"
		);
		
		//统计所有投放后缀的用户ID
		$query = $this->DB_master->query("SELECT uid, postfix FROM $this->buy_table WHERE aid = '$id' AND showing = '1' AND verified = '1'
			GROUP BY postfix");
		
		while($arr = $this->DB_master->fetch_array($query)){
			$_cache[$id]['uid'][$arr['postfix']] = $arr['uid'];
		}
		
		$this->core->CACHE->write('core/modules', $this->name, (int)$id, $_cache[$id]);
		
	}
	
	$ad = $_cache[$id];
	
	$content = '';
	
	$_query = $this->DB_master->query("SELECT * FROM $this->buy_table
		WHERE aid = '$ad[id]' AND showing = '1' AND verified = '1'
		AND postfix = '$postfix' AND (expire = '0' OR expire > '". P8_TIME ."')
		ORDER BY display_order ASC, timestamp ASC LIMIT $ad[show_count]");
	
	$i = 0;
	$medias = $expire = array();
	while($arr = $this->DB_master->fetch_array($_query)){
		/*$this->DB_master->update(
			$this->buy_table,
			array('showing' => 1),
			"id = '$arr[id]'"
		);*/
		
		$arr['data'] = attachment_url(unserialize($arr['data']));
		$arr['type'] = $ad['type'];
		$arr['expense_type'] = $ad['expense_type'];
		$arr['link_type'] = $ad['link_type'];
		$arr['template'] = $ad['template'];
		$arr['width'] = $ad['width'];
		$arr['height'] = $ad['height'];
		
		$arr['data']['id'] = $arr['id'];
		
		$medias[] = $arr['data'];
		$expire[] = $arr['expire'];
		
		$data = $arr;
		
		$i++;
	}
	
	if($i){
		if($ad['type'] == 'effect'){
			$data['medias'] = $medias;
			$data['expire'] = $expire;
		}
		
		$content = $this->to_js($data);
	}else{
		//没有投放记录就删除缓存
		rm($this->path .'js/'. $this->js_file($id, $postfix) .'.js.php');
		rm($this->path .'js/'. $this->js_file($id, $postfix) .'.php');
	}
	
	return $content;
}

/**
* 写JS文件
* @param array $data 数据
* @return array 
**/
function to_js(&$data){
	
	$id = $data['aid'];
	
	$ret = $this->format($data);
	
	$now = P8_TIME;
	
	$http_304 = <<<EOT
if(!empty(\$_SERVER['HTTP_IF_NONE_MATCH']) && \$_SERVER['HTTP_IF_NONE_MATCH'] == $now){
	//not modified 304
	header('Etag: '. $now, true, 304);
	exit;
}
\$gmt = gmdate('D, d M Y H:i:s', $now) .' GMT';
//header('Last Modified: '. \$gmt);
//header('Expires: '. \$gmt);
header('Etag: '. $now);
//exit;
EOT;
	
	if(empty($data['expire'])){
		$check = $http_304;
	}else{
		if(is_array($data['expire'])){
			//同时显示多个广告的,检查每个广告的过期时间
			$s = 'false';
			foreach($data['expire'] as $v){
				if(!empty($v)){
					$s .= ' || ' . $v .' < $_46_[\'time\']';
				}
			}
			
			$expire = $s;
		}else{
			$expire = $data['expire'] .' < $_46_[\'time\']';
		}
		
		
		
		$check = <<<EOT
\$_46_['time'] = time();
if($expire){
	\$_46_['expire'] = true;
	//refresh
	\$_REQUEST['_no_session'] = true;
	require_once dirname(__FILE__) .'/../../../../inc/init.php';
	\$_46_module = \$core->load_module('{$this->name}');
	\$_46_['ret'] = \$_46_module->js(\$_46_['id'], \$_46_['postfix']);
	\$_46_['js_content'] = \$_46_['ret']['js_content'];
	\$_46_['js'] = \$_46_['ret']['js'];
	
	ob_start();
}else{
	$http_304
}
EOT;
		
	}
	
	$head = <<<EOT
<?php
error_reporting(0);
\$_46_ = array(
	'expire' => false,
	'id' => $id,
	'charset' => '{$this->core->CONFIG['page_charset']}',
	'postfix' => '$data[postfix]',
);

$check
?>

EOT;

	
	$js = <<<EOT
<?php
\$_46_['js_content'] = '$ret[js_content]';

\$_46_['js'] = '$ret[js]';

if(isset(\$_GET['charset']) && \$_GET['charset'] != \$charset){
	header('Content-type: text/javascript; charset='. \$_GET['charset']);
	\$convert = true;
}else{
	header('Content-type: text/javascript; charset={$this->core->CONFIG['page_charset']}');
}

if(!isset(\$js_php)) echo 'document.write(\''. \$_46_['js_content'] .'\');'. \$_46_['js'];
?>
EOT;
	
	$content = <<<EOT
<?php
header('Content-type: text/html; charset={$this->core->CONFIG['page_charset']}');
?>
$ret[content]
<?php
if(\$_46_['expire']){
	ob_end_clean();
	echo \$_46_['ret']['content'];
}
?>
EOT;
	
	$file = $this->path .'js/'. $this->js_file($data['aid'], $data['postfix']);
	
	md(dirname($file));
	
	write_file($file .'.js.php', $head . $js);
	write_file($file .'.php', $head . $content);
	
	return $ret;
}

/**
* 格式化要输出的广告内容
* @param array $data 数据
**/
function format(&$data, $js = true){
	
	$content = '';
	
	$core = &$this->core;
	
	global $SKIN, $P8LANG, $RESOURCE;
	
	$timestamp = P8_TIME;
	
	$ret = array(
		'content' => '',
		'js_content' => '',
		'js' => ''
	);
	
	switch($data['type']){
	
	case 'text':
		$url = $data['link_type'] == 1 ? 
			$data['data']['url'] :
			$this->controller .'-jump?id='. $data['aid'] . '&bid='. $data['id'] .
			'&postfix='. $data['postfix'] .'&url='. urlencode($data['data']['url']);
		
		$ret['content'] = $ret['js_content'] = '<a href="'. $url .'" target="_blank">'. $data['data']['name'] .'</a>';
	break;
	
	case 'image':
		$url = $data['link_type'] == 1 ? 
			$data['data']['url'] :
			$this->controller .'-jump?id='. $data['aid'] . '&bid='. $data['id'] .
			'&postfix='. $data['postfix'] .'&url='. urlencode($data['data']['url']);
		
		$ret['content'] = $ret['js_content'] = '<a href="'. $url .'" target="_blank"><img width="'. $data['width'] .'" height="'. $data['height'] .'" src="'. $data['data']['media'] .'" title="'. $data['data']['name'] .'" border="0" /></a>';
	break;
	
	case 'flash':
		$url = $data['link_type'] == 1 ? 
			$data['data']['url'] :
			$this->controller .'-jump?id='. $data['aid'] . '&bid='. $data['id'] .
			'&postfix='. $data['postfix'] .'&url='. urlencode($data['data']['url']);
		
		$ret['content'] = $ret['js_content'] = 
		'<span style="width: '. $data['width'] .'px; height: '. $data['height'] .'px; overflow: hidden; display: inline-block;">
		<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="100%" height="100%">
			<param name="allowScriptAccess" value="sameDomain" />
			<param name="movie" value="'. $this->url .'/clicker.swf" />
			<param name="quality" value="high" />
			<param name="scale" value="noscale" />
			<param name="salign" value="lt" />
			<param name="FlashVars" value="v_swf='. $data['data']['media'] .'&v_url='. urlencode($url) .'">
			<param name="wmode" value="transparent" />
			<embed src="'. $this->url .'/clicker.swf" wmode="transparent" quality="high" scale="noscale" salign="lt" width="100%" height="100%" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" FlashVars="v_swf='. $data['data']['media'] .'&v_url='. urlencode($url) .'" />
		</object>
		</span>';
	break;
	
	case 'scroll':
	case 'windows':
		$url = $data['link_type'] == 1 ? 
			$data['data']['url'] :
			$this->controller .'-jump?id='. $data['aid'] . '&bid='. $data['id'] .
				'&postfix='. $data['postfix'] .'&url='. urlencode($data['data']['url']);
		
		global $TEMP_OBJ;
		
		ob_start();
		include template($TEMP_OBJ, $this->name .'/'. $data['template'], 'label');
		$ret['content'] = ob_get_clean();
	break;
	
	case 'effect':
		$url_prefix = $data['link_type'] == 1 ? 
			'' :
			$this->controller .'-jump?id='. $data['aid'] .
				'&postfix='. $data['postfix'] .'&url=';
		
		$list = array();
		foreach($data['medias'] as $k => $v){
			$list[] = array(
				'media' => $v['media'],
				'thumb' => $v['thumb'],
				'name' => $v['name'],
				'url' => $data['link_type'] == 1 ?
					$v['url'] :
					$url_prefix . urlencode($v['url']) . '&bid='. $v['id'],
			);
		}
		
		global $TEMP_OBJ;
		
		ob_start();
		include template($TEMP_OBJ, $this->name .'/'. $data['template'], 'label');
		$ret['content'] = ob_get_clean();
	break;
	
	case 'diy':
		$ret['content'] = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><body>'. $data['data']['diy'] .'</body></html>';
	break;
	case 'fly':
		$url = $data['link_type'] == 1 ? 
			$data['data']['url'] :
			$this->controller .'-jump?id='. $data['aid'] . '&bid='. $data['id'] .
			'&postfix='. $data['postfix'] .'&url='. urlencode($data['data']['url']);
		$ret['content'] = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<div id="flying" style="width:{$data['width']}px;height:{$data['height']}px;position: absolute;overflow:hidden;z-index:9999">
<a href="$url" target="_blank"><img width="{$data['width']}" height="{$data['height']}" src="{$data['data']['media']}" title="{$data['data']['name']}" border="0" /></a>
<span style="top:2px;right:2px;cursor:pointer;position: absolute;width: 18px; height: 18px; background: url($RESOURCE/images/close.gif) no-repeat 0 -18px;" onclick="$('#flying').hide();"></span>
</div>
<script type="text/javascript">
(function(){
	var height = $(window).height(); 
	var width = $(window).width();
	var Hoffset = $('#flying').height(); 
	var Woffset = $('#flying').width(); 
	var xPos = (width-Woffset)/2; 
	var yPos = (height-Hoffset)/2; 
	var step = 1; 
	var delay = 30;
	var yon = 0;
	var xon = 0;
	var pause = true; 
	var interval; 
	var interval = setInterval(changePos, delay);
	$('#flying').hover(function(){ clearInterval(interval); },function(){ interval = setInterval(changePos, delay);});
	function changePos() {
		$('#flying').css({left:xPos+$(window).scrollLeft(),top:yPos+$(window).scrollTop()});																																																								
		if (yon) {yPos = yPos + step; } 
		else {yPos = yPos - step; } 
		if (yPos < 0) { yon = 1;yPos = 0; } 
		if (yPos >= (height - Hoffset)) { yon = 0;yPos = (height - Hoffset);}																																																																	
		if (xon) {xPos = xPos + step; } 
		else {xPos = xPos - step; } 
		if (xPos < 0) { xon = 1;xPos = 0; } 
		if (xPos >= (width - Woffset-20)) { xon = 0;xPos = (width - Woffset-20); }
	}
})()
</script>
</body></html>
EOT;
	break;
	
	}
	
	if(preg_match('#<body[^>]*>(.*)</body>#is', $ret['content'], $m)){
		$ret['js_content'] = $m[1];
		
		if(preg_match_all('#(<script[^>]*>)(.*?)</script>#is', $ret['js_content'], $mm)){
			$ret['js_content'] = preg_replace('#<script[^>]*>(.*)</script>#is', '', $ret['js_content']);
			
			foreach($mm[2] as $k => $v){
				if(preg_match('/\s+src=[\'"]?([^\'"?\s]+)[\'"]?/', $mm[1][$k], $mmm)){
					$ret['js'] .= "\r\n". 'document.write(\'<scr\' + \'ipt type="text/javascript" src="'. $mmm[1] .'"></scr\' + \'ipt>\');'. "\r\n";
				}else{
					$ret['js'] .= $v;
					
				}
			}
			//if($data['type'] == 'diy'){print_r($ret['js']);exit;}
			$ret['js'] = str_replace(array('\\', '\''), array('\\\\', '\\\''), $ret['js']);
		}
		
	}
	
	$ret['js_content'] = str_replace(array("\r", "\n", '\\', '\''), array('', '', '\\\\', '\\\''), $ret['js_content']);
	//slashes twice
	$ret['js_content'] = str_replace(array('\\', '\''), array('\\\\', '\\\''), $ret['js_content']);
	
	return $ret;
}

/**
* 点击日志,重复IP无效
* @param int $id
* @return bool
**/
function click_log($bid, $ip_check = false){
	
	$check = true;
	if($ip_check){
		$check = $this->DB_slave->fetch_one("SELECT ip FROM $this->click_log_table WHERE bid = '$bid' AND ip = '". P8_IP ."'");
		if(empty($check['ip'])){
			$check = true;
		}else{
			$check = false;
		}
	}
	
	if($check){
		$this->DB_master->insert(
			$this->click_log_table,
			array(
				'bid' => $bid,
				'ip' => P8_IP,
				'timestamp' => P8_TIME,
				'referer' => html_entities(HTTP_REFERER)
			)
		);
	}
	
	return $check;
}

}