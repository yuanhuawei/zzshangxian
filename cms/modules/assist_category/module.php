<?php
defined('PHP168_PATH') or die();

class P8_CMS_Assist_category extends P8_Module{
var $categories;//分类
var $sort_table;//辅栏目表
var $list_table;//辅栏表内容对应表

function P8_CMS_Assist_category(&$system, $name){

	$this->configurable = false;
	$this->system = &$system;
	parent::__construct($name);
	$this->sort_table = $this->TABLE_;
	$this->list_table = $this->TABLE_.'list';
}


/**
 * 添加多个辅栏目
 * @param {array} $data
 * @return {boolean} 添加成功返回TRUE
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
* 取得分类的所有父分类的数据
* @param int $id 分类ID
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
 * 得到所有的子类
 * @param $id 欲搜索ID
 * @param $datas 所有项
 * @return {array} 所有的子类,树形结构
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
 * 批量删除栏目下内容
 * @param $list {array} 要删除的项,复合主键
 * @return {array} 删除成功的列表
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
 * 辅栏目下添加内容,批量处理,一条内容同时添加到多个辅栏目下
 * @param $iid {int} 内容ID
 * @param $list_sid 辅栏目ID列表
 * @return {array} 添加成功的辅栏目列表
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
 * 更新辅栏目
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
 * 删除辅栏目下内容
 * @param $iid 内容ID
 * @param $sid 栏目ID
 */
function delete_list_all($iid,$sid = 0){

	$query = "DELETE FROM {$this->list_table} WHERE iid={$iid} ";
	$query .= empty($sid) ? '' : 'AND sid={$sid}';

	return $this->DB_master->query($query);
}

/**
 * 更新辅栏目下内容
 * @param {int} $iid
 * @param {array} $list_sid
 */
function update_list($iid, $list_sid){
	$this->delete_list_all($iid);
	$this->add_list($iid, $list_sid);
	return true;
}
/**
 * 获取栏目内容
 * @param {int} $id 文章ID
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
* 生成缓存
* @param string $model 指定模型,如果不指定则是生成所有模型的分类
* @param bool $cache_all 是否把每个分类都缓存成一个缓存文件
* @param bool $write_cache 是否写缓存,如果否,则不写缓存,保持树形结构,用于实时刷新
* @param array $id 只缓存的分类的ID哈希 array(id1 => 1, id2 => 1 ...)
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
* 取得缓存的JSON
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
* 标签调用的数据, 接口
* @param array $label 标签数据
* @param array $var 变量
**/
function label(&$LABEL, &$label, &$var){

	$option = &$label['option'];
	$cids = $idsdb = $ids = '';

	$select=select();
	$select->from($this->list_table.' AS i', 'i.*');
	//分类
	if(!empty($option['category'])){
		$select->in('i.sid', $option['category']);
	}
	//当前页码
	$page = 0;
	//总记录数
	$count = 0;
	$page_size = $option['limit'];
	//echo $select->build_sql();
	
	//取出数据
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

	//排序
	$order = empty($option['order_by_string']) ? 'i.id DESC ' : $option['order_by_string'];
	$item = &$this->system->load_module('item');
	$fields = 'i.id, i.model, i.title, i.title_color, i.title_bold, i.sub_title, i.cid, i.frame, i.url, i.uid, i.username, i.attributes, i.summary, i.html_view_url_rule, i.views, i.comments, i.timestamp';

	$list=$this->DB_master->fetch_all("SELECT $fields FROM $item->main_table AS i WHERE i.id in($ids) ORDER BY $order");

	$category = &$this->system->load_module('category');
	$category->get_cache();
	$this->get_cache();
	
	$dot = empty($option['title_dot']) ? '' : '...';
	//处理URL
	foreach($list as $k => $v){
		$v['category'] = $this->categories[$cids[$v['id']]];
		$v['#category'] = &$category->categories[$v['cid']];
		$list[$k]['url'] = p8_url($item, $v, 'view');
		$list[$k]['frame'] = attachment_url($v['frame']);
		$list[$k]['full_title'] = $v['title'];
		
		$list[$k]['title'] = p8_cutstr($v['title'], $option['title_length'], $dot);
		$list[$k]['summary'] = p8_cutstr($v['summary'], isset($option['summary_length'])?$option['summary_length']:0, '');
		//分类名称
		$list[$k]['category_name'] = $v['category']['name'];
		//分类URL
		$list[$k]['category_url'] = $v['category']['url'];
		
		//加粗和颜色
		if(!empty($v['title_color'])) $list[$k]['title'] = '<font color="'. $v['title_color'] .'">'. $list[$k]['title'] .'</font>';
		if(!empty($v['title_bold'])) $list[$k]['title'] = '<b>'. $list[$k]['title'] .'</b>';
	}
	//幻灯片宽高
	$swidth = isset($option['width']) ? $option['width'] : 300;
	$sheight = isset($option['height']) ? $option['height'] : 300;
	//随机数
	$case = mt_rand(100,999);
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
	
	return isset($pages) ? array($content, $pages) : array($content);
}
}