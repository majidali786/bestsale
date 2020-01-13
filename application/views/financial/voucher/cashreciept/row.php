<div class="col-sm-12 data-row">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed" style="width:1108px;">
<thead class="theme-bg">
<tr>
<th style="text-align:center;width:300px;">Invoices</th>
<th style="text-align:center;width:150px;">Inv. Amount</th>
<th style="text-align:center;width:250px;">Party/Account</th>
<th style="text-align:center;width:300px;">Description</th>
<th style="text-align:center;width:150px;">Amount</th>
</tr>
</thead>
<tbody>
<tr>

<td>
<input type="hidden" name="pcode" class="hidden-data" />
<select name="pname" id="pname" change-assign-value="pcode" data-required hidden-data="pcode" data-name-array="aname_name"
 class="form-control select2 move-enter-row enter-1 row-start" data-position="1" >
<option value="">Select Invoices</option>
<?php 
if(count($invoiceno)){
foreach($invoiceno as $g){
?>
<option value="<?= $g['INVNO'];?>"> Invoice : <?= $g['INVNO']; ?> - <?= $g['VNAME']; ?> : <?= $g['DIF']; ?></option>
<?php
}
}
?>
</select></td>
<td><input type="text"  class="form-control" name="invAmt" readonly placeholder="Invoice Amount"></td>

<td>

<input type="text" class="form-control" name="apname"readonly placeholder="Party Name"></td>
<td><input type="text" class="form-control move-enter-row enter-2" data-required data-position="2" 
name="descrip" placeholder="Description"></td>
<td class="th-right"><input type="text" data-required data-only-numbers greater-then-zero  data-sum="tamount" 
class="form-control  move-enter-row enter-3 row-end" data-position="3" name="amount" placeholder="Amount"></td>
</tr>
</tbody>
</table>
</div>
</div>
