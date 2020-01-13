
/*
| -------------------------------------------------------------------------
| Custom fucntion Written by tasawar chohan 07-12-18
| -------------------------------------------------------------------------
|*/

$(document).on("keyup","[name=weight]",function(){
var unit = $('#unit').val();
//this pweight input in on wach voucher main.php page on line number 1
var pweight = removeCommas($('#pweight').val());
var weight = removeCommas(this.value);
if (unit == 'Kg') 
{
var qty = addcommas(Math.round(weight/pweight,2));
$('[name=qty]').val(qty);
}
else if (unit == 'Bag') 
{
var qty = addcommas(Math.round(weight*pweight,2));
$('[name=qty]').val(qty);
}
});

// $(document).on("change","[name=pname]",function(){
// var val=$(this).val();	
// if(val!=""){
// $.get("<?= base_url('data/product-weight');?>",{pcode:val},function(response){
// if(response.success=='true'){
// alert(response.pweight);
// $('[name=pweight]').val(response.pweight);	
// }
// },"json");	
// }
// });	