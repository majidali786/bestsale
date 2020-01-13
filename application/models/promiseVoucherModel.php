<?php
	class promiseVoucherModel extends MY_Model{
		
	public function insert($data){
		
	$mainTable="PROMISE";
	$voucher_Jo="PM";
	$gnrllgr="Gnrllgr_promise";		
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
	$this->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","PNO"=>$no,"B_ID"=>$this->userData['B_ID']));	
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
	if(!empty($data['acode'])){
	if(removecommas($data['amount'])>0){

	$acode=$data['acode'];
	$descrip=$data['descrip'];
	$amount=removecommas($data['amount']);
	$pdate=$data['pdate'];
	$pdate=$this->dateFormat($data['pdate']);
	$pmdate=$data['pmdate'];
	$pmdate=$this->dateFormat($data['pmdate']);
	
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$acode),"ANAME","");
	if(!empty($cnm)){
	$aname=$cnm[0]['ANAME'];	
	}
	

	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,ACODE,ANAME,DESCR,AMOUNT,PMDATE,PDATE,U_ID,B_ID,UNPOSTED,POSTED,APPROVED,STATUS) VALUES ('$no','$vdate','$acode','$aname','$descrip','$amount','$pmdate','$pdate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved',1)");
	
	if($insertMain){
	if($data['rights']['UNPOSTED']==0){	
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(NO,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,PMDATE,PDATE,PNO,SNO,PAMOUNT) VALUES($no,'$vdate','$voucher_Jo','$acode','$descrip',$amount,0,'".$this->userData['B_ID']."','$pmdate','$pdate','$no',0,$amount)");
	}
	}
		
	}
	}
	
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VLOG(VDATE,U_ID,B_ID,NO,JO,TYPE) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo','$post_type')");
	
	return true;	
	}
	
	}
?>