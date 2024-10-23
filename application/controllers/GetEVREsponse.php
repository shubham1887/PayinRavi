<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetEVREsponse extends CI_Controller {
	
	
public function logentry($data)
	{
		$filename = "ev.txt";
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
		$getdata = serialize($this->input->get());
		$postdata = serialize($this->input->post());	
	//	$this->logentry($getdata." ".$postdata);
		$jsonget = json_encode($this->input->get());
		if(isset($_GET["reqid"]) and isset($_GET["status"])  and isset($_GET["field1"]))
		{
				$recharge_id = $_GET["reqid"];
				$status = $_GET["status"];
				$operator_id = $_GET["field1"];
				$remark = $_GET["remark"];
				$balance = $_GET["balance"];
				$mn = $_GET["mn"];
				if($status == "SUCCESS")
				{
					$status="Success";
				}
				else if($status == "FAILED" or $status == "REFUND")
				{
					$status="Failure";
				}
				else
				{
				$status="Pending";
				}
				$this->load->model("Errorlog");
				$this->load->model("Insert_model");
				$upresp = $recharge_id."#".$status."#".$operator_id."#".$remark."#".$balance."#".$mn;
				$date = $this->common->getMySqlDate();
				//$this->Errorlog->logentry($transaction_id."#".$status."#".$operator_id);
			//	echo $status;exit;
					$rslt = $this->db->query("select recharge_id from tblrecharge where  recharge_id = ? and  Date(tblrecharge.add_date) = ?",array($recharge_id,$date));
					if($rslt->num_rows() == 1)
					{
						$recharge_id = $rslt->row(0)->recharge_id;
						
						$this->load->model("Errorlog");
						$this->Errorlog->httplog("callback evan",$jsonget,$recharge_id);
						 $this->load->model("Update_methods");
						 $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);		
					}
		}
	
	}
	
}