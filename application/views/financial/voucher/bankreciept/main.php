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
<th>Party/Account</th>
<th>Bank</th>
<th>Invoices <button type="button" class="btn btn-info" reload-invoices><i class="icon-reload"></i></button></th>
<th>Ref. Chq.No  <button type="button" class="btn btn-info" reload-refChqNo><i class="icon-reload"></i></button></th>
<th>Inv. Amount</th>
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
<td>
<input type="hidden" name="bcode_e" class="hidden-data" />
<select name="bank_e" id="bank_e" change-assign-value="bcode_e" data-required hidden-data="bcode_e" data-name-array="aname_name" class="form-control select2 move-enter-row">
<option value="">Select Bank</option>
<?php 
if(count($bank)){
foreach($bank as $g){
?>
<option value="<?= $g['BCODE'];?>"><?= $g['BNAME']; ?></option>
<?php
}
}
?>
</select>
</td>
<td><select name="invoices_e" id="invoices_e" value-splitter=","  change-assign-value="invAmt_e" value-index="1"  class="form-control select2">
<option value="">Select Invoice</option>

</select></td>
<td>
<select name="refChqNo_e"  value-splitter="," value-index="1"  change-assign-value="refChqAmt_e" id="refChqNo_e" ajax-data class="form-control select2">
<option value="">Select Reference Chq.No</option>

</select>
</td>
<td><input type="text"  class="form-control th-right" name="invAmt_e" readonly placeholder="Invoice Amount"></td>
</tr>
<tr class="theme-bg">
<th>Ref. Chq. Amount</th>
<th>Description</th>
<th>Cheque No.</th>
<th>Cheque Date</th>
<th>Amount</th>
</tr>
<tr>
<td><input type="text"  class="form-control th-right" name="refChqAmt_e" readonly placeholder="Reference Chq. Amount"></td>
<td><input type="text" class="form-control" data-required name="descrip_e" placeholder="Description"></td>
<td><input type="text" class="form-control" name="chqNo_e" placeholder="Cheque No."></td>
<td><input type="text" class="form-control" name="chqDate_e" input-mask-date placeholder="dd/mm/yyyy"></td>
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

<div class="modal fade modal-ref-chq" id="basic" tabindex="-1" role="basic" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header modal-header-custom">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">Pending Reference Cheques</h4>
</div>
<div class="modal-body"></div>
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
<div class="modal-body"></div>
</div>
</div>
</div>

<script>
$(window).on("load",function(){
baseUrl="<?= base_url("financial/bank-reciept")?>";	
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
if(response.data2.length>0){
$(document).find(".modal-pending-invoices").find(".modal-body").html(response.saleinv);	
$(document).find(".modal-pending-invoices").find(".modal-dialog").css("width","70%");		
}
if(response.data.length>0){
$(document).find(".modal-ref-chq").find(".modal-body").html(response.refchq);	
$(document).find(".modal-ref-chq").find(".modal-dialog").css("width","70%");	
}
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
$(document).on("change","[name=bank]",function(){
if($(document).find(".modal-ref-chq").find(".modal-body").html()!=""){	
$(document).find(".modal-ref-chq").modal();	
setTimeout(function(){$(document).find("[name=invoices]").select2("close");},100);
}
if($(document).find(".modal-pending-invoices").find(".modal-body").html()!=""){		
$(document).find(".modal-pending-invoices").modal();
}
});
</script>