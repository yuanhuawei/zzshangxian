<?php
defined('PHP168_PATH') or die();

//P8_Label::cache($id = 0, $orig_data = array())
	
	$last_cache = '@'. $this->core->CONFIG['last_label_cache'];
	$last_last_label_cache = '@'. $this->core->CONFIG['last_last_label_cache'];

	if($id){
		$query = $this->DB_master->query("SELECT * FROM $this->table WHERE id = '$id'");
	}else{
		$query = $this->DB_master->query("SELECT system, module,site, env, postfix FROM $this->table GROUP BY system, module, postfix");
		
		md(CACHE_PATH .'label/bak', true);
		$flag = $flag2 = false;
		$flag = rename(PHP168_PATH.'data/label/#/cms/_index'.$this->last_cache.'.php',PHP168_PATH.'data/label/bak/_index'.$this->last_cache.'.php');
		
		//ɾ����һ�εĻ���
		
		while($arr = $this->DB_master->fetch_array($query)){
			$this->core->CACHE->delete('label/#/'. $arr['system'], $arr['module'], $arr['site'] . $arr['env'] .$arr['postfix'] . $last_cache);
			$this->core->CACHE->delete('label/data/'. $arr['system'], $arr['module'], $arr['site'] . $arr['env'] .$arr['postfix'] . $last_cache);
		}
		
		$this->_labels = array();
				
		//ɾ����ǩ����
		rm(CACHE_PATH .'label/#/');
		rm(CACHE_PATH .'label/data/');
		md(CACHE_PATH .'label/#/cms', true);
		if($flag){
			rename(PHP168_PATH.'data/label/bak/_index'.$this->last_cache.'.php',PHP168_PATH.'data/label/#/cms/_index@'.P8_TIME.'.php');
		}
		
		//ɾ����������
		$this->core->CACHE->delete('', 'label', 'refresh_lock');
		$this->core->CACHE->delete('', 'label', 'cache_data_lock');
		
		rm(CACHE_PATH .'label/bak/');
		md(CACHE_PATH .'label/data/var', true);
	}
	
	
	if($id || defined('P8_CLUSTER')){
		$this->last_cache = '@'. $this->core->CONFIG['last_label_cache'];
	}else{
		//������»���ȫ����ǩ,�����ϴα�ǩ���»���ʱ��
		$this->core->set_config(array(
			'last_last_label_cache' => intval($this->core->CONFIG['last_label_cache']),
			'last_label_cache' => P8_TIME
		));			
		$this->last_cache = '@'. P8_TIME;
	}
	
	if(!$id) return;
	//var_dump($id);
	while($v = $this->DB_master->fetch_array($query)){
		$name = $v['name'];
		
		$v['option'] = attachment_url(mb_unserialize($v['option']));
		$v['content'] = attachment_url($v['content']);
		
		if(isset($v['option']['unset_options'])){
			//�����Ҫ�����ѡ��
			foreach($v['option']['unset_options'] as $opt){
				
				$unset = &$v['option'];
				$tmp = explode('/', $opt);
				$key = array_pop($tmp);
				foreach($tmp as $path){
					$unset = &$unset[$path];
				}
				unset($unset[$key]);
				
				//unset($v['option'][$opt]);
			}
			unset($v['option']['unset_options']);
		}
		unset($v['timestamp'], $v['invoke']);
		
		//������ǩ
		//$CACHE->write('label', 'label', urlencode($v['name']) . $this->last_cache, $v);
		
		//��ʾ�� system-model=site#postfix
		$scope = $v['module'] ? $v['system'] .'-'. $v['module'] : $v['system'];
		$scope .= empty($v['site']) ? '' : '='. $v['site'];
		$scope .= empty($v['env']) ? '' : '%'. $v['env'];
		$scope .= empty($v['postfix']) ? '' : '#'. $v['postfix'];
		$v['scope'] = $scope;
		$label_key = $v['module'] .(empty($v['postfix']) ? '' : '#'. $v['postfix']);
		
		md(CACHE_PATH .'label/#/'. $v['system'] .'/'. $v['module'], true);
		md(CACHE_PATH .'label/data/'. $v['system'] .'/'. $v['module'] .'/', true);
		
		if($id){
			
			if(!empty($orig_data)){
				//ԭ��������,�޸ı�ǩ��ʱ��
				$orig_scope = $orig_data['module'] ? $orig_data['system'] .'-'. $orig_data['module'] : $orig_data['system'];
				$orig_scope .= empty($orig_data['site']) ? '' : '='. $orig_data['site'];
				$orig_scope .= empty($orig_data['env']) ? '' : '%'. $orig_data['env'];
				$orig_scope .= empty($orig_data['postfix']) ? '' : '#'. $orig_data['postfix'];
				
				//����������б仯,����ǰ�Ļ���ɾ��
				if($scope != $orig_scope){
					//��ǩ��Ϣ
					$tmp = $this->core->CACHE->read('label/#/'. $orig_data['system'], $orig_data['module'], $orig_data['site'] . $orig_data['env'] . $orig_data['postfix'] . $this->last_cache, 'serialize');
					unset($tmp[$orig_data['name']]);
					$this->core->CACHE->write('label/#/'. $orig_data['system'], $orig_data['module'], $orig_data['site']. $orig_data['env'] . $orig_data['postfix'] . $this->last_cache, $tmp, 'serialize');
					
					//����
					$tmp = $this->core->CACHE->read('label/data/'. $v['system'], $v['module'], $v['site'] . $v['env'] . $v['postfix'] . $this->last_cache, 'serialize');
					unset($tmp[$orig_data['name']]);
					$this->core->CACHE->write('label/data/'. $v['system'], $v['module'], $v['site'] . $v['env'] . $v['postfix'] . $this->last_cache, $tmp, 'serialize');
					unset($tmp);
				}
			}
			
			$this->_labels[$scope] = $this->core->CACHE->read('label/#/'. $v['system'], $v['module'], $v['site']. $v['env'] . $v['postfix'] . $this->last_cache, 'serialize');
			
			//��ǩ�������ݻ���
			if(!$v['variable']){
				$tmp_data = $this->core->CACHE->read('label/data/'. $v['system'], $v['module'], $v['site']. $v['env'] . $v['postfix'] . $this->last_cache, 'serialize');
				//$tmp_data[$v['name']] = $this->fetch($v, null);
				unset($tmp_data[$v['name']]);
				$this->core->CACHE->write('label/data/'. $v['system'], $v['module'], $v['site']. $v['env'] . $v['postfix'] . $this->last_cache, $tmp_data, 'serialize');
			}
		}
		
		$this->_labels[$scope][$name] = $v;
	}
	
	
	foreach($this->_labels as $_scope => $v){
		
		//ɾ�����ڵľ�����
		$this->core->CACHE->delete('label', '#', $_scope . $last_cache);
		$this->core->CACHE->delete('label', 'data', $_scope . $last_cache);
		
		//������
		$tmp = $this->parse_scope($_scope);
		$this->core->CACHE->write('label/#/'. $tmp['system'], $tmp['module'], $tmp['site'] . $tmp['env'] .$tmp['postfix'] . $this->last_cache, $this->_labels[$_scope], 'serialize');
	}