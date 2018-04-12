<?php
defined('PHP168_PATH') or die();

 $this_controller->check_admin_action($ACTION) or message('no_privilege');
GetGP(array('job','action','id','postdb','listdb','ifhide','yz'));

if($action=="delete"){
	$ids=implode(",",$id);
	$where="id in($ids)";
	$status =$this_module->delete_book($where);
	echo jsonencode($id);
	exit;
}
if($action=="verify"){
	$ids=implode(",",$id);
	$where="id in($ids)";
	$status =$status =$this_module->verify($where,$yz);
	echo jsonencode($id);
	exit;
}
elseif($job=="show")
{
	$rsdb=$this_module->get($id);
	$rsdb['content']=str_replace("\r\n","<br>",$rsdb['content']);
	include template($this_module, 'show', 'admin');
}
elseif($job=="edit")
{	$category = $this_module->get_category();
	$rsdb=$this_module->get($id);
	include template($this_module, 'edit', 'admin');
}
elseif($action=="edit")
{	$this_controller->update($postdb);
	message('done');
}
elseif($job=="reply")
{
	$rsdb=$this_module->get($id);
	$rsdb['replyer'] || $rsdb['replyer']=$USERNAME;
	include template($this_module, 'reply', 'admin');
}
elseif($action=="reply")
{
	$postdb['replytime']=P8_TIME;
	$postdb['replyer']=$postdb['replyer']?html_entities($postdb['replyer']):$USERNAME;
	$postdb['reply']=html_entities($postdb['reply']);
	$this_module->update($postdb,$id);
	message('done');
}
else
{	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max($page, 1);
	$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
	$_category = $this_module->get_category();
	$page_url=$this_url.'?cid='.$cid.'&page=?page?';
	foreach($_category as $detail){
		$category[$detail['id']]=$detail;
	}
	$select = select();
	$select->from($this_module->table .' AS i', 'i.*');
	if($cid){
		$select->in('i.cid', $cid);
	}
	$select->order('i.id DESC');

	//echo $select->build_sql();
	$count = 0;
	//取数据
	$listdb = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => 20,
			'ms' => 'master'
		)
	);

	//分页
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => 20,
		'url' => $page_url
	));
	
	include template($this_module, 'list', 'admin');
}
?>