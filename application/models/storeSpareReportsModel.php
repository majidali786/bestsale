<?php
	class storeSpareReportsModel extends MY_Model{
	
	public function stockTransfer($data){
		
	if($data['brtype']==1){
	$br=implode(",",$data['branch']);
	$branch="AND T2.B_ID IN ($br)";
	}	
	else{
	$branch="";	
	}
	if($data['fdptype']==1){
	$br=implode(",",$data['fdepartment']);
	$fdepartment="AND T2.FDPCODE IN ($br)";
	}	
	else{
	$fdepartment="";	
	}
	if($data['tdptype']==1){
	$br=implode(",",$data['tdepartment']);
	$tdepartment="AND T2.TDPCODE IN ($br)";
	}	
	else{
	$tdepartment="";	
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
	$mgroup="AND T5.MGID IN ($br)";
	}	
	else{
	$mgroup="";	
	}
	if($data['stype']==1){
	$br=implode(",",$data['size']);
	$size="AND T5.SID IN ($br)";
	}	
	else{
	$size="";	
	}
	if($data['ottype']==1){
	$br=implode(",",$data['outerdia']);
	$outerdia="AND T5.OTID IN ($br)";
	}	
	else{
	$outerdia="";	
	}
	if($data['ctype']==1){
	$br=implode(",",$data['coil']);
	$coil="AND T5.CID IN ($br)";
	}	
	else{
	$coil="";	
	}
	if($data['gatype']==1){
	$br=implode(",",$data['gauge']);
	$gauge="AND T5.GID IN ($br)";
	}	
	else{
	$gauge="";	
	}
	if($data['utype']==1){
	$br=implode(",",$data['unit']);
	$unit="AND T5.UID IN ($br)";
	}	
	else{
	$unit="";	
	}
	if($data['wtype']==1){
	$br=implode(",",$data['weight']);
	$weight="AND T5.WID IN ($br)";
	}	
	else{
	$weight="";	
	}
	if($data['intype']==1){
	$br=implode(",",$data['innerdia']);
	$innerdia="AND T5.INID IN ($br)";
	}	
	else{
	$innerdia="";	
	}
	if($data['otype']==1){
	$br=implode(",",$data['others']);
	$others="AND T5.OID IN ($br)";
	}	
	else{
	$others="";	
	}
	if($data['ftype']==1){
	$br=implode(",",$data['feet']);
	$feet="AND T5.FID IN ($br)";
	}	
	else{
	$feet="";	
	}
	if($data['ntype']==1){
	$br=implode(",",$data['nature']);
	$nature="AND T5.NID IN ($br)";
	}	
	else{
	$nature="";	
	}
	if($data['htype']==1){
	$br=implode(",",$data['hrtype']);
	$hrtype="AND T5.HRID IN ($br)";
	}	
	else{
	$hrtype="";	
	}
	
	
	$date1=$data['date1'];
	$date2=$data['date2'];
	
	$result=$this->query("SELECT T2.NO,T2.VDATE,T2.B_ID,T2.PCODE,T2.UNIT,T2.WEIGHT,T2.QTY,T2.FEET,T2.RATE,T2.AMOUNT,T3.DPName AS FDPNAME,T4.DPName AS TDPNAME,T5.PNAME 
	FROM SSSTRNF2 AS T2
	LEFT JOIN DEPT AS T3 ON T2.FDPCODE=T3.DPCode 
	LEFT JOIN DEPT AS T4 ON T2.TDPCODE=T4.DPCode 
	LEFT JOIN SSPRODUCT AS T5 ON T2.PCODE=T5.PCODE 
	WHERE T2.VDATE >='$date1' AND T2.VDATE <='$date2' $branch $fdepartment $tdepartment  $product $mgroup $size $outerdia $innerdia $coil $others $gauge $feet $unit $nature $weight $hrtype 
	ORDER BY T2.VDATE
	");

	return $result;
		
	}	
	
	public function ledger($data){
		
	if($data['brtype']==1){
	$br=implode(",",$data['branch']);
	$branch="AND T1.B_ID IN ($br)";
	}	
	else{
	$branch="";	
	}
	if($data['dptype']==1){
	$br=implode(",",$data['department']);
	$department="AND T1.DPCODE IN ($br)";
	}	
	else{
	$department="";	
	}

	$date1=$data['date1'];
	$date2=$data['date2'];
	$date3=date("Y-m-d",strtotime("-1 days",strtotime($date1)));
	$result=$this->query("SELECT T1.NO,T1.JO,T1.VDATE,T1.DESCR,T2.PCODE,T2.PNAME,T2.UNIT,T1.INQT,T1.OUTQT,T1.INWGHT,T1.OUTWGHT,T1.INFT,T1.OUTFT,T3.DPName,T1.DPCODE,T1.B_ID,'".$this->userData['U_ID']."','$date1','$date2' FROM STOCK_SS AS T1 INNER JOIN SSPRODUCT AS T2 ON T1.PCODE=T2.PCODE
	LEFT JOIN DEPT AS T3 ON T1.DPCODE=T3.DPCode 
	WHERE T2.PCODE IS NOT NULL AND T1.VDATE >='$date1' AND T1.VDATE <='$date2' AND T1.PCODE='".$data['product']."' $branch $department
	ORDER BY T1.VDATE
	");

	return $result;
		
	}	
	
	public function balance($data){
		
	if($data['brtype']==1){
	$br=implode(",",$data['branch']);
	$branch="AND T1.B_ID IN ($br)";
	}	
	else{
	$branch="";	
	}
	if($data['dptype']==1){
	$br=implode(",",$data['department']);
	$department="AND T1.DPCODE IN ($br)";
	}	
	else{
	$department="";	
	}
	if($data['prtype']==1){
	$br=implode(",",$data['product']);
	$product="AND T1.PCODE IN ($br)";
	}	
	else{
	$product="";	
	}
	if($data['mtype']==1){
	$br=implode(",",$data['mgroup']);
	$mgroup="AND T2.MGID IN ($br)";
	}	
	else{
	$mgroup="";	
	}
	if($data['stype']==1){
	$br=implode(",",$data['size']);
	$size="AND T2.SID IN ($br)";
	}	
	else{
	$size="";	
	}
	if($data['ottype']==1){
	$br=implode(",",$data['outerdia']);
	$outerdia="AND T2.OTID IN ($br)";
	}	
	else{
	$outerdia="";	
	}
	if($data['ctype']==1){
	$br=implode(",",$data['coil']);
	$coil="AND T2.CID IN ($br)";
	}	
	else{
	$coil="";	
	}
	if($data['gatype']==1){
	$br=implode(",",$data['gauge']);
	$gauge="AND T2.GID IN ($br)";
	}	
	else{
	$gauge="";	
	}
	if($data['utype']==1){
	$br=implode(",",$data['unit']);
	$unit="AND T2.UID IN ($br)";
	}	
	else{
	$unit="";	
	}
	if($data['wtype']==1){
	$br=implode(",",$data['weight']);
	$weight="AND T2.WID IN ($br)";
	}	
	else{
	$weight="";	
	}
	if($data['intype']==1){
	$br=implode(",",$data['innerdia']);
	$innerdia="AND T2.INID IN ($br)";
	}	
	else{
	$innerdia="";	
	}
	if($data['otype']==1){
	$br=implode(",",$data['others']);
	$others="AND T2.OID IN ($br)";
	}	
	else{
	$others="";	
	}
	if($data['ftype']==1){
	$br=implode(",",$data['feet']);
	$feet="AND T2.FID IN ($br)";
	}	
	else{
	$feet="";	
	}
	if($data['ntype']==1){
	$br=implode(",",$data['nature']);
	$nature="AND T2.NID IN ($br)";
	}	
	else{
	$nature="";	
	}
	if($data['htype']==1){
	$br=implode(",",$data['hrtype']);
	$hrtype="AND T2.HRID IN ($br)";
	}	
	else{
	$hrtype="";	
	}
	
	
	$vdate=$data['vdate'];
	
	$result=$this->query("SELECT T2.PCODE,T2.PNAME,T2.UNIT,T1.B_ID,SUM(T1.INQT-T1.OUTQT) AS TQT,SUM(T1.INWGHT-T1.OUTWGHT) AS TWGHT,T3.DPName,T1.DPCODE,SUM(T1.INFT-T1.OUTFT) AS TFT,'".$this->userData['U_ID']."','$vdate' FROM STOCK_SS AS T1 INNER JOIN SSPRODUCT AS T2 ON T1.PCODE=T2.PCODE
	LEFT JOIN DEPT AS T3 ON T1.DPCODE=T3.DPCode 
	WHERE T2.PCODE IS NOT NULL AND T1.VDATE <='$vdate' $branch $department $product $mgroup $size $outerdia $innerdia $coil $others $gauge $feet $unit $nature $weight $hrtype 
	GROUP BY T2.PCODE,T2.PNAME,T2.UNIT,T1.B_ID,T3.DPName,T1.DPCODE HAVING SUM(T1.INQT-T1.OUTQT)<>0 OR SUM(T1.INWGHT-T1.OUTWGHT)<>0 OR SUM(T1.INFT-T1.OUTFT)<>0 ORDER BY T2.PNAME ASC
	");

	return $result;
		
	}	
	
		
	public function movement($data){
	if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND T1.B_ID='".$data['branch']."'";		
	}
	$this->deleteData("STKLGR",array("U_ID"=>$this->userData['U_ID']));
	$vdate1=$data['date1'];
	$vdate2=$data['date2'];
	
	$insert=$this->db->query("INSERT INTO STKLGR(PCODE,PNAME,UNIT,B_ID,INQT,QTY,OUTQT,INWGHT,WEIGHT,OUTWGHT,U_ID,DATE1,DATE2) SELECT T2.PCODE,T2.PNAME,T2.UNIT,T1.B_ID,SUM(case when T1.VDATE<'$vdate1' then T1.INQT-T1.OUTQT else 0 end ) AS TQT_op,SUM(case when T1.VDATE>'$vdate1' and T1.VDATE<'$vdate2' then T1.INQT-T1.OUTQT else 0 end ) AS TQT_du,SUM(case when T1.VDATE>'$vdate2' then T1.INQT-T1.OUTQT else 0 end ) AS TQT_cl,SUM(case when T1.VDATE<'$vdate1' then T1.INWGHT-T1.OUTWGHT else 0 end ) AS TWGHT_op, SUM(case when T1.VDATE>'$vdate1' and T1.VDATE<'$vdate2' then T1.INWGHT-T1.OUTWGHT else 0 end ) AS TWGHT_du, SUM(case when T1.VDATE>'$vdate2' then T1.INWGHT-T1.OUTWGHT else 0 end ) AS TWGHT_cl ,'".$this->userData['U_ID']."','$vdate1','$vdate2' FROM STOCK_SS AS T1 INNER JOIN SSPRODUCT AS T2 ON T1.PCODE=T2.PCODE WHERE T2.PCODE IS NOT NULL $branch GROUP BY T2.PCODE,T2.PNAME,T2.UNIT,T1.B_ID HAVING SUM(T1.INQT-T1.OUTQT)<>0 AND SUM(T1.INWGHT-T1.OUTWGHT)<>0 ORDER BY T2.PNAME ASC");
	
	$query2=$this->query("SELECT PCODE,PNAME,UNIT,INQT,QTY,OUTQT,INWGHT,WEIGHT,OUTWGHT,B_ID FROM STKLGR WHERE U_ID='".$this->userData['U_ID']."' GROUP BY PCODE,PNAME,UNIT,INQT,QTY,OUTQT,INWGHT,WEIGHT,OUTWGHT,B_ID ORDER BY PCODE ASC");
	
	return array($query2);
	
	}		
	
	}
	
?>