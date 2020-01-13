<ul class="dropdown-menu-list scroller-notif" data-handle-color="#637283" style="max-height:250px">
<?php
foreach($list as $a){
?>
<li>
<a href="<?= base_url("notification/pending-voucher")."?jo=".$a['JO']?>">
<span class="time"><?=$a['TOTAL']?></span>
<span class="details">
<span class="label label-sm label-icon label-success">
<i class="icon-doc"></i>
</span> <?= $joInWords[$a['JO']]?> </span>
</a>
</li>
<?php 	
}
?>
</ul>
<script>
$(".scroller-notif").slimscroll({
  width: '100%',
  height: '',
  railVisible: true
});
</script>