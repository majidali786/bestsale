<?php
	class supplierReportsModel extends MY_Model{
		
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
	SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(CASE WHEN Gnrllgr.VDate<='$vdate' THEN 
	Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL1,SUM(CASE WHEN Gnrllgr.VDate<='$vdate2' THEN 
	Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL2,SUM(CASE WHEN Gnrllgr.VDate<='$vdate3' THEN 
	Gnrllgr.Debit-Gnrllgr.Credit ELSE 0 END) AS BAL3,'$vdate','$vdate2','$vdate3','".$this->userData['U_ID']."','".$this->userData['B_ID']."' 
	FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode WHERE ACCOUNT.ATYPE=5 AND ACCOUNT.LEVL=4 $branch GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME
	HAVING SUM(Gnrllgr.DEBIT-Gnrllgr.CREDIT)<>0 ORDER BY ACCOUNT.ANAME ASC");
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."'");
	
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
	
	
	if($data['rtype']==2){
		
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,VDATE,DESCR,U_ID,DATE1,DATE2,B_ID) 
	SELECT '".$data['party']."',PARTY.VNAME,sum(Debit),sum(Credit),$date1,'Opening','".$this->userData['U_ID']."'
	
	,'$date1','$date2','".$this->userData['B_ID']."' from gnrllgr inner join PARTY on Gnrllgr.ACode=PARTY.VCODE 
	where VDate<'$date1' and ACode='".$data['party']."' $branch  group by PARTY.VNAME");	
	
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2) 
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,Gnrllgr.DEBIT,Gnrllgr.CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr,
	Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2' FROM Gnrllgr 
	INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr.ACode  WHERE PARTY.ATYPE=1 AND Gnrllgr.ACODE='".$data['party']."' 
	AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' $branch
	ORDER BY Gnrllgr.VDATE ASC");
	}
	else if($data['rtype']==1){
		
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,VDATE,DESCR,U_ID,DATE1,DATE2) 
	SELECT '".$data['party']."',PARTY.VNAME,sum(Debit),sum(Credit),$date1,'Opening'
	,'".$this->userData['U_ID']."','$date1','$date2' from gnrllgr inner join PARTY on Gnrllgr.ACode=PARTY.VCODE 
	where VDate<'$date1' and ACode='".$data['party']."' $branch group by PARTY.VNAME");	
	
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2)
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,sum(Gnrllgr.DEBIT) as DEBIT,sum(Gnrllgr.CREDIT) as CREDIT,Gnrllgr.NO,Gnrllgr.Jo
	,Gnrllgr.VDATE,Gnrllgr.Descr,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2' 
	FROM Gnrllgr INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr.ACode WHERE PARTY.ATYPE=1 AND Gnrllgr.ACODE='".$data['party']."'
	AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' $branch AND Jo NOT IN ('PU','PR') GROUP BY PARTY.VCODE,PARTY.VNAME,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr,Gnrllgr.CHQNO,Gnrllgr.B_ID
	ORDER BY Gnrllgr.VDATE ASC");
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2) SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,SUM(Gnrllgr.DEBIT) AS DEBIT,SUM(Gnrllgr.CREDIT) AS CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,' Inovice # '+CAST(PURCH1.NO AS NVARCHAR(100))+' Book No.'+CAST(PURCH1.VNO AS NVARCHAR(100)) AS DESCR,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2' FROM Gnrllgr INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr.ACode
	INNER JOIN PURCH1 ON Gnrllgr.No=PURCH1.NO AND Gnrllgr.B_ID=PURCH1.B_ID
	WHERE PARTY.ATYPE=1 AND Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' $branch AND Jo IN ('PU')
	GROUP BY PARTY.VCODE,PARTY.VNAME,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.CHQNO,Gnrllgr.B_ID,PURCH1.NO,PURCH1.VNO
	ORDER BY Gnrllgr.VDATE ASC
	");
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2) 
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,SUM(Gnrllgr.DEBIT) AS DEBIT,SUM(Gnrllgr.CREDIT) AS CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,' Inovice # '+CAST(PRET1.NO AS NVARCHAR(100))+' Book No.'+CAST(PRET1.VNO AS NVARCHAR(100)) AS DESCR,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2' FROM Gnrllgr INNER JOIN PARTY ON PARTY.VCODE=Gnrllgr.ACode 
	INNER JOIN PRET1 ON Gnrllgr.No=PRET1.NO AND Gnrllgr.B_ID=PRET1.B_ID
	WHERE PARTY.ATYPE=1 AND Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' $branch AND Jo IN ('PR')
	GROUP BY PARTY.VCODE,PARTY.VNAME,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.CHQNO,Gnrllgr.B_ID,PRET1.NO,PRET1.VNO
	ORDER BY Gnrllgr.VDATE ASC
	");
	}
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY VDATE ASC");
	
	return $query1;
	
	}
	
	
	public function sbalance($data){
	if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND SGnrllgr.B_ID='".$data['branch']."'";		
	}
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$vdate=$data['vdate'];
	$vdate2=$data['vdate2'];
	$vdate3=$data['vdate3'];
	
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,BAL,BAL2,BAL3,DATE1,DATE2,DATE3,U_ID,B_ID) 
	SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(CASE WHEN SGnrllgr.VDate<='$vdate' THEN 
	SGnrllgr.Debit-SGnrllgr.Credit ELSE 0 END) AS BAL1,SUM(CASE WHEN SGnrllgr.VDate<='$vdate2' THEN 
	SGnrllgr.Debit-SGnrllgr.Credit ELSE 0 END) AS BAL2,SUM(CASE WHEN SGnrllgr.VDate<='$vdate3' THEN 
	SGnrllgr.Debit-SGnrllgr.Credit ELSE 0 END) AS BAL3,'$vdate','$vdate2','$vdate3','".$this->userData['U_ID']."'
	,'".$this->userData['UB_ID']."' 
	FROM SGnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=SGnrllgr.ACode WHERE ACCOUNT.ATYPE=5 AND ACCOUNT.LEVL=4 $branch 
	GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME
	HAVING SUM(SGnrllgr.DEBIT-SGnrllgr.CREDIT)<>0 ORDER BY ACCOUNT.ANAME ASC");
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."'");
	
	return $query1;
	
	}
	
	public function sledger($data){
		
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	
	
	if($data['rtype']==2){
		
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,VDATE,DESCR,U_ID,DATE1,DATE2) 
	SELECT '".$data['party']."',PARTY.VNAME,sum(Debit),sum(Credit),$date1,'Opening','".$this->userData['U_ID']."','$date1','$date2' 
	from sgnrllgr inner join PARTY on sGnrllgr.ACode=PARTY.VCODE where VDate<'$date1' and ACode='".$data['party']."' group by PARTY.VNAME");	
	
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,U_ID,B_ID,DATE1,DATE2) 
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,sGnrllgr.DEBIT,sGnrllgr.CREDIT,sGnrllgr.NO,sGnrllgr.Jo,sGnrllgr.VDATE,sGnrllgr.Descr
	,'".$this->userData['U_ID']."',sGnrllgr.B_ID,'$date1','$date2' FROM sGnrllgr INNER JOIN PARTY ON PARTY.VCODE=sGnrllgr.ACode  WHERE PARTY.ATYPE=1 AND 
	sGnrllgr.ACODE='".$data['party']."' AND sGnrllgr.VDATE >='$date1' AND sGnrllgr.VDATE <='$date2'
	ORDER BY sGnrllgr.VDATE ASC");
	}
	else if($data['rtype']==1){
		
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,VDATE,DESCR,U_ID,DATE1,DATE2) 
	SELECT '".$data['party']."',PARTY.VNAME,sum(Debit),sum(Credit),$date1,'Opening','".$this->userData['U_ID']."','$date1','$date2' from 
	sgnrllgr inner join PARTY on sGnrllgr.ACode=PARTY.VCODE where VDate<'$date1' and ACode='".$data['party']."' group by PARTY.VNAME");	
	
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,U_ID,B_ID,DATE1,DATE2) 
	SELECT PARTY.VCODE AS ACODE,PARTY.VNAME,sum(sGnrllgr.DEBIT) as DEBIT,sum(sGnrllgr.CREDIT) as CREDIT,sGnrllgr.NO,sGnrllgr.Jo
	,sGnrllgr.VDATE,sGnrllgr.Descr,'".$this->userData['U_ID']."',sGnrllgr.B_ID,'$date1','$date2' 
	FROM sGnrllgr INNER JOIN PARTY ON PARTY.VCODE=sGnrllgr.ACode WHERE PARTY.ATYPE=1 AND sGnrllgr.ACODE='".$data['party']."'
	AND sGnrllgr.VDATE >='$date1' AND sGnrllgr.VDATE <='$date2' GROUP BY PARTY.VCODE,PARTY.VNAME,sGnrllgr.NO,sGnrllgr.Jo
	,sGnrllgr.VDATE,sGnrllgr.Descr,sGnrllgr.B_ID
	ORDER BY sGnrllgr.VDATE ASC");

	
	}
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY VDATE ASC");
	
	return $query1;
	
	}
	
	
	public function aging($data){
		
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$date=$data['vdate'];
	$select=$this->query("SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(Gnrllgr.CREDIT) AS CREDIT,Gnrllgr.NO
	,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.CHQNO,'".$this->userData['U_ID']."' AS U_ID,(SELECT SUM(Gnrllgr.DEBIT) AS TDEBIT FROM Gnrllgr WHERE Gnrllgr.ACODE='".$data['party']."') AS TDEBIT
	,Gnrllgr.B_ID,DATEDIFF(day,Gnrllgr.VDATE,'$date') AS PDAYS
	FROM Gnrllgr 
	INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode 
	WHERE Gnrllgr.CREDIT>0 AND ACCOUNT.ATYPE=5 AND ACCOUNT.LEVL=4 AND Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.B_ID='".$this->userData['B_ID']."'
	GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.NO,Gnrllgr.B_ID,Gnrllgr.CHQNO
	ORDER BY Gnrllgr.VDATE ASC
	");
	$tdebit=$bal15=$bal30=$bal45=$bal60=$bal75=$bal90=$bal105=$bal120=$bal121=0;
	if(!empty($select)){
	$tdebit=$select[0]['TDEBIT'];
	}
	foreach($select as $row){
	$invoiceAmt=$row['CREDIT'];	
	$bal=$tdebit-$row['CREDIT'];
	if($bal<0){
	$bal1=abs($bal);	
	$credit=abs($bal);	
	if($tdebit<0){
	$credit=$row['CREDIT'];	
	}
	$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,BAL2,BAL,NO,JO,VDATE,INVDAYS,U_ID,B_ID) VALUES('".$row['ACODE']."','".$row['ANAME']."','".$credit."',$invoiceAmt,$bal1,'".$row['NO']."','".$row['Jo']."','".$row['VDATE']."','".$row['PDAYS']."','".$row['U_ID']."','".$row['B_ID']."')");
	if($row['PDAYS']<=15){
	$bal15+=$credit;
	}
	else if($row['PDAYS'] >15 && $row['PDAYS']<=30){
	$bal30+=$credit;	
	}
	else if($row['PDAYS'] >30 && $row['PDAYS']<=45){
	$bal45+=$credit;	
	}
	else if($row['PDAYS'] >45 && $row['PDAYS']<=60){
	$bal60+=$credit;	
	}
	else if($row['PDAYS'] >60 && $row['PDAYS']<=75){
	$bal75+=$credit;	
	}
	else if($row['PDAYS'] >75 && $row['PDAYS']<=90){
	$bal90+=$credit;	
	}
	else if($row['PDAYS'] >90 && $row['PDAYS']<=105){
	$bal105+=$credit;	
	}
	else if($row['PDAYS'] >105 && $row['PDAYS']<=120){
	$bal120+=$credit;	
	}
	else if($row['PDAYS'] >120){
	$ba121+=$credit;	
	}
	}
	$tdebit=$bal;
	}
	$update=$this->db->query("UPDATE Lgrrep SET BAL15='$bal15',BAL30='$bal30',BAL45='$bal45',BAL60='$bal60',BAL75='$bal75',BAL90='$bal90',BAL105='$bal105',BAL120='$bal120',BAL121='$bal121' WHERE U_ID='".$this->userData['U_ID']."'");
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."' ORDER BY VDATE ASC");
	
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

	if($data['party']==0){
	$party="";	
	}
	else{
	$party="AND ACCOUNT.ACODE='".$data['party']."'";		
	}

	$parties=$this->query("SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,SUM(Gnrllgr.DEBIT) AS TCREDIT FROM Gnrllgr INNER 
	JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode WHERE ACCOUNT.ATYPE=5 AND ACCOUNT.LEVL=4 $party $branch GROUP BY ACCOUNT.ACODE,ACCOUNT.ANAME
	HAVING SUM(Gnrllgr.DEBIT-Gnrllgr.CREDIT)<>0 ORDER BY ACCOUNT.ANAME ASC");
	if(!empty($parties)){
	foreach($parties as $a){
		
	$select=$this->query("SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,Gnrllgr.CREDIT,Gnrllgr.NO
	,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr,Gnrllgr.CHQNO,'".$this->userData['U_ID']."' AS U_ID,Gnrllgr.B_ID,DATEDIFF(day,Gnrllgr.VDATE,'$date') AS PDAYS
	FROM Gnrllgr 
	INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode 
	WHERE Gnrllgr.CREDIT>0 AND ACCOUNT.ATYPE=5 AND ACCOUNT.LEVL=4 AND Gnrllgr.ACODE='".$a['ACODE']."' $branch 
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
	else if($row['PDAYS'] >90 && $row['PDAYS']<=120){
	$bal120+=$debit;	
	}
	else if($row['PDAYS'] >120){
	$bal121+=$debit;	
	}
	}
	$tcredit=$bal;
	}
	$update=$this->db->query("UPDATE Lgrrep SET BAL30='$bal30',BAL45='$bal45',BAL60='$bal60',BAL90='$bal90',BAL120='$bal120',BAL121='$bal121',BAL='$tdebit' WHERE U_ID='".$this->userData['U_ID']."' AND ACODE='".$a['ACODE']."'");
	}
	$insert=$this->db->query("INSERT INTO Lgrrep_age(ACODE,ANAME,BAL,BAL30,BAL45,BAL60,BAL90,BAL120,BAL121,U_ID) SELECT ACODE,ANAME,BAL,BAL30,BAL45,BAL60,BAL90,BAL120,BAL121,U_ID FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."' GROUP BY ACODE,ANAME,U_ID,BAL,BAL30,BAL45,BAL60,BAL90,BAL120,BAL121");
	}
	
	$query1=$this->query("SELECT * FROM Lgrrep_age WHERE U_ID='".$this->userData['U_ID']."' ORDER BY ANAME ASC");
	
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
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,CHQNO,U_ID,B_ID,DATE1,DATE2,CDAYS) SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,Gnrllgr.DEBIT,Gnrllgr.CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr,Gnrllgr.CHQNO,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2',T3.NO FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode
	LEFT JOIN ( SELECT NO,B_ID FROM PURCH1 WHERE VCODE='".$data['party']."' GROUP BY NO,B_ID) AS T3 ON Gnrllgr.PNO=T3.NO AND Gnrllgr.B_ID=T3.B_ID
	WHERE ACCOUNT.ATYPE=5 AND ACCOUNT.LEVL=4 AND Gnrllgr.ACODE='".$data['party']."' 
	AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' $branch AND Gnrllgr.PNO <>'' AND Gnrllgr.PNO IS NOT NULL 
	ORDER BY Gnrllgr.B_ID,Gnrllgr.NO,Gnrllgr.VDATE ASC");
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY CDAYS,VDATE ASC");
	
	return $query1;
	
	}
	
	
	}
	
?>