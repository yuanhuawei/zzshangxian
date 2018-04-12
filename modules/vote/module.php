<?php
defined('PHP168_PATH') or die();

class P8_Vote extends P8_Module{

var $table;
var $option_table;
var $voter_table;

function __construct(&$system, $name){
	$this->system = &$system;
	parent::__construct($name);
	
	$this->table = $this->TABLE_;
	$this->option_table = $this->TABLE_ .'option';
	$this->voter_table = $this->TABLE_ .'voter';
}

function P8_Vote(&$system, $name){
	$this->__construct($system, $name);
}

function get($id){
	
}

/**
* 添加投票
**/
function add(&$data){
	
	$options = isset($data['options']) ? $data['options'] : array();
	$hash = isset($data['attachment_hash']) ? $data['attachment_hash'] : array();
	unset($data['attachment_hash'], $data['options']);
	
	$data['timestamp'] = P8_TIME;
	
	$id = $this->DB_master->insert(
		$this->table,
		$data,
		array('return_id' => true)
	);
	
	uploaded_attachments($this, $id, $hash);
	
	return $id;
}

/**
* 修改投票
**/
function update($id, &$data){
	
	$options = isset($data['options']) ? $data['options'] : array();
	$hash = isset($data['attachment_hash']) ? $data['attachment_hash'] : array();
	unset($data['attachment_hash'], $data['options'], $data['timestamp']);
	
	$status = $this->DB_master->update(
		$this->table,
		$data,
		"id = '$id'"
	);
	
	if(empty($data['enabled'])){
		rm($this->path .'js/'. $this->js_file($id));
	}
	
	uploaded_attachments($this, $id, $hash);
	
	return $status;
}

/**
* 添加投票项
**/
function add_option(&$data){
	
	$id = $this->DB_master->insert(
		$this->option_table,
		$data
	);
	
	return $data;
}

/**
* 修改投票项
**/
function update_option($id, &$data){
	
	$vid = isset($data['vid']) ? $data['vid'] : 0;
	unset($data['vid']);
	
	$status = $this->DB_master->update(
		$this->option_table,
		$data,
		"id = '$id'"
	);
	
	return $status;
}

/**
* 投票
**/
function vote($id, $oid){
	
	global $UID, $USERNAME;
	
	$oid = (array)$oid;
	$oids = implode(',', $oid);
	$votes = count($oid);
	
	//读缓存
	$data = $this->core->CACHE->read($this->system->name .'/modules/'. $this->name, 'vote', (int)$id, 'serialize');
	$data['votes'] += $votes;
	foreach($oid as $v){
		//插入投票者表
		$this->DB_master->insert(
			$this->voter_table,
			array(
				'vid' => $id,
				'oid' => $v,
				'uid' => $UID ? $UID : P8_IP,
				'username' => $USERNAME,
				'timestamp' => P8_TIME,
			)
		);
		
		$data['options'][$v]['votes'] ++;
	}
	//写回缓存
	$this->core->CACHE->write($this->system->name .'/modules/'. $this->name, 'vote', (int)$id, $data, 'serialize');
	
	//更新投票选项票数
	$this->DB_master->update(
		$this->option_table,
		array('votes' => 'votes +1'),
		"id IN($oids)",
		false
	);
	
	//更新投票票数
	$this->DB_master->update(
		$this->table,
		array('votes' => 'votes +1'),
		"id = '$id'",
		false
	);
	
	if($UID){
		//应用积分规则
		$credit = &$this->core->load_module('credit');
		$credit->apply_rule($this, 'vote', $UID, $this->core->ROLE);
	}
	
	return true;
}

/**
* 删除投票
**/
function delete($data){
	$query = $this->DB_master->query("SELECT id FROM $this->table WHERE $data[where]");
	$ids = $comma = '';
	while($arr = $this->DB_master->fetch_array($query)){
		//删除缓存
		$this->core->CACHE->delete($this->system->name .'/modules/'. $this->name, 'vote', (int)$arr['id']);
		rm($this->path .'js/'. $this->js_file($id));
		
		$ids .= $comma . $arr['id'];
		$comma = ',';
	}
	
	if(
		$status = $this->DB_master->delete(
			$this->table,
			"id IN ($ids)"
		)
	){
		//删除选项
		$this->DB_master->delete(
			$this->option_table,
			"vid IN ($ids)"
		);
		
		//删除投票者
		$this->DB_master->delete(
			$this->voter_table,
			"vid IN ($ids)"
		);
	}
	
	return $status;
}

function js_file($id){
	return intval($id / 1000) .'/'. $id .'.js';
}

function cache($id = 0){
	
	global $TEMP_OBJ, $RESOURCE, $SKIN, $P8LANG;
	$this_module = &$this;
	$core = &$this->core;
	
	$query = $this->DB_slave->query("SELECT * FROM $this->table". ($id ? " WHERE id = '$id'" : ''));
	while($data = $this->DB_slave->fetch_array($query)){
		$_query = $this->DB_slave->query("SELECT * FROM $this->option_table WHERE vid = '$data[id]' ORDER BY display_order, id ASC");
		$data['options'] = array();
		while($_arr = $this->DB_slave->fetch_array($_query)){
			unset($_arr['vid']);
			$_arr['frame'] = attachment_url($_arr['frame']);
			
			$data['options'][$_arr['id']] = $_arr;
		}
		$data['frame'] = attachment_url($data['frame']);
		$data['roles'] = $data['roles'] ? array_flip(explode('|', $data['roles'])) : array();
		$this->core->CACHE->write($this->system->name .'/modules/'. $this->name, 'vote', (int)$data['id'], $data, 'serialize');
		$options = &$data['options'];
		
		//生成JS调用文件
		ob_start();
		
		include template($TEMP_OBJ, $this->name .'/'. $data['label_template'], 'label');
		$content = ob_get_clean();
		
		$js = '';
		if(preg_match_all('#(<script[^>]*>)(.*?)</script>#is', $content, $mm)){
			$content = preg_replace('#<script[^>]*>(.*)</script>#is', '', $content);
			
			foreach($mm[2] as $k => $v){
				if(preg_match('/\s+src=[\'"]?([^\'"?\s]+)[\'"]?/', $mm[1][$k], $mmm)){
					$js .= "\r\n". 'document.write(\'<scr\' + \'ipt type="text/javascript" src="'. $mmm[1] .'"></scr\' + \'ipt>\');'. "\r\n";
				}else{
					$js .= $v;
				}
			}
			
			$js = str_replace(array('\\', '\''), array('\\\\', '\\\''), $js);
		}
		
		$content = str_replace(array("\r", "\n", '\\', '\''), array('', '', '\\\\', '\\\''), $content);
		//slashes twice
		//$content = str_replace(array('\\', '\''), array('\\\\', '\\\''), $content);
		
		$js_file = $this->js_file($id);
		md(dirname($this->path .'js/'. $js_file));
		
		write_file($this->path .'js/'. $js_file, "document.write('". $content ."');". $js);
	}
}

}