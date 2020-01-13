<table class="table table-bordered table-striped table-condensed">
<thead class="theme-bg">
<tr>
<th>Product</th>
<th>Unit</th>
<th>Weight</th>
<th>Qty</th>
<th>Feet</th>
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
<option value="<?= $g['SSUNIT'];?>"><?= $g['SSUNIT']; ?></option>
<?php
}
}
?>
</select>
</td>
<td>
<input type="text"  class="form-control th-right" name="weight_e"  placeholder="Weight" data-required>
</td>
<td>
<input type="text" data-required data-only-numbers   class="form-control th-right" name="qty_e"   placeholder="Qty" >
</td>
<td>
<input type="text"  data-required data-only-numbers  class="form-control th-right" name="feet_e" placeholder="Feet">
</td>
<td>
<input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" name="rate_e"  placeholder="Rate" >
</td>
<td><input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" name="amount_e" readonly placeholder="Amount"></td>
</tr>
</tbody>
</table>
<script>
$('[name=pname_e]').select2({width:"100%"});
$('[name=unit_e]').select2({width:"100%"});
$('[name=pname_e]').parents("table").find("[data-only-numbers]").popover({content: "",placement: "bottom",trigger:"focus",container: 'body'});
$('[name=pname_e]').parents("table").find("[data-only-numbers]").each(function(){
var cleave = new Cleave($(this), {
    numeral: true,
    numeralThousandsGroupStyle: 'lakh',
	numeralDecimalScale:4
});
});	
</script>
<div class="form-actions">
<button type="button" class="btn green update-row">Update</button>
<button type="button" class="btn default" data-dismiss="modal" >Close</button>
</div>