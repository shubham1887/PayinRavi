<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetXpResponse extends CI_Controller {
	
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
		$filename = "xp.txt";
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
	
        $response = file_get_contents('php://input');
		//$jsonresq = json_encode($this->input->get());
		
		$this->logentry($response);
	
		
		$recharge_id = $this->get_string_between($response, "ClientRefNo=", "&Status=");
		$operator_id = $this->get_string_between($response, "OprID=", "&DP=");
		$Statuscode = $this->get_string_between($response, "Status=", "&StatusMsg=");
		$Statusmsg = $this->get_string_between($response, "&StatusMsg=", "&TrnID=");
		if($Statuscode == "2" or $Statuscode == "3" or $Statuscode == "5")
		{
		    $status = "Failure";
		}
		if($Statuscode == "1")
		{
		    $status = "Success";
		}
		
			$recharge_info = $this->db->query("SELECT a.* 
	FROM `tblpendingrechares` a 
	where a.recharge_id = ?",array($recharge_id));
//	echo $recharge_info->num_rows();exit;
			if($recharge_info->num_rows() == 1)
			{
				$this->load->model("Errorlog");
				$this->Errorlog->httplog("callback XP",$response,$recharge_id);
				
					if($status == "Success")
					{
						$this->load->model("Update_methods");
						$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,"Success");		
					}
					else if($status == "Failure")
					{
						$this->load->model("Update_methods");
						$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,"Failure");		
					}
					
				
			}
			
		
	}
	
}