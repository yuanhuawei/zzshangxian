<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<ul class="label_ul_b new_li6" style="font-size:14px;color:#454545;">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
print <<<EOT

<li style="$wf;">
<a href="$value[url]" target="_blank" title="$value[full_title]">$value[title]</a>
</li>
EOT;
}
}

print <<<EOT

<li class="clear"></li>
</ul>
EOT;
?>