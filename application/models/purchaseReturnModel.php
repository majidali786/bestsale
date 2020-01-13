<?php
	class purchaseReturnModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="PRET1";
	$mainTable2="PRET2";
	$voucher_Jo="PR";
	$gnrllgr="Gnrllgr";		
	$stock="STOCK";	
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
		
	}
	
	

	
	
    $vno=$data['vno'];
    $conversion=$data['conversion'];
    $addr=$data['address'];
	$remarks=$data['remarks'];
	$tqty=$data['tqty'];
	$tqty = str_replace(',','',$tqty);
	$tamount=$data['tamount'];
	$tamount = str_replace(',','',$tamount);
	$dtamount=$data['dtamount'];
	$dtamount = str_replace(',','',$dtamount);
	
	$gst=$data['gst'];		
	$gst = str_replace(',','',$gst);
	$gstamt=$data['gstamt'];
	$gstamt = str_replace(',','',$gstamt);
	$net=$data['net'];
	$net = str_replace(',','',$net);

	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,VCODE,VNAME,ADDR,REMARKS,VNO,CRATE,TQTY,TOTAL,CTOTAL,GST,GSTAMT,NET,U_ID,B_ID,UNPOSTED,POSTED,APPROVED) 
	VALUES ('$no','$vdate','$vcode','$vname','$addr','$remarks','$vno','$conversion','$tqty','$tamount','$tamount','$gst','$gstamt','$net','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
	
	if($gstamt>0)
	{
	//Discount ACCOUNT 
	$gnrllgrSaccd = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,FCODE,FNAME) 
	VALUES ('$no','$vdate','$voucher_Jo','40101002','$vname',0,'$gstamt','".$this->userData['B_ID']."','".$this->userData['U_ID']."','$vcode','$vname')");
	
	//PARTY Credit
	$gnrllgrPacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,FCODE,FNAME) 
	VALUES ('$no','$vdate','$voucher_Jo','$vcode','PURCHASE DISCOUNT','$gstamt',0,'".$this->userData['B_ID']."','".$this->userData['U_ID']."','40101002','PURCHASE DISCOUNT')");
	
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
	$qty=$data['qty_'.$row.''];
	$qty = str_replace(',','',$qty);
	$rate=$data['rate_'.$row.''];
	$rate = str_replace(',','',$rate);
	$amount=$data['amount_'.$row.''];
	$amount = str_replace(',','',$amount);
    $drate=$data['drate_'.$row.''];
	$drate = str_replace(',','',$drate);
	$damount=$data['damount_'.$row.''];
	$damount = str_replace(',','',$damount);
	
	$cnm=$this->getData("PRODUCT",array("PCODE"=>$pcode),"PNAME","");
	if(!empty($cnm)){
	$pname=$cnm[0]['PNAME'];	
	}
	
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,UNIT,QTY,RATE,AMOUNT,FRATE,FAMOUNT,SNO,VCODE,U_ID,B_ID)
	VALUES ('$no','$vdate','$pcode','$pname','$unit','$qty','$drate','$damount','$rate','$amount','$sno','$vcode','".$this->userData['U_ID']."','".$this->userData['B_ID']."')");
	
	
	if($insertRow){
	if($data['rights']['UNPOSTED']==0){	
	$descrip=$pname." Qty".$qty."Foreign exchange rate @ ".$rate."";
	//PURCHASE ACCOUNT Debit
	$gnrllgrSacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,SNO,FCODE,FNAME) 
	VALUES ('$no','$vdate','$voucher_Jo','40102001','$descrip',0,'$damount','".$this->userData['B_ID']."','".$this->userData['U_ID']."','$sno','$vcode','$vname')");
	//PARTY Credit
	$gnrllgrPacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,SNO,FCODE,FNAME) 
	VALUES ('$no','$vdate','$voucher_Jo','$vcode','$descrip','$damount',0,'".$this->userData['B_ID']."','".$this->userData['U_ID']."','$sno','40101001','PURCHASE A/C')");
	
	
	$asd = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,INQT,OUTQT,INAMT,OUTAMT,VCODE,B_ID,RATE,UNIT,VNO) 
	VALUES ('$no','$vdate','$voucher_Jo','$pcode','$descrip',0,'$qty',0,'$damount','$vcode','".$this->userData['B_ID']."','$rate','$unit','$vno')");
	
	}
	}
	$sno++;	
	}
	}
	$row++;
	}
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VLOG(VDATE,U_ID,B_ID,NO,JO,TYPE) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo','$post_type')");
	return true;	
	}
	}
	
	}
?>