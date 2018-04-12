<?php
defined('PHP168_PATH') or die();
?>
<?php
print <<<EOT
<style type="text/css">
.intranet_vote2 li{line-height:25px;_margin-bottom:5px}
</style>
EOT;
$i_type = $data['multi'] == 1 ? 'radio' : 'checkbox';
print <<<EOT

<a style="color:#f13300;" href="{$this_module->controller}-vote?id=$data[id]" target="_blank">$data[name]</a>
<form action="{$this_module->controller}-vote" method="post" target="_blank">
<ul class="intranet_vote2">
EOT;
$__t_foreach = @$options;
if(!empty($__t_foreach)){
foreach($__t_foreach as $v){
print <<<EOT

<li>
<input type="$i_type" name="oid[]" id="p8_v_o_{$data['id']}_{$v['id']}" value="$v[id]" /> <label for="p8_v_o_{$data['id']}_{$v['id']}">$v[name]</label>
</li>
EOT;
}
}
if($data['captcha']){
print <<<EOT

<li>
{$P8LANG['captcha']}:<input type="text"  class="txt"  name="captcha" id="captcha" size="10"/> <span id="captchachr"></span>
</li>	
EOT;
}
print <<<EOT

</ul>
<div style="line-height:28px; text-align:center;height:28px;">
<input class="vote_sumit" type="hidden" name="id" value="$data[id]" />
<input type="submit" value="{$P8LANG['submit']}" /> <input type="button" value="查看" onclick="window.open('{$this_module->controller}-vote?id=$data[id]')"/>
</div>
</form>
<script type="text/javascript">
(function(){
EOT;
if($data['captcha']){
print <<<EOT

captcha($("#captchachr"), $("input[name=captcha]"));
EOT;
}
print <<<EOT

})();
</script>
EOT;
?>