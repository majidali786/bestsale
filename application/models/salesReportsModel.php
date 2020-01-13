<?php
	class salesReportsModel extends MY_Model{
	
	public function sales($data){
		
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

	
	
	$date1=$data['date1'];
	$date2=$data['date2'];
	
	$result=$this->query("SELECT T1.VCODE,T1.NO,T1.VDATE,T1.VNO,T1.B_ID,T1.DISCOUNT
	,T1.RAMOUNT,T1.NET,T2.PCODE,T2.UNIT,T2.DISCOUNT,T2.DISCOUNTPER,T2.TOTAL,T2.GST,T2.GSTPER,T2.NET,T2.QTY,T2.RATE,T2.AMOUNT,T3.ANAME,T4.PNAME 
	FROM SALE1 AS T1 INNER JOIN SALE2 AS T2 ON T1.NO=T2.NO AND T1.B_ID=T2.B_ID 
	LEFT JOIN ACCOUNT AS T3 ON T1.VCODE=T3.ACODE 
	LEFT JOIN PRODUCT AS T4 ON T2.PCODE=T4.PCODE WHERE T1.VDATE >='$date1' AND T1.VDATE <='$date2' AND T1.B_ID='".$this->userData['B_ID']."' $party $product
	ORDER BY T1.VDATE
	");
	

	return $result;
		
	}	
	public function saleReturn($data){
		
	
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

	
	
	$date1=$data['date1'];
	$date2=$data['date2'];
	
	$result=$this->query("SELECT T1.VCODE,T1.NO,T1.VDATE,T1.VNO,T1.B_ID,T1.DISCOUNT
	,T1.RAMOUNT,T1.NET,T2.PCODE,T2.UNIT,T2.DISCOUNT,T2.DISCOUNTPER,T2.TOTAL,T2.GST,T2.GSTPER,T2.NET,T2.QTY,T2.RATE,T2.AMOUNT,T3.ANAME
	,T4.PNAME 
	FROM SRET1 AS T1 INNER JOIN SRET2 AS T2 ON T1.NO=T2.NO AND T1.B_ID=T2.B_ID 
	LEFT JOIN ACCOUNT AS T3 ON T1.VCODE=T3.ACODE 
	LEFT JOIN PRODUCT AS T4 ON T2.PCODE=T4.PCODE WHERE T1.VDATE >='$date1' AND T1.VDATE <='$date2' $branch $party $product
	ORDER BY T1.VDATE
	");

	return $result;
		
	}

//SALES LIST
	public function SaleList($data){
		
	if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND SALE1.B_ID='".$data['branch']."'";		
	}
	$date1=$data['date1'];
	$date2=$data['date2'];
	$result=$this->query("
SELECT DISTINCT(dbo.Gnrllgr.VNO) AS VNO, dbo.Gnrllgr.ACode, dbo.ACCOUNT.ANAME,
SUM(dbo.Gnrllgr.CREDIT) AS BAL, dbo.Gnrllgr.B_ID, dbo.SALE1.TOTAL, dbo.SALE1.NET,
dbo.SALE1.U_ID FROM dbo.Gnrllgr LEFT JOIN dbo.ACCOUNT ON dbo.Gnrllgr.ACode = dbo.ACCOUNT.ACODE  
LEFT JOIN dbo.SALE1 ON dbo.Gnrllgr.VNO = dbo.SALE1.VNO 
AND dbo.Gnrllgr.B_ID = dbo.SALE1.B_ID 
WHERE SALE1.VDATE >='$date1' AND SALE1.VDATE <='$date2' $branch 
AND Gnrllgr.ACode NOT IN ('20102001','30101001') GROUP BY dbo.Gnrllgr.VNO,
dbo.Gnrllgr.ACode, dbo.ACCOUNT.ANAME,
dbo.Gnrllgr.B_ID, dbo.SALE1.TOTAL, dbo.SALE1.NET, 
dbo.SALE1.U_ID HAVING (SUM(dbo.Gnrllgr.CREDIT) > 0)
");
return $result;
		}	
	
	//sales adjustment
	
	public function SaleAdj($data){
		
	if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND Gnrllgr.B_ID='".$data['branch']."'";		
	}
	$date1=$data['date1'];
	$date2=$data['date2'];
	$result=$this->query("SELECT     dbo.Gnrllgr.ACode, dbo.PARTY.VNAME, ROUND(SUM(dbo.Gnrllgr.Debit - dbo.Gnrllgr.Credit), 2) AS DIF, dbo.Gnrllgr.VNO AS INVNO, dbo.Gnrllgr.B_ID
	FROM       dbo.Gnrllgr INNER JOIN
                      dbo.PARTY ON dbo.Gnrllgr.ACode = dbo.PARTY.VCODE
	WHERE     (dbo.Gnrllgr.Jo IN ('SA', 'CR')) AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' $branch 
	GROUP BY dbo.Gnrllgr.ACode, dbo.PARTY.VNAME, dbo.Gnrllgr.VNO, dbo.Gnrllgr.B_ID
	HAVING      (SUM(dbo.Gnrllgr.Debit - dbo.Gnrllgr.Credit) > 0)");
	
	return $result;
		}
		
	
	
	}
	
?>