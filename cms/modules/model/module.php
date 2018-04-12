<?php
defined('PHP168_PATH') or die();

/**
* 添加模型的系统需求
* /template/default/cms/item/		可写	创建模板目录
* /template/label/cms/				可写	创建标签模板
* /lang/zh-cn/cms/item/				可写	创建语言包
* /skin/default/cms/item/			可写	创建风格目录
* /cms/model/						可写	创建模型脚本
* /cms/								可写	创建HTML存放目录
**/

class P8_CMS_Model extends P8_Module{

var $table;
var $field_table;
var $field_types;
var $widgets;
var $_model_fields;

function __construct(&$system, $name){
	$this->configurable = false;	//暂没有设置
	$this->system = &$system;
	parent::__construct($name);
	
	$this->table = $this->system->TABLE_ .'model';
	
	$this->field_table = $this->TABLE_ .'field';
	
	//可选的字段类型 类型 => 语言包键值
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
	
	//可选的输入类型
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
* 添加一个模型
* @param string $name 模型名称(唯一)
* @param string $alias 模型别名
* @return int 返回的ID
**/
function add(&$data, $addon_data = array()){
	
	//模型配置
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
		
		//### 创建CMS模型开始{
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
			//添加评论的表分区,一个模型一个分区
			$this->DB_master->query("ALTER TABLE {$item->TABLE_}comment ADD PARTITION (PARTITION `$data[name]` VALUES IN ($id))");
		}
		
		//定义模型名称
		//### 添加字段 ###
		if(!empty($addon_data['#fields'])){
			//如果有预定义字段,通常用于导入
			$fields = $addon_data['#fields'];
		}else{
			$fields = include $item->path .'install/default_fields.php';
		}
		
		$fields = convert_encode('gbk', $this->core->CONFIG['page_charset'], $fields);	//转换编码
		foreach($fields as $v){
			$v['model'] = $data['name'];
			$this->add_field($v);
		}
		//### 创建CMS模型结束}
		
		/** 复制模型脚本{ **/
		$path = $this->system->path .'model/'. $data['name'] .'/';
		
		//如果目录不存在,如果存在的一般都是导入模型
		is_dir($path) || cp($item->path .'#/', $path);
		/** 复制模型脚本} **/
		
		/** 复制模板, 如果模板已经存在就不用覆盖{ **/
		foreach($this->core->CONFIG['templates'] as $template => $alias){
			$temp_dir = TEMPLATE_PATH . $template .'/'. $this->system->name .'/'. $item->name .'/';
			md($temp_dir . $data['name']);
			
			//列表页模板
			is_file($temp_dir . $data['name'] .'/big_list.html') ||
				cp($temp_dir .'#/big_list.html', $temp_dir . $data['name'] .'/big_list.html');
			
			//列表页模板
			is_file($temp_dir . $data['name'] .'/list.html') ||
				cp($temp_dir .'#/list.html', $temp_dir . $data['name'] .'/list.html');
			
			//内容页模板
			is_file($temp_dir . $data['name'] .'/view.html') ||
				cp($temp_dir .'#/view.html', $temp_dir . $data['name'] .'/view.html');
			
			//创建风格文件夹
			md(PHP168_PATH .'skin/'. $template .'/'. $this->system->name .'/'. $item->name .'/'. $data['name']);
		}
		//标签模板
			
		cp(TEMPLATE_PATH .'label/'.$this->system->name.'/#/', TEMPLATE_PATH .'label/'.$this->system->name.'/'.$data['name'].'/');
		/** 复制模板 **/
		
		//创建语言包, 如果语言包已经存在不要覆盖
		foreach($this->core->CONFIG['language'] as $language => $alias){
			$lang_file = LANGUAGE_PATH .$language .'/'. $this->system->name .'/'. $item->name .'/'. $data['name'] .'.php';
			is_file($lang_file) || write_file($lang_file, "<?php\r\nreturn array(\r\n\r\n);");
		}
		
		//JS目录
		md(PHP168_PATH .'js/'. $this->system->name .'/item/'. $data['name']);
		md(TEMPLATE_PATH .'admin/'. $this->system->name .'/item/'. $data['name']);
		md(TEMPLATE_PATH . $this->core->CONFIG['member_template'] .'/'. $this->system->name .'/item/'. $data['name']);
		
		//更新缓存
		$this->cache($data['name']);
	}
	
	return $id;
}

/**
* 导出模型
**/
function export($name, $new_name = ''){
	
	$new_name = $new_name == '' ? $name : $new_name;
	
	$model = $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE name = '$name'");
	if(empty($model)) return false;
	
	$model['config'] = mb_unserialize($model['config']);
	
	//导出字段
	$_fields = $this->DB_master->fetch_all("SELECT * FROM $this->field_table WHERE model = '$name'");
	//必须有字段才算模型
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
	
	//模型信息, 模型的名称以及字段
	$data['#fields'] = &$fields;
	
	
	$path = $this->system->path .'#export/'. $new_name .'/';
	md($path);
	
	$SYSTEM = $this->system->name;
	
	$copies = array(
		//脚本
		$this->system->path .'model/'. $name .'/'
			=> $path .'/'. $SYSTEM .'/model/'. $new_name .'/',
		
		//标签模板
		TEMPLATE_PATH .'label/'. $SYSTEM .'/'. $name .'/'
			=> $path .'template/label/'. $SYSTEM .'/'. $new_name .'/',
		
		//后台配置模板
		TEMPLATE_PATH .'admin/'. $SYSTEM .'/'. $this->name .'/model_config/'. $name .'.html'
			=> $path .'template/admin/'. $SYSTEM .'/'. $this->name .'/model_config/'. $new_name .'.html',
		
		//后台模板
		TEMPLATE_PATH .'admin/'. $SYSTEM .'/item/'. $name .'/'
			=> $path .'template/admin/'. $SYSTEM .'/item/'. $new_name .'/',
		
		//JS
		PHP168_PATH .'js/'. $SYSTEM .'/item/'. $name .'/'
			=> $path .'/js/'. $SYSTEM .'/item/'. $new_name .'/'
	);
	
	foreach($this->core->CONFIG['templates'] as $template => $alias){
		//前台模板
		$copies[TEMPLATE_PATH . $template .'/'. $SYSTEM .'/item/'. $name .'/'] = 
			$path .'template/'. $template .'/'. $SYSTEM .'/item/'. $new_name .'/';
		
		//风格
		$copies[PHP168_PATH .'skin/'. $template .'/'. $SYSTEM .'/item/'. $name .'/']
			= $path .'skin/'. $template .'/'. $SYSTEM .'/item/'. $new_name .'/';
	}
	
	foreach($this->core->CONFIG['language'] as $language => $alias){
		//语言包
		$copies[PHP168_PATH .'lang/'. $language .'/'. $SYSTEM .'/item/'. $name .'.php']
			= $path .'lang/'. $language .'/'. $SYSTEM .'/item/'. $new_name .'.php';
	}
	
	foreach($copies as $k => $v){
		cp($k, $v);
	}
	
	//所有导出的文件转回gbk
	require_once PHP168_PATH .'install/install.func.php';
	convert_file_encode($path, $this->core->CONFIG['page_charset'], 'gbk', '.js|.css|.html|.php');
	
	//转换编码,转回GBK
	$data = convert_encode($this->core->CONFIG['page_charset'], 'gbk', $data);
	$data = "<?php\r\nreturn ". var_export($data, true) .';';
	
	write_file($path .'#data.php', $data);
	
	return true;
}

/**
* 导入模型
* @param string $name 模型的名称
* @param string $alias POST的模型别名
* @return int add方法返回的值
**/
function import($name, $alias){
	
	//模型数据以及字段
	$path = $this->system->path .'#export/'. $name .'/';
	
	if(!is_dir($path)){
		return false;
	}
	
	$data = include $path .'#data.php';
	$addon = array('#fields' => $data['#fields']);
	unset($data['#fields']);
	
	$data['alias'] = $alias;
	
	//直接添加
	if($status = $this->add($data, $addon)){
		
		require_once PHP168_PATH .'install/install.func.php';
		
		//新安装时不用覆盖了，本来就有,可以缩短安装时间
		if(is_file( PHP168_PATH .'data/install.lock')){
			$_path = CACHE_PATH .'tmp/cms_model_import/'. $name .'/';
			cp($path, $_path);
					
			convert_file_encode($_path, 'gbk', $this->core->CONFIG['page_charset'], '.js|.css|.html|.php');
			
			//把所有文件覆盖到根目录即可
			cp($_path, PHP168_PATH);
			rm($_path);
			rm(PHP168_PATH .'#data.php');
		}
		//执行导入后的操作
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
* 更新一个模型,参数基本同add
* @return bool 是否修改成功
* 模型名称不能修改
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
* 删除一个模型
* @param int|array $cond 要删除的条件
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
		//删除字段
		$this->DB_master->delete($this->field_table, "model IN ($names)");
		
		$item = &$this->system->load_module('item');
		$role = $this->core->load_module('role');
		
		foreach($models as $model){
			$item->set_model($model['name']);
			
			//删除脚本
			rm($this->system->path .'model/'. $model['name']);
			//后台模板
			rm(TEMPLATE_PATH .'admin/'. $this->system->name .'/'. $item->name .'/'. $model['name']);
			
			foreach($this->core->CONFIG['templates'] as $template => $alias){
				//模板文件
				rm(TEMPLATE_PATH . $template .'/'. $this->system->name .'/'. $item->name .'/'. $model['name']);
				//风格文件夹
				rm(PHP168_PATH .'skin/'. $template .'/'. $this->system->name .'/'. $item->name .'/'. $model['name']);
			}
			
			foreach($this->core->CONFIG['language'] as $language => $alias){
				//语言包
				rm(LANGUAGE_PATH . $language .'/'. $this->system->name .'/'. $item->name .'/'. $model['name'] .'.php');
			}
			
			//删除模型缓存
			$CACHE->delete($this->system->name .'/modules', $this->name, $model['name']);
			
			if($this->DB_master->version() > '5.1.0'){
				//删除评论的表分区
				$this->DB_master->query("ALTER TABLE {$item->TABLE_}comment DROP PARTITION `$model[name]`");
			}
			
			$category = &$this->system->load_module('category');
			$category->delete(array(
				'where' => "model = '$model[name]'",
				'delete_hook' => true
			));
			
			//删除表
			$this->DB_master->query("DROP TABLE $item->table");
			$this->DB_master->query("DROP TABLE $item->addon_table");
			
			//清除权限
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
* 为模型增加一个字段
* @param int $mid 模型ID
* @param string $name 字段名称(唯一)
* @param string $alias 字段别名
* @param string $type 字段类型
* @param int $length 字段长度
* @param bool $is_unsigned 非负数
* @param string $widget 输入方式
* @param int $display_order 排序
* @return int 返回的ID
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
* 修改一个字段,参数基本同add_field
* @return bool
**/
function update_field($id, &$data){
	$model = $this->get_model($data['model']);
	$data['data'] = $this->DB_master->escape_string(serialize($data['data']));
	$data['config'] = $this->DB_master->escape_string(serialize($data['config']));
	
	if(empty($model)) return false;
	
	//不允许修改模型,字段存放表
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
* 连接字段的SQL
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
* 删除一个字段
* @param string 要删除的条件
**/
function delete_field($cond){
	
	$field = $this->DB_master->fetch_one("SELECT id, name, model, list_table FROM $this->field_table WHERE $cond");
	if(empty($field)) return false;
	//内容字段不能删除
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
* 更新特定或所有模型的缓存
* @param string $name 要更新模型的名称, 如果传入了特定的模型名称, 则只生成特定模型的缓存
**/
function cache($name = ''){
	parent::cache();
	
	$models = $this->DB_master->fetch_all("SELECT * FROM $this->table");
	
	//读取缓存的模型
	$cache_models = array();
	foreach($models as $model){
		$config = mb_unserialize($model['config']);
		unset($model['config']);
		$cache_models[$model['name']] = $model;
		
		//如果指定了模型
		if($name && $model['name'] != $name) continue;
		
		//读取各模型的字段
		$fields = $this->DB_master->fetch_all("SELECT id, name, parent, alias, type, not_null, length, is_unsigned, editable, default_value, widget, widget_addon_attr, data, list_table, filterable, orderby, config, units, description
			FROM $this->field_table
			WHERE model = '$model[name]' ORDER BY display_order DESC");
		
		$_model = $model;
		$this->_model_fields = &$fields;
		unset($_model['name']);
		$_model['fields'] = array();
		$_model['filterable_fields'] = array();
		
		//各字段缓存
		foreach($fields as $field){
			$field['data'] = mb_unserialize($field['data']);
			$field['CONFIG'] = mb_unserialize($field['config']);
			
			$_model['fields'][$field['name']] = $field;
			
			switch($field['widget']){
				case 'checkbox':
				case 'multi_select':
				case 'multi_uploader':
					//多选以,分隔
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
		
		//配置
		$_model['CONFIG'] = $config;
		
		//$this->template_cache($model['name'], $this->_model_fields);
		
		//写单个模型缓存
		$this->core->CACHE->write($this->system->name .'/modules', $this->name, $model['name'], $_model, 'serialize');
	}
	
	//写模型总缓存
	$this->core->CACHE->write($this->system->name .'/modules', $this->name, 'models', $cache_models);
}

/**
* 生成模板
**/
function template_cache($model, $fields = array()){
	
	if(empty($fields)){
		$this->_model_fields = $this->DB_master->fetch_all("SELECT id, name, alias, type, not_null, length, is_unsigned, editable, default_value, widget, widget_addon_attr, data, list_table, filterable, orderby, config, units, description
		FROM $this->field_table
		WHERE model = '$model' ORDER BY display_order DESC");
	}
	
	//把所有widget都集成到一个模板
	//后台
	$edit_template_dir = TEMPLATE_PATH .'admin/'. $this->system->name .'/item/';
	md($edit_template_dir);
	
	//蓝本
	if(is_file($edit_template_dir . $model .'/#edit.html')){
		$file = $edit_template_dir . $model .'/#edit.html';
	}else{
		$file = $edit_template_dir .'edit.html';
	}
	$content = file_get_contents($file);
	//清除循环
	$content = preg_replace('/<\!--\!\!foreach_widgets\!\!-->([\s\S]+?)<\!--\!\!foreach_widgets\!\!-->/', '', $content);
	//每个widget
	$content = preg_replace_callback('/<\!--\!\!widgets\!\!-->([\s\S]+?)<\!--\!\!widgets\!\!-->/', array(&$this, 'edit_template_callback'), $content);
	write_file($edit_template_dir . $model .'/edit.html', $content);
	
	
	
	//会员中心
	$edit_template_dir = TEMPLATE_PATH . $this->core->CONFIG['member_template'] .'/'. $this->system->name .'/item/';
	md($edit_template_dir);
	
	//蓝本
	if(is_file($edit_template_dir . $model .'/#edit.html')){
		$file = $edit_template_dir . $model .'/#edit.html';
	}else{
		$file = $edit_template_dir .'edit.html';
	}
	$content = file_get_contents($file);
	//清除循环
	$content = preg_replace('/<\!--\!\!foreach_widgets\!\!-->([\s\S]+?)<\!--\!\!foreach_widgets\!\!-->/', '', $content);
	//每个widget
	$content = preg_replace_callback('/<\!--\!\!widgets\!\!-->([\s\S]+?)<\!--\!\!widgets\!\!-->/', array(&$this, 'edit_template_callback'), $content);
	write_file($edit_template_dir . $model .'/edit.html', $content);
	
	
	
	//列表页
	$list_template_dir = TEMPLATE_PATH . $this->system->CONFIG['template'] .'/'. $this->system->name .'/item/';
	md($list_template_dir . $model);
	
	//蓝本
	if(is_file($list_template_dir . $model .'/#list.html')){
		$file = $list_template_dir . $model .'/#list.html';
	}else{
		$file = $list_template_dir .'#/list.html';
	}
	$content = file_get_contents($file);
	//清除循环
	$content = preg_replace('/<\!--\!\!filterable_fields\!\!-->([\s\S]+?)<\!--\!\!filterable_fields\!\!-->/', '', $content);
	//每个field
	$content = preg_replace_callback('/<\!--\!\!fields\!\!-->([\s\S]+?)<\!--\!\!fields\!\!-->/', array(&$this, 'list_template_callback'), $content);
	write_file($list_template_dir . $model .'/list.html', $content);
	
}

/**
* 列表页
**/
function list_template_callback($m){
	$fields = '';
	$template = $m[1];
	
	foreach($this->_model_fields as $v){
		
		if(!$v['filterable']) continue;	//不可过滤
		
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
* 编辑页
**/
function edit_template_callback($m){
	
	static $_t_widgets = array();
	
	$widgets = '';
	$template = $m[1];
	foreach($this->_model_fields as $v){
		
		if(!$v['editable']) continue;	//不可编辑
		
		//JS验证的字段名称
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