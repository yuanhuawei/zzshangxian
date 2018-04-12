<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<ul class="label_pic_com_ul32">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
print <<<EOT

<li class="media">
<div class="thumbnail"><a href="$value[url]" target="_blank" title="$value[full_title]"><img width="205" height="257" alt="$value[full_title]" onError="this.src='$RESOURCE/images/nopic.jpg'" src="
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
<div class="mediacon">
<h3><a href="$value[url]" target="_blank" title="$value[full_title]">$value[title]</a></h3>
<p>$value[summary]<span class="cDRed"><a href="$value[url]" target="_blank">[详细]</a></span></p>
</div>
</li>   
EOT;
}
}
?>