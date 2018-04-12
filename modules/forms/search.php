<?php
defined('PHP168_PATH') or die();

$this_controller->check_action($ACTION) or message('no_privilege');
if(REQUEST_METHOD == 'GET'){
	$mid = isset($_GET['mid'])? intval($_GET['mid']) : 0;

	if($mid)$this_module->set_model($mid) or message('no_such_model');
	//搜索开始
	$accurate = isset($_GET['accurate']) ? $_GET['accurate'] : 0;
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = max(1, $page);
	
	
	$count = 0;
	
	$select = select();
	$select -> from("$this_module->table as i",'i.*');
	if($mid)$select -> left_join("$this_module->data_table as d",'d.*','i.id=d.id');
	if($mid)$select -> in('i.mid',$mid);
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
	$username = isset($_GET['username']) ? html_entities(p8_html_filter($_GET['username'])) : '';
	if($username){
		$page_url .= "&username=$username";
		if($accurate)
		$select -> in('i.username',$username);
		else
		$select -> like('i.username',$username);
	}
	$selectstatus = isset($_GET['selectstatus']) ? $_GET['selectstatus'] : '';

	if($selectstatus!=''){
		$selectstatus = intval($selectstatus);
		$page_url .= "&selectstatus=$selectstatus";
		$select -> in('i.status',$selectstatus);
	}
	//自定义字段过滤
	$F = isset($_GET['field#']) ? $_GET['field#'] : array();
	$F || $F=$_GET;
	if($mid){
		foreach($this_model['filterable_fields'] as $field=>$field_data){
			if(!empty($F[$field])){
				if($field_data['widget']=='text'){
					$F[$field]=html_entities($F[$field]);
					$data[$field] = $F[$field];
					$page_url .= "&$field=$F[$field]";
					if($accurate)
					$select -> in("d.$field",$F[$field]);
					else
					$select -> like("d.$field",$F[$field]);
				}elseif($field_data['widget']=='radio' || $field_data['widget']=='select' || $field_data['widget']=='city'){
					$F[$field]=html_entities($F[$field]);
					$data[$field] = $F[$field];
					$page_url .= "&$field=$F[$field]";
					$select -> in("d.$field",$F[$field]);
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
							$select -> like("d.$field",$v);
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
						$select -> like("d.$field",$data[$field],'left');
					}
				}
			}
		}
	}
	$select -> order('i.id DESC');
//echo $select->build_sql();	
	$list = $core->list_item(
		$select,
		array(
			'page' => &$page,
			'count' => &$count,
			'page_size' => 20
		)
	);
	$_page_url = $this_router .'-'. $ACTION .'?page=?page?';
	if($mid)$_page_url .= "&mid=$mid";
	$_page_url .= (strpos($_page_url,'&')===false? '?': '&').substr($page_url,1);
	$pages = list_page(array(
		'count' => $count,
		'page' => $page,
		'page_size' => 20,
		'url' => $_page_url
	));
	if($mid){
		foreach($list as $key=>$detail){
		$this_module->format_data($list[$key],36);
		$this_module->format_view($list[$key]);
		$list[$key]['url'] = p8_url($this_module,$detail,'view');
		if(!empty($this_model['CONFIG']['viewhash']))$list[$key]['url'] .= (strpos($list[$key]['url'],'?')===false?'?':'&').'viewcode='.p8_code($detail['id'].'_'.P8_TIME);
	}
	}
	$models = $this_module->core->CACHE->read('core/modules', 'forms', 'models');
	$status = $this_module->CONFIG['status'];
	$status_json = p8_json($statuses);
	
	$SEO_KEYWORDS = $SEO_DESCRIPTION = '';
	$TITLE = $P8LANG['search'];
	include template($this_module, 'search');

}else if(REQUEST_METHOD == 'POST'){
	
}