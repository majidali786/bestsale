
<div class="page-content-inner">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class=" icon-layers font-green"></i>
<span class="caption-subject font-green bold uppercase">Dash Board</span>
</div>
<div class="actions">
<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
<i class="icon-cloud-upload"></i>
</a>
<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
<i class="icon-wrench"></i>
</a>
<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
<i class="icon-trash"></i>
</a>
</div>
</div>
<div class="portlet-body" >
	<div class="row">
	<?php 
	if(!empty($rights['PROMISES']))
	{
	if($rights['PROMISES']==1)
	{	
	?>
	<div class="col-sm-3">
	<h3><b><i class="icon-pin"></i> Best Soutions</b></h3>
	<div class="todo-tasklist" promises >
	
	</div>
	</div>
	<?php 
	}
	}
	?>
	<div class="col-sm-8" style="width:74.67%">
	<?php 
	if(!empty($rights['PENDINGDC']))
	{
	if($rights['PENDINGDC']==1)
	{	
	?>
		<div class="row" style="display:none;">
			<div class="col-sm-12">
				<div id="pchallan">
				</div>
			</div>
		</div>
	<?php 
	}
	}
	if(!empty($rights['DASHBOARD']))
	{
	if($rights['DASHBOARD']==1)
	{	
	?>
		<div class="row" style="display:none;">
			<div class="col-sm-12">
				<div id="msatus">
				</div>
			</div>
		</div>
		<div class="row" style="display:none;">
			
			<div class="col-sm-4">
				<div id="crecovery">
				</div>
			</div>
		
			<div class="col-sm-8" style="display:none;">
				<div id="saleinv">
				</div>
			</div>
			<div class="col-sm-4" style="display:none;">
				<div id="rActivity">
				</div>
			</div>
			<div class="col-sm-8" style="display:none;">
				<div id="recovery">
				</div>
			</div>
		</div>
		<?php 
	}
	}	?>
	</div>
</div>
</div>
</div>
<?php 
if(!empty($rights['PROMISES']))
{
if($rights['PROMISES']==1)
{	
?>
<script>
$(window).on("load",function(){
var colors=["red","green"];	
$.ajax({
url:"<?= base_url("load-promises")?>",	
method:"get",
dataType:"json"	
}).done(function(response){
$.each(response,function(i,tag){	
var a='<div class="todo-tasklist-item todo-tasklist-item-border-'+colors[tag['TYPE']]+'" promise-no="'+tag['NO']+'">'+
'<div class="todo-tasklist-item-title"><i class="icon-user"></i> '+tag['ANAME']+' </div>'+
'<div class="todo-tasklist-controls pull-left">'+
'<span class="todo-tasklist-date">'+
'<i class="fa fa-calendar"></i> '+tag['PRDATE']+' </span>'+
'<span class="todo-tasklist-badge badge badge-roundless">'+tag['AMOUNT']+'</span>'+
'</div>'+
'</div>';
$("[promises]").append(a).hide().show("slow");		
});		
});
singlePromiseUrl="<?= base_url("load-promise")?>";	

});
</script>
<?php 
}
}
 
if(!empty($rights['DASHBOARD']))
{
if($rights['DASHBOARD']==1)
{	
?>
<script>
$(window).on("load",function(){
var baseUrl="<?= base_url("load-monthlystatus")?>";	
var target=$('#msatus');	
$.post(baseUrl,{},function(response){
target.html(response);	
});
var baseUrl="<?= base_url("load-custstatus")?>";	
var target1=$('#csales');	
$.post(baseUrl,{},function(response){
target1.html(response);	
});
var baseUrl="<?= base_url("load-custrec")?>";	
var target2=$('#crecovery');	
$.post(baseUrl,{},function(response){
target2.html(response);	
});
var baseUrl="<?= base_url("load-saleinvoices")?>";	
var target3=$('#saleinv');	
$.post(baseUrl,{},function(response){
target3.html(response);	
});
var baseUrl="<?= base_url("load-recovery")?>";	
var target4=$('#recovery');	
$.post(baseUrl,{},function(response){
target4.html(response);	
});
});


</script>
<?php 
}
}
 
if(!empty($rights['PENDINGDC']))
{
if($rights['PENDINGDC']==1)
{	
?>
<script>
$(window).on("load",function(){
//var baseUrl="<?= base_url("monthlystatus/loadpchallan")?>";	
var target52=$('#pchallan');	
$.post(baseUrl,{},function(response){
target52.html(response);	
});
});
</script>
<?php 
}
}	?>
