$(document).on("submit",".action-url",function(){
	var obj=$(this);	
	obj.find("[type=submit]").attr("disabled",true);
	var data=obj.serializeArray();
	var data2=$('.main-form').serializeArray();
	$.each(data2,function(i,tag){	
	data.push({name:tag.name,value:tag.value});
	})
	var url=$(this).attr("action");
	var level=$(this).attr("level");
	$.ajax({
	url:url,
	type:"POST",
	data:data,
	dataType:"JSON"	
	}).done(function(response){
	obj.find('.text-danger').remove();	
	if(response.success=="true")
	{
	$(".level-"+level+"").parents(".btn-group").find("[reload-level]").trigger("click");		
	$('.modal-edit').modal("hide");		
	if(obj.hasClass("edit-form"))
	{
	bootbox.dialog({title:notifications['success'],message:"Successfully Updated",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green"}}});
	}
	else{
	bootbox.dialog({title:notifications['success'],message:"Successfully Added",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green"}}});	
	}
	}
	else if(response.success=="false"){
	$.each(response.error,function(index,value){
	var abc=obj.find('[name='+index+']').parents(".show-error");
	abc.append('<div class="text-danger">* '+value+'</div>');
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
	event.preventDefault();	
});
$(document).on("submit",".action-url-extra",function(){
	var obj=$(this);	
	obj.find("[type=submit]").attr("disabled",true);
	var data=obj.serializeArray();
	var url=$(this).attr("action");
	var level=$(this).attr("level");
	$.ajax({
	url:url,
	type:"POST",
	data:data,
	dataType:"JSON"	
	}).done(function(response){
	obj.find('.text-danger').remove();	
	if(response.success=="true")
	{
	$(".level-"+level+"").parents(".btn-group").find("[reload-level]").trigger("click");		
	$('.modal-edit-extra').modal("hide");		
	if(obj.hasClass("edit-form"))
	{
	bootbox.dialog({title:notifications['success'],message:"Successfully Updated",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green"}}});
	}
	else{
	bootbox.dialog({title:notifications['success'],message:"Successfully Added",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green"}}});	
	}
	}
	else if(response.success=="false"){
	$.each(response.error,function(index,value){
	var abc=obj.find('[name='+index+']').parents(".show-error");
	abc.append('<div class="text-danger">* '+value+'</div>');
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
	event.preventDefault();	
});	
	

