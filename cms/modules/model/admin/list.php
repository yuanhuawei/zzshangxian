<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

if(REQUEST_METHOD == 'GET'){
	
	load_language($core, 'config');
	
	$select = select();
	$select->from($this_module->table, '*');
	
	$list = $core->list_item(
		$select,
		array(
			'page_size' => 0,
			'ms' => 'master'
		)
	);
	
	include template($this_module, 'list', 'admin');

}else if(REQUEST_METHOD == 'POST'){
	
	//sphinx索引配置
	if(isset($_POST['sphinx'])){
		$item = &$this_system->load_module('item');
		require_once PHP168_PATH .'inc/sphinx_conf.php';
		
		$models = $this_system->get_models();
		
		foreach($models as $k => $v){
			
			$_REQUEST['model'] = $k;
			$this_system->init_model();
			$item->set_model($k);
			
			$data = array(
				'main' => array(),
				'delta' => array(),
				'index_path' => $SYSTEM .'/'
			);
			
			//索引名
			$data['index_name'] = $index_name = $core->CONFIG['sphinx_prefix'] . $SYSTEM .'-'. $item->name .'-'. $MODEL;
			
			if(empty($v['enabled'])){
				remove_sphinx_config_index($index_name);
				continue;
			}
			
			//可筛选字段,一定要为整数型
			$f_fields = $f_attrs = '';
			foreach($this_model['fields'] as $field => $v){
				if(!$v['list_table'] && (!$v['filterable'] || !$v['orderby'])) continue;
				$f_fields .= ', i.`'. $field .'`';
				$f_attrs .= "\r\n\tsql_attr_uint		= $field";
			}
			
			//生成索引的SQL
			$sql = <<<EOT
		SELECT i.id, i.id AS id, i.title, i.cid, i.uid, i.list_order, i.timestamp, i.views, i.comments, i.summary  $f_fields\
		FROM $item->table AS i INNER JOIN $item->addon_table AS a ON i.id = a.iid \
EOT;
			
			//查询的属性
			$data['attributes'] = <<<EOT
	sql_attr_uint		= id
	sql_attr_uint		= cid
	sql_attr_uint		= uid
	sql_attr_uint		= views
	sql_attr_uint		= comments
	sql_attr_timestamp	= timestamp
	sql_attr_timestamp	= list_order
	
	sql_attr_multi = uint tid from query; SELECT iid, tid FROM $item->tag_item_table
	$f_attrs
EOT;
			$data['main']['sql_query_pre'] = <<<EOT
	sql_query_pre			= \
		REPLACE INTO {$core->TABLE_}sphinx SELECT '$index_name', MAX(id) FROM $item->table
EOT;
			//主索引的取数据
			$data['main']['sql_query'] = <<<EOT
	sql_query			= \
$sql
		WHERE i.id <= (SELECT max_id FROM {$core->TABLE_}sphinx WHERE id = '$index_name')
EOT;
			$data['main']['sql_query_info'] = <<<EOT
	sql_query_info			= \
		SELECT * \
		FROM $item->table AS i INNER JOIN $item->addon_table AS a ON i.id = a.iid \
		WHERE i.id = \$id
EOT;
			
			$data['delta']['sql_query'] = <<<EOT
	sql_query			= \
$sql
		WHERE i.id > (SELECT max_id FROM {$core->TABLE_}sphinx WHERE id = '$index_name')
EOT;
			
			refresh_sphinx_config($data);
		}
		
		message('done');
	}
	
	
	
	
	$this_module->cache();
	
	message('done');
	
}