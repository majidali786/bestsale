	<select name="product" id="product" class="form-control select2">
	<option value="">Select Item</option>
	<?php 
	if(count($products)){
	foreach($products as $g){
	?>
	<option value="<?= $g['PCODE'];?>"><?= $g['PNAME']; ?></option>
	<?php
	}
	}
	?>
	</select>

<script type="text/javascript">
$(document).find(".select2").select2({
width: "100%",
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