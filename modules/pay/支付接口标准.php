<?php
die();
/*
֧������
1.����ģ����ñ�ģ���order�������ɶ���
2.�����ɵĶ�����Ŵ��ر�ģ���pay action,��pay-pay?NO=�������, ��ѡ��֧����ʽ
3.����֧����ʽ����֧������,��ת��֧���ӿڵ���վ
4.֧���ɹ�,��notify_[$interface].php�����ܲ�ͬ�ӿڵ�֪ͨ,��֧��������notify_alipay.php,��Ǯ,notify_99bill.php
5.֧��ģ������ֻ������֧���ӿ�֮��Ľ���,��û���κ�������ģ����صĹ���,����֧��ģ��ÿ�ν���֧���ӿڵĻص���ʱ��,���ü��ܵķ�ʽ������ģ�����ͨ��,�ɾ����ģ��ʵ�־���Ĺ���
*/

class P8_Pay_[$interface]{

/*
���캯��
@param object $pay ֧��ģ�������
@param array $config �ӿڵ�����
@param array $order ������Ϣ������
*/
function __constructor(&$pay, $config, &$order){}

/*
����֧������
@return array ������Ϣ
���ظ�ʽ
array(
	'gateway' => '֧������',
	'method' => 'get', ���ύ��ʽ
	'params' => array(	������,�ɱ���ʽ�ύ
		'price' => '0.01',
		'quality' => 
	)
)


�¶�����ʽ
�¶�����������������һ��������źͻص�,��������ڸ�ϵͳģ���½�������������������
$pay = &$core->load_module('pay');
$data = array(
	'name' => '��������',
	'amount' => '�������',
	'number' => '����',
	'NO_prefix' => '����ǰ׺',
	'seller_uid' => '����ID',
	'seller_username' => '�����û���',
	'buyer_uid' => '���ID',
	'buyer_username' => '����û���',
	'notify' => array(
		'system' => 'b2b',	//�¶�����ϵͳ����
		'module' => 'sell',	//�¶�����ģ������
		'action' => 'buy',	//�¶����Ķ�������
		// ����3���ص������Ǳ����
		�ӿڻص���������www.php168.com,֧���ص�����POST��ʽ�����¶��������ַ
		http://www.php168.com/index.php/b2b/sell-buy?pay_notify=����(money=$money)
		
		//�Զ������
		'money' => $money,
	)
);

!!!!ע��,�ص�ֻ��ͨ��index.php�����ڽ��лص�,u.php,admin.php��������ھ����ܻص�

$pay->order($data);
*/
function pay(){}


/*
����֧���ӿڵ�֪ͨ, ��֤֪ͨ�Ƿ���ȷ, ������ָ����״̬��, ���ض������
@param int $status ǿ�ƴ����״̬��

-1	���׹ر�
0	δ����
1	������
2	������
3	�������
array(
	'status' => 1, ����״̬��
	'order_NO' => '', �������
	'interface_NO' => '',֧���ӿ����ɵĶ�����
	'amount' => '', �������
	'number' => '', ��������
)
����nullʱ֤����֤ʧ��

notify���֮�������µ�֮ǰ��ģ����Ϣ���лص�,���Ա��ֵ,http://url/core/member-recharge,ֻ�ܷ���success�Լ�fail
*/
function notify($status = null){}

}