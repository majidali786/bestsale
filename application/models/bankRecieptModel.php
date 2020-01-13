<?php
	class bankRecieptModel extends MY_Model{
		
	public function insert($data){
	
	$mainTable="DEBIT";
	$voucher_Jo="BR";
	$gnrllgr="Gnrllgr";
	$gnrllgrChq="Gnrllgr_chq";
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
	$this->deleteData("$gnrllgrChq",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
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
	$invno=$data['invoices_'.$row.''];
	$rchqno=$data['refChqNo_'.$row.''];
	$amt=$data['invAmt_'.$row.''];
	$refchqamt=$data['refChqAmt_'.$row.''];
	
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
	if(!empty($rchqno)){
	$bt=explode(",",$rchqno);
	$rchqno=$bt[0];
	}
	if(!empty($invno)){
	$bt=explode(",",$invno);
	$invno=$bt[0];
	}
	
	if(!empty($data['sms'])){
	$party=$this->getData("PARTY",array("VCODE"=>$acode),"","");
	$sms=1;
	if(!empty($party)){
	$prev=$this->getData("$gnrllgr",array("ACODE"=>$acode),"SUM(DEBIT-CREDIT) AS TDB","");
	$sms=1;
	$prebal=$prev[0]['TDB'];
	$totbal=$prebal-$debit;
	$message="Bank Receipt Voucher".PHP_EOL." ".$data['vdate']." ".PHP_EOL." B.R".$no." ".PHP_EOL." ".$aname." ".PHP_EOL."  Bank:".PHP_EOL." ".$bname." ".PHP_EOL."  P.B=".$prebal." ".PHP_EOL." Received: ".$debit." ".PHP_EOL." Remaining Balance=".$totbal." ".PHP_EOL." If you feel any problem regard this then must contact with in 7 days 03208400171;";	
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
	$message="بینک رسید".PHP_EOL."B.R NO.".$no."".PHP_EOL."".$prebal." بقایا : ".PHP_EOL."".$debit." موصول : ".PHP_EOL."".$totbal." موجودہ : ".PHP_EOL."اگر کھاتہ میں کوئی فرق ہو تو 7 دنوں کے اندر اکاونٹ ڈیپارٹمنٹ سے رجوع کریں۔ شکریہ".PHP_EOL."0320-8400171";	
	if(!empty($party[0]['MOBILE'])){
	$to=$party[0]['MOBILE'];	
	$this->sendSms($to,$message);	
	}
	}
	}
	else{
	$smsurdu=0;	
	}
	
	if(!empty($data['smsurdu'])){
	$party=$this->getData("PARTY",array("VCODE"=>$acode),"","");
	if(!empty($party)){
	$prev=$this->getData("$gnrllgr",array("ACODE"=>$acode),"SUM(DEBIT-CREDIT) AS TDB","");
	$smsurdu=1;
	$prebal=$prev[0]['TDB'];
	$totbal=$prebal-$debit;
	$message="کیش رسید واؤچر ".PHP_EOL." ".$data['vdate']." ".PHP_EOL." C.R NO.".$no." ".PHP_EOL." ".$aname."".PHP_EOL."  پچھلا بقایا =".$prebal." ".PHP_EOL." موصول ہوا : ".$debit." ".PHP_EOL." موجودہ بقایا =".$totbal." ".PHP_EOL."  اگر آپ کو اس کے ساتھ کوئی مسئلہ محسوس ہوتا ہے تو 7 دنوں میں رابطہ کرنا ہوگا۔ 03208400171";	
	if(!empty($party[0]['MOBILE'])){
	$to=$party[0]['MOBILE'];	
	$this->sendSms($to,$message);	
	}
	}
	}
	else{
	$smsurdu=0;	
	}
	
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,CACODE,CANAME,ACODE,ANAME,DESCR,DEBIT,BCODE,BNAME,STATUS,U_ID,STATUS2,INVNO,RCHQNO,INVAMT,RCHQAMT,CHQNO,CHQDATE,B_ID,UNPOSTED,POSTED,APPROVED,SMS,USMS) VALUES ('$no','$vdate','".$data['cacode']."','$caname','$acode','$aname','$descrip','$debit','$bcode','$bname','1','".$this->userData['U_ID']."','1','$invno','$rchqno','$amt','$refchqamt','$chqno','$chqdate','".$this->userData['B_ID']."','$unposted','$posted','$approved',$sms,$smsurdu)");
	
	if($insertMain){
	if($data['rights']['UNPOSTED']==0){	
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,CHQNO,CHQDATE,BCODE,BNAME,RCHQNO) VALUES ('$no','$vdate','$voucher_Jo','".$data['cacode']."','$descrip','$debit',0,'".$this->userData['B_ID']."','$chqno','$chqdate','$bcode','$bname','$rchqno')");
	
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,CHQNO,CHQDATE,BCODE,BNAME,RCHQNO,SNO) VALUES ('$no','$vdate','$voucher_Jo','$acode','$descrip',0,$debit,'".$this->userData['B_ID']."','$chqno','$chqdate','$bcode','$bname','$rchqno','$invno')");
	
	if(!empty($rchqno)){
	$gnrllgrSec = $this->db->query("INSERT INTO $gnrllgrChq(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,CHQNO) VALUES ('$no','$vdate','$voucher_Jo','$acode','$descrip',$debit,0,'".$this->userData['B_ID']."','$rchqno')");	
	}
	
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