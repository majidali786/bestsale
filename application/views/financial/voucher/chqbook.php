<table class="table table-striped table-bordered">
<tbody>
<?php 
if(!empty($data)){
?>
<tr><th colspan="2"><h2 style="margin:0;padding:0;">Bank : <?= $data[0]['BNAME']?></h2></th></tr>
<tr>
<th style="width:50%;"><h3 style="margin:0;padding:0;">Cheque Book</h3></th>
<td>
<select class="form-control" name="bchqbook" value="bchqbook">
<option>Select Cheque Book</option>
<?php 
foreach($data as $row){
?>
<option value="<?= $row['BNO']?>"><?= $row['BNO']?></option>
<?php 	
}
?>
</select>
</td>
</tr>
<?php 
}
else{
?>
<tr><th colspan="2"><h2 style="margin:0;padding:0;">No Cheque Book Found</h2></th></tr>
<?php 	
}
?>
</tbody>
</table>
<div chq-book-chqs></div>
<script>
<?php 
if(!empty($data)){
?>
$(document).find("[name=bchqbook]").select2({width:"100%"});
$(document).on("change","[name=bchqbook]",function(){
var data={
	cbcode:$(this).val(),
	bcode:'<?= $data[0]['BCODE']?>'
	
}	
if($(this).val()!=""){
$('[chq-book-chqs]').customPreloader("show");	
var url="<?= base_url("data/chq-book-chqs");?>";
$.get(url,data,function(response){
$('[chq-book-chqs]').customPreloader("hide");
$(document).find("[chq-book-chqs]").html(response.chqbook);			
},'json');		
}	
});
</script>
<?php 
}
?>
