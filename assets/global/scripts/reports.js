var ajaxInvoke=0;
var ledgerUrl="";
var ledgerDate="";
var voucherDetailsUrl="";
$(document).on("submit",".action-url",function(){
	var obj=$(this);
	if(ajaxInvoke==0){
	ajaxInvoke=1;	
	obj.find("[type=submit]").attr("disabled",true);
	var data=obj.serializeArray();
	var url=$(this).attr("action");
	var tar=$(this).attr("data-target");
	var target=$(''+tar+'');
	target.customPreloader("show");
	$.ajax({
	url:url,
	type:"POST",
	data:data,
	dataType:"JSON"	
	}).done(function(response){
	ajaxInvoke=0;	
	obj.find('.text-danger').remove();	
	target.customPreloader("hide");
	if(response.success=="true")
	{
	target.html(response.data);
	}
	else if(response.success=="false"){
	$.each(response.error,function(index,value){
	var abc=obj.find('[name="'+index+'"]').parents(".show-error");
	abc.append('<div class="text-danger">* '+value+'</div>');
	index=index.replace(/[\[\]']+/g,"");
	$('#'+index+'').focus();
	});	
	bootbox.dialog({title:notifications['error'],message:"Error",buttons:{close:{label:'Ok',className:"red"}}});
	}
	else{
	bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'Ok',className:"red"}}});
	}
	obj.find("[type=submit]").attr("disabled",false);
	}).fail(function(error){
	bootbox.dialog({title:notifications['error'],message:error,buttons:{close:{label:'Ok',className:"red"}}});		
	});
	}
	else{
		
	}
	event.preventDefault();	
});
function ledger(vcode){
var url=ledgerUrl;
var data={
party:vcode,
date:ledgerDate,
rtype:1
}
var modal=$('.modal-edit');
modal.find(".modal-dialog").css("width","90%");
modal.find(".modal-title").html("Customer Ledger");
modal.modal();
modal.find(".modal-body").customPreloader("show");
$.post(url,data,function(response){
modal.find(".modal-body").html(response.data);
},"json");
}
function partydetail(no){
var modal=$('.modal-voucher-details');
modal.find(".modal-dialog").css("width","80%");
modal.find(".modal-title").html("Voucher Details");
modal.modal();
modal.find(".modal-body").customPreloader("show");		
$.post(voucherDetailsUrl,{no:no},function(response){
if(response.success=="true"){
modal.find(".modal-body").html(response.data);	
}	
else{
modal.find(".modal-body").html("<h1>"+response.error+"</h1>");	
}
},"json");	
}

function chqdetail(vcode){
var url=chqdetailUrl;
var data={
party:vcode,
date:chqdetailDate
}
var modal=$('.modal-edit');
modal.find(".modal-dialog").css("width","90%");
modal.find(".modal-title").html("Cheque Details");
modal.modal();
modal.find(".modal-body").customPreloader("show");
$.post(url,data,function(response){
modal.find(".modal-body").html(response.data);
},"json");
}

function aging(vcode){
var url=agingUrl;
var data={
party:vcode,
date:agingDate
}
var modal=$('.modal-edit');
modal.find(".modal-dialog").css("width","90%");
modal.find(".modal-title").html("Aging Report");
modal.modal();
modal.find(".modal-body").customPreloader("show");
$.post(url,data,function(response){
modal.find(".modal-body").html(response.data);
},"json");
}

function balanceComparison(vcode){
var url=balanceComparisonUrl;
var data={
party:vcode,
date:agingDate
}
var modal=$('.modal-edit');
modal.find(".modal-dialog").css("width","90%");
modal.find(".modal-title").html("Balance Comparison");
modal.modal();
modal.find(".modal-body").customPreloader("show");
$.post(url,data,function(response){
modal.find(".modal-body").html(response.data);
},"json");
}	
function vdetail(no,type,bid){
var modal=$('.modal-voucher-details');
modal.find(".modal-dialog").css("width","80%");
modal.find(".modal-title").html("Voucher Details");
modal.modal();
modal.find(".modal-body").customPreloader("show");		
$.post(voucherDetailsUrl,{no:no,type:type,bid:bid},function(response){
if(response.success=="true"){
modal.find(".modal-body").html(response.data);	
}	
else{
modal.find(".modal-body").html("<h1>"+response.error+"</h1>");	
}
},"json");	
}
$(document).on("change",".disable-enable",function(){
var name=$(this).attr("name");	
var val=$("[name="+name+"]:checked").val();
var target=$(this).parents("[disable-enable]");
var elem=target.attr("disable-enable");
var disable=target.attr("disable-at");
var enable=target.attr("enable-at");
if(disable==val){	
$("#"+elem+"").prop("disabled",true);	
}
else{
$("#"+elem+"").prop("disabled",false);		
}
});
$(document).find(".disable-enable").trigger("change");