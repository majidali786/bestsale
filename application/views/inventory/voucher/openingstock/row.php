<div class="col-sm-12 data-row">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed" style="width:1105px;">
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
<input type="hidden" name="pcode" class="hidden-data" />
<select name="pname" id="pname" change-assign-value="pcode" data-required hidden-data="pcode" data-name-array="aname_name" class="form-control select2 move-enter-row enter-1 row-start" data-position="1" >
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
<td><input type="text" class="form-control move-enter-row" name="unit" id="unit" placeholder="Unit">
</td>
<td>
<input type="text" data-required data-only-numbers  class="form-control move-enter-row enter-2" name="qty" data-sum="tqty" data-dmas="qty-add,rate-multiply,amount-result" placeholder="Qty"  data-position="2">
</td>
<td>
<input type="text" data-required data-only-numbers greater-then-zero class="form-control move-enter-row enter-3 row-end" data-dmas="qty-add,rate-multiply,amount-result" name="rate" placeholder="Rate"  data-position="4" >
</td>
<td><input type="text" data-required data-only-numbers greater-then-zero data-sum="tamount" class="form-control" name="amount" readonly placeholder="Amount"></td>
</tr>
</tbody>
</table>
</div>
</div>
<script>

</script>