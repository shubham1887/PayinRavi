<?php
class Fino_dmt_model extends CI_Model 
{	
	public $nefturl;
	public $impsurl;
	public $txnstaturl;
	public $balanceurl;

	protected $at_partnerid;
	protected $at_salt;
	protected $mt3_sender;
	protected $mt3_sender_info;
	protected $airtel_sender;
	protected $beneficiaries;
	protected $airtel_beneficiary;
	protected $mt3_bene_temp;
	protected $api;
	protected $arrHoldMsg;
	function __construct()
	{
	  	parent::__construct();
	  	$this->load->helper('string');
		$this->nefturl="https://fpbs.finopaymentbank.in/FinoMoneyTransferService/UIService.svc/FinoMoneyTransactionApi/NEFTrequest";
		$this->impsurl="https://fpbs.finopaymentbank.in/FinoMoneyTransferService/UIService.svc/FinoMoneyTransactionApi/IMPSrequest";
		$this->txnstaturl="https://fpbs.finopaymentbank.in/FinoMoneyTransferService/UIService.svc/FinoMoneyTransactionApi/TxnstatusRequest";
		$this->balanceurl="https://fpbs.finopaymentbank.in/FinoMoneyTransferService/UIService.svc/FinoMoneyTransactionApi/GetPartnersBalanceRequest";

		$this->mt3_sender="mt3_remitter_registration";
		$this->mt3_sender_info="mt3_remitter_registration_info";
		$this->mt3_sender="mt3_remitter_registration";
		$this->mt3_sender_info="mt3_remitter_registration_info";
		$this->airtel_sender="airtel_sender";
		$this->airtel_beneficiary="airtel_beneficiary";
		$this->beneficiaries="beneficiaries";
		$this->mt3_bene_temp="mt3_beneficiary_register_temp";
		$this->api='FINO';
		$this->arrHoldMsg=array("Insufficient Available Balance","Issuing Bank CBS down","Issuing bank CBS or node offline","Access not allowed for MRPC at this time","Transaction not processed.Bank is not available now.","Your transfer was declined by the beneficiary bank. Please try again after some time.");
	}
	
	private function getClientId()
	{
		return "94";
	}
	private function getAuthKey()
	{					
		return "409c6003-4380-4495-aa46-d73e80a6757b";
	}
	private function getHeaderEncKey()
	{					
		return "982b0d01-b262-4ece-a2a2-45be82212ba1";
	}
	private function getBodyEncKey()
	{					
		return "1114cb05-d4b9-48e9-9acb-7c50da75fd65";
	}
	private function get_our_msg($msg)
	{   $msgid=0;$ourmsg=trim($msg);
			$this->db->select("msg_id,our_msg");
			$this->db->from("tbl_dmt_msg");
			$this->db->where("msg_from_api",$ourmsg);
			$resMsg = $this->db->get();
			if($resMsg->num_rows()==0)
			{
					return array('msgid'=>$msgid,'ourmsg'=>$ourmsg);
			}
			return array('msgid'=>$resMsg->row(0)->msg_id,'ourmsg'=>trim($resMsg->row(0)->our_msg));
	}
	public function getBalanceOnline()
	{
		
		$clientId = $this->getClientId();
		$authKey = $this->getAuthKey();
		$plainHeader = '{"ClientId":'.$clientId.',"AuthKey":"'.$authKey.'"}';
		
		$headerEncKey = $this->getHeaderEncKey();
		$bodyEncKey = $this->getBodyEncKey();
		$encrypt_header = $this->encrypt($plainHeader, $headerEncKey);
	
		$url = $this->balanceurl;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "");
		curl_setopt($ch, CURLOPT_HTTPHEADER,array(
				"authentication: {$encrypt_header}",
				"cache-control: no-cache",
				"content-type: application/json"
			)
		);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
				echo "<strong>Error:</strong> <br><br>".curl_error($ch);exit;
		}
		curl_close($ch);
			
		$response = json_decode($result);
		$decrypt_body="";
		if($response->ResponseCode==0 && isset($response->ResponseData)&&trim($response->ResponseData)!=="")
		{
			$decrypt_body = $this->decrypt($response->ResponseData, $bodyEncKey);
			$decrypt_body_json = json_decode($decrypt_body);
			if(is_object($decrypt_body_json))
			{
					$AvailableBalance = isset($decrypt_body_json->AvailableBalance)?$decrypt_body_json->AvailableBalance:0;
					if($AvailableBalance>0)
					{
							$this->db->reset_query();
							$this->db->where('param','FINO_DMT_BALANCE');
							$this->db->update('common',array('value'=>$AvailableBalance));
							$this->db->reset_query();
							
					}
					// else			
					// {
					// 	$this->db->reset_query();
					// 	$this->db->select('param,value');
					// 	$bal = $this->db->get_where('common',['param'=>'FINO_DMT_BALANCE'])->result();
					// 	$AvailableBal = $bal[0]->value;
					// }

			}
		}
		else
		{
			$this->db->reset_query();
			$this->db->select('param,value');
			$bal = $this->db->get_where('common',['param'=>'FINO_DMT_BALANCE'])->result();
			$AvailableBal = $bal[0]->value;
		}
				/*var_dump($AvailableBal);
				print_r($response);exit;*/
		$this->loging("getBalanceOnline","",$result,$decrypt_body,"Admin");
		return $AvailableBal;
	}
	
	public function processIMPSRequest($ClientUniqueID,$CustomerMobileNo,$CustomerName,$BeneIFSCCode,$BeneAccountNo,$BeneName,$Amount)
  {

			$clientId = $this->getClientId();
			$authKey = $this->getAuthKey();
			$plainHeader = '{"ClientId":'.$clientId.',"AuthKey":"'.$authKey.'"}';
			
			$headerEncKey = $this->getHeaderEncKey();
			$encrypt_header = $this->encrypt($plainHeader, $headerEncKey);
			
			$data = array();
			$data['ClientUniqueID'] = $ClientUniqueID;
			$data['CustomerMobileNo'] =  $CustomerMobileNo;
			$data['CustomerName'] = $CustomerName;
			$data['BeneIFSCCode'] = $BeneIFSCCode;
			$data['BeneAccountNo'] = $BeneAccountNo;
			$data['BeneName'] = $BeneName;
			$data['Amount'] = $Amount;
			$data['RFU1'] = "";
			$data['RFU2'] = "";
			$data['RFU3'] = "";
        
        $parameters = json_encode($data);
				$bodyEncKey = $this->getBodyEncKey();
				$encrypt_body = $this->encrypt($parameters, $bodyEncKey);
			
        $url = $this->impsurl;
				
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "\"{$encrypt_body}\"");
				curl_setopt($ch, CURLOPT_HTTPHEADER,array(
						"authentication: {$encrypt_header}",
						"cache-control: no-cache",
						"content-type: application/json"
					)
				);
        $result = curl_exec($ch);

				curl_close($ch);
				
			return $result;
    
  	}
	
	public function gethoursbetweentwodates($fromdate,$todate)
	{
		$now_date = strtotime (date ($todate)); // the current date 
		$key_date = strtotime (date ($fromdate));
		$diff = $now_date - $key_date;
		return round(abs($diff) / 60,2);
	}
	
	//*********** Padding Function *********************
	public function pkcs5_pad($plainText, $blockSize) {
	    $pad = $blockSize - (strlen($plainText) % $blockSize);
	    return $plainText . str_repeat(chr($pad), $pad);
	}

	//********** Hexadecimal to Binary function for php 4.0 version ********
	public function hextobin($hexString) {
	    $length = strlen($hexString);
	    $binString = "";
	    $count = 0;
	    while ($count < $length) {
	        $subString = substr($hexString, $count, 2);
	        $packedString = pack("H*", $subString);
	        if ($count == 0) {
	            $binString = $packedString;
	        } else {
	            $binString .= $packedString;
	        }

	        $count += 2;
	    }
	    return $binString;
	}

	//********** To generate ramdom String ********
	public function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $characters = '0123456789';
	    $charactersLength = strlen($characters);

	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
   private function loging_db($method,$request,$response,$json_resp,$username,$sender_mobile=0,$lat=0,$lng=0)
	{
		$this->db->reset_query();
		$insarray=array("log_ip"=>$_SERVER['REMOTE_ADDR'],"log_user"=>$username,"sender_mobile"=>$sender_mobile,"log_method"=>"finodmt_".$method,"log_request"=>$request,"log_response"=>$response,"log_downline_response"=>$json_resp,"log_datetime"=>date("Y-m-d H:i:s"),"log_api"=>"FINO");
		$this->db->insert("tbl_logs_dmt_4",$insarray);
	}
	public function loging($method,$request,$response,$json_resp,$username,$sender_mobile=0)
	{
/*
		$ipaddress = $this->_get_client_ip();
		// $this->db->reset_query();
		$insarray=array("log_ip"=>$ipaddress,"log_user"=>$username,"sender_mobile"=>$sender_mobile,"log_method"=>"finodmt_".$method,"log_request"=>$request,"log_response"=>$response,"log_downline_response"=>$json_resp,"log_datetime"=>date("Y-m-d H:i:s"));
		$this->db->insert("tbl_logs_finodmt",$insarray);*/
	}
	
	/**********************functions provided by fino team start***************************/
	
	/**
     * @param      $data
     * @param      $passphrase
     * @param null $salt        ONLY FOR TESTING
     * @return string           encrypted data in base64 OpenSSL format
     */
    public static function encrypt($data, $passphrase, $salt = null) {
        $salt = $salt ?: openssl_random_pseudo_bytes(8);
        list($key, $iv) = self::evpkdf($passphrase, $salt);

        $ct = openssl_encrypt($data, 'aes-256-cbc', $key, true, $iv);

        return self::encode($ct, $salt);
    }

    /**
     * @param string $base64        encrypted data in base64 OpenSSL format
     * @param string $passphrase
     * @return string
     */
    public static function decrypt($base64, $passphrase) {
        list($ct, $salt) = self::decode($base64);
        list($key, $iv) = self::evpkdf($passphrase, $salt);

        $data = openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv);

        return $data;
    }

    public static function evpkdf($passphrase, $salt) {
        $salted = '';
        $dx = '';
        while (strlen($salted) < 48) {
            $dx = md5($dx . $passphrase . $salt, true);
            $salted .= $dx;
        }
        $key = substr($salted, 0, 32);
        $iv = substr($salted, 32, 16);

        return [$key, $iv];
    }

    public static function decode($base64) {
        $data = base64_decode($base64);

        if (substr($data, 0, 8) !== "Salted__") {
            throw new \InvalidArgumentException();
        }

        $salt = substr($data, 8, 8);
        $ct = substr($data, 16);

        return [$ct, $salt];
    }

    public static function encode($ct, $salt) {
        return base64_encode("Salted__" . $salt . $ct);
    }
		
	/**********************functions provided by fino team end***************************/
	
	public function _get_client_ip() {
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
				$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
				$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
				$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
				$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			 $ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
				$ipaddress = getenv('REMOTE_ADDR');
		else
				$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

    public function transfer($remittermobile,$beneficiary_array,$amount,$mode,$userinfo,$order_id)
	{
		$postfields = '';
		$jwtToken = "";
		$transtype = "IMPSIFSC";
		$apimode = "2";
		$reqarr=array("remittermobile"=>$remittermobile,"amount"=>$amount,"mode"=>$mode,"order_id"=>$order_id);
		if($mode == "NEFT" or $mode == "1")
		{
		    $transtype = "NEFT";
		    $mode = "NEFT";
			$apimode = "1";
		}
		$postparam = $remittermobile." <> ".$beneficiary_array->row(0)->paytm_bene_id." <> ".$amount." <> ".$mode;
		$buffer = $response ="No Api Call"; 
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
						    $crntBalance = $this->Common_methods->getAgentBalance($user_id);
    						if(floatval($crntBalance) >= floatval($amount) + 30)
    						{
    									$used_limit = 0;
    									$remaining_limit = 25000 - $used_limit;
    									if($remaining_limit >= $amount)
    									{
    										if($beneficiary_array->num_rows()>0)
		    								{
		    									$benificiary_name = $beneficiary_array->row(0)->bene_name;
		    									$benificiary_mobile = $beneficiary_array->row(0)->benemobile;
		    									$benificiary_ifsc = $beneficiary_array->row(0)->IFSC;
													
													if($benificiary_ifsc=="JAKA0000001")$benificiary_ifsc="JAKA0CIRCUS";
													if($benificiary_ifsc=="BARBOBUPGBX")$benificiary_ifsc="BARB0BUPGBX";
													if($benificiary_ifsc=="BARB0COPARK")$benificiary_ifsc="BARB0KOPARK";
													
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
														ccf,cashback,tds)
		    											values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
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
														"FINO",
														$ccf,
														$cashback,
														$tds
		    											));
		    										if($resultInsert == true)
		    										{
		    											$insert_id = $this->db->insert_id();
	    											$affctrows = $this->setSenderLimit($remittermobile,"plus",$amount,$userinfo);
	    											if($affctrows>0)
	    											{
/////////////////////////////////////////////////////////////////////////
							$transaction_type = "DMR";
							$dr_amount = $amount;
							$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
							$sub_txn_type = "REMITTANCE";
							$remark = "Money Remittance";
							$paymentdebited = $this->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
							
							if($paymentdebited == true)
							{
								$amt = $amount;
								$ifsc =$benificiary_ifsc;
								$beneAccNo =$benificiary_account_no;
								$beneMobNo=$remittermobile;

								$sender_mobile_no=$remittermobile;
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
									if($pincode == "0")
									{
										$pincode = "380001";
									}
								}
								////
								////////////////
								////////// timmer start here
								//////////////////////////////
								$msc_step1 = microtime(true);
								$dt_step1 = $this->common->getDate();
								$timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));

								$clientId = $this->getClientId();
								$authKey = $this->getAuthKey();
								$plainHeader = '{"ClientId":'.$clientId.',"AuthKey":"'.$authKey.'"}';
								
								$headerEncKey = $this->getHeaderEncKey();
								$encrypt_header = $this->encrypt($plainHeader, $headerEncKey);
								
								$data = array();
								$data['ClientUniqueID'] = $insert_id;
								$data['CustomerMobileNo'] =  $sender_mobile_no;
								$data['CustomerName'] = $sender_name." ".$lastname;
								$data['BeneIFSCCode'] = $benificiary_ifsc;
								$data['BeneAccountNo'] = $beneAccNo;
								$data['BeneName'] = $benificiary_name;
								$data['Amount'] = $amt;
								$data['RFU1'] = "";
								$data['RFU2'] = "";
								$data['RFU3'] = "";
								$reqarr = $data;
								$parameters = json_encode($data);
								$bodyEncKey = $this->getBodyEncKey();
								$encrypt_body = $this->encrypt($parameters, $bodyEncKey);
								
								$url = $this->impsurl;
								if($mode=="NEFT")
								{
									$url = $this->nefturl;	
								}
								
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, $url);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($ch, CURLOPT_POST, 1);
								curl_setopt($ch, CURLOPT_POSTFIELDS, "\"{$encrypt_body}\"");
								curl_setopt($ch, CURLOPT_HTTPHEADER,array(
								"authentication: {$encrypt_header}",
								"cache-control: no-cache",
								"content-type: application/json"
								)
								);
								$response = curl_exec($ch);
								$my_result_json = json_decode($response);
								$err = curl_error($ch);
								curl_close($ch);
								
								$msc_step2 = microtime(true);
								$dt_step2 = $this->common->getDate();
								////
								////////////////
								////////// timmer stop here
								//////////////////////////////
								$this->loging_db("transfer-step-1",$mode." ".$url."?".$parameters,$response,$response,$userinfo->row(0)->username,$remittermobile);
										
										$arrPendingActCodes = array(1,401,500,503,700292,91,99,998,999,5001,504,-1);
										$arrMsg=array('brijesh');//$this->arrHoldMsg;
										$bodyEncKey = $this->getBodyEncKey();
										$decrypt_body = $this->decrypt($my_result_json->ResponseData, $bodyEncKey);
										$res = json_decode($decrypt_body);
										$my_result_json->ResponseData = $res;
										$message = trim((string)$my_result_json->MessageString);
										$statuscode = trim((string)$res->ActCode);
										
										if(isset($my_result_json->ResponseCode) && isset($res->ActCode))
										{
												if(in_array($res->ActCode,$arrPendingActCodes))
												{
												
														$data = $res;
														$tid = trim((string)$data->TxnID);
														$bank_ref_num = trim((string)$my_result_json->RequestID);
														$_rrn = trim((string)$my_result_json->ClientUniqueID);
														$recipient_name = trim((string)$data->BeneName);
														$message = $my_result_json->DisplayMessage;
														$statuscode = trim((string)$my_result_json->ClientUniqueID);

														$data = array(
															'RESP_statuscode' => "TXN",
															'RESP_status' => $message,
															'RESP_ipay_id' => $_rrn,//$tid,
															'RESP_opr_id' => $tid,//$_rrn,
															'RESP_name' => $recipient_name,
															'Status'=>'PENDING',
															'message'=>$message,
															'edit_date'=>$this->common->getDate()
													);
													$this->db->where('Id', $insert_id);
													$this->db->update('mt3_transfer', $data);
													
													$arrDmtMsg=$this->get_our_msg($message);
													$ourmsg=trim($arrDmtMsg['ourmsg']);
													$msgid=intval($arrDmtMsg['msgid']);
													
													$resp_arr = array(
																		"message"=>$ourmsg,"msgid"=>$msgid,
																		"status"=>1,
																		"statuscode"=>"TUP",
																		"data"=>array(
																			"tid"=>$_rrn,//$tid,
																			"ref_no"=>$bank_ref_num,
																			"opr_id"=>$tid,//$_rrn,
																			"name"=>$recipient_name,
																			"balance"=>0,
																			"amount"=>$amount,

																		)
																	);
													$json_resp =  json_encode($resp_arr);
															
												}
												elseif($my_result_json->ResponseCode=='0'&&$res->ActCode=='0')
												{
														

														$data = $res;
														$tid = trim((string)$data->TxnID);
														$bank_ref_num = trim((string)$my_result_json->RequestID);
														$_rrn = trim((string)$my_result_json->ClientUniqueID);
														$recipient_name = trim((string)$data->BeneName);
														$message = trim((string)$my_result_json->DisplayMessage);
														$statuscode = trim((string)$my_result_json->ClientUniqueID);
														
														$Status="SUCCESS";$RESP_statuscode="TXN";
														if($mode == "NEFT")
														{
															$Status="PENDING";
															$RESP_statuscode="TUP";
														}
														
														$data = array(
																'RESP_statuscode' => $RESP_statuscode,
																'RESP_status' => $message,
																'RESP_ipay_id' => $_rrn,//$tid,
																'RESP_opr_id' => $tid,//$_rrn,
																'RESP_name' => $recipient_name,
																'Status'=>$Status,
																'message'=>$message,
																'edit_date'=>$this->common->getDate()
														);
														$this->db->where('Id', $insert_id);
														$this->db->update('mt3_transfer', $data);
													
													$arrDmtMsg=$this->get_our_msg($message);
													$ourmsg=trim($arrDmtMsg['ourmsg']);
													$msgid=intval($arrDmtMsg['msgid']);
													
													$status=0;
													if($mode == "NEFT")
													{
														$status=1;$ourmsg="PENDING";
													}
													
													$resp_arr = array(
																		"message"=>$ourmsg,
																		"msgid"=>$msgid,
																		"status"=>$status,
																		"statuscode"=>$RESP_statuscode,
																		"data"=>array(
																			"tid"=>$_rrn,//$tid,
																			"ref_no"=>$bank_ref_num,
																			"opr_id"=>$tid,//$_rrn,
																			"name"=>$recipient_name,
																			"balance"=>0,
																			"amount"=>$amount,

																		)
																	);
													$json_resp =  json_encode($resp_arr);
													
													if($user_id==2&&$mode == "IMPS")
													{
														$smstext="Sent Rs. {$amt}/- to {$recipient_name} via Masterpay.pro. Service charge 1%, min Rs. 10/-. Ref ID: ".$tid;
														$this->common->executeAirtelNewSmsAPI($sender_mobile_no,$smstext);
														/*if($sender_mobile_no!='')
														{
															$date=date("Y-m-d H:i:s");
															$this->db->query("insert into tempsms_airtel(message,to_mobile,smsapi,date_time) values(?,?,?,?)",array($smstext,$sender_mobile_no,'airtel',$date));
														}*/
													}
																
												}
												elseif($my_result_json->ResponseCode=='1')
												{
														$this->setSenderLimit($sender_mobile_no,"minus",$amount,$userinfo);	
														$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
														if($message=="Insufficient Available Balance")$message="Please try after sometime.";
															$data = array(
																'RESP_statuscode' => "ERR",
																'RESP_status' => $message,
																'RESP_ipay_id' => "",//$tid,
																'RESP_opr_id' => "",//$_rrn,
																'RESP_name' => "",
																'Status'=>'FAILURE',
																'message'=>$message,
																'edit_date'=>$this->common->getDate()
														);
														$this->db->where('Id', $insert_id);
														$this->db->update('mt3_transfer', $data);
													
													$arrDmtMsg=$this->get_our_msg($message);
													$ourmsg=trim($arrDmtMsg['ourmsg']);
													$msgid=intval($arrDmtMsg['msgid']);
													
													$resp_arr = array(
																		"message"=>$ourmsg,"msgid"=>$msgid,
																		"status"=>1,
																		"statuscode"=>"ERR",
																		"data"=>array(
																			"tid"=>$_rrn,//$tid,
																			"ref_no"=>$bank_ref_num,
																			"opr_id"=>$tid,//$_rrn,
																			"name"=>$recipient_name,
																			"balance"=>0,
																			"amount"=>$amount,

																		)
																	);
													$json_resp =  json_encode($resp_arr);
															
												}
												else
												{
												
														$data = $res;
														$tid = trim((string)$data->TxnID);
														$bank_ref_num = trim((string)$my_result_json->RequestID);
														$_rrn = trim((string)$my_result_json->ClientUniqueID);
														$recipient_name = trim((string)$data->BeneName);
														$message = $my_result_json->DisplayMessage;
														$statuscode = trim((string)$my_result_json->ClientUniqueID);

														$data = array(
																'RESP_statuscode' => "TXN",
																'RESP_status' => $message,
																'RESP_ipay_id' => $_rrn,//$tid,
																'RESP_opr_id' => $tid,//$_rrn,
																'RESP_name' => $recipient_name,
																'Status'=>'PENDING',
																'message'=>$message,
																'edit_date'=>$this->common->getDate()
														);
														$this->db->where('Id', $insert_id);
														$this->db->update('mt3_transfer', $data);
														
														$arrDmtMsg=$this->get_our_msg($message);
														$ourmsg=trim($arrDmtMsg['ourmsg']);
														$msgid=intval($arrDmtMsg['msgid']);
														
														$resp_arr = array(
																			"message"=>$ourmsg,"msgid"=>$msgid,
																			"status"=>0,
																			"statuscode"=>"TUP",
																			"data"=>array(
																				"tid"=>$_rrn,//$tid,
																				"ref_no"=>$bank_ref_num,
																				"opr_id"=>$tid,//$_rrn,
																				"name"=>$recipient_name,
																				"balance"=>0,
																				"amount"=>$amount,
	
																			)
																		);
														$json_resp =  json_encode($resp_arr);
															
												}
												
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
												$arrDmtMsg=$this->get_our_msg($message);
												$ourmsg=trim($arrDmtMsg['ourmsg']);
												$msgid=intval($arrDmtMsg['msgid']);
												
												$resp_arr = array(
																		"message"=>$ourmsg,"msgid"=>$msgid,
																		"status"=>0,
																		"statuscode"=>"TUP",
																	);
												$json_resp =  json_encode($resp_arr);
													
										}	
											
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
												$arrDmtMsg=$this->get_our_msg($message);
												$ourmsg=trim($arrDmtMsg['ourmsg']);
												$msgid=intval($arrDmtMsg['msgid']);
													
								$resp_arr = array(
									"message"=>$ourmsg,"msgid"=>$msgid,
									"status"=>1,
									"statuscode"=>"ERR",
								);
								$json_resp =  json_encode($resp_arr);	
							}							
/////////////////////////////////////////////////////////////////////////	
	    											}
	    											else
		    										{
															$message="Monthly limit breach.";
															$arrDmtMsg=$this->get_our_msg($message);
															$ourmsg=trim($arrDmtMsg['ourmsg']);
															$msgid=intval($arrDmtMsg['msgid']);
												
		    											$resp_arr = array(
		    												"message"=>$ourmsg,"msgid"=>$msgid,
		    												"status"=>1,
		    												"statuscode"=>"ERR",
		    											);
		    											$json_resp =  json_encode($resp_arr);	
		    										}	

		    													
		    										}
		    										else
		    										{
															$message="Internal Server Error";
															$arrDmtMsg=$this->get_our_msg($message);
															$ourmsg=trim($arrDmtMsg['ourmsg']);
															$msgid=intval($arrDmtMsg['msgid']);
															
		    											$resp_arr = array(
		    												"message"=>$ourmsg,"msgid"=>$msgid,
		    												"status"=>1,
		    												"statuscode"=>"ERR",
		    											);
		    											$json_resp =  json_encode($resp_arr);	
		    										}
		    									
		    								}
		    								else
		    								{
													$message="Invalid Beneficiary Id";
													$arrDmtMsg=$this->get_our_msg($message);
													$ourmsg=trim($arrDmtMsg['ourmsg']);
													$msgid=intval($arrDmtMsg['msgid']);
															
		    									$resp_arr = array(
		    											"message"=>$ourmsg,"msgid"=>$msgid,
		    											"status"=>1,
		    											"statuscode"=>"ERR",
		    										);
		    									$json_resp =  json_encode($resp_arr);
		    								}
    									}
    									else
    									{
												$message="Sender Limit Over";
												$arrDmtMsg=$this->get_our_msg($message);
												$ourmsg=trim($arrDmtMsg['ourmsg']);
												$msgid=intval($arrDmtMsg['msgid']);
													
    										$resp_arr = array(
    												"message"=>$ourmsg,"msgid"=>$msgid,
	    											"status"=>1,
	    											"statuscode"=>"ERR",
	    										);
	    									$json_resp =  json_encode($resp_arr);
    									}
    						}
    						else
    						{
									$message="InSufficient Balance";
									$arrDmtMsg=$this->get_our_msg($message);
									$ourmsg=trim($arrDmtMsg['ourmsg']);
									$msgid=intval($arrDmtMsg['msgid']);
												
    							$resp_arr = array(
    									"message"=>$ourmsg,"msgid"=>$msgid,
    									"status"=>1,
    									"statuscode"=>"ERR",
    								);
    							$json_resp =  json_encode($resp_arr);
    						}    
						}
						else
						{
								$message="Minimum Balance Limit is 1000 Rupees";
								$arrDmtMsg=$this->get_our_msg($message);
								$ourmsg=trim($arrDmtMsg['ourmsg']);
								$msgid=intval($arrDmtMsg['msgid']);
									
						    $resp_arr = array(
    									"message"=>$ourmsg,"msgid"=>$msgid,
    									"status"=>1,
    									"statuscode"=>"ERR",
    								);
    							$json_resp =  json_encode($resp_arr);
						}
						
						
					}
					else
					{
						$message="Your Account Deactivated By Admin";
						$arrDmtMsg=$this->get_our_msg($message);
						$ourmsg=trim($arrDmtMsg['ourmsg']);
						$msgid=intval($arrDmtMsg['msgid']);
								
						$resp_arr = array(
									"message"=>$ourmsg,"msgid"=>$msgid,
									"status"=>1,
									"statuscode"=>"ERR",
								);
						$json_resp =  json_encode($resp_arr);
					}
						
				}
				else
				{
					$message="Invalid Access";
					$arrDmtMsg=$this->get_our_msg($message);
					$ourmsg=trim($arrDmtMsg['ourmsg']);
					$msgid=intval($arrDmtMsg['msgid']);
						
					$resp_arr = array(
									"message"=>$ourmsg,"msgid"=>$msgid,
									"status"=>1,
									"statuscode"=>"ERR",
								);
					$json_resp =  json_encode($resp_arr);
				}
			}
			else
			{
				$message="Userinfo Missing";
				$arrDmtMsg=$this->get_our_msg($message);
				$ourmsg=trim($arrDmtMsg['ourmsg']);
				$msgid=intval($arrDmtMsg['msgid']);
					
				$resp_arr = array(
									"message"=>$ourmsg,"msgid"=>$msgid,
									"status"=>4,
									"statuscode"=>"ERR",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$message="Userinfo Missing";
			$arrDmtMsg=$this->get_our_msg($message);
			$ourmsg=trim($arrDmtMsg['ourmsg']);
			$msgid=intval($arrDmtMsg['msgid']);
				
			$resp_arr = array(
									"message"=>$ourmsg,"msgid"=>$msgid,
									"status"=>4,
									"statuscode"=>"ERR",
								);
			$json_resp =  json_encode($resp_arr);
			
		}
		$this->loging_db("transfer",$mode." ".$url."?".json_encode($reqarr),$response,$json_resp,$userinfo->row(0)->username,$remittermobile);
		return $json_resp;
		
	}
	
		public function transfer_status($tId)
		{		$dmr_id=$tId;
					$reqArr = array('tId'=>$tId);
					
 				$resultdmr = $this->db->query("SELECT a.API,a.Id,a.add_date,a.user_id,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited,a.balance,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_opr_id,a.RESP_name,a.txn_req_id,
b.businessname,b.username
FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id
 where a.Id = ? AND a.API='FINO'",array($dmr_id));

					if($resultdmr->num_rows() == 1)
					{

							$dmr_id = $tId;
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
							if($debit_amount < $Amount)
							{
									$resp_arr = array(
													"message"=>"some problem found",
													"status"=>3,
												);
									$json_resp =  json_encode($resp_arr);
							}
							else
							{
									
									
									if($Status=="PENDING")
									{
											
											$benificiary_account_no = $resultdmr->row(0)->AccountNumber;
											$benificiary_ifsc = $resultdmr->row(0)->IFSC;
											
											if($benificiary_ifsc=="JAKA0000001")$benificiary_ifsc="JAKA0CIRCUS";
											if($benificiary_ifsc=="BARBOBUPGBX")$benificiary_ifsc="BARB0BUPGBX";
											if($benificiary_ifsc=="BARB0COPARK")$benificiary_ifsc="BARB0KOPARK";
											//$benificiary_ifsc=substr_replace($benificiary_ifsc,"0",5,1);
											
											$Charge_Amount = $resultdmr->row(0)->Charge_Amount;
											$remittermobile = $resultdmr->row(0)->RemiterMobile;

											$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
											$sub_txn_type = "REMITTANCE";
											$remark = "Money Remittance";
											
											/////////////////////////////////////////////
												$clientId = $this->getClientId();
												$authKey = $this->getAuthKey();
												$plainHeader = '{"ClientId":'.$clientId.',"AuthKey":"'.$authKey.'"}';
												
												$headerEncKey = $this->getHeaderEncKey();
												$encrypt_header = $this->encrypt($plainHeader, $headerEncKey);
												
												$data = array();
												$data['ClientUniqueID'] = $tId;
												
												$parameters = json_encode($data);
												$bodyEncKey = $this->getBodyEncKey();
												$encrypt_body = $this->encrypt($parameters, $bodyEncKey);
												
												$url = $this->txnstaturl;
												
												$ch = curl_init();
												curl_setopt($ch, CURLOPT_URL, $url);
												curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
												curl_setopt($ch, CURLOPT_POST, 1);
												curl_setopt($ch, CURLOPT_POSTFIELDS, "\"{$encrypt_body}\"");
												curl_setopt($ch, CURLOPT_HTTPHEADER,array(
												"authentication: {$encrypt_header}",
												"cache-control: no-cache",
												"content-type: application/json"
												)
												);
												$response = curl_exec($ch);
												$my_result_json = json_decode($response);
												$err = curl_error($ch);
												curl_close($ch);
											/////////////////////////////////////////////
												
												$bodyEncKey = $this->getBodyEncKey();
												$decrypt_body = $this->decrypt($my_result_json->ResponseData, $bodyEncKey);
												$res = json_decode($decrypt_body);
												$my_result_json->ResponseData = $res;
												$message = trim((string)$my_result_json->MessageString);
												$statuscode = trim((string)$res->ActCode);
												$arrMsg=array('brijesh');//$this->arrHoldMsg;
												$arrPendingActCodes = array(1,401,500,503,700292,91,99,998,999,5001,504,-1,20,9);
												$arrFailedActCodes = array(100,'R',23,21,12,1014);
												if(isset($my_result_json->ResponseCode)&&isset($res->ActCode)&&$my_result_json->ResponseCode=='0'&&($res->ActCode=='S'||$res->ActCode=='26'||$res->ActCode=='11'))
												{
																
														$data = $res;
														$tid = trim((string)$data->TxnID);
														$bank_ref_num = trim((string)$my_result_json->RequestID);
														$_rrn = trim((string)$my_result_json->ClientUniqueID);
														$recipient_name = trim((string)$data->BeneName);
														$message = trim((string)$my_result_json->DisplayMessage);
														$statuscode = trim((string)$my_result_json->ClientUniqueID);

														$data = array(
																'RESP_statuscode' => "TXN",
																'RESP_status' => $message,
																'RESP_ipay_id' => $_rrn,//$tid,
																'RESP_opr_id' => $tid,//$_rrn,
																'RESP_name' => $recipient_name,
																'Status'=>'SUCCESS',
																'edit_date'=>$this->common->getDate()
														);
														$this->db->where('Id', $dmr_id);
														$this->db->update('mt3_transfer', $data);
														
														$arrDmtMsg=$this->get_our_msg($message);
														$ourmsg=trim($arrDmtMsg['ourmsg']);
														$msgid=intval($arrDmtMsg['msgid']);
														
													$resp_arr = array(
																		"message"=>$ourmsg,"msgid"=>$msgid,
																		"status"=>0,
																		"statuscode"=>"TXN",
																		"data"=>array(
																			"tid"=>$_rrn,//$tid,
																			"ref_no"=>$bank_ref_num,
																			"opr_id"=>$tid,//$_rrn,
																			"name"=>$recipient_name,
																			"balance"=>0,
																			"amount"=>$amount,

																		)
																	);
													$json_resp =  json_encode($resp_arr);
											}
											elseif(isset($my_result_json->ResponseCode)&&isset($res->ActCode)&&$my_result_json->ResponseCode=='0'&&(in_array($res->ActCode,$arrPendingActCodes)||$res->ActCode=='P'))
											{
													$data = $res;
													$tid = trim((string)$data->TxnID);
													$bank_ref_num = trim((string)$my_result_json->RequestID);
													$_rrn = trim((string)$my_result_json->ClientUniqueID);
													$recipient_name = trim((string)$data->BeneName);
													$message = trim((string)$my_result_json->DisplayMessage);
													$statuscode = trim((string)$my_result_json->ClientUniqueID);
													$arrDmtMsg=$this->get_our_msg($message);
													$ourmsg=trim($arrDmtMsg['ourmsg']);
													$msgid=intval($arrDmtMsg['msgid']);
													$resp_arr = array(
																		"message"=>$ourmsg,"msgid"=>$msgid,
																		"status"=>0,
																		"statuscode"=>"TUP",
																		"data"=>array(
																			"tid"=>$_rrn,
																			"ref_no"=>$bank_ref_num,
																			"opr_id"=>$tid,
																			"name"=>$recipient_name,
																			"balance"=>0,
																			"amount"=>$Amount,
																		)
																	);
													$json_resp =  json_encode($resp_arr);
											}
											elseif(isset($my_result_json->ResponseCode)&&isset($res->ActCode)&&$my_result_json->ResponseCode=='0'&&in_array($res->ActCode,$arrFailedActCodes))
											{
													$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
													$this->setSenderLimit($remittermobile,"minus",$Amount,$userinfo);
													
													$transaction_type = "DMR";
													$sub_txn_type = "REMITTANCE";
													$remark = "Money Remittance";
													$message = trim((string)$my_result_json->DisplayMessage);
													$statuscode = trim((string)$my_result_json->ClientUniqueID);
													
													$this->PAYMENT_CREDIT_ENTRY($user_id,$tId,$transaction_type,$Amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
										
													$data = array(
															'RESP_statuscode' => $statuscode,
															'RESP_status' => $message,
															'Status'=>'FAILURE',
															'edit_date'=>$this->common->getDate()
													);
													$this->db->where('Id', $dmr_id);
													$this->db->update('mt3_transfer', $data);
													
													$arrDmtMsg=$this->get_our_msg($message);
													$ourmsg=trim($arrDmtMsg['ourmsg']);
													$msgid=intval($arrDmtMsg['msgid']);
													
													$resp_arr = array(
																			"message"=>$ourmsg,"msgid"=>$msgid,
																			"status"=>1,
																			"statuscode"=>"ERR",
																		);
													$json_resp =  json_encode($resp_arr);
											}
											else
											{
												$message=$Status;
												$arrDmtMsg=$this->get_our_msg($message);
												$ourmsg=trim($arrDmtMsg['ourmsg']);
												$msgid=intval($arrDmtMsg['msgid']);
												$resp_arr = array(
																	"message"=>$ourmsg,"msgid"=>$msgid,
																	"status"=>2,
																	"statuscode"=>$Status,
																);
												$json_resp =  json_encode($resp_arr);
												return $json_resp;
											}
											
									}
									else if($Status == "SUCCESS")
									{
										$message="SUCCESS";
										$arrDmtMsg=$this->get_our_msg($message);
										$ourmsg=trim($arrDmtMsg['ourmsg']);
										$msgid=intval($arrDmtMsg['msgid']);
										$resp_arr = array(
														"message"=>$ourmsg,"msgid"=>$msgid,
														"status"=>0,
														"statuscode"=>"TXN",
														"data"=>array(
															"tid"=>$dmr_id,
															"ref_no"=>$RESP_ipay_id,
															"opr_id"=>$RESP_opr_id,
															"name"=>$RESP_name,
															"amount"=>$amount,
			
														)
													);
										$json_resp =  json_encode($resp_arr); 
										$this->loging_db("transfer_status","success in mastermoney",$json_resp,$json_resp,"Admin",$sender_mobile_no);
										return $json_resp;
									}
									else if($Status == "FAILURE")
									{
										$message="FAILURE";
										$arrDmtMsg=$this->get_our_msg($message);
										$ourmsg=trim($arrDmtMsg['ourmsg']);
										$msgid=intval($arrDmtMsg['msgid']);
										$resp_arr = array(
														"message"=>$ourmsg,"msgid"=>$msgid,
														"status"=>1,
														"statuscode"=>"ERR",
													);
										$json_resp =  json_encode($resp_arr);
										$this->loging_db("transfer_status","failure in mastermoney",$json_resp,$json_resp,"Admin",$sender_mobile_no);
										return $json_resp;
									}
									else
									{
										$message=$Status;
										$arrDmtMsg=$this->get_our_msg($message);
										$ourmsg=trim($arrDmtMsg['ourmsg']);
										$msgid=intval($arrDmtMsg['msgid']);
										$resp_arr = array(
															"message"=>$ourmsg,"msgid"=>$msgid,
															"status"=>2,
															"statuscode"=>$Status,
														);
										$json_resp =  json_encode($resp_arr);
										return $json_resp;
									}
									
							}
								
					}
					else
					{
								$message="PENDING";
								$arrDmtMsg=$this->get_our_msg($message);
								$ourmsg=trim($arrDmtMsg['ourmsg']);
								$msgid=intval($arrDmtMsg['msgid']);
								$resp_arr = array(
													"message"=>$ourmsg,"msgid"=>$msgid,
													"status"=>0,
													"statuscode"=>"TUP",
												);
								$json_resp =  json_encode($resp_arr);
					}
				$this->loging_db("transfer_status",$url."?".$parameters,json_encode($my_result_json),$json_resp,"Admin",$sender_mobile_no);
				return $json_resp;		
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
				if($usertype_name == "APIUSER")
				{
					if($user_status == '1')
					{
						
						$accval_resultcheck = $this->db->query("SELECT RESP_benename FROM `mt3_account_validate` where account_no = ? and remitter_mobile = ? and user_id = ? and status = 'SUCCESS' and API = 'PAYTM' order by Id desc limit 1",
						array($acc_no,$mobile_no,$user_id));
						if($accval_resultcheck->num_rows() == 1)
						{
						    $resp_arr = array(
													"message"=>"Beneficiary Already Validated. ".$accval_resultcheck->row(0)->RESP_benename,
													"status"=>1,
													"statuscode"=>"ERR",
													"recipient_name"=>$accval_resultcheck->row(0)->RESP_benename
												);
							$json_resp =  json_encode($resp_arr); 

						}
						else
						{
						    $crntBalance = $this->Common_methods->getAgentBalance($user_id);

    						if(floatval($crntBalance) < 3)
    						{
    							$resp_arr = array(
    													"message"=>"InSufficient Balance",
    													"status"=>1,
    													"statuscode"=>"ISB",
    												);
    							$json_resp =  json_encode($resp_arr);
    							echo $json_resp;exit;
    						}
								
								$resSender = $this->db->query("select name,lastname from mt3_remitter_registration where mobile=?",array($mobile_no));
								$sendername = $resSender->row(0)->name." ".$resSender->row(0)->lastname;
								
    						$rsltinsert = $this->db->query("insert into mt3_account_validate(user_id,add_date,edit_date,ipaddress,remitter_id,remitter_mobile,account_no,IFSC,status,API) values(?,?,?,?,?,?,?,?,?,?)",array(
    							$user_id,$this->common->getDate(),$this->common->getDate(),$this->common->getRealIpAddr(),$mobile_no,$mobile_no,$acc_no,$ifsc,"PENDING","FINO"
    						));
    						if($rsltinsert == true)
    						{
    							$insert_id = $this->db->insert_id();
    							$transaction_type = "DMR";
    							$sub_txn_type = "Account_Validation";
    							if($user_id == 10)
    							{
    								$charge_amount = 2.00;
    							}
    							else
    							{
    								$charge_amount = 3.00;
    							}
    							
    							$Description = "Valid.Charge : ".$acc_no;
    							$remark = $mobile_no."  Acc NO :".$acc_no;
    							$debitpayment = $this->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$charge_amount,$Description,$sub_txn_type,$remark,0);
    
    							if($debitpayment == true)
    							{
											$unique_id = $insert_id;
											$ddbit_amount_a = 1;

									$my_result = $this->processIMPSRequest($insert_id,$mobile_no,$sendername,$ifsc,$acc_no,$sendername,1);
									$my_result_json =json_decode($my_result);
									$message  = $my_result_json->MessageString;
									
									$bodyEncKey = $this->getBodyEncKey();
									$decrypt_body = $this->decrypt($my_result_json->ResponseData, $bodyEncKey);
									$decrypt_body_json = json_decode($decrypt_body);
									
									$my_result_json->ResponseData=$decrypt_body_json;
									$is_success=false;		
									$recipient_name = "";
									if((isset($my_result_json->ResponseCode) && isset($decrypt_body_json->ActCode)) && (($my_result_json->ResponseCode=='0' && $decrypt_body_json->ActCode=='0') || ($my_result_json->ResponseCode=='0' && $decrypt_body_json->ActCode=='1')))
									{
											$recipient_name = isset($decrypt_body_json->BeneName)?trim((string)$decrypt_body_json->BeneName):"";
											if($recipient_name!="")
											{
												$is_success=true;
												$resp_arr = array(
																				"message"=>$message."  Name : ".$recipient_name,
																				"status"=>0,
																				"statuscode"=>"TXN",
																				"recipient_name"=>$recipient_name
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
																	"recipient_name"=>$recipient_name
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
		
		$this->loging_db("bene_verify",$reqarr,json_encode($my_result_json),$json_resp,$userinfo->row(0)->username,$mobile_no);

		return $json_resp;
		
	}
	
	
	public function getStateList()
  	{
		$allstates='[
			{
				"CODE": 35,
				"STATE": "ANDAMAN AND NICOBAR"
			},
			{
				"CODE": 37,
				"STATE": "ANDHRA PRADESH"
			},
			{
				"CODE": 12,
				"STATE": "ARUNACHAL PRADESH"
			},
			{
				"CODE": 18,
				"STATE": "ASSAM"
			},
			{
				"CODE": 10,
				"STATE": "BIHAR"
			},
			{
				"CODE": 4,
				"STATE": "CHANDIGARH"
			},
			{
				"CODE": 22,
				"STATE": "CHHATTISGARH"
			},
			{
				"CODE": 26,
				"STATE": "DADRA AND NAGAR HAVELI"
			},
			{
				"CODE": 25,
				"STATE": "DAMAN AND DIU"
			},
			{
				"CODE": 7,
				"STATE": "DELHI"
			},
			{
				"CODE": 99,
				"STATE": "Default State"
			},
			{
				"CODE": 30,
				"STATE": "GOA"
			},
			{
				"CODE": 24,
				"STATE": "GUJARAT"
			},
			{
				"CODE": 6,
				"STATE": "HARYANA"
			},
			{
				"CODE": 2,
				"STATE": "HIMACHAL PRADESH"
			},
			{
				"CODE": 1,
				"STATE": "JAMMU & KASHMIR"
			},
			{
				"CODE": 20,
				"STATE": "JHARKHAND"
			},
			{
				"CODE": 29,
				"STATE": "KARNATAKA"
			},
			{
				"CODE": 32,
				"STATE": "KERALA"
			},
			{
				"CODE": 31,
				"STATE": "LAKSHDWEEP"
			},
			{
				"CODE": 23,
				"STATE": "MADHYA PRADESH"
			},
			{
				"CODE": 27,
				"STATE": "MAHARASHTRA"
			},
			{
				"CODE": 14,
				"STATE": "MANIPUR"
			},
			{
				"CODE": 17,
				"STATE": "MEGHALAYA"
			},
			{
				"CODE": 15,
				"STATE": "MIZORAM"
			},
			{
				"CODE": 13,
				"STATE": "NAGALAND"
			},
			{
				"CODE": 21,
				"STATE": "ORISSA"
			},
			{
				"CODE": 34,
				"STATE": "PONDICHERRY"
			},
			{
				"CODE": 3,
				"STATE": "PUNJAB"
			},
			{
				"CODE": 8,
				"STATE": "RAJASTHAN"
			},
			{
				"CODE": 11,
				"STATE": "SIKKIM"
			},
			{
				"CODE": 33,
				"STATE": "TAMIL NADU"
			},
			{
				"CODE": 36,
				"STATE": "TELANGANA"
			},
			{
				"CODE": 16,
				"STATE": "TRIPURA"
			},
			{
				"CODE": 9,
				"STATE": "UTTAR PRADESH"
			},
			{
				"CODE": 5,
				"STATE": "UTTRAKHAND"
			},
			{
				"CODE": 19,
				"STATE": "WEST BENGAL"
			}
		]';
		$jsonobj = json_decode($allstates);
		return $jsonobj;
    
  	}
  	
	public function setSenderLimit($sender_mobile_no,$type,$amount,$userinfo="")
	{
			$updatedRows = 0;
			$used_limit = $this->getSenderLimit_fino($sender_mobile_no);
			if($type=="plus")$totallimit = $used_limit+$amount;
			if($type=="minus")$totallimit = $used_limit-$amount;
			//if($totallimit<=25000)
			//{
				if($type=="plus")
				{
					$this->db->query("UPDATE `fino_sender_limit` SET `limit_spent`=`limit_spent`+".$amount." WHERE `limit_sender`='".$sender_mobile_no."'");
					$updatedRows = $this->db->affected_rows();
				}
				if($type=="minus")
				{
					$this->db->query("UPDATE `fino_sender_limit` SET `limit_spent`=`limit_spent`-".$amount." WHERE `limit_sender`='".$sender_mobile_no."'");
					$updatedRows = $this->db->affected_rows();
				}
			//}	
			return $updatedRows;
	}
	public function getSenderLimit_fino($sender_mobile_no)
	{
			$avail_limit = 25000;
			$add_date = date("Y-m-d H:i:s"); $ipaddress = $this->_get_client_ip();
			$this->db->reset_query();
			$this->db->select('limit_total,limit_spent');
			$res_limit = $this->db->get_where('fino_sender_limit',array('limit_sender'=>$sender_mobile_no));
			if($res_limit->num_rows() == 1)
			{
				$arr_limit = $res_limit->row_array();
				$mcmv = $arr_limit["limit_total"];
				$mcv = $arr_limit["limit_spent"];
				$avail_limit = $mcmv - $mcv;
			}
			else
			{
					$arrInsert = array('limit_sender'=>$sender_mobile_no,'limit_total'=>25000,'limit_spent'=>0,
					'add_date'=>$add_date,'add_ipaddress'=>$ipaddress,'add_device'=>'WEB','add_lat'=>0,'add_lng'=>0,
					'edit_date'=>$add_date,'edit_ipaddress'=>$ipaddress,'edit_device'=>'WEB','edit_lat'=>0,'edit_lng'=>0);
					$this->db->insert('fino_sender_limit',$arrInsert);
					$avail_limit = 25000;
			}
			$this->db->reset_query();
			return $avail_limit;
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
		$result_oldbalance = $this->db->query("SELECT balance FROM `tblewallet` where user_id = ? order by Id desc limit 1",array($user_id));
		if($result_oldbalance->num_rows() > 0)
		{
			$old_balance =  $result_oldbalance->row(0)->balance;
		}
		else 
		{
			
				
        		$result_oldbalance2 = $this->db->query("SELECT balance FROM masterpa_archive.tblewallet where user_id = ? order by Id desc limit 1",array($user_id));
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
		
		//$old_balance = $this->Common_methods->getAgentBalance($user_id);
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
    			$str_query = "insert into  tblewallet(user_id,dmr_id,transaction_type,debit_amount,balance,description,add_date,ipaddress,remark)
    
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
    									$str_query_charge = "insert into  tblewallet(user_id,dmr_id,transaction_type,debit_amount,balance,description,add_date,ipaddress,remark)
    
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
        		$old_balance = $this->Common_methods->getAgentBalance($user_id);
        		$current_balance = $old_balance + $dr_amount;
        		$tds = 0.00;
        		$stax = 0.00;
        		if($transaction_type == "DMR")
        		{
        			$remark = "Money Remittance Reverse";
        			$str_query = "insert into  tblewallet(user_id,dmr_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,remark)
        
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
        									$str_query_charge = "insert into  tblewallet(user_id,dmr_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,remark)
        
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
	
		
}

?>