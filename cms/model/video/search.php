<?php
defined('PHP168_PATH') or die();

/**
* ������Ƶ
**/

$select = select();

//�з���
if($cid){
	$cids = array($cid);
	if(isset($category->categories[$cid]['categories'])){
		$cids = $category->get_children_ids($cid) + $cids;
	}
	$select->in('m.cid', $cids);
}

$keyword = html_entities($keyword);



if($sphinx){
	//�����sphinx����
	
	$select->from($this_module->table. ' AS i', 'i.*');
	
	//sphinx�������ֶο�������
	$select->like('i.id', $keyword);
	$select->order('i.timestamp DESC');
	
	//sphinx��ǰģ�͵�����
	$sphinx_indexes = $this_system->sphinx_indexes($MODEL);
	
	$sphinx = $this_module->CONFIG['sphinx'];
	$sphinx['index'] = $sphinx_indexes;
	
	//ȡ����
	$count = 0;
	$list = &$core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => 20,
			'sphinx' => $sphinx
		)
	);
	
}else{
	
	$select->from($this_module->table. ' AS i', 'i.*');
	
	$select->search('i.title', $keyword);
	$select->where_or();
	$select->search('i.summary', $keyword);
	$select->order('i.timestamp DESC');
	
	//ȡ����
	$count = 0;
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => 20
		)
	);
}


//��ҳ
$pages = list_page(array(
	'count' => $count,
	'page' => $page,
	'page_size' => 20,
	'url' => $page_url
));



//����URL
foreach($list as $k => $v){
	$v['#category'] = &$category->categories[$v['cid']];
	
	$list[$k]['url'] = p8_url($this_module, $v, 'view');
	$list[$k]['frame'] = attachment_url($v['frame']);
	
	//��������
	$list[$k]['category_name'] = $v['#category']['name'];
	//�����ַ
	$list[$k]['category_url'] = $v['#category']['url'];
}

include template($this_module, 'video/search');