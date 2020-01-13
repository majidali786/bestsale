<form class="form-horizontal main-form" role="form" onsubmit="return false;">
<div class="form-body">


<div class="form-actions right1 row">
<?php 
if(!empty($voucherrights[0]['AD']))
{
if($voucherrights[0]['AD']==1){
?>
<div class="col-sm-3">
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
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label" ><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Voucher No.<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" style="text-align:center;" class="form-control move-enter-up move-enter-start move-enter-1" data-position="1" int-numbers-only name="no" value="<?= $max;?>" placeholder="Voucher No.">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Voucher Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" style="text-align:center;" class="form-control move-enter-up move-enter-2" data-position="2" input-mask-date name="vdate" value="<?= $vdate?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher" style="text-align: center;"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Cash Acc.Name<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="hidden" class="form-control" name="cacode" readonly placeholder="Cash Account Code">
<select name="caname" id="caname" change-assign-value="cacode" class="form-control select2 move-enter-up move-to-row move-enter-3" data-position="3">
<option value="">Select Cash Account Name</option>
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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Sms(Arabic)</label>
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


<?php 
$this->load->view($loadRow);
?>

<div class="col-sm-12 data-rows flip-scroll">
<table class="table table-bordered table-striped table-condensed flip-content">
<thead class="flip-content theme-color border-theme">
<tr>
<th style="text-align-center">Sr#</th>
<th style="text-align-center">Party/Account</th>
<th style="text-align-center">Invoices</th>
<th style="text-align-center">Inv. Amount</th>
<th style="text-align-center">Description</th>
<th style="text-align-center">Amount</th>
</tr>
</thead>
<tbody class="theme-border">

</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="5">Total</th>
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
}
?>
</script>