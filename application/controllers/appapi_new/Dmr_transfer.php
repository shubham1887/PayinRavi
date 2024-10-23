<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr_transfer extends CI_Controller {
	
	public function index()
	{ 
		//http://www.deziremoney.com/api_users/dmr_transfer?username=&password=&remittermobile=&remitter_id=&bene_id=&amount=&mode=
		if($_SERVER['REQUEST_METHOD'] == 'GET') 
		{
			if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['remittermobile']) && isset($_GET['remitter_id']) && isset($_GET['bene_id']) && isset($_GET['amount']) && isset($_GET['mode']))
			{
				$username = trim($_GET['username']);
				$pwd =  trim($_GET['password']);
				$remittermobile = trim($_GET['remittermobile']);
				$bene_id = trim($_GET['bene_id']);
				$amount = trim($_GET['amount']);
				$mode = trim($_GET['mode']); 
				$remitter_id = trim($_GET['remitter_id']); 
				 $txnpwd = $_GET['txnpwd'];
				$userinfo = $this->db->query("select user_id,business_name,username,status,usertype_name,emailid,mobile_no,parentid,mt_access from tblusers where (username = ? or mobile_no = ?) and password = ?",array($username,$username,$pwd));
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
						if($amount > 25000)
						{
							$resp_arr = array(
										"message"=>"Invalid Amount",
										"status"=>1,
										"statuscode"=>"ERR",
										);
							$json_resp =  json_encode($resp_arr);
							echo $json_resp;exit;
						}
					
						if(ctype_digit($remittermobile))
						{
							$checkbeneexist = $this->db->query("select * from mt3_beneficiary_register_temp 
																	where remitterid = ? and RESP_beneficiary_id = ? and status = 'SUCCESS' 
																	order by Id desc limit 1",array(
																	$remitter_id,$bene_id));
						
							if($checkbeneexist->num_rows() > 0)
							{
								$this->load->model("Instapay");
								$resparray = array();
								
								$amounts_arr = $this->getamountarray(intval($amount));
								
								$whole_amount = intval($amount);
								$data = array(
										'user_id' => $user_id,
										'add_date'  => $this->common->getDate(),
										'ipaddress'  => $this->common->getRealIpAddr(),
										'whole_amount'  => $whole_amount,
										'fraction_json'  =>json_encode($amounts_arr),
										'remitter_id'  => $remitter_id ,
										'remitter_mobile'  => $remittermobile,
										'remitter_name'  => '',
										'account_no'  => $checkbeneexist->row(0)->benificiary_account_no,
										'ifsc'  => $checkbeneexist->row(0)->benificiary_ifsc,
										'bene_name'  => $checkbeneexist->row(0)->benificiary_name,
										'bene_id'  => $checkbeneexist->row(0)->RESP_beneficiary_id,
								);
								$insertresp = $this->db->insert('mt3_uniquetxnId', $data);
								if($insertresp == true)
								{
									$unique_id =  $this->db->insert_id();
									//echo $unique_id;exit;
									foreach($amounts_arr as $amt)
									{
										$beneficiaryid = $bene_id;
										$amount = $amt;
										
										$resp =  $this->Instapay->transfer($remittermobile,$bene_id,$amt,$mode,$userinfo,$unique_id);	
									
										array_push($resparray,json_decode($resp));
									}
									$json_resp =  json_encode($resparray);
									echo $json_resp;exit;
									
								}
								else
								{
									$resp_arr = array(
										"message"=>"Internal Server Occured",
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
										"message"=>"Internal Server Occured",
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
		else if($_SERVER['REQUEST_METHOD'] == 'POST') 
		{
			if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['remittermobile']) && isset($_POST['remitter_id']) && isset($_POST['bene_id']) && isset($_POST['amount']) && isset($_POST['mode']))
			{
				$username = trim($_POST['username']);
				$pwd =  trim($_POST['password']);
				$remittermobile = trim($_POST['remittermobile']);
				$bene_id = trim($_POST['bene_id']);
				$amount = trim($_POST['amount']);
				$mode = trim($_POST['mode']); 
				$remitter_id = trim($_POST['remitter_id']); 
				 $txnpwd = $_POST['txnpwd'];
				$userinfo = $this->db->query("select user_id,business_name,username,status,usertype_name,emailid,mobile_no,parentid,mt_access from tblusers where (username = ? or mobile_no = ?) and password = ?",array($username,$username,$pwd));
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
						if($amount > 25000)
						{
							$resp_arr = array(
										"message"=>"Invalid Amount",
										"status"=>1,
										"statuscode"=>"ERR",
										);
							$json_resp =  json_encode($resp_arr);
							echo $json_resp;exit;
						}
					
						if(ctype_digit($remittermobile))
						{
							$checkbeneexist = $this->db->query("select * from mt3_beneficiary_register_temp 
																	where remitterid = ? and RESP_beneficiary_id = ? and status = 'SUCCESS' 
																	order by Id desc limit 1",array(
																	$remitter_id,$bene_id));
						
							if($checkbeneexist->num_rows() > 0)
							{
								$this->load->model("Instapay");
								$resparray = array();
								
								$amounts_arr = $this->getamountarray(intval($amount));
								
								$whole_amount = intval($amount);
								$data = array(
										'user_id' => $user_id,
										'add_date'  => $this->common->getDate(),
										'ipaddress'  => $this->common->getRealIpAddr(),
										'whole_amount'  => $whole_amount,
										'fraction_json'  =>json_encode($amounts_arr),
										'remitter_id'  => $remitter_id ,
										'remitter_mobile'  => $remittermobile,
										'remitter_name'  => '',
										'account_no'  => $checkbeneexist->row(0)->benificiary_account_no,
										'ifsc'  => $checkbeneexist->row(0)->benificiary_ifsc,
										'bene_name'  => $checkbeneexist->row(0)->benificiary_name,
										'bene_id'  => $checkbeneexist->row(0)->RESP_beneficiary_id,
								);
								$insertresp = $this->db->insert('mt3_uniquetxnId', $data);
								if($insertresp == true)
								{
									$unique_id =  $this->db->insert_id();
									//echo $unique_id;exit;
									foreach($amounts_arr as $amt)
									{
										$beneficiaryid = $bene_id;
										$amount = $amt;
										
										$resp =  $this->Instapay->transfer($remittermobile,$bene_id,$amt,$mode,$userinfo,$unique_id);	
									
										array_push($resparray,json_decode($resp));
									}
									$json_resp =  json_encode($resparray);
									echo $json_resp;exit;
									
								}
								else
								{
									$resp_arr = array(
										"message"=>"Internal Server Occured",
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
										"message"=>"Internal Server Occured",
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
	private function getamountarray($Amount)
	{
		$maxamount = 5000;
		$AmountArray = array();
		$n= $Amount / $maxamount;
		if($n < 1)
		{
			$AmountArray[0] = $Amount;
			return $AmountArray;
		}
		else if($n == 1)
		{
			$AmountArray[0] = $Amount;
			return $AmountArray;
		}
		else if($n < 2)
		{
			$i = 1;
			$sctamt = $n - $i;
			$part1 = $maxamount * $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $part1;
			$AmountArray[1] = $part2;
			return $AmountArray;
			
		}
		else if($n == 2)
		{
			$i = 2;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			return $AmountArray;
		}
		else if($n < 3)
		{
			$i = 2;
			$sctamt = $n - $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $part2;
			return $AmountArray;
			
		}
		else if($n == 3)
		{
			$i = 3;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[3] = $maxamount;
			return $AmountArray;
		}
		else if($n < 4)
		{
			$i = 3;
			$sctamt = $n - $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $part2;
			return $AmountArray;
			
		}
		else if($n == 4)
		{
			$i = 4;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			return $AmountArray;
		}
		else if($n < 5)
		{
			$i = 4;
			$sctamt = $n - $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $part2;
			return $AmountArray;
			
		}
		else if($n == 5)
		{
			$i = 5;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			return $AmountArray;
		}
	}
}
