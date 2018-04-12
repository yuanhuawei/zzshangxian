<?php
defined('PHP168_PATH') or die();

$IS_ADMIN or exit('false');

//header('Content-type: text/json; charset=utf-8');


define('NO_ADMIN_LOG', true);


$data = isset($_GET['data']) ? $_GET['data'] : '';
$data or exit('false');

switch($data){
	
	case 'parent':
		//��֤������
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$id or exit('false');
		
		$parent = isset($_GET['parent']) ? intval($_GET['parent']) : 0;

		$this_module->get_cache();

		//���ܰѸ������ƶ����ӷ����������
		$cids = $this_module->get_children_ids($id);
		array_push($cids, $id);

		if(in_array($parent, $cids)) exit('false');


		exit('true');
	break;
	
	case 'path':
		
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$parent = isset($_GET['parent']) ? intval($_GET['parent']) : 0;
		$path = isset($_GET['path']) ? basename($_GET['path']) : '';
		
		$orig_path = '';
		if($id){
			$cat = $DB_master->fetch_one("SELECT path FROM $this_module->table WHERE id = '$id'");
			$orig_path = basename($cat['path']);
		}
		
		//��������Ƕ�������,���HTML·���Ƿ���ϵͳ��Ŀ¼��ͻ
		if($parent == 0 && strlen($orig_path) && $orig_path != $path && is_dir($this_system->path . $path)) exit('false');
		
		exit('true');
		
	break;
}

