<?php
defined('PHP168_PATH') or die();

class P8_Opinion extends P8_Module{

var $table;			//����
var $data_table;	//��ǰģ�����ݱ�

function __construct(&$system, $name){
	$this->system = &$system;
	//��������
	parent::__construct($name);
	
	$this->table = $this->TABLE_.'item';
	$this->data_table = $this->TABLE_.'data';
	$this->comment_table = $this->TABLE_.'comment';


}

function add(&$data){
	$id = $this->DB_master->insert(
		$this->data_table,
		$this->DB_master->escape_string($data),
		array('return_id' => true)
	);

	$this->update_count($data['iid']);
	return $id;
}

function get($id){
	$sql = "SELECT * FROM {$this->data_table} WHERE id='$id'";

	return $this->DB_master->fetch_one($sql);
}

function update($data,$id){
	$this->DB_master->update(
		$this->data_table,
		$this->DB_master->escape_string($data),
		"id='$id'"
	);
}

function delete($id){
	$sql = "DELETE FROM {$this->data_table} WHERE id='$id'";
	$data = $this->get($id);
	$this->update_count($data['iid'],0);
	return $this->DB_master->query($sql);
}

function get_item($id){
	$sql = "SELECT * FROM {$this->table} WHERE id='$id'";
	$query = $this->DB_master->fetch_one($sql);
	return $query;
}


function P8_Opinion(&$system, $name){
	$this->__construct($system, $name);
}


function add_item(&$data){
	//��������ȡ��ID
	$id = $this->DB_master->insert(
		$this->table,
		$this->DB_master->escape_string($data),
		array('return_id' => true)
	);
	return $id;
}

function update_item($id, &$data){
	//��������ȡ��ID
	$this->DB_master->update(
		$this->table,
		$this->DB_master->escape_string($data),
		"id='$id'"
	);
	return true;
}
function delete_item($id){
	//��������ȡ��ID
	$this->DB_master->delete(
		$this->table,
		"id='$id'"
	);
	$this->DB_master->delete(
		$this->data_table,
		"iid='$id'"
	);
	return true;
}

function add_data(&$data){
	//��������ȡ��ID
	$id = $this->DB_master->insert(
		$this->data_table,
		$this->DB_master->escape_string($data),
		array('return_id' => true)
	);
	return $id;
}

function update_data(&$data){
	//��������ȡ��ID
	$this->DB_master->insert(
		$this->data_table,
		$this->DB_master->escape_string($data),
		"id='$id'"
	);
	return true;
}

function delete_data($id){
	//��������ȡ��ID
	$this->DB_master->delete(
		$this->data_table,
		"id='$id'"
	);
	return true;
}

function update_count($iid,$type=1){

	$data = array('post'=>$type?"post+1":"post-1");
	$this->DB_master->update(
		$this->table,
		$this->DB_master->escape_string($data),
		"id='$iid'",
		false
	);
	return true;
}
function update_view($iid,$type=1){

	$data = array('view'=>$type?"view+1":"view-1");
	$this->DB_master->update(
		$this->table,
		$this->DB_master->escape_string($data),
		"id='$iid'",
		false
	);
	return true;
}

function verify($id,$status){
	$this->DB_master->update(
		$this->data_table,
		array('status'=>$status),
		"id='$id'",
		false
	);
	return $status;

}
function accept($id,$accept){
	$this->DB_master->update(
		$this->data_table,
		array('accept'=>($accept=='-1'?0:1),'accept_desc'=>"$accept"),
		"id='$id'"
	);
	return $id;
}
function comment($data){
	return $this->DB_master->insert(
		$this->comment_table,
		$this->DB_master->escape_string($data),
		array('return_id' => true)
	);
	

}

function updown($id,$type){
	if($type==1){
		$data = array('up'=>'up+1');
	}else{
		$data = array('down'=>'down+1');
	}
	$this->DB_master->update(
		$this->data_table,
		$data,
		"id='$id'",
		false
	);
	return $id;
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