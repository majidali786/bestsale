<?php
	class BankPymModel extends MY_Model{		
	public function insert($data){
		
	$mainTable="CREDIT";
	$voucher_Jo="BP";
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
	else
	{		
	$no=$data['no'];
	$this->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	$this->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
   //$this->deleteData("$gnrllgrChq",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));		
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
	$chqno=$data['chqNo_'.$row.''];
	$chqdate=$this->dateFormat($data['chqDate_'.$row.'']);	
	$chqdate=$this->dateFormat($data['chqDate_'.$row.'']);
	$debit=removecommas($data['amount_'.$row.'']);

	
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$acode),"ANAME","");
	if(!empty($cnm)){
	$aname=$cnm[0]['ANAME'];	
	}
	else
	{
	$cnm=$this->getData("PARTY",array("VCODE"=>$acode),"VNAME","");	
	$aname=$cnm[0]['VNAME'];	
	}
	
	
	
	if(!empty($data['sms'])){
	$party=$this->getData("PARTY",array("VCODE"=>$acode),"","");
	if(!empty($party)){
	$prev=$this->getData("$gnrllgr",array("ACODE"=>$acode),"SUM(DEBIT-CREDIT) AS TDB","");
	$sms=1;
	$prebal=$prev[0]['TDB'];
	$totbal=$prebal-$debit;
	$message="Bank Receipt Voucher".PHP_EOL." ".$data['vdate']." ".PHP_EOL." C.R ".$no." ".PHP_EOL." ".$aname."".PHP_EOL."  P.B=".$prebal." ".PHP_EOL." Payment: ".$debit." ".PHP_EOL." Remaining Balance=".$totbal." ".PHP_EOL." If you feel any problem regard this then must contact with in 7 days 03214426383;";	
	if(!empty($party[0]['MOBILE'])){
	$to=$party[0]['MOBILE'];	
	$this->sendSms($to,$message);	
	}
	}
	}
	else{
	$sms=0;	
	}
	if(!empty($data['smsurdu'])){
	$party=$this->getData("PARTY",array("VCODE"=>$acode),"","");
	$smsurdu=1;
	if(!empty($party)){
	$prev=$this->getData("$gnrllgr",array("ACODE"=>$acode),"SUM(DEBIT-CREDIT) AS TDB","");
	$smsurdu=1;
	$prebal=$prev[0]['TDB'];
	$totbal=$prebal-$debit;
	$message="کیش ادائیگی ".PHP_EOL."C.R NO.".$no."".PHP_EOL."".$prebal." بقایا : ".PHP_EOL."".$debit." موصول : ".PHP_EOL."".$totbal." موجودہ : ".PHP_EOL."اگر کھاتہ میں کوئی فرق ہو تو 7 دنوں کے اندر اکاونٹ ڈیپارٹمنٹ سے رجوع کریں۔ شکریہ".PHP_EOL."0321-4426383";	
	if(!empty($party[0]['MOBILE'])){
	$to=$party[0]['MOBILE'];	
	$this->sendSms($to,$message);	
	}
	}
	}
	else{
	$smsurdu=0;	
	}

	 $insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,CACODE,CANAME,ACODE,ANAME,DESCR,DEBIT,CHQNO,CHQDATE,STATUS,U_ID,STATUS2,B_ID,UNPOSTED,POSTED,APPROVED,SMS,USMS,SNO) 
	 VALUES ('$no','$vdate','".$data['cacode']."','$caname','$acode','$aname','$descrip','$debit','$chqno','$chqdate','1','".$this->userData['U_ID']."','1','".$this->userData['B_ID']."','$unposted','$posted','$approved','$sms','$smsurdu','$row')");
	
	
	if($insertMain)
	{


	if($data['rights']['UNPOSTED']==0){	
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,CHQNO,CHQDATE,B_ID,SNO,FCODE,FNAME) 
	VALUES ('$no','$vdate','$voucher_Jo','".$data['cacode']."','$descrip',0,'$debit','$chqno','$chqdate','".$this->userData['B_ID']."','$row','$acode','$aname')");
	
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,CHQNO,CHQDATE,B_ID,SNO,FCODE,FNAME)
	VALUES ('$no','$vdate','$voucher_Jo','$acode','$descrip','$debit',0,'$chqno','$chqdate','".$this->userData['B_ID']."','$row','".$data['cacode']."','$caname')");
	
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