<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetAepsCallback_live extends CI_Controller {
	public function logentry($data)
	{
		$this->load->model("Paytm_aeps");
		$this->Paytm_aeps->reqresplog("Callback : ".$data);
	}
	public function index()
	{  
		
			$response = file_get_contents('php://input');
			$this->logentry($response);
			$json_obj = json_decode($response);
			//print_r($json_obj);exit;
			if(isset($json_obj->orderId) and isset($json_obj->amount))
			{

				$orderId = $json_obj->orderId;
				$amount = $json_obj->amount;
				$agentCustId = $json_obj->agentCustId;
				$agentCaNumber = $json_obj->agentCaNumber;
				$status = $json_obj->status;
				$responseMessage = $json_obj->responseMessage;//json array
					$response_obj = json_decode($responseMessage);
						$requestId = $response_obj->requestId;
						$resp_status = $response_obj->status;
						$txnStatus = $response_obj->txnStatus;
						$responseCode = $response_obj->responseCode;
						$responseMessage_in = $response_obj->responseMessage;
						$stan = $response_obj->stan;
						$rrn = $response_obj->rrn;
						$uidaiAuthCode = $response_obj->uidaiAuthCode;
						$currencyCode = $response_obj->currencyCode;
						$receiptRequired = $response_obj->receiptRequired;

				$created = $json_obj->created;
				$depositorMobileNumber = $json_obj->depositorMobileNumber;
				$failureCode = $json_obj->failureCode;
				$requestReferenceId = $json_obj->requestReferenceId;
				$terminalCode = $json_obj->terminalCode;
				$productType = $json_obj->productType;



				$this->db->query("insert into paytm_aeps_callback(orderId,amount,agentCustId,agentCaNumber,status,responseMessage,created,depositorMobileNumber,failureCode,requestReferenceId,terminalCode,productType,requestId,resp_status,txnStatus,responseCode,stan,rrn,uidaiAuthCode,currencyCode,receiptRequired) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($orderId,$amount,$agentCustId,$agentCaNumber,$status,$responseMessage_in,$created,$depositorMobileNumber,$failureCode,$requestReferenceId,$terminalCode,$productType,$requestId,$resp_status,$txnStatus,$responseCode,$stan,$rrn,$uidaiAuthCode,$currencyCode,$receiptRequired));
				

			}
			echo "OK";exit;
			
	}	
}
