<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class IndoNepal_autoVerify extends CI_Controller {
		
	public function index()
	{


		$str = '';
		$rslt_instantpaybankdown = $this->db->query("SELECT Id,bank_name FROM `instantpay_banklist` where imps_enabled = 0");
		foreach($rslt_instantpaybankdown ->result() as $rwbk)
		{
			$str .=$rwbk->bank_name.' : Down,';
		}
		$this->db->query("update admininfo set value = ? where param = 'Message'",array($str));







		$rslt = $this->db->query("select * from indonepal_transaction where aPinNo != '' and aMessage = 'Success' and aPinNo != '' and Date(add_date) = ?",array('2022-03-05'));
		foreach($rslt->result() as $rw)
		{
			$aPinNo = $rw->aPinNo;
			$insert_id = $rw->Id;
			//echo $aPinNo;exit;
			//VerifyTransaction



		//define('PRABHU2_0WSDL','https://sandbox.prabhuindia.com/Api/Send.svc?wsdl');
		//define('PRABHU2_0USERNAME','SAMS_API');
		//define('PRABHU2_0PASSWORD','SamsApi@895');


			$prabhu_url='https://www.prabhuindia.com/Api/Send.svc?wsdl';
			$prabhu_username='SAMS_API';
			$prabhu_password='SamS#api951';
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
		    "SOAPAction: http://tempuri.org/ISend/VerifyTransaction"
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);


	print htmlentities($response) ;exit;
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
	public function emptyarrayremove($data)
	{
		if(is_array($data))
		{
			return "";
		}
		return $data;
	}
	function parsedata($soapResponse)
	{
		$xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $soapResponse);
		$xml = simplexml_load_string($xml);
		$json = json_encode($xml);
		return $responseArray = json_decode($json,true);
		
		exit;
	}	
}
