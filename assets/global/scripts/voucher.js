var ajaxInvoke=0;
(function () {

numberToWords=function(num){
nm=num.split(".");
num=nm[0];
var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '];
var c = ['zero', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine'];
var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
if ((num = num.toString()).length > 9) return 'overflow';
n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
if (!n) return;
var str = '';
str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + '' : '';
if(nm[1]!==undefined && nm[1]!=""){
var dc=nm[1].split("");
str +=" point "+c[dc[0]];
if(dc[1]!==undefined && dc[1]>0){
str +=" "+c[dc[1]];	
}
}
return str;
};

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

(function () {

lakhSeparator=function(value){
value=value.toString();	
var numeralDecimalMark=".";
var numeralPositiveOnly=false;
var numeralDecimalScale=2;
var numeralIntegerScale=0;
var delimiter=",";
var stripLeadingZeroes=false;
var parts, partInteger, partDecimal = '';

// strip alphabet letters
value = value.replace(/[A-Za-z]/g, '')
// replace the first decimal mark with reserved placeholder
.replace(numeralDecimalMark, 'M')

// strip non numeric letters except minus and "M"
// this is to ensure prefix has been stripped
.replace(/[^\dM-]/g, '')

// replace the leading minus with reserved placeholder
.replace(/^\-/, 'N')

// strip the other minus sign (if present)
.replace(/\-/g, '')

// replace the minus sign (if present)
.replace('N', numeralPositiveOnly ? '' : '-')

// replace decimal mark
.replace('M', numeralDecimalMark);

// strip any leading zeros
if (stripLeadingZeroes) {
value = value.replace(/^(-)?0+(?=\d)/, '$1');
}

partInteger = value;

if (value.indexOf(numeralDecimalMark) >= 0) {
parts = value.split(numeralDecimalMark);
partInteger = parts[0];
partDecimal = numeralDecimalMark + parts[1].slice(0, numeralDecimalScale);
}

if (numeralIntegerScale > 0) {
partInteger = partInteger.slice(0, numeralIntegerScale + (value.slice(0, 1) === '-' ? 1 : 0));
}

partInteger = partInteger.replace(/(\d)(?=(\d\d)+\d$)/g, '$1' + delimiter);

return partInteger.toString() + (numeralDecimalScale > 0 ? partDecimal.toString() : '');


};

})();

jQuery.fn.putCursorAtEnd = function() {
return this.each(function() {
$(this).focus()
// If this function exists...
if (this.setSelectionRange) {
// ... then use it (Doesn't work in IE)
// Double the length because Opera is inconsistent about whether a carriage return is one character or two. Sigh.
var len = $(this).val().length * 2;
this.setSelectionRange(len, len);
} else {
// ... otherwise replace the contents with itself
// (Doesn't work in Google Chrome)
$(this).val($(this).val());
}
// Scroll to the bottom, in case we're in a tall textarea
// (Necessary for Firefox and Google Chrome)
this.scrollTop = 999999;
});
};

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

function removeCommas(value){
return value.toString().replace(/,/g,'');
}
function addcommas(str) {
return str.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); 
} 


$("[data-only-numbers]").each(function(){
var cleave = new Cleave($(this), {
numeral: true,
numeralThousandsGroupStyle: 'lakh',
numeralDecimalScale:4
});	
$(this).css("text-align","right");
});

$(document).on("change","[change-assign-value]",function(){	
var objArray=$(this).attr("change-assign-value");
var value=$(this).val();
if($(this).is("[value-splitter]")){
var splitter=$(this).attr("value-splitter");
var vindex=$(this).attr("value-index");
var amt=value.split(splitter);
value=amt[vindex];	
}
objArray=objArray.split(",");	
$.each(objArray,function(i,tag){
$('[name='+tag+']').val(value);
});
});

$('body').on("click","[type=reset]",function(){
var obj=$(this).parents("form");	
obj.find('.text-danger').remove();
setTimeout(function(){
obj.find('select').trigger("change");			
},100);		
});

///////////enter function for input

$('.move-enter-start').putCursorAtEnd();
var rowNumber=1;
var ProrowNumber=1;
var totalRows=1;
var upperPosition=1;
var rowPosition=1;
var baseUrl="";
var editRow=0;
var error=[];
$('form').append("<input type='hidden' name='nrows' value='1' />");
$('form').append("<input type='hidden' name='nprorows' value='1' />");

$(document).on("keyup","input",function(e){	
var present=$(this);
if(e.keyCode==13)
{	
if(present.hasClass("move-enter-up")){
var currentPostion=present.attr("data-position");
if(!present.hasClass("move-to-row")){	
var nextPosition=parseFloat(currentPostion)+1;
var next=$(".move-enter-"+nextPosition+"");
upperPosition=nextPosition;
if(next.is("input")){
next.putCursorAtEnd();	
}
else{
next.putCursorAtEnd();
next.select2('val','');		
next.select2("open");	
}
}
else{
rowPosition=1;	
var next=$(".row-start");
if(next.is("input")){
next.putCursorAtEnd();	
}
else{
next.putCursorAtEnd();	
next.select2("open");	
next.select2('val', '');
}	
}	
}
else if(present.hasClass("move-enter-row") && !present.hasClass("move-enter-prorow")){	
var currentPostion=present.attr("data-position");
if(present.hasClass("move-enter-row") && !present.hasClass("row-end")){	
var nextPosition=parseFloat(currentPostion)+1;
var next=$(".enter-"+nextPosition+"");
rowPosition=nextPosition;
if(next.is("input")){
next.putCursorAtEnd();	
}
else{
next.putCursorAtEnd();	
next.select2("open");
next.select2('val', '');	
}
}
else if(present.hasClass("row-end")){
var data=[];
var error=[];	
$('.data-row input,.data-row select').each(function(i,tag){
var rowData={};	
var rowTag=$('[name='+tag.name+']');
if(rowTag.is("[data-required]") && rowTag.val()==''){
error.push({name:tag.name,error:"This Field is Required"});	
}
if(rowTag.is("[data-unique]") && $('#'+rowTag.val()+'').length > 0){
error.push({name:tag.name,error:"Must contain A unique value"});	
}
if(rowTag.is("[data-only-numbers]") && !$.isNumeric(removeCommas(rowTag.val()))){
error.push({name:tag.name,error:"Only Numbers are allowed"});	
}
if(rowTag.is("[greater-then-zero]") && rowTag.val()<=0){
error.push({name:tag.name,error:"Must be greater then 0"});	
}
if(rowTag.is("[if-greater-then-zero]") && !$.isNumeric(removeCommas(rowTag.val()))){
error.push({name:tag.name,error:"Only Numbers are allowed"});	
}
else if(rowTag.is("[if-greater-then-zero]") && rowTag.val()<=0){
var ifelse=rowTag.attr("if-greater-then-zero");	
if($('[name='+ifelse+']').val()<=0 || $('[name='+ifelse+']').val()==""|| !$.isNumeric(removeCommas($('[name='+ifelse+']').val()))){
error.push({name:tag.name,error:"Must be greater then 0"});	
}
}	
rowData['name']=tag.name;
rowData['type']="input";
if(rowTag.is("select")){
rowData['type']="select";	
}
else if(rowTag.hasClass("hidden-data")){
rowData['type']="hidden";		
}	
rowData['value']=rowTag.val();
if(rowTag.is("[hidden-data]")){
rowData['hidden-data']=rowTag.attr("hidden-data");	
}
if(rowTag.is("[data-sum]")){
rowData['data-sum']=rowTag.attr("data-sum");	
}
if(rowTag.is("[data-name-array]")){
rowData['data-name-array']=rowTag.attr("data-name-array");
rowData['data-name']=$('#select2-'+tag.name+'-container').html();
}
if(rowTag.is("[ajax-data]")){
rowData['select2-val']=rowTag.val();
rowData['select2-show']=$('#select2-'+tag.name+'-container').html();
}
if(rowTag.is("[data-unique]")){
rowData['data-unique']=rowTag.val();
}
if(rowTag.is("[data-only-numbers]")){
rowData['data-only-numbers']="true";
}
data.push(rowData);	
});
if(error.length==0){	
if(makeRow(data)){
$('.data-row input,.data-row select').val("");	
$('.data-row select').select2("val","");
rowPosition=1;
clearRow();	
dataSum();
}
}
else{
$(document).find('.data-row').find(".text-danger").remove();	
$.each(error,function(i,tag){	
rowTag=$('[name='+tag.name+']');
rowTag.parent("td").append("<div class='text-danger'>*"+tag.error+"</div>");
if(!rowTag.is("[readonly]")){
rowTag.putCursorAtEnd();		
}
});
error=[];	
}
}	
}
else if(present.hasClass("move-enter-prorow") && !present.hasClass("move-enter-row")){	
var currentPostion=present.attr("data-position");
if(present.hasClass("move-enter-prorow") && !present.hasClass("prorow-end")){	
var nextPosition=parseFloat(currentPostion)+1;
var next=$(".enter-pro-"+nextPosition+"");
rowPosition=nextPosition;
if(next.is("input")){
next.putCursorAtEnd();	
}
else{
next.putCursorAtEnd();	
next.select2("open");
next.select2('val', '');	
}
}
else if(present.hasClass("prorow-end")){
var data=[];
var error=[];	
$('.data-prorow input,.data-prorow select').each(function(i,tag){
var rowData={};	
var rowTag=$('[name='+tag.name+']');
if(rowTag.is("[data-required]") && rowTag.val()==''){
error.push({name:tag.name,error:"This Field is Required"});	
}
if(rowTag.is("[data-unique]") && $('#'+rowTag.val()+'').length > 0){
error.push({name:tag.name,error:"Must contain A unique value"});	
}
if(rowTag.is("[data-only-numbers]") && !$.isNumeric(removeCommas(rowTag.val()))){
error.push({name:tag.name,error:"Only Numbers are allowed"});	
}
if(rowTag.is("[greater-then-zero]") && rowTag.val()<=0){
error.push({name:tag.name,error:"Must be greater then 0"});	
}
if(rowTag.is("[if-greater-then-zero]") && !$.isNumeric(removeCommas(rowTag.val()))){
error.push({name:tag.name,error:"Only Numbers are allowed"});	
}
else if(rowTag.is("[if-greater-then-zero]") && rowTag.val()<=0){
var ifelse=rowTag.attr("if-greater-then-zero");	
if($('[name='+ifelse+']').val()<=0 || $('[name='+ifelse+']').val()==""|| !$.isNumeric(removeCommas($('[name='+ifelse+']').val()))){
error.push({name:tag.name,error:"Must be greater then 0"});	
}
}	
rowData['name']=tag.name;
rowData['type']="input";
if(rowTag.is("select")){
rowData['type']="select";	
}
else if(rowTag.hasClass("hidden-data")){
rowData['type']="hidden";		
}	
rowData['value']=rowTag.val();
if(rowTag.is("[hidden-data]")){
rowData['hidden-data']=rowTag.attr("hidden-data");	
}
if(rowTag.is("[data-sum]")){
rowData['data-sum']=rowTag.attr("data-sum");	
}
if(rowTag.is("[data-name-array]")){
rowData['data-name-array']=rowTag.attr("data-name-array");
rowData['data-name']=$('#select2-'+tag.name+'-container').html();
}
if(rowTag.is("[ajax-data]")){
rowData['select2-val']=rowTag.val();
rowData['select2-show']=$('#select2-'+tag.name+'-container').html();
}
if(rowTag.is("[data-unique]")){
rowData['data-unique']=rowTag.val();
}
if(rowTag.is("[data-only-numbers]")){
rowData['data-only-numbers']="true";
}
data.push(rowData);	
});
if(error.length==0){	
if(makeProRow(data)){
$('.data-prorow input,.data-prorow select').val("");	
$('.data-prorow select').select2("val","");
rowPosition=1;
clearProRow();	
dataSum();
}
}
else{
$(document).find('.data-prorow').find(".text-danger").remove();	
$.each(error,function(i,tag){	
rowTag=$('[name='+tag.name+']');
rowTag.parent("td").append("<div class='text-danger'>*"+tag.error+"</div>");
if(!rowTag.is("[readonly]")){
rowTag.putCursorAtEnd();		
}
});
error=[];	
}
}	
}
event.preventDefault();
}	
});

function makeRow(data){	
if($('.data-rows').children("table").length==0){
$('.data-rows').append('<table class="table table-bordered table-striped table-condensed flip-content">'+
'</table>');	
}	
var row;
row="<tr data-id='"+rowNumber+"'>";	
row=row+'<td class="theme-bg theme-border text-align-center">'+	
'<div class="btn-group">'+
'<a class="btn btn-sm  theme-bg" href="javascript:;"'+
'data-toggle="dropdown" data-hover="dropdown" style="padding: 0px 5px;"'+
'data-close-others="true">'+totalRows+'</a>'+
'<ul class="dropdown-menu pull-right">'+
'<li>'+
'<a href="javascript:;" edit-row><i class="icon-pencil text-warning"></i>'+ 'Edit </a>'+
'</li>'+
'<li>'+
'<a href="javascript:;" delete-row><i class="icon-trash text-danger"></i>'+ 'Delete </a>'+
'</li>'+
'</ul>'+
'</div>'+
'</td>';
$.each(data,function(i){
var td=makeTd(data[i],data);
if(td!==undefined){
row=row+td;
}
});
row=row+"</tr>";
$('.data-rows').children("table").find("tbody").append(row);
$('.data-rows').children("table").find("tbody tr:last-child").find(".popovers").popover();
rowNumber++;
totalRows++;
$('[name=nrows]').val(rowNumber);
$(document).find('.data-row').find(".text-danger").remove();
$(document).find('.data-row').scrollLeft( 0 );
return true;
}

function makeProRow(data){	
if($('.data-prorows').children("table").length==0){
$('.data-prorows').append('<table class="table table-bordered table-striped table-condensed flip-content">'+
'</table>');	
}	
var row;
row="<tr data-id='"+ProrowNumber+"'>";	
row=row+'<td class="theme-bg theme-border text-align-center">'+	
'<div class="btn-group">'+
'<a class="btn btn-sm  theme-bg" href="javascript:;"'+
'data-toggle="dropdown" data-hover="dropdown" style="padding: 0px 5px;"'+
'data-close-others="true">'+ProrowNumber+'</a>'+
'<ul class="dropdown-menu pull-right">'+
'<li>'+
'<a href="javascript:;" edit-pro-row><i class="icon-pencil text-warning"></i>'+ 'Edit </a>'+
'</li>'+
'<li>'+
'<a href="javascript:;" delete-pro-row><i class="icon-trash text-danger"></i>'+ 'Delete </a>'+
'</li>'+
'</ul>'+
'</div>'+
'</td>';
$.each(data,function(i){
var td=makeProTd(data[i],data);
if(td!==undefined){
row=row+td;
}
});
row=row+"</tr>";
$('.data-prorows').children("table").find("tbody").append(row);
$('.data-prorows').children("table").find("tbody tr:last-child").find(".popovers").popover();
ProrowNumber++;
totalRows++;
$('[name=nprorows]').val(ProrowNumber);
$(document).find('.data-prorows').find(".text-danger").remove();
$(document).find('.data-prorows').scrollLeft( 0 );
return true;
}

function makeTd(data,allData){	
if(data['type']!='hidden'){
value=data['value'];	
name=data['value'];	
if(data['data-name-array']!==undefined){
value=data['data-name'];
name=data['data-name'];
}
if(name==""){
name="-";
}
var td='<td';
if(data['data-only-numbers']!==undefined){
val=removeCommas(value);	
str=numberToWords(val);		
td+=" class='th-right popovers'";
td+=' data-container="body" data-trigger="hover" data-placement="bottom" data-content="'+str+'"';	
}	
td+=">";
td=td+'<span>'+stringToSubstring(name,35)+'</span><input type="hidden" name="'+data['name']+'_'+rowNumber+'" value="'+value+'"';
if(data['hidden-data']!==undefined){
td=td+'hidden-data="'+data['hidden-data']+'_'+rowNumber+'"';	
}
if(data['select2-val']!==undefined){
td=td+' ajax-data';	
}
td=td+' class="form-control';
if(data['data-sum']!==undefined){
td=td+' sum_'+data['name']+'';	
}
td=td+'"/>';
if(data['hidden-data']!==undefined){
var hidVal="";
$.each(allData,function(i){
if(allData[i]['name']==data['hidden-data']){
hidVal=allData[i]['value'];
}	
});	
td=td+'<input type="hidden" name="'+data['hidden-data']+'_'+rowNumber+'" value="'+hidVal+'" />';	
}
if(data['select2-val']!==undefined){
td=td+'<input type="hidden" name="select2val_'+data['name']+'_'+rowNumber+'" value="'+data['select2-val']+'" />';		
td=td+'<input type="hidden" name="select2show_'+data['name']+'_'+rowNumber+'" value="'+data['select2-show']+'" />';		
}
if(data['data-unique']!==undefined){
td=td+'<input type="hidden" id="'+data['data-unique']+'" value="'+data['data-unique']+'" />';			
}
td=td+'</td>'
}	
return td;
}

function makeProTd(data,allData){	
if(data['type']!='hidden'){
value=data['value'];	
name=data['value'];	
if(data['data-name-array']!==undefined){
value=data['data-name'];
name=data['data-name'];
}
if(name==""){
name="-";
}
var td='<td';
if(data['data-only-numbers']!==undefined){
val=removeCommas(value);	
str=numberToWords(val);		
td+=" class='th-right popovers'";
td+=' data-container="body" data-trigger="hover" data-placement="bottom" data-content="'+str+'"';	
}	
td+=">";
td=td+'<span>'+stringToSubstring(name,35)+'</span><input type="hidden" name="'+data['name']+'_'+ProrowNumber+'" value="'+value+'"';
if(data['hidden-data']!==undefined){
td=td+'hidden-data="'+data['hidden-data']+'_'+ProrowNumber+'"';	
}
if(data['select2-val']!==undefined){
td=td+' ajax-data';	
}
td=td+' class="form-control';
if(data['data-sum']!==undefined){
td=td+' sum_'+data['name']+'';	
}
td=td+'"/>';
if(data['hidden-data']!==undefined){
var hidVal="";
$.each(allData,function(i){
if(allData[i]['name']==data['hidden-data']){
hidVal=allData[i]['value'];
}	
});	
td=td+'<input type="hidden" name="'+data['hidden-data']+'_'+ProrowNumber+'" value="'+hidVal+'" />';	
}
if(data['select2-val']!==undefined){
td=td+'<input type="hidden" name="select2val_'+data['name']+'_'+ProrowNumber+'" value="'+data['select2-val']+'" />';		
td=td+'<input type="hidden" name="select2show_'+data['name']+'_'+ProrowNumber+'" value="'+data['select2-show']+'" />';		
}
if(data['data-unique']!==undefined){
td=td+'<input type="hidden" id="'+data['data-unique']+'" value="'+data['data-unique']+'" />';			
}
td=td+'</td>'
}	
return td;
}

///////// for select

$(document).on("change","select",function(e){	
var present=$(this);
if(present.hasClass("move-enter-up") && present.val()!=""){
var currentPostion=present.attr("data-position");
if(!present.hasClass("move-to-row")){	
var nextPosition=parseFloat(currentPostion)+1;
var next=$(".move-enter-"+nextPosition+"");
upperPosition=nextPosition;
if(next.is("input")){
next.putCursorAtEnd();
setTimeout(function(){
moveToCurrentUpper();	
},100);		
}
else{
next.putCursorAtEnd();	
next.select2("open");	
next.select2('val', '');
}
}
else{
var next=$(".row-start");
rowPosition=1;
if(next.is("input")){
next.putCursorAtEnd();	
}
else{
next.putCursorAtEnd();	
next.select2("open");
next.select2('val', '');	
}	
}	
}
else if(present.hasClass("move-enter-row") && present.val()!="" && !present.hasClass("move-enter-prorow")){
var currentPostion=present.attr("data-position");
if(present.hasClass("move-enter-row") && !present.hasClass("row-end") && !present.hasClass("move-enter-prorow")){	
var nextPosition=parseFloat(currentPostion)+1;
var next=$(".enter-"+nextPosition+"");
rowPosition=nextPosition;
if(next.is("input")){
next.putCursorAtEnd();
setTimeout(function(){
moveToCurrentRow();	
},100);	
}
else{	
next.putCursorAtEnd();	
next.select2("open");
next.select2('val', '');	
}
}
else if(present.hasClass("row-end") && !present.hasClass("move-enter-prorow")){
var data=[];
var error=[];	
$('.data-row input,.data-row select').each(function(i,tag){
var rowData={};	
var rowTag=$('[name='+tag.name+']');
if(rowTag.is("[data-required]") && rowTag.val()==''){
error.push({name:tag.name,error:"This Field is Required"});	
}
if(rowTag.is("[data-only-numbers]") && !$.isNumeric(rowTag.val())){
error.push({name:tag.name,error:"Only Numbers are allowed"});	
}
if(rowTag.is("[greater-then-zero]") && rowTag.val()<=0){
error.push({name:tag.name,error:"Must be greater then 0"});	
}
if(rowTag.is("[if-greater-then-zero]") && !$.isNumeric(rowTag.val())){
error.push({name:tag.name,error:"Only Numbers are allowed"});	
}
else if(rowTag.is("[if-greater-then-zero]") && rowTag.val()<=0){
var ifelse=rowTag.attr("if-greater-then-zero");	
if($('[name='+ifelse+']').val()<=0 || $('[name='+ifelse+']').val()==""|| !$.isNumeric($('[name='+ifelse+']').val())){
error.push({name:tag.name,error:"Must be greater then 0"});	
}
}	
rowData['name']=tag.name;
rowData['type']="input";
if(rowTag.is("select")){
rowData['type']="select";	
}
else if(rowTag.hasClass("hidden-data")){
rowData['type']="hidden";		
}	
rowData['value']=rowTag.val();
if(rowTag.is("[hidden-data]")){
rowData['hidden-data']=rowTag.attr("hidden-data");	
}
if(rowTag.is("[data-sum]")){
rowData['data-sum']=rowTag.attr("data-sum");	
}
if(rowTag.is("[data-name-array]")){
rowData['data-name-array']=rowTag.attr("data-name-array");
rowData['data-name']=$('#select2-'+tag.name+'-container').html();
}
if(rowTag.is("[ajax-data]")){
rowData['select2-val']=rowTag.val();
rowData['select2-show']=$('#select2-'+tag.name+'-container').html();
}
data.push(rowData);	
});
if(error.length==0){	
if(makeRow(data)){
$('.data-row input,.data-row select').val("");	
$('.data-row select').select2("val","");
rowPosition=1;
clearRow();	
dataSum();
}
}
else{
$.each(error,function(i,tag){	
rowTag=$('[name='+tag.name+']');
rowTag.parent("td").append("<div class='text-danger'>*"+tag.error+"</div>");
if(!rowTag.is("[readonly]")){
rowTag.putCursorAtEnd();		
}
});
error=[];	
}
}	
}

else if(present.hasClass("move-enter-prorow") && present.val()!="" && !present.hasClass("move-enter-row")){	
var currentPostion=present.attr("data-position");
if(present.hasClass("move-enter-prorow") && !present.hasClass("prorow-end") && !present.hasClass("move-enter-row")){	
var nextPosition=parseFloat(currentPostion)+1;
var next=$(".enter-pro-"+nextPosition+"");
rowPosition=nextPosition;
if(next.is("input")){
next.putCursorAtEnd();
setTimeout(function(){
moveToCurrentProRow();	
},100);	
}
else{	
next.putCursorAtEnd();	
next.select2("open");
next.select2('val', '');	
}
}
else if(present.hasClass("prorow-end") && !present.hasClass("move-enter-row")){
var data=[];
var error=[];	
$('.data-prorow input,.data-prorow select').each(function(i,tag){
var rowData={};	
var rowTag=$('[name='+tag.name+']');
if(rowTag.is("[data-required]") && rowTag.val()==''){
error.push({name:tag.name,error:"This Field is Required"});	
}
if(rowTag.is("[data-only-numbers]") && !$.isNumeric(rowTag.val())){
error.push({name:tag.name,error:"Only Numbers are allowed"});	
}
if(rowTag.is("[greater-then-zero]") && rowTag.val()<=0){
error.push({name:tag.name,error:"Must be greater then 0"});	
}
if(rowTag.is("[if-greater-then-zero]") && !$.isNumeric(rowTag.val())){
error.push({name:tag.name,error:"Only Numbers are allowed"});	
}
else if(rowTag.is("[if-greater-then-zero]") && rowTag.val()<=0){
var ifelse=rowTag.attr("if-greater-then-zero");	
if($('[name='+ifelse+']').val()<=0 || $('[name='+ifelse+']').val()==""|| !$.isNumeric($('[name='+ifelse+']').val())){
error.push({name:tag.name,error:"Must be greater then 0"});	
}
}	
rowData['name']=tag.name;
rowData['type']="input";
if(rowTag.is("select")){
rowData['type']="select";	
}
else if(rowTag.hasClass("hidden-data")){
rowData['type']="hidden";		
}	
rowData['value']=rowTag.val();
if(rowTag.is("[hidden-data]")){
rowData['hidden-data']=rowTag.attr("hidden-data");	
}
if(rowTag.is("[data-sum]")){
rowData['data-sum']=rowTag.attr("data-sum");	
}
if(rowTag.is("[data-name-array]")){
rowData['data-name-array']=rowTag.attr("data-name-array");
rowData['data-name']=$('#select2-'+tag.name+'-container').html();
}
if(rowTag.is("[ajax-data]")){
rowData['select2-val']=rowTag.val();
rowData['select2-show']=$('#select2-'+tag.name+'-container').html();
}
data.push(rowData);	
});
if(error.length==0){	
if(makeRow(data)){
$('.data-prorow input,.data-prorow select').val("");	
$('.data-prorow select').select2("val","");
rowPosition=1;
clearProRow();	
dataSum();
}
}
else{
$.each(error,function(i,tag){	
rowTag=$('[name='+tag.name+']');
rowTag.parent("td").append("<div class='text-danger'>*"+tag.error+"</div>");
if(!rowTag.is("[readonly]")){
rowTag.putCursorAtEnd();		
}
});
error=[];	
}
}	
}
event.preventDefault();	
});

function moveToCurrentUpper(){
var nextPosition=upperPosition;	
var next=$(".move-enter-"+nextPosition+"");
upperPosition=nextPosition;
if(next.is("input")){
next.putCursorAtEnd();	
}
else{
next.putCursorAtEnd();	
next.select2("open");
next.select2('val', '');	
}	
}

function moveToNextUpper(){
var nextPosition=parseFloat(upperPosition)+1;	
var next=$(".move-enter-"+nextPosition+"");
upperPosition=nextPosition;
if(next.is("input")){
next.putCursorAtEnd();	
}
else{
next.putCursorAtEnd();	
next.select2("open");
next.select2('val', '');	
}	
}

function moveToCurrentRow(){
var nextPosition=parseFloat(rowPosition);
var next=$(".enter-"+nextPosition+"");
rowPosition=nextPosition;
if(next.is("input")){
next.putCursorAtEnd();	
}
else{
next.putCursorAtEnd();	
next.select2("close");
next.select2("open");
}	
} 

function moveToNextRow(){
var nextPosition=parseFloat(rowPosition)+1;
var next=$(".enter-"+nextPosition+"");
rowPosition=nextPosition;
if(next.is("input")){
next.putCursorAtEnd();	
}
else{	
next.putCursorAtEnd();	
next.select2("open");
next.select2('val', '');	
}	
}

function moveToCurrentProRow(){
var nextPosition=parseFloat(rowPosition);
var next=$(".enter-pro-"+nextPosition+"");
rowPosition=nextPosition;
if(next.is("input")){
next.putCursorAtEnd();	
}
else{
next.putCursorAtEnd();	
next.select2("close");
next.select2("open");
}	
} 

function moveToNextProRow(){
var nextPosition=parseFloat(rowPosition)+1;
var next=$(".enter-pro-"+nextPosition+"");
rowPosition=nextPosition;
if(next.is("input")){
next.putCursorAtEnd();	
}
else{	
next.putCursorAtEnd();	
next.select2("open");
next.select2('val', '');	
}	
}

function clearRow(){
var nextPosition=parseFloat(rowPosition);
var next=$(".enter-"+nextPosition+"");
rowPosition=nextPosition;
if(next.is("input")){
next.putCursorAtEnd();	
}
else{
next.putCursorAtEnd();
next.select2('val', '');
next.trigger("change");	
next.select2("open");	
}	
}

function clearProRow(){
var nextPosition=parseFloat(rowPosition);
var next=$(".enter-pro-"+nextPosition+"");
rowPosition=nextPosition;
if(next.is("input")){
next.putCursorAtEnd();	
}
else{
next.putCursorAtEnd();
next.select2('val', '');
next.trigger("change");	
next.select2("open");	
}	
}

function stringToSubstring(string,length){
if(string.length>length){
string=string.substring(0,length);
string=string+'...';	
}
return string;	
}

$(document).find("[data-sum]").each(function(){
var obj=$(this).attr("data-sum");	
$('[name='+obj+']').attr("type","hidden");
if($('[name='+obj+']').parent("td").find("span").length==0){
$('[name='+obj+']').parent("td").append("<span></span>");
}
});

function dataSum(){
$(document).find("[data-sum]").each(function(){
var name=$(this).attr("name");	
var tname=$(this).attr("data-sum");	
var obj=$('[name='+tname+']');
var sum=0;
$('.sum_'+name+'').each(function(){
var val=$(this).val();
val=removeCommas(val);
if(!isNaN(val)){	
sum=sum+Math.round10(val,-3);	
}
});
sum=Math.round10(sum,-3);
sum=lakhSeparator(sum);
obj.val(sum);
obj.parent("td").children("span").html(sum);
});	
$(document).find("[data-dmas]").trigger("keyup");
}

$(document).on("keypress","[int-numbers-only]",function(e){	
if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {	
return false;
}	
});

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

$(document).on("submit",".main-form",function(){
var obj=$(this);
obj.customPreloader("show");
if(!obj.hasClass("action-url"))
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
var url=clearUrl(window.location.href)+'/'+urlPrefix;
$.ajax({
url:url,
type:"POST",
data:data,
contentType:false,
processData:false,
dataType:"JSON"	
}).done(function(response){
obj.customPreloader("hide");	
obj.find('.text-danger').remove();	
if(response.success=="true")
{
obj.find("[type=reset]").trigger("click");
obj.find(".image-remove").trigger("click");
if(obj.hasClass("edit-form"))
{
$('.modal-edit').modal("hide");	
bootbox.dialog({title:notifications['success'],message:"Successfully Updated",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green",callback:function(){ location.href=baseUrl; }}}});
}
else{
bootbox.dialog({title:notifications['success'],message:"Successfully Added",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green",callback:function(){ location.href=baseUrl; }}}});	
}
if(obj.hasClass("list-refresh"))
{
$('.loadlist').trigger("click");		
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

$(document).on("keypress",function(e) {
if (e.which == 13) {
e.preventDefault();
return false;
}
});

function reinitializeTable(rowno){
if($('form').find("[name=nrows]").length==0){
$('form').append("<input type='hidden' name='nrows' value='1' />");	
}	
$('.move-enter-start').putCursorAtEnd();
$("[data-only-numbers]").each(function(){
var cleave = new Cleave($(this), {
numeral: true,
numeralThousandsGroupStyle: 'lakh',
numeralDecimalScale:4

});	
$(this).css("text-align","right");
$(this).popover({content: "",placement: "bottom",trigger:"focus",container: 'body'});
});
rowNumber=rowno;
totalRows=rowno;
upperPosition=1;
rowPosition=1;
error=[];
$('[name=nrows]').val(rowno);
$(document).find("[data-sum]").each(function(){
var obj=$(this).attr("data-sum");	
$('[name='+obj+']').attr("type","hidden");
if($('[name='+obj+']').parent("td").find("span").length==0){
$('[name='+obj+']').parent("td").append("<span></span>");
}
});
dataSum();
$(".popovers").popover();
$("[data-only-numbers]").popover("hide");
}	

function reinitializeProTable(rowno){
if($('form').find("[name=nprorows]").length==0){
$('form').append("<input type='hidden' name='nprorows' value='1' />");	
}	
$('.move-enter-start').putCursorAtEnd();
$("[data-only-numbers]").each(function(){
var cleave = new Cleave($(this), {
numeral: true,
numeralThousandsGroupStyle: 'lakh',
numeralDecimalScale:4

});	
$(this).css("text-align","right");
$(this).popover({content: "",placement: "bottom",trigger:"focus",container: 'body'});
});
rowProNumber=rowno;
totalRows=rowno;
upperPosition=1;
rowPosition=1;
error=[];
$('[name=nprorows]').val(rowno);
$(document).find("[data-sum]").each(function(){
var obj=$(this).attr("data-sum");	
$('[name='+obj+']').attr("type","hidden");
if($('[name='+obj+']').parent("td").find("span").length==0){
$('[name='+obj+']').parent("td").append("<span></span>");
}
});
dataSum();
$(".popovers").popover();
$("[data-only-numbers]").popover("hide");
}	

function clearUrl(url){
if(url.indexOf('?')>0){
var a=url.split("?");	
url=a[0];
}
if(url.indexOf('#')>0){
var a=url.split("#");	
url=a[0];	
}
return url;	
}

$(document).on("click","[data-control-reload]",function(){
var no=$("[name=no]").val();
if(no>0){
loadVoucher(no);	
}	
});

$(document).on("click","[data-control-left]",function(){
var no=$("[name=no]").val();
if(no>1){
no=parseFloat(no)-1;	
loadVoucher(no);	
}	
});

$(document).on("click","[data-control-right]",function(){
var no=$("[name=no]").val();
if(no>0){
no=parseFloat(no)+1;	
loadVoucher(no);	
}	
});

$(document).on("click","[data-control-delete]",function(){
var url=clearUrl(window.location.href)+'/'+"delete";		
bootbox.dialog({
message: "Are you sure you want to delete this Voucher?",
title:notifications['del'],
buttons: {
danger:{
label: "Delete <i class='icon-trash'></i>",
className: "red",
callback: function(){
$.post(url,function(response){
if(response.success=="true"){
bootbox.dialog({title:notifications['success'],message:"Successfully Deleted",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green",callback:function(){ location.href=baseUrl; }}}});
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

function loadVoucher(no){
var url=baseUrl+"/"+no;	
var obj=$(".all-data");
obj.customPreloader("show");
$.get(url,function(response){
obj.html(response);
ChangeUrl("No."+no+"", url);
$('.for-scroll').optiscroll();
obj.find(".select2").select2();
obj.find("[input-mask-date]").inputmask("mask",{mask:"99/99/9999"});
});
}

function ChangeUrl(title, url) {
if (typeof (history.pushState) != "undefined") {
var obj = { Title: title, Url: url };
history.pushState(obj, obj.Title, obj.Url);
} else {
alert("Browser does not support HTML5.");
}
}

$(document).on("click","[edit-row]",function(){
var obj=$(this).parents("tr");
var id=obj.attr("data-id");
editRow=id;
var modal=$(".modal-edit-row");
modal.find(".modal-dialog").css("width","90%");
modal.modal("show");
$.each(obj.find("input"),function(i,tag){
if(tag.name!=''){	
var nm=tag.name.split("_");
name=nm[0];
var target=$(document).find("[name="+name+"_e]");
if($("[name="+tag.name+"]").is("[ajax-data]")){
var select2val=$("[name=select2val_"+tag.name+"]").val();	
var select2show=$("[name=select2show_"+tag.name+"]").val();
if(select2val!="" && select2show!=""){
target.html("");	
target.select2({
data:[
{id:"",text:"Select"},
{id:select2val,text:select2show}
],
width: "100%"
});
}
else{
target.html("");	
target.select2({
data:[
{id:"",text:"Select"}
],
width: "100%"
});	
}
}
if($("[name="+tag.name+"]").is("[hidden-data]")){
var hddata=$("[name="+tag.name+"]").attr("hidden-data");
var val=$("[name="+hddata+"]").val();
target.val(val);
}
else{
target.val(tag.value);	
}
if(target.is("select")){
target.trigger("change");	
}
}
});
modal.find("[data-only-numbers]").trigger("keyup");
modal.find("[data-only-numbers]").popover("hide");
});

$(document).on("click","[edit-pro-row]",function(){
var obj=$(this).parents("tr");
var id=obj.attr("data-id");
editRow=id;
var modal=$(".modal-edit-pro-row");
modal.find(".modal-dialog").css("width","90%");
modal.modal("show");
$.each(obj.find("input"),function(i,tag){
if(tag.name!=''){	
var nm=tag.name.split("_");
name=nm[0];
var target=$(document).find("[name="+name+"_ee]");
if($("[name="+tag.name+"]").is("[ajax-data]")){
var select2val=$("[name=select2val_"+tag.name+"]").val();	
var select2show=$("[name=select2show_"+tag.name+"]").val();
if(select2val!="" && select2show!=""){
target.html("");	
target.select2({
data:[
{id:"",text:"Select"},
{id:select2val,text:select2show}
],
width: "100%"
});
}
else{
target.html("");	
target.select2({
data:[
{id:"",text:"Select"}
],
width: "100%"
});	
}
}
if($("[name="+tag.name+"]").is("[hidden-data]")){
var hddata=$("[name="+tag.name+"]").attr("hidden-data");
var val=$("[name="+hddata+"]").val();
target.val(val);
}
else{
target.val(tag.value);	
}
if(target.is("select")){
target.trigger("change");	
}
}
});
modal.find("[data-only-numbers]").trigger("keyup");
modal.find("[data-only-numbers]").popover("hide");
});

$(document).on("click","[delete-row]",function(){
var obj=$(this).parents("tr");
var id=obj.attr("data-id");
bootbox.dialog({
message: "Are you sure you want to delete this Row ?",
title:notifications['del'],
buttons: {
danger:{
label: "Delete <i class='icon-trash'></i>",
className: "red",
callback: function() {
obj.remove();
reinitializeTable(rowNumber);
}
},
main:{
label: "Cancel",
className: "default",
}
}
});

});

$(document).on("click","[delete-pro-row]",function(){
var obj=$(this).parents("tr");
var id=obj.attr("data-id");
bootbox.dialog({
message: "Are you sure you want to delete this Row ?",
title:notifications['del'],
buttons: {
danger:{
label: "Delete <i class='icon-trash'></i>",
className: "red",
callback: function() {
obj.remove();
reinitializeTable(ProrowNumber);
}
},
main:{
label: "Cancel",
className: "default",
}
}
});

});

$(document).on("click",".update-row",function(){	
var modal=$(".modal-edit-row");
var obj=$(this).parents(".modal-body");	
obj.find(".text-danger").remove();
var data=[];
var error=[];	
obj.find('input,select').each(function(i,tag){
var rowData={};	
var rowTag=$('[name='+tag.name+']');

if(rowTag.is("[data-required]") && rowTag.val()==''){
error.push({name:tag.name,error:"This Field is Required"});	
}
if(rowTag.is("[data-unique]") && $('#'+rowTag.val()+'').length > 0){
error.push({name:tag.name,error:"Must contain A unique value"});	
}
if(rowTag.is("[data-only-numbers]") && !$.isNumeric(removeCommas(rowTag.val()))){
error.push({name:tag.name,error:"Only Numbers are allowed"});	
}
if(rowTag.is("[greater-then-zero]") && rowTag.val()<=0){
error.push({name:tag.name,error:"Must be greater then 0"});	
}
if(rowTag.is("[if-greater-then-zero]") && !$.isNumeric(removeCommas(rowTag.val()))){
error.push({name:tag.name,error:"Only Numbers are allowed"});	
}
else if(rowTag.is("[if-greater-then-zero]") && rowTag.val()<=0){
var ifelse=rowTag.attr("if-greater-then-zero");	
if($('[name='+ifelse+']').val()<=0 || $('[name='+ifelse+']').val()==""|| !$.isNumeric(removeCommas($('[name='+ifelse+']').val()))){
error.push({name:tag.name,error:"Must be greater then 0"});	
}
}	
rowData['name']=tag.name;
rowData['type']="input";
if(rowTag.is("select")){
rowData['type']="select";	
}
else if(rowTag.hasClass("hidden-data")){
rowData['type']="hidden";		
}	
rowData['value']=rowTag.val();
if(rowTag.is("[hidden-data]")){
rowData['hidden-data']=rowTag.attr("hidden-data");	
}
if(rowTag.is("[data-sum]")){
rowData['data-sum']=rowTag.attr("data-sum");	
}
if(rowTag.is("[data-name-array]")){
rowData['data-name-array']=rowTag.attr("data-name-array");
rowData['data-name']=$('#select2-'+tag.name+'-container').html();
}
if(rowTag.is("[ajax-data]")){
rowData['select2-val']=rowTag.val();
rowData['select2-show']=$('#select2-'+tag.name+'-container').html();
}
if(rowTag.is("[data-unique]")){
rowData['data-unique']=rowTag.val();
}
if(rowTag.is("[data-only-numbers]")){
rowData['data-only-numbers']="true";
}

data.push(rowData);	
});
if(error.length==0){	
var allData=data;
$.each(data,function(i,tag){
var updateData=data[i];
if(updateData['type']!='hidden'){
value=updateData['value'];	
name=updateData['value'];	
if(updateData['data-name']!==undefined){
value=updateData['data-name'];
name=updateData['data-name'];
}
if(name==""){
name="-";
}	
var pst=updateData['name'].split("_");
var postName=pst[0]+"_"+editRow;
var postTag=$("[name="+postName+"]");
postTag.val(value);
postTag.parent("td").find("span").html(stringToSubstring(name,35));

if(updateData['hidden-data']!==undefined){
var abc=updateData['hidden-data'].split("_");	
var def=abc[0];
postTag.attr("hidden-data",def+'_'+editRow);	

var hidVal="";
$.each(allData,function(i){
if(allData[i]['name']==updateData['hidden-data']){
hidVal=allData[i]['value'];
}	
});
postTag.parent("td").find("[name="+def+'_'+editRow+"]").val(hidVal);	
}
if(updateData['data-only-numbers']!==undefined){	
str=removeCommas(value);
str=numberToWords(str);		
postTag.parent("td").attr('data-content',str);
}
if(updateData['ajax-data']!==undefined){
$("[name=select2val_"+postName+"]").val(updateData['select2-val']);	
$("[name=select2show_"+postName+"]").val(updateData['select2-show']);	
}
}
});
dataSum();
modal.modal("hide");
modal.find("[data-only-numbers]").popover("hide");
}
else{
$.each(error,function(i,tag){	
rowTag=$('[name='+tag.name+']');
rowTag.parent("td").append("<div class='text-danger'>*"+tag.error+"</div>");
rowTag.putCursorAtEnd();	
});
error=[];	
}
});

$(document).on("click",".update-pro-row",function(){	
var modal=$(".modal-edit-pro-row");
var obj=$(this).parents(".modal-body");	
obj.find(".text-danger").remove();
var data=[];
var error=[];	
obj.find('input,select').each(function(i,tag){
var rowData={};	
var rowTag=$('[name='+tag.name+']');

if(rowTag.is("[data-required]") && rowTag.val()==''){
error.push({name:tag.name,error:"This Field is Required"});	
}
if(rowTag.is("[data-unique]") && $('#'+rowTag.val()+'').length > 0){
error.push({name:tag.name,error:"Must contain A unique value"});	
}
if(rowTag.is("[data-only-numbers]") && !$.isNumeric(removeCommas(rowTag.val()))){
error.push({name:tag.name,error:"Only Numbers are allowed"});	
}
if(rowTag.is("[greater-then-zero]") && rowTag.val()<=0){
error.push({name:tag.name,error:"Must be greater then 0"});	
}
if(rowTag.is("[if-greater-then-zero]") && !$.isNumeric(removeCommas(rowTag.val()))){
error.push({name:tag.name,error:"Only Numbers are allowed"});	
}
else if(rowTag.is("[if-greater-then-zero]") && rowTag.val()<=0){
var ifelse=rowTag.attr("if-greater-then-zero");	
if($('[name='+ifelse+']').val()<=0 || $('[name='+ifelse+']').val()==""|| !$.isNumeric(removeCommas($('[name='+ifelse+']').val()))){
error.push({name:tag.name,error:"Must be greater then 0"});	
}
}	
rowData['name']=tag.name;
rowData['type']="input";
if(rowTag.is("select")){
rowData['type']="select";	
}
else if(rowTag.hasClass("hidden-data")){
rowData['type']="hidden";		
}	
rowData['value']=rowTag.val();
if(rowTag.is("[hidden-data]")){
rowData['hidden-data']=rowTag.attr("hidden-data");	
}
if(rowTag.is("[data-sum]")){
rowData['data-sum']=rowTag.attr("data-sum");	
}
if(rowTag.is("[data-name-array]")){
rowData['data-name-array']=rowTag.attr("data-name-array");
rowData['data-name']=$('#select2-'+tag.name+'-container').html();
}
if(rowTag.is("[ajax-data]")){
rowData['select2-val']=rowTag.val();
rowData['select2-show']=$('#select2-'+tag.name+'-container').html();
}
if(rowTag.is("[data-unique]")){
rowData['data-unique']=rowTag.val();
}
if(rowTag.is("[data-only-numbers]")){
rowData['data-only-numbers']="true";
}

data.push(rowData);	
});
if(error.length==0){	
var allData=data;
$.each(data,function(i,tag){
var updateData=data[i];
if(updateData['type']!='hidden'){
value=updateData['value'];	
name=updateData['value'];	
if(updateData['data-name']!==undefined){
value=updateData['data-name'];
name=updateData['data-name'];
}
if(name==""){
name="-";
}	
alert(editRow);
var pst=updateData['name'].split("_");
alert(pst[0]);
var postName=pst[0]+"_"+editRow;
alert(postName);
var postTag=$("[name="+postName+"]");
postTag.val(value);
postTag.parent("td").find("span").html(stringToSubstring(name,35));

if(updateData['hidden-data']!==undefined){
var abc=updateData['hidden-data'].split("_");	
var def=abc[0];
postTag.attr("hidden-data",def+'_'+editRow);	

var hidVal="";
$.each(allData,function(i){
if(allData[i]['name']==updateData['hidden-data']){
hidVal=allData[i]['value'];
}	
});
postTag.parent("td").find("[name="+def+'_'+editRow+"]").val(hidVal);	
}
if(updateData['data-only-numbers']!==undefined){	
str=removeCommas(value);
str=numberToWords(str);		
postTag.parent("td").attr('data-content',str);
}
if(updateData['ajax-data']!==undefined){
$("[name=select2val_"+postName+"]").val(updateData['select2-val']);	
$("[name=select2show_"+postName+"]").val(updateData['select2-show']);	
}
}
});
dataSum();
modal.modal("hide");
modal.find("[data-only-numbers]").popover("hide");
}
else{
$.each(error,function(i,tag){	
rowTag=$('[name='+tag.name+']');
rowTag.parent("td").append("<div class='text-danger'>*"+tag.error+"</div>");
rowTag.putCursorAtEnd();	
});
error=[];	
}
});

$(document).on("keyup","[if-greater-then-zero]",function(){
var obj=$(this).attr("if-greater-then-zero");	
if($(this).val()>0){
$('[name='+obj+']').val(0);
}
});

$(document).on("keyup","[data-multiply]",function(){
var obj=$(this).attr("data-multiply");	
var target=$(this).attr("result-multiply");	
var value=$(this).val();
var sum=0;
if($(this).val()>0 && $.isNumeric(value)){
var val2=$('[name='+obj+']').val();
sum=val2*value;
}
var dt=target.split(",");
$.each(dt,function(i,tag){
$("[name="+tag+"]").val(sum);	
});
});

$(document).on("keyup","[data-dmas]",function(){
var data=$(this).attr("data-dmas");
var result=0;
$.each(data.split(","),function(i,tag){	
var ob=tag.split("-");
var obj=ob[0];
var action=ob[1];
var objValue=$('[name='+obj+']').val();
if(objValue!==undefined){
objValue=removeCommas(objValue);
}
if($.isNumeric(objValue) || action=="result" || action=="clear"){
if(action=="divide"){	
result=parseFloat(result)/parseFloat(objValue);	
}
else if(action=="multiply"){	
result=parseFloat(result)*parseFloat(objValue);	
}
else if(action=="add"){	
result=parseFloat(result)+parseFloat(objValue);	
}
else if(action=="minus"){	
result=parseFloat(result)-parseFloat(objValue);	
}


else if(action=="percent")
{	
var rt=Math.round10((parseFloat(result)*parseFloat(objValue))/100,-2);
$('[name='+ob[2]+']').val(rt);
result=parseFloat(result)+parseFloat(rt);
}


else if(action=="percentage"){
if(objValue>0){	
var rt=Math.round10((parseFloat(objValue)/parseFloat(result))*100,-2);
$('[name='+ob[2]+']').val(rt);
result=parseFloat(result)+parseFloat(objValue);	
}
else{
$('[name='+ob[2]+']').val('');	
}
}

else if(action=="dpercent")
{	
var rt=Math.round10((parseFloat(result)*parseFloat(objValue))/100,-2);
$('[name='+ob[2]+']').val(rt);
result=parseFloat(result)-parseFloat(rt);
}


else if(action=="dpercentage"){
if(objValue>0){	
var rt=Math.round10((parseFloat(objValue)/parseFloat(result))*100,-2);
$('[name='+ob[2]+']').val(rt);
result=parseFloat(result)-parseFloat(objValue);	
}
else{
$('[name='+ob[2]+']').val('');	
}
}


else if(action=="result"){
if(ob[2]!==undefined && ob[2]=="round"){
var abc="-"+ob[3];	
$('[name='+obj+']').val(lakhSeparator(Math.round10(result,abc)));	
}
else{	
$('[name='+obj+']').val(lakhSeparator(Math.round10(result,0)));
}
}
else if(action=="clear"){	
result=0;
}
}
});
$(document).find("[data-only-numbers]").popover("hide");
});

$(document).find("[data-only-numbers]").popover({content: "",placement: "bottom",trigger:"focus",container: 'body'});

$(document).on("keyup","[data-only-numbers]",function(){
var val=$(this).val();
val=removeCommas(val);	
var str="";
if(!isNaN(val) && val!=""){
str=numberToWords(val);	
$(this).siblings(".popover").find(".popover-content").html(str);
$(this).data('bs.popover').options.content=str;
$(this).popover('show');
}
else{
$(this).siblings(".popover").find(".popover-content").html("");
$(this).data('bs.popover').options.content="";
$(this).popover('hide');	
}
});

function pend_invoices(Peding_type,page,baseUrl){
var vcode = $("input[name=vcode]").val();
var modal=$('.modal-voucher-details');
modal.find(".modal-dialog").css("width","80%");
modal.find(".modal-title").html(Peding_type);
modal.modal();
modal.find(".modal-body").customPreloader("show");		
$.post(baseUrl+page,{vcode:vcode},function(response){
if(response.success=="true"){
modal.find(".modal-body").html(response.data);	
}	
else{
modal.find(".modal-body").html("<h1>"+response.error+"</h1>");	
}
},'json');
}

function send_no(Challan,field,vcode,vname,odate){
var modal=$('.modal-voucher-details');
modal.modal("hide");
$(field).val(Challan);
$('[name=vcode]').val(vcode);
$('[name=odate]').val(odate);
$('[name=vname]').val(vcode);
document.getElementsByClassName("select2-selection")[0].innerHTML=vname;
}



function pend_grn(Peding_type,page,baseUrl){
var vcode = $("input[name=vcode]").val();
var modal=$('.modal-voucher-details');
modal.find(".modal-dialog").css("width","80%");
modal.find(".modal-title").html(Peding_type);
modal.modal();
modal.find(".modal-body").customPreloader("show");		
$.post(baseUrl+page,{vcode:vcode},function(response){
if(response.success=="true"){
modal.find(".modal-body").html(response.data);	
}	
else{
modal.find(".modal-body").html("<h1>"+response.error+"</h1>");	
}
},'json');
}

function send_gno(Challan,field,vcode,vname,odate,dc){
var modal=$('.modal-voucher-details');
modal.modal("hide");
$(field).val(Challan);
$('[name=vcode]').val(vcode);
$('[name=odate]').val(odate);
$('[name=vname]').val(vcode);
$('[name=dcno]').val(dc);
document.getElementsByClassName("select2-selection")[0].innerHTML=vname;
}




$(document).on("click","#load-pdata",function(){
var no = $(".pdata").val();
if(no!=""){
var target=$('[load-lcinfo]');	
target.customPreloader("show");
$.post(baseUrl+"/loadpdata",{no:no},function(response){
target.html(response);	
});
}
});


