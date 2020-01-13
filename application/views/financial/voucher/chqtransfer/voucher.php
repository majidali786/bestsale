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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> From Account<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="faccount" id="faccount" class="form-control select2 move-enter-up move-enter-3" data-position="3">
<option value="">Select From Account</option>
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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> To Account<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="taccount" id="taccount" class="form-control select2 move-enter-up  move-enter-4" data-position="4">
<option value="">Select To Account</option>
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
<label class="control-label col-md-12"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> As On</label>
<div class="col-md-9 show-error padding-left-yes">
<input class="form-control date-range-picker" size="16" type="text"  name="date" value="<?= "01/01/2017 - ".date("d/m/Y")?>" />
</div>
<div class="col-md-3 padding-0">
<button type="button" class="btn green load-cheques">Load <i class="icon-arrow-down"></i></button> 
</div>
</div>
</div>
<input type="hidden" name="amount" data-sum="tamount" />

<div class="col-sm-12 data-rows flip-scroll">
<table class="table table-bordered table-striped table-condensed flip-content">
<thead class="flip-content theme-color border-theme">
<tr>
<th>#</th>
<th>Party/Account</th>
<th>Bank</th>
<th>Description</th>
<th>Cheque No.</th>
<th>Chq. Date</th>
<th>Amount</th>
<th>
Action
<div class="list-icon-container done" style="display:inline">
<div class="md-checkbox has-error" style="display:inline">
<input type="checkbox" id="selectChqAll" name="selectChqAll" value="1" class="md-check">
<label for="selectChqAll">
<span></span>
<span class="check"></span>
<span class="box"></span></label>
</div>
</div>
</th>
</tr>
</thead>
<tbody class="theme-border">

</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="6">Total</th>
<td class="theme-bg"><input type="text" name="tamount" /></td>
<th></th>
</tr>
</tfoot>
</table>
</div>

</div>
</div>
<input type='hidden' name='nrows' value='1' />
</form>
<script>
<?php 
if(!empty($dataType)){
?>
reinitializeTable(1);
$("[name=date]").daterangepicker({
  minDate: moment().subtract(2, 'years'),
  callback: function (startDate, endDate, period) {
    $(this).val(startDate.format('DD/MM/YYYY') + ' - ' + endDate.format('DD/MM/YYYY'));
  },
  startDate:'2017-01-01',
  endDate:'<?= date("Y-m-d");?>',
  maxDate:moment().add(1, 'years')
});
<?php 	
}
?>
</script>