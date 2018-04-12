<?php
defined('PHP168_PATH') or die();
class P8_Interview extends P8_Module{

var $table;

function P8_Interview(&$system, $name){

	$this->system = &$system;
	parent::__construct($name);
	$this->table_ask = $this->TABLE_.'ask';
	$this->table_content = $this->TABLE_.'content';
	$this->table_picture = $this->TABLE_.'picture';
	$this->table_subject = $this->TABLE_.'subject';
	$this->table_person = $this->TABLE_.'person';
	$this->CONFIG['dynamic_view_url_rule']='{$module_controller}-view-{$id}.html';//动态详细页地址
}

function add_subject($data){
	return  $this->DB_master->insert($this->table_subject, $data);
}

function add_picture($data){
	return $this->DB_master->insert($this->table_picture, $data);
}

function add_content($data){
	return $this->DB_master->insert($this->table_content, $data, array('return_id'=>true));
}

function add_ask($data){
	return $this->DB_master->insert($this->table_ask, $data);
}

function delete_subject($id){
	$query = "DELETE FROM {$this->table_subject} WHERE id IN (". implode(',', $id) .")";
	$query1 = "DELETE FROM {$this->table_content} WHERE sid IN (". implode(',', $id) .")";
	$query2 = "DELETE FROM {$this->table_picture} WHERE sid IN (". implode(',', $id) .")";
	$query3 = "DELETE FROM {$this->table_ask} WHERE sid IN (". implode(',', $id) .")";
	$flag = $this->DB_master->query($query)&&$this->DB_master->query($query1)&&
	$this->DB_master->query($query2)&&$this->DB_master->query($query3);
	return $flag;
}

function delete_picture($id){
	$query = "DELETE FROM {$this->table_picture} WHERE id IN (". implode(',', $id) .")";
	return $this->DB_master->query($query);
}

function delete_content($id){
	$query = "DELETE FROM {$this->table_content} WHERE id IN (". implode(',', $id) .")";
	return $this->DB_master->query($query);
}

function delete_ask($id){
	$query = "DELETE FROM {$this->table_ask} WHERE id IN (". implode(',', $id) .")";
	return $this->DB_master->query($query);
}

function check_ask($id){
	$query = "UPDATE {$this->table_ask} SET status=1 WHERE id IN (". implode(',', $id) .")";
	return $this->DB_master->query($query);
}

function update_subject($data){

	$query = "UPDATE {$this->table_subject} SET ".
			 "title='{$data['title']}',".
			 "summary='{$data['summary']}',".
			 "status={$data['status']},".
			 "picture='{$data['picture']}',".
			 "video='{$data['video']}',".
			 "type={$data['type']},".
			 "gpicture='{$data['gpicture']}',".
			 "gname='{$data['gname']}',".
			 "gintroduction='{$data['gintroduction']}',".
			 "cpicture='{$data['cpicture']}',".
			 "cname='{$data['cname']}',".
			 "cintroduction='{$data['cintroduction']}',".
			 "begintime={$data['begintime']},".
			 "endtime={$data['endtime']},".
			 "posttime={$data['posttime']} ".
			 "WHERE id={$data['id']}";

	return $this->DB_master->query($query);
}

/**
 * 标签调用的数据, 接口
 * @param array $label 标签数据
 * @param array $var 变量
 **/
function label(&$LABEL, &$label, &$var){
	$option = &$label['option'];
	$sid = isset($option['display_content']) ? explode(',', $option['display_content']) : array();

	$select = select();
	$select->from("{$this->table_subject}");
	$sid = array_filter($sid);
	if($sid)$select->in('id',$sid);
	$count=$option['limit'];
	$list = $this->core->list_item($select,array('page_size' => &$count));
	foreach($list as $k=> $v){
		$list[$k]['url'] = p8_url($this, $v, 'view');;
		$list[$k]['full_title'] = $v['title'];
		$dot = empty($option['title_dot']) ? '' : '...';
		$list[$k]['title'] = p8_cutstr($v['title'], isset($option['title_length'])?$option['title_length']:60, $dot);
		$list[$k]['frame']=attachment_url($list[$k]['picture']);
		$list[$k]['gpicture']=attachment_url($list[$k]['gpicture']);
		$list[$k]['cpicture']=attachment_url($list[$k]['cpicture']);
		$list[$k]['summary'] = p8_cutstr($v['summary'], isset($option['summary_length'])?$option['summary_length']:0, '');
	}
	//随机数
	$rand = rand_str(4);
	//每行的宽度,用于多列
	$width = ($option['rows']>1) ? (100/$option['rows']-1).'%' : '99%';
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