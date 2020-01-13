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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Party Name<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="hidden" class="form-control" name="vcode" value="<?= $data[0]['VCODE']?>" readonly placeholder="Party Code">
<select name="vname" id="vname" change-assign-value="vcode" data-through-ajax="address-address" class="form-control select2 move-enter-up move-enter-3" data-position="3">
<option value="">Select Party Name</option>
<?php 
if(count($party)){
foreach($party as $g){
?>
<option value="<?= $g['VCODE'];?>"><?= $g['VNAME']; ?></option>
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
<input type="text" class="form-control" value="<?= $data[0]['ADDR']?>" name="address" readonly placeholder="Address">
</div>
</div>
</div>
</div>
<div class="row margin-0">
<div class="col-sm-2">
<div class="form-group show-error">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Serial</label>
<div class="col-md-12  show-error">
<input type="text" class="form-control move-enter-up move-enter-4" data-position="4" name="serial" value="<?= $data[0]['SERIAL']?>"  placeholder="Serial">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Book No.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-5" data-position="5" name="vno" value="<?= $data[0]['VNO']?>"  placeholder="Book No.">
</div>
</div>
</div>
<div class="col-sm-4">
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


<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Department<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="department" id="department" class="form-control select2 move-enter-up move-enter-7" data-position="7">
<option value="">Select Department</option>
<?php 
if(count($department)){
foreach($department as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['DEPT']; ?></option>
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

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> LCNO<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="lcno" id="lcno" class="form-control select2 move-enter-up move-enter-8" data-position="8">
<option value="">Select LCNO</option>
<?php 
if(count($lcno)){
foreach($lcno as $g){
?>
<option value="<?= $g['LCNO'];?>"><?= $g['LCNO']; ?></option>
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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Bond<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="lcbond" id="lcbond" class="form-control select2 move-enter-up move-enter-9" data-position="9">
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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Remarks.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-to-row move-enter-9" data-position="9" name="remarks" value="<?= $data[0]['REMARKS']?>"  placeholder="Remarks">
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
<th style="width:10%";>Coil</th>
<th style="width:10%";>Weight</th>
<th style="width:10%";>Qty</th>
<th style="width:10%";>Feet</th>
<th style="width:10%";>Rate</th>
<th style="width:10%";>Amount</th>
</tr>
</thead>
<tbody class="theme-border">
<?php
$rowNumber=1; 
foreach($data2 as $row):
?>
<tr data-id="<?= $rowNumber;?>">
    <td class="theme-bg theme-border text-align-center" >
	<div class="btn-group">
	<a class="btn btn-sm theme-bg" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" style="padding: 0px 5px;" data-close-others="true" ><?= $rowNumber;?></a>
	<ul class="dropdown-menu pull-right">
	<li>
	<a href="javascript:;" edit-row><i class="icon-pencil text-warning"></i> Edit </a>
	</li>
	<li>
	<a href="javascript:;" delete-row><i class="icon-trash text-danger"></i> Delete </a>
	</li>
	</ul>
	</div>
	</td>
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
    <td><span><?= $row['WEIGHT'];?></span>
        <input type="hidden" name="weight_<?= $rowNumber;?>" value="<?= $row['WEIGHT'];?>" class="form-control">
    </td>
    <td class="th-right"><span><?= $row['QTY'];?></span>
        <input type="hidden" name="qty_<?= $rowNumber;?>" value="<?= $row['QTY'];?>" class="form-control sum_qty">
    </td>
    <td class="th-right"><span><?= $row['FEET'];?></span>
        <input type="hidden" name="feet_<?= $rowNumber;?>" value="<?= $row['FEET'];?>" class="form-control">
    </td>
    <td><span><?= $row['RATE'];?></span>
        <input type="hidden" name="rate_<?= $rowNumber;?>" value="<?= $row['RATE'];?>" class="form-control">
    </td>
    <td class="th-right"><span><?= $row['AMOUNT'];?></span>
        <input type="hidden" name="amount_<?= $rowNumber;?>" value="<?= $row['AMOUNT'];?>" class="form-control sum_amount">
    </td>
</tr>
<?php 
$rowNumber ++;
endforeach;
?>
</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="5">Total</th>
<td class="theme-bg th-right"><input type="text" name="tqty" /></td>
<td colspan="2"></td>
<td class="theme-bg th-right"><input type="text" name="tamount" /></td>
</tr>
</tfoot>
</table>
</div>
</div>
</div>
</form>
<script>
$("[name=lcbond]").val(<?= $data[0]['BNID']?>);
$("[name=lcno]").val(<?= $data[0]['LCNO']?>);
$("[name=vname]").val(<?= $data[0]['VCODE']?>);
$("[name=department]").val(<?= $data[0]['DPCODE']?>);
$("[name=sacode]").val(<?= $data[0]['SACODE']?>);
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
