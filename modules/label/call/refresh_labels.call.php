<?php
defined('PHP168_PATH') or die();

//P8_Label::refresh_labels()
	@set_time_limit(0);
	
	global $__label;
	
	$refresh = array_merge($this->expire_labels, $this->missed_labels);
	//print_r($refresh);
	$refresh_labels = $this->expire_labels = $this->missed_labels = array();
	
	//ˢ�¹��ں�δ���еı�ǩ{
	foreach($refresh as $name => $v){
		
		$label = $this->get($name);
		
		if(empty($label)) continue;
		
		if(is_array($v)){
			
		}else{
			//ȡ�ñ�ǩ����
			$refresh_labels[$label['scope']][$name] = $this->fetch($label);
			$__label[$name] = $refresh_labels[$label['scope']][$name]['content'];
		}
		
		//����Ǳ�ǩ�༭״̬,��ӱ�ǩռλ
		if(P8_EDIT_LABEL && !defined('P8_GENERATE_HTML')){
			$__label[$name] = $this->edit_mode($name) . $__label[$name];
		}
		
	}
	//ˢ�¹��ں�δ���еı�ǩ}
	
	foreach($refresh_labels as $scope => $v){
		
		//�������ݸ��ǵ���������
		$this->_data[$scope] = array_merge($this->_data[$scope], $v);
		
		//д�ػ���
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