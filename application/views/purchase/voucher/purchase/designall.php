
<?php
if(!empty($design)) {
foreach($design as $row):
?>
<ul class="list-unstyled">
<li><?= $row["NAME"] ?></li>
</ul>
<?php 
endforeach;
}	else	{
?>
<ul class="list-unstyled">
<li>Not Found</li>
</ul>
<?php 
}
?>