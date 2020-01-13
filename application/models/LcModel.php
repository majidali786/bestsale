<?php
	class LcModel extends MY_Model{
		
	public function insertLcAccount($data)
	{
	$max = $this->getMax("LCACCOUNT","ID","");
	$run = $this->db->query("INSERT INTO LCACCOUNT(ID,LCACCOUNT) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateLcAccount($data)
	{
	$run = $this->db->query("UPDATE LCACCOUNT SET LCACCOUNT='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	public function insertIndentor($data)
	{
	$max = $this->getMax("INDENTOR","ID","");
	$run = $this->db->query("INSERT INTO INDENTOR(ID,INDENTOR) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateIndentor($data)
	{
	$run = $this->db->query("UPDATE INDENTOR SET INDENTOR='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	public function insertLcLocation($data)
	{
	$max = $this->getMax("LCLOCATION","ID","");
	$run = $this->db->query("INSERT INTO LCLOCATION(ID,LCLOCATION) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateLcLocation($data)
	{
	$run = $this->db->query("UPDATE LCLOCATION SET LCLOCATION='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	public function insertLcBond($data)
	{
	$max = $this->getMax("LCBOND","ID","");
	$run = $this->db->query("INSERT INTO LCBOND(ID,LCBOND) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateLcBond($data)
	{
	$run = $this->db->query("UPDATE LCBOND SET LCBOND='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	
	}
?>