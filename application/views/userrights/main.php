<div class="row">
<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-list font-white"></i>
<span class="caption-subject font-white bold uppercase">List User</span>
</div>
<div class="actions">
 <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
</div>
</div>
<div class="portlet-body">
<table class="table table-striped table-bordered table-hover order-column" id="list">
<thead>
<tr>
<th> Username </th>
<th> Type </th>
<th> Branch </th>
<th> Status </th>
<th style="width:20%;"> Actions </th>
</tr>
</thead>
<tbody>
<?php 
$branch=$type="";
$status=array("Deactive","Active");
if(count($list)){
foreach($list as $a):
foreach($list_branch as $b):
if($a['B_ID']==$b['BCODE'])
{
$branch=$b['BNAME'];	
}
endforeach;
foreach($list_type as $c):
if($a['TYPE']==$c['ID'])
{
$type=$c['TYPE'];	
}
endforeach;
?>
<tr>
<td><?= $a['USERNAME'];?></td>
<td><?= $type;?></td>
<td><?= $branch;?></td>
<td><?= $status[$a['STATUS']];?></td>
<td>
<div class="btn-group">
<a class="btn theme-haze btn-outline btn-circle btn-sm level-1" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" style="padding: 0px 5px;" data-close-others="true" user="<?= $a['USERNAME'];?>">Action <i class="fa fa-angle-down"></i>
</a>
<ul class="dropdown-menu pull-right">
<li>
<a href="javascript:;" menu-rights ><i class="icon-list"></i> Menu Rights </a>
</li>
<li>
<a href="javascript:;" voucher-rights><i class="icon-notebook text-warning"></i> Voucher Rights </a>
</li>
<li>
<a href="javascript:;" other-rights><i class="icon-directions text-warning"></i> Other Rights </a>
</li>
</ul>
</div>
</td>
</tr>
<?php
endforeach;
}
?>
</tbody>
</table>
<script>
$(window).on("load",function(){
$('#list').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    infoEmpty: "No records found",
                    infoFiltered: "(filtered1 from _MAX_ total records)",
                    lengthMenu: "Show _MENU_",
                    search: "Search:",
                    zeroRecords: "No matching records found",
                    paginate: {
                        previous: "Prev",
                        next: "Next",
                        last: "Last",
                        first: "First"
                    }
                },
                bStateSave: !0,
                lengthMenu: [
                    [6, 15, 20, -1],
                    [6, 15, 20, "All"]
                ],
                pageLength: 6,
                columnDefs: [{
                    targets: [0]
                }, {
                    searchable: !1,
                    targets: [0]
                }],
                order: [
                    [1, "asc"]
                ]
            });
baseUrl="<?= base_url("user-rights")?>";			
});			
</script>
</div>
</div>
</div>

</div>