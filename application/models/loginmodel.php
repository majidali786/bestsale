<?php
defined("BASEPATH") OR exit("No direct script access allowed");

Class loginModel extends CI_Model{
	
	public function validateuser($data){
	$query=$this->db->select("USERNAME,B_ID,TYPE")->where("USERNAME",$data['username'])->where("PASSWORD",$data['pword'])->where("STATUS","1")->get("login");
	if($query->num_rows())
	{
	$row=$query->row();
	if($row->TYPE!=0){
	$query=$this->db->query("SELECT BRANCH.BCODE,BRANCH.BNAME FROM BRANCH INNER JOIN MENU_RIGHTS ON BRANCH.BCODE=MENU_RIGHTS.B_ID WHERE MENU_RIGHTS.USR='".$row->USERNAME."' GROUP BY BRANCH.BCODE,BRANCH.BNAME ORDER BY BRANCH.BNAME");
	$branches=$query->result_array();
	$authorized=false;
	$alwaysHeadOffice=false;
	foreach($branches as $d){
	if($d['BCODE']==$data['branch']){
	$authorized=true;	
	}
	if($d['BCODE']==1){
	$alwaysHeadOffice=true;	
	}	
	}
	if($alwaysHeadOffice){
	$data['branch']=1;	
	}
	if($authorized==true){
	$userData=array('U_ID'=>$row->USERNAME,'B_ID'=>$data['branch'],'U_TYPE'=>$row->TYPE,'BRANCHES'=>$branches,'UB_ID'=>$row->B_ID);
	//print_r($userData);
	
	
	if($row->TYPE==2){
	$spcode="8";	
	$sperson=$this->db->select("BCODE")->where("USERNAME",$row->USERNAME)->get("SPERSON");
	if($sperson->num_rows())
	{
	$rec=$sperson->row();
	$spcode=$rec->BCODE;
	}
	$userData['SPCODE']=$spcode;
	}
	$this->session->set_userdata(array('project'=>'inayat','user'=>$userData));	
	return "true";
	}
	else{
	return "unauthorized";	
	}
	}
	else if($row->TYPE==0){
	$query=$this->db->query("SELECT BCODE,BNAME FROM BRANCH ORDER BY BNAME");	
	$branches=$query->result_array();
	$userData=array('U_ID'=>$row->USERNAME,'B_ID'=>1,'U_TYPE'=>$row->TYPE,'BRANCHES'=>$branches,'UB_ID'=>$row->B_ID);
	$this->session->set_userdata(array('project'=>'inayat','user'=>$userData));	
	return "true";
	}
	}
	else{
	return FALSE;	
	} 
	}
	public function branches(){
	$query=$this->db->query("SELECT BCODE,BNAME FROM BRANCH ORDER BY BNAME ASC");
	return $query->result_array();
	}
	
}
?>