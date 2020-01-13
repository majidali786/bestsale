<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monthlystatus extends MY_Controller{

function __construct(){
parent::__construct();
//$this->load->model("MonthlystatusModel");
$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs");
}

public function loadcuststatus(){
	if($this->input->is_ajax_request()){
	$cust1=$this->dataModel->query("SELECT TOP 5 ACODE,ANAME,DEBIT AS AMOUNT FROM CUSTSTATUS ORDER BY DEBIT DESC");
	$response=$this->load->view("monthlystatus/customerstatus",["data"=>$cust1],true);
	echo $response;
	}	
	}		

public function loadpchallan(){
if($this->input->is_ajax_request()){
$pchallan=$this->dataModel->query("

select t1.NO,t1.PCODE,t1.PNAME,round(t1.bal,2) as QTY,t1.COLOR,t2.VNAME,t1.VDATE
,t1.STATUS,t4.IMG from (
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
where t1.B_ID='".$this->userData['B_ID']."'
group by t1.NO,t1.PCODE,t1.bal,t1.PNAME,t1.COLOR,t1.VDATE,t2.VNAME,t1.STATUS,t4.IMG
order by t1.NO asc


");

$response=$this->load->view("monthlystatus/pendingchallan",["data"=>$pchallan],true);
echo $response;
}	
}

public function loadsalesinvoices(){
if($this->input->is_ajax_request()){
$sale1=$this->dataModel->query("SELECT TOP 5 NO,VDATE,VNO,VCODE,VNAME,NET FROM SALE1 ORDER BY NET DESC");

$response=$this->load->view("monthlystatus/salesinvoices",["data"=>$sale1],true);
echo $response;
}	
}

public function loadcustrecovery(){
if($this->input->is_ajax_request()){
$cust2=$this->dataModel->query("SELECT TOP 5 ACODE,ANAME,CREDIT AS AMOUNT FROM CUSTSTATUS ORDER BY CREDIT DESC");

$response=$this->load->view("monthlystatus/customer_recovery",["data"=>$cust2],true);
echo $response;
}	
}

public function loadrecovery(){
if($this->input->is_ajax_request()){
$cust2=$this->dataModel->query("SELECT TOP 5 NO,VDATE,VNO,JO,ACODE,ANAME,CREDIT FROM RECOVERY ORDER BY CREDIT DESC");

$response=$this->load->view("monthlystatus/recovery",["data"=>$cust2],true);
echo $response;
}	
}	
public function loadmonthlystatus(){
if($this->input->is_ajax_request()){
$stk1=$this->dataModel->query("SELECT SUM(AMOUNT) AS AMOUNT FROM STOCK_0719");
$stk2=$this->dataModel->query("SELECT SUM(AMOUNT) AS AMOUNT FROM STOCK_0819");
$stk3=$this->dataModel->query("SELECT SUM(AMOUNT) AS AMOUNT FROM STOCK_0919");
$stk4=$this->dataModel->query("SELECT SUM(AMOUNT) AS AMOUNT FROM STOCK_1019");
$stk5=$this->dataModel->query("SELECT SUM(AMOUNT) AS AMOUNT FROM STOCK_1119");
$stk6=$this->dataModel->query("SELECT SUM(AMOUNT) AS AMOUNT FROM STOCK_1219");
// CUSTOMER BALANCE
$stk7=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate <='2019-09-30' AND ACCOUNT.ATYPE = 4");
$stk8=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate <='2019-10-31' AND ACCOUNT.ATYPE = 4");
$stk9=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate <='2019-11-30' AND ACCOUNT.ATYPE = 4");
$stk10=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate <='2019-12-31' AND ACCOUNT.ATYPE = 4");
$stk11=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate <='2020-01-30' AND ACCOUNT.ATYPE = 4");
$stk12=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate <='2020-02-28' AND ACCOUNT.ATYPE = 4");
// SUPPLIER BALANCE
$stk13=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate <='2019-09-30'AND ACCOUNT.ATYPE = 5");
$stk14=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate <='2019-10-31' AND ACCOUNT.ATYPE = 5");
$stk15=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate <='2019-11-30' AND ACCOUNT.ATYPE = 5");
$stk16=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate <='2019-12-31' AND ACCOUNT.ATYPE = 5");
$stk17=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate <='2020-01-30' AND ACCOUNT.ATYPE = 5");
$stk18=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate <='2020-02-28' AND ACCOUNT.ATYPE = 5");
// SALES
$stk19=$this->dataModel->query("select sum(Gnrllgr.Credit-Gnrllgr.Debit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2019-09-01' AND Gnrllgr.VDate <='2019-09-30' AND ACCOUNT.ATYPE = 7");
$stk20=$this->dataModel->query("select sum(Gnrllgr.Credit-Gnrllgr.Debit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2019-10-01' AND Gnrllgr.VDate <='2019-10-31' AND ACCOUNT.ATYPE = 7");
$stk21=$this->dataModel->query("select sum(Gnrllgr.Credit-Gnrllgr.Debit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2019-11-01' AND Gnrllgr.VDate <='2019-11-30' AND ACCOUNT.ATYPE = 7");
$stk22=$this->dataModel->query("select sum(Gnrllgr.Credit-Gnrllgr.Debit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2019-12-01' AND Gnrllgr.VDate <='2019-12-31' AND ACCOUNT.ATYPE = 7");
$stk23=$this->dataModel->query("select sum(Gnrllgr.Credit-Gnrllgr.Debit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2020-01-01' AND Gnrllgr.VDate <='2020-01-30' AND ACCOUNT.ATYPE = 7");
$stk24=$this->dataModel->query("select sum(Gnrllgr.Credit-Gnrllgr.Debit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2020-02-01' AND Gnrllgr.VDate <='2020-02-28' AND ACCOUNT.ATYPE = 7");
// RECOVERY
$stk25=$this->dataModel->query("select sum(Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.JO IN ('CR','BR') AND Gnrllgr.VDate >='2019-09-01' AND Gnrllgr.VDate <='2019-09-30' AND ACCOUNT.ATYPE = 4");
$stk26=$this->dataModel->query("select sum(Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.JO IN ('CR','BR') AND Gnrllgr.VDate >='2019-10-01' AND Gnrllgr.VDate <='2019-10-31' AND ACCOUNT.ATYPE = 4");
$stk27=$this->dataModel->query("select sum(Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.JO IN ('CR','BR') AND Gnrllgr.VDate >='2019-11-01' AND Gnrllgr.VDate <='2019-11-30' AND ACCOUNT.ATYPE = 4");
$stk28=$this->dataModel->query("select sum(Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.JO IN ('CR','BR') AND Gnrllgr.VDate >='2019-12-01' AND Gnrllgr.VDate <='2019-12-31' AND ACCOUNT.ATYPE = 4");
$stk29=$this->dataModel->query("select sum(Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.JO IN ('CR','BR') AND Gnrllgr.VDate >='2020-01-01' AND Gnrllgr.VDate <='2020-01-30' AND ACCOUNT.ATYPE = 4");
$stk30=$this->dataModel->query("select sum(Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.JO IN ('CR','BR') AND Gnrllgr.VDate >='2020-02-01' AND Gnrllgr.VDate <='2020-02-28' AND ACCOUNT.ATYPE = 4");
// PURCHASES
$stk31=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2019-09-01' AND Gnrllgr.VDate <='2019-09-30' AND ACCOUNT.ATYPE = 8");
$stk32=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2019-10-01' AND Gnrllgr.VDate <='2019-10-31' AND ACCOUNT.ATYPE = 8");
$stk33=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2019-11-01' AND Gnrllgr.VDate <='2019-11-30' AND ACCOUNT.ATYPE = 8");
$stk34=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2019-12-01' AND Gnrllgr.VDate <='2019-12-31' AND ACCOUNT.ATYPE = 8");
$stk35=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2020-01-01' AND Gnrllgr.VDate <='2020-01-31' AND ACCOUNT.ATYPE = 8");
$stk36=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2020-02-01' AND Gnrllgr.VDate <='2020-02-28' AND ACCOUNT.ATYPE = 8");

// EXPENSES
$stk37=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2019-09-01' AND Gnrllgr.VDate <='2019-09-30' AND ACCOUNT.AGROUP = 4 AND ACCOUNT.LEVL=4");
$stk38=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2019-10-01' AND Gnrllgr.VDate <='2019-10-31' AND ACCOUNT.AGROUP = 4 AND ACCOUNT.LEVL=4");
$stk39=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2019-11-01' AND Gnrllgr.VDate <='2019-11-30' AND ACCOUNT.AGROUP = 4 AND ACCOUNT.LEVL=4");
$stk40=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2019-12-01' AND Gnrllgr.VDate <='2019-12-31' AND ACCOUNT.AGROUP = 4 AND ACCOUNT.LEVL=4");
$stk41=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2020-01-01' AND Gnrllgr.VDate <='2020-01-30' AND ACCOUNT.AGROUP = 4 AND ACCOUNT.LEVL=4");
$stk42=$this->dataModel->query("select sum(Gnrllgr.Debit-Gnrllgr.Credit) as CREDIT from Gnrllgr inner join ACCOUNT on Gnrllgr.ACode=ACCOUNT.ACODE where Gnrllgr.VDate >='2020-02-01' AND Gnrllgr.VDate <='2020-02-28' AND ACCOUNT.AGROUP = 4 AND ACCOUNT.LEVL=4");


$response=$this->load->view("monthlystatus/stockstatus",["data"=>$stk1,"data2"=>$stk2,"data3"=>$stk3,"data4"=>$stk4,"data5"=>$stk5,"data6"=>$stk6,"data7"=>$stk7,"data8"=>$stk8,"data9"=>$stk9,"data10"=>$stk10,"data11"=>$stk11,"data12"=>$stk12,"data13"=>$stk13,"data14"=>$stk14,"data15"=>$stk15,"data16"=>$stk16,"data17"=>$stk17,"data18"=>$stk18,"data19"=>$stk19,"data20"=>$stk20,"data21"=>$stk21,"data22"=>$stk22,"data23"=>$stk23,"data24"=>$stk24,"data25"=>$stk25,"data26"=>$stk26,"data27"=>$stk27,"data28"=>$stk28,"data29"=>$stk29,"data30"=>$stk30,"data31"=>$stk31,"data32"=>$stk32,"data33"=>$stk33,"data34"=>$stk34,"data35"=>$stk35,"data36"=>$stk36,"data37"=>$stk37,"data38"=>$stk38,"data39"=>$stk39,"data40"=>$stk40,"data41"=>$stk41,"data42"=>$stk42],true);
echo $response;
}	
}

public function loadPromise(){
if($this->input->is_ajax_request()){
$data=$this->input->get();	
$data1=$this->dataModel->query("SELECT * FROM PROMISE WHERE NO='".$data['pno']."' AND B_ID='".$this->userData['B_ID']."'");
$data2=$this->dataModel->query("SELECT * FROM PROMISECOMMENT WHERE PNO='".$data['pno']."' AND B_ID='".$this->userData['B_ID']."'");
$response=$this->load->view("promise/single-promise",["data"=>$data1,"data2"=>$data2],true);
echo $response;	
}	
}


function comment(){
$this->punchData['libraries']=array("promiseJs");
$segment=$this->uri->segment(4);
$pno=$this->uri->segment(3);	
if($this->input->is_ajax_request() && is_numeric($pno))
{
if($segment=="save")
{
$this->form_validation->set_rules("pamount","Amount Paid","required|numeric");
$this->form_validation->set_rules("cstatus","Status","required");
$this->form_validation->set_rules("description","Description","required");
if($this->input->post("cstatus")==1){
$this->form_validation->set_rules("eamount","Expected Amount","required|numeric");
$this->form_validation->set_rules("edate","Expected Date","required");
}
if($this->form_validation->run()){
$data=$this->input->post();
$data['pno']=$pno;
if($this->PromiseModel->insertComment($data)){
echo json_encode(array("error"=>"","success"=>"true"));
}
else{
echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
}
}
else{
echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
}	
}
if($segment=="edit")
{
$data=$this->PromiseModel->getData("PROMISECOMMENT",array("PNO"=>$pno,"NO"=>$this->input->get("no"),"B_ID"=>$this->userData['B_ID']),"","");
$this->punchData['data']=$data;
echo $this->load->view("promise/edit-promise-comment",$this->punchData,TRUE);	
}
if($segment=="update")
{
$this->form_validation->set_rules("pamount","Amount Paid","required|numeric");
$this->form_validation->set_rules("cstatus_e","Status","required");
$this->form_validation->set_rules("description","Description","required");
if($this->input->post("cstatus_e")==1){
$this->form_validation->set_rules("eamount","Expected Amount","required|numeric");
$this->form_validation->set_rules("edate","Expected Date","required");
}
if($this->form_validation->run()){
$data=$this->input->post();
$data['pno']=$pno;
if($this->PromiseModel->updateComment($data)){
echo json_encode(array("error"=>"","success"=>"true"));
}
else{
echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
}
}
else{
echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
}	
}
if($segment=="delete")
{
$data=$this->PromiseModel->getData("PROMISECOMMENT",array("PNO"=>$pno,"NO"=>$this->input->post("no"),"B_ID"=>$this->userData['B_ID']),"","");	
$data1=$this->PromiseModel->deleteData("PROMISECOMMENT",array("PNO"=>$pno,"NO"=>$this->input->post("no"),"B_ID"=>$this->userData['B_ID']));
if($data[0]['STATUS']==0){
$this->db->query("UPDATE PROMISE SET STATUS=1 WHERE NO='$pno' AND B_ID='".$this->userData['B_ID']."'");	
}
echo json_encode(array("success"=>"true"));
}
if($segment=="close")
{
$this->db->query("UPDATE PROMISE SET STATUS=0 WHERE NO='$pno' AND B_ID='".$this->userData['B_ID']."'");	
echo json_encode(array("success"=>"true"));
}
if($segment=="open")
{
$this->db->query("UPDATE PROMISE SET STATUS=1 WHERE NO='$pno' AND B_ID='".$this->userData['B_ID']."'");	
echo json_encode(array("success"=>"true"));
}
}	
}







}
