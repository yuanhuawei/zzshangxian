<?php
defined('PHP168_PATH') or die();
?>
<?php
$slide_num=0;
$swidth1 = 4/5*$swidth;
$swidth2 = 1/5*$swidth;
$sheight2 = 1/4*($sheight-12);
print <<<EOT

<style type="text/css">
.clssMainRoll {FILTER: progid:DXImageTransform.Microsoft.Slide(slidestyle=SWAP, Bands=1); CURSOR: pointer }
</style>
<script language="JavaScript" type="text/javascript" src="{$core->url}/js/slide3/imagerollover.js"></script>
<SCRIPT language=javascript>
var m_nPageInitTime = new Date();
var MainTopRoll = new xwzRollingImageTrans("IMG_MAIN_TOP_ROLL_DETAIL_{$label['id']}", "IMGS_MAIN_TOP_ROLL_THUMBNAIL_{$label['id']}");
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
$slide_num++;
if($slide_num == 1 ){
$first_frame = $value['frame'];
}
if($slide_num > 4) break;
print <<<EOT

MainTopRoll.addItem("$value[url]","$value[frame]");
EOT;
}
}

print <<<EOT

</SCRIPT>
<TABLE cellSpacing="0" cellPadding="0" width="{$swidth}" height="{$sheight}" align="center">
<TBODY>
<TR>
<TD id="IDS_DIV_MAIN_TOP_ROLL_DETAIL_{$label['id']}" width="{$swidth1}" height="{$sheight}"> <IMG class="clssMainRoll" width="{$swidth1}" height = "{$sheight}" border="0" name="IMG_MAIN_TOP_ROLL_DETAIL_{$label['id']}" src="$first_frame" /> </TD>
<TD width="5">&nbsp;</TD>
<TD width="{$swidth2}" bgcolor="#F4F4F4">
<ul>
EOT;
$slide_num=0;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
if($slide_num > 3) break;
print <<<EOT

<li style="float:right;height:{$sheight2}px;display:inline;
EOT;
if($slide_num != 3){
print <<<EOT
margin-bottom:4px;
EOT;
}else{
print <<<EOT
margin-bottom:0;
EOT;
}
print <<<EOT
">
<IMG  width="{$swidth2}" height="{$sheight2}" style="CURSOR: pointer" onclick="MainTopRoll.alterImage($slide_num)" border="0" src="$value[frame]" /></li>
EOT;
$slide_num++;
}
}

print <<<EOT

</ul>
</TD>
</TR>
</TBODY>
</TABLE>
<SCRIPT language=JavaScript>
MainTopRoll.Index =  parseInt('0');
MainTopRoll.install();
</SCRIPT>
EOT;
?>