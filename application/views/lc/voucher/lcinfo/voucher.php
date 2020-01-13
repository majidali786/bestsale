<form class="form-horizontal main-form" role="form" onsubmit="return false;">
<div class="form-body">


<div class="form-actions right1 row">
<?php 
if(!empty($voucherrights[0]['AD']))
{
if($voucherrights[0]['AD']==1){
?>
<div class="col-sm-2">
<button type="submit" class="btn green">Save</button>
<button type="reset" class="btn default">Reset</button>
</div>
<?php 
}
}
?>
<div class="col-sm-3">
<div class="note note-danger ">
<p class="block">UnPosted By : <b></b></p>
</div> 
</div> 
<div class="col-sm-3">
<div class="note note-warning ">
<p class="block">Posted By : <b></b></p>
</div> 
</div> 
<div class="col-sm-3">
<div class="note note-success">
<p class="block">Approved By : <b></b></p>
</div>
</div>
</div>


<div class="row">
<div class="row margin-0">
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Voucher No.<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-start move-enter-1" data-position="1" int-numbers-only name="no" value="<?= $max;?>" placeholder="Voucher No.">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Voucher Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-2" data-position="2" input-mask-date name="vdate" value="<?= $vdate?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>
<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Lc Account<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="lccode" id="lccode" class="form-control select2 move-enter-up move-enter-3" data-position="3">
<option value="">Select Lc Account</option>
<?php 
if(count($account)){
foreach($account as $g){
?>
<option value="<?= $g['ACODE'];?>"><?= $g['ANAME']; ?></option>
<?php
}
}
?>
</select>

</div>
</div>
</div>
<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Party Name<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="hidden" class="form-control" name="vcode" readonly placeholder="Party Code">
<select name="vname" id="vname" change-assign-value="vcode" data-through-ajax="address-address,balance-previous" class="form-control select2 move-enter-up move-enter-4" data-position="4">
<option value="">Select Party Name</option>
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

</div>
</div>
</div>


</div>
<div class="row margin-0">
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> LC No.<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up  move-enter-5" data-position="5" name="lcno" placeholder="LC No.">
</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> LC Code<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up  move-enter-6" data-position="6" name="lcode" placeholder="LC Code">
</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> LC Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-7" data-position="7" input-mask-date name="lcdate" value="<?= $vdate?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> LC Type<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="lctype" id="lctype" class="form-control select2 move-enter-up move-enter-8" data-position="8">
<option value="">Select LC Type</option>
<option value="0">Sight</option>
<option value="1">FATR</option>
<option value="2">DA</option>
<option value="3">ADV. By TT</option>
</select>

</div>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Indentor<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="indentor" id="indentor" class="form-control select2 move-enter-up move-enter-9" data-position="9">
<option value="">Select Indentor</option>
<?php 
if(count($indentor)){
foreach($indentor as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['INDENTOR']; ?></option>
<?php
}
}
?>
</select>

</div>
</div>
</div>

</div>
<div class="row margin-0">

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> ETD</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-10" data-position="10" input-mask-date name="etd" value="<?= $vdate?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> ETA</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-11" data-position="11" input-mask-date name="eta" value="<?= $vdate?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Maturity Date</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-12" data-position="12" input-mask-date name="mdate" value="<?= $vdate?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Tracking No.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up  move-enter-13" data-position="13" name="tracking" placeholder="Tracking No.">
</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Destination<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up  move-enter-14" data-position="14" name="destination" placeholder="Destination">
</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Origin<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up  move-enter-15" data-position="15" name="origin" placeholder="Origin">
</div>
</div>
</div>

</div>

<div class="row margin-0">


<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Bond</label>
<div class="col-md-12 show-error">
<select name="lcbond" id="lcbond" class="form-control select2 move-enter-up move-enter-16" data-position="16">
<option value="">Select Bond</option>
<?php 
if(count($lcbond)){
foreach($lcbond as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['LCBOND']; ?></option>
<?php
}
}
?>
</select>

</div>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Bank<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="bank" id="bank" class="form-control select2 move-enter-up move-enter-17" data-position="17">
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

</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Currency<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="currency" id="currency" class="form-control select2 move-enter-up move-enter-18" data-position="18">
<option value="">Select Currency</option>
<option value="0">USD</option>
<option value="1">EURO</option>
<option value="2">POUND</option>
</select>
</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Conversion Rate<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up  move-enter-19 move-to-row" data-position="19" name="conversion" placeholder="Conversion Rate">
</div>
</div>
</div>



</div>






<?php 
$this->load->view($loadRow);
?>


<div class="col-sm-12 data-rows flip-scroll">
<table class="table table-bordered table-striped table-condensed flip-content">
<thead class="flip-content theme-color border-theme">
<tr>
<th>#</th>
<th style="width:20%";>Product</th>
<th style="width:10%";>Unit</th>
<th style="width:10%";>Coil</th>
<th style="width:10%";>Qty(MT)</th>
<th style="width:10%";>Weight(MT)</th>
<th style="width:10%";>F.C Rate(MT)</th>
<th style="width:10%";>PKR Rate(MT)</th>
<th style="width:10%";>F.C Amount(MT)</th>
<th style="width:10%";>PKR Amount(MT)</th>
</tr>
</thead>
<tbody class="theme-border">

</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="4">Total</th>
<td class="theme-bg"><input type="text" name="tqty" /></td>
<td class="theme-bg"><input type="text" name="tweight" /></td>
<td colspan="2"></td>
<td class="theme-bg"><input type="text" name="fctamount" /></td>
<td class="theme-bg"><input type="text" name="tamount" /></td>
</tr>
</tfoot>
</table>
</div>

</div>
</div>
</form>
<script>
<?php 
if(!empty($dataType)){
?>
reinitializeTable(1);
<?php 
if(!empty($bissueError)){
?>
bootbox.dialog({title:notifications['error'],message:"<?= $bissueError?>",buttons:{close:{label:'Ok',className:"red",callback:function(){ location.href="<?= base_url("home")?>"; }}}});
<?php 	
}
?>	
<?php 	
}
?>
</script>