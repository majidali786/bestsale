var baseUrl;
$(document).on("click","[menu-rights]",function(){
	var obj=$(this).parents(".btn-group").find("[user]");
	var user=obj.attr("user");
	var url=baseUrl+"/menu-rights";
	var modal=$('.modal-edit');
	modal.find(".modal-dialog").css("width","90%");
	modal.find(".modal-title").html("Menu Rights");
	var target=modal.find(".modal-body");
	target.customPreloader("show");
	modal.modal("show");
	$.get(url,{user:user},function(response){
	if(response.success=="true"){
	target.html(response.data);	
	}
	else{
	bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'Ok',className:"red"}}});		
	}
	},"json")
});
$(document).on("click","[voucher-rights]",function(){
	var obj=$(this).parents(".btn-group").find("[user]");
	var user=obj.attr("user");
	var url=baseUrl+"/voucher-rights";
	var modal=$('.modal-edit');
	modal.find(".modal-dialog").css("width","90%");
	modal.find(".modal-title").html("Voucher Rights");
	var target=modal.find(".modal-body");
	target.customPreloader("show");
	modal.modal("show");
	$.get(url,{user:user},function(response){
	if(response.success=="true"){
	target.html(response.data);	
	}
	else{
	bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'Ok',className:"red"}}});		
	}
	},"json")
});
$(document).on("click","[other-rights]",function(){
	var obj=$(this).parents(".btn-group").find("[user]");
	var user=obj.attr("user");
	var url=baseUrl+"/other-rights";
	var modal=$('.modal-edit');
	modal.find(".modal-dialog").css("width","50%");
	modal.find(".modal-title").html("Other Rights");
	var target=modal.find(".modal-body");
	target.customPreloader("show");
	modal.modal("show");
	$.get(url,{user:user},function(response){
	if(response.success=="true"){
	target.html(response.data);	
	}
	else{
	bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'Ok',className:"red"}}});		
	}
	},"json")
});
