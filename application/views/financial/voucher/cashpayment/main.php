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
<div class="modal fade modal-edit-row" id="basic" role="basic" aria-hidden="true">
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
<th style="text-align:center;" >Party/Account</th>
<th style="text-align:center;">Invoices <button type="button" class="btn btn-info" reload-invoices><i class="icon-reload"></i></button></th>
<th style="text-align:center;">Inv. Amount</th>
<th style="text-align:center;">Description</th>
<th style="text-align:center;">درهم Amount</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="acode_e" class="hidden-data" />
<select name="aname_e" id="aname_e" data-ajax-request="invoices_e,invoices_e" change-assign-value="acode_e" data-name-array="aname_array" data-required hidden-data="acode_e" class="form-control select2"  >
<option value="">Select Party/Account</option>
<optgroup label="Accounts">
<?php 
if(count($account)){
foreach($account as $g){
?>
<option value="<?= $g['ACODE'];?>"><?= $g['ACODE']."-".$g['ANAME']; ?></option>
<?php
}
}
?>
</optgroup>
<optgroup label="Customers">
<?php 
if(count($party)){
foreach($party as $g){
?>
<option value="<?= $g['VCODE'];?>"><?= $g['VCODE']."-".$g['VNAME']; ?></option>
<?php
}
}
?>
</optgroup>
<optgroup label="Suppliers">
<?php 
if(count($supplier)){
foreach($supplier as $g){
?>
<option value="<?= $g['VCODE'];?>"><?= $g['VCODE']."-".$g['VNAME']; ?></option>
<?php
}
}
?>
</optgroup>
</select></td>
<td><select name="invoices_e" id="invoices_e" value-splitter=","  change-assign-value="invAmt_e" value-index="1" ajax-data class="form-control select2">
<option value="">Select Invoice</option>

</select></td>
<td><input type="text"  class="form-control" name="invAmt_e" readonly placeholder="Invoice Amount"></td>
<td><input type="text" class="form-control" data-required name="descrip_e" placeholder="Description"></td>
<td><input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" name="amount_e" placeholder="Amount"></td>
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

<div class="modal fade modal-pending-invoices" id="basic" tabindex="-1" role="basic" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header modal-header-custom">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">Pending Purchase Invoices</h4>
</div>
<div class="modal-body"></div>
</div>
</div>
</div>

<script>
$(window).on("load",function(){
baseUrl="<?= base_url("financial/cash-payment")?>";	
});
$(document).on("change","[name=aname]",function(){
var data={
	acode:$(this).val()
}
var sdata=[];
$(document).find("[name=invoices]").select2('destroy');
$(document).find("[name=invoices]").empty();
$(document).find("[name=invoices]").select2({
    data:[{id:'',text:"Select Invoice"}],
    width: "100%"
	});		
if($(this).val()!=''){
$('.data-row').customPreloader("show");	
var url="<?= base_url("data/purchase-invoices");?>";
$.get(url,data,function(response){
$('.data-row').customPreloader("hide");
sdata.push({id:'',text:"Select Invoice"});	
$.each(response.data,function(i,tag){
if(parseFloat(tag['DIF'])<0){
tag['DIF']=Math.abs(tag['DIF']);	
}
else{
tag['DIF']=0-tag['DIF'];		
}	
var sval=tag['INVNO']+","+tag['DIF'];
var sshow=tag['INVNO']+" => "+tag['DIF'];
sdata.push({id:sval,text:sshow});	
});
$(document).find("[name=invoices]").select2({
    data:sdata,
    width: "100%"
});	
if(response.data.length>0){
$(document).find(".modal-pending-invoices").find(".modal-body").html(response.purchinv);	
$(document).find(".modal-pending-invoices").find(".modal-dialog").css("width","70%");
$(document).find(".modal-pending-invoices").modal();		
}
},'json');
}
});
$(document).on("click","[reload-invoices]",function(){
var acode=$(document).find("[name=aname_e]").val();	

var data={
	acode:acode
}
var sdata=[];
$(document).find("[name=invoices_e]").select2('destroy');
$(document).find("[name=invoices_e]").empty();
$(document).find("[name=invoices_e]").select2({
    data:[{id:'',text:"Select Invoice"}],
    width: "100%"
	});		
if(acode!=''){
$('.modal-edit-row').find(".modal-body").customPreloader("show");	
var url="<?= base_url("data/purchase-invoices");?>";
$.get(url,data,function(response){
$('.modal-edit-row').find(".modal-body").customPreloader("hide");
sdata.push({id:'',text:"Select Invoice"});	
$.each(response.data,function(i,tag){
if(parseFloat(tag['DIF'])<0){
tag['DIF']=Math.abs(tag['DIF']);	
}
else{
tag['DIF']=0-tag['DIF'];		
}	
var sval=tag['INVNO']+","+tag['DIF'];
var sshow=tag['INVNO']+" => "+tag['DIF'];
sdata.push({id:sval,text:sshow});	
});
$(document).find("[name=invoices_e]").select2({
    data:sdata,
    width: "100%"
});	
},'json');
}
});
</script>