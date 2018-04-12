<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<ul class="label_ul_list">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
print <<<EOT

<li  style="">
<h3><a class="" href="$value[url]" target="_blank" title="$value[full_title]" >$value[title]</a></h3>
<p class="label_summary">$value[summary]... </p>
</li>
EOT;
}
}

print <<<EOT

<li class="clear"></li>
</ul>
EOT;
?>