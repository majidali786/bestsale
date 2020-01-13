<div class="col-sm-12 data-row">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed" style="width:1100px;">
<thead class="theme-bg">

<tr>
<th style="text-align:center;width:300px;">Product Name</th>
<th style="text-align:center;width:80px;">Unit</th>
<th style="text-align:center;width:120px;">Qty</th>
<th style="text-align:center;width:120px;">Rate</th>
<th style="text-align:center;width:120px;">Amount</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="pcode" class="hidden-data" />
<select name="pname" id="pname" change-assign-value="pcode" change-assign-value="pcode_e" data-required hidden-data="pcode" data-name-array="aname_name" class="form-control select2 move-enter-row enter-1 row-start" data-through-ajax="unit-unit" data-position="1" >
<option value="">Select Product</option>
<?php 
if(count($product)){
foreach($product as $g){
?>
<option value="<?= $g['PCODE'];?>"><?= $g['PNAME']; ?>-<?= $g['PCODE']; ?></option>
<?php
}
}
?>
</select></td>

<td>
<input type="text"  class="form-control" name="unit"  placeholder="Unit">
</td>
<td>
<input type="text" data-required data-only-numbers  class="form-control move-enter-row enter-2" name="qty" data-sum="tqty" placeholder="Qty"  data-position="2">
</td>

<td>
<input type="text" data-required data-only-numbers greater-then-zero class="form-control move-enter-row enter-3 row-end" name="rate" placeholder="Rate"  data-position="3" >
</td>
<td><input type="text" data-required data-only-numbers greater-then-zero data-sum="tamount" class="form-control" name="amount" readonly placeholder="Amount"></td>
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
$.get("<?= base_url('data/getrate');?>",{pcode:val},function(response){
if(response.success=='true'){
$('[name=rate]').val(response.rate);	
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