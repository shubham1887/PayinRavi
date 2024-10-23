<?php
class IndoNepalPrabhu extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
		//define('PRABHU2_0WSDL','https://sandbox.prabhuindia.com/Api/Send.svc?wsdl');
		//define('PRABHU2_0USERNAME','SAMS_API');
		//define('PRABHU2_0PASSWORD','SamsApi@TEST_895');

		  define('PRABHU2_0WSDL','https://www.prabhuindia.com/Api/Send.svc?wsdl');
		define('PRABHU2_0USERNAME','SAMS_API');
		define('PRABHU2_0PASSWORD','SamS#api951');


	}
	public function getCustomerId($number)
	{
		$sender_info = $this->db->query("select CustomerId from indonepal_customers where Status = 'Verified' and Mobile = ? ",array($number));
		if($sender_info->num_rows() == 1)
		{
			return $sender_info->row(0)->CustomerId;
		}
		else
		{
			return false;
		}

	}
	function parsedata($soapResponse)
	{
		$xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $soapResponse);
		$xml = simplexml_load_string($xml);
		$json = json_encode($xml);
		return $responseArray = json_decode($json,true);
		
		exit;
	}
	public function add_db_log($action_methods,$request,$response,$url,$user_id,$ref_id)
	{
		$this->db->query("insert into indonepal_logs(add_date,ipaddress,action_methods,request,response,url,user_id,ref_id) values(?,?,?,?,?,?,?,?)",array($this->common->getDate(),$this->common->getRealIpAddr(),$action_methods,$request,$response,$url,$user_id,$ref_id));
	}
	public function sendOTP_transfer($CustomerMobile,$CustomerId,$ReceiverId,$PaymentMode,$userinfo)
	{


		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;


		$user_id = $userinfo->row(0)->user_id;

		define('PRABHU2_0WSDL','https://www.prabhuindia.com/Api/Send.svc?wsdl');
		define('PRABHU2_0USERNAME','SAMS_API');
		define('PRABHU2_0PASSWORD','SamS#api951');


		$insert_rslt = $this->db->query("insert into indonepal_TransferOtp(add_date,ipaddress,user_id,CustomerMobile,CustomerId,ReceiverId,PaymentMode) values(?,?,?,?,?,?,?)",
			array($this->common->getDate(),$this->common->getRealIpAddr(),$userinfo->row(0)->user_id,$CustomerMobile,$CustomerId,$ReceiverId,$PaymentMode));
		if($insert_rslt == true)
		{
			$insert_id = $this->db->insert_id();
			$prabhu_url='https://www.prabhuindia.com/Api/Send.svc?wsdl';
			$prabhu_username='SAMS_API';
			$prabhu_password='SamS#api951';
			$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <SendOTP xmlns=\"http://tempuri.org/\">
						            <SendOTPRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						                <Operation xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">SendTransaction</Operation>
						                <Mobile xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$CustomerMobile."</Mobile>
						                <CustomerId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$CustomerId."</CustomerId>
						                <ReceiverId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$ReceiverId."</ReceiverId>
						                <ReceiverName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></ReceiverName>
						                <PaymentMode xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$PaymentMode."</PaymentMode>
						                <PinNo xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></PinNo>


						                
						            </SendOTPRequest>
						        </SendOTP>
						    </Body>
						</Envelope>";

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $prabhu_url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS =>$postfield_data,
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: text/xml",
		    "SOAPAction: http://tempuri.org/ISend/SendOTP"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		//print_r($json_obj);exit;
		$this->add_db_log("SendOTP_SendTransaction",$postfield_data,json_encode($json_obj),$prabhu_url,$user_id,$insert_id);

			if(isset($json_obj["sBody"]))
			{
				$sBody = $json_obj["sBody"];
				$SendOTPResponse = $sBody["SendOTPResponse"];
				if(isset($SendOTPResponse["SendOTPResult"]))
				{
					$SendOTPResult = $SendOTPResponse["SendOTPResult"];
					
					if(isset($SendOTPResult["aCode"]))
					{
						$aCode = trim($SendOTPResult["aCode"]);
						if($aCode == "000")
						{
								
							$aMessage = trim($SendOTPResult["aMessage"]);
							$aProcessId = trim($SendOTPResult["aProcessId"]);
							$rslt_update = $this->db->query("update indonepal_TransferOtp set ProcessId=?,statuscode=?,ResponseMessage=? where Id = ?",array($aProcessId,$aCode,$aMessage,$insert_id));
							if($rslt_update == true)
							{
								$resp_array = array(
									"message"=>$aMessage,
									"status"=>0,
									"statuscode"=>"TXN",
									"ProcessId"=>$aProcessId,
									"Message"=>$aMessage,
									"StatusCode"=>1

								);
								return json_encode($resp_array);
							}
						}
						else if($aCode == "025" or $aCode == "035")
						{
							
							$aMessage = trim($SendOTPResult["aMessage"]);

							$resp_array = array(
								"message"=>$aMessage,
								"status"=>1,
								"statuscode"=>"RNF",
								"Message"=>$aMessage,
								"StatusCode"=>0
							);
							return json_encode($resp_array);
						}
						else
						{
							print_r($json_obj);exit;
						}

					}
				}
			}
		}
	}
	public function transfer($sender_info,$receiver_info,$userinfo,$order_id,$SendAmount,$RemittanceReason,$ProcessId,$otp)
	{ 


		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
		$Amount = $SendAmount;
		$amount = $SendAmount;

		//$CollectedAmount,$ServiceCharge this two methods get from getservice charge method
		if($userinfo != NULL)
		{	
			if($userinfo->num_rows() == 1)
			{	
				$url = '';
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "APIUSER" or $usertype_name == "Agent")
				{	
					if($user_status == '1')
					{ 
						if($amount >= 100)
						{
						    $crntBalance = $this->Ew2->getAgentBalance($user_id);
    						if(floatval($crntBalance) >= floatval($amount) + 200)
    						{
    								
    								if($receiver_info->num_rows()== 1)
    								{	
    									$add_date = $this->common->getDate();
    									$ipaddress = $this->common->getRealIpAddr();
										$CustomerId = $sender_info->row(0)->CustomerId;
										$SenderName = $sender_info->row(0)->Name;
										$SenderGender = $sender_info->row(0)->Gender;
										$SenderDoB = $sender_info->row(0)->Dob;
										$SenderAddress = $sender_info->row(0)->Address;
										$SenderPhone = "";
										$SenderMobile = $sender_info->row(0)->Mobile;
										$SenderCity = $sender_info->row(0)->City;
										$SenderDistrict = $sender_info->row(0)->District;
										$SenderState = $sender_info->row(0)->State;
										$SenderNationality = $sender_info->row(0)->Nationality;
										$Employer = $sender_info->row(0)->Employer;
										$SenderIDType = $sender_info->row(0)->IDType;
										$SenderIDNumber = $sender_info->row(0)->IDNumber;
										$IncomeSource = $sender_info->row(0)->IncomeSource;



										$ReceiverId = $receiver_info->row(0)->aReceiverId;
										$ReceiverName = $receiver_info->row(0)->ReceiverName;
										$ReceiverGender = $receiver_info->row(0)->Gender;
										$ReceiverAddress = $receiver_info->row(0)->Address;
										$ReceiverMobile = $receiver_info->row(0)->Mobile;
										$ReceiverCity = $sender_info->row(0)->City;
										$BankBranchId = $receiver_info->row(0)->BankBranchId;
										$SendCountry = "India";
										$PayoutCountry = "Nepal";
										$PaymentMode = $receiver_info->row(0)->PaymentMode;




										$charge_info = json_decode($this->getServiceCharge($amount,$PaymentMode,$BankBranchId));
										/*
										{"aCollectionAmount":"1000","aCollectionCurrency":"INR","aServiceCharge":"200","aTransferAmount":"800","aExchangeRate":"1.6","aPayoutAmount":"1280","aPayoutCurrency":"NPR"}
										*/
										if(isset($charge_info->aCollectionAmount) and isset($charge_info->aServiceCharge)   and isset($charge_info->aTransferAmount) and isset($charge_info->aExchangeRate)  and isset($charge_info->aPayoutAmount))
										{
											$aCollectionAmount = $charge_info->aCollectionAmount;
											$aServiceCharge = $charge_info->aServiceCharge;
											$aTransferAmount = $charge_info->aTransferAmount;
											$aExchangeRate = $charge_info->aExchangeRate;
											$aPayoutAmount = $charge_info->aPayoutAmount;
										}
										else
										{
											$resp_array = array(
													"message"=>"Unable To Get Charge Info",
													"statuscode"=>"ERR",
													"status"=>"1",
													"Status"=>0,
													"Message"=>"Unable To Get Charge Info"
											);
											return json_encode($resp_array);
										}
										
										$CollectedAmount = $aCollectionAmount;
										$ServiceCharge = $aServiceCharge;











										$SendCurrency = "INR";
										$PayAmount = $aPayoutAmount;
										$PayCurrency = "NPR";
										$ExchangeRate = $aExchangeRate;
										$BankBranchId = $receiver_info->row(0)->BankBranchId;
										$AccountNumber = $receiver_info->row(0)->AccountNumber;
										$AccountType = "";
										$NewAccountRequest = "";
										$PartnerPinNo = "";
										
										$Relationship = $receiver_info->row(0)->Relationship;
										$CSPCode = "9920427176";//"9819891887";
										$OTPProcessId = $ProcessId;
										$OTP = $otp;
										$status = "Pending";








    										
													///////////////////////////////////////////////
													/////// RETAILER CHARGE CALCULATION
											////////////////////////////////////////////
													
											$Charge_type = "Amount";
											$charge_value = "200";

											$Charge_Amount = $charge_value;
											$retailer_gst = ((floatval($Charge_Amount) * 18)/ 100);
											$tds = 0;
											
											$Charge_Amount = (floatval($Charge_Amount) + floatval($tds) + floatval($retailer_gst));	

    										$resultInsert = $this->db->query("
    											insert into indonepal_transaction(
    											user_id,add_date,ipaddress,
												CustomerId,SenderName,SenderGender,
    											SenderDoB,SenderAddress,SenderPhone,
    											SenderMobile,SenderCity,SenderDistrict,
    											SenderState,SenderNationality,Employer,
												SenderIDType,SenderIDNumber,ReceiverId,
												ReceiverName,ReceiverGender,ReceiverAddress,
												ReceiverMobile,ReceiverCity,SendCountry,
												PayoutCountry,PaymentMode,CollectedAmount,
												ServiceCharge,SendAmount,SendCurrency,
												PayAmount,PayCurrency,ExchangeRate,
												BankBranchId,AccountNumber,AccountType,
												NewAccountRequest,PartnerPinNo,IncomeSource,
												RemittanceReason,Relationship,CSPCode,
												OTPProcessId,OTP,status,
												Charge_Amount



												)
    											values(?,?,?,?,?,?,?,?,?,?,
    													?,?,?,?,?,?,?,?,?,?,
    													?,?,?,?,?,?,?,?,?,?,
    													?,?,?,?,?,?,?,?,?,?,
    													?,?,?,?,?,?)
    											",array(
												$user_id,$add_date,$ipaddress,
												$CustomerId,$SenderName,$SenderGender,
												$SenderDoB,$SenderAddress,$SenderPhone,
    											$SenderMobile,$SenderCity,$SenderDistrict,
    											$SenderState,$SenderNationality,$Employer,
    											$SenderIDType,$SenderIDNumber,$ReceiverId,
												$ReceiverName,$ReceiverGender,$ReceiverAddress,
												$ReceiverMobile,$ReceiverCity,$SendCountry,
												$PayoutCountry,$PaymentMode,$CollectedAmount,
												$ServiceCharge,$SendAmount,$SendCurrency,
												$PayAmount,$PayCurrency,$ExchangeRate,
												$BankBranchId,$AccountNumber,$AccountType,
												$NewAccountRequest,$PartnerPinNo,$IncomeSource,
												$RemittanceReason,$Relationship,$CSPCode,
												$OTPProcessId,$OTP,$status,
												$Charge_Amount
    											));
    										if($resultInsert == true)
    										{
												$insert_id = $this->db->insert_id(); 
												$PartnerPinNo = $insert_id;
												
    											$transaction_type = "INDONEPAL";
    											$dr_amount = $SendAmount;
    											$Description = "I-N ".$SenderMobile." ".$PayAmount." : ".$ReceiverName;
    											$sub_txn_type = "REMITTANCE";
    											$remark = "Indo-Nepal Money Transfer";
    											$this->load->model("Paytm");
    											$paymentdebited = $this->Paytm->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount);



    											if($paymentdebited == true)
    											{
    											   
        											$dohold = 'no';
        										    $rsltcommon = $this->db->query("select * from common where param = 'DMRHOLD'");
        										    if($rsltcommon->num_rows() == 1)
        										    {
        										        $is_hold = $rsltcommon->row(0)->value;
        										    	if($is_hold == 1)
        										    	{
        										    	    $dohold = 'yes';
        										    	}
        										    }
        										    
        											//if($mode == "NEFT")
        										    if($dohold == 'yes' and $mode == "NEFT")
    												{
    													$this->db->query("update indonepal_transaction set Status = 'HOLD' where Id = ?",array($insert_id));
    													$resp_arr = array(
    																							"message"=>"Transaction Under Process",
    																							"status"=>0,
    																							"statuscode"=>"TUP",
    																						);
    																	$json_resp =  json_encode($resp_arr);
    												}
    												else
    												{
    													
    													
    												    $timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));

												    	$datetime=date("Y-m-d H:i:s");
////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// A P I    C A L L    S T A R T ////////////////////////////////////

		$prabhu_url='https://www.prabhuindia.com/Api/Send.svc?wsdl';
		$prabhu_username='SAMS_API';
		$prabhu_password='SamS#api951';
		$postfield_data='<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
						    <Body>
						        <SendTransaction xmlns="http://tempuri.org/">
						            <!-- Optional -->
						            <SendTransactionRequest>
						                <UserName xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$prabhu_username.'</UserName>
						                <Password xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$prabhu_password.'</Password>
						                <CustomerId xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$CustomerId.'</CustomerId>
						                <SenderName xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$SenderName.'</SenderName>
						                <SenderGender xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$SenderGender.'</SenderGender>
						                <SenderDoB xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$SenderDoB.'</SenderDoB>
						                <SenderAddress xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$SenderAddress.'</SenderAddress>
						                <SenderPhone xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$SenderPhone.'</SenderPhone>
						                <SenderMobile xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$SenderMobile.'</SenderMobile>
						                <SenderCity xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$SenderCity.'</SenderCity>
						                <SenderDistrict xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$SenderDistrict.'</SenderDistrict>
						                <SenderState xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$SenderState.'</SenderState>
						                <SenderNationality xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$SenderNationality.'</SenderNationality>
						                <Employer xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$Employer.'</Employer>
						                <SenderIDType xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$SenderIDType.'</SenderIDType>
						                <SenderIDNumber xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$SenderIDNumber.'</SenderIDNumber>
						                <SenderIDExpiryDate xmlns="http://schemas.datacontract.org/2004/07/Remit.API"></SenderIDExpiryDate>
						                <SenderIDIssuedPlace xmlns="http://schemas.datacontract.org/2004/07/Remit.API"></SenderIDIssuedPlace>
						                <ReceiverId xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$ReceiverId.'</ReceiverId>
						                <ReceiverName xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$ReceiverName.'</ReceiverName>
						                <ReceiverGender xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$ReceiverGender.'</ReceiverGender>
						                <ReceiverAddress xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$ReceiverAddress.'</ReceiverAddress>
						                <ReceiverMobile xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$ReceiverMobile.'</ReceiverMobile>
						                <ReceiverCity xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$ReceiverCity.'</ReceiverCity>
						                <SendCountry xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$SendCountry.'</SendCountry>
						                <PayoutCountry xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$PayoutCountry.'</PayoutCountry>
						                <PaymentMode xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$PaymentMode.'</PaymentMode>
						                <CollectedAmount xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$aCollectionAmount.'</CollectedAmount>
						                <ServiceCharge xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$ServiceCharge.'</ServiceCharge>
						                <SendAmount xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$SendAmount.'</SendAmount>
						                <SendCurrency xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$SendCurrency.'</SendCurrency>
						                <PayAmount xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$PayAmount.'</PayAmount>
						                <PayCurrency xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$PayCurrency.'</PayCurrency>
						                <ExchangeRate xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$ExchangeRate.'</ExchangeRate>
						                <BankBranchId xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$BankBranchId.'</BankBranchId>
						                <AccountNumber xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$AccountNumber.'</AccountNumber>
						                <AccountType xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$AccountType.'</AccountType>
						                <NewAccountRequest xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$NewAccountRequest.'</NewAccountRequest>
						                <PartnerPinNo xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$PartnerPinNo.'</PartnerPinNo>
						                <IncomeSource xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$IncomeSource.'</IncomeSource>
						                <RemittanceReason xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$RemittanceReason.'</RemittanceReason>
						                <Relationship xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$Relationship.'</Relationship>
						                <CSPCode xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$CSPCode.'</CSPCode>
						                <OTPProcessId xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$OTPProcessId.'</OTPProcessId>
						                <OTP xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$OTP.'</OTP>
						            </SendTransactionRequest>
						        </SendTransaction>
						    </Body>
						</Envelope>';
									

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $prabhu_url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS =>$postfield_data,
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: text/xml",
		    "SOAPAction: http://tempuri.org/ISend/SendTransaction"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$this->add_db_log("SendTransaction",$postfield_data,$response,$url,$user_id,$insert_id);
		$json_obj = $this->parsedata($response);
		if(isset($json_obj["sBody"]))
		{
			$sBody = $json_obj["sBody"];
			$SendTransactionResponse = $sBody["SendTransactionResponse"];
			if(isset($SendTransactionResponse["SendTransactionResult"]))
			{
				$SendTransactionResult = $SendTransactionResponse["SendTransactionResult"];
				
				if(isset($SendTransactionResult["aCode"]))
				{
					$aCode = trim($SendTransactionResult["aCode"]);
					if($aCode == "000")
					{
						$aMessage = $this->emptyarrayremove($SendTransactionResult["aMessage"]);
						$aTrnsactionId = $this->emptyarrayremove($SendTransactionResult["aTrnsactionId"]);
						$aPinNo = $this->emptyarrayremove($SendTransactionResult["aPinNo"]);
						
						$rslt_update = $this->db->query("update indonepal_transaction set status = 'Success',aCode=?,aMessage=?,aTrnsactionId=?,aPinNo = ? where Id = ?",array($aCode,$aMessage,$aTrnsactionId,$aPinNo,$insert_id));
						if($rslt_update == true)
						{
							$resp_array = array(
							"message"=>$aMessage,
							"status"=>0,
							"statuscode"=>"RNF",
							"Message"=>$aMessage,
							"StatusCode"=>1,
							"OrderID"=>$insert_id,
							"TransId"=>$aTrnsactionId
							);
							return json_encode($resp_array);
						}
					}
					else if($aCode == "777")
					{
						$aMessage = $this->emptyarrayremove($SendTransactionResult["aMessage"]);
						$aTrnsactionId = $this->emptyarrayremove($SendTransactionResult["aTrnsactionId"]);
						$aPinNo = $this->emptyarrayremove($SendTransactionResult["aPinNo"]);
						
						$rslt_update = $this->db->query("update indonepal_transaction set aCode=?,aMessage=?,aTrnsactionId=?,aPinNo = ? where Id = ?",array($aCode,$aMessage,$aTrnsactionId,$aPinNo,$insert_id));
						if($rslt_update == true)
						{
							$resp_array = array(
							"message"=>$aMessage,
							"status"=>0,
							"statuscode"=>"TUP",
							"Message"=>$aMessage,
							"StatusCode"=>1,
							"OrderID"=>$insert_id,
							"TransId"=>$aTrnsactionId
							);
							return json_encode($resp_array);
						}
					}
					else 
					{
						$aMessage = $this->emptyarrayremove($SendTransactionResult["aMessage"]);
						$aTrnsactionId = $this->emptyarrayremove($SendTransactionResult["aTrnsactionId"]);
						$aPinNo = $this->emptyarrayremove($SendTransactionResult["aPinNo"]);
						
						$rslt_update = $this->db->query("update indonepal_transaction set status = 'Failure',aCode=?,aMessage=?,aTrnsactionId=?,aPinNo = ? where Id = ?",array($aCode,$aMessage,$aTrnsactionId,$aPinNo,$insert_id));
						if($rslt_update == true)
						{

							$this->Paytm->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount);


							$resp_array = array(
							"message"=>$aMessage,
							"status"=>1,
							"statuscode"=>"ERR",
							"Message"=>$aMessage,
							"StatusCode"=>0,
							"OrderID"=>$insert_id,
							"TransId"=>$aTrnsactionId
							);
							return json_encode($resp_array);
						}
					}
					
				}
			}
		}
	
/*
<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Body>
<SendTransactionResponse xmlns="http://tempuri.org/">
<SendTransactionResult xmlns:a="http://schemas.datacontract.org/2004/07/Remit.API" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
	<a:Code>071</a:Code>
	<a:Message>OTP Vefification Failed: Invalid Mobile OTP [002]</a:Message>
	<a:TrnsactionId i:nil="true"/>
	<a:PinNo i:nil="true"/>
</SendTransactionResult></SendTransactionResponse></s:Body></s:Envelope>





<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/">
<s:Body>
<SendTransactionResponse xmlns="http://tempuri.org/">
<SendTransactionResult xmlns:a="http://schemas.datacontract.org/2004/07/Remit.API" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">

<a:Code>000</a:Code>
<a:Message>Success</a:Message>
<a:TrnsactionId>16979</a:TrnsactionId>
<a:PinNo>1111218813265190</a:PinNo>

</SendTransactionResult>
</SendTransactionResponse>
</s:Body>
</s:Envelope>
*/





//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx E N D    A P I    C A L L xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx//
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx//
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx//														
        												
														
											
											
													         
														$json_obj = json_decode($response);
														
														$arrMsg=array("brijesh");
														//array("Insufficient Available Balance","Issuing Bank CBS down","Issuing bank CBS or node offline","Access not allowed for MRPC at this time","Transaction not processed.Bank is not available now.","Your transfer was declined by the beneficiary bank. Please try again after some time.");
														$message = isset($json_obj->message)?trim($json_obj->message):"";
														$status = isset($json_obj->status)?trim($json_obj->status):"";
														
														if(isset($json_obj->status) and isset($json_obj->message))
														{
    														$status = $json_obj->status;
															$message = $json_obj->message;
															
															if($status == "success")
															{
																$txn_id = $json_obj->txn_id;
																$mw_txn_id = $json_obj->mw_txn_id;
																$rrn = $json_obj->rrn;
																$extra_info = $json_obj->extra_info;
																
																
																$data = array(
																			'RESP_statuscode' => "TXN",
																			'RESP_status' => $message,
																			'RESP_ipay_id' => $mw_txn_id,
																			'RESP_opr_id' => $rrn,
																			'RESP_name' => $extra_info->beneficiaryName,
																			'message'=>$message,
																			'Status'=>'SUCCESS',
																			'edit_date'=>$this->common->getDate()
																	);

																	$this->db->where('Id', $insert_id);
																	$this->db->update('indonepal_transaction', $data);

                                                                    $sendmsg = 'Transaction Successful, TID: '.$rrn.' Amt:Rs.'.$amount.' A/C: '.$benificiary_account_no.'  '.$this->common->getDate().' Thanks,PayInn';
                                                                   
																	
																	$resp_arr = array(
																						"message"=>"Transaction Done Successfully",
																						"status"=>0,
																						"statuscode"=>"TXN",
																						"data"=>array(
																							"tid"=>$insert_id,
																							"ref_no"=>$insert_id,
																							"opr_id"=>$rrn,
																							"name"=>$extra_info->beneficiaryName,																								"balance"=>"",
																							"amount"=>$amount,

																						)
																					);
																	$json_resp =  json_encode($resp_arr);
															}
															else if($status == "failure")
															{
																	$response_code = $json_obj->response_code;
																	
																	$docredit=true; 
																	$status='FAILURE'; 
																	$RESP_statuscode='ERR';
																	
																	if($docredit==true)
																	{
																			$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
																	}
																
																	if($message=="Insufficient Available Balance")
																	{$message="Please try after sometime.";}

																	$data = array(
																			'RESP_statuscode' => $RESP_statuscode,
																			'RESP_status' => $message,
																			'Status'=>$status,
																			'edit_date'=>$this->common->getDate()
																	);

																$this->db->where('Id', $insert_id);
																$this->db->update('indonepal_transaction', $data);


																if($response_code == "1067")
																{
																	$message = "Service Not Available.Try After Some Time";
																}
																
																$resp_arr = array(
																						"message"=>"Transaction Failed",
																						"status"=>1,
																						"statuscode"=>$RESP_statuscode,
																					);
																$json_resp =  json_encode($resp_arr);

															}
															else if($status == "pending" or $status == "initiated")
															{
																	
																	$txn_id = $json_obj->txn_id;
																	$mw_txn_id = $json_obj->mw_txn_id;
																	$rrn = isset($json_obj->rrn)?$json_obj->rrn:"";
																	$extra_info = isset($json_obj->extra_info)?$json_obj->extra_info:"";
																	$_benename = isset($extra_info->beneficiaryName)?$extra_info->beneficiaryName:"";	
																		
																$data = array(
																			'RESP_statuscode' => "PENDING",
																			'RESP_status' => $message,
																			'RESP_ipay_id' => $mw_txn_id,
																			'RESP_opr_id' => $rrn,
																			'RESP_name' => $_benename,
																			'message'=>$message,
																			'Status'=>'PENDING',
																			'edit_date'=>$this->common->getDate()
																	);

																	$this->db->where('Id', $insert_id);
																	$this->db->update('indonepal_transaction', $data);
																		
																		$resp_arr = array(
																						"message"=>"Transaction Under Process",
																						"status"=>0,
																						"statuscode"=>"TUP",
																						"data"=>array(
																							"tid"=>$insert_id,
																							"ref_no"=>$insert_id,
																							"opr_id"=>$rrn,
																							"name"=>$_benename,"balance"=>"",
																							"amount"=>$amount,

																						)
																					);
																	$json_resp =  json_encode($resp_arr);
															}
    														else
															{
																	$extra_info=$_benename="";
																	$txn_id = isset($json_obj->txn_id)?$json_obj->txn_id:"";
																	$mw_txn_id = isset($json_obj->mw_txn_id)?$json_obj->mw_txn_id:"";
																	$rrn = isset($json_obj->rrn)?$json_obj->rrn:"";
																	if(isset($json_obj->extra_info))
																	{
																		$extra_info = isset($json_obj->extra_info)?$json_obj->extra_info:"";
																		$_benename = isset($extra_info->beneficiaryName)?$extra_info->beneficiaryName:"";	
																	}
																$data = array(
																			'RESP_statuscode' => "PENDING",
																			'RESP_status' => $message,
																			'RESP_ipay_id' => $mw_txn_id,
																			'RESP_opr_id' => $rrn,
																			'RESP_name' => $_benename,
																			'message'=>$message,
																			'Status'=>'PENDING',
																			'edit_date'=>$this->common->getDate()
																	);

																	$this->db->where('Id', $insert_id);
																	$this->db->update('indonepal_transaction', $data);
																		
																		$resp_arr = array(
																						"message"=>"Transaction Under Process",
																						"status"=>0,
																						"statuscode"=>"TUP",
																						"data"=>array(
																							"tid"=>$insert_id,
																							"ref_no"=>$insert_id,
																							"opr_id"=>$rrn,
																							"name"=>$_benename,"balance"=>"",
																							"amount"=>$amount,

																						)
																					);
																	$json_resp =  json_encode($resp_arr);
																	
																	/*$data = array(
																				"RESP_status"=>$message,
																				'RESP_statuscode' => "UNK",
																				'Status'=>'PENDING',
																				'RESP_statuscode'=>$status,
																				'edit_date'=>$this->common->getDate()
																	);

																	$this->db->where('Id', $insert_id);
																	$this->db->update('indonepal_transaction', $data);
																	$arrDmtMsg=$this->get_our_msg($message);
																		$ourmsg=trim($arrDmtMsg['ourmsg']);
																		$msgid=intval($arrDmtMsg['msgid']);
																		$resp_arr = array(
																							"message"=>$ourmsg,"msgid"=>$msgid,
																							"status"=>2,
																							"statuscode"=>"TUP",
																						);
																	$json_resp =  json_encode($resp_arr);*/
																		
															}
    
    
    													}
														else if(isset($json_obj->errorCode) and isset($json_obj->errorMessage))
														{
    														$errorCode = $json_obj->errorCode;
															$errorMessage = $json_obj->errorMessage;
															$data = array(
																				"RESP_status"=>$errorMessage,
																				'RESP_statuscode' => $errorCode,
																				'Status'=>'PENDING',
																				'edit_date'=>$this->common->getDate()
																	);

																	$this->db->where('Id', $insert_id);
																	$this->db->update('indonepal_transaction', $data);
																	
																		
																		$resp_arr = array(
																							"message"=>"Transaction Under Process",
																							"status"=>2,
																							"statuscode"=>"TUP",
																						);
																	$json_resp =  json_encode($resp_arr);
    
    													}
    													else
    													{ 
																		$message = isset($json_obj->message)?trim($json_obj->message):"";
																		$status = isset($json_obj->status)?trim($json_obj->status):"";
																		
																		$respmsg = "Unknown Response or No Response";
																		if(trim($message)!="")$respmsg=$message;
																		
																		$respsts = "UNK";
																		if(trim($status)!="")$respsts=$status;
																		
																		//$this->loging_new("transfer-UNK",$remittermobile,$response,$userinfo->row(0)->username,$userinfo->row(0)->username);
    														//check status befor refund
    														//$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount);
    														$data = array(
    																			'RESP_statuscode' => $respsts,
    																			'RESP_status' => $respmsg,
    																			'edit_date'=>$this->common->getDate()
    																	);
    
    																	$this->db->where('Id', $insert_id);
    																	$this->db->update('indonepal_transaction', $data);
    														
																	$message="Your Request Submitted Successfully";
																	
																	
																	$resp_arr = array(
    																"message"=>"Transaction Under Process",
    																"status"=>0,
    																"statuscode"=>"TUP",
    															);
    														$json_resp =  json_encode($resp_arr);
    													}
												    
        												
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
    												$this->db->update('indonepal_transaction', $data);
																			
    												$message="Payment Failure";
													
																		
														$resp_arr = array(
    													"message"=>"PAYMENT FAILURE",
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
											$message="Invalid Beneficiary Id";
											
    									$resp_arr = array(
    											"message"=>$message,
    											"status"=>1,
    											"statuscode"=>"RNF",
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
		//$this->loging_db("transfer",$mode." ".$url."?".json_encode($request_array)."  ..........".$jwtToken,$response,$json_resp,$userinfo->row(0)->username,$remittermobile);

		return $json_resp;
		
	}




















	public function getCustomerByMobile($sendermobile,$userinfo)
	{
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;


		$user_id = $userinfo->row(0)->user_id;


		$prabhu_url='https://www.prabhuindia.com/Api/Send.svc?wsdl';
		$prabhu_username='SAMS_API';
		$prabhu_password='SamS#api951';
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
					      	<Body>
					          	<GetCustomerByMobile xmlns=\"http://tempuri.org/\">
						            <GetCustomerByMobileRequest>
					                  	<UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
					                  	<Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
					                  	<CustomerMobile xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$sendermobile."</CustomerMobile>
					              	</GetCustomerByMobileRequest>
					          	</GetCustomerByMobile>
					      	</Body>
					    </Envelope>";
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $prabhu_url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS =>$postfield_data,
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: text/xml",
		    "SOAPAction: http://tempuri.org/ISend/GetCustomerByMobile"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		//print_r($json_obj);exit;
		$this->add_db_log("GetCustomerByMobile",$postfield_data,json_encode($json_obj),$prabhu_url,$user_id,0);
		

		if(isset($json_obj["sBody"]))
		{
			$sBody = $json_obj["sBody"];
			$GetCustomerByMobileResponse = $sBody["GetCustomerByMobileResponse"];
			if(isset($GetCustomerByMobileResponse["GetCustomerByMobileResult"]))
			{
				$GetCustomerByMobileResult = $GetCustomerByMobileResponse["GetCustomerByMobileResult"];
				if(isset($GetCustomerByMobileResult["aCode"]))
				{
					$aCode = trim($GetCustomerByMobileResult["aCode"]);
					if($aCode == "000")
					{
						
						$aMessage = trim($GetCustomerByMobileResult["aMessage"]);
						$aCustomers = $GetCustomerByMobileResult["aCustomers"]["aCustomer"];

						//print_r($aCustomers);exit;

						$aCustomerId = $aCustomers["aCustomerId"];
						$aName = $aCustomers["aName"];
						$aGender = $aCustomers["aGender"];
						$aDob = $aCustomers["aDob"];
						$aAddress = $aCustomers["aAddress"];
						$aMobile = $aCustomers["aMobile"];//array
						$Mobile = $aMobile["bstring"];






						$aCity = $aCustomers["aCity"];
						$aState = $aCustomers["aState"];
						$aDistrict = $aCustomers["aDistrict"];
						$aNationality = $aCustomers["aNationality"];
						$aEmployer = $aCustomers["aEmployer"];
						$aIncomeSource = $aCustomers["aIncomeSource"];
						$aStatus = $aCustomers["aStatus"];
						$aApproveStatus = $this->emptyarrayremove($aCustomers["aApproveStatus"]);//array
						$aApproveComment = $this->emptyarrayremove($aCustomers["aApproveComment"]);//array
						$aIds = $aCustomers["aIds"];//array
						$aIdType = $this->emptyarrayremove($aIds["aId"]["aIdType"]);
						$aIdNumber = $aIds["aId"]["aIdNumber"];



						$aReceivers = $aCustomers["aReceivers"];//array
						if(isset($aReceivers["aReceiver"]))
						{
							$aReceiver = $aReceivers["aReceiver"];

							if(isset( $aReceiver["aReceiverId"]))
							{
									// $aReceiverId = $aReceiver["aReceiverId"];
									// $aName = $aReceiver["aName"];
									// $aGender = $aReceiver["aGender"];
									// $aRelationship = $aReceiver["aRelationship"];
									// $aAddress = $aReceiver["aAddress"];
									// $aMobile = $aReceiver["aMobile"];
									// $aPaymentMode = $aReceiver["aPaymentMode"];


									// $aBankBranchId = $aReceiver["aBankBranchId"];
									// $aBankName = $aReceiver["aBankName"];
									// $aBankBranchName = $aReceiver["aBankBranchName"];
									// $aAcNumber = $aReceiver["aAcNumber"];
							}
							else
							{
								foreach($aReceiver as $bene)
								{

									// $aReceiverId = $bene["aReceiverId"];
									// $aName = $bene["aName"];
									// $aGender = $bene["aGender"];
									// $aRelationship = $bene["aRelationship"];
									// $aAddress = $bene["aAddress"];
									// $aMobile = $bene["aMobile"];
									// $aPaymentMode = $bene["aPaymentMode"];


									// $aBankBranchId = $bene["aBankBranchId"];
									// $aBankName = $bene["aBankName"];
									// $aBankBranchName = $bene["aBankBranchName"];
									// $aAcNumber = $bene["aAcNumber"];
								}	
							}
								
						}
						

						

						$checksender = $this->db->query("select * from indonepal_customers where Mobile = ?",array($sendermobile));
						if($checksender->num_rows() == 1)
						{
							if($checksender->row(0)->Status != 'Verified')
							{
								$this->db->query("delete from indonepal_customers where Mobile = ?",array($sendermobile));

								$Iddetail = $this->db->query("SELECT IDType,IDNumber FROM indonepal_customers_temp where Mobile = ?
									ORDER BY indonepal_customers_temp.Id desc  limit 1",array($sendermobile));
								//print_r($Iddetail->result());exit;
								if($Iddetail->num_rows() == 1)
								{
									$aIdType = $Iddetail->row(0)->IDType;
									$aIdNumber = $Iddetail->row(0)->IDNumber;
								}




									$rsltinsertsender = $this->db->query("insert into indonepal_customers(add_date,ipaddress,user_id,CustomerId,Name,Gender,Dob,Address,Mobile,City,State,District,Nationality,Employer,IncomeSource,Status,ApproveStatus,ApproveComment,Email,IDType,IDNumber) 
									values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
									array($this->common->getDate(),$this->common->getRealIpAddr(),0,$aCustomerId,$aName,$aGender,$aDob,$aAddress,$Mobile,$aCity,$aState,$aDistrict,$aNationality,$aEmployer,$aIncomeSource,$aStatus,$aApproveStatus,$aApproveComment,"",$aIdType,$aIdNumber));
							}
							
						}
						if($checksender->num_rows() == 0)
						{
							
								$rsltinsertsender = $this->db->query("insert into indonepal_customers(add_date,ipaddress,user_id,CustomerId,Name,Gender,Dob,Address,Mobile,City,State,District,Nationality,Employer,IncomeSource,Status,ApproveStatus,ApproveComment,Email,IDType,IDNumber) 
								values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
								array($this->common->getDate(),$this->common->getRealIpAddr(),0,$aCustomerId,$aName,$aGender,$aDob,$aAddress,$Mobile,$aCity,$aState,$aDistrict,$aNationality,$aEmployer,$aIncomeSource,$aStatus,$aApproveStatus,$aApproveComment,"",$aIdType,$aIdNumber));
						}
								$resp_array = array(
									"Message"=>"Success",
									"StatusCode"=>3,
									"Data"=>array(
									"SenderMobile"=>$Mobile,
									"CustomerId"=>$aCustomerId,
									"Name"=>$aName,
									"Gender"=>$aGender,
									"Dob"=>$aDob,
									"Address"=>$aAddress,
									"City"=>$aCity,
									"State"=>$aState,
									"District"=>$aDistrict,
									"Nationality"=>$aNationality,
									"Employer"=>$aEmployer,
									"IncomeSource"=>$aIncomeSource,
									"Status"=>$aStatus,
									"ApproveStatus"=>$aApproveStatus,
									"ApproveComment"=>$aApproveComment,
									"Ids"=>$aIds,
									"IdType"=>$aIdType,
									"IdNumber"=>$aIdNumber)
								);
								return json_encode($resp_array);


						//$aTransactionCount = $aCustomers->aTransactionCount;//array
						//$aReceivers = $aCustomers->aReceivers;//array


					}
					else if($aCode == "666")
					{
						
						$aMessage = trim($GetCustomerByMobileResult["aMessage"]);

						$resp_array = array(
							"message"=>$aMessage,
							"status"=>1,
							"statuscode"=>"RNF",
							"StatusCode"=>2,
							"Message"=>"Sender Not Found",
						);
						return json_encode($resp_array);
					}
					else
					{
						print_r($json_obj);exit;
					}

				}
			}
		}

	}
	public function emptyarrayremove($data)
	{
		if(is_array($data))
		{
			return "";
		}
		return $data;
	}
	public function getbenelist2($sendermobile,$userinfo)
	{

		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;


		$user_id = $userinfo->row(0)->user_id;


		$prabhu_url='https://www.prabhuindia.com/Api/Send.svc?wsdl';
		$prabhu_username='SAMS_API';
		$prabhu_password='SamS#api951';
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
					      	<Body>
					          	<GetCustomerByMobile xmlns=\"http://tempuri.org/\">
						            <GetCustomerByMobileRequest>
					                  	<UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
					                  	<Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
					                  	<CustomerMobile xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$sendermobile."</CustomerMobile>
					              	</GetCustomerByMobileRequest>
					          	</GetCustomerByMobile>
					      	</Body>
					    </Envelope>";
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $prabhu_url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS =>$postfield_data,
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: text/xml",
		    "SOAPAction: http://tempuri.org/ISend/GetCustomerByMobile"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		//print_r($json_obj);exit;
		$this->add_db_log("GetCustomerByMobile",$postfield_data,json_encode($json_obj),$prabhu_url,$user_id,0);
		

		if(isset($json_obj["sBody"]))
		{
			$sBody = $json_obj["sBody"];
			$GetCustomerByMobileResponse = $sBody["GetCustomerByMobileResponse"];
			if(isset($GetCustomerByMobileResponse["GetCustomerByMobileResult"]))
			{
				$GetCustomerByMobileResult = $GetCustomerByMobileResponse["GetCustomerByMobileResult"];
				if(isset($GetCustomerByMobileResult["aCode"]))
				{
					$aCode = trim($GetCustomerByMobileResult["aCode"]);
					if($aCode == "000")
					{
						
						$aMessage = trim($GetCustomerByMobileResult["aMessage"]);
						$aCustomers = $GetCustomerByMobileResult["aCustomers"]["aCustomer"];

						//print_r($aCustomers);exit;

						$aCustomerId = $aCustomers["aCustomerId"];
						$aName = $aCustomers["aName"];
						$aGender = $aCustomers["aGender"];
						$aDob = $aCustomers["aDob"];
						$aAddress = $aCustomers["aAddress"];
						$aMobile = $aCustomers["aMobile"];//array
						$Mobile = $aMobile["bstring"];






						$aCity = $aCustomers["aCity"];
						$aState = $aCustomers["aState"];
						$aDistrict = $aCustomers["aDistrict"];
						$aNationality = $aCustomers["aNationality"];
						$aEmployer = $aCustomers["aEmployer"];
						$aIncomeSource = $aCustomers["aIncomeSource"];
						$aStatus = $aCustomers["aStatus"];
						$aApproveStatus = $aCustomers["aApproveStatus"];//array
						$aApproveComment = $aCustomers["aApproveComment"];//array
						$aIds = $aCustomers["aIds"];//array
						$aIdType = $aIds["aId"]["aIdType"];
						$aIdNumber = $aIds["aId"]["aIdNumber"];


						$resp_benearray = array();
						$aReceivers = $aCustomers["aReceivers"];//array
						if(isset($aReceivers["aReceiver"]))
						{
							$aReceiver = $aReceivers["aReceiver"];
							
							if(isset( $aReceiver["aReceiverId"]))
							{
								$aReceiverId = $this->emptyarrayremove($aReceiver["aReceiverId"]);
								//echo $aReceiverId;exit;
								$aName = $this->emptyarrayremove($aReceiver["aName"]);
								$aGender = $this->emptyarrayremove($aReceiver["aGender"]);
								$aRelationship = $this->emptyarrayremove($aReceiver["aRelationship"]);
								$aAddress = $this->emptyarrayremove($aReceiver["aAddress"]);
								$aMobile = $this->emptyarrayremove($aReceiver["aMobile"]);
								$aPaymentMode = $this->emptyarrayremove($aReceiver["aPaymentMode"]);


								$aBankBranchId = $this->emptyarrayremove($aReceiver["aBankBranchId"]);
								$aBankName = $this->emptyarrayremove($aReceiver["aBankName"]);
								$aBankBranchName = $this->emptyarrayremove($aReceiver["aBankBranchName"]);
								$aAcNumber = $this->emptyarrayremove($aReceiver["aAcNumber"]);
								$temp_benearray = array(

									"ReceiverId"=>$aReceiverId,
									"Name"=>$aName,
									"Gender"=>$aGender,
									"Relationship"=>$aRelationship,
									"Address"=>$aAddress,
									"Mobile"=>$aMobile,
									"PaymentMode"=>$aPaymentMode,
									"BankBranchId"=>$aBankBranchId,
									"BankName"=>$aBankName,
									"BankBranchName"=>$aBankBranchName,
									"AcNumber"=>$aAcNumber,



									"beneficiaryId"=>$aReceiverId,
									"bankName"=>$aBankName,
									"bankId"=>$aBankBranchId,
									"accountHolderName"=>$aName,
									"accountNumber"=>$aAcNumber,
									"ifscCode"=>$aBankBranchName,
									"verifystatus"=>false,
									"verified_name"=>"",

									
									"MobileNo"=>$aMobile,
									"RPTID"=>$aReceiverId,
									"AccountNo"=>$aAcNumber,
									"IFSC"=>$aBankBranchId,
									"BankName"=>$aBankName,
									"Status"=>"Success",
									"IsValidate"=>false
								);
								//print_r($temp_benearray);exit;							
								array_push($resp_benearray,$temp_benearray);
							}
							else
							{
									$totalCount = 0;
								//print_r($aReceiver);exit;
								foreach($aReceiver as $bene)
								{
								
									$totalCount ++;
									$aReceiverId = $this->emptyarrayremove($bene["aReceiverId"]);
									//echo $aReceiverId;exit;
									$aName = $this->emptyarrayremove($bene["aName"]);
									$aGender = $this->emptyarrayremove($bene["aGender"]);
									$aRelationship = $this->emptyarrayremove($bene["aRelationship"]);
									$aAddress = $this->emptyarrayremove($bene["aAddress"]);
									$aMobile = $this->emptyarrayremove($bene["aMobile"]);
									$aPaymentMode = $this->emptyarrayremove($bene["aPaymentMode"]);


									$aBankBranchId = $this->emptyarrayremove($bene["aBankBranchId"]);
									$aBankName = $this->emptyarrayremove($bene["aBankName"]);
									$aBankBranchName = $this->emptyarrayremove($bene["aBankBranchName"]);
									$aAcNumber = $this->emptyarrayremove($bene["aAcNumber"]);
									$temp_benearray = array(

										"ReceiverId"=>$aReceiverId,
										"Name"=>$aName,
										"Gender"=>$aGender,
										"Relationship"=>$aRelationship,
										"Address"=>$aAddress,
										"Mobile"=>$aMobile,
										"PaymentMode"=>$aPaymentMode,
										"BankBranchId"=>$aBankBranchId,
										"BankName"=>$aBankName,
										"BankBranchName"=>$aBankBranchName,
										"AcNumber"=>$aAcNumber,



										"beneficiaryId"=>$aReceiverId,
										"bankName"=>$aBankName,
										"bankId"=>$aBankBranchId,
										"accountHolderName"=>$aName,
										"accountNumber"=>$aAcNumber,
										"ifscCode"=>$aBankBranchName,
										"verifystatus"=>false,
										"verified_name"=>"",

										
										"MobileNo"=>$aMobile,
										"RPTID"=>$aReceiverId,
										"AccountNo"=>$aAcNumber,
										"IFSC"=>$aBankBranchId,
										"BankName"=>$aBankName,
										"Status"=>"Success",
										"IsValidate"=>false
									);
									//print_r($temp_benearray);exit;							
									array_push($resp_benearray,$temp_benearray);
								}
							}	
						}
						


						$resp_arr = array(
												"message"=>"Beneficiary Fetch Successfully",
												"status"=>0,
												"statuscode"=>"TXN",
												"data"=>$resp_benearray,
												"StatusCode"=>1,
												"Message"=>"Success",
												"Data"=>$resp_benearray
											);
						return  json_encode($resp_arr);
						
					}
					else if($aCode == "666")
					{
						
						$aMessage = trim($GetCustomerByMobileResult["aMessage"]);

						$resp_array = array(
							"message"=>$aMessage,
							"status"=>1,
							"statuscode"=>"RNF",
							"StatusCode"=>2,
							"Message"=>"Sender Not Found",
						);
						return json_encode($resp_array);
					}
					else
					{
						print_r($json_obj);exit;
					}

				}
			}
		}

	
	}


//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////// C R E A T E     C U S T O M E R    ///////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////


public function sendOTP_CreateCustomer($sendermobile,$userinfo)
{


		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;


		$user_id = $userinfo->row(0)->user_id;

		define('PRABHU2_0WSDL','https://www.prabhuindia.com/Api/Send.svc?wsdl');
		define('PRABHU2_0USERNAME','SAMS_API');
		define('PRABHU2_0PASSWORD','SamS#api951');


		$insert_rslt = $this->db->query("insert into indonepal_CustomerRegistrationOtp(add_date,ipaddress,user_id,CustomerMobile) values(?,?,?,?)",
			array($this->common->getDate(),$this->common->getRealIpAddr(),$userinfo->row(0)->user_id,$sendermobile));
		if($insert_rslt == true)
		{
			$insert_id = $this->db->insert_id();
			$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <SendOTP xmlns=\"http://tempuri.org/\">
						            <SendOTPRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						                <Operation xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">CreateCustomer</Operation>
						                <Mobile xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$sendermobile."</Mobile>
						                <CustomerId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></CustomerId>
						                <ReceiverId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></ReceiverId>
						                <ReceiverName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></ReceiverName>
						                <PinNo xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></PinNo>
						            </SendOTPRequest>
						        </SendOTP>
						    </Body>
						</Envelope>";

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $prabhu_url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS =>$postfield_data,
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: text/xml",
		    "SOAPAction: http://tempuri.org/ISend/SendOTP"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		//print_r($json_obj);exit;
		$this->add_db_log("SendOTP_CreateCustomer",$postfield_data,json_encode($json_obj),$prabhu_url,$user_id,$insert_id);

			if(isset($json_obj["sBody"]))
			{
				$sBody = $json_obj["sBody"];
				$SendOTPResponse = $sBody["SendOTPResponse"];
				if(isset($SendOTPResponse["SendOTPResult"]))
				{
					$SendOTPResult = $SendOTPResponse["SendOTPResult"];
					
					if(isset($SendOTPResult["aCode"]))
					{
						$aCode = trim($SendOTPResult["aCode"]);
						if($aCode == "000")
						{
								
							$aMessage = trim($SendOTPResult["aMessage"]);
							$aProcessId = trim($SendOTPResult["aProcessId"]);
							$rslt_update = $this->db->query("update indonepal_CustomerRegistrationOtp set ProcessId=?,statuscode=?,ResponseMessage=? where Id = ?",array($aProcessId,$aCode,$aMessage,$insert_id));
							if($rslt_update == true)
							{
								$resp_array = array(
									"message"=>$aMessage,
									"status"=>0,
									"statuscode"=>"TXN",
									"ProcessId"=>$aProcessId,
									"Message"=>$aMessage,
									"StatusCode"=>1

								);
								return json_encode($resp_array);
							}
						}
						else if($aCode == "025" or $aCode == "035")
						{
							
							$aMessage = trim($SendOTPResult["aMessage"]);

							$resp_array = array(
								"message"=>$aMessage,
								"status"=>1,
								"statuscode"=>"RNF",
								"Message"=>$aMessage,
								"StatusCode"=>0
							);
							return json_encode($resp_array);
						}
						else
						{
							print_r($json_obj);exit;
						}

					}
				}
			}
		}
	}



public function createCustomer($Name,$Gender,$Dob,$Address,$Mobile,$State,$District,$City,$Nationality,$Email,$Employer,$IDType,$IDNumber,$IDExpiryDate,$IDIssuedPlace,$IncomeSource,$OTPProcessId,$OTP,$userinfo,$request_by)
{

	if($userinfo != null)
	{
		$user_id = $userinfo->row(0)->user_id;
		$usertype_name = $userinfo->row(0)->usertype_name;
		if($usertype_name == "Agent" or $usertype_name == "APIUSER")
		{
			$checkCustomerExist = $this->db->query("select user_id,Status from indonepal_customers where Mobile = ?",array($Mobile));
			if($checkCustomerExist->num_rows() >= 1)
			{
				$IN_status = $checkCustomerExist->row(0)->Status;
				if($IN_status == "Verified")
				{
					$resp_array = array(
						"status"=>1,
						"message"=>"User Already Registered",
						"statuscode"=>"ERR",
						"StatusCode"=>0,
						"Message"=>"User Already Registered"
					);
					return json_encode($resp_array);
				}
				else
				{

				}
			}
			else
			{
				$rsltinsert = $this->db->query("insert into indonepal_customers_temp(add_date, ipaddress, user_id, CustomerId, Name, Gender, Dob, Address, Mobile, City, State, District, Nationality, Employer, IncomeSource, Status,Email,IDType,IDNumber) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($this->common->getDate(),$this->common->getRealIpAddr(),$user_id,0,$Name,$Gender,$Dob,$Address,$Mobile,$City,$State,$District,$Nationality,$Employer,$IncomeSource,"Pending",$Email,$IDType,$IDNumber));
				if($rsltinsert == true)
				{
					$insert_id = $this->db->insert_id();
					$prabhu_url='https://www.prabhuindia.com/Api/Send.svc?wsdl';
					$prabhu_username='SAMS_API';
					$prabhu_password='SamS#api951';
					
					$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
							    <Body>
							        <CreateCustomer xmlns=\"http://tempuri.org/\">
							            <CreateCustomerRequest>
							                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
							                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
							                <Name xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$Name."</Name>
							                <Gender xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$Gender."</Gender>
							                <Dob xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$Dob."</Dob>
							                <Address xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$Address."</Address>
							                <Mobile xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$Mobile."</Mobile>
							                <State xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$State."</State>
							                <District xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$District."</District>
							                <City xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$City."</City>
							                <Nationality xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$Nationality."</Nationality>
							                <Email xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$Email."</Email>
							                <Employer xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$Employer."</Employer>
							                <IDType xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$IDType."</IDType>
							                <IDNumber xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$IDNumber."</IDNumber>
							                <IDExpiryDate xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></IDExpiryDate>
							                <IDIssuedPlace xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></IDIssuedPlace>
							                <IncomeSource xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$IncomeSource."</IncomeSource>
							                <OTPProcessId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$OTPProcessId."</OTPProcessId>
							                <OTP xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$OTP."</OTP>
							            </CreateCustomerRequest>
							        </CreateCustomer>
							    </Body>
							</Envelope>";

							$curl = curl_init();

							curl_setopt_array($curl, array(
							  CURLOPT_URL => $prabhu_url,
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING => "",
							  CURLOPT_MAXREDIRS => 10,
							  CURLOPT_TIMEOUT => 0,
							  CURLOPT_FOLLOWLOCATION => true,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => "POST",
							  CURLOPT_POSTFIELDS =>$postfield_data,
							  CURLOPT_HTTPHEADER => array(
							    "Content-Type: text/xml",
							    "SOAPAction: http://tempuri.org/ISend/CreateCustomer"
							  ),
							));

							$response = curl_exec($curl);

							curl_close($curl);
							$json_obj = $this->parsedata($response);
							$this->add_db_log("CreateCustomer",$postfield_data,json_encode($json_obj),$prabhu_url,$user_id,$insert_id);
							//print_r($json_obj);exit;

							if(isset($json_obj["sBody"]))
							{
								$sBody = $json_obj["sBody"];
								$CreateCustomerResponse = $sBody["CreateCustomerResponse"];
								if(isset($CreateCustomerResponse["CreateCustomerResult"]))
								{
									$CreateCustomerResult = $CreateCustomerResponse["CreateCustomerResult"];
									
									if(isset($CreateCustomerResult["aCode"]))
									{
										$aCode = trim($CreateCustomerResult["aCode"]);
										if($aCode == "000")
										{
											/*
											{"sBody":{"CreateCustomerResponse":{"CreateCustomerResult":{"aCode":"000","aMessage":"Success","aCustomerId":"9060"}}}}
											*/
												
											$aMessage = trim($CreateCustomerResult["aMessage"]);
											$aCustomerId = $CreateCustomerResult["aCustomerId"];
											
											
												$resp_array = array(
													"message"=>$aMessage,
													"status"=>0,
													"statuscode"=>"TXN",
													"aCustomerId"=>$aCustomerId,
													"Message"=>$aMessage,
													"StatusCode"=>1

												);
												return json_encode($resp_array);
											
										}
										else 
										{
											
											$aMessage = trim($CreateCustomerResult["aMessage"]);

											$resp_array = array(
												"message"=>$aMessage,
												"status"=>1,
												"statuscode"=>"RNF",
												"Message"=>$aMessage,
												"StatusCode"=>0
											);
											return json_encode($resp_array);
										}
										

									}
								}
							}

							/*
{"sBody":{"CreateCustomerResponse":{"CreateCustomerResult":{"aCode":"047","aMessage":"OTP Vefification Failed: Invalid Mobile OTP [002]","aCustomerId":[]}}}}
							*/
							$resp_array = array(
						"status"=>0,
						"message"=>"Transaction Done Successfully",
						"statuscode"=>"TXN",
						"StatusCode"=>1,
						"Message"=>"Transaction Done Successfully"
					);
					return json_encode($resp_array);
				}
			}
		}
	}
}








public function UploadCustomerDocument($CustomerId,$FileName,$DocumentType,$IDType,$FileBase64,$userinfo)
{
	error_reporting(-1);
	ini_set('display_errors',1);
	$this->db->db_debug = TRUE;


	$user_id = $userinfo->row(0)->user_id;


	$prabhu_url='https://www.prabhuindia.com/Api/Send.svc?wsdl';
	$prabhu_username='SAMS_API';
	$prabhu_password='SamS#api951';
	$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
                        <Body>
                            <UploadCustomerDocument xmlns=\"http://tempuri.org/\">
                                <UploadCustomerDocumentRequest>
                                    <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
                                    <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
                                    <CustomerId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[int]</CustomerId>
                                    <FileName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</FileName>
                                    <DocumentType xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$DocumentType."</DocumentType>
                                    <IDType xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$IDType."</IDType>
                                    <FileBase64 xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$FileBase64."</FileBase64>
                                </UploadCustomerDocumentRequest>
                            </UploadCustomerDocument>
                        </Body>
                    </Envelope>";
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $prabhu_url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS =>$postfield_data,
	  CURLOPT_HTTPHEADER => array(
	    "Content-Type: text/xml",
	    "SOAPAction: http://tempuri.org/ISend/GetCustomerByMobile"
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	$json_obj = $this->parsedata($response);
	//print_r($json_obj);exit;
	$this->add_db_log("GetCustomerByMobile",$postfield_data,json_encode($json_obj),$prabhu_url,$user_id,0);
	

	if(isset($json_obj["sBody"]))
	{
		$sBody = $json_obj["sBody"];
		$GetCustomerByMobileResponse = $sBody["GetCustomerByMobileResponse"];
		if(isset($GetCustomerByMobileResponse["GetCustomerByMobileResult"]))
		{
			$GetCustomerByMobileResult = $GetCustomerByMobileResponse["GetCustomerByMobileResult"];
			if(isset($GetCustomerByMobileResult["aCode"]))
			{
				$aCode = trim($GetCustomerByMobileResult["aCode"]);
				if($aCode == "000")
				{
					
					$aMessage = trim($GetCustomerByMobileResult["aMessage"]);
					$aCustomers = $GetCustomerByMobileResult["aCustomers"]["aCustomer"];

					//print_r($aCustomers);exit;

					$aCustomerId = $aCustomers["aCustomerId"];
					$aName = $aCustomers["aName"];
					$aGender = $aCustomers["aGender"];
					$aDob = $aCustomers["aDob"];
					$aAddress = $aCustomers["aAddress"];
					$aMobile = $aCustomers["aMobile"];//array
					$Mobile = $aMobile["bstring"];






					$aCity = $aCustomers["aCity"];
					$aState = $aCustomers["aState"];
					$aDistrict = $aCustomers["aDistrict"];
					$aNationality = $aCustomers["aNationality"];
					$aEmployer = $aCustomers["aEmployer"];
					$aIncomeSource = $aCustomers["aIncomeSource"];
					$aStatus = $aCustomers["aStatus"];
					$aApproveStatus = $aCustomers["aApproveStatus"];//array
					$aApproveComment = $aCustomers["aApproveComment"];//array
					$aIds = $aCustomers["aIds"];//array
					$aIdType = $aIds["aId"]["aIdType"];
					$aIdNumber = $aIds["aId"]["aIdNumber"];




					$checksender = $this->db->query("select * from indonepal_customers where Mobile = ?",array($sendermobile));
					if($checksender->num_rows() == 0)
					{
						$rsltinsertsender = $this->db->query("insert into indonepal_customers(add_date,ipaddress,user_id,CustomerId,Name,Gender,Dob,Address,Mobile,City,State,District,Nationality,Employer,IncomeSource,Status,ApproveStatus,ApproveComment,Email,IDType,IDNumber) 
							values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
							array($this->common->getDate(),$this->common->getRealIpAddr(),0,$aCustomerId,$aName,$aGender,$aDob,$aAddress,$Mobile,$aCity,$aState,$aDistrict,$aNationality,$aEmployer,$aIncomeSource,$aStatus,$aApproveStatus,$aApproveComment,"",$aIdType,$aIdNumber));
					}
							$resp_array = array(
								"Message"=>"Success",
								"StatusCode"=>3,
								"Data"=>array(
								"SenderMobile"=>$Mobile,
								"CustomerId"=>$aCustomerId,
								"Name"=>$aName,
								"Gender"=>$aGender,
								"Dob"=>$aDob,
								"Address"=>$aAddress,
								"City"=>$aCity,
								"State"=>$aState,
								"District"=>$aDistrict,
								"Nationality"=>$aNationality,
								"Employer"=>$aEmployer,
								"IncomeSource"=>$aIncomeSource,
								"Status"=>$aStatus,
								"ApproveStatus"=>$aApproveStatus,
								"ApproveComment"=>$aApproveComment,
								"Ids"=>$aIds,
								"IdType"=>$aIdType,
								"IdNumber"=>$aIdNumber)
							);
							return json_encode($resp_array);


					//$aTransactionCount = $aCustomers->aTransactionCount;//array
					//$aReceivers = $aCustomers->aReceivers;//array


				}
				else if($aCode == "666")
				{
					
					$aMessage = trim($GetCustomerByMobileResult["aMessage"]);

					$resp_array = array(
						"message"=>$aMessage,
						"status"=>1,
						"statuscode"=>"RNF",
						"StatusCode"=>2,
						"Message"=>"Sender Not Found",
					);
					return json_encode($resp_array);
				}
				else
				{
					print_r($json_obj);exit;
				}

			}
		}
	}

}


//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////// C R E A T E      R E C E I V E R    //////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////


public function sendOTP_CreateReceiver($sendermobile,$receiver_name,$PaymentMode,$BankBranchId,$AccountNumber,$userinfo)
{



		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;


		$user_id = $userinfo->row(0)->user_id;
		$customer_info = $this->db->query("SELECT CustomerId FROM `indonepal_customers` where Mobile = ?",array($sendermobile));
		if($customer_info->num_rows() == 1)
		{
			$CustomerId = $customer_info->row(0)->CustomerId;
			$insert_rslt = $this->db->query("insert into indonepal_ReceiverRegistrationOtp(add_date,ipaddress,user_id,CustomerMobile,CustomerId,ReceiverName,PaymentMode,BankBranchId,AccountNumber) values(?,?,?,?,?,?,?,?,?)",
			array($this->common->getDate(),$this->common->getRealIpAddr(),$userinfo->row(0)->user_id,$sendermobile,$CustomerId,$receiver_name,$PaymentMode,$BankBranchId,$AccountNumber));
		if($insert_rslt == true)
		{
			$insert_id = $this->db->insert_id();
			$prabhu_url='https://www.prabhuindia.com/Api/Send.svc?wsdl';
			$prabhu_username='SAMS_API';
			$prabhu_password='SamS#api951';
			$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
							    <Body>
							        <SendOTP xmlns=\"http://tempuri.org/\">
							            <SendOTPRequest>
							                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
							                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
							                <Operation xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">CreateReceiver</Operation>
							                <Mobile xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$sendermobile."</Mobile>
							                <CustomerId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$CustomerId."</CustomerId>
							                <ReceiverId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></ReceiverId>
							                <ReceiverName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$receiver_name."</ReceiverName>
							                <PinNo xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></PinNo>
							                <PaymentMode xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$PaymentMode."</PaymentMode>
							                <BankBranchId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$BankBranchId."</BankBranchId>
							                <AccountNumber xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$AccountNumber."</AccountNumber>
							            </SendOTPRequest>
							        </SendOTP>
							    </Body>
							</Envelope>";

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $prabhu_url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>$postfield_data,
			  CURLOPT_HTTPHEADER => array(
			    "Content-Type: text/xml",
			    "SOAPAction: http://tempuri.org/ISend/SendOTP"
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$json_obj = $this->parsedata($response);
			//print_r($json_obj);exit;
			$this->add_db_log("SendOTP_ReceiverCustomer",$postfield_data,json_encode($json_obj),$prabhu_url,$user_id,$insert_id);

				if(isset($json_obj["sBody"]))
				{
					$sBody = $json_obj["sBody"];
					$SendOTPResponse = $sBody["SendOTPResponse"];
					if(isset($SendOTPResponse["SendOTPResult"]))
					{
						$SendOTPResult = $SendOTPResponse["SendOTPResult"];
						
						if(isset($SendOTPResult["aCode"]))
						{
							$aCode = trim($SendOTPResult["aCode"]);
							if($aCode == "000")
							{
									
								$aMessage = trim($SendOTPResult["aMessage"]);
								$aProcessId = trim($SendOTPResult["aProcessId"]);
								$rslt_update = $this->db->query("update indonepal_ReceiverRegistrationOtp set ProcessId=?,statuscode=?,ResponseMessage=? where Id = ?",array($aProcessId,$aCode,$aMessage,$insert_id));
								if($rslt_update == true)
								{
									$resp_array = array(
										"message"=>$aMessage,
										"status"=>0,
										"statuscode"=>"TXN",
										"ProcessId"=>$aProcessId,
										"Message"=>$aMessage,
										"StatusCode"=>1

									);
									return json_encode($resp_array);
								}
							}
							else if($aCode == "025" or $aCode == "035")
							{
								
								$aMessage = trim($SendOTPResult["aMessage"]);

								$resp_array = array(
									"message"=>$aMessage,
									"status"=>1,
									"statuscode"=>"RNF",
									"Message"=>$aMessage,
									"StatusCode"=>0
								);
								return json_encode($resp_array);
							}
							else
							{
								print_r($json_obj);exit;
							}

						}
					}
				}
			}
		}
	}


public function CreateReceiver($sendermobile,$receiver_name,$Gender,$Receiver_mobile,$Address,$Relationship,$PaymentMode,$BankBranchId,$AccountNumber,$userinfo)
{



		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;


		$user_id = $userinfo->row(0)->user_id;
		$customer_info = $this->db->query("SELECT CustomerId FROM `indonepal_customers` where Mobile = ?",array($sendermobile));
		if($customer_info->num_rows() == 1)
		{
			$CustomerId = $customer_info->row(0)->CustomerId;
			
				$OTPProcessId = "";
				$Otp = "";
				$insert_rslt = $this->db->query("insert into indonepal_ReceiverRegistration(add_date,ipaddress,user_id,CustomerMobile,CustomerId,ReceiverName,Gender,Mobile,Relationship,Address,PaymentMode,BankBranchId,AccountNumber,ProcessId,Otp) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
			array($this->common->getDate(),$this->common->getRealIpAddr(),$userinfo->row(0)->user_id,$sendermobile,$CustomerId,$receiver_name,$Gender,$Receiver_mobile,$Relationship,$Address,$PaymentMode,$BankBranchId,$AccountNumber,$OTPProcessId,$Otp));

				if($insert_rslt == true)
				{
					$insert_id = $this->db->insert_id();
					
					$prabhu_url='https://www.prabhuindia.com/Api/Send.svc?wsdl';
					$prabhu_username='SAMS_API';
					$prabhu_password='SamS#api951';
					$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
								    <Body>
								        <CreateReceiver xmlns=\"http://tempuri.org/\">
								            <!-- Optional -->
								            <CreateReceiverRequest>
								                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
								                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
								                <CustomerId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$CustomerId."</CustomerId>
								                <Name xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$receiver_name."</Name>
								                <Gender xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$Gender."</Gender>
								                <Mobile xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$Receiver_mobile."</Mobile>
								                <Relationship xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$Relationship."</Relationship>
								                <Address xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$Address."</Address>
								                <PaymentMode xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$PaymentMode."</PaymentMode>
								                <BankBranchId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$BankBranchId."</BankBranchId>
								                <AccountNumber xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$AccountNumber."</AccountNumber>
								                <OTPProcessId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">47cc9ca6-7b25-468c-95fa-487449a5d98b</OTPProcessId>
								                <OTP xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">597374</OTP>
								                
								            </CreateReceiverRequest>
								        </CreateReceiver>
								    </Body>
								</Envelope>";

					$curl = curl_init();

					curl_setopt_array($curl, array(
					  CURLOPT_URL => $prabhu_url,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 0,
					  CURLOPT_FOLLOWLOCATION => true,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS =>$postfield_data,
					  CURLOPT_HTTPHEADER => array(
					    "Content-Type: text/xml",
					    "SOAPAction: http://tempuri.org/ISend/CreateReceiver"
					  ),
					));

					$response = curl_exec($curl);

					curl_close($curl);
					$json_obj = $this->parsedata($response);
					//print_r($json_obj);exit;
					$this->add_db_log("ReceiverRegistration",$postfield_data,json_encode($json_obj),$prabhu_url,$user_id,$insert_id);
					//print_r($json_obj);exit;

						if(isset($json_obj["sBody"]))
						{
							$sBody = $json_obj["sBody"];
							$CreateReceiverResponse = $sBody["CreateReceiverResponse"];
							if(isset($CreateReceiverResponse["CreateReceiverResult"]))
							{
								$CreateReceiverResult = $CreateReceiverResponse["CreateReceiverResult"];
								
								if(isset($CreateReceiverResult["aCode"]))
								{
									$aCode = trim($CreateReceiverResult["aCode"]);
									if($aCode == "000")
									{
											
										$aMessage = trim($CreateReceiverResult["aMessage"]);
										$aReceiverId = trim($CreateReceiverResult["aReceiverId"]);
										$rslt_update = $this->db->query("update indonepal_ReceiverRegistration set aReceiverId=?,aMessage=? where Id = ?",array($aReceiverId,$aMessage,$insert_id));
										if($rslt_update == true)
										{
											$resp_array = array(
												"message"=>$aMessage,
												"status"=>0,
												"statuscode"=>"TXN",
												"aReceiverId"=>$aReceiverId,
												"Message"=>$aMessage,
												"StatusCode"=>1

											);
											return json_encode($resp_array);
										}
									}
									else if($aCode == "025" or $aCode == "035")
									{
										
										$aMessage = trim($CreateReceiverResult["aMessage"]);

										$resp_array = array(
											"message"=>$aMessage,
											"status"=>1,
											"statuscode"=>"RNF",
											"Message"=>$aMessage,
											"StatusCode"=>0
										);
										return json_encode($resp_array);
									}
									else
									{
										$aMessage = trim($CreateReceiverResult["aMessage"]);

										$resp_array = array(
											"message"=>$aMessage,
											"status"=>1,
											"statuscode"=>"RNF",
											"Message"=>$aMessage,
											"StatusCode"=>0
										);
										return json_encode($resp_array);
									}

								}
							}
						}
					}
			
		}
	}

public function AcPayBankBranchList_db_insertion()
{	

		$prabhu_url='https://www.prabhuindia.com/Api/Send.svc?wsdl';
		$prabhu_username='SAMS_API';
		$prabhu_password='SamS#api951';
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
  						    <Body>
  						        <AcPayBankBranchList xmlns=\"http://tempuri.org/\">

  						            <AcPayBankBranchListRequest>
  						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
  						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
  						                <Country xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Nepal</Country>
  						                <State xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></State>
  						                <District xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></District>
  						                <City xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></City>
  						                <BankName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></BankName>
  						                <BranchName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></BranchName>
  						            </AcPayBankBranchListRequest>
  						        </AcPayBankBranchList>
  						    </Body>
      					</Envelope>";
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $prabhu_url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS =>$postfield_data,
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: text/xml",
		    "SOAPAction: http://tempuri.org/ISend/AcPayBankBranchList"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$json_obj =  $this->parsedata($response);
		
		if(isset($json_obj["sBody"]))
		{
			$sBody = $json_obj["sBody"];
			$AcPayBankBranchListResponse = $sBody["AcPayBankBranchListResponse"];
			
			if(isset($AcPayBankBranchListResponse["AcPayBankBranchListResult"]))
			{
				$AcPayBankBranchListResult = $AcPayBankBranchListResponse["AcPayBankBranchListResult"];
				
				if(isset($AcPayBankBranchListResult["aCode"]))
				{
					//print_r($AcPayBankBranchListResult);exit;
					$aCode = trim($AcPayBankBranchListResult["aCode"]);
					if($aCode == "000")
					{
							
						$this->db->query("truncate indonepal_BankBranches");
						$aMessage = trim($AcPayBankBranchListResult["aMessage"]);
						$aBankBranches = $AcPayBankBranchListResult["aBankBranches"];
						$aBankBranch = $aBankBranches["aBankBranch"];
						foreach($aBankBranch as $rw)
						{
							$aBankBranchId = $this->emptyarrayremove($rw["aBankBranchId"]);
							$aBankName = $this->emptyarrayremove($rw["aBankName"]);
							$aBranchName = $this->emptyarrayremove($rw["aBranchName"]);
							$aBranchCode = $this->emptyarrayremove($rw["aBranchCode"]);
							$aRoutingCode = $this->emptyarrayremove($rw["aRoutingCode"]);
							$aCountry = $this->emptyarrayremove($rw["aCountry"]);
							$aAddress = $this->emptyarrayremove($rw["aAddress"]);
							$aState = $this->emptyarrayremove($rw["aState"]);
							$aDistrict = $this->emptyarrayremove($rw["aDistrict"]);
							$aCity = $this->emptyarrayremove($rw["aCity"]);
							$aPhoneNumber = $this->emptyarrayremove($rw["aPhoneNumber"]);
							$this->db->query("insert into indonepal_BankBranches(Id,BankName,BranchName,BranchCode,RoutingCode,Country,Address,State,District,City,PhoneNumber) values(?,?,?,?,?,?,?,?,?,?,?)",
								array($aBankBranchId,$aBankName,$aBranchName,$aBranchCode,$aRoutingCode,$aCountry,$aAddress,$aState,$aDistrict,$aCity,$aPhoneNumber));

						}
					}
				}
			}
		}
	}
public function getBankName()
{
	$rslt = $this->db->query("select BankName from indonepal_BankBranches group by BankName order by BankName");
	return json_encode($rslt->result());
}
public function getBankCity($BankName)
{
	$rslt = $this->db->query("select City from indonepal_BankBranches where BankName = ? group by City order by City",array($BankName));
	return json_encode($rslt->result());
}

public function getBankBranch($City,$BankName)
{
	$rslt = $this->db->query("select Id,BranchName,BranchCode,Address,CONCAT(BranchName,' ',Address) as BranchAddress from indonepal_BankBranches where City = ? and BankName = ? order by BranchName",array($City,$BankName));
	return json_encode($rslt->result());
}































/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
////////////////////// S E R V I C E     C H A R G E    M E T H O D S  //////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

public function getServiceChargeByCollection($amount,$BankBranchId = "")
{
	$prabhu_url='https://www.prabhuindia.com/Api/Send.svc?wsdl';
	$prabhu_username='SAMS_API';
	$prabhu_password='SamS#api951';
	$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <GetServiceChargeByCollection xmlns=\"http://tempuri.org/\">
						            <!-- Optional -->
						            <GetServiceChargeByCollectionRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						                <Country xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Nepal</Country>
						                <PaymentMode xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Cash Payment</PaymentMode>
						                <CollectionAmount xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$amount."</CollectionAmount>
						                <PayoutAmount xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></PayoutAmount>
						                <BankBranchId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></BankBranchId>
						                <IsNewAccount xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></IsNewAccount>
						            </GetServiceChargeByCollectionRequest>
						        </GetServiceChargeByCollection>
						    </Body>
  					</Envelope>";

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $prabhu_url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS =>$postfield_data,
	  CURLOPT_HTTPHEADER => array(
	    "Content-Type: text/xml",
	    "SOAPAction: http://tempuri.org/ISend/GetServiceChargeByCollection"
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	$json_obj = $this->parsedata($response);
	if(isset($json_obj["sBody"]))
	{
		$sBody = $json_obj["sBody"];
		$GetServiceChargeByCollectionResponse = $sBody["GetServiceChargeByCollectionResponse"];
		if(isset($GetServiceChargeByCollectionResponse["GetServiceChargeByCollectionResult"]))
		{
			$GetServiceChargeByCollectionResult = $GetServiceChargeByCollectionResponse["GetServiceChargeByCollectionResult"];
			
			if(isset($GetServiceChargeByCollectionResult["aCode"]))
			{
				$aCode = trim($GetServiceChargeByCollectionResult["aCode"]);
				if($aCode == "000")
				{
					$GenderArray = array();

					$aMessage = trim($GetServiceChargeByCollectionResult["aMessage"]);
					$aCollectionAmount = $GetServiceChargeByCollectionResult["aCollectionAmount"];
					$aCollectionCurrency = $GetServiceChargeByCollectionResult["aCollectionCurrency"];
					$aServiceCharge = $GetServiceChargeByCollectionResult["aServiceCharge"];
					$aTransferAmount = $GetServiceChargeByCollectionResult["aTransferAmount"];
					$aExchangeRate = $GetServiceChargeByCollectionResult["aExchangeRate"];
					$aPayoutAmount = $GetServiceChargeByCollectionResult["aPayoutAmount"];
					$aPayoutCurrency = $GetServiceChargeByCollectionResult["aPayoutCurrency"];
					$ServiceChargeArray = array(
							"aCollectionAmount"=>$aCollectionAmount,
							"aCollectionCurrency"=>$aCollectionCurrency,
							"aServiceCharge"=>$aServiceCharge,
							"aTransferAmount"=>$aTransferAmount,
							"aExchangeRate"=>$aExchangeRate,
							"aPayoutAmount"=>$aPayoutAmount,
							"aPayoutCurrency"=>$aPayoutCurrency,
					);
					return json_encode($ServiceChargeArray);
					
				}
				else
				{
					print_r($json_obj);exit;
				}

			}
		}
	}

}
public function getServiceCharge($amount,$PaymentMode,$BankBranchId)
{
	$prabhu_url='https://www.prabhuindia.com/Api/Send.svc?wsdl';
	$prabhu_username='SAMS_API';
	$prabhu_password='SamS#api951';
	$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <GetServiceCharge xmlns=\"http://tempuri.org/\">
						            <!-- Optional -->
						            <GetServiceChargeRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						                <Country xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Nepal</Country>
						                <PaymentMode xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$PaymentMode."</PaymentMode>
						                <TransferAmount xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$amount."</TransferAmount>
						                <PayoutAmount xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></PayoutAmount>
						                <BankBranchId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$BankBranchId."</BankBranchId>
						                <IsNewAccount xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></IsNewAccount>
						            </GetServiceChargeRequest>
						        </GetServiceCharge>
						    </Body>
  					</Envelope>";
//echo $postfield_data;exit;
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $prabhu_url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS =>$postfield_data,
	  CURLOPT_HTTPHEADER => array(
	    "Content-Type: text/xml",
	    "SOAPAction: http://tempuri.org/ISend/GetServiceCharge"
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	$json_obj = $this->parsedata($response);
	//print_r($json_obj);exit;
	if(isset($json_obj["sBody"]))
	{
		$sBody = $json_obj["sBody"];
		$GetServiceChargeResponse = $sBody["GetServiceChargeResponse"];
		if(isset($GetServiceChargeResponse["GetServiceChargeResult"]))
		{
			$GetServiceChargeResult = $GetServiceChargeResponse["GetServiceChargeResult"];
			
			if(isset($GetServiceChargeResult["aCode"]))
			{
				$aCode = trim($GetServiceChargeResult["aCode"]);
				if($aCode == "000")
				{

					$aMessage = trim($GetServiceChargeResult["aMessage"]);
					$aCollectionAmount = $GetServiceChargeResult["aCollectionAmount"];
					$aCollectionCurrency = $GetServiceChargeResult["aCollectionCurrency"];
					$aServiceCharge = $GetServiceChargeResult["aServiceCharge"];
					$aTransferAmount = $GetServiceChargeResult["aTransferAmount"];
					$aExchangeRate = $GetServiceChargeResult["aExchangeRate"];
					$aPayoutAmount = $GetServiceChargeResult["aPayoutAmount"];
					$aPayoutCurrency = $GetServiceChargeResult["aPayoutCurrency"];
					$ServiceChargeArray = array(
							"aCollectionAmount"=>$aCollectionAmount,
							"aCollectionCurrency"=>$aCollectionCurrency,
							"aServiceCharge"=>$aServiceCharge,
							"aTransferAmount"=>$aTransferAmount,
							"aExchangeRate"=>$aExchangeRate,
							"aPayoutAmount"=>$aPayoutAmount,
							"aPayoutCurrency"=>$aPayoutCurrency,
					);
					return json_encode($ServiceChargeArray);
					
				}
				else
				{
					print_r($json_obj);exit;
				}

			}
		}
	}

}








/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
////////////////////// O T H E R    M E T H O D S  //////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////	
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
    										$rslt_updtrec = $this->db->query("update indonepal_transaction set reverted='yes',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),credit_amount = ? where Id = ?",array($current_balance2,$ewallet_id2,$totaldebit_amount,$transaction_id));	
    										
    										
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
    												a.IFSC from indonepal_transaction a
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
    										$rslt_updtrec = $this->db->query("update indonepal_transaction set reverted='yes',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),_amount = ? where Id = ?",array($current_balance,$ewallet_id,$dr_amount,$transaction_id));	
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




	public function getIdType()
	{
		$resp_array = array(
				"Aadhaar Card",
				"Indian Driving License",
				"Nepalese Citizenship",
				"Nepalese Passport",
				"Pan Card"
		);
		return json_encode($resp_array);
	}
	public function getIncomeSource()
	{
		$resp_array = array(
				"Business",
				"Gift",
				"Lotery",
				"Other",
				"Salary",
				"Saving"
		);
		return json_encode($resp_array);
	}






	//Note : Value must either of Gender, Nationality, IDType, IncomeSource, Relationship, PaymentMode, RemittanceReason, EntityType, Device, Connectivity, OffDay, COccupation, CQualification


public function getStaticData_Gender()//Gender
{
	$prabhu_url=PRABHU2_0WSDL;
	$prabhu_username=PRABHU2_0USERNAME;
	$prabhu_password=PRABHU2_0PASSWORD;
	$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <GetStaticData xmlns=\"http://tempuri.org/\">
						            <!-- Optional -->
						            <GetStaticDataRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						                <Type xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Gender</Type>
						            </GetStaticDataRequest>
						        </GetStaticData>
						    </Body>
  					</Envelope>";
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $prabhu_url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS =>$postfield_data,
	  CURLOPT_HTTPHEADER => array(
	    "Content-Type: text/xml",
	    "SOAPAction: http://tempuri.org/ISend/GetStaticData"
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	$json_obj = $this->parsedata($response);
	if(isset($json_obj["sBody"]))
	{
		$sBody = $json_obj["sBody"];
		$GetStaticDataResponse = $sBody["GetStaticDataResponse"];
		if(isset($GetStaticDataResponse["GetStaticDataResult"]))
		{
			$GetStaticDataResult = $GetStaticDataResponse["GetStaticDataResult"];
			
			if(isset($GetStaticDataResult["aCode"]))
			{
				$aCode = trim($GetStaticDataResult["aCode"]);
				if($aCode == "000")
				{
					$GenderArray = array();

					$aMessage = trim($GetStaticDataResult["aMessage"]);
					$aDataList = $GetStaticDataResult["aDataList"];
					foreach($aDataList["aData"] as $rw)
					{
						$GenderArray[$rw["aValue"]]= $rw["aLabel"];
						$temp_array = array(
							$rw["aValue"]=>$rw["aLabel"]
						);
					//	array_push($GenderArray,$temp_array);
					}
					return json_encode($GenderArray);
					
				}
				else
				{
					print_r($json_obj);exit;
				}

			}
		}
	}
	
}



public function getStaticData_IDType()//IDType
{
	$prabhu_url=PRABHU2_0WSDL;
	$prabhu_username=PRABHU2_0USERNAME;
	$prabhu_password=PRABHU2_0PASSWORD;
	$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <GetStaticData xmlns=\"http://tempuri.org/\">
						            <!-- Optional -->
						            <GetStaticDataRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						                <Type xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">IDType</Type>
						            </GetStaticDataRequest>
						        </GetStaticData>
						    </Body>
  					</Envelope>";
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $prabhu_url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS =>$postfield_data,
	  CURLOPT_HTTPHEADER => array(
	    "Content-Type: text/xml",
	    "SOAPAction: http://tempuri.org/ISend/GetStaticData"
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	$json_obj = $this->parsedata($response);

	print_r($json_obj);exit;

	if(isset($json_obj["sBody"]))
	{
		$sBody = $json_obj["sBody"];
		$GetStaticDataResponse = $sBody["GetStaticDataResponse"];
		if(isset($GetStaticDataResponse["GetStaticDataResult"]))
		{
			$GetStaticDataResult = $GetStaticDataResponse["GetStaticDataResult"];
			
			if(isset($GetStaticDataResult["aCode"]))
			{
				$aCode = trim($GetStaticDataResult["aCode"]);
				if($aCode == "000")
				{
					$GenderArray = array();

					$aMessage = trim($GetStaticDataResult["aMessage"]);
					$aDataList = $GetStaticDataResult["aDataList"];
					foreach($aDataList["aData"] as $rw)
					{
						$GenderArray[$rw["aValue"]]= $rw["aLabel"];
						$temp_array = array(
							$rw["aValue"]=>$rw["aLabel"]
						);
					//	array_push($GenderArray,$temp_array);
					}
					return json_encode($GenderArray);
					
				}
				else
				{
					print_r($json_obj);exit;
				}

			}
		}
	}
	
}





public function getStaticData_IncomeSource()//IncomeSource
{
	$prabhu_url=PRABHU2_0WSDL;
	$prabhu_username=PRABHU2_0USERNAME;
	$prabhu_password=PRABHU2_0PASSWORD;
	$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <GetStaticData xmlns=\"http://tempuri.org/\">
						            <!-- Optional -->
						            <GetStaticDataRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						                <Type xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">IncomeSource</Type>
						            </GetStaticDataRequest>
						        </GetStaticData>
						    </Body>
  					</Envelope>";
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $prabhu_url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS =>$postfield_data,
	  CURLOPT_HTTPHEADER => array(
	    "Content-Type: text/xml",
	    "SOAPAction: http://tempuri.org/ISend/GetStaticData"
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	$json_obj = $this->parsedata($response);

	//print_r($json_obj);exit;

	if(isset($json_obj["sBody"]))
	{
		$sBody = $json_obj["sBody"];
		$GetStaticDataResponse = $sBody["GetStaticDataResponse"];
		if(isset($GetStaticDataResponse["GetStaticDataResult"]))
		{
			$GetStaticDataResult = $GetStaticDataResponse["GetStaticDataResult"];
			
			if(isset($GetStaticDataResult["aCode"]))
			{
				$aCode = trim($GetStaticDataResult["aCode"]);
				if($aCode == "000")
				{
					$GenderArray = array();

					$aMessage = trim($GetStaticDataResult["aMessage"]);
					$aDataList = $GetStaticDataResult["aDataList"];
					foreach($aDataList["aData"] as $rw)
					{
						$GenderArray[$rw["aValue"]]= $rw["aLabel"];
						$temp_array = array(
							$rw["aValue"]=>$rw["aLabel"]
						);
					//	array_push($GenderArray,$temp_array);
					}
					return json_encode($GenderArray);
					
				}
				else
				{
					print_r($json_obj);exit;
				}

			}
		}
	}
	
}




public function getStaticData_Nationality()//Nationality
{
	$prabhu_url=PRABHU2_0WSDL;
	$prabhu_username=PRABHU2_0USERNAME;
	$prabhu_password=PRABHU2_0PASSWORD;
	$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <GetStaticData xmlns=\"http://tempuri.org/\">
						            <!-- Optional -->
						            <GetStaticDataRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						                <Type xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">City</Type>
						            </GetStaticDataRequest>
						        </GetStaticData>
						    </Body>
  					</Envelope>";
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $prabhu_url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS =>$postfield_data,
	  CURLOPT_HTTPHEADER => array(
	    "Content-Type: text/xml",
	    "SOAPAction: http://tempuri.org/ISend/GetStaticData"
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	$json_obj = $this->parsedata($response);
	//print_r($json_obj);exit;
	if(isset($json_obj["sBody"]))
	{
		$sBody = $json_obj["sBody"];
		$GetStaticDataResponse = $sBody["GetStaticDataResponse"];
		if(isset($GetStaticDataResponse["GetStaticDataResult"]))
		{
			$GetStaticDataResult = $GetStaticDataResponse["GetStaticDataResult"];
			
			if(isset($GetStaticDataResult["aCode"]))
			{
				$aCode = trim($GetStaticDataResult["aCode"]);
				if($aCode == "000")
				{

					$NationalityArray = array();

					$aMessage = trim($GetStaticDataResult["aMessage"]);
					$aDataList = $GetStaticDataResult["aDataList"];
					print_r($aDataList["aData"]);exit;
					foreach($aDataList["aData"] as $rw)
					{

						array_push($NationalityArray,$rw);
					}
					return json_encode($NationalityArray);
					
				}
				else
				{
					print_r($json_obj);exit;
				}

			}
		}
	}
	
}







public function getStateDistrictNepal()
{
		$prabhu_url='https://www.prabhuindia.com/Api/Send.svc?wsdl';
		$prabhu_username='SAMS_API';
		$prabhu_password='SamS#api951';
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
  						    <Body>
  						        <GetStateDistrict xmlns=\"http://tempuri.org/\">
  						            <!-- Optional -->
  						            <GetStateDistrictRequest>
  						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
  						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
  						                <Country xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Nepal</Country>
  						            </GetStateDistrictRequest>
  						        </GetStateDistrict>
  						    </Body>
      					</Envelope>";

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $prabhu_url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS =>$postfield_data,
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: text/xml",
		    "SOAPAction: http://tempuri.org/ISend/GetStateDistrict"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		if(isset($json_obj["sBody"]))
		{
			$sBody = $json_obj["sBody"];
			$GetStateDistrictResponse = $sBody["GetStateDistrictResponse"];
			if(isset($GetStateDistrictResponse["GetStateDistrictResult"]))
			{
				$GetStateDistrictResult = $GetStateDistrictResponse["GetStateDistrictResult"];
				
				if(isset($GetStateDistrictResult["aCode"]))
				{
					$aCode = trim($GetStateDistrictResult["aCode"]);
					if($aCode == "000")
					{
						$this->db->query("truncate indonepal_statedistrict");
						$stateArray = array();

						$aMessage = trim($GetStateDistrictResult["aMessage"]);
						$aDataList = $GetStateDistrictResult["aData"];

						foreach($aDataList["aStateDistrict"] as $rw)
						{

							$state= $rw["aState"];
							$District= $rw["aDistrict"];
							$this->db->query("insert into indonepal_statedistrict(aState,aDistrict) values(?,?)",
												array($state,$District));
						}
						echo "Task Completed";exit;
						
						
					}
					else
					{
						print_r($json_obj);exit;
					}

				}
			}
		}

	}



public function getStateDistrictIndia()
{
		$prabhu_url='https://www.prabhuindia.com/Api/Send.svc?wsdl';
		$prabhu_username='SAMS_API';
		$prabhu_password='SamS#api951';
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
  						    <Body>
  						        <GetStateDistrict xmlns=\"http://tempuri.org/\">
  						            <GetStateDistrictRequest>
  						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
  						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
  						                <Country xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">India</Country>
  						            </GetStateDistrictRequest>
  						        </GetStateDistrict>
  						    </Body>
      					</Envelope>";

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $prabhu_url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS =>$postfield_data,
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: text/xml",
		    "SOAPAction: http://tempuri.org/ISend/GetStateDistrict"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);

		if(isset($json_obj["sBody"]))
		{
			$sBody = $json_obj["sBody"];
			$GetStateDistrictResponse = $sBody["GetStateDistrictResponse"];
			if(isset($GetStateDistrictResponse["GetStateDistrictResult"]))
			{
				$GetStateDistrictResult = $GetStateDistrictResponse["GetStateDistrictResult"];
				
				if(isset($GetStateDistrictResult["aCode"]))
				{
					$aCode = trim($GetStateDistrictResult["aCode"]);
					if($aCode == "000")
					{
						$this->db->query("truncate indonepal_statedistrict_india");
						$stateArray = array();

						$aMessage = trim($GetStateDistrictResult["aMessage"]);
						$aDataList = $GetStateDistrictResult["aData"];

						foreach($aDataList["aStateDistrict"] as $rw)
						{

							$state= $rw["aState"];
							$District= $rw["aDistrict"];
							$StateCode= $rw["aStateCode"];
							$this->db->query("insert into indonepal_statedistrict_india(aState,aDistrict,aStateCode) values(?,?,?)",
												array($state,$District,$StateCode));
						}
						echo "Task Completed";exit;
						
						
					}
					else
					{
						print_r($json_obj);exit;
					}

				}
			}
		}

	}



	
}

?>
