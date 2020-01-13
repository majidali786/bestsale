<?php
	class chqBookModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="CHQBOOK";
	$voucher_Jo="CB";
	$gnrllgr="Gnrllgr_cb";
	$post_type;	
	
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
	$this->deleteData("$gnrllgr",array("NO"=>$no,"B_ID"=>$this->userData['B_ID'],"Jo"=>$voucher_Jo));	
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
	
	$startat=$data['starting'];
	$bno=$data['bno'];
	$bcode=$data['bank'];
	$bmm=$this->getData("BANK",array("BCODE"=>$bcode),"BNAME","");
	if(!empty($bmm)){
	$bank=$bmm[0]['BNAME'];	
	}
	$endat=$data['ending'];

	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,BCODE,BANK,BNO,STARTAT,ENDAT,U_ID,B_ID,STATUS) VALUES ('$no','$vdate','$bcode','$bank','$bno','$startat','$endat','".$this->userData['U_ID']."','".$this->userData['B_ID']."','1')");
	
	while($startat<=$endat){	
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,Debit,Credit,B_ID,CHQNO,BCODE,BNAME,BNO) VALUES ('$no','$vdate','$voucher_Jo',1,0,'".$this->userData['B_ID']."','$startat','$bcode','$bank','$bno')");
	$startat++;	
	}
	
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VLOG(VDATE,U_ID,B_ID,NO,JO,TYPE) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo','$post_type')");
	return true;	
	}
	}
	
?>