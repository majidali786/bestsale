<?php
	class purchaseOrderModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="PORDR1";
	$mainTable2="PORDR2";
	$voucher_Jo="PO";	
    $gnrllgr="SGnrllgr";	
	$stock="STOCK_SORDR";
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
	$bdate=$this->dateFormat($data['bdate']);
	$vcode=$data['vcode'];
	$cnm=$this->getData("PARTY",array("VCODE"=>$vcode),"VNAME,ADDR","");
	if(!empty($cnm)){
	$vname=$cnm[0]['VNAME'];	
	$addr=$cnm[0]['ADDR'];	
	}


	
	$vno=$data['vno'];
	$remarks=$data['remarks'];
	$crdays=$data['crdays'];
	$bno=$data['bno'];
	$transport=$data['transport'];

	$discount1=$data['discount'];
	$discount = str_replace(',','',$discount1);
	$previous1=$data['previous'];
	$previous = str_replace(',','',$previous1);

    $current1=$data['current'];
	$current = str_replace(',','',$current1);
	
	$total1=$data['net'];
	$total = str_replace(',','',$total1);
	
	$tqty=$data['tqty'];
	$tqty = str_replace(',','',$tqty);

	
	if(empty($error)){
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,VCODE,VNAME,ADDR,REMARKS,CRDAYS
	, VNO, BNO, BDATE, TRANSPORT, DISCOUNT, PBAL, CBAL,TQTY,TOTAL,U_ID,B_ID,UNPOSTED,POSTED,APPROVED) 
	VALUES ('$no','$vdate','$vcode','$vname','$addr','$remarks','$crdays','$vno','$bno','$bdate','$transport','$discount'
	,'$previous','$current','$tqty','$total','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
	
	$nrows=$data['nrows'];
	$row=1;
	$sno=1;
	if($insertMain){
	while($row<$nrows){
	if(!empty($data['pcode_'.$row.''])){
	
	$pcode=$data['pcode_'.$row.''];
	$color=$data['color_'.$row.''];
    $qty=$data['qty_'.$row.''];
	$qty = str_replace(',','',$qty);
	$rate=$data['rate_'.$row.''];
	$rate = str_replace(',','',$rate);
	$amount=$data['amount_'.$row.''];
	$amount = str_replace(',','',$amount);
	
	
	$cnm=$this->getData("DESIGN",array("ID"=>$pcode),"ID,NAME","");
	if(!empty($cnm)){
	
	$design=$cnm[0]['NAME'];	
	
	}
	
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,DESIGN,COLOR,UNIT,QTY,RATE,AMOUNT,SNO,VCODE,U_ID,B_ID,STATUS)
	VALUES ('$no','$vdate','$pcode','$design','$design','$color','$color','$qty','$rate','$amount','$sno','$vcode','".$this->userData['U_ID']."','".$this->userData['B_ID']."','Pending')");
	
	if($data['rights']['UNPOSTED']==0){	
	$descrip=$design." Qty ".$qty." - ".$rate."";
/* 	//PURCHASE ACCOUNT Debit
	$gnrllgrSacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,SNO,FCODE,FNAME) 
	VALUES ('$no','$vdate','$voucher_Jo','40101001','$descrip','$amount',0,'".$this->userData['B_ID']."','".$this->userData['U_ID']."','$sno','$vcode','$vname')");
	//PARTY Credit
	$gnrllgrPacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,SNO,FCODE,FNAME) 
	VALUES ('$no','$vdate','$voucher_Jo','$vcode','$descrip',0,'$amount','".$this->userData['B_ID']."','".$this->userData['U_ID']."','$sno','40101001','PURCHASE A/C')");
	 */
	$asd = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,INQT,OUTQT,VCODE,B_ID,RATE) 
	VALUES ('$no','$vdate','$voucher_Jo','$pcode','$descrip','$qty',0,'$vcode','".$this->userData['B_ID']."','$rate')");
	
	}
	
	
	$sno++;	
	
	}
	$row++;
	}
	$descrip1="Order Qty @".$tqty;
	//PURCHASE ACCOUNT Debit
	$gnrllgrSacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,SNO,FCODE,FNAME) 
	VALUES ('$no','$vdate','$voucher_Jo','40101001','$descrip1','$total',0,'".$this->userData['B_ID']."','".$this->userData['U_ID']."','$sno','$vcode','$vname')");
	//PARTY Credit
	$gnrllgrPacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,U_ID,SNO,FCODE,FNAME) 
	VALUES ('$no','$vdate','$voucher_Jo','$vcode','$descrip1',0,'$total','".$this->userData['B_ID']."','".$this->userData['U_ID']."','$sno','40101001','PURCHASE A/C')");
	
	
	
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