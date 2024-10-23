<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr2_transfer extends CI_Controller {
	public function checkduplicate($Amount,$user_id,$RemitterCode,$BeneficiaryCode,$type)
	{
		$add_date = $this->getDate();
		$ip ="asdf";
		$rslt = $this->db->query("insert into mtstopduplication	 (Amount,user_id,RemitterCode,BeneficiaryCode,add_date,type) values(?,?,?,?,?,?)",array($Amount,$user_id,$RemitterCode,$BeneficiaryCode,$add_date,$type));
		  if($rslt == "" or $rslt == NULL)
		  {
			//$this->logentry($add_date,$number,$user_id);
			return false;
		  }
		  else
		  {
			return true;
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
	   // $this->logentry("",json_encode($this->input->get()),"'");
		//http://www.deziremoney.com/appapi1/dmr_transfer?username=&password=&remittermobile=&remitter_id=&bene_id=&amount=&mode=
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
				//$txnpwd = $_GET['txnpwd'];
				$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no,parentid,mt_access,txn_password from tblusers where username = ?  and password = ?",array($username,$pwd));
				if($userinfo->num_rows() == 1)
				{
					$status = $userinfo->row(0)->status;
					$user_id = $userinfo->row(0)->user_id;
					$businessname = $userinfo->row(0)->businessname;
					$username = $userinfo->row(0)->username;
					$mobile_no = $userinfo->row(0)->mobile_no;
					$usertype_name = $userinfo->row(0)->usertype_name;
					$mt_access = $userinfo->row(0)->mt_access;
					$txn_password = $userinfo->row(0)->txn_password;
					if($status == '1')
					{
						/*if($txn_password != $txnpwd)
						{
							$resp_arr = array(
								"message"=>"Invalid Transaction Password",
								"status"=>1,
								"statuscode"=>"ERR",
								);
							$json_resp =  json_encode($resp_arr);
							echo $json_resp;exit;
						}*/
						/*if($mt_access != '1')
						{
							$resp_arr = array(
								"message"=>"You Dont Have Permission to Use DMR. Please Contact Administrator",
								"status"=>1,
								"statuscode"=>"ERR",
								);
							$json_resp =  json_encode($resp_arr);
							echo $json_resp;exit;
						}*/
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
																	where remitterid = ? and RESP_beneficiary_id = ? and status = 'SUCCESS'  and API = 'SHOOTCASE'
																	order by Id desc limit 1 ",array(
																	$remitter_id,$bene_id));
							
						
							if($checkbeneexist->num_rows() > 0)
							{
							
								//if($this->checkduplicate($amount,$user_id,$remitter_id, $bene_id,"IMPS"))
								if(true)
								{
								    
								//$this->db->db_debug = TRUE;
								//    error_reporting(E_ALL);
								//    ini_set("display_errors",1);
								    
									$this->load->model("Shootcase");
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
											'API'  => 'SHOOTCASE',
									);
									$insertresp = $this->db->insert('mt3_uniquetxnid', $data);
									if($insertresp == true)
									{
										$unique_id =  $this->db->insert_id();
										//echo $unique_id;exit;
										foreach($amounts_arr as $amt)
										{
											$beneficiaryid = $bene_id;
											$amount = $amt;
                                            $balance = $this->Ew2->getAgentBalance($user_id);
                                            
											if(floatval($balance) > $amount)
											{
												$resp =  $this->Shootcase->transfer($remittermobile,$beneficiaryid,$amount,$mode,$userinfo,$unique_id);
												//($remittermobile,$bene_id,$amt,$mode,$userinfo,$unique_id);	

												array_push($resparray,json_decode($resp));        
											}
                                                
                                            	
										}
										
										//$this->loging("LOGING","",json_encode($resparray),"no set",$username);
										
										$json_resp =  json_encode($resparray);
										
										
										if(count($resparray) == 1)
										
										{
											$tx_response = $resparray[0];
											if(isset($tx_response->message) and isset($tx_response->status) and isset($tx_response->statuscode))
											{
												$message = $tx_response->message;
												$status = $tx_response->status;
												$statuscode = $tx_response->statuscode;
												$new_resp_arr = array(
																	"message"=>$message,
																	"status"=>$status,
																	"statuscode"=>$statuscode,
																	);
												$new_json_resp =  json_encode($new_resp_arr);
												$this->loging("LOGING","",json_encode($resparray),$new_json_resp,$username);
												echo json_encode($new_resp_arr);exit;
											}
											else if(isset($tx_response->message) and isset($tx_response->status))
											{
												$message = $tx_response->message;
												$status = $tx_response->status;
												$statuscode = "ERR";
												if($status == "0")
												{
													$message = "Request Sent Successfully";
													$statuscode = "TXN";	
												}

												$new_resp_arr = array(
																	"message"=>$message,
																	"status"=>$status,
																	"statuscode"=>$statuscode,
																	);
												$new_json_resp =  json_encode($new_resp_arr);
												$this->loging("LOGING","",json_encode($resparray),$new_json_resp,$username);
												echo json_encode($new_resp_arr);exit;
											}
										}
										else
										{
											$resp_arr = array(
											"message"=>"Request Sent Successfully",
											"status"=>0,
											"statuscode"=>"TXN",
											);
											$json_resp =  json_encode($resp_arr);
											$this->loging("LOGING","",json_encode($resp_arr),$json_resp,$username);
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
	private function loging($methiod,$request,$response,$json_resp,$username)
	{
		
		//echo $methiod." <> ".$request." <> ".$response." <> ".$json_resp." <> ".$username;exit;
		$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
		"username: ".$username.PHP_EOL.
		"Request: ".$request.PHP_EOL.
        "Response: ".$response.PHP_EOL.
		"Downline Response: ".$json_resp.PHP_EOL.
        "Method: ".$methiod.PHP_EOL.
        "-------------------------".PHP_EOL;
		
		
		//echo $log;exit;
		$filename ='inlogs/'.$methiod.'log_'.date("j.n.Y").'.txt';
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		
//Save string to log, use FILE_APPEND to append.
		file_put_contents('inlogs/'.$methiod.'log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
		
	}
	
}
