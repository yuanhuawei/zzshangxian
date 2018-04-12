<?php
die();
/*
支付流程
1.其他模块调用本模块的order方法生成订单
2.把生成的订单编号传回本模块的pay action,即pay-pay?NO=订单编号, 并选择支付方式
3.根据支付方式生成支付代码,跳转到支付接口的网站
4.支付成功,由notify_[$interface].php来收受不同接口的通知,如支付宝就是notify_alipay.php,快钱,notify_99bill.php
5.支付模块里面只负责与支付接口之间的交互,并没有任何与其他模块相关的功能,但是支付模块每次接受支付接口的回调的时候,会用加密的方式与其它模块进行通信,由具体的模块实现具体的功能
*/

class P8_Pay_[$interface]{

/*
构造函数
@param object $pay 支付模块的引用
@param array $config 接口的配置
@param array $order 订单信息的引用
*/
function __constructor(&$pay, $config, &$order){}

/*
生成支付代码
@return array 代码信息
返回格式
array(
	'gateway' => '支付网关',
	'method' => 'get', 表单提交方式
	'params' => array(	表单参数,由表单隐式提交
		'price' => '0.01',
		'quality' => 
	)
)


下订单格式
下订单仅是在主表生成一个订单编号和回调,具体可以在各系统模块下建个订单表来单独管理
$pay = &$core->load_module('pay');
$data = array(
	'name' => '订单名称',
	'amount' => '订单金额',
	'number' => '数量',
	'NO_prefix' => '订单前缀',
	'seller_uid' => '卖家ID',
	'seller_username' => '卖家用户名',
	'buyer_uid' => '买家ID',
	'buyer_username' => '买家用户名',
	'notify' => array(
		'system' => 'b2b',	//下订单的系统名称
		'module' => 'sell',	//下订单的模块名称
		'action' => 'buy',	//下订单的动作名称
		// 以上3个回调参数是必须的
		接口回调如域名是www.php168.com,支付回调会用POST方式请求下订单处理地址
		http://www.php168.com/index.php/b2b/sell-buy?pay_notify=加密(money=$money)
		
		//自定义参数
		'money' => $money,
	)
);

!!!!注意,回调只能通过index.php这个入口进行回调,u.php,admin.php等其他入口均不能回调

$pay->order($data);
*/
function pay(){}


/*
接受支付接口的通知, 验证通知是否正确, 并返回指定的状态码, 返回订单编号
@param int $status 强制传入的状态码

-1	交易关闭
0	未付款
1	己付款
2	己发货
3	交易完成
array(
	'status' => 1, 交易状态码
	'order_NO' => '', 订单编号
	'interface_NO' => '',支付接口生成的订单号
	'amount' => '', 金额总数
	'number' => '', 货物数量
)
返回null时证明验证失败

notify完成之后会根据下单之前的模块信息进行回调,如会员充值,http://url/core/member-recharge,只能返回success以及fail
*/
function notify($status = null){}

}