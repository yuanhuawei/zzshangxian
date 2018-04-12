<?php
defined('PHP168_PATH') or die();

/**
* 列表页
**/

//$this_controller->check_action('list') or message('no_privilege');

$viewself = false;
$page = isset($_GET['page'])? intval($_GET['page']): 1;
foreach($URL_PARAMS as $k => $v){ 
	switch($v){
		case 'page':
			$page = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 0;
		break;
	}
}
	$Letter = $core->load_module('letter');	
	$letter_controller = $core->controller($Letter);
	load_language($Letter,'global');
	//搜索开始
	$page_url = $this_url.'#-page-?page?#.html ';
	$count = 0;

	$select = select();
	$select -> from("$Letter->table",'*');
	$page_param = array();
	
	
	if(!$IS_FOUNDER){
        $my_dep = $letter_controller->getcatbyAct('list');
        $deps = array_keys($my_dep);

        if($letter_controller->check_action('manager')){//管理员
			$my_manage = $letter_controller->getcatbyAct('manager');
			$_deps = array_keys($my_manage);
			$deps = array_merge($deps,$_deps);
		}else{
            $select -> in('visual',1);
            $select -> in('undisplay',0);
            if(!empty($Letter->CONFIG['redepartment'])){
                $redepartment = intval($Letter->CONFIG['redepartment']);	
                $select->in("department",$redepartment,true);
            }
        }    
		
		if($deps){
			$select -> in('department',$deps);
				//$acl_where .= " department IN($deps)";	
			}else{
			message('no_privilege');
		}

	}
	
	//搜索条件
	$department = isset($_GET['department']) ?  intval($_GET['department']) : '';
	if($department){
		$page_param['department']=$department;
		$select -> in('department',$department);
	}
	$type = isset($_GET['type']) ? intval($_GET['type']) : '';
	if($type){
		$page_param['type']=$type;
		$select -> like('type',$type);
	}
	$number = isset($_GET['number']) ? html_entities($_GET['number']) : '';
	if($number){
		$page_param['number']=$number;
		$select -> in('number',$number);
	}
	$keyword = isset($_GET['keyword']) ? html_entities(p8_html_filter($_GET['keyword'])) : '';
	if($keyword){
		$page_param['keyword']=$keyword;
		$select -> like('title',$keyword);
	}
	$username = isset($_GET['username']) ? html_entities($_GET['username']) : '';
	if($username){
		$page_param['username']=$username;
		$select -> like('username',$username);
	}
	$status = isset($_GET['status']) ? intval($_GET['status']) : '-1';
	if($status!=-1){
		$page_param['status']=$status;
		$select -> in('status',$status);
	}
	
	$select -> order(' id DESC');
//echo $select->build_sql();	
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => 30
		)
	);

	if($page_param){
		$page_param = http_build_query($page_param);
		$page_url .='?'.$page_param;
	}
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => 30,
		'url' => $page_url
	));
	$cates = $Letter->get_category();
	$id_type = $Letter->id_type();
	foreach($list as $key=>$row){
		$list[$key]['status_name'] = $P8LANG['status_'.$row['status']];
		$list[$key]['department_name'] = $cates['department'][$row['department']]['name'];
		$list[$key]['type_name'] = $cates['type'][$row['type']]['name'];
		$list[$key]['url'] = $Letter->controller.'-view-id-'.$row['id'];
		$list[$key]['title_s'] = p8_cutstr($row['title'],44);
		$list[$key]['dp'] = $Letter->getdp($row);
	}
	$TITLE = $SEO_KEYWORDS = $SEO_DESCRIPTION = '';

	//初始化标签
	$LABEL_POSTFIX = array();
	//如果分类有自己的标签后缀
	array_push($LABEL_POSTFIX, 'letter');
	
	$tatistics = $Letter->getstatistics2();
	
include template($this_module, 'letter');
