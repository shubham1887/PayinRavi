<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SendSms extends MY_Controller 
{
	 public function __construct()
    {        
        parent::__construct();
    } 
	public function get_string_between($string, $start, $end)
	 { 
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}
	public function index()
	{
		$api_rslt = $this->db->query("select Id from api_configuration where api_name = 'ZPULS'");
		$this->load->model("Api_model");
		echo $this->Api_model->getBalance($api_rslt->row(0)->Id);
		exit;
		$this->load->model("Sms");
		$sms = 'Dear Partner, Balance Credited INR 500 New balance is 1000.570 Thanks for using our service.PAYIN';
		$sms = 'Dear Customer, INR 1000 To Ac No: 31360591069 ,Beneficiary Name: Ravikant Laxmanbhai And Your IMPS Ref No. is: 10021321 is Successful.PAYIN';
		$this->common->ExecuteSmsApi("8238232303",$sms);
		echo "END";exit;
	}
	public function logentry($data)
	{

		$filename = "dezsms.txt";
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
}
