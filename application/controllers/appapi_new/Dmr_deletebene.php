<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr_deletebene extends CI_Controller {
	
	public function index()
	{ 
		
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['remitter_id']) && isset($_GET['bene_id']))
			{
				$username = trim($_GET['username']);
				$pwd =  trim($_GET['password']);
				$remitter_id = trim($_GET['remitter_id']);
				$bene_id = trim($_GET['bene_id']);
				$userinfo = $this->db->query("select user_id,business_name,username,status,usertype_name,emailid,mobile_no from tblusers where (username = ? or mobile_no = ?) and password = ?",array($username,$username,$pwd));
				if($userinfo->num_rows() == 1)
				{
					$status = $userinfo->row(0)->status;
					$user_id = $userinfo->row(0)->user_id;
					$businessname = $userinfo->row(0)->business_name;
					$username = $userinfo->row(0)->username;
					
					$emailid = $userinfo->row(0)->emailid;
					$mobile_no = $userinfo->row(0)->mobile_no;
					$usertype_name = $userinfo->row(0)->usertype_name;
					
					if($status == '1')
					{
						if(ctype_digit($remitter_id))
						{
							
								$this->load->model("Instapay");
								echo $this->Instapay->beneficiary_remove($remitter_id,$bene_id,$userinfo);exit;
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
			if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['remitter_id']) && isset($_POST['bene_id']))
			{
				$username = trim($_POST['username']);
				$pwd =  trim($_POST['password']);
				$remitter_id = trim($_POST['remitter_id']);
				$bene_id = trim($_POST['bene_id']);
				$userinfo = $this->db->query("select user_id,business_name,username,status,usertype_name,emailid,mobile_no from tblusers where (username = ? or mobile_no = ?) and password = ?",array($username,$username,$pwd));
				if($userinfo->num_rows() == 1)
				{
					$status = $userinfo->row(0)->status;
					$user_id = $userinfo->row(0)->user_id;
					$businessname = $userinfo->row(0)->business_name;
					$username = $userinfo->row(0)->username;
					
					$emailid = $userinfo->row(0)->emailid;
					$mobile_no = $userinfo->row(0)->mobile_no;
					$usertype_name = $userinfo->row(0)->usertype_name;
					
					if($status == '1')
					{
						if(ctype_digit($remitter_id))
						{
							
								$this->load->model("Instapay");
								echo $this->Instapay->beneficiary_remove($remitter_id,$bene_id,$userinfo);exit;
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
