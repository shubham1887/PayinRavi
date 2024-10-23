<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IndoNepal_logtest extends CI_Controller 
{
	public function emptyarrayremove($data)
	{
		if(is_array($data))
		{
			return "";
		}
		return $data;
	}
	public function checksender()
	{
		$sendermobile = '9920427176';
		$userinfo = $this->db->query("select * from tblusers where username = '8080623623'");
		$this->load->model("IndoNepalPrabhu");
		echo $this->IndoNepalPrabhu->getCustomerByMobile($sendermobile,$userinfo);
	}
	public function confirmtransaction()
	{
		$rslt = $this->db->query("select * from indonepal_transaction where aPinNo != '' and aMessage = 'Success' and aPinNo != '' and Date(add_date) = ?",array($this->common->getMySqlDate()));
		foreach($rslt->result() as $rw)
		{
			$aPinNo = $rw->aPinNo;
			$insert_id = $rw->Id;
			//echo $aPinNo;exit;
			//VerifyTransaction



		//define('PRABHU2_0WSDL','https://sandbox.prabhuindia.com/Api/Send.svc?wsdl');
		//define('PRABHU2_0USERNAME','SAMS_API');
		//define('PRABHU2_0PASSWORD','SamsApi@895');


			$prabhu_url='https://sandbox.prabhuindia.com/Api/Send.svc?wsdl';
			$prabhu_username='SAMS_API';
			$prabhu_password='SamsApi@895';
			$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <VerifyTransaction xmlns=\"http://tempuri.org/\">
						            <VerifyTransactionRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						                <PinNo xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$aPinNo."</PinNo>						                
						            </VerifyTransactionRequest>
						        </VerifyTransaction>
						    </Body>
						</Envelope>";


		//print htmlentities($postfield_data);
		//echo "<hr>";

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
		    "SOAPAction: http://tempuri.org/ISend/VerifyTransaction"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);


	
		$json_obj = $this->parsedata($response);
		/*
Array ( [sBody] => Array ( [VerifyTransactionResponse] => Array ( [VerifyTransactionResult] => Array ( [aCode] => 000 [aMessage] => Success [aPinNo] => 1111218813265190 ) ) ) )
		*/
		if(isset($json_obj["sBody"]))
		{
			$sBody = $json_obj["sBody"];
			$VerifyTransactionResponse = $sBody["VerifyTransactionResponse"];

			if(isset($VerifyTransactionResponse["VerifyTransactionResult"]))
			{
				$VerifyTransactionResult = $VerifyTransactionResponse["VerifyTransactionResult"];
				if(isset($VerifyTransactionResult["aCode"]))
				{
					$aCode = trim($VerifyTransactionResult["aCode"]);
					if($aCode == "000")
					{
							
						$aMessage = trim($VerifyTransactionResult["aMessage"]);
						$aPinNo = trim($VerifyTransactionResult["aPinNo"]);
						$rslt_update = $this->db->query("update indonepal_transaction set verify_status=?,verify_response=?,verify_code=? where Id = ?",array("Success",$aMessage,$aCode,$insert_id));	
					}
					
				}
			}
		}
		//print_r($json_obj);exit;
		}
	}
	public function response_parser()
	{
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;

		$response = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Body><VerifyTransactionResponse xmlns="http://tempuri.org/"><VerifyTransactionResult xmlns:a="http://schemas.datacontract.org/2004/07/Remit.API" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><a:Code>125</a:Code><a:Message>Transaction Detail not Match for Approval</a:Message><a:PinNo>1111211657324280</a:PinNo></VerifyTransactionResult></VerifyTransactionResponse></s:Body></s:Envelope>';

$json_obj = $this->parsedata($response);
//print_r($json_obj);exit;
		/*
Array ( [sBody] => Array ( [VerifyTransactionResponse] => Array ( [VerifyTransactionResult] => Array ( [aCode] => 000 [aMessage] => Success [aPinNo] => 1111218813265190 ) ) ) )
		*/
		if(isset($json_obj["sBody"]))
		{
			$sBody = $json_obj["sBody"];
			$VerifyTransactionResponse = $sBody["VerifyTransactionResponse"];

			if(isset($VerifyTransactionResponse["VerifyTransactionResult"]))
			{
				$VerifyTransactionResult = $VerifyTransactionResponse["VerifyTransactionResult"];
				if(isset($VerifyTransactionResult["aCode"]))
				{
					$aCode = trim($VerifyTransactionResult["aCode"]);
					if($aCode == "000")
					{
							
						$aMessage = trim($VerifyTransactionResult["aMessage"]);
						$aPinNo = trim($VerifyTransactionResult["aPinNo"]);
						$rslt_update = $this->db->query("update indonepal_transaction set verify_status=?,verify_response=?,verify_code=? where Id = ?",array("Success",$aMessage,$aCode,$insert_id));	
					}
					
				}
			}
		}
	}
	public function transfer()
	{
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
		if(isset($_GET["mobile"]))
		{
			$userinfo = $this->db->query("select * from tblusers where user_id = 7");
			$mobile = trim($this->input->get("mobile"));
			$receiver_id = trim($this->input->get("receiver_id"));
			$amount = trim($this->input->get("amount"));
			$RemittanceReason = "Family Maintanance";
			$order_id = "";
			if(strlen($mobile) == 10)
			{
				$sender_info = $this->db->query("select * from indonepal_customers_temp where Status = 'Success' and Mobile = ? ",array($mobile));
				if($sender_info->num_rows() == 1)
				{
					$receiver_info = $this->db->query("select * from indonepal_ReceiverRegistration where  aReceiverId = ? and CustomerMobile = ?",array($receiver_id,$mobile));
					if($receiver_info->num_rows() == 1)
					{
						$this->load->model("IndoNepalPrabhu");		
						$resp = $this->IndoNepalPrabhu->transfer($sender_info,$receiver_info,$userinfo,$order_id,$amount,$RemittanceReason);
						var_dump($resp);exit;
					}
				}			
			}
		}
	}
	public function samplelog()
	{
		/*
		<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:rem="http://schemas.datacontract.org/2004/07/Remit.API">
   <soapenv:Header/>
   <soapenv:Body>
      <tem:CreateCSP>
         <!--Optional:-->
         <tem:CreateCSPRequest>
            <rem:UserName>SAMS_API</rem:UserName>
            <rem:Password>SamsApi@895</rem:Password>
            <rem:CSPCode>8238232303</rem:CSPCode>
            <rem:EntityType>Individual</rem:EntityType>
            <rem:Name>Ravikant</rem:Name>
            <rem:State>Gujarat</rem:State>
            <rem:District>Ahmedabad</rem:District>
            <rem:City>Ahmedabad</rem:City>
            <rem:Address>Ahmedabad</rem:Address>
            <rem:PinCode>382418</rem:PinCode>
            <rem:Phone>8238232303</rem:Phone>
            <rem:Email>ravikantchavda365@gmail.com</rem:Email>
            <rem:IsOwnBranch>0</rem:IsOwnBranch>
            <!--Optional:-->
            <rem:PanNo>AIMPC2133L</rem:PanNo>
            <!--Optional:-->
            <rem:GSTIN></rem:GSTIN>
            <rem:Device>Laptop</rem:Device>
            <rem:Connectivity>Mobile</rem:Connectivity>
            <rem:StartTime>08:00:00</rem:StartTime>
            <rem:EndTime>21:00:00</rem:EndTime>
            <rem:OffDay>None</rem:OffDay>
            <rem:AcBankName>Punjab National Bank</rem:AcBankName>
            <rem:ACType>Saving</rem:ACType>
            <rem:ACIFSCCode>PUNB0096400</rem:ACIFSCCode>
            <rem:ACNumber>0964000102016012</rem:ACNumber>
            <rem:ContantPerson>Ravikant</rem:ContantPerson>
            <rem:CGender>Male</rem:CGender>
            <rem:CFatherName>Laxmanbhai</rem:CFatherName>
            <rem:CDob>1988-01-13</rem:CDob>
            <rem:CState>Gujarat</rem:CState>
            <rem:CDistrict>Ahmedabad</rem:CDistrict>
            <rem:CCity>Ahmedabad</rem:CCity>
            <rem:CAddress>Ahmedabad</rem:CAddress>
            <rem:CEmail>ravikantchavda365@gmail.com</rem:CEmail>
            <rem:CMobile>8238232303</rem:CMobile>
            <rem:COccupation>Self Employed</rem:COccupation>
            <rem:CQualification>Graduate</rem:CQualification>
            <rem:CIDType>Aadhaar Card</rem:CIDType>
            <rem:CIDNumber>XXXXXXXX5069</rem:CIDNumber>
         </tem:CreateCSPRequest>
      </tem:CreateCSP>
   </soapenv:Body>
</soapenv:Envelope>
		*/
	}
	public function __construct()
	{
		parent::__construct();		
		$this->load->helper('url');
		define('PRABHU2_0WSDL','https://sandbox.prabhuindia.com/Api/Send.svc?wsdl');
		define('PRABHU2_0USERNAME','SAMS_API');
		define('PRABHU2_0PASSWORD','SamsApi@895');
		$this->load->model("IndoNepalPrabhu");

		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
		//$amount = "100";
		//$PaymentMode = "Cash Payment";
		//$BankBranchId = "";
		//$resp = $this->IndoNepalPrabhu->getServiceCharge($amount,$PaymentMode,$BankBranchId);
		//print_r($resp);exit;

//		 $client = new SoapClient("https://sandbox.prabhuindia.com/Api/Send.svc?wsdl");
//var_dump($client->__getFunctions());    
//var_dump($client->__getTypes());exit;

	}

public function createCSP2()
{
	$req  = '<UserName>SAMS_API</UserName>
            <Password>SamsApi@895</Password>
            <CSPCode>8238232303</CSPCode>
            <EntityType>Individual</EntityType>
            <Name>Ravikant</Name>
            <State>Gujarat</State>
            <District>Ahmedabad</District>
            <City>Ahmedabad</City>
            <Address>Ahmedabad</Address>
            <PinCode>382418</PinCode>
            <Phone>8238232303</Phone>
            <Email>ravikantchavda365@gmail.com</Email>
            <IsOwnBranch>0</IsOwnBranch>
            <!--Optional:-->
            <PanNo>AIMPC2133L</PanNo>
            <!--Optional:-->
            <GSTIN></GSTIN>
            <Device>Laptop</Device>
            <Connectivity>Mobile</Connectivity>
            <StartTime>08:00:00</StartTime>
            <EndTime>21:00:00</EndTime>
            <OffDay>None</OffDay>
            <AcBankName>Punjab National Bank</AcBankName>
            <ACType>Saving</ACType>
            <ACIFSCCode>PUNB0096400</ACIFSCCode>
            <ACNumber>0964000102016012</ACNumber>
            <ContantPerson>Ravikant</ContantPerson>
            <CGender>Male</CGender>
            <CFatherName>Laxmanbhai</CFatherName>
            <CDob>1988-01-13</CDob>
            <CState>Gujarat</CState>
            <CDistrict>Ahmedabad</CDistrict>
            <CCity>Ahmedabad</CCity>
            <CAddress>Ahmedabad</CAddress>
            <CEmail>ravikantchavda365@gmail.com</CEmail>
            <CMobile>8238232303</CMobile>
            <COccupation>Self Employed</COccupation>
            <CQualification>Graduate</CQualification>
            <CIDType>Aadhaar Card</CIDType>
            <CIDNumber>XXXXXXXX5069</CIDNumber>';
}
public function createCSP()
{
	$insert_id = $this->db->insert_id();
	$prabhu_url='https://sandbox.prabhuindia.com/Api/Send.svc?wsdl';
	$prabhu_username='SAMS_API';
	$prabhu_password='SamsApi@895';


	$Entity_type_array = array(
		"Individual","Partnership Firm","Sole Proprietor"
	);
	$Mobile = "8238232303";
	$EntityType = "Individual";
	$Name = "Ravikant";
	$State = "Gujarat";
	$District = "Ahmedabad";
	$City = "Ahmedabad";
	$Address = "Ahmedabad";
	$PinCode = '382418';
	$GSTIN = '';
	$Email = "ravikantchavda365@gmail.com";
	$IsOwnBranch = "yes";
	$PanNo = "AIMPC2133L";
	$Device = '';
	$Connectivity = '';
	$StartTime = '';
	$EndTime = '';
	$OffDay = '';
	$AcBankName='Punjab National Bank';
	$ACType='Saving';
	$ACIFSCCode='PUNB0096400';
	$ACNumber='0964000102016012';
	$ContantPerson='Ravikant';
	$CGender='Male';
	$CFatherName='Laxmanbhai';
	$CDob='13-01-1988';
	$CState='Gujarat';
	$CDistrict='Ahmedabad';
	$CCity='Ahmedabad';
	$CAddress='Ahmedabad';
	$CEmail='ravikantchavda365@gmail.com';
	$CMobile='8238232303';
	$COccupation='Business';
	$CQualification='';
	$CIDType='Aadhaar Card';
	$CIDNumber = '696850545069';

	$postfield_data='<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
			    <Body>
			        <CreateCSP xmlns="http://tempuri.org/">
			            <CreateCSPRequest>
			                <UserName  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">SAMS_API</UserName>
				            <Password  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">SamsApi@895</Password>
				            <CSPCode  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">8238232303</CSPCode>
				            <EntityType  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Individual</EntityType>
				            <Name  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Ravikant</Name>
				            <State  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Gujarat</State>
				            <District  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Ahmedabad</District>
				            <City  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Ahmedabad</City>
				            <Address  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Ahmedabad</Address>
				            <PinCode  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">382418</PinCode>
				            <Phone  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">8238232303</Phone>
				            <Email  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">ravikantchavda365@gmail.com</Email>
				            <IsOwnBranch  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">0</IsOwnBranch>
				            <PanNo  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">AIMPC2133L</PanNo>
				            <GSTIN  xmlns="http://schemas.datacontract.org/2004/07/Remit.API"></GSTIN>
				            <Device  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Laptop</Device>
				            <Connectivity  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Mobile</Connectivity>
				            <StartTime  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">08:00:00</StartTime>
				            <EndTime  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">21:00:00</EndTime>
				            <OffDay  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">None</OffDay>
				            <AcBankName  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Punjab National Bank</AcBankName>
				            <ACType  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Saving</ACType>
				            <ACIFSCCode  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">PUNB0096400</ACIFSCCode>
				            <ACNumber  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">0964000102016012</ACNumber>
				            <ContantPerson  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Ravikant</ContantPerson>
				            <CGender  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Male</CGender>
				            <CFatherName  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Laxmanbhai</CFatherName>
				            <CDob  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">1988-01-13</CDob>
				            <CState  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Gujarat</CState>
				            <CDistrict  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Ahmedabad</CDistrict>
				            <CCity  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Ahmedabad</CCity>
				            <CAddress  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Ahmedabad</CAddress>
				            <CEmail  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">ravikantchavda365@gmail.com</CEmail>
				            <CMobile  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">8238232303</CMobile>
				            <COccupation  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Self Employed</COccupation>
				            <CQualification  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Graduate</CQualification>
				            <CIDType  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Aadhaar Card</CIDType>
				            <CIDNumber  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">696850545069</CIDNumber>
			            </CreateCSPRequest>
			        </CreateCSP>
			    </Body>
			</Envelope>';



//print htmlentities($postfield_data);exit;
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
			    "SOAPAction: http://tempuri.org/ISend/CreateCSP"
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$json_obj = $this->parsedata($response);


			echo json_encode($json_obj);exit;

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



	public function test()
	{
		$amount = 100;
		if(isset($_GET["amount"]))
		{
			$amount = $this->input->get("amount");
		}
		$resp = $this->IndoNepalPrabhu->getServiceCharge($amount);
		echo $resp;exit;
	}
	public function branchlist()
	{

		$this->IndoNepalPrabhu->AcPayBankBranchList();
	}
	public function createreceiver_tets()
	{
		error_reporting(-1);
		ini_set('display_errors',1);
					$prabhu_url='https://sandbox.prabhuindia.com/Api/Send.svc?wsdl';
					$prabhu_username='SAMS_API';
					$prabhu_password='SamsApi@895';
					$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <CreateReceiver xmlns=\"http://tempuri.org/\">
						            <!-- Optional -->
						            <CreateReceiverRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						                <CustomerId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">9060</CustomerId>
						                <Name xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Rajni Chavda</Name>
						                <Gender xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Male</Gender>
						                <Mobile xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">98546548</Mobile>
						                <Relationship xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Brother</Relationship>
						                <Address xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Raiya Chawkadi</Address>
						                <PaymentMode xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Cash Payment</PaymentMode>
						                <BankBranchId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></BankBranchId>
						                <AccountNumber xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></AccountNumber>
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
					    "SOAPAction: http://tempuri.org/ISend/SendOTP"
					  ),
					));

					$response = curl_exec($curl);

					curl_close($curl);
var_dump($response);exit;





	}
	public function test_response()
	{
		$resp = '{"sBody":{"CreateCustomerResponse":{"CreateCustomerResult":{"aCode":"049","aMessage":"Invalid State [302]","aCustomerId":[]}}}}';
		$json_obj = (array)json_decode($resp);
		//print_r($json_obj);exit;
		if(isset($json_obj["sBody"]))
		{
			$sBody = (array)$json_obj["sBody"];
			$CreateCustomerResponse = (array)$sBody["CreateCustomerResponse"];
			if(isset($CreateCustomerResponse["CreateCustomerResult"]))
			{
				$CreateCustomerResult = (array)$CreateCustomerResponse["CreateCustomerResult"];
				
				if(isset($CreateCustomerResult["aCode"]))
				{
					$aCode = trim($CreateCustomerResult["aCode"]);

					if($aCode == "000")
					{
							
						$aMessage = trim($CreateCustomerResult["aMessage"]);
						echo $aMessage;exit;
						$aCustomerId = $SendOTPResult["aCustomerId"];
						
						
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
						echo  json_encode($resp_array);
					}
					

				}
			}
		}
	}

	public function test_getSendrInfo()
	{
		if(isset($_GET["sendermobile"]))
		{
			$sendermobile = trim($this->input->get("sendermobile"));
			$userinfo = $this->db->query("select * from tblusers where usertype_name = 'Agent' order by user_id limit 1");

			$response = $this->IndoNepalPrabhu->getCustomerByMobile($sendermobile,$userinfo);
			echo $response;exit;

				
		}
	}
	public function test_getSendrOtp()
	{
		if(isset($_GET["sendermobile"]))
		{
			$sendermobile = trim($this->input->get("sendermobile"));
			$userinfo = $this->db->query("select * from tblusers where usertype_name = 'Agent' order by user_id limit 1");

			$response = $this->IndoNepalPrabhu->sendOTP_CreateCustomer($sendermobile,$userinfo);
			echo $response;exit;

				
		}

		
	}

	public function test_createCustomer()
	{
		if(isset($_GET["sendermobile"]))
		{
			$sendermobile = trim($this->input->get("sendermobile"));
			$userinfo = $this->db->query("select * from tblusers where usertype_name = 'Agent' order by user_id limit 1");

			$response = $this->IndoNepalPrabhu->createCustomer($Name,$Gender,$Dob,$Address,$Mobile,$State,$District,$City,$Nationality,$Email,$Employer,$IDType,$IDNumber,$IDExpiryDate,$IDIssuedPlace,$IncomeSource,$OTPProcessId,$OTP);
			echo $response;exit;

				
		}
		
	}

	public function test_getGender()
	{
			$userinfo = $this->db->query("select * from tblusers where usertype_name = 'Agent' order by user_id limit 1");

			$response = $this->IndoNepalPrabhu->getStaticData_Gender();
			echo $response;exit;
	}
	public function test_getNationality()
	{
			$userinfo = $this->db->query("select * from tblusers where usertype_name = 'Agent' order by user_id limit 1");

			$response = $this->IndoNepalPrabhu->getStaticData_Nationality();
			echo $response;exit;
	}

	public function test_getIDType()
	{
			$userinfo = $this->db->query("select * from tblusers where usertype_name = 'Agent' order by user_id limit 1");

			$response = $this->IndoNepalPrabhu->getStaticData_IDType();
			echo $response;exit;
	}
	public function test_getIncomeSource()
	{
			$userinfo = $this->db->query("select * from tblusers where usertype_name = 'Agent' order by user_id limit 1");

			$response = $this->IndoNepalPrabhu->getStaticData_IncomeSource();
			echo $response;exit;
	}

	public function test_getState_nepal()
	{
		$this->load->model("IndoNepalPrabhu");
		echo $this->IndoNepalPrabhu->getStateDistrictNepal();
	}

	public function test_getState_india()
	{
		$this->load->model("IndoNepalPrabhu");
		echo $this->IndoNepalPrabhu->getStateDistrictIndia();
	}









	function parsedata($soapResponse)
	{
		$xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $soapResponse);
		$xml = simplexml_load_string($xml);
		$json = json_encode($xml);
		return $responseArray = json_decode($json,true);
		
		exit;
	}
	public function index()
	{
		$this->load->view('Home');
	}
	public function AcPayBankBranchList()
	{	
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
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
		$resp =  $this->parsedata($response);
		print_r($resp);exit;
	}
	public function CashPayLocationList()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
  						    <Body>
  						        <CashPayLocationList xmlns=\"http://tempuri.org/\">
  						            <CashPayLocationListRequest>
  						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
  						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
  						                <Country xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Nepal</Country>
  						                <State xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></State>
  						                <District xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></District>
  						                <City xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></City>
  						                <LocationName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></LocationName>
  						            </CashPayLocationListRequest>
  						        </CashPayLocationList>
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
		    "SOAPAction: http://tempuri.org/ISend/CashPayLocationList"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		print_r($json_obj);exit;
	}

	public function getCustomerByMobile()
	{

		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;

		$sendermobile='8306889227';
		// $mobile='8866628967';
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
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
							$rsltinsertsender = $this->db->query("insert into indonepal_customers(add_date,ipaddress,user_id,CustomerId,Name,Gender,Dob,Address,Mobile,City,State,District,Nationality,Employer,IncomeSource,Status) 
								values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
								array($this->common->getDate(),$this->common->getRealIpAddr(),0,$aCustomerId,$aName,$aGender,$aDob,$aAddress,$Mobile,$aCity,$aState,$aDistrict,$aNationality,$aEmployer,$aIncomeSource,$aStatus));
							if($rsltinsertsender  == true)
							{
								$insert_id = $this->db->insert_id();



								$resp_array = array(
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
									"Status"=>$aStatus
								);
								echo json_encode($resp_array);exit;

							}



						}


						//$aTransactionCount = $aCustomers->aTransactionCount;//array
						//$aReceivers = $aCustomers->aReceivers;//array


					}

				}
			}
		}

	}





	public function getCustomerByIdNumber()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
  						    <Body>
  						        <GetCustomerByIdNumber xmlns=\"http://tempuri.org/\">
  						            <!-- Optional -->
  						            <GetCustomerByIdNumberRequest>
  						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
  						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
  						                <CustomerIdNo xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">684536312941</CustomerIdNo>
  						            </GetCustomerByIdNumberRequest>
  						        </GetCustomerByIdNumber>
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
		    "SOAPAction: http://tempuri.org/ISend/GetCustomerByIdNumber"
		  ),
		));
 
		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		print_r($json_obj);exit;
		// 684536312941
		// 687281411623 
	}



	///////
	////// API No 9 : getServiceCharge
	////////////////////////////////
	public function getServiceCharge()
	{
		$amount = 100;
		if(isset($_GET["amount"]))
		{
			$amount = trim($this->input->get("amount"));
		}
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
  						    <Body>
  						        <GetServiceCharge xmlns=\"http://tempuri.org/\">
		  				            <GetServiceChargeRequest>
		  				                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
		  				                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
		  				                <Country xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Nepal</Country>
		  				                <PaymentMode xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">CashPayment</PaymentMode>
		  				                <TransferAmount xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$amount."</TransferAmount>
		  				                <PayoutAmount xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></PayoutAmount>
		  				                <BankBranchId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></BankBranchId>
		  				                <IsNewAccount xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></IsNewAccount>
		  				            </GetServiceChargeRequest>
		  				        </GetServiceCharge>
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
		    "SOAPAction: http://tempuri.org/ISend/GetServiceCharge"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		print_r($json_obj);exit;

	}


	public function getServiceChargeAccDeposit()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
  						    <Body>
  						        <GetServiceCharge xmlns=\"http://tempuri.org/\">
  						            <GetServiceChargeRequest>
  						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
  						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
  						                <Country xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Nepal</Country>
  						                <PaymentMode xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">CashPayment</PaymentMode>
  						                <TransferAmount xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">100</TransferAmount>
  						                <PayoutAmount xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></PayoutAmount>
  						                <BankBranchId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">5</BankBranchId>
  						                <IsNewAccount xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></IsNewAccount>
  						            </GetServiceChargeRequest>
  						        </GetServiceCharge>
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
		    "SOAPAction: http://tempuri.org/ISend/GetServiceCharge"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		print_r($json_obj);exit;
	}



	public function getServiceChargeByCollectionAccDeposit()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
  						    <Body>
  						        <GetServiceChargeByCollection xmlns=\"http://tempuri.org/\">
  						            <!-- Optional -->
  						            <GetServiceChargeByCollectionRequest>
  						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
  						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
  						                <Country xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Nepal</Country>
  						                <PaymentMode xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Account Deposit</PaymentMode>
  						                <CollectionAmount xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">300</CollectionAmount>
  						                <PayoutAmount xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></PayoutAmount>
  						                <BankBranchId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">5</BankBranchId>
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
		print_r($json_obj);exit;

	}
	public function getServiceChargeByCollection()
	{
		$amount = 100;
		if(isset($_GET["amount"]))
		{
			$amount = trim($this->input->get("amount"));
		}
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
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
		print_r($json_obj);exit;

	}
	public function getStateDistrictNepal()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
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
		print_r($json_obj);exit;

	}
	public function getStateDistrictIndia()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
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
		echo $response;

	}

	public function getBalance()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
  						    <Body>
  						        <GetBalance xmlns=\"http://tempuri.org/\">
  						            <GetBalanceRequest>
  						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
  						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
  						            </GetBalanceRequest>
  						        </GetBalance>
  						    </Body>
      					</Envelope>";



      $postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
  						    <Body>
  						        <tem:GetStaticDataRequest>
 <rem:UserName>".$prabhu_username."</rem:UserName>
 <rem:Password>".$prabhu_password."</rem:Password>
 <rem:Type>Gender</rem:Type>
 </tem:GetStaticDataRequest>
  						    </Body>
      					</Envelope>";

      
      	print htmlentities($postfield_data);
      	echo "<hr>";

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
		    "SOAPAction: http://tempuri.org/ISend/GetBalance"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		print_r($json_obj);exit;

	}


	////
	/// api no 11 : get static data (Gender)
	/////////////////////////////
	public function getStaticDataGender()//Gender
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
  						                <Type xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">EntityType</Type>
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
	}
	public function getStaticDataIDType()///Id Type
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
	}
	public function getStaticDataNationality()//Nationality
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
  						                <Type xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Nationality</Type>
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

	}
	public function getStaticDataIncomeSource()//income source
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
		print_r($json_obj);exit;
	}

	public function getStaticDataRelationship()//relationship
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
  						                <Type xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Relationship</Type>
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
	}
	public 	function getStaticDataPaymentMode()//payment Mode
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
  						                <Type xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">PaymentMode</Type>
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

	}

	public function getStaticDataRemittanceReason()
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
  						                <Type xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">RemittanceReason</Type>
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

	}
	public function searchTransactions()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
  						    <Body>
  						        <SearchTransaction xmlns=\"http://tempuri.org/\">
  						            <!-- Optional -->
  						            <SearchTransactionRequest>
  						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
  						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
  						                <PinNo xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></PinNo>
  						                <PartnerPinNo xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></PartnerPinNo>
  						                <FromDate xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></FromDate>
  						                <ToDate xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></ToDate>
  						            </SearchTransactionRequest>
  						        </SearchTransaction>
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
		    "SOAPAction: http://tempuri.org/ISend/SearchTransaction"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		print_r($json_obj);exit;

	}
	public function complianceTransactions()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <ComplianceTransactions xmlns=\"http://tempuri.org/\">
						            <ComplianceTransactionsRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
										<Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						            </ComplianceTransactionsRequest>
						        </ComplianceTransactions>
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
		    "SOAPAction: http://tempuri.org/ISend/ComplianceTransactions"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		print_r($json_obj);exit;
	}

	public function unverifiedTransactions()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <UnverifiedTransactions xmlns=\"http://tempuri.org/\">
						            <UnverifiedTransactionsRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
										<Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						            </UnverifiedTransactionsRequest>
						        </UnverifiedTransactions>
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
		    "SOAPAction: http://tempuri.org/ISend/UnverifiedTransactions"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		print_r($json_obj);exit;
	}
	public function sendOTP()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <SendOTP xmlns=\"http://tempuri.org/\">
						            <SendOTPRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						                <Operation xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">CreateReceiver</Operation>
						                <Mobile xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">8306889227</Mobile>
						                <CustomerId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">7843</CustomerId>
						                <ReceiverId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></ReceiverId>
						                <ReceiverName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Brijesh Solanki Receiver</ReceiverName>
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
		print_r($json_obj);exit;
	}

	public function createCustomer()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
							    <Body>
							        <CreateCustomer xmlns=\"http://tempuri.org/\">
							            <CreateCustomerRequest>
							                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
							                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
							                <Name xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Brijesh Solanki</Name>
							                <Gender xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Male</Gender>
							                <Dob xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">1987-03-07</Dob>
							                <Address xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Raiya Chawkadi</Address>
							                <Mobile xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">8306889227</Mobile>
							                <State xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Gujarat</State>
							                <District xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Rajkot</District>
							                <City xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Rajkot</City>
							                <Nationality xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Indian</Nationality>
							                <Email xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></Email>
							                <Employer xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Champion</Employer>
							                <IDType xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Aadhaar Card</IDType>
							                <IDNumber xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">684536312941</IDNumber>
							                <IDExpiryDate xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></IDExpiryDate>
							                <IDIssuedPlace xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></IDIssuedPlace>
							                <IncomeSource xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Salary</IncomeSource>
							                <OTPProcessId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">48606b65-1ae5-4ffa-ab86-5af69b18236e</OTPProcessId>
							                <OTP xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">603334</OTP>
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
		print_r($json_obj);exit;
	}

	public function createReceiver()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <CreateReceiver xmlns=\"http://tempuri.org/\">
						            <!-- Optional -->
						            <CreateReceiverRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						                <CustomerId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">9060</CustomerId>
						                <Name xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">RajniKant</Name>
						                <Gender xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Male</Gender>
						                <Mobile xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">9854654880</Mobile>
						                <Relationship xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Brother</Relationship>
						                <Address xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Raiya Chawkadi</Address>
						                <PaymentMode xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">Cash Payment</PaymentMode>
						                <BankBranchId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></BankBranchId>
						                <AccountNumber xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\"></AccountNumber>
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
		print_r($json_obj);exit;
	}

	public function uploadCustomerDocument()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <UploadCustomerDocument xmlns=\"http://tempuri.org/\">
						            <UploadCustomerDocumentRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						                <CustomerId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[int]</CustomerId>
						                <FileName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</FileName>
						                <DocumentType xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</DocumentType>
						                <IDType xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</IDType>
						                <FileBase64 xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</FileBase64>
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
		    "SOAPAction: http://tempuri.org/ISend/UploadCustomerDocument"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		print_r($json_obj);exit;
	}
	public function sendTransaction()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <SendTransaction xmlns=\"http://tempuri.org/\">
						            <!-- Optional -->
						            <SendTransactionRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						                <CustomerId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[int]</CustomerId>
						                <SenderName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</SenderName>
						                <SenderGender xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</SenderGender>
						                <SenderDoB xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</SenderDoB>
						                <SenderAddress xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</SenderAddress>
						                <SenderPhone xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string?]</SenderPhone>
						                <SenderMobile xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</SenderMobile>
						                <SenderCity xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</SenderCity>
						                <SenderDistrict xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</SenderDistrict>
						                <SenderState xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</SenderState>
						                <SenderNationality xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</SenderNationality>
						                <Employer xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</Employer>
						                <SenderIDType xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</SenderIDType>
						                <SenderIDNumber xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</SenderIDNumber>
						                <SenderIDExpiryDate xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string?]</SenderIDExpiryDate>
						                <SenderIDIssuedPlace xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string?]</SenderIDIssuedPlace>
						                <ReceiverId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[int]</ReceiverId>
						                <ReceiverName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</ReceiverName>
						                <ReceiverGender xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</ReceiverGender>
						                <ReceiverAddress xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</ReceiverAddress>
						                <ReceiverMobile xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</ReceiverMobile>
						                <ReceiverCity xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</ReceiverCity>
						                <SendCountry xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</SendCountry>
						                <PayoutCountry xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</PayoutCountry>
						                <PaymentMode xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</PaymentMode>
						                <CollectedAmount xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</CollectedAmount>
						                <ServiceCharge xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</ServiceCharge>
						                <SendAmount xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</SendAmount>
						                <SendCurrency xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</SendCurrency>
						                <PayAmount xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</PayAmount>
						                <PayCurrency xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</PayCurrency>
						                <ExchangeRate xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</ExchangeRate>
						                <BankBranchId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string?]</BankBranchId>
						                <AccountNumber xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string?]</AccountNumber>
						                <AccountType xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string?]</AccountType>
						                <NewAccountRequest xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string?]</NewAccountRequest>
						                <PartnerPinNo xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</PartnerPinNo>
						                <IncomeSource xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</IncomeSource>
						                <RemittanceReason xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</RemittanceReason>
						                <Relationship xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</Relationship>
						                <CSPCode xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</CSPCode>
						                <OTPProcessId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</OTPProcessId>
						                <OTP xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</OTP>
						            </SendTransactionRequest>
						        </SendTransaction>
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
		    "SOAPAction: http://tempuri.org/ISend/SendTransaction"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		print_r($json_obj);exit;
	}

	public function verifyTransaction()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
								    <Body>
								        <VerifyTransaction xmlns=\"http://tempuri.org/\">
								            <VerifyTransactionRequest>
								                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
								                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
								                <PinNo xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</PinNo>
								            </VerifyTransactionRequest>
								        </VerifyTransaction>
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
		    "SOAPAction: http://tempuri.org/ISend/VerifyTransaction"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		print_r($json_obj);exit;
	}

	public 	function cancelTransaction()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
							    <Body>
							        <CancelTransaction xmlns=\"http://tempuri.org/\">
							            <CancelTransactionRequest>
							                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
											<Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
							                <PinNo xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</PinNo>
							                <ReasonForCancellation xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</ReasonForCancellation>
							                <OTPProcessId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</OTPProcessId>
							                <OTP xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">[string]</OTP>
							            </CancelTransactionRequest>
							        </CancelTransaction>
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
		    "SOAPAction: http://tempuri.org/ISend/CancelTransaction"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		print_r($json_obj);exit;
	}




}
