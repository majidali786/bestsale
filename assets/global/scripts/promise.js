var InsertCommenturl;
var singlePromiseUrl;
var promisePno;
$(document).on("submit",".promise-comment",function(){
	var data=$(this).serializeArray();
	var obj=$(this);
	if(obj.hasClass("edit-comment"))
	{
	urlPrefix="update";	
	}
	else{
	urlPrefix="save";		
	}	
	obj.customPreloader("show");
	obj.find("[type=submit]").attr("disabled",true);
	$.ajax({
	url:InsertCommenturl+"/"+urlPrefix,
	type:"POST",
	data:data,
	dataType:"JSON"	
	}).done(function(response){
	obj.customPreloader("hide");	
	obj.find('.text-danger').remove();	
	if(response.success=="true")
	{

	if(obj.hasClass("edit-comment"))
	{
	loadPromise();	
	$('.modal-edit-extra').modal("hide");	
	bootbox.dialog({title:notifications['success'],message:"Successfully Updated",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green",callback:function(){  }}}});
	}
	else{
	loadPromise();	
	bootbox.dialog({title:notifications['success'],message:"Successfully Added",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green",callback:function(){  }}}});	
	}
	}
	else if(response.success=="false"){
	var errorToString="";
	var err=0;
	$.each(response.error,function(index,value){
	var abc=obj.find('[name='+index+']').parents(".show-error");
	if(obj.find('[name='+index+']').length>0 && !obj.find('[name='+index+']').is(":hidden")){
	abc.append('<div class="text-danger">* '+value+'</div>');
	$('#'+index+'').focus();
	errorToString="Error";
	err++;
	}
	else if(obj.find('[name='+index+']').is(":hidden")){
	errorToString=errorToString+"<span>"+value+"</span></br>";	
	}
	else{
	errorToString=errorToString+"<span>"+value+"</span></br>";	
	}
	});
	if(err>0){
	errorToString="Error";		
	}
	bootbox.dialog({title:notifications['error'],message:errorToString,buttons:{close:{label:'Ok',className:"red"}}});
	}
	else if(response.success=="error"){
	bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'Ok',className:"red"}}});
	}
	else{
	bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'Ok',className:"red"}}});
	}
	obj.find("[type=submit]").attr("disabled",false);
	}).fail(function(error){
	bootbox.dialog({title:notifications['error'],message:error,buttons:{close:{label:'Ok',className:"red"}}});		
	});
	event.preventDefault();	
	});
	function loadPromise(){
	var modal=$(".modal-edit");	
	modal.find(".modal-body").customPreloader("show");
	$.ajax({
	url:singlePromiseUrl,	
	method:"get",
	data:{pno:promisePno}
	}).done(function(response){
	modal.find(".modal-body").html(response);
	});		
	}
	$(document).on("click","[promise-no]",function(){
	var modal=$(".modal-edit");
	var pno=$(this).attr("promise-no");	
	modal.find(".modal-title").html("Promise Details");
	modal.find(".modal-body").customPreloader("show");
	modal.modal("show");
	$.ajax({
	url:singlePromiseUrl,	
	method:"get",
	data:{pno:pno}
	}).done(function(response){
	modal.find(".modal-body").html(response);
	});	
});
$(document).on("click","[promise-closed]",function(){
	var url=InsertCommenturl+"/close";	
	bootbox.dialog({
	message: "Are you sure you want to Close this Promise?",
	title:notifications['clos'],
	buttons: {
	danger:{
	label: "Close <i class='icon-close'></i>",
	className: "red",
	callback: function(){
	$.post(url,function(response){
	if(response.success=="true"){
	loadPromise();		
	bootbox.dialog({title:notifications['success'],message:"Successfully Closed",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green",callback:function(){  }}}});
	}
	else{
	bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"red"}}});	
	}
	},"json");
	}
	},
	main:{
	label: "Cancel",
	className: "default",
	}
	}
	});
});
$(document).on("click","[promise-open]",function(){
	var url=InsertCommenturl+"/open";	
	bootbox.dialog({
	message: "Are you sure you want to Open this Promise?",
	title:notifications['opened'],
	buttons: {
	danger:{
	label: "Open <i class='icon-envelope-open'></i>",
	className: "green",
	callback: function(){
	$.post(url,function(response){
	if(response.success=="true"){
	loadPromise();		
	bootbox.dialog({title:notifications['success'],message:"Successfully Opened",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green",callback:function(){ }}}});
	}
	else{
	bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"red"}}});	
	}
	},"json");
	}
	},
	main:{
	label: "Cancel",
	className: "default",
	}
	}
	});
});
$(document).on("click","[promise-comment-edit]",function(){
	var modal=$(".modal-edit-extra");
	var no=$(this).parents("[promise-comment-no]").attr("promise-comment-no");	
	modal.find(".modal-title").html("Edit Promise Comment");
	modal.find(".modal-body").customPreloader("show");
	modal.modal("show");
	$.ajax({
	url:InsertCommenturl+"/edit",	
	method:"get",
	data:{no:no}
	}).done(function(response){
	modal.find(".modal-body").html(response);
	});	
});
$(document).on("click","[promise-comment-delete]",function(){
	var url=InsertCommenturl+"/delete";	
	var no=$(this).parents("[promise-comment-no]").attr("promise-comment-no");	
	bootbox.dialog({
	message: "Are you sure you want to Delete this comment?",
	title:notifications['del'],
	buttons: {
	danger:{
	label: "Delete <i class='icon-trash'></i>",
	className: "red",
	callback: function(){
	$.post(url,{no:no},function(response){
	if(response.success=="true"){
	loadPromise();		
	bootbox.dialog({title:notifications['success'],message:"Successfully Deleted",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green",callback:function(){  }}}});
	}
	else{
	bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"red"}}});	
	}
	},"json");
	}
	},
	main:{
	label: "Cancel",
	className: "default",
	}
	}
	});
});
