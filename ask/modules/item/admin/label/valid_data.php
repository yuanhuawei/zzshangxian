<?php
defined('PHP168_PATH') or die();

$this_controller->check_admin_action($ACTION) or message('no_privilege');

//������
$system = isset($_POST['system']) ? $_POST['system'] : '';
$module = isset($_POST['module']) ? $_POST['module'] : '';

if($system != 'core' && !get_system($system)){
	message('no_such_system');
}

if($module && !get_module($system, $module)){
	message('no_such_module');
}

//����Դģ����Ϣ
$_POST['source_system'] = $this_system->name;
$_POST['source_module'] = $this_module->name;
//��ǩ����Ϊģ������
$_POST['type'] = 'module_data';

$controller = &$core->controller($LABEL);

$option = isset($_POST['option']) && is_array($_POST['option']) ? $_POST['option'] : array();

//��ǩͨ�ò���,����֤�õ����ݸ���ԭ��������
$option = $controller->valid_module_data_option($option) + $option;
unset($option['order_by_desc']);
$option['var_fields'] = array();

//�Ƿ���sphinx��������
$option['sphinx'] = !empty($option['sphinx']) && !empty($this_module->CONFIG['sphinx']) ? $this_module->CONFIG['sphinx'] : array();
empty($option['sphinx']) || $option['sphinx']['enabled'] = 1;
//����
$option['category'] = empty($option['category']) ? array() : $option['category'];
//��¼��
$option['limit']  = empty($option['limit']) ? 10 : intval($option['limit']);
//��������ֽ���
$option['title_length'] = empty($option['title_length']) ? 30 : intval($option['title_length']);
//��ѡ����
$option['attribute'] = empty($option['attribute']) ? '' : $option['attribute'];

//��ʼ����select
$select = select();
$select->from($this_module->table . ' AS i', 'i.*');
$select->left_join($this_module->table_data . ' AS d', 'd.tel,d.info,d.bestanswer,d.content', 'd.id=i.id');

if($option['verify']!=2) $select->in('i.verify', $option['verify']);
if($option['recommend']!=2) $select->in('i.recommend', $option['recommend']);
if($option['status']!=2){
	if($option['status']==3){
		$select->in('i.status', 3);
	}else{
		$select->in('i.status', 3, true);
	}
}
if($option['urgent']!=2) $select->in('i.urgent', $option['urgent']);
if($option['offercredit']!=2) $select->in('i.offercredit', $option['offercredit']);
//��ָ��ID
if(empty($option['ids'])){
	if($option['category']){
		
			if($controller->is_var_field($option['category'])){						
				$option['var_fields']['i.cid'] = array('operator' => 'in', 'var' => $option['category']);
				//���Խ�����
				if($action == 'explain'){				
					$select->in('i.cid', $option['category']);
				}					
			}else{
				$option['category'] = preg_replace("/[^0-9,]/", '', $option['category']);
				//�����,
				$option['category'] = array_filter(explode(',', $option['category']));
				
				$select->in('i.cid', $option['category']);
				
				$option['category'] = implode(',', $option['category']);
			}
		
	}
	if(!empty($option['keyword'])){
			if($controller->is_var_field($option['keyword'])){
				//�����ֶ�
				$option['var_fields']['i.title'] = array('operator' => 'search', 'var' => $option['keyword']);
				
				if($action == 'explain'){
					//���Խ�����
					$select->search('i.title', $option['keyword']);
				}
				
				//$option['var_fields']['i.summary'] = array('operator' => 'search', 'var' => $option['keyword']);
				$option['unset_options'][] = 'keyword';
			}else{
				$option['keyword'] = html_entities($option['keyword']);
			}
		}
}else{
	
	//ָ����ID����������ᱻ����
	
	$option['ids'] = filter_int(explode(',', $option['ids']));
	$select->in('i.id', $option['ids']);
}	
//����
if(!empty($option['order_by'] )){
	$str = $comma = '';
	foreach($option['order_by'] as $field => $desc){
		$str .= $comma . $field .($desc ? ' DESC' : ' ASC');
		$comma = ',';
	}
	$select->order($str);
}else{
	$select->order('id DESC');

}
if($str){
	$select->order($str);
	$option['order_by_string'] = $str;
}	

$select->limit(0, $option['limit']);