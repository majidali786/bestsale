<form class="form-horizontal list-refresh" role="form">
<div class="form-body">

<div class="form-group">
<label class="col-md-3 control-label">Code</label>
<div class="col-md-3 show-error">
<input type="text" class="form-control" name="id"  style="text-align:center" placeholder="id" >
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Account</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="name" placeholder="Account">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">A/C Type</label>
<div class="col-md-9 show-error">
<select name="atype" class="form-control select2">
<option value="">Select Account Type</option>
<?php 
if(count($atype)){
foreach($atype as $g){
?>
<option value="<?= $g['TCODE']; ?>"><?= $g['TYPE']; ?></option>
<?php
}
}
?>
</select>
</div>
</div>

</div>
<div class="form-actions right1">
<button type="submit" name="submit" class="btn green">Submit</button>
<button type="reset" class="btn default">Reset</button>
</div>
</form>

<script>
$(document).on("click","[name=submit]",function(){
	
});

$(window).load(function(){
$.get("<?= base_url('data/get_max_acode');?>",{},function(response){
if(response.success=='true'){
$('[name=id]').val(response.acode);	
}
},"json");	
});
</script>

