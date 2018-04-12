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
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr><td>
<table class="formtable">
<tr>
<td class="title">{$P8LANG['operation']}</td>
</tr>
<tr><td class="headerbtn_list">
<ul>
<li><a href="{$core->admin_controller}/core/uploader-config">模块配置</a></li>
<li><a href="{$core->admin_controller}/core/uploader-list">附件管理</a></li>
<li><a href="{$core->admin_controller}/core/uploader-role_filter">上传权限</a></li>
</ul>
</td>
</tr>
</table>

</td></tr>
</table>
</div>
</div><form action="$this_url" method="post">
<div class="mainbox mainborder">
<div class="section">
<table border="0" width="100%" cellpadding="0" cellspacing="0" >
<tr><td>
<table class="formtable hover_table">
<tr>
<td colspan="2" class="title">{$P8LANG['uploader_config']}</td>
</tr>

<tr>
<td class="tdL">
{$P8LANG['bind_domain']}
</td>
<td class="tdR">
<input type="text" class="txt" name="config[domain]" value="
EOT;
if(!empty($config['domain'])){
print <<<EOT
{$config['domain']}
EOT;
}
print <<<EOT
" size="60" />
<span class="help">{$P8LANG['bind_upload_domain_note']}</span>
</td>
</tr>

<tr>
<td class="tdL">是否开启缩略图</td>
<td class="tdR">
<input type="radio" name="config[thumb][enabled]" value="1"
EOT;
if(!empty($config['thumb']['enabled'])){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 />{$P8LANG['Y']}
<input type="radio" name="config[thumb][enabled]" value="0"
EOT;
if(empty($config['thumb']['enabled'])){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 />{$P8LANG['N']}
</td>
</tr>

<tr>
<td class="tdL">缩略图大小</td>
<td class="tdR">
<input type="text" class="txt" name="config[thumb][width]" value="
EOT;
if(!empty($config['thumb']['width'])){
print <<<EOT
{$config['thumb']['width']}
EOT;
}else{
print <<<EOT
100
EOT;
}
print <<<EOT
" size="3" />
x
<input type="text" class="txt" name="config[thumb][height]" value="
EOT;
if(!empty($config['thumb']['height'])){
print <<<EOT
{$config['thumb']['height']}
EOT;
}else{
print <<<EOT
100
EOT;
}
print <<<EOT
" size="3" />
</td>
</tr>

<tr>
<td class="tdL">内容页缩略图大小</td>
<td class="tdR">
<input type="text" class="txt" name="config[cthumb][width]" value="
EOT;
if(!empty($config['cthumb']['width'])){
print <<<EOT
{$config['cthumb']['width']}
EOT;
}else{
print <<<EOT
600
EOT;
}
print <<<EOT
" size="3" />
x
<input type="text" class="txt" name="config[cthumb][height]" value="
EOT;
if(!empty($config['cthumb']['height'])){
print <<<EOT
{$config['cthumb']['height']}
EOT;
}else{
print <<<EOT
450
EOT;
}
print <<<EOT
" size="3" />
</td>
</tr>

<tr>
<td class="tdL">缩略图质量</td>
<td class="tdR">
<input type="text" class="txt" name="config[thumb][quality]" value="
EOT;
if(!empty($config['thumb']['quality'])){
print <<<EOT
{$config['thumb']['quality']}
EOT;
}else{
print <<<EOT
75
EOT;
}
print <<<EOT
" size="3" /> %
</td>
</tr>

<tr>
<td class="tdL">是否开启水印</td>
<td class="tdR">
<input type="radio" name="config[watermark][enabled]" value="1"
EOT;
if(!empty($config['watermark']['enabled'])){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 />{$P8LANG['Y']}
<input type="radio" name="config[watermark][enabled]" value="0"
EOT;
if(empty($config['watermark']['enabled'])){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 />{$P8LANG['N']}
</td>
</tr>

<tr>
<td class="tdL">水印文件</td>
<td class="tdR">
<input type="text" class="txt" name="config[watermark][file]" value="
EOT;
if(!empty($config['watermark']['file'])){
print <<<EOT
{$config['watermark']['file']}
EOT;
}else{
print <<<EOT
mark.gif
EOT;
}
print <<<EOT
" />
</td>
</tr>

<tr>
<td class="tdL">水印位置</td>
<td class="tdR">
<table>
<tr>
<td><input type="radio" name="config[watermark][position]" value="7"
EOT;
if($config['watermark']['position'] == 7){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 /></td>
<td><input type="radio" name="config[watermark][position]" value="8"
EOT;
if($config['watermark']['position'] == 8){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 disabled /></td>
<td><input type="radio" name="config[watermark][position]" value="9"
EOT;
if($config['watermark']['position'] == 9){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 /></td>
</tr>
<tr>
<td><input type="radio" name="config[watermark][position]" value="4"
EOT;
if($config['watermark']['position'] == 4){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 disabled /></td>
<td><input type="radio" name="config[watermark][position]" value="5"
EOT;
if($config['watermark']['position'] == 5){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 /></td>
<td><input type="radio" name="config[watermark][position]" value="6"
EOT;
if($config['watermark']['position'] == 6){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 disabled /></td>
</tr>
<tr>
<td><input type="radio" name="config[watermark][position]" value="1"
EOT;
if($config['watermark']['position'] == 1){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 /></td>
<td><input type="radio" name="config[watermark][position]" value="2"
EOT;
if($config['watermark']['position'] == 2){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 disabled /></td>
<td><input type="radio" name="config[watermark][position]" value="3"
EOT;
if($config['watermark']['position'] == 3){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 /></td>
</tr>
</table>
</td>
</tr>

<tr>
<td class="tdL">水印质量</td>
<td class="tdR">
<input type="text" class="txt" name="config[watermark][quality]" value="
EOT;
if(!empty($config['watermark']['quality'])){
print <<<EOT
{$config['watermark']['quality']}
EOT;
}else{
print <<<EOT
75
EOT;
}
print <<<EOT
" size="3" /> %
</td>
</tr>

<tr id="filter">
<td class="tdL">{$P8LANG['upload_filter_config']}</td>
<td class="tdR">
<div id="data_copy" style="display: none;">
类型 <input type="text" class="txt" name="" size="5" /> ,  
大小 <input type="text" class="txt" name="" size="5" value="" /> K
<input type="button" value="{$P8LANG['delete']}" />
</div>
<input type="button" value="添加附件类型" onclick="_copy_data()" />
<script type="text/javascript">
function _copy_data(ext, size){
var copy = $('#data_copy').clone().show().attr('id', '');

$('input:eq(0)', copy).attr('name', 'filter[ext][]').val(ext === undefined ? '' : ext);
$('input:eq(1)', copy).attr('name', 'filter[size][]').val(size === undefined ? '' : size);

copy.find('input[type=button]').
attr('onclick', '').
click(function(){
$(this).parent().remove();
});

$('#filter div:last').after(copy);
}

$(document).ready(function(){
EOT;
if(!empty($filter)){
$__t_foreach = @$filter;
if(!empty($__t_foreach)){
foreach($__t_foreach as $ext => $size){
print <<<EOT

_copy_data('$ext', '$size');
EOT;
}
}
}
print <<<EOT

});
</script>
</td>
</tr>

<tr>
<td class="tdL">{$P8LANG['ftp_enabled']}</td>
<td class="tdR">
<input type="radio" name="config[ftp_config][enabled]" value="1" onclick="show_ftp_config(this.value)"
EOT;
if(!empty($config['ftp_config']['enabled'])){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 />{$P8LANG['Y']}
<input type="radio" name="config[ftp_config][enabled]" value="0" onclick="show_ftp_config(this.value)"
EOT;
if(empty($config['ftp_config']['enabled'])){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 />{$P8LANG['N']}
<span style="color:#999999;padding-left:10px">属于高端应用，一般不作设置</span>
</td>
</tr>

<tbody id="ftp_config">
<th colspan="2">{$P8LANG['ftp_config']}</th>

<tr>
<td class="tdL">{$P8LANG['ftp_host']}</td>
<td class="tdR">
<input id="ftp_host" type="text" class="txt" name="config[ftp_config][host]" value="
EOT;
if(!empty($this_module->CONFIG['ftp_config']['host'])){
print <<<EOT
{$this_module->CONFIG['ftp_config']['host']}
EOT;
}else{
print <<<EOT
localhost
EOT;
}
print <<<EOT
" />
</td>
</tr>

<tr>
<td class="tdL">{$P8LANG['ftp_port']}</td>
<td class="tdR">
<input id="ftp_port" type="text" class="txt" name="config[ftp_config][port]" value="
EOT;
if(!empty($this_module->CONFIG['ftp_config']['port'])){
print <<<EOT
{$this_module->CONFIG['ftp_config']['port']}
EOT;
}else{
print <<<EOT
21
EOT;
}
print <<<EOT
" />
</td>
</tr>

<tr>
<td class="tdL">{$P8LANG['ftp_user']}</td>
<td class="tdR">
<input id="ftp_user" type="text" class="txt" name="config[ftp_config][user]" value="
EOT;
if(!empty($this_module->CONFIG['ftp_config']['user'])){
print <<<EOT
{$this_module->CONFIG['ftp_config']['user']}
EOT;
}else{
print <<<EOT
user
EOT;
}
print <<<EOT
" />
</td>
</tr>

<tr>
<td class="tdL">{$P8LANG['ftp_password']}</td>
<td class="tdR">
<input id="ftp_password" type="password" class="txt" name="config[ftp_config][password]" value="
EOT;
if(isset($this_module->CONFIG['ftp_config']['password'])){
print <<<EOT
{$this_module->CONFIG['ftp_config']['password']}
EOT;
}else{
print <<<EOT
password
EOT;
}
print <<<EOT
" />
</td>
</tr>

<tr>
<td class="tdL">{$P8LANG['ftp_dir']}</td>
<td class="tdR">
<input id="ftp_dir" type="text" class="txt" name="config[ftp_config][dir]" value="
EOT;
if(!empty($this_module->CONFIG['ftp_config']['dir'])){
print <<<EOT
{$this_module->CONFIG['ftp_config']['dir']}
EOT;
}else{
print <<<EOT
/
EOT;
}
print <<<EOT
" />
</td>
</tr>

<tr>
<td class="tdL">ssl</td>
<td class="tdR">
<input type="radio" name="config[ftp_config][ssl]" value="1"
EOT;
if(!empty($config['ftp_config']['ssl'])){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 />{$P8LANG['Y']}
<input type="radio" name="config[ftp_config][ssl]" value="0"
EOT;
if(empty($config['ftp_config']['ssl'])){
print <<<EOT
 checked
EOT;
}
print <<<EOT
 />{$P8LANG['N']}

</td>
</tr>

<tr>
<td class="tdL">timeout</td>
<td class="tdR">
<input id="ftp_dir" type="text" class="txt" name="config[ftp_config][timeout]" value="
EOT;
if(!empty($this_module->CONFIG['ftp_config']['timeout'])){
print <<<EOT
{$this_module->CONFIG['ftp_config']['timeout']}
EOT;
}
print <<<EOT
" />
</td>
</tr>

<tr>
<td class="tdL"><input type="button" value="{$P8LANG['test_ftp']}" onclick="test_ftp()" /></td>
<td class="tdR">
<div id="ftp_test_result"></div>
</td>
</tr>

</tbody>

<script type="text/javascript">
function show_ftp_config(v){
if(v == 1)
$('#ftp_config').show()
else
$('#ftp_config').hide();
}

function test_ftp(){
$.ajax({
url: '$this_router-test_ftp',
dataType: 'json',
type: 'post',
cache: false,
data: {
host: $('#ftp_host').val(),
port: $('#ftp_port').val(),
user: $('#ftp_user').val(),
password: $('#ftp_password').val(),
dir: $('#ftp_dir').val()
},
beforeSend: function(){
ajaxing({});
},
success: function(json){
ajaxing({action: 'hide'});
var result = '';
var str;
if(json.connect == 0){
str = 'Yes';
}else if(json.connect == -1){
str = '{$P8LANG['ftp_test_connect_fail']}';
}else if(json.connect == -2){
str = '{$P8LANG['ftp_test_login_fail']}';
}

result += '{$P8LANG['ftp_test_connect']}: '+ str +'<br />';
result += '{$P8LANG['ftp_test_mkdir']}: '+ (json.mkdir ? 'Yes' : 'No') +'<br />';
result += '{$P8LANG['ftp_test_put']}: '+ (json.put ? 'Yes' : 'No') +'<br />';
result += '{$P8LANG['ftp_test_delete']}: '+ (json['delete'] ? 'Yes' : 'No') +'<br />';
result += '{$P8LANG['ftp_test_rmdir']}: '+ (json.rmdir ? 'Yes' : 'No') +'<br />';

$('#ftp_test_result').html(result);
}
});
}

show_ftp_config(
EOT;
if(!empty($config['ftp_config']['enabled'])){
print <<<EOT
1
EOT;
}else{
print <<<EOT
0
EOT;
}
print <<<EOT
);
</script>
<tr>
<td class="tdL">&nbsp;</td>
<td class="tdR"><input type="submit" value="{$P8LANG['submit']}" class="submit_btn"/></td>
</tr>

</table>
</td>
</tr>
</table>
</div>
</div>
</form>
<div class="mainbox mainborder">
<div class="section">
<table class="formtable">
<tr>
<td class="title">{$P8LANG['help_about']}</td>
</tr>
<tr>
<td class="headerbtn_list">
1、本系统主要设定关于图片类、附件类的常规应用设置。<br>

2、“是否开启缩略图”---每上传的一个图片，系统自动为他生成一张缩略图。
</td>
</tr>

</table>
</div>
</div><div class="clear"></div>

</body>
</html>
EOT;
?>