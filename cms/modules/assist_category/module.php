<?php
defined('PHP168_PATH') or die();

class P8_CMS_Assist_category extends P8_Module{
var $categories;//����
var $sort_table;//����Ŀ��
var $list_table;//���������ݶ�Ӧ��

function P8_CMS_Assist_category(&$system, $name){

	$this->configurable = false;
	$this->system = &$system;
	parent::__construct($name);
	$this->sort_table = $this->TABLE_;
	$this->list_table = $this->TABLE_.'list';
}


/**
 * ��Ӷ������Ŀ
 * @param {array} $data
 * @return {boolean} ��ӳɹ�����TRUE
 */
function add_sort(&$data){
	$id = $this->DB_master->insert(
			$this->sort_table,
			$data,
			array('return_id' => true)
		);
	return $id;
}

/**
* ȡ�÷�������и����������
* @param int $id ����ID
**/
function get_parents($id){
	if(!$this->categories)$this->get_cache(true);
	if(!isset($this->categories[$id])) return array();

	$p = $this->categories[$id]['parent'];
	$ps = array();
	while($p){
		array_unshift($ps, $this->categories[$p]);
		unset($ps[0]['categories']);
		$p = $this->categories[$p]['parent'];
	}
	return $ps;
}
function get_childs_id($childs){
	$temp = array();
	foreach($childs as $v){
		if(isset($v['childs'])){
			$temp = $this->get_childs_id($v['childs']);
		}
		$temp[] = $v['id'];
	}
	return $temp;
}

/**
 * �õ����е�����
 * @param $id ������ID
 * @param $datas ������
 * @return {array} ���е�����,���νṹ
 */
function get_childs($id, $datas){
	$temp = array();
	foreach($datas as $v){
		if($v['parent'] == $id){
			$temp[$v['id']] = $v;
		}
	}
	if(empty($temp)) return $temp;
	foreach($temp as $vv){

		$childs = $this->get_childs($vv['id'], $datas);
		if(!empty($childs))$temp[$vv['id']]['childs'] = $childs;
	}
	return $temp;
}

/**
 * ����ɾ����Ŀ������
 * @param $list {array} Ҫɾ������,��������
 * @return {array} ɾ���ɹ����б�
 */
function delete_list($list){
	$temp = array();
	foreach($list as $v){
		$flag = $this->DB_master->query("DELETE FROM {$this->list_table} WHERE iid={$v['iid']} AND sid={$v['sid']}");
		if($flag)$temp[] = "{$v['sid']}_{$v['iid']}";
	}
	return $temp;
}

/**
 * ����Ŀ���������,��������,һ������ͬʱ��ӵ��������Ŀ��
 * @param $iid {int} ����ID
 * @param $list_sid ����ĿID�б�
 * @return {array} ��ӳɹ��ĸ���Ŀ�б�
 */
function add_list($iid,$sids){
	$temp = array();
	$list_sid = explode(",",$sids);
	foreach((array)$list_sid as $v){
		if(empty($v))continue;
		$flag = $this->DB_master->query("INSERT INTO {$this->list_table} (sid,iid) values ({$v},{$iid})");
		if($flag) $temp[] = $v;
		$this->item_count($v);
	}
	return $temp;
}
function item_count($id,$type=true,$count=1){
	$type=$type? "+":"-";
	$ps = $this->get_parents($id);
	$ids=array();
	foreach($ps as $p){
		$ids[]=$p['id'];
	}
	array_unshift($ids,$id);
	$ids = implode(",",$ids);
	$this->DB_master->update(
		$this->sort_table,
		array('item_count'=>'item_count'.$type.$count),
		"id in($ids)",
		false
	);
	
}
/**
 * ���¸���Ŀ
 * @param $data
 */
function update_sort($data,$id){
	$status=$this->DB_master->update(
		$this->sort_table,
		$data,
		"id='". $id."'"
	);
	return $status;
}

/**
 * ɾ������Ŀ������
 * @param $iid ����ID
 * @param $sid ��ĿID
 */
function delete_list_all($iid,$sid = 0){

	$query = "DELETE FROM {$this->list_table} WHERE iid={$iid} ";
	$query .= empty($sid) ? '' : 'AND sid={$sid}';

	return $this->DB_master->query($query);
}

/**
 * ���¸���Ŀ������
 * @param {int} $iid
 * @param {array} $list_sid
 */
function update_list($iid, $list_sid){
	$this->delete_list_all($iid);
	$this->add_list($iid, $list_sid);
	return true;
}
/**
 * ��ȡ��Ŀ����
 * @param {int} $id ����ID
 * @param {string} $ids
 */
function get_sids($id){
	$query=$this->DB_master->fetch_all("SELECT * FROM $this->list_table WHERE iid='$id'");
	$ids=array();
	foreach($query as $rs){
		$ids[]=$rs['sid'];
	}
	return implode(",",$ids);
}
/**
* ���ɻ���
* @param string $model ָ��ģ��,�����ָ��������������ģ�͵ķ���
* @param bool $cache_all �Ƿ��ÿ�����඼�����һ�������ļ�
* @param bool $write_cache �Ƿ�д����,�����,��д����,�������νṹ,����ʵʱˢ��
* @param array $id ֻ����ķ����ID��ϣ array(id1 => 1, id2 => 1 ...)
**/
function cache($cache_all = true, $write_cache = true, $id = array()){
	parent::cache();

	return include $this->path .'call/cache.call.php';
}

function get_cache($read_cache = true){
	if(!empty($this->categories)) return;

	global $CACHE;

	if(
		$read_cache &&
		$this->data = $CACHE->read(
			$this->system->name .'/modules',
			$this->name,
			'categories',
			'serialize'
		)
	){
		$this->categories = &$this->data['categories'];
		$this->top_categories = &$this->data['top_categories'];
	}else{
		$this->cache(false, false);
	}
}

/**
* ȡ�û����JSON
**/
function get_json(){
	global $CACHE;
	$json = $CACHE->read($this->system->name .'/modules', $this->name, 'json');
	return array(
	'json' => empty($json['json']) ? '{}' : $json['json'],
	'path' => empty($json['path']) ? '{}' : $json['path'],
	);
}
/**
* ��ǩ���õ�����, �ӿ�
* @param array $label ��ǩ����
* @param array $var ����
**/
function label(&$LABEL, &$label, &$var){

	$option = &$label['option'];
	$cids = $idsdb = $ids = '';

	$select=select();
	$select->from($this->list_table.' AS i', 'i.*');
	//����
	if(!empty($option['category'])){
		$select->in('i.sid', $option['category']);
	}
	//��ǰҳ��
	$page = 0;
	//�ܼ�¼��
	$count = 0;
	$page_size = $option['limit'];
	//echo $select->build_sql();
	
	//ȡ������
	$idsdb = $this->core->list_item(
		$select,
		array(
			'page' => &$page,
			'page_size' => $page_size,
			'count' => &$count,
			'sphinx' => $sphinx
		)
	);

	foreach($idsdb as $detail){
		$ids[] = $detail['iid'];
		$cids[$detail['iid']]=$detail['sid'];
	}
	$ids = implode(',', (array)$ids);
	unset($select, $tmp);

	//����
	$order = empty($option['order_by_string']) ? 'i.id DESC ' : $option['order_by_string'];
	$item = &$this->system->load_module('item');
	$fields = 'i.id, i.model, i.title, i.title_color, i.title_bold, i.sub_title, i.cid, i.frame, i.url, i.uid, i.username, i.attributes, i.summary, i.html_view_url_rule, i.views, i.comments, i.timestamp';

	$list=$this->DB_master->fetch_all("SELECT $fields FROM $item->main_table AS i WHERE i.id in($ids) ORDER BY $order");

	$category = &$this->system->load_module('category');
	$category->get_cache();
	$this->get_cache();
	
	$dot = empty($option['title_dot']) ? '' : '...';
	//����URL
	foreach($list as $k => $v){
		$v['category'] = $this->categories[$cids[$v['id']]];
		$v['#category'] = &$category->categories[$v['cid']];
		$list[$k]['url'] = p8_url($item, $v, 'view');
		$list[$k]['frame'] = attachment_url($v['frame']);
		$list[$k]['full_title'] = $v['title'];
		
		$list[$k]['title'] = p8_cutstr($v['title'], $option['title_length'], $dot);
		$list[$k]['summary'] = p8_cutstr($v['summary'], isset($option['summary_length'])?$option['summary_length']:0, '');
		//��������
		$list[$k]['category_name'] = $v['category']['name'];
		//����URL
		$list[$k]['category_url'] = $v['category']['url'];
		
		//�Ӵֺ���ɫ
		if(!empty($v['title_color'])) $list[$k]['title'] = '<font color="'. $v['title_color'] .'">'. $list[$k]['title'] .'</font>';
		if(!empty($v['title_bold'])) $list[$k]['title'] = '<b>'. $list[$k]['title'] .'</b>';
	}
	//�õ�Ƭ���
	$swidth = isset($option['width']) ? $option['width'] : 300;
	$sheight = isset($option['height']) ? $option['height'] : 300;
	//�����
	$case = mt_rand(100,999);
	//ÿ�еĿ��,���ڶ���
	$width = ($option['rows']>1) ? (100/$option['rows']-1).'%' : '99%';
	
	global $SKIN, $TEMPLATE, $RESOURCE;
	$this_system = &$this->system;
	$this_module = &$this;
	$SYSTEM = $this->system->name;
	$MODULE = $this->name;
	$core = &$this->core;
	
	if(!empty($label['option']['tplcode']) && strlen($label['option']['tplcode']) > 10){
		//��ʱ�����ģ��
		$tplcode = $LABEL->compile_template($label['option']['tplcode']);
		ob_start();
		eval($tplcode);
		$content = ob_get_clean();
		
	}else{
		//������ָ����ģ��
		$template = empty($var['#template#']) ? $label['option']['template'] : $var['#template#'];
		
		//�����ݰ���ģ��ȡ�ñ�ǩ����
		ob_start();
		include $LABEL->template($template);
		$content = ob_get_clean();
	}
	
	return isset($pages) ? array($content, $pages) : array($content);
}
}