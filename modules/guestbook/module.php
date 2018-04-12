<?php
defined('PHP168_PATH') or die();

class P8_Guestbook extends P8_Module{

var $table;
var $table_category;
var $categories;

function P8_Guestbook(&$system, $name){
	$this->system = &$system;
	parent::__construct($name);
	
	$this->table = $this->TABLE_;
	$this->table_category = $this->TABLE_ . "category";
	
}
/*���ӷ���*/
function add_category($data){
	return $this->DB_master->insert(
			$this->table_category,
			$data,
			array('return_id' => true)
	);
}
/*�޸ķ���*/
function edit_category($id,$data){
	return $this->DB_master->update(
			$this->table_category,
			$data,
			"id = '$id'"
	);
}
/*ɾ������*/
function delete_category($id){
	$where = " id ='$id'";
	$this->DB_master->delete(
			$this->table_category,
			$where
	);
	//ɾ����Ӧ���������
	$where = " cid ='$id'";
	$this->DB_master->delete(
			$this->table,
			$where
	);
}
/*��ȡ����*/
function get_category($id=''){
	global $P8LANG;
	$where = $id? " WHERE id='$id'":'';
	$query = $this->DB_master->fetch_all("SELECT * FROM $this->table_category $where");
	return $query;

}

function cache($cache_all = true, $write_cache = true, $id = 0){
	global $CACHE;
	parent::cache();
	$list = $this->DB_master->query("SELECT * FROM $this->table_category ORDER BY display_order DESC");
	$this->categories = array();
	
	while($arr = $this->DB_master->fetch_array($list)){
		if(empty($arr['url'])){
			//���ݷ������ȡ�þ��Ե�ַURL
			$arr['is_category'] = true;
			$arr['url'] = p8_url($this, $arr, 'list');
			unset($arr['is_category']);
		}
		$this->categories[$arr['id']] = $arr;

	}
	
	
	
	$this->data = array(
		'categories' => &$this->categories
	);
	if($write_cache){
		$CACHE->write(
			$this->system->name .'/modules/',
			$this->name,
			'categories',
			$this->data,
			'serialize'
		);
		$json = array(
			'json' => jsonencode($this->categories)
		);
		
		//�˵�·��
		$path = array();
		foreach($this->categories as $v){
			$tmp = array();
			$tmp[] = $v['id'];
			
			$path[$v['id']] = $tmp;
		}
		$json['path'] = jsonencode($path);
		
		$CACHE->write(
			$this->system->name .'/modules/',
			$this->name,
			'category_json',
			$json
		);
		
	}

}
/**
*ȡ�û���
**/

function get_cache($read_cache = true){
	if(!empty($this->categories)) return;
	
	global $CACHE;
	
	if(
		$read_cache &&
		$this->data = $CACHE->read(
			$this->system->name .'/modules',
			$this->name,
			'categories',
			'serialize'
		)
	){
		$this->categories = &$this->data['categories'];
	}else{
		$this->cache(false, false);
	}
}

/**
* ȡ�û����JSON
**/
function get_json(){
	global $CACHE;
	$json = $CACHE->read($this->system->name .'/modules', $this->name, 'category_json');
	return array(
		'json' => empty($json['json']) ? '{}' : $json['json'],
		'path' => empty($json['path']) ? '{}' : $json['path'],
	);
}

/*����*/
function add($data){
	return $this->DB_master->insert(
			$this->table,
			$data,
			array('return_id' => true)
	);
}
/*ȡһ��*/
function get($id){
	$where = $id? " WHERE id='$id'":'';
	return $query = $this->DB_master->fetch_one("SELECT * FROM $this->table $where");
}
/*ɾ��*/
function delete_book($where){
	$this->DB_master->delete(
			$this->table,
			$where
	);

}
/*���*/
function verify($where,$yz){
	$this->DB_master->update(
			$this->table,
			array('verified'=>$yz),
			$where
	);

}
/*����*/
function update($data,$id){
	$this->DB_master->update(
			$this->table,
			$data,
			"id = '$id'"
	);

}

/**
*��ǩ �ӿ�
**/
function label(&$LABEL, &$label, &$var){
	$option = &$label['option'];
	
	$select = select();
	$select->from($this->table .' AS i', 'i.*');
	
	
	//����
	if(!empty($option['order_by_string'])){
		$select->order($option['order_by_string']);
	}else{
		$select->order('i.id DESC');
	}
	
	if(empty($option['ids'])){
		
		//����
		if(!empty($option['category'])){
			$select->in('i.cid', $option['category']);
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
	$this->get_cache();
	
	//����URL
	foreach($list as $k => $v){
		$list[$k]['url'] = p8_url($this, $v, 'view');
		$list[$k]['full_title'] = $v['title'];
		$dot=!empty($option['title_dot'])?'...' : '';
		$list[$k]['title'] = p8_cutstr($v['title'], $option['title_length'], $dot);
		$list[$k]['summary'] =$list[$k]['content'] = p8_cutstr($v['content'], $option['summary_length'], '');
		//��������
		$list[$k]['category_name'] = $this->categories[$v['cid']]['name'];
		//����URL
		$list[$k]['category_url'] = $this->categories[$v['cid']]['url'];
	}
	
	
	
	
	
	
	//�����
	$rand = rand_str(4);
	//ÿ�еĿ��,���ڶ���
	$width = (isset($option['rows']) && $option['rows']>1) ? (100/$option['rows']-1).'%' : '99%';
	global $SKIN, $TEMPLATE, $RESOURCE;
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