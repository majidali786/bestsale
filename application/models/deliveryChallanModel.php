<?php
	class deliveryChallanModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="DC1";
	$mainTable2="DC2";
	$sordr="SORDR2";
	$voucher_Jo="DC";		
	$stock="STOCK_SORDR";
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
	else
	{
	$no=$data['no'];
	$this->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	$this->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	$this->deleteData("$stock",array("JO"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	}
	
	$vdate=$this->dateFormat($data['vdate']);
	$vcode=$data['vcode'];
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$vcode),"ANAME","");
	if(!empty($cnm)){
	$vname=$cnm[0]['ANAME'];	
	$addr="None";	
	}
	$clmt=$this->getData("PARTY",array("VCODE"=>$vcode),"CLIMIT","");
	if(!empty($clmt)){
	$limit=$clmt[0]['CLIMIT'];	
	}
	
	$total=$data['total'];
	$total = str_replace(',','',$total);
	
	if(!empty($data['rights'])){
	if($data['rights']['UNPOSTED']==1){
	$unposted=$this->userData['U_ID'];	
	$posted="";	
	$approved="";		
	$post_type=1;	
	if($total>$limit)
	{
	$stats = 'Pending';
	}	else {
	$stats = 'Done';
	}	
	}
	else if($data['rights']['POSTED']==1){
	$unposted="";	
	$posted=$this->userData['U_ID'];	
	$approved="";	
	$post_type=2;		
	if($total>$limit)
	{
	$stats = 'Pending';
	}	else {
	$stats = 'Done';
	}
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
	if($total>$limit)
	{
	$stats = 'Pending';
	}	else {
	$stats = 'Done';
	}
	}	
	}
	else{
	$unposted=$this->userData['U_ID'];	
	$posted="";	
	$approved="";			
	$post_type=1;	
	if($total>$limit)
	{
	$stats = 'Pending';
	}	else {
	$stats = 'Done';
	}
	}
	
	
	$remarks=$data['remarks'];
	$vehicle=$data['vehicle'];
	$vehicleno=$data['vehicleno'];
	$driver=$data['driver'];
	$dcno=$data['dcno'];
	$previous=$data['previous'];
	$previous = str_replace(',','',$previous);
	$current=$data['current'];
	$current = str_replace(',','',$current);
	if(empty($error)){
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,VCODE,VNAME,ADDR,REMARKS,DCNO,U_ID,B_ID,UNPOSTED,POSTED,APPROVED,STATUS,PREV_BAL,CUR_BAL,TOTAL,VEHICLE,VEHICLENO,DRIVER,CLIMIT) VALUES ('$no','$vdate','$vcode','$vname','$addr','$remarks','$dcno','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved','$stats','$previous','$current','$total','$vehicle','$vehicleno','$driver','$limit')");
	
	$nrows=$data['nrows'];
	$row=1;
	$sno=1;
	if($insertMain){
	while($row<$nrows){
	if(!empty($data['pcode_'.$row.''])){
	if($data['amount_'.$row.'']>0 && $data['rate_'.$row.'']>0){

	$sono=$data['sordr_'.$row.''];
	$pono=$data['pono_'.$row.''];
	$sordr_dt=$data['sodat_'.$row.''];
	$pcode=$data['pcode_'.$row.''];
	$unit=$data['unit_'.$row.''];
	$maxqty=$data['maxqty_'.$row.''];
	$qty=$data['qty_'.$row.''];
	$maxwght=$data['maxwght_'.$row.''];
	$weight=$data['wght_'.$row.''];
	$rate=$data['rate_'.$row.''];
	$amount=$data['amount_'.$row.''];

	
	$cnm=$this->getData("PRODUCT",array("PCODE"=>$pcode),"PNAME","");
	if(!empty($cnm)){
	$pname=$cnm[0]['PNAME'];	
	}
	
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,UNIT,WEIGHT,QTY,RATE,AMOUNT,SNO,VCODE,U_ID,B_ID,SONO,PONO,SORDR_DATE) VALUES ('$no','$vdate','$pcode','$pname','$unit','$weight','$qty','$rate','$amount','$sno','$vcode','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$sono','$pono','$sordr_dt')");
	
	if($qty==$maxqty && $maxwght==$weight)
	{
		$updt = $this->db->query("update $sordr set STATUS='Done' where NO='$sono' and PCODE='$pcode' and RATE='$rate'");
	}

	if($stats=='Done')
	{
	if($insertRow){
	if($data['rights']['UNPOSTED']==0){	
	$descrip=$pname." Qty".$qty." ".$weight."Kg Ft @".$rate;
	
	$asd = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,INWGHT,OUTWGHT,INQT,OUTQT,VCODE,B_ID,RATE,UNIT,PONO) VALUES ('$no','$vdate','$voucher_Jo','$pcode','',0,$weight,0,$qty,'$vcode','".$this->userData['B_ID']."','$rate','$unit','$pono')");
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