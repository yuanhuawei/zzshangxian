<?php
defined('PHP168_PATH') or die();

/**
* 数据过滤,将option中的选项存到数据库,同时也作SQL解析用
**/

if($action == 'explain'){
	$_POST = p8_stripslashes2(from_utf8($_POST));
}

$MODEL = empty($MODEL) ? '' : $MODEL;

//数据源模块信息
$_POST['source_system'] = $this_system->name;
$_POST['source_module'] = $this_module->name;
//标签类型为模块数据
$_POST['type'] = 'module_data';

$controller = &$core->controller($LABEL);

$option = isset($_POST['option']) && is_array($_POST['option']) ? $_POST['option'] : array();

//标签通用部分,把验证好的数据覆盖原来的数据
$option = $controller->valid_module_data_option($option) + $option;
unset($option['order_by_desc']);
$option['var_fields'] = array();

//当前模型
$option['model'] = $MODEL;



//是否开启sphinx搜索功能
!empty($option['sphinx']) && $option['sphinx']['enabled'] = 1;

//分类
$option['category'] = empty($option['category']) ? array() : $option['category'];
$option['uids'] = isset($option['uids']) ? $option['uids'] : '';

$option['timestamp'] = empty($option['timestamp']) ? array() : $option['timestamp'];
$option['timestamp'][0] = isset($option['timestamp'][0]) ? preg_replace('/[^0-9- \:]/', '', $option['timestamp'][0]) : null;
$option['timestamp'][0] = $option['timestamp'][0] === '' ? null : $option['timestamp'][0];
$option['timestamp'][1] = isset($option['timestamp'][1]) ? preg_replace('/[^0-9- \:]/', '', $option['timestamp'][1]) : null;
$option['timestamp'][1] = $option['timestamp'][1] === '' ? null : $option['timestamp'][1];
$option['timestamp']['exclude'] = empty($option['timestamp']['exclude']) ? false : true;

$option['field#'] = isset($option['field#']) && is_array($option['field#']) ? $option['field#'] : array();

//开始构造select
$select = select();

$table = $MODEL ? $this_module->table : $this_module->main_table;

if(!empty($option['attribute'])){
	//有属性
	
	$select->from($table .' AS i', 'i.*');
	$select->inner_join($this_module->attribute_table .' AS a', '', 'a.id = i.id');
	$select->in('a.aid', $option['attribute']);
	
}else{
	$select->from($table .' AS i', 'i.*');
}

$_POST['invoke'] = '$label['. $_POST['name'] .']';
$invoke = array();

//非指定ID
if(empty($option['ids'])){
	
	if(!empty($option['category'])){
		if($controller->is_var_field($option['category'])){
			//变量字段
			
			if(!empty($option['attribute'])){
				//有属性的从属性表里面检索分类
				$select->in('a.cid', html_entities($option['category']));
				$option['var_fields']['a.cid'] = array('operator' => 'in', 'var' => $option['category']);
				
				$invoke['a.cid'] = $option['category'];
			}else{
				$select->in('i.cid', html_entities($option['category']));
				$option['var_fields']['i.cid'] = array('operator' => 'in', 'var' => $option['category']);
				
				$invoke['i.cid'] = $option['category'];
			}
			
			//生成缓存时要把category项去掉
			$option['unset_options'][] = 'category';
			
		}else{
			
			$option['category'] = preg_replace('/[^0-9,]/', '', $option['category']);
			//多余的,
			$option['category'] = filter_int(explode(',', $option['category']));
			
			$cats = $option['category'];
			if(!empty($option['include_sub_category'])){
				$category = &$this_system->load_module('category');
				$category->get_cache();
				
				foreach($option['category'] as $v){
					$cats = array_merge($cats, $category->get_children_ids($v));
				}
			}
			
			if(!empty($option['attribute'])){
				//有属性的从属性表里面检索分类
				$select->in('a.cid', $cats);
			}else{
				$select->in('i.cid', $cats);
			}
			
		}
	}
	
	
	if(!empty($option['uids'])){
		if($controller->is_var_field($option['uids'])){
			//变量字段
			$option['var_fields']['i.uid'] = array('operator' => 'in', 'var' => $option['uids']);
			
			$select->in('i.uid', html_entities($option['uids']));
			
			$invoke['i.uid'] = $option['uids'];
			
			$option['unset_options'][] = 'uids';
		}else{
			$option['uids'] = filter_int(explode(',', $option['uids']));
			
			$select->in('i.uid', $option['uids']);
			
			$option['uids'] = implode(',', $option['uids']);
		}
	}
	
	if(!empty($option['keyword'])){
		$option['keyword'] = $DB_slave->escape_string($option['keyword']);
		
		if($controller->is_var_field($option['keyword'])){
			//变量字段
			$option['var_fields']['i.title'] = array('operator' => 'search', 'var' => $option['keyword']);
			
			if($action == 'explain'){
				//测试解析的
				$select->inner_join($this_module->tag_item_table .' AS ti', '', 'ti.iid = i.id');
				$select->in('ti.tid', array(0, -1));
				//$select->search('i.title', html_entities($option['keyword']));
			}
			
			$invoke['i.title'] = $option['keyword'];
			
			//$option['var_fields']['i.summary'] = array('operator' => 'search', 'var' => $option['keyword']);
			$option['unset_options'][] = 'keyword';
		}else{
			$option['keyword'] = filter_word(html_entities($option['keyword']));
			
			/*if(!empty($option['keyword_tag'])){*/
				//tag搜索
				$tag = $this_module->get_tag($option['keyword'], true);
				
				if($tag['tag_id']){
					$select->inner_join($this_module->tag_item_table .' AS ti', '', 'ti.iid = i.id');
					$select->in('ti.tid', $tag['tag_id']);
				}
			/*}else{
				$select->search('i.title', $option['keyword']);
			}*/
		}
	}
	
	//时间区意
	$select->range(
		'i.timestamp',
		empty($option['timestamp'][0]) ? null : strtotime($option['timestamp'][0]),
		empty($option['timestamp'][1]) ? null : strtotime($option['timestamp'][1]),
		$option['timestamp']['exclude']
	);
	
	//处理自定义字段
	
	if(!empty($this_model) && isset($option['field#']) && is_array($option['field#'])){
		$fields = array();
		foreach($option['field#'] as $field => $v){
			if(
				empty($this_model['fields'][$field]['list_table']) ||
				empty($v['value'])
			) continue;
			
			empty($v['op']) && $v['op'] = 'in';
			$exclude = empty($v['exclude']) ? false : true;
			
			switch($v['op']){
			
			case 'in':
				
				if($controller->is_var_field($v['value'])){
					$option['var_fields']['i.'. $field] = array('operator' => 'in', 'var' => $v['value']);
					$option['unset_options'][] = 'field#/'. $field;
					$invoke['i.'. $field] = $v['value'];
				}else{
					
				}
				$fields[$field] = array(
					'op' => 'in',
					'value' => $v['value'],
					'exclude' => $exclude
				);
				
				$select->in('i.'. $field, $v['value'], $exclude);
			break;
			
			case 'range':
				if($controller->is_var_field($v['value'])){
					$option['var_fields']['i.'. $field] = array('operator' => 'range', 'var' => $v['value']);
					$option['unset_options'][] = 'field#/'. $field;
					$invoke['i.'. $field] = $v['value'];
					
					$select->range('i.'. $field, $v['value'], $v['value'], $exclude);
				}else{
					
					$value = explode('|||', $v['value']);
					
					if(strlen(trim($value[0]))){
					}else{
						$v['value'][0] = null;
					}
					
					if(isset($value[1]) && strlen(trim($value[1]))){
					}else{
						$value[1] = null;
					}
					
					$fields[$field] = array(
						'op' => 'range',
						'value' => array(
							0 => $value[0],
							1 => $value[1],
						),
						'exclude' => $exclude
					);
					
					$select->range('i.'. $field, $value[0], $value[1], $exclude);
				}
			break;
			
			case 'search':
				if($controller->is_var_field($v['value'])){
					$option['var_fields']['i.'. $field] = array('operator' => 'search', 'var' => $v['value']);
					$option['unset_options'][] = 'field#/'. $field;
					$invoke['i.'. $field] = $v['value'];
				}
				
				$select->like('i.'. $field, $v['value'], 'all', $exclude);
				$fields[$field] = array(
					'op' => 'search',
					'value' => $v['value'],
					'exclude' => $exclude
				);
			break;
			
			}
		}
		
		$option['fields#'] = $fields; unset($fields);
	}
	
}else{
	
	//指定了ID其余的条件会被忽略
	
	$option['ids'] = filter_int(explode(',', $option['ids']));
	$select->in('i.id', $option['ids']);
}





//排序
$str = $comma = '';
foreach($option['order_by'] as $field => $desc){
	if(!isset($order_bys[$field])) continue;
	
	if($field=='d.digg' || $field=='d.trample')
		$select->left_join($this_module->TABLE_.'digg as d', 'd.digg, d.trample', 'd.iid=i.id', $index = '');
		
	$str .= $comma . $field .($desc ? ' DESC' : ' ASC');
	$comma = ',';
}

if($str){
	$select->order($str);
	$option['order_by_string'] = $str;
}

$str = $comma = '';
foreach($invoke as $field => $value){
	$str .= "$comma '$field' => $value";
	$comma = ',';
}
$_POST['invoke'] .= $str ? '{'. $str .'}' : '';

if(!empty($option['attribute'])){
	//有属性以属性的时间戳为排序条件
	$option['order_by_string'] = 'a.timestamp DESC';
	$select->order('i.timestamp DESC');
}

//限制
$select->limit(0, $option['limit']);


$_POST['option'] = $option;		//选项