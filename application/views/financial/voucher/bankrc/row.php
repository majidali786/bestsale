<div class="col-sm-12 data-row">

<table class="table table-bordered table-striped table-condensed" style="width:1110px;">
<thead class="theme-bg">
<tr>
<th style="width:275px;">Party/Account</th>
<th style="width:250px;">Description</th>
<th style="width:100px;">Cheque No</th>
<th style="width:80px;">Cheque Date</th>
<th style="text-align:center;width:80px;">Amount</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="acode" class="hidden-data" />
<select name="aname" id="aname" data-through-ajax="refChqNo-refChqNo_view-html"  change-assign-value="acode" data-required hidden-data="acode" data-name-array="aname_name" class="form-control select2 move-enter-row enter-1 row-start" data-position="1" >
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
foreach($party as $g1){
?>
<option value="<?= $g1['VCODE'];?>"><?= $g1['VCODE']."-".$g1['VNAME']; ?></option>
<?php
}
}
?>
</optgroup>
<optgroup label="Suppliers">
<?php 
if(count($supplier)){
foreach($supplier as $g2){
?>
<option value="<?= $g2['VCODE'];?>"><?= $g2['VCODE']."-".$g2['VNAME']; ?></option>
<?php
}
}
?>
</optgroup>
</select>
</td>


<td><input type="text" class="form-control move-enter-row enter-2" data-required data-position="2" name="descrip" placeholder="Description"></td>
<td><input type="text" class="form-control move-enter-row enter-3" data-position="3" name="chqNo" placeholder="Cheque No." data-required  ></td>
<td><input type="text" class="form-control move-enter-row enter-4" input-mask-date data-position="4" name="chqDate" data-required  placeholder="dd/mm/yyyy" value="<?= date('d/m/Y')?>" ></td>
<td class="th-right"><input type="text" data-required data-only-numbers greater-then-zero  data-sum="tamount" class="form-control  move-enter-row enter-5 row-end" style="text-align:right;" data-position="5" name="amount" placeholder="Amount"></td>
</tr>
</tbody>
</table>

</div>
