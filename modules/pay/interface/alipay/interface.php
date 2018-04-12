<?php
defined('PHP168_PATH') or die();

/*
支付宝notify的时候使用的是POST
return的时候使用的是GET
*/

class P8_Pay_alipay{

var $partner;			//合作者
var $security_code;		//安全码
var $seller_email;		//卖家
var $charset;			//字符集
var $sign_type;			//签名方式
var $transport;			//协议
var $service;			//服务类型
var $notify_url;		//通知URL
var $return_url;		//返回URL
var $gateway;			//支付宝网关

var $pay;				//支付模块的引用
var $order;				//订单

function P8_Pay_alipay(&$pay, $config, &$order){
	
	//账号和安全码总要设置吧
	if(empty($config['account']) || empty($config['security_code'])) message('pay_interface_set_error');
	$this->pay = &$pay;
	$this->order = &$order;
	
	$this->partner = $config['partner'];
	$this->security_code = $config['security_code'];
	$this->seller_email = $config['account'];
	$this->charset = strtoupper($pay->core->CONFIG['page_charset']);
	//这个参数只能以后台设置的为主
	$this->transport = isset($pay->CONFIG['alipay']['config']['transport']) && $pay->CONFIG['alipay']['config']['transport'] == 'http' ? 'http' : 'https';
	$this->sign_type = 'MD5';
	$this->service = $config['service'];
	$this->gateway = $this->transport .'://www.alipay.com/cooperate/gateway.do?';
	$this->verify_notify_url = 'http://notify.alipay.com/trade/notify_query.do';
	
	$this->notify_url = $pay->url .'/notify_alipay.php';
	//$this->return_url = $pay->controller .'-notify_alipay';
}

/**
* 生成支付代码
* @param array $order 订单信息
**/
function pay(){
	/*
	纯担保交易接口	create_partner_trade_by_buyer
	标准实物双接口	trade_create_by_buyer
	即时到账接口	create_direct_pay_by_user
	*/
	$params = array(
		'service'			=> $this->service,			//交易类型
		'partner'			=> $this->partner,         	//合作商户号
		//'return_url'		=> $this->return_url,      	//同步返回
		'notify_url'		=> $this->notify_url,      	//异步返回
		'_input_charset'	=> $this->charset,  		//字符集,默认为GBK
		'subject'        	=> $this->order['name'],	//商品名称，必填
		'body'				=> $this->order['name'],	//商品描述，必填
		'out_trade_no'		=> $this->order['NO'],		//商品外部交易号,必填（保证唯一性）
		'price'				=> $this->order['amount'],	//总额
		'payment_type'		=> 1,						//默认为1,不需要修改
		'quantity'			=> 1,						//商品数量,强制为1,总额在price处算好
		
		'logistics_fee'		=> '0.00',        			//物流配送费用
		'logistics_payment'	=> 'BUYER_PAY',   //物流费用付款方式：SELLER_PAY(卖家支付)、BUYER_PAY(买家支付)、BUYER_PAY_AFTER_RECEIVE(货到付款)
		'logistics_type'	=> 'EXPRESS',     			//物流配送方式：POST(平邮)、EMS(EMS)、EXPRESS(其他快递)
		//'show_url'		=> $order['item_url'],
		'seller_email'		=> $this->seller_email     	//卖家邮箱，必填
	);
	
	ksort($params);
	
	$params['sign'] = $this->sign($params);
	$params['sign_type'] = $this->sign_type;
	
	return array(
		'method' => 'get',
		'gateway' => $this->gateway,
		'params' => $params
	);
}

/**
* 处理通知
**/
function notify($status){
	
	if($status !== null){
		if($status == 2){
			//实现支付宝的发货接口,标准双接口才支持,而且需要php开启openssl功能
			$this->service = 'send_goods_confirm_by_platform';
			$params = array(
				'service'			=> $this->service,			//交易类型
				'partner'			=> $this->partner,         	//合作商户号
				'notify_url'		=> $this->notify_url,      	//异步返回
				'_input_charset'	=> $this->charset,  		//字符集,默认为GBK
				//支付宝订单号
				'trade_no' => $this->order['interface_NO'],
				//物流公司名称
				'logistics_name' => 'test',
				//物流单号
				'invoice_no' => 'test',
				//发货类型，POST(平邮),EXPRESS(快递)，EMS(EMS)
				'transport_type' => '',
			);
			
			ksort($params);
			
			$sign = $this->sign($params);
			
			$url = $this->gateway;
			foreach($params as $k => $v){
				$url .= $k .'='. urlencode($v) .'&';
			}
			$url .= 'sign='. $sign .'&sign_type='. $this->sign_type;
			
			$ret = p8_http_request(array('url' => $url));
		}
		
		//非支付宝请求,管理员或用户修改的状态
		return array(
			'status' => $status,
			'amount' => $this->order['amount'],
			'number' => $this->order['number'],
			'timestamp' => P8_TIME
		);
	}
	
	$notify_id = isset($_POST['notify_id']) ? $_POST['notify_id'] : '';
	
	//验证通知和签名
	$notify_verify = $this->notify_verify($notify_id);
	$sign_verify = $this->verify_sign($_POST);
	
	if($notify_verify && $sign_verify){
		
		switch($_POST['trade_status']){
		
		//等待买家付款
		case 'WAIT_BUYER_PAY': $status = $this->pay->STATUS['WAIT_BUYER_PAY']; break;
		
		//买家付款
		case 'WAIT_SELLER_SEND_GOODS': $status = $this->pay->STATUS['BUYER_PAID']; break;
		
		//卖家发货
		case 'WAIT_BUYER_CONFIRM_GOODS': $status = $this->pay->STATUS['SELLER_SENT']; break;
		
		//交易完成
		case 'TRADE_SUCCESS': case 'TRADE_FINISHED': $status = $this->pay->STATUS['TRADE_SUCCESS']; break;
		
		//交易关闭
		case 'TRADE_CLOSED': $status = $this->pay->STATUS['TRADE_CLOSED']; break;
		
		default:
			return null;
		}
		
		if(isset($_POST['refund_status']) && $_POST['refund_status'] == 'REFUND_SUCCESS'){
			//退款成功
			$status = $this->pay->STATUS['TRADE_CLOSED'];
		}
		
		return array(
			'status' => $status,
			'amount' => $_POST['total_fee'],
			'number' => $_POST['quantity'],
			'interface_NO' => $_POST['trade_no'],
			'timestamp' => P8_TIME
		);
	}
	
	return null;
}

/**
* 通知验证
* @param string $notify_id 通知ID
* @return bool
**/
function notify_verify($notify_id){
	$ret = p8_http_request(
		array(
			'url' => $this->verify_notify_url,
			'post' => 'partner='. $this->partner .'&notify_id='. $notify_id
		)
	);
	
	return $ret['body'] == 'true';
}

/**
* 签名
* @param array $params 参数
* @return string 签名MD5
**/
function sign($params){
	//去除不参与签名的值
	unset($params['sign'], $params['sign_type']);
	
	ksort($params);
	
	$and = $sign = '';
	foreach($params as $k => $v){
		$v = trim($v);
		if($v !== ''){	//去除空值
			$sign .= $and . $k .'='. $v;
			$and = '&';
		}
	}
	
	return md5($sign . $this->security_code);
}

/**
* 验证签名
* @param array $params
* @return bool
**/
function verify_sign($params){
	if(empty($params) || empty($params['sign'])) return false;
	
	return $this->sign($params) == $params['sign'];
}

}