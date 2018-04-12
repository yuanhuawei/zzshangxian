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
<td class="title">操作管理</td>
</tr>
<tr><td class="headerbtn_list">
<ul>
<li><a href="$this_router-config">模块设置</a></li>
<li><a href="$this_router-list">信件管理</a></li>
</ul>
</td>
</tr>
</table>

</td></tr>
</table>
</div>
</div><div class="mainbox mainborder">
<div class="section">
<div id="tab_1" class="tab_box mtop">
<div class="head">
<span class="$class[0]"><a href="$this_router-list?status=0">处理中信件</a></span>
<span class="$class[3]"><a href="$this_router-list?status=3">已处理信件</a></span> 
</div>
</div>
</div>
</div>
<div class="mainbox mainborder">
<div class="section">
<table class="columntable formtable hover_table click_changeable" width="100%" style="text-align:center" >
<tr bgcolor="#eeeeee" class="title">
<td width="9%">编号</td>
<td width="8%">状态</td>
<td width="8%">来源</td>
<td width="34%">标题</td>
<td width="10%">部门/类型</td>
<td width="12%">提问时间</td>
<td width="12%">解决时间</td>
<td width="8%">操作</td>
</tr>
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $k => $v){
print <<<EOT

<tr>
<td>$v[number]</td>
<td>
EOT;
if($v['status']==0){
print <<<EOT

未受理 
EOT;
}elseif($v['status']==3){
print <<<EOT

已解决
EOT;
}else{
print <<<EOT

处理中
EOT;
}
print <<<EOT

</td>
<td>{$P8LANG['source_'.$v['source']]}</td>
<td><a href="{$this_module->controller}-view-id-{$v['id']}" target="_blank">$v[title]</a></td>
<td>{$cates['department'][$v['department']]['name']}/{$cates['type'][$v['type']]['name']}</td>
<td>
EOT;
echo date("Y-m-d H:i:s",$v['create_time']);
print <<<EOT

</td>
<td>
EOT;
if($v['solve_time']) echo date("Y-m-d H:i:s",$v['solve_time']);
print <<<EOT

</td>
<td><a href="{$this_module->controller}-view-id-{$v['id']}" target="_blank">查看</a> / <a href="$this_router-delete?id=$v[id]" onclick="javascript:return confirm('确定了')">删除</a></td>
</tr>
EOT;
}
}

print <<<EOT

<tr>
<td colspan="7" class="pages">{$pages}</td>
</tr>
</table>
</div>
</div>
<div class="mainbox mainborder">
<div class="section">
<form name="form" id="searchFrom" action="" method="post">
<table class="columntable formtable hover_table click_changeable" width="100%" style="text-align:center" >
<tr bgcolor="#eeeeee" class="title">
<td>搜索</td>
</tr>
<tr>
<td>

信件来源： <select name="source">
<option value="">全部</option>
<option value="1" 
EOT;
if($source==1){
print <<<EOT
selected
EOT;
}
print <<<EOT
>在线</option>
<option value="2" 
EOT;
if($source==2){
print <<<EOT
selected
EOT;
}
print <<<EOT
>邮箱</option>
<option value="3" 
EOT;
if($source==3){
print <<<EOT
selected
EOT;
}
print <<<EOT
>电话</option>
</select>问题编号：<input name="number" value="$number" type="text" /> 关键词：<input name="keyword" value="$keyword" type="text" /> 解决人：<input name="solve_name" value="$solve_name" type="text" /> <input type="hidden" name="act" value="search"/><input type="submit" value="搜索" />
</td>
</tr>
</table>
</form>
</div>
</div>
<script type="text/javascript">
function printthis(){
$('#searchFrom input[name="act"]').val('print');
$('#searchFrom').attr('target','_blank').submit();
}
function searchthis(){
$('#searchFrom input[name="act"]').val('search');
$('#searchFrom').attr('target','_self').submit();
}
</script>
EOT;
?>