<form class="form-horizontal promise-comment edit-comment">
<input type="hidden" name="no" value="<?= $data[0]['NO']?>" />
<input type="hidden" name="vdate" value="<?= $data[0]['VDATE']?>" />
<div class="form-group">
<div class="col-sm-6 show-error">
<input type="text" name="pamount" data-only-numbers class="form-control" value="<?= $data[0]['PAMOUNT']?>" placeholder="Amount Paid"/>
</div>
<div class="col-sm-6 show-error">
<select class="form-control" name="cstatus_e">
<option value="">Status</option>
<option value="0">Closed</option>
<option value="1">Extend</option>
</select>
</div>
</div>
<div class="form-group">
<div class="col-sm-12 show-error">
<textarea name="description" class="form-control todo-taskbody-taskdesc" rows="4" placeholder="Description..."><?= $data[0]['DESCR']?></textarea>
</div>
</div>
<div class="form-group extend">
<div class="col-sm-6 show-error">
<input type="text" name="eamount" data-only-numbers class="form-control" value="<?= $data[0]['EAMOUNT']?>" placeholder="Expected Amount"/>
</div>
<div class="col-sm-6 show-error">
<input type="text" name="edate" value="<?= date("d/m/Y",strtotime($data[0]['EDATE']))?>" class="form-control" placeholder="Expected Date"/>
</div>
</div>
<div class="form-actions right todo-form-actions">
<button class="btn btn-circle btn-sm green" type="submit">Update</button>
</div>
</form>
<script>
<?php 
if($data[0]['STATUS']==0){
?>
$(".edit-comment").find(".extend").hide();
<?php 
}
?>
$(".edit-comment").find("[name=cstatus_e]").val(<?= $data[0]['STATUS']?>);
$(".edit-comment").on("change","[name=cstatus_e]",function(){
if($(this).val()==1){
$(".edit-comment").find(".extend").show();	
}
else{
$(".edit-comment").find(".extend").hide();	
}	
});
$(".edit-comment").find("[name=edate]").datepicker({rtl:App.isRTL(),orientation:"left",autoclose:!0,format:"dd/mm/yyyy",todayHighlight:true});
$(".edit-comment").find("[data-only-numbers]").each(function(){
var cleave = new Cleave($(this), {
    numeral: true,
    numeralThousandsGroupStyle: 'lakh',
	numeralDecimalScale:4
});	
$(this).css("text-align","right");
});
</script>