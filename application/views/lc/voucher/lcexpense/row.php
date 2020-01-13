<div class="col-sm-12 data-row">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed" style="width:1050px;">
<thead class="theme-bg">
<tr>
<th style="width:300px;">Expense Type</th>
<th style="width:300px;">L/C No.</th>
<th style="width:300px;">Description</th>
<th style="width:150px;">Amount</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="lcid" class="hidden-data" />
<select name="lcaccount" id="lcaccount" change-assign-value="lcid" data-required hidden-data="lcid" data-name-array="aname_name" class="form-control select2 move-enter-row enter-1 row-start" data-position="1" >
<option value="">Select Expense Type</option>
<?php 
if(count($lcaccount)){
foreach($lcaccount as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['LCACCOUNT']; ?></option>
<?php
}
}
?>
</select>
</td>
<td>
<input type="hidden" name="acode" class="hidden-data" />
<select name="aname" id="aname" change-assign-value="acode" data-required hidden-data="acode" class="form-control select2 move-enter-row enter-2" data-position="2" >
<option value="">Select LC NO</option>
<optgroup label="Accounts">
<?php 
if(count($lcno)){
foreach($lcno as $g){
?>
<option value="<?= $g['LCNO'];?>"><?= $g['LCNO']; ?></option>
<?php
}
}
?>
</optgroup>
</select>
</td>
<td><input type="text" class="form-control move-enter-row enter-3" data-required data-position="3" name="descrip" placeholder="Description"></td>
<td><input type="text" data-required data-only-numbers greater-then-zero  data-sum="tamount" class="form-control  move-enter-row enter-4 row-end" data-position="4" name="amount" placeholder="Amount"></td>
</tr>
</tbody>
</table>
</div>
</div>
