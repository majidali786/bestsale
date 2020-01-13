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
<th style="width:450px;text-align:center">Product Description</th>
<th style="width:150px;text-align:center">Unit</th>
<th style="width:150px;text-align:center">Qty</th>
<th style="width:150px;text-align:center">Rate</th>
<th style="width:150px;text-align:center">Amount</th>
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

<td><input type="text" class="form-control move-enter-row enter-3" name="unit_e" id="unit_e" placeholder="Unit">
</td>

<td>
<input type="text" data-required data-only-numbers   class="form-control th-right" name="qty_e"  data-dmas="qty_e-add,rate_e-multiply,amount_e-result"  placeholder="Qty"  data-position="2">
</td>
<td>
<input type="text" data-required data-only-numbers greater-then-zero data-dmas="qty_e-add,rate_e-multiply,amount_e-result" class="form-control th-right" name="rate_e"  placeholder="Rate" >
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


<script>
$(window).on("load",function(){
baseUrl="<?= base_url("inventory/opening-stock")?>";		
});

//get product rate
$(document).on("change","[name=pname]",function(){
var val=$(this).val();	
if(val!=""){
$.get("<?= base_url('data/getrate');?>",{pcode:val},function(response){
if(response.success=='true'){
$('[name=rate]').val(response.rate);	
$('[name=unit]').val(response.unit);
}
},"json");	
}
});	

</script>