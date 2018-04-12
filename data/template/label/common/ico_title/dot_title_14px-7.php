<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<ul class="label_ul_b sidelist14" style="color:#4f6b72;font-size:14px;">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
print <<<EOT

<li style="$wf;">
<span class="label_datatime" style="color:#666666;font-size:12px;">
EOT;
echo date('Y/m/d', $value['timestamp']);
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