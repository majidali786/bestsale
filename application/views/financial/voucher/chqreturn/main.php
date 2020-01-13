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
<th colspan="3">Party/Account</th>
<th>Bank</th>
</tr>
</thead>
<tbody>
<tr>
<td  colspan="3">
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
</tr>
<tr class="theme-bg">
<th>Description</th>
<th>Cheque No.</th>
<th>Cheque Date</th>
<th>Amount</th>
</tr>
<tr>
<td><input type="text" class="form-control" data-required name="descrip_e" placeholder="Description"></td>
<td><input type="text" class="form-control th-right" name="chqNo_e" placeholder="Cheque No."></td>
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
<h4 class="modal-title">Pending Cheques</h4>
</div>
<div class="modal-body"></div>
</div>
</div>
</div>

<script>
$(window).on("load",function(){
baseUrl="<?= base_url("financial/cheque-reciept")?>";	
});
$(document).on("change","[name=bank]",function(){
if($(document).find(".modal-ref-chq").find(".modal-body").html()!=""){	
$(document).find(".modal-ref-chq").modal();	
setTimeout(function(){$(document).find("[name=invoices]").select2("close");},100);
}
});
$(document).on("change","[name=aname]",function(){
var data={
	acode:$(this).val()
}
if($(this).val()!=''){
$('.data-row').customPreloader("show");	
var url="<?= base_url("data/pending-cheque");?>";
$.get(url,data,function(response){

$('.data-row').customPreloader("hide");	
if(response.data.length>0){
$(document).find(".modal-ref-chq").find(".modal-body").html(response.chqs);	
$(document).find(".modal-ref-chq").find(".modal-dialog").css("width","70%");	
}
},'json');
}
});
</script>