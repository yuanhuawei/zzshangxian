<?php
class P8_Ask_Member extends P8_module{

var $table_member;
var $table;
var $table_expertor;
var $my_ask;
var $my_amswer;

function P8_Ask_Member(&$system, $name){
	$this->system = &$system;
	parent::__construct($name);
	
	$this->table_member = $this->core->TABLE_ . 'member';
	$this->table = $this->system->TABLE_ . 'member';
	$this->table_expertor = $this->system->TABLE_ . 'expertors';
	
}

/**
 * ����û��Ƿ����
 * param string $conditon ����
 * return bool true||false ���ڷ���true,����false
 */
function check_exists($condition){

	if($this->DB_master->fetch_one("SELECT id FROM " . $this->table . " WHERE $condition")){
		return true;
	}else{
		return false;
	}

}

/**
 * ���ר���û��Ƿ����
 * param string $condition ����
 * return array ����ר���û���Ϣ
 */
function check_exists_expertor($condition){

	if($this->DB_master->fetch_one(
		"SELECT id FROM " . $this->table_expertor . " WHERE $condition"
	)){
		return true;
	}else{
		return false;
	}

}

/**
 * ����û�
 * param string $condition ����
 * param array $data ����
 */
function verify($condition, $data){

	return $this->DB_master->update(
			$this->table,
			$data,
			$condition
		);

}

/**
 * �����ʴ�֮��
 * param string $condition ����
 * param array $data ����
 */
function set_star($condition, $data){

	return $this->DB_master->update(
			$this->table,
			$data,
			$condition
		);

}

/**
 * ����ר���û�
 * param array &$data ����
 * return array �����û����õķ���/ר�ұ�ID
 */
function set_expertor(&$data){

	$return = array();

	//��������ģ��
	$item = &$this->system->load_module('item');

	//�������ģ��
	$category = &$this->system->load_module('category');
	$category_controller = &$this->core->controller($category);
	$category->get_cache(true);

	foreach($data['uids'] as $uid){
		foreach($data['cids'] as $cid){
			if(!$this->check_exists_expertor("uid='$uid' AND cid='$cid'")){
				$id = $this->DB_master->insert(
					$this->table_expertor,
					array(
						'cid' => $cid,
						'uid' => $uid
					),
					array('return_id' => true)
				);
			}else{
				$row = $this->DB_master->fetch_one("SELECT id FROM " . $this->table_expertor . " WHERE uid='$uid' AND cid='$cid'");
				$id = $row['id'];
			}

			$name = '';
			//��ȡ������
			$parent_categories = $category->get_parents((int)$cid);
					if(!empty($parent_categories)){
						foreach($parent_categories as $v){
							if(!$this->check_exists_expertor("uid='$uid' AND cid='$v[id]'")){
								$this->DB_master->insert(
									$this->table_expertor,
									array(
										'cid' => $v['id'],
										'uid' => $uid
									),
									array('return_id' => false)
								);
							}
					$name .= '<a href="' . p8_url($item, $v, 'list') . '" target="_blank">' . $v['name'] . '</a>&gt;';
				}
			}

			$current_category = $category_controller->get_one(array('id'=>(int)$cid), true);
			$name .= '<a href="' .$current_category['url'] . '" target="_blank">' . $current_category['name'] . '</a>';

			$return[$uid]['cids'][$cid]['name'] = $name;
			//�û�����ר�ұ��ID
			$return[$uid]['cids'][$cid]['id'] = $id;
		}
	}

	$alluids = implode(',', $data['uids']);
	$this->DB_master->update(
		$this->table,
		array('expert'=>1),
		"id IN($alluids)"
	);

	return $return;

}

/**
 * ɾ��ר��
 * param array &$data ����
 * param string $data['condition'] ����ר������
 * param string $data['condition2'] ɾ��ר��������������
 * return int ���ظ�����Ŀ
 */
function delete_expertor($condition){

	$uids_arr = array();
	$query = $this->DB_master->query("SELECT * FROM " . $this->table_expertor . " WHERE $condition");
	while($row = $this->DB_master->fetch_array($query)){
		$uids_arr[$row['uid']]['ids'][] = $row['id'];
		$uids_arr[$row['uid']]['cids'][] = $row['cid'];
	}

	//ɾ��ר�ҵķ���
	$this->DB_master->delete(
			$this->table_expertor,
			$condition
		);

	foreach($uids_arr as $uid=>$cids){
		if(!$this->DB_master->fetch_one("SELECT id FROM " . $this->table_expertor . " WHERE uid='$uid'")){
			$this->DB_master->update(
				$this->table,
				array('expert'=>0),
				"id='$uid'"
			);
		}
	}

	return $uids_arr;

}

/**
 * ���»�Ա�����ղ���
 * param int $uid �û�ID
 * param string $method �����(add,cut)
 * param int $number ������Ŀ
 * return int $rows ����Ӱ�������
 */
function update_count_favorites($uid, $method, $number){

	$data = array();
	$rows = 0;

	$data = $this->DB_master->fetch_one("SELECT id,favorites FROM " . $this->table . " WHERE id='$uid'");
	print_r($data);
	if(!empty($data)){
		$favorites = intval($data['favorites']);
		if($method == 'add'){
			$favorites = $favorites + $number ;
		}elseif($method == 'cut' && $favorites>=$number){
			$favorites = $favorites - $number;
		}

		if($favorites < 0){
			$favorites = 0;
		}

		$rows = $this->DB_master->update(
			$this->table,
			array(
				'favorites' => $favorites
			),
			" id='$uid'"
		);
	}

	return $rows;

}
	/**
 * ���»�Ա������
 * param int $uid �û�ID
 * param string $method �����(add,cut)
 * param int $number ������Ŀ
 * param string $forwhat �Ǹ��ֶ�
 * return int $rows ����Ӱ�������
 */
function update_count_item($uid, $method,$filter, $number){
	$data = array();
	$count=0;
	$rows = 0;
	$data = $this->DB_master->fetch_one("SELECT id,$filter FROM " . $this->table . " WHERE id='$uid'");
	if(!empty($data))
		$_count = intval($data[$filter]);
		if($method == 'add'){
			$count = $_count + intval($number) ;
		}elseif($method == 'cut' && $count>=$number){
			$count = $_count - $number;
		}

		if($count < 0 || empty($count)){
			$count = 0;
		}
		
		$rows = $this->DB_master->update(
			$this->table,
			array(
				"$filter" => $count
			),
			" id='$uid'"
		);
	
}

/**
 * ��ȡר���û�����
 * param string $condition ����
 * param bool $read_cache �Ƿ��ȡ���໺��
 * return array $data ����ר���û���������
 */
function get_expertor_category($condition, $read_cache){

	$data = $categories = array();

	//��������ģ��
	$item = &$this->system->load_module('item');

	//�������ģ��
	$category = &$this->system->load_module('category');
	$category_controller = $this->core->controller($category);
	$category->get_cache($read_cache);

	$query = $this->DB_master->query("SELECT * FROM " . $this->table_expertor . " WHERE $condition ORDER BY id ASC");
	while($row = $this->DB_master->fetch_array($query)){
		$name = '';
		$current_category = $category_controller->get_one(array('id'=>$row['cid']), $read_cache);
		//��ȡ������
		$parent_categories = $category->get_parents($row['cid']);
		if(!empty($parent_categories)){
			foreach($parent_categories as $v){
				$name .= '<a href="' . p8_url($item, $v, 'list') . '" target="_blank">' . $v['name'] . '</a>&gt;';
			}
		}
		$row['name'] = $name . '<a href="' .$current_category['url'] . '" target="_blank">' . $current_category['name'] . '</a>';
		$data[] = $row;
	}

	return $data;

}

/**
* ��ǩ���õ�����, �ӿ�
* @param array $label ��ǩ����
* @param array $var ����
**/
function label(&$LABEL, &$label, &$var){

	$option = &$label['option'];
	$select = select();
	$select -> from($this->table.' AS i','i.*');
	if(!empty($option['mbtype'])){
		$select -> in('i.'.$option['mbtype'],1);
		if($option['mbtype']=='expert'){
		$select->left_join($this->table_expertor . ' AS E', 'E.uid,E.cid', 'i.id=E.uid');
		if(!empty($option['category'])){
				$option['category'] = preg_replace("/[^0-9,]/", '', $option['category']);
				$option['category'] = array_filter(explode(',', $option['category']));
				$select -> in(' E.cid',$option['category']);
			}
		}
	}
	
	//����
		if(!empty($option['order_by_string'])){
			$select->order($option['order_by_string']);
		}else{
			$select->order('i.id DESC');
		}
	
	if(is_array($var)){
		$select->left_join($this->table_expertor . ' AS E', 'E.uid', 'i.id=E.uid');
			foreach($option['var_fields'] as $field => $v){
				//��������ֶ�
				switch($v['operator']){
					case 'in':
						$select->in($field, $var[$field]);
						break;						
					case 'search':
						$select->like($field, $var[$field]);
						break;
				}
			}
		
			
		}
		$select->group('i.id');
		//echo $select->build_sql();
		$list = $this->core->list_item(
			$select,
			array(
				'page' => &$page,
				'page_size' => $option['limit'],
				'count' => &$count,
				'sphinx' => $option['sphinx']
			)
		);
		

	foreach($list as $k => $v){	
		$list[$k]['title']=$v['username'];
		$list[$k]['url']='';
		if($option['mbtype']=='expert'){
			$list[$k]['url']=$list[$k]['ask_url']=$ask_url= $this->system->controller."/item-ask?exper=".$v['uid'];
			$list[$k]['allcnames']=$this->get_cnames($v['uid'],$ask_url);
			$list[$k]['summary']=$list[$k]['cnames']=p8_cutstr($list[$k]['allcnames'], $option['summary_length'], '');
		}
		
	}
		//�����
	$rand = rand_str(4);
	//ÿ�еĿ��,���ڶ���
	$width = (!empty($option['rows']) && $option['rows']>1) ? (100/$option['rows']-1).'%' : '99%';
	
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

function get_cnames($uid){
	$category = &$this->system->load_module('category');
	$category->get_cache(true);
	$comm=$categorys='';
	$cids=$this->get_exper_cid($uid);
	foreach($cids as $cid => $_cid){
		$categorys .= $comm.$category->categories[$cid]['name'];
		$comm=",";
	}
	return $categorys;
}

function makeexpertorjson($uid){
	$cids=array();
	$cids=$this->get_exper_cid($uid);
	return $cids;
}

function get_exper_cid($uid){
	$query=$this->DB_master->query("SELECT * FROM " . $this->table_expertor . " WHERE uid='$uid' ORDER BY id ASC");
		while($row = $this->DB_master->fetch_array($query)){
			$data[$row['cid']]=$row['cid'];
	}
	return $data;
}

function getexpertor($uid){
	$query=$this->DB_master->fetch_one("SELECT username from $this->table WHERE id='$uid'");
	return $query['username'];
	}
	
function get_member_info(){
global $UID;
if(!$UID)return array();
$query=$this->DB_master->fetch_one("SELECT * from $this->table WHERE id='$UID'");
if(!$query)return array();
		$this->my_ask = $query['item_count'];
		$this->my_amswer = $query['reply_count'];
		return $query;
}	
}