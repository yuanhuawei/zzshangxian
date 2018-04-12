<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');

if(!in_array('id', $URL_PARAMS)){
	message('ask_error', $this_system->controller, 3);
}

$data = $endtime = $parent_categories = $CAT = $CATEGORY = $addition = $list = array();

//�������ģ��
$category = &$this_system->load_module('category');
$category->get_cache(true);

//�����ģ��
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

//����״̬(1:δ���,2:����,3:�ѽ��),$is_closed:ʱ�䵽�Զ��ر�,$closed:����Ա�ر�
$is_closed = $closed =false;
$status = $data['status'];
//�Ƿ񼺽��
$is_solved = $status==3? true : false;
if($status != 3){
	if($data['endtime'] >= P8_TIME){
		$endtime = $this_controller->endtime($data['endtime']);
	}else{
		$is_closed = true;
	}
}
//����Ա�رպ�Ͳ��ɻظ�������ͶƱ����Ͷ��
if($data['closed'])$closed = true;


//�Ƿ��Ǳ����ⴴ����
$is_creator = !empty($UID) && $UID==$data['uid'] ? true : false;
//��ǰ��¼�û��Ƿ��ѻش������
$is_answered = !empty($UID) && $answer->check_exists("tid='$id' AND uid='$UID'") ? true : false;
//�Ƿ���Ȩ�ޱ༭����
$allow_edit = ($this_controller->check_category_action('edit', $data['cid']) || $is_creator && !$closed && !$is_closed && !$is_solved) ? true : false;
//�Ƿ���Ȩ��Ͷ������
$allow_poller = !$is_creator && $this_controller->check_category_action('poller', $data['cid']) ? true : false;


//�Ƿ���Ȩ�޻ش�
$allow_answer = ($answer_controller->check_category_action('post', $data['cid'])  && !$is_creator && !$is_answered && !$is_closed && !$is_solved && !$closed) ? true : false;
//�Ƿ���Ȩ��Ͷ�ߴ�
$allow_poller_answer = $answer_controller->check_category_action('poller', $data['cid']) ? true : false;
//�Ƿ���Ȩ��ͶƱ��Ѵ�
$allow_vote_answer = ($answer_controller->check_category_action('vote', $data['cid']) && !$is_creator) ? true : false;
//�������Ƿ����׷��
$allow_post_follow = ($answer_controller->check_category_action('post_follow', $data['cid']) && $is_creator || $IS_FOUNDER) ? true : false;
//�Ƿ���Ա༭��
$allow_edit_answer = $answer_controller->check_category_action('edit', $data['cid']) ? true : false;
//�Ƿ������Ϊ��Ѵ�
$allow_setbest_answer = $answer_controller->check_category_action('set_best_answer', $data['cid'])? true : false;


//��������
$addition = $this_controller->get_addition(array('id'=>$id));

$KEYWORD = str_replace(",",' ',$data['keywords']);
//���б�
$list = $answer->show($id,$data['cid']);
//λ�õ���
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