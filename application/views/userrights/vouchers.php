<div class="mt-element-list">
<div class="mt-list-head list-simple font-white bg-red">
<div class="list-head-title-container">
<h3 class="list-title">Vouchers</h3>
</div>
</div>
<div class="mt-list-container list-simple">
<ul>
<?php 
$a=1;	
if(count($data)){	
foreach($data as $g):
?>
<li class="mt-list-item" data-id="<?= $g['NO']?>"> 
<div class="list-icon-container done">
<i class="icon-list"></i>
</div>
<div class="list-item-content">
<h3 class="uppercase">
<a href="javascript:;" load-voucher-rights><?= $g['NAME']?></a>
</h3>
</div>
</li>
<?php
$a++; 
endforeach;
}
?>
</ul>
</div>
</div>
