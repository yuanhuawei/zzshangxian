<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<ul class="label_pic_com_ul21">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
print <<<EOT

<li class="col-md-4 col-sm-4 col-xs-12">
<div class="testbox">
<div class="clientimg"><a href="$value[url]" target="_blank" title="$value[full_title]"><img width="388" height="104" alt="$value[full_title]" onError="this.src='$RESOURCE/images/nopic.jpg'" src="
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
" /></a></div>
<div class="test">
<p>$value[summary]</p>
</div>
<div class="clientname">
<h4><a href="$value[url]" target="_blank" title="$value[full_title]">$value[title]</a></h4>
</div>
</div>
</li>
EOT;
}
}

print <<<EOT

</ul>
EOT;
?>