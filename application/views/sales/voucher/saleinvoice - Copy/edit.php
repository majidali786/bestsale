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
<input type="text" class="form-control move-enter-up move-enter-start move-enter-1" style="text-align:center" data-position="1" int-numbers-only name="no" value="<?= $max;?>" placeholder="Voucher No.">
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
<select name="vname" id="vname" change-assign-value="vcode" data-through-ajax="address-address,ntn-ntn,saletax-saletax" class="form-control select2 move-enter-up move-enter-3" data-position="3">
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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Bill No.</label>
<div class="col-md-12">
<input type="text" class="form-control move-enter-up move-enter-4" data-position="4" name="vno" required value="<?= $data[0]['VNO']?>"  
placeholder="Bill No.">
</div>
</div>
</div>
<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Sales Account<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="sacode" id="sacode" class="form-control select2 move-enter-up move-enter-4" data-position="4">
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


<div class="col-sm-6">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Remarks.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-to-row move-enter-8" data-position="8" name="remarks" value="<?= $data[0]['REMARKS']?>"  placeholder="Remarks">
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
<th style="width:15%;text-align:center";>Product</th>
<th style="width:5%;text-align:center";>Unit</th>
<th style="width:8%;text-align:center";>Qty</th>
<th style="width:8%;text-align:center";>Rate</th>
<th style="width:10%;text-align:center";>Amount درهم</th>
<th style="width:8%;text-align:center";>Discount %</th>
<th style="width:8%;text-align:center";>Discount درهم</th>
<th style="width:10%;text-align:center";>Total درهم</th>
<th style="width:8%;text-align:center";>Vat %</th>
<th style="width:8%;text-align:center";>Vat.Amount درهم</th>
<th style="width:10%;text-align:center";>Net درهم</th>
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
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['QTY'])?>"><span><?= round($row['QTY'],2);?></span>
        <input type="hidden" name="qty_<?= $rowNumber;?>" value="<?= round($row['QTY'],2);?>" class="form-control sum_qty">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['RATE'])?>"><span><?= lakhseparater($row['RATE'],2);?></span>
        <input type="hidden" name="rate_<?= $rowNumber;?>" value="<?= lakhseparater($row['RATE'],2);?>" class="form-control">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['AMOUNT'])?>"><span><?= lakhseparater($row['AMOUNT']);?></span>
        <input type="hidden" name="amount_<?= $rowNumber;?>" value="<?= lakhseparater($row['AMOUNT'],2);?>" class="form-control sum_amount">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['DISCOUNTPER'])?>"><span><?= round($row['DISCOUNTPER'],2);?></span>
        <input type="hidden" name="discountper_<?= $rowNumber;?>" value="<?= round($row['DISCOUNTPER'],2);?>" class="form-control">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['DISCOUNT'])?>"><span><?= lakhseparater($row['DISCOUNT']);?></span>
        <input type="hidden" name="discount_<?= $rowNumber;?>" value="<?= lakhseparater($row['DISCOUNT'],2);?>" class="form-control sum_discount">
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
<th colspan="3">Total</th>
<td class="theme-bg th-right"><input type="text" name="tqty" /></td>
<td></td>
<td class="theme-bg th-right"><input type="text" name="tamount" /></td>
<td></td>
<td class="theme-bg th-right"><input type="text" name="tdiscount" /></td>
<td class="theme-bg th-right"><input type="text" name="ttotal" /></td>
<td></td>
<td class="theme-bg th-right"><input type="text" name="tgst" /></td>
<td class="theme-bg th-right"><input type="text" name="tnet" /></td>
</tr>
</tfoot>
</table>

<div class="col-sm-12">
<table class="table table-bordered table-striped table-condensed flip-content">
<tr class="theme-bg">
<th style="width:60%"></th>
<th>Discount In(%)</th>
<th>Discount (Rs)</th>
</tr>
<tr>
<td></td>
<td  class="show-error th-right"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-12"
 data-position="12" data-dmas="tnet-add,dst-dpercent-gstamt,cnet-result" name="dst" value="<?= $data[0]['DIS']?>"
 placeholder="Discount(%)"></td>
<td  class="show-error th-right"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-13" 
data-position="13" name="gstamt" data-dmas="tnet-add,gstamt-dpercentage-dst,cnet-result"  placeholder="Discount(Rs)" 
value="<?= $data[0]['DISCOUNT']?>"></td>
</tr>
<tr>
<td></td>
<th class="theme-bg">Net</th>
<td><input type="text" class="form-control theme-bg th-right" readonly name="cnet"  placeholder="Invoice Total"></td>
</tr>
</table>

</div>

</div>
</div>
</div>
</form>
<script>
$("[name=vname]").val(<?= $data[0]['VCODE']?>);
$("[name=sacode]").val(<?= $data[0]['SCODE']?>);

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
