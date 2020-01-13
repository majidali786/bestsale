<div class="col-sm-12 data-row">

<div>
<table class="table table-bordered table-striped table-condensed" style="width:1100px;">
<thead class="theme-bg">

<tr>
<th style="text-align:center;width:400px;">Design</th>
<th style="text-align:center;width:100px;">Color</th>
<th style="text-align:center;width:100px;">Qty</th>
<th style="text-align:center;width:100px;">Unit Price</th>
<th style="text-align:center;width:100px;">Amount</th>
</tr>
</thead>
<tbody>
<tr>



<td>
<input type="hidden" name="pcode" class="hidden-data" />

<select name="design" id="design"  change-assign-value="pcode" change-assign-value="pcode_e" data-required hidden-data="pcode" data-name-array="aname_name" class="form-control select2 move-enter-row enter-1 row-start" data-position="1" >
<option value="">Select Design</option>
<?php 
if(count($design)){
foreach($design as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['NAME']; ?></option>
<?php
}
}
?>
</select>
</td>


<td>
<input type="text"  class="form-control move-enter-row enter-2"  name="color"  placeholder="Color" data-position="2">
</td>
<td>
<input type="text" data-required data-only-numbers  class="form-control move-enter-row enter-3" name="qty" data-sum="tqty" data-dmas="qty-add,rate-multiply,amount-result"placeholder="Qty"  data-position="3">
</td>

<td>
<input type="text" data-required data-only-numbers greater-then-zero 
class="form-control move-enter-row enter-4 row-end" name="rate" placeholder="Rate"  data-position="4" data-dmas="qty-add,rate-multiply,amount-result" >
</td>
<td><input type="text" data-required data-only-numbers greater-then-zero data-sum="tamount" class="form-control" name="amount" readonly placeholder="Amount"></td>
</tr>
</tbody>
</table>
</div>
<div class="portlet-body" data-list-load>

</div>
<script>


</script>
<script src="<?php echo base_url("assets/global/scripts/jquery.uploadPreview.min.js")?>">
</script>
	<script>
	$('.image-preview').uploadPreview();
	</script>
</div>