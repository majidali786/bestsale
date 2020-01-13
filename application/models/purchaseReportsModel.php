<?php
	class purchaseReportsModel extends MY_Model{
	
	public function purchase($data){
	
	if($data['brtype']==1){
	$br=implode(",",$data['branch']);
	$branch="AND T1.B_ID IN ($br)";
	}	
	else{
	$branch="";	
	}
	if($data['ptype']==1){
	$br=implode(",",$data['party']);
	$party="AND T1.VCODE IN ($br)";
	}	
	else{
	$party="";	
	}
	if($data['prtype']==1){
	$br=implode(",",$data['product']);
	$product="AND T2.PCODE IN ($br)";
	}	
	else{
	$product="";	
	}
	if($data['mtype']==1){
	$br=implode(",",$data['mgroup']);
	$mgroup="AND T4.MGID IN ($br)";
	}	
	else{
	$mgroup="";	
	}
	$date1=$data['date1'];
	$date2=$data['date2'];
	$result=$this->query("SELECT T1.VCODE,T1.NO,T1.VDATE,T1.VNO,T1.B_ID,T1.DISCOUNT,T1.OTHERS,T2.PCODE,
	T2.UNIT,T2.QTY,T2.FRATE,T2.FAMOUNT,T2.RATE,T2.AMOUNT,T3.VNAME,T4.PNAME 
	FROM PURCH1 AS T1 INNER JOIN PURCH2 AS T2 ON T1.NO=T2.NO AND T1.B_ID=T2.B_ID 
	LEFT JOIN PARTY AS T3 ON T1.VCODE=T3.VCODE 
	LEFT JOIN PRODUCT AS T4 ON T2.PCODE=T4.PCODE WHERE T1.VDATE >='$date1' AND T1.VDATE <='$date2' $branch $party $product 
	ORDER BY T1.VDATE	
	");
	return $result;		
	}	
	

//purchase order

  public function Purchaseorders($data){
		
	$this->deleteData("PLREP",array("U_ID"=>$this->userData['U_ID']));
	$branch="1";
	if($data['ptype']==1){
	$br=implode(",",$data['party']);
	$party="AND T1.VCODE IN ($br)";
	}	
	else{
	$party="";	
	}
	if($data['prtype']==1){
	$br=implode(",",$data['product']);
	$product="AND T2.PCODE IN ($br)";
	}	
	else{
	$product="";	
	}
	$date1=$data['date1'];
	$date2=$data['date2'];

	$result=$this->query("SELECT T1.VCODE,T1.NO,T1.VDATE,T1.CRDAYS-DATEDIFF(day,T1.VDATE,'$date2') AS PDAYS,T1.VNO,T1.B_ID,T1.CRDAYS
	,T2.PCODE,T2.UNIT,T2.QTY,T2.RATE,T2.AMOUNT,T3.VNAME,T4.NAME,T4.IMG  
	FROM PORDR1 AS T1 INNER JOIN PORDR2 AS T2 ON T1.NO=T2.NO AND T1.B_ID=T2.B_ID 
	LEFT JOIN PARTY AS T3 ON T1.VCODE=T3.VCODE 
	LEFT JOIN DESIGN AS T4 ON T2.PCODE=T4.ID WHERE T1.VDATE >='$date1' AND T1.VDATE <='$date2'  $party $product  
	ORDER BY T1.VDATE
	");
	
 if(!empty($result))
		{
			foreach($result as $select)
			{
				$no = $select['NO'];
				$vdate = $select['VDATE'];
				$vno = $select['VNO'];
				$pcode = $select['PCODE'];
				$pname = $select['NAME'];
				$vcode = $select['VCODE'];
				$vname = $select['VNAME'];
				$unit = $select['UNIT'];
				$qty = $select['QTY'];
				$rate = $select['RATE'];
				$amount = $select['AMOUNT'];
				$pdasys = $select['PDAYS'];
				$crdasys = $select['CRDAYS'];
				
				
				$insert=$this->db->query("INSERT INTO PLREP( NO, VDATE, PCODE, PNAME, UNIT, QTY, RATE, AMOUNT, VCODE, VNAME, U_ID, DATE1, DATE2, VNO, PDAYS, CRDAYS,DCODE) VALUES('$no','$vdate','$pcode','$pname','$unit','$qty','$rate','$amount','$vcode','$vname'
				,'".$this->userData['U_ID']."','$date1','$date2','$vno','$pdasys','$crdasys','$pcode')");		
			}
		} 
		
		
	return $result;
		
	}		


	// Pending Purchase Orders
	public function Pendingorders($data){
		
	$this->deleteData("PLREP",array("U_ID"=>$this->userData['U_ID']));
	if($data['ptype']==1){
	$br=implode(",",$data['party']);
	$party="AND t2.VCODE IN ($br)";
	}	
	else{
	$party="";	
	}
	if($data['stats']==0){
	$stats="AND t1.STATUS NOT IN ('Close')";
	}	
	else{
	$stats="AND t1.STATUS IN ('Close')";
	}

	$date1=$data['date1'];
	$date2=$data['date2'];
	
	$result=$this->query("select t1.NO,t1.PCODE,t1.PNAME,round(t1.bal,2) as QTY,t1.COLOR,t2.VNAME,t1.VDATE,DATEDIFF(day,t1.VDATE,'$date2') AS PDAYS,t1.STATUS,t4.IMG from (
	(SELECT a1.NO,a1.PNAME,a1.PCODE,a1.QTY-SUM(a2.qty) as bal,a1.COLOR,a1.B_ID,a1.VDATE,a1.VCODE,a1.STATUS from PORDR2 a1 
	left join TRANS2 a2 on a1.NO=a2.SONO and a1.B_ID=a2.B_ID and a1.VCODE=a2.VCODE and a1.PCODE=a2.PCODE
	group by a1.NO,a1.PNAME,a1.PCODE,a1.COLOR,a1.B_ID,a1.QTY,a1.PCODE,a1.VDATE,a1.VCODE,a1.STATUS
	having a1.QTY<> SUM(a2.qty)) union all
	(SELECT a1.NO,a1.PNAME,a1.PCODE,a1.QTY,a1.COLOR,a1.B_ID as bal,a1.VDATE,a1.VCODE,a1.STATUS from PORDR2 a1 
	left join TRANS2 a2 on a1.NO=a2.SONO and a1.B_ID=a2.B_ID and a1.VCODE=a2.VCODE and a1.PCODE=a2.PCODE
	where a2.PCODE is null
	group by a1.NO,a1.PNAME,a1.QTY,a1.PCODE,a1.COLOR,a1.B_ID,a1.VDATE,a1.VCODE,a1.STATUS)) t1 
	left join PARTY t2 on t1.VCODE=t2.VCODE
	left join DESIGN t4 on t1.PCODE=t4.ID
	where t1.VDATE>='$date1' and t1.VDATE<='$date2' $party $stats
	group by t1.NO,t1.PCODE,t1.bal,t1.PNAME,t1.COLOR,t1.VDATE,t2.VNAME,t1.STATUS,t4.IMG
	order by t1.NO asc
");

if(!empty($result))
		{
			foreach($result as $select)
			{
				$no = $select['NO'];
				$vdate = $select['VDATE'];
				$pcode = $select['PCODE'];
				$pname = $select['PNAME'];
				$vname = $select['VNAME'];
				$pname = $select['PNAME'];
				$qty = $select['QTY'];
				$color = $select['COLOR'];
				$pdasys = $select['PDAYS'];
				$status = $select['STATUS'];
				$insert=$this->db->query("INSERT INTO PLREP( NO, VDATE, DCODE, PCODE, PNAME, COLOR, QTY, VNAME, U_ID, DATE1, DATE2, PDAYS, STATUS) VALUES('$no','$vdate','$pcode','$pcode','$pname','$color','$qty','$vname'
				,'".$this->userData['U_ID']."','$date1','$date2','$pdasys','$status')");
			}
		}
	return $result;
	
	
		
	}
	
	

/// trnasfershipment




   public function transfership($data){
	$this->deleteData("PLREP",array("U_ID"=>$this->userData['U_ID']));	
	$branch="1";
	if($data['ptype']==1){
	$br=implode(",",$data['party']);
	$party="AND T1.VCODE IN ($br)";
	}	
	else{
	$party="";	
	}
	if($data['prtype']==1){
	$br=implode(",",$data['product']);
	$product="AND T2.PCODE IN ($br)";
	}	
	else{
	$product="";	
	}
	
	
	if($data['rty']==0){
	$sts="AND T1.STATUS2=0";
	}	
	else{
	$sts="AND T1.STATUS2=1";	
	}

	
	$date1=$data['date1'];
	$date2=$data['date2'];
	
	
	$result=$this->query("SELECT T1.VCODE,T1.NO,T1.VDATE,T1.PONO,T1.B_ID,T1.CID,T1.CARGO,T1.CRDAYS,T1.CRDAYS-DATEDIFF(day,T1.VDATE,'$date2') AS PDAYS
	,T2.PCODE,T2.UNIT,T2.QTY,T2.RATE,T2.AMOUNT,T3.VNAME,T4.NAME,T4.IMG  
	FROM TRANS1 AS T1 INNER JOIN TRANS2 AS T2 ON T1.NO=T2.NO AND T1.B_ID=T2.B_ID 
	LEFT JOIN PARTY AS T3 ON T1.VCODE=T3.VCODE 
	LEFT JOIN DESIGN AS T4 ON T2.PCODE=T4.ID WHERE T1.VDATE >='$date1' AND T1.VDATE <='$date2' $sts $party $product  
	ORDER BY T1.VDATE
	");


if(!empty($result))
		{
			foreach($result as $select)
			{
				$no = $select['NO'];
				$vdate = $select['VDATE'];
				$vno = $select['PONO'];
				$pcode = $select['PCODE'];
				$cargo = $select['CARGO'];
				$pname = $select['NAME'];
				$vcode = $select['VCODE'];
				$vname = $select['VNAME'];
				$unit = $select['UNIT'];
				$qty = $select['QTY'];
				$rate = $select['RATE'];
				$amount = $select['AMOUNT'];
				$pdasys = $select['PDAYS'];
				$crdasys = $select['CRDAYS'];
				
				
				$insert=$this->db->query("INSERT INTO PLREP( NO, VDATE, PCODE, PNAME,CARGO, UNIT, QTY, RATE, AMOUNT, VCODE, VNAME, U_ID, DATE1, DATE2, VNO, PDAYS, CRDAYS,DCODE) VALUES('$no','$vdate','$pcode','$pname','$cargo','$unit','$qty','$rate','$amount','$vcode','$vname'
				,'".$this->userData['U_ID']."','$date1','$date2','$vno','$pdasys','$crdasys','$pcode')");		
			}
		}
		
	return $result;
		
	}	
	


	
	
		public function purchaseReturn($data){
	
	if($data['brtype']==1){
	$br=implode(",",$data['branch']);
	$branch="AND T1.B_ID IN ($br)";
	}	
	else{
	$branch="";	
	}
	if($data['ptype']==1){
	$br=implode(",",$data['party']);
	$party="AND T1.VCODE IN ($br)";
	}	
	else{
	$party="";	
	}
	if($data['prtype']==1){
	$br=implode(",",$data['product']);
	$product="AND T2.PCODE IN ($br)";
	}	
	else{
	$product="";	
	}
	if($data['mtype']==1){
	$br=implode(",",$data['mgroup']);
	$mgroup="AND T4.MGID IN ($br)";
	}	
	else{
	$mgroup="";	
	}
	$date1=$data['date1'];
	$date2=$data['date2'];
	$result=$this->query("SELECT T1.VCODE,T1.NO,T1.VDATE,T1.VNO,T1.B_ID,T1.DISCOUNT,T1.OTHERS,T2.PCODE,
	T2.UNIT,T2.QTY,T2.FRATE,T2.FAMOUNT,T2.RATE,T2.AMOUNT,T3.VNAME,T4.PNAME 
	FROM PRET1 AS T1 INNER JOIN PRET2 AS T2 ON T1.NO=T2.NO AND T1.B_ID=T2.B_ID 
	LEFT JOIN PARTY AS T3 ON T1.VCODE=T3.VCODE 
	LEFT JOIN PRODUCT AS T4 ON T2.PCODE=T4.PCODE WHERE T1.VDATE >='$date1' AND T1.VDATE <='$date2' $branch $party $product 
	ORDER BY T1.VDATE	
	");
	return $result;		
	}
	
	
	}
	
?>