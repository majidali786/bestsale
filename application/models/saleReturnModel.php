<?php
	class saleReturnModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="SRET1";
	$mainTable2="SRET2";
	$voucher_Jo="SR";		
	$stock="STOCK";
	$gnrllgr="Gnrllgr";		
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
	$this->deleteData("$stock",array("JO"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
		
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
	$cnm=$this->getData("PARTY",array("VCODE"=>$vcode),"VNAME","");
	if(!empty($cnm)){
	$vname=$cnm[0]['VNAME'];	
	$addr="";	
	}

	$scode=$data['sacode'];
	$cbm=$this->getData("ACCOUNT",array("ACODE"=>$scode),"ANAME","");
	if(!empty($cbm)){
	$sname=$cbm[0]['ANAME'];		
	}
	
/* 	$st=array("Cash","Credit");
	$stype=$data['stype'];
	$stname=$st[$stype]; */
	
	$vno=$data['vno'];
	$remarks=$data['remarks'];
	
	$std='0';
	if(!empty($data['sms']))
	{
	$std='1';
	$stdnm='Included Tax';
	}
	else
	{
	$std='0';
	$stdnm='Excluded Tax';
	}
	
	$wsale='0';
	if(!empty($data['sms2']))
	{
	$wsale='1';
	$wholes='Wholes Sales';
	}
	else
	{
	$wsale='0';
	$wholes='None Whole Sales';
	}
	
	
	$tqty=$data['tqty'];
	$tqty = str_replace(',','',$tqty);
	$tamount=$data['tamount'];
	$tamount = str_replace(',','',$tamount);
	$gst=$data['gst'];		
	$gst = str_replace(',','',$gst);
	$gstamt=$data['gstamt'];
	$gstamt = str_replace(',','',$gstamt);
	$net=$data['net'];
	$net = str_replace(',','',$net);

	
	
	if(empty($error)){
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,STYPE,STNAME,VCODE,VNAME,ADDR,SCODE,SNAME,REMARKS,VNO,TQTY,TOTAL,
	GST,GSTAMT,NET,TAX,WHOLES,U_ID,B_ID,UNPOSTED,POSTED,APPROVED) 
	VALUES ('$no','$vdate','0','','$vcode','$vname','$addr','$scode','$sname','$remarks','$vno','$tqty','$tamount'
	,'$gst','$gstamt','$net','$std','$wsale','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
	
	
	
	$nrows=$data['nrows'];
	$row=1;
	$sno=1;
	if($insertMain){
	while($row<$nrows){
	if(!empty($data['pcode_'.$row.''])){
	if($data['amount_'.$row.'']>0 && $data['rate_'.$row.'']>0){

	$pcode=$data['pcode_'.$row.''];
	$unit=$data['unit_'.$row.''];
	$qty=$data['qty_'.$row.''];
	$qty = str_replace(',','',$qty);
	$rate=$data['rate_'.$row.''];
	$rate = str_replace(',','',$rate);
	$amount=$data['amount_'.$row.''];
	$amount = str_replace(',','',$amount);
	
	
	
	$cnm=$this->getData("PRODUCT",array("PCODE"=>$pcode),"PNAME","");
	if(!empty($cnm)){
	$pname=$cnm[0]['PNAME'];	
	}
	
	// for whole sales
	//if(!empty($data['sms2']))
	//{
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,UNIT,QTY,RATE,AMOUNT,SNO,VCODE,U_ID,B_ID) 
	VALUES ('$no','$vdate','$pcode','$pname','$unit','$qty','$rate','$amount','$sno','$vcode','".$this->userData['U_ID']."','".$this->userData['B_ID']."')");
	
	$descrip=$pname." Qty".$qty."@".$rate;

	//SAELS ACCOUNT CREDIT
	$gnrllgrSacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,SNO,FCODE,FNAME,VNO) 
	VALUES ('$no','$vdate','$voucher_Jo','$scode','$descrip',0,'$amount','".$this->userData['B_ID']."','".$this->userData['U_ID']."'
	,'$sno','$vcode','$vname','$vno')");
	//PARTY DEBIT
	$gnrllgrPacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,SNO,FCODE,FNAME,VNO) 
	VALUES ('$no','$vdate','$voucher_Jo','$vcode','$descrip','$amount',0,'".$this->userData['B_ID']."','".$this->userData['U_ID']."'
	,'$sno','$scode','$sname','$vno')");
	//}
	
/* 	else{
		
	
	// vat tax 
	if(!empty($data['sms']))
	{
	$gstper=5;
	$gst2=$amount/105*$gstper;
	$net3=$amount-$gst2;
	
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,UNIT,QTY,RATE,AMOUNT,GST,GSTPER,NET,SNO,VCODE,U_ID,B_ID) 
	VALUES ('$no','$vdate','$pcode','$pname','$unit','$qty','$rate','$amount','$gst2','$gstper','$net3','$sno','$vcode','".$this->userData['U_ID']."','".$this->userData['B_ID']."')");
	
	$descrip=$pname." Qty".$qty."@".$rate;

	//SAELS ACCOUNT CREDIT
	$gnrllgrSacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,SNO,FCODE,FNAME,VNO) 
	VALUES ('$no','$vdate','$voucher_Jo','$scode','$descrip','$net3',0,'".$this->userData['B_ID']."','".$this->userData['U_ID']."'
	,'$sno','$vcode','$vname','$vno')");
	//PARTY DEBIT
	$gnrllgrPacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,SNO,FCODE,FNAME,VNO) 
	VALUES ('$no','$vdate','$voucher_Jo','$vcode','$descrip',0,'$net3','".$this->userData['B_ID']."','".$this->userData['U_ID']."'
	,'$sno','$scode','$sname','$vno')");
	
	//SAELS TAX 
	$gnrllgrSacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,SNO,FCODE,FNAME,VNO) 
	VALUES ('$no','$vdate','$voucher_Jo','20102001','$descrip','$gst2','0','".$this->userData['B_ID']."','".$this->userData['U_ID']."'
	,'$sno','$vcode','$vname','$vno')");
	//PARTY DEBIT
	$gnrllgrPacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,SNO,FCODE,FNAME,VNO) 
	VALUES ('$no','$vdate','$voucher_Jo','$vcode','VAT TAX @5%','0','$gst2','".$this->userData['B_ID']."','".$this->userData['U_ID']."'
	,'$sno','$scode','$sname','$vno')");
	
	
	}
	else
	{
	$gstper=5;
	$gst2=$amount/100*$gstper;
	$net3=$amount-$gst2;
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,UNIT,QTY,RATE,AMOUNT,GST,GSTPER,NET,SNO,VCODE,U_ID,B_ID) 
	VALUES ('$no','$vdate','$pcode','$pname','$unit','$qty','$rate','$amount','$gst2','$gstper','$net3','$sno','$vcode','".$this->userData['U_ID']."','".$this->userData['B_ID']."')");
	
	$descrip=$pname." Qty".$qty."@".$rate;
	

	//SAELS ACCOUNT CREDIT
	$gnrllgrSacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,SNO,FCODE,FNAME,VNO) 
	VALUES ('$no','$vdate','$voucher_Jo','$scode','$descrip','$net3',0,'".$this->userData['B_ID']."','".$this->userData['U_ID']."'
	,'$sno','$vcode','$vname','$vno')");
	//PARTY DEBIT
	$gnrllgrPacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,SNO,FCODE,FNAME,VNO) 
	VALUES ('$no','$vdate','$voucher_Jo','$vcode','$descrip',0,'$net3','".$this->userData['B_ID']."','".$this->userData['U_ID']."'
	,'$sno','$scode','$sname','$vno')");
	
	
	//SAELS TAX 
	$gnrllgrSacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,SNO,FCODE,FNAME,VNO) 
	VALUES ('$no','$vdate','$voucher_Jo','20102001','$descrip','$gst2','0','".$this->userData['B_ID']."','".$this->userData['U_ID']."'
	,'$sno','$vcode','$vname','$vno')");
	//PARTY DEBIT
	$gnrllgrPacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,SNO,FCODE,FNAME,VNO) 
	VALUES ('$no','$vdate','$voucher_Jo','$vcode','VAT TAX @5%','0','$gst2','".$this->userData['B_ID']."','".$this->userData['U_ID']."'
	,'$sno','$scode','$sname','$vno')");
	
	
	}
	} */
	
	$asd = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,INQT,OUTQT,VCODE,B_ID,RATE,UNIT,VNO,U_ID) 
	VALUES ('$no','$vdate','$voucher_Jo','$pcode','$descrip','$qty',0,'$vcode','".$this->userData['B_ID']."','$rate','$unit','$vno','".$this->userData['U_ID']."')");
	
	

	
	$sno++;	
	}
	}
	$row++;
	}
	if($gstamt>0)
	{
	//Discount ACCOUNT 
	$gnrllgrSaccd = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,FCODE,FNAME,VNO) 
	VALUES ('$no','$vdate','$voucher_Jo','30201001','$vname','$gstamt',0,'".$this->userData['B_ID']."','".$this->userData['U_ID']."'
	,'$vcode','$vname','$vno')");
	
	//PARTY DEBIT
	$gnrllgrPacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,FCODE,FNAME,VNO) 
	VALUES ('$no','$vdate','$voucher_Jo','$vcode','SALES DISCOUNT',0,'$gstamt','".$this->userData['B_ID']."'
	,'".$this->userData['U_ID']."','30201001','SALES DISCOUNT','$vno')");
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