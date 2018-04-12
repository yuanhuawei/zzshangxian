<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<span id="login_info" 
EOT;
if(!$UID){
print <<<EOT
style="display:none"
EOT;
}
print <<<EOT
 >
<span style="margin-left:0px;"><a href="{$core->U_controller}"><font color="#0000ff"><b class="username">
EOT;
if($UID){
print <<<EOT
{$this_module->username}
EOT;
}
print <<<EOT
</b></font></a>&nbsp;<a class="rolename"></a> 欢迎您回来！&nbsp;<a href="{$core->U_controller}" target="_blank"><font color="#FF7F04"><b>会员中心</b></font></a> 
<a href="{$core->U_controller}?main_page=
EOT;
echo urlencode('/message-inbox?message_type=new');
print <<<EOT
" 
EOT;
if(empty($this_module->new_messages)){
print <<<EOT
style="display:none"
EOT;
}
print <<<EOT
 target="_blank"><font color="red" >你有新信息(<u class="new_messages">{$this_module->new_messages}</u>)</font></a> 
<a href="{$core->U_controller}/member-logout" onclick="return ajax_logout()">安全退出</a></span>
</span>
<span id="login_link" 
EOT;
if($UID){
print <<<EOT
style="display:none"
EOT;
}
print <<<EOT
>
<a href="{$core->controller}/core/member-register">注册</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="{$core->U_controller}">登录</a>
</span>
<div style=" position:absolute; background-color:#ffffff;border:4px solid #8CB8EA;display:none;z-index:999" id="loginbox">
<form id="login_form" method="post" onsubmit="ajax_login();return false;">
<table id="login" align="center" cellpadding="4" cellspacing="0" width="100%">
<tr>
<td colspan="2" align ="left" style="font-size:14px;font-weight:bolder; background-color:#F1F7FD" > {$P8LANG['login']}</td>
<td style="background-color:#F1F7FD"><div style="width:28px;font-size:12px;float:right;padding-right:5px;line-height:18px;font-weight:bold;cursor:pointer;" onclick="$('#loginbox').hide();">X</div></td>
</tr>
<tr>
<td>&nbsp;</td>
<td class="td_left" align ="right">
<br />
EOT;
if($inte){
print <<<EOT

帐号
EOT;
}else{
print <<<EOT

<select name="type">
<option value="username">帐号</option>
<option value="email">邮箱</option>
<option value="id">UID</option>
</select>
EOT;
}
print <<<EOT
	
</td>
<td  class="td_right" align ="left"><br /> <input type="text" name="username" id="username" class="input" /> </td>
</tr>
<tr>
<td>&nbsp;</td>
<td class="td_left" align ="right">{$P8LANG['password']}</td>
<td  class="td_right" align ="left"> <input name="password" type="password" id="password" class="input" /> </td>
</tr>
EOT;
if(!empty($this_module->CONFIG['login_with_captcha'])){
print <<<EOT

<tr>
<td>&nbsp;</td>
<td class="td_left" align ="right">{$P8LANG['captcha']}</td>
<td class="td_right" align ="left"> <input name="captcha" type="text" id="logincaptcha" class="input" /> <span id="logincaptcham"></span> </td>
</tr>
<script type="text/javascript">
captcha($('#logincaptcham'), $('#logincaptcha'));
</script>
EOT;
}
print <<<EOT

<tr>
<td>&nbsp;</td>
<td ></td>
<td  class="td_right" align="left"><input type="checkbox" name="remember_me" value="1" /> 记住密码 <a href="{$core->controller}/member-getpassword">忘记密码</a></td>
</tr>
<tr>
<td colspan="3" align="center">
<input type="submit" value="{$P8LANG['login']}" tabindex="3" class="submit"/> 
<input type="button" value="{$P8LANG['cancel']}" onclick="$('#loginbox').hide();" />
<input type="hidden" name="forward" value="$forward"/>				
</td>
</tr>
</table>
</form>
</div>
<script language="javascript">
function ajax_login(){
if($('#login_form input[name=username]').val()==''){alert('账号不能为空');return false;}
if($('#login_form input[name=password]').val()==''){alert('密码不能为空');return false;}
EOT;
if(!empty($this_module->CONFIG['login_with_captcha'])){
print <<<EOT

if($('#login_form input[name=captcha]').val()==''){alert('验证码不能为空');return false;}
EOT;
}
print <<<EOT

$.ajax({
type:'POST',
url:"{$core->U_controller}/member-login",
data:$('#login_form').serialize(),
dataType:'json',
success:function(msg){
if(msg=='no_such_username')alert('此用户不存在');
if(msg=='user_no_verify')alert('此用户还在审核中');
if(msg=='wrong_password')alert('帐号或密码错误');
if(msg.status=='0'){
$('#login_link').hide();
$('#loginbox').hide();
$('#login_info .username').html(msg.username);
if(msg.message){
$('#login_info .new_messages').show().html(msg.message);

}
$('#login_info').show();
}
}
})
}
function ajax_logout(){
if(!confirm('真嘀要退出么？'))return false;
$.ajax({
type:'POST',
url:"{$core->U_controller}/member-logout",
success:function(msg){
$('#login_link').show();
$('#login_info').hide();
}
});
return false;
}
function loginshwo(){
$('#loginbox').css({
left: parseInt((get_scrollLeft() + get_document_width() - 150)/2) +'px',
top: parseInt(get_scrollTop() + (get_document_height() - 90)/2) +'px',
width:'300px',
height:'180px'
}).show();

}
</script>
EOT;
?>