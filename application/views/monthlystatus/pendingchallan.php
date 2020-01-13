
		<div class="portlet box red">
    <div class="portlet-title" style="text-align:center;">
        <div style="margin-top:10px;">Pending China Order</div>
    </div>
    <div class="portlet-body" style="padding: 0px;">
        <div class="table-responsive">
		 <table id="table2" class="table table-bordered" style="margin:0px">
<thead>
<tr>
<th style="text-align:center;">Order#</th>
<th style="text-align:center;">Date</th>
<th style="text-align:center;">Product </th>
<th style="text-align:center;">Party</th>
<th style="text-align:center;">Actions</th>
</tr>
</thead>
<tbody class="theme-border">
<?PHP
foreach ($data as $data)
{
?>
<tr>
    <td style="text-align:left;"><span><?= $data['NO'];?></span></td>
    <td style="text-align:left;"><span><?= date('m/d/Y',strtotime($data['VDATE']));?></span></td>
    <td style="text-align:left;"><span><?= $data['PNAME'];?></span></td>
    <td style="text-align:left;"><span><?= $data['VNAME'];?></span></td>

	
	<td><a href="<?= base_url("purchase/transfer-order/".$data['NO'])?>" target="blank" class="btn btn-sm blue"><i class="icon-link"></i></a>
	
	</td>
</tr>
<?PHP
}
?>
</tbody>
</table>
</div>