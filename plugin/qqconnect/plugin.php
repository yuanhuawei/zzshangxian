<?php
defined('PHP168_PATH') or die();

class P8_Plugin_Qqconnect extends P8_Plugin{

public $access_token;
public $expires_in;
public $openid;
public $appid;
private $appkey;

function __construct(&$core, $name){
	$this->core = &$core;
	parent::__construct($name);
	$this->table = $this->TABLE_;
	$this->init();
}

function P8_Plugin_Qqconnect(&$core, $name){
	$this->__construct($core, $name);
}

function _cache(){
	
}

function init(){
	global  $_P8SESSION, $UID;
	$config=$this->get_config();
	$this->appid = $config['appid'];
	$this->appkey = $config['appkey'];
	if(!empty($_P8SESSION['qqconnect_data'])){
		$this->access_token = $_P8SESSION['qqconnect_data']['access_token'];
		$this->expires_in = $_P8SESSION['qqconnect_data']['expires_in'];
		$this->openid = $_P8SESSION['qqconnect_data']['openid'];
	}elseif(!empty($_P8SESSION['qqconnect_openid'])){
		$bind = $this->get_bind_info($_P8SESSION['qqconnect_openid']);
		$this->access_token = $bind['access_token'];
		$this->expires_in = $bind['expires_in'];
		$this->openid = $bind['openid'];
	}elseif($UID){
		$bind = $this->get_bind_info($UID,'uid');
		if($bind){
			$this->access_token = $bind['access_token'];
			$this->expires_in = $bind['expires_in'];
			$this->openid = $bind['openid'];
			$_P8SESSION['qqconnect_openid'] = $this->openid ;
		}	
	}
}

function mark_session(){
	global  $_P8SESSION;
	 $_P8SESSION['qqconnect_data'] = array(
		'access_token'=>$this->access_token,
		'expires_in'=>$this->expires_in,
		'openid'=>$this->openid	 
	 );
}
function qq_login(){
	global  $_P8SESSION;
	$_P8SESSION['qqconnect_state'] = $state = md5(uniqid(rand(), TRUE)); //CSRF protection;
	$scope = 'get_user_info';
	$callback = $this->controller.'-login';
    $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 
        . $this->appid 
        . "&state=" . $state
        . "&scope=". $scope
		. "&redirect_uri=" . urlencode($callback);
    header("Location:$login_url");

}

function callback($GET){
	global  $_P8SESSION;

    if($GET['state'] != $_P8SESSION['qqconnect_state'])
		return false;
	
	$callback = $this->controller.'-login';
	$token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
		. "client_id=" . $this->appid 
		. "&client_secret=" . $this->appkey 
		. "&code=" . $GET["code"]
		. "&redirect_uri=" . urlencode($callback);

        $response = p8_http_request(array('url'=>$token_url));//print_r($response);
        $response = $response['body'];
        if (strpos($response, "callback") !== false)
        {
            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);
            if (isset($msg->error))
            {
                echo "<h3>error:</h3>" . $msg->error;
                echo "<h3>msg  :</h3>" . $msg->error_description;
                exit;
            }
        }

        $params = array();
        parse_str($response, $params);

        $this->access_token = $params["access_token"];
        $this->expires_in = $params["expires_in"];

		return $this->get_openid();
		
}

function get_openid()
{
	global  $_P8SESSION;

    $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=" . $this->access_token;

   $ret = p8_http_request(array('url'=>$graph_url));
   $str = $ret['body'];
    if (strpos($str, "callback") !== false)
    {
        $lpos = strpos($str, "(");
        $rpos = strrpos($str, ")");
        $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
    }

    $user = json_decode($str);
    if (isset($user->error))
    {
        echo "<h3>error:</h3>" . $user->error;
        echo "<h3>msg  :</h3>" . $user->error_description;
        exit;
    }

    $this->openid = $_P8SESSION['qqconnect_openid']= $user->openid;
	return $this->openid;
}

function get_qq_user_info()
{	
    $get_user_info = "https://graph.qq.com/user/get_user_info?"
        . "access_token=" . $this->access_token
        . "&oauth_consumer_key=" . $this->appid
        . "&openid=" . $this->openid
        . "&format=json";

    $info = p8_http_request(array('url'=>$get_user_info));
    $arr = json_decode($info['body'], true);

    return $arr;
}

function get_bind_info($openid=0,$type='openid'){
	
	if($type=='openid')
		$openid = $openid? $openid : $this->openid;
	elseif($type=='uid'){
		global $UID;
		$openid = $UID? $UID : 0;
	}

	if(!$openid)
		return false;
	$SQL = "SELECT * FROM {$this->table} WHERE $type='{$openid}'";
	
	$query = $this->DB_slave->fetch_one($SQL);
	if($query){
		return $query;
	}else{
		return false;
	}	
}

function login($data,$update=true){
	$member = $this->core->load_module('member');
	if($update){
		$qq_user_info = $this->get_qq_user_info();
		$this->update_qq_user_info($qq_user_info,$data['uid']);
		
	}
	if(empty($data['uid']))
		$data['uid'] = $data['id'];
	return $member->login($data['username'], '', $data['uid']);
}

function update_qq_user_info($data,$uid){

	$indata = array(
		'access_token' => $this->access_token,
		'expires_in' => $this->expires_in,
		'nickname' => html_entities(from_utf8($data['nickname'])),
		'gender' => html_entities(from_utf8($data['gender'])),
		'vip' => html_entities($data['vip']),
		'level' => html_entities($data['level']),
		'figureurl' => html_entities($data['figureurl'])
	);
	$this->DB_master->update($this->table, $indata, "openid = '{$this->openid}'");
	
	$member = $this->core->load_module('member');
	$user_data = array(
		'icon' => html_entities($data['figureurl'])
	);
	//$member->update($uid, $user_data);
}

function bind($udata=''){
	global $UID;

	if(!$udata && !$UID)
		return false;
	elseif($UID)	
		$udata = get_member($UID, false ,'id');

	$qdata = $this->get_qq_user_info();

	if($this->get_bind_info())
		return false;
		
	$indata = array(
		'uid' => $udata['id'],
		'username' => $udata['username'],
		'openid' => $this->openid,
		'access_token' => $this->access_token,
		'expires_in' => $this->expires_in,
		'nickname' => html_entities(from_utf8($qdata['nickname'])),
		'gender' => html_entities(from_utf8($qdata['gender'])),
		'vip' => html_entities($qdata['vip']),
		'level' => html_entities($qdata['level']),
		'figureurl' => html_entities($qdata['figureurl']),
		'timestamp' => time()
	);

	return $this->DB_master->insert($this->table, $indata, array('return_id' => true));
}

function _display(){

	$config=$this->get_config();
	$data='<a href="'.$this->controller.'-login"><img src="'.$this->url.'icon/Connect_logo_'.$config['display'].'.png"></a>';

	echo $data;
}

function add_weibo($data)
{
	//发表微博的接口地址, 不要更改!!
    $url  = "https://graph.qq.com/wb/add_weibo";
    $post = "access_token=".$this->access_token
        ."&oauth_consumer_key=".$this->appid
        ."&openid=".$this->openid
        ."&format=".$data["format"]
        ."&type=".$data["type"]
        ."&content=".urlencode($data["content"])
        ."&img=".urlencode($data["img"]);

    //echo $data;
    $ret = p8_http_request(array('url'=>$url,'post'=>$post));
    return $ret;
}

function add_share($post)
{
    //发布一条动态的接口地址, 不要更改!!
    $url = "https://graph.qq.com/share/add_share?"
        ."access_token=".$this->access_token
        ."&oauth_consumer_key=".$this->appid
        ."&openid=".$this->openid
        ."&format=json"
        ."&title=".urlencode($post["title"])
        ."&url=".urlencode($post["url"])
        ."&comment=".urlencode($post["comment"])
        ."&summary=".urlencode($post["summary"])
        ."&images=".urlencode($post["images"]);

    //echo $url;

    $ret = p8_http_request(array('url'=>$url,'post'=>$post));
	return $ret;
}


function add_blog($data)
{
	//发表QQ空间日志的接口地址, 不要更改!!
    $url  = "https://graph.qq.com/blog/add_one_blog";
    $post = "access_token=".$this->access_token
        ."&oauth_consumer_key=".$this->appid
        ."&openid=".$this->openid
        ."&format=".$data["format"]
        ."&title=".$data["title"]
        ."&content=".$data["content"];

    $ret = p8_http_request(array('url'=>$url,'post'=>$post)); 
    return $ret;
}


function add_topic($data)
{
	//发表QQ空间日志的接口地址, 不要更改!!
    $url  = "https://graph.qq.com/shuoshuo/add_topic";
    $post = "access_token=".$this->access_token
        ."&oauth_consumer_key=".$this->appid
        ."&openid=".$this->openid
        ."&format=".$data["format"]
        ."&richtype=".$data["richtype"]
        ."&richval=".urlencode($data["richval"])
        ."&con=".urlencode($data["con"])
        ."&lbs_nm=".$data["lbs_nm"]
        ."&lbs_x=".$data["lbs_x"]
        ."&lbs_y=".$data["lbs_y"]
        ."&third_source=".$data["third_source"];

    //echo $data;
    $ret = p8_http_request(array('url'=>$url,'post'=>$post)); 
    return $ret;
}
}