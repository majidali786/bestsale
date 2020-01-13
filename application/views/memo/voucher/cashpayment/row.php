<div class="col-sm-12 data-row">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed" style="width:1150px;">
<thead class="theme-bg">
<tr>
<th style="width:300px;">Party/Account</th>
<th style="width:150px;">Invoices</th>
<th style="width:150px;">Inv. Amount</th>
<th style="width:300px;">Description</th>
<th style="width:150px;">Amount</th>
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
</select></td>
<td><select name="invoices" id="invoices" value-splitter=","  value-index="1"  change-assign-value="invAmt" ajax-data  class="form-control select2 move-enter-row enter-2" data-position="2">
<option value="">Select Invoice</option>

</select></td>
<td><input type="text" class="form-control" name="invAmt" readonly placeholder="Invoice Amount"></td>
<td><input type="text" class="form-control move-enter-row enter-3" data-required data-position="3" name="descrip" placeholder="Description"></td>
<td><input type="text" data-required data-only-numbers greater-then-zero  data-sum="tamount" class="form-control  move-enter-row enter-4 row-end" data-position="4" name="amount" placeholder="Amount"></td>
</tr>
</tbody>
</table>
</div>
</div>
