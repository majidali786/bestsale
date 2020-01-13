<div class="page-wrapper-row">
<div class="page-wrapper-top">
<!-- BEGIN HEADER -->
<div class="page-header">
<!-- BEGIN HEADER TOP -->
<div class="page-header-top">
<div class="container">
<!-- BEGIN LOGO -->
<div class="page-logo">
<a href="<?= base_url("home"); ?>">
<img src="<?= base_url("assets/pages/img/logo_t.png?1")?>" alt="logo" class="logo-default" style="width: 285px;padding-top: 0%;">
</a>
</div>
<!-- END LOGO -->
<!-- BEGIN RESPONSIVE MENU TOGGLER -->

<!-- END RESPONSIVE MENU TOGGLER -->
<!-- BEGIN TOP NAVIGATION MENU -->
<div class="top-menu">
<ul class="nav navbar-nav pull-right">
<!-- BEGIN USER LOGIN DROPDOWN -->
<?php 
if($user['U_TYPE']==3)
{ 
?>
<li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
<i class="icon-bell"></i>
</a>
<ul class="dropdown-menu">
<li class="external">
<h3>You have
<strong>0 pending</strong> Vouchers</h3>
<a href="<?= base_url("notification/pending-voucher")?>">view all</a>
</li>
<li>
<div notif-list > 

</div>
</li>
</ul>
</li>
<?php
}
?>
<li class="dropdown dropdown-branch dropdown-dark">
<select class="form-control" name="changebranch">
<?php 
foreach($user['BRANCHES'] as $row){
?>
<option value="<?= $row['BCODE']?>" <?php if($row['BCODE']==$user['B_ID']){ echo "selected"; } ?>><?= $row['BNAME']?></option>
<?php 	
}
?>
</select>
</li>
<li class="dropdown dropdown-user dropdown-dark">
<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
<img alt="" class="img-circle" src="<?= base_url("assets/layouts/layout3/img/avatar9.png");?>">
<span class="username username-hide-mobile"><?= $user['U_ID']?></span>
</a>
<ul class="dropdown-menu dropdown-menu-default">
<li>
<a href="<?= base_url("change-password");?>">
<i class="icon-key"></i> Change Password </a>
</li>
<li>
<a href="<?= base_url("logout");?>">
<i class="icon-logout"></i> Log Out </a>
</li>
</ul>
</li>
<li class="dropdown dropdown-dark">
<a href="javascript:;" class="menu-toggler"></a>
</li>
</ul>
</div>
<!-- END TOP NAVIGATION MENU -->
</div>
</div>
<!-- END HEADER TOP -->
<!-- BEGIN HEADER MENU -->
<div class="page-header-menu fh-fixedHeader">
<div class="container">
<!-- BEGIN MEGA MENU -->
<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
<div class="hor-menu  ">
<ul class="nav navbar-nav">
<li aria-haspopup="true">
<a href="<?= base_url("home");?>"> Dashboard
<span class="arrow"></span>
</a>
</li>
<?php
$nav1=$navbar[0];
$nav2=$navbar[1];
$nav3=$navbar[2];
foreach($nav1 as $nav1a){
$classnav="";
$classnavb="";
$sr=0;	
$key=$nav1a['NO'];
if(array_key_exists($key,$nav2))
{
$navb=$nav2[$nav1a['NO']];
$classnav="";	
$classnavb="";	
$sr++;
}
?>
<li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown">
<a  class="" href="javascript:;">
<?php echo $nav1a['NAME'];?>
<span class="arrow"></span>
</a>
<?php 
if($sr>0)
{
?>
<ul class="dropdown-menu">
<?php 
foreach($navb as $navb1){
$key2=$navb1['NO'];
$classnav3="";
$classnav4="nav-link";
$abc=0;
if(array_key_exists($key2,$nav3))
{
$navc=$nav3[$navb1['NO']];
$classnav3="dropdown-submenu";	
$classnav4="nav-link nav-toggle";	
$abc++;
}
if($navb1['LINK']=="javascript:;"){
$linka="javascript:;";
}
else{
$linka=base_url().$navb1['LINK'];	
}

	
?>
<li aria-haspopup="true" class="<?php echo $classnav3;?>">
<a class="<?php echo $classnav4;?>" href="<?php  echo $linka;?>">
<?php echo $navb1['NAME'];?>
</a>
<?php 
if($abc>0)
{
?>
<ul class="dropdown-menu">
<?php 
foreach($navc as $navb2){	
?>
<li>
<a href="<?php  echo base_url().$navb2['LINK'];?>">
<?php echo $navb2['NAME'];?>
</a>
<?php
}
?>
</ul>
<?php 
}
?>
</li>
<?php 
}
?>		
</ul>		
<?php 		
}
?>			
</li>
<?php 
}
?>
</ul>
</div>
<!-- END MEGA MENU -->
</div>
</div>
<!-- END HEADER MENU -->
</div>
<!-- END HEADER -->
</div>
</div>