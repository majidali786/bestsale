<div class="col-sm-12 data-row">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed" style="width:1525px;">
<thead class="theme-bg">
<tr>
<th style="width:300px;text-align:center">Product</th>
<th style="width:100px;text-align:center">Unit</th>
<th style="width:125px;text-align:center">Qty</th>
<th style="width:125px;text-align:center">Rate</th>
<th style="width:125px;text-align:center">Amount درهم</th>
<th style="width:125px;text-align:center">Disc %</th>
<th style="width:125px;text-align:center">Dis.Amount درهم</th>
<th style="width:125px;text-align:center">Total درهم</th>
<th style="width:125px;text-align:center">GST %</th>
<th style="width:125px;text-align:center">Vat.درهم.</th>
<th style="width:125px;text-align:center">Net درهم</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden"  class="hidden-data stock" name="stock" />
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
<input type="text" data-required data-only-numbers  class="th-right form-control move-enter-row enter-2" name="qty" data-sum="tqty" data-dmas="qty-add,rate-multiply,amount-result,qty-clear,discountper-add,amount-percent-discount,total-clear,amount-add,discount-minus,total-result,qty-clear,gstper-add,total-percent-gst,net-clear,total-add,gst-add,net-result" placeholder="Qty"  data-position="2">
</td>

<td>
<input type="text" data-required data-only-numbers greater-then-zero class="th-right form-control move-enter-row enter-3" data-dmas="qty-add,rate-multiply,amount-result,qty-clear,discountper-add,amount-percent-discount,total-clear,amount-add,discount-minus,total-result,qty-clear,gstper-add,total-percent-gst,net-clear,total-add,gst-add,net-result" name="rate" placeholder="Rate"  data-position="3" >
</td>

<td><input type="text" data-required data-only-numbers greater-then-zero data-sum="tamount" class="form-control th-right" name="amount" readonly placeholder="Amount"></td>

<td><input type="text"    class="th-right form-control move-enter-row enter-4" data-dmas="qty-add,rate-multiply,amount-result,qty-clear,discountper-add,amount-percent-discount,total-clear,amount-add,discount-minus,total-result,qty-clear,gstper-add,total-percent-gst,net-clear,total-add,gst-add,net-result" data-position="4" name="discountper" value="0" placeholder="Discount%"></td>


<td><input type="text" data-only-numbers  data-sum="tdiscount" class="form-control th-right move-enter-row enter-5"  data-dmas="qty-add,rate-multiply,amount-result,qty-clear,amount-add,discount-percentage-discountper,total-clear,amount-add,discount-minus,total-result,qty-clear,gstper-add,total-percent-gst,net-clear,total-add,gst-add,net-result" data-position="5" value="0" name="discount" placeholder="Discount"></td>


<td><input type="text" data-required data-only-numbers greater-then-zero data-sum="ttotal" class="form-control" name="total" readonly placeholder="Total"></td>


<td><input type="text"  class="form-control th-right move-enter-row enter-6 row-end" 
data-dmas="qty-add,rate-multiply,amount-result,qty-clear,discountper-add,amount-percent-discount,total-clear,amount-add
,discount-minus,total-result,qty-clear,gstper-add,total-percent-gst,net-clear,total-add,gst-add,net-result,net-result" data-position="6"  value="5"name="gstper" placeholder="Gst%"></td>



<td><input type="text"  data-sum="tgst" class="form-control th-right" name="gst" readonly placeholder="Gst"></td>
<td><input type="text" data-required data-only-numbers greater-then-zero data-sum="tnet" class="form-control" 
name="net" readonly placeholder="Net"></td>
</tr>
</tbody>
</table>
</div>
</div>
<div class="col-sm-12">
<h4>Current Stock : <span class="current-stock"></span></h4>
</div>
