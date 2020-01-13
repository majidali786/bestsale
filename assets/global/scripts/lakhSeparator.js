(function ( $ ) {
 
$.fn.lakhSeparator=function(value){
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
 
}( jQuery ));