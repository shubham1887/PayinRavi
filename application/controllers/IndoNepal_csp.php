<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IndoNepal_csp extends CI_Controller {



	public function getmethods()
	{


		$client = new SoapClient("https://sandbox.prabhuindia.com/Api/Send.svc?wsdl");
		var_dump($client->__getFunctions());    
		var_dump($client->__getTypes());
		echo "end";exit;

	}
	public function search_csp()
	{

		//9819891887
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;
		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <SearchCSP xmlns=\"http://tempuri.org/\">
						            <SearchCSPRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						                <CSPCode xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">7304988555</CSPCode>
						              
						            </SearchCSPRequest>
						        </SearchCSP>
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
		    "SOAPAction: http://tempuri.org/ISend/SearchCSP"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		print_r($json_obj);exit;
	}
	public function upload_document_csp()
	{
		$prabhu_url=PRABHU2_0WSDL;
		$prabhu_username=PRABHU2_0USERNAME;
		$prabhu_password=PRABHU2_0PASSWORD;


	$FileName = "uploads/ID Proof and Address Proof of Ravikant Chavada.pdf";

    $DocumentType = strtolower(pathinfo($FileName,PATHINFO_EXTENSION));
    $IDType = "aadhaar card";
    $FileBase64 = base64_encode(file_get_contents($FileName) );

	/*
	ID Proof and Address Proof of Ravikant Chavada.pdf
	$FileName = "ID Proof and Address Proof of Ravikant Chavada";
	$DocumentType = "pdf";
	$IDType = "";
	$FileBase64
	*/

		$postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
						    <Body>
						        <UploadCSPDocument xmlns=\"http://tempuri.org/\">
						            <UploadCSPDocumentRequest>
						                <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
						                <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
						                <CSPCode xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">9819891887</CSPCode>
						                <FileName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$FileName."</FileName>
						                <DocumentType xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$DocumentType."</DocumentType>
						                <FileBase64 xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$FileBase64."</FileBase64>
						            </UploadCSPDocumentRequest>
						        </UploadCSPDocument>
						    </Body>
						</Envelope>";


					//	print htmlentities($postfield_data);exit;

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
		    "SOAPAction: http://tempuri.org/ISend/UploadCSPDocument"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$json_obj = $this->parsedata($response);
		/*
Array ( [sBody] => Array ( [UploadCSPDocumentResponse] => Array ( [UploadCSPDocumentResult] => Array ( [aCode] => 000 [aMessage] => File Upload Successfully ) ) ) )
		*/
		print_r($json_obj);exit;
	}
	public function response_parser()
	{
		$resp = '<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Body>
<SendTransactionResponse xmlns="http://tempuri.org/">
<SendTransactionResult xmlns:a="http://schemas.datacontract.org/2004/07/Remit.API" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">
	<a:Code>071</a:Code>
	<a:Message>OTP Vefification Failed: Invalid Mobile OTP [002]</a:Message>
	<a:TrnsactionId i:nil="true"/>
	<a:PinNo i:nil="true"/>
</SendTransactionResult></SendTransactionResponse></s:Body></s:Envelope>';
	$json_obj = $this->parsedata($resp);
	//print_r($json_obj);exit;
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
					$aMessage = trim($SendTransactionResult["aMessage"]);
					$aTrnsactionId = trim($SendTransactionResult["aTrnsactionId"]);
					$aPinNo = trim($SendTransactionResult["aPinNo"]);
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
				else
				{
					$aMessage = trim($SendTransactionResult["aMessage"]);

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



//		 $client = new SoapClient("https://sandbox.prabhuindia.com/Api/Send.svc?wsdl");
//var_dump($client->__getFunctions());    
//var_dump($client->__getTypes());exit;

	}

public function createCSP2()
{
	$req  = '<UserName>SAMS_API</UserName>
            <Password>SamsApi@895</Password>
            <CSPCode>9820458677</CSPCode>
            <EntityType>Individual</EntityType>
            <Name>Tejasbhai</Name>
            <State>Maharashtra</State>
            <District>Mumbai</District>
            <City>Mumbai</City>
            <Address>panvel</Address>
            <PinCode>410106</PinCode>
            <Phone>9820458677</Phone>
            <Email>mpayonline7@gmail.com</Email>
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
            <AcBankName>State Bank of India</AcBankName>
            <ACType>Current</ACType>
            <ACIFSCCode>SBIN0015664</ACIFSCCode>
            <ACNumber>38787055929</ACNumber>
            <ContantPerson>Tejasbhai</ContantPerson>
            <CGender>Male</CGender>
            <CFatherName>Laxmanbhai</CFatherName>
            <CDob>1980-12-23</CDob>
            <CState>Maharashtra</CState>
            <CDistrict>Mumbai</CDistrict>
            <CCity>Mumbai</CCity>
            <CAddress>panvel</CAddress>
            <CEmail>mpayonline7@gmail.com</CEmail>
            <CMobile>9820458677</CMobile>
            <COccupation>Self Employed</COccupation>
            <CQualification>Graduate</CQualification>
            <CIDType>Aadhaar Card</CIDType>
            <CIDNumber>123412341234</CIDNumber>';
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
	$Mobile = "7304988555";
	$EntityType = "Individual";
	$Name = "Tejasbhai";
	$State = "Maharashtra";
	$District = "Mumbai";
	$City = "Mumbai";
	$Address = "Panvel";
	$PinCode = '410106';
	$GSTIN = '';
	$Phone = '7304988555';
	$Email = "mpayonline7@gmail.com";
	$IsOwnBranch = "0";
	$PanNo = "ABHPl9864K";
	$Device = '';
	$Connectivity = '';
	$StartTime = '';
	$EndTime = '';
	$OffDay = '';
	$AcBankName='State Bank of India';
	$ACType='Saving';
	$ACIFSCCode='SBIN0015664';
	$ACNumber='38787055929';
	$ContantPerson='Tejasbhai';
	$CGender='Male';
	$CFatherName='Laxmanbhai';
	$CDob='1980-12-23';
	$CState='Maharashtra';
	$CDistrict='Mumbai';
	$CCity='Mumbai';
	$CAddress='Panvel';
	$CEmail='mpayonline7@gmail.com';
	$CMobile='7304988555';
	$COccupation='Business';
	$CQualification='';
	$CIDType='Aadhaar Card';
	$CIDNumber = '123412341234';

	$postfield_data='<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
			    <Body>
			        <CreateCSP xmlns="http://tempuri.org/">
			            <CreateCSPRequest>
			                <UserName  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">SAMS_API</UserName>
				            <Password  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">SamsApi@895</Password>
				            <CSPCode  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$CMobile.'</CSPCode>
				            <EntityType  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$EntityType.'</EntityType>
				            <Name  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$Name.'</Name>
				            <State  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$State.'</State>
				            <District  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$District.'</District>
				            <City  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$City.'</City>
				            <Address  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$Address.'</Address>
				            <PinCode  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$PinCode.'</PinCode>
				            <Phone  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$Phone.'</Phone>
				            <Email  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$Email.'</Email>
				            <IsOwnBranch  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$IsOwnBranch.'</IsOwnBranch>
				            <PanNo  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$PanNo.'</PanNo>



				            <GSTIN  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$GSTIN.'</GSTIN>
				            <Device  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Laptop</Device>
				            <Connectivity  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Mobile</Connectivity>
				            <StartTime  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">08:00:00</StartTime>
				            <EndTime  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">21:00:00</EndTime>
				            <OffDay  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">None</OffDay>
				            <AcBankName  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$AcBankName.'</AcBankName>
				            <ACType  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$ACType.'</ACType>
				            <ACIFSCCode  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$ACIFSCCode.'</ACIFSCCode>
				            <ACNumber  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$ACNumber.'</ACNumber>
				            <ContantPerson  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$ContantPerson.'</ContantPerson>
				            <CGender  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$CGender.'</CGender>
				            <CFatherName  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$CFatherName.'</CFatherName>
				            <CDob  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$CDob.'</CDob>
				            <CState  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$CState.'</CState>
				            <CDistrict  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$CDistrict.'</CDistrict>
				            <CCity  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$CCity.'</CCity>
				            <CAddress  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$CAddress.'</CAddress>
				            <CEmail  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$CEmail.'</CEmail>
				            <CMobile  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$CMobile.'</CMobile>
				            <COccupation  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Self Employed</COccupation>
				            <CQualification  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">Graduate</CQualification>
				            <CIDType  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$CIDType.'</CIDType>
				            <CIDNumber  xmlns="http://schemas.datacontract.org/2004/07/Remit.API">'.$CIDNumber.'</CIDNumber>
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



public function createCSP2123()
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



}
