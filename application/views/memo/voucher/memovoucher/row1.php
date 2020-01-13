<div class="col-sm-12 data-row">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed" style="width:750px;">
<thead class="theme-bg">
<tr>
<th style="width:300px;">Services</th>
<th style="width:300px;">Description</th>
<th style="width:150px;">Amount</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="pcode" class="hidden-data" />
<select name="pname" id="pname" change-assign-value="pcode" data-required hidden-data="pcode" data-name-array="aname_name" class="form-control select2 move-enter-row enter-1 row-start" data-position="1" >
<option value="">Select Services</option>
<?php 
if(count($services)){
foreach($services as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['SERVICES']; ?></option>
<?php
}
}
?>
</select></td>
<td>
<input type="text"  class="form-control move-enter-row enter-2" name="descrip"  placeholder="Description" data-position="2">
</td>
<td>
<input type="text" data-required data-only-numbers  class="form-control move-enter-row enter-3 row-end" name="amount" data-sum="tamount" placeholder="Amount"  data-position="3">
</td>
</tr>
</tbody>
</table>
</div>
</div>
<script>
<?php 
if(!empty($dataType)){
?>
$('[name=pname]').select2({width:"100%"});
$('.for-scroll').optiscroll();
<?php 	
}
?>
</script>
