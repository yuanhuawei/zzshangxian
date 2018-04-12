<?php
defined('PHP168_PATH') or die();

/**
* 列表页
**/

$this_controller->check_action($ACTION) or message('no_privilege');
//如果魔法引号开启strip掉
$_GET = p8_stripslashes2($_GET);
$mid = 0;
$page = 1;
$viewself = false;
$mid = isset($_GET['mid'])? intval($_GET['mid']): 0;
$page = isset($_GET['page'])? intval($_GET['page']): 1;
foreach($URL_PARAMS as $k => $v){ 
	switch($v){
		case 'mid':
			$mid = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 0;
			$PAGE_CACHE_PARAM['mid'] = $mid;
		break;
		case 'page':
		$page = isset($URL_PARAMS[$k +1]) ? intval($URL_PARAMS[$k +1]) : 1;
		$page = max($page, 1);
		break;
	}
}
	if(!$mid){
		$select = select();
		$select -> from($this_module->model_table,'*');
		$select -> order('display_order DESC, id DESC');
		$list = $core->select($select);
		include template($this_module, 'select_model');
		exit;
	}
	$this_module->set_model($mid) or message('no_such_model');
	if(!$this_controller->check_model_action($ACTION,$mid) && empty($this_model['CONFIG']['viewself'])){
		message('no_model_privilege');
	}elseif(!$this_controller->check_model_action($ACTION,$mid) && !empty($this_model['CONFIG']['viewself'])){
		$viewself = true;
	}
	$download = $this_controller->check_model_action('download',$mid) || $viewself;
	$import_list = $this_controller->check_model_action('import_list',$mid);
	$manage = $this_controller->check_model_action('manage',$mid);
	
	//搜索开始
	$page_url = '';
	$count = 0;
	$accurate = isset($_GET['accurate']) ? $_GET['accurate'] : 0;
	$select = select();
	$select -> from("$this_module->table as i",'i.*');
	$select -> left_join("$this_module->data_table as d",'d.*','i.id=d.id');
	$select -> in('i.mid',$mid);
	if($this_model['verified'] != '')$select -> in('i.status',explode(",",$this_model['verified']));
	if($this_model['recommend'] == '1')$select -> in('i.recommend',1);
	if($viewself)$select -> in('i.uid',$UID);
	//搜索条件
	$mindate = isset($_GET['mindate']) ? $_GET['mindate'] : '';
	if($mindate){
		$page_url .= "&mindate=$mindate";
		$select -> range('i.timestamp',strtotime($mindate));
	}
	$maxdate = isset($_GET['maxdate']) ? $_GET['maxdate'] : '';
	if($maxdate){
		$page_url .= "&maxdate=$maxdate";
		$select -> range('i.timestamp',null,strtotime($maxdate));
	}
	$username = isset($_GET['username']) ? p8_addslashes(html_entities($_GET['username'])) : '';
	if($username){
		$page_url .= "&username=$username";
		if($accurate)
		$select -> in('i.username',$username);
		else
		$select -> like('i.username',$username);
	}
	$selectstatus = isset($_GET['selectstatus']) ? p8_addslashes(html_entities($_GET['selectstatus'])) : '';

	if($selectstatus!=''){
		$selectstatus = intval($selectstatus);
		$page_url .= "&selectstatus=$selectstatus";
		$select -> in('i.status',$selectstatus);
	}
	if(!empty($mindate) || !empty($maxdate) || !empty($username) || !empty($selectstatus)){
		$this_controller->check_action('search') or message('no_privilege');
	}
	//自定义字段过滤
	$F = isset($_GET['field#']) ? $_GET['field#'] : array();
	$F || $F=$_GET;
	foreach($this_model['filterable_fields'] as $field=>$field_data){
		if(!empty($F[$field])){
			$this_controller->check_action('search') or message('no_privilege');
			if($field_data['widget']=='text'){
				$data[$field] = html_entities($F[$field]);
				$page_url .= "&$field=$F[$field]";
				if($accurate)
				$select -> in("d.$field",p8_addslashes($F[$field]));
				else
				$select -> like("d.$field",p8_addslashes($F[$field]));
			}elseif($field_data['widget']=='radio' || $field_data['widget']=='select' || $field_data['widget']=='city'){
				$data[$field] =  html_entities($F[$field]);
				$page_url .= "&$field=$F[$field]";
				$select -> in("d.$field",p8_addslashes($F[$field]));
			}elseif($field_data['widget']=='checkbox' || $field_data['widget']=='multi_select'){
				if(!empty($F[$field])){
				if(!is_array($F[$field]))
					$F[$field] = explode('-',$F[$field]);
					$page_url .= "&{$field}=";
					$split = '';
					foreach($F[$field] as $v){
						if(array_key_exists($v,$field_data['data'])){
							$data[$field][] = $v;
							$page_url .= $split.$v;
							$select -> like("d.$field",p8_addslashes($v));
							$split = '-';
						}	
					}
				}
			}elseif($field_data['widget']=='linkage'){
				foreach($F[$field] as $k=>$vl){
						if($vl)
						$data[$field] = $vl;
				}
				if($data[$field]){
					$page_url .= "&$field=$F[$field]";
					$select -> like("d.$field",p8_addslashes($data[$field]),'left');
				}
			}
		}
	}
	
	$select -> order('i.display_order DESC, i.id DESC');
//echo $select->build_sql();	
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => 20
		)
	);
	$_page_url = p8_url($this_module, $this_model, 'list', false);
	$_page_url .= (strpos($_page_url,'&')===false? '?': '&').substr($page_url,1);
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => 20,
		'url' => $_page_url
	));
	foreach($list as $key=>$detail){
		$this_module->format_data($list[$key],80);
		$this_module->format_view($list[$key]);
		$list[$key]['url'] = p8_url($this_module,$detail,'view');
		if(!empty($this_model['CONFIG']['viewhash']))$list[$key]['url'] .= (strpos($list[$key]['url'],'?')===false?'?':'&').'viewcode='.p8_code($detail['id'].'_'.P8_TIME);
	}

	$status = $this_module->CONFIG['status'];
	$status_json = p8_json($status);
	$_SERVER['REQUEST_URI'] = xss_url($_SERVER['REQUEST_URI']);
	
	//模型自定义脚本
	include $this_model['path'] .'list.php';
	
	$SEO_KEYWORDS = $SEO_DESCRIPTION = '';
	$TITLE = $this_model['alias'].' - '.$core->CONFIG['site_name'];
	
	$template = empty($this_model['list_template'])? 'list' : 'tpl/'.$this_model['list_template'];
	include template($this_module, $template);
