<?php
defined("BASEPATH") OR exit("No direct script access allowed");

Class Homemodel extends MY_Model{


public function get_graph(){

$data=$this->db->query("select MONTH(Gnrllgr.VDate) as MONTH ,YEAR(Gnrllgr.VDate) as YEAR,
sum(case when PARTY.ATYPE = 0  then Gnrllgr.Debit-Gnrllgr.Credit else 0 end) as totbal,
SUM(case when jo in ('SV','SR') AND PARTY.ATYPE = 0 and Gnrllgr.jo not in ('op')  then Debit else 0 end ) as sale,
SUM(case when jo in ('JV','CR','BR') AND PARTY.ATYPE = 0   then Credit else 0 end ) as trecovery,
SUM(case when ACCOUNT.ATYPE = 10   then Debit-Credit else 0 end ) as expense
from Gnrllgr left join PARTY on Gnrllgr.ACode=PARTY.VCODE
left join account oN Gnrllgr.ACode = ACCOUNT.ACODE
where Gnrllgr.VDate IS NOT NULL AND YEAR(Gnrllgr.VDate)>=2019
group by MONTH(Gnrllgr.VDate),YEAR(Gnrllgr.VDate) 
order by Year(Gnrllgr.VDate),MONTH(Gnrllgr.VDate) asc");
return $data;
}



public function get_prev(){
$data=$this->db->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join PARTY on Gnrllgr.ACode=PARTY.VCODE 
where  Gnrllgr.VDate <'2019-01-01' AND PARTY.ATYPE = 0 ")->result_array();
return $data[0]['CREDIT'];
}



public function get_pie_chart(){
$date1 = date("Y-m-d");		// current date
$date2 = date('Y-m-d', strtotime("1 months", strtotime($date1)));  // 1 month before
$date3 = date('Y-m-d', strtotime("-1 months", strtotime($date2)));   // 2 months bofore

$d1 = date('M-Y', strtotime($date1));	// current month
$d2= date("M-Y",mktime(0,0,0,date("m")-1,1,date("Y")));
$d3 = date('M-Y', strtotime($date3));	// 2 month

$mn1 = date('m', strtotime($date1));	// current month
$mn2= date("m",mktime(0,0,0,date("m")-1,1,date("Y")));
$y2= date('Y',strtotime($date1));
$mn3 = date('m', strtotime($date3));	// 2 month


$edate1 =date("Y-$mn1-t", strtotime($date1));	// current month
$sdate1 =date("Y-$mn1-01", strtotime($date1));	// current month
if ($mn2=='02')
{
$edate2 =date("$y2-$mn2-28", strtotime($date2));	// one month
}
else
{
$edate2 =date("$y2-$mn2-t", strtotime($date2));	// one month
}
if ($mn2=='09')
{
$sdate2 =date("$y2-$mn2-30", strtotime($date2));	// one month
}
else
{
$sdate2 =date("$y2-$mn2-01", strtotime($date2));	// one month
}

if ($mn2=='09')
{
$e2date2 =date("$y2-$mn2-30", strtotime($date3));	// one month
}
else
{
$e2date2 =date("$y2-$mn2-01", strtotime($date3));	// one month
}
if ($mn3=='09')
{
$edate3 =date("y-$mn3-30", strtotime($date3));	// one month
}
else
{
$edate3 =date("Y-$mn3-t", strtotime($date3));	// 2 month
}
$sdate3 =date("Y-$mn3-01", strtotime($date3));	// 2 month

$data=$this->db->query("SELECT dbo.PRODUCT.COLOR ,
SUM(case when dbo.STOCK.VDATE >= '$sdate2' AND dbo.STOCK.VDATE <= '$sdate2' AND
dbo.STOCK.JO IN ('SV','SR')  then cast(dbo.STOCK.OUTQT as float)-cast(dbo.STOCK.INQT as float) else 0 end)
AS TQT, SUM(case when dbo.STOCK.VDATE > '$sdate2' AND dbo.STOCK.VDATE <= '$sdate2' AND dbo.STOCK.JO IN ('SV','SR') 
then cast(dbo.STOCK.OUTQT as float)-cast(dbo.STOCK.INQT as float) else 0 end) AS CTQT FROM dbo.STOCK 
INNER JOIN dbo.PRODUCT ON dbo.STOCK.PCODE = dbo.PRODUCT.PCODE GROUP BY dbo.PRODUCT.COLOR ORDER BY dbo.PRODUCT.COLOR ASC");

$d=array();
$d['data1']= $data;



$data2=$this->db->query("SELECT dbo.PRODUCT.DESIGN ,
SUM(case when dbo.STOCK.VDATE >= '$sdate2' AND dbo.STOCK.VDATE <= '$sdate2' AND
dbo.STOCK.JO IN ('SV','SR')  then cast(dbo.STOCK.OUTQT as float)-cast(dbo.STOCK.INQT as float) else 0 end)
AS TQT, SUM(case when dbo.STOCK.VDATE > '$sdate2' AND dbo.STOCK.VDATE <= '$sdate2' AND dbo.STOCK.JO IN ('SV','SR') 
then cast(dbo.STOCK.OUTQT as float)-cast(dbo.STOCK.INQT as float) else 0 end) AS CTQT FROM dbo.STOCK 
INNER JOIN dbo.PRODUCT ON dbo.STOCK.PCODE = dbo.PRODUCT.PCODE GROUP BY dbo.PRODUCT.DESIGN ORDER BY dbo.PRODUCT.DESIGN ASC");
$d['data2']= $data2;
return $d;



}



///new 
public function get_pie_chart2(){
$date1 = date("Y-m-d");		// current date
$date2 = date('Y-m-d', strtotime("-1 months", strtotime($date1)));  // 1 month before
$date3 = date('Y-m-d', strtotime("-1 months", strtotime($date2)));   // 2 months bofore

$d1 = date('M-Y', strtotime($date1));	// current month
$d2= date("M-Y",mktime(0,0,0,date("m")-1,1,date("Y")));
$d3 = date('M-Y', strtotime($date3));	// 2 month

$mn1 = date('m', strtotime($date1));	// current month
$mn2= date("m",mktime(0,0,0,date("m")-1,1,date("Y")));
$y2= date('Y',strtotime($date1));
$mn3 = date('m', strtotime($date3));	// 2 month



$edate1 =date("Y-$mn1-t", strtotime($date1));	// current month
$sdate1 =date("Y-$mn1-01", strtotime($date1));	// current month
if ($mn2=='02')
{
$edate2 =date("$y2-$mn2-28", strtotime($date2));	// one month
}
else
{
$edate2 =date("$y2-$mn2-t", strtotime($date2));	// one month
}
if ($mn2=='09')
{
$sdate2 =date("$y2-$mn2-30", strtotime($date2));	// one month
}
else
{
$sdate2 =date("$y2-$mn2-01", strtotime($date2));	// one month
}

if ($mn2=='09')
{
$e2date2 =date("$y2-$mn2-30", strtotime($date3));	// one month
}
else
{
$e2date2 =date("$y2-$mn2-01", strtotime($date3));	// one month
}
if ($mn3=='09')
{
$edate3 =date("y-$mn3-30", strtotime($date3));	// one month
}
else
{
$edate3 =date("Y-$mn3-t", strtotime($date3));	// 2 month
}
$sdate3 =date("Y-$mn3-01", strtotime($date3));	// 2 month

$data=$this->db->query("SELECT dbo.PRODUCT.COLOR ,
SUM(case when dbo.STOCK.VDATE >= '$sdate2' AND dbo.STOCK.VDATE <= '$sdate2' AND
dbo.STOCK.JO IN ('SV','SR')  then cast(dbo.STOCK.OUTQT as float)-cast(dbo.STOCK.INQT as float) else 0 end)
AS TQT, SUM(case when dbo.STOCK.VDATE > '$sdate2' AND dbo.STOCK.VDATE <= '$sdate2' AND dbo.STOCK.JO IN ('SV','SR') 
then cast(dbo.STOCK.OUTQT as float)-cast(dbo.STOCK.INQT as float) else 0 end) AS CTQT FROM dbo.STOCK 
INNER JOIN dbo.PRODUCT ON dbo.STOCK.PCODE = dbo.PRODUCT.PCODE GROUP BY dbo.PRODUCT.COLOR ORDER BY dbo.PRODUCT.COLOR ASC");

$d=array();
$d['data1']= $data;



$data2=$this->db->query("SELECT dbo.PRODUCT.DESIGN ,
SUM(case when dbo.STOCK.VDATE >= '$sdate2' AND dbo.STOCK.VDATE <= '$sdate2' AND
dbo.STOCK.JO IN ('SV','SR')  then cast(dbo.STOCK.OUTQT as float)-cast(dbo.STOCK.INQT as float) else 0 end)
AS TQT, SUM(case when dbo.STOCK.VDATE > '$sdate2' AND dbo.STOCK.VDATE <= '$sdate2' AND dbo.STOCK.JO IN ('SV','SR') 
then cast(dbo.STOCK.OUTQT as float)-cast(dbo.STOCK.INQT as float) else 0 end) AS CTQT FROM dbo.STOCK 
INNER JOIN dbo.PRODUCT ON dbo.STOCK.PCODE = dbo.PRODUCT.PCODE GROUP BY dbo.PRODUCT.DESIGN ORDER BY dbo.PRODUCT.DESIGN ASC");
$d['data2']= $data2;
return $d;



}


}