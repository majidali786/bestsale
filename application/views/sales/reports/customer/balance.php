<div class="row">

<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Customer Balances Report</span>
</div>
</div>
<div class="portlet-body">
<form action="<?= base_url("customer-reports/balance/data")?>" class="form-horizontal form-bordered action-url" data-target="[data-load-report]">
	<div class="form-body row">
	<div class="col-sm-4">
	<div class="form-group">
	<label class="control-label col-md-5">As On <i class="icon-calendar theme-color"></i></label>
	<div class="col-md-7 show-error">
	<input class="form-control date-picker" size="16" type="text" placeholder="dd/mm/yyyy" name="date" value="<?= date("d/m/Y")?>" />
	</div>
	</div>
	</div>
	<?php 
	if($user['U_TYPE']==0 || $user['UB_ID']==1)
	{	
	?>
	<div class="col-sm-4">
	<div class="form-group">
	<label class="control-label col-md-5">Branch <i class="icon-home theme-color"></i></label>
	<div class="col-md-7 show-error">
	<select name="branch"  id="branch" class="form-control select2">
	<option value="0">Accumulated (All)</option>
	<?php 
	if(count($branch)){
	foreach($branch as $g){
	?>
	<option value="<?= $g['BCODE'];?>"><?= $g['BNAME']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	</div>
	</div>
	<?php 
	}
	else{
	?>
	<input type="hidden" name="branch"  id="branch" value="<?= $user['B_ID']?>">
	<?php 
	}
	?>
	</div>
	<div class="form-actions right1">
	<button type="submit" class="btn green">Load Report</button>
	<button type="reset" class="btn default">Reset</button>
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
<span class="caption-subject font-white bold uppercase">Report</span>
</div>
<div class="actions">
 <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
</div>
</div>
<div class="portlet-body" data-load-report>

</div>
</div>
</div>

</div>