<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetNoveltyResponse extends CI_Controller {
	
	
    public function logentry($data)
	{
		$filename = "nv.txt";
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
	
errot_reporting(-1);
ini_set('display_errors',1);

		$jsonresq = json_encode($this->input->get());
		$jsonresq_post = json_encode($this->input->post());
		
		
		$json = file_get_contents('php://input');
		$this->logentry($jsonresq."     post : ".$jsonresq_post."    input : ".$json );
	
		
		
		if(isset($_GET["TNO"]) and isset($_GET["STMSG"]) and isset($_GET["ST"]))
		{
    		$recharge_id = $_GET["TNO"];
        	$status = $_GET["STMSG"];
        	$ST = $_GET["ST"];
        	$operator_id = rawurlencode(trim($_GET["OPRTID"]));
        	
        	if($ST == 2)
        	{
        	    $status = "Failure";
        	}
        	if($ST == 5)
        	{
        	    $status = "Failure";
        	}
			
	
			$recharge_info = $this->db->query("SELECT a.* ,c.Name as apigroup_name
	FROM `tblpendingrechares` a 
	left join tblapi b on a.api_id = b.api_id 
	left join tblapiroups c on b.apigroup = c.Id
	where a.recharge_id = ?",array($recharge_id));
//	echo $recharge_info->num_rows();exit;
			if($recharge_info->num_rows() == 1)
			{
				$this->load->model("Errorlog");
				$this->Errorlog->httplog("callback Noelty Group",$jsonresq,$recharge_id);
				$group_name = $recharge_info->row(0)->apigroup_name;
			
				if($group_name == "NOVELTY")
				{
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
		
		/*
		{"ClientRefNo":"3745","Status":"2","StatusMsg":"Failed","TrnID":"10066494","OprID":"0","DP":"0.00","DR":"0.00","BAL":"4569.47"}
		*/
		
		if(isset($_POST["ClientRefNo"]) and isset($_POST["StatusMsg"]) and isset($_POST["Status"]))
		{
    		$recharge_id = $_POST["ClientRefNo"];
        	$status = $_POST["StatusMsg"];
        	$ST = $_POST["Status"];
        	$operator_id = rawurlencode(trim($_POST["OprID"]));
        	if($ST == 1)
        	{
        	    $status = "Success";
        	}
        	if($ST == 2)
        	{
        	    $status = "Failure";
        	}
        	if($ST == 5)
        	{
        	    $status = "Failure";
        	}
			
	
			$recharge_info = $this->db->query("SELECT a.* ,c.Name as apigroup_name
	FROM `tblpendingrechares` a 
	left join tblapi b on a.api_id = b.api_id 
	left join tblapiroups c on b.apigroup = c.Id
	where a.recharge_id = ?",array($recharge_id));
//	echo $recharge_info->num_rows();exit;
			if($recharge_info->num_rows() == 1)
			{
				$this->load->model("Errorlog");
				$this->Errorlog->httplog("callback royalpayapi.com",$jsonresq,$recharge_id);
			
			
				
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
	
}