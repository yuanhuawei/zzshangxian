<?php
defined('PHP168_PATH') or die();

/*
֧����notify��ʱ��ʹ�õ���POST
return��ʱ��ʹ�õ���GET
*/

class P8_Pay_alipay{

var $partner;			//������
var $security_code;		//��ȫ��
var $seller_email;		//����
var $charset;			//�ַ���
var $sign_type;			//ǩ����ʽ
var $transport;			//Э��
var $service;			//��������
var $notify_url;		//֪ͨURL
var $return_url;		//����URL
var $gateway;			//֧��������

var $pay;				//֧��ģ�������
var $order;				//����

function P8_Pay_alipay(&$pay, $config, &$order){
	
	//�˺źͰ�ȫ����Ҫ���ð�
	if(empty($config['account']) || empty($config['security_code'])) message('pay_interface_set_error');
	$this->pay = &$pay;
	$this->order = &$order;
	
	$this->partner = $config['partner'];
	$this->security_code = $config['security_code'];
	$this->seller_email = $config['account'];
	$this->charset = strtoupper($pay->core->CONFIG['page_charset']);
	//�������ֻ���Ժ�̨���õ�Ϊ��
	$this->transport = isset($pay->CONFIG['alipay']['config']['transport']) && $pay->CONFIG['alipay']['config']['transport'] == 'http' ? 'http' : 'https';
	$this->sign_type = 'MD5';
	$this->service = $config['service'];
	$this->gateway = $this->transport .'://www.alipay.com/cooperate/gateway.do?';
	$this->verify_notify_url = 'http://notify.alipay.com/trade/notify_query.do';
	
	$this->notify_url = $pay->url .'/notify_alipay.php';
	//$this->return_url = $pay->controller .'-notify_alipay';
}

/**
* ����֧������
* @param array $order ������Ϣ
**/
function pay(){
	/*
	���������׽ӿ�	create_partner_trade_by_buyer
	��׼ʵ��˫�ӿ�	trade_create_by_buyer
	��ʱ���˽ӿ�	create_direct_pay_by_user
	*/
	$params = array(
		'service'			=> $this->service,			//��������
		'partner'			=> $this->partner,         	//�����̻���
		//'return_url'		=> $this->return_url,      	//ͬ������
		'notify_url'		=> $this->notify_url,      	//�첽����
		'_input_charset'	=> $this->charset,  		//�ַ���,Ĭ��ΪGBK
		'subject'        	=> $this->order['name'],	//��Ʒ���ƣ�����
		'body'				=> $this->order['name'],	//��Ʒ����������
		'out_trade_no'		=> $this->order['NO'],		//��Ʒ�ⲿ���׺�,�����֤Ψһ�ԣ�
		'price'				=> $this->order['amount'],	//�ܶ�
		'payment_type'		=> 1,						//Ĭ��Ϊ1,����Ҫ�޸�
		'quantity'			=> 1,						//��Ʒ����,ǿ��Ϊ1,�ܶ���price�����
		
		'logistics_fee'		=> '0.00',        			//�������ͷ���
		'logistics_payment'	=> 'BUYER_PAY',   //�������ø��ʽ��SELLER_PAY(����֧��)��BUYER_PAY(���֧��)��BUYER_PAY_AFTER_RECEIVE(��������)
		'logistics_type'	=> 'EXPRESS',     			//�������ͷ�ʽ��POST(ƽ��)��EMS(EMS)��EXPRESS(�������)
		//'show_url'		=> $order['item_url'],
		'seller_email'		=> $this->seller_email     	//�������䣬����
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
* ����֪ͨ
**/
function notify($status){
	
	if($status !== null){
		if($status == 2){
			//ʵ��֧�����ķ����ӿ�,��׼˫�ӿڲ�֧��,������Ҫphp����openssl����
			$this->service = 'send_goods_confirm_by_platform';
			$params = array(
				'service'			=> $this->service,			//��������
				'partner'			=> $this->partner,         	//�����̻���
				'notify_url'		=> $this->notify_url,      	//�첽����
				'_input_charset'	=> $this->charset,  		//�ַ���,Ĭ��ΪGBK
				//֧����������
				'trade_no' => $this->order['interface_NO'],
				//������˾����
				'logistics_name' => 'test',
				//��������
				'invoice_no' => 'test',
				//�������ͣ�POST(ƽ��),EXPRESS(���)��EMS(EMS)
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
		
		//��֧��������,����Ա���û��޸ĵ�״̬
		return array(
			'status' => $status,
			'amount' => $this->order['amount'],
			'number' => $this->order['number'],
			'timestamp' => P8_TIME
		);
	}
	
	$notify_id = isset($_POST['notify_id']) ? $_POST['notify_id'] : '';
	
	//��֤֪ͨ��ǩ��
	$notify_verify = $this->notify_verify($notify_id);
	$sign_verify = $this->verify_sign($_POST);
	
	if($notify_verify && $sign_verify){
		
		switch($_POST['trade_status']){
		
		//�ȴ���Ҹ���
		case 'WAIT_BUYER_PAY': $status = $this->pay->STATUS['WAIT_BUYER_PAY']; break;
		
		//��Ҹ���
		case 'WAIT_SELLER_SEND_GOODS': $status = $this->pay->STATUS['BUYER_PAID']; break;
		
		//���ҷ���
		case 'WAIT_BUYER_CONFIRM_GOODS': $status = $this->pay->STATUS['SELLER_SENT']; break;
		
		//�������
		case 'TRADE_SUCCESS': case 'TRADE_FINISHED': $status = $this->pay->STATUS['TRADE_SUCCESS']; break;
		
		//���׹ر�
		case 'TRADE_CLOSED': $status = $this->pay->STATUS['TRADE_CLOSED']; break;
		
		default:
			return null;
		}
		
		if(isset($_POST['refund_status']) && $_POST['refund_status'] == 'REFUND_SUCCESS'){
			//�˿�ɹ�
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
* ֪ͨ��֤
* @param string $notify_id ֪ͨID
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
* ǩ��
* @param array $params ����
* @return string ǩ��MD5
**/
function sign($params){
	//ȥ��������ǩ����ֵ
	unset($params['sign'], $params['sign_type']);
	
	ksort($params);
	
	$and = $sign = '';
	foreach($params as $k => $v){
		$v = trim($v);
		if($v !== ''){	//ȥ����ֵ
			$sign .= $and . $k .'='. $v;
			$and = '&';
		}
	}
	
	return md5($sign . $this->security_code);
}

/**
* ��֤ǩ��
* @param array $params
* @return bool
**/
function verify_sign($params){
	if(empty($params) || empty($params['sign'])) return false;
	
	return $this->sign($params) == $params['sign'];
}

}