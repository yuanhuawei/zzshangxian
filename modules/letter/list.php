<?php
defined('PHP168_PATH') or die();

/**
* 列表页
**/

$this_controller->check_action($ACTION) or message('no_privilege');

$viewself = false;
$page = isset($_GET['page'])? intval($_GET['page']): 1;
	
	//搜索开始
	$page_url = $this_url;
	$count = 0;

	$select = select();
	$select -> from("$this_module->table",'*');
	
	
	$acl_where = $split = '';
	if(!$IS_FOUNDER){
		$my_dep = $this_controller->getcatbyAct('list');
        $deps = array_keys($my_dep);

        if($this_controller->check_action('manager')){//管理员
			$my_manage = $this_controller->getcatbyAct('manager');
			$_deps = array_keys($my_manage);
			$deps = array_merge($deps,$_deps);
		}else{
            $select -> in('visual',1);
            $select -> in('undisplay',0);
            if(!empty($this_module->CONFIG['redepartment'])){
                $redepartment = intval($this_module->CONFIG['redepartment']);	
                $select->in("department",$redepartment,true);
            }
        }
		
		if($deps){
			$select -> in('department',$deps);
				//$acl_where .= " department IN($deps)";	
			}
		else{
			message('no_privilege');
		}		

	}
	$page_param = array();
	//搜索条件
	$department = isset($_GET['department']) ?  intval($_GET['department']) : '';
	if($department){
		$page_param['department']=$department;
		$select -> in('department',$department);
	}
	$type = isset($_GET['type']) ? intval($_GET['type']) : '';
	$typ = isset($_GET['typ']) ? intval($_GET['typ']) : '';
	$type = $type?$type:$typ;
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
	if(isset($_GET['keyword'])){
		$page_param['keyword']=$keyword;
		$select -> like('title',$core->DB_master->escape_string($keyword));
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
			'page_size' => 20
		)
	);

	if($page_param){
		$page_param = http_build_query($page_param);
		$page_url .= '?'.$page_param;
	}
	$page_url .= '#'.(strpos($page_url,'?')===false? '?':'&').'page=?page?# ';
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => 20,
		'url' => $page_url
	));
	$cates = $this_module->get_category();
	$id_type = $this_module->id_type();
	foreach($list as $key=>$row){
		$list[$key]['status_name'] = $P8LANG['status_'.$row['status']];
		$list[$key]['department_name'] = $cates['department'][$row['department']]['name'];
		$list[$key]['type_name'] = $cates['type'][$row['type']]['name'];
		$list[$key]['url'] = $this_router.'-view-id-'.$row['id'];
		$list[$key]['title_s'] = p8_cutstr($row['title'],44);
		$list[$key]['dp'] = $this_module->getdp($row);
	}
	$SEO_KEYWORDS = $SEO_DESCRIPTION = '';
	$TITLE = $P8LANG['letter'] .'_'. $core->CONFIG['site_name'];
	
	$tatistics = $this_module->getstatistics2();

//初始化标签
$LABEL_POSTFIX = array();
//如果分类有自己的标签后缀
array_push($LABEL_POSTFIX, 'gb_cid_'.intval($department));	
	
include template($this_module, 'list');
