<?php
defined('PHP168_PATH') or die();

/**
* 按属性浏览, 设置或删除属性
**/

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	$attribute = isset($_GET['attribute']) ? intval($_GET['attribute']) : 0;
	$attribute or exit('{}');
	
	$category = &$this_system->load_module('category');
	
	if(!P8_AJAX_REQUEST){
		
		$allow_attribute = $this_controller->check_admin_action($ACTION);
		
		$models = $this_system->get_models();
		//模型JSON
		$model_json = p8_json($models);
		//属性JSON
		$attributes = array();
		foreach($this_module->attributes as $aid => $lang){
			$attributes[$aid] = $P8LANG['cms_item']['attribute'][$aid];
		}
		$attr_json = p8_json($attributes);
		
		include template($this_module, 'attribute', 'admin');
		exit;
	}
	
	$page_url = $this_url .'?page=?page?';
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max($page, 1);
	
	$keyword = isset($_GET['keyword']) ? ltrim($_GET['keyword']) : '';
	
	$page_url .= '&attribute='. $attribute;
	$page_url .= '&keyword='. urlencode($keyword);
	$page_url = 'javascript:request_item(?page?)';
	
	$select = select();
	$select->from($this_module->main_table .' AS i', 'i.id, i.model, i.title, i.title_color, i.title_bold, i.cid, i.url, i.uid, i.username, i.attributes, i.pages, i.views, i.comments, i.verified, i.timestamp');
	$select->inner_join($this_module->attribute_table .' AS a', 'a.timestamp AS last_timestamp, a.last_setter', 'a.id = i.id');
	$select->inner_join($this_system->category_table .' AS c', 'c.name AS category_name', 'i.cid = c.id');
	$select->in('a.aid', $attribute);
	if(isset($_GET['cid'])){
		$category->get_cache();
		
		$cid = intval($_GET['cid']);
		if($cid){
			$select->in('a.cid', array($cid) + $category->get_children_ids($cid));
		}
	}
	$select->order('a.timestamp DESC');
	
	
	//所有模型
	$models = $this_system->get_models();
	
	$count = 0;
	$page_size = 40;
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => $page_size,
			'ms' => 'master'
		)
	);
	
	
	$json = array(
		'list' => $list,
		'pages' => list_page(array(
			'count' => $count,
			'page' => $page,
			'page_size' => $page_size,
			'url' => $page_url
		))
	);
	echo p8_json($json);
	exit;
	
	include template($this_module, 'attribute', 'admin');
	
	
	
	
	
	
	
}else if(REQUEST_METHOD == 'POST'){
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	* 批量设置或删除属性
	**/
	
	//$domain = !empty($core->CONFIG['base_domain']) ? 'document.domain = \''. $core->CONFIG['base_domain'] .'\';': '';
	$js = '<script type="text/javascript">parent.window.ajaxing({action: \'hide\'});</script>';
	
	//提交的属性
	$attribute = isset($_POST['attribute']) ? filter_int($_POST['attribute']) : array();
	!empty($attribute) or exit($js);
	
	//提交的内容ID
	$ids = isset($_POST['id']) ? filter_int($_POST['id']) : array();
	!empty($ids) or exit($js);
	
	//删除或设置
	$action = isset($_POST['act']) && $_POST['act'] == 'delete' ? 'delete' : 'set';
	
	//要设置或删除属性的内容
	$query = $DB_master->query("SELECT id, cid, model, attributes FROM $this_module->main_table WHERE id IN (". implode(',', $ids) .")");
	
	if($action == 'delete'){
		
		//删除属性
		while($arr = $DB_master->fetch_array($query)){
			//原本属性
			$_attributes = array_flip(explode(',', $arr['attributes']));
			foreach($attribute as $aid){
				unset($_attributes[$aid]);
			}
			$_attributes = implode(',', array_flip($_attributes));
			
			//更新主表属性
			$DB_master->update(
				$this_module->main_table,
				array('attributes' => $_attributes),
				"id = '$arr[id]'"
			);
			
			//更新模型表属性
			$this_module->set_model($arr['model']);
			$DB_master->update(
				$this_module->table,
				array('attributes' => $_attributes),
				"id = '$arr[id]'"
			);
		}
		
		//批量删除内容属性
		$DB_master->delete(
			$this_module->attribute_table,
			"aid IN (". implode(',', $attribute) .") AND id IN (". implode(',', $ids) .")"
		);
		
	}else{
		
		//设置内容属性
		$datas = array();
		while($arr = $DB_master->fetch_array($query)){
			//原本属性
			$_attributes = array_filter(explode(',', $arr['attributes']));
			foreach($attribute as $aid){
				$_attributes[] = $aid;
				$datas[] = array($arr['id'], $aid, $arr['cid'], $USERNAME, P8_TIME);
			}
			$_attributes = implode(',', array_unique($_attributes));
			
			//更新主表属性
			$DB_master->update(
				$this_module->main_table,
				array('attributes' => $_attributes),
				"id = '$arr[id]'"
			);
			
			//更新模型表属性
			$this_module->set_model($arr['model']);
			$DB_master->update(
				$this_module->table,
				array('attributes' => $_attributes),
				"id = '$arr[id]'"
			);
		}
		
		//批量replace into
		$DB_master->insert(
			$this_module->attribute_table,
			$datas,
			array(
				'multiple' => array('id', 'aid', 'cid', 'last_setter', 'timestamp'),
				'replace' => true
			)
		);
	}
	
	exit('<script type="text/javascript">'. $domain .'parent.request_item(parent.PAGE);</script>');
}