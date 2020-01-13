<?php
	class lcInfoModel extends MY_Model{
		
	public function insert($data){
			
	$mainTable="LC1";
	$mainTable2="LC2";
	$voucher_Jo="LC";
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
	$vcode=$data['vname'];
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$vcode),"ANAME","");
	if(!empty($cnm)){
	$vname=$cnm[0]['ANAME'];	
	$addr="None";	
	}
	
	$iid=$data['indentor'];
	$crm=$this->getData("INDENTOR",array("ID"=>$iid),"INDENTOR","");
	if(!empty($crm)){
	$indentor=$crm[0]['INDENTOR'];		
	}
	
	$bcode=$data['bank'];
	$crm=$this->getData("BANK",array("BCODE"=>$bcode),"BNAME","");
	if(!empty($crm)){
	$bname=$crm[0]['BNAME'];		
	}
	
	$bnid=$data['lcbond'];
	$lcbond="";
	$crm=$this->getData("LCBOND",array("ID"=>$bnid),"LCBOND","");
	if(!empty($crm)){
	$lcbond=$crm[0]['LCBOND'];		
	}
	
	$lccode=$data['lccode'];
	$cbm=$this->getData("ACCOUNT",array("ACODE"=>$lccode),"ANAME","");
	if(!empty($cbm)){
	$lcname=$cbm[0]['ANAME'];		
	}
	
	
	
	$lcode=$data['lcode'];
	$lcno=$data['lcno'];
	$lcdate=$data['lcdate'];
	if($lcdate==""){
	$lcdate=$vdate;	
	}
	else{
	$lcdate=$this->dateFormat($lcdate);
	}
	$lctype=$data['lctype'];
	$etd=$data['etd'];
	if($etd==""){
	$etd=$vdate;	
	}
	else{
	$etd=$this->dateFormat($etd);
	}
	$eta=$data['eta'];
	if($eta==""){
	$eta=$vdate;	
	}
	else{
	$eta=$this->dateFormat($eta);
	}
	$mdate=$data['mdate'];
	if($mdate==""){
	$mdate=$vdate;	
	}
	else{
	$mdate=$this->dateFormat($mdate);
	}
	$tracking=$data['tracking'];
	$destination=$data['destination'];
	$origin=$data['origin'];
	$currency=$data['currency'];
	$conversion=$data['conversion'];

	$tqty=removecommas($data['tqty']);
	$tweight=removecommas($data['tweight']);
	$fctamount=removecommas($data['fctamount']);
	$tamount=removecommas($data['tamount']);
		
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,LCCODE,LCNAME,VCODE,VNAME,LCODE,LCNO,LCDATE,LCTYPE,IID,INDENTOR,ETA,ETD,MDATE,TRACKING,DESTINATION,ORIGIN,CURRENCY,CONVERSION,BNID,LCBOND,BCODE,BNAME,TQTY,TWEIGHT,FCTAMOUNT,TAMOUNT,U_ID,B_ID,UNPOSTED,POSTED,APPROVED) VALUES ('$no','$vdate','$lccode','$lcname','$vcode','$vname','$lcode','$lcno','$lcdate','$lctype','$iid','$indentor','$eta','$etd','$mdate','$tracking','$destination','$origin','$currency','$conversion','$bnid','$lcbond','$bcode','$bname','$tqty','$tweight','$fctamount','$tamount','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
		
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
	$fcrate=removecommas($data['fcrate_'.$row.'']);
	$rate=removecommas($data['rate_'.$row.'']);
	$amount=removecommas($data['amount_'.$row.'']);
	$fcamount=removecommas($data['fcamount_'.$row.'']);

	
	$cnm=$this->getData("PRODUCT",array("PCODE"=>$pcode),"PNAME","");
	if(!empty($cnm)){
	$pname=$cnm[0]['PNAME'];	
	}
	
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,VCODE,LCNO,LCCODE,PCODE,PNAME,UNIT,COIL,QTY,WEIGHT,FCRATE,RATE,FCAMOUNT,AMOUNT,SNO,U_ID,B_ID) VALUES ('$no','$vdate','$vcode','$lcno','$lccode','$pcode','$pname','$unit','$coil','$qty','$weight','$fcrate','$rate','$fcamount','$amount','$sno','".$this->userData['U_ID']."','".$this->userData['B_ID']."')");
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