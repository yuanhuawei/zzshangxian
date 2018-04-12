<?php
defined('PHP168_PATH') or die();

//P8_Label::cache_data($label_scopes = array())
	
	@set_time_limit(0);
	
	foreach($label_scopes as $scope => $none){
		
		$tmp = $this->parse_scope($scope);
		$this->_labels[$scope] = array();
		
		$query =  $this->DB_master->query("SELECT * FROM $this->table WHERE system = '$tmp[system]' AND module = '$tmp[module]' AND site='$tmp[site]' AND env='$tmp[env]'  AND postfix = '$tmp[postfix]'");
		
		md(CACHE_PATH .'label/#/'. $tmp['system'] .'/'. $tmp['module'], true);
		md(CACHE_PATH .'label/data/'. $tmp['system'] .'/'. $tmp['module'] .'/', true);
		
		while($v = $this->DB_master->fetch_array($query)){
			
			$name = $v['name'];
			$v['option'] = attachment_url(mb_unserialize($v['option']));
			$v['content'] = attachment_url($v['content']);
			
			if(isset($v['option']['unset_options'])){
				//清除需要清除的选项
				foreach($v['option']['unset_options'] as $opt){
					
					$unset = &$v['option'];
					$_tmp = explode('/', $opt);
					$key = array_pop($_tmp);
					foreach($_tmp as $path){
						$unset = &$unset[$path];
					}
					unset($unset[$key]);
					
					//unset($v['option'][$opt]);
				}
				unset($v['option']['unset_options']);
			}
			unset($v['timestamp'], $v['invoke']);
			
			//单个标签
			//$this->core->CACHE->write('label', 'label', urlencode($v['name']) . $this->last_cache, $v);
			
			$v['scope'] = $scope;
			$label_key = $v['module'] .(empty($v['postfix']) ? '' : '#'. $v['postfix']);
			
			$this->_labels[$scope][$v['name']] = $v;
		}
		
		//写缓存
		$this->core->CACHE->write('label/#/'. $tmp['system'], $tmp['module'], $tmp['site']. $tmp['env'] . $tmp['postfix'] . $this->last_cache, $this->_labels[$scope], 'serialize');
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		$this->_data[$scope] = array();
		if(empty($this->_labels[$scope])){
			//当前作用域没有任何标签,防止继续缓存,写一个空的
			
			$this->_data[$scope][''] = array(
				'content' => '',
				'expire' => 9999999999
			);
			$this->core->CACHE->write('label/data/'. $tmp['system'], $tmp['module'], $tmp['site']. $tmp['env'] . $tmp['postfix'] . $this->last_cache, $this->_data[$scope], 'serialize');
			unset($lock[$scope]);
			continue;
		}
		
		foreach($this->_labels[$scope] as $name => $label){
			$label['scope'] = $scope;
			if($label['variable']){
				//变量标签
			}else{	//固定标签
				$this->_data[$scope][$name] = $this->fetch($label);
			}
		}
		
		$this->core->CACHE->write('label/data/'. $tmp['system'], $tmp['module'], $tmp['site']. $tmp['env'] . $tmp['postfix'] . $this->last_cache, $this->_data[$scope], 'serialize');
		
		unset($lock[$scope]);
	}
	
	if(empty($lock)){
		$this->core->CACHE->delete('', 'label', 'cache_data_lock');
	}else{
		$this->core->CACHE->write('', 'label', 'cache_data_lock', $lock, 'serialize');
	}