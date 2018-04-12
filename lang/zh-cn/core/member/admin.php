<?php
//后台管理语言包

return array(
	'set_role' => '设置角色',
	'system_integration' =>'系统整合配置',
	'member_config' => '会员设置',
	
	'member_integration' => '会员整合',
	'member_no_integration' => '不整合会员',
	'integration_sync_id' => '同步整合的会员ID',
	
	'uc' => array(
		'config' => 'UC整合配置',
		'connect' => 'UC连接类型',
		'db_host' => '数据库主机',
		'db_user' => '数据库用户名',
		'db_password' => '数据库密码',
		'db_name' => '数据库名',
		'db_charset' => '数据库字符集',
		'db_table_prefix' => '表名前缀',
		'key' => '通信密码',
		'api' => 'UC API地址',
		'charset' => 'UC 字符集',
		'ip' => 'UC IP地址',
		'appid' => 'UC 应用ID',
		'test_api' => '测试UC连接',
		'transition' => 'UC会员导入',
		'note1' => '',
		'note2' => '一般为localhost，不需修改',
		'note3' => '填入UC数据库用户名，root为默认Mysql超管用户名',
		'note4' => '填入数据库密码，官方套件默认密码为php168.net',
		'note5' => '填入安装UC软件时的数据库名，安装UC时需记住,默认为ucenter或ultrax',
		'note6' => '根据情况填写，一般为gbk编码(gbk, utf8)',
		'note7' => '格式：UC数据库.UC数据库前缀, 安装UC时候需记住，默认为：ucenter.uc_ 或 ultrax.pre_ucenter_',
		'note8' => '将UC端设定的通信密钥填入至此框中',
		'note9' => '填写UC的应用网址，如UC软件安装在本地UC文件夹中：http://127.0.0.1/uc',
		'note10' => '一般不填',
		'note11' => '根据情况填写，一般为gbk编码(gbk, utf-8)',
		'note12' => 'UC端添加PHP168程序整合后，会产生一个对应ID，填入此框中',
		'note13' => 'uc连接失败，请先把上面参数设好',
		'note14' => '真的要转换会员数据吗，转换前务必先备分数据，切记！！',
		'tran_type' => '导入方向选择',
		'this_system' => '本系统',
		'traning' => '会员转换中...'
		
	),
	
	'phpwind' => array(
		'config' => 'phpwind配置'
	),
	
	'register_with_check_code' => '注册是否需要验证码',
	'register_enabled' => '是否允许注册',
	
	'php168' => array(
		'config' => 'PHP168 配置',
		'p8_key' => 'PHP168 通信密码',
		'charset' => '页面编码',
		'api' => 'api地址',
		'test_api' => '测试PHP168整合',
		'ip' => 'api ip 地址',
	),
	
	'batch_send_note' => '你将要给{$1}个人发送，确定吗？',
	
	'_module_cache_admin_log' => '更新会员缓存',
	'_module_config_admin_log' => '配置',
	'_module_integrate_admin_log' => '会员整合',
	'_module_buy_role_admin_log' => '确认会员升级',
	'_module_recharge_admin_log' => '会员充值管理',
	'_module_recharge_card_admin_log' => '充值卡管理',
	'_module_add_admin_log' => '添加会员',
	'_module_update_admin_log' => '修改会员',
	'_module_credit_admin_log' => '修改会员积分',
	'_module_delete_admin_log' => '删除会员',
	'_module_batch_send_admin_log' => '批量发送会员信息',
	'error3' => '格式有误',
	'error2' => '文件太大'
	
);