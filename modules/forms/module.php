<?php
defined('PHP168_PATH') or die();

class P8_Forms extends P8_Module{

var $table;			//主表
var $model_table;	//模型表
var $field_table;	//字段表
var $model;			//当前模型
var $MODEL;			//当前模型名称
var $data_table;	//当前模型数据表
var $_html;

function __construct(&$system, $name){
	$this->system = &$system;
	//不可配置
	parent::__construct($name);
	
	$this->table = $this->TABLE_.'item';
	$this->model_table = $this->TABLE_.'model';
	$this->field_table = $this->TABLE_.'model_field';
	$this->delimiter = chr(7);
	$this->col_delimiter = chr(6);
	$this->_html = array();
	
	//可选的字段类型 类型 => 语言包键值
	$this->field_types = array(
		'varchar'		=> 'forms_model_field_type_varchar',
		'tinyint'		=> 'forms_model_field_type_tinyint',
		'smallint'		=> 'forms_model_field_type_smallint',
		'mediumint'		=> 'forms_model_field_type_mediumint',
		'int'			=> 'forms_model_field_type_int',
		'bigint'		=> 'forms_model_field_type_bigint',
		
		'decimal'		=> 'forms_model_field_type_decimal',
		
		'char'			=> 'forms_model_field_type_char',
		
		'text'			=> 'forms_model_field_type_text',
		'mediumtext'	=> 'forms_model_field_type_mediumtext',
		'longtext' 		=> 'forms_model_field_type_longtext'
	);
	
	//可选的输入类型
	$this->widgets = array(
		'text'			=> 'forms_model_widget_text',
		'textarea'		=> 'forms_model_widget_textarea',
		'textdate'		=> 'forms_model_widget_textdate',
		
		'radio'			=> 'forms_model_widget_radio',
		'checkbox'		=> 'forms_model_widget_checkbox',
		
		'multi_select'	=> 'forms_model_widget_multi_select',
		'select'		=> 'forms_model_widget_select',
		'link'			=> 'forms_model_widget_link',
		'uploader'		=> 'forms_model_widget_uploader',
		'multi_uploader'=> 'forms_model_widget_multi_uploader',
		'image_uploader'=> 'forms_model_widget_image_uploader',
		'video_uploader'=> 'forms_model_widget_video_uploader',
		
		'editor'		=> 'forms_model_widget_editor',
		'editor_basic'	=> 'forms_model_widget_editor_basic',
		'editor_common'	=> 'forms_model_widget_editor_common',
		
		'city' 			=> 'forms_model_widget_city',
		
		'linkage' 			=> 'forms_model_widget_linkage',
	);
}

function P8_Forms(&$system, $name){
	$this->__construct($system, $name);
}
/**
*设置当前的模型
*@param string $name 名称
**/
function set_model($name,$id=false){
	if(empty($name))return false;
	global $this_model;
	if(!preg_match('/^[a-zA-z]/', $name))$id=true;
	if($id){
		$index = $this->core->CACHE->read('core/modules', 'forms', 'index');
		if(!$index){
			$this->cache();
			$index = $this->core->CACHE->read('core/modules', 'forms', 'index');
		};
		$name = $index[$name];
	}
	$_model = $this->core->CACHE->read('core/modules', 'forms', $name, 'serialize');
	if(!$_model){
		$this->cache($name);
		$_model = $this->core->CACHE->read('core/modules', 'forms', $name, 'serialize');
	};
	if(!$_model)return false;
	unset($_model['config']);
	unset($this->model);
	$this->model = $this_model =$_model;
	$this->MODEL = $this->model['name'];
	$this->data_table = $this->table.'_'.$this->model['name'];
	return true;
}
/**
*取模型原始数据
*@param int or string $name 名称或ID,取决于第二个参数
*@param bool $id 可选,确定第一个参数是名称或ID
**/
function get_model($name,$id=false){
	$where = $id? " id = '".intval($name)."'" : " name = '$name'";
	return $this->DB_master->fetch_one("SELECT * FROM $this->model_table WHERE $where");
}

function add(&$data){
	//插入主表取得ID
	$id = $this->DB_master->insert(
		$this->table,
		$this->DB_master->escape_string($data['main']),
		array('return_id' => true)
	);
	
	if(empty($id)) return false;
	
	//收集己上传的附件
	if(isset($data['attachment_hash'])){
		uploaded_attachments($this, $id, $data['attachment_hash']);
		unset($data['attachment_hash']);
	}
	
	$data['item']['id'] = $id;
	$st = $this->DB_master->insert(
		$this->data_table,
		$this->DB_master->escape_string($data['item'])
	);
	if(!$st){
		$this->delete(array('ids'=>array($id)));
		return false;
	}
	//数据修改
	$this->change_count(1,'+');
	return $id;
}

function update($id,&$data){
	$status = true;
	//收集己上传的附件
	if(isset($data['attachment_hash'])){
		uploaded_attachments($this, $id, $data['attachment_hash']);
		unset($data['attachment_hash']);
	}
	$status |= $this->DB_master->update(
		$this->table,
		$this->DB_master->escape_string($data['main']),
		"id = '$id'"
	);
	$status |=	$this->DB_master->update(
		$this->data_table,
		$this->DB_master->escape_string($data['item']),
		"id = '$id'"
	);
	
	return $status;
}

function delete($data){

	$this->DB_master->delete(
			$this->table,
			"id in(".implode(",",$data['ids']).")"
	);
	$this->DB_master->delete(
			$this->data_table,
			"id in(".implode(",",$data['ids']).")"
	);
	//数据修改
	$this->change_count(count($data['ids']),'-');
	return $data['ids'];
}
/**
*取一条数据
*@param int $id ID
*@param string $name 模型名称
*@return array 返回查询结果
**/
function get_data($id,$name=''){
	if(!$name)
		return $this->DB_master->fetch_one("SELECT * FROM $this->table WHERE id = '$id'");
	else
		return $this->DB_master->fetch_one("SELECT i.*, d.* FROM $this->table AS i LEFT JOIN $this->data_table AS d ON i.id = d.id WHERE i.id = '$id'");
}

function status($data){
	$this->DB_master->update(
			$this->table,
			$this->DB_master->escape_string(array(
				'status' => $data['status'],
				'recommend' => $data['recommend'],
				'reply' => $data['reply'],
				'replyer' => $data['replyer'],
				'reply_time' => P8_TIME
			)),
			"id in($data[ids])"
		);
		return $this->DB_master->fetch_all("SELECT id, status,reply, reply_time FROM $this->table WHERE id IN($data[ids]) ");
}

function get_statuses(){
	$query = $this->DB_master->fetch_all("SELECT id,name FROM $this->model_table");
	$statuses = array();
	foreach($query as $key => $rs){
		$this_model = $this->core->CACHE->read('core/modules', 'forms', $rs['name'], 'serialize'); 
		$statuses[$rs['id']] = $this_model['CONFIG']['status'];
	}
	return $statuses;
}

function verify($data){
	$this->DB_master->update(
		$this->table,
		array(
			'verified' => abs(1-$data['ov'])
		),
		"id in($data[ids])"
	);
	
	return $this->DB_master->fetch_all("SELECT id, verified FROM $this->table WHERE id IN($data[ids]) ");
}

/**
* 格式化数据
* @param array $data
**/
function format_data(&$data, $length=0){

	foreach($this->model['fields'] as $field => $v){
		
		if(!isset($data[$field])) continue;
		
		switch($v['widget']){
		
		//分割多选项
		case 'checkbox':
		case 'multi_select':
			$tmp = explode($this->delimiter, $data[$field]);
			$data[$field] = array();
			foreach($tmp as $vv){
				foreach($v['data'] as $value => $key){
					if($vv == $value) $data[$field][$value] = $value;
				}
			}
			unset($tmp);
		break;
		
		//上传器,编辑器要对附件地址处理
		case 'editor': case 'editor_basic': case 'editor_common':case 'ueditor': case 'ueditor_common':
			$data[$field] = attachment_url($data[$field]);
		break;
		
		case 'uploader': case 'image_uploader':
			$tmp = explode($this->delimiter, attachment_url($data[$field]));
			$data[$field] = array(
				'title' => $tmp[0],
				'url' => isset($tmp[1]) ? $tmp[1] : '',
				'thumb' => isset($tmp[2]) ? $tmp[2] : ''
			);
		break;
		
		//多上传器
		case 'multi_uploader':
			$tmp = explode($this->delimiter, attachment_url($data[$field]));
			
			$data[$field] = array();
			foreach($tmp as $v){
				$v = explode($this->col_delimiter, $v);
				$data[$field][] = array(
					'title' => $v[0],
					'url' => isset($v[1]) ? $v[1] : '',
					'thumb' => isset($v[2]) ? $v[2] : ''
				);
			}
			unset($tmp);
		break;	
		//case 'link':
		//	$data[$field] = preg_match("/^(http|https)/i",$data[$field])? $data[$field] : 'http://'.$data[$field];
		case 'link':
            if(strpos($data[$field], '|')){
                $linktemp = explode('|', $data[$field]);
                $data[$field] = array('txt'=>$linktemp[0], 'url'=>$linktemp[1]);
                !empty($linktemp[2]) && $data[$field]['target']=$linktemp[2];
            }else{
                $data[$field] = preg_match("/^(http|https)/i",$data[$field])? $data[$field] : 'http://'.$data[$field];
            }
        
        break;
		//时间选择器
		case 'textdate':
			$data[$field] = empty($data[$field]) ? '' : date('Y-m-d',$data[$field]);
		break;
		}
		$length && $data[$field] = p8_cutstr($data[$field], $length,'');//为标签而作
	}
	
}


/**
* 格式化数据
* @param array $data
**/
function format_view(&$data){

	foreach($this->model['fields'] as $field => $v){
		
		if(!isset($data[$field])) continue;
		
		switch($v['widget']){
		
			//城市
			case 'city':
				$area = area();
				$area->get_cache();
				$ps = $area->get_parents($data[$field]);
				$data[$field] = $area->areas[$data[$field]]['name'];
				$_a = '';
				foreach($ps as $k =>$v){
					$_a .= $v['name'].'>';
				}
				$data[$field] = $_a.$data[$field];
			break;
			case 'textarea':
			$data[$field] = nl2br($data[$field]);
			break;
			case 'linkage':
				$values = explode('-',$data[$field]);
				$resust = array();
				$filedata = mb_unserialize($v['data']['select_data']);
				foreach($values as $key=>$val){
					if($key==0)
						$filedata = !empty($filedata[$val])? $filedata[$val] : array();
					else
						$filedata = !empty($filedata['s'][$val])? $filedata['s'][$val] : array();;
					if($val && !empty($filedata))$resust[$val] = $filedata['n'];
				}
				$data[$field] = $resust;
			break;
		}
	}


}

/**
* 添加一个模型
* @param string $name 模型名称(唯一)
* @param string $alias 模型别名
* @return int 返回的ID
**/
function add_model(&$data){
	return include $this->path .'call/add_model.call.php';
}

function update_model($id,$data){
	$data['config'] = $this->DB_master->escape_string(serialize($data['config']));
	if(
		$status = $this->DB_master->update(
			$this->model_table,
			$data,
			"id = '$id'"
		)
	){
		
		$this->cache($id);
	}
	return $status;
}

function export($mid){
	return include $this->path .'call/export.call.php';
}
/**
* 导入模型
* @param string $name 模型的名称
* @param string $alias POST的模型别名
* @return int add方法返回的值
**/
function import($post, $oname){
	return include $this->path .'call/import.call.php';
}

function delete_model($mid){
	$this->set_model($mid,true);
	//删除数据
	$this->DB_master->delete(
		$this->table,
		"mid='$mid'"
	);
	//删除字段
	$filds = $this->DB_master->fetch_all("SELECT * FROM $this->field_table WHERE model = '$this->MODEL'");
	if(is_array($filds)){
		foreach($filds as $field){
			$this->delete_field($field['id']);
		}
	
	}
	//删除数据表
	$this->DB_master->fetch_one("DROP TABLE IF EXISTS `$this->data_table`");
	//删除模型
	$this->DB_master->delete(
		$this->model_table,
		"id='$mid'"
	);
	return $mid;	
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
	$data['data'] = $this->DB_master->escape_string(serialize($data['data']));
	$data['config'] = $this->DB_master->escape_string(serialize($data['config']));
	if(
		$status = $this->DB_master->insert(
			$this->field_table,
			$data,
			array('return_id' => true)
		)
	){
		
		$field = $this->field_sql($data);
		
		$status = $this->DB_master->query("ALTER TABLE $this->data_table ADD `$data[name]` $field");
		$this->cache($this->model['id']);
	}
	
	return $status;
}


/**
* 修改一个字段,参数基本同add_field
* @return bool
**/
function update_field($id, &$data){
	$data['data'] = $this->DB_master->escape_string(serialize($data['data']));
	$data['config'] = $this->DB_master->escape_string(serialize($data['config']));
	$fielddb = $this->get_field($id);
	$fieldname = $fielddb['name'];
	//不允许修改模型,字段存放表
	unset($data['model']);
	unset($data['name']);
	if(
		$status = $this->DB_master->update(
			$this->field_table,
			$data,
			"id = '$id'"
		)
	){
		$field = $this->field_sql($data);
		$status = $this->DB_master->query("ALTER TABLE $this->data_table CHANGE `$fieldname` `$fieldname` $field");
		$this->cache($this->model['id']);
	}
	//return $status;
}

/**
* 修改一个字段,只修改与字段类型无关的资料
* @return bool
**/
function update_field_data($id, $data){
	!empty($data['data']) && $data['data'] = $this->DB_master->escape_string(serialize($data['data']));
	!empty($data['config']) && $data['config'] = $this->DB_master->escape_string(serialize($data['config']));
	//不允许修改模型,字段存放表
	unset($data['model']);
	unset($data['type']);
	unset($data['name']);
	unset($data['not_null']);
	if(
		$status = $this->DB_master->update(
			$this->field_table,
			$data,
			"id = '$id'"
		)
	){
		$this->cache($this->model['id']);
	}
	return $status;
}

function delete_field($id){
	$field=$this->get_field($id);
	if(empty($field))return false;
	if($status = $this->DB_master->delete($this->field_table,"id='$id'")){
		$this->DB_master->query("ALTER TABLE $this->data_table DROP `$field[name]`");
		$this->cache();
		return true;
	}
	return false;
}

/**
*取模型原始数据
*@param int or string $name 名称或ID,取决于第二个参数
*@param bool $id 可选,确定第一个参数是名称或ID
**/
function get_field($id){
	return $this->DB_master->fetch_one("SELECT * FROM $this->field_table WHERE id='$id'");
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
* 更新特定或所有模型的缓存
* @param string $name 要更新模型的名称, 如果传入了特定的模型名称, 则只生成特定模型的缓存
**/
function cache($name = ''){
	parent::cache();
	return include $this->path .'call/cache.call.php';
}

/**
*修改数据量
*@param int $count
*@param string $type
*@param string $model
**/
function change_count($count, $type, $model=''){
	$M = $model? $model : $this->model['name'];
	if($type == '+'){
		$set = "count+$count";
	}elseif($type == '-'){
		$set = "count-$count";
	}
	return $this->DB_master->update(
		$this->model_table,
		array('count' => $set),
		"name = '$M'",
		false
	);
}

function html($id){
	return include $this->path .'call/html.call.php';
}

function clean($ids){

	foreach($ids as $id)
	{
		$id = intval($id);
		if(!$id)continue;
		$model_info = $this->set_model($id,true);
	
		$this->DB_master->delete(
				$this->table,
				"mid=$id"
		);
		$this->DB_master->delete(
				$this->data_table
		);
		//数据修改
		$this->DB_master->update(
			$this->model_table,
			array('count' => '0'),
			"id = '$id'",
			false
		);
	}
}


/**
* 标签调用的数据, 接口
* @param array $LABEL 标签模块
* @param array $label 标签数据
* @param array $var 变量
**/
function label(&$LABEL, &$label, &$var){

	$option = &$label['option'];
	$mid = $option['mid'];
	$this->set_model($mid);
	if(!$this->model)return false;
	$this_model = $this->model;
	$option['fields'] = $option['fields']? $option['fields'] : array_keys($this_model['fields']);
	$afields = 'a.*';
	if(isset($option['fields'])){
		$afields = $dash = '';
		foreach($option['fields'] as $field){
			$afields .= $dash.'a.'.$field;
			$dash = ',';
		}
	}
	$select = select();
	$select->from($this->table .' AS i', 'i.*');
	$select->inner_join($this->data_table .' AS a', $afields, 'a.id = i.id');
	//$select->in('i.verified',1);
	isset($option['status']) && $select->in('i.status',$option['status']);
	if(isset($option['recommend']) && $option['recommend']>=0)$select->in('i.recommend',$option['recommend']);
	//排序
	if(!empty($option['order_by_string'])){
		$select->order($option['order_by_string']);
	}else{
		$select->order('i.list_order DESC');
	}
	
	//当前页码
	$page = 0;
	//总记录数
	$count = 0;
	$page_size = $option['limit'];

	//echo $select->build_sql().'<br>';
	
	$list = $this->core->list_item(
		$select,
		array(
			'page' => &$page,
			'page_size' => $page_size,
			'count' => &$count,
			//'sphinx' => $sphinx
		)
	);
	unset($select, $tmp);
	//幻灯片宽高
	$swidth = isset($option['width']) ? $option['width'] : 300;
	$sheight = isset($option['height']) ? $option['height'] : 300;
	
	//每行的宽度,用于多列
	$width = isset($option['rows']) && $option['rows'] > 1 ? (100/$option['rows']-1).'%' : '99%';
	$wf ='';
	if($width!='99%'){
		$wf = "width:$width;float:left;margin-right:1%";
	}	
	
	foreach($list as $key=>$detail){
		$this->format_data($list[$key] ,$option['title_length']);
		$this->format_view($list[$key]);
		$list[$key]['url'] = p8_url($this, $detail, 'view');
	}

	global $SKIN, $TEMPLATE, $RESOURCE;
	$this_system = &$this->system;
	$this_module = &$this;
	$SYSTEM = $this->system->name;
	$MODULE = $this->name;
	$core = &$this->core;
	
	if(!empty($label['option']['tplcode']) && strlen($label['option']['tplcode']) > 10){
		//即时编译的模板
		$tplcode = $LABEL->compile_template($label['option']['tplcode']);
		ob_start();
		eval($tplcode);
		$content = ob_get_clean();
		
	}else{
		//变量中指定了模板
		$template = empty($var['#template#']) ? $label['option']['template'] : $var['#template#'];
		
		//用数据包含模板取得标签内容
		ob_start();
		include $LABEL->template($template);
		$content = ob_get_clean();
	}
	
	return isset($pages) ? array($content, $pages) : array($content);
}

}