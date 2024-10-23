<?php
class Paytm_aeps extends CI_Model 
{ 
  
	function _construct()
	{
		parent::_construct();
      	header('Content-Type: application/json');
		date_default_timezone_set("Asia/Kolkata");
	}
	public function reqresplog($data)
	{
		$filename = "inlogs/paytm_aeps_live_reqresp.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $this->common->getDate()."\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
	}
	public function aeps_loging2($aeps_id,$request,$response,$param1 = "",$param2 = "",$param3 = "")
  {
    $this->db->query("insert into aeps_testlog(add_date,ipaddress,request,response,param1,aeps_id) values(?,?,?,?,?,?)",array($this->common->getDate(),$this->common->getRealIpAddr(),$request,$response,$param1,$aeps_id));
  }
  public function aeps_loging($request,$response,$param1 = "",$param2 = "",$param3 = "")
  {
    $this->db->query("insert into aeps_testlog(add_date,ipaddress,request,response,param1) values(?,?,?,?,?)",array($this->common->getDate(),$this->common->getRealIpAddr(),$request,$response,$param1));
  }
	private function getLiveUrl($type)
	{
		
	}
	private function getToken()
	{
		return "dfdsfdsfff";
	}
	private function getClientId()
	{
		return "DMR88";
	}
	private function getUserId()
	{
		return "29";
	}
	private function getinitiator_id()
	{
		return "8849972833";
	}
	private function getdauthKey()
	{
		return "A511Ds2YgE_shootc";
	}
	public function encrypt($plainText)
	{
	    $public_key = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCz1zqQHtHvKczHh58ePiRNgOyiHEx6lZDPlvwBTaHmkNlQyyJ06SIlMU
1pmGKxILjT7n06nxG7LlFVUN5MkW/jwF39
/+drkHM5B0kh+hPQygFjRq81yxvLwolt+Vq7h+CTU0Z1wkFABcTeQQldZkJlTpyx0c3+jq0o47wIFjq5fwIDAQAB';



	   
	}
	
	
	public function jwt_token($requestId)
    {
    //stating api partner id
    //DMT_i30_000200
      $this->load->library("CreatorJwtAeps");
      $this->objOfJwt = new CreatorJwtAeps();
        $randomnumber = rand ( 10000 , 99999 );
      $t = $milliseconds = round(microtime(true) * 1000);
      

      $json_array = array(
        "iss"=>"PAYTM",
        "timestamp"=>$t,
        "partnerId"=>"AEPS_SAM_000315",
        "partnerSubId"=>"9740617959",
        "requestReferenceId"=>$requestId
      );

      $json_string = json_encode($json_array);
      $this->reqresplog("JWT Payload : ".$json_string);
     // echo "JWT Payload : ";
      //echo $json_string;
      //echo "<hr>";
      
      $jwtToken = $this->objOfJwt->GenerateToken(json_decode($json_string ));
     // echo $jwtToken;exit;
      return $jwtToken;
    }
    public function fetchIIN()
    {
    	$partner_id = "AEPS_SAM_000315";
      $secret_key = 'fizO5hKi1VlO_bPwgy2ogNtvCPHTdI_XidCUe__kKXY=';
      $base_url = 'https://pass-api.paytmbank.com/';
      $url = $base_url.'/api/bfs/fulfillment/int/v1/aeps/iin/detail';
      	$requestId = "ReqIIN".date_format(date_create($this->common->getDate()),'YmdHis');
      $jwtToken = $this->jwt_token($requestId);
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
            "authorization: ".$jwtToken,
            "cache-control: no-cache",
            "content-type: application/json",
            "postman-token: c492db75-571a-fe94-5bf5-2ca4f2c87db8"
            ),
          ));
      
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
       // echo $response;exit;
        $str = '<table border="1">
        		<tr>
        			<td>Bank Name</td>
        			<td>IIN</td>
        		</tr>';
		$json_obj = json_decode($response);
		if(isset($json_obj->payload))
		{
			$iinlist  = $json_obj->payload->iinList;
			foreach($iinlist as $bk)
			{
				$iin = $bk->iin;
				$name = $bk->name;
				$str .='<tr>
        			<td>'.$name.'</td>
        			<td>'.$iin.'</td>
        		</tr>';
				//$this->db->query("insert into aeps_bank(aeps_bk_nm,aeps_bk_code) values(?,?)",array($name,$iin));
			}
		}
		$str .= '</table>';
		echo $str;exit;
		echo "END";exit;
		exit;
    }
    public function balance_check($userinfo,$pidData,$aadhaar_no,$latitude,$longitude,$bankcode)
    {
    	$partner_id = "AEPS_SAM_000315";
      $secret_key = 'fizO5hKi1VlO_bPwgy2ogNtvCPHTdI_XidCUe__kKXY=';

    	$guid = 'GUID'.date('YmdHis');
    	$username = $userinfo->row(0)->username;
    	$user_id = $userinfo->row(0)->user_id;
        $xml_pidData = simplexml_load_string($pidData);
       // print_r($xml_pidData);exit;
            $hmac = $xml_pidData->Hmac;
            $dvatt = $xml_pidData->DeviceInfo->attributes();
            $Respatt = $xml_pidData->Resp->attributes();
            $Skeyatt = $xml_pidData->Skey->attributes();

        exec("java HelloWorld $aadhaar_no", $output); 
        $adhar_uid =  $output[0];


    	$requestId = "Req".date_format(date_create($this->common->getDate()),'YmdHis');
		$postdata =array(
		        "requestId"=>$requestId,
		        "method"=>$requestId,
		        "channel"=> "merchant",
		        "tnc"=>"AEPSBalanceEnquiry",
		        "authenticationFactorList"=> ["FMR"],
		        "bcNameAndLocation"=>"India",
		        "state"=>"MH",
		        "country"=>"IN",
		        "city"=>"Mumbai",
		        "agentMobileNumber"=>$username,
		        "bcId"=> $user_id,
		        "ci"=>urlencode((string)$Skeyatt['ci']),
		        "dc"=> urlencode((string)$dvatt['dc']),
		        "depositorMobileNo"=>$username,
		        "dpId"=>urlencode((string)$dvatt['dpId']),
		        "hmac"=>urlencode($hmac),
		        "iin"=>$bankcode,
		        "mc"=>urlencode((string)$dvatt['mc']),
		        "mcc"=>"6012",
		        "mi"=>urlencode((string)$dvatt['mi']),
		        "pid"=>urlencode((string)$xml_pidData->Data),
		        "pidType"=>urlencode((string)$xml_pidData->Data->attributes()->type),
		        "rc"=>"Y",
		        "rdsId"=>urlencode((string)$dvatt['rdsId']),
		        "rdsVer"=>urlencode((string)$dvatt['rdsVer']),
		        "skey"=>urlencode((string) $xml_pidData->Skey),
		        "uid"=>$adhar_uid,
		        "uidType"=>"AADHAAR",
		        "latitude"=>$latitude,
		        "longitude"=>$longitude,
		        "nmPoints"=>urlencode((string)$Respatt['nmPoints']),
		        "qscore"=>urlencode((string)$Respatt['qScore'])
		  );

		///print_r($postdata);exit;
		$data = 'inlogs/CallbackInstaLive.txt';

		$log = "\n\n".'GUID - '.$guid."================================================================ \n";
		//$log.=$dt."\n\n";



		$data_json = json_encode($postdata);

		$this->reqresplog("Post Data : ".$data_json);
		//echo "Post Data : ".$data_json;
		//echo "<hr>";
		//$log .= 'piddata - '.$dt."\n\n";
		//$log .= 'Request - '.$data_json."\n\n";
		//file_put_contents($data, $log, FILE_APPEND | LOCK_EX);
		//echo $data_json;
		$base_url = 'https://pass-api.paytmbank.com/';
		$url = $base_url.'/api/bfs/fulfillment/ext/v1/merchant/aeps/bi/checkout';

		$this->reqresplog("Request Url : ".$url);


		//echo $url;
		//echo "<hr>";

		$jwtToken = $this->jwt_token($requestId);
		$this->reqresplog("jwtToken : ".$jwtToken);
		//echo "jwtToken : ".$jwtToken;
		//echo "<hr>";



		$curl = curl_init();

			curl_setopt_array($curl, array(
			    CURLOPT_URL => $url,
			    CURLOPT_RETURNTRANSFER => true,
			    CURLOPT_ENCODING => "",
			    CURLOPT_MAXREDIRS => 10,
			    CURLOPT_TIMEOUT => 0,
			    CURLOPT_FOLLOWLOCATION => true,
			    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			    CURLOPT_CUSTOMREQUEST => "POST",
			    CURLOPT_POSTFIELDS => $data_json,
			    CURLOPT_HTTPHEADER => array(
			        "authorization: ".$jwtToken,
			         "requestId:".$requestId,
			         "cache-control: no-cache",
			          "content-type: application/json",
			          "postman-token: e65364aa-3d7d-fea3-76db-c1cb36585a6f"
			    ),
			));

			$response1 = curl_exec($curl);
			curl_close($curl);
			$this->aeps_loging($response1,"","W_RESP_INSTA");
			$this->reqresplog("Response : ".$response1);
			//$this->logentry($response1);
			sleep(4);
			$dbcallback = $this->getcallback($requestId);
			$k=0;
			while($dbcallback == false)
			{

				if($k > 2)
				{
					break;
				}
				$dbcallback = $this->getcallback($requestId);
				$k++;
			}
			$this->reqresplog("Downline Response : ".$dbcallback);
			echo  $dbcallback;exit;
    }
    public function getcallback($requestId)
    {
    	$rslt = $this->db->query("select * from paytm_aeps_callback where requestReferenceId = ?",array($requestId));
    	if($rslt->num_rows() == 1)
    	{
    		$responseMessage = $rslt->row(0)->responseMessage;
    		$txnStatus = $rslt->row(0)->txnStatus;
    		$rrn = $rslt->row(0)->rrn;
    		$orderId = $rslt->row(0)->orderId;
    		$amount = $rslt->row(0)->amount;
    		$agentCustId = $rslt->row(0)->agentCustId;
    		$status = $rslt->row(0)->status;
    		$db_requestId = $rslt->row(0)->requestId;
    		$resp_status = $rslt->row(0)->resp_status;
    		$responseCode = $rslt->row(0)->responseCode;
    		$stan = $rslt->row(0)->stan;
    		$uidaiAuthCode = $rslt->row(0)->uidaiAuthCode;
    		$currencyCode = $rslt->row(0)->currencyCode;
    		$receiptRequired = $rslt->row(0)->receiptRequired;
    		$created = $rslt->row(0)->created;
    		$depositorMobileNumber = $rslt->row(0)->depositorMobileNumber;
    		$failureCode = $rslt->row(0)->failureCode;
    		$terminalCode = $rslt->row(0)->terminalCode;
    		 $infomsg=$responseMessage;
    		 if($txnStatus == "FAILURE")
    		 {
    			$resp_json =  json_encode(  array (
                'status' => 'failure',
                'type' => 'CB',
                'bal' => "",
                'opid' => $rrn,
                'smsg'=>$responseMessage,
                    'infomsg' => $infomsg
                  ));
	         //   $this->logentry($resp_json);
	            return $resp_json; 	
    		 }
    		 else
    		 {
    		 	$resp_json =  json_encode(  array (
                'status' => 'success',
                'type' => 'CB',
                'bal' => "",
                'opid' => "",
                'smsg'=>$message,
                    'infomsg' => $infomsg
                  ));
	           // $this->logentry($resp_json);
	            return $resp_json; 
    		 }
            
    	}
    	return false;
    }


	
}
?>