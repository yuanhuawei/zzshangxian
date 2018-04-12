<?php
defined('PHP168_PATH') or die();

//P8_Forms::export($mid)
	
	$model = $this->DB_master->fetch_one("SELECT * FROM $this->model_table WHERE id = '$mid'");
	if(empty($model)) return false;
	
	$model['config'] = mb_unserialize($model['config']);
	//导出字段
	$_fields = $this->DB_master->fetch_all("SELECT * FROM $this->field_table WHERE model = '$model[name]'");
	//必须有字段才算模型
	if(empty($_fields)) return false;
	$name = $new_name = $model['name'];
	$data = array(
		'name' => $name,
		'alias' => $model['alias'],
		'config' => $model['config'],
		'post_template' => $model['post_template'],
		'list_template' => $model['list_template'],
		'view_template' => $model['view_template']
	);
	
	$fields = array();
	foreach($_fields as $v){
		unset($v['id']);
		$v['config'] = mb_unserialize($v['config']);
		$v['data'] = mb_unserialize($v['data']);
		$fields[$v['name']] = $v;
	}
	unset($_fields);
	
	//模型信息, 模型的名称以及字段
	$data['#fields'] = &$fields;
	
	
	$path = $this->path .'#export/'. $name .'/';
	$status = md($path); 
	$copies = array();
	$MODULE = $this->name;
	//脚本
	file_exists($this->path .'model/'. $name .'/') && $copies[$this->path .'model/'. $name .'/'] = $path .'/modules/'. $MODULE .'/model/'. $new_name .'/';
	
	foreach($this->core->CONFIG['templates'] as $template => $alias){
		//前台模板
		if($model['post_template'] && file_exists(TEMPLATE_PATH . $template .'/core/'. $MODULE .'/tpl/'. $model['post_template'] .'.html'))$copies[TEMPLATE_PATH . $template .'/core/'. $MODULE .'/tpl/'. $model['post_template'] .'.html'] = $path .'template/'. $template .'/core/'. $MODULE .'/tpl/'. $model['post_template'] .'.html';
		if($model['list_template'] && file_exists(TEMPLATE_PATH . $template .'/core/'. $MODULE .'/tpl/'. $model['list_template'] .'.html'))$copies[TEMPLATE_PATH . $template .'/core/'. $MODULE .'/tpl/'. $model['list_template'] .'.html'] = $path .'template/'. $template .'/core/'. $MODULE .'/tpl/'. $model['list_template'] .'.html';
		if($model['view_template'] && file_exists(TEMPLATE_PATH . $template .'/core/'. $MODULE .'/tpl/'. $model['view_template'] .'.html'))$copies[TEMPLATE_PATH . $template .'/core/'. $MODULE .'/tpl/'. $model['view_template'] .'.html'] = $path .'template/'. $template .'/core/'. $MODULE .'/tpl/'. $model['view_template'] .'.html';
	}
	
	foreach($this->core->CONFIG['language'] as $language => $alias){
		//语言包
		if(file_exists(PHP168_PATH .'lang/'. $language .'/core/'. $MODULE .'/'. $name .'.php'))
		$copies[PHP168_PATH .'lang/'. $language .'/core/'. $MODULE .'/'. $name .'.php'] = $path .'lang/'. $language .'/core/'. $MODULE .'/'. $new_name .'.php';
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
