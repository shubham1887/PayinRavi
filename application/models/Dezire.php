<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dezire extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		
				 
			$user_id = 100002;
			$password = 'SBDvMHXm';
			$apiKey = '123456';
			$encryptionKey = '1234565';
			
			
			$reqarr = array(
			    "merchantUserID"=>1234,
			    "key"=>$apiKey
			    );
			    
			    
			$req = json_encode($reqarr);
			$url = 'http://uat-api.deziremoney.com/api/DMR/GetBalance/100002?key='.$apiKey;
			
			
			
			$cipher="AES256";
			$iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);
		 $encData = base64_encode(openssl_encrypt($req, $cipher, $encryptionKey, $options = OPENSSL_RAW_DATA , $iv));
			
			$curl = curl_init();

			  curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_POSTFIELDS => "",
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache",
			    "content-type: application/x-www-form-urlencoded",
			    "postman-token: 72497f4d-efa9-e666-ca21-4c50bae69c15"
			  ),
			));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);
			
			curl_close($curl);
			
			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			  echo $response;
			}
    }

	

	public function StateList()
	{
		$user_id = 100002;
		$password = '12312';
		$apiKey = '123134==';
		$encryptionKey = '12345';
		$reqarr = array(
		    "merchantUserID"=>100002,
		    "key"=>$apiKey
		    );		    
		$req = json_encode($reqarr);
		$url = 'http://uat-api.deziremoney.com/api/DMR/StateList?key='.$apiKey;
		
		
		
		$cipher="AES256";
		$iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);
	 $encData = base64_encode(openssl_encrypt($req, $cipher, $encryptionKey, $options = OPENSSL_RAW_DATA , $iv));
		
		$curl = curl_init();

		  curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: application/x-www-form-urlencoded",
		    "postman-token: 72497f4d-efa9-e666-ca21-4c50bae69c15"
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
		
	}
	public function AddressProofList()
	{
		//$user_id = 100002;
		//$password = 'SBDvMHXm';
		$apiKey = '1231==';
		$encryptionKey = '1231';
		$reqarr = array(
		    "merchantUserID"=>100002,
		    "key"=>$apiKey
		    );		    
		$req = json_encode($reqarr);
		$url = 'http://uat-api.deziremoney.com/api/DMR/AddressProofList?key='.$apiKey;
		
		
		
		$cipher="AES256";
		$iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);
	 $encData = base64_encode(openssl_encrypt($req, $cipher, $encryptionKey, $options = OPENSSL_RAW_DATA , $iv));
		
		$curl = curl_init();

		  curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: application/x-www-form-urlencoded",
		    "postman-token: 72497f4d-efa9-e666-ca21-4c50bae69c15"
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
	}
	public function IDProofList()
	{
		$apiKey = '15151==';
		$encryptionKey = '1231321';
		$reqarr = array(
		    "merchantUserID"=>100002,
		    "key"=>$apiKey
		    );		    
		$req = json_encode($reqarr);
		$url = 'http://uat-api.deziremoney.com/api/DMR/IDProofList?key='.$apiKey;
		
		
		
		$cipher="AES256";
		$iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);
	 $encData = base64_encode(openssl_encrypt($req, $cipher, $encryptionKey, $options = OPENSSL_RAW_DATA , $iv));
		
		$curl = curl_init();

		  curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: application/x-www-form-urlencoded",
		    "postman-token: 72497f4d-efa9-e666-ca21-4c50bae69c15"
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
	}

	public function SenderRegistration()
	{
		    
			$apiKey = '12311==';
			$encryptionKey = '45651';
			
			
			$reqarr = array(
				   "merchantUserID"  => 100002,
				   "senderCode"      => 3,
				   "first_Name"      => 'chirag',
				   "last_Name"       => 'josh',
				   "kyc_Flag"        => true,
				   "mobileNo"        => 7405674249,
				   "address"=>0,
				   "cityName"=>"",
				   "stateID"=>0,
				   "pincode"=>360001,
				   "addressProofNo"=>"",
				   "addressProof"=>0,
				   "addressProofUrl"=>"",
				   "idProofNo"=>"",
				   "idProof"=>0,
				   "idProofUrl"=>"",
				   );
			    
			    
			$req = json_encode($reqarr);
			$url = 'http://uat-api.deziremoney.com/api/DMR/SenderRegistration?key='.$apiKey;
			$cipher="AES256";
			$iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);
		 	$encData = base64_encode(openssl_encrypt($req, $cipher, $encryptionKey, $options = OPENSSL_RAW_DATA , $iv));
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "\"".$encData."\"",
			  CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"key: FTyG2f9cPNWGlhwqtHWd1g==",
				"merchantuserid: 100002",
				"postman-token: a654e38f-038b-b837-3778-81ceb062e5e7"
			  ),
			));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);
			
			curl_close($curl);
			
			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			  echo $response;
			}
 			
	}

	public function SenderLogin()
	{
			
		$apiKey = '1312==';
		$encryptionKey = '131213';
		$reqarr = array(
		    "merchantUserID"=>100002,
		    "senderID"=>8,
		    "mobile_No"=>7405674249,
		    "PIN"=>123456,
		    "key"=>$apiKey
		    );		    
		$req = json_encode($reqarr);
			$url = 'http://uat-api.deziremoney.com/api/DMR/SenderLogin?key='.$apiKey;
			$cipher="AES256";
			$iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);
		 	$encData = base64_encode(openssl_encrypt($req, $cipher, $encryptionKey, $options = OPENSSL_RAW_DATA , $iv));
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "\"".$encData."\"",
			  CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"content-type: application/json",
				"key: FTyG2f9cPNWGlhwqtHWd1g==",
				"merchantuserid: 100002",
				"postman-token: a654e38f-038b-b837-3778-81ceb062e5e7"
			  ),
			));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);
			
			curl_close($curl);
			
			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			  echo $response;
			}		
	}
	public function GetSenderDetails()
	{
		$senderID = 5;
		$merchantUserID = 100002;
		$apiKey = '1231==';
		$encryptionKey = '1321551';
		$reqarr = array(
		    "merchantUserID"=>100002,
		    "key"=>$apiKey
		    );		    
		$req = json_encode($reqarr);
		$url = 'http://uat-api.deziremoney.com/api/DMR/GetSenderDetails/'.$senderID.'/'.$merchantUserID.'?key='.$apiKey;

		$cipher="AES256";
		$iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);
	 $encData = base64_encode(openssl_encrypt($req, $cipher, $encryptionKey, $options = OPENSSL_RAW_DATA , $iv));
		
		$curl = curl_init();

		  curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: application/x-www-form-urlencoded",
		    "postman-token: 72497f4d-efa9-e666-ca21-4c50bae69c15"
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}		
	}
	public function UpdateKYCDetails()
	{
		$apiKey = '1315151==';
		$encryptionKey = '13515151';
		
		
		$reqarr = array(
			   "merchantUserID"  => 100002,
			   "senderID"      => 5,
			   "first_Name"      => 'Raj',
			   "last_Name"       => 'Patel',
			   "kyc_Flag"        => false,
			   "mobileNo"        => 7405674249,
			   "address"         =>'100001',
			   "cityName"        =>"Ahm",
			   "stateID"         =>12,
			   "pincode"         =>360012,
			   "addressProofNo"  =>"1234566",
			   "addressProof"    =>1,
			   "addressProofUrl"=>"https://cdn.mos.cms.futurecdn.net/gvQ9NhQP8wbbM32jXy4V3j-970-80.jpg",
			   "idProofNo"=>"123400",
			   "idProof"=>1,
			   "idProofUrl"=>"https://cdn.mos.cms.futurecdn.net/gvQ9NhQP8wbbM32jXy4V3j-970-80.jpg",
			   );
		    
		    
		$req = json_encode($reqarr);
		$url = 'http://uat-api.deziremoney.com/api/DMR/UpdateKYCDetails?key='.$apiKey;
		$cipher="AES256";
		$iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);
	 	$encData = base64_encode(openssl_encrypt($req, $cipher, $encryptionKey, $options = OPENSSL_RAW_DATA , $iv));
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "\"".$encData."\"",
		  CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: application/json",
			"key: FTyG2f9cPNWGlhwqtHWd1g==",
			"merchantuserid: 100002",
			"postman-token: a654e38f-038b-b837-3778-81ceb062e5e7"
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}			
	}


	public function BankList()
	{
		$apiKey = '135151==';
		$encryptionKey = '135151';
		$reqarr = array(
		    "merchantUserID"=>100002,
		    "key"=>$apiKey
		    );		    
		$req = json_encode($reqarr);
		$url = 'http://uat-api.deziremoney.com/api/DMR/BankList?key='.$apiKey;
		
		
		
		$cipher="AES256";
		$iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);
	 $encData = base64_encode(openssl_encrypt($req, $cipher, $encryptionKey, $options = OPENSSL_RAW_DATA , $iv));
		
		$curl = curl_init();

		  curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: application/x-www-form-urlencoded",
		    "postman-token: 72497f4d-efa9-e666-ca21-4c50bae69c15"
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
	}
	public function BeneficiaryRegistration()
	{
	     $apiKey = '6551351==';
	     $encryptionKey = '5151513551';
		
		
		$reqarr = array(
			   "beneficiary_ID"  => 0,
			   "senderID"        => 5,
			   "merchantUserID"  => '100002',
			   "beneficiary_Code"=> 'B005',
			   "beneficiaryName" => 'Rahul',
			   "beneficiaryAddress" => 'rajkot',
			   "mobileNo"         =>'9712003998',
			   "ifscType"         =>1,
			   "accountType"      =>1,
			   "bank_ID"          =>80,
			   "ifscCode"         =>'PUNB0096400',
			   "accountNo"        =>'0964000102016018',
			   "MMID"             =>"null",
			   );
		    
		    
		$req = json_encode($reqarr);
		$url = 'http://uat-api.deziremoney.com/api/DMR/BeneficiaryRegistration?key='.$apiKey;
		
			
		$cipher="AES256";
		$iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);
	 	$encData = base64_encode(openssl_encrypt($req, $cipher, $encryptionKey, $options = OPENSSL_RAW_DATA , $iv));
		
		$curl = curl_init();

		  curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "\"".$encData."\"",
		  CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: application/json",
			"key: FTyG2f9cPNWGlhwqtHWd1g==",
			"merchantuserid: 100002",
			"postman-token: a654e38f-038b-b837-3778-81ceb062e5e7"
		  ),
		));
		
			
			
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}			
	}
	public function BeneficiaryList()
	{
		$senderID = 5;
		$merchantUserID = 100002;
		$apiKey = '1315151==';
		$encryptionKey = '13515151';
		$reqarr = array(
		    "merchantUserID"=>100002,
		    "key"=>$apiKey
		    );		    
		$req = json_encode($reqarr);
		$url = 'http://uat-api.deziremoney.com/api/DMR/BeneficiaryList/'.$senderID.'/'.$merchantUserID.'?key='.$apiKey;
			
		$cipher="AES256";
		$iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);
	 $encData = base64_encode(openssl_encrypt($req, $cipher, $encryptionKey, $options = OPENSSL_RAW_DATA , $iv));
		
		$curl = curl_init();

		  curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: application/x-www-form-urlencoded",
		    "postman-token: 72497f4d-efa9-e666-ca21-4c50bae69c15"
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}		
	}
	public function GetBeneficiaryDetails()
	{
		$beneficiary_ID = 3;		
		$senderID = 5;
		$merchantUserID = 100002;
		$apiKey = '1351351==';
		$encryptionKey = '3135151515';
		$reqarr = array(
		    "merchantUserID"=>100002,
		    "key"=>$apiKey
		    );		    
		$req = json_encode($reqarr);
		$url = 'http://uat-api.deziremoney.com/api/DMR/GetBeneficiaryDetails/'.$beneficiary_ID.'/'.$senderID.'/'.$merchantUserID.'?key='.$apiKey;
		$cipher="AES256";
		$iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);
	 $encData = base64_encode(openssl_encrypt($req, $cipher, $encryptionKey, $options = OPENSSL_RAW_DATA , $iv));
		
		$curl = curl_init();

		  curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: application/x-www-form-urlencoded",
		    "postman-token: 72497f4d-efa9-e666-ca21-4c50bae69c15"
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
	}

	public function VerifyBeneficiary()
	{
		$apiKey = '5151515==';
		$encryptionKey = '1315151';
		$reqarr = array(
			   "beneficiary_ID"  => 3,
			   "senderID"        => 5,
			   "merchantUserID"  => '100002',
			   );
		    
		    
		$req = json_encode($reqarr);
		$url = 'http://uat-api.deziremoney.com/api/DMR/VerifyBeneficiary?key='.$apiKey;
		$cipher="AES256";
		$iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);
	 	$encData = base64_encode(openssl_encrypt($req, $cipher, $encryptionKey, $options = OPENSSL_RAW_DATA , $iv));
		
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "\"".$encData."\"",
		  CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: application/json",
			"key: FTyG2f9cPNWGlhwqtHWd1g==",
			"merchantuserid: 100002",
			"postman-token: a654e38f-038b-b837-3778-81ceb062e5e7"
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
	}
	public function PaymentTransaction()
	{
	
	/*
	 {"transactionCode":"1234","senderID":5,"beneficiaryID":1,"merchantUserID":100002,"transAmount":10,"transactionType":1,"remark":"xyzabcd"}
	*/
	
	
		$apiKey = '131515151==';
		$encryptionKey = '515135151';
		$reqarr = array(
			   "transactionCode" =>1235,
			   "senderID"        =>5,
			   "beneficiaryID"  =>1,
			   "merchantUserID"  =>'100002',
			   "transAmount"     =>10,
			   "transactionType"     =>1,
			   "remark"     =>'FirstTransaction',
			   );
		    
		    
		$req = json_encode($reqarr);
		$url = 'http://uat-api.deziremoney.com/api/DMR/PaymentTransaction?key='.$apiKey;
		
		
		echo $url."<br>";
		echo $req."<br>";
		
		$cipher="AES256";
		$iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);
	 	$encData = base64_encode(openssl_encrypt($req, $cipher, $encryptionKey, $options = OPENSSL_RAW_DATA , $iv));
		echo $encData."<br>";
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "\"".$encData."\"",
		  CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: application/json",
			"key: FTyG2f9cPNWGlhwqtHWd1g==",
			"merchantuserid: 100002",
			"postman-token: a654e38f-038b-b837-3778-81ceb062e5e7"
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}
	}
	public function GetBalance()
	{
		$merchantUserID = 100002;
		$password = '135151';
		$apiKey = '135151==';
		$encryptionKey = '6551515';
		
		
		$reqarr = array(
		    "merchantUserID"=>100002,
		    "key"=>$apiKey
		    );
		    
		$req = json_encode($reqarr);
		$url = 'http://uat-api.deziremoney.com/api/DMR/GetBalance/'.$merchantUserID.'?key='.$apiKey;
		$cipher="AES256";
		$iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);
	 	$encData = base64_encode(openssl_encrypt($req, $cipher, $encryptionKey, $options = OPENSSL_RAW_DATA , $iv));
		
		$curl = curl_init();

		  curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "content-type: application/x-www-form-urlencoded",
		    "postman-token: 72497f4d-efa9-e666-ca21-4c50bae69c15"
		  ),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}	
	}

}
