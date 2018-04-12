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
<li><a href="{$core->admin_controller}/core-allow_ip">后台登陆ip限定</a></li>
<li><a href="{$core->admin_controller}/core-stop_ip">IP黑名单</a></li>
<li><a href="{$core->admin_controller}/core-word_filter">词语过滤</a></li>
<li><a href="{$core->admin_controller}/core-md5_files">文件改动扫描</a></li>
<li><a href="{$core->admin_controller}/core-global_config">后台路径/验证码/安全码设置</a></li>
<li><a href="{$core->admin_controller}/core-aboutlogin">登陆失败设置</a></li>
</ul>
</td>
</tr>

</table>
</div>
</div>
<form action="$this_url" method="post" id="form">
<div class="mainbox mainborder">
<div class="section">
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr><td>
<table class="columntable formtable hover_table">
<tr>
<td colspan="3" class="title">IP禁止设置</td>
</tr>
<tr>
<td class="tdL">是否启用IP禁止:</td>
<td class="tdL">
<input type="radio" name="config[stop_ip][enabled]" value="1" 
EOT;
if(!empty($config['stop_ip']['enabled'])){
print <<<EOT
 checked
EOT;
}
print <<<EOT
/>开启
<input type="radio" name="config[stop_ip][enabled]" value="0" 
EOT;
if(empty($config['stop_ip']['enabled'])){
print <<<EOT
 checked
EOT;
}
print <<<EOT
/>不开启
</td>
<td class="tdR">&nbsp;</td>
</tr>
<tr>
<td class="tdL">禁止IP:</td>
<td class="tdL">
<textarea cols="30" rows="5" name="config[stop_ip][forbidip]">

EOT;
if(!empty($config['stop_ip']['forbidip'])){
$__t_foreach = @$config['stop_ip']['forbidip'];
if(!empty($__t_foreach)){
foreach($__t_foreach as $key => $value){
print <<<EOT
$key

EOT;
}
}
}
print <<<EOT
</textarea>
</td>
<td class="tdR point">
你可以设置封掉设置过的IP访问网站前台和后台,每个IP换一行,书写格式如下：<br>
192.168.0.2<br>
192.168.1.5<br>
...<br>
192.168.0 格式表示限制所有192.168.0.0--192.168.0.254段的IP<br />
注意:这里会同时禁止访问前台与后台,请不要封自己的IP,否则很麻烦
</td>
</tr>
<tr>
<td class="tdL">禁止IP段:</td>
<td align="right" class="tdL">
<input name="config[stop_ip][beginip]" type="text"  class="txt" id="" value="
EOT;
if(!empty($config['stop_ip']['beginip'])){
print <<<EOT
{$config['stop_ip']['beginip']}
EOT;
}
print <<<EOT
" size="33" />
</td>
<td class="tdR">
-- <input id="" type="text" class="txt" name="config[stop_ip][endip]" value="
EOT;
if(!empty($config['stop_ip']['endip'])){
print <<<EOT
{$config['stop_ip']['endip']}
EOT;
}
print <<<EOT
" /> 
<span class="point">例如：192.168.0.2-192.168.0.111</span>
</td>
</tr>
</table>
</td></tr>
</table>
<input type="submit" value="保存设置" class="submit_btn" style="margin-left:5px;margin-top:10px;" />
</div>
</div>
</form><div class="clear"></div>

</body>
</html>
EOT;
?>