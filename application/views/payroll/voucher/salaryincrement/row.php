
<div class="col-sm-12 data-row">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed" style="width:600px;">
<thead class="theme-bg">
<tr>
<th style="width:300px;">Employee</th>
<th style="width:150px;">Current Salary</th>
<th style="width:150px;">Incremented Salary</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="acode" class="hidden-data" />
<select name="aname" id="aname" data-ajax-request="invoices,refChqNo" change-assign-value="acode" data-required hidden-data="acode" data-name-array="aname_name" class="form-control select2 move-enter-row enter-1 row-start" data-position="1" >
<option value="">Employee</option>
<?php 
if(count($employee)){
foreach($employee as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['ID']."-".$g['NAME']; ?></option>
<?php
}
}
?>
</select>
</td>
<td><input type="text" class="form-control" data-required readonly name="current" placeholder="Current Salary"></td>

<td><input type="text" data-required data-only-numbers data-sum="tamount" class="form-control  move-enter-row enter-2 row-end" data-position="2" name="increment" placeholder="Incremented Salary"></td>
</tr>
</tbody>
</table>
</div>
</div>
