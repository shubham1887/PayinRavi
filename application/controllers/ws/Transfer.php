<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transfer extends CI_Controller {
	public function checkduplicate_order_id($order_id,$user_id)
	{
		$rslt = $this->db->query("insert into locking_order_id	(user_id,order_id,add_date,ipaddress) values(?,?,?,?)",
		array($user_id,$order_id,$this->common->getDate(),$this->common->getRealIpAddr()));
		  if($rslt == true)
		  {
			return true;
		  }
		  else
		  {
			return false;
		  }
	}
public function logentry($add_date,$number,$user_id)
{
	$filename = "duplicate_entry.txt";
	if (!file_exists($filename)) 
	{
		file_put_contents($filename, '');
	} 
	$this->load->library("common");

	$this->load->helper('file');
	$sapretor = "------------------------------------------------------------------------------------";
	
write_file($filename." .\n", 'a+');
write_file($filename, $add_date."\n", 'a+');
write_file($filename, "Number : ".$number."\n", 'a+');
write_file($filename, "User Id : ".$user_id."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
}
public function getDate()
{
	putenv("TZ=Asia/Calcutta");
	date_default_timezone_set('Asia/Calcutta');
	$date = date("Y-m-d h");		
	return $date; 
}
	public function index()
	{ 
	  $ip = $this->common->getRealIpAddr();
		if($ip == "148.66.143.67" or $ip == "15.206.98.141" or $ip == "148.72.210.122" or $ip == "139.59.0.202")
		{

		}
		else
		{
			$resp_arr = array(
							"message"=>"Invalid Ip",
							"status"=>1,
							"statuscode"=>"ERR",
							);
						$json_resp =  json_encode($resp_arr);
						echo $json_resp;exit;
		}
		//http://www.masterpay.pro/appapi1/dmr2_transfer?username=&password=&sendermobile=&remitter_id=&bene_id=&amount=&mode=
		if($_SERVER['REQUEST_METHOD'] == 'GET') 
		{
			if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['sendermobile']) && isset($_GET['bene_id']) && isset($_GET['amount']) && isset($_GET['mode']) && isset($_GET['order_id']))
			{
				$username = trim($_GET['username']);
				$pwd =  trim($_GET['password']);
				$sendermobile = trim($_GET['sendermobile']);
				$bene_id = trim($_GET['bene_id']);
				$amount = trim($_GET['amount']);
				$mode = trim($_GET['mode']); 
				$order_id = trim($_GET['order_id']); 
				$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no,mt_access,service from tblusers where username = ?  and password = ?",array($username,$pwd));
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
						else if($amount > 5000)
						{
							$resp_arr = array(
										"message"=>"Invalid Amount",
										"status"=>1,
										"statuscode"=>"ERR",
										);
							$json_resp =  json_encode($resp_arr);
							echo $json_resp;exit;
						}
						else if($amount < 100)
						{
							$resp_arr = array(
										"message"=>"Invalid Amount",
										"status"=>1,
										"statuscode"=>"ERR",
										);
							$json_resp =  json_encode($resp_arr);
							echo $json_resp;exit;
						}
					
						else if(ctype_digit($sendermobile))
						{
							$checkbeneexist = $this->db->query("select * from beneficiaries where sender_mobile = ? and Id = ? and is_paytm = 'yes' order by Id desc limit 1",array($sendermobile,$bene_id));
							if($checkbeneexist->num_rows() > 0)
							{
								$is_bankit = $checkbeneexist->row(0)->is_bankit;
								if($this->checkduplicate_order_id($order_id,$user_id))
								{
								    $this->load->model("Paytm");
									$this->load->model("Bankit");
									$resparray = array();
									
										$beneficiaryid = $checkbeneexist->row(0)->paytm_bene_id;
										$userinfo_balance = $this->db->query("select balance from tblusers where user_id = ? and user_id > 1",array(intval($user_id)));
										if($userinfo_balance->num_rows() == 1)
										{
											if(floatval($userinfo_balance->row(0)->balance) > $amount)
											{
												$beneficiary_array = $checkbeneexist;
												if($mode == "NEFT")
												{
												
													/*
													
													if($is_bankit == 'yes')
													{
														echo  $this->Bankit->transfer($sendermobile,$beneficiary_array,$amount,$mode,$userinfo,$order_id);exit;	
													}
													else
													{
														$senderinfo = $this->db->query("SELECT * FROM `mt3_remitter_registration` where mobile = ?",array($sendermobile));
														if($senderinfo->num_rows() == 1)
														{
															$BANKIT = $senderinfo->row(0)->BANKIT;
															if($BANKIT == "yes")
															{
																$this->Bankit->add_benificiary($sendermobile,$checkbeneexist->row(0)->bene_name,$checkbeneexist->row(0)->benemobile,$checkbeneexist->row(0)->account_number,$checkbeneexist->row(0)->IFSC,$checkbeneexist->row(0)->dezire_bank_id,$userinfo);
															}
															else
															{
																$this->Bankit->remitter_registration_auto($sendermobile,$senderinfo->row(0)->name,$senderinfo->row(0)->lastname,$userinfo);
																$this->Bankit->add_benificiary($sendermobile,$checkbeneexist->row(0)->bene_name,$checkbeneexist->row(0)->benemobile,$checkbeneexist->row(0)->account_number,$checkbeneexist->row(0)->IFSC,$checkbeneexist->row(0)->dezire_bank_id,$userinfo);


															}
														}
														$checkbeneexist = $this->db->query("select * from beneficiaries where sender_mobile = ? and Id = ? and is_paytm = 'yes' order by Id desc limit 1",array($sendermobile,$bene_id));
														$beneficiary_array = $checkbeneexist;
														echo  $this->Bankit->transfer($sendermobile,$beneficiary_array,$amount,$mode,$userinfo,$order_id);exit;

													}

													*/
													
													echo  $this->Paytm->transfer($sendermobile,$beneficiary_array,$amount,$mode,$userinfo,$order_id);exit;
												}
												else
												{
													$paytmlimit = $this->Paytm->remitter_details_limit($sendermobile,$userinfo);
													if($paytmlimit >= $amount)
													//if(true)
													{
														echo  $this->Paytm->transfer($sendermobile,$beneficiary_array,$amount,$mode,$userinfo,$order_id);exit;
													}
													else
													{
														$this->loging("BANKITLOG","step1",$checkbeneexist->row(0)->account_number,$sendermobile,$username);
														if($is_bankit == 'yes')
														{
															$this->loging("BANKITLOG","step2",$checkbeneexist->row(0)->account_number,$sendermobile,$username);
															echo  $this->Bankit->transfer($sendermobile,$beneficiary_array,$amount,$mode,$userinfo,$order_id);exit;
														}
														else
														{
															$this->loging("BANKITLOG","step3",$checkbeneexist->row(0)->account_number,$sendermobile,$username);
															$senderinfo = $this->db->query("SELECT * FROM `mt3_remitter_registration` where mobile = ?",array($sendermobile));
															if($senderinfo->num_rows() == 1)
															{
																$this->loging("BANKITLOG","step4",$checkbeneexist->row(0)->account_number,$sendermobile,$username);
																$BANKIT = $senderinfo->row(0)->BANKIT;
																if($BANKIT == "yes")
																{
																	$this->loging("BANKITLOG","step5",$checkbeneexist->row(0)->account_number,$sendermobile,$username);
																	$this->Bankit->add_benificiary($sendermobile,$checkbeneexist->row(0)->bene_name,$checkbeneexist->row(0)->benemobile,$checkbeneexist->row(0)->account_number,$checkbeneexist->row(0)->IFSC,$checkbeneexist->row(0)->dezire_bank_id,$userinfo);
																}
																else
																{
																	$this->loging("BANKITLOG","step6",$checkbeneexist->row(0)->account_number,$sendermobile,$username);
																	$this->Bankit->remitter_registration_auto($sendermobile,$senderinfo->row(0)->name,$senderinfo->row(0)->lastname,$userinfo);
																	$this->Bankit->add_benificiary($sendermobile,$checkbeneexist->row(0)->bene_name,$checkbeneexist->row(0)->benemobile,$checkbeneexist->row(0)->account_number,$checkbeneexist->row(0)->IFSC,$checkbeneexist->row(0)->dezire_bank_id,$userinfo);


																}
															}
															$this->loging("BANKITLOG","step7",$checkbeneexist->row(0)->account_number,$sendermobile,$username);
															$checkbeneexist = $this->db->query("select * from beneficiaries where sender_mobile = ? and Id = ? and is_paytm = 'yes' order by Id desc limit 1",array($sendermobile,$bene_id));
															$beneficiary_array = $checkbeneexist;
															echo  $this->Bankit->transfer($sendermobile,$beneficiary_array,$amount,$mode,$userinfo,$order_id);exit;

														}
														
													}
													
												}
												
												
												    
											}

										}			
								}
								else
								{
									$resp_arr = array(
										"message"=>"Duplicate Entry.Try After 1 Hour",
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
										"message"=>"Internal Server Occured 1",
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
	
	private function loging($methiod,$request,$response,$json_resp,$username)
	{
		$this->db->query("insert into templog(dmt_id,add_date,ipaddress,request,response,downline_response,type) values(?,?,?,?,?,?,?)",
											array(0,$this->common->getDate(),$this->common->getRealIpAddr(),$request,$response,$json_resp,$methiod));
	}
}
