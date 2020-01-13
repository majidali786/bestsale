<?php 
$this->load->view($loadControls);
?>
<div class="page-content-inner">
<div class="portlet light portlet-fit ">
<div class="portlet-body all-data">
<?php 
$this->load->view($loadVoucher);
?>
</div>
</div>
</div>
<!------edit row portion--->
<!------edit row portion--->
<div class="modal fade modal-edit-row" id="basic"  role="basic" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header modal-header-custom">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title"><?= $heading?></h4>
</div>
<div class="modal-body">
<table class="table table-bordered table-striped table-condensed">
<thead class="theme-bg">
<tr>
<th>Product</th>
<th>Unit</th>
<th>Coil</th>
<th>Weight</th>
<th>Qty</th>
<th>Feet</th>
<th>Rate</th>
<th>Amount</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="pcode_e" class="hidden-data" />
<select name="pname_e" id="pname_e" change-assign-value="pcode_e" data-required hidden-data="pcode_e" data-name-array="aname_name" class="form-control select2" >
<option value="">Select Product</option>
<?php 
if(count($product)){
foreach($product as $g){
?>
<option value="<?= $g['PCODE'];?>"><?= $g['PNAME']; ?></option>
<?php
}
}
?>
</select></td>
<td>
<select name="unit_e" id="unit_e" data-required class="form-control select2">
<option value="">Select Unit</option>
<?php 
if(count($unit)){
foreach($unit as $g){
?>
<option value="<?= $g['UNIT'];?>"><?= $g['UNIT']; ?></option>
<?php
}
}
?>
</select>
</td>
<td>
<input type="text"  class="form-control" name="coil_e"  placeholder="Coil No." data-required >
</td>
<td>
<input type="text"  class="form-control" name="weight_e"  placeholder="Weight" data-required>
</td>
<td>
<input type="text" data-required data-only-numbers   class="form-control" name="qty_e"   placeholder="Qty" >
</td>
<td>
<input type="text"  data-required data-only-numbers  class="form-control" name="feet_e" placeholder="Feet">
</td>
<td>
<input type="text" data-required data-only-numbers greater-then-zero class="form-control" name="rate_e"  placeholder="Rate" >
</td>
<td><input type="text" data-required data-only-numbers greater-then-zero class="form-control" name="amount_e" readonly placeholder="Amount"></td>
</tr>
</tbody>
</table>


<div class="form-actions">
<button type="button" class="btn green update-row">Update</button>
<button type="button" class="btn default" data-dismiss="modal" >Close</button>
</div>
</div>
</div>
</div>
</div>
<script>
$(window).on("load",function(){
baseUrl="<?= base_url("lc/lc-sale")?>";	
});
$(document).on("change","[name=vname]",function(){
var data={
	acode:$(this).val()
}	
var array=$(this).attr("data-through-ajax");	
var output={}
var urlParam="";
$.each(array.split(","),function(i,tag){
var a=tag.split("-");
urlParam=urlParam+"/"+a[0];
output[a[0]]=a[1];
});
var url="<?= base_url("data/party-data");?>"+urlParam;
$.get(url,data,function(response){
$.each(output,function(i,tag){
$(document).find("[name="+tag+"]").val(response[i]);	
});
dataSum();	
},'json');
});
$(document).on("change","[name=unit]",function(){
var val=$(this).val();
if(val=="feet"){
$(document).find("[name=weight]").removeAttr("data-dmas");
$(document).find("[name=qty]").removeAttr("data-dmas");
$(document).find("[name=rate]").removeAttr("data-dmas");	
$(document).find("[name=feet]").attr("data-dmas","feet-add,rate-multiply,amount-result");	
$(document).find("[name=rate]").attr("data-dmas","feet-add,rate-multiply,amount-result");	
$(document).find("[name=feet]").trigger("keyup");
}
else if(val=="kg"){
$(document).find("[name=feet]").removeAttr("data-dmas");
$(document).find("[name=qty]").removeAttr("data-dmas");
$(document).find("[name=rate]").removeAttr("data-dmas");	
$(document).find("[name=weight]").attr("data-dmas","weight-add,rate-multiply,amount-result");	
$(document).find("[name=rate]").attr("data-dmas","weight-add,rate-multiply,amount-result");
$(document).find("[name=weight]").trigger("keyup");	
}
else if(val=="pcs"){
$(document).find("[name=feet]").removeAttr("data-dmas");
$(document).find("[name=weight]").removeAttr("data-dmas");
$(document).find("[name=rate]").removeAttr("data-dmas");	
$(document).find("[name=qty]").attr("data-dmas","qty-add,rate-multiply,amount-result");	
$(document).find("[name=rate]").attr("data-dmas","qty-add,rate-multiply,amount-result");
$(document).find("[name=qty]").trigger("keyup");	
}
});
$(document).on("change","[name=unit_e]",function(){
var val=$(this).val();
if(val=="feet"){
$(document).find("[name=weight_e]").removeAttr("data-dmas");
$(document).find("[name=qty_e]").removeAttr("data-dmas");
$(document).find("[name=rate_e]").removeAttr("data-dmas");	
$(document).find("[name=feet_e]").attr("data-dmas","feet_e-add,rate_e-multiply,amount_e-result");	
$(document).find("[name=rate_e]").attr("data-dmas","feet_e-add,rate_e-multiply,amount_e-result");	
$(document).find("[name=feet_e]").trigger("keyup");
}
else if(val=="kg"){
$(document).find("[name=feet_e]").removeAttr("data-dmas");
$(document).find("[name=qty_e]").removeAttr("data-dmas");
$(document).find("[name=rate_e]").removeAttr("data-dmas");	
$(document).find("[name=weight_e]").attr("data-dmas","weight_e-add,rate_e-multiply,amount_e-result");	
$(document).find("[name=rate_e]").attr("data-dmas","weight_e-add,rate_e-multiply,amount_e-result");
$(document).find("[name=weight_e]").trigger("keyup");	
}
else if(val=="pcs"){
$(document).find("[name=feet_e]").removeAttr("data-dmas");
$(document).find("[name=weight_e]").removeAttr("data-dmas");
$(document).find("[name=rate_e]").removeAttr("data-dmas");	
$(document).find("[name=qty_e]").attr("data-dmas","qty_e-add,rate_e-multiply,amount_e-result");	
$(document).find("[name=rate_e]").attr("data-dmas","qty_e-add,rate_e-multiply,amount_e-result");
$(document).find("[name=qty_e]").trigger("keyup");	
}
});
</script>