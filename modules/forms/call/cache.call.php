<?php
defined('PHP168_PATH') or die();

//P8_Forms::cache($name = '')
	global $P8LANG;
	$models = $this->DB_master->fetch_all("SELECT * FROM $this->model_table");
	
	//读取缓存的模型
	$cache_models = $index =array();
	foreach($models as $model){
		$config = mb_unserialize($model['config']);
		unset($model['config']);
		$cache_models[$model['name']] = $model;
		$index[$model['id']] = $model['name'];
		//如果指定了模型
		if($name && !($model['name'] == $name || $model['id'] == $name)) continue;
		
		//读取各模型的字段
		$fields = $this->DB_master->fetch_all("SELECT id, name, parent, alias, type, not_null, length, is_unsigned, editable,manager_editable, default_value, widget, widget_addon_attr, data, list_table, filterable, orderby, config, units, description, part, jsreg, jsregmsg, color
			FROM $this->field_table
			WHERE model = '$model[name]' ORDER BY display_order DESC");
		
		$_model = $model;
		$this->_model_fields = &$fields;
		$_model['fields'] = array();
		$_model['filterable_fields'] = array();
		$parts = array();
		//各字段缓存
		foreach($fields as $field){
			$field_data = mb_unserialize($field['data']);
			$field['data'] = array();
			foreach($field_data as $key=>$val){
				$key = stripslashes(html_decode_entities($key));
				$val = stripslashes(html_decode_entities($val));
				$field['data'][$key] = $val;
			}
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
			
			if($field['filterable']){
				$_model['filterable_fields'][$field['name']] = &$_model['fields'][$field['name']];
			}
			if($field['list_table']){
				$_model['list_table_fields'][$field['name']] = &$_model['fields'][$field['name']];
			}
			if(!empty($field['part'])){
				$parts[$field['part']][$field['id']] = $field['name'];
			}
		}
		$_model['parts'] = !empty($parts)? $parts : array();
		$_model['path'] = $this->path . 'model/' . $model['name'] . '/';
		
		//配置
		$_model['CONFIG'] = $config;
		//$_model['CONFIG']['status'] = !empty($_model['CONFIG']['status'])? $_model['CONFIG']['status'] : array();
		//$_model['CONFIG']['status']['0'] = $P8LANG['forms_no_manage'];
		//$_model['CONFIG']['status']['-1'] = $P8LANG['forms_send_back'];
		
		
		//写单个模型缓存
		$this->core->CACHE->write($this->system->name .'/modules', $this->name, $model['name'], $_model, 'serialize');
	}
	
	//写模型总缓存
	$this->core->CACHE->write($this->system->name .'/modules', $this->name, 'models', $cache_models);
	$this->core->CACHE->write($this->system->name .'/modules', $this->name, 'index', $index);