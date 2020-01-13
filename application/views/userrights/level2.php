<div class="mt-element-list">
<div class="mt-list-head list-simple font-white bg-blue">
<div class="list-head-title-container">
<h3 class="list-title">Level 2</h3>
</div>
</div>
<div class="mt-list-container list-simple">
<ul>
<?php 
$a=1;	
if(count($data)){
foreach($data as $g):
$match=0;
foreach($data2 as $d){
if($g['NO']==$d['NO']){
$match=1;	
}
}
?>
<li class="mt-list-item" data-id="<?= $g['NO']?>"> 
<div class="list-icon-container done">
<div class="md-checkbox has-success">
<input type="checkbox" id="level2_<?= $a?>" <?php if($match==1){ echo "checked"; } ?> name="level2_<?= $a?>" value="<?= $g['NO']?>" class="md-check">
<label for="level2_<?= $a?>">
<span></span>
<span class="check"></span>
<span class="box"></span></label>
</div>
</div>
<div class="list-item-content">
<h3 class="uppercase">
<a href="javascript:;" load-level-3><?= $g['NAME']?></a>
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
<input type="hidden" name="level2" value="<?= $a;?>"/>