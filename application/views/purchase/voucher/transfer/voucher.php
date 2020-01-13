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
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Voucher Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text"  style="text-align:center" class="form-control move-enter-up move-enter-2" data-position="2" input-mask-date name="vdate" value="<?= $vdate?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>


<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Party Name<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="hidden" class="form-control" name="vcode" readonly placeholder="Party Code">
<select name="vname" id="vname" change-assign-value="vcode" data-through-ajax="address-address,balance-previous,climit-limit" class="form-control select2 move-enter-up move-enter-3" data-position="3">
<option value="">Select Party Name</option>
<optgroup label="Customers">
<?php 
if(count($party)){
foreach($party as $g){
?>
<option value="<?= $g['VCODE'];?>"><?= $g['VCODE'].' - '.$g['VNAME']; ?></option>
<?php
}
}
?>
</optgroup>
</select>

</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Address.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control" name="address" readonly placeholder="Address">
</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Complete</label>
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

</div>


</div>
<div class="row margin-0">
<div class="col-sm-2">
<div class="form-group show-error">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i>Order No.</label>
<div class="col-md-5 padding-left-yes">
<input type="text"  class="form-control move-enter-up move-enter-4 pdata" data-position="4" name="sordrno"  placeholder="Sale Order No.">
</div>
<div class="col-md-6 padding-0">
<button type="button" class="btn green"><a href="javascript:void(0);" onclick="pend_invoices('Pending Orders','/porders','<?= base_url("purchase/transfer-order")?>');"><i class="icon-list"></i></a></button> 
<button type="button" id="load-pdata" class="btn green"><i class="icon-arrow-down"></i></button>
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Order Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text"  style="text-align:center" class="form-control move-enter-up move-enter-5" data-position="5" input-mask-date name="odate" value="<?= $odate?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Cargo<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="hidden" class="form-control" name="ccode" readonly placeholder="Cargo Code">
<select name="cargo" id="cargo" change-assign-value="ccode" data-through-ajax="" class="form-control select2 move-enter-up move-enter-6" data-position="6">
<option value="">Select Cargo</option>
<optgroup label="Cargo">
<?php 
if(count($cargo)){
foreach($cargo as $g){
?>
<option value="<?= $g['CODE'];?>"><?= $g['CODE'].' - '.$g['VNAME']; ?></option>
<?php
}
}
?>
</optgroup>
</select>

</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Delivery Days.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-to-row move-enter-7" data-position="7" name="crdays" value="0"  placeholder="Delivery Days">
</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Remarks.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-to-row move-enter-8" data-position="8" name="remarks"  placeholder="Remarks">
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
<th style="width:50%;text-align:center">Design/Style</th>
<th style="width:12%;text-align:center">Color</th>
<th style="width:12%;text-align:center">Order Qty</th>
<th style="width:12%;text-align:center">Transfer Qty</th>
<th style="width:12%;text-align:center">Pending Qty</th>
</tr>
</thead>
<tbody class="theme-border"  load-lcinfo>

</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="4">Total</th>
<td class="theme-bg th-right"><input type="text" name="tqty" ></td>
<td colspan="2"></td>
</tr>
</tfoot>
</table>
</div>
</div>
</div>

<div class="portlet-body" data-pchalan>

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