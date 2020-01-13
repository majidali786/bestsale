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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Lot No.<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" readonly value="<?= $data[0]['LOTNO']?>" class="form-control" name="lotno"  placeholder="Lot No.">
</div>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Raw Material<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="rmaterial" id="rmaterial" class="form-control select2 move-enter-up move-enter-4" data-position="4">
<option value="">Select Raw Material</option>
<?php 
foreach($rawMaterial as $a){
?>
<option value="<?= $a['PCODE'];?>"><?= $a['PNAME']; ?></option>
<?php 	
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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Department<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="department" id="department" class="form-control select2 move-enter-up move-enter-5" data-position="5">
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


<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Used Raw Material(Weight)</label>
<div class="col-md-12 show-error">
<input type="text" readonly class="form-control" name="used"  placeholder="Used Raw Material(Weight)">
</div>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> In Hand Raw Material(Weight)</label>
<div class="col-md-12 show-error">
<input type="text" readonly class="form-control" name="inhand"  placeholder="In Hand Raw Material(Weight)">
</div>
</div>
</div>

</div>

<div class="row margin-0">
<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Currently Used(QTY)</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-6" data-position="6" name="cused" value="<?= $data[0]['CUSED']?>"  placeholder="Currently Used(QTY)">
</div>
</div>
</div>

<div class="col-sm-8">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Remarks.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-to-row move-enter-7" data-position="7" name="remarks" value="<?= $data[0]['REMARKS']?>"  placeholder="Remarks">
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
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['WEIGHT'])?>"><span><?= lakhseparater($row['WEIGHT'],2);?></span>
        <input type="hidden" name="weight_<?= $rowNumber;?>" value="<?= lakhseparater($row['WEIGHT'],2);?>" class="form-control sum_weight">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['QTY'])?>"><span><?= lakhseparater($row['QTY'],2);?></span>
        <input type="hidden" name="qty_<?= $rowNumber;?>" value="<?= lakhseparater($row['QTY'],2);?>" class="form-control sum_qty">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['FEET'])?>"><span><?= lakhseparater($row['FEET'],2);?></span>
        <input type="hidden" name="feet_<?= $rowNumber;?>" value="<?= lakhseparater($row['FEET'],2);?>" class="form-control">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['RATE'])?>"><span><?= lakhseparater($row['RATE'],2);?></span>
        <input type="hidden" name="rate_<?= $rowNumber;?>" value="<?= lakhseparater($row['RATE'],2);?>" class="form-control">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['AMOUNT'])?>"><span><?= lakhseparater($row['AMOUNT']);?></span>
        <input type="hidden" name="amount_<?= $rowNumber;?>" value="<?= lakhseparater($row['AMOUNT'],2);?>" class="form-control sum_amount">
    </td>
</tr>
<?php 
$rowNumber ++;
endforeach;
?>
</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="3">Total</th>
<td class="theme-bg th-right"><input type="text" name="twght" /></td>
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
$(document).find("[name=department]").val('<?= $data[0]['DPCODE']?>');
$(document).find("[name=rmaterial]").val('<?= $data[0]['RPCODE']?>');
$(window).on("load",function(){	
reinitializeTable(<?= $rowNumber;?>);
$.each(<?= json_encode($rawMaterial)?>,function(i,tag){
rawData[tag['PCODE']]=tag;	
});	
$(document).find("[name=used]").val(rawData['<?= $data[0]['RPCODE']?>']['USED']);	
$(document).find("[name=inhand]").val(rawData['<?= $data[0]['RPCODE']?>']['BAL']);	
});
<?php 
if(!empty($dataType)){
?>
$.each(<?= json_encode($rawMaterial)?>,function(i,tag){
rawData[tag['PCODE']]=tag;	
});	
$(document).find("[name=used]").val(rawData['<?= $data[0]['RPCODE']?>']['USED']);	
$(document).find("[name=inhand]").val(rawData['<?= $data[0]['RPCODE']?>']['BAL']);	
reinitializeTable(<?= $rowNumber;?>);
<?php 	
}
?>
</script>
