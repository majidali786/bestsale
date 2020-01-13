<select name="sgrp" id="sgrp" class="form-control select2">
<option value="">Select Size</option>
<?php 
if(count($sgroup)){
foreach($sgroup as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['NAME']; ?></option>
<?php
}
}
?>
</select>

<script type="text/javascript">
$(document).find(".select2").select2({
width: "100%",
});




$('[name=sgrp]').on("change",function(){
var grp = $('[name=grp]').val();
var sgrp = this.value;
var obj=$(document).find("[data-list-load]");
var url=window.location.href+'/list_by_grp';
var preloader=obj;	
preloader.customPreloader("show");
$.post(url,{grp:grp,sgrp:sgrp,type:'single'},function(data){
$(obj).html(data);	
preloader.customPreloader("hide");
});

var url2=window.location.href+'/load_products';
$(".products").html("<h5>Loading...</h5>");	
$.post(url2,{grp:grp,sgrp:sgrp,type:'single'},function(data){
$(".products").html(data);	
preloader.customPreloader("hide");
});

});	

</script>