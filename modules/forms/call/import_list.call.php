<?php
defined('PHP168_PATH') or die();

	$mid = isset($_POST['mid'])? intval($_POST['mid']) : '';
	$this_module->set_model($mid) or message('no_such_forms_model');
	$this_controller->check_model_action('import_list',$mid) or message('no_model_privilege');
	
	if ($_FILES["csv_file"]["error"] > 0||($_FILES["csv_file"]["size"] / 1024)>10000){
		message('error');
	}
	//set_time_limit(0);
	require_once PHP168_PATH.'inc/csv.class.php';
	$csv  = new P8_Csv();
	$csv->open($_FILES["csv_file"]["tmp_name"]);
	if(!$csv->data)return;
	
	$fields = isset($_POST['fields'])? $_POST['fields'] : array();
	
	$line = isset($_POST['line'])? intval($_POST['line']) : 0;
	
	$recordfield = $RESOURCE."data/import_forms_list_".$this_model['name'].".html";
	
	
	foreach($csv->data as $key => $val){
		if($key < $line)continue;
		$val = attachment_url($val,true);
		$data = array(
			'main' => array(),
			'item' => array()
		);
		$data['main']['timestamp'] = P8_TIME;
		$data['main']['uid'] = $UID;
		$data['main']['username'] = $USERNAME;
		$data['main']['mid'] = $this_model['id'];
		$data['main']['ip'] = P8_IP;
		$data['main']['title'] = $this_model['alias'];	
		$data['main']['status'] = 9;
		$data['main']['list_order'] = P8_TIME;
		foreach($fields as $field=>$fid){
			if($fid=='')continue;
			if(!array_key_exists($field,$this_model['fields']))continue;
			$fielddb = $this_model['fields'][$field];
			$table = 'item';
			switch($fielddb['widget']){
				//单选,单选下拉框
				case 'radio': case 'select':
					foreach($fielddb['data'] as $fkey => $fdata){
						if($val[$fid] == $fdata)$data[$table][$field] = $fkey;
					}
				break;
				//多选框,多选下拉框
				case 'checkbox': case 'multi_select':
					$_myselect = explode(',',$val[$fid]);
					$_mydata = array();
					foreach($fielddb['data'] as $fkey => $fdata){
						if(in_array($fdata,$_myselect))$_mydata[] = $fkey;
					}
					$data[$table][$field] = implode(',',$_mydata);
				break;
				//时间选择器
				case 'textdate':
					$data[$table][$field] = isset($val[$fid]) ? strtotime($val[$fid]) : '';
				break;
				//上传器
				case 'uploader': case 'image_uploader':
					$tmp = explode('|', $val[$fid]);
					$data[$table][$field] = array(
						'title' => $tmp[0],
						'url' => isset($tmp[1]) ? $tmp[1] : '',
						'thumb' => isset($tmp[2]) ? $tmp[2] : ''
					);
				break; 
				
				
				//批量上传
				case 'multi_uploader':
					$tmp = explode("\r\n", $val[$field]);
			
					$data[$field] = array();
					foreach($tmp as $v){
						$v = explode("|", $v);
						$data[$field][] = array(
							'title' => $v[0],
							'url' => isset($v[1]) ? $v[1] : '',
							'thumb' => isset($v[2]) ? $v[2] : ''
						);
					}
					unset($tmp);
				break; 
				
				default:
					$data[$table][$field] = filter_word($val[$fid]);
			}
		}
		$status = $this_module->add($data);
		if(!$status)
		record('the '.$key.' is import error. the import data is "'.implode(",",$val).'"',$recordfield);
	}
	message(
		array(
			array('view', $recordfield)
		),
		$this_router.'-list',
		10000
	);
	
function record($content,$recordfield){
	$data = '['.date('Y-m-d h:i:s').']'."\t".$content.'<br>';
	write_file($recordfield,$data,'a');
}