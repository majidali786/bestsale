<form class="form-horizontal list-refresh edit-form" role="form">
<input type="hidden" name="id" value="<?= $data[0]['ID']?>" />
<div class="form-body">

<div class="form-group">
<label class="col-md-3 control-label"> Design </label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="name" value="<?= $data[0]['NAME']?>"  placeholder="Design">
</div>
</div>
<div class="form-group">
			<label class="control-label col-sm-3">Image</label>
				<div class="col-sm-6  show-error">
				<div class="image-preview <?php if($data[0]['IMG']!=""){ echo "imgExist";}?>" data-url="<?= base_url("product/category/".$data[0]['IMG']);?>">
				<input type="file" name="img" id="img" accept="image/*" value="<?= base_url("product/category/".$data[0]['IMG']);?>" class="image-input" />
				</div>
				</div>
</div>
</div>
<div class="form-actions">
<button type="submit" class="btn green">Update</button>
<button type="button" class="btn default" data-dismiss="modal" >Close</button>
</div>
</form>
<script>
$('.edit-form').find('.image-preview').uploadPreview();
$.each($('.edit-form').find('.image-preview'),function(i,tag){
var img=$(this).attr("data-url");
var n = Date.now();
if(img!="")
{	
$(this).css("background-image", "url("+img+"?"+n+")");
$(this).css("background-size", "cover");
$(this).css("background-position", "center center");
$(this).children(".image-label").hide();
$(this).children(".image-edit").show();
$(this).children(".image-remove").show();	
}
});
$('.edit-form').on("click",".image-remove",function(){	
var inputFile=$(this);	
if(inputFile.parent().hasClass("imgExist"))
{	
var id=$('.edit-form').find("#id").val();	
var img=inputFile.parent().attr("data-url");	
var input=inputFile.parent().find("input[type=file]").attr("name");	
var url=window.location.href+'/deleteFile';	
alertify.confirm(notifications['del'],"Are you sure you want to delete this?",
function(){
$.post(url,{img:img,input:input,id:id},function(data){
inputFile.parent().css("background-image", "none");
inputFile.parent().children(".image-label").show();
inputFile.parent().children(".image-edit").hide();
inputFile.parent().children(".image-remove").hide();	
inputFile.parent().removeClass("imgExist");	
alertify.success('Successfully Deleted !');	
});		
},function(){
inputFile.parent().css("background-image", "url("+img+")");
inputFile.parent().css("background-size", "cover");
inputFile.parent().css("background-position", "center center");
inputFile.parent().children(".image-label").hide();
inputFile.parent().children(".image-edit").show();
inputFile.parent().children(".image-remove").show();	
});	
}
});
</script>