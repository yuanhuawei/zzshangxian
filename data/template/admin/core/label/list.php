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
<body><script type="text/javascript" src="{$RESOURCE}/js/iColorPicker.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/core/label/label.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/upload.js"></script>
<div class="mainbox mainborder">
<div class="section">
<table class="formtable">
<tr>
<td class="title">{$P8LANG['operation']}</td>
</tr>
<tr><td class="headerbtn_list">
<ul>
<li><a href="{$core->admin_controller}/core/label-list?
EOT;
if(isset($_GET['holder'])){
print <<<EOT
$_GET[holder]
EOT;
}
print <<<EOT
">{$P8LANG['list_label']}</a></li>
<li><a href="{$core->admin_controller}/core/label-add?system=
EOT;
if(isset($system)){
print <<<EOT
$system
EOT;
}
print <<<EOT
&module=
EOT;
if(isset($module)){
print <<<EOT
$module
EOT;
}
print <<<EOT
&site=
EOT;
if(isset($site)){
print <<<EOT
$site
EOT;
}
print <<<EOT
&env=
EOT;
if(isset($env)){
print <<<EOT
$env
EOT;
}
print <<<EOT
">{$P8LANG['add_label']}</a></li>
<li><a href="{$core->admin_controller}/core/label-cache">{$P8LANG['update_cache']}</a></li>
EOT;
if(!empty($id)){
print <<<EOT

<li><a href="{$core->admin_controller}/core/label-add?id=$id&name=$data[name]&postfix=$data[postfix]&system=$data[system]&module=$data[module]&site=$data[site]&env=$data[env]&_referer=$HTTP_REFERER">更换选择其它设置</a></li>
<li><a href="{$core->admin_controller}/core/label-list?postfix=$data[postfix]&keyword=$data[name]">清空此标签数据</a></li>
EOT;
}
if(!empty($viewurl)){
print <<<EOT

<li ><a href="{$viewurl}" target="_blank">查看效果</a></li>
<li ><a href="{$viewurl}&edit_label=1">返回频道\\专题</a></li>
EOT;
}
print <<<EOT

</ul>
</td>
</tr>
</table>
</div>
</div>
<script type="text/javascript" src="{$RESOURCE}/js/rcalendar.js"></script>

<form id="searchForm" action="$this_url" method="GET">
<div class="mainbox mainborder">
<div class="section">
<table class="columntable formtable hover_table">
<tr>
<td class="title">{$P8LANG['label_scope']}</td>
</tr>

<tr>
<td class="headerbtn_list">
<ul>
<li><a href="$this_router-list?all=$all">{$P8LANG['all']}</a></li>
<li><a href="$this_router-list?system=core&all=$all">
EOT;
if('core' == $system){
print <<<EOT
<b>{$P8LANG['core']}</b>
EOT;
}else{
print <<<EOT
{$P8LANG['core']}
EOT;
}
print <<<EOT
</a></li>
EOT;
$__t_foreach = @$systems;
if(!empty($__t_foreach)){
foreach($__t_foreach as $k => $v){
print <<<EOT
	
<li><a href="$this_router-list?system=$k&all=$all">
EOT;
if($k == $system){
print <<<EOT
<b>{$v['alias']}</b>
EOT;
}else{
print <<<EOT
{$v['alias']}
EOT;
}
print <<<EOT
</a></li>
EOT;
}
}

print <<<EOT

</ul>
</td>
</tr>

<tr>
<td class="headerbtn_list">
<ul>
EOT;
$__t_foreach = @$modules;
if(!empty($__t_foreach)){
foreach($__t_foreach as $k => $v){
if(file_exists(PHP168_PATH . ($system == 'core' ? '' : $system) .'/modules/'. $k .'/admin/label.php')){
print <<<EOT

<li><a href="$this_router-list?system=$system&module=$k">
EOT;
if($k == $module){
print <<<EOT
<b>{$v['alias']}</b>
EOT;
}else{
print <<<EOT
{$v['alias']}
EOT;
}
print <<<EOT
</a></li>
EOT;
}
}
}

print <<<EOT

</ul>
</td>
</tr>

<tr>
<td class="headerbtn_list">
EOT;
if($sitesd){
print <<<EOT
站点别名<input type="text" name="site" class="txt" value="$site" size="10" />
EOT;
}
print <<<EOT
 
{$P8LANG['label_postfix']}<input type="text" name="postfix" class="txt" value="$postfix" size="10" />
{$P8LANG['label_name']}<input type="text" class="txt" name="keyword" value="$keyword" size="20" /> 
{$P8LANG['label_ttl']}<input type="text" class="txt" name="ttl[]" value="$ttl[0]" size="3" /> - <input type="text" class="txt" name="ttl[]" value="$ttl[1]" size="3" />
上次更新时间<input type="text" class="txt" name="last_update[]" value="$last_update[0]" size="10" onclick="rcalendar(this)" autocomplete="off" /> - <input type="text" class="txt" name="last_update[]" value="$last_update[1]" size="10" onclick="rcalendar(this)" autocomplete="off" />
ID<input type="text" class="txt" name="id" value="$id" size="5" /> 
<input type="submit" name="search" class="submit_btn" value="{$P8LANG['label_search']}" />
</td>
</tr>
</table>
</div>
</div>
<input type="hidden" name="system" value="$system" />
<input type="hidden" name="module" value="$module" />
</form>


<form action="$this_url" method="POST" id="form">
<div class="mainbox mainborder">
<div class="section">
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr><td>
<table class="columntable formtable hover_table click_changeable">
<tr class="title">
<td width="3%" class="title"><input type="checkbox" onclick="check_all(this, 'id[]'); init_tr($('#form'));" /></td>
<td width="5%" class="title">ID</td>
<td width="18%" class="title">{$P8LANG['label_name']}</td>
<td width="7%" class="title">{$P8LANG['label_scope']}</td>
<td width="10%" class="title">{$P8LANG['label_postfix']}</td>
EOT;
if($sitesd){
print <<<EOT
 
<td width="10%" class="title">站点</td>
EOT;
}
print <<<EOT

<td width="8%" class="title">{$P8LANG['label_last_update']}</td>
<td width="6%" class="title">{$P8LANG['label_cache']}</td>
<td width="10%" class="title">{$P8LANG['operation']}</td>
</tr>
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
print <<<EOT

<tr id="label_$value[id]">
<td><input type="checkbox" name="id[]" value="$value[id]" /></td>
<td>{$value['id']}</td>
<td id="name_$value[id]">
<a href="###" invoke="{$value['invoke']}" onclick="prompt('', $(this).attr('invoke'));" title="{$P8LANG['label_type'][$value['type']]}"><img src="{$_SKIN}/$MODULE/$value[type].gif" />
EOT;
if($value['variable']){
print <<<EOT
<font color="blue">{$value['name']}</font>
EOT;
}else{
print <<<EOT
{$value['name']}
EOT;
}
print <<<EOT
</a>
</td>
<td>{$value['system']}/{$value['module']}</td>
<td>{$value['postfix']}</td>
EOT;
if($sitesd){
print <<<EOT

<td>{$value['site']}</td>
EOT;
}
print <<<EOT

<td>
EOT;
if($value['last_update']){
echo date('Y-m-d H:i', $value['last_update']);
}
print <<<EOT
</td>
<td>{$value['ttl']}</td>
<td>
<a href="$this_router-copy?id={$value['id']}" target="_blank">{$P8LANG['copy']}</a>
<a href="$this_router-update?id={$value['id']}&fromurl=admin" target="_blank">{$P8LANG['edit']}</a>
EOT;
if($value['system']=='core' && $value['module']==''){
print <<<EOT
 <a href="###" onclick="showJs('{$value['name']}')">JS调用</a>
EOT;
}
print <<<EOT

</td>
</tr>
EOT;
}
}

print <<<EOT


</table>
</td></tr>


<tr>
<td colspan="10">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="foot_btn">
<tr>
<td align="center" id="pages" class="pages">$pages</td>
</tr>
<tr>
<td>
<input type="button" value="导入" onclick="import_dialog.show();" class="edit_btn" />
<input type="button" value="导出" onclick="_export()" class="edit_btn" />
<input type="button" value="导出所有" onclick="_exportall()" class="edit_btn" />
<input type="button" value="删除" onclick="delete_label()" class="edit_btn" />
<td>
</tr>
</table>
</td>
</tr>

</table>
</div>
</div>
<input type="hidden" name="act" value="" />
</form>

<script type="text/javascript">
function delete_label(){
var id = checked_values('id[]', $('#form'));

if(!id.length) return;

if(!confirm('{$P8LANG['confirm_to_delete']}')) return;

$.ajax({
url: '$this_router-delete',
type: 'POST',
dataType: 'json',
cache: false,
data: ajax_parameters({id: id}),
beforeSend: function(){
ajaxing({});
},
success: function(json){
ajaxing({action: 'hide'});

for(var i in json){
$('#label_'+ json[i]).remove();
}
}
});
return false;
}

function _export(){
var id = checked_values('id[]', $('#form'));

if(!id.length) return;

$('#form input[name=act]').val('export');
$('#form').submit();
}
function _exportall(){

$('#searchForm').append('<input type="hidden" name="exportall" value="1" />');
$('#searchForm').submit();
}

var import_dialog = new P8_Dialog({
title_text: '导入',
width: 400,
height: 300,
button: true,
ok: function(){
$.trim(this.content.find('textarea').appendTo($('#form')).val());

$('#form input[name=act]').val('import');
$('#form').submit();
}
});

var evaluate_dialog = new P8_Dialog({ 
title_text: '标签数据javascript调用', 
width: 350, 
height: 170, 
button:false
});
function showJs(name){
var shtml='<textarea rows="3" cols="50">\\<script type="text/javascript" src="{$core->url}/api/lbjs.php?n='+name+'"\\>\\</script\\></textarea>';
shtml +='<br/><span style="color:red">注意：js调用的标签，【系统】必须是“核心”，【模块】必须为无,【标签后缀】必须为空，否则会不能正常显示！</span><br/>';
shtml +='<p style="text-align:center"><input type="button" class="submit_btn" value=" 关闭 " onclick="evaluate_dialog.close()"/></p>';
evaluate_dialog.show();        
evaluate_dialog.content.html(shtml);
}
import_dialog.content.append($('<textarea name="data" style="width: 380px; height: 220px;"></textarea>'));
</script><div class="clear"></div>

</body>
</html>
EOT;
?>