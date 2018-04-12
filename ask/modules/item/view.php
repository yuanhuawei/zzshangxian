<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');

if(!in_array('id', $URL_PARAMS)){
	message('ask_error', $this_system->controller, 3);
}

$data = $endtime = $parent_categories = $CAT = $CATEGORY = $addition = $list = array();

//载入分类模块
$category = &$this_system->load_module('category');
$category->get_cache(true);

//载入答案模块
$answer = &$this_system->load_module('answer');
$answer_controller = &$core->controller($answer);

foreach($URL_PARAMS as $k => $v){
	switch($v){
		case 'id':
			$id = isset($URL_PARAMS[$k+1]) ? intval($URL_PARAMS[$k+1]) : message('ask_error', $this_system->controller, 3);
			break;
	}
}

$select = select();
$select->from($this_module->table . ' AS i', 'i.*');
$select->left_join($this_module->table_data . ' AS d', 'd.*', 'i.id=d.id');
$select->in('i.id', $id);
$data = $core->select($select, array('single' => true));

$this_controller->check_category_action($ACTION,$data['cid']) or message('no_category_privilege');

if(!empty($data)){
if($data['verify']!=1 && !$IS_FOUNDER)message('ask_not_verify', $this_system->controller, 3);
$this_module->view_record('views',$id);
}
if(array_key_exists('cid', $data)){
	$CAT = $category->get_one(array('id'=>intval($data['cid'])), true);
}
if(empty($data) || !$CAT){
	message('ask_error', $this_system->controller, 3);
}


$CATEGORY = $category->get_children_ids($CAT['id']);
array_unshift($CATEGORY, $CAT['id']);

//问题状态(1:未解决,2:续问,3:已解决),$is_closed:时间到自动关闭,$closed:管理员关闭
$is_closed = $closed =false;
$status = $data['status'];
//是否己解决
$is_solved = $status==3? true : false;
if($status != 3){
	if($data['endtime'] >= P8_TIME){
		$endtime = $this_controller->endtime($data['endtime']);
	}else{
		$is_closed = true;
	}
}
//管理员关闭后就不可回复，不可投票不可投诉
if($data['closed'])$closed = true;


//是否是本问题创建者
$is_creator = !empty($UID) && $UID==$data['uid'] ? true : false;
//当前登录用户是否已回答过问题
$is_answered = !empty($UID) && $answer->check_exists("tid='$id' AND uid='$UID'") ? true : false;
//是否有权限编辑问题
$allow_edit = ($this_controller->check_category_action('edit', $data['cid']) || $is_creator && !$closed && !$is_closed && !$is_solved) ? true : false;
//是否有权限投诉问题
$allow_poller = !$is_creator && $this_controller->check_category_action('poller', $data['cid']) ? true : false;


//是否有权限回答
$allow_answer = ($answer_controller->check_category_action('post', $data['cid'])  && !$is_creator && !$is_answered && !$is_closed && !$is_solved && !$closed) ? true : false;
//是否有权限投诉答案
$allow_poller_answer = $answer_controller->check_category_action('poller', $data['cid']) ? true : false;
//是否有权限投票最佳答案
$allow_vote_answer = ($answer_controller->check_category_action('vote', $data['cid']) && !$is_creator) ? true : false;
//提问人是否可以追问
$allow_post_follow = ($answer_controller->check_category_action('post_follow', $data['cid']) && $is_creator || $IS_FOUNDER) ? true : false;
//是否可以编辑答案
$allow_edit_answer = $answer_controller->check_category_action('edit', $data['cid']) ? true : false;
//是否可以设为最佳答案
$allow_setbest_answer = $answer_controller->check_category_action('set_best_answer', $data['cid'])? true : false;


//补充问题
$addition = $this_controller->get_addition(array('id'=>$id));

$KEYWORD = str_replace(",",' ',$data['keywords']);
//答案列表
$list = $answer->show($id,$data['cid']);
//位置导航
$position = '';
$parent_categories = $category->get_parents((int)$CAT['id']);
foreach($parent_categories as $value){
	$position .= '&nbsp;&gt;&nbsp;<a href="' .$value['url'] . '">' . $value['name'] . '</a>';
}
$position = $this_system->position . $position . '&nbsp;&gt;&nbsp; <a href="' .$CAT['url'] . '">'. $CAT['name']. '</a>'. '&nbsp;&gt;&nbsp'.$P8LANG['ask_detail'];

//SEO
$sitename = $data['title'] . ' - ' . $CAT['name'] . ' - ' . $this_system->sitename;
$meta_keywords = $data['title'] . ',' . $CAT['name'] . ',' . $this_system->meta_keywords;
$meta_description =  $data['title'] . ',' . $this_system->meta_description;

include template($this_module, 'view');