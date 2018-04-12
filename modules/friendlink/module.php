<?php
defined('PHP168_PATH') or die();


class P8_Friendlink extends P8_Module{

var $table;
var $table_link;
var $table_sort;

function P8_Friendlink(&$system, $name){
	$this->system = &$system;
	$this->configurable = false;
	//不可配置
	parent::__construct($name);

	$this->table = $this->TABLE_;
	$this->table_link = $this->TABLE_ .'link';
	$this->table_sort = $this->TABLE_ .'sort';

}

function add_sort($datas){
	return $this->DB_master->insert($this->table_sort, $datas, array('return_id' => true));
}

function add_link($datas){
	return $this->DB_master->insert($this->table_link, $datas, array('return_id' => true));
}

function list_sort(){

	$select = select();
	$select->from($this->table_sort);
	$this->core->list_item();
}

function update_link($datas){

	$query = "UPDATE {$this->table_link} SET name='{$datas['name']}', fid={$datas['fid']}, url='{$datas['url']}',logo='{$datas['logo']}',descrip='{$datas['descrip']}', ifhide={$datas['ifhide']}, yz={$datas['yz']}, iswordlink={$datas['iswordlink']}, endtime={$datas['endtime']} WHERE id={$datas['id']}";
	return $this->DB_master->query($query);
}
function update_list($datas){
	$query = "UPDATE {$this->table_link} SET list='{$datas['list']}' WHERE id='{$datas['id']}'";
	return $this->DB_master->query($query);
}
function update_sort($datas){

	$query = "UPDATE {$this->table_sort} SET name='{$datas['name']}', list={$datas['list']} WHERE fid={$datas['fid']}";
	return $this->DB_master->query($query);
}

function delete_sort($fid){

	$query = "DELETE FROM {$this->table_sort} WHERE fid IN (". implode(',', $fid) .")";
	$query1 = "DELETE FROM {$this->table_link} WHERE fid IN (". implode(',', $fid) .")";
	
	return $this->DB_master->query($query)&&$this->DB_master->query($query1);
}

function delete_link($id){

	$query = "DELETE FROM {$this->table_link} WHERE id IN (". implode(',', $id) .")";
	return $this->DB_master->query($query);
}

/**
 * 标签调用的数据, 接口
 * @param array $label 标签数据
 * @param array $var 变量
 **/
function label(&$LABEL, &$label, &$var){

	$option = &$label['option'];
	$fids = isset($option['display_content']) ? explode(',', $option['display_content']):array();
	
	$select = select();
	$select->from("{$this->table_link} AS l", 'l.*');
	$select->in('l.yz', '1');
	$select->in('l.ifhide', '0');
	$select->inner_join("{$this->table_sort} AS s", 's.name sname', 'l.fid = s.fid');
	$select->in('s.fid', $fids);
	$select->order('s.list DESC, l.list DESC');
	$datas = $this->core->list_item($select);
	
	$list = array();
	foreach($datas as $v){
		$v['endtime'] = !empty($v['endtime']) ? ($v['endtime'] > P8_TIME ? 0 : 1) : 0;
		$v['logo'] = attachment_url($v['logo']);
		$list[$v['fid']]['name'] = $v['sname'];
		$list[$v['fid']]['fid'] = $v['fid'];
		$list[$v['fid']]['list'] = $v['list'];
		$list[$v['fid']]['link'][] = $v;
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
	
	return array($content);
}

}