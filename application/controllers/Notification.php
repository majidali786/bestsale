<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MY_Controller{
	
	public $joInWords;
	
	function __construct(){
	parent::__construct();
	$this->load->model("NotificationModel");
	$this->punchData['libraries']=array("datatable","formJs");
	$this->joInWords=array("BI"=>"Book Issue Note Voucher","BP"=>"Bank Payment Voucher","BR"=>"Bank Receipt Voucher","CP"=>"Cash Payment Voucher","CR"=>"Cash Receipt Voucher","CT"=>"Cheque Transfer Voucher","DO"=>"Customer Demand Order","JV"=>"Journal Voucher","LC"=>"LC Information Voucher","LE"=>"LC Expense Voucher","LJ"=>"LC Journal Model","LN"=>"Loan/Advance Voucher","LP"=>"Loan/Advance Payment Voucher","LS"=>"LC Sale Voucher","OP"=>"Opening Journal Voucher","PL"=>"LC Purchase Voucher","PR"=>"Purchase Return Voucher","PU"=>"Purchase Voucher","RC"=>"Cheque Receipt Voucher","SL"=>"Sale Voucher","SO"=>"Sale Order Voucher","SR"=>"Sale Return Voucher","SS"=>"Salary Sheet Voucher","ST"=>"Stock Transfer Voucher","SG"=>"Store & Spare Goods Receipt Note","OR"=>"Store & Spare Opening Stock","TS"=>"Store & Spare Stock Transfer","DV"=>"Discount Voucher","BM"=>"Book Issue Note Memo","AM"=>"Amendment Voucher","CM"=>"Cash Payment Memo","MO"=>"Memo Voucher","DC"=>"Delivery Challan");
	$this->punchData['joInWords']=$this->joInWords;
	}
	
	function pendingVoucher(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="voucher-list")
		{
		$JoLinks=array("BI"=>"sales/book-issue-note","BP"=>"financial/bank-payment","BR"=>"financial/bank-reciept","CP"=>"financial/cash-payment","CR"=>"financial/cash-reciept","CT"=>"financial/cheque-transfer","DO"=>"sales/customer-demand-order","JV"=>"financial/journal","LC"=>"lc/lc-information","LE"=>"lc/lc-expense","LJ"=>"lc/journal","LN"=>"Loan/Advance","LP"=>"pay-roll/loan-advance","LS"=>"lc/lc-sale","OP"=>"financial/opening-journal","PL"=>"lc/lc-purchase","PR"=>"purchase/purchase-return","PU"=>"purchase/purchase-voucher","RC"=>"financial/cheque-reciept","SL"=>"sales/sale-voucher","SO"=>"sales/sale-order","SR"=>"sales/sale-return","SS"=>"pay-roll/salary-sheet","ST"=>"inventory/stock-transfer","SG"=>"store-and-spare/goods-receipt-note","OR"=>"store-and-spare/opening-stock","TS"=>"store-and-spare/stock-transfer","DV"=>"financial/discount","BM"=>"memo/book-issue-note","AM"=>"sales/amendment","CM"=>"memo/cash-payment-memo","MO"=>"memo/memo-voucher","DC"=>"sales/delivery-challan");	
		$data['data']=$this->input->post();	
		$list=$this->dataModel->query("SELECT * FROM NOTIFROWS WHERE B_ID='".$this->userData['B_ID']."' AND JO='".$data['data']['jo']."' ORDER BY NO ASC");
		$data['list']=$list;
		$data['JoLinks']=$JoLinks;
		$data['joInWords']=$this->joInWords;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="notif-total")
		{
		$result=$this->dataModel->query("SELECT * FROM NOTIFTOTAL WHERE B_ID='".$this->userData['B_ID']."'");
		echo json_encode($result);
		}
		if($segment=="list")
		{
		$result=$this->dataModel->query("SELECT * FROM NOTIFTOTAL WHERE B_ID='".$this->userData['B_ID']."'");
		$btot=array_sum(array_column($result,'TOTAL'));
		$data=$this->load->view("$segment1/$segment2/$segment",["list"=>$result,"joInWords"=>$this->joInWords],TRUE);
		echo json_encode(array("data"=>$data,"btot"=>$btot));
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$data=$this->dataModel->query("SELECT * FROM NOTIFTOTAL WHERE B_ID='".$this->userData['B_ID']."' ORDER BY TOTAL DESC");
		$this->punchData['data']=$data;
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Pending Voucher";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
}
