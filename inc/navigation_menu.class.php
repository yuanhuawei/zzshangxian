<?php
/**
* ͷ�������˵���
**/

class P8_Navigation_Menu{

var $_data;			//�洢���ݵ�����
var $menus;			//�ɹ����ҵ�����
var $top_menus;		//��������
var $core_menus;	//���Ĳ˵�
var $system_menus;	//ϵͳ�Ĳ˵�
var $system_menu;	//ָ��ĳϵͳ�Ĳ˵�
var $table;			//��

function P8_Navigation_Menu(){
	$this->table = P8_TABLE_ .'navigation_menu';
}

function get($params){
	global $core;
	
	$params = array(
		'system' => $params['system'],
		'parent' => isset($params['parent']) ? $params['parent'] : null,
		'return' => isset($params['return']) && $params['return'] == 'all' ? 'all' : 'one'
	);
	
	$sql = "SELECT * FROM $this->table WHERE system = '$params[system]' AND module = '$params[module]'". ($params['parent'] === null ? '' : " AND parent = '$params[parent]'");
	
	return $params['return'] == 'all' ? $DB_master->fetch_all($sql) : $DB_master->fetch_one($sql);
}

function add($data){
	global $core;
	
	$name = $data['name'];
	$parent = empty($data['parent']) ? 0 : $data['parent'];
	$system = empty($data['system']) ? 'core' : $data['system'];
	$module = empty($data['module']) ? '' : $data['module'];
	$display = empty($data['display']) ? 1 : $data['display'];
	$display_order = empty($data['display_order']) ? 0 : $data['display_order'];
	$url = empty($data['url']) ? '' : $data['url'];
	$target = empty($data['target']) ? '' : $data['target'];
	$color = empty($data['color']) ? '' : $data['color'];

	
	if(
		$id = $DB_master->insert(
			$this->table,
			array(
				'name' => $name,
				'parent' => $parent,
				'system' => $system,
				'module' => $module,
				'display' => $display,
				'display_order' => $display_order,
				'url' => $url,
				'target' => $target,
				'color' => $color
			),
			array('return_id' => true)
		)
	){
		//$this->cache();
	}
	
	return $id;
}

function view($id){
	global $core;
	
	return $DB_master->fetch_one("SELECT * FROM $this->table WHERE id = '$id'");
}

function update($id, $data){
	global $core;
	
	$name = html_entities($data['name']);
	//��URL��������ݿ�������,��URLΪ׼
	$url = isset($data['url']) ? $data['url'] : '';
	$target = isset($data['target']) ? $data['target'] : '';
	$parent = isset($data['parent']) ? intval($data['parent']) : 0;
	$system = isset($data['system']) ? $data['system'] : 'core';
	$color = isset($data['color']) ? $data['color'] : '';
	$display = isset($data['display']) ? intval($data['display']) : 0;
	$display_order = isset($data['display_order']) ? intval($data['display_order']) : 0;
	
	$cids = $this->get_children_ids($id);
	array_push($cids, $id);
	//���ܰѸ������ƶ����ӷ�����߱�������
	if(in_array($parent, $cids)) return false;
	
	if(
		$status = $DB_master->update(
			$this->table,
			array(
				'name' => $name,
				'parent' => $parent,
				'system' => $system,
				'color' => $color,
				'url' => $url,
				'target' => $target,
				'display' => $display,
				'display_order' => $display_order
			),
			"id = '$id'"
		)
	){
		//$this->cache();
	}
	
	return $status;
}

/**
* ɾ���˵�,��ID���뼴��,ע��,����˵����Ӳ˵���ȫ��ɾ��
* @param int $id �˵���ID
* @return 
**/
function delete($id){
	global $core;
	
	$cids = $this->get_children_ids($id);
	array_unshift($cids, $id);
	
	$ids = implode(',', $cids);
	
	return $DB_master->delete($this->table, "id IN ($ids)") ? $cids : array();
}

/**
* ���ɲ˵�����
* @param bool $write �Ƿ�д����,�����false,����д����ĸ�ʽ,���ǲ�д������,һ������ʵʱˢ�µ��б�
**/
function cache($write = true){
	global $core, $CACHE;
	
	$this->menus = array();
	$query = $DB_master->query("SELECT * FROM $this->table ORDER BY display_order DESC");
	$_menus = array();
	while($arr = $DB_master->fetch_array($query)){
		$url = '/'. $arr['system'];
		$url = empty($info['bind_domain']) ? $core->U_controller .'/'. $arr['system'] : $info['bind_domain'];
		if($arr['module']){
			$url = $url .'/'. $arr['module'];
		}
		
		if($write){
			if(!$arr['display']) continue;
			
			$_menus[$arr['id']] = $this->menus[$arr['id']] = array(
				'id' => $arr['id'],
				'system' => $arr['system'],
				'parent' => $arr['parent'],
				'name' => $arr['name'],
				'url' => $arr['url'],
				'color' => $arr['color'],
				'target' => $arr['target']
			);
			
		}else{
			$this->menus[$arr['id']] = $arr;
			
		}
	}
	
	//����JSON�õ�
	$_top_menus = array();
	
	foreach($this->menus as $v){
		if($v['parent']){
			$this->menus[$v['parent']]['menus'][] = &$this->menus[$v['id']];
			
			$_menus[$v['parent']]['menus'][$v['id']] = &$_menus[$v['id']];
		}else{
			$this->top_menus[] = &$this->menus[$v['id']];
			
			$_top_menus[$v['id']] = &$_menus[$v['id']];
			
			if($v['system'] == 'core'){
				$this->core_menus[] = &$this->menus[$v['id']];
			}else{
				$this->system_menus[] = &$this->menus[$v['id']];
			}
		}
	}
	
	$this->_data = array(
		'top_menus' => &$this->top_menus,
		'core_menus' => &$this->core_menus,
		'system_menus' => &$this->system_menus,
		'menus' => &$this->menus
	);
	
	if($write){
		$CACHE->write('', 'core', 'navigation_menu', $this->_data, 'serialize');
		
		$json = array(
			'json' => jsonencode($_top_menus)
		);
		
		//�˵�·��
		$path = array();
		foreach($this->menus as $v){
			$parents = $this->get_parents($v['id']);
			$tmp = array();
			foreach($parents as $p){
				$tmp[] = $p['id'];
			}
			$tmp[] = $v['id'];
			
			$path[$v['id']] = $tmp;
		}
		$json['path'] = jsonencode($path);
		$CACHE->write('', 'core', 'navigation_menu_json', $json);
	}
	
	unset($_menus, $_top_menus);
}

/**
* ��ȡ�˵�����
**/
function get_cache(){
	global $CACHE;
	
	$this->_data = $CACHE->read('', 'core', 'navigation_menu', 'serialize');
	
	$this->menus = &$this->_data['menus'];
	$this->top_menus = &$this->_data['top_menus'];
	$this->core_menus = &$this->_data['core_menus'];
	$this->system_menus = &$this->_data['system_menus'];
}
function get_system_menus($system){
global $CACHE;
	
	$this->_data = $CACHE->read('', 'core', 'navigation_menu', 'serialize');
	$list=array();
	if($system=='core')
	{
		$list=&$this->_data['core_menus']['0']['menus'];
	}else{
		foreach($this->_data['system_menus'] as $k =>$v){
			if($v['system']==$system)$list=&$v['menus'];
		}
	}
	$this->system_menu = $this->make_full_url($list);
}
function make_full_url($data){
	global $core;
	foreach((array)$data as $k => $v){
		if(!empty($v['menus']))$data[$k]['menus']=$this->make_full_url($v['menus']);
		if(strstr($v['url'],"http"))continue;
		$data[$k]['url']=$core->url.'/'.$v['url'];
		
	}
	return $data;
}
/**
* ׷�ݲ˵��ĸ��˵�����
* @param int $id �˵���ID
* @return array 
**/
function get_parents($id){
	
	if(empty($this->menus[$id]['parent'])) return array();
	
	$p = $this->menus[$id]['parent'];
	$ps = array();
	while($p){
		array_unshift($ps, $this->menus[$p]);
		unset($ps[0]['menus']);
		$p = $this->menus[$p]['parent'];
	}
	return $ps;
}

/**
* ��ò˵�ȫ���Ӳ˵���ID
* @param int $id �˵���ID
* @return array 
**/
function get_children_ids($id){
	if(empty($this->menus[$id]['menus'])) return array();
	
	$ids = array();
	foreach($this->menus[$id]['menus'] as $v){
		$ids[$v['id']] = $v['id'];
		if(isset($v['menus']))
			$ids = $ids + $this->get_children_ids($v['id']);
	}
	
	return $ids;
}

}

$navigation_menu = new P8_Navigation_Menu();