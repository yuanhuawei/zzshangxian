<?php
defined('PHP168_PATH') or die();
/**
* ��֤�����˵�
**/
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id or exit('false');

header('Content-type: text/json; charset=utf-8');

define('NO_ADMIN_LOG', true);

$parent = isset($_GET['parent']) ? intval($_GET['parent']) : 0;
require_once PHP168_PATH .'admin/inc/navigation_menu.class.php';
$navigation_menu->get_cache();
//���ܰѸ������ƶ����ӷ����������
$cids = $navigation_menu->get_children_ids($id);
array_push($cids, $id);
if(in_array($parent, $cids)) exit('false');
exit('true');