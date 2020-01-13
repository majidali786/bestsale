<?php
	class MemoVoucherModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="MEMO1";
	$mainTable2="MEMO2";
	$voucher_Jo="MO";		
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
	if($data['rights']['APPROVED']!=1){
	$Bissue1=$this->getData("BISSUEMEMO1",array("B_ID"=>$this->userData['B_ID'],"STATUS"=>1),"","");
	if(!empty($Bissue1)){
	$maxFBissue=$this->getMax("BISSUEMEMO2","NO",array("B_ID"=>$this->userData['B_ID'],"BNO"=>$Bissue1[0]['NO']));
	if($maxFBissue<=$Bissue1[0]['ENDAT']){
	if($maxFBissue==1){
	$maxFBissue=$Bissue1[0]['STARTAT'];	
	}	
	$maxBissue=$Bissue1[0]['BNO']."-".$maxFBissue;	
	$vno=$maxBissue;
	
	$insertBissue=$this->db->query("INSERT INTO BISSUEMEMO2(NO,BNO,SNO,B_ID,STATUS) VALUES($maxFBissue,".$Bissue1[0]['NO'].",'$no','".$this->userData['B_ID']."',1)");
	}
	else{
	$error="Old Book is full issue New Book";	
	}
	}
	else{
	$error="No Book Found ! Issue Book";		
	}
	}
	else{
	$cc=explode("-",$data['vno']);
	if(!empty($cc[1])){
	$Bissue1=$this->getData("BISSUEMEMO1",array("B_ID"=>$this->userData['B_ID'],"BNO"=>$cc[0]),"","");
	if(!empty($Bissue1)){
	$Bissue2=$this->getData("BISSUEMEMO2",array("B_ID"=>$this->userData['B_ID'],"BNO"=>$Bissue1[0]['NO'],"NO"=>$cc[1]),"","");
	if(empty($Bissue2)){	
	if($cc[1] >= $Bissue1[0]['STARTAT'] && $cc[1] <= $Bissue1[0]['ENDAT']){
	$maxFBissue=$this->getMax("BISSUEMEMO2","NO",array("B_ID"=>$this->userData['B_ID'],"BNO"=>$Bissue1[0]['NO']));	
	if($cc[1] <= $maxFBissue){
	$vno=$cc[1];	
	$insertBissue=$this->db->query("INSERT INTO BISSUEMEMO2(NO,BNO,SNO,B_ID,STATUS) VALUES($vno,".$Bissue1[0]['NO'].",'$no','".$this->userData['B_ID']."',1)");
	$vno=$data['vno'];
	}
	else{
	$error="Serial Number is greater then current maximum serial number which may disturb the continuity.";		
	}
	}
	else{
	$error="Serial Not Found in Book !";	
	}
	}
	else{
	$error="Serial Number Already Exist !";	
	}
	}
	else{
	$error="No Book Found ! Issue Book";		
	}	
	}
	else{
	$error="Invalid Format";	
	}
	}
	}
	else{
	$no=$data['no'];
	$vno=$data['vno'];
	$this->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	$this->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	$this->deleteData("$gnrllgr",array("JO"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
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
	
	$dacode=$data['dacode'];
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$dacode),"ANAME","");
	if(!empty($cnm)){
	$daname=$cnm[0]['ANAME'];		
	}
	$cacode=$data['cacode'];
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$cacode),"ANAME","");
	if(!empty($cnm)){
	$caname=$cnm[0]['ANAME'];		
	}
	
	$remarks=$data['remarks'];
	$type=$data['type'];
	$dpcode=0;
	$department="";
	if($type==2){
	$dpcode=$data['department'];
	$cnm=$this->getData("DEPT",array("DPCode"=>$dpcode),"DPName","");
	if(!empty($cnm)){
	$department=$cnm[0]['DPName'];	
	}	
	}
	$tamount=removecommas($data['tamount']);
	
	if(empty($error)){
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,DACODE,DANAME,CACODE,CANAME,REMARKS,NET,U_ID,B_ID,UNPOSTED,POSTED,APPROVED,TYPE,DPCODE,DEPARTMENT,VNO) VALUES ('$no','$vdate','$dacode','$daname','$cacode','$caname','$remarks','$tamount','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved',$type,$dpcode,'$department','$vno')");
	
	
	$nrows=$data['nrows'];
	$row=1;
	$sno=1;
	if($insertMain){
	
	$gnrllgrSacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,MNO) VALUES ('$no','$vdate','$voucher_Jo','$cacode','$remarks',0,$tamount,'".$this->userData['B_ID']."','$no')");
	
	$gnrllgrPacc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('$no','$vdate','$voucher_Jo','$dacode','$remarks',$tamount,0,'".$this->userData['B_ID']."')");
	
	while($row<$nrows){
	if(!empty($data['pcode_'.$row.'']) && !empty($data['amount_'.$row.''])){
	$pcode=$data['pcode_'.$row.''];
	$amount=removecommas($data['amount_'.$row.'']);
	$qty=$weight=$feet=$rate=0;
	$descrip=$unit='';
	if($type==1){
	$descrip=$data['descrip_'.$row.''];
	$cnm=$this->getData("SERVICES",array("ID"=>$pcode),"SERVICES","");
	if(!empty($cnm)){
	$pname=$cnm[0]['SERVICES'];	
	}
	}
	else if($type==2){
	$unit=$data['unit_'.$row.''];
	$qty=removecommas($data['qty_'.$row.'']);
	$weight=removecommas($data['weight_'.$row.'']);
	$feet=removecommas($data['feet_'.$row.'']);
	$rate=removecommas($data['rate_'.$row.'']);
	$cnm=$this->getData("SSPRODUCT",array("PCODE"=>$pcode),"PNAME","");
	if(!empty($cnm)){
	$pname=$cnm[0]['PNAME'];	
	}	
	}
	
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,DESCR,UNIT,WEIGHT,QTY,FEET,RATE,AMOUNT,SNO,DPCODE,U_ID,B_ID) VALUES ('$no','$vdate','$pcode','$pname','$descrip','$unit','$weight','$qty','$feet','$rate','$amount','$sno','$dpcode','".$this->userData['U_ID']."','".$this->userData['B_ID']."')");
	
	if($insertRow){
	if($data['rights']['UNPOSTED']==0){	
	if($type==2){
	$descrip=$pname." Qty".$qty." ".$weight."Kg Ft".$feet." @".$rate;
	$stocka = $this->db->query("INSERT INTO $stock(NO,VDATE,JO,PCODE,DESCR,INWGHT,OUTWGHT,INQT,OUTQT,INFT,OUTFT,INAMT,OUTAMT,RATE,DPCODE,B_ID) VALUES ('$no','$vdate','$voucher_Jo','$pcode','$descrip',0,$weight,0,$qty,0,$feet,0,$amount,$rate,'$dpcode','".$this->userData['B_ID']."')");
	}
	}
	}
	$sno++;	
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