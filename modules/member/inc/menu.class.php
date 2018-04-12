<?php
defined('PHP168_PATH') or die();

/**
* 会员中心菜单类
**/

class P8_Member_Menu{

var $_data;			//存储数据的引用
var $menus;			//可供查找的数据
var $top_menus;		//顶级数据
var $core_menus;	//核心菜单
var $system_menus;	//指定某系统的菜单
var $table;			//表

function P8_Member_Menu(){
	global $core;
	$this->table = $core->TABLE_ .'member_menu';
}

function get($params){
	global $core;
	
	$params = array(
		'system' => $params['system'],
		'module' => isset($params['module']) ? $params['module'] : '',
		'action' => isset($params['action']) ? $params['action'] : '',
		'parent' => isset($params['parent']) ? $params['parent'] : null,
		'return' => isset($params['return']) && $params['return'] == 'all' ? 'all' : 'one'
	);
	
	$sql = "SELECT * FROM $this->table WHERE system = '$params[system]' AND module = '$params[module]' AND action = '$params[action]'". ($params['parent'] === null ? '' : " AND parent = '$params[parent]'");
	
	return $params['return'] == 'all' ? $core->DB_master->fetch_all($sql) : $core->DB_master->fetch_one($sql);
}

function add($data){
	global $core;
	
	$name = $data['name'];
	$parent = empty($data['parent']) ? 0 : $data['parent'];
	$system = empty($data['system']) ? 'core' : $data['system'];
	$module = empty($data['module']) ? '' : $data['module'];
	$action = empty($data['action']) ? '' : $data['action'];
	$display = !isset($data['display']) ? 1 : $data['display'];
	$front = empty($data['front']) ? 0 : 1;
	$display = !isset($data['display']) ? 1 : $data['display'];
	$url = empty($data['url']) ? '' : $data['url'];
	$target = empty($data['target']) ? '' : $data['target'];
	$top = empty($data['top']) ? '' : $data['top'];
    
    if($url && !empty($top)){
		//如果URL不为空,数据任意
		$system = '';
	}if($system != 'core' && $module == '' && $action == '' && $parent == 0){
		//每个系统菜单只能添加一次,核心无限制
		if($core->DB_master->fetch_one("SELECT * FROM $this->table WHERE system = '$system' AND module = '$module' AND action = ''"))
			return false;
	}else if($system && $module && $action == ''){
		//每个模块菜单只能添加一次
		if($core->DB_master->fetch_one("SELECT * FROM $this->table WHERE system = '$system' AND module = '$module' AND action = ''"))
			return false;
	}
	
	return $core->DB_master->insert(
		$this->table,
		array(
			'name' => $name,
			'parent' => $parent,
			'system' => $system,
			'module' => $module,
			'action' => $action,
			'display' => $display,
			'front' => $front,
			'display_order' => $display_order,
			'url' => $url,
			'target' => $target,
		),
		array('return_id' => true)
	);
}

function view($id){
	global $core;
	
	return $core->DB_master->fetch_one("SELECT * FROM $this->table WHERE id = '$id'");
}

function update($id, $data){
	global $core;
	
	$name = html_entities($data['name']);
	//有URL的情况数据可以任意,以URL为准
	$url = isset($data['url']) ? $data['url'] : '';
	$target = isset($data['target']) ? $data['target'] : '';
	$parent = isset($data['parent']) ? intval($data['parent']) : 0;
	$system = isset($data['system']) ? $data['system'] : 'core';
	$module = isset($data['module']) ? $data['module'] : '';
	$action = isset($data['action']) ? $data['action'] : '';
	$display = isset($data['display']) ? intval($data['display']) : 0;
	$front = empty($data['front']) ? 0 : 1;
	$display_order = isset($data['display_order']) ? intval($data['display_order']) : 0;
	
	$cids = $this->get_children_ids($id);
	array_push($cids, $id);
	//不能把父分类移动到子分类或者本身下面
	if(in_array($parent, $cids)) return false;
	
	if(
		$status = $core->DB_master->update(
			$this->table,
			array(
				'name' => $name,
				'parent' => $parent,
				'system' => $system,
				'module' => $module,
				'action' => $action,
				'url' => $url,
				'target' => $target,
				'display' => $display,
				'front' => $front,
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
* 删除菜单,把ID传入即可,注意,如果菜单有子菜单将全部删除
* @param int $id 菜单的ID
* @return 
**/
function delete($id){
	global $core;
	
	$cids = $this->get_children_ids($id);
	array_unshift($cids, $id);
	
	$ids = implode(',', $cids);
	
	return $core->DB_master->delete($this->table, "id IN ($ids)") ? $cids : array();
}

/**
* 生成菜单缓存
* @param bool $write 是否写缓存,如果是false,保持写缓存的格式,但是不写到缓存,一般用于实时刷新的列表
**/
function cache($write = true){
	global $core, $CACHE;
	
	$this->menus = array();
	$query = $core->DB_master->query("SELECT * FROM $this->table ORDER BY display_order DESC");
	$_menus = array();
	while($arr = $core->DB_master->fetch_array($query)){
		
		if($arr['system'] != 'core'){
			if($arr['module']){
				$info = get_module($arr['system'], $arr['module']);
			}else{
				$info = get_system($arr['system']);
			}
			$url = $arr['front'] ? $info['controller'] : $info['U_controller'];
		}else{
			if($arr['module']){
				$info = get_module('core', $arr['module']);
				$url = $arr['front'] ? $info['controller'] : $info['U_controller'];
			}else{
				$url = $arr['front'] ? $core->controller : $core->U_controller;
			}
		}
		
		if($write){
			if(!$arr['display']) continue;
			
			$_menus[$arr['id']] = $this->menus[$arr['id']] = array(
				'id' => $arr['id'],
				'system' => $arr['system'],
				'parent' => $arr['parent'],
				'name' => $arr['name'],
				'url' => empty($arr['url']) ? 
					($arr['action'] ? $url .'-'. $arr['action'] : '') :
					$arr['url']
				,
				'target' => $arr['target']
			);
			
		}else{
			$this->menus[$arr['id']] = $arr;
			
		}
	}
	
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
		$CACHE->write('core/modules', 'member', 'menu', $this->_data, 'serialize');
		
		$json = array(
			'json' => jsonencode($_top_menus),
            'json2' => p8_json($this->make_json_sort($_top_menus))
		);
		
		//菜单路径
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
		$CACHE->write('core/modules', 'member', 'menu_json', $json);
	}
}

/**
* 读取菜单缓存
**/
function get_cache(){
	global $CACHE;
	
	$this->_data = $CACHE->read('core/modules', 'member', 'menu', 'serialize');
	
	$this->menus = &$this->_data['menus'];
	$this->top_menus = &$this->_data['top_menus'];
	$this->core_menus = &$this->_data['core_menus'];
	$this->system_menus = &$this->_data['system_menus'];
}

/**
* 追溯菜单的父菜单到根
* @param int $id 菜单的ID
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
* 获得菜单全部子菜单的ID
* @param int $id 菜单的ID
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
function make_json_sort($data){
    $return = array();
    if(!is_array($data))return $return;
    foreach($data as $k=>$v){
    if(!empty($v['menus'])){
    $v['menus']=$this->make_json_sort($v['menus']);
    }
    $return[]=$v;
    }

    return $return;

}
}

$member_menu = new P8_Member_Menu();
