<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CheckSenderExist extends CI_Controller 
{
	public function index()
	{ 
		//echo "";exit;
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['sendermobile']) && isset($_GET['account_no'])  && isset($_GET['ifsc']) && isset($_GET['benename']) && isset($_GET['wholeamount'])  && isset($_GET['bank_id']))
			{
				$username = trim($_GET['username']);
				$pwd =  trim($_GET['password']);
				$sendermobile = trim($_GET['sendermobile']);
				$in_account_no = trim($_GET['account_no']);
				$in_ifsc = trim($_GET['ifsc']);
				$in_benename = trim($_GET['benename']);
				$in_wholeamount = trim($_GET['wholeamount']);
				$bank_id = trim($_GET['bank_id']);
				$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no,mt_access from tblusers where mobile_no = ? and password = ?",array($username,$pwd));
				
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
							echo "ACCESS DENIED";exit;
						}
						if(ctype_digit($sendermobile))
						{
							
							    $rsltcommon = $this->db->query("select * from common where param = 'DMRSERVICE'");
							    if($rsltcommon->num_rows() == 1)
							    {
							        $is_service = $rsltcommon->row(0)->value;
							    	if($is_service == "DOWN")
							    	{
							    	    echo "SERVICE DONE";exit;
							    	}
							    }
								$rsltsender = $this->db->query("select Id,DEZIRE,DEZIRE_ID,DEZIRE_PIN from mt3_remitter_registration where mobile = ? and PAYTM = 'yes'",array($sendermobile));
								if($rsltsender->num_rows() == 1)
								{
									$DEZIRE = $rsltsender->row(0)->DEZIRE;
									$DEZIRE_ID = $rsltsender->row(0)->DEZIRE_ID;
									$DEZIRE_PIN = $rsltsender->row(0)->DEZIRE_PIN;
									
									$this->load->model("Paytm");
									
									$limit = $this->Paytm->remitter_details_limit($sendermobile,$userinfo);
									if($limit < $in_wholeamount)
									{
										echo "NO LIMIT";exit;
									}
									$beneficiary_main_array = array();
									$beneresult =  json_decode($this->Paytm->getbenelist($sendermobile,$userinfo,2000,0));
									
									if(isset($beneresult->status))
									{
										$bene_status = trim((string)$beneresult->status);
										if($bene_status == "0")
										{
											$recipient_list = $beneresult->data;
											if(count($recipient_list) > 0)
											{
												foreach($recipient_list as $benelsit)
												{
													$recipient_id = $benelsit->beneficiaryId;
													$recipient_name = $benelsit->accountHolderName;
													$recipient_mobile = "";
													$account = $benelsit->accountNumber;
													$ifsc = $benelsit->ifscCode;
													$bank = $benelsit->bankName;
													
												
												}
												
											}
										}
									}
									//$in_account_no,$in_ifsc
									$getbeneid_exist = $this->db->query("select Id from beneficiaries where account_number = ? and IFSC = ? and sender_mobile = ? and is_paytm = 'yes'",array($in_account_no,$in_ifsc,$sendermobile));
									if($getbeneid_exist->num_rows() == 1)
									{
										echo $getbeneid_exist->row(0)->Id;
									}
									else
									{
										$this->load->model("Paytm");
										$resp_json =  $this->Paytm->add_benificiary($sendermobile,$in_benename,$sendermobile,$in_account_no,$in_ifsc,$bank_id,$userinfo);
										$json_obj = json_decode($resp_json);
										if(isset($json_obj->statuscode))
										{
											$statuscode = trim($json_obj->statuscode);
											if($statuscode == "TXN")
											{
												$bene_id = $json_obj->data;
												echo $bene_id;exit;
											}
										}
										else
										{
											echo "ADD BENEFICIARY NO";exit;
										}
									}
									
									
									
									
									
									
								}
								else
								{
								
									$this->load->model("Paytm");
									$ispaytmexist =  $this->Paytm->is_sender_exist($sendermobile,$userinfo);
									if($ispaytmexist == "yes")
									{
										$this->load->model("Paytm");
										$resp_json =  $this->Paytm->add_benificiary($sendermobile,$in_benename,$sendermobile,$in_account_no,$in_ifsc,$bank_id,$userinfo);
										$json_obj = json_decode($resp_json);
										if(isset($json_obj->statuscode))
										{
											$statuscode = trim($json_obj->statuscode);
											if($statuscode == "TXN")
											{
												$bene_id = $json_obj->data;
												echo $bene_id;exit;
											}
										}
										else
										{
											echo "ADD BENEFICIARY NO";exit;
										}
									}
									else
									{
										echo "PAYTM != yes";exit;
									}
									
								}
						}
						else
						{
							echo "INVALID SENDER MOBILE";exit;
						}
						
					}
					else
					{
						echo "NO";exit;
					}
				}
				else
				{
					echo "NO";exit;
				}
				
				
			}
			else
			{
				echo "NO";exit;
			}			
		}
		else
		{
			echo "NO";exit;
		}
		
		
	
	
	}	
	public function checkexist()
	{
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['sendermobile']) )
			{
				$username = trim($_GET['username']);
				$pwd =  trim($_GET['password']);
				$sendermobile = trim($_GET['sendermobile']);
				$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no,mt_access from tblusers where mobile_no = ? and password = ?",array($username,$pwd));
				
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
							echo "NO";exit;
						}
						if(ctype_digit($sendermobile))
						{
							
							    $rsltcommon = $this->db->query("select * from common where param = 'DMRSERVICE'");
							    if($rsltcommon->num_rows() == 1)
							    {
							        $is_service = $rsltcommon->row(0)->value;
							    	if($is_service == "DOWN")
							    	{
							    	    echo "NO";exit;
							    	}
							    }
								$rsltsender = $this->db->query("select Id from mt3_remitter_registration where mobile = ? and PAYTM = 'yes'",array($sendermobile));
								if($rsltsender->num_rows() == 1)
								{
								
									echo "yes";
								}
								else
								{
									$this->load->model("Paytm");
									echo $this->Paytm->is_sender_exist($sendermobile,$userinfo);
								}
						}
						else
						{
							echo "NO";exit;
						}
						
					}
					else
					{
						echo "NO";exit;
					}
				}
				else
				{
					echo "NO";exit;
				}
				
				
			}
			else
			{
				echo "NO";exit;
			}			
		}
		else
		{
			echo "NO";exit;
		}
	}
	public function getpaytmbalance()
	{
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['key']) )
			{
				$key = trim($_GET['key']);
				if($key == "vffhb1sdsfdawephwlbjhbvd5351ubjh")
				{
					$this->load->model("Paytm");
					echo $this->Paytm->getBalance();exit;
				}
				
				
			}
			else
			{
				echo "";exit;
			}			
		}
		else
		{
			echo "";exit;
		}
	}
	public function getbankitbalance()
	{
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['key']) )
			{
				$key = trim($_GET['key']);
				if($key == "vffhb1sdsfdawephwlbjhbvd5351ubjh")
				{
					$this->load->model("Bankit");
					echo $this->Bankit->getBalance();exit;
				}
				
				
			}
			else
			{
				echo "";exit;
			}			
		}
		else
		{
			echo "";exit;
		}
	}
}
