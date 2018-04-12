<?php
defined('PHP168_PATH') or die();


$inajax = P8_AJAX_REQUEST ? true : false;

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if(empty($UID)){
	$inajax ? message('ask_error_nologin') : message('ask_error_nologin', $this_system->controller);
}

if(!$this_controller->check_exists(array('id'=>$id))){
	$inajax ? message('ask_error_notallow_edit_item') : message('ask_error_notallow_edit_item', $this_system->controller);
}

//紧急问题扣除积分
$urgent_credit = intval($this_system->CONFIG['urgent_credit']);
//积分列表
$reward = explode("\r\n",$this_system->CONFIG['reply_credit']);

$select = select();
$select->from($this_module->table . ' AS I', 'I.*');
$select->inner_join($this_module->table_data . ' AS D', 'D.tel,D.info,D.content', 'D.id=I.id');
$select->in('I.id', $id);
$data = $core->select($select, array('single' => true));
//检查分类权限
if(!$this_controller->check_category_action($ACTION, $data['cid']) && !($UID == $data['uid'] && $data['status'] ==1 && $data['closed'] ==0 && $data['endtime'] >= P8_TIME)){
 $inajax ? exit("['no_category_privilege']") : message("no_category_privilege");
}
$data['tags'] = $this_controller->get_itemtags(array('id'=>$id));

$category = &$this_system->load_module('category');
$category->get_cache(true);

$json = $category->get_json();

//所属分类
$categories = '<input type="radio" value="' . $data['cid'] . '" checked="checked"/> '; 
$_categories = '';
$parents = $category->get_parents(intval($data['cid']));
foreach($parents as $k=> $v){
	$_categories .= $v['name'] . '&nbsp;&gt;&nbsp;';
}
$categories .= $_categories . $category->categories[(int)$data['cid']]['name'];

//当前位置
$position = $this_system->position . '&nbsp;&gt;&nbsp;' . $P8LANG['ask_edit'];

$sitename = $data['title'] . ' - ' . $this_system->sitename;
$keywords = $this_system->keywords;
$description = $this_system->description;

include template($this_module, 'edit');