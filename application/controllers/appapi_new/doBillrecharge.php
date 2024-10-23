<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DoBillrecharge extends CI_Controller 
{
    public function logentry($data)
	{
		
	}
	public function test()
	{
		$resp = '{ddlcity=city, customer_mobile=9313952575, amount=70.00, mcode=NDE, username=500002, option2=Option2, particulars={"dueamount":"70.00","duedate":"25-02-2019","customername":"BBPS","billnumber":"010104007685","billdate":"06-02-2019","billperiod":"02","billdetails":[],"customerparamsdetails":[{"Name":"CA Number","Value":"60005410620"}],"additionaldetails":[],"reference_id":169845}, pwd=0000, option1=Option1, serviceno=60005410620, custname=BBPS}';
		$json_object = json_decode($resp);
		print_r($json_object);exit;
	}
	public function index()
	{ 
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
				

				
			 	
                $host_id = 1;
				$user_info = $this->db->query("select * from tblusers where username = ? and password = ?",array($username,$pwd));
				if($user_info->row(0)->usertype_name == "Agent" or $user_info->row(0)->usertype_name == "Distributor" or $user_info->row(0)->usertype_name == "MasterDealer")
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
						$balance = $this->Ew2->getAgentBalance($user_info->row(0)->user_id);
						if($balance >= $Amount)
						{
							$this->load->model("Instapay");
							$payment_mode = "CASH";
						    $payment_channel = "AGT";
							$this->load->model("Instapay");
							//$response = $this->Instapay->recharge_transaction2($user_info,$mcode,$company_info->row(0)->company_id,$Amount,$serviceno,$customer_mobile,"BillPayment",$option1,$particulars_obj,"","");
							$response = $this->Instapay->recharge_transaction($user_info,$mcode,$company_info->row(0)->company_id,$Amount,$serviceno,$customer_mobile,"BillPayment",$option1,$option2,$ddlcity,$custname);
							//($user_info,$mcode,0,0,$serviceno,$customer_mobile,$option1);
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
		else if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
		   if(isset($_POST['username']) && isset($_POST['pwd'])   && isset($_POST['mcode']) && isset($_POST['serviceno']) && isset($_POST['customer_mobile']) && isset($_POST['option1']) && isset($_POST['Amount']))
			{
				$username = $_POST['username'];
				$pwd =  $_POST['pwd'];
			
				$mcode = $_POST['mcode'];
				$serviceno =  $_POST['serviceno'];
				$customer_mobile = $_POST['customer_mobile'];
				$option1 = $_POST['option1'];
				$Amount = $_POST['Amount'];
				$custname = "";
				if(isset($_POST["custname"]))
				{
				    $custname = $_POST["custname"];
				}
				$option2 = "";
				$ddlcity = "";
				
				if(isset($_POST["option2"]))
				{
					$option2 = $_POST['option2'];	
				}
				if(isset($_POST["ddlcity"]))
				{
					$ddlcity = $_POST['ddlcity'];	
				}
				if(isset($_POST["particulars"]))
				{
					$particulars = $_POST['particulars'];	
				}
				
				
				if($mcode == "TPE")
			 	{
			 	    
			 	    
                   if(isset($_POST['ddlcity']))
                   {
                        $option1 = $_POST['ddlcity'];    
                        if($option1 == "Ahmedabad")
                        {
                            $mcode = "TYE";
                        }
                         if($option1 == "Surat")
                        {
                            $mcode = "TWE";
                        }
                   }	    
			 	}
				
				
				//$particulars = '{"dueamount":"70.00","duedate":"25-02-2019","customername":"BBPS","billnumber":"010104007685","billdate":"06-02-2019","billperiod":"02","billdetails":[],"customerparamsdetails":[{"Name":"CA Number","Value":"60005410620"}],"additionaldetails":[],"reference_id":169845}';
				$particulars_obj = json_decode($particulars);

				
			 	

				$user_info = $this->db->query("select * from tblusers where (username = ? or mobile_no = ?) and password = ?",array($username,$username,$pwd));
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
						$balance = $this->Ew2->getAgentBalance($user_info->row(0)->user_id);
						if($balance >= $Amount)
						{
							$this->load->model("Instapay");
							$payment_mode = "CASH";
						    $payment_channel = "AGT";
							$this->load->model("Instapay");
							$response = $this->Instapay->recharge_transaction2($user_info,$mcode,$company_info->row(0)->company_id,$Amount,$serviceno,$customer_mobile,"BillPayment",$option1,$particulars_obj,"","");
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