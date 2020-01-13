<?php
	class MemoModel extends MY_Model{
		
	public function insertServices($data)
	{
	$max = $this->getMax("SERVICES","ID","");
	$run = $this->db->query("INSERT INTO SERVICES(ID,SERVICES) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateServices($data)
	{
	$run = $this->db->query("UPDATE SERVICES SET SERVICES='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	}
?>