<table class="table table-bordered table-striped table-condensed">
<thead class="theme-bg">
<tr>
<th>Services</th>
<th>Description</th>
<th>Amount</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="pcode_e" class="hidden-data" />
<select name="pname_e" id="pname_e" change-assign-value="pcode_e" data-required hidden-data="pcode_e" data-name-array="aname_name" class="form-control select2" >
<option value="">Select Services</option>
<?php 
if(count($services)){
foreach($services as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['SERVICES']; ?></option>
<?php
}
}
?>
</select></td>
<td>
<input type="text"  class="form-control" name="descrip_e"  placeholder="Description" >
</td>
<td>
<input type="text" data-required data-only-numbers class="form-control th-right" name="amount_e" placeholder="Amount" >
</td>
</tr>
</tbody>
</table>
<script>
$('[name=pname_e]').select2({width:"100%"});
$('[name=pname_e]').parents("table").find("[data-only-numbers]").popover({content: "",placement: "bottom",trigger:"focus",container: 'body'});
$('[name=pname_e]').parents("table").find("[data-only-numbers]").each(function(){
var cleave = new Cleave($(this), {
    numeral: true,
    numeralThousandsGroupStyle: 'lakh',
	numeralDecimalScale:4
});	
});	
</script>
<div class="form-actions">
<button type="button" class="btn green update-row">Update</button>
<button type="button" class="btn default" data-dismiss="modal" >Close</button>
</div>