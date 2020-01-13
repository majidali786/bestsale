<?php
	class cashRecieptModel extends MY_Model{
		
	public function insert($data){
		
	$mainTable="CASHRCP";
	$voucher_Jo="CR";
	$gnrllgr="Gnrllgr";
	
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
	$tot=$data['tamount'];
	$nrows=$data['nrows'];
	$row=1;
	
	$crow=1;
	$acod='';
	$chksms=0;
	while($crow<$nrows){
	if(!empty($data['acode_'.$crow.''])){
	if($acod==''){
	$acod=$data['acode_'.$crow.''];
	}
	if($acod==$data['acode_'.$crow.''])
	{
		$chksms=1;
	}	else {
		$chksms=0;
	}
	}
	$crow++;
	}
	
	while($row<$nrows){
	if(!empty($data['pcode_'.$row.''])){
	if(removecommas($data['amount_'.$row.''])>0){

	//$acode=$data['acode_'.$row.''];
	$pcode=$data['pcode_'.$row.''];
	$descrip=$data['descrip_'.$row.''];
	$debit=removecommas($data['amount_'.$row.'']);
	//$invno=$data['invoices_'.$row.''];
	$amt=$data['invAmt_'.$row.''];
	$aname=$data['apname_'.$row.''];
	
	$pnm=$this->getData("SALESPAY",array("INVNO"=>$pcode),"INVNO","");
	if(!empty($pnm)){
	$invno=$pnm[0]['INVNO'];	
	}
	

	$cnm=$this->getData("ACCOUNT",array("ANAME"=>$aname),"ACODE","");
	if(!empty($cnm)){
	$acode=$cnm[0]['ACODE'];	
	}
	else
	{
	$cnm=$this->getData("PARTY",array("ANAME"=>$aname),"VNAME","");	
	$acode=$cnm[0]['VCODE'];	
	}
	
	
	
	

	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,CACODE,CANAME,ACODE,ANAME,DESCR,DEBIT,STATUS,U_ID,STATUS2,INVNO
	,AMT,B_ID,UNPOSTED,POSTED,APPROVED,SMS,USMS) 
	VALUES ('$no','$vdate','".$data['cacode']."','$caname','$acode','$aname','$descrip','$debit','1'
	,'".$this->userData['U_ID']."','1','$invno','$amt','".$this->userData['B_ID']."','$unposted','$posted','$approved','0','0')");
	
//if($insertMain){
	//if($data['rights']['UNPOSTED']==0){	
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,VNO,SNO,U_ID) 
	VALUES ('$no','$vdate','$voucher_Jo','".$data['cacode']."','$descrip','$debit',0,'".$this->userData['B_ID']."','$invno','$row','".$this->userData['U_ID']."')");
	
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,VNO,SNO,U_ID)
	VALUES ('$no','$vdate','$voucher_Jo','$acode','$descrip',0,'$debit','".$this->userData['B_ID']."','$invno','$row','".$this->userData['U_ID']."')");

	
	//}
	//}
		
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