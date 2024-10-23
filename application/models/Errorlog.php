<?php
class Errorlog extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	
	
	public function httplog($url,$buffer,$recharge_id = 0)
	{
		$this->db->query("insert into tblreqresp(add_date,ipaddress,request,response,recharge_id) values(?,?,?,?,?)",array($this->common->getDate(),$this->common->getRealIpAddr(),$url,$buffer,$recharge_id));
		return $this->db->insert_id();
	}
	
	
	public function Entry($data,$recharge_id,$number,$amount,$company_name,$user_info,$path)
	{}
	public function LongcodeEntry($data,$recharge_id,$user_info,$path)
	{}
	public function GPRSEntry($data,$recharge_id,$user_info,$path)
	{}
	public function RechargeCommissionEntry($recType,$rechargeBy,$recharge_id,$allCommission,$rechargeDetail,$RecCommDetails)
	{}
		public function ApiEntry($RoyalResponse,$iSparshResponse,$recharge_id,$number,$amount,$company_name,$user_info,$path)
		{}
	public function logentry($data)
	{
		$filename = "admin_chrsp.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
	}
	
	public function noentry($data)
	{
		$filename = "noresp.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
	}
	
	
	public function airlog($data,$airbookid)
	{}
	
}

?>