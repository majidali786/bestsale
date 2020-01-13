<div class="col-sm-12 data-row">

<div>
<table class="table table-bordered table-striped table-condensed" style="width:1100px;">
<thead class="theme-bg">

<tr>
<th style="text-align:center;width:200px;">Design</th>
<th style="text-align:center;width:200px;">Image</th>
<th style="text-align:center;width:80px;">Color</th>
<th style="text-align:center;width:100px;">Qty</th>
<th style="text-align:center;width:100px;">Unit Price</th>
<th style="text-align:center;width:100px;">Amount</th>
</tr>
</thead>
<tbody>
<tr>




<td>
<div class="autocomplete" style="width:200px;">
<input type="text"  class="form-control move-enter-row enter-1 row-start" id="myInput" name="design"  placeholder="Design" data-position="1">
<div id="designList"></div></div>
</td>

<td class="image-preview">				
 <input type="file" name="img"  class="form-control  move-enter-row enter-2" id="img" accept="image/*" class="image-input" />
				
</td>
<td>
<input type="text"  class="form-control move-enter-row enter-2"  name="color"  placeholder="Color" data-position="2">
</td>
<td>
<input type="text" data-required data-only-numbers  class="form-control move-enter-row enter-3" name="qty" data-sum="tqty" placeholder="Qty"  data-position="3">
</td>

<td>
<input type="text" data-required data-only-numbers greater-then-zero class="form-control move-enter-row enter-4 row-end" name="rate" placeholder="Rate"  data-position="4" >
</td>
<td><input type="text" data-required data-only-numbers greater-then-zero data-sum="tamount" class="form-control" name="amount" readonly placeholder="Amount"></td>
</tr>
</tbody>
</table>
</div>
<div class="portlet-body" data-list-load>

</div>

<script src="<?php echo base_url("assets/global/scripts/jquery.uploadPreview.min.js")?>">
</script>
	<script>
	$('.image-preview').uploadPreview();
	</script>
</div>