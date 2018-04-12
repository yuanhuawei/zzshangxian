<?php
/**
*ÏêÏ¸
**/
defined('PHP168_PATH') or die();
$this_controller->check_action($ACTION) or message('no_privilege');
if(REQUEST_METHOD == 'POST'){
	$id = isset($_POST['id'])? intval($_POST['id']) : '';
	$role_gid = isset($_POST['role_gid']) ? intval($_POST['role_gid']) : 0;
	$role_id = isset($_POST['role_id']) ? intval($_POST['role_id']) : 0;
	$keyword = isset($_POST['keyword']) ? html_entities(from_utf8($_POST['keyword'])) : '';
	$receive = isset($_POST['receive']) ? html_entities($_POST['receive']) : '';
	$status = isset($_POST['status']) ? html_entities($_POST['status']) : '';
	

	$select = select();
	$select->from($this_module->sign_in_table .' AS i', 'i.*');
	$select->inner_join($core->member_table .' AS m', 'm.id, m.username, m.name, m.role_id, m.role_gid', 'i.uid = m.id');
	$select->in('i.nid',$id);
	
	if($role_id){
		$select->in('m.role_id', $role_id);
	}else if($role_gid){
		$select->in('m.role_gid', $role_gid);
	}
	if($receive !=''){
		$select->in('i.receive',$receive);
	}
	if($status!=''){
		$select->in('i.status', $status);
	}
	if($keyword){
		if(preg_match('/[^a-zA-Z]/', $keyword)){
			$select->like('m.name', $keyword);
		}else{
			$select->like('m.pinyin', $keyword);
		}
	}
	
	
	$list = $core->list_item($select);
	
	$core->get_cache('role_group');
	$core->get_cache('role');
	$status = $this_module->CONFIG['status'];
	$_list = $content=array();
	foreach($list as $key => $val){
		$_list['id'] = $val['id'];
		$_list['name'] = empty($val['name'])?$val['username']:$val['name'];
		$_list['role_gname'] = $core->role_groups[$val['role_gid']]['name'];
		$_list['role_name'] = $core->roles[$val['role_id']]['name'];
		$_list['receive'] = $P8LANG['receive'][$val['receive']];
		$_list['status'] = $status[$val['status']];
		$_list['time'] = !empty($val['timestamp'])?date("Y-m-d h:i:s",$val['timestamp']) : '';
		$_list['comment'] = $val['comment'];
		$content[] = $_list;
	}
	include PHP168_PATH.'/inc/csv.class.php';
	$filename = 'notify-list'.date("Y-m-d-h-i-s").'.csv';
	$csv = new P8_Csv();
	$csv->data = $content;
	$csv->file = 'php://output';
	header('Last-Modified: '. gmdate('D, d M Y H:i:s', P8_TIME) .' GMT');
	header('Pragma: no-cache');
	header('Content-type: csv');
	header('Content-Encoding: none');
	header('Content-Disposition: attachment; filename='. $filename);
	header('Content-type: csv');
	$csv->save();
	exit;
}