<?php
defined('PHP168_PATH') or die();

class P8_Spider extends P8_Module{

var $rule_table;	
var $category_table;	
var $item_table;	
var $item_addon_table;	
var $rules;
var $_rules;
var $categories;
var $_url;
var $_atts;
var $timeout = 0;
var $_diy_rule_info = array('all' => false, 'capture' => false);

function __construct(&$system, $name){
	$this->system = &$system;
	parent::__construct($name);
	
	$this->rule_table = $this->TABLE_ .'rule';
	$this->category_table = $this->TABLE_ .'category';
	$this->item_table = $this->TABLE_ .'item';
	$this->item_addon_table = $this->TABLE_ .'item_addon';
}

function P8_Spider(&$system, $name){
	$this->__construct($system, $name);
}


/**
* 添加规则
**/
function add_rule(&$data){
	
	$data['data'] = $this->DB_master->escape_string(serialize($data['data']));
	
	return $this->DB_master->insert(
		$this->rule_table,
		$data
	);
}

/**
* 修改规则
**/
function update_rule($id, &$data){
	
	$data['data'] = $this->DB_master->escape_string(serialize($data['data']));
	
	$status = $this->DB_master->update(
		$this->rule_table,
		$data,
		"id = '$id'"
	);
	
	$this->get_rule($id, true, true);
}

/**
* 删除规则
**/
function delete_rule($data){
	$query = $this->DB_master->query("SELECT id FROM $this->rule_table WHERE $data[where]");
	
	$ids = $comma = '';
	while($v = $this->DB_master->fetch_array($query)){
		$ids .= $comma . $v['id'];
		$comma = ',';
	}
	
	if($ids && $this->DB_master->delete($this->rule_table, "id IN ($ids)")){
		if(!empty($data['delete_item'])){
			$this->delete_item(array(
				'where' => "rid IN ($ids)"
			));
		}
		
		return true;
	}
	
	return false;
}

/**
* 添加内容, 传入iid视为追加
**/
function add_item(&$data){
	
	if(!empty($data['iid'])){
		//追加
		$tmp = $this->get_item(array('where' => "id = '$data[iid]'"));
		$_data = array_shift($tmp);
		
		if(empty($_data)) return false;
		
		$data['data'] = serialize($data['data']);
		$data = $this->DB_master->escape_string($data);
		
		if($id = $this->DB_master->insert(
			$this->item_addon_table,
			$data,
			array('return_id' => true)
		)){
			//分页数
			$this->DB_master->update(
				$this->item_table,
				array('pages' => 'pages +1'),
				"id = '$data[iid]'",
				false
			);
			
			$_COOKIE[$this->core->CONFIG['cookie']['prefix'] . 'uploaded_attachments']['hash'] = $this->_atts;
			uploaded_attachments($this, $data['iid'], 'hash');
		}
		
		return $id;
	}
	
	//新插入
	$data['data'] = serialize($data['data']);
	$data = $this->DB_master->escape_string($data);
	
	$id = $this->DB_master->insert(
		$this->item_table,
		$data,
		array('return_id' => true)
	);
	
	$_COOKIE[$this->core->CONFIG['cookie']['prefix'] . 'uploaded_attachments']['hash'] = $this->_atts;
	uploaded_attachments($this, $id, 'hash');
	
	return $id;
}

/**
* 删除内容
**/
function delete_item($data){
	$query = $this->DB_master->query("SELECT id FROM $this->item_table WHERE $data[where]");
	
	$ids = $comma = '';
	while($v = $this->DB_master->fetch_array($query)){
		$ids .= $comma . $v['id'];
		$comma = ',';
	}
	
	//追加表
	if($ids && $this->DB_master->delete($this->item_table, "id IN ($ids)")){
		$this->DB_master->delete($this->item_addon_table, "iid IN ($ids)");
		
		if(!empty($data['hook'])){
			$this->delete_hook_module_item($ids);
		}
	}
	
	return true;
}

/**
* 添加分类
**/
function add_category(&$data){
	return $this->DB_master->insert(
		$this->category_table,
		$data
	);
}

/**
* 修改分类
**/
function update_category($id, &$data){
	return $this->DB_master->update(
		$this->category_table,
		$data,
		"id = '$id'"
	);
}

/**
* 删除分类
**/
function delete_category($data){
	$query = $this->DB_master->query("SELECT id FROM $this->category_table WHERE $data[where]");
	
	$ids = $comma = '';
	while($v = $this->DB_master->fetch_array($query)){
		$ids .= $comma . $v['id'];
		$comma = ',';
	}
	
	if($ids && $this->DB_master->delete($this->category_table, "id IN ($ids)")){
		$this->delete_rule(array(
			'where' => "cid IN ($ids)",
			'delete_item' => true
		));
		
		return true;
	}
	
	return false;
}

/**
* 获取缓存
**/
function get_cache(){
	$this->categories = $this->core->CACHE->read('core/modules', $this->name, 'categories');
	if(empty($this->categories)){
		$this->cache_category();
	}
}

/**
* 缓存分类
**/
function cache_category($cache = true){
	
	$query = $this->DB_master->query("SELECT * FROM $this->category_table ORDER BY display_order");
	
	$this->categories = array();
	while($v = $this->DB_master->fetch_array($query)){
		$this->categories[$v['id']] = $v;
	}
	
	if($cache){
		$this->core->CACHE->write('core/modules', $this->name, 'categories', $this->categories);
	}
}

/**
* 获取单条规则
* @param int $id 规则ID
* @param bool $refresh 重新从数据库里读
* @param bool $cache 生成缓存
**/
function get_rule($id, $refresh = false, $cache = false){
	if(!$refresh){
		$ret = $this->core->CACHE->read('core/modules/'. $this->name, 'rule', (int)$id);
	}
	
	if(empty($ret)){
		$ret = $this->DB_master->fetch_one("SELECT * FROM $this->rule_table WHERE id = '$id'");
		$ret['data'] = mb_unserialize($ret['data']);
		
		if($cache){
			unset($ret['captured_items']);
			$_ret = $this->format_rule($ret);
			$this->core->CACHE->write('core/modules/'. $this->name, 'rule', (int)$id, $_ret);
			
			return $_ret;
		}
	}
	
	return $ret;
}

/**
* 格式化规则
**/
function format_rule($rule){
	
	$diy_rule = array();
	foreach($rule['data']['diy_rule'] as $k => $v){
		
		//替换正则
		$replace = explode("\r\n", $v['replace']);
		$replace1 = $replace2 = array();
		foreach($replace as $vv){
			if(!strlen($vv = trim($vv))) continue;
			
			$tmp = explode('<###>', $vv);
			$replace1[] = '#'. $this->format_rule_reg($tmp[0]) .'#is';
			$replace2[] = isset($tmp[1]) ? $tmp[1] : '';
		}
		
		$reg = $this->format_rule_reg($v['reg']);
		
		$diy_rule[$this->_diy_rule_info['name']] = $this->_diy_rule_info + array(
			'reg' => '#'. $reg .'#is',
			'start' => $v['start'],
			'end' => $v['end'],
			'replace1' => $replace1,
			'replace2' => $replace2
		);
		
	}
	$rule['data']['diy_rule'] = $diy_rule;
	
	$rule['data']['list_item'] = '#'. $this->format_rule_reg($rule['data']['list_item']) .'#is';
	$rule['data']['content_page'] = $rule['data']['content_page'] ? '#'. $this->format_rule_reg($rule['data']['content_page']) .'#is' : '';
	
	return $rule;
}

/**
* 格式化规则的正则
**/
function format_rule_reg($str){
	
	$str = preg_replace('/\(([^\.\\\]*?)\*(.*?)\)/is', '(\1.*\2)', $str);
	$str = preg_replace_callback('/\{#(.+?)#([\s\S]+?)\}/', array(&$this, 'rule_parse'), $str);
	$str = str_replace('#', '\\#', $str);
	
	return $str;
}

/**
* 解释规则,preg_replace_calback
**/
function rule_parse($m){
	$tmp = explode('|', $m[1]);
	
	$this->_diy_rule_info = array('name' => $tmp[0], 'all' => false, 'once' => false, 'capture' => false, 'capture_image' => false, 'fix_url' => false, 'forward' => 0);
	if(($len = count($tmp)) > 1){
		for($i = 1; $i < $len; $i++){
			
			$_tmp = explode(':', $tmp[$i]);
			$tmp[$i] = $_tmp[0];
			
			switch($tmp[$i]){
			
			case 'once':
				$this->_diy_rule_info['once'] = true;
			break;
			
			case 'all':
				$this->_diy_rule_info['all'] = true;
			break;
			
			case 'capture':
				$this->_diy_rule_info['capture'] = true;
			break;
			
			case 'capture_image':
				$this->_diy_rule_info['capture_image'] = true;
			break;
			
			case 'fix_url':
				$this->_diy_rule_info['fix_url'] = true;
			break;
			
			case 'forward':
				$this->_diy_rule_info['forward'] = intval(isset($_tmp[1]) ? $_tmp[1] : 1);
			break;
			}
		}
	}
	
	$m[2] = str_replace(array('(.*?)', '(.*)'), array('.*?', '.*'), $m[2]);
	
	return '(?<'. $tmp[0] .'>'. $m[2] .')';
}
































/**
* 请求网页
* @param string $url URL
* @param string $charset 对方的字符,请求后会转化成本地字符
**/
function request($url, $charset){
	$tmp = p8_http_request(array(
		'url' => $url,
		'timeout' => $this->timeout,
		'connection' => 'keep-alive'
	));
	$ret = $tmp['body'];
	
	//转换为本站编码
	if($charset != $this->core->CONFIG['page_charset']) 
		$ret = convert_encode($charset, $this->core->CONFIG['page_charset'], $ret);
	
	return $ret;
}

/**
* 获取列表
* @param array $rule 规则
* @param int $page 页码
**/
function capture_list(&$rule, $page, $test = false){
	$this->timeout = isset($rule['data']['timeout']) ? $rule['data']['timeout'] : 0;
	
	if($rule['data']['zero_fill']){
		//补0
		$page = sprintf('%0'. ($rule['data']['zero_fill'] +1) .'d', $page);
	}
	
	$page = $page == 0 ? max($rule['data']['start'], 0) : $page;
	/* 规则中(*)部分 */
	if($page == 0){
		$url = preg_replace('/\((.*?)\*(.*?)\)/', '', $rule['data']['list_page']);
	}else{
		$url = str_replace('*', $page, preg_replace('/\((.*?)\*(.*?)\)/', '$1*$2', $rule['data']['list_page']));
	}
	
	$ret = array();
	
	$this->_url = $ret['url'] = $url;
	
	$list = $this->request($url, $rule['data']['charset']);
	
	if(!$list) return array();
	
	preg_match('/<base\s+[^\'"]*?href=[\'"]?([^\'"]+)[\'"]?/i', $list, $base);
	
	$ret['items'] = array();
	
	//截取上下文
	if($rule['data']['list_item_start']){
		
		if(($pos1 = strpos($list, $rule['data']['list_item_start'])) === false) return $ret;
		
		$_list = substr($list, $pos1);
		if($rule['data']['list_item_end']){
			if(($pos2 = strpos($_list, $rule['data']['list_item_end'])) === false) return $ret;
			
			$_list = substr($_list, 0, $pos2);
		}
		
		$list = $_list;
		unset($_list);
	}
	
	$abs_url = null;
	$path = '';
	if(preg_match_all($rule['data']['list_item'], $list, $m)){
		
		foreach($m['title'] as $k => $v){
			
			$frame = isset($m['frame'][$k]) ? $this->fix_url(trim($m['frame'][$k]), $url) : '';
			!empty($rule['data']['capture_frame']) && !$test && $frame = $this->capture_attachment($frame);
			
			$ret['items'][$this->fix_url(trim($m['url'][$k]), empty($base[1]) ? $url : $base[1])] = array(
				'title' => trim($m['title'][$k]),
				'frame' => $frame
			);
		}
		
		if(!empty($rule['data']['reverse'])){
			$ret['items'] = array_reverse($ret['items']);
		}
	}
	
	return $ret;
}

/**
* 获取内容页
* @param array $rule 规则
* @param string $url URL
* @param int $page 页码
* @param bool $test 测试采集
* @param int $forward 向前跳转的次数
**/
function capture_item(&$rule, $url, $page = 0, $test = false, $forward = 0){
	
	$this->timeout = isset($rule['data']['timeout']) ? $rule['data']['timeout'] : 0;
	
	$content = $this->request($url, $rule['data']['charset']);
	
	if(!$content) return array();
	
	preg_match('/<base\s+[^\'"]*?href=[\'"]?([^\'"]+)[\'"]?/i', $content, $base);
	$base_url = empty($base[1]) ? $url : $base[1];
	
	$ret = array('_url' => $url, 'pages' => array());
	$this->_url = $url;
	if(!$forward) $this->_atts = '';
	
	//提取内容页的字段信息
	foreach($rule['data']['diy_rule'] as $r){
		//只提取一次的
		if($forward && !$r['forward'] && !empty($r['once'])) continue;
		
		$_content = $content;
		//截取上下文
		if($r['start']){
			if( ($pos1 = strpos($_content, $r['start'])) === false ) continue;
			
			$_content = substr($_content, $pos1);
			if($r['end'] && ($pos2 = strpos($_content, $r['end'])) !== false){
				$_content = substr($_content, 0, $pos2);
			}
		}
		
		if($r['all']){
			if(!preg_match_all($r['reg'], $_content, $m)) continue;
		}else{
			if(!preg_match($r['reg'], $_content, $m)) continue;
		}
		
		foreach($m as $k => $v){
			//非数字捕获的分组即(?<some>)捕获到的组
			if(is_int($k)) continue;
			
			//if(preg_match($r['not']), $v) continue;
			
			$v = $this->fix_link($v, $url, empty($base[1]) ? '' : $base[1]);
			
			//替换
			if($r['replace1']){
				if(is_array($v)){
					foreach($v as $kk => $vv){
						if($r['replace2'] == '[#NOT#]' && preg_match($r['replace1'], $vv)) continue;
						$v[$kk] = preg_replace($r['replace1'], $r['replace2'], $vv);
					}
				}else{
					if($r['replace2'] == '[#NOT#]' && preg_match($r['replace1'], $v)) continue;
					$v = preg_replace($r['replace1'], $r['replace2'], $v);
				}
			}
			
			//修复URL
			if(!empty($r['fix_url'])){
				$v = $this->fix_url($v, $base_url);
			}
			
			//捕抓图片
			if($r['capture_image'] && !$test){
				$v = $this->capture_image($v);
			}
			
			//捕抓附件
			if($r['capture'] && !$test){
				$v = $this->capture_attachment($v);
			}
			
			$ret[$k] = $v;
		}
		
		if($r['name'] == 'pages' && is_string($ret['pages'])){
			$ret['pages'] = $this->fix_url(trim($ret['pages']), $url, $base_url);
		}
		
		//继续向前捕抓,限制次数
		if($r['forward'] && $forward < $r['forward']){
			end($ret);
			$_url = current($ret);
			
			$_url = (array)current($ret);
			foreach($_url as $__url){
				$this->_url = $__url = $this->fix_url($__url, $base_url);
				$_ret = $this->capture_item($rule, $__url, 0, $test, $forward +1);
				if(empty($_ret['pages'])) unset($_ret['pages']);
				
				//递归合并
				$ret = array_merge_recursive($ret, $_ret);
			}
			
			return $ret;
		}
	}
	
	
	//匹配分页,如果没有填写此项,分组中有 pages,即为不断捕获下一页
	if($page == 0 && $rule['data']['content_page']){
		
		if($rule['data']['content_page_start']){
			if(($pos1 = strpos($content, $rule['data']['content_page_start'])) === false) return $ret;
			
			$content = substr($content, $pos1);
			if($rule['data']['content_page_end']){
				if(($pos2 = strpos($content, $rule['data']['content_page_end'])) === false) return $ret;
				
				$content = substr($content, 0, $pos2);
			}
		}
		
		if(!preg_match_all($rule['data']['content_page'], $content, $m)) return $ret;
		
		foreach($m['title'] as $k => $v){
			
			$frame = isset($m['frame'][$k]) ? $this->fix_url(trim($m['frame'][$k]), $url) : '';
			if(!empty($rule['data']['capture_frame']) && !$test){
				$frame = $this->capture_attachment($frame);
			}
			
			$page_url = $this->fix_url(trim($m['url'][$k]), $base_url);
			$ret['pages'][$page_url] = array(
				'title' => trim($m['title'][$k]),
				'frame' => $frame
			);
		}
	}
	
	return $ret;
}

/**
* 修补URL
* @param string $url 待修的URL
* @param string $context_url 关联的URL
**/
function fix_url($url, $context_url){
	if(is_array($url)){
		foreach($url as $k => $v){
			$url[$k] = $this->fix_url($v, $context_url);
		}
	}else{
		if(stristr($url, '://') === false){
			$parse = parse_url($context_url);
			$path = '';
			//print_r($parse);
			if(substr($url, 0, 1) != '/'){
				$path = substr($parse['path'], 0, strrpos($parse['path'], '/') +1);
			}
			
			return $parse['scheme'] .'://'. $parse['host'] . $path . $url;
		}
	}
	
	return $url;
}

//修复图片及超链接URL
function fix_link($content, $context_url, $base){
	$this->_url = $context_url;
	
	if(is_array($content)){
		foreach($content as $k => $v){
			$content[$k] = $this->fix_link($v, $context_url, $base);
		}
	}else{
		$content = preg_replace_callback('/(<img\s+?[^>]*?)(src)=[\'"]?([^\'"\s\>]+)[\'"]?/i', array(&$this, '_fix_link'), $content);
		
		$this->_url = $base ? $base : $context_url;
		$content = preg_replace_callback('/(<a\s+?[^>]*?)(href)=[\'"]?([^\'"\s\>]+)[\'"]?/i', array(&$this, '_fix_link'), $content);
	}
	
	return $content;
}

//preg_replace_callback
function _fix_link($m){
	//return str_replace();
	return $m[1] . $m[2] .'="'. $this->fix_url($m[3], $this->_url) .'"';
}

/**
* 从内容中提取图片并保存, preg_replace_callback
**/
function capture_image($string){
	
	if(is_array($string)){
		foreach($string as $k => $v){
			$string[$k] = $this->capture_image($v);
		}
	}else{
		$string = preg_replace_callback(
			'#<img[^>]+?src=[\'"]?([^>\'"\s]+)[\'"]?[^>]*>#i',
			array(&$this, '_capture_image'),
			$string
		);
	}
	
	return $string;
}

function _capture_image($m){
	return str_replace($m[1], $this->capture_attachment($m[1]), $m[0]);
}

/**
* 捕抓远程文件,字符串或数组,只支持一维数组
**/
function capture_attachment($url){
	
	static $uploader;
	if($uploader === null){
		$uploader = &$this->core->load_module('uploader');
		$uploader->set($this->system->name, $this->name);
	}
	
	$url = $this->fix_url($url, $this->_url);
	$today = CACHE_PATH .'tmp/attachment/'. date('Y-m-d', P8_TIME) .'/';
	md($today);
	$is_array = is_array($url);
	
	if($is_array && function_exists('curl_init')){
		$mch = curl_multi_init();
		
		$ch = array();
		foreach($url as $k => $v){
			$ch[$k] = p8_http_request(array(
				'url' => $v,
				'timeout' => $this->timeout,
				'connection' => 'keep-alive',
				'referer' => $this->_url,
				'return_curl' => true
			));
			
			curl_multi_add_handle($mch, $ch[$k]);
		}
		
		$active = null;
		//execute the handles
		do {
			$mrc = curl_multi_exec($mch, $active);
		} while ($mrc == CURLM_CALL_MULTI_PERFORM);
		
		while ($active && $mrc == CURLM_OK) {
			if (curl_multi_select($mch) != -1) {
				do {
					$mrc = curl_multi_exec($mch, $active);
				} while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}
		
		$file = array();
		foreach($ch as $k => $v){
			$file[$k] = array();
			if($content = curl_multi_getcontent($v)){
				$tmp = $today . unique_id(16);
				write_file($tmp, $content);
				
				$file[$k]['success'] = true;
				$file[$k]['url'] = $tmp;
			}else{
				$file[$k]['success'] = false;
				$file[$k]['url'] = $url[$k];
			}
			
			curl_multi_remove_handle($mch, $ch[$k]);
		}
		
		curl_multi_close($mch);
		
	}else{
		
		$file = array();
		foreach((array)$url as $k => $v){
			$content = p8_http_request(array(
				'url' => $v,
				'timeout' => $this->timeout,
				'referer' => $this->_url,
				'connection' => 'keep-alive'
			));
			
			$file[$k] = array();
			if($content['body']){
				$tmp = $today . unique_id(16);
				write_file($tmp, $content['body']);
				
				$file[$k]['success'] = true;
				$file[$k]['url'] = $tmp;
			}else{
				$file[$k]['success'] = false;
				$file[$k]['url'] = $url;
			}
		}
	}
	
	$ret = array();
	foreach($file as $k => $v){
		if(
			$v['success'] &&
			$tmp = $uploader->upload(array(
				'files' => array(
					array(
						'tmp_name' => $v['url'],
						'name' => html_entities(basename($is_array ? $url[$k] : $url)),
						'size' => filesize($v['url']),
						'ext' => 'jpg',
						'type' => function_exists('mime_content_type') ? 
							($m = mime_content_type($v['url']) ? $m : 'application/octet-stream' ) :
							'application/octet-stream'
					)
				),
				'capture' => true,
				'watermark' => false
			))
		){
			$tmp = current($tmp);
			
			if($tmp['thumb'] == 2) $tmp['file'] .= '.cthumb.jpg';
			
			$this->_atts .= $tmp['id'] .',';
			
			$v['url'] = $tmp['file'];
		}else{
			$v['url'] = $url[$k];
		}
		
		$ret[$k] = $v['url'];
	}
	
	return $is_array ? $ret : current($ret);
}

/**
* 获取内容
**/
function get_item($data){
	$ret = array();
	
	$field = empty($data['count']) ? '*' : 'COUNT(*) AS `count`';
	
	if(!empty($data['iid'])){
		$table = $this->item_addon_table;
		$sql = "SELECT $field FROM $this->item_addon_table WHERE iid = '$data[iid]'";
	}else{
		$table = $this->item_table;
		$sql = "SELECT $field FROM $this->item_table WHERE $data[where]";
	}
	
	//仅返回数量
	if(!empty($data['count'])){
		$tmp = $this->DB_master->fetch_one($sql);
		
		return $tmp['count'];
	}else{
		$sql .= ' ORDER BY id ASC';
	}
	
	$sql = $sql . ( empty($data['limit']) ?
		'' :
		' LIMIT '. ( empty($data['offset']) ? '' : $data['offset'] .',' ) . $data['limit'] 
	);
	//echo $sql;
	$query = $this->DB_master->query($sql);
	$ids = $comma = '';
	while($v = $this->DB_master->fetch_array($query)){
		$v['data'] = mb_unserialize($v['data']);
		$ids .= $comma . $v['id'];
		$comma = ',';
		$ret[] = $v;
	}
	
	if(!empty($data['delete']) && $ids){
		//不能删除附件
		$this->delete_item(array('where' => 'id IN ('. $ids .')'));
	}
	
	return $ret;
}


}