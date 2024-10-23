<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recharge extends CI_Controller {
	private function errorresponse($message,$status,$rechargeBy)
    {
    	if($rechargeBy == "GPRS")
    	{
    		$resparray = array(
    		"status"=>$status,
    		"message"=>$message
    		);
    		echo json_encode($resparray);exit;
    	}
    	else
    	{
    		echo $message;exit;
    	}
    }
    public function logentry($data)
	{
		/*$filename = "rec.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');*/
	}
	public function index()
	{ 
		//$this->logentry(json_encode($this->input->get()));
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd'])  && isset($_GET['operatorcode']) && isset($_GET['number']) && isset($_GET['amount']))
			{$username = $_GET['username'];$pwd =  $_GET['pwd'];
			$operatorcode = $_GET['operatorcode'];$number =  $_GET['number'];$amount = $_GET['amount'];
			
			
			}
			else
			{echo 'Paramenter is missing';exit;}		
		}
		else if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_POST['username']) && isset($_POST['pwd'])  && isset($_POST['operatorcode']) && isset($_POST['number']) && isset($_POST['amount']))
			{$username = $_POST['username'];$pwd =  $_POST['pwd'];
			$operatorcode = $_POST['operatorcode'];$number =  $_POST['number'];$amount = $_POST['amount'];
		
			
			}
			else
			{echo 'Paramenter is missing';exit;}		
		}
		else
		{
			echo 'Paramenter is missing';exit;
		}
		
		
	    	
		
			$host_id = 1;
			$user_info = $this->db->query("select * from tblusers where username = ?  and password = ? ",array($username,$pwd));
			if($user_info->num_rows() == 1)
			{
			    
			    //if($user_info->row(0)->usertype_name == "Agent")
			    if(true)
    			{
    				/*$txn_password = $user_info->row(0)->txn_password;
    				if($txn_password != $txnpwd)
    				{
    					echo "Error Code : Invalid Transaction Password";exit;
    				}*/
    				
    				
    				if($operatorcode == "TB")
    				{
    				    $operatorcode = "RB";
    				}
    				else if($operatorcode == "RB")
    				{
    				    $operatorcode = "TB";
    				}
    				
    			
    				
    				$company_id = $operatorcode;
    				if($company_id == false)
    				{
    				    $resparr = array(
    							    "status"=>"Failure",
    							    "message"=>"Error Code : 1001, Contact Service Provider"
    							    );
    				    echo json_encode($resparr);exit;
    				}
    				if($amount < 10)
    				{	
    				    $resparr = array(
    							    "status"=>"Failure",
    							    "message"=>"Minimum amount 10 INR For Recharge"
    							    );
    				    echo json_encode($resparr);exit;
    				}
    				
    				$company_info = $this->db->query("select * from tblcompany where mcode = ?",array($company_id));
    				if($company_info->num_rows() == 0)
    				{
    				    $resparr = array(
    							    "status"=>"Failure",
    							    "message"=>"Invalid Operator Code"
    							    );
    				    echo json_encode($resparr);exit;
    				}
    			
    				
    				$MobileNo =	$number;
    				$Amount = $amount;
    				$company_id = $company_info->row(0)->company_id; 	
    				$service_id = $company_info->row(0)->service_id;
    				
    				    $recharge_type = $this->Common_methods->getRechargeType($service_id);
        				$rechargeBy = "GPRS";
        				$circle_code = "*";
        				$this->load->model("Do_recharge_model");
        				
        				
        				$response = $this->Do_recharge_model->ProcessRecharge($user_info,$circle_code,$company_id,$Amount,$MobileNo,$recharge_type,$service_id,$rechargeBy,"");
        				//echo $response;exit;
        			    $resparr = array(
    							    "status"=>"Success",
    							    "message"=>"Recharge Request Sent Successfully"
    							    );
    				    echo json_encode($resparr);exit;
    				
    				
    			}	
    			else
    			{
    			     $resparr = array(
    							    "status"=>"Failure",
    							    "message"=>"Unauthorised Access"
    							    );
    				echo json_encode($resparr);exit;
    				
    			}    
			}
			else
			{
			    $resparr = array(
    							    "status"=>"Failure",
    							    "message"=>"Invalid UserId or Password"
    							    );
    				echo json_encode($resparr);exit;
			}
			
		
	
	
	}	
	public function getCompanyIdByProvider($operatorcode)
	{
		$rslt = $this->db->query("select company_id from tblcompany where mcode = ?",array($operatorcode));
		if($rslt->num_rows() >= 1)
		{
			return $rslt->row(0)->company_id;
		}
		else
		{
			return false;
		}
	}
	function check_login($username,$password)
	{
		$str_query = "select user_id,status from tblusers where username=? and password=?";
		$result = $this->db->query($str_query,array($username,$password));		
		if($result->num_rows() == 1)
		{
			
			if($result->row(0)->status == '1')
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}		
	}
}