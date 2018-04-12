<?php

return array(
	
	'no_such_username' => '此用户不存在',
	'user_no_verify' => '此用户还在审核中',
	'username' => '用户名',
	'username_length_range' => '用户名必须是3 - 20个字符',
	'username_required' => '用户名必须填写',
	'username_invalid' => '用户名不允许有特殊字符',
	'username_exists_or_denied' => '用户名已存在或用户名不允许注册',
	'username_hint' => '支持中英文注册，可直接输入公司名称或个人姓名',
	'cell_phone_hint' => '手机用于售后服务',
	'role_group_field_required' => '此字段必须填写',
	'confirm_to_logout' => '确认退出吗？',
	'confirm_to_delete_member' => '严重提示，删除会员，会同时删除此会员发布的所有内容。确定要删除会员吗?',
	
	'login_success' => '登录成功, <a href="{$1}" style="color:blue;">进入首页>></a>',
	'profile' => '会员资料',
	'confirm_password' => '确认密码',
	'old_password' => '旧密码',
	'new_password' => '新密码',
	'register_time' => '注册时间',
	'last_login_time' => '上次登录时间',
	'last_login_ip' => '上次登录IP',
	'login_time' => '登录次数',
	'phone' => '电话',
	'cell_phone' => '手机',
	'address' => '地址',
	'role_gname' => '部门',
	'role_name' => '角色',
	'status' => '状态',
	'email' => '电子邮箱',
	'address_list' => '部门员工',
	'number' => '编号',
	'register_with_captcha' => '注册是否需要验证码',
	'register_disabled' => '禁止注册',
	'login_with_captcha' => '登录是否需要验证码',
	
	'verify_question' => '验证问题',
	'register_question_enabled' => '是否开启注册问题',
	
	'verify_question_required' => '验证问题必须填写',
	'verify_question_incorrect' => '验证问题不正确',
	
	'email_required' => 'E-mail 必须填写',
	'email_invalid' => 'E-mail 格式不正确',
	'email_registerd' => 'E-mail 已被注册',
	
	'change_password' => '修改密码',
	'password_required' => '密码必须填写',
	'password_length_range' => '密码必须是8 - 20个字符',
	'password_strong' => '密码必须同时包含数字与字母',
	'password_not_match' => '两次密码不匹配',
	
	'phone_invalid' => '手机号码不正确',
	'phone_too_long' => '手机号码太长',
	
	'agreement_required' => '必须同意注册协议',
	
	'wrong_password' => '密码错误',
	'address_list' => '通讯录',
	'request_to_be_friends' => '{$1}请求加你为好友',
	'request_to_be_friends_content' => '{$1}请求加你为好友。<br />{$2}<br />验证<a href="'. $core->U_controller .'/member-friend?verified=0"><font color="red">传送门</a></a>',
	'verified_to_be_friends' => '{$1}通过了你的好友请求',
	'to_be_your_friend' => '{$1}加你为好友',
	
	'cache_acl_init' => '会员权限缓存初始化',
	'cache_acl_success' => '会员权限缓存完毕',
	'cache_acl' => '会员权限权限缓存',
	'cache_member' => '会员缓存',
	
	'member_status' => array(
		'' => '会员状态',
	
		0 => '正常',
		1 => '待审核',
		2 => '锁定',
	),
	
	'recharge' => array(
		'' => '充值',
		'order_name' => '充值 {$1}',
		'done' => '充值成功',
		'not_paid' => '未付款',
		'confirm_note' => '确认之前请确定已经收到买家的付款',
		
		'done_message' => '充值成功!',
		'done_message_content' => '你充值的{$1} {$2} {$3}已经完成。请查收。',
		
		'select_amount' => '选择充值金额',
		'note' => '1、选择金额：请选择您需要的充值的金额。<br />
		2、支付状态：您对此笔充值情况，如还没有充值成功，可以点击“充值管理”来完成这次支付<br />
		3、详细说明：充值的币种可以根据网站需要，支付不同商品购买，包括广告。<br />',
	),
	
	'buy_role' => array(
		'' => '购买会员权限',
		'select_role' => '选择需要升级的会员组',
		'note' => '<p>1,不同的用户组有不同的权限，请选择自身需要的用户组</p><p>2,你可以通过支会购买方式升级到相应用户组</p><p>3,你可以选择包月、包季度、包年等多种套餐服务</p>',
		'order_name' => '升级到“{$1}”',
		'need_maney' => '需要支付',
		'confirm_note' => '确定之前请确认你已经收到对方付款'
	),
		'register_active_success' => '帐号激活成功，请重新<a href="{$1}">登录</a>',
);