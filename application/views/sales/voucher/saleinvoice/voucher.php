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
<input type="text" class="form-control move-enter-up move-enter-start move-enter-1" data-position="1" int-numbers-only name="no" value="<?= $max;?>" style="text-align:center"  placeholder="Voucher No.">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Voucher Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-2" style="text-align:center" data-position="2" input-mask-date name="vdate" value="<?= $vdate?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>
<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Party Name<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="hidden" class="form-control" name="vcode" readonly placeholder="Party Code">
<select name="vname" id="vname" change-assign-value="vcode" data-through-ajax="address-address,ntn-ntn,saletax-saletax" class="form-control select2 move-enter-up move-enter-3" data-position="3">
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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Book No.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-4" data-position="4" name="vno" required  placeholder="Book No.">
</div>
</div>
</div>
<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Sales Account<span class="required">*</span></label>
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

<div class="col-sm-6">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Remarks.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-to-row move-enter-6" data-position="6" name="remarks"  placeholder="Remarks">
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
<th style="width:15%;text-align:center";>Product</th>
<th style="width:5%;text-align:center";>Unit</th>
<th style="width:8%;text-align:center";>Qty</th>
<th style="width:8%;text-align:center";>Rate</th>
<th style="width:10%;text-align:center";>Amount درهم</th>
<th style="width:8%;text-align:center";>Discount %</th>
<th style="width:8%;text-align:center";>Discount درهم</th>
<th style="width:10%;text-align:center";>Total درهم</th>
<th style="width:8%;text-align:center";>Vat %</th>
<th style="width:8%;text-align:center";>Vat.Amount درهم</th>
<th style="width:10%;text-align:center";>Net درهم</th>
</tr>
</thead>
<tbody class="theme-border"  load-lcinfo>

</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="3">Total</th>
<td class="theme-bg th-right"><input type="text" name="tqty" /></td>
<td></td>
<td class="theme-bg th-right"><input type="text" name="tamount" /></td>
<td></td>
<td class="theme-bg th-right"><input type="text" name="tdiscount" /></td>
<td class="theme-bg th-right"><input type="text" name="ttotal" /></td>
<td></td>
<td class="theme-bg th-right"><input type="text" name="tgst" /></td>
<td class="theme-bg th-right"><input type="text" name="tnet" /></td>
</tr>
</tfoot>
</table>
<div class="col-sm-12">
<table class="table table-bordered table-striped table-condensed flip-content">
<tr class="theme-bg">
<th style="width:60%"></th>
<th>Discount in(%)</th>
<th>Discount (Rs)</th>
</tr>
<tr>
<td></td>
<td  class="show-error th-right"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-12" data-position="12"
 data-dmas="tnet-add,dst-dpercent-gstamt,cnet-result" name="dst"  placeholder="Discount (%)"></td>
<td  class="show-error th-right"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-13" 
data-position="13" name="gstamt" data-dmas="tnet-add,gstamt-dpercentage-dst,cnet-result"  placeholder="Discount(Rs)"></td>
</tr>
<tr>
<td></td>
<th class="theme-bg">Net Balance</th>
<td><input type="text" class="form-control theme-bg th-right" readonly name="cnet"  placeholder="Invoice Total"></td>
</tr>
</table>
</div>
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