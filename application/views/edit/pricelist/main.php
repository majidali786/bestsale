<div class="row">

<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Item Price List</span>
</div>
</div>
<div class="portlet-body">
<form class="form-horizontal list-refresh edit-form" role="form">
<div class="form-body" style="height: 33px">

<div class="col-sm-4">
	<div class="form-group">
	<label class="col-md-4 control-label">Design</label>
	<div class="col-md-8 show-error">
	<select name="grp" id="grp" class="form-control select2">
	<option value="">Select Design</option>
	<?php 
	if(count($mgroup)){
	foreach($mgroup as $g){
	?>
	<option value="<?= $g['ID'];?>"><?= $g['NAME']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	</div>
</div>

<div class="col-sm-4">
	<div class="form-group">
	<label class="col-md-4 control-label">Item</label>
	<div class="col-md-8 show-error products">
	<select name="product" id="product" class="form-control select2">
	<option value="">Select Item</option>
	<?php 
	if(count($product)){
	foreach($product as $g){
	?>
	<option value="<?= $g['PCODE'];?>"><?= $g['PNAME']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	</div>
</div>

</div>

</form>
</div>
</div>
</div>



<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-list font-white"></i>
<span class="caption-subject font-white bold uppercase">Item List</span>
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

</div>



<script type="text/javascript">
$('[name=grp]').on("change",function(){
var grp = this.value;
var obj=$(document).find("[data-list-load]");
var url=window.location.href+'/list_by_grp';
var preloader=obj;	
preloader.customPreloader("show");
//sorting list w.r.t main group
$.post(url,{grp:grp,type:'all'},function(data){
$(obj).html(data);	
preloader.customPreloader("hide");
});


var url2=window.location.href+'/load_products';
$(".products").html("<h5>Loading...</h5>");	
$.post(url2,{grp:grp,type:'allproduct'},function(data){
$(".products").html(data);	
preloader.customPreloader("hide");
});

});	


$('[name=product]').on("change",function(){
var pcode = this.value;
var obj=$(document).find("[data-list-load]");
var url=window.location.href+'/list_by_product';
var preloader=obj;	
preloader.customPreloader("show");
//sorting list w.r.t product
$.post(url,{pcode:pcode},function(data){
$(obj).html(data);	
preloader.customPreloader("hide");
});

});	



</script>