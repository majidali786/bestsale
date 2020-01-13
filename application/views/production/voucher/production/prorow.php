<div class="col-sm-12 data-prorow">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed" style="width:1200px;">
<thead class="theme-bg">
<tr>
<th style="width:300px;">Product</th>
<th style="width:150px;">Unit</th>
<th style="width:150px;">Coil</th>
<th style="width:150px;">Weight</th>
<th style="width:150px;">Qty</th>
<th style="width:150px;">MM Wastage</th>
<th style="width:150px;">Total Weight</th>
<th style="width:150px;">Waste</th>
<th style="width:150px;">Manual Waste</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="propcode" class="hidden-data" />
<select name="propname" id="propname" change-assign-value="propcode" data-required hidden-data="propcode" data-name-array="aname_name" class="form-control select2 move-enter-prorow enter-pro-1 prorow-start" data-position="1" >
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
<select name="prounit" id="prounit" change-assign-value="probcode" data-required class="form-control select2 move-enter-prorow enter-pro-2" data-position="2">
<option value="">Select Unit</option>
<?php 
if(count($unit)){
foreach($unit as $g){
if($g['UNIT']!='feet')
{
?>
<option value="<?= $g['UNIT'];?>"><?= $g['UNIT']; ?></option>
<?php
}	}
}
?>
</select>
</td>
<td>
<input type="text"  class="form-control move-enter-prorow enter-pro-3" name="procoil"  placeholder="Coil" data-required data-position="3">
</td>
<td>
<input type="text"  class="form-control move-enter-prorow enter-pro-4" name="proweight"  placeholder="Weight" data-sum="protwght" data-required data-only-numbers   data-position="4">
</td>
<td>
<input type="text" data-required data-only-numbers  class="form-control move-enter-prorow enter-pro-5" name="proqty" data-sum="protqty" placeholder="Qty"  data-position="5">
</td>
<td>
<input type="text" data-only-numbers class="form-control move-enter-prorow enter-pro-6" name="prommwaste" placeholder="Wastage" data-sum="protmmwaste" data-position="6">
</td>
<td>
<input type="text" data-required data-only-numbers greater-then-zero class="form-control" data-sum="prototwght" readonly name="prototweight"  placeholder="Total Weight"  >
</td>
<td><input type="text" data-required data-only-numbers greater-then-zero data-sum="protwaste" class="form-control move-enter-prorow enter-pro-7"  data-position="7" name="prowaste" placeholder="Waste"></td>

<td><input type="text" data-only-numbers greater-then-zero data-sum="protmwaste" class="form-control move-enter-prorow enter-pro-8 prorow-end" name="promanualwaste" data-position="8"  placeholder="Manual Waste"></td>
</tr>
</tbody>
</table>
</div>
</div>
