<table class="table table-bordered table-striped table-condensed flip-content">
<thead class="flip-content theme-color border-theme">
<tr>
<th>#</th>
<th>Challan#</th>
<th>Date</th>
<th>Remarks</th>
<th>Total</th>
</tr>
</thead>
<tbody class="theme-border">
<?php
$rowNumber=1; 
foreach($data as $row):
?>
<tr>
    <td class="theme-bg theme-border text-align-center" ><a href="javascript:void(0);" style="color:white" onclick="send_no(<?= $row['NO'];?>)"><?= $rowNumber;?></button></td>
	<td><span><?= $row['NO'];?></span></td>
	<td><span><?= $row['VDATE'];?></span></td>
	<td><span><?= $row['REMARKS'];?></span></td>
    <td><span><?= $row['TOTAL'];?></span></td>
</tr>
<?php 
$rowNumber ++;
endforeach;
?>
</tbody>

</table>
