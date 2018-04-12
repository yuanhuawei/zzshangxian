<?php
defined('PHP168_PATH') or die();
?>
<?php
$swidth = strpos($swidth, '%')!==false?$swidth:$swidth.'px';
print <<<EOT

<div id="carousel-example-generic" class="full-width carousel slide" data-ride="carousel">
<!-- Wrapper for slides -->
<div class="carousel-inner" role="listbox">
EOT;
$__t_foreach = @$list;
if(!empty($__t_foreach)){
foreach($__t_foreach as $value){
print <<<EOT

<div class="item"><a href="{$value['url']}"><img src="{$value['frame']}" width="$swidth" height="$sheight" alt="" class="img-responsive"></a></div>
EOT;
}
}

print <<<EOT

</div>
<!-- Controls -->
<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
<span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
<span class="sr-only">Next</span>
</a>
</div>
<script type="text/javascript">
(function () {
$("#carousel-example-generic .carousel-inner .item:first,#carousel-example-generic .carousel-indicators .pagination:first").addClass("active");
})()
</script>
EOT;
?>