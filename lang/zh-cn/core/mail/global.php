<?php

return array(
	'memail' => array(
		'crlf_o' => '邮件服务器换行符',
		'crlf' => 'CRLF (windows主机)',
		'lf' => 'LF (linix主机)',
		'send_type' => '发送方式',
		'send_smtp' => 'SMTP发送',
		'send_mail' => 'mail函数发送',
		'emailpassword' =>'邮箱密码',
		
		'email_required' => 'email 必须填写',
		'subject_required' => '邮件标题必须填写',
		'content_required' => '邮件内容必须填写',
		
		'smtp' => array(
			'server' => 'SMTP服务器',
			'port' => 'SMTP服务器端口'
		),
		'note1' => '一般选择SMTP发送，属于邮件协议。选择mail函数发送需要配置服务器',
		'note2' => '一般选择CRLF，现在普遍两种都支持。',
		'note3' => '163邮箱：smtp.163.com ，Gmail邮箱：smtp.gmail.com，以此类推。',
		'note4' => '端口默认为25',
		'note5' => '网站所有群发给用户的邮件都以此邮箱名义。填写你的邮箱账号',
		'note6' => '填写上面提供邮箱的密码',
		'note7' => '多个邮箱请用半角逗号分开',
		'note8' => '日志保存在data/log里，方便调试哪些地方出错',
		'note9' => '',
		'note10' => '',
	),
);