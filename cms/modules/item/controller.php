<?php
defined('PHP168_PATH') or die();

class P8_CMS_Item_Controller extends P8_Controller{

var $category_acl;
var $att_ids;

function __construct(&$obj){
	//$this->no_base_acl = true;
	parent::__construct($obj);
}

function P8_CMS_Item_Controller(&$obj){
	$this->__construct($obj);
}

function _init(){
	//获取基于分类的权限控制表
	$this->category_acl = $this->get_acl('category_acl');
}

/**
* 检查分类权限
**/
function check_category_action($action, $cid = 0){
	global $IS_FOUNDER;
	if($IS_FOUNDER) return true;
	
	//如果没有上一级权限
	if(!parent::check_action($action)) return false;
	
	//如果拥有所有分类的权限
	if(!empty($this->category_acl[0]['actions'][$action])) return true;
	
	return !empty($this->category_acl[$cid]['actions'][$action]);
}

/**
 * 允许IP
 */
function allow_ip($config){
	if(!isset($config['allow_ip']['enabled']) || $config['allow_ip']['enabled'] == 0){
		return true;
	}
	//ip集合序列
	if(in_array(P8_IP,$config['allow_ip']['collectip'])){
		return true;
	}

	//ip段
	if(!empty($config['allow_ip']['beginip']) && !empty($config['allow_ip']['endip'])){
		
		$pos_begin = strrpos($config['allow_ip']['beginip'], '.');
		$pos_end = strrpos($config['allow_ip']['endip'], '.');
		$pos_user = strrpos(P8_IP, '.');
		
		$ippre_begin = ($pos_begin === false) ? '' : substr($config['allow_ip']['beginip'], 0, $pos_begin) ;
		$ippre_end = ($pos_end === false) ? '' : substr($config['allow_ip']['endip'], 0, $pos_end);
		$ippre_user = ($pos_user === false) ? '' : substr(P8_IP, 0, $pos_user);

		if(empty($ippre_user)){
			message('cms_category_not_allow_ip_one_error');
		}
		
		if(!empty($ippre_begin) && !empty($ippre_end) && $ippre_begin == $ippre_end){
			
			if($ippre_end == $ippre_user && intval(substr(P8_IP, $pos_user+1)) >= intval(substr($config['allow_ip']['beginip'], $pos_begin+1)) && intval(substr(P8_IP, $pos_user+1)) <= intval(substr($config['allow_ip']['endip'], $pos_end+1))){
				//ip例外
				if($config['allow_ip']['ruleoutip'] && in_array(P8_IP,$config['allow_ip']['ruleoutip'])){
					message('cms_category_not_allow_ip_three_error');
				}else{
					return true;
				}
				
			}else{
				message('cms_category_not_allow_ip_two_error');
			}
		}
	}else{
		message('cms_category_apply_to_sub_categories');
	} 
}
/**
* 检查分级审核权限
**/
function verify_acl($value){
	global $IS_FOUNDER;
	if($IS_FOUNDER) return true;
	
	return !empty($this->model->CONFIG['verify_acl'][$value]['role'][$this->model->system->ROLE]);
}

/**
* 添加内容
**/
function add(&$POST){
	
	//检查权限,站群免检
	if(!defined('P8_CLUSTER') && !$this->check_category_action('add', isset($POST['cid']) ? intval($POST['cid']) : 0)){
		return false;
	}
	
	global $UID, $USERNAME;
	
	//验证数据
	$data = $this->valid_data($POST);
	
	if($data === null) return false;
	
	$data['main']['pages'] = $data['item']['pages'] = $data['addon']['page'] = 1;
	$data['main']['update_time'] = $data['item']['update_time'] = 
	$data['main']['create_time'] = $data['item']['create_time'] = P8_TIME;
	if(empty($data['main']['timestamp']))
		$data['main']['timestamp'] = $data['item']['timestamp'] = $data['addon']['timestamp'] = P8_TIME;
	$data['main']['uid'] = $data['item']['uid'] = $UID;
	$data['main']['username'] = (defined('P8_CLUSTER') && !empty($POST['username']))?$POST['username']:$USERNAME;
	$data['main']['model'] = $this->model->model;
	
	$data['item']['username'] = &$data['main']['username'];
	$data['item']['model'] = &$data['main']['model'];
	
	$data['addon']['addon_summary'] = &$data['main']['summary'];
	$data['addon']['addon_frame'] = &$data['main']['frame'];
	
	$data['push_item_id'] = defined('P8_CLUSTER')? $POST['push_item_id']:'';
	
	//不允许设定追加自增ID
	unset($data['addon']['id']);
	
	$id = $this->model->add($data);
	
	return $id;
}

function update($id, &$POST, $verified = true){
	
	$T = $verified ? $this->model->main_table : $this->model->unverified_table;
	
	$orig_data = $this->DB_master->fetch_one("SELECT i.*, m.role_id FROM $T AS i
	LEFT JOIN {$this->model->system->member_table} AS m ON i.uid = m.id
	WHERE i.id = '$id'");
	if(empty($orig_data)) return false;
	
	
	global $UID, $IS_FOUNDER;
	if($UID != $orig_data['uid']){
		//检查权限,不是内容所有者,不是创始人,没有修改当前分类内容权限的
		
		if(!$this->check_category_action('update', $orig_data['cid'])){
			return false;
		}
	}
	
	//验证数据
	$data = $this->valid_data($POST);
	
	$data['addon']['addon_summary'] = &$data['main']['summary'];
	$data['addon']['addon_frame'] = &$data['main']['frame'];
	if($data['main']['list_order'] == P8_TIME){
		$data['main']['list_order'] = $data['item']['list_order'] = $orig_data['timestamp'];
	}
	
	$data['main']['update_time'] = $data['item']['update_time'] = P8_TIME;
	
	//不允许改动的字段
	unset($data['addon']['iid'], $data['addon']['ip'], $data['addon']['id'], $data['addon']['page']);
	
	return $this->model->update($id, $data, $orig_data, $verified);
}

function addon(&$POST){
	
	//检查权限,站群免检
	if(!defined('P8_CLUSTER') && !$this->check_category_action('add', isset($POST['cid']) ? intval($POST['cid']) : 0)){
		return false;
	}
	
	$data = $this->valid_data($POST);
	if($data === null) return false;
	
	if(isset($POST['verified'])){
		$data['addon']['verified'] = $POST['verified'] == 1 ? true : false;
	}else{
		$data['addon']['verified'] = true;
	}
	
	$data['addon']['timestamp'] = P8_TIME;
	$data['addon']['html'] = $data['html'];
	
	//追加不允许设定自增id
	unset($data['addon']['id']);
	$data['addon']['attachment_hash'] = $data['attachment_hash'];
	
	return $this->model->addon($data['addon']);
}

function update_addon(&$POST){
	
	$id = isset($POST['id']) ? intval($POST['id']) : 0;
	if(empty($id)) return false;
	
	if(isset($POST['verified'])){
		$verified = $POST['verified'] == 1 ? true : false;
	}else{
		$verified = true;
	}
	
	$table = $verified ? $this->model->table : $this->model->unverified_table;
	
	$orig_data = $this->DB_master->fetch_one("SELECT a.*, i.uid, m.role_id, i.cid FROM {$this->model->addon_table} AS a
	INNER JOIN {$table} AS i ON i.id = a.iid
	LEFT JOIN {$this->model->system->member_table} AS m ON i.uid = m.id
	WHERE a.id = '$id'");
	
	if(empty($orig_data)) return false;
	
	global $UID, $IS_FOUNDER;
	if($UID != $orig_data['uid']){
		//检查权限,不是内容所有者,不是创始人,没有修改当前分类内容权限的
		
		if(!$this->check_category_action('update', $orig_data['cid'])){
			return false;
		}
	}
	
	$data = $this->valid_data($POST);
	$data['addon']['attachment_hash'] = $data['attachment_hash'];
	$data['addon']['verified'] = $verified;
	
	//修改追加数据时不修改IP
	unset($data['addon']['ip']);
	return $this->model->update_addon($data['addon'], $orig_data);
}

function verify($data){
	global $core;
	$T = $data['value'] == 1 ? $this->model->unverified_table : $this->model->main_table;
	$T = $data['verified'] ? $this->model->main_table : $this->model->unverified_table;
	
	$query = $this->DB_master->query("SELECT
	$T.id, $T.cid, $T.uid FROM $T 
	WHERE $data[where]");
	
	$ids = $comma = '';
	while($arr = $this->DB_master->fetch_array($query)){
		//检查权限
		if(!$this->check_category_action('verify', $arr['cid'])) continue;
		
		$ids .= $comma . $arr['id'];
		$comma = ',';
	}

	if(!$ids) return array();
	if($core->systems['sites']['installed']){
		$this->DB_master->update(
			P8_TABLE_.'sites_stop_data',
			array('status' => $data['value']),
			"new_id IN ($ids)"
		);				
	}
	$data['where'] = "$T.id IN ($ids)";
	return $this->model->verify($data);
}

function delete($data){
	
	$T = $data['verified'] ? $this->model->main_table : $this->model->unverified_table;
	
	$query = $this->DB_master->query("SELECT
	$T.id, $T.cid, $T.uid FROM $T 
	WHERE $data[where]");
	
	$ids = $comma = '';
	while($arr = $this->DB_master->fetch_array($query)){
		//检查权限
		if(!$this->check_category_action('delete', $arr['cid'])) continue;
		
		$ids .= $comma . $arr['id'];
		$comma = ',';
	}
	
	if(!$ids) return array();
	
	$data['where'] = "$T.id IN ($ids)";
	
	return $this->model->delete($data);
}

function delete_addon($data){
	$T = $data['verified'] ? $this->model->main_table : $this->model->unverified_table;
	
	$item = $this->DB_master->fetch_one("SELECT
		$T.* FROM $T
		WHERE id = '$data[iid]'");
	if(empty($data)) return false;
	
	if(!$this->check_category_action('delete', $item['cid'])) return false;
	
	return $this->model->delete_addon(array(
		'iid' => $data['iid'],
		'id' => $data['id'],
		'verified' => $data['verified'],
		'item' => $item,
	));
}

function move(){
	
}

/**
 * 搜索指定的内容，找出是否有敏感词
 * @param $content {string} 要过滤的内容
 * @return $matches代表匹配到敏感词
 */
function valid_filter_word($content){
	global $core, $CACHE;
	
	static $cache;
	if($cache === null){
		$cache = $CACHE->read('', $core->name, 'word_filter');
	}
	if(!$cache || !$content){
		return array();
	}
	preg_match_all($cache, $content,$matches);
	$matches = $matches ? array_unique($matches[0]) : array();
	return $matches;
}

/**
* 验证数据
* field# 数组为自定义字段的值
**/
function valid_data(&$POST){
	global $this_model, $IS_FOUNDER,$P8LANG;
	
	$data = array(
		'main' => array(),
		'item' => array(),
		'addon' => array()
	);
	
	$clusterd = defined('P8_CLUSTER');
	//站群的数据就不用再次实体化鸟
	$func = $clusterd ? create_function('$a', 'return $a;') : 'html_entities';
	
	//关联附件哈希
	$data['attachment_hash'] = isset($POST['attachment_hash']) ? $POST['attachment_hash'] : '';
	//审核
	$data['verify'] = isset($POST['verify']) ? intval($POST['verify']) : 0;
	//修改后生成静态
	$data['html'] = empty($POST['html']) ? false : true;
	
	//转换附件地址
	$data['main']['frame'] = isset($POST['frame']) ? attachment_url($func($POST['frame']), true) : '';
	
	
	//验证公共部分
	$matches = isset($POST['title']) ? $this->valid_filter_word($POST['title']) : array();
	if($matches){
		foreach($matches as $v) $ms .= $v.',';
		message(p8lang($P8LANG['cms_item_title_include_filter_word'], array(count($matches))).':'.substr($ms,0,-1));
	}
	$data['main']['title'] = isset($POST['title']) ? filter_word($func($POST['title'])) : '';

	$data['main']['title_color'] = isset($POST['title_color']) ? $func($POST['title_color']) : '';
	$data['main']['title_bold'] = empty($POST['title_bold']) ? 0 : 1;
	
	$data['main']['cid'] = isset($POST['cid']) ? intval($POST['cid']) : 0;
	if(isset($POST['action']) && ($POST['action'] == 'add' || $POST['action'] == 'update')){
		$cat = $this->model->system->fetch_category($data['main']['cid']);
		//分类不存在
		if(empty($cat)) return null;
	}
	
	$data['main']['url'] = isset($POST['url']) ? $func($POST['url']) : '';
	$data['main']['summary'] = isset($POST['summary']) ? filter_word(strip_tags(str_replace(array("\r", "\n", "\t"), '', $POST['summary']))) : '';

	//评论
	$data['main']['allow_comment'] = empty($POST['forbidden_comment']) ? 1 : 0;
	//内容收费
	$data['main']['credit_type'] = !empty($POST['credit_type']) && isset($this->core->credits[$POST['credit_type']]) ? intval($POST['credit_type']) : 0;
	$data['main']['credit'] = empty($POST['credit']) ? 0 : intval($POST['credit']);
	$data['main']['author'] = isset($POST['author']) ? $func($POST['author']) : '';
	$data['main']['views'] = empty($POST['views']) ? 0 : intval($POST['views']);
	$data['main']['editer'] = isset($POST['editer']) ? $func($POST['editer']) : '';
	$data['main']['verifier'] = isset($POST['verifier']) ? $func($POST['verifier']) : '';
	//自定义的HTML文件规则
	$data['main']['html_view_url_rule'] = isset($POST['html_view_url_rule']) ? $func($POST['html_view_url_rule']) : '';
	//副标题
	$data['main']['sub_title'] = isset($POST['sub_title']) ? $func($POST['sub_title']) : '';
	
	
	//发布时间
	if($this->check_category_action('create_time',$data['main']['cid'])){
		$data['main']['timestamp'] = !empty($POST['timestamp'])? strtotime($POST['timestamp']) : P8_TIME;
	}else{
		$data['main']['timestamp'] = P8_TIME;
	}
	
	//排序
	if($this->check_admin_action('list_order')){
		$data['main']['list_order'] = isset($POST['list_order']) && ($list_order = strtotime($POST['list_order'])) ? $list_order : $data['main']['timestamp'];
	}else{
		$data['main']['list_order'] = P8_TIME;
	}
	
	
	
	//标题
	$data['item']['title'] = &$data['main']['title'];
	$data['item']['title_color'] = &$data['main']['title_color'];
	$data['item']['title_bold'] = &$data['main']['title_bold'];
	$data['item']['sub_title'] = &$data['main']['sub_title'];
	$data['item']['url'] = &$data['main']['url'];
	$data['item']['source'] = isset($POST['source']) ? $func($POST['source']) : '';
	
	$data['item']['html_view_url_rule'] = &$data['main']['html_view_url_rule'];
	//摘要
	$data['item']['summary'] = &$data['main']['summary'];
	$data['item']['attributes'] = &$data['main']['attributes'];
	//分类ID
	$data['item']['cid'] = &$data['main']['cid'];
	//关键词
	$data['item']['keywords'] = isset($POST['keywords']) ? filter_word($func($POST['keywords'])) : '';
	//模板
	$data['item']['template'] = isset($POST['template']) ? $func($POST['template']) : '';
	$data['item']['label_postfix'] = isset($POST['label_postfix']) ? $func($POST['label_postfix']) : '';
	$data['item']['list_order'] = &$data['main']['list_order'];
	$data['item']['timestamp'] = &$data['main']['timestamp'];
	$data['item']['author'] = &$data['main']['author'];
	$data['item']['views'] = &$data['main']['views'];
	$data['item']['editer'] = &$data['main']['editer'];
	$data['item']['verifier'] = &$data['main']['verifier'];
	//$data['item']['verified'] = empty($POST['verified']) ? 0 : 1;
	
	
	
	
	
	//要追加内容的条目ID
	$data['addon']['id'] = isset($POST['id']) ? intval($POST['id']) : 0;
	$data['addon']['iid'] = isset($POST['iid']) ? intval($POST['iid']) : 0;
	//追加内容页码
	$data['addon']['page'] = isset($POST['page']) ? intval($POST['page']) : 2;
	$data['addon']['page'] = max($data['addon']['page'], 2);
	//标题,封面,摘要
	$data['addon']['addon_title'] = isset($POST['addon_title']) ? filter_word($func($POST['addon_title'])) : '';
	$data['addon']['addon_frame'] = isset($POST['addon_frame']) ? $func($POST['addon_frame']) : '';
	$data['addon']['addon_summary'] = isset($POST['addon_summary']) ? filter_word($func($POST['addon_summary'])) : '';
	//IP
	$data['addon']['ip'] = P8_IP;
	$data['addon']['last_update_ip'] = P8_IP;
	$data['addon']['timestamp'] = &$data['main']['timestamp'];
	//辅栏目
	$data['assist_category'] = isset($POST['assist_category']) ? $POST['assist_category'] : '';
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//自定义字段的过滤
	//兼容ewebeditor编辑器begin
	if(isset($POST['field']) && is_array($POST['field'])){
		foreach($POST['field'] as $field => $v){
				$POST['field#'][$field] = $POST['field'][$field];
		}
		if($POST['field#']['content']){
			$matches = $this->valid_filter_word($POST['field#']['content']);
			if($matches){
				foreach($matches as $v) $ms .= $v.',';
				message(p8lang($P8LANG['cms_item_content_include_filter_word'], array(count($matches))).':'.substr($ms,0,-1));
			}
		}
	}
	//兼容ewebeditor编辑器end

	if(isset($POST['field#']) && is_array($POST['field#'])){
		$F = &$POST['field#'];
	}else{
		$F = array();
	}
	if($POST['field#']['content']){
		$matches = $this->valid_filter_word($POST['field#']['content']);
		if($matches){
			foreach($matches as $v) $ms .= $v.',';
			message(p8lang($P8LANG['cms_item_content_include_filter_word'], array(count($matches))).':'.substr($ms,0,-1));
		}
	}
	
	foreach($this_model['fields'] as $field => $v){
		//检测是否正确的提交字段
		$posted = true;//$v['editable']; //isset($POST['#field_'. $field .'_posted']) || defined('P8_CLUSTER');
		
		//存放在哪个表
		$table = $v['list_table'] ? 'item' : 'addon';
		
		switch($v['widget']){
		
		//文本框,多行文本框,单选,单选下拉框,单个上传框
		case 'text': case 'textarea': case 'radio': case 'select':
			
			switch($v['type']){
			
			//整型
			case 'tinyint': case 'smallint': case 'mediumint': case 'int': case 'bigint':
				$data[$table][$field] = $posted && isset($F[$field]) ?
					(int)$F[$field] :
					$v['default_value'];
			break;
			
			//浮点
			case 'float': case 'double': case 'decimal':
				$data[$table][$field] = $posted && isset($F[$field]) ?
					(float)$F[$field] :
					$v['default_value'];
			break;
			
			//字符
			case 'char': case 'varchar':
				$data[$table][$field] = $posted && isset($F[$field]) ?
					filter_word($func($F[$field])) :
					$v['default_value'];
			break;
			
			//默认
			default: 
				$data[$table][$field] = $posted && isset($F[$field]) ?
					filter_word($func($F[$field])) :
					$v['default_value'];
			}
			
		break;
		
		//多选框,多选下拉框
		case 'checkbox': case 'multi_select':
			if($posted){
				$data[$table][$field] = isset($F[$field]) ?
					implode($this->model->delimiter, (array)$F[$field]) :
					'';
			}else{
				$data[$table][$field] = implode($this->model->delimiter, $v['default_value']);
			}
		break;
		
		//上传器
		case 'uploader':case 'image_uploader':
			if($posted){
				$title = isset($F[$field]['title']) ? filter_word($F[$field]['title']) : '';
				$url = isset($F[$field]['url']) ? $F[$field]['url'] : '';
				$thumb = isset($F[$field]['thumb']) ? $F[$field]['thumb'] : '';
				
				$data[$table][$field] = attachment_url($func($title . $this->model->delimiter . $url . $this->model->delimiter . $thumb), true);
			}else{
				$data[$table][$field] = $v['default_value'];
			}
		break;
		
		//批量上传
		case 'multi_uploader':
			if($posted){
				if($clusterd){
					$data[$table][$field] = $comma = ''; 
					foreach($F[$field] as $_kk=>$_vv){
						$_vv = implode($this->model->col_delimiter,$_vv);
						$data[$table][$field] .= $comma.$_vv;
						$comma = $this->model->delimiter;
					}					
				}else{
				$title = isset($F[$field]['title']) ? (array)$F[$field]['title'] : array();
				$url = isset($F[$field]['url']) ? (array)$F[$field]['url'] : array();
				$thumb = isset($F[$field]['thumb']) ? (array)$F[$field]['thumb'] : array();
				
				$data[$table][$field] = $comma = '';
				foreach($url as $k => $v){
					if(!strlen($v)) continue;
					
					$data[$table][$field] .= $comma . filter_word($title[$k]) . $this->model->col_delimiter . $v . $this->model->col_delimiter . $thumb[$k];
					$comma = $this->model->delimiter;
				}
				}
				
				$data[$table][$field] = attachment_url($func($data[$table][$field]), true);
			}
		break;
		
		//编辑器,编辑器的内容很危险
		case 'editor': case 'editor_basic': case 'editor_common':case 'ueditor': case 'ueditor_common':
			if($posted && isset($F[$field])){
				$acl = $this->core->load_acl('core', '', $this->ROLE);
				$data[$table][$field] = p8_html_filter($F[$field], $acl['allow_tags'], $acl['disallow_tags']);
				//本地化图片
				if(!empty($POST['capture_image'])){
					$this->_att_ids = '';
					
					$data[$table][$field] = preg_replace_callback(
						'#<img[^>]*?src=(?:\'|")?([^\'"]+)(?:\'|")?[^>]*?>#',
						array(&$this, 'capture_image'),
						$data[$table][$field]
					);
					
					$_COOKIE[$this->core->CONFIG['cookie']['prefix'] . 'uploaded_attachments'][$data['attachment_hash']] .= $this->_att_ids;
				}
	
				if(!$data['main']['frame'] && $this->model->CONFIG['first_img_to_frame']){//第一张图片作为封面
					$data['main']['frame'] = $this->first_img_to_frame($data[$table][$field]);
				}
				$data[$table][$field] = attachment_url( filter_word($data[$table][$field]), true);
				
			}else{
				$data[$table][$field] = $v['default_value'];
			}
		break;
		
		default:
			$data[$table][$field] = $posted && isset($F[$field]) ?
				filter_word($func($F[$field])) :
				$v['default_value'];
		}
		
	}
	//处理自定义字段结束}
	
	//封面图片不为空标记属性为'图片'
	empty($data['main']['frame']) || $POST['attribute'][6] = 6;
	//封面图片
	$data['item']['frame'] = &$data['main']['frame'];
	
	//检查有无设置属性的权限
	if($this->check_admin_action('attribute')){
		//属性,不为空,唯一
		$attributes = isset($POST['attribute']) ? array_unique(filter_int($POST['attribute'])) : array();
		//排序属性
		asort($attributes);
		
		foreach($attributes as $k => $v){
			if($v == 6) continue;
			
			//检查属性设置权限
			if(!$IS_FOUNDER && empty($this->model->CONFIG['attribute_acl'][$v][$this->ROLE])){
				unset($attributes[$k]);
			}
		}
	}else{
		$attributes = array();
	}
	isset($POST['views']) && $data['main']['views'] = $data['item']['views'] = intval($POST['views']);
	$data['main']['attributes'] = implode(',', $attributes);
	
	$l1 = strlen($data['main']['summary']);
	$l2 = strlen($data['addon']['addon_summary']);
	//没有摘要自动生成摘要
	if(
		!$l1 || !$l2 &&
		isset($data['addon']['content'])
	){
		$data['strip_tags_content'] = p8_cutstr(str_replace(array("\r", "\n", "\t","&nbsp;"), '', strip_tags(trim($data['addon']['content']))), 250, '');
		
		$l1 || $data['main']['summary'] = $func(trim($data['strip_tags_content']));
		
		$l2 || $data['addon']['addon_summary'] = $func(trim($data['strip_tags_content']));
	}

	return $data;
}

/**
* 捕抓远程图片并上传, preg_replace_callback
**/
function capture_image($m){
	return str_replace($m[1], $this->_capture_image($m[1]), $m[0]);
}

function _capture_image($url){
	static $uploader;
	if($uploader === null){
		
		$up = &$this->core->load_module('uploader');
		$up->set($this->model->system->name, $this->model->name);
		
		$uploader = &$this->core->controller($up);
	}
	
	//已经是本站有的附件了
	if(attachment_url($url, true) != $url){
		return $url;
	}
	
	global $this_model;
	$config = $this_model['CONFIG'];
	
	if(
		$ret = $uploader->capture(array(
			'files' => $url,
			'thumb_width' => empty($config['frame_thumb_width']) ? 0 : $config['frame_thumb_width'],
			'thumb_height' => empty($config['frame_thumb_height']) ? 0 : $config['frame_thumb_height'],
			'cthumb_width' => empty($config['content_thumb_width']) ? 0 : $config['content_thumb_width'],
			'cthumb_height' => empty($config['content_thumb_height']) ? 0 : $config['content_thumb_height'],
		))
	){
		$ret = current($ret);
		
		if($ret['thumb'] == 2) $ret['file'] .= '.cthumb.jpg';
		
		$this->_att_ids .= $ret['id'] .',';
		
		return $ret['file'];
	}
	
	return $url;
}


function add_order(&$post){
	global $UID, $USERNAME;
	$data = $this->varify_order($post);
	$good = $this->get_good_detail($post['id']);
	$data['subject'] = $good['title'];
	$data['seller_uid'] = $good['uid'];
	$data['seller_username'] = $good['username'];
	$data['sid'] = $good['id'];
	$data['buyer_uid'] = $UID;
	$data['buyer_username'] = $USERNAME;
	$data['amount'] = $good['price'] * $data['number'];
	$data['number'] = $data['number'];
	$data['timestamp'] = P8_TIME;
	
	$sdata = $this->model-> add_order($data);
	return array($sdata['NO']);
}

function get_good_detail($id){
$data = $this->model->data('read', $id);
$_REQUEST['model'] = $data['model'];
$this->model->system->init_model();
$SQL = "SELECT i.*, a.*, i.timestamp AS timestamp, a.iid AS id FROM ".$this->model->table." AS i
		INNER JOIN ".$this->model->addon_table." AS a ON i.id = a.iid
		WHERE i.id = '$id'";
$data = array_merge($this->model->DB_slave->fetch_one($SQL), $data);

return $data;
}

function varify_order($post){
	$data = array();
	if(!empty($post['name']))$data['name'] = filter_word(from_utf8($post['name']));
	if(!empty($post['address']))$data['address'] = filter_word(from_utf8($post['address']));
	if(!empty($post['email']))$data['email'] = filter_word($post['email']);
	if(!empty($post['phone']))$data['phone'] = filter_word($post['phone']);
	if(!empty($post['number']))$data['number'] = intval($post['number']);
	if(!empty($post['content']))$data['content'] = filter_word(from_utf8($post['content']));
	return $data;
}


function first_img_to_frame($data){
	$attachs = array();
	preg_match_all('/(<img\s+?[^>]*?)(src)=[\'"]?([^\'"\s\>]+)[\'"]?/i',$data,$attachs);
	if(!empty($attachs[3][0])){
		return attachment_url($attachs[3][0],true);
	}
}

}