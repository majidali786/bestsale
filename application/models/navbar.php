<?php
defined("BASEPATH") OR exit("No direct script access allowed");

Class Navbar extends CI_Model{
	
	public function mynavigation(){
	$userdata=$this->session->userdata("user");
	if($userdata['U_TYPE']==0){
	$query=$this->db->where("LEVL",1)->where("STATUS",1)->order_by('SORT','ASC')->get("MENU");
	}
	else{
	$query=$this->db->query("SELECT MENU.NO,MENU.NAME,MENU.LINK,MENU.LEVL,MENU.LEVEL1,MENU.LEVEL2,MENU.SORT,MENU.STATUS FROM MENU INNER JOIN MENU_RIGHTS ON MENU.NO=MENU_RIGHTS.MENU WHERE MENU_RIGHTS.USR='".$userdata['U_ID']."' AND MENU.LEVL='1' AND MENU.STATUS=1 AND ( MENU_RIGHTS.B_ID='".$userdata['B_ID']."' OR MENU.UNIVERSAL=0 ) GROUP BY MENU.NO,MENU.NAME,MENU.LINK,MENU.LEVL,MENU.LEVEL1,MENU.LEVEL2,MENU.SORT,MENU.STATUS ORDER BY MENU.SORT");	
	}
	$nav1=array();	
	$nav2=array();	
	$nav3=array();	
	//======level1=======
	foreach($query->result() as $row)
	{
	$navdata=array("NO"=>$row->NO,"NAME"=>$row->NAME,"LINK"=>$row->LINK,"LEVL"=>$row->LEVL,"LEVEL1"=>$row->LEVEL1,"LEVEL2"=>$row->LEVEL2,"SORT"=>$row->SORT,"STATUS"=>$row->STATUS);	
	array_push($nav1,$navdata);
	//======level2=======
	
	if($userdata['U_TYPE']==0){
	$navquery2=$this->db->where("LEVL",2)->where("STATUS",1)->where("LEVEL1",$row->NO)->order_by('SORT','ASC')->get("MENU");
	}
	else{
	$navquery2=$this->db->query("SELECT MENU.NO,MENU.NAME,MENU.LINK,MENU.LEVL,MENU.LEVEL1,MENU.LEVEL2,MENU.SORT,MENU.STATUS FROM MENU INNER JOIN MENU_RIGHTS ON MENU.NO=MENU_RIGHTS.MENU WHERE MENU_RIGHTS.USR='".$userdata['U_ID']."' AND MENU.LEVL='2' AND MENU.STATUS=1 AND MENU.LEVEL1='".$row->NO."' AND ( MENU_RIGHTS.B_ID='".$userdata['B_ID']."' OR MENU.UNIVERSAL=0 ) GROUP BY MENU.NO,MENU.NAME,MENU.LINK,MENU.LEVL,MENU.LEVEL1,MENU.LEVEL2,MENU.SORT,MENU.STATUS ORDER BY MENU.SORT");	
	}
	
	
	$nav2b=array();
	foreach($navquery2->result() as $rec)
	{
	$navdata2=array("NO"=>$rec->NO,"NAME"=>$rec->NAME,"LINK"=>$rec->LINK,"LEVL"=>$rec->LEVL,"LEVEL1"=>$rec->LEVEL1,"LEVEL2"=>$rec->LEVEL2,"SORT"=>$rec->SORT,"STATUS"=>$rec->STATUS);	
	array_push($nav2b,$navdata2);
	//======level3=======
	$navquery3=$this->db->where("LEVL",3)->where("STATUS",1)->where("LEVEL1",$row->NO)->where("LEVEL2",$rec->NO)->order_by('SORT','ASC')->get("MENU");
	
	if($userdata['U_TYPE']==0){
		
	$navquery3=$this->db->where("LEVL",3)->where("STATUS",1)->where("LEVEL1",$row->NO)->where("LEVEL2",$rec->NO)->order_by('SORT','ASC')->get("MENU");
	}
	else{
	$navquery3=$this->db->query("SELECT MENU.NO,MENU.NAME,MENU.LINK,MENU.LEVL,MENU.LEVEL1,MENU.LEVEL2,MENU.SORT,MENU.STATUS FROM MENU INNER JOIN MENU_RIGHTS ON MENU.NO=MENU_RIGHTS.MENU WHERE MENU_RIGHTS.USR='".$userdata['U_ID']."' AND MENU.LEVL='3' AND MENU.STATUS=1 AND MENU.LEVEL1='".$row->NO."' AND MENU.LEVEL2='".$rec->NO."' AND ( MENU_RIGHTS.B_ID='".$userdata['B_ID']."' OR MENU.UNIVERSAL=0 ) GROUP BY MENU.NO,MENU.NAME,MENU.LINK,MENU.LEVL,MENU.LEVEL1,MENU.LEVEL2,MENU.SORT,MENU.STATUS ORDER BY MENU.SORT");	
	}
	
	
	$nav3b=array();
	foreach($navquery3->result() as $reb)
	{
	$navdata3=array("NO"=>$reb->NO,"NAME"=>$reb->NAME,"LINK"=>$reb->LINK,"LEVL"=>$reb->LEVL,"LEVEL1"=>$reb->LEVEL1,"LEVEL2"=>$reb->LEVEL2,"SORT"=>$reb->SORT,"STATUS"=>$reb->STATUS);	
	array_push($nav3b,$navdata3);
	}
	if(count($nav3b)>0)
	{
	$nav3[$rec->NO]=$nav3b;
	}
	}
	if(count($nav2b)>0)
	{
	$nav2[$row->NO]=$nav2b;
	}
	}
	$navbar=array($nav1,$nav2,$nav3);
	return $navbar;
	}
	
}
?>