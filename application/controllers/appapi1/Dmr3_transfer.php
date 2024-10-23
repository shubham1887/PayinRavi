<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr3_transfer extends CI_Controller {
	public function checkduplicate($Amount,$user_id,$RemitterCode,$BeneficiaryCode,$type)
	{
		$add_date = $this->getDate();
		$ip ="asdf";
		$rslt = $this->db->query("insert into mtstopduplication (Amount,user_id,RemitterCode,BeneficiaryCode,add_date,type) values(?,?,?,?,?,?)",array($Amount,$user_id,$RemitterCode,$BeneficiaryCode,$add_date,$type));
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
	    $this->db->db_debug = TRUE;
        error_reporting(E_ALL);
        ini_set("display_errors",1);
        
       // $this->logentry("","",json_encode($this->input->get()));
        
        
		//http://demo.mpayonline.co/appapi1/dmr2_transfer?username=&password=&remittermobile=&remitter_id=&bene_id=&amount=&mode=
		if($_SERVER['REQUEST_METHOD'] == 'GET') 
		{
			if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['remittermobile']) && isset($_GET['bene_id']) && isset($_GET['amount']) && isset($_GET['mode'])  && isset($_GET['bank_id']))
			{
				$username = trim($_GET['username']);
				$pwd =  trim($_GET['password']);
				$remittermobile = trim($_GET['remittermobile']);
				$bene_id = trim($_GET['bene_id']);
				$amount = trim($_GET['amount']);
				$mode = trim($_GET['mode']); 
				$txnpwd = trim($_GET['txnpwd']); 
				$remitter_id = $remittermobile; 
				$bank_id = $_GET['bank_id'];

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
					   
					if($txn_password != $txnpwd)
						{
							$resp_arr = array(
								"message"=>"Invalid Transaction Password",
								"status"=>1,
								"statuscode"=>"ERR",
								);
							$json_resp =  json_encode($resp_arr);
							echo $json_resp;exit;
						}
						if($mt_access != '1')
						{
							$resp_arr = array(
								"message"=>"Service Down. Try After Some Time",
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
						$balance = $this->Ew2->getAgentBalance($user_id);
                        if($balance <= $amount)
                        {
                          $resp_array = array(
                                          "status"=>1,
                                          "statuscode"=>"ERR",
                                          "message"=>"Insufficient Balance",
                                        );
                          echo json_encode($resp_array);exit;
                            
                        }
					
						if(ctype_digit($remittermobile))
						{
							$checkbeneexist = $this->db->query("select * from beneficiaries 
																	where sender_mobile = ? and Id = ? and is_paytm = 'yes'  
																	order by Id desc limit 1 ",array(
																	$remittermobile,$bene_id));
						   // print_r($checkbeneexist ->result());exit;
							
						
							if($checkbeneexist->num_rows() > 0)
							{
							    //echo "herer";exit;
							
								if($this->checkduplicate($amount,$user_id,$remitter_id, $bene_id,"IMPS"))
								{
									$this->load->model("Paytm");
									$resparray = array();
									//$amounts_arr = $this->getamountarray(intval($amount));
									$whole_amount = $amount;
									$data = array(
											'user_id' => $user_id,
											'add_date'  => $this->common->getDate(),
											'ipaddress'  => $this->common->getRealIpAddr(),
											'whole_amount'  => $whole_amount,
											'fraction_json'  =>$amount,
											'remitter_id'  => $remitter_id ,
											'remitter_mobile'  => $remittermobile,
											'remitter_name'  => '',
											'account_no'  => $checkbeneexist->row(0)->account_number,
											'ifsc'  => $checkbeneexist->row(0)->IFSC,
											'bene_name'  => $checkbeneexist->row(0)->bene_name,
											'bene_id'  => $checkbeneexist->row(0)->paytm_bene_id,
											'bank_id'  => $checkbeneexist->row(0)->bank_id,
											'API'  => 'PAYTM',
									);
									$insertresp = $this->db->insert('mt3_uniquetxnid', $data);
									if($insertresp == true)
									{
										$unique_id =  $this->db->insert_id();
										//echo $unique_id;exit;
										
											$beneficiaryid = $bene_id;
											$beneficiary_array = $checkbeneexist;
											$order_id = 0;
                                         
											$resp =  $this->Paytm->transfer_razorpay($remittermobile,$beneficiary_array,$amount,$mode,$userinfo,$order_id,$unique_id);
											      
											   
                                            	
										
										
										//$this->loging("LOGING","",json_encode($resparray),"no set",$username);
										
										$json_resp =  json_decode($resp);
										
										
										
											if(isset($json_resp->message) and isset($json_resp->status) and isset($json_resp->statuscode))
											{
												$message = $json_resp->message;
												$status = $json_resp->status;
												$statuscode = $json_resp->statuscode;
												$new_resp_arr = array(
																	"message"=>$message,
																	"status"=>$status,
																	"UId"=>$unique_id,
																	"statuscode"=>$statuscode,
																	);
												$new_json_resp =  json_encode($new_resp_arr);
												$this->loging("LOGING","",json_encode($resparray),$new_json_resp,$username);
												echo json_encode($new_resp_arr);exit;
											}
											else if(isset($json_resp->message) and isset($json_resp->status))
											{
												$message = $json_resp->message;
												$status = $json_resp->status;
												$statuscode = "ERR";
												if($status == "0")
												{
													$message = "Request Sent Successfully";
													$statuscode = "TXN";	
												}

												$new_resp_arr = array(
																	"message"=>$message,
																	"status"=>$status,
																	"UId"=>$unique_id,
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
										"message"=>"Internal Server Occured1",
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
    	/*
        if($Amount <= 50000)
        {
          $amount = intval($Amount);
          $remainder=$amount % 5000;
          $lastvalue = $remainder;
          $remainint_value = ($amount - $lastvalue);
          $count = ($remainint_value / 5000);
          $amount_array = array();
          if($count > 0)
          {

            for($i=0;$i < $count;$i++)
            {
                array_push($amount_array, 5000);
            }
            array_push($amount_array, $lastvalue);

          }
          else
          {
              array_push($amount_array, $lastvalue);
          }

          return $amount_array;
        }
        else
        {
          return false;
        }
        */


    }
	private function loging($methiod,$request,$response,$json_resp,$username)
	{
		return "";
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
