<?php
	class customerReportsModel extends MY_Model{
		
	public function balance($data){
	if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";		
	}
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$vdate=$data['vdate'];
	$vdate2=$data['vdate2'];
	$vdate3=$data['vdate3'];
	
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,BAL,BAL2,BAL3,DATE1,DATE2,DATE3,U_ID,B_ID)
	SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(CASE WHEN Gnrllgr.VDate<='$vdate' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END)
	AS BAL1,SUM(CASE WHEN Gnrllgr.VDate<='$vdate2' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL2,
	SUM(CASE WHEN Gnrllgr.VDate<='$vdate3' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL3,'$vdate','$vdate2','$vdate3'
	,'".$this->userData['U_ID']."','".$this->userData['UB_ID']."' FROM Gnrllgr INNER JOIN 
	ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode  WHERE ACCOUNT.ATYPE=4 AND ACCOUNT.LEVL=4 $branch GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME
	HAVING SUM(Gnrllgr.DEBIT-Gnrllgr.CREDIT)<>0 ORDER BY ACCOUNT.ANAME ASC");
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."'");
	
	return $query1;
	
	}		
		
	public function listing($data){
	$branch="";	
	if($data['btype']==1){
	$br=implode(",",$data['branch']);
	$branch="AND B_ID IN ($br)";
	}
	$city="";	
	if($data['ctype']==1){
	$br=implode(",",$data['city']);
	$city="AND CID IN ($br)";
	}
	$salesman="";	
	if($data['stype']==1){
	$br=implode(",",$data['salesman']);
	$salesman="AND SID IN ($br)";
	}	
	$query1=$this->query("SELECT * FROM PARTY WHERE ATYPE=4 $branch $city $salesman");
	
	return $query1;
		
	}		
	
	public function ledger($data){
	if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";		
	}
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	
	if($data['rtype']!=1){
		
	
		$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,VDATE,DESCR,U_ID,DATE1,DATE2,B_ID) 
	SELECT gnrllgr.ACode,case WHEN v.VNAME IS NULL Then a.ANAME else  v.VNAME END AS ANAME,CASE WHEN SUM(DEBIT-CREDIT) >0  
	THEN SUM(DEBIT-CREDIT)  ELSE 0 END AS DEBIT,CASE WHEN SUM(DEBIT-CREDIT) < 0  
	THEN SUM(DEBIT-CREDIT)  ELSE 0 END AS CREDIT
	,'$date1','Opening','".$this->userData['U_ID']."','$date1','$date2','".$data['branch']."'  	
	from Gnrllgr  left join ACCOUNT a ON a.ACODE=Gnrllgr.ACode left join PARTY v ON v.VCODE=Gnrllgr.Acode 
	where VDate<'$date1' and Gnrllgr.ACode='".$data['party']."' $branch GROUP BY Gnrllgr.ACode,A.ANAME,V.VNAME");	
		
		
	
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,VNO,U_ID,B_ID,DATE1,DATE2)
	SELECT PARTY.VCODE AS VCODE,PARTY.VNAME,Gnrllgr.DEBIT,Gnrllgr.CREDIT,Gnrllgr.NO,Gnrllgr.Jo,
	Gnrllgr.VDATE,Gnrllgr.Descr,Gnrllgr.VNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2' 
	FROM Gnrllgr INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr.ACode 
	WHERE  Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' $branch
	ORDER BY Gnrllgr.VDATE ASC");
	}
	else if($data['rtype']==1){
		
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,VDATE,DESCR,U_ID,DATE1,DATE2) SELECT '".$data['party']."'
	,PARTY.VNAME,sum(Debit),sum(Credit),$date1,'Opening','".$this->userData['U_ID']."','$date1','$date2'
	from gnrllgr inner join PARTY on Gnrllgr.ACode=PARTY.VCODE where VDate<'$date1' and ACode='".$data['party']."' $branch group by PARTY.VNAME");	
	
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2) 
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,sum(Gnrllgr.DEBIT) as DEBIT,sum(Gnrllgr.CREDIT) as CREDIT,
	Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2' 
	FROM Gnrllgr INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr.ACode WHERE PARTY.ATYPE=0 AND Gnrllgr.ACODE='".$data['party']."' 
	AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' $branch AND Jo NOT IN ('SV','SR') GROUP BY PARTY.VCODE,PARTY.VNAME,
	Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr,Gnrllgr.CHQNO,Gnrllgr.B_ID
	ORDER BY Gnrllgr.VDATE ASC");
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2) 
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,SUM(Gnrllgr.DEBIT) AS DEBIT,SUM(Gnrllgr.CREDIT) AS CREDIT,Gnrllgr.NO,Gnrllgr.Jo,
	Gnrllgr.VDATE,' Inovice # '+CAST(SALE1.NO AS NVARCHAR(100))+' Book No.'+CAST(SALE1.VNO AS NVARCHAR(100)) AS DESCR,
	Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2' FROM Gnrllgr INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr.ACode
	INNER JOIN SALE1 ON Gnrllgr.No=SALE1.NO AND Gnrllgr.B_ID=SALE1.B_ID
	WHERE PARTY.ATYPE=0 AND Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' $branch AND Jo IN ('SV')
	GROUP BY PARTY.VCODE,PARTY.VNAME,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.CHQNO,Gnrllgr.B_ID,SALE1.NO,SALE1.VNO
	ORDER BY Gnrllgr.VDATE ASC
	");
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2) 
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,SUM(Gnrllgr.DEBIT) AS DEBIT,SUM(Gnrllgr.CREDIT) AS CREDIT,
	Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,' Inovice # '+CAST(SRET1.NO AS NVARCHAR(100))+' Book No.'+CAST(SRET1.VNO AS NVARCHAR(100)) AS DESCR,
	Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2' FROM Gnrllgr INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr.ACode 
	INNER JOIN SRET1 ON Gnrllgr.No=SRET1.NO AND Gnrllgr.B_ID=SRET1.B_ID
	WHERE PARTY.ATYPE=0 AND Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2'
	$branch AND Jo IN ('SR')
	GROUP BY PARTY.VCODE,PARTY.VNAME,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.CHQNO,Gnrllgr.B_ID,SRET1.NO,SRET1.VNO
	ORDER BY Gnrllgr.VDATE ASC
	");
	}


	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY VDATE,JO ASC");
	return $query1;
	
	}
			
	public function ledgerChq($data){

	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$this->deleteData("Lgrrep_chq",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	
	if($data['rtype']!=1){
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2)
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,Gnrllgr.DEBIT,Gnrllgr.CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,
	Gnrllgr.Descr,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2' FROM Gnrllgr 
	INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr.ACode  WHERE PARTY.ATYPE=0  AND Gnrllgr.ACODE='".$data['party']."' 
	Gnrllgr.B_ID='".$this->userData['B_ID']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2'
	ORDER BY Gnrllgr.VDATE ASC");
	}
	else if($data['rtype']==1){
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2)
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,Gnrllgr.DEBIT,Gnrllgr.CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr
	,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2' FROM Gnrllgr 
	INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr.ACode 
	WHERE PARTY.ATYPE=0  AND Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.B_ID='".$this->userData['B_ID']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' 
	AND Jo NOT IN ('SV','SR')
	ORDER BY Gnrllgr.VDATE ASC");
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2)
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,SUM(Gnrllgr.DEBIT) AS DEBIT,SUM(Gnrllgr.CREDIT) AS CREDIT,Gnrllgr.NO
	,Gnrllgr.Jo,Gnrllgr.VDATE,CAST(SALE1.STNAME AS NVARCHAR(100))+' Inovice # '+CAST(SALE1.NO AS NVARCHAR(100))+' Book No.'
	+CAST(SALE1.VNO AS NVARCHAR(100)) AS DESCR,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2' 
	FROM Gnrllgr INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr.ACode  
	INNER JOIN SALE1 ON Gnrllgr.No=SALE1.NO AND Gnrllgr.B_ID=SALE1.B_ID
	WHERE PARTY.ATYPE=0 AND Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' AND Jo IN ('SV')
	GROUP BY PARTY.VCODE,PARTY.VNAME,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.CHQNO,Gnrllgr.B_ID,SALE1.NO,SALE1.VNO,SALE1.STNAME
	ORDER BY Gnrllgr.VDATE ASC
	");
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2) 
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,SUM(Gnrllgr.DEBIT) AS DEBIT,SUM(Gnrllgr.CREDIT) AS CREDIT,Gnrllgr.NO,
	Gnrllgr.Jo,Gnrllgr.VDATE,CAST(SRET1.STNAME AS NVARCHAR(100))+' Inovice # '+CAST(SRET1.NO AS NVARCHAR(100))+' Book No.'
	+CAST(SRET1.VNO AS NVARCHAR(100)) AS DESCR,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2' 
	FROM Gnrllgr INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr.ACode  
	INNER JOIN SRET1 ON Gnrllgr.No=SRET1.NO AND Gnrllgr.B_ID=SRET1.B_ID
	WHERE PARTY.ATYPE=0 AND Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' AND Jo IN ('SR')
	GROUP BY PARTY.VCODE,PARTY.VNAME,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.CHQNO,Gnrllgr.B_ID,SRET1.NO,SRET1.VNO,SRET1.STNAME
	ORDER BY Gnrllgr.VDATE ASC
	");
	}
	
	$this->db->query("INSERT INTO Lgrrep_chq(BCODE,BNAME,CHQNO,CHQDATE,DEBIT,BAL,DESCR,NO,U_ID) SELECT 
	T1.BCODE,T1.BNAME,T1.CHQNO,T1.CHQDATE,T1.DEBIT,SUM(T3.CREDIT-T3.DEBIT) AS BAL,T1.DESCR,T1.NO,'".$this->userData['U_ID']."'
	FROM CHQRECIEPT AS T1
	INNER JOIN Gnrllgr_chq AS T3 ON T1.CHQNO=T3.CHQNO AND T1.ACODE=T3.ACODE
	WHERE T1.ACODE ='".$data['party']."'
	GROUP BY T1.NO,T1.BCODE,T1.BNAME,T1.CHQNO,T1.CHQDATE,T1.DEBIT,T1.DESCR
	HAVING SUM(T3.DEBIT-T3.CREDIT)<>0
	ORDER BY T1.CHQDATE ASC");
		
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY VDATE,VNO ASC");
	$query2=$this->query("SELECT * FROM Lgrrep_chq WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY VDATE,VNO ASC");

	return array("data1"=>$query1,"data2"=>$query2);
	
	}
	
	public function chqDetail($data){
		if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";		
	}
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,CHQDATE,BNAME,U_ID,B_ID,DATE1,DATE2) 
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,Gnrllgr_chq.DEBIT,Gnrllgr_chq.CREDIT,Gnrllgr_chq.NO,Gnrllgr_chq.Jo
	,Gnrllgr_chq.VDATE,Gnrllgr_chq.Descr,Gnrllgr_chq.CHQNO,T3.CHQDATE,Gnrllgr_chq.BNAME,'"
	.$this->userData['U_ID']."',Gnrllgr_chq.B_ID,'$date1','$date2' FROM Gnrllgr_chq INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr_chq.ACode 
	LEFT JOIN ( SELECT CHQNO,CHQDATE FROM CHQRECIEPT WHERE ACODE='".$data['party']."' 
	GROUP BY CHQNO,CHQDATE) AS T3 ON Gnrllgr_chq.CHQNO=T3.CHQNO
	WHERE PARTY.ATYPE=0  AND Gnrllgr_chq.ACODE='".$data['party']."' AND Gnrllgr_chq.VDATE >='$date1' AND Gnrllgr_chq.VDATE <='$date2' GROUP BY PARTY.VCODE,PARTY.VNAME,Gnrllgr_chq.Jo,Gnrllgr_chq.VDATE,Gnrllgr_chq.NO,Gnrllgr_chq.B_ID,Gnrllgr_chq.CHQNO,T3.CHQDATE,Gnrllgr_chq.BNAME,Gnrllgr_chq.Descr,Gnrllgr_chq.DEBIT,Gnrllgr_chq.CREDIT
	ORDER BY Gnrllgr_chq.CHQNO,Gnrllgr_chq.VDATE ASC");
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY CHQNO,VDATE ASC");
	
	return $query1;
	
	}
	
	public function invoiceDetail($data){
		if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";		
	}
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2,CDAYS)
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,Gnrllgr.DEBIT,Gnrllgr.CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr
	,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2',T3.NO FROM Gnrllgr
	INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr.ACode 
	LEFT JOIN ( SELECT NO,B_ID FROM SALE1 WHERE VCODE='".$data['party']."' GROUP BY NO,B_ID) AS T3 ON Gnrllgr.SNO=T3.NO 
	AND Gnrllgr.B_ID=T3.B_ID
	WHERE PARTY.ATYPE=0 AND Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND 
	Gnrllgr.VDATE <='$date2' AND Gnrllgr.SNO <>'' AND Gnrllgr.SNO IS NOT NULL GROUP BY PARTY.VCODE,PARTY.VNAME,Gnrllgr.Jo,Gnrllgr.VDATE
	,Gnrllgr.NO,Gnrllgr.B_ID,Gnrllgr.CHQNO,Gnrllgr.Descr,Gnrllgr.DEBIT,Gnrllgr.CREDIT,T3.NO
	ORDER BY Gnrllgr.B_ID,Gnrllgr.NO,Gnrllgr.VDATE ASC");
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY CDAYS,VDATE ASC");
	
	return $query1;
	
	}
	
	public function invoiceCashDetail($data){
		
	
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2,CDAYS) 
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,Gnrllgr.DEBIT,Gnrllgr.CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE
	,Gnrllgr.Descr,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2',T3.NO
	FROM Gnrllgr INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr.ACode 
	LEFT JOIN ( SELECT NO,B_ID,STYPE FROM SALE1 GROUP BY NO,B_ID,STYPE) AS T3 ON Gnrllgr.SNO=T3.NO AND Gnrllgr.B_ID=T3.B_ID
	WHERE PARTY.ATYPE=0 AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' AND Gnrllgr.B_ID='".$this->userData['B_ID']."' AND Gnrllgr.SNO <>'' 
	AND Gnrllgr.SNO IS NOT NULL AND T3.STYPE=0 GROUP BY PARTY.VCODE,PARTY.VNAME,Gnrllgr.Jo,Gnrllgr.VDATE,
	Gnrllgr.NO,Gnrllgr.B_ID,Gnrllgr.CHQNO,Gnrllgr.Descr,Gnrllgr.DEBIT,Gnrllgr.CREDIT,T3.NO
	ORDER BY Gnrllgr.B_ID,Gnrllgr.NO,Gnrllgr.VDATE ASC");
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY CDAYS,VDATE ASC");
	
	return $query1;
	
	}
	
	public function ledgerAll($data){
		if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";		
	}
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$this->deleteData("Lgrrep_age",array("U_ID"=>$this->userData['U_ID']));
	$date=$data['vdate'];

	if($data['party']==0){
	$party="";	
	}
	else{
	$party="AND ACCOUNT.ACODE='".$data['party']."'";		
	}

	$parties=$this->query("SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(Gnrllgr.DEBIT) AS TCREDIT FROM 
	Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode WHERE ACCOUNT.ATYPE=4 AND ACCOUNT.LEVL=4 $party 
	GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME
	HAVING SUM(Gnrllgr.DEBIT-Gnrllgr.CREDIT)<>0 ORDER BY ACCOUNT.ANAME ASC");
	if(!empty($parties)){
	foreach($parties as $a){
		
	$select=$this->query("SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,Gnrllgr.CREDIT,Gnrllgr.NO
	,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr,Gnrllgr.CHQNO,'".$this->userData['U_ID']."' 
	AS U_ID,Gnrllgr.B_ID,DATEDIFF(day,Gnrllgr.VDATE,'$date') AS PDAYS
	FROM Gnrllgr 
	INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode 
	WHERE Gnrllgr.CREDIT>0 AND ACCOUNT.ATYPE=4 AND ACCOUNT.LEVL=4 AND Gnrllgr.ACODE='".$a['ACODE']."' 
	GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.NO,Gnrllgr.B_ID,Gnrllgr.CHQNO,Gnrllgr.Descr,Gnrllgr.CREDIT
	ORDER BY Gnrllgr.VDATE ASC
	");
	$tcredit=$bal15=$bal30=$bal45=$bal60=$bal75=$bal90=$bal105=$bal120=$bal121=$tdebit=0;
	if(!empty($select)){
	$tcredit=$a['TCREDIT'];
	$tdebit=0;
	}
	
	foreach($select as $row){
	$bal=$tcredit-$row['CREDIT'];
	if($bal<0){
	$bal1=abs($bal);	
	$debit=abs($bal);	
	if($tcredit<0){
	$debit=$row['CREDIT'];	
	}
	$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,BAL,NO,JO,VDATE,INVDAYS,U_ID,B_ID) 
	VALUES('".$row['ACODE']."','".$row['ANAME']."','".$debit."',$bal1,'".$row['NO']."','".$row['Jo']."'
	,'".$row['VDATE']."','".$row['PDAYS']."','".$row['U_ID']."','".$row['B_ID']."')");
	$tdebit+=$debit;
	if($row['PDAYS']<=30){
	$bal30+=$debit;	
	}
	else if($row['PDAYS'] >30 && $row['PDAYS']<=45){
	$bal45+=$debit;	
	}
	else if($row['PDAYS'] >45 && $row['PDAYS']<=60){
	$bal60+=$debit;	
	}
	else if($row['PDAYS'] >60 && $row['PDAYS']<=90){
	$bal90+=$debit;	
	}
	else if($row['PDAYS'] >90 && $row['PDAYS']<=120){
	$bal120+=$debit;	
	}
	else if($row['PDAYS'] >120){
	$bal121+=$debit;	
	}
	}
	$tcredit=$bal;
	}
	$update=$this->db->query("UPDATE Lgrrep SET BAL30='$bal30',BAL45='$bal45',BAL60='$bal60',BAL90='$bal90'
	,BAL120='$bal120',BAL121='$bal121',BAL='$tdebit' WHERE U_ID='".$this->userData['U_ID']."' AND ACODE='".$a['ACODE']."'");
	}
	$insert=$this->db->query("INSERT INTO Lgrrep_age(ACODE,ANAME,BAL,BAL30,BAL45,BAL60,BAL90,BAL120,BAL121,U_ID) 
	SELECT ACODE,ANAME,BAL,BAL30,BAL45,BAL60,BAL90,BAL120,BAL121,U_ID FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."' 
	GROUP BY ACODE,ANAME,U_ID,BAL,BAL30,BAL45,BAL60,BAL90,BAL120,BAL121");
	}
	
	$query1=$this->query("SELECT * FROM Lgrrep_age WHERE U_ID='".$this->userData['U_ID']."' ORDER BY ANAME ASC");
	
	return $query1;
	}
	
	public function ledgerAllChqs($data){
		if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";		
	}
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$this->deleteData("Lgrrep_chq",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	
	if($data['rtype']!=1){
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2) 
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,Gnrllgr.DEBIT,Gnrllgr.CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE
	,Gnrllgr.Descr,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2' 
	FROM Gnrllgr INNER JOIN ACCOUNT ON PARTY.VCODE=Gnrllgr.ACode  WHERE ACCOUNT.ATYPE=4 
	AND ACCOUNT.LEVL=4 AND Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' AND Gnrllgr.Jo <>'OP' 
	ORDER BY Gnrllgr.VDATE ASC");
	
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2) 
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,Gnrllgr_old.DEBIT,Gnrllgr_old.CREDIT,Gnrllgr_old.NO,Gnrllgr_old.Jo,Gnrllgr_old.VDATE,Gnrllgr_old.Descr,Gnrllgr_old.CHQNO,'".$this->userData['U_ID']."',Gnrllgr_old.B_ID,'$date1','$date2' FROM Gnrllgr_old INNER JOIN ACCOUNT ON PARTY.VCODE=Gnrllgr_old.ACode INNER JOIN PARTY ON PARTY.VCODE=PARTY.VCODE WHERE ACCOUNT.ATYPE=4 AND ACCOUNT.LEVL=4 AND Gnrllgr_old.ACODE='".$data['party']."' AND Gnrllgr_old.VDATE >='$date1' AND Gnrllgr_old.VDATE <='$date2'  
	ORDER BY Gnrllgr_old.VDATE ASC");
	}
	else if($data['rtype']==1){
	
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2) SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,Gnrllgr.DEBIT,Gnrllgr.CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID ,'$date1','$date2' FROM Gnrllgr INNER JOIN ACCOUNT ON PARTY.VCODE=Gnrllgr.ACode INNER JOIN PARTY ON PARTY.VCODE=PARTY.VCODE WHERE ACCOUNT.ATYPE=4 AND ACCOUNT.LEVL=4 AND Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' AND Jo NOT IN ('SV','SR','OP')
	ORDER BY Gnrllgr.VDATE ASC");
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2) SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,SUM(Gnrllgr.DEBIT) AS DEBIT,SUM(Gnrllgr.CREDIT) AS CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,CAST(SALE1.STNAME AS NVARCHAR(100))+' Inovice # '+CAST(SALE1.NO AS NVARCHAR(100))+' Book No.'+CAST(SALE1.VNO AS NVARCHAR(100)) AS DESCR,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2' FROM Gnrllgr INNER JOIN ACCOUNT ON PARTY.VCODE=Gnrllgr.ACode INNER JOIN PARTY ON PARTY.VCODE=PARTY.VCODE 
	INNER JOIN SALE1 ON Gnrllgr.No=SALE1.NO AND Gnrllgr.B_ID=SALE1.B_ID
	WHERE ACCOUNT.ATYPE=4 AND ACCOUNT.LEVL=4 AND Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' AND Jo IN ('SV')
	GROUP BY PARTY.VCODE,PARTY.VNAME,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.CHQNO,Gnrllgr.B_ID,SALE1.NO,SALE1.VNO,SALE1.STNAME
	ORDER BY Gnrllgr.VDATE ASC
	");
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2) SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,SUM(Gnrllgr.DEBIT) AS DEBIT,SUM(Gnrllgr.CREDIT) AS CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,CAST(SRET1.STNAME AS NVARCHAR(100))+' Inovice # '+CAST(SRET1.NO AS NVARCHAR(100))+' Book No.'+CAST(SRET1.VNO AS NVARCHAR(100)) AS DESCR,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2' FROM Gnrllgr INNER JOIN ACCOUNT ON PARTY.VCODE=Gnrllgr.ACode INNER JOIN PARTY ON PARTY.VCODE=PARTY.VCODE 
	INNER JOIN SRET1 ON Gnrllgr.No=SRET1.NO AND Gnrllgr.B_ID=SRET1.B_ID
	WHERE ACCOUNT.ATYPE=4 AND ACCOUNT.LEVL=4 AND Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' AND Jo IN ('SR')
	GROUP BY PARTY.VCODE,PARTY.VNAME,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.CHQNO,Gnrllgr.B_ID,SRET1.NO,SRET1.VNO,SRET1.STNAME
	ORDER BY Gnrllgr.VDATE ASC
	");
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2) SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,Gnrllgr_old.DEBIT,Gnrllgr_old.CREDIT,Gnrllgr_old.NO,Gnrllgr_old.Jo,Gnrllgr_old.VDATE,Gnrllgr_old.Descr,Gnrllgr_old.CHQNO,'".$this->userData['U_ID']."',Gnrllgr_old.B_ID,'$date1','$date2' FROM Gnrllgr_old INNER JOIN ACCOUNT ON PARTY.VCODE=Gnrllgr_old.ACode INNER JOIN PARTY ON PARTY.VCODE=PARTY.VCODE WHERE ACCOUNT.ATYPE=4 AND ACCOUNT.LEVL=4 AND Gnrllgr_old.ACODE='".$data['party']."' AND Gnrllgr_old.VDATE >='$date1' AND Gnrllgr_old.VDATE <='$date2'  
	ORDER BY Gnrllgr_old.VDATE ASC");
	// $insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID) SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,SUM(Gnrllgr_old.DEBIT),SUM(Gnrllgr_old.CREDIT),Gnrllgr_old.NO,Gnrllgr_old.Jo,Gnrllgr_old.VDATE,'',Gnrllgr_old.CHQNO,'".$this->userData['U_ID']."',Gnrllgr_old.B_ID FROM Gnrllgr_old INNER JOIN ACCOUNT ON PARTY.VCODE=Gnrllgr_old.ACode INNER JOIN PARTY ON PARTY.VCODE=PARTY.VCODE WHERE ACCOUNT.ATYPE=4 AND ACCOUNT.LEVL=4 AND Gnrllgr_old.ACODE='".$data['party']."' AND Gnrllgr_old.VDATE >='$date1' AND Gnrllgr_old.VDATE <='$date2' 
	// GROUP BY PARTY.VCODE,PARTY.VNAME,Gnrllgr_old.NO,Gnrllgr_old.Jo,Gnrllgr_old.VDATE,Gnrllgr_old.CHQNO,Gnrllgr_old.B_ID 
	// ORDER BY Gnrllgr_old.VDATE ASC");
		
	}
	
	
	$this->db->query("INSERT INTO Lgrrep_chq(BCODE,BNAME,CHQNO,CHQDATE,DEBIT,DESCR,NO,U_ID) SELECT 
	T1.BCODE,T1.BNAME,T1.CHQNO,T1.CHQDATE,SUM(T3.CREDIT-T3.DEBIT) AS DEBIT,T1.DESCR,T1.NO,'".$this->userData['U_ID']."'
	FROM CHQRECIEPT AS T1
	INNER JOIN Gnrllgr_chq AS T3 ON T1.CHQNO=T3.CHQNO AND T1.ACODE=T3.ACODE
	WHERE T1.ACODE ='".$data['party']."'
	GROUP BY T1.NO,T1.BCODE,T1.BNAME,T1.CHQNO,T1.CHQDATE,T1.DEBIT,T1.DESCR
	HAVING SUM(T3.DEBIT-T3.CREDIT)<>0
	ORDER BY T1.CHQDATE ASC");
		
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY VDATE ASC");
	$query2=$this->query("SELECT * FROM Lgrrep_chq WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY VDATE ASC");

	return array("data1"=>$query1,"data2"=>$query2);
	
	}
	
	public function aging($data){
		if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";		
	}
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$date=$data['vdate'];
	$select=$this->query("
	SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,Gnrllgr.DEBIT,Gnrllgr.NO
	,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr,Gnrllgr.CHQNO,'".$this->userData['U_ID']."' AS U_ID,
	(SELECT SUM(Gnrllgr.CREDIT) AS TCREDIT FROM Gnrllgr WHERE Gnrllgr.ACODE='".$data['party']."') AS TCREDIT
	,Gnrllgr.B_ID,DATEDIFF(day,Gnrllgr.VDATE,'$date') AS PDAYS
	FROM Gnrllgr 
	INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode 
	
	WHERE Gnrllgr.DEBIT>0 AND ACCOUNT.ATYPE=4 AND ACCOUNT.LEVL=4 AND Gnrllgr.ACODE='".$data['party']."'  $branch
	GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.NO,Gnrllgr.B_ID,Gnrllgr.CHQNO,Gnrllgr.Descr,Gnrllgr.DEBIT
	ORDER BY Gnrllgr.VDATE ASC
	");
	$tcredit=$bal15=$bal30=$bal45=$bal60=$bal75=$bal90=$bal105=$bal120=$bal121=0;
	if(!empty($select)){
	$tcredit=$select[0]['TCREDIT'];
	}
	foreach($select as $row){
	$bal=$tcredit-$row['DEBIT'];
	if($bal<0){
	$bal1=abs($bal);	
	$debit=abs($bal);	
	if($tcredit<0){
	$debit=$row['DEBIT'];	
	}
	$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,BAL,NO,JO,VDATE,INVDAYS,U_ID,B_ID) VALUES('".$row['ACODE']."','".$row['ANAME']."','".$debit."',$bal1,'".$row['NO']."','".$row['Jo']."','".$row['VDATE']."','".$row['PDAYS']."','".$row['U_ID']."','".$row['B_ID']."')");
	if($row['PDAYS']<=15){
	$bal15+=$debit;
	}
	else if($row['PDAYS'] >15 && $row['PDAYS']<=30){
	$bal30+=$debit;	
	}
	else if($row['PDAYS'] >30 && $row['PDAYS']<=45){
	$bal45+=$debit;	
	}
	else if($row['PDAYS'] >45 && $row['PDAYS']<=60){
	$bal60+=$debit;	
	}
	else if($row['PDAYS'] >60 && $row['PDAYS']<=75){
	$bal75+=$debit;	
	}
	else if($row['PDAYS'] >75 && $row['PDAYS']<=90){
	$bal90+=$debit;	
	}
	else if($row['PDAYS'] >90 && $row['PDAYS']<=105){
	$bal105+=$debit;	
	}
	else if($row['PDAYS'] >105 && $row['PDAYS']<=120){
	$bal120+=$debit;	
	}
	else if($row['PDAYS'] >120){
	$bal121+=$debit;	
	}
	}
	$tcredit=$bal;
	}
	$update=$this->db->query("UPDATE Lgrrep SET BAL15='$bal15',BAL30='$bal30',BAL45='$bal45',BAL60='$bal60',BAL75='$bal75',BAL90='$bal90',BAL105='$bal105',BAL120='$bal120',BAL121='$bal121',DATE1='$date' WHERE U_ID='".$this->userData['U_ID']."'");
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."' ORDER BY VDATE ASC");
	
	return $query1;
	
	}
	
	public function balanceComparison($data){
		if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";		
	}
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$this->deleteData("Lgrrep_chq",array("U_ID"=>$this->userData['U_ID']));
	$this->deleteData("Lgrrep_age",array("U_ID"=>$this->userData['U_ID']));
	
	$tmonths=count($data['dates']);
	$vdate=$data['vdate'];		
	
	$this->db->query("INSERT INTO Lgrrep(ANAME,ACODE,CDAYS,CLIMIT,BAL15,BAL30,BAL45,BAL60,BAL75,BAL,U_ID) 
	SELECT T1.VNAME,T1.VCODE,T1.CDAYS,T1.CLIMIT,
	SUM(T2.DEBIT)/$tmonths AS AVSL,SUM(T2.CREDIT)/$tmonths AS AVRC,
	SUM(T2.DEBIT-T2.CREDIT)/$tmonths AS AVBAL,
	(SUM(T2.CREDIT)/$tmonths)*2 AS ESTLMT,((SUM(T2.CREDIT)/$tmonths)*2)-SUM(T2.DEBIT-T2.CREDIT) AS REMLMT,SUM(T2.DEBIT-T2.CREDIT) AS BAL,'".$this->userData['U_ID']."' 
	FROM PARTY AS T1 INNER JOIN Gnrllgr AS T2 ON T1.VCODE=T2.ACODE 
	WHERE T1.VCODE='".$data['party']."' AND VDATE <= '$vdate'
	GROUP BY T1.VNAME,T1.VCODE,T1.CDAYS,T1.CLIMIT
	");
	
	$this->db->query("INSERT INTO Lgrrep_chq (DEBIT,CREDIT,BAL,VDATE,ACODE,U_ID)  SELECT SUM(DEBIT) AS SALES,SUM(CREDIT) AS RECOV,SUM(DEBIT-CREDIT) AS BAL,'2018-' + cast(right('0'+right(datepart(month,VDATE),2),2)as varchar) + '-01',ACODE,'".$this->userData['U_ID']."'  FROM Gnrllgr WHERE ACODE='".$data['party']."' AND month(VDATE) >=month('".$data['dates'][0]."') AND month(VDATE) <=month('$vdate') 
	GROUP BY DATEPART(month, VDATE),ACODE
	ORDER BY DATEPART(month, VDATE)");
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."' ORDER BY VDATE ASC");
	
	
	$select=$this->query("
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,Gnrllgr.DEBIT,Gnrllgr.NO
	,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr,Gnrllgr.CHQNO,'".$this->userData['U_ID']."' AS U_ID,(SELECT SUM(Gnrllgr.CREDIT) AS TCREDIT FROM Gnrllgr WHERE Gnrllgr.ACODE='".$data['party']."') AS TCREDIT
	,Gnrllgr.B_ID,DATEDIFF(day,Gnrllgr.VDATE,'$vdate') AS PDAYS
	FROM Gnrllgr 
	INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr.ACode 
	
	WHERE Gnrllgr.DEBIT>0 AND PARTY.ATYPE=0  AND Gnrllgr.ACODE='".$data['party']."' 
	GROUP BY PARTY.VCODE,PARTY.VNAME,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.NO,Gnrllgr.B_ID,Gnrllgr.CHQNO,Gnrllgr.Descr,Gnrllgr.DEBIT
	ORDER BY Gnrllgr.VDATE ASC
	");
	$tcredit=$bal15=0;
	if(!empty($select)){
	$tcredit=$select[0]['TCREDIT'];
	}
	$daysArr=array();
	foreach($select as $row){
	$bal=$tcredit-$row['DEBIT'];
	if($bal<0){
	$bal1=abs($bal);	
	$debit=abs($bal);	
	if($tcredit<0){
	$debit=$row['DEBIT'];	
	}
	array_push($daysArr,$row['PDAYS']);
	if($row['PDAYS']>$query1[0]['CDAYS']){
	$bal15+=$debit;
	}
	}
	$tcredit=$bal;
	}
	rsort($daysArr);
	$abc=$this->query("
	SELECT VDATE FROM Gnrllgr WHERE ACODE='".$data['party']."' AND CREDIT>0 GROUP BY VDATE ORDER BY VDATE ASC");
	
	$avgBalDay=0;
	$totC=count($abc);
	$prevDate=$data['fdate'];
	$days=0;
	foreach($abc as $d){
	$cdate=$d['VDATE'];
	$diff=date_diff(date_create($cdate),date_create($prevDate));
	$days+=$diff->format("%a");
	$prevDate=$d['VDATE'];
	}
	
	if(!empty($abc)){
	$avgBalDay=round($days/$totC);	
	}
	if(empty($daysArr)){
	array_push($daysArr,0);	
	}
	$this->db->query("INSERT INTO Lgrrep_age(ACODE,INVDAYS,BAL15,BAL,U_ID) 
	VALUES('".$data['party']."',$avgBalDay,'".$daysArr[0]."',$bal15,'".$this->userData['U_ID']."')
	");
	
	$query2=$this->query("SELECT * FROM Lgrrep_chq WHERE U_ID='".$this->userData['U_ID']."' ORDER BY VDATE ASC");
	$query3=$this->query("SELECT * FROM Lgrrep_age WHERE U_ID='".$this->userData['U_ID']."' ORDER BY VDATE ASC");
	
	return array("data1"=>$query1,"data2"=>$query2,"data3"=>$query3);
	}

	public function agingPrevious($data){
	$date=$data['vdate'];
	$this->deleteData("Gnrllgr_merge",array("U_ID"=>$this->userData['U_ID']));
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));

	$insertGnrl=$this->db->query("INSERT INTO Gnrllgr_merge(No,Jo,ACode,VDate,Descr,Debit,Credit,B_ID,U_ID)
	SELECT No,Jo,ACode,VDate,Descr,Debit,Credit,B_ID,'".$this->userData['U_ID']."' FROM Gnrllgr WHERE VDate <='$date' AND Jo<>'OP' AND  ACode='".$data['party']."' "); 
	$insertGnrl=$this->db->query("INSERT INTO Gnrllgr_merge (No,Jo,ACode,VDate,Descr,Debit,Credit,B_ID,U_ID)
	SELECT No,Jo,ACode,VDate,Descr,Debit,Credit,B_ID,'".$this->userData['U_ID']."' FROM Gnrllgr_old WHERE VDate <='$date' AND ACode='".$data['party']."'");

	$select=$this->query("SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,Gnrllgr_merge.DEBIT,Gnrllgr_merge.NO
	,Gnrllgr_merge.Jo,Gnrllgr_merge.VDATE,Gnrllgr_merge.Descr,Gnrllgr_merge.CHQNO,'".$this->userData['U_ID']."' AS U_ID,(SELECT SUM(Gnrllgr_merge.CREDIT) AS TCREDIT FROM Gnrllgr_merge WHERE Gnrllgr_merge.ACODE='".$data['party']."' AND U_ID='".$this->userData['U_ID']."') AS TCREDIT
	,Gnrllgr_merge.B_ID,DATEDIFF(day,Gnrllgr_merge.VDATE,'$date') AS PDAYS
	FROM Gnrllgr_merge 
	INNER JOIN ACCOUNT ON PARTY.VCODE=Gnrllgr_merge.ACode 
	INNER JOIN PARTY ON PARTY.VCODE=PARTY.VCODE 
	WHERE Gnrllgr_merge.DEBIT>0 AND ACCOUNT.ATYPE=4 AND ACCOUNT.LEVL=4 AND Gnrllgr_merge.ACODE='".$data['party']."' AND Gnrllgr_merge.U_ID='".$this->userData['U_ID']."'
	GROUP BY PARTY.VCODE,PARTY.VNAME,Gnrllgr_merge.Jo,Gnrllgr_merge.VDATE,Gnrllgr_merge.NO,Gnrllgr_merge.B_ID,Gnrllgr_merge.CHQNO,Gnrllgr_merge.Descr,Gnrllgr_merge.DEBIT
	ORDER BY Gnrllgr_merge.VDATE ASC
	");
	$tcredit=$bal15=$bal30=$bal45=$bal60=$bal75=$bal90=$bal105=$bal120=$bal121=0;
	if(!empty($select)){
	$tcredit=$select[0]['TCREDIT'];
	}
	foreach($select as $row){
	$bal=$tcredit-$row['DEBIT'];
	if($bal<0){
	$bal1=abs($bal);	
	$debit=abs($bal);	
	if($tcredit<0){
	$debit=$row['DEBIT'];	
	}
	$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,BAL,NO,JO,VDATE,INVDAYS,U_ID,B_ID) VALUES('".$row['ACODE']."','".$row['ANAME']."','".$debit."',$bal1,'".$row['NO']."','".$row['Jo']."','".$row['VDATE']."','".$row['PDAYS']."','".$row['U_ID']."','".$row['B_ID']."')");
	if($row['PDAYS']<=15){
	$bal15+=$debit;
	}
	else if($row['PDAYS'] >15 && $row['PDAYS']<=30){
	$bal30+=$debit;	
	}
	else if($row['PDAYS'] >30 && $row['PDAYS']<=45){
	$bal45+=$debit;	
	}
	else if($row['PDAYS'] >45 && $row['PDAYS']<=60){
	$bal60+=$debit;	
	}
	else if($row['PDAYS'] >60 && $row['PDAYS']<=75){
	$bal75+=$debit;	
	}
	else if($row['PDAYS'] >75 && $row['PDAYS']<=90){
	$bal90+=$debit;	
	}
	else if($row['PDAYS'] >90 && $row['PDAYS']<=105){
	$bal105+=$debit;	
	}
	else if($row['PDAYS'] >105 && $row['PDAYS']<=120){
	$bal120+=$debit;	
	}
	else if($row['PDAYS'] >120){
	$bal121+=$debit;	
	}
	}
	$tcredit=$bal;
	}
	$update=$this->db->query("UPDATE Lgrrep SET BAL15='$bal15',BAL30='$bal30',BAL45='$bal45',BAL60='$bal60',BAL75='$bal75',BAL90='$bal90',BAL105='$bal105',BAL120='$bal120',BAL121='$bal121' WHERE U_ID='".$this->userData['U_ID']."'");
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."' ORDER BY VDATE ASC");
	
	return $query1;
	
	}
	
	public function spersonRecoveryChq($data){
		
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	
	$date1=$data['date1'];
	$date2=$data['date2'];
	
	if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND PARTY.B_ID='".$data['branch']."'";		
	}
	if($data['sperson']==0){
	$sperson="";	
	}
	else{
	$sperson="AND PARTY.SID='".$data['sperson']."'";		
	}
	
	
	$this->db->query("
	INSERT INTO Lgrrep(ACODE,ANAME,CDAYS,CLIMIT,SPERSON,CREDIT,DEBIT,BAL,BAL2,BAL3,U_ID) 
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,PARTY.CDAYS,PARTY.CLIMIT,PARTY.SPERSON,SUM(CASE WHEN Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' THEN Gnrllgr.CREDIT ELSE 0 END) AS TCREDIT,SUM(CASE WHEN Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' THEN Gnrllgr.DEBIT ELSE 0 END) AS TDEBIT,SUM(CASE WHEN Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' THEN Gnrllgr.DEBIT-Gnrllgr.CREDIT ELSE 0 END) AS BAL,CHQS.DEBIT AS CHQBALANCE,SUM(CASE WHEN Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' THEN Gnrllgr.DEBIT-Gnrllgr.CREDIT ELSE 0 END)-ISNULL(CHQS.DEBIT,0) AS REMA,'".$this->userData['U_ID']."' FROM Gnrllgr INNER JOIN ACCOUNT ON PARTY.VCODE=Gnrllgr.ACode INNER JOIN PARTY ON PARTY.VCODE=PARTY.VCODE  
	LEFT JOIN (SELECT 
	T1.ACODE,SUM(T3.CREDIT-T3.DEBIT) AS DEBIT
	FROM CHQRECIEPT AS T1
	INNER JOIN Gnrllgr_chq AS T3 ON T1.CHQNO=T3.CHQNO AND T1.ACODE=T3.ACODE
	GROUP BY T1.ACODE
	HAVING SUM(T3.DEBIT-T3.CREDIT)<>0 ) AS CHQS ON PARTY.VCODE=CHQS.ACODE 
	WHERE ACCOUNT.ATYPE=4 AND ACCOUNT.LEVL=4 $branch $sperson GROUP BY PARTY.VCODE,PARTY.VNAME,PARTY.CDAYS,PARTY.CLIMIT,CHQS.DEBIT,PARTY.SPERSON
	ORDER BY PARTY.VNAME ASC");
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."' ORDER BY ANAME ASC");
	
	return $query1;
	}
	
	public function spersonRecoveryChqGraph($data){
		
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	
	$vdate=$data['vdate'];		
	
	if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND PARTY.B_ID='".$data['branch']."'";		
	}
	if($data['sperson']==0){
	$sperson="";	
	}
	else{
	$sperson="AND PARTY.SID='".$data['sperson']."'";		
	}
	
	$this->db->query("
	INSERT INTO Lgrrep(DEBIT,CREDIT,SPERSON,FROOM,TOO,U_ID)
	SELECT SUM(TDEBIT) AS TDEBIT,SUM(TCREDIT) AS TCREDIT,SPERSON,DATEPART(MONTH,VDATE) AS MNTH,DATEPART(YEAR,VDATE) AS YER,U_ID FROM (
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,PARTY.SPERSON,Gnrllgr.VDATE,SUM(Gnrllgr.CREDIT) AS TCREDIT,SUM(Gnrllgr.DEBIT) AS TDEBIT,'".$this->userData['U_ID']."' AS U_ID FROM Gnrllgr INNER JOIN ACCOUNT ON PARTY.VCODE=Gnrllgr.ACode INNER JOIN PARTY ON PARTY.VCODE=PARTY.VCODE   
	WHERE ACCOUNT.ATYPE=4 AND ACCOUNT.LEVL=4 AND Gnrllgr.VDATE <='$vdate' $branch $sperson GROUP BY PARTY.VCODE,PARTY.VNAME,PARTY.SPERSON,Gnrllgr.VDATE)
	AS L1 GROUP BY DATEPART(MONTH,VDATE),DATEPART(YEAR,VDATE),SPERSON,U_ID
	ORDER BY SPERSON,YER,MNTH
	");
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."' ORDER BY ANAME ASC");
	
	return $query1;
	}
	
	public function agingAll($data){
		if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";		
	}
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$this->deleteData("Lgrrep_age",array("U_ID"=>$this->userData['U_ID']));
	$date=$data['vdate'];
	
	$vdate1=date("Y-m-d",strtotime("-1 month",strtotime($date)));
	$vdate2=date("Y-m-d",strtotime("-2 month",strtotime($date)));
	$vdate3=date("Y-m-d",strtotime("-3 month",strtotime($date)));
	$d1 = date('M/Y', strtotime($vdate1));
	$d2 = date('M/Y', strtotime($vdate2));
	$d3 = date('M/Y', strtotime($vdate3));
	$mn1 = date('m', strtotime($vdate1));
	$mn2 = date('m', strtotime($vdate2));
	$mn3 = date('m', strtotime($vdate3));
	$sdate1 =date("$mn1/01/Y", strtotime($vdate1));
	$sdate2 =date("$mn2/01/Y", strtotime($vdate2));
	$sdate3 =date("$mn3/01/Y", strtotime($vdate3));
	$edate1 =date("$mn1/t/Y", strtotime($vdate1));
	$edate2 =date("$mn2/t/Y", strtotime($vdate2));
	$edate3 =date("$mn3/t/Y", strtotime($vdate3));
	
	
	if($data['party']==0){
	$party="";	
	}
	else{
	$party="AND PARTY.VCODE='".$data['party']."'";		
	}

	$parties=$this->query("SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,PARTY.CDAYS,(case when PARTY.CHEQUE='0' 
	then 'Cash' else 'Cheque' end) as CHEQUE,SUM(Gnrllgr.Credit) AS TCREDIT,AVG(T3.BAL) AS CHQBAL,
	PTYPE,(case when PARTY.SID='15' then 'ZZ' else 'XY' end) as CTYPE FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode 
	INNER JOIN PARTY ON PARTY.VCODE=ACCOUNT.ACODE 
	LEFT JOIN (SELECT ACODE,SUM(CREDIT-DEBIT) AS BAL FROM Gnrllgr_chq GROUP BY ACode  ) AS T3 ON ACCOUNT.ACODE=T3.ACODE 
	WHERE ACCOUNT.ATYPE=4 AND ACCOUNT.LEVL=4 $branch  $party GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME,PARTY.CDAYS,PARTY.CHEQUE,PTYPE,PARTY.SID
	HAVING SUM(Gnrllgr.DEBIT-Gnrllgr.CREDIT)>0 ORDER BY ACCOUNT.ANAME ASC");
	if(!empty($parties)){
	foreach($parties as $a){
		
	$select=$this->query("SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,PARTY.SID,PARTY.SPERSON,Gnrllgr.DEBIT,Gnrllgr.NO
	,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr,Gnrllgr.CHQNO,'".$this->userData['U_ID']."' AS U_ID,Gnrllgr.B_ID,
	DATEDIFF(day,Gnrllgr.VDATE,'$date') AS PDAYS
	FROM Gnrllgr 
	INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode 
	INNER JOIN PARTY ON PARTY.VCODE=ACCOUNT.ACODE 
	WHERE Gnrllgr.DEBIT>0 AND ACCOUNT.ATYPE=4 AND ACCOUNT.LEVL=4 AND Gnrllgr.ACODE='".$a['ACODE']."' 
	GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.NO,Gnrllgr.B_ID,Gnrllgr.CHQNO
	,Gnrllgr.Descr,Gnrllgr.DEBIT,PARTY.SID,PARTY.SPERSON
	ORDER BY Gnrllgr.VDATE ASC
	");
	$cdays=$a['CDAYS'];
	$tcredit=$bal15=$bal30=$bal45=$bal60=$bal75=$bal90=$bal105=$bal120=$bal121=$dbal=0;
	if(!empty($select)){
	$tcredit=$a['TCREDIT'];
	$tdebit=0;
	}
	foreach($select as $row){
	$bal=$tcredit-$row['DEBIT'];
	if($bal<0){
	$bal1=abs($bal);	
	$debit=abs($bal);	
	if($tcredit<0){
	$debit=$row['DEBIT'];	
	}
	$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,BAL,NO,JO,VDATE,INVDAYS,U_ID,B_ID,SPERSON,SNAME,DESCR,BNAME) 
	VALUES('".$row['ACODE']."','".$row['ANAME']."','".$debit."',$bal1,'".$row['NO']."','".$row['Jo']."','".$row['VDATE']."'
	,'".$row['PDAYS']."','".$row['U_ID']."','".$row['B_ID']."','".$row['SID']."','".$row['SPERSON']."','".$a['CHEQUE']."','".$a['CTYPE']."')");
	$tdebit+=$debit;
	if($row['PDAYS']<=15){
	$bal15+=$debit;	
		if($cdays<=15)	{
			$dbal+=$debit;
		}
	}
	else if($row['PDAYS'] >15 && $row['PDAYS']<=30){
	$bal30+=$debit;	
		if($cdays<=30)	{
			$dbal+=$debit;
		}
	}
	else if($row['PDAYS'] >30 && $row['PDAYS']<=45){
	$bal45+=$debit;	
		if($cdays<=45)	{
			$dbal+=$debit;
		}
	}
	else if($row['PDAYS'] >45 && $row['PDAYS']<=60){
	$bal60+=$debit;	
		if($cdays<=60)	{
			$dbal+=$debit;
		}
	}
	else if($row['PDAYS'] >60 && $row['PDAYS']<=90){
	$bal90+=$debit;	
		if($cdays<=90)	{
			$dbal+=$debit;
		}
	}
	else if($row['PDAYS'] >90){
	$bal120+=$debit;
		if($cdays<90)	{
			$dbal+=$debit;
		}	
	}
	}
	$tcredit=$bal;
	}
	$chqbal=$a['CHQBAL'];
	$tot_val=$this->query("SELECT 
	SUM(CASE when VDate<='$date' and Jo in ('SV','SR','OP') then Debit-Credit else 0 end) as t_sale,
	SUM(CASE when VDate>='$sdate3' and VDate<='$edate3' and Jo in ('SV','SR','OP') then Debit-Credit else 0 end) as t_sale1,
	SUM(CASE when VDate>='$sdate2' and VDate<='$edate2' and Jo in ('SV','SR','OP') then Debit-Credit else 0 end) as t_sale2,
	SUM(CASE when VDate>='$sdate1' and VDate<='$edate1' and Jo in ('SV','SR','OP') then Debit-Credit else 0 end) as t_sale3,
	SUM(CASE when VDate>='$sdate3' and VDate<='$edate3' and Jo in ('CR','BR','OP') then Credit else 0 end) as t_rec1,
	SUM(CASE when VDate>='$sdate2' and VDate<='$edate2' and Jo in ('CR','BR','OP') then Credit else 0 end) as t_rec2,
	SUM(CASE when VDate>='$sdate1' and VDate<='$edate1' and Jo in ('CR','BR','OP') then Credit else 0 end) as t_rec3,
	SUM(CASE when VDate<='$date' and Jo in ('CR','BR','OP') then Credit else 0 end) as t_rec from Gnrllgr where ACODE='".$a['ACODE']."'");
	if(!empty($tot_val)){
	$update=$this->db->query("UPDATE Lgrrep SET BAL15='$bal15',BAL30='$bal30',BAL60='$bal60',BAL45='$bal45',BAL90='$bal90',BAL120='$bal120'
	,BAL='$tdebit',BAL2='$chqbal',CDAYS='$cdays',T_SALE='".$tot_val[0]['t_sale']."',T_REC='".$tot_val[0]['t_rec']."',SALE1='".$tot_val[0]['t_sale1']."',SALE2='".$tot_val[0]['t_sale2']."',SALE3='".$tot_val[0]['t_sale3']."',REC1='".$tot_val[0]['t_rec1']."',REC2='".$tot_val[0]['t_rec2']."',REC3='".$tot_val[0]['t_rec3']."',BAL105='$dbal' WHERE U_ID='".$this->userData['U_ID']."' AND ACODE='".$a['ACODE']."'");
	}	else {
	$update=$this->db->query("UPDATE Lgrrep SET BAL15='$bal15',BAL30='$bal30',BAL60='$bal60',BAL45='$bal45',BAL90='$bal90',BAL120='$bal120'
	,BAL='$tdebit',BAL2='$chqbal',BAL105='$dbal',CDAYS='$cdays' WHERE U_ID='".$this->userData['U_ID']."' AND ACODE='".$a['ACODE']."'");
	}	
	$cash_sle=$this->query("select sum(NET) as net from SALE1 where STYPE=0 and VCODE='".$a['ACODE']."'");
	if(!empty($cash_sle)){
	$update=$this->db->query("UPDATE Lgrrep SET BAL121='".$cash_sle[0]['net']."' WHERE U_ID='".$this->userData['U_ID']."' 
	AND ACODE='".$a['ACODE']."'");
	}
	}
	
	/* $uptsale=$this->db->query("select SUM(CASE when a1.VDate<='2018-08-31' and a1.Jo in ('SV','SR','OP') then a1.Debit-a1.Credit else 0 end) as t_sale,
SUM(CASE when a1.VDate>='2018-05-01' and a1.VDate<='2018-05-30' and a1.Jo in ('SV','SR','OP') then a1.Debit-a1.Credit else 0 end) as t_sale1,
SUM(CASE when a1.VDate>='2018-06-01' and a1.VDate<='2018-06-30' and a1.Jo in ('SV','SR','OP') then a1.Debit-a1.Credit else 0 end) as t_sale2,
SUM(CASE when a1.VDate>='2018-07-01' and a1.VDate<='2018-07-30' and a1.Jo in ('SV','SR','OP') then a1.Debit-a1.Credit else 0 end) as t_sale3,
SUM(CASE when a1.VDate>='2018-05-01' and a1.VDate<='2018-05-30' and a1.Jo in ('CR','BR','OP') then a1.Credit else 0 end) as t_rec1,
SUM(CASE when a1.VDate>='2018-06-01' and a1.VDate<='2018-06-30' and a1.Jo in ('CR','BR','OP') then a1.Credit else 0 end) as t_rec2,
SUM(CASE when a1.VDate>='2018-07-01' and a1.VDate<='2018-07-30' and a1.Jo in ('CR','BR','OP') then a1.Credit else 0 end) as t_rec3,
SUM(CASE when a1.VDate<='2018-08-31' and a1.Jo in ('CR','BR','OP') then a1.Credit else 0 end) as t_rec,a2.ACODE 
from Gnrllgr a1 inner join Lgrrep a2 on a1.ACode = a2.ACODE and a2.U_ID='admin'
group by a2.acode"); */
	
	$insert=$this->db->query("INSERT INTO Lgrrep_age(ACODE,ANAME,BAL,BAL15,BAL30,BAL45,BAL60,BAL90,BAL120,BAL2,CDAYS,U_ID,
	SNAME,SPERSON,DATE1,T_SALE,T_REC,SALE1,SALE2,SALE3,REC1,REC2,REC3,DESCR,BAL121,BAL105,JO) 
	SELECT ACODE,ANAME,BAL,BAL15,BAL30,BAL45,BAL60,BAL90,BAL120,BAL2,CDAYS,U_ID,SNAME,SPERSON,'$date',T_SALE,T_REC,SALE1,SALE2,
	SALE3,REC1,REC2,REC3,DESCR,BAL121,BAL105,BNAME FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."' GROUP BY ACODE,ANAME,U_ID,BAL,BAL15,BAL30,BAL45,BAL60,BAL90,BAL120,BAL2,CDAYS,T_SALE,T_REC,SNAME,SPERSON,SALE1,SALE2,SALE3,REC1,REC2,REC3,DESCR,BAL121,BAL105,BNAME");
	}
	
	$query1=$this->db->query("update Lgrrep_age set INVDAYS = a2.INVDAYS from Lgrrep_age a1 inner join Lgrrep a2 on a1.ACODE = a2.ACODE and a1.U_ID=a2.U_ID and a1.U_ID='".$this->userData['U_ID']."'");
	
	$query1=$this->query("SELECT * FROM  Lgrrep_age where U_ID='".$this->userData['U_ID']."' ORDER BY ANAME ASC");
	
	return $query1;
	}
	
	public function salesmanAging($data){
		
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	
	if($data['sperson']==0){
	$sperson="";	
	}
	else{
	$sperson="AND a2.SID='".$data['sperson']."'";		
	}
	$query1=$this->query("SELECT SUM(CASE when VDate<='$date1' then Debit-Credit else 0 end) as op,
	SUM(CASE when VDate>'$date1' and VDate<'$date2' and Jo in ('SV','SR','OP') then Debit-Credit else 0 end) as sale,
	SUM(CASE when VDate>'$date1' and VDate<'$date2' and Jo in ('CR','BR') then Credit else 0 end) as recovry,
	a2.vcode,a2.VNAME,SID,SPERSON
	from gnrllgr a1 inner join PARTY a2 on a1.ACode=a2.vcode and a2.ATYPE='4' $sperson
	group by a2.vcode,a2.VNAME,SID,SPERSON");
	
	return $query1;
	}
	
	public function agingAllPrevious($data){
	$date=$data['vdate'];	
	
	$this->deleteData("Gnrllgr_merge",array("U_ID"=>$this->userData['U_ID']));
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$this->deleteData("Lgrrep_age",array("U_ID"=>$this->userData['U_ID']));
	if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND PARTY.B_ID='".$data['branch']."'";		
	}
	if($data['party']==0){
	$party="";	
	$party_m="";		
	}
	else{
	$party="AND PARTY.VCODE='".$data['party']."'";		
	$party_m="AND ACode='".$data['party']."'";		
	}
	if($data['sperson']==0){
	$sperson="";	
	}
	else{
	$sperson="AND PARTY.SID='".$data['sperson']."'";		
	}
	$insertGnrl=$this->db->query("INSERT INTO Gnrllgr_merge(No,Jo,ACode,VDate,Descr,Debit,Credit,B_ID,U_ID) SELECT No,Jo,ACode,VDate,Descr,Debit,Credit,B_ID,'".$this->userData['U_ID']."' FROM Gnrllgr WHERE VDate <='$date' AND Jo<>'OP' $party_m "); 
	$insertGnrl=$this->db->query("INSERT INTO Gnrllgr_merge (No,Jo,ACode,VDate,Descr,Debit,Credit,B_ID,U_ID) SELECT No,Jo,ACode,VDate,Descr,Debit,Credit,B_ID,'".$this->userData['U_ID']."' FROM Gnrllgr_old WHERE VDate <='$date' $party_m");
	
	
	$parties=$this->query("SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,PARTY.CDAYS,SUM(Gnrllgr_merge.Credit) AS TCREDIT,AVG(T3.BAL) AS CHQBAL FROM Gnrllgr_merge INNER JOIN ACCOUNT ON PARTY.VCODE=Gnrllgr_merge.ACode INNER JOIN PARTY ON PARTY.VCODE=PARTY.VCODE
	LEFT JOIN (SELECT ACODE,SUM(CREDIT-DEBIT) AS BAL FROM Gnrllgr_chq GROUP BY ACode  ) AS T3 ON PARTY.VCODE=T3.ACODE 
	WHERE ACCOUNT.ATYPE=4 AND ACCOUNT.LEVL=4 AND Gnrllgr_merge.U_ID='".$this->userData['U_ID']."' $branch $sperson $party GROUP BY PARTY.VCODE,PARTY.VNAME,PARTY.CDAYS
	HAVING SUM(Gnrllgr_merge.DEBIT-Gnrllgr_merge.CREDIT)>0 ORDER BY PARTY.VNAME ASC");
	
	if(!empty($parties)){
	foreach($parties as $a){
	$tcredit=$bal15=$bal30=$bal45=$bal60=$bal75=$bal90=$bal105=$bal120=$bal121=0;	
	$select=$this->query("SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,Gnrllgr_merge.DEBIT,Gnrllgr_merge.NO
	,Gnrllgr_merge.Jo,Gnrllgr_merge.VDATE,Gnrllgr_merge.Descr,Gnrllgr_merge.CHQNO,'".$this->userData['U_ID']."' AS U_ID,Gnrllgr_merge.B_ID,DATEDIFF(day,Gnrllgr_merge.VDATE,'$date') AS PDAYS
	FROM Gnrllgr_merge 
	INNER JOIN ACCOUNT ON PARTY.VCODE=Gnrllgr_merge.ACode 
	INNER JOIN PARTY ON PARTY.VCODE=PARTY.VCODE 
	WHERE Gnrllgr_merge.DEBIT>0 AND ACCOUNT.ATYPE=4 AND ACCOUNT.LEVL=4 AND Gnrllgr_merge.ACODE='".$a['ACODE']."' AND Gnrllgr_merge.U_ID='".$this->userData['U_ID']."' 
	GROUP BY PARTY.VCODE,PARTY.VNAME,Gnrllgr_merge.Jo,Gnrllgr_merge.VDATE,Gnrllgr_merge.NO,Gnrllgr_merge.B_ID,Gnrllgr_merge.CHQNO,Gnrllgr_merge.Descr,Gnrllgr_merge.DEBIT
	ORDER BY Gnrllgr_merge.VDATE ASC
	");
	if(!empty($select)){
	$tcredit=$a['TCREDIT'];
	$tdebit=0;
	}
	foreach($select as $row){
	$bal=$tcredit-$row['DEBIT'];
	if($bal<0){
	$bal1=abs($bal);	
	$debit=abs($bal);	
	if($tcredit<0){
	$debit=$row['DEBIT'];	
	}
	$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,BAL,NO,JO,VDATE,INVDAYS,U_ID,B_ID) VALUES('".$row['ACODE']."','".$row['ANAME']."','".$debit."',$bal1,'".$row['NO']."','".$row['Jo']."','".$row['VDATE']."','".$row['PDAYS']."','".$row['U_ID']."','".$row['B_ID']."')");
	$tdebit+=$debit;
	if($row['PDAYS']<=30){
	$bal30+=$debit;	
	}
	else if($row['PDAYS'] >30 && $row['PDAYS']<=45){
	$bal45+=$debit;	
	}
	else if($row['PDAYS'] >45 && $row['PDAYS']<=60){
	$bal60+=$debit;	
	}
	else if($row['PDAYS'] >60 && $row['PDAYS']<=90){
	$bal90+=$debit;	
	}
	else if($row['PDAYS'] >90){
	$bal120+=$debit;	
	}
	}
	$tcredit=$bal;
	}
	$chqbal=$a['CHQBAL'];
	$cdays=$a['CDAYS'];
	$update=$this->db->query("UPDATE Lgrrep SET BAL30='$bal30',BAL60='$bal60',BAL45='$bal45',BAL90='$bal90',BAL120='$bal120',BAL='$tdebit',BAL2='$chqbal',CDAYS='$cdays' WHERE U_ID='".$this->userData['U_ID']."' AND ACODE='".$a['ACODE']."'");
	}
	$insert=$this->db->query("INSERT INTO Lgrrep_age(ACODE,ANAME,BAL,BAL30,BAL45,BAL60,BAL90,BAL120,BAL2,CDAYS,U_ID,SPERSON,DATE1) SELECT ACODE,ANAME,BAL,BAL30,BAL45,BAL60,BAL90,BAL120,BAL2,CDAYS,U_ID,".$data['sperson'].",'$date' FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."' GROUP BY ACODE,ANAME,U_ID,BAL,BAL30,BAL45,BAL60,BAL90,BAL120,BAL2,CDAYS");
	}
	
	$query1=$this->query("SELECT * FROM Lgrrep_age WHERE U_ID='".$this->userData['U_ID']."' ORDER BY ANAME ASC");
	
	return $query1;
	}
	
	}
	
?>