<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class InCreateCustomer extends CI_Controller {
	
	public function index()
	{ 
		//echo "";exit;
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			/*
			https://payin.live/appapi1/InCreateCustomer?username=8080623623&password=623623&sendermobile=8238232303&Name=&Gender=&Dob=&Address=&State=&District=&City=&Nationality=&Email=&Employer=&IDType=&IDNumber=&IncomeSource=&OTPProcessId=&OTP=
				
			*/
				if(
					isset($_GET['username']) && isset($_GET['password']) && isset($_GET['sendermobile']) and
					isset($_GET['Name']) && isset($_GET['Gender']) && isset($_GET['Dob']) and
					isset($_GET['Address']) && isset($_GET['State']) && isset($_GET['District']) and
					isset($_GET['City']) && isset($_GET['Nationality']) && isset($_GET['Email']) and
					isset($_GET['Employer']) && isset($_GET['IDType']) && isset($_GET['IDNumber']) and
					isset( isset($_GET['IncomeSource']) and
					isset($_GET['OTPProcessId']) && isset($_GET['OTP']))


		)
			{
				$username = trim($_GET['username']);
				$pwd =  trim($_GET['password']);
				$sendermobile = trim($_GET['sendermobile']);

				$Name = trim($_GET['Name']);
				$Gender = trim($_GET['Gender']);
				$Dob = trim($_GET['Dob']);
				$Address = trim($_GET['Address']);
				$State = trim($_GET['State']);
				$District = trim($_GET['District']);
				$City = trim($_GET['City']);
				$Nationality = trim($_GET['Nationality']);
				$Email = trim($_GET['Email']);
                 
				$Employer = trim($_GET['Employer']);
				$IDType = trim($_GET['IDType']);
				$IDNumber = trim($_GET['IDNumber']);

				$IDExpiryDate = "";
        		$IDIssuedPlace = "";
				$IncomeSource = trim($_GET['IncomeSource']);

				$OTPProcessId = trim($_GET['OTPProcessId']);
				$OTP = trim($_GET['OTP']);
				$request_by = "ANDROID";

				$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no,mt_access from tblusers where username = ? and password = ?",array($username,$pwd));
				
				if($userinfo->num_rows() == 1)
				{
					$status = $userinfo->row(0)->status;
					$user_id = $userinfo->row(0)->user_id;
					$businessname = $userinfo->row(0)->businessname;
					$username = $userinfo->row(0)->username;
					$mobile_no = $userinfo->row(0)->mobile_no;
					$usertype_name = $userinfo->row(0)->usertype_name;
					$mt_access = $userinfo->row(0)->mt_access;
					
					if($status == '1')
					{
						//if($mt_access != '1')
						if(false)
						{
							
							$resp_arr = array(
								"message"=>"You Dont Have Permission to Use DMR. Please Contact Administrator",
								"status"=>1,
								"statuscode"=>"ERR",
								);
							$json_resp =  json_encode($resp_arr);
							echo $json_resp;exit;
						}
						if(ctype_digit($sendermobile))
						{
							
								$this->load->model("IndoNepalPrabhu");
								$CreateCustomer_response =  $this->IndoNepalPrabhu->createCustomer($Name,$Gender,$Dob,$Address,$Mobile,$State,$District,$City,$Nationality,$Email,$Employer,$IDType,$IDNumber,$IDExpiryDate,$IDIssuedPlace,$IncomeSource,$OTPProcessId,$OTP,$userinfo,$request_by);
							
								echo $CreateCustomer_response;exit;
								
						}
						else
						{
							$resp_arr = array(
								"message"=>"Invalid Mobile Number",
								"status"=>1,
								"statuscode"=>"ERR",
								);
							$json_resp =  json_encode($resp_arr);
							echo $json_resp;exit;
						}
						
					}
					else
					{
						$resp_arr = array(
							"message"=>"Your account is deactivated. contact your Administrator",
							"status"=>1,
							"statuscode"=>"ERR",
						);
						$json_resp =  json_encode($resp_arr);
						echo $json_resp;exit;
					}
				}
				else
				{
					$resp_arr = array(
						"message"=>"Authentication Failed",
						"status"=>1,
						"statuscode"=>"ERR",
					);
					$json_resp =  json_encode($resp_arr);
					echo $json_resp;exit;
				}
				
				
			}
			else
			{
				$resp_arr = array(
							"message"=>"Invalid Input",
							"status"=>1,
							"statuscode"=>"ERR",
						);
				$json_resp =  json_encode($resp_arr);
				echo $json_resp;exit;
			}			
		}
		else
		{
			$resp_arr = array(
							"message"=>"Invalid Input",
							"status"=>1,
							"statuscode"=>"ERR",
						);
			$json_resp =  json_encode($resp_arr);
			echo $json_resp;exit;
		}
		
		
	
	
	}	
}
