<?php
	class purchaseModel extends MY_Model{
		
			public function DeleteImg($input,$id,$table){
			$this->db->set($input,"");
			$this->db->where($id);
			$this->db->update($table);
			return true;
			}
			
	public function insert($data){
			
	$mainTable="PURCH1";
	$mainTable2="PURCH2";
	$voucher_Jo="PO";
		
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
	$cnm=$this->getData("PARTY",array("VCODE"=>$vcode),"VNAME","");
	if(!empty($cnm)){
	$vname=$cnm[0]['VNAME'];	
		
	}
	
	
	
	
	
    $vno=$data['vno'];
    $crdays=$data['crdays'];
    $addr=$data['address'];
	$remarks=$data['remarks'];
	$tqty=$data['tqty'];
	$tqty = str_replace(',','',$tqty);
	$tamount=$data['tamount'];
	$tamount = str_replace(',','',$tamount);
	$gstamt=$data['gstamt'];
	$gstamt = str_replace(',','',$gstamt);
	$net=$data['net'];
	$net = str_replace(',','',$net);

	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,VCODE,VNAME,ADDR,REMARKS,VNO,CRDAYS,TQTY,TOTAL,GSTAMT,NET,U_ID,B_ID,UNPOSTED,POSTED,APPROVED) 
	VALUES ('$no','$vdate','$vcode','$vname','$addr','$remarks','$vno','$crdays','$tqty','$tamount','$gstamt','$net','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
	
	
	
	$nrows=$data['nrows'];
	$row=1;
	$sno=1;
	if($insertMain){
	while($row<$nrows){
	//if(!empty($data['pcode_'.$row.''])){
	if($data['amount_'.$row.'']>0 && $data['rate_'.$row.'']>0){
	
	
	$img=$data['img_'.$row.''];
	$design=$data['design_'.$row.''];
	$unit=$data['color_'.$row.''];
	$qty=$data['qty_'.$row.''];
	$qty = str_replace(',','',$qty);
	$rate=$data['rate_'.$row.''];
	$rate = str_replace(',','',$rate);
	$amount=$data['amount_'.$row.''];
	$amount = str_replace(',','',$amount);

	$cnm=$this->getData("DESIGN",array("NAME"=>$design),"NAME,ID","");
	if(!empty($cnm)){
	$pcode=$cnm[0]['ID'];
	$pname=$cnm[0]['NAME'];
    $insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,UNIT,QTY,RATE,AMOUNT,SNO,VCODE,U_ID,B_ID,IMG)
	VALUES ('$no','$vdate','$pcode','$pname','$unit','$qty','$rate','$amount','$sno','$vcode','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$img')");
		
	}
	else{
		
		$max = $this->getMax("DESIGN","ID","");
		$insertRow = $this->db->query("INSERT INTO DESIGN (ID,NAME) VALUES ('$max','$design')");
	$insertRow = $this->db->query("INSERT INTO $mainTable2(NO,VDATE,PCODE,PNAME,UNIT,QTY,RATE,AMOUNT,SNO,VCODE,U_ID,B_ID,IMG)
	VALUES ('$no','$vdate','$max','$design','$unit','$qty','$rate','$amount','$sno','$vcode','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$img')");
	
	}
	



	
	
	$sno++;	
	}
	//}
	$row++;
	}
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VLOG(VDATE,U_ID,B_ID,NO,JO,TYPE) 
	VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo','$post_type')");
	return true;	
	}
	}
	
	}
?>