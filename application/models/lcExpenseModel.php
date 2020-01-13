<?php
	class lcExpenseModel extends MY_Model{
		
	public function insert($data){
		
	$mainTable="LCEXPENSE";
	$voucher_Jo="LE";
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
	$tdate=$this->dateFormat($data['tdate']);
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$data['cacode']),"ANAME","");
	if(!empty($cnm)){
	$caname=$cnm[0]['ANAME'];	
	}
	$lclid=$data['lclocation'];
	$cnm=$this->getData("LCLOCATION",array("ID"=>$lclid),"LCLOCATION","");
	if(!empty($cnm)){
	$location=$cnm[0]['LCLOCATION'];	
	}
	$nrows=$data['nrows'];
	$row=1;
	while($row<$nrows){
	if(!empty($data['acode_'.$row.''])){
	if(removecommas($data['amount_'.$row.''])>0){

	$lccode=$data['lcid_'.$row.''];
	$cnm=$this->getData("LCACCOUNT",array("ID"=>$lccode),"LCACCOUNT","");
	if(!empty($cnm)){
	$lcname=$cnm[0]['LCACCOUNT'];	
	}
	$lcno=$data['acode_'.$row.''];
	$crm=$this->getData("LC1",array("LCNO"=>$lcno),"LCCODE","");
	if(!empty($crm)){
	$acode=$crm[0]['LCCODE'];	
	}
	$descrip=$data['descrip_'.$row.''];
	$debit=removecommas($data['amount_'.$row.'']);

	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$acode),"ANAME","");
	if(!empty($cnm)){
	$aname=$cnm[0]['ANAME'];	
	}
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,TDATE,LCLID,LOCATION,CACODE,CANAME,LCNO,ACODE,ANAME,LCCODE,LCNAME,DESCR,DEBIT,U_ID,B_ID,UNPOSTED,POSTED,APPROVED) VALUES ('$no','$vdate','$tdate','$lclid','$location','".$data['cacode']."','$caname','$lcno','$acode','$aname','$lccode','$lcname','$descrip','$debit','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
	
	if($insertMain){
	if($data['rights']['UNPOSTED']==0){	
	$descrip=$descrip." @ ".$lcname;
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,JO,ACode,Descr,Debit,Credit,PDate,FCODE,FNAME,B_ID,BCODE,BNAME) VALUES ('$no','$vdate','$voucher_Jo','".$data['cacode']."','$descrip',0,$debit,'$tdate','$lclid','$location','".$this->userData['B_ID']."','".$data['cacode']."','$caname')");
	
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,JO,ACode,Descr,Debit,Credit,PDate,FCODE,FNAME,B_ID,LCNO) VALUES ('$no','$vdate','$voucher_Jo','$acode','$descrip',$debit,0,'$tdate','$lclid','$location','".$this->userData['B_ID']."','$lcno')");
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