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
<input type="text" style="text-align-center" class="form-control move-enter-up move-enter-start move-enter-1"  data-position="1" int-numbers-only name="no" value="<?= $max;?>" placeholder="Voucher No.">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Voucher Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" style="text-align-center" class="form-control move-enter-up move-enter-2" data-position="2"  input-mask-date name="vdate" value="<?= $vdate?>" placeholder="dd/mm/yyyy">
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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Bill No.</label>
<div class="col-md-12">
<input type="text" class="form-control move-enter-up move-enter-4" data-position="4" name="vno" value="<?= $data[0]['VNO']?>"  placeholder="Bill No.">
</div>
</div>
</div>



<div class="col-sm-6">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Remarks.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-to-row move-enter-5" data-position="5" name="remarks" value="<?= $data[0]['REMARKS']?>"  placeholder="Remarks">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Credit.Days.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-to-row move-enter-6" data-position="6" value="<?= $data[0]['CRDAYS']?>" name="crdays"  placeholder=" Credit.Days">
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
<th style="width:5%;">Sr#</th>
<th style="width:25%;text-align: center;";>Design</th>
<th style="width:20%;text-align: center;";>Image</th>
<th style="width:8%;text-align: center;";>Color</th>
<th style="width:10%;text-align: center;";>Qty</th>
<th style="width:12%;text-align: center;";>Unit Price</th>
<th style="width:12%;text-align: center;";>Amount</th>
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
        <input type="hidden" name="design_<?= $rowNumber;?>" value="<?= $row['PNAME'];?>" hidden-data="pcode_<?= $rowNumber;?>" class="form-control">
        <input type="hidden" name="pcode_<?= $rowNumber;?>" value="<?= $row['PCODE'];?>">
    </td>
		
	
	  <td class="image-preview <?php if($row[0]['IMG']!=""){ echo "imgExist";}?>" data-url="<?= $row[0]['IMG']?>">
        <input type="file" accept="image/*" name="img_<?= $rowNumber;?>" value="<?= $row['IMG'];?>" class="form-control image-input">
    </td>
	
    <td><span><?= $row['UNIT'];?></span>
        <input type="hidden" name="color_<?= $rowNumber;?>" value="<?= $row['UNIT'];?>" class="form-control">
    </td>
  
    <td class="th-right"><span><?= $row['QTY'];?></span>
        <input type="hidden" name="qty_<?= $rowNumber;?>" value="<?= $row['QTY'];?>" class="form-control sum_qty">
    </td>
    <td class="th-right"><span><?= $row['RATE'];?></span>
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
<th colspan="3">Total</th>
<td class="theme-bg th-right" style="text-align-right"><input type="text" name="tqty" /></td>
<td colspan="1"></td>
<td class="theme-bg th-right" style="text-align-right"><input type="text" name="tamount" /></td>
</tr>
</tfoot>
</table>
</div>
<div class="col-sm-12">
<table class="table table-bordered table-striped table-condensed flip-content">
<tr class="theme-bg">
<th style="width:70%"></th>
<th>Last Balance</th>

<td  class="show-error th-right"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-12" data-position="12" name="gstamt" data-dmas="tamount-add,gstamt-percentage-gst,net-result"  placeholder="Last Balance" value="<?= $data[0]['GSTAMT']?>"></td>
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
$('.edit-form').find('.image-preview').uploadPreview();
$.each($('.edit-form').find('.image-preview'),function(i,tag){
var img=$(this).attr("data-url");
var n = Date.now();
if(img!="")
{	
$(this).css("background-image", "url(<?= img_url();?>order/design/"+img+"?"+n+")");
$(this).css("background-size", "cover");
$(this).css("background-position", "center center");
$(this).children(".image-label").hide();
$(this).children(".image-edit").show();
$(this).children(".image-remove").show();	
}
});
$('.edit-form').on("click",".image-remove",function(){	
var inputFile=$(this);	
if(inputFile.parent().hasClass("imgExist"))
{	
var id=$('.edit-form').find("#id").val();	
var img=inputFile.parent().attr("data-url");	
var input=inputFile.parent().find("input[type=file]").attr("name");	
var url=window.location.href+'/deleteFile';	
alertify.confirm(notifications['del'],"Are you sure you want to delete this?",
function(){
$.post(url,{img:img,input:input,id:id},function(data){
inputFile.parent().css("background-image", "none");
inputFile.parent().children(".image-label").show();
inputFile.parent().children(".image-edit").hide();
inputFile.parent().children(".image-remove").hide();	
inputFile.parent().removeClass("imgExist");	
alertify.success('Successfully Deleted !');	
});		
},function(){
inputFile.parent().css("background-image", "url(<?= img_url();?>order/design/"+img+")");
inputFile.parent().css("background-size", "cover");
inputFile.parent().css("background-position", "center center");
inputFile.parent().children(".image-label").hide();
inputFile.parent().children(".image-edit").show();
inputFile.parent().children(".image-remove").show();	
});	
}
});
$("[name=vname]").val(<?= $data[0]['VCODE']?>);
$("[name=pacode]").val(<?= $data[0]['PCODE']?>);

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
