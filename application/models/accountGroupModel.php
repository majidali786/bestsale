<?php
	class accountGroupModel extends MY_Model{
		
	public function insert($data){
		
	$mainTable="ACGROUP";
	$post_type;	
		
	if($data['action']=="save"){	
	$no=$data['no'];	
	$max = $this->getMax("$mainTable","NO","");
	if($data['no']>$max || $data['no']<=0){
	$no=$max;	
	}
	$check1=$this->getData("$mainTable",array("NO"=>$no),"","");
	if(!empty($check1)){
	$max = $this->getMax("$mainTable","NO","");
	$no=$max;	
	}
	}
	else{
	$no=$data['no'];
	$this->deleteData("$mainTable",array("NO"=>$no));		
	}
	
	
	
	
	$vdate=$this->dateFormat($data['vdate']);
	$cnm=$this->getData("PGROUP",array("PGRP"=>$data['agrp']),"PGNAME","");
	if(!empty($cnm)){
	$agroup=$cnm[0]['PGNAME'];	
	}
	$nrows=$data['nrows'];
	$row=1;
	while($row<$nrows){
	if(!empty($data['acode_'.$row.''])){

	$acode=$data['acode_'.$row.''];
	
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$acode),"ANAME","");
	if(!empty($cnm)){
	$aname=$cnm[0]['ANAME'];	
	}
	if(!empty($rchqno)){
	$bt=explode(",",$rchqno);
	$rchqno=$bt[0];
	}
	$insertMain=$this->db->query("INSERT INTO $mainTable(NO,VDATE,AGRP,AGROUP,ACODE,ANAME) VALUES ('$no','$vdate','".$data['agrp']."','$agroup','$acode','$aname')");	
	}
	$row++;
	}
	return true;	
	}
	
	}
?>