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

<th style="text-align-center">Invoices</th>
<th style="text-align-center">Inv. Amount</th>
<th style="text-align-center">Party/Account</th>
<th style="text-align-center">Description</th>
<th style="text-align-center">Amount</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="pcode_e" class="hidden-data" />
<select name="pname_e" id="pname_e" change-assign-value="pcode_e" data-required hidden-data="pcode_e" 
data-name-array="aname_name" class="form-control select2" >
<option value="">Select Invoices</option>
<?php 
if(count($invoiceno)){
foreach($invoiceno as $g){
?>
<option value="<?= $g['INVNO'];?>"> Invoice : <?= $g['INVNO']; ?> - <?= $g['VNAME']; ?> : <?= $g['DIF']; ?></option>
<?php
}
}
?>
</select></td>

<td><input type="text"  class="form-control" name="invAmt_e" readonly placeholder="Invoice Amount"></td>
<td>
<input type="hidden"  class="form-control" name="acode_e" readonly placeholder="Code">
<input type="text" class="form-control" name="apname_e" readonly placeholder="Party Name"></td>
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




<script>
$(window).on("load",function(){
baseUrl="<?= base_url("financial/cash-reciept")?>";	
});
//get Invoice Detial 
$(document).on("change","[name=pname]",function(){
var val=$(this).val();	
if(val!=""){
$.get("<?= base_url('data/getinvoices');?>",{pcode:val},function(response){
if(response.success=='true'){
$('[name=acode]').val(response.acode);	
$('[name=apname]').val(response.apname);	
$('[name=invAmt]').val(response.invAmt);
}
},"json");	
}
});	

</script>