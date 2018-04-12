<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<ul class="label_dotlist_{$label['id']} newsListStyle" style="font-size:12px;color:#454545;">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
print <<<EOT

<li>
<span class="label_datatime" style="color:#333;font-size:12px;">
EOT;
echo date('m-d', $value['timestamp']);
print <<<EOT
</span><a href="$value[url]" target="_blank" title="$value[full_title]">$value[title]</a>
</li>
EOT;
}
}

print <<<EOT

<li class="clear"></li>
</ul>
EOT;
?>