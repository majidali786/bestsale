<form class="form-horizontal main-form edit-form" role="form" onsubmit="return false;">
<div class="form-body">


<div class="form-actions right1 row">
<?php 
if(!empty($voucherrights[0]['EDIT']))
{
if(($voucherrights[0]['EDIT']==1 && $voucherrights[0]['UNPOSTED']==1 && empty($posted) && empty($approved)) || ($voucherrights[0]['EDIT']==1 && $voucherrights[0]['POSTED']==1 && empty($approved)) || ($voucherrights[0]['EDIT']==1 && $voucherrights[0]['APPROVED']==1)){
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
<input type="text"  style="text-align:center" class="form-control move-enter-up move-enter-start move-enter-1" data-position="1" int-numbers-only name="no" value="<?= $max;?>" placeholder="Voucher No.">
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
<input type="hidden" class="form-control" name="vcode" value="<?= $data[0]['VCODE']?>" readonly placeholder="Party Code">
<select name="vname" id="vname" change-assign-value="vcode" data-through-ajax="address-address" class="form-control select2 move-enter-up move-enter-3" data-position="3">
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

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Address.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control" value="<?= $data[0]['ADDR']?>"  name="address" readonly placeholder="Address">
</div>
</div>
</div>


<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Complete</label>
<div class="col-md-12 show-error">
<div class="md-checkbox">
<input type="checkbox" id="sms" name="sms" <?php if($data[0]['STATUS2']==1){ echo "checked";}?> value="1" class="md-check"  >
<label for="sms">
<span class="inc"></span>
<span class="check"></span>
<span class="box"></span> <b>Yes</b></label>
</div>
</div>
</div>
</div>


</div>
<div class="row margin-0">
<div class="col-sm-2">
<div class="form-group show-error">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Order No.</label>
<div class="col-md-5 padding-left-yes">
<input type="text" class="form-control move-enter-up move-enter-4" data-position="4" name="sordrno" readonly value="<?= $data[0]['PONO']?>"  placeholder=" Order No.">
</div>
<div class="col-md-7 padding-0">
<button type="button" class="btn green"><i class="icon-list"></i></button> 
<button type="button" class="btn green"><i class="icon-arrow-down"></i></button>
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Order Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text"  style="text-align:center" class="form-control move-enter-up move-enter-5" data-position="5" input-mask-date name="odate" value="<?= date("d/m/Y",strtotime($data[0]['SODATE']))?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Cargo Name<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="hidden" class="form-control" name="ccode" value="<?= $data[0]['CID']?>" readonly placeholder="Cargo Code">
<select name="cargo" id="cargo" change-assign-value="ccode"  class="form-control select2 move-enter-up move-enter-6" data-position="6>
<option value="">Select Cargo Name</option>
<optgroup label="Cargo">
<?php 
if(count($cargo)){
foreach($cargo as $g){
?>
<option value="<?= $g['CODE'];?>"><?= $g['CODE']."-".$g['VNAME']; ?></option>
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
<input type="text" class="form-control move-enter-up move-to-row move-enter-7" data-position="7" name="crdays" value="<?= $data[0]['CRDAYS']?>"  placeholder="Delivery Days">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Remarks.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-to-row move-enter-10" data-position="10" name="remarks" value="<?= $data[0]['REMARKS']?>"  placeholder="Remarks">
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
<tbody class="theme-border">
<?php
$rowNumber=1; 
foreach($data2 as $row):
?>
<tr data-id="<?= $rowNumber;?>">
    <td class="theme-bg theme-border text-align-center" >
	<div class="btn-group">
	<a class="btn btn-sm theme-bg" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" style="padding: 0px 5px;" data-close-others="true" ><?= $rowNumber;?></a>
	</div>
	</td>
    <td><span><?= $row['PNAME'];?></span>
        <input type="hidden" name="pname_<?= $rowNumber;?>" value="<?= $row['PNAME'];?>" hidden-data="pcode_<?= $rowNumber;?>" class="form-control">
        <input type="hidden" name="pcode_<?= $rowNumber;?>" value="<?= $row['PCODE'];?>">
    </td>
    <td><span><?= $row['UNIT'];?></span>
        <input type="hidden" name="unit_<?= $rowNumber;?>" value="<?= $row['UNIT'];?>" class="form-control">
    </td>
    <td class="th-right"><span><?= $row['ORDERQTY'];?></span>
        <input type="hidden" name="orderqty_<?= $rowNumber;?>" value="<?= $row['ORDERQTY'];?>">
    </td>
    <td class="th-right"><span><?= $row['QTY'];?></span>
        <input type="hidden" name="qty_<?= $rowNumber;?>" value="<?= $row['QTY'];?>" class="form-control sum_qty">
    </td>
    <td class="th-right"><span><?= $row['STOCK'];?></span>
        <input type="hidden" name="stock_<?= $rowNumber;?>" value="<?= $row['STOCK'];?>" >
        <input type="hidden" name="rate_<?= $rowNumber;?>" value="<?= $row['RATE'];?>" >
        <input type="hidden" name="amount_<?= $rowNumber;?>" value="<?= $row['AMOUNT'];?>" >
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
<td class="theme-bg th-right"><input type="text" name="tqty" ></td>
<td colspan="2"></td>
</tr>
</tfoot>
</table>
</div>
</div>
</div>
</form>
<script>
$("[name=vname]").val(<?= $data[0]['VCODE']?>);
$("[name=cargo]").val(<?= $data[0]['CID']?>);


$(window).on("load",function(){	
reinitializeTable(<?= $rowNumber;?>);	
if($('#dcsale').is(":checked"))	
{
$("#dcsale").prop("disabled", true);
$("#vname").prop("disabled", true);
$("input[name=qty]").prop("readonly", true);
$("input[name=rate]").prop("readonly", true);
}	else {
$("#dcsale").prop("disabled", true);
$("#vname").prop("disabled", false);
$("input[name=qty]").prop("readonly", false);
$("input[name=rate]").prop("readonly", false);	
}
});
<?php 
if(!empty($dataType)){
?>
reinitializeTable(<?= $rowNumber;?>);
<?php 	
}
?>
</script>
