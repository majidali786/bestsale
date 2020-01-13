<form class="form-horizontal main-form edit-form" role="form" onsubmit="return false;">
<div class="form-body">


<div class="form-actions right1 row">
<?php 
if(!empty($voucherrights[0]['EDIT']))
{
if($voucherrights[0]['EDIT']==1){
?>
<div class="col-sm-2">
<button type="submit" class="btn green">Update</button>
<button type="reset" class="btn default">Reset</button>
</div>
<?php 
}
}
?>
<div class="col-sm-3">
<div class="note note-danger ">
<p class="block">UnPosted By : <b><?php if(!empty($unposted)){ echo $unposted[0]['U_ID']; }?></b></p>
</div> 
</div> 
<div class="col-sm-3">
<div class="note note-warning ">
<p class="block">Posted By : <b><?php if(!empty($posted)){ echo $posted[0]['U_ID']; }?></b></p>
</div> 
</div> 
<div class="col-sm-3">
<div class="note note-success">
<p class="block">Approved By : <b><?php if(!empty($approved)){ echo $approved[0]['U_ID']; }?></b></p>
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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Purchase Account<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="paccount" id="paccount" class="form-control select2 move-enter-up move-enter-3" data-position="3">
<option value="">Select Purchase Account</option>
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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> LC. No<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" value="<?= $data[0]['LCNO']?>" readonly class="form-control" name="lcno" placeholder="LC No">
</div>
</div>
</div>


</div>

<div class="row margin-0">
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> GRN No.<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up  move-enter-5" data-position="5" name="grno"  value="<?= $data[0]['GRN']?>" placeholder="GRN No">
</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> GRN Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-6" data-position="6" input-mask-date name="grndate" value="<?= $grndate?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>

<div class="col-sm-8">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Remarks<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-7" data-position="7" name="remarks"  value="<?= $data[0]['REMARKS']?>" placeholder="Remarks">
</div>
</div>
</div>

</div>

<div class="row margin-0">


<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> LC Account<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="hidden" value="<?= $data[0]['LCCODE']?>" name="lccode">
<input type="text" value="<?= $data[0]['LCNAME']?>" readonly class="form-control" name="lcname" placeholder="LC Account">
</div>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Party<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="hidden" value="<?= $data[0]['VCODE']?>" name="vcode">
<input type="text" value="<?= $data[0]['VNAME']?>" readonly class="form-control" name="vname" placeholder="Party">
</div>
</div>
</div>

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

</div>


<input type="hidden" name="qty" data-sum="tqty" />
<input type="hidden" name="weight" data-sum="tweight" />
<input type="hidden" name="amount" data-sum="tamount" />
<input type="hidden" name="overhead" data-sum="toverhead" />
<input type="hidden" name="total" data-sum="net" />

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
<th style="width:10%";>PKR Rate(MT)</th>
<th style="width:10%";>PKR Amount(MT)</th>
<th style="width:10%";>Overhead</th>
<th style="width:10%";>Total</th>
</tr>
</thead>
<tbody class="theme-border">
<?php
$rowNumber=1; 
foreach($data2 as $row):
$ohead=$row['OVERHEAD'];
$total=$row['TOTAL'];
?>
<tr data-id="<?= $rowNumber;?>">
    <td class="theme-bg theme-border text-align-center" ><?= $rowNumber;?></td>
    <td><span><?= $row['PNAME'];?></span>
        <input type="hidden" name="pname_<?= $rowNumber;?>" value="<?= $row['PNAME'];?>" hidden-data="pcode_<?= $rowNumber;?>" class="form-control">
        <input type="hidden" name="pcode_<?= $rowNumber;?>" value="<?= $row['PCODE'];?>">
    </td>
    <td><span><?= $row['UNIT'];?></span>
        <input type="hidden" name="unit_<?= $rowNumber;?>" value="<?= $row['UNIT'];?>" class="form-control">
    </td>
	 <td><span><?= $row['COIL'];?></span>
        <input type="hidden" name="coil_<?= $rowNumber;?>" value="<?= $row['COIL'];?>" class="form-control">
    </td>
	 <td class="th-right"><span><?= $row['QTY'];?></span>
        <input type="hidden" name="qty_<?= $rowNumber;?>" value="<?= $row['QTY'];?>" class="form-control sum_qty">
    </td>
    <td class="th-right"><span><?= $row['WEIGHT'];?></span>
        <input type="hidden" name="weight_<?= $rowNumber;?>" value="<?= $row['WEIGHT'];?>" class="form-control sum_weight">
    </td>
    <td class="th-right"><span><?= $row['RATE'];?></span>
        <input type="hidden" name="rate_<?= $rowNumber;?>" value="<?= $row['RATE'];?>" class="form-control">
    </td>
    <td class="th-right"><span><?= $row['AMOUNT'];?></span>
        <input type="hidden" name="amount_<?= $rowNumber;?>" value="<?= $row['AMOUNT'];?>" class="form-control sum_amount">
    </td>
    <td class="th-right"><span><?= $ohead;?></span>
        <input type="hidden" name="overhead_<?= $rowNumber;?>" value="<?= $ohead;?>" class="form-control sum_overhead">
    </td>
    <td class="th-right"><span><?= $total;?></span>
        <input type="hidden" name="total_<?= $rowNumber;?>" value="<?= $total;?>" class="form-control sum_total">
    </td>
</tr>
<?php 
$rowNumber ++;
endforeach;
?>
</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="4">Total</th>
<td class="theme-bg th-right"><input type="text" name="tqty" /></td>
<td class="theme-bg th-right"><input type="text" name="tweight" /></td>
<td colspan="1"></td>
<td class="theme-bg th-right"><input type="text" name="tamount" /></td>
<td class="theme-bg th-right"><input type="text" name="toverhead" /></td>
<td class="theme-bg th-right"><input type="text" name="net" /></td>
</tr>
</tfoot>
</table>
</div>

</div>
</div>
</form>
<script>
$("[name=paccount]").val(<?= $data[0]['PACODE']?>);
<?php 
if($data[0]['BNID']>0){
?>
$("[name=lcbond]").val(<?= $data[0]['BNID']?>);
<?php 
}
?>
$(window).on("load",function(){	
reinitializeTable(<?= $rowNumber;?>);	
});
<?php 
if(!empty($dataType)){
?>
reinitializeTable(<?= $rowNumber;?>);
<?php 	
}
?>
</script>
