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
<input type="text" class="form-control move-enter-up move-enter-start move-enter-1" data-position="1" int-numbers-only name="no" value="<?= $max;?>" style="text-align:center" placeholder="Voucher No.">
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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> PDC No.</label>
<div class="col-md-12">
<input type="text" class="form-control move-enter-up move-enter-4" data-position="4" name="dcno" readonly value="<?= $data[0]['DCNO']?>" placeholder="PDC No.">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i>Sales Tax No.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control" name="saletaxno" value="124832.35" readonly placeholder="Sales Tax No.">
</div>
</div>
</div><div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i>NTN #</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control" readonly name="ntn"  value="<?= $data[0]['NTN']?>" placeholder="NTN #" >
</div>
</div>
</div><div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i>Sales Tax #</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control" name="saletax"  value="<?= $data[0]['STAX']?>" readonly placeholder="Sales Tax #">
</div>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Remarks.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-to-row move-enter-7" data-position="7" name="remarks" value="<?= $data[0]['REMARKS']?>"  placeholder="Remarks">
</div>
</div>
</div>
<div class="row margin-0">
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Orignial Inv No.<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-6" data-position="6" int-numbers-only name="ono" value="<?= $data[0]['ONO'] ?>" style="text-align:center" placeholder="Orignial No.">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Orignial Inv Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-to-row move-enter-7" style="text-align:center" data-position="7" input-mask-date value="<?= $data[0]['ODATE'] ?>" name="odate" placeholder="dd/mm/yyyy">
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
<th>Sr.#</th>
<th style="width:50%;text-align:center">Description</th>
<th style="width:15%;text-align:center">Total</th>
<th style="width:10%;text-align:center">GST %</th>
<th style="width:10%;text-align:center">GST Rs</th>
<th style="width:15%;text-align:center">Net</th>

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
	<?php if($data[0]['DCNO']==''){  ?>
	<ul class="dropdown-menu pull-right">
	<li>
	<a href="javascript:;" edit-row><i class="icon-pencil text-warning"></i> Edit </a>
	</li>
	<li>
	<a href="javascript:;" delete-row><i class="icon-trash text-danger"></i> Delete </a>
	</li>
	</ul>
	<?php } ?>
	</div>
	</td>
    <td><span><?= $row['DESCR'];?></span>
        <input type="hidden" name="desc_<?= $rowNumber;?>" value="<?= $row['DESCR'];?>" hidden-data="pcode_<?= $rowNumber;?>" class="form-control">
        <input type="hidden" name="pcode_<?= $rowNumber;?>" value="<?= $row['PCODE'];?>">
    </td>
  
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['TOTAL'])?>"><span><?= lakhseparater($row['TOTAL']);?></span>
        <input type="hidden" name="total_<?= $rowNumber;?>" value="<?= lakhseparater($row['TOTAL'],2);?>" class="form-control sum_total">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['GSTPER'])?>"><span><?= lakhseparater($row['GSTPER']);?></span>
        <input type="hidden" name="gstper_<?= $rowNumber;?>" value="<?= lakhseparater($row['GSTPER'],2);?>" class="form-control">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['GST'])?>"><span><?= lakhseparater($row['GST']);?></span>
        <input type="hidden" name="gst_<?= $rowNumber;?>" value="<?= lakhseparater($row['GST'],2);?>" class="form-control sum_gst">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['NET'])?>"><span><?= lakhseparater($row['NET']);?></span>
        <input type="hidden" name="net_<?= $rowNumber;?>" value="<?= lakhseparater($row['NET'],2);?>" class="form-control sum_net">
    </td>
</tr>
<?php 
$rowNumber ++;
endforeach;
?>
</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="2">Total</th>
<td class="theme-bg th-right"><input type="text" name="ttotal" /></td>
<td></td>
<td class="theme-bg th-right"><input type="text" name="tgst" /></td>
<td class="theme-bg th-right"><input type="text" name="tnet" /></td>
</tr>
</tfoot>
</table>
</div>
</div>
</div>
</form>
<script>
$("[name=vname]").val(<?= $data[0]['VCODE']?>);
$("[name=department]").val(<?= $data[0]['DPCODE']?>);
$("[name=sacode]").val(<?= $data[0]['SCODE']?>);
$("[name=stype]").val(<?= $data[0]['STYPE']?>);
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
