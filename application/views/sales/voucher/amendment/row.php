
<div class="col-sm-12 data-row">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed">
<thead class="theme-bg">
<tr>
<th>Party/Account</th>
<th>Description</th>
<th>Debit</th>
<th>Credit</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="acode" class="hidden-data" />
<select name="aname" id="aname" data-ajax-request="invoices,refChqNo" change-assign-value="acode" data-required hidden-data="acode" data-name-array="aname_name" class="form-control select2 move-enter-row enter-1 row-start" data-position="1" >
<option value="">Select Party/Account</option>
<optgroup label="Accounts">
<?php 
if(count($account)){
foreach($account as $g){
?>
<option value="<?= $g['ACODE'];?>"><?= $g['ACODE']."-".$g['ANAME']; ?></option>
<?php
}
}
?>
</optgroup>
<optgroup label="Customers">
<?php 
if(count($party)){
foreach($party as $g){
?>
<option value="<?= $g['VCODE'];?>"><?= $g['VCODE']."-".$g['VNAME']; ?></option>
<?php
}
}
?>
</optgroup>
<optgroup label="Suppliers">
<?php 
if(count($supplier)){
foreach($supplier as $g){
?>
<option value="<?= $g['VCODE'];?>"><?= $g['VCODE']."-".$g['VNAME']; ?></option>
<?php
}
}
?>
</optgroup>
</select>
</td>
<td><input type="text" class="form-control move-enter-row enter-2" data-required data-position="2" name="descrip" placeholder="Description"></td>
<td><input type="text" data-required data-only-numbers if-greater-then-zero="credit"  data-sum="tdebit" class="form-control  move-enter-row enter-3" data-position="3" name="debit" placeholder="Debit"></td>
<td><input type="text" data-required data-only-numbers  credit data-sum="tcredit" class="form-control  move-enter-row enter-4 row-end" if-greater-then-zero="debit" data-position="4" name="credit" placeholder="Credit"></td>
</tr>
</tbody>
</table>
</div>
</div>
