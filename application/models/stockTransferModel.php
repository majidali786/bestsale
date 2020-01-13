<?php
	class stockTransferModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="STRNF1";
	$mainTable2="STRNF2";
	$voucher_Jo="ST";	
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
	$this->deleteData("$stock",array("JO"=>"$voucher_Jo","NO"=>$no,"TB_ID"=>$this->userData['B_ID']));		
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
	$fbid=$data['fbranch'];
	$cnm=$this->getData("BRANCH",array("BCODE"=>$fbid),"BNAME","");
	if(!empty($cnm)){
	$fbranch=$cnm[0]['BNAME'];	
	}
	$tbid=$data['tbranch'];
	$cnm=$this->getData("BRANCH",array("BCODE"=>$tbid),"BNAME","");
	if(!empty($cnm)){
	$tbranch=$cnm[0]['BNAME'];	
	}
	
	
	$remarks=$data['remarks'];
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,FBID,FBRANCH,TBID,TBRANCH,REMARKS,U_ID,B_ID,UNPOSTED,POSTED,APPROVED) 
	VALUES ('$no','$vdate','$fbid','$fbranch','$tbid','$tbranch','$remarks','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
	
	
	$nrows=$data['nrows'];
	$row=1;
	$sno=1;
	if($insertMain){
	while($row<$nrows){
	if(!empty($data['pcode_'.$row.''])){
	if($data['qty_'.$row.'']>0){

	$pcode=$data['pcode_'.$row.''];
	$unit=$data['unit_'.$row.''];
	$qty=removecommas($data['qty_'.$row.'']);
	$stk=removecommas($data['stock_'.$row.'']);


	
	$cnm=$this->getData("PRODUCT",array("PCODE"=>$pcode),"PNAME,PRATE","");
	if(!empty($cnm)){
	$pname=$cnm[0]['PNAME'];	
	$rate=$cnm[0]['PRATE'];	
	}
	$amount=$qty*$rate;
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,UNIT,QTY,RATE,AMOUNT,STOCK,SNO,U_ID,B_ID,FBID,TBID) 
	VALUES ('$no','$vdate','$pcode','$pname','$unit','$qty','$rate','$amount','$stk','$sno','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$fbid','$tbid')");
	
	if($insertRow){
	if($data['rights']['UNPOSTED']==0){	
	$descrip1="Qty".$qty."Stock Transfer To ".$tbranch;
	$descrip2="Qty".$qty."Stock Transfer From ".$fbranch;
	
	$stockf = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,INQT,OUTQT,INAMT,OUTAMT,RATE,B_ID,TB_ID,VCODE)
	VALUES ('$no','$vdate','$voucher_Jo','$pcode','$descrip1',0,'$qty',0,'$amount','$rate','$fbid','".$this->userData['B_ID']."','')");
	
	$stockt = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,INQT,OUTQT,INAMT,OUTAMT,RATE,B_ID,TB_ID,VCODE)
	VALUES ('$no','$vdate','$voucher_Jo','$pcode','$descrip2','$qty',0,'$amount','$rate',0,'$tbid','".$this->userData['B_ID']."','')");
	
	//$h=array("1"=>"HO","2"=>"GJW","3"=>"KG","4"=>"CS");
	//$lotno=$no."-".$voucher_Jo."-".$h[$this->userData['B_ID']];
	
	//$stockt = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,INWGHT,OUTWGHT,INQT,OUTQT,INAMT,OUTAMT,RATE,BATCH,POST,B_ID,COIL,TNO,TB_ID,VCODE,LOTNO) 
	//VALUES ('$no','$vdate','$voucher_Jo','$pcode','$descrip2',$weight,0,$qty,0,$amount,0,$rate,'','','$tbid','0','$no','".$this->userData['B_ID']."','','$lotno')");

	

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