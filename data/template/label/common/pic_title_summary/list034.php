<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<ul class="label_pic_com_ul34">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
print <<<EOT
	
<li>
<div class="item">
<div class="thumbnail"><img width="360" height="254" alt="$value[full_title]" onError="this.src='$RESOURCE/images/nopic.jpg'" src="
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
" /></div>
<div class="caption">
<a href="$value[url]" title="$value[full_title]" target="_blank">
<h3>$value[title]</h3>
<p>$value[summary]</p>
</a>
</div>
<div class="handle">
<a href="$value[url]" title="$value[full_title]" target="_blank" class="more">+ 更多详情</a>
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