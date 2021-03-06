<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$core->CONFIG['page_charset']}" />
<meta name="renderer" content="webkit"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1"/>
<title>{$P8LANG['login']}</title>
<link rel="stylesheet" type="text/css" href="{$SKIN}core/style.css" />
<script type="text/javascript" src="{$RESOURCE}/js/config.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/util.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/jq_validator.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/lang/core/{$core->CONFIG['lang']}.js"></script>
</head>
<body>
<div class="headbar">
<div class="header">
<div class="logo fl"><img src="{$SKIN}core/images/logo.png"/></div>
<div class="home fr"><a href="{$core->controller}">返回首页</a></div>
</div>
</div>
<div class="contentbox">
<div class="wrapper">
<div class="loginbox">
<div class="logindiv fr">
<div class="brand">
<h3>账号密码{$P8LANG['login']}</h3>
</div>
<form method="post" id="form" action="$this_url" >
<div class="formint">
<input type="text" name="username" id="username" class="username" value="请输入账号" onfocus="if(this.value=='请输入账号'){this.value='';}" onblur="if(this.value==''){this.value='请输入账号';}"/>
</div>
<div class="formint">
<input type="password" name="password" id="password" class="password"/>
</div>
EOT;
if(!empty($this_module->CONFIG['login_with_captcha'])){
print <<<EOT

<div class="formcode">
<input name="captcha" type="text" id="captcha" class="input" value="验证码" onfocus="if (value =='验证码'){value =''}" onblur="if (value ==''){value='验证码'}" /> <span id="captcham"></span>
</div>
<script type="text/javascript">
captcha($('#captcham'), $('#captcha'));
</script>
EOT;
}
print <<<EOT

<div class="formbtn">
<input type="submit" value="{$P8LANG['login']}" tabindex="3" class="submit"/>
</div>
<div class="formul">
<ul>
<li>记住密码<input type="checkbox" name="remember_me" value="1" /></li>
<li><a href="{$core->controller}/member-getpassword">忘记密码</a></li>
<li><a href="{$core->controller}/member-register" class="tologin">{$P8LANG['register']}</a></li>
</ul>
</div>
<input type="hidden" name="forward" value="
EOT;
if(isset($forward)){
print <<<EOT
$forward
EOT;
}
print <<<EOT
" />
</form>	
</div>
</div>
</div>
</div>
<div class="footbar">
<div class="footer">
<div class="copyright">
<ul>
<li>{$core->CONFIG['copyright']}</li>
</ul>
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
$('#username').focus();

$('#form').validate({
rules: {
username: {
required: true
},
password: {
required: true
}
},
messages: {
username: {
required: '<font color=red>帐号不能为空</font>'
},
password: {
required: '<font color=red>密码不能为空</font>'
}
},

onkeyup: false
});
});

$('#username').get(0).focus();
</script>
</body>
</html>
EOT;
?>