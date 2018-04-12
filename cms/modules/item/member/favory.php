<?php
defined('PHP168_PATH') or die();



//$this_controller->check_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){

$page_url = $this_router .'-'. $ACTION .'?';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max($page, 1);

$page_url .= '&page=?page?';
$select = select();

$select->from($this_module->collection_table .' AS c', 'c.uid,c.timestamp as cts');
$select->in('c.uid', $UID);
$select->inner_join($this_module->main_table .' AS i', 'i.*', 'i.id = c.iid');
$select->order('c.timestamp DESC');

$count = 0;
//ȡ����
$list = $core->list_item(
	$select,
	array(
		'page' => &$page,
		'count' => &$count,
		'page_size' => 20,
		'ms' => 'master'
	)
);
//��ҳ
	$pages = list_page(array(
			'count' => $count,
			'page' => $page,
			'page_size' => 20,
			'url' => $page_url
		));

	include template($this_module, 'favory');
	
}else if(REQUEST_METHOD == 'POST'){
	$request_type= isset($_POST['request_type']) ? $_POST['request_type'] : '';
	switch($request_type){
		
		//ɾ���ղ�
		case 'del':
			$id = isset($_POST['id']) ? filter_int($_POST['id']) : array();
			$id or exit('[]');
			//ֻ��ɾ���Լ���
			$cond = "iid IN (". implode(',', $id) .") AND uid = '$UID'";
			
			if($DB_master->delete($this_module->collection_table , $cond)){
				exit(jsonencode($id));
			}
			exit('[]');
			break;
			
		//�����ղ�
		case 'add':
			$id = isset($_POST['id']) ? $_POST['id'] : '';
			if(preg_match("/^\\d+$/",$id)){
				$select = select();
				$select->from($this_module->collection_table);
				$select->in('iid',$id);
				$select->in('uid',$UID);
				
				$cond = array("iid" => $id, "uid" => $UID, "timestamp" => time());
				
				if($core->select($select, array('single' => true))){
					echo 0; //����0��ʾ���ղ�
				}elseif($DB_master->insert($this_module->collection_table , $cond)){
					echo 1;//����1��ʾ�ɹ�
				}else{
					echo -1;//����-1��ʾʧ��
				}
			}else{
				echo -1;//����-1��ʾʧ��
			}
			exit;
			break;
	}
}