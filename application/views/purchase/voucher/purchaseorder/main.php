<input type="hidden" name="pweight" id="pweight">

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
<th style="text-align:center;width:400px;">Design</th>
<th style="text-align:center;width:100px;">Color</th>
<th style="text-align:center;width:100px;">Qty</th>
<th style="text-align:center;width:100px;">Unit Price</th>
<th style="text-align:center;width:100px;">Amount</th>
</tr>
</thead>
<tbody>
<tr>

<td>
<input type="hidden" name="pcode_e" class="hidden-data" />
<select name="design_e" id="design_e" change-assign-value="pcode_e" data-required hidden-data="pcode_e" data-name-array="aname_name" class="form-control select2"  data-position="1" >
<option value="">Select Design/Style</option>
<?php 
if(count($design)){
foreach($design as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['NAME']; ?></option>
<?php
}
}
?>
</select>
</td>

<td>

<input type="text" data-required class="form-control th-right" name="color_e"  id="color_e" placeholder="Color">
</td>
<td>
<input type="text" data-required data-only-numbers   class="form-control th-right" name="qty_e"   placeholder="Qty"  data-position="2">
</td>
<td>
<input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" name="rate_e"  placeholder="Rate" >
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
baseUrl="<?= base_url("purchase/purchase-order")?>";				
});

$(document).find("[name=qty]").attr("data-dmas","qty-add,rate-multiply,amount-result");
$(document).find("[name=rate]").attr("data-dmas","qty-add,rate-multiply,amount-result");

$(document).find("[name=qty_e]").attr("data-dmas","qty_e-add,rate_e-multiply,amount_e-result");
$(document).find("[name=rate_e]").attr("data-dmas","qty_e-add,rate_e-multiply,amount_e-result");

//get party date
$(document).on("change","[name=vname]",function(){
var data={
	acode:$(this).val()
}	
var array=$(this).attr("data-through-ajax");	
var output={}
var urlParam="";
$.each(array.split(","),function(i,tag){
var a=tag.split("-");
urlParam=urlParam+"/"+a[0];
output[a[0]]=a[1];
});
var url="<?= base_url("data/party-data");?>"+urlParam;
$.get(url,data,function(response){
$.each(output,function(i,tag){
$(document).find("[name="+tag+"]").val(response[i]);	
});
dataSum();	
},'json');
});



</script>
