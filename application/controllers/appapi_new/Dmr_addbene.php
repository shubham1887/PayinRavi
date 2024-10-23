<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr_addbene extends CI_Controller {
	
	public function index()
	{ 
		//http://www.deziremoney.com/appapi/dmr_addbene?username=&password=&remitter_id=&benificiary_name=&benificiary_mobile=&benificiary_ifsc=&benificiary_account_no=
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
		//$remitter_id,$benificiary_name,$benificiary_mobile,$benificiary_ifsc,$benificiary_account_no
			if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['remitter_id']) && isset($_GET['benificiary_name']) && isset($_GET['benificiary_mobile']) && isset($_GET['benificiary_ifsc']) && isset($_GET['benificiary_account_no']))
			{
				$username = trim($_GET['username']);
				$pwd =  trim($_GET['password']);
				$remitter_id = trim($_GET['remitter_id']);
				$benificiary_name = trim($_GET['benificiary_name']);
				$benificiary_mobile = trim($_GET['benificiary_mobile']);
				$benificiary_ifsc = trim($_GET['benificiary_ifsc']);
				$benificiary_account_no = trim($_GET['benificiary_account_no']);
				$userinfo = $this->db->query("select user_id,business_name,username,status,usertype_name,emailid,mobile_no,mt_access from tblusers where (username = ? or mobile_no = ?) and password = ?",array($username,$username,$pwd));
				if($userinfo->num_rows() == 1)
				{
					$status = $userinfo->row(0)->status;
					$user_id = $userinfo->row(0)->user_id;
					$businessname = $userinfo->row(0)->business_name;
					$username = $userinfo->row(0)->username;
					$emailid = $userinfo->row(0)->emailid;
					$mobile_no = $userinfo->row(0)->mobile_no;
					$usertype_name = $userinfo->row(0)->usertype_name;
					$mt_access = $userinfo->row(0)->mt_access;
					if($status == '1')
					{
						if($mt_access != '1')
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
							
								$this->load->model("Instapay");
								echo $this->Instapay->beneficiary_register($remitter_id,$benificiary_name,$benificiary_mobile,$benificiary_ifsc,$benificiary_account_no,$userinfo);
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
		else if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
		//$remitter_id,$benificiary_name,$benificiary_mobile,$benificiary_ifsc,$benificiary_account_no
			if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['remitter_id']) && isset($_POST['benificiary_name']) && isset($_POST['benificiary_mobile']) && isset($_POST['benificiary_ifsc']) && isset($_POST['benificiary_account_no']))
			{
				$username = trim($_POST['username']);
				$pwd =  trim($_POST['password']);
				$remitter_id = trim($_POST['remitter_id']);
				$benificiary_name = trim($_POST['benificiary_name']);
				$benificiary_mobile = trim($_POST['benificiary_mobile']);
				$benificiary_ifsc = trim($_POST['benificiary_ifsc']);
				$benificiary_account_no = trim($_POST['benificiary_account_no']);
				$userinfo = $this->db->query("select user_id,business_name,username,status,usertype_name,emailid,mobile_no,mt_access from tblusers where (username = ? or mobile_no = ?) and password = ?",array($username,$username,$pwd));
				if($userinfo->num_rows() == 1)
				{
					$status = $userinfo->row(0)->status;
					$user_id = $userinfo->row(0)->user_id;
					$businessname = $userinfo->row(0)->business_name;
					$username = $userinfo->row(0)->username;
					$emailid = $userinfo->row(0)->emailid;
					$mobile_no = $userinfo->row(0)->mobile_no;
					$usertype_name = $userinfo->row(0)->usertype_name;
					$mt_access = $userinfo->row(0)->mt_access;
					if($status == '1')
					{
						if($mt_access != '1')
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
							
								$this->load->model("Instapay");
								echo $this->Instapay->beneficiary_register($remitter_id,$benificiary_name,$benificiary_mobile,$benificiary_ifsc,$benificiary_account_no,$userinfo);
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
