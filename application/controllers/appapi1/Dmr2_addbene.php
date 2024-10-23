<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr2_addbene extends CI_Controller {
	
	public function index()
	{ 
		//http://demo.masterpay.pro/appapi1/dmr2_addbene?username=&password=&remitter_id=&benificiary_name=&benificiary_mobile=&benificiary_ifsc=&benificiary_account_no=&bank_code=&bank_id=
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
		//$remitter_id,$benificiary_name,$benificiary_mobile,$benificiary_ifsc,$benificiary_account_no
			if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['remitter_id']) && isset($_GET['benificiary_name']) && isset($_GET['benificiary_mobile']) && isset($_GET['benificiary_ifsc']) && isset($_GET['benificiary_account_no']) )
			{
				$username = trim($_GET['username']);
				$pwd =  trim($_GET['password']);
				$remitter_id = trim($_GET['remitter_id']);
				$benificiary_name = trim($_GET['benificiary_name']);
				$benificiary_mobile = trim($_GET['benificiary_mobile']);
				$benificiary_ifsc = trim($_GET['benificiary_ifsc']);
				$benificiary_account_no = trim($_GET['benificiary_account_no']);
				$bank_id = trim($_GET['bank_id']);
				
				
				
				
				
				
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
						if(ctype_digit($remitter_id))
						{
							
								$this->load->model("Paytm");
								echo $this->Paytm->add_benificiary($remitter_id,$benificiary_name,$benificiary_mobile,$benificiary_account_no,$benificiary_ifsc,$bank_id,$userinfo);
							//($remitter_id,$benificiary_name,$benificiary_mobile,$benificiary_ifsc,$benificiary_account_no,$userinfo);
						}
						else
						{
							$resp_arr = array(
								"message"=>"Invalid Remitter Id",
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
