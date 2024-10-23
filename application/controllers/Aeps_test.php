<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aeps_test extends CI_Controller 
{

   function __construct()
    {
        parent:: __construct();
      error_reporting(-1);

      ini_set('display_errors',1);
      $this->db->db_debug = TRUE;
      $this->load->library("CreatorJwtAeps");
       
    }


  public function logentry($data)
  {
    $filename = "inlogs/aeps.txt";
    if (!file_exists($filename)) 
    {
      file_put_contents($filename, '');
    } 
    $this->load->library("common");

    $this->load->helper('file');
  
    $sapretor = "------------------------------------------------------------------------------------";
    
write_file($filename." .\n", 'a+');
write_file($filename, $this->common->getDate()."\n", 'a+');
write_file($filename, $this->common->getRealIpAddr()."\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
  }
  

  public function aeps_loging($request,$response,$param1 = "",$param2 = "",$param3 = "")
  {
    $this->db->query("insert into aeps_testlog(add_date,ipaddress,request,response,param1) values(?,?,?,?,?)",array($this->common->getDate(),$this->common->getRealIpAddr(),$request,$response,$param1));
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
        "partnerId"=>"AEPS_SAM_000247",
        "partnerSubId"=>"12345132",
        "requestReferenceId"=>$requestId
      );

      $json_string = json_encode($json_array);

      echo "JWT Payload : ";
      echo $json_string;
      echo "<hr>";
      
      $jwtToken = $this->objOfJwt->GenerateToken(json_decode($json_string ));
     // echo $jwtToken;exit;
      return $jwtToken;
    }

    
  public function index()
	{

      $partner_id = "AEPS_SAM_000247";
      $secret_key = 'wKtPAe5aZLsaVdRHm02TYG2qO83dn9gpHJy3piNzo1M=';
      //https://pass-api-staging.paytmbank.com
      $this->aeps_loging(json_encode($this->input->post()),"","W");


      $str = '{"amount":"100","pdata":"<PidData>\n   <Data type=\"X\">MjAyMS0xMC0yOVQyMjo1MDowM72yDHuRBxn61rixxhJJAOPoBWcvOA1iAzUBur6wvgMQZ8uo7JhiTBpLjugKFjZ\/R\/AFe0aC3OL\/YsHqWf71JAi6AMz0TF3Uu5EhdfYw+cdR\/jnjJwYVp7Z4NFdXvJd2kzOjA9FS\/W9a6gh1g7yW7COZGrXchdmtLVoozY05R+JwB2AKomQjp45QfPxhTsdlzpa038MGCp8Ubu0TZ7VsW1bT7RN01k2JfZkQIi40S1ZHYcM07ZgBTimWkfmUHu3PqgxRTefRXRe70FIeDyZTa0w5cfRMdLVbr9SUYi77DCKFvbaiYtzizXY8ZLDnTF+EzGbu3+G9o+\/nOq6Z28gVSU4QzoDcW+0nohzif1pu8QpC\/D1e6EvAN5jY3IzlyxlG792KIKpjcdpTh+0zFKAYTFlMlea69wJZpPyvlqjB8NVS4dW+YNHeLLYI5iN7+syrFgo4xEaK+v53aWC+SzBBLsLhBfUs5SOL2LJcn2UR9eA6ZauZtkTxlAWFPk57Ipf1MhvjGlu8ue1XKV0cG7VB21bXMfVGdEmRtBykJ+uhyP8U9GzwoNqqy7lqR6tCkxf+Nee0JWY7Pkqk\/8IAIokw0oyriE3dw\/xosiuaTDecP5VswywP8i\/MCgJAPjGkEMhA0BR5v5EGmIqAKqI+Wu5HVwkCPD0NBGhTppD0BcgyeoHnGNGs+DFLJBtNRF3z05I9Ejf\/dXnK6R+ogDdShs4IetOV6mAUvBOetjrvIMxcXutvoJ9RsGVCWo6iV6I\/rsMPs5MLS53Q2eoSvohUh9tn8VrjlNtYJyHO\/tClWY8PlD8ho7Iz3WxrbPfDbDvCJGbWozVr9nGb8y1Z\/zKDCEgb13ErzobWPiK\/Ix3g3WazDO5kZ2pbbcJTvLfN\/hVTX\/qKP51d1HbOc+yUElSedAnjkdtITAQ\/XUkEbv0IpZpY92BAUfx1arlXER\/2ixsWFjfzCgyayLuz8JjistAS1ZM7INwl\/XbGPWe0nXTkgTkUWYQ3ye1bcJRSvKIPMxLqeebX5e+7GREE<\/Data>\n   <DeviceInfo dc=\"090e2a6e-741b-4d9e-92d9-96f258e96f3a\" dpId=\"MANTRA.MSIPL\" mc=\"MIIEGjCCAwKgAwIBAgIGAXzNEFXiMA0GCSqGSIb3DQEBCwUAMIHqMSowKAYDVQQDEyFEUyBNYW50cmEgU29mdGVjaCBJbmRpYSBQdnQgTHRkIDcxQzBBBgNVBDMTOkIgMjAzIFNoYXBhdGggSGV4YSBvcHBvc2l0ZSBHdWphcmF0IEhpZ2ggQ291cnQgUyBHIEhpZ2h3YXkxEjAQBgNVBAkTCUFobWVkYWJhZDEQMA4GA1UECBMHR3VqYXJhdDEdMBsGA1UECxMUVGVjaG5pY2FsIERlcGFydG1lbnQxJTAjBgNVBAoTHE1hbnRyYSBTb2Z0ZWNoIEluZGlhIFB2dCBMdGQxCzAJBgNVBAYTAklOMB4XDTIxMTAyOTE3MDQzNFoXDTIxMTEyODE3MTkzMVowgbAxJDAiBgkqhkiG9w0BCQEWFXN1cHBvcnRAbWFudHJhdGVjLmNvbTELMAkGA1UEBhMCSU4xEDAOBgNVBAgTB0dVSkFSQVQxEjAQBgNVBAcTCUFITUVEQUJBRDEOMAwGA1UEChMFTVNJUEwxHjAcBgNVBAsTFUJpb21ldHJpYyBNYW51ZmFjdHVyZTElMCMGA1UEAxMcTWFudHJhIFNvZnRlY2ggSW5kaWEgUHZ0IEx0ZDCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAMw0SE7ByVF+6aoP\/65+H0ui8istAL2Viujbi1klnM+2b6Bjg02hRH7AISVhl510V\/PxG4dJFlryV4pPGB++4dHR\/Gio+P3nhLrI58\/7mb21RLmfx4Y4HAVJinZY6wUpjmC7UzJ3y4QyYai6dKZ4kQ2CxJ4WXS9g4\/XXL6\/5RBaWUs83BNH6E3hUlvIPVA\/Ckz9zRoQu0V78HtdGxPV\/BdeFDAPf\/U9ZL2RvKg3W13ksxDrvDNFE9j\/\/RTauFkXWKTfaKLjLUUAy0lJ\/tSHzyTHVFoPXw+OPwXtmu+R\/f0sXWQyS7lX0AKRMYmFI+FWpxeOMOdiaB+vLa9v\/L1NO7b0CAwEAATANBgkqhkiG9w0BAQsFAAOCAQEASd6Nx1Y06uKZxqcMhYXbpQtzaMTNsf5yTq7u7CIwombxcEFkI3bhY4A9AHTwQUGWN7ohJjxdcOSdtUJElCTXW6X0iZWCSf3m+JtAjqJp7GN5d9qXv0XhKwXk7Kt7r9rVsd4Q04JkOwhs1Y66fRkEuhgx0sbzBCZGdCcETs67nt706NYc3u4pNOfceFjEgfP7cQw006vXGURy\/01GS1CGCjvpfZ8MWJ4ZOy49zTv5CTHTUbQNJvkjkFNgky9FCGDHXKYjSbCa\/QaRX+9ZnkGk6gXDPueMEWex0WymJXNiMueGinPIOUD6VXKx7S25Tf6suIEBXp2GvQJ3SdCBCpdvSQ==\" mi=\"MFS100\" rdsId=\"MANTRA.AND.001\" rdsVer=\"1.0.5\">\n      <additional_info>\n         <Param name=\"srno\" value=\"3983030\"\/>\n         <Param name=\"sysid\" value=\"867194031285466\"\/>\n         <Param name=\"ts\" value=\"2021-10-29T22:50:06+05:30\"\/>\n      <\/additional_info>\n   <\/DeviceInfo>\n   <Hmac>Aya0c4uiQ6RRuqYGKgtl6dSZI4dC3lUgIvQoC6JSYMN53dpY\/zbZ3EupYVawrIMa<\/Hmac>\n   <Resp errCode=\"0\" errInfo=\"Capture Success\" fCount=\"1\" fType=\"0\" iCount=\"0\" iType=\"0\" nmPoints=\"26\" pCount=\"0\" pType=\"0\" qScore=\"99\"\/>\n   <Skey ci=\"20221021\">SAlLloQamYdgr9aTueNTlaYXaC\/cGzlHYO48cpArtLQyXuZBEZ7xbh4x0tnWmA5PryVB8HH+hnA1EHtCON6v7lQGn8ZAmAtZzCqhOkrBjJGh+bK1WLGoqDNnoFJXpbKcqUzN08mJ5VeoAmHUNkfKi+kJPa96tqKCbsQqLdz5mNWc0B9LgZHOtGxWbvCYapVIN1pnBAVbnV7J2KTvPWq0gywxSN\/4LFw1B9ecHxH5UJJQpQaeddQGKeZmdxxjjW0Ik7B0216ixsN\/w0I5xRhguKv8E\/Lia5y0ZeOhGEsUIchkCh4AVJDDz1T6Xc+fuO3A9ECJl9G3ovGeEFYw6KrybQ==<\/Skey>\n<\/PidData>","aadhaar_no":"972845544952","cmobile":"9819891887","rqtyp":"WA","pwd":"623623","bankcode":"652150","lat":"18.9949768","long":"73.1069928","username":"8080623623"}';



      $_POST = (array)json_decode($str);

      if(isset($_POST['pdata'])==true && isset($_POST['username'])==true && isset($_POST['pwd'])==true && isset($_POST['rqtyp'])==true && isset($_POST['amount'])==true && isset($_POST['bankcode'])==true && isset($_POST['aadhaar_no'])==true && isset($_POST['cmobile'])==true && isset($_POST['lat'])==true && isset($_POST['long'])==true)
            {
	  
    	       $this->load->helper('file');
            $guid = 'GUID'.date('YmdHis');
    	    	$dt = $_POST["pdata"];
    	    	$username=$_POST["username"];
    	    	$pwd=$_POST["pwd"];
    	    	$rqtyp=$_POST["rqtyp"];
    	    	$amount=$_POST["amount"];
    	    	$bankcode=$_POST["bankcode"];
    	    	$aadhaar_no=$_POST["aadhaar_no"];
    	    	$cmobile=$_POST["cmobile"];
    	    	$lat=$_POST["lat"];
    	    	$long=$_POST["long"];



            exec("java HelloWorld $aadhaar_no", $output); 
            $adhar_uid =  $output[0];
       
            $this->aeps_loging($dt,"","W");






           // echo $username." | ".$pwd;exit;
            $userinfo = $this->db->query("select * from tblusers where host_id = 1 and username = ? and password = ?",array($username,$pwd));
           // echo $userinfo->num_rows();exit;
            if($userinfo->num_rows() == 1)
            {
                $user_id = $userinfo->row(0)->user_id;
                $usertype_name = $userinfo->row(0)->usertype_name;
                if($rqtyp == "WA")
                {
                    $rqtypp="WAP";
                }
                else if($rqtyp == "CB")
                {
                    $rqtypp="BAP";
                }
                else if($rqtyp == "MS")
                {
                    $rqtypp="SAP";
                }


              
                $xml = simplexml_load_string($dt);
                $hmac = $xml->Hmac;
                $dvatt = $xml->DeviceInfo->attributes();
                $Respatt = $xml->Resp->attributes();
                $Skeyatt = $xml->Skey->attributes();

/*

"channel": "merchant",
"tnc":"AEPSBalanceEnquiry",
"authenticationFactorList": ["FMR"],
"bcId": "bcid1bcid",
"bcNameAndLocation": "Test Sec 125 ",
"state": "UP",
"country": "IN",
"city": "Noida",
"agentMobileNumber":"90096128909"
"ci": "ci",
"dc": "dc",
"depositorMobileNo": "1231231212",
"dpId": "string",
"hmac": "hmac",
"iin": "608304",
"mc": "jgsajhccdscdsnckkncenjkcnejknckjenwjkcnkjwenkjcnkjwejkcnw",
"mcc": "6012",
"mi": "mi",
"pid": "FPD1sdfshxjksnkjclkdcklmdlmcklmelcmklekldc1",
"pidType": "X",
"rc": "Y",
"rdsId": "rdsid",
"rdsVer": "1.2.3",
"skey": "skey",
"uid":"hEFpo2izjkmwhlEvIDpUGOucCOsgmFsh9BoEFcs/8rBv/nHaXFm+NvS3WZP
/MaUuL0wLwvBgLcH+UCF3t365mP8d7D7+D1dUwZx1SbmIiLb+cmCoB/AiYpAmhbfm4Mj
/3MUnrWnxNNEQFrzgsb6i+krEZY7JeSmmnlYA5iNs9pw=" // uid is encrpted. Encryption logic is provided above
"uidType": "AADHAAR",
"latitude":"string",
"longitude":"string",
"nmPoints":"40",
"qscore":"95"
 }

*/

$requestId = "Req".date_format(date_create($this->common->getDate()),'YmdHis');
$postdata =array(
        "requestId"=>$requestId,
        "method"=>$requestId,
        "channel"=> "merchant",
        "tnc"=>"AEPSBalanceEnquiry",
        "authenticationFactorList"=> ["FMR"],
        "bcNameAndLocation"=>"India",
        "state"=>"UP",
        "country"=>"IN",
        "city"=>"Noida",
        "agentMobileNumber"=>$username,
        "bcId"=> $user_id,
        "ci"=>urlencode((string)$Skeyatt['ci']),
        "dc"=> urlencode((string)$dvatt['dc']),
        "depositorMobileNo"=>$username,
        "dpId"=>urlencode((string)$dvatt['dpId']),
        "hmac"=>urlencode($hmac),
        "iin"=>"608304",
        "mc"=>urlencode((string)$dvatt['mc']),
        "mcc"=>"6012",
        "mi"=>urlencode((string)$dvatt['mi']),
        "pid"=>urlencode((string)$xml->Data),
        "pidType"=>urlencode((string)$xml->Data->attributes()->type),
        "rc"=>"Y",
        "rdsId"=>urlencode((string)$dvatt['rdsId']),
        "rdsVer"=>urlencode((string)$dvatt['rdsVer']),
        "skey"=>urlencode((string) $xml->Skey),
        "uid"=>$adhar_uid,
        "uidType"=>"AADHAAR",
        "latitude"=>$lat,
        "longitude"=>$long,
        "nmPoints"=>urlencode((string)$Respatt['nmPoints']),
        "qscore"=>urlencode((string)$Respatt['qScore'])
  );

///print_r($postdata);exit;
$data = 'inlogs/CallbackInstaLive.txt';

$log = "\n\n".'GUID - '.$guid."================================================================ \n";
//$log.=$dt."\n\n";



$data_json = json_encode($postdata);
echo "Post Data : ".$data_json;
echo "<hr>";
//$log .= 'piddata - '.$dt."\n\n";
$log .= 'Request - '.$data_json."\n\n";
file_put_contents($data, $log, FILE_APPEND | LOCK_EX);
//echo $data_json;
$base_url = 'https://pass-api-staging.paytmbank.com';
$url = $base_url.'/api/bfs/fulfillment/ext/v1/merchant/aeps/bi/checkout';


echo $url;
echo "<hr>";

$jwtToken = $this->jwt_token($requestId);

echo "jwtToken : ".$jwtToken;
echo "<hr>";



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

$this->logentry($response1);

echo $response1;exit;
if($rqtypp == "WAP")
{

  /*
{"status":"0","statuscode":"TXN","message":"Transaction Successful","data":{"sp_key":"WAP","opening_bal":"","pdrs_id":33,"amount":"100.00","amount_txn":"100.36","account_no":"9861468509","txn_mode":"CR","status":"SUCCESS","opr_id":"129418031562","balance":"835.42"},"timestamp":"2021-10-21 18:09:43","pdrs_uuid":0,"orderid":"CIJ012129418093465","environment":"PRODUCTION"}
  */
    $json_obj = json_decode($response1);
    if(isset($json_obj->statuscode) and isset($json_obj->status) and isset($json_obj->message))
    {
        $statuscode = $json_obj->statuscode;
        $status = $json_obj->status;
        $message = $json_obj->message;

        $balance = "";
        $opening_bal = "";
        $pdrs_id = "";
        $resp_amount = "";
        $resp_amount_txn = "";
        $account_no = "";
        $txn_mode = "";
        $resp_status = "";
        $opr_id = "";


        if(isset($json_obj->data))
        {
            $data = $json_obj->data;
              $opening_bal = $data->opening_bal;
              $pdrs_id = $data->pdrs_id;
              $resp_amount = $data->amount;
              $resp_amount_txn = $data->amount_txn;
              $account_no = $data->account_no;
              $txn_mode = $data->txn_mode;
              $resp_status = $data->status;
              $opr_id = $data->opr_id;
              $balance = $data->balance;

        }
        $timestamp = $json_obj->timestamp;
        $pdrs_uuid = $json_obj->pdrs_uuid;
        $environment = $json_obj->environment;


        if($statuscode == "TXN")
        {
            $add_date = $this->common->getDate();
            $ip = $this->common->getRealIpAddr();
            $this->db->query("insert into aeps_stk_lock (akssid, aepsdt, ipad, userid) VALUES (?,?,?,?)",array($guid, $add_date , $ip, $user_id));

            $aeps_transactions2=$this->db->query("insert into aeps_transactions2(add_date,ipaddress,request_id,sp_key,amount,user_id,customer_params,response_code,cb_res_code,cb_res_msg,balance,cb_status,cb_opr_id,response_msg,cb_ipay_id,outlet_mobile) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,? )",array ($add_date,$ip,$guid,$rqtypp,$resp_amount,$user_id,$aadhaar_no,$statuscode,$statuscode,$message,$balance,$resp_status,$opr_id,$message,$pdrs_id,$cmobile));

            $this->PAYMENT_CREDIT_ENTRY($userinfo,$guid,$amount,$pdrs_id,$opr_id,$balance);
        }
        else if($statuscode == "ERR")
        {
            $add_date = $this->common->getDate();
            $ip = $this->common->getRealIpAddr();
            $this->db->query("insert into aeps_stk_lock (akssid, aepsdt, ipad, userid) VALUES (?,?,?,?)",array($guid, $add_date , $ip, $user_id));

            $aeps_transactions2=$this->db->query("insert into aeps_transactions2(add_date,ipaddress,request_id,sp_key,amount,user_id,customer_params,response_code,cb_res_code,cb_res_msg,balance,cb_status,cb_opr_id,response_msg,cb_ipay_id,outlet_mobile) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,? )",array ($add_date,$ip,$guid,$rqtypp,$resp_amount,$user_id,$aadhaar_no,$statuscode,$statuscode,$message,$balance,$resp_status,$opr_id,$message,$pdrs_id,$cmobile));

           




            $resparr =  json_encode(  array (
                                                'status' => 'failure',
                                                    'infomsg' => $message,
                                                    'opid' => "",
                                                    'bal' => "",
                                                    'type' => "WA",
                                                    'smsg'=>$message
                                                  ));
          
            $this->logentry($resparr);
            echo $resparr;exit;


        }


    }

}
else if($rqtypp == "BAP")
{
  /*

{"status":"1","statuscode":"ERR","message":"Duplicate Transaction",
  "data":
  {
    "sp_key":"BAP",
    "opening_bal":"-",
    "pdrs_id":23,
    "amount":"",
    "amount_txn":"",
    "account_no":"",
    "txn_mode":"-",
    "status":"FAILED",
    "opr_id":"-",
    "balance":"-"
  }
,"timestamp":"2021-10-15 17:22:56","pdrs_uuid":0,"orderid":"DPJ012128817225289","environment":"PRODUCTION"
}
  */
    $json_obj = json_decode($response1);
    if(isset($json_obj->statuscode) and isset($json_obj->status) and isset($json_obj->message))
    {
        $statuscode = $json_obj->statuscode;
        $status = $json_obj->status;
        $message = $json_obj->message;

        $balance = "";
        $opening_bal = "";
        $pdrs_id = "";
        $resp_amount = "";
        $resp_amount_txn = "";
        $account_no = "";
        $txn_mode = "";
        $resp_status = "";
        $opr_id = "";


        if(isset($json_obj->data))
        {
            $data = $json_obj->data;
              $opening_bal = $data->opening_bal;
              $pdrs_id = $data->pdrs_id;
              $resp_amount = $data->amount;
              $resp_amount_txn = $data->amount_txn;
              $account_no = $data->account_no;
              $txn_mode = $data->txn_mode;
              $resp_status = $data->status;
              $opr_id = $data->opr_id;
              $balance = $data->balance;

        }
        $timestamp = $json_obj->timestamp;
        $pdrs_uuid = $json_obj->pdrs_uuid;
        $environment = $json_obj->environment;


        if($statuscode == "TXN")
        {
             $add_date = $this->common->getDate();
            $ip = $this->common->getRealIpAddr();
            $this->db->query("insert into aeps_stk_lock (akssid, aepsdt, ipad, userid) VALUES (?,?,?,?)",array($guid, $add_date , $ip, $user_id));

            $aeps_transactions2=$this->db->query("insert into aeps_transactions2(add_date,ipaddress,request_id,sp_key,amount,user_id,customer_params,response_code,cb_res_code,cb_res_msg,balance,cb_status,cb_opr_id,response_msg,cb_ipay_id,outlet_mobile) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,? )",array ($add_date,$ip,$guid,$rqtypp,$resp_amount,$user_id,$aadhaar_no,$statuscode,$statuscode,$message,$balance,$resp_status,$opr_id,$message,$pdrs_id,$cmobile));
            
            
            $infomsg="Balance Check Successfully";
            $resp_json =  json_encode(  array (
                'status' => 'success',
                'type' => 'CB',
                'bal' => $balance,
                'opid' => $opr_id,
                'smsg'=>$message,
                    'infomsg' => $infomsg
                  ));
            $this->logentry($resp_json);
            echo $resp_json;exit;
        }
        else if($statuscode == "ERR")
        {
             $add_date = $this->common->getDate();
            $ip = $this->common->getRealIpAddr();
            $this->db->query("insert into aeps_stk_lock (akssid, aepsdt, ipad, userid) VALUES (?,?,?,?)",array($guid, $add_date , $ip, $user_id));

            $aeps_transactions2=$this->db->query("insert into aeps_transactions2(add_date,ipaddress,request_id,sp_key,amount,user_id,customer_params,response_code,cb_res_code,cb_res_msg,balance,cb_status,cb_opr_id,response_msg,cb_ipay_id,outlet_mobile) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,? )",array ($add_date,$ip,$guid,$rqtypp,$resp_amount,$user_id,$aadhaar_no,$statuscode,$statuscode,$message,$balance,$resp_status,$opr_id,$message,$pdrs_id,$cmobile));

            $infomsg="Balance Check Error";
            $resp_json =  json_encode(  array (
                'status' => 'failure',
                'type' => 'CB',
                'bal' => "",
                'opid' => "",
                'smsg'=>$message,
                    'infomsg' => $infomsg
                  ));
            $this->logentry($resp_json);
            echo $resp_json;exit;
        }


    }
}
else
{
    echo $response1;exit;
}
            





////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

            }//end of if(userinfo->num_rows() == 1)

	

	    


	  

















            }
			
			else
			{
			    $resparray = array(
   	            'infomsg'=>'Something Went Wrong',
   	            'status'=>'failure'
   	           );
   		echo json_encode($resparray);exit;
			    
			}
	}
    function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    public function checkduplicate($user_id,$transaction_id)
    {
//	$add_date = $this->common->getDate();
//	$ip = $this->common->getRealIpAddr();

	$rslt = $this->db->query("select * from aeps_stk_lock where userid = ? and akssid = ? ",array($user_id,$transaction_id));
	 if($rslt->num_rows() == 1)
    {
		return 0;
	  }
	  else
	  {
	  	return 1;
	  }
}
  private function PAYMENT_CREDIT_ENTRY($userinfo,$transaction_id,$cr_amount,$trremarks,$txnref,$cbal)
	{
	   $cruserinfo = $userinfo;
     $usertype_name=$userinfo->row(0)->usertype_name;
	   $user_id = $userinfo->row(0)->user_id;
		 if($this->checkduplicate($user_id,$transaction_id) == 1)
     {
            	    
        echo json_encode(  array (
                                    'status' => 'failure',
                                    'infomsg' => "Dublicate Tranactions or check your wallet!!!"
                                ));
        exit;	
    }
    else
    {
        $txnld=$transaction_id;
        $remark="Load Money With refid :".$txnref." txid : ".$txnld." remarks: ".$trremarks;
        $dr_user_id = 1;
        $cr_user_id = $user_id;
        if($usertype_name == "MasterDealer" or $usertype_name == "Distributor" or $usertype_name == "Agent" or $usertype_name == "APIUSER")
        {
          $refidinfo = $this->db->query("select * from tblpayment where ref_id = ? ",array($txnref));
          if($refidinfo->num_rows() == 0)
          {
            $commission = $this->getChargeValue($userinfo,$cr_amount);
            $cr_amt = $commission + $cr_amount;
            $payment_type = "AEPS";
            $response = $this->Ew2->tblewallet_Payment_AEPS($cr_user_id,$dr_user_id,$cr_amt,$remark,$remark,$payment_type);
          	$log = json_encode(  array (
                                          'status' => 'success',
                                              'infomsg' => $response,
                                              'opid' => $txnref,
                                              'bal' => $cr_amount." Remaining Account Balance is ".$this->Ew2->getAgentBalance($cr_user_id),
                                              'type' => "WA",
                                              'smsg'=>"Remaining Account Balance is ".$this->Ew2->getAgentBalance($cr_user_id),
                                            ))."\n\n";


            echo json_encode(  array (
                                          'status' => 'success',
                                              'infomsg' => $response,
                                              'opid' => $txnref,
                                              'bal' => $cr_amount." Remaining Account Balance is ".$cbal,
                                              'type' => "WA",
                                              'smsg'=>"Remaining Account Balance is ".$cbal
                                            ));
          	exit;	
          }
          else
          {
          		    
          	echo json_encode(  array (
                                          'status' => 'failure',
                                              'infomsg' => "Dublicate Tranactions or check your wallet!!!"
                                            ));
            exit;	
          		    
          }
        }
          							
        else
        {
          	echo json_encode(  array (
                                        'status' => 'failure',
                                        'infomsg' => "Other Error!!"
                                      ));
          	exit;	
          							    
        }        	
    }
	}
  private function getChargeValue($userinfo,$amount)
  {
    
    
    $groupinfo = $this->db->query("select * from aeps_group where Id = ?",array($userinfo->row(0)->scheme_id));
  if($groupinfo->num_rows() == 1)
  {
    $getrangededuction = $this->db->query("
      select 
        a.commission_type,
        a.commission,
        a.max_commission
        from aeps_slab a 
        where a.range_from <= ? and a.range_to >= ? and group_id = ?",array($amount,$amount,$groupinfo->row(0)->Id));
      if($getrangededuction->num_rows() == 1)
      {
        $commission_type = $getrangededuction->row(0)->commission_type;
        $commission = $getrangededuction->row(0)->commission;
        $max_commission = $getrangededuction->row(0)->max_commission;
        if($commission_type == "PER")
        {
          $commission = (($amount * $commission)/100);
        }
        if($commission > $max_commission)
        {
          return $max_commission;
        }
        return $commission;
      }
    
    
  }
    
    
    
    
    
    

}
}