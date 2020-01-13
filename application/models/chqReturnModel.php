<?php
	class chqReturnModel extends MY_Model{
		
	public function insert($data){
	
	$mainTable="CHQRETURN";
	$voucher_Jo="CN";
	$gnrllgr="Gnrllgr_chq";
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
	$this->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
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
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$data['cacode']),"ANAME","");
	if(!empty($cnm)){
	$caname=$cnm[0]['ANAME'];	
	}
	$nrows=$data['nrows'];
	$row=1;
	while($row<$nrows){
	if(!empty($data['acode_'.$row.''])){
	if(removecommas($data['amount_'.$row.''])>0){
	
	$acode=$data['acode_'.$row.''];
	$bcode=$data['bcode_'.$row.''];
	$descrip=$data['descrip_'.$row.''];
	$debit=removecommas($data['amount_'.$row.'']);
	$chqno=$data['chqNo_'.$row.''];
	$chqdate=$data['chqDate_'.$row.''];
	$chqdate=$this->dateFormat($data['chqDate_'.$row.'']);
	
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$acode),"ANAME","");
	if(!empty($cnm)){
	$aname=$cnm[0]['ANAME'];	
	}
	
	$bmm=$this->getData("BANK",array("BCODE"=>$bcode),"BNAME","");
	if(!empty($cnm)){
	$bname=$bmm[0]['BNAME'];	
	}
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,CACODE,CANAME,ACODE,ANAME,DESCR,DEBIT,BCODE,BNAME,STATUS,U_ID,STATUS2,CHQNO,CHQDATE,B_ID,UNPOSTED,POSTED,APPROVED) VALUES ('$no','$vdate','".$data['cacode']."','$caname','$acode','$aname','$descrip','$debit','$bcode','$bname','1','".$this->userData['U_ID']."','1','$chqno','$chqdate','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
	
	if($insertMain){
	if($data['rights']['UNPOSTED']==0){	
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,CHQNO,CHQDATE,BCODE,BNAME) VALUES ('$no','$vdate','$voucher_Jo','".$data['cacode']."','$descrip','$debit',0,'".$this->userData['B_ID']."','$chqno','$chqdate','$bcode','$bname')");
	
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,CHQNO,CHQDATE,BCODE,BNAME) VALUES ('$no','$vdate','$voucher_Jo','$acode','$descrip',0,$debit,'".$this->userData['B_ID']."','$chqno','$chqdate','$bcode','$bname')");
	}
	}
		
	}
	}
	$row++;
	}
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VLOG(VDATE,U_ID,B_ID,NO,JO,TYPE) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo','$post_type')");
	return true;	
	}
	
	}
?>