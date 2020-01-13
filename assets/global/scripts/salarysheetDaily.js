function removeCommas(value){
	return value.toString().replace(/,/g,'');
}
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
$(document).on("keyup","[salary-sheet]",function(){
var pt=$(this).parents("[rowno]");
if(pt.is("[rowno]")){	
var rowno=pt.attr("rowno");	
var whours=removeCommas($("[name=whours_"+rowno+"]").val());
var basic=removeCommas($("[name=basic_"+rowno+"]").val());
var tdays=removeCommas($("[name=tdays]").val());
var wdays=removeCommas($("[name=wdays_"+rowno+"]").val());
var hours=removeCommas($("[name=hours_"+rowno+"]").val());
var oamount=0;
if(!isNaN(hours) && hours!=''){
oamount=Math.round10((basic/whours)*hours,0);
}
$("[name=oamount_"+rowno+"]").val(lakhSeparator(oamount));
$(".oamount_"+rowno+"").html(lakhSeparator(oamount));
var tltl=removeCommas($("[name=tltl_"+rowno+"]").val());
var tstl=removeCommas($("[name=tstl_"+rowno+"]").val());
var tadvance=removeCommas($("[name=tadvance_"+rowno+"]").val());
var ltl=removeCommas($("[name=ltermded_"+rowno+"]").val());
var stl=removeCommas($("[name=stermded_"+rowno+"]").val());
var advance=removeCommas($("[name=advanceded_"+rowno+"]").val());
if(isNaN(ltl) || ltl==''){
$("[name=ltermded_"+rowno+"]").val('');	
ltl=0;
}
else if(parseFloat(ltl)>parseFloat(tltl)){
$("[name=ltermded_"+rowno+"]").val(lakhSeparator(tltl));	
ltl=tltl;
}
if(isNaN(stl) || stl==''){
$("[name=stermded_"+rowno+"]").val('');
stl=0;	
}
else if(parseFloat(stl)>parseFloat(tstl)){
$("[name=stermded_"+rowno+"]").val(lakhSeparator(tstl));	
stl=tstl;
}
if(isNaN(advance) || advance==''){
$("[name=advanceded_"+rowno+"]").val('');
advance=0;	
}
else if(parseFloat(advance)>parseFloat(tadvance)){
$("[name=advanceded_"+rowno+"]").val(lakhSeparator(tadvance));	
advance=tadvance;
}

if(isNaN(wdays) || wdays==""){
$("[name=wdays_"+rowno+"]").val("");		
wdays=0;
}
else if(parseFloat(wdays)>parseFloat(tdays)){
$("[name=wdays_"+rowno+"]").val(lakhSeparator(tdays));
wdays=tdays;		
}

var gpay=Math.round10((basic)*wdays);
$("[name=gpay_"+rowno+"]").val(lakhSeparator(gpay));
$(".gpay_"+rowno+"").html(lakhSeparator(gpay));
var npay=parseFloat(gpay)+parseFloat(oamount)-parseFloat(ltl)-parseFloat(stl)-parseFloat(advance);
$("[name=npay_"+rowno+"]").val(lakhSeparator(npay));
$(".npay_"+rowno+"").html(lakhSeparator(npay));
$("[name=tpay_"+rowno+"]").val(lakhSeparator(npay));
npay=Math.round(npay / 10) * 10;
$(".tpay_"+rowno+"").html(lakhSeparator(npay));
dataSum();
}
});

$(document).on("click","[salary-sheet-done]",function(){
var pt=$(this).parents("[rowno]");
if(pt.is("[rowno]")){	
var rowno=pt.attr("rowno");	
$("[rowno="+rowno+"]").each(function(){
$(this).addClass("calculated-row");	
})
}
});
$(document).on("click","[salary-sheet-clear]",function(){
var pt=$(this).parents("[rowno]");
if(pt.is("[rowno]")){	
var rowno=pt.attr("rowno");	
$("[rowno="+rowno+"]").each(function(){
$(this).removeClass("calculated-row");	
$(this).find("input:visible").each(function(){
$(this).val(0);
});
});
pt.find('[salary-sheet-calculate]').trigger("keyup");	
}
});

function dataSum(){
$(document).find("[data-sum]").each(function(){
var name=$(this).attr("name");	
var sum=0;
$('.'+name+'').each(function(){
var val=$(this).val();
val=removeCommas(val);
if(!isNaN(val)){	
sum=sum+Math.round10(val,-3);	
}
});
sum=Math.round10(sum,-3);
sum=lakhSeparator(sum);
$(this).val(sum);
$(this).parent("td").children("span").html(sum);
});	
}