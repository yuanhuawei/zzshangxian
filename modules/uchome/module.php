<?php
defined('PHP168_PATH') or die();

class P8_Uchome extends P8_Module{

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

function P8_Uchome(&$system, $name){
	$this->__construct($system, $name);
}

function get_event_class(){
	$sql = "SELECT classid,classname FROM ".$this->TABLE_ .'eventclass'." ORDER BY displayorder ASC";
	$query = $this->DB_master->fetch_all($sql);
	return $query;
	$data =array();
	while($arr = $this->DB_master->fetch_array($query)){
		$data[$arr['classid']] = $arr['classname'];
	}
	return $data;
}


/**
* 日志调用
**/
function label_blog(&$LABEL, &$label, &$var){
	
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
	$select->from($this->TABLE_ .'blog', '*,subject as title,dateline as timestamp');
	
	if(empty($option['ids'])){
		
		//用户ID
		if(!empty($option['uids'])){
			$select->in($option['uids']);
		}
		
		//搜索关键字
		if(!empty($option['subject'])){
			$select->search('subject', $option['subject']);
		}
		
		//隐私范围
		if(isset($option['friend'])){
			$select->in('friend', $option['friend']);
		}
		
		//发布时间
		if(!empty($option['dateline'])){
			$select->range('dateline', P8_TIME-$option['dateline']);
		}
		
		
		//排序
		if(!empty($option['order_by_string'])){
			$select->order($option['order_by_string']);
		}else{
			$select->order('blogid DESC');
		}
		$page = 0;
		//总记录数
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
	}else{
		//指定ID,不需分页,不使用sphinx, 排序按传入ID的顺序排
		$select->in('blogid', $option['ids']);
		$c = range(0, count($option['ids']) -1);
		
		$list = $this->core->list_item(
			$select,
			array(
				'page_size' => 0,
				'db_obj' => &$this->db,
			)
		);
	}
	//echo $select->build_sql();
	//print_r($list);exit;
	foreach($list as $k=>$v){
		$list[$k]['url'] = $this->CONFIG['url'].'/space.php?uid='.$v['uid'].'&do=blog&id='.$v['blogid'];
		$list[$k]['user_url'] = $this->CONFIG['url'].'/space.php?uid='.$v['uid'];
		$list[$k]['full_title'] = $v['title'];
		$dot=!empty($option['title_dot'])?'...' : '';
		$list[$k]['title'] = p8_cutstr($v['title'], $option['title_length'], $dot);
	}
	
	if(!empty($label['option']['tplcode']) && strlen($label['option']['tplcode']) > 10){
		//即时编译的模板
		$tplcode = $LABEL->compile_template($label['option']['tplcode']);
		ob_start();
		eval($tplcode);
		$content = ob_get_clean();
		
	}else{
		//变量中指定了模板
		$template = empty($var['#template#']) ? $label['option']['template'] : $var['#template#'];
		
		//用数据包含模板取得标签内容
		ob_start();
		include $LABEL->template($template);
		$content = ob_get_clean();
	}
	
	return isset($pages) ? array($content, $pages) : array($content);
}



/**
* 相册调用
**/
function label_album(&$LABEL, &$label, &$var){
	
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
	$select->from($this->TABLE_ .'album', '*,albumname as title,dateline as timestamp');
	
	//非指定ID
	if(empty($option['albumid'])){
			
		//用户ID
		if(!empty($option['uids'])){
				$option['uids'] = preg_replace('/[^0-9,]/', '', $option['uids']);
				$option['uids'] = filter_int(explode(',', $option['uids']));
				$select->in('uid', $option['uids']);
		}
		
		//发布时间
		if(!empty($option['dateline'])){
			$select->range('dateline', P8_TIME-$option['dateline']);
		}
		//更新时间
		if(!empty($option['updatetime'])){
			$select->range('updatetime', P8_TIME-$option['updatetime']);
		}
		//隐私范围
		if(isset($option['friend'])){
			$select->in('friend', $option['friend']);
		}
		//排序
		if(!empty($option['order_by_string'])){
			$select->order($option['order_by_string']);
		}else{
			$select->order('albumid DESC');
		}

		$page = 0;
		//总记录数
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
	}else{
			//指定ID,不需分页,不使用sphinx, 排序按传入ID的顺序排
		$select->in('albumid', $option['albumid']);
		$c = range(0, count($option['albumid']) -1);
		
		$list = $this->core->list_item(
			$select,
			array(
				'page_size' => 0,
				'db_obj' => &$this->db,
			)
		);

	}
	//echo $select->build_sql();
	//print_r($list);exit;
	foreach($list as $k=>$v){
		$list[$k]['url'] = $this->CONFIG['url'].'/space.php?uid='.$v['uid'].'&do=album&id='.$v['albumid'];
		$list[$k]['user_url'] = $this->CONFIG['url'].'/space.php?uid='.$v['uid'];
		$list[$k]['full_title'] = $v['title'];
		$list[$k]['frame'] = $this->CONFIG['url'].'/attachment/'.$v['pic'];
		$dot=!empty($option['title_dot'])?'...' : '';
		$list[$k]['title'] = p8_cutstr($v['title'], $option['title_length'], $dot);
	}
	
	if(!empty($label['option']['tplcode']) && strlen($label['option']['tplcode']) > 10){
		//即时编译的模板
		$tplcode = $LABEL->compile_template($label['option']['tplcode']);
		ob_start();
		eval($tplcode);
		$content = ob_get_clean();
		
	}else{
		//变量中指定了模板
		$template = empty($var['#template#']) ? $label['option']['template'] : $var['#template#'];
		
		//用数据包含模板取得标签内容
		ob_start();
		include $LABEL->template($template);
		$content = ob_get_clean();
	}
	
	return isset($pages) ? array($content, $pages) : array($content);
}

/**
* 图片调用
**/
function label_pic(&$LABEL, &$label, &$var){
	
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
	$select->from($this->TABLE_ .'pic', '*,dateline as timestamp');
	
	//非指定ID
	if(empty($option['ids'])){
			
		if($option['username']){
			$option['username'] = explode(',', $option['username']);
			$select->in('username', $option['username']);
		}

		if(!empty($option['albumid'])){
			$select->in('albumid', $option['albumid']);
		}
		//用户ID
		if(!empty($option['uids'])){
				$select->in('uid', $option['uids']);
		}
		//排序
		if(!empty($option['order_by_string'])){
			$select->order($option['order_by_string']);
		}else{
			$select->order('albumid DESC');
		}

		$page = 0;
		//总记录数
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
	}else{
			//指定ID,不需分页,不使用sphinx, 排序按传入ID的顺序排
		$select->in('picid', $option['ids']);
		$c = range(0, count($option['ids']) -1);
		
		$list = $this->core->list_item(
			$select,
			array(
				'page_size' => 0,
				'db_obj' => &$this->db,
			)
		);

	}
	//echo $select->build_sql();
	//print_r($list);exit;
	foreach($list as $k=>$v){
		$list[$k]['url'] = $this->CONFIG['url'].'/space.php?uid='.$v['uid'].'&do=album&picid='.$v['picid'];
		$list[$k]['user_url'] = $this->CONFIG['url'].'/space.php?uid='.$v['uid'];
		$list[$k]['full_title'] = $v['title'];
		$list[$k]['frame'] = $this->CONFIG['url'].'/attachment/'.$v['filepath'].'.thumb.jpg';
		$dot=!empty($option['title_dot'])?'...' : '';
		$list[$k]['title'] = p8_cutstr($v['title'], $option['title_length'], $dot);
	}
	
	if(!empty($label['option']['tplcode']) && strlen($label['option']['tplcode']) > 10){
		//即时编译的模板
		$tplcode = $LABEL->compile_template($label['option']['tplcode']);
		ob_start();
		eval($tplcode);
		$content = ob_get_clean();
		
	}else{
		//变量中指定了模板
		$template = empty($var['#template#']) ? $label['option']['template'] : $var['#template#'];
		
		//用数据包含模板取得标签内容
		ob_start();
		include $LABEL->template($template);
		$content = ob_get_clean();
	}
	
	return isset($pages) ? array($content, $pages) : array($content);
}



/**
* 主调用
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
	$select->from($this->TABLE_ .'thread', '*,subject as title,dateline as timestamp');
	
	//非指定ID
	if(empty($option['ids'])){
			
		//用户ID
		if(!empty($option['uids'])){

			$select->in('uid', $option['uids']);
		}
		
		//发布时间
		if(!empty($option['dateline'])){
			$select->range('dateline', P8_TIME-$option['dateline']);
		}
		//更新时间
		if(!empty($option['updatetime'])){
			$select->range('updatetime', P8_TIME-$option['updatetime']);
		}
		//隐私范围
		if(isset($option['friend'])){
			$select->in('friend', $option['friend']);
		}
		//群组ID
		if(isset($option['tagid'])){
			$select->in('tagid', $option['tagid']);
		}
		//排序
		if(!empty($option['order_by_string'])){
			$select->order($option['order_by_string']);
		}else{
			$select->order('tid DESC');
		}

		$page = 0;
		//总记录数
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
	}else{
			//指定ID,不需分页,不使用sphinx, 排序按传入ID的顺序排
		$select->in('tid', $option['ids']);
		$c = range(0, count($option['ids']) -1);
		
		$list = $this->core->list_item(
			$select,
			array(
				'page_size' => 0,
				'db_obj' => &$this->db,
			)
		);

	}
	//echo $select->build_sql();
	//print_r($list);exit;
	foreach($list as $k=>$v){
		$list[$k]['url'] = $this->CONFIG['url'].'/space.php?uid='.$v['uid'].'&do=thread&id='.$v['tid'];
		$list[$k]['user_url'] = $this->CONFIG['url'].'/space.php?uid='.$v['uid'];
		$list[$k]['full_title'] = $v['title'];
		$dot=!empty($option['title_dot'])?'...' : '';
		$list[$k]['title'] = p8_cutstr($v['title'], $option['title_length'], $dot);
	}
	
	if(!empty($label['option']['tplcode']) && strlen($label['option']['tplcode']) > 10){
		//即时编译的模板
		$tplcode = $LABEL->compile_template($label['option']['tplcode']);
		ob_start();
		eval($tplcode);
		$content = ob_get_clean();
		
	}else{
		//变量中指定了模板
		$template = empty($var['#template#']) ? $label['option']['template'] : $var['#template#'];
		
		//用数据包含模板取得标签内容
		ob_start();
		include $LABEL->template($template);
		$content = ob_get_clean();
	}
	
	return isset($pages) ? array($content, $pages) : array($content);
}


/**
* 活動调用
**/
function label_event(&$LABEL, &$label, &$var){
	
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
	$select->from($this->TABLE_ .'event', '*,dateline as timestamp');
	
	//非指定ID
	if(empty($option['albumid'])){
				
			//用户ID
		if(!empty($option['uids'])){
				$select->in('uid', $option['uids']);
		}
		
		//发布时间
		if(!empty($option['dateline'])){
			$select->range('dateline', P8_TIME-$option['dateline']);
		}
		//更新时间
		if(!empty($option['updatetime'])){
			$select->range('updatetime', P8_TIME-$option['updatetime']);
		}
		//隐私范围
		if(!empty($option['public'])){
			$select->in('public', $option['public']);
		}
		//活动状态
		if(!empty($option['grade'])){
			$select->in('grade', $option['grade']);
		}//活动类型
		if(!empty($option['classid'])){
			$select->in('classid', $option['classid']);
		}
		//排序
		if(!empty($option['order_by_string'])){
			$select->order($option['order_by_string']);
		}else{
			$select->order('eventid DESC');
		}

		$page = 0;
		//总记录数
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
	}else{
			//指定ID,不需分页,不使用sphinx, 排序按传入ID的顺序排
		$select->in('eventid', $option['ids']);
		$c = range(0, count($option['ids']) -1);
		
		$list = $this->core->list_item(
			$select,
			array(
				'page_size' => 0,
				'db_obj' => &$this->db,
			)
		);

	}
	//echo $select->build_sql();
	//print_r($list);exit;
	foreach($list as $k=>$v){
		$list[$k]['url'] = $this->CONFIG['url'].'/space.php?uid='.$v['uid'].'&do=event&id='.$v['eventid'];
		$list[$k]['user_url'] = $this->CONFIG['url'].'/space.php?uid='.$v['uid'];
		$list[$k]['full_title'] = $v['title'];
		$dot=!empty($option['title_dot'])?'...' : '';
		$list[$k]['title'] = p8_cutstr($v['title'], $option['title_length'], $dot);
	}
	
	if(!empty($label['option']['tplcode']) && strlen($label['option']['tplcode']) > 10){
		//即时编译的模板
		$tplcode = $LABEL->compile_template($label['option']['tplcode']);
		ob_start();
		eval($tplcode);
		$content = ob_get_clean();
		
	}else{
		//变量中指定了模板
		$template = empty($var['#template#']) ? $label['option']['template'] : $var['#template#'];
		
		//用数据包含模板取得标签内容
		ob_start();
		include $LABEL->template($template);
		$content = ob_get_clean();
	}
	
	return isset($pages) ? array($content, $pages) : array($content);
}
/**
* 取得会员
**/
function label_space(&$LABEL, &$label, &$var){
	$option = &$label['option'];
	
	global $SKIN, $TEMPLATE, $RESOURCE;
	$this_system = &$this->system;
	$this_module = &$this;
	$SYSTEM = $this->system->name;
	$MODULE = $this->name;
	$core = &$this->core;
	
	$select = select();
	$select->from($this->TABLE_ .'space AS m', 'm.*');
	
	if(empty($option['uids'])){
		
		if(!empty($option['usergroup'])){
			$select->in('usergroup', $option['usergroup']);
	}
	
	if(!empty($option['username'])){
			$select->in('username', $option['username']);
	}
	//头像
	if(isset($option['avatar'])){
		$select->in('avatar', $option['avatar']);
	}//用户状态
	if(isset($option['flag'])){
		$select->in('flag', $option['flag']);
	}
		
		//排序
		if(!empty($option['order_by_string'])){
			$select->order($option['order_by_string']);
		}
		
		$page = 0;
		//总记录数
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
		//指定ID,不需分页,不使用sphinx, 排序按传入ID的顺序排
		$select->in('m.uid', $option['uids']);
		$c = range(0, count($option['uids']) -1);
		
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
		//转编码
		$list[$k] = $v = convert_encode($this->CONFIG['page_charset'], $this->core->CONFIG['page_charset'], $v);
		
		$title = str_replace('{actor}',$actor,$v['title_template']);
		
		$list[$k]['avatar'] = $this->avatar($v['uid'], 'small', true);
		$list[$k]['user_url'] = $this->url.'/space.php?uid='.$v['uid'];
	}
	
	//echo $select->build_sql();
	
	if(!empty($label['option']['tplcode']) && strlen($label['option']['tplcode']) > 10){
		//即时编译的模板
		$tplcode = $LABEL->compile_template($label['option']['tplcode']);
		ob_start();
		eval($tplcode);
		$content = ob_get_clean();
		
	}else{
		//变量中指定了模板
		$template = empty($var['#template#']) ? $label['option']['template'] : $var['#template#'];
		
		//用数据包含模板取得标签内容
		ob_start();
		include $LABEL->template($template);
		$content = ob_get_clean();
	}
	
	return isset($pages) ? array($content, $pages) : array($content);
}



/**
* 动态调用
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
	$select->from($this->TABLE_ .'feed', ' *');
	
	
	if($option['uids']){
	//多余的,
		$option['uids'] = filter_int(explode(',', $option['uids']));
		
		$select->in('uid', $option['uids']);
	}
		
	//排序
	if(!empty($option['order_by_string'])){
		$select->order($option['order_by_string']);
	}else{
		$select->order('feedid desc');
	}
	
	$list = $this->core->list_item(
		$select,
		array(
			'page_size' => 0,
			'db_obj' => &$this->db,
		)
	);

	foreach($list as $k => $v){
		//转编码
		$list[$k] = $v = convert_encode($this->CONFIG['page_charset'], $this->core->CONFIG['page_charset'], $v);
		$bodydata = mb_unserialize($v['body_data']);
		$actor = '<a href="'.$this->url.'/space.php?uid=1" target="_blank">'.$v['username'].'</a>';
		$title = str_replace('{actor}',$actor,$v['title_template']);
		
		switch($v['icon']){
			case 'blog': $title .= '：'.$this->formatUrl($bodydata['subject']);break;
			case 'album': $title .= '：'.$this->formatUrl($bodydata['album']);break;
			case 'poll': $title .= '：'.$this->formatUrl('<a href="'.$bodydata['url'].'">'.$bodydata['subject'].'</a>');break;
			case 'event': $title .= '：'.$this->formatUrl($bodydata['title']);break;
			case 'thread': $title .= '：'.$this->formatUrl($bodydata['subject']);break;
			case 'mtag': 
				$title_data = mb_unserialize($v['title_data']);
				$title = $this->formatUrl( str_replace(array('{mtag}','{field}'),array($title_data['mtag'],$title_data['field']),$title));
				break;
		}
		
		$list[$k]['title'] = $title;
	}
	if(!empty($label['option']['tplcode']) && strlen($label['option']['tplcode']) > 10){
		//即时编译的模板
		$tplcode = $LABEL->compile_template($label['option']['tplcode']);
		ob_start();
		eval($tplcode);
		$content = ob_get_clean();
		
	}else{
		//变量中指定了模板
		$template = empty($var['#template#']) ? $label['option']['template'] : $var['#template#'];
		
		//用数据包含模板取得标签内容
		ob_start();
		include $LABEL->template($template);
		$content = ob_get_clean();
	}
	
	return isset($pages) ? array($content, $pages) : array($content);
}
function formatUrl($data){
	return str_replace('href="','target="_blank" href="'.$this->url.'/',$data);
}
/**
* 生成缓存
**/
function cache(){
	return include $this->path .'call/cache_forums.call.php';
}

/**
* 头像
*/
function avatar($uid, $size = 'middle', $returnsrc = FALSE, $real = FALSE, $static = FALSE, $ucenterurl = '') {
	
	$ucenterurl = empty($ucenterurl) ? $this->CONFIG['ucenterurl'] : $ucenterurl;
	$size = in_array($size, array('big', 'middle', 'small')) ? $size : 'middle';
	$uid = abs(intval($uid));
		$uid = sprintf("%09d", $uid);
		$dir1 = substr($uid, 0, 3);
		$dir2 = substr($uid, 3, 2);
		$dir3 = substr($uid, 5, 2);
		$file = $ucenterurl.'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2).($real ? '_real' : '').'_avatar_'.$size.'.jpg';
		return $returnsrc ? $file : '<img src="'.$file.'" onerror="this.onerror=null;this.src=\''.$ucenterurl.'/images/noavatar_'.$size.'.gif\'" />';
	
}

}
