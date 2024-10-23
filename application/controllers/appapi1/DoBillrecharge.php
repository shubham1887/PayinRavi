<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DoBillrecharge extends CI_Controller 
{
    public function logentry($data)
	{
		
	}
	
	public function index()
	{ 
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
		$this->logentry(json_encode($this->input->get()));
		$this->logentry(json_encode($this->input->post()));
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd'])   && isset($_GET['mcode']) && isset($_GET['serviceno']) && isset($_GET['customer_mobile']) && isset($_GET['option1']) && isset($_GET['Amount']))
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
			
				$mcode = $_GET['mcode'];
				$serviceno =  $_GET['serviceno'];
				$customer_mobile = $_GET['customer_mobile'];
				$option1 = $_GET['option1'];
				$Amount = $_GET['Amount'];
				$custname = "";
				if(isset($_GET["custname"]))
				{
				    $custname = $_GET["custname"];
				}
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
				
				$particulars_obj = false;
				if(isset($_GET['particulars']))
				{
				    $particulars_obj = json_decode($particulars);
				}
				
			//	$particulars = '{"dueamount":"70.00","duedate":"25-02-2019","customername":"BBPS","billnumber":"010104007685","billdate":"06-02-2019","billperiod":"02","billdetails":[],"customerparamsdetails":[{"Name":"CA Number","Value":"60005410620"}],"additionaldetails":[],"reference_id":169845}';
				

				
			 	
                $host_id = $this->Common_methods->getHostId($this->white->getDomainName());
				$user_info = $this->db->query("select * from tblusers where username = ? and password = ?",array($username,$pwd));
				if($user_info->num_rows() == 1)
				{
					if($user_info->row(0)->usertype_name == "Agent")
					{
					/*	$txn_password = $user_info->row(0)->txn_password;
						if($txn_password != $txnpwd)
						{
							$resp_arr = array(
										"message"=>"Invalid Transaction Password",
										"status"=>1,
										"statuscode"=>"AUTH",
									);
							$json_resp =  json_encode($resp_arr);
							echo $json_resp;exit;
						}
						*/
						

						$company_info = $this->db->query("select * from tblcompany where mcode = ?",array($mcode));
						if($company_info->num_rows() == 1)
						{
							$company_id = $company_info->row(0)->company_id;
							$balance = $this->Ew2->getAgentBalance($user_info->row(0)->user_id);
							if($balance >= $Amount)
							{
								$ref_id = 0;

								$remark = "Bill Payment";

								$done_by = "ANDROID";
							

								$payment_mode = "Normal";
								if(isset($_GET["mode"]))
								{
									$payment_mode = trim($this->input->get("mode"));
								}
								$option3 = "";
								$particulars = "";
					             $this->load->model("BillPayment");
					             $resp = $this->BillPayment->recharge_transaction2($user_info,$company_info->row(0)->company_id,$Amount,$serviceno,$customer_mobile,$remark,$option1,$ref_id,$particulars,$option2,$option3,$done_by,$payment_mode);
					             //recharge_transaction2($userinfo,$company_id,$Amount,$Mobile,$CustomerMobile,$remark,$option1,$ref_id,$particulars,$option2="",$option3="",$done_by = "WEB",$payment_mode = "EXPRESS")
					             echo $resp;exit;
					            
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
				{
					$resp_arr = array(
										"message"=>"Invalid Userid or Password",
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