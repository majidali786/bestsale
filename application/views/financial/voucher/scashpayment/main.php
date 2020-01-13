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

<th style="width:340px;text-align:center;">Party/Account</th>
<th style="width:100px;text-align:center;">Balance.Amount</th>
<th style="width:300px;text-align:center;">Description</th>
<th style="width:120px;text-align:center;">Amount</th>
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
<!--<td><select name="invoices_e" id="invoices_e" value-splitter=","  change-assign-value="invAmt_e" value-index="1" ajax-data class="form-control select2">
<option value="">Select Invoice</option>

</select></td>-->
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

<div class="modal fade modal-Order-invoices" id="basic" tabindex="-1" role="basic" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header modal-header-custom">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">Pending Order Invoices</h4>
</div>
<div class="modal-body"></div>
</div>
</div>
</div>

<script>
$(window).on("load",function(){
baseUrl="<?= base_url("financial/scash-payment")?>";	
});

//get amount
$(document).on("change","[name=aname]",function(){
var val=$(this).val();	
if(val!=""){
$.get("<?= base_url('data/sparty-data');?>",{acode:val},function(response){
if(response.success=='true'){
$('[name=invAmt]').val(response.invAmt);	
}
},"json");	
}
});	

</script>