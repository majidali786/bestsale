<div class="col-sm-12 data-row">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed" style="width:1105px;">
<thead class="theme-bg">
<tr>
<th style="width:450px;text-align:center">Design/Style</th>
<th style="width:150px;text-align:center">Color</th>
<th style="width:150px;text-align:center">Order Qty</th>
<th style="width:150px;text-align:center">Transfer Qty</th>
<th style="width:150px;text-align:center">Stock</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="pcode" class="hidden-data" />
<select name="pname" id="pname" change-assign-value="pcode" data-required hidden-data="pcode" data-name-array="aname_name" data-through-ajax="rate-rate,conv-conv,weight-weght" class="form-control select2 move-enter-row enter-1 row-start" data-position="1" >
<option value="">Select Design</option>

</select></td>

<td>
<input type="text" readonly class="form-control" name="unit" id="unit" placeholder="Color" >
</td>

<td>
<input type="text" readonly class="form-control th-right" name="oqty" placeholder="Order Qty" >
</td>
<td>
<input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" name="qty"  readonly placeholder="Qty" data-sum="tqty" >
</td>
<td>
<input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" name="stock"  readonly placeholder="Stock" >
</td>
</tr>
</tbody>
</table>
</div>
</div>