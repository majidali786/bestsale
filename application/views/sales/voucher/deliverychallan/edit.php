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


<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> DC No.<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up  move-enter-3" data-position="3" value="<?= $data[0]['DCNO']; ?>" name="dcno" placeholder="DC No">
</div>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Party Name<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="hidden" class="form-control" name="vcode" value="<?= $data[0]['VCODE']?>" readonly placeholder="Party Code">
<select name="vname" id="vname" change-assign-value="vcode" data-through-ajax="address-address" disabled class="form-control select2 move-enter-up move-enter-3" data-position="3">
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
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Credit Limit.<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" readonly class="form-control" value="<?= $clmt[0]['CLIMIT'] ?>" name="limit" placeholder="Party Credit Limit.">
</div>
</div>
</div>

</div>

<div class="row margin-0">


<div class="col-sm-6">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Remarks<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-5" data-position="5" value="<?= $data[0]['REMARKS'] ?>" name="remarks" placeholder="Remarks">
</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Vehicle Name<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up  move-enter-6" data-position="6" value="<?= $data[0]['VEHICLE'] ?>" name="vehicle" placeholder="Vehicle Name">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Vehicle No.<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up  move-enter-7" data-position="7" value="<?= $data[0]['VEHICLENO'] ?>" name="vehicleno" placeholder="Vehicle No.">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Driver Name.<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up  move-enter-8" data-position="8" value="<?= $data[0]['DRIVER'] ?>" name="driver" placeholder="Driver Name.">
</div>
</div>
</div>

</div>

<input type="hidden" name="qty" data-sum="tqty" />
<input type="hidden" name="feet" data-sum="tfeet" />
<input type="hidden" name="wght" data-sum="tweight" />
<input type="hidden" name="amount" data-sum="tamount" />

<div class="col-sm-12 data-rows flip-scroll">
<table class="table table-bordered table-striped table-condensed flip-content">
<thead class="flip-content theme-color border-theme">
<tr>
<th>#</th>
<th>Sale Order#</th>
<th>Purchase Order#</th>
<th>Sale Order Date</th>
<th>Product</th>
<th>Unit</th>
<th>Max Weight</th>
<th>Weight</th>
<th>Max Qty</th>
<th>Qty</th>
</tr>
</thead>
<tbody class="theme-border">
<?php
$rowNumber=1; 
foreach($data2 as $row):
$total=$row['AMOUNT'];
if(!empty($ordr))   {
foreach($ordr as $order):
    if($row['PCODE'] == $order['PCODE'] && $row['SONO']==$order['NO'])  {
        $MAXWGHT = $order['MAXWGHT']+$row['WEIGHT'];
        $MAXQTY = $order['MAXQTY']+$row['QTY'];
        $pro_wght = $order['pro_wght'];
        $pro_bal = $order['pro_bal'];
    }   else {
        $MAXWGHT = $row['WEIGHT'];
        $MAXQTY = $row['QTY'];
        $pro_wght = 0;
        $pro_bal = 0;
    }
endforeach;
} else {
        $MAXWGHT = $row['WEIGHT'];
        $MAXQTY = $row['QTY'];
        $pro_wght = '';
        $pro_bal = '';
}
?>
<tr data-id="<?= $rowNumber;?>">
    <td class="theme-bg theme-border text-align-center" ><?= $rowNumber;?></td>
    <td><span><?= $row['SONO'];?></span>
        <input type="hidden" name="sordr_<?= $rowNumber;?>" value="<?= $row['SONO'];?>" class="form-control">
    </td>
    <td><span><?= $row['PONO'];?></span>
        <input type="hidden" name="pono_<?= $rowNumber;?>" value="<?= $row['PONO'];?>" class="form-control">
    </td>
    <td><span><?= date("d/m/Y",strtotime($row['SORDR_DATE']));?></span>
        <input type="hidden" name="sodat_<?= $rowNumber;?>" value="<?= date("Y-m-d",strtotime($row['SORDR_DATE']));?>" class="form-control">
    </td>
    <td><span><?= $row['PNAME'];?></span>
        <input type="hidden" name="pname_<?= $rowNumber;?>" value="<?= $row['PNAME'];?>" hidden-data="pcode_<?= $rowNumber;?>" class="form-control">
        <input type="hidden" name="pcode_<?= $rowNumber;?>" value="<?= $row['PCODE'];?>">
    </td>
    <td><span><?= $row['UNIT'];?></span>
        <input type="hidden" name="unit_<?= $rowNumber;?>" value="<?= $row['UNIT'];?>" class="form-control">
    </td>
     <td><span><?= $MAXWGHT;?></span><br><span style="color:red"><?= $pro_wght; ?></span>
        <input type="hidden" name="maxwght_<?= $rowNumber;?>" value="<?= $MAXWGHT;?>" class="form-control">
    </td>
    <td>
        <input type="text" name="wght_<?= $rowNumber;?>" value="<?= $row['WEIGHT'];?>" placeholder="Weight"<?php if($row['UNIT']=='kg') { ?> onkeyup="amt($(this).val(),<?= $rowNumber;?>);" <?php } ?> class="form-control sum_wght">
    </td>
    
    <td><span><?= $MAXQTY;?></span><br><span style="color:red"><?= $pro_bal; ?></span>
        <input type="hidden" name="maxqty_<?= $rowNumber;?>" value="<?= $MAXQTY;?>" class="form-control">
    </td>
    <td>
        <input type="text" name="qty_<?= $rowNumber;?>" value="<?= $row['QTY'];?>" placeholder="Qty"<?php if($row['UNIT']=='pcs') { ?> onkeyup="amt($(this).val(),<?= $rowNumber;?>);" <?php } ?> class="form-control sum_qty">
    </td>
    <td>
        <input type="hidden" name="rate_<?= $rowNumber;?>" value="<?= $row['RATE'];?>" class="form-control">
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
<th colspan="7">Total</th>
<td class="theme-bg"><input type="text" name="tweight" /></td>
<td colspan="1"></td>
<input type="hidden" name="tamount" />
<td class="theme-bg"><input type="text" name="tqty" /></td>
<input type="hidden" data-dmas="tamount-add,net-result,current-result,previous-add,total-result" readonly="" name="net" placeholder="Net">
</tr>
</tfoot>
</table>
</div>


<div class="col-sm-12">
<table class="table table-bordered table-striped table-condensed flip-content">
<tr class="theme-bg">
<th>Previous</th>
<th>Current</th>
<th>Total</th>
</tr>
<tr>
<td><input type="text" class="form-control theme-bg" value="<?= $data[0]['PREV_BAL'] ?>" readonly name="previous"  placeholder="Previous"></td>
<td><input type="text" class="form-control theme-bg" value="<?= $data[0]['CUR_BAL'] ?>" readonly name="current"  placeholder="Current"></td>
<td><input type="text" class="form-control theme-bg" value="<?= $data[0]['TOTAL'] ?>" readonly name="total"  placeholder="Total"></td>
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
<?php 
if(!empty($dataType)){
?>
reinitializeTable(<?= $rowNumber;?>);
<?php   
}
?>
$(document).find("[data-id]").on("keyup","input",function(){
var row=$(this).parents("[data-id]").attr("data-id");
var name=$(this).attr("name");
var a=name.split("_");  
if($(this).val()>parseFloat($('[name=max'+a[0]+'_'+row+'').val())){
$(this).val($('[name=max'+a[0]+'_'+row+'').val());  
}
dataSum();
});
</script>
