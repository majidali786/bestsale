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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> From Account<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="faccount" id="faccount" class="form-control select2 move-enter-up move-enter-3" data-position="3">
<option value="">Select From Account</option>
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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> To Account<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="taccount" id="taccount" class="form-control select2 move-enter-up move-enter-4" data-position="4">
<option value="">Select To Account</option>
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

<input type="hidden" name="amount" data-sum="tamount" />


<div class="col-sm-12 data-rows flip-scroll">
<table class="table table-bordered table-striped table-condensed flip-content">
<thead class="flip-content theme-color border-theme">
<tr>
<th>#</th>
<th>Party/Account</th>
<th>Bank</th>
<th>Description</th>
<th>Cheque No.</th>
<th>Chq. Date</th>
<th>Amount</th>
<th>Action</th>
</tr>
</thead>
<tbody class="theme-border">
<?php
$rowNumber=1; 
foreach($data as $row):
if(!empty($row['CHQDATE'])){
$row['CHQDATE']=date("d/m/Y",strtotime($row['CHQDATE']));	
}
?>
<tr data-id="<?= $rowNumber;?>">
    <td class="theme-bg theme-border text-align-center" >
	<?= $rowNumber;?>
	</td>
    <td><span><?= $row['ACODE']."-".$row['ANAME'];?></span>
        <input type="hidden" name="aname_<?= $rowNumber;?>" value="<?= $row['ACODE']."-".$row['ANAME'];?>" hidden-data="acode_<?= $rowNumber;?>" class="form-control">
        <input type="hidden" name="acode_<?= $rowNumber;?>" value="<?= $row['ACODE'];?>">
    </td>
	<td><span><?= $row['BNAME'];?></span>
        <input type="hidden" name="bank_<?= $rowNumber;?>" value="<?= $row['BNAME'];?>" hidden-data="bcode_<?= $rowNumber;?>" class="form-control">
        <input type="hidden" name="bcode_<?= $rowNumber;?>" value="<?= $row['BCODE'];?>">
    </td>
    <td><span><?= $row['DESCR'];?></span>
        <input type="hidden" name="descrip_<?= $rowNumber;?>" value="<?= $row['DESCR'];?>" class="form-control">
    </td>
    <td><span><?= $row['CHQNO'];?></span>
        <input type="hidden" name="chqNo_<?= $rowNumber;?>" value="<?= $row['CHQNO'];?>" class="form-control">
    </td>
	<td><span><?= $row['CHQDATE'];?></span>
        <input type="hidden" name="chqDate_<?= $rowNumber;?>" value="<?= $row['CHQDATE'];?>" class="form-control">
    </td>
    <td class="th-right"><span><?= $row['DEBIT'];?></span>
        <input type="hidden" name="amount_<?= $rowNumber;?>" value="<?= $row['DEBIT'];?>" class="form-control sum_amount">
    </td>
	<td>
	<div class="list-icon-container done">
	<div class="md-checkbox has-error">
	<input type="checkbox" id="incChq_<?= $rowNumber;?>" name="incChq_<?= $rowNumber;?>" checked value="1" class="md-check">
	<label for="incChq_<?= $rowNumber;?>">
	<span></span>
	<span class="check"></span>
	<span class="box"></span></label>
	</div>
	</div>
    </td>
</tr>
<?php 
$rowNumber ++;
endforeach;
?>
</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="6">Total</th>
<td class="theme-bg th-right"><input type="text" name="tamount" /></td>
<th></th>
</tr>
</tfoot>
</table>



</div>


</div>
</div>
<input type='hidden' name='nrows' value='1' />
</form>
<script>
$("[name=faccount]").val(<?= $data[0]['FACODE']?>);
$("[name=taccount]").val(<?= $data[0]['TACODE']?>);
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
