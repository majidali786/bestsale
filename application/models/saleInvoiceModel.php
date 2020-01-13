<?php
	class saleInvoiceModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="SALE1";
	$mainTable2="SALE2";
	$voucher_Jo="SL";
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
	
	$this->deleteData("$stock",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	
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
	$cnm=$this->getData("PARTY",array("VCODE"=>$vcode),"VNAME,ADDR","");
	if(!empty($cnm)){
	$vname=$cnm[0]['VNAME'];	
	$addr=$cnm[0]['ADDR'];	
	
	}
	
		

	$scode=$data['sacode'];
	$snm=$this->getData("ACCOUNT",array("ACODE"=>$scode),"ANAME","");
	if(!empty($snm)){
	$sname=$snm[0]['ANAME'];	
	}
	
	
	$remarks=$data['remarks'];
	$total=removecommas($data['tamount']);
	$net2=removecommas($data['tnet']);
	$cnet=removecommas($data['cnet']);
	$dst=removecommas($data['dst']);
	$gstamt=removecommas($data['gstamt']);
	$vno=$data['vno'];
	

	if(empty($error)){
	
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,VCODE,VNAME,ADDR,VNO,SCODE,SNAME,REMARKS,TOTAL,DIS,DISCOUNT,
	NET,U_ID,B_ID,UNPOSTED,POSTED,APPROVED) 
	VALUES ('$no','$vdate','$vcode','$vname','$addr','$vno','$scode','$sname','$remarks','$net2','$dst','$gstamt','$cnet'
	,'".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
	
	
	
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
	$rate=removecommas($data['rate_'.$row.'']);
	$amount=removecommas($data['amount_'.$row.'']);
	$discountper=removecommas($data['discountper_'.$row.'']);
	$discount=removecommas($data['discount_'.$row.'']);
	$total=removecommas($data['total_'.$row.'']);
	$gstper=removecommas($data['gstper_'.$row.'']);
	$gst=removecommas($data['gst_'.$row.'']);
	$net=removecommas($data['net_'.$row.'']);

	
	$cnm=$this->getData("PRODUCT",array("PCODE"=>$pcode),"PNAME","");
	if(!empty($cnm)){
	$pname=$cnm[0]['PNAME'];	
	}
	
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,UNIT,QTY,RATE,AMOUNT,DISCOUNT,DISCOUNTPER,TOTAL,GST,GSTPER,NET,SNO,VCODE,U_ID,B_ID) 
	VALUES ('$no','$vdate','$pcode','$pname','$unit','$qty','$rate','$amount','$discount','$discountper','$total','$gst','$gstper','$net','$sno','$vcode','".$this->userData['U_ID']."','".$this->userData['B_ID']."')");
	
	if($insertRow){
	if($data['rights']['UNPOSTED']==0){	
	$descrip=$pname." Qty".$qty." @".$rate;
	$descrip2=$pname." VAT@ ".$gstper;
	if($total>0)
	{
	$gnrllgrSacc1 = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,VNO) 
	VALUES ('$no','$vdate','$voucher_Jo','30101001','$descrip',0,'$total','".$this->userData['B_ID']."','$vno')");
	
	$gnrllgrSacc12 = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,VNO) 
	VALUES ('$no','$vdate','$voucher_Jo','$vcode','$descrip','$total',0,'".$this->userData['B_ID']."','$vno')");
	}
	
	if($gst>0)
	{
	$gnrllgrSacc2 = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,VNO)
	VALUES ('$no','$vdate','$voucher_Jo','20102001','$descrip2',0,'$gst','".$this->userData['B_ID']."','$vno')");
	$gnrllgrSacc22 = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,VNO)
	VALUES ('$no','$vdate','$voucher_Jo','$vcode','$descrip2','$gst',0,'".$this->userData['B_ID']."','$vno')");
	}
	
	$stocka = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,INQT,OUTQT,INAMT,OUTAMT,RATE,VCODE,B_ID)
	VALUES ('$no','$vdate','$voucher_Jo','$pcode','$descrip',0,'$qty',0,'$amount','$rate','$vcode','".$this->userData['B_ID']."')");
	
	
	}
	}
	$sno++;	
	}
	}
	$row++;
	}
	if($gstamt>0)
	{		
	$gnrllgrPacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,VNO)
	VALUES ('$no','$vdate','$voucher_Jo','30201001','$remarks','$gstamt',0,'".$this->userData['B_ID']."','$vno')");
	
	$gnrllgrPaccE = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,VNO)
	VALUES ('$no','$vdate','$voucher_Jo','$vcode','Discount on Sales: ',0,'$gstamt','".$this->userData['B_ID']."','$vno')");
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