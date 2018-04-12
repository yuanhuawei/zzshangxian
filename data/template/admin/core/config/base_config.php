<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台管理  powerby www.php168.net</title>
<meta http-equiv="Content-Type" content="text/html; charset={$core->CONFIG['page_charset']}">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="stylesheet" href="{$RESOURCE}/skin/admin/style.css" type="text/css">
<script type="text/javascript" src="{$RESOURCE}/js/config.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/util.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/jq_validator.js"></script>

<script type="text/javascript" src="{$RESOURCE}/js/admin.js"></script>

<script type="text/javascript" src="{$RESOURCE}/js/lang/core/{$core->CONFIG['lang']}.js"></script>
EOT;
if($SYSTEM != 'core'){
print <<<EOT

<script type="text/javascript" src="{$RESOURCE}/js/lang/$SYSTEM/{$core->CONFIG['lang']}.js"></script>
EOT;
}
print <<<EOT


<script type="text/javascript">
P8CONFIG.admin_controller = '{$core->admin_controller}';
var P8_ROOT = '$P8_ROOT';

P8CONFIG.RESOURCE = '$RESOURCE';
var SYSTEM = '$SYSTEM',
MODULE = '$MODULE',
ACTION = '$ACTION',
LABEL_URL = '$LABEL_URL',
\$this_router = '{$this_router}',
\$this_url = \$this_router +'-'+ ACTION,
SKIN = '$SKIN',
TEMPLATE = '$TEMPLATE';
mobile_status= '{$core->CONFIG['enable_mobile']}',
mobile_auto_jump='{$core->CONFIG['mobile_auto_jump']}',
mobile_url = '{$core->CONFIG['murl']}';
if(mobile_status=='1' && SYSTEM!='sites'){
if(browser.versions.android || browser.versions.iPhone || browser.versions.iPad){
if(mobile_auto_jump=='1' && mobile_url!=P8CONFIG.RESOURCE){
var this_url = location.href,_pul=P8CONFIG.RESOURCE;
if(this_url.indexOf(mobile_url)==-1 && this_url.indexOf('s.php')==-1 && this_url.indexOf('u.php')==-1 && this_url.indexOf('admin.php')==-1 && SYSTEM!='sites'){
if(this_url.indexOf(P8CONFIG.RESOURCE+'/html')!=-1)_pul+='/html';
this_url = this_url.replace(_pul, mobile_url);
location.href = this_url;
}
}
}
}

</script>
<script type="text/javascript">
$(document).ready(function(){
$('.headerbtn_list li a').each(function(){  
if($($(this))[0].href==String(window.location)){  
$(this).parent().addClass('active');  
}     
}); 
}); 
</script>
</head>
<body><div class="mainbox mainborder">
<div class="section">
<table class="formtable">
<tr>
<td class="title">{$P8LANG['operation']}</td>
</tr>
<tr>
<td class="headerbtn_list">
<ul>
<li><a href="{$core->admin_controller}/core-base_config">{$P8LANG['base_config']}</a></li>
<li><a href="{$core->admin_controller}/core-global_config">{$P8LANG['total_config']}</a></li>
<li><a href="{$core->admin_controller}/core-mobile_config">{$P8LANG['mobile_config']}</a></li>
<li><a href="{$core->admin_controller}/core-aboutlogin">后台登陆设置</a></li>
<li><a href="{$core->admin_controller}/core-reg_config">{$P8LANG['reg_config']}</a></li>
<li><a href="{$core->admin_controller}/cms/item-config">静态与内容设置</a></li>
<li><a href="{$core->admin_controller}/cms/item-attribute_acl">权限设置</a></li>
<li><a href="{$core->admin_controller}/core/member-config">会员登陆验证码</a></li>
<li><a href="{$core->admin_controller}/core-word_filter">安全设置</a></li>
</ul>
</td>
</tr>
</table>
</div>
</div><script type="text/javascript" src="{$RESOURCE}/js/upload.js"></script>
<form action="$this_url" method="post">
<div class="mainbox mainborder">
<div class="section">
<table class="columntable formtable hover_table">
<tr>
<td colspan="2" class="title">{$P8LANG['base_config']}</td>
</tr>
<tr>
<td class="tdL">{$P8LANG['site_name']}</td>
<td class="tdR">
<input type="text" class="txt" name="config[site_name]" size="38"  value="
EOT;
if(!empty($config['site_name'])){
print <<<EOT
{$config['site_name']}
EOT;
}
print <<<EOT
" />
</td>
</tr>
<tr>
<td class="tdL">{$P8LANG['which_system_to_index']}</td>
<td class="tdR">
<select name="config[index_system]">
<option value="">{$P8LANG['default']}</option>
EOT;
$__t_foreach = @$core->systems;
if(!empty($__t_foreach)){
foreach($__t_foreach as $system => $v){
print <<<EOT

<option value="$system"
EOT;
if(!empty($config['index_system']) && $config['index_system'] == $system){
print <<<EOT
 selected
EOT;
}
print <<<EOT
>
$v[alias]
</option>
EOT;
}
}

print <<<EOT

</select>
</td>
</tr>
<tr>
<td class="tdL">{$P8LANG['site_key_word']}</td>
<td class="tdR">
<input type="text" class="txt" name="config[site_key_word]" size="50"  value="
EOT;
if(!empty($config['site_key_word'])){
print <<<EOT
{$config['site_key_word']}
EOT;
}
print <<<EOT
"/> {$P8LANG['explode_width_dot']}
</td>
</tr>
<tr>
<td class="tdL">{$P8LANG['site_description']}</td>
<td class="tdR">
<textarea  name="config[site_description]" cols="47" rows="5" class="textarea" >
EOT;
if(!empty($config['site_description'])){
print <<<EOT
{$config['site_description']}
EOT;
}
print <<<EOT
</textarea>
</td>
</tr>
<tr>
<td class="tdL">{$P8LANG['logo']}</td>
<td class="tdR" id="up">
<span id="u">
<input type="text" class="txt" name="config[logo]" id="logo_img" size="38"  value="
EOT;
if(!empty($config['logo'])){
print <<<EOT
{$config['logo']}
EOT;
}
print <<<EOT
" />
<input type="button" onclick="imgupload.choseup()" value="{$P8LANG['upload']}" class="u" />
</span>
<a href="http://www.55.la" target="_blank" style="padding-left:20px;">{$P8LANG['make_logo_online']}<img src="{$RESOURCE}/skin/admin/jj.png" /></a>

</td>
</tr>
<tr>
<td class="tdL">{$P8LANG['admin_email']}</td>
<td class="tdR">
<input type="text" class="txt" name="config[admin_email]" size="38"  value="
EOT;
if(!empty($config['admin_email'])){
print <<<EOT
{$config['admin_email']}
EOT;
}
print <<<EOT
"/>
</td>
</tr>
<tr>
<td class="tdL">{$P8LANG['site_url']}</td>
<td class="tdR">
<input type="text" class="txt" name="config[url]" size="38"  value="
EOT;
if(!empty($config['url'])){
print <<<EOT
{$config['url']}
EOT;
}
print <<<EOT
" />
</td>
</tr>
<tr>
<td class="tdL">{$P8LANG['base_domain']} <span class="help">网络安装时，自动获取基域名到框中.当启用多个域名或二级域名时候，对cookie产生作用。
与网站地址一样，不加http://。格式：php168.net</span></td>
<td class="tdR">
<input type="text" class="txt" name="config[base_domain]" size="38"  value="
EOT;
if(!empty($config['base_domain'])){
print <<<EOT
{$config['base_domain']}
EOT;
}
print <<<EOT
" /><span class="point">(如php168.net)</span>
</td>
</tr>

<tr>
<td class="tdL">{$P8LANG['site_open']}</td>
<td class="tdR">
<input type="radio" name="config[site_open]" value="1"
EOT;
if(!empty($config['site_open'])){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 />
{$P8LANG['Y']}
<input type="radio" name="config[site_open]" value="0"
EOT;
if(empty($config['site_open'])){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 />
{$P8LANG['N']}<br />
</td>
</tr>
<tr>
<td class="tdL">{$P8LANG['site_close_reason']}</td>
<td class="tdR">
<input name="config[site_close_reason]" size="38" class="txt"  value="
EOT;
if(!empty($config['site_close_reason'])){
print <<<EOT
{$config['site_close_reason']}
EOT;
}else{
print <<<EOT
网站正在维护中...
EOT;
}
print <<<EOT
"/>
</td>
</tr>
<tr>
<td class="tdL">{$P8LANG['copyright']}</td>
<td class="tdR">
<input type="text" class="txt" size="38"  name="config[copyright_domain]" value="
EOT;
if(!empty($config['copyright_domain'])){
print <<<EOT
{$config['copyright_domain']}
EOT;
}
print <<<EOT
"/>
</td>
</tr>
<tr>
<td class="tdL">{$P8LANG['statistics']}</td>
<td class="tdR">
<textarea name="config[copyright]" cols="47" rows="5">
EOT;
if(!empty($config['copyright'])){
print <<<EOT
{$config['copyright']}
EOT;
}
print <<<EOT
</textarea>
</td>
</tr>
<tr>
<td class="tdL">统计代码</td>
<td class="tdR">
<textarea name="config[statistics]" cols="47" rows="5">
EOT;
if(!empty($config['statistics'])){
print <<<EOT
{$config['statistics']}
EOT;
}
print <<<EOT
</textarea><span class="point">你可以向<a href="http://www.cnzz.com/" style="color:red" target="_blank">CNZZ官方</a>申请统计代码，然后将申请到的统计代码复制到此框内</span>
</td>
</tr>
<tr>
<td class="tdL">&nbsp;</td>
<td class="tdR">
<input type="submit" value="{$P8LANG['submit']}" class="submit_btn"/>
</td>
</tr>
</table>
</div>
</div>
</form>
<script type="text/javascript">
var imgupload = new P8_Upload({
element: {
src: $('#logo_img'),
attribute: 'value'
},
param: {
filter: {
gif: 1024000,
jpg: 1024000
}
}
});
</script><div class="clear"></div>

</body>
</html>
EOT;
?>