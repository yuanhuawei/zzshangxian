<?php
defined('PHP168_PATH') or die();

//P8_Label::delete($data)

	$query = $this->DB_master->query("SELECT id, name, system, site, module, postfix FROM $this->table WHERE $data[where]");
	$scopes = array();
	$ids = $comma = '';
	while($arr = $this->DB_master->fetch_array($query)){
		$key = $arr['system'] .($arr['module'] ? '-'. $arr['module'] : '');
		$key .= $arr['postfix'] ? '#'. $arr['postfix'] : '';
		$scopes[$key][$arr['name']] = 1;
		$ids .= $comma . $arr['id'];
		$comma = ',';
		//ɾ��SSI�ļ�
		rm(CACHE_PATH .'label/ssi/'. $arr['system'] .'/'. $arr['module'] .'/'. $arr['name'] .'@'. $arr['site'].$arr['postfix'] .'.html');
	}
	
	if($ids && $status = $this->DB_master->delete($this->table, "id IN ($ids)")){
		
		foreach($scopes as $scope => $v){
			$tmp = $this->parse_scope($scope);
			//ɾ����ǩ��������
			$label = $this->core->CACHE->read('label/#/'. $tmp['system'], $tmp['module'], $tmp['site'].$tmp['postfix'] . $this->last_cache, 'serialize');
			$ldata = $this->core->CACHE->read('label/data/'. $tmp['system'], $tmp['module'], $tmp['site'].$tmp['postfix'] . $this->last_cache, 'serialize');
			
			foreach($v as $name => $k){
				unset($label[$name], $ldata[$name]);
			}
			
			//����д�ػ���
			$this->core->CACHE->write('label/#/'. $tmp['system'], $tmp['module'], $tmp['site'].$tmp['postfix'] . $this->last_cache, $label, 'serialize');
			$this->core->CACHE->write('label/data/'. $tmp['system'], $tmp['module'], $tmp['site'].$tmp['postfix'] . $this->last_cache, $ldata, 'serialize');
		}
		
		//ɾ����Ӧ�Ĺҹ�����
		if(!empty($data['delete_hook'])){
			$this->delete_hook_module_item($ids);
		}
		
		return true;
	}
	
	return false;