<div class="col-sm-12 data-row">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed" style="width:1105px;">
<thead class="theme-bg">
<tr>
<th style="width:550px;text-align:center">Description</th>
<th style="width:125px;text-align:center">Total</th>
<th style="width:125px;text-align:center">GST %</th>
<th style="width:125px;text-align:center">GST Rs</th>
<th style="width:125px;text-align:center">Net</th>
</tr>
</thead>
<tbody>
<tr>
<td><input type="text" class="form-control  move-enter-row enter-1 row-start" data-position="1" name="desc" placeholder="Description"></td>
<td><input type="text" data-required data-only-numbers greater-then-zero data-sum="ttotal" class="form-control move-enter-row enter-2 row-end" data-position="2" data-dmas="gstper-add,total-percent-gst,net-clear,total-add,gst-add,net-result" data-position="3" name="total" name="total" placeholder="Total"></td>


<td><input type="text" data-required data-only-numbers greater-then-zero name="gstper" class="form-control move-enter-row enter-3" readonly value="17" placeholder="Gst%"></td>


<td><input type="text" data-required data-only-numbers greater-then-zero data-sum="tgst" class="form-control" name="gst" readonly placeholder="Gst"></td>
<td><input type="text" data-required data-only-numbers greater-then-zero data-sum="tnet" class="form-control" name="net" readonly placeholder="Net"></td>
</tr>
</tbody>
</table>
</div>
</div>
