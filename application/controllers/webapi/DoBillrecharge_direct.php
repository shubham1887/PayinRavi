<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DoBillrecharge_direct extends CI_Controller 
{
    public function logentry($data)
	{
		
	}
	
	public function index()
	{ 
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
		//http://master.maharshimulti.in/webapi/doBillrecharge?username=&pwd=&mcode=&serviceno=&customer_mobile=&option1=&Amount=
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
				$RefId = 0;
				if(isset($_GET["RefId"]))
				{
					$RefId = $_GET['RefId'];	
				}
				
				
				
			//	billpay($userinfo,$spkey,$company_id,$Amount,$Mobile,$CustomerMobile,$remark,$RefId,$option1,$option2="",$option3="",$done_by = "WEB")
				

				$user_info = $this->db->query("select * from tblusers where username = ? and password = ?",array($username,$pwd));
				if($user_info->row(0)->usertype_name == "APIUSER")
				{
					$company_info = $this->db->query("select * from tblcompany where mcode = ?",array($mcode));

					if($company_info->num_rows() == 1)
					{
						$balance = $this->Ew2->getAgentBalance($user_info->row(0)->user_id);
						if($balance >= $Amount)
						{
							$ref_id = 0;
				            $this->load->model("Mastermoney");
				            //fetchbill($userinfo,$spkey,$company_id,$Mobile,$CustomerMobile,$option1 = "")
				            $response = $this->Mastermoney->fetchbill($user_info,$mcode,$company_info->row(0)->company_id,$serviceno,$customer_mobile,$option1);
							$response = $this->Mastermoney->recharge_transaction2($user_info,$mcode,$company_info->row(0)->company_id,$Amount,$serviceno,$customer_mobile,"BillPayment",$option1,$ref_id,false,$option2,"ANDROID");
				
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