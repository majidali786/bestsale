<?php
	class productionKarolModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="PRODTNK1";
	$mainTable2="PRODTNK2";
	$voucher_Jo="PK";	
	$stock="STOCK";	
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
	
	$lotno=$data['lotno'];
	$dpcode=$data['department'];
	$cnm=$this->getData("DEPT",array("DPCode"=>$dpcode),"DPName","");
	if(!empty($cnm)){
	$department=$cnm[0]['DPName'];	
	}
	
	$rpcode=$data['rmaterial'];
	$prr=$this->getData("PRODUCT",array("PCODE"=>$rpcode),"PNAME","");
	if(!empty($prr)){
	$rpname=$prr[0]['PNAME'];	
	}
	
	
	$used=removecommas($data['used']);
	$inhand=removecommas($data['inhand']);
	$cused=removecommas($data['cused']);
	$remarks=$data['remarks'];
	$twght=$data['twght'];
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,LOTNO,USED,INHAND,CUSED,RPCODE,RPNAME,DPCODE,DEPARTMENT,REMARKS,TOTWEIGHT,U_ID,B_ID,UNPOSTED,POSTED,APPROVED) VALUES ('$no','$vdate','$lotno','$used','$inhand','$cused','$rpcode','$rpname','$dpcode','$department','$remarks','$twght','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
	
	if($data['rights']['UNPOSTED']==0){
	$descrip1="Consume in Production Lot No.".$lotno;	
	$stockf = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,INWGHT,OUTWGHT,INQT,OUTQT,INAMT,OUTAMT,RATE,B_ID,VCODE,LOTNO) VALUES ('$no','$vdate','$voucher_Jo','$rpcode','$descrip1',0,$cused,0,0,0,0,0,'".$this->userData['B_ID']."','','$lotno')");
	}
	
	
	$nrows=$data['nrows'];
	$row=1;
	$sno=1;
	if($insertMain){
	while($row<$nrows){
	if(!empty($data['pcode_'.$row.''])){
	if($data['amount_'.$row.'']>0 && $data['qty_'.$row.'']>0 && $data['rate_'.$row.'']>0){

	$pcode=$data['pcode_'.$row.''];
	$unit=$data['unit_'.$row.''];
	$qty=removecommas($data['qty_'.$row.'']);
	$weight=removecommas($data['weight_'.$row.'']);
	$feet=removecommas($data['feet_'.$row.'']);
	$rate=removecommas($data['rate_'.$row.'']);
	$amount=removecommas($data['amount_'.$row.'']);

	
	$cnm=$this->getData("PRODUCT",array("PCODE"=>$pcode),"PNAME","");
	if(!empty($cnm)){
	$pname=$cnm[0]['PNAME'];	
	}
	
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,UNIT,WEIGHT,QTY,FEET,RATE,AMOUNT,SNO,U_ID,B_ID,LOTNO,RPCODE,DPCODE) VALUES ('$no','$vdate','$pcode','$pname','$unit','$weight','$qty','$feet','$rate','$amount','$sno','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$lotno','$rpcode','$dpcode')");
	
	if($insertRow){
	if($data['rights']['UNPOSTED']==0){	
	$descrip2="Production From Lot No.".$lotno;	
	
	$stockt = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,INWGHT,OUTWGHT,INQT,OUTQT,INAMT,OUTAMT,RATE,B_ID,VCODE) VALUES ('$no','$vdate','$voucher_Jo','$pcode','$descrip2',$weight,0,$qty,0,$amount,0,$rate,'".$this->userData['B_ID']."','')");
	
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