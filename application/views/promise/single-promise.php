<div class="timeline">
<?php 
$sr=1;
foreach($data as $a){
?>
<div class="timeline-item">
<div class="timeline-badge">
<h2><?= $sr ?></h2>
</div>
<div class="timeline-body">
<div class="timeline-body-arrow"> </div>
<div class="timeline-body-head">
<div class="timeline-body-head-caption">
<a class="timeline-body-title font-blue-madison"><?= $a['ANAME']?></a>
</div>
<div class="timeline-body-head-actions">
<div class="btn-group">
<button class="btn btn-circle green btn-sm dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
<i class="fa fa-angle-down"></i>
</button>
<ul class="dropdown-menu pull-right" role="menu">
<?php 
if($data[0]['STATUS']==1){
?>
<li>
<a href="javascript:;" promise-closed >Close</a>
</li>
<?php 
}
else{
?>
<li>
<a href="javascript:;" promise-open >Open</a>
</li>
<?php 
}
?>
</ul>
</div>
</div>
<div class="timeline-body-head-datetime">
<span class="timeline-body-time font-grey-cascade">Promise Make On <span class="label label-info"><i class="icon-calendar"></i> <?= date("F d,Y",strtotime($a['PMDATE']))?></span></span>
</div>
</div>
<div class="timeline-body-content">
<p class="font-grey-cascade"> <?= $a['DESCR']?></p>
<p class="font-grey-cascade"> Promise Date <span class="label label-primary"><i class="icon-calendar"></i> <?= date("F d,Y",strtotime($a['PDATE']))?></span> Promise Amount <span class="label label-danger"><i class="icon-tag"></i> <?= lakhseparater($a['AMOUNT'])?></span></p>
</div>
</div>
</div>
<?php 
$sr++;	
}
foreach($data2 as $b){
?>
<div class="timeline-item">
<div class="timeline-badge">
<h2><?= $sr ?></h2>
</div>
<div class="timeline-body">
<div class="timeline-body-arrow"> </div>
<div class="timeline-body-head">
<div class="timeline-body-head-caption">
<a class="timeline-body-title font-blue-madison"><?= date("F d,Y",strtotime($b['VDATE']))?></a>
</div>
<div class="timeline-body-head-actions">
<div class="btn-group">
<button class="btn btn-circle green btn-sm dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
<i class="fa fa-angle-down"></i>
</button>
<ul class="dropdown-menu pull-right" role="menu" promise-comment-no="<?= $b['NO']?>">
<li>
<a href="javascript:;" promise-comment-edit>Edit</a>
</li>
<li>
<a href="javascript:;" promise-comment-delete>Delete</a>
</li>
</ul>
</div>
</div>
</div>
<div class="timeline-body-content" style="width:100%;">
<p class="font-grey-cascade"> <?= $b['DESCR']?></p>
<p class="font-grey-cascade"> Paid Amount <span class="label label-success"><i class="icon-tag"></i> <?= lakhseparater($b['PAMOUNT'])?></span></p>
<?php 
if($b['STATUS']==1){
?>
<h3 style="text-align:center">Promise Extend</h3>
<p class="font-grey-cascade"> Expected Date <span class="label label-primary"><i class="icon-calendar"></i> <?= date("F d,Y",strtotime($b['EDATE']))?></span> Expected Amount <span class="label label-danger"><i class="icon-tag"></i> <?= lakhseparater($b['EAMOUNT'])?></span></p>
<?php 
}
?>
</div>
</div>
</div>
<?php 
$sr++;	
}
if($data[0]['STATUS']==1){
?>
<div class="timeline-item">
<div class="timeline-badge">
<h2><?= $sr ?></h2>
</div>
<div class="timeline-body">
<div class="timeline-body-arrow"> </div>
<div class="timeline-body-head pull-left" style="width:100%;">
<div class="timeline-body-head-caption">
<h3 class="timeline-body-title font-blue-madison" style="margin:0;">INSERT COMMENT</h3>
</div>
</div>
<div class="timeline-body-content" style="width:100%;">
<form class="form-horizontal promise-comment">
<div class="form-group">
<div class="col-sm-6 show-error">
<input type="text" name="pamount" data-only-numbers class="form-control" placeholder="Amount Paid"/>
</div>
<div class="col-sm-6 show-error">
<select class="form-control" name="cstatus">
<option value="">Status</option>
<option value="0">Closed</option>
<option value="1">Extend</option>
</select>
</div>
</div>
<div class="form-group">
<div class="col-sm-12 show-error">
<textarea name="description" class="form-control todo-taskbody-taskdesc" rows="4" placeholder="Description..."></textarea>
</div>
</div>
<div class="form-group extend">
<div class="col-sm-6 show-error">
<input type="text" name="eamount" data-only-numbers class="form-control" placeholder="Expected Amount"/>
</div>
<div class="col-sm-6 show-error">
<input type="text" name="edate" class="form-control" placeholder="Expected Date"/>
</div>
</div>
<div class="form-actions right todo-form-actions">
<button class="btn btn-circle btn-sm green" type="submit">Save</button>
</div>
</form>
</div>
</div>
</div>
<?php 
}
?>

</div>
<?php 
if($data[0]['STATUS']==0){
?>
<h1 style="text-align:center">
<span class="label label-danger" style="width:100%"> Closed </span>
</h1>
<?php 	
}
?>
<script>
$(".extend").hide();
$(document).on("change","[name=cstatus]",function(){
if($(this).val()==1){
$(".extend").show();	
}
else{
$(".extend").hide();	
}	
});
$("[name=edate]").datepicker({rtl:App.isRTL(),orientation:"left",autoclose:!0,format:"dd/mm/yyyy",todayHighlight:true});
$("[data-only-numbers]").each(function(){
var cleave = new Cleave($(this), {
    numeral: true,
    numeralThousandsGroupStyle: 'lakh',
	numeralDecimalScale:4
});	
$(this).css("text-align","right");
});
InsertCommenturl="<?= base_url("promise/comment/".$data[0]['NO']."")?>";
promisePno="<?= $data[0]['NO']?>";
</script>
