<input type="hidden" name="pweight" id="pweight">
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
<th style="width:650px;text-align:center;">Product Description</th>
<th style="width:140px;text-align:center;">Unit</th>
<th style="width:140px;text-align:center;">Qty</th>
<th style="width:140px;text-align:center;">Stock</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="pcode_e" class="hidden-data" />
<select name="pname_e" id="pname_e" change-assign-value="pcode_e" data-required hidden-data="pcode_e" 
data-name-array="aname_name" class="form-control select2" >
<option value="">Select Product</option>
<?php 
if(count($product)){
foreach($product as $g){
?>
<option value="<?= $g['PCODE'];?>"> <?= $g['PNAME']; ?> - <?= $g['BNAME']; ?> - Stock :- <?= $g['QTY']; ?></option>
<?php
}
}
?>
</select></td>

<td>
<input type="text"  class="form-control th-right" name="unit_e"  placeholder="Unit" data-required>
</td>
<td>
<input type="text" data-required data-only-numbers   class="form-control th-right" onkeyup="chk_qty();" name="qty_e"   placeholder="Qty" >
</td>
<td>
<input type="text" data-required data-only-numbers   class="form-control th-right" name="stock_e"   placeholder="Qty" >
</td>
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
baseUrl="<?= base_url("inventory/stock-transfer")?>";	
});
//get product rate
$(document).on("change","[name=pname]",function(){
var val=$(this).val();	
if(val!=""){
$.get("<?= base_url('data/getrate');?>",{pcode:val},function(response){
if(response.success=='true'){
$('[name=rate]').val(response.rate);	
$('[name=unit]').val(response.unit);
$('[name=stock]').val(response.stock);

}
},"json");	
}
});	

$(document).on("keyup","[name=qty]",function()
{
var qty = parseFloat(removeCommas(this.value));
var stock = parseFloat($('[name=stock]').val());
if (qty =='') {
qty = 0;
}
if (stock =='') {
stock = 0;
}
if(qty>stock) 
{
$('[name=disp]').removeClass('row-end');
toastr.error(qty+' '+'Stock is not available');
}else if(qty<stock) 
{
$('[name=disp]').addClass('row-end');
}
});
/* function chk_qty(row){
var a = $('[name=qty]').val();
var b = $('[name=stock]').val();
if(parseFloat(a)>parseFloat(b)){
$('[name=qty]').val(parseFloat(b));
}
} */
</script>