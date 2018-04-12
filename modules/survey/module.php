<?php
defined('PHP168_PATH') or die();

class P8_Survey extends P8_Module{

var $table;			//����
var $data_table;	//��ǰģ�����ݱ�

function __construct(&$system, $name){
	$this->system = &$system;
	//��������
	parent::__construct($name);
	
	$this->table = $this->TABLE_.'item';
	$this->title_table = $this->TABLE_.'title';
	$this->data_table = $this->TABLE_.'data';
	$this->addon_table = $this->TABLE_.'addon';
	//��ѡ����������
	$this->widgets = array(
		'radio'			=> 'survey_model_widget_radio',
		'checkbox'		=> 'survey_model_widget_checkbox',
		'select'		=> 'survey_model_widget_select',
		'text'			=> 'survey_model_widget_text',
		'area'			=> 'survey_model_widget_textarea',
	);
}

function P8_Survey(&$system, $name){
	$this->__construct($system, $name);
}

function get_item($id){
	$sql = "SELECT * FROM {$this->table} WHERE id='$id'";
	$query = $this->DB_master->fetch_one($sql);
	return $query;
}

function get_titles($iid){
	$sql = "SELECT * FROM {$this->title_table} WHERE iid='$iid' ORDER BY display_order ASC";
	$query = $this->DB_master->query($sql);
	
	$return = array();
	while($row = $this->DB_master->fetch_array($query)){
		$row['config'] = unserialize($row['config']);
		$row['data'] = unserialize($row['data']);
		$return[] = $row;
	}
	
	return $return;
}

function add_item(&$data){
	$id = $this->DB_master->insert(
		$this->table,
		$this->DB_master->escape_string($data),
		array('return_id' => true)
	);
	return $id;
}

function update_item($id, &$data){
	$this->DB_master->update(
		$this->table,
		$this->DB_master->escape_string($data),
		"id='$id'"
	);
	return true;
}
function delete_item($id){
	$this->DB_master->delete(
		$this->table,
		"id='$id'"
	);
	$this->DB_master->delete(
		$this->data_table,
		"iid='$id'"
	);
	$this->DB_master->delete(
		$this->addon_table,
		"iid='$id'"
	);
	return true;
}


function add_title(&$data){
	$id = $this->DB_master->insert(
		$this->title_table,
		$this->DB_master->escape_string($data),
		array('return_id' => true)
	);
	return $id;
}

function update_title($id, &$data){
	$this->DB_master->update(
		$this->title_table,
		$this->DB_master->escape_string($data),
		"id='$id'"
	);
	return true;
}
function delete_title($id){
	$this->DB_master->delete(
		$this->title_table,
		"id='$id'"
	);
	return true;
}


function add_data(&$data, &$addon){
	$id = $this->DB_master->insert(
		$this->data_table,
		$this->DB_master->escape_string($data),
		array('return_id' => true)
	);
	
	foreach($addon as $tid=>$ad){
		$ad['did'] = $id;
		$ad['tid'] = $tid;
		$ad['iid'] = $data['iid'];
		$this->DB_master->insert(
			$this->addon_table,
			$this->DB_master->escape_string($ad)
		);	
	}
	$this->cache_result($data['iid']);
	return $id;
}

function update_data(&$data){
	$this->DB_master->insert(
		$this->data_table,
		$this->DB_master->escape_string($data),
		"id='$id'"
	);
	return true;
}

function delete_data($id){
	$this->DB_master->delete(
		$this->data_table,
		"id='$id'"
	);
	$this->DB_master->delete(
		$this->addon_table,
		"did='$id'"
	);
	return true;
}

function get_data($id){
	$data = $this->DB_master->fetch_one("SELECT * FROM {$this->data_table} WHERE id='$id'");
	$query = $this->DB_master->query("SELECT * FROM {$this->addon_table} WHERE did='$id'");
	$addon = array();
	
	while($row = $this->DB_master->fetch_array($query)){
		$addon[$row['tid']] = $row;
	}
	return array('data'=>$data,'addon'=>$addon);
}

function update_count($iid,$type=1){

	$data = array('post'=>$type?'post+1':'post-1');
	$this->DB_master->update(
		$this->table,
		$data,
		"id='$iid'",
		false
	);
	return true;
}

function update_view($iid,$type=1){

	$data = array('view'=>$type?'view+1':'view-1');
	$this->DB_master->update(
		$this->table,
		$data,
		"id='$iid'",
		false
	);
	return true;
}

function cache_result($iid){

	if(!$iid) return false;
	$where = "WHERE iid IN ($iid)";
	$sql = "SELECT * FROM {$this->addon_table} $where";
	$query = $this->DB_master->query($sql);
	
	$result = array();
	while($row = $this->DB_master->fetch_array($query)){
		$data = $row['data'];
		if(preg_match('/[^\d,]+/',$data))continue;
		if(strpos($data,',')!==false){
			$_d = explode(',',$data);
			foreach($_d as $f){
				if(isset($result[$row['iid']][$row['tid']][$f]))
					$result[$row['iid']][$row['tid']][$f] += 1;
				else
					$result[$row['iid']][$row['tid']][$f] = 1;
			}
		}else{
			if(isset($result[$row['iid']][$row['tid']][$data]))
				$result[$row['iid']][$row['tid']][$data] += 1;
			else
				$result[$row['iid']][$row['tid']][$data] = 1;
		}
	}
	
	foreach($result as $i=>$da){
		$this->core->CACHE->write($this->system->name .'/modules', $this->name, 'result_'.$i, $da, 'serialize');
	}
}

function getResult($iid){
	$data = $this->core->CACHE->read($this->system->name .'/modules', $this->name, 'result_'.$iid, 'serialize');
	if(!$data)
		$this->cache_result($iid);
		
	$data = $this->core->CACHE->read($this->system->name .'/modules', $this->name, 'result_'.$iid, 'serialize');

	return $data;
}

/**
*��ǩ �ӿ�
**/
function label(&$LABEL, &$label, &$var){
	$option = &$label['option'];
	//print_r($option);
	$select = select();
	$select->from($this->table .' AS i', 'i.*');
	$lenght = intval($option['summary_length']);
	
	//����
	if(!empty($option['order_by_string'])){
		$select->order($option['order_by_string']);
	}else{
		$select->order('i.id DESC');
	}
	
	if(empty($option['ids'])){
		
		$select->in('i.status', 1);
		if(!empty($option['status'])){
			if($option['status']==1)
				$select->range('i.endtime', P8_TIME);
			if($option['status']==2)
				$select->range('i.endtime', '',P8_TIME);
		}
			
		//��ǰҳ��
		$page = 0;
		//�ܼ�¼��
		$count = 0;
		$page_size = $option['limit'];
		
		//echo $select->build_sql();
		//ȡ������
		$list = $this->core->list_item(
			$select,
			array(
				'page' => &$page,
				'page_size' => $page_size,
				'count' => &$count,
				'sphinx' => $option['sphinx']
			)
		);
		
	}else{
		//ָ��ID,�����ҳ,��ʹ��sphinx
		$select->in('i.id', $option['ids']);
		$c = range(0, count($option['ids']) -1);
		
		$list = $this->core->list_item(
			$select,
			array(
				'page_size' => 0
			)
		);
		
		$tmp = array_combine($option['ids'], $c);
		foreach($list as $v){
			$tmp[$v['id']] = $v;
		}
		
		$list = array_values($tmp);
	}
	global $SKIN, $TEMPLATE, $RESOURCE,$P8LANG;
	load_language($this, 'global');

	//����URL
	foreach($list as $k => $v){
		$list[$k]['url'] = $this->controller.'-post-id-'.$v['id'];
		$list[$k]['full_title'] = $v['title'];
		$dot=!empty($option['title_dot'])?'...' : '';
		$list[$k]['title'] = p8_cutstr($v['title'], $option['title_length'], $dot);

	}

	//�����
	$rand = rand_str(4);
	//ÿ�еĿ��,���ڶ���
	$width = (isset($option['rows']) && $option['rows']>1) ? (100/$option['rows']-1).'%' : '99%';
	
	
	$this_system = &$this->system;
	$this_module = &$this;
	$SYSTEM = $this->system->name;
	$MODULE = $this->name;
	$core = &$this->core;
	
	if(!empty($label['option']['tplcode']) && strlen($label['option']['tplcode']) > 10){
		//��ʱ�����ģ��
		$tplcode = $LABEL->compile_template($label['option']['tplcode']);
		ob_start();
		eval($tplcode);
		$content = ob_get_clean();
		
	}else{
		//������ָ����ģ��
		$template = empty($var['#template#']) ? $label['option']['template'] : $var['#template#'];
		
		//�����ݰ���ģ��ȡ�ñ�ǩ����
		ob_start();
		include $LABEL->template($template);
		$content = ob_get_clean();
	}
	
	return isset($pages) ? array($content, $pages) : array($content);
}
}