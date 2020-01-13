<?php
defined("BASEPATH") OR exit("No direct script access allowed");

Class MY_model extends CI_Model{
	public $userData;	
	function __construct(){
	parent::__construct();	
	$this->userData=$this->session->userdata("user");
	}	
	
	public function getMax($table,$id,$where)
	{
	$this->db->select_max($id);
	if($where!='')
	{
	$this->db->where($where);
	}
	$query=$this->db->get($table);	
	if($query->num_rows()>0)
	{
	$row=$query->row();
	$max=$row->$id;
	$max=$max+1;	
	}
	else{
	$max=1;	
	}
	return $max;	
	}
	public function getData($table,$where,$select,$orderBy){
	if($select!="")
	{
	$this->db->select($select);	
	}
	if($where!="")
	{
	$this->db->where($where);	
	}
	if($orderBy!="")
	{
	$this->db->order_by($orderBy);	
	}			
	$query=$this->db->get($table);
	return $query->result_array();	
	}
	
	public function getParties($atype){
	
	$this->db->select("VCODE AS VCODE,VNAME AS VNAME");
	$this->db->where(array("ATYPE"=>0,""));
	$this->db->order_by("VNAME ASC");			
	$query=$this->db->get("PARTY");
	
/* 	else if($this->userData['U_TYPE']<>2 && $this->userData['UB_ID']==1){
	$this->db->select("ACODE AS VCODE,ANAME AS VNAME");
	$this->db->where(array("ATYPE"=>$atype,""));
	$this->db->order_by("VNAME ASC");			
	$query=$this->db->get("ACCOUNT");
	}
	else if($this->userData['UB_ID']<>1 && $this->userData['U_TYPE']<>2){
	$this->db->select("VCODE,VNAME");		
	$this->db->where(array("ATYPE"=>$atype,"B_ID"=>$this->userData['UB_ID']));
	$this->db->order_by("VNAME ASC");	
	$query=$this->db->get("PARTY");
	}
	else if($this->userData['U_TYPE']==2){
	$this->db->select("VCODE,VNAME");	
	$this->db->where(array("ATYPE"=>$atype,"SID"=>$this->userData['SPCODE']));
	$this->db->order_by("VNAME ASC");	
	$query=$this->db->get("PARTY");
	} */
	return $query->result_array();	
	}
	
	public function getAccounts($type){
	$this->db->select("ACODE,ANAME");
	$this->db->where(array("ATYPE"=>$type));
	$this->db->where(array("Levl"=>4));
	$this->db->order_by("ANAME ASC");			
	$query=$this->db->get("ACCOUNT");
	return $query->result_array();	
	}
	
	
	
	
	
	public function getAccount(){
	$this->db->select("ACODE,ANAME");
	$this->db->where(array("Levl"=>4));
	$this->db->order_by("ANAME ASC");			
	$query=$this->db->get("ACCOUNT");
	return $query->result_array();	
	}
	

	
	public function getSuppliers(){
	$this->db->select("VCODE AS VCODE,VNAME AS VNAME");
	$this->db->where(array("ATYPE"=>1));
	$this->db->order_by("VNAME ASC");			
	$query=$this->db->get("PARTY");
	return $query->result_array();	
	}
	
	public function getdesign(){
	$this->db->select("NAME");
	$this->db->order_by("NAME ASC");			
	$query=$this->db->get("DESIGN");
	return $query->result_array();	
	}
	
	
	public function query($query){		
	$query=$this->db->query($query);
	return $query->result_array();	
	}
	public function getBalance($acode,$branch,$date,$daterange){
	$this->db->select("SUM(DEBIT-CREDIT) AS BAL");	
	$this->db->where(array("ACODE"=>$acode));
	if($branch==true){
	$this->db->where(array("B_ID"=>$this->userData['B_ID']));	
	}
	else if(is_numeric($branch)){
	$this->db->where(array("B_ID"=>$branch));	
	}
	if($date==true){
	$this->db->where(array("VDATE"=>$date));		
	}
	else if($daterange!=false){
	$this->db->where($daterange);			
	}			
	$query=$this->db->get("Gnrllgr");
	$row=$query->result_array();	
	return round($row[0]['BAL']);
	}
	public function updateData($table,$where,$data){
	$this->db->where($where);
	$this->db->update($table, $data);	
	}
	public function deleteData($table,$where){
	$this->db->where($where);				
	$query=$this->db->delete($table);
	return true;	
	}
	public function sendSms($to,$message){
	$username='03218444486';
	$pass='ipi1234';
	$mask='INAYAT PIPE';	
	$url = "http://weblogin.premiumsms.pk/sendsms_url.html?Username=".$username."&Password=".$pass."&From=".urlencode($mask)."&To=".urlencode($to)."&Message=".urlencode($message)."&type=ur";
	
	//setting the curl parameters.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 40);
	curl_setopt($ch, CURLOPT_TIMEOUT , 40);
	//curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	$data = curl_exec($ch);
	
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	if(!curl_errno($ch))
	{
		$info = curl_getinfo($ch);
		
		//echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'];echo '<br>';
		
		//print_r($info);echo '<br>';
	}
	curl_close($ch);	
	}
	public function dateFormat($date){
	$dt=explode("/",$date);
	return $dt[2]."-".$dt[1]."-".$dt[0];
	}
	
	
}
?>