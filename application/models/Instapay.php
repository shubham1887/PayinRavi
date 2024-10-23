<?php
class Instapay extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	private function getLiveUrl($type)
	{	
		if($type == "remitter_details")
		{
				$url = 'https://www.instantpay.in/ws/dmi/remitter_details';
		}
		if($type == "remitter_registration")
		{
				$url = 'https://www.instantpay.in/ws/dmi/remitter';
		}
		if($type == "beneficiary_register")
		{
				$url = 'https://www.instantpay.in/ws/dmi/beneficiary_register';
		}
		if($type == "beneficiary_resend_otp")
		{
				$url = 'https://www.instantpay.in/ws/dmi/beneficiary_resend_otp';
		}
		if($type == "beneficiary_register_validate")
		{
				$url = 'https://www.instantpay.in/ws/dmi/beneficiary_register_validate';
		}
		if($type == "account_validate")
		{
				$url = 'https://www.instantpay.in/ws/imps/account_validate';
		}
		if($type == "beneficiary_remove")
		{
				$url = 'https://www.instantpay.in/ws/dmi/beneficiary_remove';
		}
		if($type == "beneficiary_remove_validate")
		{
				$url = 'https://www.instantpay.in/ws/dmi/beneficiary_remove_validate';
		}
		if($type == "transfer_status")
		{
				$url = 'https://www.instantpay.in/ws/dmi/transfer_status';
		}
		if($type == "transfer")
		{
				$url = 'https://www.instantpay.in/ws/dmi/transfer';
		}
		if($type == "checkwallet")
		{
				$url = 'https://www.instantpay.in/ws/api/checkwallet';
		}
		if($type == "bank_details")
		{
				$url = 'https://www.instantpay.in/ws/dmi/bank_details';
		}
		
		
		return $url;
	}
	private function getToken()
	{
		//return "b8667c567e89e7e8c8956862290ed78d";
		//return "9ecf9d8d1d7d5438f436b247a101e267";
		return "45a145c8bff9191c64d73d75ebf591b1";
	}
	private function getOutletId()
	{
		return 7297;
	}
	
	public function bank_details($accountno,$userinfo,$ifsc)
	{
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
				$ifsc_f = substr($ifsc,0,4);
				
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "Agent" or $usertype_name == "APIUSER")
				{
					if($user_status == '1')
					{
							$postparam = '{"token": "'.$this->getToken().'","request": {"account": "'.$accountno.'"}}';
		
							$headers = array();
							$headers[] = 'Accept: application/json';
							$headers[] = 'Content-Type: application/json';
							
							$ch = curl_init();
							curl_setopt($ch,CURLOPT_URL,$this->getLiveUrl("bank_details"));
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
							curl_setopt($ch, CURLOPT_POST,1);
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
							curl_setopt($ch, CURLOPT_POSTFIELDS, $postparam);
							$buffer = curl_exec($ch);
							curl_close($ch);
							
							//echo $buffer;exit;
							$json_obj = json_decode($buffer);
						//echo "URL :: ".$this->getLiveUrl("bank_details");
					//	echo "<br>";
					//	echo "POST PARAMS :: ".$postparam;
						//echo "<br>";
						//echo "Response :: ".$buffer;exit;
						
							if(isset($json_obj->statuscode) and isset($json_obj->status))
							{
									$statuscode = $json_obj->statuscode;
									$status = $json_obj->status;
								
									if($statuscode == "TXN")
									{
										
										$data = $json_obj->data;
										//print_r($data);exit;
											$active = true;
											foreach($data as $rw)
											{
												$id = $rw->id;
												$bank_name = $rw->bank_name;
												$imps_enabled = $rw->imps_enabled;
												$bank_sort_name = $rw->bank_sort_name;
												$branch_ifsc = $rw->branch_ifsc;
												$ifsc_alias = trim((string)$rw->ifsc_alias);
												$is_down = trim((string)$rw->is_down);
												if($ifsc_alias == $ifsc_f)
												{
													if($is_down  == "1")
													{
														$active = false;
													}
													else
													{
														$active = true;
													}
													break;
												}
												
											}
										return $active;
											
										
										
									}
									else
									{
										$resp_arr = array(
																	"message"=>$status,
																	"status"=>1,
																	"statuscode"=>$statuscode,
																);
											$json_resp =  json_encode($resp_arr);
									}
							}
							else
							{
								$resp_arr = array(
										"message"=>"Internal Server Error, Please Try Later",
										"status"=>10,
										"statuscode"=>"UNK",
									);
								$json_resp =  json_encode($resp_arr);
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
		$this->loging("remitter_details",$postparam,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}
	
	public function balance()
	{
		
		$postparam = '{"token": "'.$this->getToken().'"}';

		$headers = array();
		$headers[] = 'Accept: application/json';
		$headers[] = 'Content-Type: application/json';

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$this->getLiveUrl("checkwallet"));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postparam);
		$buffer = curl_exec($ch);
		curl_close($ch);
							
							//echo $buffer;exit;
		$json_obj = json_decode($buffer);
		if(isset($json_obj->Wallet) )
		{
			$Wallet = $json_obj->Wallet;
		}
		else
		{
			$Wallet =  "";
		}

		
		$this->loging("checkwallet",$postparam,$buffer,$Wallet,"Admin");
		return $Wallet;
		
	}
	
	
	
	
	public function gethoursbetweentwodates($fromdate,$todate)
	{
		 $now_date = strtotime (date ($todate)); // the current date 
		$key_date = strtotime (date ($fromdate));
		$diff = $now_date - $key_date;
		return round(abs($diff) / 60,2);
	}
	
	

	public function getTransactionChargeInfo($userinfo,$TransactionAmount)
	{
			return 5.00;
	}
	
	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////                  ///////////////////////////////////////////////////
//////////////////////////////////////////    L O G I N G   ////////////////////////////////////////////////////
/////////////////////////////////////////                  /////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
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

////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//*************************************** L O G I N G    E N D   H E R E *************************************//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////







////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////// bill payments api
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	
	
	
	public function getservice($mcode)
	{
	   // $mcode = "TYE";
	    $headers = array();
		$headers[] = 'Accept: application/json';
		$headers[] = 'Content-Type: application/json';
        $url = 'https://www.instantpay.in/ws/userresources/bbps_biller';
        $request_array = array();
        
        $mainreq_array["token"]=$this->getToken();
        
        $request_array = array(
            "sp_key"=>$mcode);
        
        $mainreq_array["request"] = $request_array;
        
       // echo json_encode($mainreq_array);
       
        
      
       
       
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mainreq_array));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		
		$buffer = curl_exec($ch);
		curl_close($ch);
        $resparray = json_decode($buffer);
        $dataarray = $resparray->data[0];
       $paramsarray = json_decode($dataarray->params);
       //print_r($paramsarray );exit;
        $resparray = array();
       foreach($paramsarray as $paramas)
       {
          array_push($resparray,$paramas->name);
       }
	    return $resparray;
	    
	}
	public function recharge_transaction_validate2($userinfo,$spkey,$company_id,$Amount,$Mobile,$CustomerMobile,$option1 = "")
	{
		
		
		if($spkey == "TYE")
		{
		   $option1 = "Ahmedabad"; 
		}
		if($spkey == "TZE")
		{
		   $option1 = "Agra"; 
		}
		if($spkey == "TXE")
		{
		   $option1 = "Bhiwandi"; 
		}
		if($spkey == "TWE")
		{
		   $option1 = "Surat"; 
		}
		
		
		
		/*$resp_arr = array(
									"message"=>$option1,
									"status"=>5,
									"statuscode"=>"UNK",
								);
						$json_resp =  json_encode($resp_arr);
						echo $json_resp;exit;*/
		/*
		{"statuscode":"TXN","status":"Transaction Successful","data":{"dueamount":"140.00","duedate":"04-02-2019","customername":"NISHAT","billnumber":"055440619012212","billdate":"22-01-2019","billperiod":"NA","billdetails":[],"customerparamsdetails":[{"Name":"CA Number","Value":"103761766"}],"additionaldetails":[],"reference_id":46731}}
		*/
		$ipaddress = $this->common->getRealIpAddr();
		$payment_mode = "CASH";
		$payment_channel = "AGT";
		$url= '';
		$buffer = '';
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
				
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "Agent" or $usertype_name == "APIUSER")
				{
					if($user_status == '1')
					{
						
							$insert_rslt = $this->db->query("insert into tblbillcheck(add_date,ipaddress,user_id,mobile,customer_mobile,company_id) values(?,?,?,?,?,?)",array($this->common->getDate(),$ipaddress,$user_id,$Mobile,$CustomerMobile,$company_id));
							if($insert_rslt == true)
							{
								$insert_id = $this->db->insert_id();
								$transaction_type = "BILL";
								$dr_amount = $Amount;
								$Description = "Service No.  ".$Mobile." Bill Amount : ".$Amount;
								$sub_txn_type = "BILL";
								$remark = "Bill PAYMENT";
								$Charge_Amount = 0.00;
								
								
									$headers = array();
									$headers[] = 'Accept: application/json';
									$headers[] = 'Content-Type: application/json';

									
									$temp_customer_arams = array();
									$main_customer_params = array();
									$params = $this->getservice($spkey);
									$this->loging("RECHARGE_VALIDATE",$url." ?".json_encode($params),"","",$userinfo->row(0)->username);
									//print_r($params);exit;
									foreach($params as $p)
									{
										if($p == "Account Number" or $p =="Contract Number")
										{
											array_push($main_customer_params ,$Mobile);
											 $temp_customer_arams = array(
												 $service_number
												 );
										}
										if($p == "Telephone Number"  or $p == "Landline Number with STD code" or $p == "Number with STD Code (without 0)" or $p == "Subdivision Code")
										{
											array_push($main_customer_params ,$option1);
											 $temp_customer_arams = array(
												 $service_number
												 );
										}
										
										
										if($p == "Service Number" or $p == "ACCOUNTNO"  or $p == "CA Number" or $p == "K Number" or $p == "RR Number"  or $p == "K No" or $p == "Consumer No" or $p == "Consumer Number" or $p == "Service Connection Number" or $p == "Consumer number" or $p == "BP Number" or $p =="Consumer ID" or preg_match('/Customer ID/',$p) or preg_match('/Account ID/',$p))
										{
										    //Account ID (RAPDRP) OR Consumer Number \/ Connection ID (Non-RAPDRP)
											 $temp_customer_arams = array(
												 $service_number
												 );
												 array_push($main_customer_params ,$Mobile);
										}

										if($p == "Mobile Number")
										{
											 $temp_customer_arams = array(
												$mobile_number
												 );
												 array_push($main_customer_params ,$CustomerMobile);
										}
										if($p == "City")
										{
											 $temp_customer_arams = array(
												$option1
												 );
												  array_push($main_customer_params ,$option1);
										}
										if($p == "BU")
										{
											 $temp_customer_arams = array(
												$city
												 );
												  array_push($main_customer_params ,$option1);
										}


									}
								
								
							//	print_r($main_customer_params);exit;
								
									
									$url = 'https://www.instantpay.in/ws/bbps/bill_fetch';
									$request_array = array();
        							$mainreq_array["token"]=$this->getToken();

									$request_array = array(
										"sp_key"=>$spkey,
										"agentid"=>$insert_id,
										"customer_mobile"=>$CustomerMobile,
										"customer_params"=>$main_customer_params,
										"init_channel"=>"AGT",
										"endpoint_ip"=>$this->common->getRealIpAddr(),
										"mac"=>"BC-EE-7B-9C-F6-C0",
										"payment_mode"=>"Cash",
										"payment_info"=>"bill",
										"amount"=>"10",
										"reference_id"=>"",
										"latlong"=>"24.1568,78.5263",
										"outletid"=>$this->getOutletId(),
										);

									$mainreq_array["request"] = $request_array;
								//print_r($mainreq_array);exit;
								$ch = curl_init();
								curl_setopt($ch,CURLOPT_URL,$url);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
								curl_setopt($ch, CURLOPT_POST,1);
								curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mainreq_array));
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
								curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

								$buffer = curl_exec($ch);
								curl_close($ch);
								
								$json_resp =  $buffer;
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
		$this->loging("RECHARGE_VALIDATE",$url." ?".json_encode($request_array),$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}
	public function recharge_transaction2($userinfo,$spkey,$company_id,$Amount,$Mobile,$CustomerMobile,$remark,$option1,$particulars,$option2="",$option3="",$done_by = "WEB")
	{

		$params = $userinfo->row(0)->user_id." ".$spkey." ".$company_id." ".$Amount." ".$Mobile." ".$CustomerMobile." ".$remark." Pending ".$option1." ".json_encode($particulars);
            							$this->loging("RECHARGE","step0",$Mobile,$params,$userinfo->row(0)->username);



	    $api_name = "";
	    $company_info = $this->db->query("select a.company_id,a.company_name from tblcompany a where a.company_id = ?",array($company_id));
	  
	   
	   
	    if(true)
	    {
	        $this->loging("RECHARGE","step2",$Mobile,"",$userinfo->row(0)->username);
	        if($this->bill_checkduplicate($userinfo->row(0)->user_id,$Mobile,$Amount) == false)
        	{
        	    $resp_arr = array(
								"message"=>"Please Try Later",
								"status"=>1,
								"statuscode"=>"ERR",
							);
			    $json_resp =  json_encode($resp_arr);
			    	$this->loging("RECHARGE","","",$json_resp,$userinfo->row(0)->username);
        		return $json_resp;   
        	}
        	else
        	{
        	    $this->loging("RECHARGE","step3",$Mobile,"",$userinfo->row(0)->username);
        	    $rsltcheck = $this->db->query("SELECT Id FROM `tblbills`  where service_no = ? and user_id = ? and status != 'Failure' and Date(add_date) = ?
ORDER BY `tblbills`.`Id`  DESC",array($Mobile,$userinfo->row(0)->user_id,$this->common->getMySqlDate()));
                if($rsltcheck->num_rows() == 1)
                {
                    $resp_arr = array(
								"message"=>"Duplicate Request Found.",
								"status"=>1,
								"statuscode"=>"ERR",
							);
			        $json_resp =  json_encode($resp_arr);
                }
                else
                {
                    $this->loging("RECHARGE","step4",$Mobile,"",$userinfo->row(0)->username);
                    $Amount = intval($Amount);
            		$ipaddress = $this->common->getRealIpAddr();
            		$payment_mode = "CASH";
            		$payment_channel = "AGT";
            		
            		if($spkey == "TPE" )
            		{
            			$payment_mode = "";
            			$payment_channel = "";
            		}
            		$url= '';
            		$buffer = '';
            		if($userinfo != NULL)
            		{
            		    $this->loging("RECHARGE","step5",$Mobile,"",$userinfo->row(0)->username);
            			if($userinfo->num_rows() == 1)
            			{
            				
            				$user_id = $userinfo->row(0)->user_id;
            				$usertype_name = $userinfo->row(0)->usertype_name;
            				$user_status = $userinfo->row(0)->status;
            				if($usertype_name == "Agent" or $usertype_name == "APIUSER")
            				{
            					if($user_status == '1')
            					{
            						 $this->loging("RECHARGE","step6",$Mobile,"",$userinfo->row(0)->username);
            						/*
            						
            		{"statuscode":"TXN","status":"Transaction Successful","data":{"dueamount":"140.00","duedate":"04-02-2019","customername":"NISHAT","billnumber":"055440619012212","billdate":"22-01-2019","billperiod":"NA","billdetails":[],"customerparamsdetails":[{"Name":"CA Number","Value":"103761766"}],"additionaldetails":[],"reference_id":46731}}
            		*/
            						
            						$crntBalance = $this->Common_methods->getAgentBalance($user_id);
            						if(floatval($crntBalance) >= floatval($Amount))
            						{
            						    
            								$dueamount = "";
            								$duedate = "";
            								$billnumber = "";
            								$billdate = "";
            								$billperiod = "";
            								$custname = "";
            							//print_r($particulars);exit;
            							if($particulars != false)
            							{
            								$custname = $particulars->customername;
            								$dueamount = $particulars->dueamount;
            								$duedate = $particulars->duedate;
            								$billnumber = $particulars->billnumber;
            								$billdate = $particulars->billdate;
            								$billperiod = $particulars->billperiod;
            								$insta_ref = $particulars->reference_id;
            							}
            							$params = $user_id." ".$Mobile." ".$CustomerMobile." ".$company_id." ".$Amount." ".$payment_mode." ".$payment_channel." Pending ".$custname." ".$dueamount." ".$duedate." ".$billnumber." ".$billdate." ".$billperiod." ".$option1." ".$done_by;
            							$this->loging("RECHARGE","step7",$Mobile,$params,$userinfo->row(0)->username);
            							$insert_rslt = $this->db->query("insert into tblbills(add_date,ipaddress,user_id,service_no,customer_mobile,company_id,bill_amount,paymentmode,payment_channel,status,customer_name,dueamount,duedate,billnumber,billdate,billperiod,option1,done_by)
            							values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
            							array($this->common->getDate(),$ipaddress,$user_id,$Mobile,$CustomerMobile,$company_id,$Amount,$payment_mode,$payment_channel,"Pending",$custname,$dueamount,$duedate,$billnumber,$billdate,$billperiod,$option1,$done_by));
            							if($insert_rslt == true)
            							{
            								$this->loging("RECHARGE","step8",$Mobile,$params,$userinfo->row(0)->username);
            								$insert_id = $this->db->insert_id();
            								$transaction_type = "BILL";
            								
            								if($Amount >= 100000)
            								{
	                                            $Charge_Amount =0.0;
            								}
            								else
            								{
            								    $Charge_Amount = (($Amount * 0.15)/100);
            								}
            								
            							
            								$dr_amount = $Amount - $Charge_Amount;
            								$Description = "Service No.  ".$Mobile." Bill Amount : ".$Amount;
            								$sub_txn_type = "BILL";
            								$remark = "Bill PAYMENT";
            								$Charge_Amount = $Charge_Amount;
            								$paymentdebited = $this->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
            								if($paymentdebited == true)
            								{
            								    $otoamount = 2000;
            								    $rsltcommon_otoamt = $this->db->query("select * from common where param = 'BILLAMT_OTOMAX'");
            								    if($rsltcommon_otoamt->num_rows() == 1)
            								    {
            								        $otoamount = $rsltcommon_otoamt->row(0)->value;
            								    }
            								    $dohold = 'no';
											    $rsltcommon = $this->db->query("select * from common where param = 'BILLHOLD'");
											    if($rsltcommon->num_rows() == 1)
											    {
											        $is_hold = $rsltcommon->row(0)->value;
											    	if($is_hold == 1)
											    	{
											    	    $dohold = 'yes';
											    	}
											    }
											    if($api_name == "AUTOWOT" and $Amount <= $otoamount)
												{
													
													
													$url = 'http://172.107.175.226:1273/trx?product='.$spkey.'&qty='.$Amount.'&dest='.$Mobile.'&refID='.$insert_id.'&memberID=0007&pin=1234&password=123456';
					                                $response = $this->common->callurl($url);
                                					
													
													$resp_arr = array(
																			"message"=>"Bill Request Submitted Successfully",
																			"status"=>0,
																			"statuscode"=>"TUP",
																			"data"=>array(

																				"ipay_id"=>"",
																				"opr_id"=>"",
																				"status"=>"Pending",
																				"res_msg"=>"Bill Request Submitted Successfully",
																			)
																		);
													$json_resp =  json_encode($resp_arr);	
													$this->loging("RECHARGE",$url,$response,$json_resp,$userinfo->row(0)->username);
												}
											    else if($dohold == 'yes')
												{
													
													$resp_arr = array(
																			"message"=>"Bill Request Submitted Successfully",
																			"status"=>0,
																			"statuscode"=>"TUP",
																			"data"=>array(

																				"ipay_id"=>"",
																				"opr_id"=>"",
																				"status"=>"Pending",
																				"res_msg"=>"Bill Request Submitted Successfully",
																			)
																		);
													$json_resp =  json_encode($resp_arr);	
												}
            								    else
            								    {
            								        	$headers = array();
                    									$headers[] = 'Accept: application/json';
                    									$headers[] = 'Content-Type: application/json';
                    
            											$temp_customer_arams = array();
            											$main_customer_params = array();
            											$params = $this->getservice($spkey);
            											//print_r($params);exit;
            											foreach($params as $p)
            											{
            												if($p == "Account Number" or $p =="Contract Number")
            												{
            													array_push($main_customer_params ,$Mobile);
            													 $temp_customer_arams = array(
            														 $service_number
            														 );
            												}
            												if($p == "Service Number" or $p == "ACCOUNTNO"  or $p == "CA Number" or $p == "K Number" or $p == "Consumer No" or $p == "Consumer Number")
            												{
            													 $temp_customer_arams = array(
            														 $service_number
            														 );
            														 array_push($main_customer_params ,$Mobile);
            												}
            
            												if($p == "Mobile Number")
            												{
            													 $temp_customer_arams = array(
            														$mobile_number
            														 );
            														 array_push($main_customer_params ,$CustomerMobile);
            												}
            												if($p == "City")
            												{
            													 $temp_customer_arams = array(
            														$city
            														 );
            														  array_push($main_customer_params ,$option1);
            												}
            												if($p == "BU")
            												{
            													 $temp_customer_arams = array(
            														$city
            														 );
            														  array_push($main_customer_params ,$option1);
            												}
            
            
            											}
            
            
            
                                                        sleep(3);
            
            											$url = 'https://www.instantpay.in/ws/bbps/bill_pay';
            											$request_array = array();
            											$mainreq_array["token"]=$this->getToken();
            
            											$request_array = array(
            												"sp_key"=>$spkey,
            												"agentid"=>$insert_id,
            												"customer_mobile"=>$CustomerMobile,
            												"customer_params"=>$main_customer_params,
            												"init_channel"=>"AGT",
            												"endpoint_ip"=>$this->common->getRealIpAddr(),
            												"mac"=>"BC-EE-7B-9C-F6-C0",
            												"payment_mode"=>"Cash",
            												"payment_info"=>"bill",
            												"amount"=>$Amount,
            												"reference_id"=>$insta_ref,
            												"latlong"=>"24.1568,78.5263",
            												"outletid"=>$this->getOutletId(),
            												);
            
            											$mainreq_array["request"] = $request_array;
            											//print_r($mainreq_array);exit;
            											$ch = curl_init();
            											curl_setopt($ch,CURLOPT_URL,$url);
            											curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            											curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            											curl_setopt($ch, CURLOPT_POST,1);
            											curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mainreq_array));
            											curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            											curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            
            											$buffer = curl_exec($ch);
            											curl_close($ch);
            
            											$json_resp =  $buffer;
            											
            											
            											$this->loging("RECHARGE",$url." ? ".json_encode($mainreq_array),$buffer,"",$userinfo->row(0)->username);
            										
            									//	$this->loging("RECHARGE",$url,$json_resp,json_encode($request_array),$userinfo->row(0)->username);
            										
            											
                    									/*
                    									{"ipay_id":"1180518152856NUHHQ","agent_id":"1235","opr_id":"1805181529230004","account_no":"8238232303","sp_key":"VFP","trans_amt":10,"charged_amt":9.93,"opening_bal":"18066.10","datetime":"2018-05-18 15:29:14","status":"SUCCESS","res_code":"TXN","res_msg":"Transaction Successful"}
            											
            											
            											new response 
            											{"statuscode":"TXN","status":"Transaction Successful",
            											"data":{
            												"ipay_id":"1190122152826GSQYX",
            												"agent_id":"14",
            												"opr_id":"TJ0100953330",
            												"account_no":"103761766",
            												"sp_key":"BYE",
            												"trans_amt":"140",
            												"charged_amt":139.05,
            												"opening_bal":"23927.70",
            												"datetime":"2019-01-22 15:28:28",
            												"status":"SUCCESS"
            											}}
            											
                    									*/
                    									$json_obj = json_decode($buffer);
                    									if(isset($json_obj->ipay_errorcode) and isset($json_obj->ipay_errordesc))
                    									{
                    											$ipay_errorcode = $json_obj->ipay_errorcode;
                    											$ipay_errordesc = $json_obj->ipay_errordesc;
                    											if($ipay_errorcode == "DTX")
                    											{
                    												$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
                    												
                    												$this->db->query("update tblbills set status = 'Failure',resp_status=?,res_code=?,res_msg=? where Id = ?",array("FAILURE",$ipay_errorcode,$ipay_errordesc,$insert_id));
                    												
                    													$resp_arr = array(
                    																			"message"=>"Duplicate Transaction",
                    																			"status"=>1,
                    																			"statuscode"=>"DTX",
                    																		);
                    													$json_resp =  json_encode($resp_arr);
                    											}
                    											if($ipay_errorcode == "SPD")
                    											{
                    												$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
                    												
                    												$this->db->query("update tblbills set status = 'Failure',resp_status=?,res_code=?,res_msg=? where Id = ?",array("FAILURE",$ipay_errorcode,$ipay_errordesc,$insert_id));
                    													$resp_arr = array(
                    																			"message"=>"Service Provider Downtime",
                    																			"status"=>1,
                    																			"statuscode"=>"DTX",
                    																		);
                    													$json_resp =  json_encode($resp_arr);
                    											}
                    
                    											else
                    											{
                    												$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
                    												
                    												$this->db->query("update tblbills set status = 'Failure',resp_status=?,res_code=?,res_msg=? where Id = ?",array("FAILURE",$ipay_errorcode,$ipay_errordesc,$insert_id));
                    												
                    												$resp_arr = array(
                    																			"message"=>$ipay_errordesc,
                    																			"status"=>1,
                    																			"statuscode"=>$ipay_errorcode,
                    																		);
                    													$json_resp =  json_encode($resp_arr);
                    											}
                    
                    									}
                    									else if(isset($json_obj->statuscode) and isset($json_obj->status))
                    									{
            													$statuscode = trim((string)$json_obj->statuscode);
            													$status = trim((string)$json_obj->status);
            												
            													if($statuscode == "TXN")
            													{
            														$data = $json_obj->data;
            														$ipay_id = $data->ipay_id;
            														$agent_id = $data->agent_id;
            														$opr_id = $data->opr_id;
            														$sp_key = $data->sp_key;
            														$trans_amt = $data->trans_amt;
            														$charged_amt = $data->charged_amt;
            														$opening_bal = $data->opening_bal;
            														$datetime = $data->datetime;
            														$status = $data->status;
            														if($status == "SUCCESS")
            														{
            															$this->db->query("update tblbills set status = 'Success',ipay_id = ?,opr_id=?,trans_amt=?,charged_amt=?,opening_bal=?,datetime=?,resp_status=?,res_code=?,res_msg=? where Id = ?",array($ipay_id,$opr_id,$trans_amt,$charged_amt,$opening_bal,$datetime,$status,$statuscode,$status,$insert_id));
            
            														}
            														else
            														{
            															$this->db->query("update tblbills set ipay_id = ?,opr_id=?,trans_amt=?,charged_amt=?,opening_bal=?,datetime=?,resp_status=?,res_code=?,res_msg=? where Id = ?",array($ipay_id,$opr_id,$trans_amt,$charged_amt,$opening_bal,$datetime,$status,$statuscode,$status,$insert_id));
            
            														}
            
            
            															$resp_arr = array(
            																					"message"=>$status,
            																					"status"=>0,
            																					"statuscode"=>$statuscode,
            																					"data"=>array(
            
            																						"ipay_id"=>$ipay_id,
            																						"opr_id"=>$opr_id,
            																						"status"=>$status,
            																						"res_msg"=>$status,
            																					)
            																				);
            															$json_resp =  json_encode($resp_arr);	
            													}
            													else if($statuscode == "TUP")
            													{
            														$data = $json_obj->data;
            														$ipay_id = $data->ipay_id;
            														$agent_id = $data->agent_id;
            														$opr_id = $data->opr_id;
            														$sp_key = $data->sp_key;
            														$trans_amt = $data->trans_amt;
            														$charged_amt = $data->charged_amt;
            														$opening_bal = $data->opening_bal;
            														$datetime = $data->datetime;
            														$status = $data->status;
            														
            															$this->db->query("update tblbills set status = 'Pending',ipay_id = ?,opr_id=?,trans_amt=?,charged_amt=?,opening_bal=?,datetime=?,resp_status=?,res_code=?,res_msg=? where Id = ?",array($ipay_id,$opr_id,$trans_amt,$charged_amt,$opening_bal,$datetime,$status,$statuscode,$status,$insert_id));
            
            														
            
            
            															$resp_arr = array(
            																		"message"=>$status,
            																		"status"=>0,
            																		"statuscode"=>$statuscode,
            																		"data"=>array(
            
            																			"ipay_id"=>$ipay_id,
            																			"opr_id"=>$opr_id,
            																			"status"=>$status,
            																			"res_msg"=>$status,
            																		)
            																	);
            															$json_resp =  json_encode($resp_arr);	
            													}
            													else if($statuscode == "IRA" or $statuscode == "UAD" or $statuscode == "IAC"  or $statuscode == "IAT"  or $statuscode == "AAB" or $statuscode == "ISP"  or $statuscode == "DID"  or $statuscode == "SPD" )
            													{
                    												$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
                    												
                    												$this->db->query("update tblbills set status = 'Failure',resp_status=?,res_code=?,res_msg=? where Id = ?",array("FAILURE",$statuscode,$status,$insert_id));
                    												
                    												$resp_arr = array(
                    																			"message"=>$status,
                    																			"status"=>1,
                    																			"statuscode"=>$statuscode,
                    																		);
                    													$json_resp =  json_encode($resp_arr);
                    											}
            													else if($statuscode == "IAB" )
            													{
                    												$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
                    												
            														$status = "Internal Server Error";
            														$statuscode = "ERR";
                    												$this->db->query("update tblbills set status = 'Failure',resp_status=?,res_code=?,res_msg=? where Id = ?",array("FAILURE",$statuscode,$status,$insert_id));
                    												
                    												$resp_arr = array(
                    																			"message"=>$status,
                    																			"status"=>1,
                    																			"statuscode"=>$statuscode,
                    																		);
                    													$json_resp =  json_encode($resp_arr);
                    											}
                        
                        
                        									}
                        									else 
                        									{
                        										$resp_arr = array(
                        												"message"=>"Some Error Occure",
                        												"status"=>10,
                        												"statuscode"=>"UNK",
                        											);
                        										$json_resp =  json_encode($resp_arr);
                        									}
            								    }
            								    
            								
            								}
            								else
            								{
            									$resp_arr = array(
            									"message"=>"Payment Error. Please Try Again",
            									"status"=>1,
            									"statuscode"=>"ERR",
            								);
            								$json_resp =  json_encode($resp_arr);
            								}
            							}
            						}
            						else
            						{
            							$resp_arr = array(
            									"message"=>"InSufficient Balance",
            									"status"=>1,
            									"statuscode"=>"ISB",
            								);
            							$json_resp =  json_encode($resp_arr);
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
                }
        		$this->loging("RECHARGE",$url,$buffer,$json_resp,$userinfo->row(0)->username);
        		return $json_resp;   
        	}    
	    }
	    
		
	}
	
	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	
	
	
	public function recharge_transaction_postpaid($userinfo,$spkey,$company_id,$Amount,$Mobile,$recharge_id)
	{
		$remark = "Bill Payment";
		$ipaddress = $this->common->getRealIpAddr();
		$payment_mode = "CASH";
		$payment_channel = "AGT";
		$url= '';
		$buffer = '';
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
				
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "Agent" or $usertype_name == "APIUSER")
				{
					if($user_status == '1')
					{
						
						$headers = array();
						$headers[] = 'Accept: application/json';
						$headers[] = 'Content-Type: application/json';


						$url = 'https://www.instantpay.in/ws/api/transaction?format=json&token='.$this->getToken().'&spkey='.$spkey.'&agentid='.$recharge_id.'&amount='.$Amount.'&account='.$Mobile.'&customermobile='.$Mobile;

						$ch = curl_init();
						curl_setopt($ch,CURLOPT_URL,$url);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($ch, CURLOPT_POST,0);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
						$buffer = curl_exec($ch);
						curl_close($ch);
						/*
						{"ipay_id":"1180518152856NUHHQ","agent_id":"1235","opr_id":"1805181529230004","account_no":"8238232303","sp_key":"VFP","trans_amt":10,"charged_amt":9.93,"opening_bal":"18066.10","datetime":"2018-05-18 15:29:14","status":"SUCCESS","res_code":"TXN","res_msg":"Transaction Successful"}
						*/
						$json_obj = json_decode($buffer);
						if(isset($json_obj->ipay_errorcode) and isset($json_obj->ipay_errordesc))
						{
								$ipay_errorcode = $json_obj->ipay_errorcode;
								$ipay_errordesc = $json_obj->ipay_errordesc;
								if($ipay_errorcode == "DTX")
								{
									$resp_arr = array(
																"message"=>"Duplicate Transaction",
																"status"=>1,
																"statuscode"=>"DTX",
															);
										$json_resp =  json_encode($resp_arr);
								}
								if($ipay_errorcode == "SPD")
								{

										$resp_arr = array(
																"message"=>"Service Provider Downtime",
																"status"=>1,
																"statuscode"=>"DTX",
															);
										$json_resp =  json_encode($resp_arr);
								}

								else
								{


										$resp_arr = array(
																"message"=>$ipay_errordesc,
																"status"=>1,
																"statuscode"=>$ipay_errorcode,
															);
										$json_resp =  json_encode($resp_arr);
								}

						}
						else if(isset($json_obj->ipay_id) and isset($json_obj->agent_id) and isset($json_obj->opr_id) and isset($json_obj->status) and isset($json_obj->res_msg))
						{
								$ipay_id = $json_obj->ipay_id;
								$agent_id = $json_obj->agent_id;
								$opr_id = $json_obj->opr_id;
								$status = $json_obj->status;
								$res_msg = $json_obj->res_msg;
								$res_code = $json_obj->res_code;

								$trans_amt = "";
								$charged_amt = "";
								$opening_bal = "";
								$datetime = "";

								$resp_arr = array(
														"message"=>$res_msg,
														"status"=>0,
														"statuscode"=>$status,
														"data"=>array(
															"ipay_id"=>$ipay_id,
															"opr_id"=>$opr_id,
															"status"=>$status,
															"res_msg"=>$res_msg,
														)
													);
								$json_resp =  json_encode($resp_arr);


						}
						else 
						{
							$resp_arr = array(
									"message"=>"Some Error Occure",
									"status"=>10,
									"statuscode"=>"UNK",
								);
							$json_resp =  json_encode($resp_arr);
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
		$this->loging("RECHARGENORMAL",$url,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
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
	
	public function PAYMENT_DEBIT_ENTRY($user_id,$transaction_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$chargeAmount = 0.00,$userinfo = false)
	{
		



		if($userinfo != false)
		{
			
			$this->load->library("common");
			$add_date = $this->common->getDate();
			$date = $this->common->getMySqlDate();
			$ip = $this->common->getRealIpAddr();
			$old_balance = $this->Common_methods->getAgentBalance($user_id);
			$current_balance = $old_balance - $dr_amount;
			
			$tds = 0.00;
			$stax = 0.00;
			if($transaction_type == "BILL")
			{
				$str_query = "insert into  tblewallet(user_id,recharge_id,transaction_type,debit_amount,balance,description,add_date,ipaddress,tds,serviceTax,remark)

				values(?,?,?,?,?,?,?,?,?,?,?)";
				$reslut = $this->db->query($str_query,array($user_id,$transaction_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip,$tds,$stax,$remark));
				
				if($reslut == true)
				{
						$ewallet_id = $this->db->insert_id();
					
						$rslt_updtrec = $this->db->query("update tblbills set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),debit_amount = ? where Id = ?",array($current_balance,$ewallet_id,$dr_amount,$transaction_id));
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
	public function PAYMENT_CREDIT_ENTRY($user_id,$transaction_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$chargeAmount = 0.00,$userinfo = false)
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
    		$old_balance = $this->Common_methods->getAgentBalance($user_id);
    		$current_balance = $old_balance + $dr_amount;
    		$tds = 0.00;
    		$stax = 0.00;
    		if($transaction_type == "DMR")
    		{
    			$remark = "Money Remittance Reverse";
    			$str_query = "insert into  tblewallet(user_id,dmr_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,tds,serviceTax,remark)
    
    			values(?,?,?,?,?,?,?,?,?,?,?)";
    			$reslut = $this->db->query($str_query,array($user_id,$transaction_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip,$tds,$stax,$remark));
    			if($reslut == true)
    			{
    					$ewallet_id = $this->db->insert_id();
    					if($ewallet_id > 100)
    					{
    						if($sub_txn_type == "Account_Validation")
    						{
    									$rslt_updtrec = $this->db->query("update mt3_account_validate set reverted='yes',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),credit_amount = ? where Id = ?",array($current_balance,$ewallet_id,$dr_amount,$transaction_id));
    									return true;
    						}
    						else if($sub_txn_type == "REMITTANCE")
    						{
    									$current_balance2 = $current_balance + $chargeAmount;
    									$remark = "Transaction Charge Reverse";
    									$str_query_charge = "insert into  tblewallet(user_id,dmr_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,tds,serviceTax,remark)
    
    									values(?,?,?,?,?,?,?,?,?,?,?)";
    									$reslut2 = $this->db->query($str_query_charge,array($user_id,$transaction_id,$transaction_type,$chargeAmount,$current_balance2,$Description,$add_date,$ip,$tds,$stax,$remark));
    									if($reslut2 == true)
    									{
    										$totaldebit_amount = $dr_amount + $chargeAmount;
    										$ewallet_id2 = $ewallet_id.",".$this->db->insert_id();
    										$rslt_updtrec = $this->db->query("update mt3_transfer set reverted='yes',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),credit_amount = ? where Id = ?",array($current_balance2,$ewallet_id2,$totaldebit_amount,$transaction_id));	
    										
    										
    										///////////////////////////////////////////////////////////////////
    										///////// TRANSACTION CHARGE OR COMMISSION ENTRY FOR DISTRIBUTOR
    										////////////////////////////////////////////////////////////////
    
    									/*	if($userinfo->row(0)->usertype_name == 'Agent')
    										{
    											$dmrinfo = $this->db->query("
    											select 
    												a.Id,
    												a.user_id,
    												a.DId,
    												a.MdId,
    												a.dist_charge_type,
    												a.dist_charge_value,
    												a.dist_charge_amount,
    												a.Amount,
    												a.AccountNumber,
    												a.IFSC from mt3_transfer a
    												where a.Id = ?
    											",array($transaction_id));
    											if($dmrinfo->num_rows() == 1)
    											{
    												$DId = $dmrinfo->row(0)->DId;
    												$dist_charge_type = $dmrinfo->row(0)->dist_charge_type;
    												$dist_charge_value = $dmrinfo->row(0)->dist_charge_value;
    												$dist_charge_amount = $dmrinfo->row(0)->dist_charge_amount;
    
    												$dist_old_balance = $this->Common_methods->getAgentBalance($DId);
    												$dist_current_balance = $dist_old_balance + $dist_charge_amount;
    												$dist_remark = "Revert Transaction Charge Done By :".$userinfo->row(0)->businessname."[".$userinfo->row(0)->username."]";
    												if($dist_charge_amount != 0)
    												{
    													$str_query_charge = "insert into  tblewallet(user_id,dmr_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,tds,serviceTax,remark)
    
    													values(?,?,?,?,?,?,?,?,?,?,?)";
    													$reslut2 = $this->db->query($str_query_charge,array($DId,$transaction_id,$transaction_type,$dist_charge_amount,$dist_current_balance,$Description,$add_date,$ip,$tds,$stax,$dist_remark));
    												}
    												
    
    
    
    											}
    										}
    										*/
    										
    										
    										return true;
    									}
    									else
    									{
    										$rslt_updtrec = $this->db->query("update mt3_transfer set reverted='yes',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),_amount = ? where Id = ?",array($current_balance,$ewallet_id,$dr_amount,$transaction_id));	
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
    		else if($transaction_type == "BILL")
    		{
    			$str_query = "insert into  tblewallet(user_id,recharge_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,tds,serviceTax,remark)
    
    			values(?,?,?,?,?,?,?,?,?,?,?)";
    			$reslut = $this->db->query($str_query,array($user_id,$transaction_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip,$tds,$stax,$remark));
    
    			if($reslut == true)
    			{
    					$ewallet_id = $this->db->insert_id();
    
    					$rslt_updtrec = $this->db->query("update tblbills set debited='yes',reverted='yes',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),credit_amount = ? where Id = ?",array($current_balance,$ewallet_id,$dr_amount,$transaction_id));
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
		if($groupinfo->row(0)->charge_type == "SLAB")
		{
			$getrangededuction = $this->db->query("
			select 
				a.charge_type,
				a.charge_amount as charge_value,
				0 as dist_charge_type,
				0 as dist_charge_value 
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
			$groupinfo = $this->db->query("select * from mt3_group where Id = (select dmr_group from tblusers where user_id = ?)",array($userinfo->row(0)->parentid));
        	if($groupinfo->num_rows() == 1)
        	{
        		if($groupinfo->row(0)->charge_type == "SLAB")
        		{
        			$getrangededuction = $this->db->query("
        			select 
        				a.charge_type,
        				a.charge_amount as charge_value,
        				0 as dist_charge_type,
        				0 as dist_charge_value 
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
public function bill_checkduplicate($user_id,$service_no,$amount)
{
	$add_date = $this->common->getDate();
	$df = date_format(date_create($add_date),"Y-m-d H:i");
	$ip = $this->common->getRealIpAddr();
	$rslt = $this->db->query("insert into locking_bill (user_id,service_no,amount,datetime) values(?,?,?,?)",array($user_id,$service_no,$amount,$df));
	  if($rslt == "" or $rslt == NULL)
	  {
		return false;
	  }
	  else
	  {
	    return true;
	  }
}

	
}

?>
