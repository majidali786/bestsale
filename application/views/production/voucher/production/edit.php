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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Contractor<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="contractor" id="contractor" class="form-control select2 move-enter-up move-enter-5" data-position="5">
<option value="">Select Contractor</option>
<?php 
if(count($contractor)){
foreach($contractor as $g){
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

</div>





<?php 
$this->load->view($loadRow);
?>


<div class="col-sm-12 data-rows flip-scroll">
<table class="table table-bordered table-striped table-condensed flip-content">
<thead class="flip-content theme-color border-theme">
<tr>
<th>#</th>
<th style="width:37%";>Product</th>
<th style="width:9%";>Unit</th>
<th style="width:9%";>Weight</th>
<th style="width:9%";>Qty</th>
<th style="width:9%";>Feet</th>
<th style="width:9%;">Total Weight</th>
<th style="width:9%";>Rate</th>
<th style="width:9%";>Amount</th>
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
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['TOTWEIGHT'])?>"><span><?= lakhseparater($row['TOTWEIGHT'],2);?></span>
        <input type="hidden" name="totweight_<?= $rowNumber;?>" value="<?= lakhseparater($row['TOTWEIGHT'],2);?>" class="form-control sum_totweight">
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
<td></td>
<td class="theme-bg th-right"><input type="text" name="totwght" /></td>
<td></td>
<td class="theme-bg th-right"><input type="text" name="tamount" /></td>
</tr>
</tfoot>
</table>
</div>

<?php 
$this->load->view($loadProRow);
?>


<div class="col-sm-12 data-prorows flip-scroll">
<table class="table table-bordered table-striped table-condensed flip-content">
<thead class="flip-content theme-color border-theme">
<tr>
<th>#</th>
<th style="width:30%">Product</th>
<th style="width:8%">Unit</th>
<th style="width:8%">Coil</th>
<th style="width:8%">Weight</th>
<th style="width:8%">Qty</th>
<th style="width:8%">MM Wastage</th>
<th style="width:8%">Total Weight</th>
<th style="width:8%">Waste</th>
<th style="width:8%">Manual Waste</th>
</tr>
</thead>
<tbody class="theme-border">
<?php
$rowProNumber=1; 
foreach($data3 as $row):
?>
<tr data-id="<?= $rowProNumber;?>">
    <td class="theme-bg theme-border text-align-center" >
	<div class="btn-group">
	<a class="btn btn-sm theme-bg" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" style="padding: 0px 5px;" data-close-others="true" ><?= $rowProNumber;?></a>
	<ul class="dropdown-menu pull-right">
	<li>
	<a href="javascript:;" edit-pro-row><i class="icon-pencil text-warning"></i> Edit </a>
	</li>
	<li>
	<a href="javascript:;" delete-pro-row><i class="icon-trash text-danger"></i> Delete </a>
	</li>
	</ul>
	</div>
	</td>
    <td><span><?= $row['PNAME'];?></span>
        <input type="hidden" name="propname_<?= $rowProNumber;?>" value="<?= $row['PNAME'];?>" hidden-data="propcode_<?= $rowProNumber;?>" class="form-control">
        <input type="hidden" name="propcode_<?= $rowProNumber;?>" value="<?= $row['PCODE'];?>">
    </td>
    <td><span><?= $row['UNIT'];?></span>
        <input type="hidden" name="prounit_<?= $rowProNumber;?>" value="<?= $row['UNIT'];?>" class="form-control">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= $row['COIL']?>"><span><?= $row['COIL'];?></span>
        <input type="hidden" name="procoil_<?= $rowProNumber;?>" value="<?= $row['FEET'];?>" class="form-control">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['WEIGHT'])?>"><span><?= lakhseparater($row['WEIGHT'],2);?></span>
        <input type="hidden" name="proweight_<?= $rowProNumber;?>" value="<?= lakhseparater($row['WEIGHT'],2);?>" class="form-control sum_proweight">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['QTY'])?>"><span><?= lakhseparater($row['QTY'],2);?></span>
        <input type="hidden" name="proqty_<?= $rowProNumber;?>" value="<?= lakhseparater($row['QTY'],2);?>" class="form-control sum_proqty">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['MMWASTE'])?>"><span><?= lakhseparater($row['MMWASTE'],2);?></span>
        <input type="hidden" name="prommwaste_<?= $rowProNumber;?>" value="<?= lakhseparater($row['MMWASTE'],2);?>" class="form-control sum_prommwaste">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['TOTWEIGHT'])?>"><span><?= lakhseparater($row['TOTWEIGHT']);?></span>
        <input type="hidden" name="prototweight_<?= $rowProNumber;?>" value="<?= lakhseparater($row['TOTWEIGHT'],2);?>" class="form-control sum_prototweight">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['WASTE'])?>"><span><?= lakhseparater($row['WASTE']);?></span>
        <input type="hidden" name="prowaste_<?= $rowProNumber;?>" value="<?= lakhseparater($row['WASTE'],2);?>" class="form-control sum_prowaste">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['MWASTE'])?>"><span><?= lakhseparater($row['MWASTE']);?></span>
        <input type="hidden" name="promanualwaste_<?= $rowProNumber;?>" value="<?= lakhseparater($row['MWASTE'],2);?>" class="form-control sum_promanualwaste">
    </td>
</tr>
<?php 
$rowProNumber ++;
endforeach;
?>
</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="4">Total</th>
<td class="theme-bg th-right"><input type="text" name="protwght" /></td>
<td class="theme-bg th-right"><input type="text" name="protqty" /></td>
<td class="theme-bg th-right"><input type="text" name="protmmwaste" /></td>
<td class="theme-bg th-right"><input type="text" name="prototwght" /></td>
<td class="theme-bg th-right"><input type="text" name="protwaste" /></td>
<td class="theme-bg th-right"><input type="text" name="protmwaste" /></td>
</tr>
</tfoot>
</table>
</div>


</div>
</div>
</form>
<script>
$(document).find("[name=contractor]").val('<?= $data[0]['RPCODE']?>');
$(document).find("[name=department]").val('<?= $data[0]['DPCODE']?>');
$(window).on("load",function(){	
reinitializeTable(<?= $rowNumber;?>);
reinitializeProTable(<?= $rowProNumber;?>);
});
<?php 
if(!empty($dataType)){
?>
reinitializeTable(<?= $rowNumber;?>);
reinitializeProTable(<?= $rowProNumber;?>);
<?php 	
}
?>
</script>
