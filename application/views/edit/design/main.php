<style>
label > a {
	text-decoration: none !important;
}
.col-sm-1 > i{
	margin-top:6px;
	cursor:pointer;
}			

   
.image-preview {
  width: 100px;
  height: 100px;
  position: relative;
  overflow: hidden;
  background-color: #ffffff;
  color: #ecf0f1;
  border:1px solid #ccc;
  border-radius:10px;
  -webkit-box-shadow:1px 1px 6px 2px #ccc; 
  -moz-box-shadow:1px 1px 6px 2px #ccc;  
   box-shadow:1px 1px 6px 2px #ccc; 
}
.image-preview input {
  line-height: 50px;
  font-size: 50px;
  position: absolute;
  opacity: 0;
  z-index: 10;
}
.image-preview label {
  position: absolute;
    z-index: 5;
    opacity: 0.8;
    cursor: pointer;
    background-color: #bdc3c7;
    width: 50px;
    height: 48px;
    font-size: 23px;
    padding-top: 12px;
    text-transform: uppercase;
    top: 0px;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    text-align: center;
    border-radius: 30px;
}
.image-preview >image-label>i:before{
cursor: pointer;	
}
.image-remove{
	z-index: 5;
    opacity: 0.8;
    cursor: pointer;
    background-color: #bdc3c7;
    width: 20px;
    height: 20px;
    font-size: 19px;
    border-radius: 30px;
    right: 2px;
    position: absolute;
    top: 3px;
    padding-left: 2px;	
}
.image-edit{
	z-index: 5;
    opacity: 0.8;
    cursor: pointer;
    background-color: #bdc3c7;
    width: 20px;
    height: 20px;
    font-size: 15px;
    border-radius: 30px;
    left: 2px;
    position: absolute;
    top: 3px;
    padding-left: 3px;	
    padding-top: 1px;	
}
.brokerage{
padding-left:0px;
padding-top:15px;	
}
</style>
<div class="row">

<div class="page-content-inner col-sm-6">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Add Design</span>
</div>
</div>
<div class="portlet-body">
<form class="form-horizontal list-refresh" role="form">
<div class="form-body">

<div class="form-group">
<label class="col-md-3 control-label">Design</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="name" placeholder="Design">
</div>
</div>
	<div class="form-group">
		<label class="control-label col-sm-3">Image</label>
			<div class="col-sm-6  show-error">
				<div class="image-preview">
				     <input type="file" name="img" id="img" accept="image/*" class="image-input" />
				</div>
			</div>
	</div>

</div>
<div class="form-actions right1">
<button type="submit" class="btn green">Submit</button>
<button type="reset" class="btn default">Reset</button>
</div>
</form>
</div>
</div>
</div>
<div class="page-content-inner col-sm-6">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-list font-white"></i>
<span class="caption-subject font-white bold uppercase">List Design</span>
</div>
<div class="actions">
<a class="btn btn-circle btn-icon-only btn-default loadlist" href="javascript:;">
<i class="icon-refresh"></i>
</a>
 <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
</div>
</div>
<div class="portlet-body" data-list-load>

</div>
</div>
</div>

<script src="<?php echo base_url("assets/global/scripts/jquery.uploadPreview.min.js")?>">
</script>
	<script>
	$('.image-preview').uploadPreview();
	</script>
</div>