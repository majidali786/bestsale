
        <div class="portlet box red">
    <div class="portlet-title" style="text-align:center;">
        <div style="margin-top:10px;">Recent Activity</div>
    </div>
    <div class="portlet-body" style="padding: 0px;">
        <div class="table-responsive">
         <table id="table2" class="table table-bordered" style="margin:0px">
<thead>
<tr>
<th style="text-align:center;">Vr. No</th>
<th style="text-align:center;">Date</th>
<th style="text-align:center;">Vr. Type</th>
<th style="text-align:center;">User</th>
<th style="text-align:center;">Branch</th>
<th style="text-align:center;">Type</th>
</tr>
</thead>
<tbody class="theme-border">
<?PHP
foreach ($data as $data)
{
?>
<tr>
    <td style="text-align:left;"><span><?= $data['NO'];?></span></td>
    <td style="text-align:left;"><span><?= date('d/m/Y',strtotime($data['VDATE']));?></span></td>
    <td style="text-align:left;"><span><?= $data['JO'];?></span></td>
    <td style="text-align:left;"><span><?= $data['U_ID'];?></span></td>
    <td style="text-align:left;"><span><?= $data['B_ID'];?></span></td>
    <td style="text-align:left;"><span><?=$data['TYPE']; ?></span></td>
</tr>
<?PHP
}
?>
</tbody>
</table>
</div>