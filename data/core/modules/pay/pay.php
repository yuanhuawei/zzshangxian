<?php
return array (
  'interfaces' => 
  array (
    'alipay' => 
    array (
      'alias' => '支付宝',
      'logo' => 'alipay.gif',
      'enabled' => 0,
      'config' => 
      array (
      ),
    ),
    'credit' => 
    array (
      'alias' => '余额付款(尚未支持)',
      'logo' => 'alipay.gif',
      'enabled' => 0,
      'config' => 
      array (
      ),
    ),
    'offline' => 
    array (
      'alias' => '线下付款',
      'logo' => 'unionpay.gif',
      'enabled' => 1,
      'config' => 
      array (
        'bank' => 
        array (
          0 => 
          array (
            'name' => '中国工商银行',
            'account' => '6222*********',
            'payee' => '某先生(小姐)',
            'logo' => 'icbc.gif',
          ),
        ),
      ),
    ),
    'tenpay' => 
    array (
      'alias' => '财付通(尚未支持)',
      'logo' => 'tenpay.gif',
      'enabled' => 0,
      'config' => 
      array (
      ),
    ),
  ),
  'mobile_template' => 'mobile/group',
  'template' => '',
);