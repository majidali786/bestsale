var printUrl="";
$(document).on("click","[print]",function(){
var type=$(this).attr("print-type");
var format=$(this).attr("print-format");
var name=$(this).attr("print-name");
var no=0;
var error=[];
if(type==undefined){
error.push("Print Type Is not defined!");		
}
else if(type=="voucher"){
no=$('[name=no]').val();	
if(no==undefined){
error.push("Voucher No. Is not defined or change print type");		
}
}
if(format==undefined){
error.push("Print format is not defined!");		
}
if(name==undefined){
error.push("Print Name is not defined!");		
}
if(printUrl==""){
error.push("Print Url is not defined!");	
}
if(error.length==0){
var modal=$('.modal-print');
modal.find(".modal-dialog").css("width","70%");
modal.find(".modal-title").html("<i class='icon-printer'></i> Print");
modal.modal();
modal.find(".modal-body").customPreloader("show");	
$.post(printUrl,{type:type,format:format,name:name,no:no},function(response){
modal.find(".modal-body").html(response);	
});	
}
else{
bootbox.dialog({title:notifications['error'],message:error.toString(),buttons:{close:{label:'Ok',className:"red"}}});	
}
});	

// tasawar 
$(document).on("click",".print_voucher",function(){
var type=$(this).attr("print-type");
var format=$(this).attr("print-format");
var name=$(this).attr("print-name");
var no=0;
var error=[];
if(type==undefined){
error.push("Print Type Is not defined!");		
}
else if(type=="voucher"){
no=$('[name=no]').val();	
if(no==undefined){
error.push("Voucher No. Is not defined or change print type");		
}
}
if(format==undefined){
error.push("Print format is not defined!");		
}
if(name==undefined){
error.push("Print Name is not defined!");		
}
if(printUrl==""){
error.push("Print Url is not defined!");	
}
if(error.length==0){
var modal=$('.modal-print');
modal.find(".modal-dialog").css("width","70%");
modal.find(".modal-title").html("<i class='icon-printer'></i> Print");
modal.modal();
modal.find(".modal-body").customPreloader("show");	
$.post(printUrl,{type:type,format:format,name:name,no:no},function(response){
modal.find(".modal-body").html(response);	
});	
}
else{
bootbox.dialog({title:notifications['error'],message:error.toString(),buttons:{close:{label:'Ok',className:"red"}}});	
}
});	