<?php
defined('PHP168_PATH') or die();

//P8_Credit::cache(){
	/**
	credit_rule_test_[postfix]_[role_2]
	
	**/
	global $CACHE;
	$CACHE->delete('core/modules/', 'credit', '*');
	
	$last_cache = '@'. $this->core->CONFIG['last_credit_cache'];
	//设置上次积分更新缓存时间
	if(!defined('P8_CLUSTER')){
		$this->core->set_config(array(
			'last_credit_cache' => P8_TIME
		));
		$this->last_cache = '@'. P8_TIME;
	}
	
	$credits = $this->DB_master->fetch_all("SELECT id, name, unit, is_unsigned, float_bit, roe FROM $this->table");
	$this->credits = array();
	foreach($credits as $v){
		$id = $v['id'];
		unset($v['id']);
		$this->credits[$id] = $v;
		$this->credits[$id]['roe'] = mb_unserialize($v['roe']);
	}
	unset($credits);
	$CACHE->write('core/modules', 'credit', 'credits', $this->credits);
	$this->core->set_config(array('credits' => $this->credits));
	
	
	$rules = $this->DB_master->fetch_all("SELECT * FROM $this->rule_table");
	$this->rules = array();
	foreach($rules as $v){
		$this->rules[$v['system']][$v['module']][$v['role_id']][$v['postfix']][$v['action']][$v['id']] = array(
			'credit_id' => (int)$v['credit_id'],
			'times' => (int)$v['times'],
			'interval' => (int)$v['interval'],
			'credit' => (int)$v['credit']
		);
	}
	unset($rules);
	
	//每个系统的规则单独存放[$system]-[$module]-[$role]#[$postfix]
	foreach($this->rules as $system => $v){
		$vkey = $system;
		foreach($v as $module => $vv){
			$vvkey = $module ? $vkey .'-'. $module : $vkey;
			foreach($vv as $role_id => $vvv){
				$vvvkey = $role_id ? $vvkey .'-role-'. $role_id : $vvkey;
				
				foreach($vvv as $postfix => $vvvv){
					$postfix = $postfix ? '#'. $postfix : '';
					$CACHE->write('core/modules/credit', 'rule', $vvvkey . $postfix . $this->last_cache, $vvvv);
					
					$CACHE->delete('core/modules/credit', 'rule', $vvvkey . $postfix . $last_cache);
				}
			}
		}
	}