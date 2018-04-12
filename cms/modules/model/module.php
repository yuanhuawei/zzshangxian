<?php
defined('PHP168_PATH') or die();

/**
* ���ģ�͵�ϵͳ����
* /template/default/cms/item/		��д	����ģ��Ŀ¼
* /template/label/cms/				��д	������ǩģ��
* /lang/zh-cn/cms/item/				��д	�������԰�
* /skin/default/cms/item/			��д	�������Ŀ¼
* /cms/model/						��д	����ģ�ͽű�
* /cms/								��д	����HTML���Ŀ¼
**/

class P8_CMS_Model extends P8_Module{

var $table;
var $field_table;
var $field_types;
var $widgets;
var $_model_fields;

function __construct(&$system, $name){
	$this->configurable = false;	//��û������
	$this->system = &$system;
	parent::__construct($name);
	
	$this->table = $this->system->TABLE_ .'model';
	
	$this->field_table = $this->TABLE_ .'field';
	
	//��ѡ���ֶ����� ���� => ���԰���ֵ
	$this->field_types = array(
		'varchar'		=> 'cms_model_field_type_varchar',
		'tinyint'		=> 'cms_model_field_type_tinyint',
		'smallint'		=> 'cms_model_field_type_smallint',
		'mediumint'		=> 'cms_model_field_type_mediumint',
		'int'			=> 'cms_model_field_type_int',
		'bigint'		=> 'cms_model_field_type_bigint',
		
		'decimal'		=> 'cms_model_field_type_decimal',
		
		'char'			=> 'cms_model_field_type_char',
		
		
		'text'			=> 'cms_model_field_type_text',
		'mediumtext'	=> 'cms_model_field_type_mediumtext',
		'longtext' 		=> 'cms_model_field_type_longtext'
	);
	
	//��ѡ����������
	$this->widgets = array(
		'text'			=> 'cms_model_widget_text',
		'textarea'		=> 'cms_model_widget_textarea',
		'textdate'		=> 'cms_model_widget_textdate',
		
		'link'		=> 'cms_model_widget_link',
		
		'radio'			=> 'cms_model_widget_radio',
		'checkbox'		=> 'cms_model_widget_checkbox',
		
		'multi_select'	=> 'cms_model_widget_multi_select',
		'select'		=> 'cms_model_widget_select',
		
		'uploader'		=> 'cms_model_widget_uploader',
		'multi_uploader'=> 'cms_model_widget_multi_uploader',
		'image_uploader'=> 'cms_model_widget_image_uploader',
		'video_uploader'=> 'cms_model_widget_video_uploader',
		'editor'		=> 'cms_model_widget_editor',
		'editor_basic'	=> 'cms_model_widget_editor_basic',
		'editor_common'	=> 'cms_model_widget_editor_common',
		
		'city' 			=> 'cms_model_widget_city',
		'news_paper_map' => 'cms_model_widget_news_paper_map',
		'vote' 			=> 'cms_model_widget_vote',
		//'google_map' 	=> 'cms_model_widget_google_map'
	);
}

function P8_CMS_Model(&$system, $name){
	$this->__construct($system, $name);
}

/**
* ���һ��ģ��
* @param string $name ģ������(Ψһ)
* @param string $alias ģ�ͱ���
* @return int ���ص�ID
**/
function add(&$data, $addon_data = array()){
	
	//ģ������
	empty($data['config']) && $data['config'] = array();
	
	$data['config'] = $this->DB_master->escape_string(serialize($data['config']));
	
	if(
		$id = $this->DB_master->insert(
			$this->table,
			$data,
			array('return_id' => true)
		)
	){
		
		$item = &$this->system->load_module('item');
		$item->set_model($data['name']);
		
		require_once PHP168_PATH .'install/install.func.php';
		
		//### ����CMSģ�Ϳ�ʼ{
		$model_sql = get_install_sql(
			$this->DB_master,
			file_get_contents($item->path .'install/model_sql.php'),
			$item->TABLE_ . $data['name'] .'_',
			true
		);
		
		foreach($model_sql as $sql){
			$this->DB_master->query($sql);
		}
		
		if($this->DB_master->version() > '5.1.0'){
			//������۵ı����,һ��ģ��һ������
			$this->DB_master->query("ALTER TABLE {$item->TABLE_}comment ADD PARTITION (PARTITION `$data[name]` VALUES IN ($id))");
		}
		
		//����ģ������
		//### ����ֶ� ###
		if(!empty($addon_data['#fields'])){
			//�����Ԥ�����ֶ�,ͨ�����ڵ���
			$fields = $addon_data['#fields'];
		}else{
			$fields = include $item->path .'install/default_fields.php';
		}
		
		$fields = convert_encode('gbk', $this->core->CONFIG['page_charset'], $fields);	//ת������
		foreach($fields as $v){
			$v['model'] = $data['name'];
			$this->add_field($v);
		}
		//### ����CMSģ�ͽ���}
		
		/** ����ģ�ͽű�{ **/
		$path = $this->system->path .'model/'. $data['name'] .'/';
		
		//���Ŀ¼������,������ڵ�һ�㶼�ǵ���ģ��
		is_dir($path) || cp($item->path .'#/', $path);
		/** ����ģ�ͽű�} **/
		
		/** ����ģ��, ���ģ���Ѿ����ھͲ��ø���{ **/
		foreach($this->core->CONFIG['templates'] as $template => $alias){
			$temp_dir = TEMPLATE_PATH . $template .'/'. $this->system->name .'/'. $item->name .'/';
			md($temp_dir . $data['name']);
			
			//�б�ҳģ��
			is_file($temp_dir . $data['name'] .'/big_list.html') ||
				cp($temp_dir .'#/big_list.html', $temp_dir . $data['name'] .'/big_list.html');
			
			//�б�ҳģ��
			is_file($temp_dir . $data['name'] .'/list.html') ||
				cp($temp_dir .'#/list.html', $temp_dir . $data['name'] .'/list.html');
			
			//����ҳģ��
			is_file($temp_dir . $data['name'] .'/view.html') ||
				cp($temp_dir .'#/view.html', $temp_dir . $data['name'] .'/view.html');
			
			//��������ļ���
			md(PHP168_PATH .'skin/'. $template .'/'. $this->system->name .'/'. $item->name .'/'. $data['name']);
		}
		//��ǩģ��
			
		cp(TEMPLATE_PATH .'label/'.$this->system->name.'/#/', TEMPLATE_PATH .'label/'.$this->system->name.'/'.$data['name'].'/');
		/** ����ģ�� **/
		
		//�������԰�, ������԰��Ѿ����ڲ�Ҫ����
		foreach($this->core->CONFIG['language'] as $language => $alias){
			$lang_file = LANGUAGE_PATH .$language .'/'. $this->system->name .'/'. $item->name .'/'. $data['name'] .'.php';
			is_file($lang_file) || write_file($lang_file, "<?php\r\nreturn array(\r\n\r\n);");
		}
		
		//JSĿ¼
		md(PHP168_PATH .'js/'. $this->system->name .'/item/'. $data['name']);
		md(TEMPLATE_PATH .'admin/'. $this->system->name .'/item/'. $data['name']);
		md(TEMPLATE_PATH . $this->core->CONFIG['member_template'] .'/'. $this->system->name .'/item/'. $data['name']);
		
		//���»���
		$this->cache($data['name']);
	}
	
	return $id;
}

/**
* ����ģ��
**/
function export($name, $new_name = ''){
	
	$new_name = $new_name == '' ? $name : $new_name;
	
	$model = $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE name = '$name'");
	if(empty($model)) return false;
	
	$model['config'] = mb_unserialize($model['config']);
	
	//�����ֶ�
	$_fields = $this->DB_master->fetch_all("SELECT * FROM $this->field_table WHERE model = '$name'");
	//�������ֶβ���ģ��
	if(empty($_fields)) return false;
	
	$data = array(
		'name' => $new_name,
		'config' => $model['config']
	);
	
	$fields = array();
	foreach($_fields as $v){
		unset($v['id'], $v['model']);
		$v['config'] = mb_unserialize($v['config']);
		$v['data'] = mb_unserialize($v['data']);
		$fields[$v['name']] = $v;
	}
	unset($_fields);
	
	//ģ����Ϣ, ģ�͵������Լ��ֶ�
	$data['#fields'] = &$fields;
	
	
	$path = $this->system->path .'#export/'. $new_name .'/';
	md($path);
	
	$SYSTEM = $this->system->name;
	
	$copies = array(
		//�ű�
		$this->system->path .'model/'. $name .'/'
			=> $path .'/'. $SYSTEM .'/model/'. $new_name .'/',
		
		//��ǩģ��
		TEMPLATE_PATH .'label/'. $SYSTEM .'/'. $name .'/'
			=> $path .'template/label/'. $SYSTEM .'/'. $new_name .'/',
		
		//��̨����ģ��
		TEMPLATE_PATH .'admin/'. $SYSTEM .'/'. $this->name .'/model_config/'. $name .'.html'
			=> $path .'template/admin/'. $SYSTEM .'/'. $this->name .'/model_config/'. $new_name .'.html',
		
		//��̨ģ��
		TEMPLATE_PATH .'admin/'. $SYSTEM .'/item/'. $name .'/'
			=> $path .'template/admin/'. $SYSTEM .'/item/'. $new_name .'/',
		
		//JS
		PHP168_PATH .'js/'. $SYSTEM .'/item/'. $name .'/'
			=> $path .'/js/'. $SYSTEM .'/item/'. $new_name .'/'
	);
	
	foreach($this->core->CONFIG['templates'] as $template => $alias){
		//ǰ̨ģ��
		$copies[TEMPLATE_PATH . $template .'/'. $SYSTEM .'/item/'. $name .'/'] = 
			$path .'template/'. $template .'/'. $SYSTEM .'/item/'. $new_name .'/';
		
		//���
		$copies[PHP168_PATH .'skin/'. $template .'/'. $SYSTEM .'/item/'. $name .'/']
			= $path .'skin/'. $template .'/'. $SYSTEM .'/item/'. $new_name .'/';
	}
	
	foreach($this->core->CONFIG['language'] as $language => $alias){
		//���԰�
		$copies[PHP168_PATH .'lang/'. $language .'/'. $SYSTEM .'/item/'. $name .'.php']
			= $path .'lang/'. $language .'/'. $SYSTEM .'/item/'. $new_name .'.php';
	}
	
	foreach($copies as $k => $v){
		cp($k, $v);
	}
	
	//���е������ļ�ת��gbk
	require_once PHP168_PATH .'install/install.func.php';
	convert_file_encode($path, $this->core->CONFIG['page_charset'], 'gbk', '.js|.css|.html|.php');
	
	//ת������,ת��GBK
	$data = convert_encode($this->core->CONFIG['page_charset'], 'gbk', $data);
	$data = "<?php\r\nreturn ". var_export($data, true) .';';
	
	write_file($path .'#data.php', $data);
	
	return true;
}

/**
* ����ģ��
* @param string $name ģ�͵�����
* @param string $alias POST��ģ�ͱ���
* @return int add�������ص�ֵ
**/
function import($name, $alias){
	
	//ģ�������Լ��ֶ�
	$path = $this->system->path .'#export/'. $name .'/';
	
	if(!is_dir($path)){
		return false;
	}
	
	$data = include $path .'#data.php';
	$addon = array('#fields' => $data['#fields']);
	unset($data['#fields']);
	
	$data['alias'] = $alias;
	
	//ֱ�����
	if($status = $this->add($data, $addon)){
		
		require_once PHP168_PATH .'install/install.func.php';
		
		//�°�װʱ���ø����ˣ���������,�������̰�װʱ��
		if(is_file( PHP168_PATH .'data/install.lock')){
			$_path = CACHE_PATH .'tmp/cms_model_import/'. $name .'/';
			cp($path, $_path);
					
			convert_file_encode($_path, 'gbk', $this->core->CONFIG['page_charset'], '.js|.css|.html|.php');
			
			//�������ļ����ǵ���Ŀ¼����
			cp($_path, PHP168_PATH);
			rm($_path);
			rm(PHP168_PATH .'#data.php');
		}
		//ִ�е����Ĳ���
		$import_script = $this->system->path .'model/'. $name .'/import/#post_import.php';
		if(is_file($import_script)){
			$_REQUEST['model'] = $name;
			$this->system->init_model();
			global $this_model;
			
			include $import_script;
		}
	}
	
	return $status;
}

/**
* ����һ��ģ��,��������ͬadd
* @return bool �Ƿ��޸ĳɹ�
* ģ�����Ʋ����޸�
**/
function update($name, &$data){
	
	$data['config'] = $this->DB_master->escape_string(serialize($data['config']));
	
	if(
		$status = $this->DB_master->update(
			$this->table,
			$data,
			"name = '$name'"
		)
	){
		
		$this->cache($name);
	}
	return $status;
}

/**
* ɾ��һ��ģ��
* @param int|array $cond Ҫɾ��������
* @return bool
**/
function delete($cond){
	ignore_user_abort(true);
	$models = $this->DB_master->fetch_all("SELECT id, name FROM $this->table WHERE $cond");
	
	if(empty($models)) return false;
	
	$names = $comma = '';
	foreach($models as $v){
		$names .= $comma . '\''. $v['name'] .'\'';
	}
	
	global $CACHE;
	
	if($status = $this->DB_master->delete($this->table, "name IN ($names)")){
		//ɾ���ֶ�
		$this->DB_master->delete($this->field_table, "model IN ($names)");
		
		$item = &$this->system->load_module('item');
		$role = $this->core->load_module('role');
		
		foreach($models as $model){
			$item->set_model($model['name']);
			
			//ɾ���ű�
			rm($this->system->path .'model/'. $model['name']);
			//��̨ģ��
			rm(TEMPLATE_PATH .'admin/'. $this->system->name .'/'. $item->name .'/'. $model['name']);
			
			foreach($this->core->CONFIG['templates'] as $template => $alias){
				//ģ���ļ�
				rm(TEMPLATE_PATH . $template .'/'. $this->system->name .'/'. $item->name .'/'. $model['name']);
				//����ļ���
				rm(PHP168_PATH .'skin/'. $template .'/'. $this->system->name .'/'. $item->name .'/'. $model['name']);
			}
			
			foreach($this->core->CONFIG['language'] as $language => $alias){
				//���԰�
				rm(LANGUAGE_PATH . $language .'/'. $this->system->name .'/'. $item->name .'/'. $model['name'] .'.php');
			}
			
			//ɾ��ģ�ͻ���
			$CACHE->delete($this->system->name .'/modules', $this->name, $model['name']);
			
			if($this->DB_master->version() > '5.1.0'){
				//ɾ�����۵ı����
				$this->DB_master->query("ALTER TABLE {$item->TABLE_}comment DROP PARTITION `$model[name]`");
			}
			
			$category = &$this->system->load_module('category');
			$category->delete(array(
				'where' => "model = '$model[name]'",
				'delete_hook' => true
			));
			
			//ɾ����
			$this->DB_master->query("DROP TABLE $item->table");
			$this->DB_master->query("DROP TABLE $item->addon_table");
			
			//���Ȩ��
			$role->delete_acl(array(
				'system' => $this->system->name,
				'module' => $item->name,
				'postfix' => $model['name']
			));
		}
		
		$this->cache();
	}
	
	return $status;
}

/**
* Ϊģ������һ���ֶ�
* @param int $mid ģ��ID
* @param string $name �ֶ�����(Ψһ)
* @param string $alias �ֶα���
* @param string $type �ֶ�����
* @param int $length �ֶγ���
* @param bool $is_unsigned �Ǹ���
* @param string $widget ���뷽ʽ
* @param int $display_order ����
* @return int ���ص�ID
**/
function add_field(&$data){
	
	empty($data['config']) && $data['config'] = array();
	empty($data['data']) && $data['data'] = array();
	$model = $this->get_model($data['model']);
	$data['data'] = $this->DB_master->escape_string(serialize($data['data']));
	$data['config'] = $this->DB_master->escape_string(serialize($data['config']));
	
	if(empty($model)) return false;
	
	if(
		$status = $this->DB_master->insert(
			$this->field_table,
			$data,
			array('return_id' => true)
		)
	){
		
		$field = $this->field_sql($data);
		
		$item = &$this->system->load_module('item');
		$item->set_model($model['name']);
		
		if($data['list_table']){
			$status = $this->DB_master->query("ALTER TABLE $item->table ADD `$data[name]` $field");
		}else{
			$status = $this->DB_master->query("ALTER TABLE $item->addon_table ADD `$data[name]` $field");
		}
		
		$this->cache($data['model']);
	}
	
	return $status;
}

/**
* �޸�һ���ֶ�,��������ͬadd_field
* @return bool
**/
function update_field($id, &$data){
	$model = $this->get_model($data['model']);
	$data['data'] = $this->DB_master->escape_string(serialize($data['data']));
	$data['config'] = $this->DB_master->escape_string(serialize($data['config']));
	
	if(empty($model)) return false;
	
	//�������޸�ģ��,�ֶδ�ű�
	unset($data['model'], $data['list_table']);
	
	$tmp = $this->DB_master->fetch_one("SELECT list_table FROM $this->field_table WHERE id = '$id'");
	
	if(
		$status = $this->DB_master->update(
			$this->field_table,
			$data,
			"id = '$id'"
		)
	){
		
		$field = $this->field_sql($data);
		
		$item = &$this->system->load_module('item');
		$item->set_model($model['name']);
		
		if($tmp['list_table']){
			$status = $this->DB_master->query("ALTER TABLE $item->table CHANGE `$data[name]` `$data[name]` $field");
		}else{
			$status = $this->DB_master->query("ALTER TABLE $item->addon_table CHANGE `$data[name]` `$data[name]` $field");
		}
		
		$this->cache($model['name']);
	}
	return $status;
}

/**
* �����ֶε�SQL
**/
function field_sql(&$data){
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
* ɾ��һ���ֶ�
* @param string Ҫɾ��������
**/
function delete_field($cond){
	
	$field = $this->DB_master->fetch_one("SELECT id, name, model, list_table FROM $this->field_table WHERE $cond");
	if(empty($field)) return false;
	//�����ֶβ���ɾ��
	if($field['name'] == 'content') return false;
	
	global $CACHE;
	if($status = $this->DB_master->delete($this->field_table, $cond)){
		$this->cache($field['model']);
		
		$item = &$this->system->load_module('item');
		$item->set_model($field['model']);
		
		if($field['list_table']){
			$status = $this->DB_master->query("ALTER TABLE $item->table DROP `$field[name]`");
		}else{
			$status = $this->DB_master->query("ALTER TABLE $item->addon_table DROP `$field[name]`");
		}
		
	}
	
	return $status;
}

function get_model($name){
	return $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE name = '$name'");
}

/**
* �����ض�������ģ�͵Ļ���
* @param string $name Ҫ����ģ�͵�����, ����������ض���ģ������, ��ֻ�����ض�ģ�͵Ļ���
**/
function cache($name = ''){
	parent::cache();
	
	$models = $this->DB_master->fetch_all("SELECT * FROM $this->table");
	
	//��ȡ�����ģ��
	$cache_models = array();
	foreach($models as $model){
		$config = mb_unserialize($model['config']);
		unset($model['config']);
		$cache_models[$model['name']] = $model;
		
		//���ָ����ģ��
		if($name && $model['name'] != $name) continue;
		
		//��ȡ��ģ�͵��ֶ�
		$fields = $this->DB_master->fetch_all("SELECT id, name, parent, alias, type, not_null, length, is_unsigned, editable, default_value, widget, widget_addon_attr, data, list_table, filterable, orderby, config, units, description
			FROM $this->field_table
			WHERE model = '$model[name]' ORDER BY display_order DESC");
		
		$_model = $model;
		$this->_model_fields = &$fields;
		unset($_model['name']);
		$_model['fields'] = array();
		$_model['filterable_fields'] = array();
		
		//���ֶλ���
		foreach($fields as $field){
			$field['data'] = mb_unserialize($field['data']);
			$field['CONFIG'] = mb_unserialize($field['config']);
			
			$_model['fields'][$field['name']] = $field;
			
			switch($field['widget']){
				case 'checkbox':
				case 'multi_select':
				case 'multi_uploader':
					//��ѡ��,�ָ�
					$_default = array();
					foreach(array_filter(explode("\r\n", $field['default_value'])) as $v){
						$_default[$v] = $v;
					}
					$_model['fields'][$field['name']]['default_value'] = $_default;
				break;
			}
			
			unset(
				$_model['fields'][$field['name']]['name'],
				$_model['fields'][$field['name']]['config'],
				$_model['fields'][$field['name']]['display_order']
			);
			
			if($field['list_table'] && $field['filterable']){
				$_model['filterable_fields'][$field['name']] = &$_model['fields'][$field['name']];
			}
		}
		
		//����
		$_model['CONFIG'] = $config;
		
		//$this->template_cache($model['name'], $this->_model_fields);
		
		//д����ģ�ͻ���
		$this->core->CACHE->write($this->system->name .'/modules', $this->name, $model['name'], $_model, 'serialize');
	}
	
	//дģ���ܻ���
	$this->core->CACHE->write($this->system->name .'/modules', $this->name, 'models', $cache_models);
}

/**
* ����ģ��
**/
function template_cache($model, $fields = array()){
	
	if(empty($fields)){
		$this->_model_fields = $this->DB_master->fetch_all("SELECT id, name, alias, type, not_null, length, is_unsigned, editable, default_value, widget, widget_addon_attr, data, list_table, filterable, orderby, config, units, description
		FROM $this->field_table
		WHERE model = '$model' ORDER BY display_order DESC");
	}
	
	//������widget�����ɵ�һ��ģ��
	//��̨
	$edit_template_dir = TEMPLATE_PATH .'admin/'. $this->system->name .'/item/';
	md($edit_template_dir);
	
	//����
	if(is_file($edit_template_dir . $model .'/#edit.html')){
		$file = $edit_template_dir . $model .'/#edit.html';
	}else{
		$file = $edit_template_dir .'edit.html';
	}
	$content = file_get_contents($file);
	//���ѭ��
	$content = preg_replace('/<\!--\!\!foreach_widgets\!\!-->([\s\S]+?)<\!--\!\!foreach_widgets\!\!-->/', '', $content);
	//ÿ��widget
	$content = preg_replace_callback('/<\!--\!\!widgets\!\!-->([\s\S]+?)<\!--\!\!widgets\!\!-->/', array(&$this, 'edit_template_callback'), $content);
	write_file($edit_template_dir . $model .'/edit.html', $content);
	
	
	
	//��Ա����
	$edit_template_dir = TEMPLATE_PATH . $this->core->CONFIG['member_template'] .'/'. $this->system->name .'/item/';
	md($edit_template_dir);
	
	//����
	if(is_file($edit_template_dir . $model .'/#edit.html')){
		$file = $edit_template_dir . $model .'/#edit.html';
	}else{
		$file = $edit_template_dir .'edit.html';
	}
	$content = file_get_contents($file);
	//���ѭ��
	$content = preg_replace('/<\!--\!\!foreach_widgets\!\!-->([\s\S]+?)<\!--\!\!foreach_widgets\!\!-->/', '', $content);
	//ÿ��widget
	$content = preg_replace_callback('/<\!--\!\!widgets\!\!-->([\s\S]+?)<\!--\!\!widgets\!\!-->/', array(&$this, 'edit_template_callback'), $content);
	write_file($edit_template_dir . $model .'/edit.html', $content);
	
	
	
	//�б�ҳ
	$list_template_dir = TEMPLATE_PATH . $this->system->CONFIG['template'] .'/'. $this->system->name .'/item/';
	md($list_template_dir . $model);
	
	//����
	if(is_file($list_template_dir . $model .'/#list.html')){
		$file = $list_template_dir . $model .'/#list.html';
	}else{
		$file = $list_template_dir .'#/list.html';
	}
	$content = file_get_contents($file);
	//���ѭ��
	$content = preg_replace('/<\!--\!\!filterable_fields\!\!-->([\s\S]+?)<\!--\!\!filterable_fields\!\!-->/', '', $content);
	//ÿ��field
	$content = preg_replace_callback('/<\!--\!\!fields\!\!-->([\s\S]+?)<\!--\!\!fields\!\!-->/', array(&$this, 'list_template_callback'), $content);
	write_file($list_template_dir . $model .'/list.html', $content);
	
}

/**
* �б�ҳ
**/
function list_template_callback($m){
	$fields = '';
	$template = $m[1];
	
	foreach($this->_model_fields as $v){
		
		if(!$v['filterable']) continue;	//���ɹ���
		
		$field = str_replace(
			array(
				'<!--!!field!!-->',
				'{$field_data[\'alias\']}',
				' style="display: none;"'
			),
			array(
				'<!--{php $field = \''. $v['name'] .'\'; $field_data = $this_model[\'fields\'][$field];}-->',
				$v['alias'],
				''
			),
			$template
		);
		
		$fields .= $field;
	}
	
	return $fields;
}

/**
* �༭ҳ
**/
function edit_template_callback($m){
	
	static $_t_widgets = array();
	
	$widgets = '';
	$template = $m[1];
	foreach($this->_model_fields as $v){
		
		if(!$v['editable']) continue;	//���ɱ༭
		
		//JS��֤���ֶ�����
		$__name = '';
		
		switch($v['widget']){
		
		case 'checkbox': case 'multi_select':
			$__name = '[]';
		break;
		case 'uploader':
			$__name = '[url]';
		break;
		case 'multi_uploader':
			$__name = '[url][]';
		break;
		
		}
		
		if(empty($_t_widgets[$v['widget']])){
			$_t_widgets[$v['widget']] = str_replace(array('<!--{php168}-->', '<!--{/php168}-->'), '', file_get_contents(TEMPLATE_PATH . 'default/core/widget/'. $v['widget'] .'.html'));
		}
		
		$widget = str_replace(
			array(
				'<!--!!widget!!-->',
				'{$field_data[\'alias\']}',
				' style="display: none;"'
			),
			array(
				'<!--{php $field = \''. $v['name'] .'\'; $field_data = $this_model[\'fields\'][$field]; $__name = \''. $__name .'\';}-->'. $_t_widgets[$v['widget']],//<!--{template $core widget/'. $v['widget'] .' default}-->
				$v['alias'],
				''
			),
			$template
		);
		
		$widget = preg_replace(
			'/<\!--\!\!js_validator\!\!-->([\s\S]+?)<\!--\!\!js_validator\!\!-->/',
			'<script type="text/javascript">'.
			($v['not_null'] ? '\1' : '').
			'</script>',
			$widget
		);
		
		$widgets .= $widget;
	}
	
	return $widgets;
}

}