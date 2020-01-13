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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Party Name<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="hidden" class="form-control" name="vcode" readonly placeholder="Party Code">
<select name="vname" id="vname" change-assign-value="vcode" data-through-ajax="address-address,balance-previous" class="form-control select2 move-enter-up move-enter-3" data-position="3">
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
<div class="form-group show-error">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Sale Order No.</label>
<div class="col-md-5 padding-left-yes">
<input type="text" readonly class="form-control move-enter-up move-enter-4" data-position="4" name="sordrno"  placeholder="Sale Order No.">
</div>
<div class="col-md-7 padding-0">
<button type="button" class="btn green"><i class="icon-list"></i></button> 
<button type="button" class="btn green"><i class="icon-arrow-down"></i></button>
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group show-error">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> DC No.</label>
<div class="col-md-5 padding-left-yes">
<input type="text" readonly class="form-control move-enter-up move-enter-5" data-position="5" name="dcno"  placeholder="DC No.">
</div>
<div class="col-md-7 padding-0">
<button  type="button" class="btn green"><a href="javascript:void(0);" onclick="pend_invoices('Pending Challan','/pchalan','<?= base_url("sales/sale-voucher")?>');"><i class="icon-list"></i></a></button> 
<button type="button" id="load-dc" class="btn green"><i class="icon-arrow-down"></i></button>
</div>
</div>
</div>
<div class="col-sm-3">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Sales Account<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="sacode" id="sacode" class="form-control select2 move-enter-up move-enter-6" data-position="6">
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

<div class="col-sm-1"></div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Sale</label>
<div class="col-md-12 show-error">
<div class="md-checkbox">
<input type="checkbox" id="dcsale" name="dcsale" value="1" class="md-check">
<label for="dcsale">
<span class="inc"></span>
<span class="check"></span>
<span class="box"></span> <b>DC</b></label>
</div>
</div>
</div>
</div>
</div>
<div class="row margin-0">
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Book No. <?php if($voucherrights[0]['APPROVED']==1){ ?> <a href="javascript:;" class="bookno-closed">(Closed)</a> <?php  }?></label>
<div class="col-md-8 show-error  padding-left-yes">
<input type="text" class="form-control move-enter-up move-enter-8" data-position="8" <?php if($voucherrights[0]['APPROVED']!=1){ echo "readonly"; } ?> name="vno" value="<?php if(!empty($maxBissue)){
echo $maxBissue;	
}?>"  placeholder="Book No.">
</div>
<div class="col-md-4 padding-0">
<button type="button" class="btn green clear-bno"><i class="icon-close"></i></button> 
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Sales Type<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="stype" id="stype" class="form-control select2 move-enter-up move-enter-9" data-position="9">
<option value="">Select Sales Type</option>
<option value="0">Cash</option>
<option value="1">Credit</option>
</select>
</div>
</div>
</div>
<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Remarks.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-to-row move-enter-10" data-position="10" name="remarks"  placeholder="Remarks">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Sms(Eng)</label>
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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Sms(Urdu)</label>
<div class="col-md-12 show-error">
<div class="md-checkbox">
<input type="checkbox" id="smsurdu" name="smsurdu" value="1" class="md-check">
<label for="smsurdu">
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
<th>#</th>
<th style="width:40%";>Product</th>
<th style="width:10%";>Unit</th>
<th style="width:10%";>Weight</th>
<th style="width:10%";>Qty</th>
<th style="width:10%";>Rate</th>
<th style="width:10%";>Amount</th>
</tr>
</thead>
<tbody class="theme-border"  load-lcinfo>

</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="3">Total</th>
<td class="theme-bg"><input type="text" name="twght" /></td>
<td class="theme-bg"><input type="text" name="tqty" /></td>
<td colspan="2"></td>
<td class="theme-bg"><input type="text" name="tamount" /></td>
</tr>
</tfoot>
</table>
</div>
<div class="col-sm-12">
<table class="table table-bordered table-striped table-condensed flip-content">
<tr class="theme-bg">
<th>Kanta Weight</th>
<th>Discount</th>
<th>Freight</th>
<th>Loading</th>
<th>Others</th>
<th>Net</th>
</tr>
<tr>
<td class="show-error"><input type="text" class="form-control move-enter-up move-enter-11" data-position="11" name="kweight" data-only-numbers  placeholder="Kanta Weight"></td>
<td  class="show-error"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-12" data-position="12" data-dmas="tamount-add,discount-minus,freight-add,loading-add,others-add,net-result,current-result,previous-add,total-result" name="discount"  placeholder="Discount"></td>
<td  class="show-error"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-13" data-position="13" name="freight" data-dmas="tamount-add,discount-minus,freight-add,loading-add,others-add,net-result,current-result,previous-add,total-result"  placeholder="Freight"></td>
<td  class="show-error"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-14" data-position="14" name="loading" data-dmas="tamount-add,discount-minus,freight-add,loading-add,others-add,net-result,current-result,previous-add,total-result" placeholder="Loading"></td>
<td  class="show-error"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-15" data-position="15" name="others" data-dmas="tamount-add,discount-minus,freight-add,loading-add,others-add,net-result,current-result,previous-add,total-result"  placeholder="Others"></td>
<td><input type="text" class="form-control theme-bg" readonly name="net"  placeholder="Net"></td>
</tr>
<tr class="theme-bg">
<th>Bilty No</th>
<th>Bilty Date</th>
<th>Ship Via</th>
<th>Previous</th>
<th>Current</th>
<th>Total</th>
</tr>
<tr>
<td  class="show-error"><input type="text" class="form-control move-enter-up move-enter-16" data-position="16" name="bno"  placeholder="Bilty No"></td>
<td  class="show-error"><input type="text" input-mask-date class="form-control move-enter-up move-enter-17" data-position="17" name="bdate"  placeholder="dd/mm/yyyy"></td>
<td  class="show-error"><input type="text" class="form-control move-enter-up move-enter-18" data-position="18" name="transport"  placeholder="Ship Via"></td>
<td><input type="text" class="form-control theme-bg" readonly name="previous"  placeholder="Previous"></td>
<td><input type="text" class="form-control theme-bg" readonly name="current"  placeholder="Current"></td>
<td><input type="text" class="form-control theme-bg" readonly name="total"  placeholder="Total"></td>
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