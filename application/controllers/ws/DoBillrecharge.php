<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DoBillrecharge extends CI_Controller {
	private function loging($data)
	{
		
		//echo $methiod." <> ".$request." <> ".$response." <> ".$json_resp." <> ".$username;exit;
	/*	$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
		"data: ".$data.PHP_EOL.
        "-------------------------".PHP_EOL;
		
		
		//echo $log;exit;
		$filename ='inlogs/testlog_'.date("j.n.Y").'.txt';
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		
//Save string to log, use FILE_APPEND to append.
		file_put_contents('inlogs/testlog_'.date("j.n.Y").'.txt', $log, FILE_APPEND);*/
		
	}
	public function index()
	{ 
	    	$input = json_encode($this->input->get());
	    $this->loging($input);
		//http://www.masterpay.pro/appapi1/doBillrecharge?username=&pwd=&txnpwd=123&mcode=&serviceno=&customer_mobile=&Amount=&option1=&ref=&data=datajson
		//print_r($this->input->get());exit;
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd'])  && isset($_GET['txnpwd']) && isset($_GET['mcode']) && isset($_GET['serviceno']) && isset($_GET['customer_mobile']) && isset($_GET['option1']) && isset($_GET['Amount'])  && isset($_GET['data'])  )
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
				$txnpwd = $_GET['txnpwd'];
				$mcode = $_GET['mcode'];
				$serviceno =  $_GET['serviceno'];
				$customer_mobile = $_GET['customer_mobile'];
				$option1 = $_GET['option1'];
				$Amount = $_GET['Amount'];
				
				$data = $_GET['data'];
				//echo $data;exit;
				$json_data = json_decode($data);
				//print_r($json_data);exit;
				$option2 = "";
				$ddlcity = "";
				
				if(isset($_GET["option2"]))
				{
					$option2 = $_GET['option2'];	
				}
				if(isset($_GET["ddlcity"]))
				{
					$ddlcity = $_GET['ddlcity'];	
				}
				
				
			 	

				$user_info = $this->db->query("select * from tblusers where username = ? and password = ?",array($username,$pwd));
				if($user_info->row(0)->usertype_name == "APIUSER")
				{
				   
					$company_info = $this->db->query("select * from tblcompany where mcode = ?",array($mcode));
					if($company_info->num_rows() == 1)
					{
						$balance = $this->Common_methods->getAgentBalance($user_info->row(0)->user_id);
						if($balance >= $Amount)
						{
						
							$this->load->model("Instapay");
							$response = $this->Instapay->recharge_transaction2($user_info,$mcode,$company_info->row(0)->company_id,$Amount,$serviceno,$customer_mobile,"BillPayment",$option1,$json_data,$option2,$ddlcity,"ANDROID");
							echo $response;exit;
						}
						else
						{
							$resp_arr = array(
									"message"=>"InSufficient Balance",
									"status"=>1,
									"statuscode"=>"CONF",
								);
							$json_resp =  json_encode($resp_arr);
							echo $json_resp;exit;
						
						}
						
					}
					else
					{
						$resp_arr = array(
									"message"=>"Operator Configuration Missing",
									"status"=>1,
									"statuscode"=>"CONF",
								);
						$json_resp =  json_encode($resp_arr);
						echo $json_resp;exit;
					}
				}	
				else
				{
					$resp_arr = array(
									"message"=>"Unauthorised Access",
									"status"=>1,
									"statuscode"=>"AUTH",
								);
						$json_resp =  json_encode($resp_arr);
					echo $json_resp;exit;
				}
			
			}
			else
			{echo 'Paramenter is missing';exit;}		
		}
		else
		{
			echo 'Paramenter is missing';exit;
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