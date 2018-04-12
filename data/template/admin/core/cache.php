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
<li><a href="{$core->admin_controller}/core-cache">一键缓存</a></li>
<li><a href="{$core->admin_controller}/cms-html_all">一键静态</a></li>
</ul>
</td>
</tr>

</table>
</div>
</div>
<form action="$this_url" method="POST">
<div class="mainbox mainborder">
<div class="section">
<table class="formtable">
<tr>
<td class="title">{$P8LANG['update_cache']}</td>
</tr>
<tr>
<td class="headerbtn_list" align="center">
<input type="submit" value="{$P8LANG['cache_all']}" class="cache_btn cache_one" />
<input type="submit" value="{$P8LANG['cache_unlock']}" onclick="this.form.type.value='unlock'" class="cache_btn cache_two" />
</td>
</tr>
</table>
</div>
</div>
<div class="mainbox mainborder">
<div class="section">
<table class="formtable">
<tr>
<td class="title">{$P8LANG['update_cache']}</td>
</tr>

<tr>
<td class="headerbtn_list" align="center">
<p><input type="submit" value="{$P8LANG['cache_index']}" class="cache_btn2" onclick="this.form.type.value='index'" size="30"/> </p>
<p><input type="submit" value="{$P8LANG['clear_page_cache']}" class="cache_btn2" onclick="this.form.type.value='page_cache'" /><span class="ab_c">{$P8LANG['cache_note_1']}</span></p>
<p><input type="submit" value="{$P8LANG['cache_template']}" class="cache_btn2" onclick="this.form.type.value='template'" size="30"/> </p>
<p><input type="submit" value="{$P8LANG['cache_label']}" class="cache_btn2" onclick="this.form.type.value='label'" size="30"/><span class="ab_c">{$P8LANG['cache_note_2']}</span></p>
<p><input type="submit" value="{$P8LANG['cache_menu']}" class="cache_btn2" onclick="this.form.type.value='menu'" size="30"/> </p>
<p><input type="submit" value="{$P8LANG['cache_language']}" class="cache_btn2" onclick="this.form.type.value='language'" /><span class="ab_c">如果你开启了memcache,你修改了语言包需要更新此缓存</span></p>
<p><input type="submit" value="{$P8LANG['cache_system_module']}" class="cache_btn2" onclick="this.form.type.value='system_module'" /></p> 

<input type="hidden" name="type" value="all" /> </td>
</tr>
</table>
</div>
</div>

</form><div class="clear"></div>

</body>
</html>
EOT;
?>