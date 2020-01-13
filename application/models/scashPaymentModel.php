<?php
	class scashPaymentModel extends MY_Model{
		
	public function insert($data){
		
	$mainTable="SCASHPYM";
	$voucher_Jo="FCP";
	$gnrllgr="SGnrllgr";
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
	$descrip=$data['descrip_'.$row.''];
	$debit=removecommas($data['amount_'.$row.'']);
	$amt=$data['invAmt_'.$row.''];
	/* $invno=$data['invoices_'.$row.''];
	
	if(!empty($invno)){
	$bt=explode(",",$invno);
	$invno=$bt[0];
	} */
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$acode),"ANAME","");
	if(!empty($cnm)){
	$aname=$cnm[0]['ANAME'];	
	}
	else{
	$cnm=$this->getData("PARTY",array("VCODE"=>$acode),"VNAME","");
	$aname=$cnm[0]['VNAME'];
	}
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,CACODE,CANAME,ACODE,ANAME,DESCR,DEBIT,STATUS,U_ID,STATUS2,INVNO,INVAMT,B_ID,UNPOSTED,POSTED,APPROVED) 
	VALUES ('$no','$vdate','".$data['cacode']."','$caname','$acode','$aname','$descrip','$debit','1','".$this->userData['U_ID']."','1','0','$amt','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
	
	if($insertMain){
	if($data['rights']['UNPOSTED']==0){	
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) 
	VALUES ('$no','$vdate','$voucher_Jo','".$data['cacode']."','$descrip',0,$debit,'".$this->userData['B_ID']."')");
	
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,PNO)
	VALUES ('$no','$vdate','$voucher_Jo','$acode','$descrip',$debit,0,'".$this->userData['B_ID']."','0')");
	}
	}
		
	}
	}
	$row++;
	}
	
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VLOG(VDATE,U_ID,B_ID,NO,JO,TYPE)
	VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo','$post_type')");
	return true;	
	}
	
	}
?>