<?php
	class lcPurchaseModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="LCPURCH1";
	$mainTable2="LCPURCH2";
	$voucher_Jo="PL";
	$stock="STOCK_LC";
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
	$this->deleteData("$stock",array("NO"=>$no,"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID']));	
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

	
	$bnid=$data['lcbond'];
	$lcbond="";
	$crm=$this->getData("LCBOND",array("ID"=>$bnid),"LCBOND","");
	if(!empty($crm)){
	$lcbond=$crm[0]['LCBOND'];		
	}
	
	$pacode=$data['paccount'];
	$ssf=$this->getData("ACCOUNT",array("ACODE"=>$pacode),"ANAME","");
	if(!empty($ssf)){
	$paname=$ssf[0]['ANAME'];		
	}
	$lccode=$data['lccode'];
	$cbm=$this->getData("ACCOUNT",array("ACODE"=>$lccode),"ANAME","");
	if(!empty($cbm)){
	$lcname=$cbm[0]['ANAME'];		
	}
	
	$lcno=$data['lcno'];
	$grn=$data['grno'];
	$grndate=$data['grndate'];

	
	if($grndate==""){
	$grndate=$vdate;	
	}
	else{
	$grndate=$this->dateFormat($grndate);
	}
	$remarks=$data['remarks'];
	$tqty=removecommas($data['tqty']);
	$tweight=removecommas($data['tweight']);
	$toverhead=removecommas($data['toverhead']);
	$tamount=removecommas($data['tamount']);
	$net=removecommas($data['net']);
		
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,PACODE,PANAME,LCCODE,LCNAME,VCODE,VNAME,LCNO,GRN,GRNDATE,BNID,LCBOND,REMARKS,TQTY,TWEIGHT,TOVERHEAD,TAMOUNT,NET,U_ID,B_ID,UNPOSTED,POSTED,APPROVED) VALUES ('$no','$vdate','$pacode','$paname','$lccode','$lcname','$vcode','$vname','$lcno','$grn','$grndate','$bnid','$lcbond','$remarks','$tqty','$tweight','$toverhead','$tamount','$net','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
		
	$nrows=$data['nrows'];
	$row=1;
	$sno=1;
	if($insertMain){
	while($row<$nrows){
	if(!empty($data['pcode_'.$row.''])){
	if(removecommas($data['amount_'.$row.''])>0 && removecommas($data['rate_'.$row.''])>0){

	$pcode=$data['pcode_'.$row.''];
	$unit=$data['unit_'.$row.''];
	$coil=$data['coil_'.$row.''];
	$qty=removecommas($data['qty_'.$row.'']);
	$weight=removecommas($data['weight_'.$row.'']);
	$overhead=removecommas($data['overhead_'.$row.'']);
	$rate=removecommas($data['rate_'.$row.'']);
	$amount=removecommas($data['amount_'.$row.'']);
	$total=removecommas($data['total_'.$row.'']);

	
	$cnm=$this->getData("PRODUCT",array("PCODE"=>$pcode),"PNAME","");
	if(!empty($cnm)){
	$pname=$cnm[0]['PNAME'];	
	}
	
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,VCODE,LCNO,LCCODE,PCODE,PNAME,UNIT,COIL,QTY,WEIGHT,RATE,AMOUNT,OVERHEAD,TOTAL,SNO,U_ID,B_ID) VALUES ('$no','$vdate','$vcode','$lcno','$lccode','$pcode','$pname','$unit','$coil','$qty','$weight','$rate','$amount','$overhead','$total','$sno','".$this->userData['U_ID']."','".$this->userData['B_ID']."')");
	if($data['rights']['UNPOSTED']==0){	
	$descrip=$pname." Qty".$qty." ".$weight." MT @".$rate;
	$asd = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,COIL,INWGHT,OUTWGHT,INQT,OUTQT,INAMT,OUTAMT,RATE,LCNO,BOND,B_ID) VALUES ('$no','$vdate','$voucher_Jo','$pcode','$descrip','$coil',$weight,0,$qty,0,$amount,0,$rate,'$lcno','$bnid','".$this->userData['B_ID']."')");
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