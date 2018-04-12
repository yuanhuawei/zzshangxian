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
<td class="title">{$P8LANG['quest_do']}</td>
</tr>
<tr>
<td class="headerbtn_list">
<ul>
<li class="li1"><a href="{$core->admin_controller}/$SYSTEM-log">所有操作日志 </a></li>
<li class="li1"><a href="{$core->admin_controller}/$SYSTEM-log?system=core">模块操作日志 </a></li>
EOT;
$__t_foreach = @$list_systems;
if(!empty($__t_foreach)){
foreach($__t_foreach as $k => $v){
if($v['installed'] && $v['enabled']){
print <<<EOT

<li class="li2 
EOT;
echo $system==$k?'active':'';
print <<<EOT
"><a href="{$core->admin_controller}/$SYSTEM-log?system=$k">{$v['alias']}日志</a></li>
EOT;
}
}
}

print <<<EOT

</ul>
</td>
</tr>
</table>
</div>
</div>
EOT;
if($list_modules){
print <<<EOT

<div class="mainbox mainborder">
<div class="section">
<table class="formtable">
<tr>
<td class="title">模块操作日志</td>
</tr>
<tr>
<td class="headerbtn_list">
<ul>
EOT;
$__t_foreach = @$list_modules;
if(!empty($__t_foreach)){
foreach($__t_foreach as $k => $v){
if($v['installed'] && $v['enabled']){
print <<<EOT

<li class="li2"><a href="{$core->admin_controller}/$SYSTEM-log?keyword=/$system/$k">{$v['alias']}日志</a></li>
EOT;
}
}
}

print <<<EOT

</ul>
</td>
</tr>
</table>
</div>
</div>
EOT;
}
print <<<EOT

<div class="mainbox mainborder">
<div class="section">
<table class="formtable">
<tr>
<td class="title">{$P8LANG['search']}</td>
</tr>
<tr>
<td class="headerbtn_list">
<form action="$this_url" method="get" id="request" onsubmit="request_item(1);return false;">
<div class="mr20 fleft">
<span id="cids"></span>
<input type="button" value="操作筛选" class="screenbtn" onclick="category_dialog.show()" />
<input type="hidden" id="cid" name="cid" value="$cid" />
</div>
<div class="fleft">
<select name="order">
<option value="0" selected="selected">降序</option>
<option value="1">升序</option>
</select>
<select onchange="$('#cond').attr('name', this.value);">
<option value="keyword">按关键字</option>
<option value="username"
EOT;
if(!empty($username)){
print <<<EOT
 selected
EOT;
}
print <<<EOT
>按用户名</option>
</select>
<input type="text" class="txt" id="cond" size="15" 
EOT;
if(!empty($keyword)){
print <<<EOT
 name="keyword" value="$keyword"
EOT;
}elseif(!empty($id)){
print <<<EOT
name="id" value="
EOT;
echo implode(',', $id);
print <<<EOT
"
EOT;
}elseif(!empty($username)){
print <<<EOT
name="username" value="$username"
EOT;
}else{
print <<<EOT
 name="keyword"
EOT;
}
print <<<EOT
 />
<input type="submit" value="{$P8LANG['search']}" />
<input type="button" value="{$P8LANG['refresh']}" onclick="request_item(PAGE)" />
</div>
</form>
</td>
</tr>
</table>
</div>
</div>
<form action="$this_url" method="post" id="form">
<div class="mainbox mainborder">
<div class="section">
<table border="0" width="100%" cellpadding="0" cellspacing="0" >
<tr>
<td>
<table class="columntable formtable hover_table click_changeable">

<tr>
<td width="3%" class="title"><input type="checkbox" onclick="check_all(this, 'id[]', $('#form'));init_tr($('#form'));" /></td>
<td width="3%" class="title">ID</td>
<td width="5%" class="title">{$P8LANG['username']}</td>
<td width="10%" class="title">{$P8LANG['title']}</td>
<td width="20%" class="title">{$P8LANG['url']}</td>
<td width="8%" class="title">{$P8LANG['date']}</td>
<td width="8%" class="title">{$P8LANG['ip']}</td>
<td width="5%" class="title">{$P8LANG['operation']}</td>
</tr>
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
print <<<EOT

<tr>
<td><input type="checkbox" name="id[]" value="$value[id]" /></td>
<td>$value[id]</td>
<td><a href="$this_url?uid=$value[uid]">$value[username]</a></td>
<td><a href="###" onclick="view_log($value[id])">$value[title]</a></td>
<td>$value[url]</td>
<td>
EOT;
echo date('Y-m-d H:i:s', $value['timestamp']);
print <<<EOT
</td>
<td>$value[ip]</td>
<td>
<a href="###" onclick="view_log($value[id])">{$P8LANG['view']}</a>
</td>
</tr>
EOT;
}
}

print <<<EOT


</table>
</td>
</tr>
<tr>
<td class="pages" align="center">$pages</td>
</tr>
</table>
</div>
</div>
<input type="hidden" name="act" />

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="foot_btn">

</table>
</form>

<script type="text/javascript">

var view_dialog = new P8_Dialog({
width: 800,
height: 400
});
view_dialog.content.css({overflow: 'auto'});

function view_log(id){
$.ajax({
url: '$this_url',
data: {act: 'view', id: id},
beforeSend: function(){
ajaxing({});
},
success: function(s){
view_dialog.show();
view_dialog.content.html('<pre>'+ s +'</pre>');
ajaxing({action: 'hide'});
}
});
}

</script><div class="clear"></div>

</body>
</html>
EOT;
?>