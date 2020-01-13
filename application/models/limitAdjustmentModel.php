<?php
	class limitAdjustmentModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="LIMITADJ";
	$mainTable2="";
	$voucher_Jo="LAD";		
	$stock="";
	$post_type;	
	$error="";
	if($data['action']=="save"){	
	$no=$data['no'];	
	$max = $this->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	if($data['no']>$max || $data['no']<=0){
	$no=$max;	
	}
	$check1=$this->getData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($check1)){
	$max = $this->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$no=$max;	
	}
	}
	else{
	$no=$data['no'];
	$this->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	}
	
	if(!empty($data['rights'])){
	if($data['rights']['UNPOSTED']==1){
	$unposted=$this->userData['U_ID'];	
	$posted="";	
	$approved="";		
	$post_type=1;		
	}
	else if($data['rights']['POSTED']==1){
	$unposted="";	
	$posted=$this->userData['U_ID'];	
	$approved="";	
	$post_type=2;	
	}
	else if($data['rights']['APPROVED']==1){
	$unposted="";	
	$posted=$this->userData['U_ID'];	
	$approved=$this->userData['U_ID'];
	$post_type=3;	
	}
	else{
	$unposted=$this->userData['U_ID'];	
	$posted="";	
	$approved="";
	$post_type=1;	
	}	
	}
	else{
	$unposted=$this->userData['U_ID'];	
	$posted="";	
	$approved="";			
	$post_type=1;
	}
	
	$vdate=$this->dateFormat($data['vdate']);
	$vcode=$data['vcode'];
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$vcode),"ANAME","");
	if(!empty($cnm)){
	$vname=$cnm[0]['ANAME'];	
	$addr="None";	
	}
	
	$remarks=$data['remarks'];
	$climit=$data['climit'];
	$elimit=$data['elimit'];
	if(empty($error)){
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,VCODE,VNAME,REMARKS,U_ID,B_ID,UNPOSTED,POSTED,APPROVED,CLIMIT,ELIMIT) VALUES ('$no','$vdate','$vcode','$vname','$remarks','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved','$climit','$elimit')");
	return true;	
	
	}
	else{
	return $error;	
	}	}
	
	}
?>