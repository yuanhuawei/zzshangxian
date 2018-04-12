<?php
defined('PHP168_PATH') or die();
?>
<?php
$i=0;
print <<<EOT

<ul class="label_pic_com_ul4">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
$i++;$j=$i%2;
print <<<EOT

<li class="label_float_$j" style="$wf;">
<div style="width:250px;padding:0px 10px;"><h3 class="label_18px_title"><a href="$value[url]" target="_blank" title="$value[full_title]">$value[title]</a></h3>
<p class="label_summary">$value[summary]<span class="cDBlue"><a href="$value[url]" target="_blank">[详细]</a></span></p>
</div>
</li>
EOT;
}
}

print <<<EOT

</ul>
EOT;
?>