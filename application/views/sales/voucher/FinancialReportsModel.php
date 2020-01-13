<?php
	class FinancialReportsModel extends MY_Model{
		
	public function ledger($data){
		
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	if($data['branch']==0){
	$branch='';	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";	
	}
	if($data['rtype']!=1){
	
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,VDATE,DESCR,U_ID,DATE1,DATE2,B_ID) 
	SELECT gnrllgr.ACode,case WHEN v.VNAME IS NULL Then a.ANAME else  v.VNAME END AS ANAME,CASE WHEN SUM(DEBIT-CREDIT) >0  
	THEN SUM(DEBIT-CREDIT)  ELSE 0 END AS DEBIT,CASE WHEN SUM(DEBIT-CREDIT) < 0  
	THEN SUM(DEBIT-CREDIT)  ELSE 0 END AS CREDIT
	,'$date1','Opening','".$this->userData['U_ID']."','$date1','$date2','".$data['branch']."'  	
	from Gnrllgr  left join ACCOUNT a ON a.ACODE=Gnrllgr.ACode left join PARTY v ON v.VCODE=Gnrllgr.Acode 
	where VDate<'$date1' and Gnrllgr.ACode='".$data['party']."' $branch GROUP BY Gnrllgr.ACode,A.ANAME,V.VNAME");	
		
		
	//$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,DEBIT,CREDIT,VDATE,DESCR,U_ID,DATE1,DATE2,B_ID) SELECT '".$data['party']."',sum(Debit),sum(Credit),'$date1','Opening','".$this->userData['U_ID']."','$date1','$date2','".$data['branch']."' from gnrllgr where VDate<'$date1' and ACode='".$data['party']."'");	
	
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2)
	SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,Gnrllgr.DEBIT,Gnrllgr.CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2' FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode WHERE  Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' $branch 
	ORDER BY Gnrllgr.VDATE ASC");
	
	
	}
	else if($data['rtype']==1){
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,DEBIT,CREDIT,VDATE,DESCR,U_ID,DATE1,DATE2,B_ID) SELECT '".$data['party']."',sum(Debit),sum(Credit),'$date1','Opening','".$this->userData['U_ID']."','$date1','$date2','".$data['branch']."' from gnrllgr where VDate<'$date1' and ACode='".$data['party']."'");	
	
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2) SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,sum(Gnrllgr.DEBIT) as DEBIT,sum(Gnrllgr.CREDIT) as CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2' FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode WHERE ACCOUNT.LEVL=4 AND Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' $branch  AND Jo NOT IN ('SL','SR','PU','PR')
	GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr,Gnrllgr.CHQNO,Gnrllgr.B_ID
	ORDER BY Gnrllgr.VDATE ASC");	
	
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID) SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(Gnrllgr.DEBIT) AS DEBIT,SUM(Gnrllgr.CREDIT) AS CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,CAST(SALE1.STNAME AS NVARCHAR(100))+' Inovice # '+CAST(SALE1.NO AS NVARCHAR(100))+' Book No.'+CAST(SALE1.VNO AS NVARCHAR(100)) AS DESCR,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode 
	INNER JOIN SALE1 ON Gnrllgr.No=SALE1.NO AND Gnrllgr.B_ID=SALE1.B_ID
	WHERE  Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' $branch AND Jo IN ('SL')
	GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.CHQNO,Gnrllgr.B_ID,SALE1.NO,SALE1.VNO,SALE1.STNAME
	ORDER BY Gnrllgr.VDATE ASC
	");
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID) SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(Gnrllgr.DEBIT) AS DEBIT,SUM(Gnrllgr.CREDIT) AS CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,CAST(SRET1.STNAME AS NVARCHAR(100))+' Inovice # '+CAST(SRET1.NO AS NVARCHAR(100))+' Book No.'+CAST(SRET1.VNO AS NVARCHAR(100)) AS DESCR,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode 
	INNER JOIN SRET1 ON Gnrllgr.No=SRET1.NO AND Gnrllgr.B_ID=SRET1.B_ID
	WHERE  Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' $branch AND Jo IN ('SR')
	GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.CHQNO,Gnrllgr.B_ID,SRET1.NO,SRET1.VNO,SRET1.STNAME
	ORDER BY Gnrllgr.VDATE ASC
	");
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID) SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(Gnrllgr.DEBIT) AS DEBIT,SUM(Gnrllgr.CREDIT) AS CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,' Inovice # '+CAST(PURCH1.NO AS NVARCHAR(100))+' Book No.'+CAST(PURCH1.VNO AS NVARCHAR(100)) AS DESCR,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode
	INNER JOIN PURCH1 ON Gnrllgr.No=PURCH1.NO AND Gnrllgr.B_ID=PURCH1.B_ID
	WHERE  Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' AND Jo IN ('PU')
	GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.CHQNO,Gnrllgr.B_ID,PURCH1.NO,PURCH1.VNO
	ORDER BY Gnrllgr.VDATE ASC
	");
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID) SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(Gnrllgr.DEBIT) AS DEBIT,SUM(Gnrllgr.CREDIT) AS CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,' Inovice # '+CAST(PRET1.NO AS NVARCHAR(100))+' Book No.'+CAST(PRET1.VNO AS NVARCHAR(100)) AS DESCR,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode 
	INNER JOIN PRET1 ON Gnrllgr.No=PRET1.NO AND Gnrllgr.B_ID=PRET1.B_ID
	WHERE  Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' AND Jo IN ('PR')
	GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.CHQNO,Gnrllgr.B_ID,PRET1.NO,PRET1.VNO
	ORDER BY Gnrllgr.VDATE ASC
	");
	
	}
	$query1=$this->query("SELECT l.*, b.BNAME FROM Lgrrep l left join BRANCH b  ON b.BCODE=l.B_ID WHERE U_ID='".$this->userData['U_ID']."'   ORDER BY VDATE ASC");
	
	$query2=$this->query("SELECT 
	T1.ACODE,T1.ANAME,T1.BCODE,T1.BNAME,T1.CHQNO,T1.CHQDATE,T1.DEBIT,T1.DESCR
	FROM (SELECT CHQNO FROM Gnrllgr_chq WHERE ACODE='".$data['party']."' GROUP BY CHQNO HAVING SUM(DEBIT-CREDIT)<>0) AS T2 INNER JOIN CHQRECIEPT AS T1 ON T2.CHQNO=T1.CHQNO
	INNER JOIN Gnrllgr_chq AS T3 ON T1.CHQNO=T3.CHQNO AND T1.ACODE=T3.ACODE
	GROUP BY T1.ACODE,T1.ANAME,T1.BCODE,T1.BNAME,T1.CHQNO,T1.CHQDATE,T1.DEBIT,T1.DESCR
	HAVING SUM(T3.DEBIT-T3.CREDIT)<>0
	ORDER BY T1.CHQDATE ASC");

	return array("data1"=>$query1,"data2"=>$query2);
	
	}
	//CASHBOOK
	public function cashBook($data){
		
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	$cashbookAcc=array();
	
	array_push($cashbookAcc,"10110001");		

	$cashAcc=implode(",",$cashbookAcc);
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID) SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,Gnrllgr.DEBIT,Gnrllgr.CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode WHERE ACCOUNT.LEVL=4 AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' AND ACCOUNT.ACODE IN ($cashAcc) GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.NO,Gnrllgr.B_ID,Gnrllgr.CHQNO,Gnrllgr.Descr,Gnrllgr.DEBIT,Gnrllgr.CREDIT
	ORDER BY Gnrllgr.VDATE ASC");
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY VDATE ASC,NO ASC");
	
	return $query1;
	
	}
	// CASH AND BANK SUMMARY
	public function cashBank($data){
		
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	if($data['branch']==0){
	$branch='';	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";	
	}
$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,BAL,BAL2,BAL3,U_ID,DATE1,DATE2,FROOM,TOO) 
SELECT Gnrllgr.ACode,case WHEN v.VNAME IS NULL Then a.ANAME else  v.VNAME END AS ANAME ,
SUM(CASE WHEN Gnrllgr.VDate < '$date1' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL1,SUM(CASE WHEN Gnrllgr.VDate >='$date1' AND Gnrllgr.VDate <='$date2'
THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL2,SUM(CASE WHEN  Gnrllgr.VDate <='$date2' 
THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL3,'".$this->userData['U_ID']."','$date1','$date2','".$data['faccount']."','".$data['taccount']."' from Gnrllgr  left join ACCOUNT a ON a.ACODE=Gnrllgr.ACode left join PARTY v ON v.VCODE=Gnrllgr.Acode 

GROUP BY Gnrllgr.ACode,A.ANAME,V.VNAME");
		
		print_r("INSERT INTO Lgrrep(ACODE,ANAME,BAL,BAL2,BAL3,U_ID,DATE1,DATE2,FROOM,TOO) 
SELECT Gnrllgr.ACode,case WHEN v.VNAME IS NULL Then a.ANAME else  v.VNAME END AS ANAME ,
SUM(CASE WHEN Gnrllgr.VDate < '$date1' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL1,SUM(CASE WHEN Gnrllgr.VDate >='$date1' AND Gnrllgr.VDate <='$date2'
THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL2,SUM(CASE WHEN  Gnrllgr.VDate <='$date2' 
THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL3,'".$this->userData['U_ID']."','$date1','$date2','".$data['faccount']."','".$data['taccount']."' from Gnrllgr  left join ACCOUNT a ON a.ACODE=Gnrllgr.ACode left join PARTY v ON v.VCODE=Gnrllgr.Acode 

GROUP BY Gnrllgr.ACode,A.ANAME,V.VNAME");
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."' AND BAL!=0 AND  BAL2!=0 AND  BAL3!=0  ORDER BY VDATE ASC");
	
	return $query1;
	
	}
	
	}
	
	public function trialSimple($data){
		
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	if($data['branch']==0){
	$branch='';	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";	
	}
	if($data['faccount']==""){
	$faccount="";	
	}
	else{
	$faccount="AND ACCOUNT.ACODE >= ".$data['faccount']."";	
	}
	if($data['taccount']==""){
	$taccount="";	
	}
	else{
	$taccount="AND ACCOUNT.ACODE <= ".$data['taccount']."";	
	}
//	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,BAL,BAL2,BAL3,U_ID,DATE1,DATE2,FROOM,TOO) SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(CASE WHEN Gnrllgr.VDate < '$date1' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL1,SUM(CASE WHEN Gnrllgr.VDate >='$date1' AND Gnrllgr.VDate <='$date2'THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL2,SUM(CASE WHEN Gnrllgr.VDate <='$date2' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL3,'".$this->userData['U_ID']."','$date1','$date2','".$data['faccount']."','".$data['taccount']."' FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode WHERE  ACCOUNT.ATYPE=4 $branch $faccount $taccount GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME
	//ORDER BY ACCOUNT.ANAME ASC");
		//echo $this->db->last_query();
	
		
		
$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,BAL,BAL2,BAL3,U_ID,DATE1,DATE2,FROOM,TOO) 
SELECT Gnrllgr.ACode,case WHEN v.VNAME IS NULL Then a.ANAME else  v.VNAME END AS ANAME ,
SUM(CASE WHEN Gnrllgr.VDate < '$date1' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL1,SUM(CASE WHEN Gnrllgr.VDate >='$date1' AND Gnrllgr.VDate <='$date2'
THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL2,SUM(CASE WHEN  Gnrllgr.VDate <='$date2' 
THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL3,'".$this->userData['U_ID']."','$date1','$date2','".$data['faccount']."','".$data['taccount']."' from Gnrllgr  left join ACCOUNT a ON a.ACODE=Gnrllgr.ACode left join PARTY v ON v.VCODE=Gnrllgr.Acode 

GROUP BY Gnrllgr.ACode,A.ANAME,V.VNAME");
		
		
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."' AND BAL!=0 AND  BAL2!=0 AND  BAL3!=0  ORDER BY VDATE ASC");
	
	return $query1;
	
	}
	
	public function trialGroup($data){
		
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	if($data['branch']==0){
	$branch='';	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";	
	}

	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,BAL,BAL2,BAL3,U_ID,DATE1,DATE2,GRP) SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(CASE WHEN Gnrllgr.VDate < '$date1' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL1,SUM(CASE WHEN Gnrllgr.VDate > '$date2' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL2,SUM(CASE WHEN Gnrllgr.VDate >='$date1' AND Gnrllgr.VDate <='$date2' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL3,'".$this->userData['U_ID']."','$date1','$date2','".$data['agroup']."' FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode INNER JOIN ACGROUP ON ACCOUNT.ACODE=ACGROUP.ACODE WHERE ACCOUNT.LEVL=4 AND ACGROUP.AGRP='".$data['agroup']."' $branch  GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME
	ORDER BY ACCOUNT.ANAME ASC");
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY VDATE ASC");
	
	return $query1;
	
	}
	
public function trial($data){
	
$delete_Lgrrep=$this->db->query("DELETE FROM Lgrrep");
$date1=$data['date1'];
$date2=$data['date2'];
if($data['branch']==0){
$branch='';	
$branch_for_rpt='0';	
}
else{
$branch_for_rpt =$data['branch']; 	
$branch="AND Gnrllgr.B_ID='".$data['branch']."'";	
}

//account Entry Approved 
$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,U_ID,B_ID,DATE1,DATE2,BRANCH2)
SELECT Gnrllgr.ACODE,ACCOUNT.ANAME,SUM(CASE WHEN Gnrllgr.DEBIT-Gnrllgr.CREDIT>0 THEN Gnrllgr.DEBIT-Gnrllgr.CREDIT ELSE 0 END) AS Debit,Abs(SUM(CASE WHEN Gnrllgr.DEBIT-Gnrllgr.CREDIT<0 THEN Gnrllgr.DEBIT-Gnrllgr.CREDIT ELSE 0 END)) AS Credit,'".$this->userData['U_ID']."','".$this->userData['B_ID']."','$date1','$date2','$branch_for_rpt'
FROM
Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACODE 
WHERE 
 Gnrllgr.VDATE>='".$date1."' AND Gnrllgr.VDATE<='".$date2."'  $branch
GROUP BY Gnrllgr.ACODE,ACCOUNT.ANAME
ORDER BY Gnrllgr.ACODE ASC");	

//for customer
$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,U_ID,B_ID,DATE1,DATE2,BRANCH2) 
SELECT '70091','Receivables From Customers',SUM(CASE WHEN Gnrllgr.DEBIT-Gnrllgr.CREDIT>0 THEN Gnrllgr.DEBIT-Gnrllgr.CREDIT ELSE 0 END) AS Debit,Abs(SUM(CASE WHEN Gnrllgr.DEBIT-Gnrllgr.CREDIT<0 THEN Gnrllgr.DEBIT-Gnrllgr.CREDIT ELSE 0 END)) AS Credit,'".$this->userData['U_ID']."','".$this->userData['B_ID']."','$date1','$date2','$branch_for_rpt'
FROM 
Gnrllgr INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr.ACODE  
WHERE PARTY.ATYPE = '0' $branch
AND Gnrllgr.VDATE>='".$date1."' AND Gnrllgr.VDATE<='".$date2."' 
");

//for suppliers
$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,U_ID,B_ID,DATE1,DATE2,BRANCH2) 
SELECT '70097','Total Supplier Payables',SUM(CASE WHEN Gnrllgr.DEBIT-Gnrllgr.CREDIT>0 THEN Gnrllgr.DEBIT-Gnrllgr.CREDIT ELSE 0 END) AS Debit,Abs(SUM(CASE WHEN Gnrllgr.DEBIT-Gnrllgr.CREDIT<0 THEN Gnrllgr.DEBIT-Gnrllgr.CREDIT ELSE 0 END)) AS Credit,'".$this->userData['U_ID']."','".$this->userData['B_ID']."','$date1','$date2','$branch_for_rpt'
FROM 
Gnrllgr INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr.ACODE  
WHERE PARTY.ATYPE = '1' $branch 
AND Gnrllgr.VDATE>='".$date1."' AND Gnrllgr.VDATE<='".$date2."' 

");
$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY VDATE ASC");	
return $query1;	
}
	//balance sheet
	public function bls($data){
		
	$this->deleteData("ACBAL",array("U_ID"=>$this->userData['U_ID']));
	$this->deleteData("PRDBAL",array("U_ID"=>$this->userData['U_ID']));
	$this->deleteData("PRDBAL1",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	if($data['branch']==0){
	$branch='';	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";	
	}
	$faccount="";
	$taccount="";	
	$agroupJoin="";	
	$agroup="";	
	
	$insert=$this->db->query("INSERT INTO ACBAL(ACODE,ANAME,BAL,BAL2,BAL3,U_ID,DATE1,DATE2) SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(CASE WHEN Gnrllgr.VDate < '$date1' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL,SUM(CASE WHEN Gnrllgr.VDate <= '$date2' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL2,SUM(CASE WHEN Gnrllgr.VDate >='$date1' AND Gnrllgr.VDate <='$date2' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL3,'".$this->userData['U_ID']."','$date1','$date2' FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode $agroupJoin WHERE ACCOUNT.LEVL=4 AND ACCOUNT.AGROUP<3 $branch $faccount $taccount $agroup GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME
	ORDER BY ACCOUNT.ANAME ASC");
	
	//************************* OPENING & CLOSING STOCK ******************
		$select=$this->query("SELECT  dbo.PRODUCT.PCODE , dbo.PRODUCT.PNAME , ROUND(SUM(case when dbo.STOCK.VDATE < '$date1' then dbo.STOCK.INQT - dbo.STOCK.OUTQT else 0 end), 2) AS OPBAL, ROUND(SUM(case when dbo.STOCK.VDATE <= '$date2' then dbo.STOCK.INQT - dbo.STOCK.OUTQT else 0 end), 2) AS CLBAL FROM dbo.STOCK INNER JOIN dbo.PRODUCT ON dbo.STOCK.PCODE = dbo.PRODUCT.PCODE GROUP BY dbo.PRODUCT.PCODE, dbo.PRODUCT.PNAME ORDER BY dbo.PRODUCT.PCODE,dbo.PRODUCT.PNAME,OPBAL,CLBAL");
		if(!empty($select))
		{
			$opbal =0;
			$oprate =0;
			$opamount=0;
			$clbal =0;
			$clrate =0;
			$clamount=0;
			foreach($select as $select)
			{
				$pcode = $select['PCODE'];
				$pname = $select['PNAME'];
				$opbal = $select['OPBAL'];
				$clbal = $select['CLBAL'];
				
				$oprt=$this->query("SELECT ROUND(SUM(INAMT) / SUM(INQT) , 7) AS OPRATE FROM dbo.STOCK WHERE PCODE = '$pcode' AND VDATE < '$date1' AND JO IN ('OS', 'PU', 'PD','LT') AND INQT > 0");
				
				$clrt=$this->query("SELECT ROUND(SUM(INAMT) / SUM(INQT) , 7) AS CLRATE FROM dbo.STOCK WHERE PCODE = '$pcode' AND VDATE <= '$date2' AND JO IN ('OS', 'PU', 'PD','LT') AND INQT > 0");
				
				$oprate = $oprt[0]['OPRATE'];
				$clrate = $clrt[0]['CLRATE'];
				$opamount = round($opbal*$oprate,0);
				$clamount = round($clbal*$clrate,0);
				if ($opamount >0)
				{
					$insert=$this->db->query("INSERT INTO PRDBAL(PCODE,PNAME,QTY,RATE,AMOUNT,U_ID) VALUES('$pcode','$pname','$opbal','$oprate','$opamount','".$this->userData['U_ID']."')");
				}
				if ($clamount >0)
				{
					$insert=$this->db->query("INSERT INTO PRDBAL1(PCODE,PNAME,QTY,RATE,AMOUNT,U_ID) VALUES('$pcode','$pname','$clbal','$clrate','$clamount','".$this->userData['U_ID']."')");
				}
				
				$opbal =0;
				$oprate =0;
				$opamount=0;
				$clbal =0;
				$clrate =0;
				$clamount=0;
			}
		}
		$st=$this->query("SELECT SUM(AMOUNT) AS TOPN FROM PRDBAL WHERE U_ID='".$this->userData['U_ID']."'");
		$topn = $st[0]['TOPN'];
		
			
		$st1=$this->query("SELECT SUM(AMOUNT) AS TCLG FROM PRDBAL1 WHERE U_ID='".$this->userData['U_ID']."'");
		$tclg = $st1[0]['TCLG'];
		$stbal = 0;
		$stbal = $topn-$tclg;
		
		if ($stbal!=0){ $stbal= $stbal*(-1);} 
		
		$insert=$this->db->query("INSERT INTO ACBAL(ACODE,ANAME,BAL,BAL2,BAL3,U_ID,DATE1,DATE2) VALUES('10120002','CLOSING STOCK','0','0','$stbal','".$this->userData['U_ID']."','$date1','$date2')");

	//**************************END STOCK **********************
	$pl=$this->query("SELECT SUM(BAL3) AS TBAL FROM ACBAL WHERE U_ID='".$this->userData['U_ID']."'");
	$pls = $pl[0]['TBAL'];
	
	$plnm=$this->query("SELECT ANAME FROM ACCOUNT WHERE ACODE ='50201001'");
	$aname=$plnm[0]['ANAME'];
	
	if ($pls!=0){ $pls= $pls*(-1);}
	$insert=$this->db->query("INSERT INTO ACBAL(ACODE,ANAME,BAL,BAL2,BAL3,U_ID,DATE1,DATE2) VALUES('50201001','$aname','0','0','$pls','".$this->userData['U_ID']."','$date1','$date2')");
	
	$query1=$this->query("SELECT * FROM ACBAL WHERE U_ID='".$this->userData['U_ID']."'  AND BAL3 <> 0 ORDER BY ACODE ASC");
	
	return $query1;
	
	}	
	// profit / loss
	public function pls($data){
		
	$this->deleteData("ACBAL",array("U_ID"=>$this->userData['U_ID']));
	$this->deleteData("PRDBAL",array("U_ID"=>$this->userData['U_ID']));
	$this->deleteData("PRDBAL1",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	if($data['branch']==0){
	$branch='';	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";	
	}
	
	$insert=$this->db->query("INSERT INTO ACBAL(ACODE,ANAME,BAL,BAL2,BAL3,U_ID,DATE1,DATE2) SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(CASE WHEN Gnrllgr.VDate < '$date1' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL,SUM(CASE WHEN Gnrllgr.VDate < '$date2' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL2,SUM(CASE WHEN Gnrllgr.VDate >='$date1' AND Gnrllgr.VDate <='$date2' AND round(Gnrllgr.Debit-Gnrllgr.Credit,0) <> 0 THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL3,'".$this->userData['U_ID']."','$date1','$date2' FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode  WHERE ACCOUNT.LEVL=4 AND ACCOUNT.AGROUP>2 $branch  GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME
	ORDER BY ACCOUNT.ACODE ASC");
	
	//************************* OPENING & CLOSING STOCK ******************
		$select=$this->query("SELECT  dbo.PRODUCT.PCODE , dbo.PRODUCT.PNAME , ROUND(SUM(case when dbo.STOCK.VDATE < '$date1' then dbo.STOCK.INQT - dbo.STOCK.OUTQT else 0 end), 2) AS OPBAL, ROUND(SUM(case when dbo.STOCK.VDATE <= '$date2' then dbo.STOCK.INQT - dbo.STOCK.OUTQT else 0 end), 2) AS CLBAL FROM dbo.STOCK INNER JOIN dbo.PRODUCT ON dbo.STOCK.PCODE = dbo.PRODUCT.PCODE GROUP BY dbo.PRODUCT.PCODE, dbo.PRODUCT.PNAME ORDER BY dbo.PRODUCT.PCODE,dbo.PRODUCT.PNAME,OPBAL,CLBAL");
		if(!empty($select))
		{
			$opbal =0;
			$oprate =0;
			$opamount=0;
			$clbal =0;
			$clrate =0;
			$clamount=0;
			foreach($select as $select)
			{
				$pcode = $select['PCODE'];
				$pname = $select['PNAME'];
				$opbal = $select['OPBAL'];
				$clbal = $select['CLBAL'];
				
				$oprt=$this->query("SELECT ROUND(SUM(INAMT) / SUM(INQT) , 7) AS OPRATE FROM dbo.STOCK WHERE PCODE = '$pcode' AND VDATE < '$date1' AND JO IN ('OS', 'PU', 'PD','LT') AND INQT > 0");
				
				$clrt=$this->query("SELECT ROUND(SUM(INAMT) / SUM(INQT) , 7) AS CLRATE FROM dbo.STOCK WHERE PCODE = '$pcode' AND VDATE <= '$date2' AND JO IN ('OS', 'PU', 'PD','LT') AND INQT > 0");
				
				$oprate = $oprt[0]['OPRATE'];
				$clrate = $clrt[0]['CLRATE'];
				$opamount = round($opbal*$oprate,0);
				$clamount = round($clbal*$clrate,0);
				if ($opamount >0)
				{
					$insert=$this->db->query("INSERT INTO PRDBAL(PCODE,PNAME,QTY,RATE,AMOUNT,U_ID) VALUES('$pcode','$pname','$opbal','$oprate','$opamount','".$this->userData['U_ID']."')");
				}
				if ($clamount >0)
				{
					$insert=$this->db->query("INSERT INTO PRDBAL1(PCODE,PNAME,QTY,RATE,AMOUNT,U_ID) VALUES('$pcode','$pname','$clbal','$clrate','$clamount','".$this->userData['U_ID']."')");
				}
				
				$opbal =0;
				$oprate =0;
				$opamount=0;
				$clbal =0;
				$clrate =0;
				$clamount=0;
			}
		}
		$st=$this->query("SELECT SUM(AMOUNT) AS TOPN FROM PRDBAL WHERE U_ID='".$this->userData['U_ID']."'");
		$topn = $st[0]['TOPN'];
		
		$insert=$this->db->query("INSERT INTO ACBAL(ACODE,ANAME,BAL,BAL2,BAL3,U_ID,DATE1,DATE2) VALUES('10120001','OPENING STOCK','0','0','$topn','".$this->userData['U_ID']."','$date1','$date2')");
		
		$st1=$this->query("SELECT SUM(AMOUNT) AS TCLG FROM PRDBAL1 WHERE U_ID='".$this->userData['U_ID']."'");
		$tclg = $st1[0]['TCLG'];
		if ($tclg>0){ $tclg= $tclg*(-1);}
		$insert=$this->db->query("INSERT INTO ACBAL(ACODE,ANAME,BAL,BAL2,BAL3,U_ID,DATE1,DATE2) VALUES('10120002','CLOSING STOCK','0','0','$tclg','".$this->userData['U_ID']."','$date1','$date2')");

	//**************************END STOCK **********************
	$pl=$this->query("SELECT SUM(BAL3) AS TBAL FROM ACBAL WHERE U_ID='".$this->userData['U_ID']."'");
	$pls = $pl[0]['TBAL'];
	
	$plnm=$this->query("SELECT ANAME FROM ACCOUNT WHERE ACODE ='50201001'");
	$aname=$plnm[0]['ANAME'];
	
	if ($pls!=0){ $pls= $pls*(-1);}
	$insert=$this->db->query("INSERT INTO ACBAL(ACODE,ANAME,BAL,BAL2,BAL3,U_ID,DATE1,DATE2) VALUES('50201001','$aname','0','0','$pls','".$this->userData['U_ID']."','$date1','$date2')");
		
	
	$query1=$this->query("SELECT * FROM ACBAL WHERE U_ID='".$this->userData['U_ID']."' AND BAL3 <> 0 ORDER BY ACODE ASC");
	
	return $query1;
	
	}
	
	public function userLog($data){
		
	$date1=$data['date1'];
	$date2=$data['date2'];
	if($data['branch']==0){
	$branch='';	
	}
	else{
	$branch="AND B_ID='".$data['branch']."'";	
	}
	if($data['utype']==1){
	$br=implode("','",$data['users']);
	$users="AND U_ID IN ('$br')";
	}	
	else{
	$users="";	
	}
	if($data['vttype']==1){
	$br=implode("','",$data['vtype']);
	$vtype="AND JO IN ('$br')";
	}
	else{
	$vtype="";	
	}
	if($data['rtype']==2){
	$orderBy="B_ID,JO,NO";	
	}
	else{
	$orderBy="VDATE";	
	}
	if($data['vno']!=''){
	$cc=explode(",",$data['vno']);
	$cc=array_filter($cc);
	$br=implode(",",$cc);
	$no="AND NO IN ('$br')";	
	}
	else{
	$no="";	
	}	
	$query1=$this->query("SELECT NO,JO,B_ID,U_ID,VDATE,TYPE,ROW_NUMBER() OVER (Partition By NO,JO,B_ID ORDER BY VDATE) AS 'ROWNO' FROM VLOG
	WHERE CONVERT(date, VDATE)>='$date1' AND CONVERT(date, VDATE)<='$date2' $users $vtype $branch $no
	GROUP BY NO,JO,U_ID,B_ID,VDATE,TYPE ORDER BY $orderBy ASC
	");
	return $query1;
	}
	
	public function dailyLog($data){
		
	$date1=$data['date1'];
	$date2=$data['date2'];
	if($data['branch']==0){
	$branch='';	
	}
	else{
	$branch="AND B_ID='".$data['branch']."'";	
	}
	if($data['vttype']==1){
	$br=implode("','",$data['vtype']);
	$vtype="AND JO IN ('$br')";
	}
	else{
	$vtype="";	
	}

	if($data['vno']!=''){
	$cc=explode(",",$data['vno']);
	$cc=array_filter($cc);
	$br=implode(",",$cc);
	$no="AND NO IN ('$br')";	
	}
	else{
	$no="";	
	}	
	$query1=$this->query("SELECT * FROM DAILYLOG
	WHERE VDATE>='$date1' AND VDATE<='$date2' $vtype $branch $no
	ORDER BY VDATE ASC
	");
	
	return $query1;
	}
	
	public function efficiency($data){
		
	$date1=$data['date1'];
	$date2=$data['date2'];
	
	$query1=$this->query("(select U_ID,COUNT(*) as cnt from VLOG where VDATE>='$date1' and VDATE<='$date2' and U_ID!='solexp' group by U_ID ) union all (select '' as U_ID,COUNT(*) from VLOG where VDATE>='$date1' and VDATE<='$date2' and U_ID!='solexp') 
	order by u_id");
	
	return $query1;
	}
	
	public function chqsInHand($data){
		
	$date1=$data['date1'];
	$date2=$data['date2'];
	if($data['branch']==0){
	$branch='';	
	}
	else{
	$branch="AND B_ID='".$data['branch']."'";	
	}
	$party="";
	if($data['ptype']==1){
	$br=implode(",",$data['party']);
	$party="AND ACODE IN ($br)";
	}
	$bank="";
	if($data['btype']==1){
	$br=implode(",",$data['bank']);
	$bank="AND BCODE IN ($br)";
	}
	$agent="";
	if($data['agtype']==1){
	$br=implode(",",$data['agents']);
	$agent="AND AGCODE IN ($br)";
	}
	$chqno="";
	if($data['ctype']==1){
	$br=implode("','",$data['chqno']);
	$chqno="AND CHQNO IN ('$br')";
	}
	if($data['rtype']==2){
	$rtype="";	
	}
	else if($data['rtype']==0){
	$rtype="AND STATUS='1' AND TSTATUS<>3";	
	}
	else if($data['rtype']==1){
	$rtype="AND STATUS='0' AND TSTATUS='1'";	
	}
	else if($data['rtype']==3){
	$rtype="AND STATUS='0' AND TSTATUS='0'";	
	}
	else if($data['rtype']==4){
	$rtype="AND TSTATUS=3";	
	}
	if($data['dtype']==1){
	$dtype="VDATE";	
	}
	else if($data['dtype']==3){
	$dtype="CHQDATE";	
	}
	else{
	$dtype="DDATE";	
	}
	
	$query1=$this->query("SELECT * FROM CHQSINHAND
	WHERE CONVERT(date, $dtype)>='$date1' AND CONVERT(date, $dtype)<='$date2'  $branch $rtype $party $bank $agent $chqno
	ORDER BY $dtype ASC
	");	
	
	return $query1;
	}
	// COST OF GOODS SOLD
	public function cgs($data){
		
	$this->deleteData("ACBAL",array("U_ID"=>$this->userData['U_ID']));
	$this->deleteData("PRDBAL",array("U_ID"=>$this->userData['U_ID']));
	$this->deleteData("PRDBAL1",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	if($data['branch']==0){
	$branch='';	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";	
	}
	
	$insert=$this->db->query("INSERT INTO ACBAL(ACODE,ANAME,BAL,BAL2,BAL3,U_ID,DATE1,DATE2) SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(CASE WHEN Gnrllgr.VDate < '$date1' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL,SUM(CASE WHEN Gnrllgr.VDate < '$date2' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL2,SUM(CASE WHEN Gnrllgr.VDate >='$date1' AND Gnrllgr.VDate <='$date2' AND round(Gnrllgr.Debit-Gnrllgr.Credit,0) <> 0 THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL3,'".$this->userData['U_ID']."','$date1','$date2' FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode  WHERE ACCOUNT.LEVL=4 AND ACCOUNT.L3CODE='40108' $branch  GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME
	ORDER BY ACCOUNT.ACODE ASC");
	
	//************************* OPENING & CLOSING STOCK ******************
		$select=$this->query("SELECT  dbo.PRODUCT.PCODE , dbo.PRODUCT.PNAME , ROUND(SUM(case when dbo.STOCK.VDATE < '$date1' then dbo.STOCK.INQT - dbo.STOCK.OUTQT else 0 end), 2) AS OPBAL, ROUND(SUM(case when dbo.STOCK.VDATE <= '$date2' then dbo.STOCK.INQT - dbo.STOCK.OUTQT else 0 end), 2) AS CLBAL FROM dbo.STOCK INNER JOIN dbo.PRODUCT ON dbo.STOCK.PCODE = dbo.PRODUCT.PCODE GROUP BY dbo.PRODUCT.PCODE, dbo.PRODUCT.PNAME ORDER BY dbo.PRODUCT.PCODE,dbo.PRODUCT.PNAME,OPBAL,CLBAL");
		if(!empty($select))
		{
			$opbal =0;
			$oprate =0;
			$opamount=0;
			$clbal =0;
			$clrate =0;
			$clamount=0;
			foreach($select as $select)
			{
				$pcode = $select['PCODE'];
				$pname = $select['PNAME'];
				$opbal = $select['OPBAL'];
				$clbal = $select['CLBAL'];
				
				$oprt=$this->query("SELECT ROUND(SUM(INAMT) / SUM(INQT) , 7) AS OPRATE FROM dbo.STOCK WHERE PCODE = '$pcode' AND VDATE < '$date1' AND JO IN ('OS', 'PU', 'PD','LT') AND INQT > 0");
				
				$clrt=$this->query("SELECT ROUND(SUM(INAMT) / SUM(INQT) , 7) AS CLRATE FROM dbo.STOCK WHERE PCODE = '$pcode' AND VDATE <= '$date2' AND JO IN ('OS', 'PU', 'PD','LT') AND INQT > 0");
				
				$oprate = $oprt[0]['OPRATE'];
				$clrate = $clrt[0]['CLRATE'];
				$opamount = round($opbal*$oprate,0);
				$clamount = round($clbal*$clrate,0);
				if ($opamount >0)
				{
					$insert=$this->db->query("INSERT INTO PRDBAL(PCODE,PNAME,QTY,RATE,AMOUNT,U_ID) VALUES('$pcode','$pname','$opbal','$oprate','$opamount','".$this->userData['U_ID']."')");
				}
				if ($clamount >0)
				{
					$insert=$this->db->query("INSERT INTO PRDBAL1(PCODE,PNAME,QTY,RATE,AMOUNT,U_ID) VALUES('$pcode','$pname','$clbal','$clrate','$clamount','".$this->userData['U_ID']."')");
				}
				
				$opbal =0;
				$oprate =0;
				$opamount=0;
				$clbal =0;
				$clrate =0;
				$clamount=0;
			}
		}
		$st=$this->query("SELECT SUM(AMOUNT) AS TOPN FROM PRDBAL WHERE U_ID='".$this->userData['U_ID']."'");
		$topn = $st[0]['TOPN'];
		
		$insert=$this->db->query("INSERT INTO ACBAL(ACODE,ANAME,BAL,BAL2,BAL3,U_ID,DATE1,DATE2) VALUES('10120001','OPENING STOCK','0','0','$topn','".$this->userData['U_ID']."','$date1','$date2')");
		
		$st1=$this->query("SELECT SUM(AMOUNT) AS TCLG FROM PRDBAL1 WHERE U_ID='".$this->userData['U_ID']."'");
		$tclg = $st1[0]['TCLG'];
		if ($tclg>0){ $tclg= $tclg*(-1);}
		$insert=$this->db->query("INSERT INTO ACBAL(ACODE,ANAME,BAL,BAL2,BAL3,U_ID,DATE1,DATE2) VALUES('10120002','CLOSING STOCK','0','0','$tclg','".$this->userData['U_ID']."','$date1','$date2')");

	//**************************END STOCK **********************
	$pl=$this->query("SELECT SUM(BAL3) AS TBAL FROM ACBAL WHERE U_ID='".$this->userData['U_ID']."'");
	$pls = $pl[0]['TBAL'];
	
	/* $plnm=$this->query("SELECT ANAME FROM ACCOUNT WHERE ACODE ='50201001'");
	$aname=$plnm[0]['ANAME'];
	
	if ($pls!=0){ $pls= $pls*(-1);}
	$insert=$this->db->query("INSERT INTO ACBAL(ACODE,ANAME,BAL,BAL2,BAL3,U_ID,DATE1,DATE2) VALUES('50201001','$aname','0','0','$pls','".$this->userData['U_ID']."','$date1','$date2')"); */
		
	
	$query1=$this->query("SELECT * FROM ACBAL WHERE U_ID='".$this->userData['U_ID']."' AND BAL3 <> 0 ORDER BY ACODE ASC");
	
	return $query1;
	
	}
	//Cash Flow
	public function cashflow($data){
		
	$this->deleteData("lgrrepcs",array("U_ID"=>$this->userData['U_ID']));
	$this->deleteData("ACBAL",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	if($data['branch']==0){
	$branch='';	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";	
	}
	$faccount="";
	$taccount="";	
	$agroupJoin="";	
	$agroup="";	
	if($date1=='2018-01-01')
		{
			//$insert=$this->db->query("INSERT INTO ACBAL(ACODE,ANAME,BAL,BAL2,BAL3,U_ID,DATE1,DATE2) SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(CASE WHEN Gnrllgr.VDate < '$date1' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL,SUM(CASE WHEN Gnrllgr.VDate <= '$date2' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL2,SUM(CASE WHEN Gnrllgr.VDate >='$date1' AND Gnrllgr.VDate <='$date2' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL3,'".$this->userData['U_ID']."','$date1','$date2' FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode $agroupJoin WHERE ACCOUNT.LEVL=4 AND ACCOUNT.AGROUP<3 $branch $faccount $taccount $agroup GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME ORDER BY ACCOUNT.ANAME ASC");
			$srqry=$this->query("SELECT SUM(Debit-Credit) AS TBAL  FROM Gnrllgr INNER JOIN Account ON Gnrllgr.ACode=Account.ACode WHERE Account.AType IN (0,1) AND ACCOUNT.LEVL = 4 AND Gnrllgr.VDate = '".$date1."' AND Jo='OP'");
		}
	else
		{
			$srqry=$this->query("SELECT SUM(Debit-Credit) AS TBAL  FROM Gnrllgr INNER JOIN Account ON Gnrllgr.ACode=Account.ACode WHERE Account.AType IN (0,1) AND ACCOUNT.LEVL = 4 AND Gnrllgr.VDate < '".$date1."'");
		}
	
	if (!empty($srqry))
	{
		$srqry2=$this->query("SELECT SUM(Debit-Credit) AS TBAL  FROM Gnrllgr INNER JOIN Account ON Gnrllgr.ACode=Account.ACode WHERE Account.AType IN (0,1) AND ACCOUNT.LEVL = 4 AND Gnrllgr.VDate < '".$date1."'");
		$tbal=0;
	//	$tbal =$srqry2[0]['TBAL'];
		
		$insert=$this->db->query("INSERT INTO Lgrrepcs(ACode,AName,DRACODE,ATPNAME,SDATE,EDATE,Debit,Credit,SORD,U_ID) VALUES('0001','Opening Balance','0002','Opening Balance','$date1','$date2','0','0','0','".$this->userData['U_ID']."')"); 	 
	}
	// trade debtors
		$cus=$this->query("SELECT dbo.ACCOUNT.ACode,dbo.ACCOUNT.AName,ROUND(SUM(dbo.Gnrllgr.CREDIT-dbo.Gnrllgr.DEBIT),2) AS TBAL FROM dbo.Gnrllgr INNER JOIN dbo.Account ON dbo.Gnrllgr.ACODE =dbo.ACCOUNT.ACODE WHERE dbo.ACCOUNT.AType=4 and dbo.ACCOUNT.LEVL=4 AND dbo.Gnrllgr.VDATE >= '".$date1."' AND dbo.Gnrllgr.VDate <= '".$date2."' AND [JO] IN ('CV','CR','CP','BP','BR') GROUP BY dbo.ACCOUNT.ACODE,dbo.ACCOUNT.ANAME ORDER BY dbo.ACCOUNT.ANAME ASC");
		$Bal=0;
		foreach ($cus as $cust)
			{
				$acode = $cust[0]['ACODE'];
				$aname = $cust[0]['ANAME'];
				$Bal = $cust[0]['TBAL'];
				if ($Bal>0)
				{
					$nSORD=2;
				}
				else
				{
					$nSORD=4;
				}
				if($Bal!="" && $Bal!=0)
				{	
					$insert=$this->db->query("INSERT INTO Lgrrepcs(ACode,AName,Debit,Credit,ATYPE,ATPNAME,SORD,DRACODE,SDATE,EDATE,U_ID) VALUES('$acode','$aname','$Bal','0','0','Trade Debtors','$nSORD','0001','$date1','$date1','".$this->userData['U_ID']."')"); 	 
				}
			}
			
			// trade debtors
		$cus=$this->query("SELECT dbo.ACCOUNT.ACode,dbo.ACCOUNT.AName,ROUND(SUM(dbo.Gnrllgr.CREDIT-dbo.Gnrllgr.DEBIT),2) AS TBAL FROM dbo.Gnrllgr INNER JOIN dbo.Account ON dbo.Gnrllgr.ACODE =dbo.ACCOUNT.ACODE WHERE dbo.ACCOUNT.AType=4 and dbo.ACCOUNT.LEVL=4 AND dbo.Gnrllgr.VDATE >= '".$date1."' AND dbo.Gnrllgr.VDate <= '".$date2."' AND [JO] IN ('CV','CR','CP','BP','BR') GROUP BY dbo.ACCOUNT.ACODE,dbo.ACCOUNT.ANAME ORDER BY dbo.ACCOUNT.ANAME ASC");
		$Bal=0;
		foreach ($cus as $cust)
			{
				$acode = $cust[0]['ACODE'];
				$aname = $cust[0]['ANAME'];
				$Bal = $cust[0]['TBAL'];
				if ($Bal>0)
				{
					$nSORD=2;
				}
				else
				{
					$nSORD=4;
				}
				if($Bal!="" && $Bal!=0)
				{	
					$insert=$this->db->query("INSERT INTO Lgrrepcs(ACode,AName,Debit,Credit,ATYPE,ATPNAME,SORD,DRACODE,SDATE,EDATE,U_ID) VALUES('$acode','$aname','$Bal','0','0','Trade Debtors','$nSORD','0001','$date1','$date1','".$this->userData['U_ID']."')"); 	 
				}
			}
			
				// trade CREDITORS
		$cus=$this->query("SELECT dbo.ACCOUNT.ACode,dbo.ACCOUNT.AName,ROUND(SUM(dbo.Gnrllgr.CREDIT-dbo.Gnrllgr.DEBIT),2) AS TBAL FROM dbo.Gnrllgr INNER JOIN dbo.Account ON dbo.Gnrllgr.ACODE =dbo.ACCOUNT.ACODE WHERE dbo.ACCOUNT.AType=5 and dbo.ACCOUNT.LEVL=4 AND dbo.Gnrllgr.VDATE >= '".$date1."' AND dbo.Gnrllgr.VDate <= '".$date2."' AND [JO] IN ('CV','CR','CP','BP','BR') GROUP BY dbo.ACCOUNT.ACODE,dbo.ACCOUNT.ANAME ORDER BY dbo.ACCOUNT.ANAME ASC");
		$Bal=0;
		foreach ($cus as $cust)
			{
				$acode = $cust[0]['ACODE'];
				$aname = $cust[0]['ANAME'];
				$Bal = $cust[0]['TBAL'];				if ($Bal>0)

				{
					$nSORD=2;
				}
				else
				{
					$nSORD=4;
				}
				if($Bal!="" && $Bal!=0)
				{	
					$insert=$this->db->query("INSERT INTO Lgrrepcs(ACode,AName,Debit,Credit,ATYPE,ATPNAME,SORD,DRACODE,SDATE,EDATE,U_ID) VALUES('$acode','$aname','$Bal','0','0','Trade Creditors','$nSORD','0001','$date1','$date1','".$this->userData['U_ID']."')"); 	 
				}
			}
			 // other accounts
	$cus=$this->query("SELECT dbo.ACCOUNT.ACode,dbo.ACCOUNT.AName,dbo.ACCOUNT.AGROUP,dbo.ACCOUNT.AGRPNAME,ROUND(SUM(dbo.Gnrllgr.CREDIT),2) AS TCR, ROUND(SUM(dbo.Gnrllgr.DEBIT),2) AS TDB FROM dbo.Gnrllgr INNER JOIN dbo.Account ON dbo.Gnrllgr.ACODE =dbo.ACCOUNT.ACODE WHERE dbo.ACCOUNT.AType NOT IN (0,1,4,5) and dbo.ACCOUNT.LEVL=4 AND dbo.Gnrllgr.VDATE >= '".$date1."' AND dbo.Gnrllgr.VDate <= '".$date2."' AND [JO] IN ('CV','CR','CP','BP','BR') GROUP BY dbo.ACCOUNT.ACODE,dbo.ACCOUNT.ANAME,dbo.ACCOUNT.AGROUP,dbo.ACCOUNT.AGRPNAME ORDER BY dbo.ACCOUNT.ANAME ASC");
		$Bal=0;
		foreach ($cus as $cust)
			{
				$acode = $cust[0]['ACODE'];
				$aname = $cust[0]['ANAME'];
				$agrp = $cust[0]['AGROUP'];
				$agrpname = $cust[0]['AGRPNAME'];
				$tdb = $cust[0]['TDB'];
				$tcr = $cust[0]['TCR'];
				$Bal=0;
				$Bal=$tcr-$tdb;
				if ($Bal>0)
				{
					$nSORD=2;
				}
				else
				{
					$nSORD=4;
				}
				if($nTdb>0 || $nTcr> 0)
				{	
					$insert=$this->db->query("INSERT INTO Lgrrepcs(ACode,AName,Debit,Credit,ATYPE,ATPNAME,SORD,DRACODE,SDATE,EDATE,U_ID) VALUES('$acode','$aname','$Bal','0','$agrp','$agrpname','$nSORD','0001','$date1','$date1','".$this->userData['U_ID']."')"); 	 
				}
			}
			
			/// CASH AND BANK SUMMARY
			//opening balance
					if($date1=='2018-01-01')
					{
						$ins=$this->query("SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(CASE WHEN Gnrllgr.VDate = '$date1' AND Gnrllgr.Jo='OP' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS OPN,SUM(CASE WHEN Gnrllgr.VDate <= '$date2' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS CLG,SUM(CASE WHEN Gnrllgr.VDate >='$date1' AND Gnrllgr.VDate <='$date2' THEN Gnrllgr.Debit ELSE 0 END) AS TDB,SUM(CASE WHEN Gnrllgr.VDate >='$date1' AND Gnrllgr.VDate <='$date2' THEN Gnrllgr.Credit ELSE 0 END) AS TCR FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode WHERE ACCOUNT.LEVL=4 AND ACCOUNT.ATYPE IN (0,1)
						$branch GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME ORDER BY ACCOUNT.ANAME ASC");
					}
					else
					{
						$ins=$this->query("SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(CASE WHEN Gnrllgr.VDate < '$date1' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS OPN,SUM(CASE WHEN Gnrllgr.VDate <= '$date2' THEN Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS CLG,SUM(CASE WHEN Gnrllgr.VDate >='$date1' AND Gnrllgr.VDate <='$date2' THEN Gnrllgr.Debit ELSE 0 END) AS TDB,SUM(CASE WHEN Gnrllgr.VDate >='$date1' AND Gnrllgr.VDate <='$date2' THEN Gnrllgr.Credit ELSE 0 END) AS TCR FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode WHERE ACCOUNT.LEVL=4 AND ACCOUNT.ATYPE IN (0,1)
						$branch GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME ORDER BY ACCOUNT.ANAME ASC");
					}
					
					foreach($ins as $inst)
					{
					
						$nBal = 0;
						$nOBAL = 0;
						$nCBal = 0;
						$grossamount=0;
						$acode = $inst[0]['ACODE'];
						$aname = $inst[0]['ANAME'];
						$nOBAL = $inst[0]['OPN'];
						$nTDB = $inst[0]['TDB'];
						$nTCR = $inst[0]['TCR'];
						$nCBal = $inst[0]['CLG'];
						$grossamount=$nOBAL+$nTDB;
					
						$insert=$this->db->query("INSERT into ACBAL (ACODE,ANAME,BALN,GROSS,TDEBIT,TCREDIT,AMOUNT,U_ID,SDATE,EDATE) values ('$acode','$aname','$grossamount','$nTDB','$nTCR','$nCBal','".$this->userData['U_ID']."','$date1','$date2') ");
					}
					$qr_del=$this->query("Delete from ACBAL WHERE GROSS=0 AND TDEBIT=0 AND TCREDIT=0 AND AMOUNT =0");
					
					/* $rpt='Cashflow1';
					$my_report = "C:\\Inetpub\\vhosts\\crspcnt.net\\1718.crspcnt.net\\crystalrp\\Reports\\".$rpt.".rpt"; 
					$filename=$rpt."-".$U_ID.".pdf";
					$forvd="../crystalrp/pdf&excel/".$filename;
					$myfile = "C:\\Inetpub\\vhosts\\crspcnt.net\\1718.crspcnt.net\\crystalrp\\pdf&excel\\".$filename;
					$FormatType=31;	
					$ObjectFactory= new COM("CrystalReports.ObjectFactory.2");
					$crapp = $ObjectFactory->CreateObject("CrystalRunTime.Application.11");
					$creport = $crapp->OpenReport($my_report, 1);
					$creport->Database->Tables(1)->SetLogOnInfo("173.249.35.42", "CRE1718", "cre17", "sep302*");
					$creport->FormulaSyntax=0; 
					//$creport->RecordSelectionFormula=stripslashes($formula);
					$creport->EnableParameterPrompting = 0;
					$creport->DiscardSavedData;
					$creport->ReadRecords();
					$creport->ExportOptions->DiskFileName=$myfile;
					$creport->ExportOptions->FormatType=$FormatType;
					$creport->ExportOptions->DestinationType=1;
					$creport->Export(false);
					$creport = null;
					$crapp = null;
					$ObjectFactory = null;
					print "<embed src=\"".$forvd."\" width=\"100%\" height=\"100%\">" */

					//$query1=$this->query("SELECT * FROM ACBAL WHERE U_ID='".$this->userData['U_ID']."'  AND BAL3 <> 0 ORDER BY ACODE ASC");
	
			//return $query1;
	} // end of cash flow
	
	}	

	
	
?>