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
<div class="note note-warning">
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
<input type="text"  class="form-control move-enter-up move-enter-start move-enter-1" data-position="1" style="text-align:center;" int-numbers-only name="no" value="<?= $max;?>" placeholder="Voucher No.">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Voucher Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" style="text-align-center" class="form-control move-enter-up move-enter-2" data-position="2" input-mask-date style="text-align:center;" name="vdate" value="<?= $vdate?>" placeholder="dd/mm/yyyy">
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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Invoice No.</label>
<div class="col-md-12">
<input type="text" class="form-control move-enter-up move-enter-4" data-position="4" name="vno" value="<?= $data[0]['VNO']?>" style="text-align:center;"  placeholder="Purchase Order No.">
</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Conversion Rate<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up  move-enter-5" data-position="5" name="conversion"  value="<?= $data[0]['CRATE']?>"style="text-align:center;"  placeholder="Conversion Rate">
</div>
</div>
</div>


<div class="col-sm-6">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Remarks.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-to-row move-enter-6" data-position="6" name="remarks" value="<?= $data[0]['REMARKS']?>"  placeholder="Remarks">
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
<th style="text-align:center;">Sr#</th>
<th style="text-align:center;width:25%";>Product Description</th>
<th style="text-align:center;width:10%";>Unit</th>
<th style="text-align:center;width:10%";>Qty</th>
<th style="text-align:center;width:10%";>F.C Rate</th>
<th style="text-align:center;width:15%";>F.C Amount</th>
<th style="text-align:center;width:10%";>درهم Rate</th>
<th style="text-align:center;width:15%";>درهم Amount</th>
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
  
    <td class="th-right"><span><?= $row['QTY'];?></span>
        <input type="hidden" name="qty_<?= $rowNumber;?>" value="<?= $row['QTY'];?>" class="form-control sum_qty">
    </td>
    <td class="th-right"><span><?= $row['FRATE'];?></span>
        <input type="hidden" name="rate_<?= $rowNumber;?>" value="<?= $row['FRATE'];?>" class="form-control">
    </td>
    <td class="th-right"><span><?= $row['FAMOUNT'];?></span>
        <input type="hidden" name="amount_<?= $rowNumber;?>" value="<?= $row['FAMOUNT'];?>" class="form-control sum_amount">
    </td>
	
	   <td class="th-right"><span><?= $row['RATE'];?></span>
        <input type="hidden" name="drate_<?= $rowNumber;?>" value="<?= $row['RATE'];?>" class="form-control">
    </td>
    <td class="th-right"><span><?= $row['AMOUNT'];?></span>
        <input type="hidden" name="damount_<?= $rowNumber;?>" value="<?= $row['AMOUNT'];?>" class="form-control sum_damount">
    </td>
	
</tr>
<?php 
$rowNumber ++;
endforeach;
?>
</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="3" style="text-align:center;">Total</th>
<td class="theme-bg th-right" style="text-align:center;"><input type="text" name="tqty" /></td>
<td colspan="1"></td>
<td class="theme-bg th-right"><input type="text" name="tamount" /></td>
<td colspan="1"></td>
<td class="theme-bg th-right"><input type="text" name="dtamount" /></td>
</tr>
</tfoot>
</table>
</div>
<div class="col-sm-12">
<table class="table table-bordered table-striped table-condensed flip-content">
<tr class="theme-bg">
<th style="width:60%"></th>
<th style="text-align:center;" >Discount in(%)</th>
<th style="text-align:center;">Discount (Rs)</th>
</tr>
<tr>
<td></td>
<td  class="show-error th-right"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-12" data-position="12" data-dmas="tamount-add,gst-dpercent-gstamt,net-result" name="gst" value="<?= $data[0]['GST']?>" placeholder="Discount(%)"></td>
<td  class="show-error th-right"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-13" data-position="13" name="gstamt" data-dmas="tamount-add,gstamt-dpercentage-gst,net-result"  placeholder="Discount(Rs)" value="<?= $data[0]['GSTAMT']?>"></td>
</tr>
<tr>
<td></td>
<th class="theme-bg">Net</th>
<td><input type="text" class="form-control theme-bg th-right" readonly name="net"  placeholder="Invoice Total"></td>
</tr>
</table>

</div>
</div>
</div>
</form>
<script>
$("[name=vname]").val(<?= $data[0]['VCODE']?>);

$(window).on("load",function(){	
reinitializeTable(<?= $rowNumber;?>);	
});

$(document).find("[name=qty_e]").attr("data-dmas","conversion-add,rate_e-multiply,drate_e-result-round-2,clear-clear,qty_e-add,rate-multiply,amount_e-result-round-2,clear-clear,qty_e-add,drate_e-multiply,damount_e-result-round-2");
$(document).find("[name=rate_e]").attr("data-dmas","conversion-add,rate_e-multiply,drate_e-result-round-2,clear-clear,qty_e-add,rate-multiply,amount_e-result-round-2,clear-clear,qty_e-add,drate_e-multiply,damount_e-result-round-2");
$(document).find("[name=drate_e]").attr("data-dmas","conversion-add,rate_e-multiply,drate_e-result-round-2,clear-clear,qty_e-add,rate-multiply,amount_e-result-round-2,clear-clear,qty_e-add,drate_e-multiply,damount_e-result-round-2");


<?php 
if(!empty($dataType)){
?>
reinitializeTable(<?= $rowNumber;?>);
<?php 	
}
?>
</script>
