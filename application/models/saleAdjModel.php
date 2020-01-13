<?php
	class saleAdjModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="SALEA1";
	$mainTable2="SALEA2";
	$voucher_Jo="SA";
	$gnrllgr="Gnrllgr";		
	$stock="STOCK";		
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
	$this->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	$this->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	//$this->deleteData("$stock",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
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

	$ono=$data['ono'];
	$vcode=$data['vcode'];
	$cnm=$this->getData("PARTY",array("VCODE"=>$vcode),"VNAME,ADDR","");
	if(!empty($cnm)){
	$vname=$cnm[0]['VNAME'];	
	$addr=$cnm[0]['ADDR'];	

	}

	
	$scode='50201001';
	$sname='ADJUSTMENT JOURNAL A/C';		
	
	$remarks=$data['remarks'];
	$totalA=removecommas($data['ttotal']);
	
	
	if(empty($error)){
	
	 $insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,VNO,VCODE,VNAME,ADDR,SCODE,SNAME,REMARKS,TOTAL,U_ID
	 ,B_ID,UNPOSTED,POSTED,APPROVED) VALUES ('$no','$vdate','$ono','$vcode','$vname','$addr','50201001','ADJUSTMENT JOURNAL A/C','$remarks','$totalA','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
	
	
	$nrows=$data['nrows'];
	$row=1;
	$sno=1;
	if($insertMain){
	while($row<$nrows){
	
	if($data['total_'.$row.'']>0){

	$desc=$data['desc_'.$row.''];
	$total=removecommas($data['total_'.$row.'']);
	


	
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,DESCR,TOTAL,U_ID,B_ID,SNO,VCODE) 
	VALUES ('$no','$vdate','$desc','$total','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$row','$vcode')");
	
	if($insertRow){
	if($data['rights']['UNPOSTED']==0){	
	//$descrip=$desc." Qty".$qty." @".$rate;
	$gnrllgrSacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,SNO,VNO) 
	VALUES ('$no','$vdate','$voucher_Jo','50201001','$desc',0,'$total','".$this->userData['B_ID']."','$row','$ono')");
	
	$gnrllgrPacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,SNO,VNO)
	VALUES ('$no','$vdate','$voucher_Jo','$vcode','$desc','$total',0,'".$this->userData['B_ID']."','$row','$ono')");
	
	
	}
	}
	$sno++;	
	}
	
	$row++;
	}
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VLOG(VDATE,U_ID,B_ID,NO,JO,TYPE)
	VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo','$post_type')");
	
	
	return true;	
	}
	}
	else{
	return $error;	
	}
	}
	
	
	}
?>