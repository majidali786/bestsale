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
<input type="text" style="text-align:center" class="form-control move-enter-up move-enter-start move-enter-1" data-position="1" int-numbers-only name="no" value="<?= $max;?>" placeholder="Voucher No.">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i>Voucher Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" style="text-align:center" class="form-control move-enter-up move-enter-2" data-position="2" input-mask-date name="vdate" value="<?= $vdate?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>
<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Party Name<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="hidden" class="form-control" name="vcode" readonly placeholder="Party Code">
<select name="vname" id="vname" change-assign-value="vcode" data-through-ajax="address-address" 
class="form-control select2 move-enter-up move-enter-3" data-position="3">
<option value="">Select Party Name</option>
<?php 
if(count($party)){
foreach($party as $g){
?>
<option value="<?= $g['VCODE'];?>" ><?= $g['VNAME']; ?></option>
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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Address.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control" name="address" readonly placeholder="Address">
</div>
</div>
</div>
</div>
<div class="row margin-0">
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Bill No.</label>
<div class="col-md-12 show-error">
<input type="text" style="text-align:center"  class="form-control move-enter-up move-enter-4" 
data-position="4" name="vno" required  placeholder="Bill No.">
</div>
</div>
</div>
<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i>Sales Account<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="sacode" id="sacode" class="form-control select2 move-enter-up move-enter-5" data-position="5">
<option value="">Select Sales Account</option>
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
<div class="col-sm-3">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Mobile.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-6" data-position="6" name="mobile"  placeholder="Mobile">
</div>
</div>
</div>
<div class="col-sm-3">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> E-Mail.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-7" data-position="7" name="email"  placeholder="E-Mail">
</div>
</div>
</div>

</div>

<div class="row margin-0">

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i>Salesman<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="saleman" id="saleman" class="form-control select2 move-enter-up move-enter-8" data-position="8">
<option value="">Select Salesman</option>
<?php 
if(count($salesman)){
foreach($salesman as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['NAME']; ?></option>
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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Remarks.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-to-row move-enter-9" data-position="9" name="remarks"  placeholder="Remarks">
</div>
</div>
</div>


<div class="col-sm-1">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Tax</label>
<div class="col-md-12 show-error">
<div class="md-checkbox">
<input type="checkbox" id="sms" name="sms" value="1" class="md-check">
<label for="sms">
<span class="inc"></span>
<span class="check"></span>
<span class="box"></span> <b>Yes</b></label>
</div>
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Wholesales</label>
<div class="col-md-12 show-error">
<div class="md-checkbox">
<input type="checkbox" id="sms2" name="sms2" value="1" class="md-check">
<label for="sms2">
<span class="inc"></span>
<span class="check"></span>
<span class="box"></span> <b>Yes</b></label>
</div>
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
<th>Sr#</th>
<th style="text-align:center;width:45%";>Product Name</th>
<th style="text-align:center;width:10%";>Unit</th>
<th style="text-align:center;width:10%";>Qty</th>
<th style="text-align:center;width:15%";>Rate</th>
<th style="text-align:center;width:15%";>Amount</th>
<th style="text-align:center;width:10%";>Stock</th>
</tr>
</thead>
<tbody class="theme-border">

</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="3">Total</th>
<td class="theme-bg th-right"><input type="text" name="tqty" /></td>
<td colspan="1"></td>
<td class="theme-bg th-right"><input type="text" name="tamount" /></td>
</tr>
</tfoot>
</table>
</div>
<div class="col-sm-12">
<table class="table table-bordered table-striped table-condensed flip-content">
<tr class="theme-bg">
<th style="width:50%"></th>
<th>Received Amount</th>
<th>Discount in(%)</th>
<th>Discount (Rs)</th>
</tr>
<tr>
<td></td>
<td  class="show-error th-right"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-12" name="rect"  placeholder="Received Amount"></td>
<td  class="show-error th-right"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-12" data-position="12" data-dmas="tamount-add,gst-dpercent-gstamt,net-result" name="gst"  placeholder="Discount (%)"></td>
<td  class="show-error th-right"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-13" data-position="13" name="gstamt" data-dmas="tamount-add,gstamt-dpercentage-gst,net-result"  placeholder="Discount(Rs)"></td>
</tr>
<tr>
<td></td>
<td></td>
<th class="theme-bg">Net Balance</th>
<td><input type="text" class="form-control theme-bg th-right" readonly name="net"  placeholder="Invoice Total"></td>
</tr>
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
}
?>

</script>