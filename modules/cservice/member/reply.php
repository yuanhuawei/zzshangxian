<?php
defined('PHP168_PATH') or die();
$this_controller->check_action('admin_replay');
if(REQUEST_METHOD=='GET'){
	GetGP(array('askid','repid','replay_id','st'));//问题ID,此回复所针对的续问，本问题ID(修改时),状态
	if(!empty($replay_id))$repdb=$DB_master->fetch_one("SELECT * FROM {$this_module->table_reply} WHERE id='$replay_id'");

	include template($this_module, "reply");

}else if(REQUEST_METHOD=='POST'){
GetGP(array('askid','st'));
if(isset($_POST['setstatu'])){
	
	if($st==1){
		$this_module->set_state($askid,$st);
	}else if($st==2){
		$_POST['content'] = $_POST['title'] = $P8LANG['manage_success'];
		$this_controller->reply(&$_POST);
		$this_module->set_state($askid,$st);
	}
}else{
	$this_controller->reply(&$_POST);
}
message('done',$this_router.'-view?id='.$_POST['askid']);
}