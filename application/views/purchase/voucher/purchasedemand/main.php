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
<th style="width:400px;text-align:center;">Product Description</th>
<th style="width:200px;text-align:center;">Design</th>
<th style="width:150px;text-align:center;">Color</th>
<th style="width:150px;text-align:center;">Size</th>
<th style="width:150px;text-align:center;">Unit</th>
<th style="width:150px;text-align:center;">Qty</th>

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
<input type="text"   class="form-control th-left" name="design_e"  readonly placeholder="Design">
</td>
<td>
<input type="text"   class="form-control th-left" name="color_e"  readonly placeholder="Color">
</td>
<td>
<input type="text"   class="form-control th-left" name="size_e" readonly  placeholder="Size">
</td>

<td>
<input type="text"   class="form-control th-left" name="unit_e"  readonly placeholder="Unit">
</td>
<td>
<input type="text" data-required data-only-numbers   class="form-control th-right" name="qty_e"   placeholder="Qty" >
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
baseUrl="<?= base_url("purchase/purchase-demand")?>";		
});
</script>
<script>
//get product rate
$(document).on("change","[name=pname_e]",function(){
var val=$(this).val();	
if(val!=""){
$.get("<?= base_url('data/getrate1');?>",{pcode:val},function(response){
if(response.success=='true'){
$('[name=design_e]').val(response.design);	
$('[name=color_e]').val(response.color);	
$('[name=size_e]').val(response.size);	
$('[name=unit_e]').val(response.unit);		
}
},"json");	
}
});	

//get product Unit
$(document).on("change","[name=pname]",function(){
var val=$(this).val();	
if(val!=""){
$.get("<?= base_url('data/getunit');?>",{pcode:val},function(response){
if(response.success=='true'){
$('[name=unit]').val(response.unit);	
}
},"json");	
}
});

</script>
