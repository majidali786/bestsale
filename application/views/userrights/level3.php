<div class="mt-element-list">
<div class="mt-list-head list-simple font-white theme-bg">
<div class="list-head-title-container">
<h3 class="list-title">Level 3</h3>
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
<li class="mt-list-item"> 
<div class="list-icon-container done">
<div class="md-checkbox has-info">
<input type="checkbox" id="level3_<?= $a?>" <?php if($match==1){ echo "checked"; } ?> name="level3_<?= $a?>" value="<?= $g['NO']?>" class="md-check">
<label for="level3_<?= $a?>">
<span></span>
<span class="check"></span>
<span class="box"></span></label>
</div>
</div>
<div class="list-item-content">
<h3 class="uppercase">
<a href="javascript:;"><?= $g['NAME']?></a>
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
<input type="hidden" name="level3" value="<?= $a;?>"/>