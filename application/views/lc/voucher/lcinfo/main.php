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
<th>Coil</th>
<th>Qty(MT)</th>
<th>Weight(MT)</th>
<th>F.C Rate(MT)</th>
<th>PKR Rate(MT)</th>
<th>F.C Amount(MT)</th>
<th>PKR Amount(MT)</th>
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
<td><input type="text"  class="form-control" name="coil_e"  placeholder="Coil" data-required ></td>
<td>
<input type="text" data-required data-only-numbers data-dmas="conversion-add,fcrate_e-multiply,rate_e-result-round-2,clear-clear,weight_e-add,fcrate_e-multiply,fcamount_e-result-round-2,clear-clear,weight_e-add,rate_e-multiply,amount_e-result-round-2" class="form-control th-right" name="qty_e"   placeholder="Qty" >
</td>
<td>
<input type="text"  class="form-control th-right" data-dmas="conversion-add,fcrate_e-multiply,rate_e-result-round-2,clear-clear,weight_e-add,fcrate_e-multiply,fcamount_e-result-round-2,clear-clear,weight_e-add,rate_e-multiply,amount_e-result-round-2" name="weight_e"  placeholder="Weight" data-required data-only-numbers >
</td>
<td>
<input type="text"  data-required data-dmas="conversion-add,fcrate_e-multiply,rate_e-result-round-2,clear-clear,weight_e-add,fcrate_e-multiply,fcamount_e-result-round-2,clear-clear,weight_e-add,rate_e-multiply,amount_e-result-round-2" data-only-numbers greater-then-zero class="form-control th-right" name="fcrate_e" placeholder="F.C Rate(MT)">
</td>
<td>
<input type="text" data-required data-dmas="conversion-add,fcrate_e-multiply,rate_e-result-round-2,clear-clear,weight_e-add,fcrate_e-multiply,fcamount_e-result-round-2,clear-clear,weight_e-add,rate_e-multiply,amount_e-result-round-2" data-only-numbers greater-then-zero class="form-control th-right" name="rate_e"  placeholder="PKR Rate(MT)" >
</td>
<td><input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" name="fcamount_e" readonly placeholder="Amount"></td>
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
baseUrl="<?= base_url("lc/lc-information")?>";		
});
</script>