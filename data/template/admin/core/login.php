<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1"/>
<title>国微系统后台管理平台</title>
<link rel="stylesheet" type="text/css" href="{$RESOURCE}/skin/admin/login/style.css" />
<script type="text/javascript" src="{$RESOURCE}/js/util.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/config.js"></script>
</head>
<body>
<div class="login">
<div class="logo"></div>
<h3>欢迎登录内容管理系统后台</h3>
<div class="loginbar">
<form action="$this_url" method="post">
<div class="formWrap">
<div class="lable user">账号：</div>
<div class="forminput">
EOT;
if($USERNAME){
print <<<EOT

<input type="hidden" name="username" value="{$USERNAME}" />
<input type="text" class="txt" value="{$USERNAME}" disabled />
EOT;
}else{
print <<<EOT

<input type="text" class="txt" id="username" value="账号" name="username" onfocus="if (value =='账号'){value =''}" onblur="if (value ==''){value='账号'}"/>
EOT;
}
print <<<EOT

</div>
</div>
<div class="formWrap">
<div class="lable pwd">密码：</div>
<div class="forminput">
<input  type="password" class="txt" name="password" />
</div>
</div>
EOT;
if(!empty($core->CONFIG['admin_login_code'])){
print <<<EOT

<div class="formWrap">
<div class="lable code">安全码：</div>
<div class="forminput">
<input  type="password" class="txt" name="code" title="新安装默认为:php168" value="安全码" onfocus="if (value =='安全码'){value =''}" onblur="if (value ==''){value='安全码'}"/>
</div>
</div>
EOT;
}
if(!empty($core->CONFIG['admin_login_with_captcha'])){
print <<<EOT

<div class="formWrap">
<div class="lable captcha">验证码：</div>
<div class="forminput">
<input  type="text" class="txt2 left" size="5" name="captcha" size="5" value="验证码" onfocus="if (value =='验证码'){value =''}" onblur="if (value ==''){value='验证码'}"/><span class="right" id="captcha"></span>
</div>
</div>
<script type="text/javascript">
$(function(){
captcha($('#captcha'));
});
</script>
EOT;
}
print <<<EOT

<div class="loginbtn"><input type="submit" class="submit" value="登录" /></div>
<input type="hidden" name="forward" value="
EOT;
if(!empty($forward)){
print <<<EOT
$forward
EOT;
}
print <<<EOT
" />
<div style="text-align:center;color:red;">（第一次若无法登陆，请再次输入账号）</div>
</form>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
element_to_center($('.login'));
EOT;
if($USERNAME){
print <<<EOT

$('form input[name=password]').get(0).focus();
EOT;
}else{
print <<<EOT

$('form #username').get(0).focus();
EOT;
}
print <<<EOT

});
</script>
</body>
</html>
EOT;
?>