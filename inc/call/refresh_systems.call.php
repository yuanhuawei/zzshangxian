<?php
defined('PHP168_PATH') or die();

//P8_System::list_systems($refresh = false)
	$systems = $this->DB_master->fetch_all("SELECT * FROM {$this->TABLE_}system");
	//�����ݿ���ļ�¼
	
	foreach($systems as $v){
		$this->systems[$v['name']] = $v;
	}
	
	$systems = $_systems = array();
	$handle = opendir(PHP168_PATH);
	while(($item = readdir($handle)) !== false){
		if($item == '.' || $item == '..') continue;
		
		//�ļ���������ͬ��php�ļ�,�����������ļ��Ľ��ᱻ��Ϊ��һ��ϵͳ��b, b/system.php, b/#.php
		if(is_dir(PHP168_PATH . $item) && is_file(PHP168_PATH . $item .'/system.php') && ($info = @include PHP168_PATH . $item .'/#.php')){
			$_systems[$item] = array(
				'alias' => $info['alias'],	//ϵͳ����
				'class' => $info['class'],	//ϵͳ����
				'controller_class' => $info['controller_class'],	//ϵͳ����
				'table_prefix' => empty($this->systems[$item]['table_prefix']) ? '' : $this->systems[$item]['table_prefix'],
				'enabled' => empty($this->systems[$item]['enabled']) ? false : true,				//�Ƿ����
				'installed' => empty($this->systems[$item]['installed']) ? false : true
				//�Ƿ�װ��
			);
			//д�����õ�
			
			//���µ�ϵͳ
			$systems[$item] = array(
				'name' => $item,
				'alias' => $info['alias'],	//ϵͳ����
				'table_prefix' => empty($this->systems[$item]['table_prefix']) ? '' : $this->systems[$item]['table_prefix'],	//��ǰ׺
				'class' => $info['class'],	//ϵͳ����
				'controller_class' => $info['controller_class'],	//ϵͳ����
				'enabled' => empty($this->systems[$item]['enabled']) ? 0 : 1,				//�Ƿ����
				'installed' => empty($this->systems[$item]['installed']) ? 0 : 1
				//�Ƿ�װ��
			);
			//д���ݿ��õ�
			
			unset($this->systems[$item]);
		}
	}
	closedir($handle);
	
	//ɾ����ɾ����ϵͳ
	foreach((array)$this->systems as $k => $v){
		$this->DB_master->delete($this->TABLE_ .'system', "name = '$k'");
	}
	
	//������ֶ�
	$fields = array('name', 'alias', 'table_prefix', 'class', 'controller_class', 'enabled', 'installed');
	//��replace into�ķ�ʽ����
	$this->DB_master->insert(
		$this->TABLE_ .'system',
		$systems,
		array(
			'multiple' => $fields,
			'replace' => true
		)
	);
	
	return $this->systems = $_systems;