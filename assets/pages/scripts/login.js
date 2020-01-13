var ajaxInvoke=0;
$(document).on("submit","form",function(){	
var form=$(this);
var preloader=form.parents('.content');
var url=form.attr("action");
var method="post";
var data=form.serializeArray();	
preloader.customPreloader("show");
if(ajaxInvoke==0)
{
ajaxInvoke++;
$.ajax({
	url:url,
	method:method,
	data:data,
	dataType:'JSON'
}).done(function(response){
ajaxInvoke=0;
form.find('.text-danger').remove();
form.find('.login-error').html("");	
if(response.success=="wrong"){
var error='<div class="alert alert-danger display-hide" style="display: block;">'+
                    '<span> '+response.error+' </span>'+
                '</div>';	
form.find('.login-error').html(error);	
}
else if(response.success=="false"){
$.each(response.error,function(index,value){
var abc=form.find('[name='+index+']').parents(".show-error");
abc.append('<div class="text-danger">* '+value+'</div>');
$('#'+index+'').focus();
});	
}
else if(response.success=="true"){
location.href=response.url;	
}
preloader.customPreloader("hide");
});
}
event.preventDefault();
});