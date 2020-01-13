<?php
	class LCstockTransferModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="LCSTRNF1";
	$mainTable2="LCSTRNF2";
	$voucher_Jo="LT";	
	$stock="STOCK_LC";	
	$stock2="STOCK";	
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
	$this->deleteData("$stock",array("JO"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	$this->deleteData("$stock2",array("JO"=>"$voucher_Jo","TNO"=>$no,"TB_ID"=>$this->userData['B_ID']));	
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
	$fbnid=$data['flcbond'];
	$crm=$this->getData("LCBOND",array("ID"=>$fbnid),"LCBOND","");
	if(!empty($crm)){
	$flcbond=$crm[0]['LCBOND'];		
	}
	$tbid=$data['tbranch'];
	$cnm=$this->getData("BRANCH",array("BCODE"=>$tbid),"BNAME","");
	if(!empty($cnm)){
	$tbranch=$cnm[0]['BNAME'];	
	}
	
	
	$remarks=$data['remarks'];
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,FBNID,FLCBOND,TBID,TBRANCH,REMARKS,U_ID,B_ID,UNPOSTED,POSTED,APPROVED) VALUES ('$no','$vdate','$fbnid','$flcbond','$tbid','$tbranch','$remarks','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
	
	
	$nrows=$data['nrows'];
	$row=1;
	$sno=1;
	if($insertMain){
	while($row<$nrows){
	if(!empty($data['pcode_'.$row.''])){
	if($data['amount_'.$row.'']>0 && $data['qty_'.$row.'']>0 && $data['rate_'.$row.'']>0){

	$pcode=$data['pcode_'.$row.''];
	$unit=$data['unit_'.$row.''];
	$coil=$data['coil_'.$row.''];
	$lcno=$data['lcno_'.$row.''];
	$qty=removecommas($data['qty_'.$row.'']);
	$weight=removecommas($data['weight_'.$row.'']);
	$rate=removecommas($data['rate_'.$row.'']);
	$amount=removecommas($data['amount_'.$row.'']);

	
	$cnm=$this->getData("PRODUCT",array("PCODE"=>$pcode),"PNAME","");
	if(!empty($cnm)){
	$pname=$cnm[0]['PNAME'];	
	}
	
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,UNIT,COIL,WEIGHT,QTY,RATE,AMOUNT,SNO,U_ID,B_ID,FBNID,TBID,LCNO) VALUES ('$no','$vdate','$pcode','$pname','$unit','$coil','$weight','$qty','$rate','$amount','$sno','".$this->userData['U_ID']."','".$this->userData['B_ID']."',$fbnid,$tbid,'$lcno')");
	
	if($insertRow){
	if($data['rights']['UNPOSTED']==0){	
	$descrip1="Qty".$qty." ".$weight."MT  Stock Transfer To ".$tbranch;
	$tweight=$weight*1000;
	$trate=$rate/1000;
	$descrip2="Qty".$qty." ".$tweight."Kg  Stock Transfer From ".$flcbond;
	
	$stockf = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,INWGHT,OUTWGHT,INQT,OUTQT,INAMT,OUTAMT,RATE,B_ID,COIL,LCNO,BOND) VALUES ('$no','$vdate','$voucher_Jo','$pcode','$descrip1',0,$weight,0,$qty,0,$amount,$rate,'".$this->userData['B_ID']."','$coil','$lcno','$fbnid')");
	
	$stockt = $this->db->query("INSERT INTO $stock2(NO,VDATE,JO,PCODE,DESCR,INWGHT,OUTWGHT,INQT,OUTQT,INAMT,OUTAMT,RATE,BATCH,POST,B_ID,COIL,TNO,TB_ID,VCODE) VALUES ('$no','$vdate','$voucher_Jo','$pcode','$descrip2',$tweight,0,$qty,0,$amount,0,$trate,'','','$tbid','$coil','$no','".$this->userData['B_ID']."','')");
	

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