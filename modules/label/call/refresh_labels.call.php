<?php
defined('PHP168_PATH') or die();

//P8_Label::refresh_labels()
	@set_time_limit(0);
	
	global $__label;
	
	$refresh = array_merge($this->expire_labels, $this->missed_labels);
	//print_r($refresh);
	$refresh_labels = $this->expire_labels = $this->missed_labels = array();
	
	//刷新过期和未命中的标签{
	foreach($refresh as $name => $v){
		
		$label = $this->get($name);
		
		if(empty($label)) continue;
		
		if(is_array($v)){
			
		}else{
			//取得标签数据
			$refresh_labels[$label['scope']][$name] = $this->fetch($label);
			$__label[$name] = $refresh_labels[$label['scope']][$name]['content'];
		}
		
		//如果是标签编辑状态,添加标签占位
		if(P8_EDIT_LABEL && !defined('P8_GENERATE_HTML')){
			$__label[$name] = $this->edit_mode($name) . $__label[$name];
		}
		
	}
	//刷新过期和未命中的标签}
	
	foreach($refresh_labels as $scope => $v){
		
		//把新数据覆盖到旧数据上
		$this->_data[$scope] = array_merge($this->_data[$scope], $v);
		
		//写回缓存
		$tmp = $this->parse_scope($scope);
		$this->core->CACHE->write('label/data/'. $tmp['system'], $tmp['module'], $tmp['site'].$tmp['postfix'] . $this->last_cache, $this->_data[$scope], 'serialize');
	}
	
	foreach($this->_scopes as $v){
		unset($lock[$v]);
	}
	
	if(empty($lock)){
		$this->core->CACHE->delete('', 'label', 'refresh_lock');
	}else{
		$this->core->CACHE->delete('', 'label', 'refresh_lock', $lock, 'serialize');
	}