<?php
defined('PHP168_PATH') or die();

class P8_Role extends P8_Module{

var $table;
var $acl_table;
var $group_table;

var $_data;
var $roles;				//按ID访问的角色
var $system_roles;		//按系统访问的角色	system_roles['系统']['角色类型']
var $type_roles;		//按类型访问的角色	type_roles['角色类型']['系统']
var $group_roles;		//按组访问的角色	type_roles['角色类型']['系统']['角色类型']
var $groups;			//角色组
var $last_cache;		//最后一次更新权限缓存的时间戳
var $group_field_table;

function __construct(&$system, $name){
	$this->system = &$system;
	//没有配置
	$this->configurable = false;
	parent::__construct($name);
	
	$this->table = $this->core->TABLE_ .'role';
	$this->group_table = $this->core->TABLE_ .'role_group';
	$this->acl_table = $this->core->TABLE_ .'acl';
	
	$this->last_cache = '@'. $this->core->CONFIG['last_acl_cache'];
	
	$this->group_field_table = $this->TABLE_ .'group_field';
	
	//可选的字段类型 类型 => 语言包键值
	$this->group_field_types = array(
		'tinyint'		=> 'role_group_field_type_tinyint',
		'smallint'		=> 'role_group_field_type_smallint',
		'mediumint'		=> 'role_group_field_type_mediumint',
		'int'			=> 'role_group_field_type_int',
		'bigint'		=> 'role_group_field_type_bigint',
		
		'decimal'		=> 'role_group_field_type_decimal',
		
		'char'			=> 'role_group_field_type_char',
		'varchar'		=> 'role_group_field_type_varchar',
		
		'text'			=> 'role_group_field_type_text',
		'mediumtext'	=> 'role_group_field_type_mediumtext',
		'longtext' 		=> 'role_group_field_type_longtext'
	);
	
	//可选的输入类型
	$this->widgets = array(
		'text'			=> 'role_group_widget_text',
		'textarea'		=> 'role_group_widget_textarea',
		
		'radio'			=> 'role_group_widget_radio',
		'checkbox'		=> 'role_group_widget_checkbox',
		
		'multi_select'	=> 'role_group_widget_multi_select',
		'select'		=> 'role_group_widget_select',
		
		/* 'uploader'		=> 'role_group_widget_uploader',
		
		'editor'		=> 'role_group_widget_editor',
		'editor_basic'	=> 'role_group_widget_editor_basic',
		'editor_common'	=> 'role_group_widget_editor_common' */
	);
}

function P8_Role(&$system, $name){
	$this->__construct($system, $name);
}

/**
* 以ID获得角色
**/
function get_by_id($id){
	return isset($this->roles[$id]) ? $this->roles[$id] : array();
}

function get_by_group($id, $system = 'core'){
	if(empty($system)){
		return isset($this->group_roles[$id]) ? $this->group_roles[$id] : array();
	}else{
		return isset($this->group_roles[$id][$system]) ? $this->group_roles[$id][$system] : array();
	}
}

/**
* 以系统获得角色
* 可以用类型来过滤
**/
function get_by_system($system, $type = ''){
	if(empty($type)){
		return isset($this->system_roles[$system]) ? $this->system_roles[$system] : array();
	}else{
		return isset($this->system_roles[$system][$type]) ? $this->system_roles[$system][$type] : array();
	}
}

/**
* 以类型获得角色
* 可以用系统来过滤
**/
function get_by_type($type, $system = 'core'){
	if(empty($system)){
		return isset($this->type_roles[$type]) ? $this->type_roles[$type] : array();
	}else{
		return isset($this->type_roles[$type][$system]) ? $this->type_roles[$type][$system] : array();
	}
}

function get_cache($refresh = false){
	
	if($refresh){
		$this->cache();
	}else{
		global $CACHE;
		
		if($this->_data = $CACHE->read('core/modules', 'role', 'roles', 'serialize')){
			$this->roles = &$this->_data['roles'];
			$this->system_roles = &$this->_data['system_roles'];
			$this->type_roles = &$this->_data['type_roles'];
			$this->group_roles = &$this->_data['group_roles'];
		}else{
			$this->cache();
		}
	}
}

function get_group_cache(){
	global $CACHE;
	
	$this->groups = $CACHE->read('core/modules', 'role', 'groups');
}

/**
* 生成缓存
**/
function cache(){
	//parent::cache();
	
	//$this->cache_acl();
	//$this->cache_role();
	//$this->cache_group();
}

/**
* 缓存角色
**/
function cache_role($postfix=''){
	$query = $this->DB_master->query("SELECT * FROM $this->table ORDER BY display_order DESC, id ASC");
	
	$this->system_roles = array();
	$this->type_roles = array('system' => array(), 'normal' => array());
	$this->roles = array();
	while($arr = $this->DB_master->fetch_array($query)){
		$this->roles[$arr['id']] = $arr;
	}
	
	//生成引用
	foreach($this->roles as $v){
		if(!isset($this->system_roles[$v['system']])){
			$this->system_roles[$v['system']] = array('system' => array(), 'normal' => array());
		}
		if(!isset($this->group_roles[$v['gid']][$v['system']])){
			$this->group_roles[$v['gid']][$v['system']] = array('system' => array(), 'normal' => array());
		}
		$this->system_roles[$v['system']][$v['type']][$v['id']] = &$this->roles[$v['id']];
		$this->type_roles[$v['type']][$v['system']][$v['id']] = &$this->roles[$v['id']];
		$this->group_roles[$v['gid']][$v['system']][$v['type']][$v['id']] = &$this->roles[$v['id']];
		
		$this->set_menu_privilege($v['id'],$postfix);
	}
	
	$this->_data = array(
		'roles' => &$this->roles,
		'system_roles' => &$this->system_roles,
		'type_roles' => &$this->type_roles,
		'group_roles' => &$this->group_roles
	);
	
	global $CACHE;
	
	$CACHE->write('core/modules', 'role', 'roles', $this->_data, 'serialize');
}

/**
* 缓存角色组
**/
function cache_group(){
	global $CACHE;
	
	$query = $this->DB_master->query("SELECT * FROM $this->group_table ORDER BY display_order DESC, id ASC");
	
	$this->groups = array();
	while($arr = $this->DB_master->fetch_array($query)){
		$this->groups[$arr['id']] = array(
			'id' => $arr['id'],
			'name' => $arr['name'],
			'default_role' => $arr['default_role'],
			'registrable' => $arr['registrable'],
			'display_order' => $arr['display_order']
		);
		
		$_group = $arr;
		$fields = array();
		$field_query = $this->DB_master->query("SELECT * FROM $this->group_field_table WHERE gid = '$arr[id]'");
		while($field = $this->DB_master->fetch_array($field_query)){
			$fields[$field['name']] = $field;
			
			switch($field['widget']){
				case 'checkbox':
				case 'multi_select':
				case 'multi_uploader':
					//多选以,分隔
					$_default = array();
					foreach(array_filter(explode("\r\n", $field['default_value'])) as $v){
						$_default[$v] = $v;
					}
					$fields[$field['name']]['default_value'] = $_default;
				break;
			}
			unset($fields[$field['name']]['name']);
			$fields[$field['name']]['data'] = mb_unserialize($field['data']);
		}
		$_group['fields'] = $fields;
		
		$CACHE->write('core/modules', 'role', 'group_'. $arr['id'], $_group, 'serialize');
	}
	
	$CACHE->write('core/modules', 'role', 'groups', $this->groups);
}
/**
* 分卷生成权限表的缓存
**/
function cache_acl_step($n, $tn, $on){
	global $CACHE;
	$query = $this->DB_master->fetch_all("SELECT * FROM $this->acl_table LIMIT $n,100");
	if(!$query) return false;
	foreach($query as $key=>$arr){
		
		$path = $arr['module'] ? $arr['system'] .'/modules/'. $arr['module'] : $arr['system'];
		$filepre = 'role_'. $arr['role_id'];
		//有后缀的
		$fielname = $arr['postfix'] ? $filepre .'#'. $arr['postfix'] : $filepre;
		$data = mb_unserialize($arr['v']);
		$CACHE->write($path, 'acl', $fielname . $tn, $data);
		//删除上次缓存的
		$CACHE->delete($path, 'acl', $fielname . $on);
	}	
		return true;	
}

/**
* 生成权限表的缓存
**/
function cache_acl(){
	$query = $this->DB_master->query("SELECT * FROM $this->acl_table");
	$acls = array();
	while($arr = $this->DB_master->fetch_array($query)){
		$acls[$arr['system']][$arr['module']][$arr['role_id']][$arr['postfix']] = mb_unserialize($arr['v']);
	}
	
	$last_cache = '@'. $this->core->CONFIG['last_acl_cache'];
	//设置上次权限更新缓存时间
	if(!defined('P8_CLUSTER')){
		$this->core->set_config(array(
			'last_acl_cache' => P8_TIME
		));
		$this->last_cache = '@'. P8_TIME;
	}
	
	//文件将被写到各系统/模块缓存目录中的acl目录里
	global $CACHE;
	foreach($acls as $system => $v){
		//系统
		$vkey = $system;
		foreach($v as $module => $vv){
			//系统 or 模块权限
			$vvkey = $module ? $vkey .'/modules/'. $module : $vkey;
			
			foreach($vv as $role_id => $vvv){
				//角色ID
				$vvvkey = 'role_'. $role_id;
				foreach($vvv as $postfix => $vvvv){
					//有后缀的
					$vvvvkey = $postfix ? $vvvkey .'#'. $postfix : $vvvkey;
					
					$CACHE->write($vvkey, 'acl', $vvvvkey . $this->last_cache, $vvvv);
					
					//删除上次缓存的
					$CACHE->delete($vvkey, 'acl', $vvvvkey . $last_cache);
				}
			}
		}
	}
}

function view($id){
	return $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE id = '$id'");
}

/**
* 添加角色
**/
function add($data){
	
	if($id = $this->DB_master->insert($this->table, $data, array('return_id' => true))){
		$group = $this->view_group($data['gid']);
		if(empty($group['default_role'])){
			//如果所属角色组没有默认角色组
			$this->DB_master->update(
				$this->group_table,
				array('default_role' => $id),
				"id = '$data[gid]'"
			);
		}
		
		//添加空的权限
		$se = serialize(array('admin_actions' => array('_' => false), 'actions' => array('_' => false)));
		$acls = array();
		$systems = $this->core->systems + array('core' => '');
		
		foreach($systems as $sys => $v){
			
			$path = $sys == 'core' ? PHP168_PATH : PHP168_PATH . $sys .'/';
			
			$info = @include $path .'#.php';
			$acl['admin_actions'] = array();
			foreach($info['admin_actions'] as $a => $name){
				$acl['admin_actions'][$a] = false;
			}
			
			$acl['actions'] = array();
			foreach($info['actions'] as $a => $name){
				$acl['actions'][$a] = false;
			}
			
			$acls[] = array(
				'system' => $sys,
				'module' => '',
				'role_id' => $id,
				'v' => serialize($acl)
			);
			
			foreach(get_modules($sys) as $mod => $vv){
				
				$_path = $path .'modules/'. $mod .'/';
				
				$info = @include $_path .'#.php';
				$acl['admin_actions'] = array();
				foreach($info['admin_actions'] as $a => $name){
					$acl['admin_actions'][$a] = false;
				}
				
				$acl['actions'] = array();
				foreach($info['actions'] as $a => $name){
					$acl['actions'][$a] = false;
				}
				
				$acls[] = array(
					'system' => $sys,
					'module' => $mod,
					'role_id' => $id,
					'v' => serialize($acl)
				);
			}
		}
		
		$this->DB_master->insert(
			$this->acl_table,
			$acls,
			array(
				'multiple' => array('system', 'module', 'role_id', 'v')
			)
		);
	}
	return $id;
}

/**
* 修改角色
**/
function update($id, $data){
	
	return $this->DB_master->update($this->table, $data, "id = '$id'");
}

/**
* 删除角色
**/
function delete($id){
	if($status = $this->DB_master->delete($this->table, "id = $id")){
		$this->delete_acl_by_role($id);
	}
	
	return $status;
}

function view_group($id){
	return $this->DB_master->fetch_one("SELECT * FROM $this->group_table WHERE id = '$id'");
}

/**
* 添加角色组
**/
function add_group($data){
	
	if(
		$id = $this->DB_master->insert($this->group_table, $data, array('return_id' => true))
	){
		
		require_once PHP168_PATH .'install/install.func.php';
		
		$sql = get_install_sql(
			$this->DB_master,
			file_get_contents($this->path .'install/group_sql.php'),
			$this->TABLE_ .'group_'. $id .'_',
			true
		);
		
		foreach($sql as $v){
			$this->DB_master->query($v);
		}
		
		return $id;
	}
	
	return false;
}

/**
* 修改角色组
**/
function update_group($id, $data){
	
	return $this->DB_master->update($this->group_table, $data, "id = '$id'");
}

/**
* 删除角色组
**/
function delete_group($id){
	if($status = $this->DB_master->delete($this->group_table, "id = '$id'")){
		//删除字段及数据表
		$this->DB_master->delete($this->group_field_table , "gid = '$id'");
		$this->DB_master->query("DROP TABLE {$this->TABLE_}group_{$id}_data");
		
	}
	return $status;
}

/**
* 添加角色组字段
**/
function add_group_field(&$data){
	if(
		$status = $this->DB_master->insert(
			$this->group_field_table,
			$data
		)
	){
		$field = $this->group_field_sql($data);
		
		$status = $this->DB_master->query("ALTER TABLE {$this->TABLE_}group_{$data['gid']}_data ADD `$data[name]` $field");
		
		return $status;
	}
	
	return false;
}

/**
* 修改角色组字段
**/
function update_group_field($id, &$data){
	
	$gid = $data['gid'];
	unset($data['gid']);
	
	if(
		$status = $this->DB_master->update(
			$this->group_field_table,
			$data,
			"id = '$id'"
		)
	){
		$field = $this->group_field_sql($data);
		
		$status = $this->DB_master->query("ALTER TABLE {$this->TABLE_}group_{$gid}_data CHANGE `$data[name]` `$data[name]` $field");
		
		return $status;
	}
	
	return false;
}

/**
* 删除角色组字段
**/
function delete_group_field($fid){
	
	$field = $this->DB_master->fetch_one("SELECT * FROM $this->group_field_table WHERE id = '$fid'");
	
	if(empty($field)) return false;
	
	if(
		$this->DB_master->delete(
			$this->group_field_table,
			"id = '$fid'"
		)
	){
		
		return $this->DB_master->query("ALTER TABLE {$this->TABLE_}group_{$field['gid']}_data DROP COLUMN `$field[name]`");
	}
	return false;
}

/**
* 连接字段的SQL
**/
function group_field_sql(&$data){
	$field = $data['type'];
	
	switch($data['type']){
		case 'tinyint': case 'smallint': case 'mediumint': case 'int': case 'bigint': case 'demical': case 'float': case 'double':
			
			if(!$data['length']) $data['length'] = 0;
			
			$field .= " ($data[length])";
			
			if($data['is_unsigned']){
				$field .= ' unsigned';
			}
			
		break;
		
		case 'char': case 'varchar': 
			if(!$data['length']) $data['length'] = 0;
			
			$field .= " ($data[length])";
			
		break;
		
		case 'tinytext': case 'text': case 'mediumtext': case 'longtext':
			
		break;
	}
	
	if($data['not_null']){
		$field .= ' NOT NULL';
	}
	
	return $field;
}












/**
* 设置访问控制,基于系统/模块,角色,多对多的映射关系
* @param string $system 要设置权限的系统
* @param string $module 要设置权限的模块
* @param int $role_id 角色ID
* @param array $acl 访问控制列表
* @param array $info #.php中的信息
* @parma string $postfix 后缀
* @return boolean
**/
function set_acl($system, $module, $role_id, $acl, $info, $postfix = ''){
	$acl_db = $this->DB_master->fetch_one("SELECT v FROM $this->acl_table WHERE system = '$system' AND module = '$module' AND role_id = '$role_id' AND postfix = '$postfix'");
	
	//从数据库里面取出来的
	$acl_db = $acl_db ? mb_unserialize($acl_db['v']) : array();
	
	//如果ACTION权限都不为空, 为空就不写ACTION权限
	if(!empty($acl['admin_actions'])){
		foreach($info['admin_actions'] as $k => $v){
			$acl_db['admin_actions'][$k] = empty($acl['admin_actions'][$k]) ? false : true;
		}
		if(empty($info['admin_actions'])) $acl_db['admin_actions'] = array();
	}
	
	if(!empty($acl['actions'])){
		foreach($info['actions'] as $k => $v){
			$acl_db['actions'][$k] = empty($acl['actions'][$k]) ? false : true;
		}
		if(empty($info['actions'])) $acl_db['actions'] = array();
	}
	unset($acl['admin_actions'], $acl['actions']);
	//处理完动作
	
	if(!empty($acl)){
		//处理其他细节权限设置
		foreach($acl as $k => $v){
			$acl_db[$k] = $v;
		}
	}
	
	//replace into
	$status = $this->DB_master->insert(
		$this->acl_table,
		array(
			'system' => $system,
			'module' => $module,
			'postfix' => $postfix,
			'role_id' => $role_id,
			'v' => $this->DB_master->escape_string(serialize($acl_db))
		),
		array(
			'replace' => true
		)
	);
	
	$path = empty($module) ? $system : $system .'/modules/'. $module;
	
	global $CACHE;
	$CACHE->write($path, 'acl', 'role_'. $role_id .($postfix ? '#'. $postfix : ''). $this->last_cache, $acl_db);
	
	return $status;
}

/**
* 根据权限设置菜单的显示
* @param int $role_id 角色ID
**/
function set_menu_privilege($role_id, $postfix=''){
	global $admin_menu, $member_menu;
	
	static $admin_menus = array(), $member_menus = array();
	if(empty($admin_menus)){
		$query = $this->DB_master->query("SELECT * FROM {$this->core->TABLE_}admin_menu");
		while($v = $this->DB_master->fetch_array($query)){
			if(($pos = strpos($v['action'], '?')) !== false) $v['action'] = substr($v['action'], 0, $pos);
			
			$admin_menus[$v['system'] .'-'. $v['module'] .'-'. $v['action']][] = $v;
		}
		
		$query = $this->DB_master->query("SELECT * FROM {$this->core->TABLE_}member_menu");
		while($v = $this->DB_master->fetch_array($query)){
			if(($pos = strpos($v['action'], '?')) !== false) $v['action'] = substr($v['action'], 0, $pos);
			
			$member_menus[$v['system'] .'-'. $v['module'] .'-'. $v['action']][] = $v;
		}
	}
	$postfix_where = $postfix?" AND (postfix = '$postfix' OR postfix='')":" AND postfix = ''";
	$query = $this->DB_master->query("SELECT * FROM $this->acl_table WHERE role_id = '$role_id'");
	
	//被禁止的菜单
	$admin_menu_denied = array();
	$member_menu_denied = array();
	
	while($v = $this->DB_master->fetch_array($query)){
		$acl = mb_unserialize($v['v']);
		
		if(!empty($acl['admin_actions'])){
			foreach($acl['admin_actions'] as $action => $priv){
				if(
					!$priv && !empty($admin_menus[$v['system'] .'-'. $v['module'] .'-'. $action])
				){
					foreach($admin_menus[$v['system'] .'-'. $v['module'] .'-'. $action] as $vv){
						$admin_menu_denied[$vv['id']] = 1;
					}
				}
			}
		}
		
		if(!empty($acl['actions'])){
			foreach($acl['actions'] as $action => $priv){
				if(
					!$priv && !empty($member_menus[$v['system'] .'-'. $v['module'] .'-'. $action])
				){
					foreach($member_menus[$v['system'] .'-'. $v['module'] .'-'. $action] as $vv){
						$member_menu_denied[$vv['id']] = 1;
					}
				}
			}
		}
	}
	
	global $CACHE;
	$CACHE->write('', 'core', 'admin_menu_role_'. $role_id.($postfix? '_'.$postfix: ''), jsonencode($admin_menu_denied));
	$CACHE->write('core/modules', 'member', 'menu_json_role_'. $role_id.($postfix? '_'.$postfix: ''), jsonencode($member_menu_denied));
}

/**
* 删除权限
* @param string $system 系统名称
* @param string $module 模块名称
* @param string $postfix 后缀
* @return bool
**/
function delete_acl($param){
	if(!isset($param['system'])) return false;
	
	$param = array(
		'system' => $param['system'],
		'module' => isset($param['module']) ? $param['module'] : '',
		'role_id' => isset($param['role_id']) ? $param['role_id'] : '',
		'postfix' => isset($param['postfix']) ? $param['postfix'] : ''
	);
	
	$cond = "system = '$param[system]' AND module = '$param[module]'";
	
	if(!empty($param['role_id'])){
		//如果指定了角色仅删除指定角色,否则删除全部角色的权限
		$cond .= " AND role_id = '$role_id'";
	}
	
	if(!empty($param['postfix'])){
		//如果定义了后缀,仅删除定义后缀的,否则删除全部的
		if(strpos($param['postfix'], '*') !== false){
			//如果后缀定义了模糊搜索
			$param['postfix'] = str_replace('*', '', $param['postfix']);
			$cond .= " AND postfix LIKE '$param[postfix]%'";
		}else{
			$cond .= " AND postfix = '$param[postfix]'";
		}
	}
	
	$query = $this->DB_master->query("SELECT role_id, postfix FROM $this->acl_table WHERE $cond");
	
	$key = $param['system'];
	$key = $param['module'] ? $key .'/modules/'. $param['module'] : $key;
	
	
	global $CACHE;
	while($arr = $this->DB_master->fetch_array($query)){
		$role = 'role_'. $arr['role_id'];
		$arr['postfix'] = $arr['postfix'] ? '#'. $arr['postfix'] : '';
		//删除缓存
		$CACHE->delete($key, 'acl', 'role_'. $arr['role_id'] . $arr['postfix']);
	}
	
	//删除数据库里的记录
	return $this->DB_master->delete($this->acl_table, $cond);
}

/**
* 按角色ID删除权限
* @param int|array $role 角色ID
**/
function delete_acl_by_role($role){
	$roles = $comma = '';
	foreach((array) $role as $v){
		$roles .= $comma . $v;
	}
	
	if(empty($roles)) return false;
	
	$query = $this->DB_master->query("SELECT * FROM $this->acl_table WHERE role_id IN ($roles)");
	
	global $CACHE;
	while($arr = $this->DB_master->fetch_array($query)){
		$key = $arr['system'];
		$key = $arr['module'] ? $key .'/modules/'. $arr['module'] : $key;
		
		$arr['postfix'] = $arr['postfix'] ? '#'. $arr['postfix'] : '';
		//删除缓存
		$CACHE->delete($key, 'acl', 'role_'. $arr['role_id'] . $arr['postfix']);
	}
	
	$this->DB_master->delete($this->acl_table, "role_id IN ($roles)");
	
	return true;
}

/**
* 获得访问控制列表
* @param object $obj 要设置权限的对象
* @param int $role_id 角色ID
* @return array 访问控制列表
**/
function get_acl(&$obj, $role_id, $postfix = ''){
	
	switch($obj->type){
	
	case 'core':
	case 'system':
		$system = $obj->name;
		$module = '';
	break;
	
	case 'module':
		$system = $obj->system->name;
		$module = $obj->name;
	break;
	
	}
	
	//能传入postfix*,查询条件将以postfix%后向模糊查找
	if(strpos($postfix, '*') !== false){
		$postfix = str_replace('*', '', $postfix);
		$acl_db = $this->DB_master->fetch_all("SELECT v, postfix FROM $this->acl_table WHERE system = '$system' AND module = '$module' AND role_id = '$role_id' AND postfix LIKE '$postfix%'");
		
		$ret = array();
		foreach($acl_db as $v){
			$ret[$v['postfix']] = mb_unserialize($v['v']);
		}
		
		return $ret;
	}else{
		$acl_db = $this->DB_master->fetch_one("SELECT v FROM $this->acl_table WHERE system = '$system' AND module = '$module' AND role_id = '$role_id' AND postfix = '$postfix'");
		
		return $acl_db ? mb_unserialize($acl_db['v']) : array();
	}
	
}

/**
* 复制一个角色的权限到一个或多个角色
* @param int $src_role_id 源角色
* @param int|array $tar_role 目标角色,单个或数组
* @param boolean 是否覆盖目标角色的权限,如果不是,将把源角色和目标角色合并,并保留目标角色的权限,但如果有重复的权限将按源角色的为准
**/
function copy_acl($src_role_id, $tar_role = array(), $cover = true){
	if(empty($tar_role)) return false;
	
	//源角色的权限
	$src_acls = $this->DB_master->fetch_all("SELECT * FROM $this->acl_table WHERE role_id = '$src_role_id'");
	$_src_acls = array();
	foreach($src_acls as $k => $v){
		
		$_src_acls[$v['system']][$v['module']][$v['postfix']] = mb_unserialize($v['v']);
		
		unset($src_acls[$k]['role_id']);
		$src_acls[$k]['v'] = mb_unserialize($v['v']);
	}
	
	$uploader = &$this->core->load_module('uploader');
	
	foreach((array) $tar_role as $role_id){
		if($role_id == $src_role_id) continue; //不能复制源角色的权限
		
		//上传权限
		$config = $this->core->get_config('core', 'uploader');
		$config = $config['role_filters'];
		$config[$role_id] = isset($config[$src_role_id]) ? $config[$src_role_id] : array();
		$uploader->set_config(array('role_filters' => $config));
		
		if($cover){
			
			//覆盖写入
			
			//删除目标角色的所有权限
			$this->delete_acl_by_role($role_id);
			
			foreach($src_acls as $vv){
				//插入权限表
				$this->DB_master->insert(
					$this->acl_table,
					array(
						'system' => $vv['system'],
						'module' => $vv['module'],
						'postfix' => $vv['postfix'],
						'role_id' => $role_id,
						'v' => $this->DB_master->escape_string(serialize($vv['v']))
					)
				);
			}
			
		}else{
			
			//合并权限
			
			//读取目标角色的权限
			$tar_acls = $this->DB_master->fetch_all("SELECT * FROM $this->acl_table WHERE role_id = '$role_id'");
			$_tar_acls = array();
			foreach($tar_acls as $k => $v){
				$_tar_acls[$v['system']][$v['module']][$v['postfix']] = mb_unserialize($v['v']);
				
				
			}
			
			//$_tar_acls = array_merge($_src_acls, $_tar_acls);
			$_acls = $_src_acls;
			foreach($_tar_acls as $system => $v){
				foreach($v as $module => $vv){
					foreach($vv as $postfix => $vvv){
						$_acls[$system][$module][$postfix] = array_merge($_acls[$system][$module][$postfix], $vvv);
						
					}
				}
			}
			print_r($_tar_acls);
			
			//删除目标角色的所有权限
			$this->delete_acl_by_role($role_id);
			
			foreach($_tar_acls as $system => $v){
				foreach($v as $module => $vv){
					foreach($vv as $postfix => $vvv){
						
						$this->DB_master->insert(
							$this->acl_table,
							array(
								'system' => $system,
								'module' => $module,
								'postfix' => $postfix,
								'role_id' => $role_id,
								'v' => $this->DB_master->escape_string(serialize($vvv))
							)
						);
						
					}
				}
			}
			
		}
		
		//菜单的权限
		$this->set_menu_privilege($role_id);
	}
	
	//$this->cache_acl();
	return true;
}

}