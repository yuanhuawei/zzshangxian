<?php
return array (
  'integration_types' => 
  array (
    'uc' => 'Ucenter',
    'pw' => 'phpwind',
    'p8' => 'php168(未实现)',
  ),
  'administrators' => 
  array (
    'admin' => 1,
  ),
  'integration_sync_id' => '1',
  'integration_type' => '',
  'mobile_template' => 'mobile/group',
  'php168_config' => 
  array (
    'p8_key' => '',
    'api' => 'http://www.***.com/api/p8.php',
    'ip' => '',
    'charset' => '',
  ),
  'pw' => 
  array (
    'api' => 'http://bbs.**.com',
    'code' => 'php168',
  ),
  'recharge' => 
  array (
    'credit_type' => '2',
    'quantity' => 
    array (
      2 => 2,
      5 => 5,
      10 => 10,
      30 => 33,
      50 => 55,
      100 => 110,
    ),
  ),
  'register' => 
  array (
    'enabled' => '1',
    'captcha' => '0',
    'verify' => '0',
    'title' => '您好，感谢您的注册{sitename}',
    'notice' => '尊敬的{username}:
您已经注册成为{sitename}的会员，请您在发表言论时，遵守当地法律法规。
如果您有什么疑问可以联系管理员，Email: {adminemail}。
你的帐号是：{username}
密码是：{password}
请妥善保存

{sitename}
{time}',
  ),
  'reg_disallow_username' => '',
  'safe' => 
  array (
  ),
  'template' => '',
  'uc' => 
  array (
    'connect' => 'mysql',
    'db_host' => 'localhost',
    'db_user' => '',
    'db_password' => '',
    'db_name' => 'ucenter',
    'db_charset' => 'gbk',
    'db_table_prefix' => 'ucenter.uc_',
    'key' => '',
    'api' => 'http://127.0.0.1/uc',
    'ip' => '',
    'charset' => 'gbk',
    'appid' => '',
  ),
);