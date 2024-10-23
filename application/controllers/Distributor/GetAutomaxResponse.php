<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetAutomaxResponse extends CI_Controller {
	
	public function get_string_between($string, $start, $end)
	 { 
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}
	public function logentry($data)
	{
		$filename = "automax.txt";
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
public function ExecuteAPI($url)
	{	
		$this->logentry2($url);
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$buffer = curl_exec($ch);	
		curl_close($ch);
		return $buffer;
	}
	public function logentry2($data)
	{
		$filename = "urllog.txt";
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
	public function index() 
	{
		$poststr = serialize($this->input->post());
		$getstr = serialize($this->input->get());
		$response = file_get_contents('php://input');
		$this->logentry($poststr."  |||| ".$getstr."     ".$response);
		
		
		
		//FullCharge:: AIRTEL Number: 9662819823 AMT: 10 Status: Succesful Trans ID: FC663327125 New BAL: Rs.-7.4128 R#10#R 17/11 14:24:30
		//FullCharge:: AIRTEL Number: 8238232303 AMT: 10 Status: Failed Trans ID: Trasaction Fail New BAL: Rs.-17.1128
		if(isset($_GET["refid"]) and isset($_GET["message"]))
		{
			$msg = trim($_GET["message"]);
			$recharge_id = trim($_GET["refid"]);
			
			$this->db->query("update tblrecharge set updated_response = ? where recharge_id = ?",array($recharge_id,$msg));
			 if(preg_match('/Status: Succesful Trans ID:/',$msg) == 1 and preg_match('/New BAL/',$msg) == 1)
			 {
				
				$operator_id = $this->get_string_between($msg,"Trans ID:","New BAL:");
				$rsltrecharge = $this->db->query("select recharge_id,order_id,user_id,recharge_by from tblrecharge where recharge_id = ? and recharge_status = 'Pending'",array($recharge_id));
				if($rsltrecharge->num_rows() == 1)
				{
					
					$status = "Success";
					$this->load->model("Update_methods");
					$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);
						
				}
			 }
			 else  if(preg_match('/Status: Failed Trans ID:/',$msg) == 1 and preg_match('/Trasaction Fail/',$msg) == 1)
			 {
				
				$operator_id = "";
				$rsltrecharge = $this->db->query("select recharge_id,order_id,user_id,recharge_by from tblrecharge where recharge_id = ? and recharge_status = 'Pending'",array($recharge_id));
				if($rsltrecharge->num_rows() == 1)
				{
					
					$status = "Failure";
					$this->load->model("Update_methods");
					$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);
						
				}
			 }
			 else if(preg_match('/second time recharge before/',$msg) == 1 and preg_match('/sts Succesful/',$msg) == 1)
			 {}
			 else if(preg_match('/RECHAGRE FAIL AND REFUND/',$msg) == 1)
			 {}
			 else  if(preg_match('/accepted u are in line Amt./',$msg) == 1 and preg_match('/Trasaction Id:/',$msg) == 1)
			 {}
			 else if(preg_match('/second time recharge before/',$msg) == 1 and preg_match('/sts Failed/',$msg) == 1)
			 {}
			 
		}
						
		
		//0|0|121235740|UE1021915350090|74707|||
		
	}
	
	public function test()
	{
		 $msg = 'FullCharge:: AIRTEL Number: 9662819823 AMT: 10 Status: Succesful Trans ID: FC663327125 New BAL: Rs.-7.4128 R#10#R 17/11 14:24:30';
		  if(preg_match('/second time recharge before/',$msg) == 1 and preg_match('/sts Failed/',$msg) == 1)
			 {}
		
	}
	
}