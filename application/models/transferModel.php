<?php
	class transferModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="TRANS1";
	$mainTable2="TRANS2";
	$voucher_Jo="TS";		
	$stock="STOCK_SORDR";		
	//$stock2="STOCK_SORDR";		
	$post_type;	
	$error="";
	if($data['action']=="save"){	
	$no=$data['no'];	
	$max=$this->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
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
	
	$vdate=$this->dateFormat($data['vdate']);
	$odate=$this->dateFormat($data['odate']);
	
	
	$vcode=$data['vcode'];
	$cnm=$this->getData("PARTY",array("VCODE"=>$vcode),"VNAME,ADDR","");
	if(!empty($cnm)){
	$vname=$cnm[0]['VNAME'];	
	$addr=$cnm[0]['ADDR'];	
	}
	
	$ccode=$data['ccode'];
	$cnm1=$this->getData("CARGO",array("CODE"=>$ccode),"VNAME","");
	if(!empty($cnm1)){
	$cargo=$cnm1[0]['VNAME'];	
	
	}
	
	
	$total=$data['tqty'];
	$total = str_replace(',','',$total);
	
	if(!empty($data['rights'])){
	if($data['rights']['UNPOSTED']==1){
	$unposted=$this->userData['U_ID'];	
	$posted="";	
	$approved="";		
	$post_type=1;	
	$stats = 'Done';
	}
	else if($data['rights']['POSTED']==1){
	$unposted="";	
	$posted=$this->userData['U_ID'];	
	$approved="";	
	$post_type=2;		
	$stats = 'Done';
	}
	else if($data['rights']['APPROVED']==1){
	$unposted="";	
	$posted=$this->userData['U_ID'];	
	$approved=$this->userData['U_ID'];
	$post_type=3;	
	$stats = 'Done';
	}
	else{
	$unposted=$this->userData['U_ID'];	
	$posted="";	
	$approved="";
	$post_type=1;		
	$stats = 'Done';
	}	
	}
	else{
	$unposted=$this->userData['U_ID'];	
	$posted="";	
	$approved="";			
	$post_type=1;	
	$stats = 'Done';
	}
	$remarks=$data['remarks'];
	$sordrno=$data['sordrno'];
	$crdays=$data['crdays'];

	$std='0';
	if(!empty($data['sms']))
	{
	$std='1';
	$stdnm='Close';
	$insertMain = $this->db->query("UPDATE PORDR2 SET STATUS='$stdnm' where NO='$sordrno'");
	
	}
	else
	{
	$std='0';
	$stdnm='Pending';
	}
	
	
	
	/////////////////////checking for duplication///////////////////////
	$cnrows=$data['nrows'];
	$crow=1;
	while($crow<$cnrows){
	if(!empty($data['pcode_'.$crow.''])){
	$cpcode=$data['pcode_'.$crow.''];
	$cqty=removecommas($data['qty_'.$crow.'']);
	
	$chck_ordr = $this->query("select t1.NO,t1.PCODE,t1.PNAME,t1.bal as QTY,SUM(t2.INQT-t2.OUTQT) as STOCK,t1.COLOR,t1.RATE,t1.AMOUNT from (
	(SELECT a1.NO,a1.PNAME,a1.PCODE,SUM(a1.QTY-a2.qty) as bal,a1.COLOR,a1.RATE,a1.AMOUNT,a1.B_ID from PORDR2 a1 
	left join TRANS2 a2 on a1.NO=a2.SONO and a1.B_ID=a2.B_ID and a1.VCODE=a2.VCODE and a1.PCODE=a2.PCODE
	group by a1.NO,a1.PNAME,a1.PCODE,a1.COLOR,a1.RATE,a1.AMOUNT,a1.B_ID,a1.QTY,a1.PCODE
	having a1.QTY<> SUM(a2.qty)) union all
	(SELECT a1.NO,a1.PNAME,a1.PCODE,a1.QTY,a1.COLOR,a1.RATE,a1.AMOUNT,a1.B_ID as bal from PORDR2 a1 
	left join TRANS2 a2 on a1.NO=a2.SONO and a1.B_ID=a2.B_ID and a1.VCODE=a2.VCODE and a1.PCODE=a2.PCODE
	where a2.PCODE is null
	group by a1.NO,a1.PNAME,a1.QTY,a1.PCODE,a1.COLOR,a1.RATE,a1.AMOUNT,a1.B_ID)) t1 
	left join STOCK t2 on t1.PCODE=t2.PCODE and t1.B_ID=t2.B_ID 
	where t1.NO='$sordrno' and t1.B_ID='".$this->userData['B_ID']."' and t1.PCODE='$cpcode' and CAST(t1.bal as decimal)>='$cqty'
	group by t1.NO,t1.PCODE,t1.bal,t1.PNAME,t1.COLOR,t1.RATE,t1.AMOUNT");
	if(empty($chck_ordr))	{
	$error = 'Order Had Already Placed ..... Please Enter Again';
	}	}
	$crow++;
	}
	//////////////////////////////end//////////////////////////////////
	
	
	
	if(empty($error)){
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,VCODE,VNAME,ADDR,CID,CARGO,CRDAYS,REMARKS,PONO,SODATE,U_ID,B_ID,UNPOSTED,POSTED,APPROVED,STATUS,STATUS2) 
	VALUES ('$no','$vdate','$vcode','$vname','$addr','$ccode','$cargo','$crdays','$remarks','$sordrno','$odate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved','$stats','$std')");
	
	$nrows=$data['nrows'];
	$row=1;
	$sno=1;
	if($insertMain){
	while($row<$nrows){
	if(!empty($data['pcode_'.$row.''])){
	if($data['qty_'.$row.'']>0 ){

	//$sordr_dt=$data['sodat_'.$row.''];
	$pcode=$data['pcode_'.$row.''];
	$unit=$data['unit_'.$row.''];
	$maxqty=removecommas($data['orderqty_'.$row.'']);
	$qty=removecommas($data['qty_'.$row.'']);
	$stck=removecommas($data['stock_'.$row.'']);
	$rate=removecommas($data['rate_'.$row.'']);
	$amount=removecommas($data['amount_'.$row.'']);
    $SQT=$maxqty-$qty;
	
	$cnm=$this->getData("DESIGN",array("ID"=>$pcode),"ID,NAME","");
	if(!empty($cnm)){
	
	$design=$cnm[0]['NAME'];	
	
	}
	
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,UNIT,ORDERQTY,QTY,STOCK,RATE,AMOUNT,SNO,VCODE,U_ID,B_ID,SONO,STATUS)
	VALUES ('$no','$vdate','$pcode','$design','$unit','$maxqty','$qty','$SQT','$rate','$amount','$sno','$vcode','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$sordrno','$std')");
	

	if($stats=='Done')
	{
	if($insertRow){
	if($data['rights']['UNPOSTED']==0){
	$descrip=$design." Qty".$qty." @".$rate;
	
	$asd = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,INQT,OUTQT,VCODE,B_ID,RATE,UNIT,U_ID,SONO) 
	VALUES ('$no','$vdate','$voucher_Jo','$pcode','$descrip',0,$qty,'$vcode','".$this->userData['B_ID']."','$rate','$unit','".$this->userData['U_ID']."','$sordrno')");
	}
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
	else{
	return $error;	
	}
	
	}
	
	
	}
?>