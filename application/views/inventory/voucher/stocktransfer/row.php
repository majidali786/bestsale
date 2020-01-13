<div class="col-sm-12 data-row">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed" style="width:1108px;">
<thead class="theme-bg">
<tr>

<th style="width:650px;text-align:center;">Product Description</th>
<th style="width:140px;text-align:center;">Unit</th>
<th style="width:140px;text-align:center;">Qty</th>
<th style="width:140px;text-align:center;">Stock</th>

</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="pcode" class="hidden-data" />
<select name="pname" id="pname" change-assign-value="pcode" data-required hidden-data="pcode" data-name-array="aname_name" 
class="form-control select2 move-enter-row enter-1 row-start" data-position="1" >
<option value="">Select Product</option>
<?php 
if(count($product)){
foreach($product as $g){
?>
<option value="<?= $g['PCODE'];?>"> <?= $g['PNAME']; ?> - <?= $g['BNAME']; ?> - Stock :- <?= $g['QTY']; ?></option>
<?php
}
}
?>
</select></td>

<td>
<input type="text"  class="form-control" name="unit"  placeholder="unit"  >
</td>
<td>
<input type="text" data-required data-only-numbers  class="form-control move-enter-row enter-2 row-end" name="qty" data-sum="tqty" placeholder="Qty"  data-position="2">
</td>

<td>
<input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" 
name="stock"  readonly placeholder="Stock" >
</td>

</tr>
</tbody>
</table>
</div>
</div>
