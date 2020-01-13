<div class="row">
<div class="page-content-inner">
<div class="todo-container">
<div class="row">
<div class="col-md-4">
<ul class="todo-projects-container">
<li class="todo-padding-b-0">
<div class="todo-head">
<h3>Voucher Type</h3>
</div>
</li>
<?php
foreach($data as $a){
?>
<li class="todo-projects-item" jo="<?=$a['JO']?>">
<h3><?= $joInWords[$a['JO']]?> <span class="badge badge-primary pull-right jo-<?=$a['JO']?>"> <?=$a['TOTAL']?> </span></h3>
</li>
<div class="todo-projects-divider"></div>
<?php 	
}
?>
</ul>
</div>
<div class="col-md-8" load-voucher-list>

</div>
</div>
</div>
</div>
</div>
<script>
$(window).on("load",function(){
setInterval(function(){
$.ajax({
url:"<?= base_url("notification/pending-voucher/notif-total");?>",
method:"get",
dataType:"json" 	
}).done(function(response){
var reload=false;	
$.each(response,function(i,tag){
var jo=tag['JO'];
var old=$(document).find(".jo-"+jo+"").html();
$(document).find(".jo-"+jo+"").html(tag['TOTAL']);	
if(old!=tag['TOTAL']){
reload=true;	
}
});
if(reload){
$(document).find(".todo-active").trigger("click");	
}
});
},3000);
<?php 
if(!empty($_GET['jo'])){
?>
$(document).find("[jo=<?= $_GET['jo']?>]").trigger("click");
<?php 	
}
?>	
});
$(document).on("click","[jo]",function(){
var jo=$(this).attr("jo");	
$(".todo-active").removeClass("todo-active");
$(this).addClass("todo-active");
var destination=$("[load-voucher-list]");
destination.customPreloader("show");
$.ajax({
url:"<?= base_url("notification/pending-voucher/voucher-list");?>",
data:{jo:jo},
method:"post"	
}).done(function(response){
destination.html(response);	
});
});
</script>