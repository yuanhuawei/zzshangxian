<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="label_table" bgcolor="#ffffff" style="text-align:center;font-size:12px">
<tr  height="28" class="title" style="color:#333333">	
EOT;
$__t_foreach = @$option['fields'];
if(!empty($__t_foreach)){
foreach($__t_foreach as $field){
print <<<EOT

<td bgcolor="#e8e8e8" align="center">{$this_model['fields'][$field]['alias']}</td>
EOT;
}
}

print <<<EOT

<td bgcolor="#e8e8e8" align="center">详细情况</td>
</tr>
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $key => $value){
print <<<EOT

<tr id="item_$value[id]" style="background-color:#F8F8F8">
EOT;
$__t_foreach = @$option['fields'];
if(!empty($__t_foreach)){
foreach($__t_foreach as $field){
print <<<EOT

<td>
EOT;
if(!empty($value[$field]) && ($this_model['fields'][$field]['widget']=='radio' || $this_model['fields'][$field]['widget']=='select' || $this_model['fields'][$field]['widget']=='city')){
print <<<EOT

<a href="$value[url]" target="_blank">{$this_model['fields'][$field]['data'][$value[$field]]}</a>
EOT;
}elseif(!empty($value[$field]) && ($this_model['fields'][$field]['widget']=='checkbox' || $this_model['fields'][$field]['widget']=='multi_select')){
$__t_foreach = @$value[$field];
if(!empty($__t_foreach)){
foreach($__t_foreach as $v){
print <<<EOT

<a href="$value[url]" target="_blank">{$this_model['fields'][$field]['data'][$v]}</a>
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

<a href="$value[url]" target="_blank">{$value[$field]}</a>
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

<td align="center"><a href="$value[url]" target="_blank">详情&gt;&gt;</a></td>
</tr>
EOT;
}
}

print <<<EOT

</table>
EOT;
?>