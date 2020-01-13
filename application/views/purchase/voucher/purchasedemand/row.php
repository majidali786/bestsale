<div class="col-sm-12 data-row">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed" style="width:1105px;">
<thead class="theme-bg">
<tr>
<th style="width:200px;text-align:center;">Design</th>
<th style="width:150px;text-align:center;">Color</th>
<th style="width:150px;text-align:center;">Size</th>
<th style="width:150px;text-align:center;">Qty</th>

</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="pcode" class="hidden-data" />
<select name="design" id="design"  class="form-control select2 move-enter-row enter-1 row-start" data-position="1" >

<option value="">Select Design</option>
<?php 
if(count($design)){
foreach($design as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['NAME']; ?></option>
<?php
}
}
?>
</select>
</td>

<td>
<select name="color[]" id="color"  class="form-control select2 move-enter-row enter-2" data-position="2" multiple>
<?php 
if(count($color)){
foreach($color as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['NAME']; ?></option>
<?php
}
}
?>
</select>
</td>


<td>
<select name="size[]" id="size"  class="form-control select2 move-enter-row enter-3" data-position="3" multiple >
<?php 
if(count($size)){
foreach($size as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['SIZE']; ?></option>
<?php
}
}
?>
</select>
</td>

<td>
<input type="text" data-required data-only-numbers  class="form-control move-enter-row enter-4 row-end" name="qty" data-sum="tqty" data-dmas="qty-add,rate-multiply,amount-result" placeholder="Qty"  data-position="4">
</td>


</tr>
</tbody>
</table>
</div>
</div>

<script>
//get product rate
$(document).on("change","[name=pname]",function(){
var val=$(this).val();	
if(val!=""){
$.get("<?= base_url('data/getrate1');?>",{pcode:val},function(response){
if(response.success=='true'){
$('[name=design]').val(response.design);	
$('[name=color]').val(response.color);	
$('[name=size]').val(response.size);	
$('[name=unit]').val(response.unit);		
}
},"json");	
}
});	

//get product Unit
$(document).on("change","[name=pname]",function(){
var val=$(this).val();	
if(val!=""){
$.get("<?= base_url('data/getunit');?>",{pcode:val},function(response){
if(response.success=='true'){
$('[name=unit]').val(response.unit);	
}
},"json");	
}
});

</script>
