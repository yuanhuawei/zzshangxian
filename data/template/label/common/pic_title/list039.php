<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<ul class="label_pic_ul39">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
print <<<EOT

<li>
<div class="label_item">
<a href="$value[url]" target="_blank" title="$value[full_title]"><img width="380" height="500" alt="$value[full_title]" onError="this.src='$RESOURCE/images/nopic.jpg'" src="
EOT;
if(empty($value['frame'])){
print <<<EOT
{$RESOURCE}/images/nopic.jpg
EOT;
}else{
print <<<EOT
$value[frame]
EOT;
}
print <<<EOT
" /></a>
<h5><a href="$value[url]" target="_blank" title="$value[full_title]">$value[title]</a></h5>
</div>
</li>
EOT;
}
}

print <<<EOT

</ul>
EOT;
?>