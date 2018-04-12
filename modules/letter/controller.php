<?php
defined('PHP168_PATH') or die();

class P8_Letter_Controller extends P8_Controller{

function P8_Letter_Controller(&$obj){
	parent::__construct($obj);
	
}
function add(&$POST){
	global  $UID, $USERNAME;
	$data = $this->valid_data($POST);
	$config = $this->model->core->get_config('core', 'letter');
	$data['main']['number']=$this->model->createNumber();
	$code = rand(10000,99999);
	$data['main']['undisplay']=$config['undisplay'];
	$data['main']['code']=$code;
	$data['main']['uid'] = $UID;
	$data['main']['ip'] = P8_IP;
	$data['main']['create_time'] = time();

	$data['data']['add_time'] = time();
	$id = $this->model->add($data);
	return $id? array('id'=>$id,'number'=>$data['main']['number'],'code'=>$code):false;
	
}

function update(&$POST){
	$id= $POST['id'];
	$data = $this->valid_data($POST);
	$data['main']['update_time'] = time();
	$status = $this->model->update($id,$data);
	return $status?$id:$status;
}

function valid_data(&$POST){
	
	if(!captcha(isset($_POST['captcha']) ? $_POST['captcha'] : '')){
			message('captcha_incorrect', HTTP_REFERER, 10);
	}
	$data = array(
		'main' => array(),
		'data' => array()
	);
	$func = 'html_entities';	
	//关联附件哈希
	$data['attachment_hash'] = isset($POST['attachment_hash']) ? $POST['attachment_hash'] : '';
		
	//验证公共部分
	$data['main']['title'] = filter_word($func($POST['title']));
	$data['main']['username'] = filter_word($POST['username']);
	$data['main']['age'] = intval($POST['age']);
	
	$config = $this->model->core->get_config('core', 'letter');
	$data['main']['department'] = intval($POST['department']);
	if(!empty($config['receive']) && !empty($config['redepartment'])){
		$data['main']['department'] = intval($config['redepartment']);	
	
	}
	
	$data['main']['gender'] = intval($POST['gender']);
	$data['main']['type'] = intval($POST['type']) or message('error');
	$data['main']['visual'] = intval($POST['visual']);
	$data['main']['source'] = intval($POST['source']);
	$data['main']['profession'] = filter_word($POST['profession']);
	$data['main']['id_type'] = filter_word($POST['id_type']);
	$data['main']['id_num'] = filter_word($POST['id_num']);
	$data['main']['phone'] = filter_word($POST['phone']);
	$data['main']['email'] = filter_word($POST['email']);
	$data['main']['address'] = filter_word($POST['address']);
	
	$data['data']['content'] = filter_word($func($POST['content'])) or message('error');
	$data['data']['attachment_name'] = !empty($POST['attachment_name'])? filter_word($POST['attachment_name']):'';
	$data['data']['attachment'] =  !empty($POST['attachment'])?attachment_url($POST['attachment'], true):'';
	return $data;
}

function reply(&$POST){
	global $UID,$USERNAME,$P8LANG,$core;

	$id = intval($POST['id']) or message('error');
	$rsdb = $this->model->getData($id,'all');
	$main = $data=array();
	$log = '';
	$cates = $this->model->get_category();
	$liu = false;
		
	$main['askable'] = intval($POST['askable']);
	
	$department = intval($POST['department']);
	if($department && $rsdb['department']!=$department){
		$main['department'] = $department;
		$log .='<br/>'.'['.date('Y-m-d H:i').']'.$USERNAME.$P8LANG['to_department'].$cates['department'][$department]['name'];
		$liu =true;
	}
		
	$type = intval($POST['type']);
	if($type && $rsdb['type']!=$type){
		$main['type'] = $type;
		$log .='<br/>'.'['.date('Y-m-d H:i').']'.$USERNAME.$P8LANG['to_type'].$cates['type'][$type]['name'];
	}
	
	$visual = intval($POST['visual']);
	if($rsdb['visual']!=$visual){
		$main['visual'] = $visual;
	}
	
	if(isset($POST['undisplay'])){
		$undisplay = intval($POST['undisplay']);
		if($rsdb['undisplay']!=$undisplay){
			$main['undisplay'] = $undisplay;
		}
	}	
	
	$replys = empty($POST['reply'])?array():$POST['reply'];	
	$reply_id = $POST['reply_id'];	
	
	if(!empty($POST['finish_time']))$main['finish_time'] = strtotime($POST['finish_time']);
	if(!empty($POST['finish_name']))$main['finish_name'] = filter_word($POST['finish_name']);
	
	$turntig = '';
	if($main['finish_time'] || !empty($POST['turntig'])){
		
		if($main['finish_time'])$turntig .= p8lang($P8LANG['turntip'], $cates['department'][$department]['name'],$POST['finish_time']).';';
		if(!empty($POST['turntig']))$turntig .=filter_word($POST['turntig']);
		$turntig .= '   <font color="blue">('.$USERNAME.'  '.date('Y-m-d').')</font>';
		
		$redata = $this->model->getData($id,'all');
		$turntig = $turntig.'<br/>'.$redata['data'][0]['turntig'];
	}
	if($replys || $department){
		foreach($reply_id as $repid=>$t){
			if(!$t)continue;
			$data[$repid]=array(
				'reply_time'=>time(),
				'reply_name'=>$USERNAME,
				'reply_uid'=>$UID
			);
			if($replys)
				$data[$repid]['reply']=filter_word($replys[$repid]);
			if($department)
				$data[$repid]['reply_department']=$department;
			if($turntig)
				$data[$repid]['turntig']=$turntig;
		}
	}
	$status = intval($POST['status']);
	
	
	$config = $core->get_config('core', 'letter');
	$main['fengfa'] = $department==$config['receive']?0:1;
	
	if($main['fengfa'])$status=2;
	$replys[$repid] = trim($replys[$repid]);
	if(!empty($replys[$repid]))$status=3;
	
	if($rsdb['status']!=$status){
		$main['status'] = $status;
		$main['solve_time'] = $status==3?time():'';
		$log .='<br/>'.'['.date('Y-m-d H:i').']'.$USERNAME.$P8LANG['rep_'.$status];
	}
	$main['solve_uid'] = $UID;
	$main['solve_department'] = $department;
	$main['status_change_time'] = time();
	$main['solve_name'] = $USERNAME;
	
	
	
	
	
	if($data){
		$log .='<br/>'.'['.date('Y-m-d H:i').']'.$USERNAME.$P8LANG['reply'];
	}
	if($log){
		$main['log'] = $rsdb['log']. $log;
	 }
	/*  print_r($POST);
	echo $main['log'],'<br/>';
	print_r($rsdb);
	print_r($main);
	print_r($data);exit;  */
	$this->model->reply($id,$main, $data);
	if($liu)$this->model->sendMsg($id);
}

function check_manage($department=0,$type=0){
	global $IS_FOUNDER;
	if($IS_FOUNDER)return true;
	$manage = false;
	if($this->check_action('manager')){
		$my_manage = $this->get_acl('my_letter_manage');
		foreach($my_manage as $dep=>$tys){
			if($dep && $department==$dep){
				foreach($tys as $ty){
					if($ty==$type)
						$manage = true;
				}
			}elseif($dep=='0'){
				foreach($tys as $ty){
					if($ty==$type)
						$manage = true;
				}
			}
		}
	}
	return $manage;

}
function getcatbyAct($act){
	global $IS_FOUNDER;
	
	
	$cates = $this->model->get_category();
	$allcate = $cates['department'];
	
	if($IS_FOUNDER)return $allcate;
	$mycat = $this->get_acl('my_letter_manage');

	$return = array();
	if(isset($mycat[$act])){
        if(array_key_exists('0',$mycat[$act]))
            $return = $allcate;
        else
            foreach($mycat[$act] as $d)
                $return[$d] = $allcate[$d];
    }
	
	return $return;
}
function check_acl($act,$department=0){
	global $IS_FOUNDER;
	if($IS_FOUNDER)return true;
	
	$acts = $this->getcatbyAct($act);
	return !empty($acts[$department]);

}
function manageMessage(){
	global $IS_FOUNDER;
	$my_manage = $this->getcatbyAct('manager');
//print_r($my_manage);
	$acl_where = $split = '';
	if(!$IS_FOUNDER){
        $deps = array_keys($my_manage);
		if(!$deps)
			return false;
        $did = implode(',',$deps);
		$acl_where = " WHERE department in ($did)";
	}
	$sql = "SELECT status,COUNT(id) AS co FROM {$this->model->table}  $acl_where GROUP BY status";
	$data = $this->model->DB_master->fetch_all($sql);

	$mana = array(0=>0,1=>0,2=>0,3=>0);
	foreach($data as $row){
		$mana[$row['status']] = $row['co'];
	}
	$sql = "SELECT comment,COUNT(id) AS co FROM {$this->model->table} $acl_where GROUP BY comment";
	$data = $this->model->DB_master->fetch_all($sql);
	$comm = array(0=>0,1=>0,2=>0,3=>0);
	foreach($data as $row){
		$comm[$row['comment']] = $row['co'];
	}
	return array('mana'=>$mana,'comm'=>$comm);

}


}