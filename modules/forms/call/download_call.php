<?php
defined('PHP168_PATH') or die();

if(REQUEST_METHOD == 'POST'){
	
	$viewself = false;
	$mid = isset($_POST['mid'])? intval($_POST['mid']) : '';
	$this_module->set_model($mid) or message('no_such_model');
	if(!$this_controller->check_model_action('download',$mid) && empty($this_model['CONFIG']['viewself'])){
		message('no_model_privilege');
	}elseif(!$this_controller->check_model_action('download',$mid) && !empty($this_model['CONFIG']['viewself'])){
		$viewself = true;
	}
	
	
	//搜索开始
	$select = select();
	$select -> from("$this_module->table AS i", 'i.id, i.username, i.ip, i.timestamp, i.status');
	$select -> left_join("$this_module->data_table AS d", 'd.*','i.id=d.id');
	$select -> in('i.mid', $mid);
	if($viewself)$select -> in('i.uid',$UID);
	//搜索条件
	$mindate = isset($_POST['mindate']) ? strtotime($_POST['mindate']) : null;
	$maxdate = isset($_POST['maxdate']) ? strtotime($_POST['maxdate']) : null;
	!$mindate && $mindate = null;
	!$maxdate && $maxdate = null;
	if($mindate || $maxdate){
		$select -> range('i.timestamp', $mindate, $maxdate);
	}
	
	$username = isset($_POST['username']) ? html_entities($_POST['username']) : '';
	if($username){
		$select -> like('i.username', $username);
	}
	$selectstatus = isset($_POST['selectstatus']) ? intval($_POST['selectstatus']) : '';
	if($selectstatus){
		$select -> in('i.status', $selectstatus);
	}
	
	//自定义字段
	$F = isset($_POST['field#']) ? $_POST['field#'] : array();
	foreach($this_model['filterable_fields'] as $field=>$field_data){
		if(!empty($F[$field])){
			if($field_data['widget']=='radio' || $field_data['widget']=='select' || $field_data['widget']=='city'){
				$data[$field] = $F[$field];
				$select -> in("d.$field",$F[$field]);
			}elseif($field_data['widget']=='checkbox' || $field_data['widget']=='multi_select'){
				if(!empty($F[$field])){
					foreach($F[$field] as $v){
						if(array_key_exists($v,$field_data['data'])){
							$data[$field][] = $v;
							$select -> like("d.$field",$v);
						}
					}
				}
			}
		}
	}


	$select -> order('i.id DESC');

	//echo $select->build_sql();
	$count = 0;
	$list = $core->list_item($select);
	$status = $this_module->CONFIG['status'];
	$delimiter = $this_module->delimiter;
	$col_delimiter = $this_module->col_delimiter;
	
	foreach($list as $key=>$value){
		$fv = array();
		$fv['id'] = $value['id'];
		$fv['username'] = $value['username'];
		$fv['ip'] = $value['ip'];
		$fv['timestamp'] = date('Y-m-d h:i:s',$value['timestamp']);
		$fv['status'] = $status[$value['status']];
		//$this_module->format_data($value);
		
		foreach($this_model['fields'] as $field => $field_data){
			
			if(!isset($value[$field])) continue;
			
			switch($field_data['widget']){
				
				//分割多选项
				case 'radio':case 'select':case 'city':
					foreach($field_data['data'] as $k => $v){
						if($value[$field] == $k)$fv[$field] =  $v;
					}
				break;
				case 'checkbox':case 'multi_select':
					$tmp = explode($delimiter, $value[$field]);
					$_v = array();
					foreach($tmp as $vv){
						foreach($field_data['data'] as $k => $v){
							if($vv == $k) $_v[] = $v;
						}
					}
					$fv[$field] = implode(',',$_v);
				break;
				//上传器,编辑器要对附件地址处理
				case 'editor': case 'editor_basic': case 'editor_common':case 'ueditor': case 'ueditor_common':
					$fv[$field]  = attachment_url($value[$field]);
				break;
				
				case 'uploader': case 'image_uploader':
					$value[$field] = str_replace($delimiter,'|', attachment_url($value[$field]));
					$fv[$field] = str_replace('||','', $value[$field]);
				break;
				
				//多上传器
				case 'multi_uploader':
					$_dd = str_replace($delimiter,'|', attachment_url($value[$field]));
					$value[$field] = str_replace($col_delimiter,"\r\n" , $_dd);
					$fv[$field] = str_replace('||','', $value[$field]);
				break;	
				case 'link':
					$fv[$field] = preg_match("/^(http|https)/i",$value[$field])? $value[$field] : 'http://'.$value[$field];
				break;
				//时间选择器
				case 'textdate':
					$fv[$field] = empty($value[$field]) ? '' : date('Y-m-d',$value[$field]);
				break;
				default:
					$fv[$field] = $value[$field];
			}
			unset($value[$field]);
		}
		
		
		$fv += $fv;
		$list[$key] = $fv;
	}
	
	$head = array(
		'id'=>'id',
		'username' => $P8LANG['addname'],
		'ip' => 'IP',
		'timestamp' => $P8LANG['addtime'],
		'status' => $P8LANG['status']
	);
	foreach($this_model['fields'] as $field=>$field_data){
		$head[$field] = $field_data['alias'].($field_data['units']? "($field_data[units])" : '');
	}

	//print_r($list);exit;
	array_unshift($list,$head);
	require PHP168_PATH.'/inc/csv.class.php';
	$filename = 'forms-'.$this_model['alias'].'-'.date('Y-m-d-h-i-s', P8_TIME).'.csv';
	$csv = new P8_Csv();
	$csv->data = $list;
	$csv->file = 'php://output';
	header('Last-Modified: '. gmdate('D, d M Y H:i:s', P8_TIME) .' GMT');
	header('Pragma: no-cache');
	header('Content-type: text/csv');
	header('Content-Encoding: none');
	header('Content-Disposition: attachment; filename='. $filename);
	header('Content-type: csv');
	$csv->save();
	exit;

}