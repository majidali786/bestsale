(function($){
$.fn.customPreloader=function(action){
var elmnt=$(this);
if(action=="show"){
var preloader=
		'<div class="overlay"></div>'+
		'<div class="spinner">'+
		'<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="'+'http://www.w3.org/1999/xlink" version="1" width="48px" height="48px"'+ 'viewBox="0 0 28 28">'+
		'<g class="qp-circular-loader">'+
		'<path class="qp-circular-loader-path" fill="none" d="M 14,1.5 A 12.5,12.5'+ '0 1 1 1.5,14" stroke-linecap="round" />'+
		'</g>'+
		'</svg>'+
		'</div>'	
elmnt.prepend(preloader);	
}
if(action=="hide"){	
elmnt.children(".spinner").remove();	
elmnt.children(".overlay").remove();	
}
};
}(jQuery));