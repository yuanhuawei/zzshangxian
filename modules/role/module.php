<?php
defined('PHP168_PATH') or die();

class P8_Role extends P8_Module{

var $table;
var $acl_table;
var $group_table;

var $_data;
var $roles;				//��ID���ʵĽ�ɫ
var $system_roles;		//��ϵͳ���ʵĽ�ɫ	system_roles['ϵͳ']['��ɫ����']
var $type_roles;		//�����ͷ��ʵĽ�ɫ	type_roles['��ɫ����']['ϵͳ']
var $group_roles;		//������ʵĽ�ɫ	type_roles['��ɫ����']['ϵͳ']['��ɫ����']
var $groups;			//��ɫ��
var $last_cache;		//���һ�θ���Ȩ�޻����ʱ���
var $group_field_table;

function __construct(&$system, $name){
	$this->system = &$system;
	//û������
	$this->configurable = false;
	parent::__construct($name);
	
	$this->table = $this->core->TABLE_ .'role';
	$this->group_table = $this->core->TABLE_ .'role_group';
	$this->acl_table = $this->core->TABLE_ .'acl';
	
	$this->last_cache = '@'. $this->core->CONFIG['last_acl_cache'];
	
	$this->group_field_table = $this->TABLE_ .'group_field';
	
	//��ѡ���ֶ����� ���� => ���԰���ֵ
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
	
	//��ѡ����������
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
* ��ID��ý�ɫ
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
* ��ϵͳ��ý�ɫ
* ����������������
**/
function get_by_system($system, $type = ''){
	if(empty($type)){
		return isset($this->system_roles[$system]) ? $this->system_roles[$system] : array();
	}else{
		return isset($this->system_roles[$system][$type]) ? $this->system_roles[$system][$type] : array();
	}
}

/**
* �����ͻ�ý�ɫ
* ������ϵͳ������
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
* ���ɻ���
**/
function cache(){
	//parent::cache();
	
	//$this->cache_acl();
	//$this->cache_role();
	//$this->cache_group();
}

/**
* �����ɫ
**/
function cache_role($postfix=''){
	$query = $this->DB_master->query("SELECT * FROM $this->table ORDER BY display_order DESC, id ASC");
	
	$this->system_roles = array();
	$this->type_roles = array('system' => array(), 'normal' => array());
	$this->roles = array();
	while($arr = $this->DB_master->fetch_array($query)){
		$this->roles[$arr['id']] = $arr;
	}
	
	//��������
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
* �����ɫ��
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
					//��ѡ��,�ָ�
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
* �־�����Ȩ�ޱ�Ļ���
**/
function cache_acl_step($n, $tn, $on){
	global $CACHE;
	$query = $this->DB_master->fetch_all("SELECT * FROM $this->acl_table LIMIT $n,100");
	if(!$query) return false;
	foreach($query as $key=>$arr){
		
		$path = $arr['module'] ? $arr['system'] .'/modules/'. $arr['module'] : $arr['system'];
		$filepre = 'role_'. $arr['role_id'];
		//�к�׺��
		$fielname = $arr['postfix'] ? $filepre .'#'. $arr['postfix'] : $filepre;
		$data = mb_unserialize($arr['v']);
		$CACHE->write($path, 'acl', $fielname . $tn, $data);
		//ɾ���ϴλ����
		$CACHE->delete($path, 'acl', $fielname . $on);
	}	
		return true;	
}

/**
* ����Ȩ�ޱ�Ļ���
**/
function cache_acl(){
	$query = $this->DB_master->query("SELECT * FROM $this->acl_table");
	$acls = array();
	while($arr = $this->DB_master->fetch_array($query)){
		$acls[$arr['system']][$arr['module']][$arr['role_id']][$arr['postfix']] = mb_unserialize($arr['v']);
	}
	
	$last_cache = '@'. $this->core->CONFIG['last_acl_cache'];
	//�����ϴ�Ȩ�޸��»���ʱ��
	if(!defined('P8_CLUSTER')){
		$this->core->set_config(array(
			'last_acl_cache' => P8_TIME
		));
		$this->last_cache = '@'. P8_TIME;
	}
	
	//�ļ�����д����ϵͳ/ģ�黺��Ŀ¼�е�aclĿ¼��
	global $CACHE;
	foreach($acls as $system => $v){
		//ϵͳ
		$vkey = $system;
		foreach($v as $module => $vv){
			//ϵͳ or ģ��Ȩ��
			$vvkey = $module ? $vkey .'/modules/'. $module : $vkey;
			
			foreach($vv as $role_id => $vvv){
				//��ɫID
				$vvvkey = 'role_'. $role_id;
				foreach($vvv as $postfix => $vvvv){
					//�к�׺��
					$vvvvkey = $postfix ? $vvvkey .'#'. $postfix : $vvvkey;
					
					$CACHE->write($vvkey, 'acl', $vvvvkey . $this->last_cache, $vvvv);
					
					//ɾ���ϴλ����
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
* ��ӽ�ɫ
**/
function add($data){
	
	if($id = $this->DB_master->insert($this->table, $data, array('return_id' => true))){
		$group = $this->view_group($data['gid']);
		if(empty($group['default_role'])){
			//���������ɫ��û��Ĭ�Ͻ�ɫ��
			$this->DB_master->update(
				$this->group_table,
				array('default_role' => $id),
				"id = '$data[gid]'"
			);
		}
		
		//��ӿյ�Ȩ��
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
* �޸Ľ�ɫ
**/
function update($id, $data){
	
	return $this->DB_master->update($this->table, $data, "id = '$id'");
}

/**
* ɾ����ɫ
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
* ��ӽ�ɫ��
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
* �޸Ľ�ɫ��
**/
function update_group($id, $data){
	
	return $this->DB_master->update($this->group_table, $data, "id = '$id'");
}

/**
* ɾ����ɫ��
**/
function delete_group($id){
	if($status = $this->DB_master->delete($this->group_table, "id = '$id'")){
		//ɾ���ֶμ����ݱ�
		$this->DB_master->delete($this->group_field_table , "gid = '$id'");
		$this->DB_master->query("DROP TABLE {$this->TABLE_}group_{$id}_data");
		
	}
	return $status;
}

/**
* ��ӽ�ɫ���ֶ�
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
* �޸Ľ�ɫ���ֶ�
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
* ɾ����ɫ���ֶ�
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
* �����ֶε�SQL
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
* ���÷��ʿ���,����ϵͳ/ģ��,��ɫ,��Զ��ӳ���ϵ
* @param string $system Ҫ����Ȩ�޵�ϵͳ
* @param string $module Ҫ����Ȩ�޵�ģ��
* @param int $role_id ��ɫID
* @param array $acl ���ʿ����б�
* @param array $info #.php�е���Ϣ
* @parma string $postfix ��׺
* @return boolean
**/
function set_acl($system, $module, $role_id, $acl, $info, $postfix = ''){
	$acl_db = $this->DB_master->fetch_one("SELECT v FROM $this->acl_table WHERE system = '$system' AND module = '$module' AND role_id = '$role_id' AND postfix = '$postfix'");
	
	//�����ݿ�����ȡ������
	$acl_db = $acl_db ? mb_unserialize($acl_db['v']) : array();
	
	//���ACTIONȨ�޶���Ϊ��, Ϊ�վͲ�дACTIONȨ��
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
	//�����궯��
	
	if(!empty($acl)){
		//��������ϸ��Ȩ������
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
* ����Ȩ�����ò˵�����ʾ
* @param int $role_id ��ɫID
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
	
	//����ֹ�Ĳ˵�
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
* ɾ��Ȩ��
* @param string $system ϵͳ����
* @param string $module ģ������
* @param string $postfix ��׺
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
		//���ָ���˽�ɫ��ɾ��ָ����ɫ,����ɾ��ȫ����ɫ��Ȩ��
		$cond .= " AND role_id = '$role_id'";
	}
	
	if(!empty($param['postfix'])){
		//��������˺�׺,��ɾ�������׺��,����ɾ��ȫ����
		if(strpos($param['postfix'], '*') !== false){
			//�����׺������ģ������
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
		//ɾ������
		$CACHE->delete($key, 'acl', 'role_'. $arr['role_id'] . $arr['postfix']);
	}
	
	//ɾ�����ݿ���ļ�¼
	return $this->DB_master->delete($this->acl_table, $cond);
}

/**
* ����ɫIDɾ��Ȩ��
* @param int|array $role ��ɫID
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
		//ɾ������
		$CACHE->delete($key, 'acl', 'role_'. $arr['role_id'] . $arr['postfix']);
	}
	
	$this->DB_master->delete($this->acl_table, "role_id IN ($roles)");
	
	return true;
}

/**
* ��÷��ʿ����б�
* @param object $obj Ҫ����Ȩ�޵Ķ���
* @param int $role_id ��ɫID
* @return array ���ʿ����б�
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
	
	//�ܴ���postfix*,��ѯ��������postfix%����ģ������
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
* ����һ����ɫ��Ȩ�޵�һ��������ɫ
* @param int $src_role_id Դ��ɫ
* @param int|array $tar_role Ŀ���ɫ,����������
* @param boolean �Ƿ񸲸�Ŀ���ɫ��Ȩ��,�������,����Դ��ɫ��Ŀ���ɫ�ϲ�,������Ŀ���ɫ��Ȩ��,��������ظ���Ȩ�޽���Դ��ɫ��Ϊ׼
**/
function copy_acl($src_role_id, $tar_role = array(), $cover = true){
	if(empty($tar_role)) return false;
	
	//Դ��ɫ��Ȩ��
	$src_acls = $this->DB_master->fetch_all("SELECT * FROM $this->acl_table WHERE role_id = '$src_role_id'");
	$_src_acls = array();
	foreach($src_acls as $k => $v){
		
		$_src_acls[$v['system']][$v['module']][$v['postfix']] = mb_unserialize($v['v']);
		
		unset($src_acls[$k]['role_id']);
		$src_acls[$k]['v'] = mb_unserialize($v['v']);
	}
	
	$uploader = &$this->core->load_module('uploader');
	
	foreach((array) $tar_role as $role_id){
		if($role_id == $src_role_id) continue; //���ܸ���Դ��ɫ��Ȩ��
		
		//�ϴ�Ȩ��
		$config = $this->core->get_config('core', 'uploader');
		$config = $config['role_filters'];
		$config[$role_id] = isset($config[$src_role_id]) ? $config[$src_role_id] : array();
		$uploader->set_config(array('role_filters' => $config));
		
		if($cover){
			
			//����д��
			
			//ɾ��Ŀ���ɫ������Ȩ��
			$this->delete_acl_by_role($role_id);
			
			foreach($src_acls as $vv){
				//����Ȩ�ޱ�
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
			
			//�ϲ�Ȩ��
			
			//��ȡĿ���ɫ��Ȩ��
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
			
			//ɾ��Ŀ���ɫ������Ȩ��
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
		
		//�˵���Ȩ��
		$this->set_menu_privilege($role_id);
	}
	
	//$this->cache_acl();
	return true;
}

}