<?php
defined('PHP168_PATH') or die();

//P8_CMS_Item::add_attribute($attributes, $id, $cid)
	
	//删除旧的属性
	$this->DB_master->delete(
		$this->attribute_table,
		"id = '$id'"
	);
	
	if(empty($attributes)) return false;
	
	$attributes = explode(',', $attributes);
	
	if($cid == 0){
		$tmp = $this->DB_master->fetch_one("SELECT cid FROM $this->main_table WHERE id = '$id'");
		$cid = $tmp['cid'];
		unset($tmp);
	}
	
	global $USERNAME;
	$data_attributes = array();
	foreach($attributes as $aid){
		$data_attributes[] = array(
			'id' => $id,					//内容ID
			'aid' => $aid,					//属性ID
			'cid' => $cid,					//分类ID
			'timestamp' => P8_TIME,			//时间戳
			'last_setter' => $USERNAME		//最后一个设置属性的人
		);
	}
	
	//添加新的属性
	return $this->DB_master->insert(
		$this->attribute_table,
		$data_attributes,
		array(
			'multiple' => array('id', 'aid', 'cid', 'timestamp', 'last_setter')
		)
	);