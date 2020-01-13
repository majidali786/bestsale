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
<!------edit row portion 1--->
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
<th>Weight</th>
<th>Qty</th>
<th>Feet</th>
<th>Total Weight</th>
<th>Rate</th>
<th>Amount</th>
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
<td>
<input type="text"  class="form-control th-right" name="weight_e" onkeyup="tot2()" placeholder="Weight" data-required>
</td>
<td>
<input type="text" data-required data-only-numbers onkeyup="tot2()" class="form-control th-right" name="qty_e"   placeholder="Qty" >
</td>
<td>
<input type="text"  data-required data-only-numbers  class="form-control th-right" name="feet_e" placeholder="Feet">
</td>
<td>
<input type="text"  data-required readonly class="form-control th-right" name="totweight_e" placeholder="Total Weight">
</td>
<td>
<input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" name="rate_e" data-dmas="totweight_e-add,rate_e-multiply,amount_e-result"  placeholder="Rate" >
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

<!------edit row portion 2--->
<div class="modal fade modal-edit-pro-row" id="basic2"  role="basic" aria-hidden="true">
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
<th>Weight</th>
<th>Qty</th>
<th>MM Wastage</th>
<th>Total Weight</th>
<th>Waste</th>
<th>Manual Waste</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="propcode_ee" class="hidden-data" />
<select name="propname_ee" id="propname_ee" change-assign-value="pcode_ee" data-required hidden-data="propcode_ee" data-name-array="aname_namee" class="form-control select2" >
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
<select name="prounit_ee" id="prounit_ee" data-required class="form-control select2">
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
<td>
<input type="text"  class="form-control th-right" name="procoil_ee"  placeholder="Coil" data-required>
</td>
<td>
<input type="text"  class="form-control th-right" name="proweight_ee"  placeholder="Weight" data-required>
</td>
<td>
<input type="text" data-required data-only-numbers   class="form-control th-right" name="proqty_ee"   placeholder="Qty" >
</td>
<td>
<input type="text"  data-required data-only-numbers  class="form-control th-right" name="prommwaste_ee" placeholder="Feet">
</td>
<td>
<input type="text"  data-required readonly class="form-control th-right" name="prototweight_ee" placeholder="Total Weight">
</td>
<td>
<input type="text"  data-required data-only-numbers class="form-control th-right" name="prowaste_ee" placeholder="Conversion Ft">
</td>
<td>
<input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" name="promanualwaste_ee"  placeholder="Rate" >
</td>
</tr>
</tbody>
</table>


<div class="form-actions">
<button type="button" class="btn green update-pro-row">Update</button>
<button type="button" class="btn default" data-dismiss="modal" >Close</button>
</div>
</div>
</div>
</div>
</div>

<script>
$(window).on("load",function(){
baseUrl="<?= base_url("production/production")?>";	
});
$(document).on("change","[name=prounit]",function(){
var val=$(this).val();
if(val=="kg"){
$(document).find("[name=proqty]").attr("data-dmas","proqty-add,proweight-multiply,prototweight-result");
$(document).find("[name=proweight]").attr("data-dmas","proweight-add,proqty-multiply,prototweight-result");	
$(document).find("[name=proweight]").trigger("keyup");	
$(document).find("[name=proqty]").trigger("keyup");	
}
else if(val=="pcs"){
$(document).find("[name=proqty]").attr("data-dmas","proqty-add,proweight-multiply,prototweight-result");
$(document).find("[name=proweight]").attr("data-dmas","proweight-add,proqty-multiply,prototweight-result");	
$(document).find("[name=proweight]").trigger("keyup");	
$(document).find("[name=proqty]").trigger("keyup");	
}
});
$(document).on("change","[name=prounit_e]",function(){
var val=$(this).val();
if(val=="kg"){
$(document).find("[name=proqty_e]").attr("data-dmas","proqty_e-add,proweight_e-multiply,prototweight_e-result");
$(document).find("[name=proweight_e]").attr("data-dmas","proweight_e-add,proqty_e-multiply,prototweight_e-result");	
$(document).find("[name=proweight_e]").trigger("keyup");	
$(document).find("[name=proqty_e]").trigger("keyup");	
}
else if(val=="pcs"){
$(document).find("[name=proqty_e]").attr("data-dmas","proqty_e-add,proweight_e-multiply,prototweight_e-result");
$(document).find("[name=proweight_e]").attr("data-dmas","proweight_e-add,proqty_e-multiply,prototweight_e-result");	
$(document).find("[name=proweight_e]").trigger("keyup");	
$(document).find("[name=proqty_e]").trigger("keyup");	
}
});

var rawData={};
$(document).on("change","[name=lotno]",function(){
var lotno=$(this).val();
var sdata=[];
$(document).find("[name=rmaterial]").select2('destroy');
$(document).find("[name=rmaterial]").empty();
$(document).find("[name=rmaterial]").select2({
    data:[{id:'',text:"Select Raw Material"}],
    width: "100%"
});	
$.ajax({
url:"<?= base_url("production/kalrol-raw-product");?>",
data:{lotno:lotno},	
method:"post",
dataType:"json"
}).done(function(response){
$.each(response,function(i,tag){
sdata.push({id:tag['PCODE'],text:tag['PNAME']});
rawData[tag['PCODE']]=tag;	
});
$(document).find("[name=rmaterial]").select2({
    data:sdata,
    width: "100%"
});
$(document).find("[name=rmaterial]").focus();	
});
});
$(document).on("change","[name=rmaterial]",function(){
var val=$(this).val();
if(val!=''){
var abc=rawData[val];
$(document).find("[name=used]").val(abc['USED']);	
$(document).find("[name=inhand]").val(abc['BAL']);	
}	
});
function tot()
{
var a = $(document).find("[name=weight]").val();	
var b = $(document).find("[name=qty]").val();
a=removeCommas(a);	
b=removeCommas(b);		
var rzt = a*b;
$(document).find("[name=totweight]").val(lakhSeparator(Math.round10(rzt,-3)));
}
function tot2()
{
var a = $(document).find("[name=weight_e]").val();	
var b = $(document).find("[name=qty_e]").val();
a=removeCommas(a);	
b=removeCommas(b);		
var rzt = a*b;
$(document).find("[name=totweight_e]").val(lakhSeparator(Math.round10(rzt,-3)));
}
</script>