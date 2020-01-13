
<div class="col-sm-12 data-row">
<div class="for-scroll optiscroll">
<table class="table table-bordered table-striped table-condensed" style="width:1050px;">
<thead class="theme-bg">
<tr>
<th style="width:300px;">Party</th>
<th style="width:300px;">Description</th>
<th style="width:150px;">Make Date</th>
<th style="width:150px;">Promise Date</th>
<th style="width:150px;">Amount</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="acode" class="hidden-data" />
<select name="aname" id="aname" data-ajax-request="invoices,refChqNo" change-assign-value="acode" data-required hidden-data="acode" data-name-array="aname_name" class="form-control select2 move-enter-row enter-1 row-start" data-position="1" >
<option value="">Select Party/Account</option>
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
</select>
</td>
<td><input type="text" class="form-control move-enter-row enter-2" data-required data-position="2" name="descrip" placeholder="Description"></td>
<td><input type="text" class="form-control move-enter-row enter-3" input-mask-date data-position="3" name="pmdate" data-required  placeholder="dd/mm/yyyy" value="<?= $vdate?>"></td>
<td><input type="text" class="form-control move-enter-row enter-4" input-mask-date data-position="4" name="pdate" data-required  placeholder="dd/mm/yyyy"></td>
<td><input type="text" data-required data-only-numbers data-sum="tamount" class="form-control  move-enter-row enter-5 row-end" data-position="5" name="amount" placeholder="Amount"></td>
</tr>
</tbody>
</table>
</div>
</div>
