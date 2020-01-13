(function($){
	$.fn.serializeForm=function(){
	var obj=$(this);
	var formdata=new FormData();
	$.each($(obj).find("input[type=file]"),function(i,tag){
		$.each($(tag)[0].files,function(i,file){
			formdata.append(tag.name,file);	
		});	
	});
	var params=$(obj).serializeArray();
	$.each(params,function(key,val){
	formdata.append(val.name,val.value);	
	});
	return formdata;	
	}
})(jQuery);
(function(){

    /**
     * Decimal adjustment of a number.
     *
     * @param   {String}    type    The type of adjustment.
     * @param   {Number}    value   The number.
     * @param   {Integer}   exp     The exponent (the 10 logarithm of the adjustment base).
     * @returns {Number}            The adjusted value.
     */
    function decimalAdjust(type, value, exp) {
        // If the exp is undefined or zero...
        if (typeof exp === 'undefined' || +exp === 0) {
            return Math[type](value);
        }
        value = +value;
        exp = +exp;
        // If the value is not a number or the exp is not an integer...
        if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
            return NaN;
        }
        // Shift
        value = value.toString().split('e');
        value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
        // Shift back
        value = value.toString().split('e');
        return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
    }

    // Decimal round
    if (!Math.round10) {
        Math.round10 = function(value, exp) {
            return decimalAdjust('round', value, exp);
        };
    }
    // Decimal floor
    if (!Math.floor10) {
        Math.floor10 = function(value, exp) {
            return decimalAdjust('floor', value, exp);
        };
    }
    // Decimal ceil
    if (!Math.ceil10) {
        Math.ceil10 = function(value, exp) {
            return decimalAdjust('ceil', value, exp);
        };
    }

})();
(function ($) {
$.fn.uploadPreview = function(options) {
	var div=$(this);
	var settings = $.extend({
        default_text: '<i class="fa fa-plus-circle"></i>',
        edit_text: '<i class="fa fa-pencil"></i>',
        remove_text: '<i class="fa fa-remove"></i>',
        no_label: false,
        success_callback : null,
      }, options);
	div.each(function(){
	$(this).prepend('<label for="image-upload" class="image-label">'+settings.default_text+'</label>'+
		 '<div class="image-edit" style="display:none;">'+settings.edit_text+'</div>'+
		 '<div class="image-remove"  style="display:none;">'+settings.remove_text+'</div>');
	$(this).children("input[type=file]").hide();		
	});
	div.children(".image-label,.image-edit").on("click",function(){
	$(this).parent().children("input[type=file]").trigger("click");	
	});
	div.children(".image-remove").on("click",function(){
	$(this).parent().css("background-image", "none");	
	$(this).parent().children("input[type=file]").val("");
	$(this).parent().children(".image-label").show();
	$(this).parent().children(".image-edit").hide();
	$(this).parent().children(".image-remove").hide();	
	});	
	div.children("input[type=file]").on("change",function(){
			var inputFile=$(this);
            var files = this.files;
            if (files.length > 0) {	
              var file = files[0];
              var reader = new FileReader();

              // Load file
              reader.addEventListener("load",function(event) {
                var loadedFile = event.target;

                // Check format
                if (file.type.match('image')) {
                  // Image
                 inputFile.parent().css("background-image", "url("+loadedFile.result+")");
                 inputFile.parent().css("background-size", "cover");
                 inputFile.parent().css("background-position", "center center");
				 inputFile.parent().children(".image-label").hide();
				 inputFile.parent().children(".image-edit").show();
				 inputFile.parent().children(".image-remove").show();
                }
				else {
                  swal("Select Only Images");
				inputFile.parent().children(".image-label").show();
				inputFile.parent().children(".image-edit").hide();
				inputFile.parent().children(".image-remove").hide();
				inputFile.val("");
                }
              });
              // Read the file
              reader.readAsDataURL(file);

              // Success callback function call
              if(settings.success_callback) {
                settings.success_callback();
              }
            } else {
              // Clear background
              inputFile.parent().css("background-image", "none");
			  inputFile.parent().children(".image-label").show();
			  inputFile.parent().children(".image-edit").hide();
			  inputFile.parent().children(".image-remove").hide();
            }
         
	});	
    return this;
    };	
})(jQuery);
$(document).on("submit","form",function(){
	var obj=$(this);
	if(!obj.hasClass("action-url") && !obj.hasClass("action-url-extra"))
	{
	obj.find(".imgExist").removeClass("imgExist");
	if(obj.hasClass("edit-form"))
	{
	urlPrefix="update";	
	}
	else{
	urlPrefix="save";		
	}	
	obj.find("[type=submit]").attr("disabled",true);
	var data=obj.serializeForm();
	var url=window.location.href+'/'+urlPrefix;
	$.ajax({
	url:url,
	type:"POST",
	data:data,
	contentType:false,
	processData:false,
	dataType:"JSON"	
	}).done(function(response){
	obj.find('.text-danger').remove();	
	if(response.success=="true")
	{
	$.each(obj.find(".selectpicker"),function(i,tag){
	$(tag).val('default');
	$(tag).selectpicker("refresh");	
	});
	obj.find("[type=reset]").trigger("click");
	obj.find(".image-remove").trigger("click");
	if(obj.hasClass("edit-form"))
	{
	$('.modal-edit').modal("hide");	
	bootbox.dialog({title:notifications['success'],message:"Successfully Updated",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green"}}});
	}
	else{
	bootbox.dialog({title:notifications['success'],message:"Successfully Added",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green"}}});	
	}
	if(obj.hasClass("list-refresh"))
	{
	$('.loadlist').trigger("click");		
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
	}
	event.preventDefault();		
});
var notifications={
	error:'<span class="fa fa-times-circle fa-2x" '
                +    'style="vertical-align:middle;color:#e10000;">'
                + '</span> Error',
	success:'<span class="fa fa-check-circle fa-2x" '
                +    'style="vertical-align:middle;color:#006634;">'
                + '</span> Success',
	del:'<span class="fa fa-trash fa-2x" '
                +    'style="vertical-align:middle;color:#e10000;">'
                + '</span> Delete',
	warning:'<span class="fa fa-exclamation-triangle fa-2x" '
                +    'style="vertical-align:middle;color:orange;">'
                + '</span> Warning',
};
$('.loadlist').on("click",function(){
var obj=$(this).parents(".portlet").find("[data-list-load]");
var url=window.location.href+'/list';
var preloader=obj;	
preloader.customPreloader("show");
$.post(url,function(data){
$(obj).html(data);	
preloader.customPreloader("hide");
});
});	
$('body').on("click",".edit",function(){
var id=$(this).attr("data-id");
if(id!="")
{
var url=window.location.href+'/edit';
var modal=$('.modal-edit');
modal.find(".modal-title").html("Edit");
modal.modal();
modal.find(".modal-body").customPreloader("show");
$.post(url,{id:id},function(data){
modal.find(".modal-body").html(data);	
});	
}

$(document).find(".select2").select2({
	width:"100%"
});
});	
$('body').on("click",".delete",function(){
var id=$(this).attr("data-id");
if(id!="")
{
	var url=window.location.href+'/delete';	
	bootbox.dialog({
	message: "Are you sure you want to delete this ?",
	title:notifications['del'],
	buttons: {
	danger:{
	label: "Delete <i class='icon-trash'></i>",
	className: "red",
	callback: function() {
	$.post(url,{id:id},function(data){
	$('body').find('.loadlist').trigger("click");	
	bootbox.dialog({title:notifications['success'],message:"Successfully Deleted",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green"}}});
	});
	}
	},
	main:{
	label: "Cancel",
	className: "default",
	}
	}
	});
}
});		
var resetLink=1;
$('body').on("click","[type=reset]",function(){
resetLink=0;	
var obj=$(this).parents("form");	
obj.find('.text-danger').remove();
setTimeout(function(){
obj.find('select').trigger("change");
resetLink=1;		
},100);		
});
$(document).on("keypress","[int-numbers-only]",function(e){	
if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {	
return false;
}	
});
$(document).on("keyup","[data-dmas]",function(){
var data=$(this).attr("data-dmas");
	var result=0;
	$.each(data.split(","),function(i,tag){	
	var ob=tag.split("-");
	var obj=ob[0];
	var action=ob[1];
	var objValue=$('[name='+obj+']').val();
	if($.isNumeric(objValue) || action=="result" || action=="result.html" || action=="clear"){
	if(action=="multiply"){	
	result=parseFloat(result)*parseFloat(objValue);	
	}
	else if(action=="add"){	
	result=parseFloat(result)+parseFloat(objValue);	
	}
	else if(action=="minus"){	
	result=parseFloat(result)-parseFloat(objValue);	
	}
	else if(action=="result"){	
	$('[name='+obj+']').val(Math.round10(result,0));
	}
	else if(action=="result.html"){	
	$('[name='+obj+']').val(Math.round10(result,0));
	$('.'+obj+'').html(Math.round10(result,0));
	}
	else if(action=="clear"){	
	result=0;
	}
	}
	});
});

function load_main(url,div)
{
$.post(url,"",function(data){
$('#'+div+'').html(data);		
});
}


