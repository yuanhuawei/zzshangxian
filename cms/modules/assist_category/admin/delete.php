<?php
defined('PHP168_PATH') or die();
$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	

}else{

	$sid = isset($_POST['sid']) ? intval($_POST['sid']) : 0;
	if(empty($sid)) exit('[]');
	
	$select = select();
	$select->from($this_module->sort_table);
	$datas = $core->list_item($select);
	
	$childs = $this_module->get_childs($sid, $datas);
	$sids = $this_module->get_childs_id($childs);
	$sids[] = $sid;
	
	if($DB_master->query("DELETE FROM {$this_module->sort_table} WHERE id IN (". implode(',', $sids) .")")&&
		$DB_master->query("DELETE FROM {$this_module->list_table} WHERE sid IN (". implode(',', $sids) .")")){
		$this_module->cache(false, true);
			exit(jsonencode($sids));
	}
	exit('[]');
	
}