<?php
defined('PHP168_PATH') or die();

class P8_DiscuzX extends P8_Module{

var $forums;
var $top_forums;
var $db;
var $TABLE_;
var $url;

function __construct(&$system, $name){
	$this->system = &$system;
	parent::__construct($name);
	
	$this->TABLE_ = $this->CONFIG['db']['name'] .'.'. $this->CONFIG['db']['table_prefix'];
	$this->url = $this->CONFIG['url'];
	
	$config = $this->CONFIG['db'];
	
	require_once PHP168_PATH .'inc/mysql.class.php';
	
	$this->db = new P8_Mysql(
		$config['host'],
		$config['user'],
		$config['password'],
		$config['name'],
		$config['charset'],
		$config['port']
	);
}

function P8_DiscuzX(&$system, $name){
	$this->__construct($system, $name);
}



/**
* ���ӵ���
**/
function label_thread(&$LABEL, &$label, &$var){
	
	$option = &$label['option'];
	
	global $SKIN, $TEMPLATE, $RESOURCE;
	$this_system = &$this->system;
	$this_module = &$this;
	$SYSTEM = $this->system->name;
	$MODULE = $this->name;
	$core = &$this->core;
	
	
	$title_length = empty($option['title_length']) ? 0 : $option['title_length'];
	$summary_length = empty($option['summary_length']) ? 0 : $option['summary_length'];
	$dot = empty($option['title_dot']) ? '' : '...';
	
	$select = select();
	$select->from($this->TABLE_ .'forum_thread AS t', 't.*, t.dateline AS timestamp');
	
	if(empty($option['ids'])){
		//����
		if(!empty($option['forums'])){
			$select->in('t.fid', $option['forums']);
		}
		
		//����
		if(!empty($option['types'])){
			$select->in('t.typeid', $option['types']);
		}
		
		//�û��ظ�������
		if(!empty($option['user_post'])){
			$select->inner_join($this_module->TABLE_ .'forum_post AS p', '', 'p.tid = t.tid');
		}
		
		//�û�ID
		if(!empty($option['uids'])){
			$select->in(!empty($option['user_post']) ? 'p.authorid' : 't.authorid', $option['uids']);
		}
		
		//�����ؼ���
		if(!empty($option['keyword'])){
			$select->search('t.subject', $option['keyword']);
		}
		
		//ͼƬ����
		if(!empty($option['image_thread'])){
			$select->in('t.attachment', 2);
		}
		
		//����
		if(!empty($option['digest'])){
			$select->in('t.digest', $option['digest']);
		}
		
		//��������
		if(!empty($option['thread_type'])){
			$select->in('t.special', $option['thread_type']);
		}
		
		//�������
		if(is_array($var)){
			foreach($option['var_fields'] as $field => $v){
				//��������ֶ�
				switch($v['operator']){
				
				case 'in':
					$select->in($field, $var[$field]);
				break;
				
				case 'range':
					$select->range(
						isset($v[0]) ? $v[0] : null,
						isset($v[1]) ? $v[1] : null,
						empty($v[2]) ? false : true
					);
				break;
				
				case 'search':
					$select->search($field, $var[$field]);
				break;
				
				}
			}
			
			if($option['pageable']){
				//�ɷ�ҳ,��ҳ��
				if(isset($var['#page#'])) $page = $var['#page#'];
				//�м�¼��
				if(isset($var['#count#'])) $count = $var['#count#'];
				//ָ����limit
				$page_size = empty($var['#page_size#']) ? $option['limit'] : $var['#page_size#'];
			}
		}
		
		//����
		if(!empty($option['order_by_string'])){
			$select->order($option['order_by_string']);
		}else{
			$select->order('t.displayorder DESC');
		}
		//echo $select->build_sql() .'<br />';
		$sphinx = null;
		
		$page = $count = 0;
		$page_size = $option['limit'];
		
		$param = array(
			'page' => &$page,
			'page_size' => $page_size,
			'count' => &$count,
			'db_obj' => &$this->db,
			'sphinx' => $sphinx,
			'title_length' => $title_length,
			'summary_length' => $summary_length,
			'title_dot' => $dot,
		);
		
		$list = $this->fetch_thread($select, $param);
		
	}else{
		
		//ָ��ID,�����ҳ,��ʹ��sphinx, ���򰴴���ID��˳����
		$select->in('t.tid', $option['ids']);
		
		$param = array(
			'page_size' => 0,
			'db_obj' => &$this->db,
			'title_length' => $title_length,
			'summary_length' => $summary_length,
			'title_dot' => $dot,
		);
		$list = $this->fetch_thread($select, $param);
		
		$tmp = array_flip($option['ids']);
		foreach($list as $v){
			$tmp[$v['id']] = $v;
		}
		
		$list = array_values($tmp);
	}
	
	//echo $select->build_sql();
	
	if(!empty($label['option']['tplcode']) && strlen($label['option']['tplcode']) > 10){
		//��ʱ�����ģ��
		$tplcode = $LABEL->compile_template($label['option']['tplcode']);
		ob_start();
		eval($tplcode);
		$content = ob_get_clean();
		
	}else{
		//������ָ����ģ��
		$template = empty($var['#template#']) ? $label['option']['template'] : $var['#template#'];
		
		//�����ݰ���ģ��ȡ�ñ�ǩ����
		ob_start();
		include $LABEL->template($template);
		$content = ob_get_clean();
	}
	
	return isset($pages) ? array($content, $pages) : array($content);
}

/**
* ȡ�����Ӳ���ʽ��
**/
function fetch_thread(&$select, &$param){
	
	static $colors = array('', '#EE1B2E', '#EE5023', '#996600', '#3C9D40', '#2897C5', '#2B65B7', '#8F2A90', '#EC1282'), $forums, $types;
	if($forums === null){
		$forums = $this->core->CACHE->read('core/modules', $this->name, 'forums', 'serialize');
		$types = &$forums['types'];
	}
	
	$list = $this->core->list_item($select, $param);
	
	$title_length = $param['title_length'];
	$summary_length = $param['summary_length'];
	$dot = $param['title_dot'];
	
	foreach($list as $k => $v){
		//ת����
		$list[$k] = $v = convert_encode($this->CONFIG['page_charset'], $this->core->CONFIG['page_charset'], $v);
		
		$list[$k]['uid'] = $v['authorid'];
		$list[$k]['url'] = str_replace('{tid}', $v['tid'], $this->CONFIG['thread_url']);
		$list[$k]['category_name'] = $forums['forums'][$v['fid']]['name'];
		$list[$k]['category_url'] = str_replace('{fid}', $v['fid'], $this->CONFIG['forum_url']);
		$list[$k]['user_url'] = str_replace('{user}', $v['authorid'], $this->CONFIG['space_url']);
		
		$list[$k]['full_title'] = $v['subject'];
		$list[$k]['title'] = p8_cutstr($v['subject'], $title_length, $dot);
		$list[$k]['username'] = $v['author'];
		$list[$k]['type'] = isset($types[$v['fid']][$v['typeid']]) ? $types[$v['fid']][$v['typeid']]['name'] : '';
		$list[$k]['avatar'] = $this->avatar($v['authorid']);
		
		//���ݱ�
		$table = $v['posttableid'] ? 'forum_post_'. $v['posttableid'] : 'forum_post';
		$a = $this->db->fetch_one("SELECT p.message, a.attachment FROM {$this->TABLE_}$table AS p
			LEFT JOIN {$this->TABLE_}forum_threadimage AS a ON p.tid = a.tid
			WHERE p.tid = '$v[tid]' AND p.first = '1' LIMIT 0,1");
		
		$a = convert_encode($this->CONFIG['page_charset'], $this->core->CONFIG['page_charset'], $a);
		
		if($a['attachment']){
			$list[$k]['frame'] = $this->CONFIG['attachment_url'] .'forum/'. $a['attachment'];
		}else{
			$list[$k]['frame'] = '';
		}
		
		//ȥUBB
		$list[$k]['summary'] = p8_cutstr(preg_replace('#\[[^\]]+?].*?\[/[^\]]+?\]#is', '', strip_tags($a['message'])), $summary_length, '');
		
		if($v['highlight']) {
			$string = sprintf('%02d', $v['highlight']);
			$stylestr = sprintf('%03b', $string[0]);
			
			$stylestr[0] && $list[$k]['title'] = '<b>'. $list[$k]['title'] .'</b>';
			$stylestr[1] && $list[$k]['title'] = '<i>'. $list[$k]['title'] .'</i>';
			$string[1] && $list[$k]['title'] = '<font color="'.$colors[$string[1]].'">'. $list[$k]['title'] .'</font>';
		}
	}
	
	return $list;
}

/**
* ȡ�û�Ա
**/
function label_member(&$LABEL, &$label, &$var){
	$option = &$label['option'];
	
	global $SKIN, $TEMPLATE, $RESOURCE;
	$this_system = &$this->system;
	$this_module = &$this;
	$SYSTEM = $this->system->name;
	$MODULE = $this->name;
	$core = &$this->core;
	
	$select = select();
	$select->from($this->TABLE_ .'common_member AS m', 'm.*');
	
	if(empty($option['ids'])){
		
		if($option['qq']){
			$select->inner_join($this_module->TABLE_ .'common_member_profile AS mp', 'mp.*', 'm.uid = mp.uid');
			$select->in('mp.qq', $option['qq']);
		}
		
		if(!empty($option['usergroup'])){
			$select->in('m.groupid', $option['usergroup']);
		}
		
		//����
		if(!empty($option['order_by_string'])){
			$select->order($option['order_by_string']);
		}
		
		$page = 0;
		//�ܼ�¼��
		$count = 0;
		$page_size = $option['limit'];
		
		$list = $this->core->list_item(
			$select,
			array(
				'page' => &$page,
				'page_size' => $page_size,
				'count' => &$count,
				'db_obj' => &$this->db,
			)
		);
		/*if(!empty($option['qq_online'])){
			$tmp = p8_http_request(array('url' => 'http://webpresence.qq.com/getonline?Type=1&'. implode(':', $option['qq'])));
		}*/
	}else{
		//ָ��ID,�����ҳ,��ʹ��sphinx, ���򰴴���ID��˳����
		$select->in('m.uid', $option['ids']);
		$c = range(0, count($option['ids']) -1);
		
		$list = $this->core->list_item(
			$select,
			array(
				'page_size' => 0,
				'db_obj' => &$this->db,
			)
		);
		
		$tmp = array_combine($option['ids'], $c);
		foreach($list as $v){
			$tmp[$v['uid']] = $v;
		}
		
		$list = array_values($tmp);
	}
	
	foreach($list as $k => $v){
		//ת����
		$list[$k] = $v = convert_encode($this->CONFIG['page_charset'], $this->core->CONFIG['page_charset'], $v);
		
		$list[$k]['avatar'] = $this->avatar($v['uid'], 'small', true);
		$list[$k]['user_url'] = str_replace('{user}', $v['uid'], $this->CONFIG['space_url']);
	}
	
	//echo $select->build_sql();
	
	if(!empty($label['option']['tplcode']) && strlen($label['option']['tplcode']) > 10){
		//��ʱ�����ģ��
		$tplcode = $LABEL->compile_template($label['option']['tplcode']);
		ob_start();
		eval($tplcode);
		$content = ob_get_clean();
		
	}else{
		//������ָ����ģ��
		$template = empty($var['#template#']) ? $label['option']['template'] : $var['#template#'];
		
		//�����ݰ���ģ��ȡ�ñ�ǩ����
		ob_start();
		include $LABEL->template($template);
		$content = ob_get_clean();
	}
	
	return isset($pages) ? array($content, $pages) : array($content);
}



/**
* ��̬����
**/
function label_feed(&$LABEL, &$label, &$var){
	$option = &$label['option'];
	
	global $SKIN, $TEMPLATE, $RESOURCE;
	$this_system = &$this->system;
	$this_module = &$this;
	$SYSTEM = $this->system->name;
	$MODULE = $this->name;
	$core = &$this->core;
	
	$select = select();
	$select->from($this->TABLE_ .'home_feed AS f', 'f.*');
	
	if(!empty($label['option']['tplcode']) && strlen($label['option']['tplcode']) > 10){
		//��ʱ�����ģ��
		$tplcode = $LABEL->compile_template($label['option']['tplcode']);
		ob_start();
		eval($tplcode);
		$content = ob_get_clean();
		
	}else{
		//������ָ����ģ��
		$template = empty($var['#template#']) ? $label['option']['template'] : $var['#template#'];
		
		//�����ݰ���ģ��ȡ�ñ�ǩ����
		ob_start();
		include $LABEL->template($template);
		$content = ob_get_clean();
	}
	
	return isset($pages) ? array($content, $pages) : array($content);
}

/**
* ���ɻ���
**/
function cache(){
	return include $this->path .'call/cache_forums.call.php';
}

/**
* ͷ��
*/
function avatar($uid, $size = 'middle', $returnsrc = FALSE, $real = FALSE, $static = FALSE, $ucenterurl = '') {
	
	static $staticavatar;
	if($staticavatar === null) {
		$staticavatar = $this->CONFIG['avatarmethod'];
	}

	$ucenterurl = empty($ucenterurl) ? $this->CONFIG['ucenterurl'] : $ucenterurl;
	$size = in_array($size, array('big', 'middle', 'small')) ? $size : 'middle';
	$uid = abs(intval($uid));
	if(!$staticavatar && !$static) {
		return $returnsrc ? $ucenterurl.'/avatar.php?uid='.$uid.'&size='.$size : '<img src="'.$ucenterurl.'/avatar.php?uid='.$uid.'&size='.$size.($real ? '&type=real' : '').'" />';
	} else {
		$uid = sprintf("%09d", $uid);
		$dir1 = substr($uid, 0, 3);
		$dir2 = substr($uid, 3, 2);
		$dir3 = substr($uid, 5, 2);
		$file = $ucenterurl.'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2).($real ? '_real' : '').'_avatar_'.$size.'.jpg';
		return $returnsrc ? $file : '<img src="'.$file.'" onerror="this.onerror=null;this.src=\''.$ucenterurl.'/images/noavatar_'.$size.'.gif\'" />';
	}
}

}