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