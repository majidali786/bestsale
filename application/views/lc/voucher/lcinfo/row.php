<div class="col-sm-12 data-row">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed" style="width:1500px;">
<thead class="theme-bg">
<tr>
<th style="width:300px;">Product</th>
<th style="width:150px;">Unit</th>
<th style="width:150px;">Coil</th>
<th style="width:150px;">Qty(MT)</th>
<th style="width:150px;">Weight(MT)</th>
<th style="width:150px;">F.C Rate(MT)</th>
<th style="width:150px;">PKR Rate(MT)</th>
<th style="width:150px;">F.C Amount(MT)</th>
<th style="width:150px;">PKR Amount(MT)</th>
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
<input type="text" data-required  class="form-control move-enter-row enter-3" name="coil" data-sum="tqty" placeholder="Coil No."  data-position="3">
</td>
<td>
<input type="text" data-required data-only-numbers  class="form-control move-enter-row enter-4" name="qty" data-sum="tqty" data-dmas="conversion-add,fcrate-multiply,rate-result-round-2,clear-clear,weight-add,fcrate-multiply,fcamount-result-round-2,clear-clear,weight-add,rate-multiply,amount-result-round-2" placeholder="Qty"  data-position="4">
</td>
<td>
<input type="text"  class="form-control move-enter-row enter-5" name="weight"  placeholder="Weight" data-sum="tweight" data-dmas="conversion-add,fcrate-multiply,rate-result-round-2,clear-clear,weight-add,fcrate-multiply,fcamount-result-round-2,clear-clear,weight-add,rate-multiply,amount-result-round-2" data-required data-only-numbers   data-position="5">
</td>
<td>
<input type="text"  data-required data-only-numbers greater-then-zero class="form-control move-enter-row enter-6" data-dmas="conversion-add,fcrate-multiply,rate-result-round-2,clear-clear,weight-add,fcrate-multiply,fcamount-result-round-2,clear-clear,weight-add,rate-multiply,amount-result-round-2" name="fcrate" placeholder="F.C Rate(MT)"  data-position="6">
</td>
<td>
<input type="text" data-required data-only-numbers greater-then-zero class="form-control move-enter-row enter-7 row-end" data-dmas="conversion-add,fcrate-multiply,rate-result-round-2,clear-clear,weight-add,fcrate-multiply,fcamount-result-round-2,clear-clear,weight-add,rate-multiply,amount-result-round-2" name="rate" placeholder="PKR Rate(MT)"  data-position="7" >
</td>
<td><input type="text" data-required data-only-numbers greater-then-zero data-sum="fctamount" class="form-control" name="fcamount" readonly placeholder="F.C Amount(MT)"></td>
<td><input type="text" data-required data-only-numbers greater-then-zero data-sum="tamount" class="form-control" name="amount" readonly placeholder="PKR Amount(MT)"></td>
</tr>
</tbody>
</table>
</div>
</div>
