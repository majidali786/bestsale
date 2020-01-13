<div class="mt-element-list">
<div class="mt-list-head list-simple font-white bg-blue">
<div class="list-head-title-container">
<h3 class="list-title">Rights</h3>
</div>
</div>
<div class="mt-list-container list-simple">	

<div class="md-checkbox-inline">
<div class="md-checkbox has-error">
<input type="checkbox" id="v_add" name="v_add" <?php if(!empty($rights[0]['AD'])){ if($rights[0]['AD']==1){ echo "checked"; }} ?>  value="1" class="md-check">
<label for="v_add">
<span></span>
<span class="check"></span>
<span class="box"></span> <b>Add</b></label>
</div>

<div class="md-checkbox has-error">
<input type="checkbox" id="v_edit" name="v_edit" <?php if(!empty($rights[0]['EDIT'])){ if($rights[0]['EDIT']==1){ echo "checked"; }} ?> value="1" class="md-check">
<label for="v_edit">
<span></span>
<span class="check"></span>
<span class="box"></span> <b>Edit</b></label>
</div>

<div class="md-checkbox has-error">
<input type="checkbox" id="v_delete" name="v_delete" <?php if(!empty($rights[0]['DEL'])){ if($rights[0]['DEL']==1){ echo "checked"; }} ?> value="1" class="md-check">
<label for="v_delete">
<span></span>
<span class="check"></span>
<span class="box"></span> <b>Delete</b></label>
</div>

<div class="md-checkbox has-error">
<input type="checkbox" id="v_nav" name="v_nav" <?php if(!empty($rights[0]['NAV'])){ if($rights[0]['NAV']==1){ echo "checked"; }} ?> value="1" class="md-check">
<label for="v_nav">
<span></span>
<span class="check"></span>
<span class="box"></span> <b>Navigation</b></label>
</div>

<div class="md-checkbox has-error">
<input type="checkbox" id="v_print" name="v_print" <?php if(!empty($rights[0]['PRNT'])){ if($rights[0]['PRNT']==1){ echo "checked"; }} ?> value="1" class="md-check">
<label for="v_print">
<span></span>
<span class="check"></span>
<span class="box"></span> <b>Print</b></label>
</div>



</div>
</div>
</div>

<div class="mt-element-list">
<div class="mt-list-head list-simple font-white bg-blue">
<div class="list-head-title-container">
<h3 class="list-title">Voucher Status</h3>
</div>
</div>
<div class="mt-list-container list-simple">
<div class="form-md-radios">
<div class="md-radio-inline">
<div class="md-radio has-info">
<input type="radio" id="vstatus1" <?php if(!empty($rights[0]['UNPOSTED'])){ if($rights[0]['UNPOSTED']==1){ echo "checked"; }} ?> name="vstatus" value="1" class="md-radiobtn">
<label for="vstatus1">
<span></span>
<span class="check"></span>
<span class="box"></span> <b>Unposted</b> </label>
</div>
<div class="md-radio has-info">
<input type="radio" id="vstatus2" <?php if(!empty($rights[0]['POSTED'])){ if($rights[0]['POSTED']==1){ echo "checked"; }} ?> name="vstatus" value="2" class="md-radiobtn" >
<label for="vstatus2">
<span></span>
<span class="check"></span>
<span class="box"></span> <b>Posted</b> </label>
</div>
<div class="md-radio has-info">
<input type="radio" id="vstatus3" name="vstatus" <?php if(!empty($rights[0]['APPROVED'])){ if($rights[0]['APPROVED']==1){ echo "checked"; }} ?> value="3" class="md-radiobtn">
<label for="vstatus3">
<span></span>
<span class="check"></span>
<span class="box"></span> <b>Approved</b> </label>
</div>
</div>
</div>
</div>
</div>
<input type="hidden" name="menu" value="<?= $menu;?>"/>