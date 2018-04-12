<?php
defined('PHP168_PATH') or die();

/**
* 列表页
**/

$this_controller->check_action('list') or message('no_privilege');

$viewself = false;
$page = isset($_GET['page'])? intval($_GET['page']): 1;
$cates = $this_module->get_category();
	//搜索开始
	$page_url = $page_url = $this_url.'#?page=?page?# ';
	$count = 0;

	$select = select();
	$select -> from("$this_module->table",'id,number,department,type,title,create_time,solve_time,status');
	
	$my_manage = $this_controller->get_acl('my_letter_manage');
//print_r($my_manage);
	$acl_where = $split = '';
	if(!$IS_FOUNDER){
		foreach($my_manage as $dep=>$tys){
			$tys=implode(',',$tys);
			if($dep)
				$acl_where .= " $split (department='$dep' AND type IN($tys))";
			else
				$acl_where .= " $split type IN($tys)";
			$split = ' OR ';	
		}
		if($acl_where){
			$acl_where = " (($acl_where) OR (visual=1 AND undisplay=0))";
			$select ->where_and();
			$select ->where($acl_where);
		}else{
			$select -> in('visual',1);
			$select -> in('undisplay',0);
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
	if($type){
		$page_param['type']=$type;
		$select -> like('type',$type);
	}
	$number = isset($_GET['number']) ? html_entities($_GET['number']) : '';
	if($number){
		$page_param['number']=$number;
		$select -> in('number',$number);
	}
	$keytype = isset($_GET['keytype'])?html_entities($_GET['keytype']):'';
	$keyword = isset($_GET['keyword']) ? html_entities(p8_html_filter($_GET['keyword'])) : '';
	if(isset($_GET['keyword'])){
		$keytypes = array('number','title');
		$page_param['keyword']=$keyword;
		if(in_array($keytype,$keytypes))
			$select -> like($keytype,$core->DB_master->escape_string($keyword));
		elseif($keytype=='create_time'){
			$select -> like('FROM_UNIXTIME(create_time)',$core->DB_master->escape_string($keyword));
		}elseif($keytype=='type'){
			foreach($cates['type'] as $tt){
				if(strpos($tt['name'],$keyword)!==false)
					$_GET['type']=$tt['id'];
			}
		}else{
            $select -> in('1',0);
        }

	}
	$type = isset($_GET['type']) ? intval($_GET['type']) : '';
	if($type){
		$page_param['type']=$type;
		$select -> like('type',$type);
	}
	$username = isset($_GET['username']) ? html_entities($_GET['username']) : '';
	if($username){
		$page_param['username']=$username;
		$select -> like('username',$username);
	}
	if(isset($_GET['status'])){
		$status =  intval($_GET['status']);
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
			'page_size' => 40
		)
	);
	
	if($page_param){
		$page_param = http_build_query($page_param);
		$page_url .=(strpos($page_url,'?')===false? '?':'&').$page_param;
	}
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => 40,
		'url' => $page_url
	));
	
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
array_push($LABEL_POSTFIX, 'letter_search');	
	
include template($this_module, 'search');
