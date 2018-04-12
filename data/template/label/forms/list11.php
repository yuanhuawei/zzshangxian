<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<table width="720px;" border="0" cellspacing="0" cellpadding="0" class="label_form_11" style="text-align:center">
<tr  height="18" class="head_title">
EOT;
$__t_foreach = @$option['fields'];
if(!empty($__t_foreach)){
foreach($__t_foreach as $field){
print <<<EOT

<td>{$this_model['fields'][$field]['alias']}</td>
EOT;
}
}

print <<<EOT

<td>发布时间</td>
<td>应聘</td>
</tr>
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $key => $value){
print <<<EOT

<tr id="item_$value[id]">
EOT;
$__t_foreach = @$option['fields'];
if(!empty($__t_foreach)){
foreach($__t_foreach as $field){
print <<<EOT

<td>
EOT;
if(!empty($value[$field]) && ($this_model['fields'][$field]['widget']=='radio' || $this_model['fields'][$field]['widget']=='select' || $this_model['fields'][$field]['widget']=='city')){
print <<<EOT

{$this_model['fields'][$field]['data'][$value[$field]]}
EOT;
}elseif(!empty($value[$field]) && ($this_model['fields'][$field]['widget']=='checkbox' || $this_model['fields'][$field]['widget']=='multi_select')){
$__t_foreach = @$value[$field];
if(!empty($__t_foreach)){
foreach($__t_foreach as $v){
print <<<EOT

{$this_model['fields'][$field]['data'][$v]}, 
EOT;
}
}
}elseif(!empty($value[$field]) && $this_model['fields'][$field]['widget']=='link'){
print <<<EOT

<a href="{$value[$field]}" target="
EOT;
if(!empty($this_model['fields'][$field]['widget']['data']['target'])){
print <<<EOT
{$this_model['fields'][$field]['widget']['data']['target']}
EOT;
}
print <<<EOT
">{$this_model['fields'][$field]['alias']}</a>
EOT;
}elseif(isset($value[$field])){
print <<<EOT

{$value[$field]}
EOT;
}
if(!empty($this_model['fields'][$field]['units'])){
print <<<EOT

{$this_model['fields'][$field]['units']}
EOT;
}
print <<<EOT

</td>
EOT;
}
}

print <<<EOT

<td>
EOT;
echo date('Y-m-d',$value['timestamp']);
print <<<EOT
</td>
<td><a  href="$value[url]" target="_blank">查看此职位</td>
</tr>
EOT;
}
}

print <<<EOT

</table>
EOT;
?>