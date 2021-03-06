
<div class="col-sm-12 data-row">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed" style="width:1450px;">
<thead class="theme-bg">
<tr>
<th style="width:300px;">Party/Account</th>
<th style="width:150px;">Bank</th>
<th style="width:150px;">Type</th>
<th style="width:300px;">Description</th>
<th style="width:150px;">Cheque No.</th>
<th style="width:150px;">Cheque Date</th>
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
<td>
<input type="hidden" name="bcode" class="hidden-data" />
<select name="bank" id="bank" change-assign-value="bcode" data-required hidden-data="bcode" data-name-array="aname_name" class="form-control select2 move-enter-row enter-2" data-position="2">
<option value="">Select Bank</option>
<?php 
if(count($bank)){
foreach($bank as $g){
?>
<option value="<?= $g['BCODE'];?>"><?= $g['BNAME']; ?></option>
<?php
}
}
?>
</select>
</td>
<td>
<select name="ctype" id="ctype" class="form-control select2 move-enter-row enter-3" data-position="3">
<option value="">Select Bank</option>
<?php 
if(count($bank)){
foreach($bank as $g){
?>
<option value="<?= $g['BCODE'];?>"><?= $g['BNAME']; ?></option>
<?php
}
}
?>
</select>
</td>
<td><input type="text" class="form-control move-enter-row enter-4 row-end" data-required data-position="4" name="descrip" placeholder="Description"></td>
<td><input type="text" class="form-control"  name="chqNo" readonly  placeholder="Cheque No." ></td>
<td><input type="text" class="form-control" input-mask-date readonly name="chqDate" data-required  placeholder="dd/mm/yyyy"></td>
<td><input type="text" readonly  data-sum="tamount" class="form-control" name="amount" placeholder="Amount"></td>
</tr>
</tbody>
</table>
</div>
</div>
