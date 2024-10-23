<?php
class Airtel_model extends CI_Model 
{	
	protected $impsurl;
	protected $limiturl;
	protected $txnenqurl;
	protected $at_partnerid;
	protected $at_salt;
	protected $mt3_sender;
	protected $mt3_sender_info;
	protected $airtel_sender;
	protected $beneficiaries;
	protected $airtel_beneficiary;
	protected $mt3_bene_temp;
	protected $api;
	protected $arr_months;
	protected $arr_dates;
	protected $year_from;
	protected $year_to;
	protected $arrHoldMsg; protected $arr_F_Names; protected $arr_L_Names;
	function __construct()
	{
		  parent::__construct();
		  $this->api='AIRTEL';
		  $this->arr_months = array('01','02','03','04','05','06','07','08','09','10','11','12');
		  $this->arr_dates = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27');
		  $this->year_from = 1960; $this->at_salt="RDA2REZCM0UtREI4OS0xMUU5LThBMzQtMkEyQUUyREJDQ0U0";
		  $this->year_to = 2000; $this->at_partnerid = "1000011097";
			$this->arrHoldMsg=array("Insufficient Available Balance ...","Issuing Bank CBS down","Issuing bank CBS or node offline","Access not allowed for MRPC at this time","Transaction not processed.Bank is not available now.","Your transfer was declined by the beneficiary bank. Please try again after some time.");
			date_default_timezone_set("Asia/Kolkata");
			$this->arr_F_Names=array("Jaydip","Kishan","Milan","Maulik","Shivam","Naitik","Jal","Kavan","Pankil","Jailesh","Sujal","Ninad","Tirth","Kuval","Siva","Ambu","Jalesh","Vasuman","Salil","Suneer","Bhumi","Daksha","Kshithi","Bhumika","Urvi","Dharti","Kalika","Nikita","Avani","Madhuja","Manu","Nikitha","Dharani","Kumuda","Vasudha");
			$this->arr_L_Names=array("Acharya","Agarwal","Khatri","Ahuja","Anand","Patel","Bakshi","Banerjee","Basu","Chadha","Chakrabarti","Chawla","Datta","Solanki","Joshi","Vasavda","Sharma","Pithdiya");
	}
	public function requestlog($insert_id,$request,$response,$mobile_no,$account_number,$downline_response)
	{
		$this->db->query("insert into dmt_reqresp(add_date,ipaddress,request,response,sender_mobile,dmt_id) value(?,?,?,?,?,?)",
			array($this->common->getDate(),$this->common->getRealIpAddr(),$request,$response,$mobile_no,$insert_id));
	}
	private function get_our_msg($msg)
	{   
		return "";
	}
	public function getBalance()
	{
					$partnerId = "1000011097";
					$feSessionId ="MA24787306";//$this->generateRandomString();
					$salt ="RDA2REZCM0UtREI4OS0xMUU5LThBMzQtMkEyQUUyREJDQ0U0";
					$customerId = $partnerId;
					//$feSessionId = $this->generateRandomString();
					$hashString = 'EXTP'.$partnerId.'#'.$customerId.'#'.$feSessionId.'#'.$salt;

					//echo "Hash String : ".$hashString."<br><br>";

	    		$hash = hash("sha512", $hashString);

/*
{"channel":"EXTP","partnerId":"1000011097","customerId":"1000011097","feSessionId":"MA24787306","hash":"2A22F91BF216DF70D3117881E1F6BB3F56180A6F7ABB9AADA4653692BE4CAE8D75B504E752554D6AE0DD06609266E5AE99510B91EEEE7491F0B084B98E9D7DD0"}
*/

					$reqarr = array(
				"channel"=>"EXTP",
				"partnerId"=>$partnerId,
				"customerId"=>$customerId,
				"feSessionId"=>$feSessionId,
				"hash"=> $hash
				);

					//echo "Request Body : ".json_encode($reqarr)."<br><br>";
					$url = "https://portal.airtelbank.com/remittance/partner/api/v1/balance/1000011097";
					//echo "Request Url : ".$url."<br><br>";
						$req = json_encode($reqarr);
						$curl = curl_init();
						curl_setopt_array($curl, array(
							CURLOPT_URL => "https://portal.airtelbank.com/remittance/partner/api/v1/balance/1000011097",
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_ENCODING => "",
							CURLOPT_MAXREDIRS => 10,
							CURLOPT_TIMEOUT => 30,
							CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							CURLOPT_CUSTOMREQUEST => "POST",
							CURLOPT_POSTFIELDS => '{"channel":"EXTP","partnerId":"1000011097","customerId":"1000011097","feSessionId":"MA24787306","hash":"2A22F91BF216DF70D3117881E1F6BB3F56180A6F7ABB9AADA4653692BE4CAE8D75B504E752554D6AE0DD06609266E5AE99510B91EEEE7491F0B084B98E9D7DD0"}',
							CURLOPT_HTTPHEADER => array(
								"Accept: */*",
								"Cache-Control: no-cache",
								"Connection: keep-alive",
								"Content-Type: application/json",
							),
						));

						$response = curl_exec($curl);
						$err = curl_error($curl);
						curl_close($curl);


						//echo "Response : ".$response;exit;
						if ($err) {
							echo "<strong>Error:</strong> ".$err;exit;
						}
						$json_resp = json_decode($response);
						if(isset($json_resp->code))
						{
							$code = trim($json_resp->code);
							if($code == "0")
							{
								$currentBal = $json_resp->currentBal;
								
								return $currentBal;
							}
						}
						return 0;

						/*
{"code":"0","messageText":"Success.","errorCode":"000","dcmv":null,"mcmv":"25000","mpt":"5000","dcv":null,"mcv":"557"}
						*/


						$this->loging("getSenderLimit",json_encode($reqarr),$response,$response,$userinfo->row(0)->username,$sender_mobile_no);
						return $response;
		}
	public function getSenderLimit_airtel($sender_mobile_no)
	{
				$partnerId = "1000011097";
				$customerId =$sender_mobile_no;
				$feSessionId =$this->generateRandomString();
				$salt ="RDA2REZCM0UtREI4OS0xMUU5LThBMzQtMkEyQUUyREJDQ0U0";
				$customerId = $sender_mobile_no;
				$feSessionId = $this->generateRandomString();
				$hashString = $partnerId.'#'.$customerId.'#'.$feSessionId.'#'.$salt;
    		$hash = hash("sha512", $hashString);

				$reqarr = array(
				"appVersion" =>"1.0",
				"caf"=>"C2A",
				"channel"=>"EXTP",
				"partnerId"=>$partnerId,
				"customerId"=>$customerId,
				"feSessionId"=>$feSessionId,
				"ver"=>"1.0",
				"hash"=> $hash
				);

					$req = json_encode($reqarr);
					$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_URL => "https://portal.airtelbank.com/remittance/partner/api/v1/sender/limit",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 30,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS => $req,
						CURLOPT_HTTPHEADER => array(
							"Accept: */*",
							"Cache-Control: no-cache",
							"Connection: keep-alive",
							"Content-Type: application/json",
						),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);
					curl_close($curl);


					//echo $response;exit;
					if ($err) {
						echo "<strong>Error:</strong> ".$err;exit;
					}
					$json_resp = json_decode($response);
					if(isset($json_resp->code))
					{
						$code = trim($json_resp->code);
						if($code == "0")
						{
							$mcmv = $json_resp->mcmv;
							$mcv = $json_resp->mcv;
							return $mcmv - $mcv;
						}
					}
					return 0;

					/*
{"code":"0","messageText":"Success.","errorCode":"000","dcmv":null,"mcmv":"25000","mpt":"5000","dcv":null,"mcv":"557"}
					*/


					$this->loging("getSenderLimit",json_encode($reqarr),$response,$response,$userinfo->row(0)->username,$sender_mobile_no);
					return $response;
	}


	public function getSenderLimit_airteltest($sender_mobile_no)
	{
				$partnerId = "1000011097";
				$customerId =$sender_mobile_no;
				$feSessionId =$this->generateRandomString();
				$salt ="RDA2REZCM0UtREI4OS0xMUU5LThBMzQtMkEyQUUyREJDQ0U0";
				$customerId = $sender_mobile_no;
				$feSessionId = $this->generateRandomString();
				$hashString = $partnerId.'#'.$customerId.'#'.$feSessionId.'#'.$salt;
    		$hash = hash("sha512", $hashString);

				$reqarr = array(
				"appVersion" =>"1.0",
				"caf"=>"C2A",
				"channel"=>"EXTP",
				"partnerId"=>$partnerId,
				"customerId"=>$customerId,
				"feSessionId"=>$feSessionId,
				"ver"=>"1.0",
				"hash"=> $hash
				);

					$req = json_encode($reqarr);
					$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_URL => "https://portal.airtelbank.com/remittance/partner/api/v1/sender/limit",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 30,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS => $req,
						CURLOPT_HTTPHEADER => array(
							"Accept: */*",
							"Cache-Control: no-cache",
							"Connection: keep-alive",
							"Content-Type: application/json",
						),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);
					curl_close($curl);


					echo $response;exit;
					if ($err) {
						echo "<strong>Error:</strong> ".$err;exit;
					}
					$json_resp = json_decode($response);
					if(isset($json_resp->code))
					{
						$code = trim($json_resp->code);
						if($code == "0")
						{
							$mcv = $json_resp->mcv;
							return $mcv;
						}
					}
					return 0;

					/*
{"code":"0","messageText":"Success.","errorCode":"000","dcmv":null,"mcmv":"25000","mpt":"5000","dcv":null,"mcv":"557"}
					*/


					$this->loging("getSenderLimit",json_encode($reqarr),$response,$response,$userinfo->row(0)->username,$sender_mobile_no);
					return $response;
	}


	public function update_limit($sender_mobile,$Amount)
	{
		// $rslt = $this->db->query("select * from mehsana_used_limit where sender_mobile = ?",array($sender_mobile));
		// if($rslt->num_rows() == 1)
		// {
		// 	$this->db->query("update mehsana_used_limit set used_limit = used_limit + ? where  sender_mobile = ?",array($Amount,$sender_mobile));
		// }
		// else
		// {
		// 	$this->db->query("insert into mehsana_used_limit(sender_mobile,used_limit) values(?,?)",array($sender_mobile,$Amount));
		// }	
	}
	public function getsenderlimit($sender_mobile)
	{
		$rslt = $this->db->query("select used_limit from mehsana_used_limit where sender_mobile = ?",array($sender_mobile));
		if($rslt->num_rows() == 1)
		{
			return $rslt->row(0)->used_limit;
		}
		else if($rslt->num_rows() > 1)
		{
			return 50000;
		}
		else
		{
			return 0;
		}
	}
	private function generateRandomString($length=0,$isnum=false)
	{
			if($length==0)$length = rand(10,20);
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			if($isnum==true)$characters = '0123456789';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
					$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
	}
	private function get_random_dob()
	{
		$random_year = rand($this->year_from,$this->year_to);
			
		$random_keys_mnths=array_rand($this->arr_months,3);
		$random_month = $this->arr_months[$random_keys_mnths[0]];
		
		$random_key_dates=array_rand($this->arr_dates,3);
		$random_date = $this->arr_dates[$random_key_dates[0]];
		
		return date("d-m-Y",strtotime($random_year.'-'.$random_month.'-'.$random_date));	
	}
	private function get_random_state()
	{
		$__arr_states = (array) $this->getStateList();
		$arr_states = array_keys($__arr_states);
		$random_keys_state=array_rand($arr_states,3);
		$__arr_states=array_values($__arr_states);
		$tmp=(object) $__arr_states[$random_keys_state[0]];
		return array("state_name"=>trim($tmp->STATE),"state_code"=>$tmp->CODE,"state_pincode"=>$tmp->PINCODE);
	}
	private function get_random_fname()
	{
		$a=$this->arr_F_Names;
		$random_keys=array_rand($a,2);
		return trim($a[$random_keys[0]]);
	}
	private function get_random_lname()
	{
		$a=$this->arr_L_Names;
		$random_keys=array_rand($a,2);
		return trim($a[$random_keys[0]]);
	}
	public function getStateList()
    {
  			$allstates='[
					{
						"CODE": 35,
						"STATE": "ANDAMAN AND NICOBAR",
						"PINCODE": 744101
					},
					{
						"CODE": 37,
						"STATE": "ANDHRA PRADESH",
						"PINCODE": 531055
					},
					{
						"CODE": 12,
						"STATE": "ARUNACHAL PRADESH",
						"PINCODE": 791111
					},
					{
						"CODE": 18,
						"STATE": "ASSAM",
						"PINCODE": 787032
					},
					{
						"CODE": 10,
						"STATE": "BIHAR",
						"PINCODE": 803101
					},
					{
						"CODE": 4,
						"STATE": "CHANDIGARH",
						"PINCODE": 133301
					},
					{
						"CODE": 22,
						"STATE": "CHHATTISGARH",
						"PINCODE": 495001
					},
					{
						"CODE": 26,
						"STATE": "DADRA AND NAGAR HAVELI",
						"PINCODE": 396193
					},
					{
						"CODE": 25,
						"STATE": "DAMAN AND DIU",
						"PINCODE": 362520
					},
					{
						"CODE": 7,
						"STATE": "DELHI",
						"PINCODE": 110001
					},
					{
						"CODE": 30,
						"STATE": "GOA",
						"PINCODE": 403110
					},
					{
						"CODE": 24,
						"STATE": "GUJARAT",
						"PINCODE": 382433
					},
					{
						"CODE": 6,
						"STATE": "HARYANA",
						"PINCODE": 244413
					},
					{
						"CODE": 2,
						"STATE": "HIMACHAL PRADESH",
						"PINCODE": 172022
					},
					{
						"CODE": 1,
						"STATE": "JAMMU & KASHMIR",
						"PINCODE": 181121
					},
					{
						"CODE": 20,
						"STATE": "JHARKHAND",
						"PINCODE": 825311
					},
					{
						"CODE": 29,
						"STATE": "KARNATAKA",
						"PINCODE": 560007
					},
					{
						"CODE": 32,
						"STATE": "KERALA",
						"PINCODE": 673633
					},
					{
						"CODE": 31,
						"STATE": "LAKSHDWEEP",
						"PINCODE": 682556
					},
					{
						"CODE": 23,
						"STATE": "MADHYA PRADESH",
						"PINCODE": 474001
					},
					{
						"CODE": 27,
						"STATE": "MAHARASHTRA",
						"PINCODE": 414001
					},
					{
						"CODE": 14,
						"STATE": "MANIPUR",
						"PINCODE": 795145
					},
					{
						"CODE": 17,
						"STATE": "MEGHALAYA",
						"PINCODE": 783123
					},
					{
						"CODE": 15,
						"STATE": "MIZORAM",
						"PINCODE": 796321
					},
					{
						"CODE": 13,
						"STATE": "NAGALAND",
						"PINCODE": 797106
					},
					{
						"CODE": 21,
						"STATE": "ORISSA",
						"PINCODE": 754029
					},
					{
						"CODE": 34,
						"STATE": "PONDICHERRY",
						"PINCODE": 605001
					},
					{
						"CODE": 3,
						"STATE": "PUNJAB",
						"PINCODE": 143502
					},
					{
						"CODE": 8,
						"STATE": "RAJASTHAN",
						"PINCODE": 303329
					},
					{
						"CODE": 11,
						"STATE": "SIKKIM",
						"PINCODE": 737101
					},
					{
						"CODE": 33,
						"STATE": "TAMIL NADU",
						"PINCODE": 600020
					},
					{
						"CODE": 36,
						"STATE": "TELANGANA",
						"PINCODE": 500004
					},
					{
						"CODE": 16,
						"STATE": "TRIPURA",
						"PINCODE": 799001
					},
					{
						"CODE": 9,
						"STATE": "UTTAR PRADESH",
						"PINCODE": 282001
					},
					{
						"CODE": 5,
						"STATE": "UTTRAKHAND",
						"PINCODE": 263652
					},
					{
						"CODE": 19,
						"STATE": "WEST BENGAL",
						"PINCODE": 700020
					}
				]';
				$jsonobj = json_decode($allstates);
				return $jsonobj;  
  }
	public function verify_bene($mobile_no,$acc_no,$ifsc,$bank,$userinfo)
	{
		if($ifsc=="JAKA0000001")$ifsc="JAKA0CIRCUS";
		if($ifsc=="BARBOBUPGBX")$ifsc="BARB0BUPGBX";
		if($ifsc=="BARB0COPARK")$ifsc="BARB0KOPARK";
		//$ifsc=substr_replace($ifsc,"0",5,1);
													
		$reqarr=json_encode(array('mobile_no'=>$mobile_no,'acc_no'=>$acc_no,'ifsc'=>$ifsc));
		$url= "";
		$request_array = "";
		$response = $json_resp = "";
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			   
				
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "APIUSER" or $usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						
						$accval_resultcheck = $this->db->query("SELECT RESP_benename FROM `mt3_account_validate` where account_no = ? and remitter_mobile = ? and user_id = ? and status = 'SUCCESS'  order by Id desc limit 1",
						array($acc_no,$mobile_no,$user_id));
						if($accval_resultcheck->num_rows() == 1)
						{
						    $resp_arr = array(
													"message"=>"Beneficiary Already Validated. ".$accval_resultcheck->row(0)->RESP_benename,
													"status"=>1,
													"statuscode"=>"ERR",
													"upline_msg"=>"0",
													"recipient_name"=>$accval_resultcheck->row(0)->RESP_benename,
													"StatusCode"=>1,
													"Message"=>"Beneficiary Already Validated.  Name : ".$accval_resultcheck->row(0)->RESP_benename,
													"Name"=>$accval_resultcheck->row(0)->RESP_benename
												);
							$json_resp =  json_encode($resp_arr); 

						}
						else
						{
						    $crntBalance = $this->Ew2->getAgentBalance($user_id);

    						if(floatval($crntBalance) < 3)
    						{
    							$resp_arr = array(
    													"message"=>"InSufficient Balance",
    													"status"=>1,
    													"statuscode"=>"ISB",
    													"StatusCode"=>2,
        												"Message"=>$message,
    												);
    							$json_resp =  json_encode($resp_arr);
    							echo $json_resp;exit;
    						}
								
								$sender_name = "";
								$lastname = "";
								$pincode = "";
								$sender_info = $this->db->query("SELECT mobile,name,lastname,pincode FROM mt3_remitter_registration where mobile = ? order by Id desc limit 1",array($mobile_no));
								if($sender_info->num_rows() == 1)
								{
									$sender_name = $sender_info->row(0)->name;
									$sender_name = preg_replace('/[^a-z]/i', '', $sender_name);
									$lastname = $sender_info->row(0)->lastname;
									$lastname = preg_replace('/[^a-z]/i', '', $lastname);
									if(trim($lastname)=="")$lastname="Kumar";
									$pincode = $sender_info->row(0)->pincode;
									if($pincode == "0")
									{
										$pincode = "380001";
									}
								}
								
								$bene_mobile=$mobile_no;
    						$rsltinsert = $this->db->query("insert into mt3_account_validate(user_id,add_date,edit_date,ipaddress,remitter_id,remitter_mobile,account_no,IFSC,status,API) values(?,?,?,?,?,?,?,?,?,?)",array(
    							$user_id,$this->common->getDate(),$this->common->getDate(),$this->common->getRealIpAddr(),$mobile_no,$mobile_no,$acc_no,$ifsc,"PENDING","AIRTEL"
    						));
    						if($rsltinsert == true)
    						{
    							$insert_id = $this->db->insert_id();
    							$transaction_type = "DMR";
    							$sub_txn_type = "Account_Validation";
    							
    							$charge_amount = 3.00;
    							
    							
    							$Description = "Valid.Charge : ".$acc_no;
    							$remark = $mobile_no."  Acc NO :".$acc_no;
    							$debitpayment = $this->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$charge_amount,$Description,$sub_txn_type,$remark,0);
    
    							if($debitpayment == true)
    							{
											$unique_id = $insert_id;
											$ddbit_amount_a = 1;
											$sender_mobile_no=$mobile_no;
											////
											////////////////
											////////// timmer start here
											//////////////////////////////
											$msc_step1 = microtime(true);
											$dt_step1 = $this->common->getDate();
											$timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));
											$amt=$amount=1;
											$partnerId = $this->at_partnerid;
											$customerId =$sender_mobile_no;
											$feSessionId =$this->generateRandomString(10).$unique_id;
											$salt =$this->at_salt;
											$channel ='EXTP';
											$amount =$amt;
											$ifsc =$ifsc;
											$beneAccNo =$acc_no;
											$beneMobNo=$bene_mobile;
											$externalRefNo =substr(hash('sha256',mt_rand().microtime()),0,15);
											$hashString = $channel.'#'.$partnerId.'#'.$customerId.'#'.$amt.'#'.$ifsc.'#'.$beneAccNo.'#'.$salt;
											$hash = hash("sha512", $hashString);
											
											/////////////////////
											$sender_dob=$this->get_random_dob();
											$arr_state_code=$this->get_random_state();
											$sender_state_code=intval($arr_state_code['state_code']);
											if($sender_state_code<=9)
											{
											 $sender_state_code='0'.$sender_state_code;	
											}
											$sender_address = trim($arr_state_code['state_name']);
											$sender_address = str_replace("&","AND",$sender_address);
											$sender_state_pincode=intval($arr_state_code['state_pincode']);
											////////////////////
												$sender_name=$this->get_random_fname();
												$lastname=$this->get_random_lname();
												$pincode=intval($pincode);
												if(strlen($pincode)!=6)
												{
													$pincode = $sender_state_pincode;
												}
											////////////////////
											$reqarr = array(
												"ver" => "2.0",
												"feSessionId" => $feSessionId,
												"channel" => 'EXTP',
												"apiMode" =>'P',
												"partnerId" =>$partnerId,
												"customerId" =>$sender_mobile_no,
												"amount" =>$amt,
												"bankName" =>"",
												"ifsc" =>$ifsc,
												"beneAccNo" =>$beneAccNo,
												"beneMobNo" =>$beneMobNo,
												"externalRefNo" =>$externalRefNo,
												"hash" =>$hash,
												"reference1" =>'ACEa'.$beneMobNo,
												"reference2" =>$sender_mobile_no,
												"custFirstName" =>$sender_name,
												"custLastName" =>$lastname,
												"custPincode" =>$pincode,
												"custAddress" =>$sender_address,
												"custDob" =>$sender_dob,
												"stateCode" =>$sender_state_code
											);
											$req = json_encode($reqarr);
											$curl = curl_init();
											curl_setopt_array($curl, array(
												CURLOPT_URL => "https://portal.airtelbank.com/RetailerPortal/CHAMPimps",
												CURLOPT_RETURNTRANSFER => true,
												CURLOPT_ENCODING => "",
												CURLOPT_MAXREDIRS => 10,
												CURLOPT_TIMEOUT => 30,
												CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
												CURLOPT_CUSTOMREQUEST => "POST",
												CURLOPT_POSTFIELDS => $req,
												CURLOPT_HTTPHEADER => array(
													"Accept: */*",
													"Cache-Control: no-cache",
													"Connection: keep-alive",
													"Content-Type: application/json",
												),
											));
						
											$response = curl_exec($curl);
											$res = json_decode($response);
											$err = curl_error($curl);
											curl_close($curl);
											
											$msc_step2 = microtime(true);
											$dt_step2 = $this->common->getDate();
											////
											////////////////
											////////// timmer stop here
											//////////////////////////////
											
											
												
											$recipient_name = "";$is_success=false;
											$message = trim((string)$res->messageText);
											$statuscode = trim((string)$res->errorCode);
											if(isset($res->code)&&$res->code=='0')
											{		$is_success=true;
													$recipient_name = trim((string)$res->beneName);
													if($recipient_name!="")
													{
														$is_success=true;
														$resp_arr = array(
																						"message"=>$message."  Name : ".$recipient_name,
																						"status"=>0,
																						"statuscode"=>"TXN",
																						"recipient_name"=>$recipient_name,
																						"upline_msg"=>"0",
																						"recipient_name"=>$recipient_name,
																						"StatusCode"=>1,
																						"Message"=>"Beneficiary Already Validated.  Name : ".$recipient_name,
																						"Name"=>$recipient_name,
																					);
																$json_resp =  json_encode($resp_arr);
		
		
																$this->db->query("update beneficiaries set is_verified = 1,verified_name=? where account_number = ? and IFSC=? and sender_mobile = ?",array($recipient_name,$acc_no,$ifsc,$mobile_no));
		
		
		
																$this->db->query("update mt3_account_validate 
																									set RESP_statuscode = ?,
																										RESP_status = ?,
																										RESP_benename = ?,
																										verification_status = ?,
																										status = 'SUCCESS'
																										where 	Id = ?",
																										array
																										(
																											"TXN",
																											$message,
																											$recipient_name,
																												"VERIFIED",
																											$insert_id
																										)
																									);
													}
											}

											if($is_success==false)
											{
													$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$charge_amount,$Description,$sub_txn_type,$remark,0);
													$message="Beneficiary validation failed."; 															
													$resp_arr = array(
																			"message"=>$message,
																			"status"=>1,
																			"statuscode"=>"ERR",
																			"recipient_name"=>$recipient_name,
																			"upline_msg"=>"0",
																			"StatusCode"=>1,
																			"Message"=>"Beneficiary Already Validated.  Name : ".$recipient_name,
																			"Name"=>$recipient_name,
																		);
													$json_resp =  json_encode($resp_arr);
													$this->db->query("update mt3_account_validate 
																							set RESP_statuscode = ?,
																								RESP_status = ?,
																								verification_status = ?,
																								status = 'FAILURE'
																								where 	Id = ?",
																								array
																								(
																									"ERR",
																									$message,
																									"FAILURE",
																									$insert_id
																								)
																							);
											}
    							}
    							
    						}
						}	
					
					}
					else

					{
						$resp_arr = array(
									"message"=>"Your Account Deactivated By Admin",
									"status"=>5,
									"statuscode"=>"UNK",
								);
						$json_resp =  json_encode($resp_arr);
					}
						
				}
				else
				{
					$resp_arr = array(
									"message"=>"Invalid Access",
									"status"=>5,
									"statuscode"=>"UNK",
								);
					$json_resp =  json_encode($resp_arr);
				}
			}
			else
			{
				$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
			$json_resp =  json_encode($resp_arr);
			
		}
		
		return $json_resp;
		
	}



	public function verify_bene_2($mobile_no,$acc_no,$ifsc,$bank,$userinfo,$order_id=0)
	{
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
		if($ifsc=="JAKA0000001")$ifsc="JAKA0CIRCUS";
		if($ifsc=="BARBOBUPGBX")$ifsc="BARB0BUPGBX";
		if($ifsc=="BARB0COPARK")$ifsc="BARB0KOPARK";
		//$ifsc=substr_replace($ifsc,"0",5,1);
													
		$reqarr=json_encode(array('mobile_no'=>$mobile_no,'acc_no'=>$acc_no,'ifsc'=>$ifsc));
		$url= "";
		$request_array = "";
		$response = $json_resp = "";
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			   
				
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "APIUSER" or $usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						
						$accval_resultcheck = $this->db->query("SELECT RESP_benename FROM `mt3_account_validate` where account_no = ? and remitter_mobile = ? and user_id = ? and status = 'SUCCESS'  order by Id desc limit 1",
						array($acc_no,$mobile_no,$user_id));
						if($accval_resultcheck->num_rows() == 1)
						{
						    $resp_arr = array(
													"message"=>"Beneficiary Already Validated. ".$accval_resultcheck->row(0)->RESP_benename,
													"status"=>1,
													"statuscode"=>"ERR",
													"recipient_name"=>$accval_resultcheck->row(0)->RESP_benename,
													"StatusCode"=>2,
        											"Message"=>"Beneficiary Already Validated. ".$accval_resultcheck->row(0)->RESP_benename,
        											"upline_msg"=>"0",
        											"Name"=>$accval_resultcheck->row(0)->RESP_benename,
												);
							$json_resp =  json_encode($resp_arr); 

						}
						else
						{
							$this->load->model("Ew2");
						    $crntBalance = $this->Ew2->getAgentBalance($user_id);

    						if($crntBalance < 3)
    						{
    							$resp_arr = array(
    													"message"=>"Internal Error ISB",
    													"status"=>1,
    													"statuscode"=>"ISB",
    													"StatusCode"=>2,
        												"Message"=>"Internal Error ISB",
    												);
    							$json_resp =  json_encode($resp_arr);
    							echo $json_resp;exit;
    						}
								
								$sender_name = "";
								$lastname = "";
								$pincode = "";
								$sender_info = $this->db->query("SELECT mobile,name,lastname,pincode FROM mt3_remitter_registration where mobile = ? order by Id desc limit 1",array($mobile_no));
								if($sender_info->num_rows() == 1)
								{
									$sender_name = $sender_info->row(0)->name;
									$sender_name = preg_replace('/[^a-z]/i', '', $sender_name);
									$lastname = $sender_info->row(0)->lastname;
									$lastname = preg_replace('/[^a-z]/i', '', $lastname);
									if(trim($lastname)=="")$lastname="Kumar";
									$pincode = $sender_info->row(0)->pincode;
									if($pincode == "0")
									{
										$pincode = "380001";
									}
								}
								
								$bene_mobile=$mobile_no;
    						

    						$amount = 1;
							$mode = "IMPS";
    						$Charge_type = "AMOUNT";
							$charge_value = 2;
							$Charge_Amount = $charge_value; 
							$ccf = 0;
							$cashback = 0;
							$tds = 0;
							$api_name = "AIRTEL";

    						$resultInsert = $this->db->query("
										insert into mt3_transfer(
										order_id,add_date,ipaddress,user_id,
										Charge_type,charge_value,Charge_Amount,
										RemiterMobile,BeneficiaryId,AccountNumber,IFSC,
										Amount,Status,mode,API,
										ccf,cashback,tds)
										values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
										",array(
										$order_id,$this->common->getDate(),$this->common->getRealIpAddr(),$user_id,
										$Charge_type,$charge_value,$Charge_Amount,
										$mobile_no,0,$acc_no,$ifsc,
										$amount,"PENDING",$mode,$api_name,
										$ccf,$cashback,$tds
										));



    						if($resultInsert == true)
    						{
    							$insert_id = $this->db->insert_id();
    							$transaction_type = "DMR";
    							$sub_txn_type = "REMITTANCE";
    							
    							$Charge_Amount = 2.00;
    							$dr_amount = $amount;
    							
    							$Description = "Valid.Charge : ".$acc_no;
    							$remark = $mobile_no."  Acc NO :".$acc_no;
    							$debitpayment = $this->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount);
    							//($user_id,$insert_id,$transaction_type,$charge_amount,$Description,$sub_txn_type,$remark,0);
    
    							if($debitpayment == true)
    							{
									$unique_id = $insert_id;
									$ddbit_amount_a = 1;
									$sender_mobile_no=$mobile_no;
									////
									////////////////
									////////// timmer start here
									//////////////////////////////
									$msc_step1 = microtime(true);
									$dt_step1 = $this->common->getDate();
									$timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));
									$amt=$amount=1;
									$partnerId = $this->at_partnerid;
									$customerId =$sender_mobile_no;
									$feSessionId =$this->generateRandomString(10).$unique_id;
									$salt =$this->at_salt;
									$channel ='EXTP';
									$amount =$amt;
									$ifsc =$ifsc;
									$beneAccNo =$acc_no;
									$beneMobNo=$bene_mobile;
									$externalRefNo =substr(hash('sha256',mt_rand().microtime()),0,15);
									$hashString = $channel.'#'.$partnerId.'#'.$customerId.'#'.$amt.'#'.$ifsc.'#'.$beneAccNo.'#'.$salt;
									$hash = hash("sha512", $hashString);
									
									/////////////////////
									$sender_dob=$this->get_random_dob();
									$arr_state_code=$this->get_random_state();
									$sender_state_code=intval($arr_state_code['state_code']);
									if($sender_state_code<=9)
									{
									 $sender_state_code='0'.$sender_state_code;	
									}
									$sender_address = trim($arr_state_code['state_name']);
									$sender_address = str_replace("&","AND",$sender_address);
									$sender_state_pincode=intval($arr_state_code['state_pincode']);
								////////////////////
									$sender_name=$this->get_random_fname();
									$lastname=$this->get_random_lname();
									$pincode=intval($pincode);
									if(strlen($pincode)!=6)
									{
										$pincode = $sender_state_pincode;
									}
									////////////////////
									$reqarr = array(
										"ver" => "2.0",
										"feSessionId" => $feSessionId,
										"channel" => 'EXTP',
										"apiMode" =>'P',
										"partnerId" =>$partnerId,
										"customerId" =>$sender_mobile_no,
										"amount" =>$amt,
										"bankName" =>"",
										"ifsc" =>$ifsc,
										"beneAccNo" =>$beneAccNo,
										"beneMobNo" =>$beneMobNo,
										"externalRefNo" =>$externalRefNo,
										"hash" =>$hash,
										"reference1" =>'ACEa'.$beneMobNo,
										"reference2" =>$sender_mobile_no,
										"custFirstName" =>$sender_name,
										"custLastName" =>$lastname,
										"custPincode" =>$pincode,
										"custAddress" =>$sender_address,
										"custDob" =>$sender_dob,
										"stateCode" =>$sender_state_code
									);
									$req = json_encode($reqarr);
									$curl = curl_init();
									curl_setopt_array($curl, array(
										CURLOPT_URL => "https://portal.airtelbank.com/RetailerPortal/CHAMPimps",
										CURLOPT_RETURNTRANSFER => true,
										CURLOPT_ENCODING => "",
										CURLOPT_MAXREDIRS => 10,
										CURLOPT_TIMEOUT => 30,
										CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
										CURLOPT_CUSTOMREQUEST => "POST",
										CURLOPT_POSTFIELDS => $req,
										CURLOPT_HTTPHEADER => array(
											"Accept: */*",
											"Cache-Control: no-cache",
											"Connection: keep-alive",
											"Content-Type: application/json",
										),
									));
				
									$response = curl_exec($curl);
									$res = json_decode($response);
									$err = curl_error($curl);
									curl_close($curl);
									
									$this->requestlog($insert_id,$req,$response,$mobile_no,$acc_no,"");

									$msc_step2 = microtime(true);
									$dt_step2 = $this->common->getDate();
									////
									////////////////
									////////// timmer stop here
									//////////////////////////////
									
									
										
									$recipient_name = "";
									$is_success=false;
									$message = trim((string)$res->messageText);
									$statuscode = trim((string)$res->errorCode);
									if(isset($res->code) && $res->code=='0')
									{		
										$is_success=true;
										$recipient_name = trim((string)$res->beneName);
										if($recipient_name!="")
										{
											$is_success=true;


											$data = array(
																	'RESP_statuscode' => "TXN",
																	'RESP_status' => $message,
																	'RESP_ipay_id' => "",
																	'RESP_opr_id' => $recipient_name,
																	'RESP_name' => $recipient_name,
																	'message'=>$message,
																	'Status'=>'SUCCESS',
																	'edit_date'=>$this->common->getDate()
														);

														$this->db->where('Id', $insert_id);
														$this->db->update('mt3_transfer', $data);




											$resp_arr = array(
																"message"=>$message."  Name : ".$recipient_name,
																"status"=>0,
																"statuscode"=>"TXN",
																"recipient_name"=>$recipient_name,
																"StatusCode"=>1,
			        											"Message"=>"Beneficiary Already Validated. ".$recipient_name,
			        											"upline_msg"=>"0",
			        											"Name"=>$recipient_name,
															);
											$json_resp =  json_encode($resp_arr);


											

											$checkbene = $this->db->query("select Id from beneficiaries where sender_mobile = ? and account_number = ? and IFSC = ?",array($mobile_no,$acc_no,$ifsc));
                                            if($checkbene->num_rows() == 1)
                                            {
                                                $this->db->query("update beneficiaries set is_verified = 1,verified_name=? where account_number = ? and IFSC=? and sender_mobile = ?",array($recipient_name,$acc_no,$ifsc,$mobile_no));    
                                            }
                                            else
                                            {
                                                
                                                $rsltinsert = $this->db->query("insert into mt3_account_validate
                                                (user_id,add_date,edit_date,ipaddress,remitter_id,remitter_mobile,account_no,IFSC,status,API,RESP_benename,verification_status,debit_amount,RESP_statuscode) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                                                array($user_id,$this->common->getDate(),$this->common->getDate(),$this->common->getRealIpAddr(),$mobile_no,$mobile_no,$acc_no,$ifsc,"SUCCESS","AIRTEL",$recipient_name,"SUCCESS",3,"TXN"));
                                            }
										}
									}

									if($is_success==false)
									{
											$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount);

											//$message="Beneficiary validation failed."; 															
											$data = array(
																'RESP_statuscode' => "ERR",
																'RESP_status' => $message,
																'Status'=>'FAILURE',
																'edit_date'=>$this->common->getDate()
														);

											$this->db->where('Id', $insert_id);
											$this->db->update('mt3_transfer', $data);
											$resp_arr = array(
																	"message"=>"Internal Error..",
																	"status"=>1,
																	"statuscode"=>"ERR",

																	"StatusCode"=>2,
				        											"Message"=>"Internal Error..",
																);
											$json_resp =  json_encode($resp_arr);
									}
    							}
    							
    						}
						}	
					
					}
					else

					{
						$resp_arr = array(
									"message"=>"Your Account Deactivated By Admin",
									"status"=>5,
									"statuscode"=>"UNK",
									"StatusCode"=>2,
				        			"Message"=>"Your Account Deactivated By Admin",
								);
						$json_resp =  json_encode($resp_arr);
					}
						
				}
				else
				{
					$resp_arr = array(
									"message"=>"Invalid Access",
									"status"=>5,
									"statuscode"=>"UNK",
									"StatusCode"=>2,
				        			"Message"=>"Invalid Access",
								);
					$json_resp =  json_encode($resp_arr);
				}
			}
			else
			{
				$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
									"StatusCode"=>2,
				        			"Message"=>"Userinfo Missing",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
									"StatusCode"=>2,
				        			"Message"=>"Userinfo Missing",
								);
			$json_resp =  json_encode($resp_arr);
			
		}
		
		return $json_resp;
		
	}



	public function transfer($remittermobile,$beneficiary_array,$amount,$mode,$userinfo,$order_id)
	{
		$postfields = '';
		$jwtToken = "";
		$transtype = "IMPSIFSC";
		$apimode = "2";
		
		if($mode == "NEFT" or $mode == "1")
		{
		    $transtype = "NEFT";
		    $mode = "NEFT";
			$apimode = "1";
		}
		$postparam = $remittermobile." <> ".$beneficiary_array->row(0)->paytm_bene_id." <> ".$amount." <> ".$mode;
		$buffer = "No Api Call";
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
				$url = '';
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "APIUSER")
				{
					if($user_status == '1')
					{
						if($amount >= 100)
						{
						    $crntBalance = $this->Ew2->getAgentBalance($user_id);
    						if(floatval($crntBalance) >= floatval($amount) + 30)
    						{
    									$used_limit = 0;
    									$remaining_limit = 25000 - $used_limit;
    									if($remaining_limit >= $amount)
    									{
    										
		    									$benificiary_name = $beneficiary_array->row(0)->bene_name;
		    									$benificiary_mobile = $beneficiary_array->row(0)->benemobile;
		    									$benificiary_ifsc = $beneficiary_array->row(0)->IFSC;
													
													if($benificiary_ifsc=="JAKA0000001")$benificiary_ifsc="JAKA0CIRCUS";
													if($benificiary_ifsc=="BARBOBUPGBX")$benificiary_ifsc="BARB0BUPGBX";
													if($benificiary_ifsc=="BARB0COPARK")$benificiary_ifsc="BARB0KOPARK";
													//$benificiary_ifsc=substr_replace($benificiary_ifsc,"0",5,1);
													
		    									$benificiary_account_no = $beneficiary_array->row(0)->account_number;
												$beneficiaryid = $beneficiary_array->row(0)->paytm_bene_id;
		    									$chargeinfo = $this->getChargeValue($userinfo,$amount);
		    									if($chargeinfo != false)
													{	
															/////////////////////////////////////////////////
															/////// RETAILER CHARGE CALCULATION
															////////////////////////////////////////////////
															$ccf = $chargeinfo->row(0)->ccf;		
															$tds = $chargeinfo->row(0)->tds;
															$ccf_type = $chargeinfo->row(0)->ccf_type;	
															$tds_type = $chargeinfo->row(0)->tds_type;
			
															$Charge_type = $chargeinfo->row(0)->charge_type;
															$charge_value = $chargeinfo->row(0)->charge_value;
		
															if($ccf_type == "PER")
															{
																 $ccf = ((floatval($ccf) * floatval($amount))/ 100); 
															}
															$gst = (($ccf * 18)/118);
															$charge =  $charge_value;
															$cashback = $ccf - ($gst + $charge); 
															if($tds_type == "PER")
															{
																 $tds = ((floatval($tds) * floatval($cashback))/ 100); 
															}
						
															$Charge_Amount = $gst + $tds +  $charge;	
													}
													else
													{
														$Charge_type = "PER";
														$charge_value = 0.40;
														$Charge_Amount = ((floatval($charge_value) * floatval($amount))/ 100); 
														$ccf = 0;
														$cashback = 0;
														$tds = 0;
														$charge = 0;
														$gst  = 0;
													}
		    									
		    									
		    										
		    									
		    										$resultInsert = $this->db->query("
		    											insert into mt3_transfer(
		    											order_id,
														add_date,
														ipaddress,
														user_id,
		    											Charge_type,
		    											charge_value,
		    											Charge_Amount,
		    											RemiterMobile,
		    											BeneficiaryId,
		    											AccountNumber,
		    											IFSC,
		    											Amount,
		    											Status,
		    											mode,
														API,
														ccf,cashback,tds,gst,charge)
		    											values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
		    											",array(
														$order_id,
														$this->common->getDate(),
														$this->common->getRealIpAddr(),
														$user_id,
		    											$Charge_type,$charge_value,$Charge_Amount,
		    											$remittermobile,
		    											$beneficiaryid,
														$benificiary_account_no,
														$benificiary_ifsc,
		    											$amount,
														"PENDING",
														$mode,
														"AIRTEL",
														$ccf,
														$cashback,
														$tds,
														$gst,
														$charge
		    											));
		    										if($resultInsert == true)
		    										{
		    											$insert_id = $this->db->insert_id();
		    											$transaction_type = "DMR";
		    											$dr_amount = $amount;
		    											$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
		    											$sub_txn_type = "REMITTANCE";
		    											$remark = "Money Remittance";
		    											$paymentdebited = $this->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
														
		    											if($paymentdebited == true)
		    											{
		    											    
		    											    
		    												$sender_mobile_no = $remittermobile;
															$partnerId = "1000011097";
															$customerId =$sender_mobile_no;
															//$feSessionId =$this->generateRandomString();

															$datetime=date("Y-m-d H:i:s");
															$feSessionId =$txnReqId= "MPAY".$insert_id;
															$salt ="RDA2REZCM0UtREI4OS0xMUU5LThBMzQtMkEyQUUyREJDQ0U0";
															$channel ='EXTP';
															$amt = $amount;
															$ifsc =$benificiary_ifsc;
															$beneAccNo =$benificiary_account_no;
															$beneMobNo=$sender_mobile_no;
															$externalRefNo =$feSessionId;//substr(hash('sha256',mt_rand().microtime()),0,15);
															$hashString = $channel.'#'.$partnerId.'#'.$customerId.'#'.$amount.'#'.$ifsc.'#'.$beneAccNo.'#'.$salt;
															$hash = hash("sha512", $hashString);
															
															$sender_state_code='';
															$sender_dob=$this->get_random_dob();
															$arr_state_code=$this->get_random_state();
															$sender_state_code=intval($arr_state_code['state_code']);
															if($sender_state_code<=9)
															{
															 $sender_state_code='0'.$sender_state_code;	
															}
															$sender_address = trim($arr_state_code['state_name']);
															$sender_address = str_replace("&","AND",$sender_address);
															$sender_state_pincode=intval($arr_state_code['state_pincode']);


															$sender_name = "";
															$lastname = "";
															$pincode = "";
															$sender_info = $this->db->query("SELECT mobile,name,lastname,pincode FROM mt3_remitter_registration where mobile = ? order by Id desc limit 1",array($sender_mobile_no));
															if($sender_info->num_rows() == 1)
															{
																$sender_name = $sender_info->row(0)->name;
																$sender_name = preg_replace('/[^a-z]/i', '', $sender_name);
																$lastname = $sender_info->row(0)->lastname;
																$lastname = preg_replace('/[^a-z]/i', '', $lastname);
																if(trim($lastname)=="")$lastname="Kumar";
																$pincode = $sender_info->row(0)->pincode;
															}
															////////////////////
																$sender_name=$this->get_random_fname();
																$lastname=$this->get_random_lname();
																$pincode=intval($pincode);
																if(strlen($pincode)!=6)
																{
																	$pincode = $sender_state_pincode;
																}
															////////////////////	
																$reqarr = array(
																	"ver" => "2.0",
																	"feSessionId" => $feSessionId,
																	"channel" => 'EXTP',
																	"apiMode" =>'P',
																	"partnerId" =>$partnerId,
																	"customerId" =>$sender_mobile_no,
																	"amount" =>$amt,
																	"bankName" =>"",
																	"ifsc" =>$benificiary_ifsc,
																	"beneAccNo" =>$beneAccNo,
																	"beneMobNo" =>$sender_mobile_no,
																	"externalRefNo" =>$externalRefNo,
																	"hash" =>$hash,
																	"reference1" =>'ACEa'.$beneMobNo,
																	"reference2" =>$sender_mobile_no,
																	"custFirstName" =>$sender_name,
																	"custLastName" =>$lastname,
																	"custPincode" =>$pincode,
																	"custAddress" =>$sender_address,
																	"custDob" =>$sender_dob,
																	"stateCode" =>$sender_state_code
																);
																$req = json_encode($reqarr);
																$url="https://portal.airtelbank.com/RetailerPortal/CHAMPimps";
																$curl = curl_init();
																curl_setopt_array($curl, array(
																	CURLOPT_URL => "https://portal.airtelbank.com/RetailerPortal/CHAMPimps",
																	CURLOPT_RETURNTRANSFER => true,
																	CURLOPT_ENCODING => "",
																	CURLOPT_MAXREDIRS => 10,
																	CURLOPT_TIMEOUT => 30,
																	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
																	CURLOPT_CUSTOMREQUEST => "POST",
																	CURLOPT_POSTFIELDS => $req,
																	CURLOPT_HTTPHEADER => array(
																		"Accept: */*",
																		"Cache-Control: no-cache",
																		"Connection: keep-alive",
																		"Content-Type: application/json",
																	),
																));

															$response = curl_exec($curl);
															$res = json_decode($response);
															$err = curl_error($curl);
															curl_close($curl);
															
															$this->loging_db("transfer-step-1",$mode." ".$url."?".json_encode($reqarr),$response,$response,$userinfo->row(0)->username,$remittermobile);
															
															$this->db->reset_query();
															$this->db->where("Id",$insert_id);
															$this->db->update("mt3_transfer",array("txn_req_id"=>$txnReqId));
															$this->db->reset_query();
															$addData = array("mt3_transfer_id"=>$insert_id,"paytm_txnReqId"=>$txnReqId,"paytm_response"=>$response,"datetime"=>$datetime);
															$this->db->insert("mt3_transfer_resend",$addData);
															
															$this->loging("airtel_transfer",$mode."https://portal.airtelbank.com/RetailerPortal/CHAMPimps?".json_encode($reqarr)."  ..........",$response,$res,$userinfo->row(0)->username);
															
															$arrMsg=array('brijesh');//$this->arrHoldMsg;
																
															if(isset($res->code))
															{
																	
																	$data = $res;
																	$tid = trim((string)$data->tranId);
																	$bank_ref_num = trim((string)$data->externalRefNo);
																	$_rrn = trim((string)$data->rrn);
																	$recipient_name = trim((string)$data->beneName);
																	$message = trim((string)$data->messageText);
																	$statuscode = trim((string)$data->rrn);
																	$errorCode = trim((string)$res->errorCode);
																	
																	if($res->code=='0')
																	{
																			
																			$this->update_limit($sender_mobile_no,$amount);
																			$data = $res;
																			$tid = trim((string)$data->tranId);
																			$bank_ref_num = trim((string)$data->externalRefNo);
																			$_rrn = trim((string)$data->rrn);
																			$recipient_name = trim((string)$data->beneName);
																			$message = trim((string)$data->messageText);
																			$statuscode = trim((string)$data->rrn);

																			$data = array(
																						'RESP_statuscode' => "TXN",
																						'RESP_status' => $message,
																						'RESP_ipay_id' => $tid,
																						'RESP_opr_id' => $_rrn,
																						'RESP_name' => $recipient_name,
																						'Status'=>'SUCCESS',
																						'message'=>$message,
																						'edit_date'=>$this->common->getDate()
																				);
																				$this->db->where('Id', $insert_id);
																				$this->db->update('mt3_transfer', $data);
																				
																				

																				$resp_arr = array(
																									"message"=>"Transaction Success With Op Id ".$bank_ref_num,
																									"status"=>0,
																									"statuscode"=>"TXN",
																									"data"=>array(
																										"tid"=>$tid,
																										"ref_no"=>$bank_ref_num,
																										"opr_id"=>$_rrn,
																										"name"=>$recipient_name,
																										"balance"=>0,
																										"amount"=>$amount,
		
																									)
																								);
																				$json_resp =  json_encode($resp_arr);
																				
																				if($user_id==2)
																				{
																					$smstext="Sent Rs. {$amt}/- to {$recipient_name} via Masterpay.pro. Service charge 1%, min Rs. 10/-. Ref ID: ".$_rrn;
																					
																					/*if($sender_mobile_no!='')
																					{
																						$date=date("Y-m-d H:i:s");
																						$this->db->query("insert into tempsms_airtel(message,to_mobile,smsapi,date_time) values(?,?,?,?)",array($smstext,$sender_mobile_no,'airtel',$date));
																					}*/
																				}
																				
																	}
																	else if($res->code=='2')
																	{
																			
																			$data = $res;
																			$tid = trim((string)$data->tranId);
																			$bank_ref_num = trim((string)$data->externalRefNo);
																			$_rrn = trim((string)$data->rrn);
																			$recipient_name = trim((string)$data->beneName);
																			$message = trim((string)$data->messageText);
																			$statuscode = trim((string)$data->rrn);

																			$data = array(
																						'RESP_statuscode' => "TUP",
																						'RESP_status' => $message,
																						'RESP_ipay_id' => $tid,
																						'RESP_opr_id' => $_rrn,
																						'RESP_name' => $recipient_name,
																						'Status'=>'PENDING',
																						'message'=>$message,
																						'edit_date'=>$this->common->getDate()
																				);
																				$this->db->where('Id', $insert_id);
																				$this->db->update('mt3_transfer', $data);
																				
																				
																				
																				$resp_arr = array(
																									"message"=>"Transaction Under Pending Process",
																									"status"=>1,
																									"statuscode"=>"TUP",
																									"data"=>array(
																										"tid"=>$tid,
																										"ref_no"=>$bank_ref_num,
																										"opr_id"=>$_rrn,
																										"name"=>$recipient_name,
																										"balance"=>0,
																										"amount"=>$amount,
		
																									)
																								);
																				$json_resp =  json_encode($resp_arr);
																				
																	}
																	else if($res->code=='1')
																	{
																			
																			
																			
																			$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
	
																			$data = $res;
																			$tid = trim((string)$data->tranId);
																			$bank_ref_num = trim((string)$data->externalRefNo);
																			$_rrn = trim((string)$data->rrn);
																			$recipient_name = trim((string)$data->beneName);
																			$message = trim((string)$data->messageText);
																			$statuscode = trim((string)$data->rrn);
																			if($message=="Insufficient Available Balance..")
																				{
																					$message="Please try after sometime.";
																				}
																			$data = array(
																						'RESP_statuscode' => "ERR",
																						'RESP_status' => $message,
																						'RESP_ipay_id' => $tid,
																						'RESP_opr_id' => $_rrn,
																						'RESP_name' => $recipient_name,
																						'Status'=>'FAILURE',
																						'message'=>$message,
																						'edit_date'=>$this->common->getDate()
																				);
																				$this->db->where('Id', $insert_id);
																				$this->db->update('mt3_transfer', $data);
																				
																				
																				
																				$resp_arr = array(
																									"message"=>"Transaction Failed",
																									"status"=>1,
																									"statuscode"=>"ERR",
																									"data"=>array(
																										"tid"=>$tid,
																										"ref_no"=>$bank_ref_num,
																										"opr_id"=>$_rrn,
																										"name"=>$recipient_name,
																										"balance"=>0,
																										"amount"=>$amount,
		
																									)
																								);
																				$json_resp =  json_encode($resp_arr);
																				
																	}
																	else
																	{
	
																			$data = array(
																					'RESP_statuscode' => "",
																					'RESP_status' => "",
																					'Status'=>'PENDING',
																					'edit_date'=>$this->common->getDate()
																			);
		
																			$this->db->where('Id', $insert_id);
																			$this->db->update('mt3_transfer', $data);
																			
																			$message="Transaction Under Pending Process";
																			
																			
																			$resp_arr = array(
																									"message"=>$message,
																									"status"=>0,
																									"statuscode"=>"TUP",
																								);
																			$json_resp =  json_encode($resp_arr);
																				
																	}
																	
															}
															else
															{
																$message="Transaction Pending";
															
																$resp_arr = array(
																					"message"=>$message,
																					"status"=>0,
																					"statuscode"=>"TUP",
																					"data"=>array(
																						"tid"=>$insert_id,
																						"ref_no"=>$insert_id,
																						"opr_id"=>"",
																						"name"=>$benificiary_name,									
																						"balance"=>"",
																						"amount"=>$amount,

																					)
																				);
																$json_resp =  json_encode($resp_arr);
															}

		/*
		{"status":"pending","message":"The amount will be transferred to CHAMPION SOFTWARE TECHNOLOGIES's bank account ","amount":102.0,"customerMobile":"8866628967","response_code":0,"txn_id":"1436095","mw_txn_id":"77297878","extra_info":{"mode":"neft","totalAmount":"112.00","utr":"PYTMH19326125256","beneficiaryName":"CHAMPION SOFTWARE TECHNOLOGIES","commission":"10.00","transfer_type":"neft"},"rrn":"PYTMH19326125256"}
		*/														       
																	
																	
		    											}
		    											else
		    											{
		    											    	$data = array(
		    																			'RESP_statuscode' => "ERR",
		    																			'RESP_status' => "PAYMENT FAILURE",
		    																			'tx_status'=>"1",
		    																			'Status'=>'FAILURE',
		    																	);
		    
		    																	$this->db->where('Id', $insert_id);
		    																	$this->db->update('mt3_transfer', $data);
																					
																		$message="Payment Failure";
																		
																							
																		$resp_arr = array(
																			"message"=>$message,
																			"status"=>1,
																			"statuscode"=>"ERR",
																		);
																		$json_resp =  json_encode($resp_arr);	
		    											}		
		    										}
		    										else
		    										{
															$message="Internal Server Error";
															
		    											$resp_arr = array(
		    												"message"=>$message,
		    												"status"=>1,
		    												"statuscode"=>"ERR",
		    											);
		    											$json_resp =  json_encode($resp_arr);	
		    										}
		    									
		    								
    									}
    									else
    									{
													$message="Sender Limit Over";
													
													$resp_arr = array(
															"message"=>$message,
															"status"=>1,
															"statuscode"=>"ERR",
														);
													$json_resp =  json_encode($resp_arr);
    									}
    						}
    						else
    						{
										$message="InSufficient Balance";
										
										$resp_arr = array(
												"message"=>$message,
												"status"=>1,
												"statuscode"=>"ISB",
											);
										$json_resp =  json_encode($resp_arr);
    						}    
						}
						else
						{
								$message="Minimum Balance Limit is 1000 Rupees";
								
						    $resp_arr = array(
    									"message"=>$message,
    									"status"=>1,
    									"statuscode"=>"ERR",
    								);
    							$json_resp =  json_encode($resp_arr);
						}
						
						
					}
					else
					{
							$message="Your Account Deactivated By Admin";
							
							$resp_arr = array(
										"message"=>$message,
										"status"=>1,
										"statuscode"=>"UNK",
									);
							$json_resp =  json_encode($resp_arr);
					}
						
				}
				else
				{
						$message="Invalid Access";
						$resp_arr = array(
										"message"=>$message,
										"status"=>1,
										"statuscode"=>"UNK",
									);
						$json_resp =  json_encode($resp_arr);
				}
			}
			else
			{
				$message="Userinfo Missing";
				
				$resp_arr = array(
									"message"=>$message,
									"status"=>4,
									"statuscode"=>"UNK",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
				$message="Userinfo Missing";
				
				$resp_arr = array(
									"message"=>$message,
									"status"=>4,
									"statuscode"=>"UNK",
								);
				$json_resp =  json_encode($resp_arr);
			
		}
		//$this->loging_db("transfer",$mode." ".$url."?".json_encode($reqarr),$response,$json_resp,$userinfo->row(0)->username,$remittermobile);
		return $json_resp;
		
	}
	
	public function transfer_status($dmr_id)
	{
	    error_reporting(-1);
	    ini_set('display_errors',1);
	    $this->db->db_debug = TRUE;
	 
		    $resultdmr = $this->db->query("SELECT a.API,a.Id,a.add_date,a.user_id,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited,a.balance,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_opr_id,a.RESP_name,a.txn_req_id,
b.businessname,b.username


FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id

 where a.Id = ?",array($dmr_id));
		
		
		
		if($resultdmr->num_rows() == 1)
		{
			$tId = $dmr_id;
			$sender_mobile_no = $resultdmr->row(0)->RemiterMobile;
			$Status = $resultdmr->row(0)->Status;
			$user_id = $resultdmr->row(0)->user_id;
			$API = $resultdmr->row(0)->API;
			$RESP_status = $resultdmr->row(0)->RESP_status;
			$RESP_name = $resultdmr->row(0)->RESP_name;
			$Amount = $amount = $resultdmr->row(0)->Amount;
			$RESP_opr_id = $resultdmr->row(0)->RESP_opr_id;
			$RESP_ipay_id = $resultdmr->row(0)->RESP_ipay_id;
			$debit_amount = $resultdmr->row(0)->debit_amount;
			$txnReqId = $resultdmr->row(0)->txn_req_id;

			$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));

			if($Status == "PENDING")
			{
				if($txnReqId=='0')
				{
					$txnReqId="MPAY".$dmr_id;
				}
				if($API == "AIRTEL")
				{
					$paymentinfo = $this->db->query("SELECT transaction_type,description,remark,credit_amount,debit_amount FROM tblewallet2 where dmr_id =? and user_id = ?",array($dmr_id,$user_id));
				
				
					if($paymentinfo->num_rows() == 0)
					{
						$data = array(
										'RESP_statuscode' => "ERR",
										'RESP_status' => "Payment Failure",
										'RESP_name' => "",
										'RESP_opening_bal' => "",
										'RESP_amount' => "",
										'RESP_locked_amt' => "",
										'tx_status'=>"Payment Failure",
										"row_lock"=>"LOCKED",
										'Status'=>'FAILURE'
								);
		
						$this->db->where('Id', $dmr_id);
						$this->db->update('mt3_transfer', $data);    
					}
					else
					{
						$benificiary_account_no = $resultdmr->row(0)->AccountNumber;
						$Charge_Amount = $resultdmr->row(0)->Charge_Amount;
						$remittermobile = $resultdmr->row(0)->RemiterMobile;

						$transaction_type = "DMR";
						$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
						$sub_txn_type = "REMITTANCE";
						$remark = "Money Remittance";
						$dr_amount = $Amount;
						if($API == "AIRTEL")
						{
							
							if($Status == "PENDING" )
							{
								$sender_mobile_no = $remittermobile;
								$partnerId = "1000011097";
								$customerId =$sender_mobile_no;
								//$feSessionId =$this->generateRandomString();


								$feSessionId = $txnReqId;
								$externalRefNo = $feSessionId;
								$salt ="RDA2REZCM0UtREI4OS0xMUU5LThBMzQtMkEyQUUyREJDQ0U0";
								$channel ='EXTP';
								$hashString = $channel.'#'.$partnerId.'#'.$externalRefNo.'#'.$salt;
								$hash = hash("sha512", $hashString);
								$reqarr = array(
									"ver" => "1.0",
									"channel" => $channel,
									"partnerId"=> $partnerId,
									"externalRefNo" => $externalRefNo,
									"feSessionId" => $feSessionId,
									"hash"=>  $hash
								);
									$req = json_encode($reqarr);
									$mode="IMPS";
									$url="https://portal.airtelbank.com/RetailerPortal/CHAMPEnquiry";	
									$curl = curl_init();
									curl_setopt_array($curl, array(
										CURLOPT_URL => $url,
										CURLOPT_RETURNTRANSFER => true,
										CURLOPT_ENCODING => "",
										CURLOPT_MAXREDIRS => 10,
										CURLOPT_TIMEOUT => 30,
										CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
										CURLOPT_CUSTOMREQUEST => "POST",
										CURLOPT_POSTFIELDS => $req,
										CURLOPT_HTTPHEADER => array(
											"Accept: */*",
											"Cache-Control: no-cache",
											"Connection: keep-alive",
											"Content-Type: application/json",
											"postman-token: 206aa74a-9d05-1c42-fa4f-cf9ba0243a01"
										),
									));
				
									$response = curl_exec($curl);
									$res = json_decode($response);
									
									//echo $response;exit;
									/*
	{"feSessionId":"MPAY1144","code":"0","messageText":"Success","responseTimestamp":"Mar 31, 2021 12:12:41 PM","externalRefNo":"MPAY1144","errorCode":"0","tranId":"4620529647","beneName":"Mr  KANAI  BHUNIA","rrn":"109011006857","amount":"5000","charges":"50.00"}
									*/

									$err = curl_error($curl);
				
									curl_close($curl);
									$this->requestlog($dmr_id,$req,$response,$remittermobile,$benificiary_account_no,"");
									
									$json_obj = json_decode($response);
									
									if(isset($json_obj->feSessionId) && isset($json_obj->code) && isset($json_obj->messageText) )
									{
										
											
											$feSessionId = trim((string)$json_obj->feSessionId);
											$statuscode = trim((string)$json_obj->code);
											$tranId = trim((string)$json_obj->tranId);
											$messageText = trim((string)$json_obj->messageText);
											$bank_ref_num = trim((string)$json_obj->rrn);
											$_rrn = trim((string)$json_obj->rrn);
											$recipient_name = trim((string)$json_obj->beneName);


											//echo $statuscode."#".$messageText;exit;
											if($statuscode == "0" and $messageText == "Success")
											{
												$dataUpd = array(
														'RESP_statuscode' => "TXN",
														'RESP_status' => $messageText,
														'RESP_ipay_id' => $tranId,
														'RESP_opr_id' => $bank_ref_num,
														'RESP_name' => $recipient_name,
														'Status'=>'SUCCESS',
														'edit_date'=>$this->common->getDate()
												);
												$this->db->where('Id', $dmr_id);
												$this->db->update('mt3_transfer', $dataUpd);
												
												$resp_arr = array(
																	"message"=>$messageText."#".$_rrn."#".$recipient_name
																);
												$json_resp =  json_encode($resp_arr);
												echo $json_resp;exit;
											}
											else if($statuscode == "1" )//Transaction Failure
											{
												
												$this->PAYMENT_CREDIT_ENTRY($user_id,$dmr_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
	
																		
												$data = array(
															'RESP_statuscode' => "ERR",
															'RESP_status' => $messageText,
															'Status'=>'FAILURE',
															'message'=>$messageText,
															'edit_date'=>$this->common->getDate()
													);
													$this->db->where('Id', $dmr_id);
													$this->db->update('mt3_transfer', $data);
												$resp_arr = array(
																	"statuscode"=>"ERR",
																	"status"=>"1",
																	"message"=>"FAILURE : ".$messageText
																);
												$json_resp =  json_encode($resp_arr);
												echo $json_resp;exit;
											}
											
											else if($statuscode == "2")
											{
												
												
												$resp_arr = array(
																	"message"=>"Transaction Under Pending Process",
																	"status"=>0,
																	"statuscode"=>"TUP",
																	"data"=>array(
																		"tid"=>$tranId,
																		"ref_no"=>$bank_ref_num,
																		"opr_id"=>$_rrn,
																		"name"=>$recipient_name,
																		"balance"=>0,
																		"amount"=>$Amount,
																	)
																);
												$json_resp =  json_encode($resp_arr);
												return $json_resp;
											}
											else if($statuscode == "1")
											{
												$resp_arr = array(
																	"message"=>"Transaction Under Pending Process",
																	"status"=>0,
																	"statuscode"=>"TUP"
																);
												$json_resp =  json_encode($resp_arr);
												return $json_resp;
											}
												
									}
							}
							else
							{
								$resp_arr = array(
												"message"=>"Somthing Went Wrong",
												"status"=>1,
												"statuscode"=>"ERR",
											);
								$json_resp =  json_encode($resp_arr);
								return $json_resp;
							}
						}
						else
						{
							return $API;
						}    
					}
				}
			}
			else
			{
				$resp_array = array("message"=>"Transaction Already Updated");
				echo json_encode($resp_array);exit;
			}
		}
		
			
	}	

	private function loging_db($method,$request,$response,$json_resp,$username,$sender_mobile=0,$lat=0,$lng=0)
	{
		$this->db->reset_query();
		$insarray=array("log_ip"=>$_SERVER['REMOTE_ADDR'],"log_user"=>$username,"sender_mobile"=>$sender_mobile,"log_method"=>"airteldmt_".$method,"log_request"=>$request,"log_response"=>$response,"log_downline_response"=>$json_resp,"log_datetime"=>date("Y-m-d H:i:s"),"log_api"=>"AIRTEL");
		$this->db->insert("tbl_logs_dmt_4",$insarray);
	}
	private function loging($methiod,$request,$response,$json_resp,$username)
	{
		
		return "";
		//**echo $methiod." <> ".$request." <> ".$response." <> ".$json_resp." <> ".$username;exit;
		$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
		"username: ".$username.PHP_EOL.
		"Request: ".$request.PHP_EOL.
        "Response: ".$response.PHP_EOL.
		"Downline Response: ".PHP_EOL.
        "Method: ".$methiod.PHP_EOL.
        "-------------------------".PHP_EOL;
		
		
		//echo $log;exit;
		$filename ='inlogs/airtel.txt';
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		
		//Save string to log, use FILE_APPEND to append.
		file_put_contents('inlogs/airtel.txt', $log, FILE_APPEND);
		
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////                                                        ////////////////////////////////
///////////////////////    P A Y M E N T   M E T H O D   S T A R T   H E R E   /////////////////////////////////
//////////////////////                                                        //////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	

	
	public function PAYMENT_DEBIT_ENTRY($user_id,$transaction_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$chargeAmount = 0.00)
	{

		$this->load->library("common");
		$add_date = $this->common->getDate();
		$date = $this->common->getMySqlDate();
		$ip = $this->common->getRealIpAddr();
	    //$this->db->query("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;");
		//$this->db->query("BEGIN;");
		$result_oldbalance = $this->db->query("SELECT balance FROM `tblewallet2` where user_id = ? order by Id desc limit 1",array($user_id));
		if($result_oldbalance->num_rows() > 0)
		{
			$old_balance =  $result_oldbalance->row(0)->balance;
		}
		else 
		{
			
				
        		$result_oldbalance2 = $this->db->query("SELECT balance FROM masterpa_archive.tblewallet2 where user_id = ? order by Id desc limit 1",array($user_id));
        		if($result_oldbalance2->num_rows() > 0)
        		{
        			$old_balance =  $result_oldbalance2->row(0)->balance;
        		}
        		else 
        		{
        			
        			$old_balance =  0;
        			
        		}
			
		}
		//$this->db->query("COMMIT;");
		
		//$old_balance = $this->Ew2->getAgentBalance($user_id);
		if($old_balance < $dr_amount)
		{
		    return false;
		}
		else
		{
		    $current_balance = $old_balance - $dr_amount;
    		$tds = 0.00;
    		$stax = 0.00;
    		if($transaction_type == "DMR")
    		{
    			$str_query = "insert into  tblewallet2(user_id,dmr_id,transaction_type,debit_amount,balance,description,add_date,ipaddress,remark)
    
    			values(?,?,?,?,?,?,?,?,?)";
    			$reslut = $this->db->query($str_query,array($user_id,$transaction_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip,$remark));
    			if($reslut == true)
    			{
    					$ewallet_id = $this->db->insert_id();
    					if($ewallet_id > 1)
    					{
    						if($sub_txn_type == "Account_Validation")
    						{
    									$rslt_updtrec = $this->db->query("update mt3_account_validate set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?),debit_amount = ? where Id = ?",array($current_balance,$dr_amount,$transaction_id));
    									return true;
    						}
    						else if($sub_txn_type == "REMITTANCE")
    						{
    									$current_balance2 = $current_balance - $chargeAmount;
    									$remark = "Transaction Charge";
    									$str_query_charge = "insert into  tblewallet2(user_id,dmr_id,transaction_type,debit_amount,balance,description,add_date,ipaddress,remark)
    
    									values(?,?,?,?,?,?,?,?,?)";
    									$reslut2 = $this->db->query($str_query_charge,array($user_id,$transaction_id,$transaction_type,$chargeAmount,$current_balance2,$Description,$add_date,$ip,$remark));
    									if($reslut2 == true)
    									{
    										$totaldebit_amount = $dr_amount + $chargeAmount;
    										$ewallet_id2 = $ewallet_id.",".$this->db->insert_id();
    										$rslt_updtrec = $this->db->query("update mt3_transfer set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?),debit_amount = ? where Id = ?",array($current_balance2,$totaldebit_amount,$transaction_id));	
    										return true;
    									}
    									else
    									{
    										$rslt_updtrec = $this->db->query("update mt3_transfer set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?),debit_amount = ? where Id = ?",array($current_balance,$dr_amount,$transaction_id));	
    										return false;
    									}
    									
    									
    									return false;
    						}
    						
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
    		else
    		{
    				return false;
    		}
		}
			
	}
	public function checkduplicate($user_id,$transaction_id)
    {
    	$add_date = $this->common->getDate();
    	$ip = $this->common->getRealIpAddr();
    
    	$rslt = $this->db->query("insert into dmr_refund_lock (user_id,dmr_id,add_date,ipaddress) values(?,?,?,?)",array($user_id,$transaction_id,$add_date,$ip));
    	  if($rslt == "" or $rslt == NULL)
    	  {
    		return false;
    	  }
    	  else
    	  {
    	  	return true;
    	  }
    }
	public function PAYMENT_CREDIT_ENTRY($user_id,$transaction_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$chargeAmount = 0.00)
	{
	    
	    
	    if($this->checkduplicate($user_id,$transaction_id) == false)
    	{
    	    
    	}
    	else
    	{
    	    	$Description = "Refund :".$Description;
        		$this->load->library("common");
        		$add_date = $this->common->getDate();
        		$date = $this->common->getMySqlDate();
        		$ip = $this->common->getRealIpAddr();
        		$old_balance = $this->Ew2->getAgentBalance($user_id);
        		$current_balance = $old_balance + $dr_amount;
        		$tds = 0.00;
        		$stax = 0.00;
        		if($transaction_type == "DMR")
        		{
        			$remark = "Money Remittance Reverse";
        			$str_query = "insert into  tblewallet2(user_id,dmr_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,remark)
        
        			values(?,?,?,?,?,?,?,?,?)";
        			$reslut = $this->db->query($str_query,array($user_id,$transaction_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip,$remark));
        			if($reslut == true)
        			{
        					$ewallet_id = $this->db->insert_id();
        					if($ewallet_id > 10)
        					{
        						if($sub_txn_type == "Account_Validation")
        						{
        									$rslt_updtrec = $this->db->query("update mt3_account_validate set reverted='yes',balance=CONCAT_WS(',',balance,?),credit_amount = ? where Id = ?",array($current_balance,$dr_amount,$transaction_id));
        									return true;
        						}
        						else if($sub_txn_type == "REMITTANCE")
        						{
        									$current_balance2 = $current_balance + $chargeAmount;
        									$remark = "Transaction Charge Reverse";
        									$str_query_charge = "insert into  tblewallet2(user_id,dmr_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,remark)
        
        									values(?,?,?,?,?,?,?,?,?)";
        									$reslut2 = $this->db->query($str_query_charge,array($user_id,$transaction_id,$transaction_type,$chargeAmount,$current_balance2,$Description,$add_date,$ip,$remark));
        									if($reslut2 == true)
        									{
        										$totaldebit_amount = $dr_amount + $chargeAmount;
        										$ewallet_id2 = $ewallet_id.",".$this->db->insert_id();
        										$rslt_updtrec = $this->db->query("update mt3_transfer set reverted='yes',balance=CONCAT_WS(',',balance,?), credit_amount = ? where Id = ?",array($current_balance2,$totaldebit_amount,$transaction_id));	
        										return true;
        									}
        									else
        									{
        										$rslt_updtrec = $this->db->query("update mt3_transfer set reverted='yes',balance=CONCAT_WS(',',balance,?),credit_amount = ? where Id = ?",array($current_balance,$dr_amount,$transaction_id));	
        										return false;
        									}
        									
        									
        									return false;
        						}
        						
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
        		else
        		{
        				return false;
        		}
    	}
	    
	    
		
	}

	public function COMMISSIONPAYMENT_CREDIT_ENTRY($user_id,$transaction_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$chargeAmount = 0.00)
	{
	
	/*	$Description = "Commission :".$Description;
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$date = $this->common->getMySqlDate();
		$ip = $this->common->getRealIpAddr();
		if($dr_amount <= 30)
		{
			$old_balance = $this->Ew2->getAgentBalance($user_id);
			$current_balance = $old_balance + $dr_amount;
			
			$tds = 0.00;
			$stax = 0.00;
			if($transaction_type == "DMR")
			{
				$remark = "Money Remittance Commission";
				$str_query = "insert into  tblewallet2(user_id,dmr_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,remark)
	
				values(?,?,?,?,?,?,?,?,?)";
				$reslut = $this->db->query($str_query,array($user_id,$transaction_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip,$remark));
				if($reslut == true)
				{
						$ewallet_id = $this->db->insert_id();
						if($ewallet_id > 10)
						{
						    $ORDERREM = "yes".$dr_amount;
							
				$rslt_updtrec = $this->db->query("update mt3_transfer set order_id=?  where Id = ?",array($ORDERREM,$transaction_id));
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
			else
			{
					return false;
			}
		}*/
			
	}
	
	

////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//****************************  P A Y M E N T   M E T H O D   E N D S   H E R E   ****************************//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

private function getChargeValue($userinfo,$whole_amount)
{
    
    
    $groupinfo = $this->db->query("select * from mt3_group where Id = (select dmr_group from tblusers where user_id = ?)",array($userinfo->row(0)->user_id));
	if($groupinfo->num_rows() == 1)
	{
		
			$getrangededuction = $this->db->query("
			select 
				a.charge_type,
				a.charge_amount as charge_value,
				'PER' as dist_charge_type,
				'0.20' as dist_charge_value,
				a.ccf,
				a.cashback,
				a.tds,
				a.ccf_type,
				a.tds_type,
				a.cashback_type
				from mt_commission_slabs a 
				where a.range_from <= ? and a.range_to >= ? and group_id = ?",array($whole_amount,$whole_amount,$groupinfo->row(0)->Id));
			if($getrangededuction->num_rows() == 1)
			{
				return $getrangededuction;
			}
		
		
	}
	else
	{
			$groupinfo = $this->db->query("select * from mt3_group where Id = (select dmr_group from tblusers where user_id = ?)",array($userinfo->row(0)->parentid));
        	if($groupinfo->num_rows() == 1)
        	{
        		if($groupinfo->row(0)->charge_type == "SLAB")
        		{
        			$getrangededuction = $this->db->query("
        			select 
        				a.charge_type,
        				a.charge_amount as charge_value,
        				'PER' as dist_charge_type,
        				'0.20' as dist_charge_value,
        				a.ccf,
        				a.cashback,
        				a.tds,
        				a.ccf_type,
						a.tds_type,
						a.cashback_type
        				from mt_commission_slabs a 
        				where a.range_from <= ? and a.range_to >= ? and group_id = ?",array($whole_amount,$whole_amount,$groupinfo->row(0)->Id));
        			if($getrangededuction->num_rows() == 1)
        			{
        				return $getrangededuction;
        			}
        		}
        		else
        		{
        			return $groupinfo;	
        		}
        		
        	}
        	else
        	{
        		return false;
        	}
	}
    
    
    
    
    
    

}













public function transfer_direct($remittermobile,$benificiary_name,$benificiary_mobile,$benificiary_ifsc,$benificiary_account_no,$amount,$mode,$userinfo,$order_id)
{

//error_reporting(-1);
//ini_set('display_errors',1);
//$this->db->db_debug = TRUE;

	$postfields = '';
	$jwtToken = "";
	$transtype = "IMPSIFSC";
	$apimode = "2";
	
	if($mode == "NEFT" or $mode == "1")
	{
	    $transtype = "NEFT";
	    $mode = "NEFT";
		$apimode = "1";
	}
	$postparam = $remittermobile." <>  <> ".$amount." <> ".$mode;
	$buffer = "No Api Call";
	if($userinfo != NULL)
	{
		if($userinfo->num_rows() == 1)
		{
			$url = '';
			$user_id = $userinfo->row(0)->user_id;
			$usertype_name = $userinfo->row(0)->usertype_name;
			$user_status = $userinfo->row(0)->status;
			if($usertype_name == "APIUSER")
			{
				if($user_status == '1')
				{
					if($amount >= 100)
					{
					    $crntBalance = $this->Ew2->getAgentBalance($user_id);
						if(floatval($crntBalance) >= floatval($amount) + 30)
						{
									$used_limit = 0;
									$remaining_limit = 25000 - $used_limit;
									if($remaining_limit >= $amount)
									{
										
	    								
												if($benificiary_ifsc=="JAKA0000001")$benificiary_ifsc="JAKA0CIRCUS";
												if($benificiary_ifsc=="BARBOBUPGBX")$benificiary_ifsc="BARB0BUPGBX";
												if($benificiary_ifsc=="BARB0COPARK")$benificiary_ifsc="BARB0KOPARK";
												//$benificiary_ifsc=substr_replace($benificiary_ifsc,"0",5,1);
												
	    									
											$beneficiaryid = "";
	    									$chargeinfo = $this->getChargeValue($userinfo,$amount);
	    									if($chargeinfo != false)
	    									{
	    										/////////////////////////////////////////////////
	    										/////// RETAILER CHARGE CALCULATION
	    										////////////////////////////////////////////////
	    										$ccf = $chargeinfo->row(0)->ccf;		
												$tds = $chargeinfo->row(0)->tds;
												$ccf_type = $chargeinfo->row(0)->ccf_type;	
												$tds_type = $chargeinfo->row(0)->tds_type;

												$Charge_type = $chargeinfo->row(0)->charge_type;
												$charge_value = $chargeinfo->row(0)->charge_value;

												if($ccf_type == "PER")
												{
													 $ccf = ((floatval($ccf) * floatval($amount))/ 100); 
												}
												$gst = (($ccf * 18)/118);
												$charge =  $charge_value;
												$cashback = $ccf - ($gst + $charge); 
												if($tds_type == "PER")
												{
													 $tds = ((floatval($tds) * floatval($cashback))/ 100); 
												}
			
												$Charge_Amount = $gst + $tds +  $charge;
	    									}
	    									else
	    									{
	    										$Charge_type = "PER";
	    										$charge_value = 0.40;
	    										$Charge_Amount = ((floatval($charge_value) * floatval($amount))/ 100); 
	    										$ccf = 0;
	    										$cashback = 0;
	    										$tds = 0;
	    										$charge = 0;
	    										$gst = 0;
	    									}
	    									
	    									
	    										
	    									
	    										$resultInsert = $this->db->query("
	    											insert into mt3_transfer(
	    											order_id,
													add_date,
													ipaddress,
													user_id,
	    											Charge_type,
	    											charge_value,
	    											Charge_Amount,
	    											RemiterMobile,
	    											BeneficiaryId,
	    											AccountNumber,
	    											IFSC,
	    											Amount,
	    											Status,
	    											mode,
													API,
													ccf,cashback,tds,gst,charge)
	    											values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
	    											",array(
													$order_id,
													$this->common->getDate(),
													$this->common->getRealIpAddr(),
													$user_id,
	    											$Charge_type,$charge_value,$Charge_Amount,
	    											$remittermobile,
	    											$beneficiaryid,
													$benificiary_account_no,
													$benificiary_ifsc,
	    											$amount,
													"PENDING",
													$mode,
													"AIRTEL",
													$ccf,
													$cashback,
													$tds,
													$gst,
													$charge
	    											));
	    										if($resultInsert == true)
	    										{
	    											$insert_id = $this->db->insert_id();
	    											$transaction_type = "DMR";
	    											$dr_amount = $amount;
	    											$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
	    											$sub_txn_type = "REMITTANCE";
	    											$remark = "Money Remittance";
	    											$paymentdebited = $this->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
													
	    											if($paymentdebited == true)
	    											{
	    											    
	    											    
	    												$sender_mobile_no = $remittermobile;
														$partnerId = "1000011097";
														$customerId =$sender_mobile_no;
														//$feSessionId =$this->generateRandomString();

														$datetime=date("Y-m-d H:i:s");
														$feSessionId =$txnReqId= "MPAY".$insert_id;
														$salt ="RDA2REZCM0UtREI4OS0xMUU5LThBMzQtMkEyQUUyREJDQ0U0";
														$channel ='EXTP';
														$amt = $amount;
														$ifsc =$benificiary_ifsc;
														$beneAccNo =$benificiary_account_no;
														$beneMobNo=$sender_mobile_no;
														$externalRefNo =$feSessionId;//substr(hash('sha256',mt_rand().microtime()),0,15);
														$hashString = $channel.'#'.$partnerId.'#'.$customerId.'#'.$amount.'#'.$ifsc.'#'.$beneAccNo.'#'.$salt;
														$hash = hash("sha512", $hashString);
														
														$sender_state_code='';
														$sender_dob=$this->get_random_dob();
														$arr_state_code=$this->get_random_state();
														$sender_state_code=intval($arr_state_code['state_code']);
														if($sender_state_code<=9)
														{
														 $sender_state_code='0'.$sender_state_code;	
														}
														$sender_address = trim($arr_state_code['state_name']);
														$sender_address = str_replace("&","AND",$sender_address);
														$sender_state_pincode=intval($arr_state_code['state_pincode']);


														$sender_name = "";
														$lastname = "";
														$pincode = "";
														$sender_info = $this->db->query("SELECT mobile,name,lastname,pincode FROM mt3_remitter_registration where mobile = ? order by Id desc limit 1",array($sender_mobile_no));
														if($sender_info->num_rows() == 1)
														{
															$sender_name = $sender_info->row(0)->name;
															$sender_name = preg_replace('/[^a-z]/i', '', $sender_name);
															$lastname = $sender_info->row(0)->lastname;
															$lastname = preg_replace('/[^a-z]/i', '', $lastname);
															if(trim($lastname)=="")$lastname="Kumar";
															$pincode = $sender_info->row(0)->pincode;
														}
														////////////////////
															$sender_name=$this->get_random_fname();
															$lastname=$this->get_random_lname();
															$pincode=intval($pincode);
															if(strlen($pincode)!=6)
															{
																$pincode = $sender_state_pincode;
															}
														////////////////////	
															$reqarr = array(
																"ver" => "2.0",
																"feSessionId" => $feSessionId,
																"channel" => 'EXTP',
																"apiMode" =>'P',
																"partnerId" =>$partnerId,
																"customerId" =>$sender_mobile_no,
																"amount" =>$amt,
																"bankName" =>"",
																"ifsc" =>$benificiary_ifsc,
																"beneAccNo" =>$beneAccNo,
																"beneMobNo" =>$sender_mobile_no,
																"externalRefNo" =>$externalRefNo,
																"hash" =>$hash,
																"reference1" =>'ACEa'.$beneMobNo,
																"reference2" =>$sender_mobile_no,
																"custFirstName" =>$sender_name,
																"custLastName" =>$lastname,
																"custPincode" =>$pincode,
																"custAddress" =>$sender_address,
																"custDob" =>$sender_dob,
																"stateCode" =>$sender_state_code
															);
															$req = json_encode($reqarr);
															$url="https://portal.airtelbank.com/RetailerPortal/CHAMPimps";
															$curl = curl_init();
															curl_setopt_array($curl, array(
																CURLOPT_URL => "https://portal.airtelbank.com/RetailerPortal/CHAMPimps",
																CURLOPT_RETURNTRANSFER => true,
																CURLOPT_ENCODING => "",
																CURLOPT_MAXREDIRS => 10,
																CURLOPT_TIMEOUT => 90,
																CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
																CURLOPT_CUSTOMREQUEST => "POST",
																CURLOPT_POSTFIELDS => $req,
																CURLOPT_HTTPHEADER => array(
																	"Accept: */*",
																	"Cache-Control: no-cache",
																	"Connection: keep-alive",
																	"Content-Type: application/json",
																),
															));

														$response = curl_exec($curl);
														$res = json_decode($response);
														$err = curl_error($curl);
														curl_close($curl);
														$this->requestlog($insert_id,$req,$response,$remittermobile,$benificiary_account_no,"");
														$this->db->reset_query();
														$this->db->where("Id",$insert_id);
														$this->db->update("mt3_transfer",array("txn_req_id"=>$txnReqId));
														$this->db->reset_query();
														
														
															
														if(isset($res->code))
														{
																
																$data = $res;
																$tid = trim((string)$data->tranId);
																$bank_ref_num = trim((string)$data->externalRefNo);
																$_rrn = trim((string)$data->rrn);
																$recipient_name = trim((string)$data->beneName);
																$message = trim((string)$data->messageText);
																$statuscode = trim((string)$data->rrn);
																$errorCode = trim((string)$res->errorCode);
																
																if($res->code=='0')
																{
																		
																		$this->update_limit($sender_mobile_no,$amount);
																		$data = $res;
																		$tid = trim((string)$data->tranId);
																		$bank_ref_num = trim((string)$data->externalRefNo);
																		$_rrn = trim((string)$data->rrn);
																		$recipient_name = trim((string)$data->beneName);
																		$message = trim((string)$data->messageText);
																		$statuscode = trim((string)$data->rrn);

																		$data = array(
																					'RESP_statuscode' => "TXN",
																					'RESP_status' => $message,
																					'RESP_ipay_id' => $tid,
																					'RESP_opr_id' => $_rrn,
																					'RESP_name' => $recipient_name,
																					'Status'=>'SUCCESS',
																					'edit_date'=>$this->common->getDate()
																			);
																			$this->db->where('Id', $insert_id);
																			$this->db->update('mt3_transfer', $data);
																			
																			
																			$resp_arr = array(
																								"message"=>"SUCCESS",
																								"status"=>0,
																								"statuscode"=>"TXN",
																								"data"=>array(
																									"tid"=>$tid,
																									"ref_no"=>$bank_ref_num,
																									"opr_id"=>$_rrn,
																									"name"=>$recipient_name,
																									"balance"=>0,
																									"amount"=>$amount,
	
																								)
																							);
																			$json_resp =  json_encode($resp_arr);
																			
																}
																else if($res->code=='2')
																{
																		
																		$data = $res;
																		$tid = trim((string)$data->tranId);
																		$bank_ref_num = trim((string)$data->externalRefNo);
																		$_rrn = trim((string)$data->rrn);
																		$recipient_name = trim((string)$data->beneName);
																		$message = trim((string)$data->messageText);
																		$statuscode = trim((string)$data->rrn);

																		$data = array(
																					'RESP_statuscode' => "TUP",
																					'RESP_status' => $message,
																					'RESP_ipay_id' => $tid,
																					'RESP_opr_id' => $_rrn,
																					'RESP_name' => $recipient_name,
																					'Status'=>'PENDING',
																					'edit_date'=>$this->common->getDate()
																			);
																			$this->db->where('Id', $insert_id);
																			$this->db->update('mt3_transfer', $data);
																			
																			
																			
																			$resp_arr = array(
																								"message"=>"Transaction Under Pending Process",
																								"status"=>1,
																								"statuscode"=>"TUP",
																								"data"=>array(
																									"tid"=>$tid,
																									"ref_no"=>$bank_ref_num,
																									"opr_id"=>$_rrn,
																									"name"=>$recipient_name,
																									"balance"=>0,
																									"amount"=>$amount,
	
																								)
																							);
																			$json_resp =  json_encode($resp_arr);
																			
																}
																else if($res->code=='1')
																{
																		
																		
																		
																		$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);

																		$data = $res;
																		$tid = trim((string)$data->tranId);
																		$bank_ref_num = trim((string)$data->externalRefNo);
																		$_rrn = trim((string)$data->rrn);
																		$recipient_name = trim((string)$data->beneName);
																		$message = trim((string)$data->messageText);
																		$statuscode = trim((string)$data->rrn);
																		if($message=="Insufficient Available Balance. .")$message="Please try after sometime.";
																		$data = array(
																					'RESP_statuscode' => "ERR",
																					'RESP_status' => $message,
																					'RESP_ipay_id' => $tid,
																					'RESP_opr_id' => $_rrn,
																					'RESP_name' => $recipient_name,
																					'Status'=>'FAILURE',
																					'edit_date'=>$this->common->getDate()
																			);
																			$this->db->where('Id', $insert_id);
																			$this->db->update('mt3_transfer', $data);
																			
																			
																			
																			$resp_arr = array(
																								"message"=>"Transaction Failed",
																								"status"=>1,
																								"statuscode"=>"ERR",
																								"data"=>array(
																									"tid"=>$tid,
																									"ref_no"=>$bank_ref_num,
																									"opr_id"=>$_rrn,
																									"name"=>$recipient_name,
																									"balance"=>0,
																									"amount"=>$amount,
	
																								)
																							);
																			$json_resp =  json_encode($resp_arr);
																			
																}
																else
																{

																		$data = array(
																				'RESP_statuscode' => "",
																				'RESP_status' => "",
																				'Status'=>'PENDING',
																				'edit_date'=>$this->common->getDate()
																		);
	
																		$this->db->where('Id', $insert_id);
																		$this->db->update('mt3_transfer', $data);
																		
																		$message="Transaction Under Pending Process";
																		
																		$resp_arr = array(
																								"message"=>$message,
																								"status"=>0,
																								"statuscode"=>"TUP",
																							);
																		$json_resp =  json_encode($resp_arr);
																			
																}
																
														}
														else
														{
															$message="Transaction Pending";
															
															$resp_arr = array(
																				"message"=>$message,
																				"status"=>0,
																				"statuscode"=>"TUP",
																				"data"=>array(
																					"tid"=>$insert_id,
																					"ref_no"=>$insert_id,
																					"opr_id"=>"",
																					"name"=>$benificiary_name,									
																					"balance"=>"",
																					"amount"=>$amount,

																				)
																			);
															$json_resp =  json_encode($resp_arr);
														}

	/*
	{"status":"pending","message":"The amount will be transferred to CHAMPION SOFTWARE TECHNOLOGIES's bank account ","amount":102.0,"customerMobile":"8866628967","response_code":0,"txn_id":"1436095","mw_txn_id":"77297878","extra_info":{"mode":"neft","totalAmount":"112.00","utr":"PYTMH19326125256","beneficiaryName":"CHAMPION SOFTWARE TECHNOLOGIES","commission":"10.00","transfer_type":"neft"},"rrn":"PYTMH19326125256"}
	*/														       
																
																
	    											}
	    											else
	    											{
	    											    	$data = array(
	    																			'RESP_statuscode' => "ERR",
	    																			'RESP_status' => "PAYMENT FAILURE",
	    																			'tx_status'=>"1",
	    																			'Status'=>'FAILURE',
	    																	);
	    
	    																	$this->db->where('Id', $insert_id);
	    																	$this->db->update('mt3_transfer', $data);
																				
																	$message="Payment Failure";
																	
																						
																	$resp_arr = array(
																		"message"=>$message,
																		"status"=>1,
																		"statuscode"=>"ERR",
																	);
																	$json_resp =  json_encode($resp_arr);	
	    											}		
	    										}
	    										else
	    										{
														$message="Internal Server Error";
														
	    											$resp_arr = array(
	    												"message"=>$message,
	    												"status"=>1,
	    												"statuscode"=>"ERR",
	    											);
	    											$json_resp =  json_encode($resp_arr);	
	    										}
	    									
	    								
									}
									else
									{
												$message="Sender Limit Over";
												
												$resp_arr = array(
														"message"=>$message,
														"status"=>1,
														"statuscode"=>"ERR",
													);
												$json_resp =  json_encode($resp_arr);
									}
						}
						else
						{
									$message="InSufficient Balance";
									
									$resp_arr = array(
											"message"=>$message,
											"status"=>1,
											"statuscode"=>"ISB",
										);
									$json_resp =  json_encode($resp_arr);
						}    
					}
					else
					{
							$message="Minimum Balance Limit is 100 Rupees";
							
					    $resp_arr = array(
									"message"=>$message,
									"status"=>1,
									"statuscode"=>"ERR",
								);
							$json_resp =  json_encode($resp_arr);
					}
					
					
				}
				else
				{
						$message="Your Account Deactivated By Admin";
						
						$resp_arr = array(
									"message"=>$message,
									"status"=>1,
									"statuscode"=>"UNK",
								);
						$json_resp =  json_encode($resp_arr);
				}
					
			}
			else
			{
					$message="Invalid Access";
					
					$resp_arr = array(
									"message"=>$message,
									"status"=>1,
									"statuscode"=>"UNK",
								);
					$json_resp =  json_encode($resp_arr);
			}
		}
		else
		{
			$message="Userinfo Missing";
		
			$resp_arr = array(
								"message"=>$message,
								"status"=>4,
								"statuscode"=>"UNK",
							);
			$json_resp =  json_encode($resp_arr);
		}
		
	}
	else
	{
			$message="Userinfo Missing";
			
			$resp_arr = array(
								"message"=>$message,
								"status"=>4,
								"statuscode"=>"UNK",
							);
			$json_resp =  json_encode($resp_arr);
		
	}
	//$this->loging_db("transfer",$mode." ".$url."?".json_encode($reqarr),$response,$json_resp,$userinfo->row(0)->username,$remittermobile);
	return $json_resp;
	
}



public function transfer_resend_hold_Airtel($Id)
{

    if($this->checkduplicate_resend($Id,"AIRTEL"))
	//if(true)
    {
        $postfields = '';
		$jwtToken = "";
		$transtype = "IMPSIFSC";
		$apimode = "2";
		
		
	    $insert_id = $Id;
	    $dmr_id = $Id;

	    $rslttransaction = $this->db->query("SELECT * FROM `mt3_transfer` where  (Status = 'PENDING' or Status = 'HOLD') and Id = ?",array($Id));


        $benificiary_name = $rslttransaction->row(0)->RESP_name;
		$remitter_id = $rslttransaction->row(0)->RemiterMobile;
		$remittermobile = $remitter_id;
		$benificiary_account_no = $rslttransaction->row(0)->BeneficiaryId;
		$mobile_no = $remitter_id;
		$mode = $rslttransaction->row(0)->mode;
		$user_id = $rslttransaction->row(0)->user_id;
		$beneficiaryid = $rslttransaction->row(0)->BeneficiaryId;
		$Charge_Amount = $rslttransaction->row(0)->Charge_Amount;
	
		$AccountNumber = $rslttransaction->row(0)->AccountNumber;
		$benificiary_account_no = $AccountNumber;
		$IFSC = $rslttransaction->row(0)->IFSC;
		$amount = $rslttransaction->row(0)->Amount;
		$dist_charge_amount= $rslttransaction->row(0)->dist_charge_amount;
		$postfields = '';
		$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
		if($mode == "IMPS"){$apimode = "2";}
		if($mode == "NEFT"){$apimode = "1";}
		$postparam = $remittermobile." <> ".$beneficiaryid." <> ".$amount." <> ".$mode;
		//echo $postparam;exit;
		if($mode == "NEFT" or $mode == "1")
		{
		    $transtype = "NEFT";
		    $mode = "NEFT";
			$apimode = "1";
		}	
		$buffer = "No Api Call";
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
				$url = '';
				$user_id = $userinfo->row(0)->user_id;
				$DId = $userinfo->row(0)->parentid;
				$MdId = 0;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				
					$parentinfo = $this->db->query("select * from tblusers where user_id = ?",array($DId));
					if($parentinfo->num_rows() == 1)
					{
							$MdId = $parentinfo->row(0)->parentid;
					}
					
					
					$this->db->query("update mt3_transfer set Status = 'PENDING' where Id = ?",array($Id));
					$insert_id = $Id;
					 $timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));

			   		
				        
				        	$this->db->query("update mt3_transfer set API = 'AIRTEL' where Id = ?",array($insert_id));
				        
					        $timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));



	//	echo $benificiary_name;exit;

							
	

		$remitter_id = $rslttransaction->row(0)->RemiterMobile;
		$remittermobile = $remitter_id;
		
		$mobile_no = $remitter_id;
		$mode = $rslttransaction->row(0)->mode;
		$user_id = $rslttransaction->row(0)->user_id;
		$beneficiaryid = $rslttransaction->row(0)->BeneficiaryId;
		$Charge_Amount = $rslttransaction->row(0)->Charge_Amount;
	
		$AccountNumber = $rslttransaction->row(0)->AccountNumber;
		$benificiary_account_no = $AccountNumber;
		$IFSC = $rslttransaction->row(0)->IFSC;
		$amount = $rslttransaction->row(0)->Amount;
		$bank_id = $rslttransaction->row(0)->bank_id;
		$MMW_mode = "IMPS";
		if($mode == "NEFT")
		{
			$MMW_mode = "NEFT";
		}
		
							$sender_mobile_no = $remittermobile;
							$partnerId = "1000011097";
							$customerId =$sender_mobile_no;
							//$feSessionId =$this->generateRandomString();

							$datetime=date("Y-m-d H:i:s");
							$feSessionId =$txnReqId= "MPAY".$insert_id;
							$salt ="RDA2REZCM0UtREI4OS0xMUU5LThBMzQtMkEyQUUyREJDQ0U0";
							$channel ='EXTP';
							$amt = $amount;
							$ifsc =$IFSC;
							$beneAccNo =$benificiary_account_no;
							$beneMobNo=$sender_mobile_no;
							$externalRefNo =$feSessionId;//substr(hash('sha256',mt_rand().microtime()),0,15);
							$hashString = $channel.'#'.$partnerId.'#'.$customerId.'#'.$amount.'#'.$ifsc.'#'.$beneAccNo.'#'.$salt;
							$hash = hash("sha512", $hashString);
							
							$sender_state_code='';
							$sender_dob=$this->get_random_dob();
							$arr_state_code=$this->get_random_state();
							$sender_state_code=intval($arr_state_code['state_code']);
							if($sender_state_code<=9)
							{
							 $sender_state_code='0'.$sender_state_code;	
							}
							$sender_address = trim($arr_state_code['state_name']);
							$sender_address = str_replace("&","AND",$sender_address);
							$sender_state_pincode=intval($arr_state_code['state_pincode']);


							$sender_name = "";
							$lastname = "";
							$pincode = "";
							$sender_info = $this->db->query("SELECT mobile,name,lastname,pincode FROM mt3_remitter_registration where mobile = ? order by Id desc limit 1",array($sender_mobile_no));
							if($sender_info->num_rows() == 1)
							{
								$sender_name = $sender_info->row(0)->name;
								$sender_name = preg_replace('/[^a-z]/i', '', $sender_name);
								$lastname = $sender_info->row(0)->lastname;
								$lastname = preg_replace('/[^a-z]/i', '', $lastname);
								if(trim($lastname)=="")$lastname="Kumar";
								$pincode = $sender_info->row(0)->pincode;
							}
							////////////////////
								$sender_name=$this->get_random_fname();
								$lastname=$this->get_random_lname();
								$pincode=intval($pincode);
								if(strlen($pincode)!=6)
								{
									$pincode = $sender_state_pincode;
								}
							////////////////////	
								$reqarr = array(
									"ver" => "2.0",
									"feSessionId" => $feSessionId,
									"channel" => 'EXTP',
									"apiMode" =>'P',
									"partnerId" =>$partnerId,
									"customerId" =>$sender_mobile_no,
									"amount" =>$amt,
									"bankName" =>"",
									"ifsc" =>$IFSC,
									"beneAccNo" =>$beneAccNo,
									"beneMobNo" =>$sender_mobile_no,
									"externalRefNo" =>$externalRefNo,
									"hash" =>$hash,
									"reference1" =>'ACEa'.$beneMobNo,
									"reference2" =>$sender_mobile_no,
									"custFirstName" =>$sender_name,
									"custLastName" =>$lastname,
									"custPincode" =>$pincode,
									"custAddress" =>$sender_address,
									"custDob" =>$sender_dob,
									"stateCode" =>$sender_state_code
								);
								$req = json_encode($reqarr);
								$url="https://portal.airtelbank.com/RetailerPortal/CHAMPimps";
								$curl = curl_init();
								curl_setopt_array($curl, array(
									CURLOPT_URL => "https://portal.airtelbank.com/RetailerPortal/CHAMPimps",
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 90,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "POST",
									CURLOPT_POSTFIELDS => $req,
									CURLOPT_HTTPHEADER => array(
										"Accept: */*",
										"Cache-Control: no-cache",
										"Connection: keep-alive",
										"Content-Type: application/json",
									),
								));

							$response = curl_exec($curl);
							$res = json_decode($response);
							$err = curl_error($curl);
							curl_close($curl);
							$this->requestlog($insert_id,$req,$response,$remittermobile,$benificiary_account_no,"");
							$this->db->reset_query();
							$this->db->where("Id",$insert_id);
							$this->db->update("mt3_transfer",array("txn_req_id"=>$txnReqId));
							$this->db->reset_query();
							
							
								
							if(isset($res->code))
							{
									
									$data = $res;
									$tid = trim((string)$data->tranId);
									$bank_ref_num = trim((string)$data->externalRefNo);
									$_rrn = trim((string)$data->rrn);
									$recipient_name = trim((string)$data->beneName);
									$message = trim((string)$data->messageText);
									$statuscode = trim((string)$data->rrn);
									$errorCode = trim((string)$res->errorCode);
									
									if($res->code=='0')
									{
											
											$this->update_limit($sender_mobile_no,$amount);
											$data = $res;
											$tid = trim((string)$data->tranId);
											$bank_ref_num = trim((string)$data->externalRefNo);
											$_rrn = trim((string)$data->rrn);
											$recipient_name = trim((string)$data->beneName);
											$message = trim((string)$data->messageText);
											$statuscode = trim((string)$data->rrn);

											$data = array(
														'RESP_statuscode' => "TXN",
														'RESP_status' => $message,
														'RESP_ipay_id' => $tid,
														'RESP_opr_id' => $_rrn,
														'RESP_name' => $recipient_name,
														'Status'=>'SUCCESS',
														'edit_date'=>$this->common->getDate()
												);
												$this->db->where('Id', $insert_id);
												$this->db->update('mt3_transfer', $data);
												
												
												$resp_arr = array(
																	"message"=>"SUCCESS",
																	"status"=>0,
																	"statuscode"=>"TXN",
																	"data"=>array(
																		"tid"=>$tid,
																		"ref_no"=>$bank_ref_num,
																		"opr_id"=>$_rrn,
																		"name"=>$recipient_name,
																		"balance"=>0,
																		"amount"=>$amount,

																	)
																);
												$json_resp =  json_encode($resp_arr);
												
									}
									else if($res->code=='2')
									{
											
											$data = $res;
											$tid = trim((string)$data->tranId);
											$bank_ref_num = trim((string)$data->externalRefNo);
											$_rrn = trim((string)$data->rrn);
											$recipient_name = trim((string)$data->beneName);
											$message = trim((string)$data->messageText);
											$statuscode = trim((string)$data->rrn);

											$data = array(
														'RESP_statuscode' => "TUP",
														'RESP_status' => $message,
														'RESP_ipay_id' => $tid,
														'RESP_opr_id' => $_rrn,
														'RESP_name' => $recipient_name,
														'Status'=>'PENDING',
														'edit_date'=>$this->common->getDate()
												);
												$this->db->where('Id', $insert_id);
												$this->db->update('mt3_transfer', $data);
												
												
												
												$resp_arr = array(
																	"message"=>"Transaction Under Pending Process",
																	"status"=>1,
																	"statuscode"=>"TUP",
																	"data"=>array(
																		"tid"=>$tid,
																		"ref_no"=>$bank_ref_num,
																		"opr_id"=>$_rrn,
																		"name"=>$recipient_name,
																		"balance"=>0,
																		"amount"=>$amount,

																	)
																);
												$json_resp =  json_encode($resp_arr);
												
									}
									
									else
									{

											
											$message="Transaction Under Pending Process";
											
											$resp_arr = array(
																	"message"=>$message,
																	"status"=>0,
																	"statuscode"=>"TUP",
																);
											$json_resp =  json_encode($resp_arr);
												
									}
									
							}
							else
							{
								$message="Transaction Pending";
								
								$resp_arr = array(
													"message"=>$message,
													"status"=>0,
													"statuscode"=>"TUP",
													"data"=>array(
														"tid"=>$insert_id,
														"ref_no"=>$insert_id,
														"opr_id"=>"",
														"name"=>$benificiary_name,									
														"balance"=>"",
														"amount"=>$amount,

													)
												);
								$json_resp =  json_encode($resp_arr);
							}



					    
				    			
										
			}
			else
			{
				$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
			$json_resp =  json_encode($resp_arr);
			
		}
		$this->loging("eko_hold_resend",$url."?".$postfields,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
    }
    else
    {
        echo "Duplicate Request Found";exit;
    }
    

    	
	
}







public function Transfer_Api_call_only($Id)
{

    //if($this->checkduplicate_resend($Id))
	if(true)
    {
        $postfields = '';
		$jwtToken = "";
		$transtype = "IMPSIFSC";
		$apimode = "2";
		
		
	    $insert_id = $Id;
	    $dmr_id = $Id;

	    $rslttransaction = $this->db->query("SELECT * FROM `mt3_transfer` where  (Status = 'PENDING' or Status = 'HOLD') and Id = ?",array($Id));


        $benificiary_name = $rslttransaction->row(0)->RESP_name;
		$remitter_id = $rslttransaction->row(0)->RemiterMobile;
		$remittermobile = $remitter_id;
		$benificiary_account_no = $rslttransaction->row(0)->BeneficiaryId;
		$mobile_no = $remitter_id;
		$mode = $rslttransaction->row(0)->mode;
		$user_id = $rslttransaction->row(0)->user_id;
		$beneficiaryid = $rslttransaction->row(0)->BeneficiaryId;
		$Charge_Amount = $rslttransaction->row(0)->Charge_Amount;
	
		$AccountNumber = $rslttransaction->row(0)->AccountNumber;
		$benificiary_account_no = $AccountNumber;
		$IFSC = $rslttransaction->row(0)->IFSC;
		$amount = $rslttransaction->row(0)->Amount;
		$dist_charge_amount= $rslttransaction->row(0)->dist_charge_amount;
		$postfields = '';
		$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
		if($mode == "IMPS"){$apimode = "2";}
		if($mode == "NEFT"){$apimode = "1";}
		$postparam = $remittermobile." <> ".$beneficiaryid." <> ".$amount." <> ".$mode;
		//echo $postparam;exit;
		if($mode == "NEFT" or $mode == "1")
		{
		    $transtype = "NEFT";
		    $mode = "NEFT";
			$apimode = "1";
		}	
		$buffer = "No Api Call";
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
				$url = '';
				$user_id = $userinfo->row(0)->user_id;
				$DId = $userinfo->row(0)->parentid;
				$MdId = 0;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				
					$parentinfo = $this->db->query("select * from tblusers where user_id = ?",array($DId));
					if($parentinfo->num_rows() == 1)
					{
							$MdId = $parentinfo->row(0)->parentid;
					}
					
					
					$this->db->query("update mt3_transfer set Status = 'PENDING' where Id = ?",array($Id));
					$insert_id = $Id;
					 $timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));

			   		
				        
				        	$this->db->query("update mt3_transfer set API = 'AIRTEL' where Id = ?",array($insert_id));
				        
					        $timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));



	//	echo $benificiary_name;exit;

							
	

		$remitter_id = $rslttransaction->row(0)->RemiterMobile;
		$remittermobile = $remitter_id;
		
		$mobile_no = $remitter_id;
		$mode = $rslttransaction->row(0)->mode;
		$user_id = $rslttransaction->row(0)->user_id;
		$beneficiaryid = $rslttransaction->row(0)->BeneficiaryId;
		$Charge_Amount = $rslttransaction->row(0)->Charge_Amount;
	
		$AccountNumber = $rslttransaction->row(0)->AccountNumber;
		$benificiary_account_no = $AccountNumber;
		$IFSC = $rslttransaction->row(0)->IFSC;
		$amount = $rslttransaction->row(0)->Amount;
		$bank_id = $rslttransaction->row(0)->bank_id;
		$MMW_mode = "IMPS";
		if($mode == "NEFT")
		{
			$MMW_mode = "NEFT";
		}
		
							$sender_mobile_no = $remittermobile;
							$partnerId = "1000011097";
							$customerId =$sender_mobile_no;
							//$feSessionId =$this->generateRandomString();

							$datetime=date("Y-m-d H:i:s");
							$feSessionId =$txnReqId= "MPAY".$insert_id;
							$salt ="RDA2REZCM0UtREI4OS0xMUU5LThBMzQtMkEyQUUyREJDQ0U0";
							$channel ='EXTP';
							$amt = $amount;
							$ifsc =$IFSC;
							$beneAccNo =$benificiary_account_no;
							$beneMobNo=$sender_mobile_no;
							$externalRefNo =$feSessionId;//substr(hash('sha256',mt_rand().microtime()),0,15);
							$hashString = $channel.'#'.$partnerId.'#'.$customerId.'#'.$amount.'#'.$ifsc.'#'.$beneAccNo.'#'.$salt;
							$hash = hash("sha512", $hashString);
							
							$sender_state_code='';
							$sender_dob=$this->get_random_dob();
							$arr_state_code=$this->get_random_state();
							$sender_state_code=intval($arr_state_code['state_code']);
							if($sender_state_code<=9)
							{
							 $sender_state_code='0'.$sender_state_code;	
							}
							$sender_address = trim($arr_state_code['state_name']);
							$sender_address = str_replace("&","AND",$sender_address);
							$sender_state_pincode=intval($arr_state_code['state_pincode']);


							$sender_name = "";
							$lastname = "";
							$pincode = "";
							$sender_info = $this->db->query("SELECT mobile,name,lastname,pincode FROM mt3_remitter_registration where mobile = ? order by Id desc limit 1",array($sender_mobile_no));
							if($sender_info->num_rows() == 1)
							{
								$sender_name = $sender_info->row(0)->name;
								$sender_name = preg_replace('/[^a-z]/i', '', $sender_name);
								$lastname = $sender_info->row(0)->lastname;
								$lastname = preg_replace('/[^a-z]/i', '', $lastname);
								if(trim($lastname)=="")$lastname="Kumar";
								$pincode = $sender_info->row(0)->pincode;
							}
							////////////////////
								$sender_name=$this->get_random_fname();
								$lastname=$this->get_random_lname();
								$pincode=intval($pincode);
								if(strlen($pincode)!=6)
								{
									$pincode = $sender_state_pincode;
								}
							////////////////////	
								$reqarr = array(
									"ver" => "2.0",
									"feSessionId" => $feSessionId,
									"channel" => 'EXTP',
									"apiMode" =>'P',
									"partnerId" =>$partnerId,
									"customerId" =>$sender_mobile_no,
									"amount" =>$amt,
									"bankName" =>"",
									"ifsc" =>$IFSC,
									"beneAccNo" =>$beneAccNo,
									"beneMobNo" =>$sender_mobile_no,
									"externalRefNo" =>$externalRefNo,
									"hash" =>$hash,
									"reference1" =>'ACEa'.$beneMobNo,
									"reference2" =>$sender_mobile_no,
									"custFirstName" =>$sender_name,
									"custLastName" =>$lastname,
									"custPincode" =>$pincode,
									"custAddress" =>$sender_address,
									"custDob" =>$sender_dob,
									"stateCode" =>$sender_state_code
								);
								$req = json_encode($reqarr);
								$url="https://portal.airtelbank.com/RetailerPortal/CHAMPimps";
								$curl = curl_init();
								curl_setopt_array($curl, array(
									CURLOPT_URL => "https://portal.airtelbank.com/RetailerPortal/CHAMPimps",
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 90,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "POST",
									CURLOPT_POSTFIELDS => $req,
									CURLOPT_HTTPHEADER => array(
										"Accept: */*",
										"Cache-Control: no-cache",
										"Connection: keep-alive",
										"Content-Type: application/json",
									),
								));

							$response = curl_exec($curl);
							$res = json_decode($response);
							$err = curl_error($curl);
							curl_close($curl);
							$this->requestlog($insert_id,$req,$response,$remittermobile,$benificiary_account_no,"");
							$this->db->reset_query();
							$this->db->where("Id",$insert_id);
							$this->db->update("mt3_transfer",array("txn_req_id"=>$txnReqId));
							$this->db->reset_query();
							
							
								
							if(isset($res->code))
							{
									
									$data = $res;
									$tid = trim((string)$data->tranId);
									$bank_ref_num = trim((string)$data->externalRefNo);
									$_rrn = trim((string)$data->rrn);
									$recipient_name = trim((string)$data->beneName);
									$message = trim((string)$data->messageText);
									$statuscode = trim((string)$data->rrn);
									$errorCode = trim((string)$res->errorCode);
									
									if($res->code=='0')
									{
											
											$this->update_limit($sender_mobile_no,$amount);
											$data = $res;
											$tid = trim((string)$data->tranId);
											$bank_ref_num = trim((string)$data->externalRefNo);
											$_rrn = trim((string)$data->rrn);
											$recipient_name = trim((string)$data->beneName);
											$message = trim((string)$data->messageText);
											$statuscode = trim((string)$data->rrn);

											$data = array(
														'RESP_statuscode' => "TXN",
														'RESP_status' => $message,
														'RESP_ipay_id' => $tid,
														'RESP_opr_id' => $_rrn,
														'RESP_name' => $recipient_name,
														'Status'=>'SUCCESS',
														'edit_date'=>$this->common->getDate()
												);
												$this->db->where('Id', $insert_id);
												$this->db->update('mt3_transfer', $data);
												
												
												$resp_arr = array(
																	"message"=>"SUCCESS",
																	"status"=>0,
																	"statuscode"=>"TXN",
																	"data"=>array(
																		"tid"=>$tid,
																		"ref_no"=>$bank_ref_num,
																		"opr_id"=>$_rrn,
																		"name"=>$recipient_name,
																		"balance"=>0,
																		"amount"=>$amount,

																	)
																);
												$json_resp =  json_encode($resp_arr);
												
									}
									else if($res->code=='2')
									{
											
											$data = $res;
											$tid = trim((string)$data->tranId);
											$bank_ref_num = trim((string)$data->externalRefNo);
											$_rrn = trim((string)$data->rrn);
											$recipient_name = trim((string)$data->beneName);
											$message = trim((string)$data->messageText);
											$statuscode = trim((string)$data->rrn);

											$data = array(
														'RESP_statuscode' => "TUP",
														'RESP_status' => $message,
														'RESP_ipay_id' => $tid,
														'RESP_opr_id' => $_rrn,
														'RESP_name' => $recipient_name,
														'Status'=>'PENDING',
														'edit_date'=>$this->common->getDate()
												);
												$this->db->where('Id', $insert_id);
												$this->db->update('mt3_transfer', $data);
												
												
												
												$resp_arr = array(
																	"message"=>"Transaction Under Pending Process",
																	"status"=>1,
																	"statuscode"=>"TUP",
																	"data"=>array(
																		"tid"=>$tid,
																		"ref_no"=>$bank_ref_num,
																		"opr_id"=>$_rrn,
																		"name"=>$recipient_name,
																		"balance"=>0,
																		"amount"=>$amount,

																	)
																);
												$json_resp =  json_encode($resp_arr);
												
									}
									
									else
									{

											
											$message="Transaction Under Pending Process";
											
											$resp_arr = array(
																	"message"=>$message,
																	"status"=>0,
																	"statuscode"=>"TUP",
																);
											$json_resp =  json_encode($resp_arr);
												
									}
									
							}
							else
							{
								$message="Transaction Pending";
								
								$resp_arr = array(
													"message"=>$message,
													"status"=>0,
													"statuscode"=>"TUP",
													"data"=>array(
														"tid"=>$insert_id,
														"ref_no"=>$insert_id,
														"opr_id"=>"",
														"name"=>$benificiary_name,									
														"balance"=>"",
														"amount"=>$amount,

													)
												);
								$json_resp =  json_encode($resp_arr);
							}



					    
				    			
										
			}
			else
			{
				$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
			$json_resp =  json_encode($resp_arr);
			
		}
		$this->loging("airtel_hold_resend",$url."?".$postfields,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
    }
    else
    {
        echo "Duplicate Request Found";exit;
    }
    

    	
	
}



public function checkduplicate_resend($dmr_id,$api_name)
{
	$result = $this->db->query("insert into dmt_resend_duplicate(dmr_id,api_name,add_date,ipaddress) values(?,?,?,?)",
					array($dmr_id,$api_name,$this->common->getDate(),$this->common->getRealIpAddr()));
	if($result == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}

public function Resend_Api_call_only($Id)
{

    if($this->checkduplicate_resend($Id,"Airtel"))
	//if(true)
    {
        $postfields = '';
		$jwtToken = "";
		$transtype = "IMPSIFSC";
		$apimode = "2";
		
		
	    $insert_id = $Id;
	    $dmr_id = $Id;

	    $rslttransaction = $this->db->query("SELECT * FROM `mt3_transfer` where  (Status = 'PENDING' or Status = 'HOLD') and Id = ?",array($Id));


        $benificiary_name = $rslttransaction->row(0)->RESP_name;
		$remitter_id = $rslttransaction->row(0)->RemiterMobile;
		$remittermobile = $remitter_id;
		$benificiary_account_no = $rslttransaction->row(0)->BeneficiaryId;
		$mobile_no = $remitter_id;
		$mode = $rslttransaction->row(0)->mode;
		$user_id = $rslttransaction->row(0)->user_id;
		$beneficiaryid = $rslttransaction->row(0)->BeneficiaryId;
		$Charge_Amount = $rslttransaction->row(0)->Charge_Amount;
	
		$AccountNumber = $rslttransaction->row(0)->AccountNumber;
		$benificiary_account_no = $AccountNumber;
		$IFSC = $rslttransaction->row(0)->IFSC;
		$amount = $rslttransaction->row(0)->Amount;
		$dist_charge_amount= $rslttransaction->row(0)->dist_charge_amount;
		$postfields = '';
		$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
		if($mode == "IMPS"){$apimode = "2";}
		if($mode == "NEFT"){$apimode = "1";}
		$postparam = $remittermobile." <> ".$beneficiaryid." <> ".$amount." <> ".$mode;
		//echo $postparam;exit;
		if($mode == "NEFT" or $mode == "1")
		{
		    $transtype = "NEFT";
		    $mode = "NEFT";
			$apimode = "1";
		}	
		$buffer = "No Api Call";
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
				$url = '';
				$user_id = $userinfo->row(0)->user_id;
				$DId = $userinfo->row(0)->parentid;
				$MdId = 0;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				
					$parentinfo = $this->db->query("select * from tblusers where user_id = ?",array($DId));
					if($parentinfo->num_rows() == 1)
					{
							$MdId = $parentinfo->row(0)->parentid;
					}
					
					
					$this->db->query("update mt3_transfer set Status = 'PENDING' where Id = ?",array($Id));
					$insert_id = $Id;
					 $timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));

			   		
				        
				        	$this->db->query("update mt3_transfer set API = 'AIRTEL' where Id = ?",array($insert_id));
				        
					        $timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));



	//	echo $benificiary_name;exit;

							
	

		$remitter_id = $rslttransaction->row(0)->RemiterMobile;
		$remittermobile = $remitter_id;
		
		$mobile_no = $remitter_id;
		$mode = $rslttransaction->row(0)->mode;
		$user_id = $rslttransaction->row(0)->user_id;
		$beneficiaryid = $rslttransaction->row(0)->BeneficiaryId;
		$Charge_Amount = $rslttransaction->row(0)->Charge_Amount;
	
		$AccountNumber = $rslttransaction->row(0)->AccountNumber;
		$benificiary_account_no = $AccountNumber;
		$IFSC = $rslttransaction->row(0)->IFSC;
		$amount = $rslttransaction->row(0)->Amount;
		$bank_id = $rslttransaction->row(0)->bank_id;
		$MMW_mode = "IMPS";
		if($mode == "NEFT")
		{
			$MMW_mode = "NEFT";
		}
		
							$sender_mobile_no = $remittermobile;
							$partnerId = "1000011097";
							$customerId =$sender_mobile_no;
							//$feSessionId =$this->generateRandomString();

							$datetime=date("Y-m-d H:i:s");
							$feSessionId =$txnReqId= "MPAY".$insert_id;
							$salt ="RDA2REZCM0UtREI4OS0xMUU5LThBMzQtMkEyQUUyREJDQ0U0";
							$channel ='EXTP';
							$amt = $amount;
							$ifsc =$IFSC;
							$beneAccNo =$benificiary_account_no;
							$beneMobNo=$sender_mobile_no;
							$externalRefNo =$feSessionId;//substr(hash('sha256',mt_rand().microtime()),0,15);
							$hashString = $channel.'#'.$partnerId.'#'.$customerId.'#'.$amount.'#'.$ifsc.'#'.$beneAccNo.'#'.$salt;
							$hash = hash("sha512", $hashString);
							
							$sender_state_code='';
							$sender_dob=$this->get_random_dob();
							$arr_state_code=$this->get_random_state();
							$sender_state_code=intval($arr_state_code['state_code']);
							if($sender_state_code<=9)
							{
							 $sender_state_code='0'.$sender_state_code;	
							}
							$sender_address = trim($arr_state_code['state_name']);
							$sender_address = str_replace("&","AND",$sender_address);
							$sender_state_pincode=intval($arr_state_code['state_pincode']);


							$sender_name = "";
							$lastname = "";
							$pincode = "";
							$sender_info = $this->db->query("SELECT mobile,name,lastname,pincode FROM mt3_remitter_registration where mobile = ? order by Id desc limit 1",array($sender_mobile_no));
							if($sender_info->num_rows() == 1)
							{
								$sender_name = $sender_info->row(0)->name;
								$sender_name = preg_replace('/[^a-z]/i', '', $sender_name);
								$lastname = $sender_info->row(0)->lastname;
								$lastname = preg_replace('/[^a-z]/i', '', $lastname);
								if(trim($lastname)=="")$lastname="Kumar";
								$pincode = $sender_info->row(0)->pincode;
							}
							////////////////////
								$sender_name=$this->get_random_fname();
								$lastname=$this->get_random_lname();
								$pincode=intval($pincode);
								if(strlen($pincode)!=6)
								{
									$pincode = $sender_state_pincode;
								}
							////////////////////	
								$reqarr = array(
									"ver" => "2.0",
									"feSessionId" => $feSessionId,
									"channel" => 'EXTP',
									"apiMode" =>'P',
									"partnerId" =>$partnerId,
									"customerId" =>$sender_mobile_no,
									"amount" =>$amt,
									"bankName" =>"",
									"ifsc" =>$IFSC,
									"beneAccNo" =>$beneAccNo,
									"beneMobNo" =>$sender_mobile_no,
									"externalRefNo" =>$externalRefNo,
									"hash" =>$hash,
									"reference1" =>'ACEa'.$beneMobNo,
									"reference2" =>$sender_mobile_no,
									"custFirstName" =>$sender_name,
									"custLastName" =>$lastname,
									"custPincode" =>$pincode,
									"custAddress" =>$sender_address,
									"custDob" =>$sender_dob,
									"stateCode" =>$sender_state_code
								);
								$req = json_encode($reqarr);
								$url="https://portal.airtelbank.com/RetailerPortal/CHAMPimps";
								$curl = curl_init();
								curl_setopt_array($curl, array(
									CURLOPT_URL => "https://portal.airtelbank.com/RetailerPortal/CHAMPimps",
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 90,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "POST",
									CURLOPT_POSTFIELDS => $req,
									CURLOPT_HTTPHEADER => array(
										"Accept: */*",
										"Cache-Control: no-cache",
										"Connection: keep-alive",
										"Content-Type: application/json",
									),
								));

							$response = curl_exec($curl);
							$res = json_decode($response);
							$err = curl_error($curl);
							curl_close($curl);
							$this->requestlog($insert_id,$req,$response,$remittermobile,$benificiary_account_no,"");
							$this->db->reset_query();
							$this->db->where("Id",$insert_id);
							$this->db->update("mt3_transfer",array("txn_req_id"=>$txnReqId));
							$this->db->reset_query();
							
							
								
							if(isset($res->code))
							{
									
									$data = $res;
									$tid = trim((string)$data->tranId);
									$bank_ref_num = trim((string)$data->externalRefNo);
									$_rrn = trim((string)$data->rrn);
									$recipient_name = trim((string)$data->beneName);
									$message = trim((string)$data->messageText);
									$statuscode = trim((string)$data->rrn);
									$errorCode = trim((string)$res->errorCode);
									
									if($res->code=='0')
									{
											
											$this->update_limit($sender_mobile_no,$amount);
											$data = $res;
											$tid = trim((string)$data->tranId);
											$bank_ref_num = trim((string)$data->externalRefNo);
											$_rrn = trim((string)$data->rrn);
											$recipient_name = trim((string)$data->beneName);
											$message = trim((string)$data->messageText);
											$statuscode = trim((string)$data->rrn);

											$data = array(
														'RESP_statuscode' => "TXN",
														'RESP_status' => $message,
														'RESP_ipay_id' => $tid,
														'RESP_opr_id' => $_rrn,
														'RESP_name' => $recipient_name,
														'Status'=>'SUCCESS',
														'edit_date'=>$this->common->getDate()
												);
												$this->db->where('Id', $insert_id);
												$this->db->update('mt3_transfer', $data);
												
												
												$resp_arr = array(
																	"message"=>"SUCCESS",
																	"status"=>0,
																	"statuscode"=>"TXN",
																	"data"=>array(
																		"tid"=>$tid,
																		"ref_no"=>$bank_ref_num,
																		"opr_id"=>$_rrn,
																		"name"=>$recipient_name,
																		"balance"=>0,
																		"amount"=>$amount,

																	)
																);
												$json_resp =  json_encode($resp_arr);
												
									}
									else if($res->code=='2')
									{
											
											$data = $res;
											$tid = trim((string)$data->tranId);
											$bank_ref_num = trim((string)$data->externalRefNo);
											$_rrn = trim((string)$data->rrn);
											$recipient_name = trim((string)$data->beneName);
											$message = trim((string)$data->messageText);
											$statuscode = trim((string)$data->rrn);

											$data = array(
														'RESP_statuscode' => "TUP",
														'RESP_status' => $message,
														'RESP_ipay_id' => $tid,
														'RESP_opr_id' => $_rrn,
														'RESP_name' => $recipient_name,
														'Status'=>'PENDING',
														'edit_date'=>$this->common->getDate()
												);
												$this->db->where('Id', $insert_id);
												$this->db->update('mt3_transfer', $data);
												
												
												
												$resp_arr = array(
																	"message"=>"Transaction Under Pending Process",
																	"status"=>1,
																	"statuscode"=>"TUP",
																	"data"=>array(
																		"tid"=>$tid,
																		"ref_no"=>$bank_ref_num,
																		"opr_id"=>$_rrn,
																		"name"=>$recipient_name,
																		"balance"=>0,
																		"amount"=>$amount,

																	)
																);
												$json_resp =  json_encode($resp_arr);
												
									}
									
									else
									{

											
											$message="Transaction Under Pending Process";
											
											$resp_arr = array(
																	"message"=>$message,
																	"status"=>0,
																	"statuscode"=>"TUP",
																);
											$json_resp =  json_encode($resp_arr);
												
									}
									
							}
							else
							{
								$message="Transaction Pending";
								
								$resp_arr = array(
													"message"=>$message,
													"status"=>0,
													"statuscode"=>"TUP",
													"data"=>array(
														"tid"=>$insert_id,
														"ref_no"=>$insert_id,
														"opr_id"=>"",
														"name"=>$benificiary_name,									
														"balance"=>"",
														"amount"=>$amount,

													)
												);
								$json_resp =  json_encode($resp_arr);
							}



					    
				    			
										
			}
			else
			{
				$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
			$json_resp =  json_encode($resp_arr);
			
		}
		$this->loging("airtel_hold_resend",$url."?".$postfields,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
    }
    else
    {
        echo "Duplicate Request Found";exit;
    }
    

    	
	
}

	
}

?>