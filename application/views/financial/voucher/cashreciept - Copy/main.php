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
<th style="text-align-center">Party/Account</th>
<th style="text-align-center">Invoices <button type="button" class="btn btn-info" reload-invoices><i class="icon-reload"></i></button></th>
<th style="text-align-center">Inv. Amount</th>
<th style="text-align-center">Description</th>
<th style="text-align-center">Amount</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="acode_e" class="hidden-data" />
<select name="aname_e" id="aname_e" data-ajax-request="invoices_e,refChqNo_e" change-assign-value="acode_e" data-name-array="aname_array" data-required hidden-data="acode_e" class="form-control select2"  >
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
</tr>
<td><input type="text" class="form-control" data-required name="descrip_e" placeholder="Description"></td>
<td><input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" 
name="amount_e" placeholder="Amount"></td>
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
<div class="modal fade modal-ref-chq" id="basic" tabindex="-1" role="basic" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header modal-header-custom">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">Pending Reference Cheques</h4>
</div>
<div class="modal-body"> Modal body goes here </div>
</div>
</div>
</div>

<div class="modal fade modal-pending-invoices" id="basic" tabindex="-1" role="basic" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header modal-header-custom">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">Pending Sale Invoices</h4>
</div>
<div class="modal-body"> Modal body goes here </div>
</div>
</div>
</div>

<script>
$(window).on("load",function(){
baseUrl="<?= base_url("financial/cash-reciept")?>";	
});
$(document).on("change","[name=aname]",function(){
var data={
	acode:$(this).val()
}
var sdata=[];
var sdata2=[];
$(document).find("[name=refChqNo]").select2('destroy');
$(document).find("[name=refChqNo]").empty();
$(document).find("[name=refChqNo]").select2({
    data:[{id:'',text:"Select Reference Chq.No"}],
    width: "100%"
	});	
$(document).find("[name=invoices]").select2('destroy');
$(document).find("[name=invoices]").empty();
$(document).find("[name=invoices]").select2({
    data:[{id:'',text:"Select Invoice"}],
    width: "100%"
	});		
if($(this).val()!=''){
$('.data-row').customPreloader("show");	
var url="<?= base_url("data/reference-cheque-invoices");?>";
$.get(url,data,function(response){
	
sdata.push({id:'',text:"Select Reference Chq.No"});	
sdata2.push({id:'',text:"Select Reference Chq.No"});	
$.each(response.data,function(i,tag){
if(parseFloat(tag['DIF'])<0){
tag['DIF']=Math.abs(tag['DIF']);	
}
else{
tag['DIF']=0-tag['DIF'];		
}	
var sval=tag['CHQNO']+","+tag['DIF'];
var sshow=tag['CHQNO']+" => "+tag['DIF'];
sdata.push({id:sval,text:sshow});	
});
$.each(response.data2,function(i,tag){
var sval=tag['INVNO']+","+Math.round(tag['DIF']);
var sshow=tag['INVNO']+" => "+Math.round(tag['DIF']);
sdata2.push({id:sval,text:sshow});	
});
$(document).find("[name=refChqNo]").select2({
    data:sdata,
    width: "100%"
});
$(document).find("[name=invoices]").select2({
    data:sdata2,
    width: "100%"
});
$('.data-row').customPreloader("hide");	

},'json');
}
});
$(document).on("click","[reload-refChqNo]",function(){
var acode=$(document).find("[name=aname_e]").val();	

var data={
	acode:acode
}
var sdata=[];
$(document).find("[name=refChqNo_e]").select2('destroy');
$(document).find("[name=refChqNo_e]").empty();
$(document).find("[name=refChqNo_e]").select2({
    data:[{id:'',text:"Select Reference Chq.No"}],
    width: "100%"
	});		
if(acode!=''){
$('.modal-edit-row').find(".modal-body").customPreloader("show");	
var url="<?= base_url("data/reference-cheque");?>";
$.get(url,data,function(response){
$('.modal-edit-row').find(".modal-body").customPreloader("hide");
sdata.push({id:'',text:"Select Reference Chq.No"});	
$.each(response.data,function(i,tag){
if(parseFloat(tag['DIF'])<0){
tag['DIF']=Math.abs(tag['DIF']);	
}
else{
tag['DIF']=0-tag['DIF'];		
}	
var sval=tag['CHQNO']+","+tag['DIF'];
var sshow=tag['CHQNO']+" => "+tag['DIF'];
sdata.push({id:sval,text:sshow});	
});
$(document).find("[name=refChqNo_e]").select2({
    data:sdata,
    width: "100%"
});	
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
var url="<?= base_url("data/sale-invoices");?>";
$.get(url,data,function(response){
$('.modal-edit-row').find(".modal-body").customPreloader("hide");
sdata.push({id:'',text:"Select Invoice"});	
$.each(response.data,function(i,tag){	
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