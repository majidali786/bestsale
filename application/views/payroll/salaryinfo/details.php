<div class="note note-success margin-bottom-10 col-sm-12">
<h3 class="margin-0"><b><i class="icon-mustache"></i> Emplopyee Information</b></h3>
</div>
<?php 
$status=array("Permanent","Temporary","Daily Wages","Contract");
?>
<div class="col-sm-4">
<h4><b>Department :</b> <?= $datae[0]['DEPARTMENT']?></h4>
</div>
<div class="col-sm-4">
<h4><b>Designation :</b> <?= $datae[0]['DESIGNATION']?></h4>
</div>
<div class="col-sm-4">
<h4><b>Type :</b> <?= $status[$datae[0]['STATUS']]?></h4>
</div>
<div class="row">
<div class="col-sm-6">
<div class="note note-success margin-bottom-10 col-sm-12">
<h3 class="margin-0"><b><i class="icon-plus"></i> Allowances</b></h3>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">Basic Pay</label>
<div class="col-sm-3 show-error">
<input type="text" class="form-control" data-dmas="callowance-add,conveyance-add,utility-add,overtime-add,tallowances-result,basic-add,gpay-result,tdeduction-minus,npay-result" int-numbers-only name="basic" placeholder="Basic Pay">
</div>
<label class="col-sm-3 control-label">City Allow.</label>
<div class="col-sm-3 show-error">
<input type="text" class="form-control" data-dmas="callowance-add,conveyance-add,utility-add,overtime-add,tallowances-result,basic-add,gpay-result,tdeduction-minus,npay-result"  int-numbers-only name="callowance" placeholder="City Allow.">
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label">Conveyance</label>
<div class="col-sm-3 show-error">
<input type="text" class="form-control" data-dmas="callowance-add,conveyance-add,utility-add,overtime-add,tallowances-result,basic-add,gpay-result,tdeduction-minus,npay-result"  int-numbers-only name="conveyance" placeholder="Conveyance">
</div>
<label class="col-sm-3 control-label">Utility</label>
<div class="col-sm-3 show-error">
<input type="text" class="form-control" data-dmas="callowance-add,conveyance-add,utility-add,overtime-add,tallowances-result,basic-add,gpay-result,tdeduction-minus,npay-result"  int-numbers-only name="utility" placeholder="Utility">
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">Over Time</label>
<div class="col-sm-3 show-error">
<input type="text" class="form-control" data-dmas="callowance-add,conveyance-add,utility-add,overtime-add,tallowances-result,basic-add,gpay-result,tdeduction-minus,npay-result" int-numbers-only name="overtime" placeholder="Over Time">
</div>
</div>

</div>

<div class="col-sm-6">
<div class="note note-success margin-bottom-10 col-sm-12">
<h3 class="margin-0"><b><i class="icon-minus"></i> Deductions</b></h3>
</div>


<div class="form-group">
<label class="col-sm-3 control-label">Loan</label>
<div class="col-sm-3 show-error">
<input type="text" class="form-control" data-dmas="loan-add,advance-add,incometax-add,leave-add,eobi-add,tdeduction-result,clear-clear-clear,gpay-add,tdeduction-minus,npay-result" int-numbers-only name="loan" placeholder="Loan">
</div>
<label class="col-sm-3 control-label">Advance</label>
<div class="col-sm-3 show-error">
<input type="text" class="form-control" data-dmas="loan-add,advance-add,incometax-add,leave-add,eobi-add,tdeduction-result,clear-clear-clear,gpay-add,tdeduction-minus,npay-result"  int-numbers-only name="advance" placeholder="Advance">
</div>
</div>
<div class="form-group">
<label class="col-sm-3 control-label">Income Tax</label>
<div class="col-sm-3 show-error">
<input type="text" class="form-control" data-dmas="loan-add,advance-add,incometax-add,leave-add,eobi-add,tdeduction-result,clear-clear-clear,gpay-add,tdeduction-minus,npay-result"  int-numbers-only name="incometax" placeholder="Income Tax">
</div>
<label class="col-sm-3 control-label">Leave</label>
<div class="col-sm-3 show-error">
<input type="text" class="form-control" data-dmas="loan-add,advance-add,incometax-add,leave-add,eobi-add,tdeduction-result,clear-clear-clear,gpay-add,tdeduction-minus,npay-result"  int-numbers-only name="leave" placeholder="Leave">
</div>
</div>

<div class="form-group">
<label class="col-sm-3 control-label">E.O.B.I</label>
<div class="col-sm-3 show-error">
<input type="text" class="form-control" data-dmas="loan-add,advance-add,incometax-add,leave-add,eobi-add,tdeduction-result,clear-clear-clear,gpay-add,tdeduction-minus,npay-result"  int-numbers-only name="eobi" placeholder="E.O.B.I">
</div>
</div>

</div>
</div>
<div class="row">
<div class="col-sm-6">
<div class="note note-success margin-bottom-10 col-sm-12">
<h3 class="margin-0"><b><i class="icon-clock"></i> Working Hours</b></h3>
</div>
<div class="form-group">
<label class="col-sm-6 control-label">Total Working Hours Of a Day</label>
<div class="col-sm-6 show-error">
<input type="text" class="form-control" name="whours" placeholder="Total Working Hours Of a Day">
</div>
</div>
</div>
<div class="col-sm-6">
<div class="note note-success margin-bottom-10 col-sm-12">
<h3 class="margin-0"><b><i class="icon-calendar"></i> Leaves</b></h3>
</div>
<div class="form-group">
<label class="col-sm-6 control-label">Total Leaves for Whole Year</label>
<div class="col-sm-6 show-error">
<input type="text" class="form-control" int-numbers-only name="yleave" placeholder="Total Leaves for Whole Year">
</div>
</div>
</div>
</div>

<div class="col-sm-12">
<div class="note note-success margin-bottom-10 col-sm-12">
<h3 class="margin-0"><b><i class="icon-calculator"></i> Total</b></h3>
</div>
<div class="col-sm-6">
<div class="form-group">
<label class="col-sm-5 control-label">Total Allowances</label>
<div class="col-sm-7 show-error">
<input type="text" class="form-control" int-numbers-only readonly name="tallowances" placeholder="Total Allowances">
</div>
</div>

<div class="form-group">
<label class="col-sm-5 control-label">Gross Pay</label>
<div class="col-sm-7 show-error">
<input type="text" class="form-control" int-numbers-only readonly name="gpay" placeholder="Gross Pay">
</div>
</div>
</div>

<div class="col-sm-6">
<div class="form-group">
<label class="col-sm-5 control-label">Total Deductions</label>
<div class="col-sm-7 show-error">
<input type="text" class="form-control" int-numbers-only readonly name="tdeduction" placeholder="Total Deductions">
</div>
</div>

<div class="form-group">
<label class="col-sm-5 control-label">Net Pay</label>
<div class="col-sm-7 show-error">
<input type="text" class="form-control" int-numbers-only readonly name="npay" placeholder="Net Pay">
</div>
</div>
</div>
</div>

<div class="form-actions margin-top-10 col-sm-12">
<button type="submit" class="btn green">Save</button>
<button type="reset" class="btn default" >Reset</button>
</div>
<script>
<?php 
if(!empty($data)){
?>
$(document).find("[name=basic]").val(<?= $data[0]['BASIC']?>);
$(document).find("[name=callowance]").val(<?= $data[0]['CALLOWANCE']?>);
$(document).find("[name=conveyance]").val(<?= $data[0]['CONVEYANCE']?>);
$(document).find("[name=overtime]").val(<?= $data[0]['OVERTIME']?>);
$(document).find("[name=utility]").val(<?= $data[0]['UTILITY']?>);
$(document).find("[name=loan]").val(<?= $data[0]['LOAN']?>);
$(document).find("[name=advance]").val(<?= $data[0]['ADVANCE']?>);
$(document).find("[name=incometax]").val(<?= $data[0]['INCOMETAX']?>);
$(document).find("[name=leave]").val(<?= $data[0]['LEAVE']?>);
$(document).find("[name=eobi]").val(<?= $data[0]['EOBI']?>);
$(document).find("[name=tallowances]").val(<?= $data[0]['TALLOWANCE']?>);
$(document).find("[name=gpay]").val(<?= $data[0]['GPAY']?>);
$(document).find("[name=tdeduction]").val(<?= $data[0]['TDEDUCTION']?>);
$(document).find("[name=npay]").val(<?= $data[0]['NPAY']?>);
$(document).find("[name=yleave]").val(<?= $data[0]['YLEAVE']?>);
<?php 	
}
?>
</script>