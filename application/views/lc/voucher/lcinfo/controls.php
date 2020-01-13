<div class="control-panel">
<ul>
<?php 
if(!empty($voucherrights[0]['NAV']))
{
if($voucherrights[0]['NAV']==1){	
?>
<li><button class="tooltips" data-control-left data-container="body" data-placement="right" data-original-title="Previous"><i class="icon-arrow-left"></i></button></li>
<li><button class="tooltips" data-control-reload data-container="body" data-placement="right" data-original-title="Load"><i class="icon-reload"></i></button></li>
<li><button class="tooltips" data-control-right data-container="body" data-placement="right" data-original-title="Next"><i class="icon-arrow-right"></i></button></li>
<?php
} 
}
if(!empty($voucherrights[0]['DEL'])){
if($voucherrights[0]['DEL']==1){	
?>
<li><button class="tooltips" data-control-delete data-container="body" data-placement="right" data-original-title="Delete"><i class="icon-trash text-danger"></i></button></li>
<?php 
}
}
if(!empty($voucherrights[0]['PRNT'])){
if($voucherrights[0]['PRNT']==1){		
?>
<li><button class="tooltips" data-control-print data-container="body" data-placement="right" data-original-title="Print"><i class="icon-printer text-info"></i></button></li>
<?php 
}
}
?>
</ul>
</div>