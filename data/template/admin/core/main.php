<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台管理  powerby www.php168.net</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<link rel="stylesheet" href="{$RESOURCE}/skin/admin/common.css" type="text/css">
<link rel="stylesheet" href="{$RESOURCE}/skin/admin/style.css" type="text/css">
<script type="text/javascript" src="{$RESOURCE}/js/config.js"></script>
<script type="text/javascript" src="{$RESOURCE}/js/util.js"></script>
</head>
<body>
<script type="text/javascript">
var cache_action = "{$core->admin_controller}/core-cache";
var index_html_action = "{$core->admin_controller}/cms-index_to_html";
var index_html_m_action = "{$core->admin_controller}/cms-index_to_html";
var item_view_action = "{$core->admin_controller}/cms/item-view_to_html";
var item_list_action = "{$core->admin_controller}/cms/item-list_to_html";
var label_action = "{$core->admin_controller}/core/label-cache";
var category_action = "{$core->admin_controller}/cms/category-cache";
var special_html = "{$core->admin_controller}/core/special-view_to_html";
var _obj = new Date(
EOT;
echo P8_TIME;
print <<<EOT
000);
var _Y = _obj.getFullYear();
var _m = _obj.getMonth() +1;
var _d = _obj.getDate();
var _H = _obj.getHours();
var _j = _obj.getDay();
</script>
<div class="wrapper">
<div class="statusList">
<div class="stsitem">
<div class="panel">
<div class="sico"><i class="ione"></i></div>
<div class="value">
<div class="vinfo">
<a href="{$core->admin_controller}/cms/item-list"><h1>{$countCmsToday['count']}/{$countCmsMonth['count']}条</h1></a>
<p>今日/本月主站内容</p>
</div>
</div>
</div>
</div>
<div class="stsitem">
<div class="panel">
<div class="sico"><i class="itwo"></i></div>
<div class="value">
<div class="vinfo">
<a href="#"><h1>{$countCmsUnverified['count']}条</h1></a>
<p>待审主站内容</p>
</div>
</div>
</div>
</div>
<div class="stsitem">
<div class="panel">
<div class="sico"><i class="ithree"></i></div>
<div class="value">
<div class="vinfo">
<a href="#"><h1>{$countSitesToday['count']}/{$countSitesMonth['count']}条</h1></a>
<p>今日/本月站群内容</p>
</div>
</div>
</div>
</div>
<div class="stsitem">
<div class="panel">
<div class="sico"><i class="ifour"></i></div>
<div class="value">
<div class="vinfo">
<a href="#"><h1>{$countSitesUnverified['count']}条</h1></a>
<p>待审站群内容</p>
</div>
</div>
</div>
</div>
</div>
<div class="mainbox">
<table border="0" width="100%" cellpadding="0" cellspacing="0" >
<tr>
<td>
<table class="mintable fleft mbt15">
<tr>
<td>
<table class="formtable">
<tr>
<td>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="articletips">
<tr class="tips_title">
<td class="tips_time">时间</td>
<td class="tips_title">最新已审核内容</td>
<td class="tips_author">录入者</td>
<td class="tips_edit">操作</td>
</tr>
EOT;
$__t_foreach = @$listdb;
if(!empty($__t_foreach)){
foreach($__t_foreach as $val){
print <<<EOT

<tr>
<td align="center">
EOT;
echo date('m/d',$val[timestamp]);
print <<<EOT
</td>
<td class="main_link"><a href="$val[url]" target="_blank">&nbsp;$val[title]</a> </td>
<td align="center"><span title="$val[username]">
EOT;
echo p8_cutstr($val[username],8);
print <<<EOT
</span></td>
<td align="center"><a href="$val[edit]">修改</a></td>
</tr>
EOT;
}
}

print <<<EOT

</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
<table class="mintable fright mbt15">
<tr>
<td>
<table class="formtable">
<tr>
<td>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="articletips">
<tr class="tips_title">
<td class="tips_time">时间</td>
<td class="tips_title">最新待审内容</td>
<td class="tips_author">状态</td>
<td class="tips_author">录入者</td>
<td class="tips_edit">操作</td>
</tr>
EOT;
$__t_foreach = @$listdb2;
if(!empty($__t_foreach)){
foreach($__t_foreach as $val){
print <<<EOT

<tr>
<td align="center">
EOT;
echo date('m/d',$val[timestamp]);
print <<<EOT
</td>
<td class="main_link"><a href="$val[url]" target="_blank">&nbsp;$val[title]</a> </td>
<td align="center"><font style="color:red;">未审</font></td>
<td align="center"><span title="$val[username]">
EOT;
echo p8_cutstr($val[username],8);
print <<<EOT
</span></td>
<td align="center"><a href="$val[edit]">修改</a></td>
</tr>
EOT;
}
}

print <<<EOT

<tr>
<td align="right" colspan="5"><a href="{$core->admin_controller}/cms/item-list" target="main" class="submit_btn" style="font-size:14px;color:#fff;">进入审核内容</a></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
<div style="clear:both;">
</div>

<table class="mintable mfoot fleft mbt15">
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" class="formtable">
<tr>
<td>
<form method="POST" action="$this_url">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td class="tdL graybg">操作系统</td>
<td class="tdR">
EOT;
echo PHP_OS;
print <<<EOT

</td>
<td class="tdL">当前域名：</td>
<td class="tdR">$_SERVER[HTTP_HOST]</td>
</tr>
<tr> 
<td class="tdL graybg">服务器端信息</td>
<td colspan="3" class="tdR">$_SERVER[SERVER_SOFTWARE]</td>
</tr>
<tr>
<td class="tdL graybg">PHP程式版本</td>
<td colspan="3" class="tdR">
EOT;
echo PHP_VERSION;
print <<<EOT

</td>
</tr>
<tr>
<td class="tdL graybg">MYSQL 版本</td>
<td colspan="3" class="tdR">
EOT;
echo $db_version;
print <<<EOT

</td>
</tr>
<tr>
<td class="tdL graybg">最大上传限制</td>
<td colspan="3" class="tdR">
EOT;
echo ini_get('upload_max_filesize');
print <<<EOT

</td>
</tr>
<tr>
<td class="tdL graybg">最大执行时间</td>
<td colspan="3" class="tdR">
EOT;
echo ini_get('max_execution_time');
print <<<EOT

秒</td>
</tr>
<tr>
<td class="tdL graybg">图像GD支持</td>
<td colspan="3" class="tdR">
EOT;
if(function_exists('imagecreate')){
print <<<EOT

是
EOT;
}else{
print <<<EOT

否
EOT;
}
print <<<EOT

</td>
</tr>
<tr>
<td class="tdL graybg">memcache</td>
<td colspan="3" class="tdR">
EOT;
if(class_exists('Memcache')){
print <<<EOT

是
EOT;
}else{
print <<<EOT

否
EOT;
}
print <<<EOT

</td>
</tr>
<tr>
<td class="tdL graybg">eAccelerator</td>
<td colspan="3" class="tdR">
EOT;
if(extension_loaded('eaccelerator')){
print <<<EOT

是
EOT;
}else{
print <<<EOT

否
EOT;
}
print <<<EOT

</td>
</tr>
<tr>
<td class="tdL graybg">ssi</td>
<td colspan="3" class="tdR">
EOT;
if($core->CONFIG['ssi']){
print <<<EOT

是
EOT;
}else{
print <<<EOT

否
EOT;
}
print <<<EOT

<input type="submit" name="detect_ssi" value="重新检测" />
</td>
</tr>
</table>
</form>
</td>
</tr>
</table>
</td>
</tr>
</table>
<table class="mintable  mfoot fright mbt15">
<tr>
<td>
<table class="formtable">
<tr>
<td>
<div class="servertips">
<ul>
<li class="li1"><a href="{$core->admin_controller}/core/dbm-manage" target="main">数据备份</a></li>
<li class="li2"><a href="{$core->admin_controller}/core-template_system" target="main">模板选择</a></li>
<li class="li3"><a href="{$core->admin_controller}/core/role-list" target="main">会员/权限</a></li>
<li class="li4"><a href="{$core->admin_controller}/core-base_config" target="main">系统设置</a></li>
<li class="li5"><a href="{$core->admin_controller}/core-cache" target="main">系统缓存</a></li>
<li class="li6"><a href="{$core->admin_controller}/cms/category-list" target="main">内容静态</a></li>
</ul>
</div>
</td>
</tr>
</table>
</td>
</tr>
</table>
<div style="clear:both;">
</div>
</td>
</tr>
</table>
</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
function cache_update(){
obj = $('#cacheform');
var selected = obj.children("select");
switch(selected.val()){

case 'template':
obj.attr('action',cache_action);
obj.find('type').attr('type','template');
obj.submit();
break;

case 'index': 
obj.attr('action',cache_action);
obj.find('type').attr('type','index');
obj.submit();
break;

case 'language':
obj.attr('action',cache_action);
obj.find('type').attr('type','language');
obj.submit();
break;

case 'system_module':
obj.attr('action',cache_action);
obj.find('type').attr('type','system_module');
obj.submit();
break;

case 'all':
obj.attr('action',cache_action);
obj.find('type').attr('type','');
obj.submit();
break;

case 'category-cache':
obj.attr('action',category_action);;
obj.find('type').attr('type','');
obj.submit();
break;

case 'label-cache':
obj.attr('action',label_action);;
obj.find('type').attr('type','');
obj.submit();
break;
}
}

function html_update(obj){
var selected = $(obj).children("select");
switch(selected.val()){

case 'index_to_html':
obj.action = index_html_action;
obj.type.value = 'index_to_html';
obj.submit();
break;

case 'index_to_m_html':
obj.action = index_html_m_action;
obj.type.value = 'index_to_m_html';
obj.submit();
break;

case 'all_item':
obj.action = item_view_action;
obj.type.value = '';
obj.submit();
break;

case 'all_item_time':
obj.action = item_view_action;
obj.type.value = '';
$(obj).children("#timer_begin").val(date('Y-m-d H:i:s', mktime(0, 0, 0, _m, _d, _Y)));
$(obj).children("#timer_end").val(date('Y-m-d H:i:s', mktime(0, 0, 0, _m, _d+1, _Y)));
obj.submit();
break;

case 'all_list':
obj.action = item_list_action;
obj.type.value = '';
obj.submit();
break;

case 'all_list_time':
obj.action = item_list_action;
obj.type.value = '';
$(obj).children("#timer_begin").val(date('Y-m-d H:i:s', mktime(0, 0, 0, _m, _d, _Y)));
$(obj).children("#timer_end").val(date('Y-m-d H:i:s', mktime(0, 0, 0, _m, _d+1, _Y)));
obj.submit();
break;

case 'all_special':
obj.action = special_html;
obj.type.value = 'all';
obj.submit();
break;
}
}
EOT;
if(isset($cache)){
print <<<EOT

var p8_dialog = new P8_Dialog({
title_text: '温馨提醒',
button: false,
width: 300,
height: 200,
show: function(){
showhtml = '<p style="text-align:center;color:red;font-size:16px">你还没更新全站缓存<br><br><input type="button" value="马上更新缓存" class="header_r_btn" onclick="javascript:$(\\'#cacheform>select\\').val(\\'all\\');cache_update();"/></p>';
this.content.html(showhtml);
}
});
p8_dialog.show();
EOT;
}
print <<<EOT

</script>
<div class="footer">
<ul>
<li><a href="http://www.php168.net/html/aboutus.shtml" target="_blank">联系我们</a></li>
<li><a href="http://www.php168.net/html/ld.shtml" target="_blank">产品亮点</a></li>
<li class="footerweb"><a href="http://www.php168.net" target="_blank">官方网站</a></li>
</ul>
</div>
EOT;
if(isset($cache)){
print <<<EOT

<form name="cacheform" id= "cacheform" method="post" style="display:none;">
<select name="type">
<option value="template">模板缓存</option>
<option value="index">首页缓存</option>
<option value="language">语言包缓存</option>
<option value="system_module">模块缓存</option>
<option value="all">所有缓存</option>
<option value="category-cache">栏目缓存</option>
<option value="label-cache" selected>标签缓存</option>
</select>
<input type="button" value="执行" class="cachebtn" onclick="cache_update()"/>
</form>
EOT;
}
print <<<EOT
<div class="clear"></div>

</body>
</html>
EOT;
?>