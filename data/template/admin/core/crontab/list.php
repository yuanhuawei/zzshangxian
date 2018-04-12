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
<li><a href="{$core->admin_controller}/core/crontab-list">计划任务列表</a></li>
<li><a href="{$core->admin_controller}/core/crontab-add">添加计划任务</a></li>
</ul>
</td>
</tr>
</table>

</td></tr>
</table>
</div>
</div><form action="$this_url" method="POST">
<div class="mainbox mainborder">
<div class="section">
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr><td>

<table class="columntable formtable hover_table">
<tr class="title">
<td class="title">ID</td>
<td class="title">{$P8LANG['crontab_name']}</td>
<td class="title">{$P8LANG['crontab_script']}</td>
<td class="title">{$P8LANG['crontab_run_interval']}</td>
<td class="title">{$P8LANG['crontab_last_run_time']}</td>
<td class="title">{$P8LANG['crontab_next_run_time']}</td>
<td class="title">{$P8LANG['enabled']}</td>
<td class="title">{$P8LANG['operation']}</td>
</tr>
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
$value['last_run_time'] = $value['last_run_time'] ? date('Y-m-d H:i:s', $value['last_run_time']) : '-';
$value['next_run_time'] = date('Y-m-d H:i:s', $value['next_run_time']);
print <<<EOT

<tr>
<td>{$value['id']}</td>      
<td>{$value['name']}</td>
<td>{$value['script']}</td>
<td>
EOT;
switch($value['interval']){
case 'day':
$value['interval'] = $value['day'] . $P8LANG['day'] . $value['hour'] . $P8LANG['hour'] . $value['minute'] . $P8LANG['minute'];
break;

case 'week':
$value['interval'] = $P8LANG['week_'. $value['week']] . $value['hour'] . $P8LANG['hour'] . $value['minute'] . $P8LANG['minute'];
break;

case 'month':
$value['interval'] = $value['month'] . $P8LANG['month'] . $value['hour'] . $P8LANG['hour'] . $value['minute'] . $P8LANG['minute'];
break;

case 'hour':
$value['interval'] = $value['hour'] . $P8LANG['hour'] . $value['minute'] . $P8LANG['minute'];
break;

case 'minute':
$value['interval'] = $value['minute'] . $P8LANG['minute'];
break;
}
print <<<EOT

{$value['interval']}</td>
<td>{$value['last_run_time']}</td>
<td>{$value['next_run_time']}</td>
<td><img src="{$SKIN}/
EOT;
if(!empty($value['status'])){
print <<<EOT
check_yes.gif
EOT;
}else{
print <<<EOT
check_no.gif
EOT;
}
print <<<EOT
" /></td>
<td>
<a href="{$this_router}-update?id={$value['id']}">{$P8LANG['edit']}</a>
<a id="crontab_{$value['id']}" href="###" onclick="return _delete(this)">{$P8LANG['delete']}</a>
<input type="button" value="{$P8LANG['run_crontab']}" onclick="this.form.action='$this_router-run';this.form.id.value='{$value['id']}';this.form.submit();" />
</td>
</tr>
EOT;
}
}

print <<<EOT


</table>


</td></tr>
</table>
</div>
</div>
<div class="mainbox mainborder">
<div class="section">
{$P8LANG['crontab_lock_status']}:
EOT;
if($lock_status){
print <<<EOT

{$P8LANG['Y']}<br />id 为 $lock_status 的任务正在锁定中
{$P8LANG['you_should_unlock_crontab_lock']}
EOT;
}else{
print <<<EOT

{$P8LANG['N']}
EOT;
}
print <<<EOT

<input type="hidden" name="id" value="" />
<input type="button" class="submit_btn" value="{$P8LANG['crontab_unlock']}" onclick="this.form.action='$this_router-list';this.form.submit();" />
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

1、你可以开启、编辑、删除官方已经提供的计划任务，根据需要进行操作。<br>

2、如果你自己要添加个性化计划任务，需要将所编的计划任务程序文件用FTP上传至系统inc/crontab里面。<br>

3、官方将不定期的为大家提供各类计划任务功能，方便大家操作。<br>
</td>
</tr>				
</table>
</div>
</div>
<script type="text/javascript">
function _delete(obj){
if(!confirm('{$P8LANG['confirm_to_delete']}')) return;

$.ajax({
url: '$this_router-delete',
type: 'POST',
dataType: 'text',
data: {id: obj.id.replace(/[^0-9]/g, '')},
cache: false,
beforeSend: function(){
ajaxing({});
},
success: function(status){

ajaxing({action: 'hide'});

if(status == 1){
$(obj).parent().parent().remove();
}
}
});

return false;
}
</script><div class="clear"></div>

</body>
</html>
EOT;
?>