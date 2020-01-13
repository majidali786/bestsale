<?php 
for($a=0;$a<count($dates);$a++){
?>
<script>
var data=[];
</script>
<?php
$debit=$credit=0; 
foreach($data as $b):
if($b['FROOM']==date("n",strtotime($dates[$a])) && $b['TOO']==date("Y",strtotime($dates[$a]))){
$dr= explode(" ",$b['SPERSON']);
$debit+=$b['DEBIT'];
$credit+=$b['CREDIT'];
?>
<script>
var a={y: "<?= $dr[0]?>", a: <?= $b['DEBIT']?>, b: <?= $b['CREDIT']?>};
data.push(a);
</script>
<?php 
}
endforeach;	
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-calendar"></i> <?= date("M/Y",strtotime($dates[$a]))?></b></h2>
</div>
<div id="sperson_chart_<?= date("M",strtotime($dates[$a]))?>" style="height:500px;"></div>
<div class="row">
<div class="dashboard-stat blue col-sm-6">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($debit);?> </div>
<div class="desc"> Total Sales </div>
</div>
</div>
<div class="dashboard-stat purple col-sm-6">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($credit);?> </div>
<div class="desc"> Total Recovery </div>
</div>
</div>

</div>
<script>
jQuery(document).ready(function() {
 new Morris.Bar( {
        element:"sperson_chart_<?= date("M",strtotime($dates[$a]))?>", data:data, xkey:"y",ykeys:["a", "b"],labels:["Total Sales", "Total Recovery"]
    }
    )
});
</script>
<?php 	
}
?>

                                                   
