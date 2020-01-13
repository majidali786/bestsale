<div class="col-sm-12 data-row">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed" style="width:900px;">
<thead class="theme-bg">
<tr>
<th style="width:300px;">Product</th>
<th style="width:150px;">Unit</th>
<th style="width:150px;">Weight</th>
<th style="width:150px;">Qty</th>
<th style="width:150px;">Feet</th>
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
<td>
<select name="unit" id="unit" change-assign-value="bcode" data-required class="form-control select2 move-enter-row enter-2" data-position="2">
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
<input type="text"  class="form-control move-enter-row enter-3" name="weight"  placeholder="Weight" data-sum="tweight"  data-required data-only-numbers   data-position="3">
</td>
<td>
<input type="text" data-required data-only-numbers  class="form-control move-enter-row enter-4" name="qty" data-sum="tqty" placeholder="Qty"  data-position="4">
</td>
<td>
<input type="text"  data-required data-only-numbers class="form-control move-enter-row enter-5 row-end" data-sum="tfeet"  name="feet" placeholder="Feet"  data-position="5">
</td>
</tr>
</tbody>
</table>
</div>
</div>
