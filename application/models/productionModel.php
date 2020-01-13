<?php
	class productionModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="PRODTN1";
	$mainTable2="PRODTN2";
	$voucher_Jo="PD";	
	$stock="STOCK";	
	$gnrllgr="Gnrllgr";	
	$stock_pdk="STOCK_PDK";	
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
	$this->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","No"=>$no,"B_ID"=>$this->userData['B_ID']));	
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
	$dpcode=$data['department'];
	$cnm=$this->getData("DEPT",array("DPCode"=>$dpcode),"DPName","");
	if(!empty($cnm)){
	$department=$cnm[0]['DPName'];	
	}	
	$ccode=$data['contractor'];
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$ccode),"ANAME","");
	if(!empty($cnm)){
	$contractor=$cnm[0]['ANAME'];	
	}else {
	$contractor='';
	}
	
	$twght=removecommas($data['twght']);
	$tqty=removecommas($data['tqty']);
	$totwght=removecommas($data['totwght']);
	$tamount=removecommas($data['tamount']);
	$protwght=removecommas($data['protwght']);
	$protqty=removecommas($data['protqty']);
	$protmmwaste=removecommas($data['protmmwaste']);
	$prototwght=removecommas($data['prototwght']);
	$protwaste=removecommas($data['protwaste']);
	$protmwaste=removecommas($data['protmwaste']);
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,RPCODE,RPNAME,DPCODE,DEPARTMENT,U_ID,B_ID,UNPOSTED,POSTED,APPROVED,FIN_TWEIGHT,FIN_QTY,FIN_TOTWEIGHT,FIN_AMOUNT,RAW_WEIGHT,RAW_QTY,RAW_MMWASTE,RAW_TOTWEIGHT,RAW_WASTE,RAW_MWASTE) VALUES ('$no','$vdate','$ccode','$contractor','$dpcode','$department','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved',$twght,$tqty,$totwght,$tamount,$protwght,$protqty,$protmmwaste,$prototwght,$protwaste,$protmwaste)");
	
	if($data['rights']['UNPOSTED']==0){	
	$discountDiscrip=$totwght." / ".$tamount;	
	
	$stockt = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,DPCODE,DPNAME) VALUES ('$no','$vdate','$voucher_Jo','$ccode','$discountDiscrip',0,$tamount,'".$this->userData['B_ID']."','$dpcode','$department')");
	$stockt = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,DPCODE,DPNAME) VALUES ('$no','$vdate','$voucher_Jo','','$discountDiscrip',$tamount,0,'".$this->userData['B_ID']."','$dpcode','$department')");
	
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
	$feet=removecommas($data['feet_'.$row.'']);
	$totweight=removecommas($data['totweight_'.$row.'']);
	$rate=removecommas($data['rate_'.$row.'']);
	$amount=removecommas($data['amount_'.$row.'']);

	$cnm=$this->getData("PRODUCT",array("PCODE"=>$pcode),"PNAME","");
	if(!empty($cnm)){
	$pname=$cnm[0]['PNAME'];	
	}
	
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,UNIT,WEIGHT,QTY,FEET,RATE,AMOUNT,SNO,U_ID,B_ID,RPCODE,DPCODE,TYPE,TOTWEIGHT,MMWASTE,WASTE,MWASTE,COIL) VALUES ('$no','$vdate','$pcode','$pname','$unit','$weight','$qty','$feet','$rate','$amount','$sno','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$ccode','$dpcode',0,$totweight,0,0,0,'')");
	
	if($insertRow){
	if($data['rights']['UNPOSTED']==0){	
	$descrip2=$pname." @".$rate;	
	
	$stockt = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,INWGHT,OUTWGHT,INQT,OUTQT,INAMT,OUTAMT,RATE,B_ID,VCODE) VALUES ('$no','$vdate','$voucher_Jo','$pcode','$descrip2',$weight,0,$qty,0,$amount,0,$rate,'".$this->userData['B_ID']."','')");
	
	}
	}
	$sno++;	
	}
	}
	$row++;
	}
	$nprorows=$data['nprorows'];
	$prorow=1;
	$prosno=1;
	while($prorow<$nprorows){
	if(!empty($data['propcode_'.$prorow.''])){
	if($data['proweight_'.$prorow.'']>0 && $data['proqty_'.$prorow.'']>0){

	$pcode=$data['propcode_'.$prorow.''];
	$unit=$data['prounit_'.$prorow.''];
	$qty=removecommas($data['proqty_'.$prorow.'']);
	$weight=removecommas($data['proweight_'.$prorow.'']);
	$procoil=removecommas($data['procoil_'.$prorow.'']);
	$prommwaste=removecommas($data['prommwaste_'.$prorow.'']);
	$prototweight=removecommas($data['prototweight_'.$prorow.'']);
	$prowaste=removecommas($data['prowaste_'.$prorow.'']);
	$promanualwaste=removecommas($data['promanualwaste_'.$prorow.'']);

	$cnm=$this->getData("PRODUCT",array("PCODE"=>$pcode),"PNAME","");
	if(!empty($cnm)){
	$pname=$cnm[0]['PNAME'];	
	}
	
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,UNIT,WEIGHT,QTY,FEET,RATE,AMOUNT,SNO,U_ID,B_ID,RPCODE,DPCODE,TYPE,TOTWEIGHT,MMWASTE,WASTE,MWASTE,COIL) VALUES ('$no','$vdate','$pcode','$pname','$unit','$weight','$qty','$feet','$rate','$amount','$prosno','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$ccode','$dpcode',1,$prototweight,$prommwaste,$prowaste,$promanualwaste,'$procoil')");
	
	if($insertRow){
	if($data['rights']['UNPOSTED']==0){	
	$descrip2=$pname." COIL ".$procoil." @".$rate;	
	
	$stockt = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,INWGHT,OUTWGHT,INQT,OUTQT,INAMT,OUTAMT,RATE,B_ID,VCODE,COIL) VALUES ('$no','$vdate','$voucher_Jo','$pcode','$descrip2',0,$weight,0,$qty,0,$amount,$rate,'".$this->userData['B_ID']."','','$procoil')");
	
	}
	}
	$prosno++;	
	}
	}
	$prorow++;
	}
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VLOG(VDATE,U_ID,B_ID,NO,JO,TYPE) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo','$post_type')");
	return true;	
	}
	}
	
	}
?>