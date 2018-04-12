<?php
defined('PHP168_PATH') or die();

/**
* 独立页入口文件
**/
$id = 0;
foreach($URL_PARAMS as $k => $v){
	switch($v){
		case 'id':
			$id = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 0;
			$PAGE_CACHE_PARAM['id'] = $id;
			break 2;
		break;
	}
}


$id or message('no_such_item');
$addcontent = $this_controller->check_action('addcontent');
$select = select();
$select->from($this_module->table, '*');
$select->in('id', $id);
$data=$core->select($select, array('single' => true));
$data or message('no_such_item');
$data['content'] = !empty($data['content']) ? attachment_url($data['content']) : '';
//SEO
$TITLE = $data['name'] .'_'. $core->CONFIG['site_name'];
$SEO_KEYWORDS = $data['keywords'];
$SEO_DESCRIPTION = $data['descrip'];

$TP = $this_controller->gettemplate($data['type'],$data['tpl_main'],$data['tpl_head'],$data['tpl_foot'],$data['tpl_mobile']);

//标签后缀
$LABEL_POSTFIX = array('page_'. $id);
//分类自定义的内容页模板

include template($this_module, $TP['main']);