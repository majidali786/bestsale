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
<th>Weight</th>
<th>Qty</th>
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
<input type="text"  class="form-control" name="weight_e"  placeholder="Weight" data-required data-only-numbers >
</td>
<td>
<input type="text" data-required data-only-numbers   class="form-control th-right" name="qty_e"   placeholder="Qty"  data-position="4">
</td>
<td>
<input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" name="rate_e"  placeholder="Rate" >
</td>
<td><input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" name="amount_e" readonly placeholder="Amount"></td>
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
baseUrl="<?= base_url("sales/sale-voucher")?>";	
<?php 
if(!empty($bissueError)){
?>
bootbox.dialog({title:notifications['error'],message:"<?= $bissueError?>",buttons:{close:{label:'Ok',className:"red",callback:function(){ location.href="<?= base_url("home")?>"; }}}});
<?php 	
}
?>	
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
if(val=="Kg"){
$(document).find("[name=qty]").removeAttr("data-dmas");
$(document).find("[name=rate]").removeAttr("data-dmas");	
$(document).find("[name=weight]").attr("data-dmas","weight-add,rate-multiply,amount-result");	
$(document).find("[name=rate]").attr("data-dmas","weight-add,rate-multiply,amount-result");
}
else if(val=="Bag"){
$(document).find("[name=weight]").removeAttr("data-dmas");
$(document).find("[name=rate]").removeAttr("data-dmas");	
$(document).find("[name=qty]").attr("data-dmas","qty-add,rate-multiply,amount-result");	
$(document).find("[name=rate]").attr("data-dmas","qty-add,rate-multiply,amount-result");
}
});
$(document).on("change","[name=unit_e]",function(){
var val=$(this).val();
if(val=="Kg"){
$(document).find("[name=qty_e]").removeAttr("data-dmas");
$(document).find("[name=rate_e]").removeAttr("data-dmas");	
$(document).find("[name=weight_e]").attr("data-dmas","weight_e-add,rate_e-multiply,amount_e-result");	
$(document).find("[name=rate_e]").attr("data-dmas","weight_e-add,rate_e-multiply,amount_e-result");
}
else if(val=="Bag"){
$(document).find("[name=weight_e]").removeAttr("data-dmas");
$(document).find("[name=rate_e]").removeAttr("data-dmas");	
$(document).find("[name=qty_e]").attr("data-dmas","qty_e-add,rate_e-multiply,amount_e-result");	
$(document).find("[name=rate_e]").attr("data-dmas","qty_e-add,rate_e-multiply,amount_e-result");
}
});

$(document).on("click",".clear-bno",function(){
	var val=$(document).find("[name=vno]").val();
	var no=$(document).find("[name=no]").val();
	var abc=val.split("-");
	bno=abc[0];
	val=abc[1];
	
	bootbox.dialog({
	message: "Are you sure you want to clear this Book No ?",
	title:"Clear <i class='icon-close text-danger'></i>",
	buttons: {
	danger:{
	label: "Clear <i class='icon-close'></i>",
	className: "red",
	callback: function() {
	$('body').customPreloader("show");
	$.post("<?= base_url("data/clear-book-no")?>",{no:val,bno:bno,sno:no},function(response){
	$('body').customPreloader("hide");
	if(response.success=="true"){
	$(document).find("[name=vno]").val(response.data);	
	bootbox.dialog({title:notifications['success'],message:"Successfully cleared",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green"}}});
	}
	else{
	bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"red",callback:function(){ location.href=baseUrl; }}}});	
	}	
	},"json");
	}
	},
	main:{
	label: "Cancel",
	className: "default",
	}
	}
	});
});
$(document).on("change","[name=pname]",function(){
var val=$(this).val();	
if(val!=""){
$.get("<?= base_url('data/current-stock');?>",{pcode:val},function(response){
if(response.success=='true'){
$('.current-stock').html(response.bal);	
}
},"json");	
}
});
$(document).on("click",".bookno-closed",function(){
var status='<?= $voucherrights[0]['APPROVED']?>';
if(status==1){
$(document).find(".bookno-serial").modal();	
$(document).find(".bookno-serial").find(".modal-dialog").css("width","50%");	
$(document).find(".bookno-serial").find(".modal-body").customPreloader("show");
var url="<?= base_url("data/bookno-closed");?>";
$.get(url,function(response){
$(document).find(".bookno-serial").find(".modal-body").customPreloader("hide");
$(document).find(".bookno-serial").find(".modal-body").html(response.data);			
},'json');	
}	
});
function send_no(Challan)
{
var modal=$('.modal-voucher-details');
modal.modal("hide");
$("input[name=dcno]").val(Challan);
}

$(document).on("click","#load-dc",function(){
if($('#dcsale').is(":checked"))	
{
var dcno = $("input[name=dcno]").val();
if(dcno!=""){
var baseUrl="<?= base_url("sales/sale-voucher")?>";	
var target=$('[load-lcinfo]');	
target.customPreloader("show");
$.post(baseUrl+"/loaddc",{dcno:dcno},function(response){
target.html(response);	
});
}
}	else {
alert("Sale with DC is not selected");
}
});

$(document).on("click","#dcsale",function(){
if($('#dcsale').is(":checked"))	
{
$('[load-lcinfo]').html('');
$("input[name=qty]").prop("readonly", true);
$("input[name=rate]").prop("readonly", true);
}	else {
$('[load-lcinfo]').html('');
$("input[name=qty]").prop("readonly", false);
$("input[name=rate]").prop("readonly", false);	
}
});

$(document).on("change","[name=pname]",function(){
var val=$(this).val();	
if(val!=""){
$.get("<?= base_url('data/product-weight');?>",{pcode:val},function(response){
if(response.success=='true'){
$('[name=pweight]').val(response.pweight);	
}
},"json");	
}
});	
</script>