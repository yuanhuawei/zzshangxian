<?php
defined('PHP168_PATH') or die();

/**
* 查看分类
**/



	//$select的参数
	$select_param = array();
	
	$select_param['from'] = array($this_module->table .' AS i', 'i.*');
	
	$CAT['is_category'] = true;
	
	if($CAT['htmlize'] == 2){
		$tmp = $CAT['htmlize'];
		$CAT['htmlize'] = 0;
	}
	$page_url = p8_url($this_module, $CAT, 'list', false);
	$CAT['htmlize'] = $tmp;
	
	$page_urls = $selected_fields = array();
	
	$field_filter = false;
	
	$orderby = empty($CAT['CONFIG']['orderby']) ? 'i.list_order' : $CAT['CONFIG']['orderby'];
	$orderby .= empty($CAT['CONFIG']['orderby_desc']) ? ' DESC' : ' ASC';
	
	$select_param['order'] = array($orderby);
	
	if(!empty($this_model['filterable_fields'])){
		//可过滤的自定义字段处理
		foreach($URL_PARAMS as $k => $v){
			
			if(empty($this_model['filterable_fields'][$v])) continue;
			
			$field = $this_model['filterable_fields'][$v];
			
			switch($field['type']){
			
			case 'tinyint': case 'smallint': case 'mediumint': case 'int': case 'bigint':
				
				switch($field['widget']){
				
				case 'input': case 'select': case 'radio':
					$value = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : null;
					
					$select_param['in']['i.'. $v] = array('i.'. $v, $value);
					$selected_fields[$v] = $PAGE_CACHE_PARAM[$k] = $value;
					$field_filter = true;
				break;
				
				}
				
			break;
			
			case 'decimal': case 'float':
				
				switch($field['widget']){
				
				case 'input': case 'select': case 'radio':
					$value = isset($URL_PARAMS[$k +1]) ? floatval($URL_PARAMS[$k +1]) : null;
					
					$select_param['in']['i.'. $v] = array('i.'. $v, $value);
					$selected_fields[$v] = $PAGE_CACHE_PARAM[$k] = $value;
					$field_filter = true;
				break;
				
				}
			break;
				
			}
		}
		
		
		$keyword = isset($_GET['keyword']) ? html_entities(trim($_GET['keyword'])) : '';
		if($keyword != ''){
			$PAGE_CACHE_PARAM['NO_CACHE'] = 1;
			$select_param['search'] = array('i.title', $keyword);
			$field_filter = true;
		}
	}


if(!empty($this_model['filterable_fields'])){
	
	//---------------------------------------------------------------{
	
	$CAT['filter'] = '{filter}';
	$CAT['htmlize'] = 0;
	$this_module->CONFIG['dynamic_list_url_rule'] = str_replace('{$id}', '{$id}{$filter}', $this_module->CONFIG['dynamic_list_url_rule']);
	$_page_url = p8_url($this_module, $CAT, 'list', false);
	
	
	$filter = '';
	foreach($selected_fields as $field => $value){
		$filter .= '-'. $field .'-'. $value;
	}
	$page_url = str_replace('{filter}', $filter, $_page_url);
	$_page_url = preg_replace('/#[^#]+#/', '', $_page_url);
	
	$form_url = preg_replace('/#[^#]+#/', '', $page_url);
	if($keyword != ''){
		$_page_url .= '?keyword='. urlencode($keyword);
	}
	//print_r($selected_fields);
	
	//各字段的过滤链接
	foreach($this_model['filterable_fields'] as $field => $field_data){
		//取消过滤链接(全部)
		$page_urls[$field][''] = '';
		
		foreach($selected_fields as $_field => $_value){
			if($_field == $field) continue;
			
			$page_urls[$field][''] .= '-'. $_field .'-'. $_value;
		}
		
		$page_urls[$field][''] = str_replace('{filter}', $page_urls[$field][''], $_page_url);
		
		foreach($field_data['data'] as $value => $key){
			$page_urls[$field][$value] = '';
			
			foreach($selected_fields as $_field => $_value){
				if($_field == $field) continue;
				
				$page_urls[$field][$value] .= '-' . $_field .'-'. $_value;
			}
			
			$page_urls[$field][$value] .= '-'. $field .'-'. $value;
			
			$page_urls[$field][$value] = str_replace('{filter}', $page_urls[$field][$value], $_page_url);
		}
		
	}
	
	//---------------------------------------------------------------}
	
}
	
	//当前分类的内容数
	$count = $field_filter ? 0 : $CAT['item_count'];
	
	$select = select();
	
	//最后才加载数据较大的分类数据
	$category->get_cache();

	
	//子分类
	$subcategories = array();
	if(isset($category->categories[$cid]['categories'])){
		$subcategories = $category->categories[$cid]['categories'];
		$CATEGORY = $category->get_children_ids($cid) + array($cid);
	}else{
		$CATEGORY = $cid;
	}
	
	$select->in('i.cid', $CATEGORY);
	
	//print_R($select_param);
	foreach($select_param as $func => $param){
		//$select->$func($param);
		switch($func){
		
		case 'in':
			foreach($param as $field => $_param){
				call_user_func_array(array(&$select, $func), $_param);
			}
		break;
		
		case 'range':
			foreach($param as $field => $_param){
				call_user_func_array(array(&$select, $func), $_param);
			}
		break;
		
		default:
			call_user_func_array(array(&$select, $func), $param);
		break;
		
		}
	}
	
	//print_r($this_model);
	//echo $select->build_sql();
	
	$sphinx = $this_module->CONFIG['sphinx'];
	$sphinx['index'] = $this_system->sphinx_indexes(array($MODEL => 1));
	
	$list = $core->list_item(
		$select,
		array(
			'count' => &$count,
			'page' => &$page,
			'page_size' => $CAT['page_size'],
			'sphinx' => $sphinx
		)
	);
	
	foreach($list as $k => $v){
		$v['#category'] = &$category->categories[$v['cid']];
		$list[$k]['url'] = p8_url($this_module, $v, 'view');
		$list[$k]['frame'] = attachment_url($v['frame']);
		$list[$k]['full_title'] = $v['title'];
		$tmp = explode('|', $v['sub_title']);
		$list[$k]['sub_title'] = $tmp[0];
		$list[$k]['sub_title_url'] = isset($tmp[1]) ? $tmp[1] : '';
		
		//分类名称
		$list[$k]['category_name'] = $v['#category']['name'];
		//分类URL
		$list[$k]['category_url'] = $v['#category']['url'];
		
		if(!empty($v['title_color'])) $list[$k]['title'] = '<font color="'. $v['title_color'] .'">'. $list[$k]['title'] .'</font>';
		if(!empty($v['title_bold'])) $list[$k]['title'] = '<b>'. $list[$k]['title'] .'</b>';
	}
	$page_template = !empty($CAT['CONFIG']['list_pages_template']) && isset($P8LANG[$CAT['CONFIG']['list_pages_template']]) ? $P8LANG[$CAT['CONFIG']['list_pages_template']] : '';
	if($core->ismobile)$page_template = !empty($CAT['CONFIG']['list_pages_template_mobile']) && isset($P8LANG[$CAT['CONFIG']['list_pages_template_mobile']]) ? $P8LANG[$CAT['CONFIG']['list_pages_template_mobile']] : '';
	
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => $CAT['page_size'],
		'url' => $page_url,
		'template' => $page_template,
	));



//顶级分类
$root_cate = $cid;
$parent_cats = $category->get_parents($cid);
if($parent_cats){
	$root_cate = $parent_cats[0]['id'];
	$root_cates = $category->categories[$parent_cats[0]['id']]['categories'];
}else{
	$root_cates = $subcategories;
}

/*与此字段相关的栏目*/
$filecats = array();
if(!empty($this_model['filterable_fields'])){
	foreach($selected_fields as $field => $value){
	
		$sql = "SELECT COUNT(1) AS cc,cid FROM {$this_module->table} WHERE `$field` ='$value' GROUP BY cid";
		$query = $core->DB_master->fetch_all($sql);
		if($query){
			$cids = array();
			foreach($query as $row){
				$cids[$row['cid']] = $row['cid'];
			}
			$fcatc = array();
			foreach($category->categories as $cat){
				if(in_array($cat['id'],$cids))
					$fcatc[$cat['id']] = $cat;
			}
			$filecats[$field] = $fcatc;
		}
	}	
}
//初始化标签
$LABEL_POSTFIX = array();
$ENV = $core->ismobile?'mobile':'';
//如果分类有自己的标签后缀
if(!empty($CAT['label_postfix'])) array_push($LABEL_POSTFIX, $CAT['label_postfix']);

$LINKRSS = array(
	'title' => $core->CONFIG['site_name'] .' - '. $CAT['name'],
	'url' => $this_system->controller .'/item-rss-category-'. $CAT['id']
);
//随机数
$rand = rand_str(4);
//每行的宽度,用于多列
$width = '99%';

$TITLE = $SEO_KEYWORDS = $SEO_DESCRIPTION = '';

$title_style = empty($CAT['CONFIG']['title_style']) ? 0 : $CAT['CONFIG']['title_style'];
switch($title_style){
	case 2: $TITLE = $CAT['name']; break;
	default: case 3: $TITLE = $CAT['name'] .'_'. $core->CONFIG['site_name']; break;
}
//若已开启移动设备样式，且是移动设备，则用移动模板
if($core->ismobile)$CAT['list_template'] = $CAT['list_template_mobile'];

//自定义的分类列表页模板
include template($this_module, $CAT['list_template']);
//保存页面缓存
page_cache();
exit;