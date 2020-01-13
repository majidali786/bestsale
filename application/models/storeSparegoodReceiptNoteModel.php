<?php
	class storeSparegoodReceiptNoteModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="SSGRN1";
	$mainTable2="SSGRN2";
	$voucher_Jo="SG";
	$gnrllgr="Gnrllgr";		
	$stock="STOCK_SS";	
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
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$vcode),"ANAME","");
	if(!empty($cnm)){
	$vname=$cnm[0]['ANAME'];	
	$addr="None";	
	}
	$dpcode=$data['department'];
	$crm=$this->getData("DEPT",array("DPCode"=>$dpcode),"DPName","");
	if(!empty($crm)){
	$dpname=$crm[0]['DPName'];		
	}
	
	$pacode="20102001";
	$cbm=$this->getData("ACCOUNT",array("ACODE"=>$pacode),"ANAME","");
	$pname="";
	if(!empty($cbm)){
	$pname=$cbm[0]['ANAME'];		
	}
	
	
	$vno=$data['vno'];
	$remarks=$data['remarks'];
	$total=removecommas($data['tamount']);
	$grn=$data['grnno'];
	$gst=removecommas($data['gst']);
	$gstamt=removecommas($data['gstamt']);
	$net=removecommas($data['net']);
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,VCODE,VNAME,ADDR,DPCODE,DPNAME,PCODE,PNAME,VNO,REMARKS,TOTAL,GST,GSTAMT,NET,GRN,U_ID,B_ID,UNPOSTED,POSTED,APPROVED) VALUES ('$no','$vdate','$vcode','$vname','$addr','$dpcode','$dpname','$pacode','$pname','$vno','$remarks','$total','$gst','$gstamt','$net','$grn','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
	
	
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
	$feet=removecommas($data['feet_'.$row.'']);
	$rate=removecommas($data['rate_'.$row.'']);
	$amount=removecommas($data['amount_'.$row.'']);

	
	$cnm=$this->getData("SSPRODUCT",array("PCODE"=>$pcode),"PNAME","");
	if(!empty($cnm)){
	$pname=$cnm[0]['PNAME'];	
	}
	
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,UNIT,WEIGHT,QTY,FEET,RATE,AMOUNT,SNO,VCODE,U_ID,B_ID) VALUES ('$no','$vdate','$pcode','$pname','$unit','$weight','$qty','$feet','$rate','$amount','$sno','$vcode','".$this->userData['U_ID']."','".$this->userData['B_ID']."')");
	
	if($insertRow){
	if($data['rights']['UNPOSTED']==0){	
	$descrip=$pname." Qty".$qty." ".$weight."Kg Ft".$feet." @".$rate;
	$gnrllgrSacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('$no','$vdate','$voucher_Jo','$pacode','$descrip',$amount,0,'".$this->userData['B_ID']."')");
	
	$gnrllgrPacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,PNO) VALUES ('$no','$vdate','$voucher_Jo','$vcode','$descrip',0,$amount,'".$this->userData['B_ID']."','$no')");
	
	$stocka = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,INWGHT,OUTWGHT,INQT,OUTQT,INFT,OUTFT,INAMT,OUTAMT,RATE,DPCODE,B_ID) VALUES ('$no','$vdate','$voucher_Jo','$pcode','$descrip',$weight,0,$qty,0,$feet,0,$amount,0,$rate,'$dpcode','".$this->userData['B_ID']."')");
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