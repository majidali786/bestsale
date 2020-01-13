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
<th>Qty</th>
<th>Rate</th>
<th>Amount درهم</th>
<th>Discount %</th>
<th>Discount درهم</th>
<th>Total درهم</th>
<th>Vat.%</th>
<th>Vat.Amount درهم</th>
<th>Net درهم</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="pcode_e" class="hidden-data" />
<select name="pname_e" id="pname_e"	<?php if($this->userData['B_ID']=='1')	{ ?> disabled <?php } ?> change-assign-value="pcode_e" data-required hidden-data="pcode_e" data-name-array="aname_name" class="form-control select2" >
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

<td><input type="text" class="form-control move-enter-row" <?php if($this->userData['B_ID']=='1')	{ ?> readonly <?php } ?> name="unit_e" id="unit_e" placeholder="Unit">
</td>
<td>
<input type="text" data-required data-only-numbers  <?php if($this->userData['B_ID']=='1')	{ ?> readonly <?php } ?>  class="form-control th-right" name="qty_e"   placeholder="Qty" data-dmas="qty_e-add,rate_e-multiply,amount_e-result,qty_e-clear,discountper_e-add,amount_e-percent-discount_e,total_e-clear,amount_e-add,discount_e-minus,total_e-result,qty_e-clear,gstper_e-add,total_e-percent-gst_e,net_e-clear,total_e-add,gst_e-add,net_e-result"  data-position="4">
</td>
<td>
<input type="text" data-required data-only-numbers greater-then-zero <?php if($this->userData['B_ID']=='1')	{ ?> readonly <?php } ?> class="form-control th-right" name="rate_e" data-dmas="qty_e-add,rate_e-multiply,amount_e-result,qty_e-clear,discountper_e-add,amount_e-percent-discount_e,total_e-clear,amount_e-add,discount_e-minus,total_e-result,qty_e-clear,gstper_e-add,total_e-percent-gst_e,net_e-clear,total_e-add,gst_e-add,net_e-result"  placeholder="Rate" >
</td>
<td><input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" name="amount_e" readonly placeholder="Amount"></td>
<td><input type="text"  class="form-control th-right" name="discountper_e" data-dmas="qty_e-add,rate_e-multiply,amount_e-result,qty_e-clear,discountper_e-add,amount_e-percent-discount_e,total_e-clear,amount_e-add,discount_e-minus,total_e-result,qty_e-clear,gstper_e-add,total_e-percent-gst_e,net_e-clear,total_e-add,gst_e-add,net_e-result" placeholder="Discount%"></td>
<td><input type="text"  class="form-control th-right" name="discount_e" readonly placeholder="Discount"></td>
<td><input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" name="total_e" readonly placeholder="Total"></td>
<td><input type="text"  class="form-control th-right" name="gstper_e" data-dmas="qty_e-add,rate_e-multiply,amount_e-result,qty_e-clear,discountper_e-add,amount_e-percent-discount_e,total_e-clear,amount_e-add,discount_e-minus,total_e-result,qty_e-clear,gstper_e-add,total_e-percent-gst_e,net_e-clear,total_e-add,gst_e-add,net_e-result" placeholder="GST%"></td>
<td><input type="text"  class="form-control th-right" name="gst_e" readonly placeholder="GST"></td>
<td><input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" name="net_e" readonly placeholder="Net"></td>
</tr>
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

<div class="modal fade bookno-serial" id="basic" tabindex="-1" role="basic" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header modal-header-custom">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">Closed Serials</h4>
</div>
<div class="modal-body"></div>
</div>
</div>
</div>
<script>
$(window).on("load",function(){
baseUrl="<?= base_url("sales/sale-invoice")?>";	
<?php 
if(!empty($bissueError)){
?>
bootbox.dialog({title:notifications['error'],message:"<?= $bissueError?>",buttons:{close:{label:'Ok',className:"red",callback:function(){ location.href="<?= base_url("home")?>"; }}}});
<?php 	
}
?>	
});
//get party date
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

//get product rate
$(document).on("change","[name=pname]",function(){
var val=$(this).val();	
if(val!=""){
$.get("<?= base_url('data/getrate');?>",{pcode:val},function(response){
if(response.success=='true'){
	$('[name=qty').val(1);
$('[name=rate]').val(response.rate);	
$('[name=gstper]').val(5);	
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

/* //get product Discount
$(document).on("change","[name=pname]",function(){
var vcode=$('[name=vcode]').val();	
var val=$(this).val();	
if(val!=""){
$.get("<?= base_url('data/getdiscount');?>",{pcode:val,vcode:vcode},function(response){
if(response.success=='true'){
$('[name=discountper]').val(response.discountper);	
}
},"json");	
}
});

*/
/* $(document).on("change","[name=pname]",function(){
var val=$(this).val();	
if(val!=""){
$.get("<?= base_url('data/current-stock');?>",{pcode:val},function(response){
if(response.success=='true'){
$('.current-stock').html(response.bal);	
}
},"json");	
}
}); 

 function get_stock_qty(val) 
{
if(val!=""){
$.get("<?= base_url('data/get-stock');?>",{pcode:val},function(response){
if(response.success=='true'){
$('.stock').val(response.stock);	
}
},"json");	
}
}

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

$(document).on("change","[name=pname],[name=pname_e]",function(){
var val=$(this).val();	
get_stock_qty(val);
}); */


</script>