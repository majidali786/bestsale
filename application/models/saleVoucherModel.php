<?php
	class saleVoucherModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="SALE1";
	$mainTable2="SALE2";
	$voucher_Jo="SL";
	$gnrllgr="Gnrllgr";		
	$stock="STOCK";	
	$stock2="STOCK_DO";	
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
	$vno=$data['vno'];
	$this->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	$this->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	$this->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	$this->deleteData("$stock",array("JO"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	$this->deleteData("$stock2",array("JO"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
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

	$scode=$data['sacode'];
	$cbm=$this->getData("ACCOUNT",array("ACODE"=>$scode),"ANAME","");
	if(!empty($cbm)){
	$sname=$cbm[0]['ANAME'];		
	}
	
	$vno=$data['vno'];	
	$remarks=$data['remarks'];
	$total=removecommas($data['tamount']);
	$discount=removecommas($data['discount']);
	$freight=removecommas($data['freight']);
	$loading=removecommas($data['loading']);
	$others=removecommas($data['others']);
	$sono=$data['sordrno'];
	$dcno=$data['dcno'];
	$net=removecommas($data['net']);
	$kweight=$data['kweight'];
	$bno=$data['bno'];
	$bdate=$data['bdate'];
	if($bdate==""){
	$bdate=$vdate;	
	}
	else{
	$bdate=$this->dateFormat($bdate);
	}
	$transport=$data['transport'];
	$pbal=removecommas($data['previous']);
	$tbal=removecommas($data['total']);
	
	$st=array("Cash","Credit");
	$stype=$data['stype'];
	$stname=$st[$stype];
	
	
	if(empty($error)){
	$sms=$smsurdu=0;
	if(!empty($data['sms'])){
	$sms=1;	
	}
	if(!empty($data['smsurdu'])){
	$smsurdu=1;	
	}
	$pbal=$this->getBalance($vcode,false,false,false);
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,STYPE,STNAME,VCODE,VNAME,ADDR,DPCODE,DPNAME,SCODE,SNAME,VNO,REMARKS,TOTAL,DISCOUNT,FREIGHT,LOADING,OTHERS,NET,KWEIGHT,BNO,BDATE,TRANSPORT,PBAL,TBAL,DCNO,SONO,U_ID,B_ID,UNPOSTED,POSTED,APPROVED,SMS,USMS) VALUES ('$no','$vdate','$stype','$stname','$vcode','$vname','$addr','','','$scode','$sname','$vno','$remarks','$total','$discount','$freight','$loading','$others','$net','$kweight','$bno','$bdate','$transport','$pbal','$tbal','$dcno','$sono','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved',$sms,$smsurdu)");
	
	if($data['rights']['UNPOSTED']==0){	
	if($discount>0){
	
	$discountAccount="40103003";
	$discountDiscrip="Discount Charges $vname Invoice No.$no Book No.$vno";
	$abc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('$no','$vdate','$voucher_Jo','$discountAccount','$discountDiscrip',$discount,0,'".$this->userData['B_ID']."')");
	
	$abc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,SNO) VALUES ('$no','$vdate','$voucher_Jo','$vcode','Discount',0,$discount,'".$this->userData['B_ID']."','$no')");
	
	}
	if($freight>0){
	
	$freightAccount="40103004";
	$freightDiscrip="Frieght Charges $vname Invoice No.$no Book No.$vno";
	$abc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('$no','$vdate','$voucher_Jo','$freightAccount','$freightDiscrip',0,$freight,'".$this->userData['B_ID']."')");
	
	$abc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,SNO) VALUES ('$no','$vdate','$voucher_Jo','$vcode','Frieght Charges',$freight,0,'".$this->userData['B_ID']."','$no')");
	
	}
	if($loading>0){
	
	$loadingAccount="40102021";
	$loadingDiscrip="Loading Charges $vname Invoice No.$no Book No.$vno";
	$abc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('$no','$vdate','$voucher_Jo','$loadingAccount','$loadingDiscrip',0,$loading,'".$this->userData['B_ID']."')");
	
	$abc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,SNO) VALUES ('$no','$vdate','$voucher_Jo','$vcode','Loading Charges',$loading,0,'".$this->userData['B_ID']."','$no')");
	
	}
	if($others>0){
	
	$othersAccount="40102081";
	$othersDiscrip="Others Charges $vname Invoice No.$no Book No.$vno";
	$abc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('$no','$vdate','$voucher_Jo','$othersAccount','$othersDiscrip',0,$others,'".$this->userData['B_ID']."')");
	
	$abc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,SNO) VALUES ('$no','$vdate','$voucher_Jo','$vcode','Others Charges',$others,0,'".$this->userData['B_ID']."','$no')");
	
	}
	}
	
	$nrows=$data['nrows'];
	$row=1;
	$sno=1;
	if($insertMain){
	while($row<$nrows){
	if(!empty($data['pcode_'.$row.''])){
	if($data['amount_'.$row.'']>0 && $data['rate_'.$row.'']>0){

	$pcode=$data['pcode_'.$row.''];
	$unit=$data['unit_'.$row.''];
	$qty=removecommas($data['qty_'.$row.'']);
	$weight=removecommas($data['weight_'.$row.'']);
	$rate=removecommas($data['rate_'.$row.'']);
	$amount=removecommas($data['amount_'.$row.'']);

	
	$cnm=$this->getData("PRODUCT",array("PCODE"=>$pcode),"PNAME","");
	if(!empty($cnm)){
	$pname=$cnm[0]['PNAME'];	
	}
	
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,UNIT,WEIGHT,QTY,FEET,RATE,AMOUNT,SNO,VCODE,U_ID,B_ID) VALUES ('$no','$vdate','$pcode','$pname','$unit','$weight','$qty','0','$rate','$amount','$sno','$vcode','".$this->userData['U_ID']."','".$this->userData['B_ID']."')");
	
	if($insertRow){
	if($data['rights']['UNPOSTED']==0){	
	$descrip=$pname." Qty".$qty." ".$weight."Kg @".$rate;
	$gnrllgrSacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('$no','$vdate','$voucher_Jo','$scode','$descrip',0,$amount,'".$this->userData['B_ID']."')");
	
	$gnrllgrPacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,SNO) VALUES ('$no','$vdate','$voucher_Jo','$vcode','$descrip',$amount,0,'".$this->userData['B_ID']."','$no')");
	
	$asd = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,INWGHT,OUTWGHT,INQT,OUTQT,INAMT,OUTAMT,RATE,BATCH,POST,VCODE,B_ID) VALUES ('$no','$vdate','$voucher_Jo','$pcode','$descrip',0,$weight,0,$qty,0,$amount,$rate,'','','$vcode','".$this->userData['B_ID']."')");
	$stock_do= $this->db->query("INSERT INTO $stock2(NO,VDATE,JO,PCODE,DESCR,INWGHT,OUTWGHT,INQT,OUTQT,INFT,OUTFT,VCODE,B_ID) VALUES ('$no','$vdate','$voucher_Jo','$pcode','',0,$weight,0,$qty,0,0,'$vcode','".$this->userData['B_ID']."')");
	$check2=$this->query("SELECT PCODE,NO,VDATE FROM DO2 WHERE PCODE='$pcode' AND B_ID='".$this->userData['B_ID']."' AND VCODE='$vcode'");
	
	if(empty($check2)){
	$check3=$this->query("SELECT VCODE,NO,VDATE FROM DO1 WHERE VCODE='$vcode' AND B_ID='".$this->userData['B_ID']."'");	
	if(!empty($check3)){	
	$bt=$check3[0];
	$insertRow = $this->db->query("INSERT INTO DO2(NO,VDATE,PCODE,PNAME,UNIT,WEIGHT,QTY,FEET,SNO,VCODE,U_ID,B_ID) VALUES ('".$bt['NO']."','".$bt['VDATE']."','$pcode','$pname','$unit','$weight','$qty','0','$sno','$vcode','".$this->userData['U_ID']."','".$this->userData['B_ID']."')");	
	
	$stock_do= $this->db->query("INSERT INTO $stock2(NO,VDATE,JO,PCODE,DESCR,INWGHT,OUTWGHT,INQT,OUTQT,INFT,OUTFT,VCODE,B_ID) VALUES ('".$bt['NO']."','".$bt['VDATE']."','DO','$pcode','',$weight,0,$qty,0,0,0,'$vcode','".$this->userData['B_ID']."')");
	}
	}
	
	}
	}
	$sno++;	
	}
	}
	$row++;
	}
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VLOG(VDATE,U_ID,B_ID,NO,JO,TYPE) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo','$post_type')");
	
	
	if($data['rights']['UNPOSTED']==0){	
	$tbal=$pbal+$net;
	if(!empty($data['sms'])){
	$party=$this->getData("PARTY",array("VCODE"=>$vcode),"","");
	if(!empty($party)){
	$sms=1;
	$tqty=$data['tqty'];
	$message="Sales Invoice ".PHP_EOL." ".$data['vdate']." ".PHP_EOL." SL".$no." ".PHP_EOL." ".$vname."".PHP_EOL." T.QTY : ".$tqty." ".PHP_EOL."  P.B=".$pbal." ".PHP_EOL." CURRENT : ".$net." ".PHP_EOL." C.B=".$tbal.";";	
	if(!empty($party[0]['MOBILE'])){
	$to=$party[0]['MOBILE'];	
	$this->sendSms($to,$message);	
	}
	}
	}
	if(!empty($data['smsurdu'])){
	$party=$this->getData("PARTY",array("VCODE"=>$vcode),"","");
	if(!empty($party)){
	$smsurdu=1;
	$tqty=$data['tqty'];
	$message="سیلز انوائس ".PHP_EOL." ".$data['vdate']." ".PHP_EOL." SL.NO=".$no." ".PHP_EOL." ".$vname."".PHP_EOL." کل تعداد : ".$tqty." ".PHP_EOL."  پچھلا بقایا =".$pbal." ".PHP_EOL." موجودہ : ".$net." ".PHP_EOL." موجودہ بقایا =".$tbal.";";	
	if(!empty($party[0]['MOBILE'])){
	$to=$party[0]['MOBILE'];	
	$this->sendSms($to,$message);	
	}
	}
	}
	}
	
	
	
	return true;	
	}
	}
	else{
	return $error;	
	}
	
	}
	
	
	}
?>