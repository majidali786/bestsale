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
<th>Design/Style</th>
<th>Color</th>
<th>Order Qty</th>
<th>Transfer Qty</th>
<th>Stock</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="pcode_e" class="hidden-data" />
<select name="pname_e" id="pname_e" change-assign-value="pcode_e" data-required hidden-data="pcode_e" data-name-array="aname_name" 
data-through-ajax="rate-rate_e,conv-conv_e,weight-weght_e" class="form-control select2" >
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
<input type="text" readonly class="form-control" name="unit_e" id="unit_e" placeholder="Color" >
</td>
<td>
<input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" name="qty_e"  readonly  >
</td>
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
baseUrl="<?= base_url("purchase/transfer-order")?>";	
});
$(document).on("keypup","[name=pname]",function(){
var val=$(this).val();	
if(val!=""){
$.get("<?= base_url('data/current-stock');?>",{pcode:val},function(response){
if(response.success=='true'){
$('.current-stock').html(response.bal);	
}
},"json");	
}
});
function chk_qty(row){
var a = $('[name=qty_'+row+']').val();
var b = $('[name=orderqty_'+row+']').val();
if(parseFloat(a)>parseFloat(b)){
$('[name=qty_'+row+']').val(parseFloat(b));
}
}
</script>