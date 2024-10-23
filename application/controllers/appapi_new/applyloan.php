<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Applyloan extends CI_Controller 
{
    public function logentry($data)
	{
		/*$filename = "andbillpay.txt";
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
*/
	}

	public function index()
	{ 
		$this->logentry(json_encode($this->input->get()));
		$this->logentry(json_encode($this->input->post()));
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
		    //http://www.PAY91.IN/appapi1/applyloan
		    //username=&pwd=&mobile_no=&aadharno=&name=&pincode=&pan_no=
			if(isset($_POST['username']) && isset($_POST['pwd'])   && isset($_POST['mobile_no']) && isset($_POST['aadharno']) && isset($_POST['name']) && isset($_POST['pincode']) && isset($_POST['pan_no']))
			{
				$username = $_POST['username'];
				$pwd =  $_POST['pwd'];
			
				$mobile_no = $_POST['mobile_no'];
				$aadharno =  $_POST['aadharno'];
				$name = $_POST['name'];
				$pincode = $_POST['pincode'];
				$pan_no = $_POST['pan_no'];
				

				$user_info = $this->db->query("select * from tblusers where username = ?  and password = ?",array($username,$pwd));
			//	if($user_info->row(0)->usertype_name == "Agent")
			if(true)
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
					

				
						$balance = $this->Ew2->getAgentBalance($user_info->row(0)->user_id);
						if($balance >= 99)
						{
							$this->load->model("Loan");
        					$response = $this->Loan->loan_enquiry($mobile_no,$aadharno,$pan_no,$name,$pincode,$user_info);
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