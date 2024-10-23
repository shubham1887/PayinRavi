<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aepstest extends CI_Controller 
{

   function __construct()
    {
        parent:: __construct();
      error_reporting(-1);

      ini_set('display_errors',1);
      $this->db->db_debug = TRUE;
      $this->load->model("ValidationModel");
       
    }
  public function aeps_loging2($aeps_id,$request,$response,$param1 = "",$param2 = "",$param3 = "")
  {
    $this->db->query("insert into aeps_testlog(add_date,ipaddress,request,response,param1,aeps_id) values(?,?,?,?,?,?)",array($this->common->getDate(),$this->common->getRealIpAddr(),$request,$response,$param1,$aeps_id));
  }
  public function aeps_loging($request,$response,$param1 = "",$param2 = "",$param3 = "")
  {
    $this->db->query("insert into aeps_testlog(add_date,ipaddress,request,response,param1) values(?,?,?,?,?)",array($this->common->getDate(),$this->common->getRealIpAddr(),$request,$response,$param1));
  }
  public function xmlresponse($statuscode,$status,$opening_bal,$ipay_id,$amount,$amount_txn,$txn_mode,$data_status,$opr_id,$balance,$timestamp,$ipay_uuid,$orderid,$environment)
  {
    $resp = '<?xml version="1.0" encoding="utf-8"?>
            <xml>
              <statuscode>ERR</statuscode>
              <status>REQUEST EXPIRED</status>
              <data>
                <opening_bal>-</opening_bal>
                <ipay_id>CPJ012128814040530</ipay_id>
                <amount>100.00</amount>
                <amount_txn>100.36</amount_txn>
                <account_no>7077023417</account_no>
                <txn_mode>CR</txn_mode>
                <status>FAILED</status>
                <opr_id>9093103916</opr_id>
                <balance>-</balance>
              </data>
              <timestamp>2021-10-15 14:04:08</timestamp>
              <ipay_uuid>A6ACE5197ECFF43DC803</ipay_uuid>
              <orderid>CPJ012128814040530</orderid>
              <environment>PRODUCTION</environment>
            </xml>';

  }
  public function custom_response($status,$statuscode,$message,$data = "",$timestamp="",$pdrs_uuid="",$orderid="",$environment="")
  {
      $resparray = array(
        "status"=>$status,
        "statuscode"=>$statuscode,
        "message"=>$message,
        "data"=>$data,
        "timestamp"=>$timestamp,
        "pdrs_uuid"=>$pdrs_uuid,
        "orderid"=>$orderid,
        "environment"=>$environment
      );
      echo json_encode($resparray);exit;
  }
  public function index()
  {

      error_reporting(-1);
      ini_set('display_errors',1);
      $this->db->db_debug = TRUE;



      $environment = "PRODUCTION";
      $pdrs_uuid = 0;
      $agent_id = 0;
      $user_opening_bal = "-";
      $pdrs_id = "-";
      $amount = "0";
      $amount_txn = "";
      $account_no = "";
      $txn_mode = "-";
      $data_status = "PENDING";
      $opr_id = "-";
      $user_balance= "-";

      $json = json_encode($this->input->post());
      $this->load->model("Paytm_aeps");
      $this->Paytm_aeps->reqresplog("Android Post Data : ".$json);
    //echo $json;exit;  
   // $this->aeps_loging($json,"","W");
    $json_obj = json_decode($json);
//print_r($json_obj);exit;
   // echo $json_obj->username."|".$json_obj->password."|".$json_obj->apitoken."|".$json_obj->request;exit;
       

        if(isset($json_obj->username) && isset($json_obj->pwd)  && isset($json_obj->aadhaar_no)    && isset($json_obj->cmobile)   && isset($json_obj->bankcode)   && isset($json_obj->amount) )
        {
            $guid = 'GUID'.date('YmdHis');
            $sessionKey = '';
            $srno = "";
            $user_agent = "";
            $username = $json_obj->username;
            $pwd = $json_obj->pwd;
            $aadhaar_no = $json_obj->aadhaar_no;
            $cmobile = $json_obj->cmobile;
            $bankcode = $json_obj->bankcode;
            $amount = $json_obj->amount;
            $rqtyp = $json_obj->rqtyp;
            $lat = $json_obj->lat;
            $long = $json_obj->long;
            $apitoken = "";
            
            

            $outlet_id = "";//120000

            $agent_id = $guid;//GUID20210928122811
            $sp_key = $rqtyp;//WAP

            $pdata = $json_obj->pdata;
            $pidData = $pdata;

            $xml_pdata = simplexml_load_string($pdata);
           // print_r($xml_pdata);exit;
                $hmac = $xml_pdata->Hmac;
                $dvatt = $xml_pdata->DeviceInfo->attributes();
                $Respatt = $xml_pdata->Resp->attributes();
                $Skeyatt = $xml_pdata->Skey->attributes();

               

             // print_r($Respatt);exit;
                
                $ci = urlencode((string)$Skeyatt['ci']);
                $dc =  urlencode((string)$dvatt['dc']);
                $depositorMobileNo = $username;
                $dpId = urlencode((string)$dvatt['dpId']);
                $hmac = urlencode($hmac);
                $iin = $bankcode;
                $mc = urlencode((string)$dvatt['mc']);
                $mcc = "6012";
                $mi = urlencode((string)$dvatt['mi']);
                $pid = urlencode((string)$xml_pdata->Data);
                $pidType = urlencode((string)$xml_pdata->Data->attributes()->type);
                $pidDataType  = $pidType;

                $tType = "";
                $errCode = $errInfo = "";
                $pCount = "";
                $fCount = "";
                $errCode = urlencode((string)$Respatt["errCode"]);
                $errInfo = urlencode((string)$Respatt["errInfo"]);
                $fCount = urlencode((string)$Respatt["fCount"]);
                $fType = urlencode((string)$Respatt["fType"]);
                $iCount = urlencode((string)$Respatt["iCount"]);
                $iType = urlencode((string)$Respatt["iType"]);
                $nmPoints = urlencode((string)$Respatt['nmPoints']);
                $qScore = urlencode((string)$Respatt['qScore']);
                $pCount = urlencode((string)$Respatt['pCount']);
                $pType = urlencode((string)$Respatt['pType']);


                $rc = "Y";
                $rdsId = urlencode((string)$dvatt['rdsId']);
                $rdsVer = urlencode((string)$dvatt['rdsVer']);
                $skey = urlencode((string) $xml_pdata->Skey);
                $uid = $aadhaar_no;
                $uidType = "AADHAAR";
                $latitude = $lat;
                $longitude = $long;
                






           
          if($this->ValidationModel->validateMobile($username) == false)
          {
            $data_status = "FAILED";
            $userresp_data = array(
                                  "opening_bal"=>$user_opening_bal,
                                  "pdrs_id"=>$pdrs_id,
                                  "amount"=>$amount,
                                  "amount_txn"=>$amount_txn,
                                  "account_no"=>$account_no,
                                  "txn_mode"=>$txn_mode,
                                  "status"=>$data_status,
                                  "opr_id"=>$opr_id,
                                  "balance"=>$user_balance
                                );

            $status = "1";
            $statuscode = "ERR";
            $message = "Invalid Username";
            $this->custom_response($status,$statuscode,$message,$userresp_data,$timestamp,$pdrs_uuid,$orderid,$environment);
          }
          if($this->ValidationModel->validatePassword($pwd) == false)
          {
            $data_status = "FAILED";
            $userresp_data = array(
                                  "opening_bal"=>$user_opening_bal,
                                  "pdrs_id"=>$pdrs_id,
                                  "amount"=>$amount,
                                  "amount_txn"=>$amount_txn,
                                  "account_no"=>$account_no,
                                  "txn_mode"=>$txn_mode,
                                  "status"=>$data_status,
                                  "opr_id"=>$opr_id,
                                  "balance"=>$user_balance
                                );
              $status = "1";
              $statuscode = "ERR";
              $message = "Invalid Password Entered";
              $this->custom_response($status,$statuscode,$message,$userresp_data,$timestamp,$pdrs_uuid,$orderid,$environment);
          }


          $rsltusercheck = $this->db->query("select * from tblusers where mobile_no = ? and password = ?",array($username,$pwd));
       
          if($rsltusercheck->num_rows() == 1)
          {
              $user_id = $rsltusercheck->row(0)->user_id;
              $user_status = $rsltusercheck->row(0)->status;
              $usertype_name = $rsltusercheck->row(0)->usertype_name;
              $developer_key = $rsltusercheck->row(0)->developer_key;
              $bcId =  $user_id;
              if($usertype_name == "Agent")
              {
                  if($user_status == "1")
                  {
                    
                     $userinfo = $rsltusercheck;
                    //$this->load->model("Paytm_aeps");
                    $resp = $this->Paytm_aeps->balance_check($userinfo,$pidData,$aadhaar_no,$latitude,$longitude,$bankcode);



                      
                         // $token_ip = $tokeninfo->row(0)->client_ip;
                          //$callback_url = $tokeninfo->row(0)->callback_url;
                          if($developer_key ==  $apitoken )
                          {
if($sp_key == "WA")
{
    $sp_key="WAP";
}
else if($sp_key == "CB")
{
    $sp_key="BAP";
}
else if($sp_key == "MS")
{
    $sp_key="SAP";
}

$add_date = $this->common->getDate();
$ipaddress = $this->common->getRealIpAddr();
$usertoken_id = $apitoken;

//echo "herre";exit;


$rslt_insert = $this->db->query("insert into aeps_request(token, outlet_id, amount, aadhaar_uid, bankiin, latitude, longitude, mobile, agent_id, sp_key, pidData, pidDataType, ci, dc, dpId, errCode, errInfo, fCount, tType, hmac, iCount, mc, mi, nmPoints, pCount, pType, qScore, rdsId, rdsVer, sessionKey, srno, user_agent, add_date, ipaddress, user_id, usertoken_id) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array(
    $apitoken, $outlet_id, $amount, $aadhaar_no, $bankcode, $lat, $long, $cmobile, $guid, $sp_key, $pidData, $pidDataType, $ci, $dc, $dpId, $errCode, $errInfo, $fCount, $tType, $hmac, $iCount, $mc, $mi, $nmPoints, $pCount, $pType, $qScore, $rdsId, $rdsVer, $sessionKey, $srno, $user_agent, $add_date, $ipaddress, $user_id, $usertoken_id
  ));
if($rslt_insert == true)
{

  $db_insert_id = $this->db->insert_id();

  $instapay_token = "";
  $postdata =array("token"=> urlencode($instapay_token),"request"=>array(
         "outlet_id"=>urlencode('120000'),
         "amount"=> $amount,
          "aadhaar_uid"=> $aadhaar_uid,
          "bankiin"=> $bankiin,
          "latitude"=> $latitude,
           "longitude"=> $longitude,
           "mobile"=> $cmobile,
            "agent_id"=> $db_insert_id,
            "sp_key"=>$sp_key,
            "pidData"=>urlencode($pidData),
    "pidDataType"=> urlencode($pidDataType),
     "ci"=> urlencode((string)$ci),
    "dc"=> urlencode((string)$dc),
    "dpId"=> urlencode((string)$dpId),
    "errCode"=>  urlencode((string)$errCode),
    "errInfo"=> urlencode((string)$errInfo),
    "fCount"=> urlencode((string)$fCount),
    "tType"=> urlencode((string)$tType),
    "hmac"=> urlencode($hmac),
    "iCount"=>urlencode((string)$iCount),
    "mc"=> urlencode((string)$mc),
    "mi"=> urlencode((string)$mi),
    "nmPoints"=>urlencode((string)$nmPoints),
    "pCount"=>urlencode((string)$pCount),
    "pType"=>urlencode((string)$pType),
    "qScore"=>urlencode((string)$qScore),
    "rdsId"=>urlencode((string)$rdsId),
    "rdsVer"=>urlencode((string)$rdsVer),
    "sessionKey"=>urlencode((string) $sessionKey),
    "srno"=> urlencode((string)$srno),
  //  "sysid"=> (string)$xml->DeviceInfo->additional_info->Param[1]->attributes()->value,
  // "user_agent"=> $user_agent
     
),
  "user_agent"=> $user_agent,
  "username"=> "9820458677",
  "password"=> "939017",
  "apitoken"=> "338784719030350728463082207282",


);


$data_json = json_encode($postdata);
$url = 'https://pdrs.online/webapi/Aeps_request_api';
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
        "Content-Type: application/json"
    ),
));

$response1 = curl_exec($curl);
curl_close($curl);
$this->aeps_loging($response1,"","W_RESP_INSTA");

$obj = simplexml_load_string($response1);
$con = json_encode($obj);
$newArr = json_decode($con, true);


if($sp_key == "WAP" or $sp_key == "BAP" or $sp_key == "SAP")
{
  if(isset($newArr["statuscode"]) and isset($newArr["status"]))
  {






    $IPAY_statuscode = trim($newArr["statuscode"]);
    $IPAY_status = trim($newArr["status"]);


      $data_opening_bal = "";
      $data_ipay_id = "";
      $data_amount = "";
      $data_amount_txn = "";
      $data_account_no = "";
      $data_txn_mode = "";
      $data_status = "PENDING";
      $data_opr_id = "";
      $data_balance = "";

      if(isset($newArr["data"]))
      {
        $Data = $newArr["data"];
          $data_opening_bal = $Data["opening_bal"];
          $data_ipay_id = $Data["ipay_id"];
          $data_amount = $Data["amount"];
          $data_amount_txn = $Data["amount_txn"];
          $data_account_no = $Data["account_no"];
          $data_txn_mode = $Data["txn_mode"];
          $data_status = $Data["status"];
          $data_opr_id = $Data["opr_id"];
          $data_balance = $Data["balance"];
      }
      $timestamp = trim($newArr["timestamp"]);
      $ipay_uuid = trim($newArr["ipay_uuid"]);
      $orderid = trim($newArr["orderid"]);
      $environment = trim($newArr["environment"]);
    if($IPAY_statuscode == "ERR" or $IPAY_statuscode == "ISE" or $IPAY_statuscode == "SPE")
    {
          $this->db->query("
          update aeps_request set 
            resp_statuscode=?,
            resp_status=?,
            resp_opening_bal=?,resp_ipay_id=?,resp_amount=?,resp_amount_txn=?,resp_account_no=?,resp_txn_mode=?,resp_txn_status=?,resp_opr_id=?,resp_balance=?,resp_timestamp=?,resp_ipay_uuid=?,resp_orderid=?,resp_environment=? where Id = ?",array(
        $IPAY_statuscode,$IPAY_status,$data_opening_bal,$data_ipay_id,$data_amount,$data_amount_txn,$data_account_no,$data_txn_mode,$data_status,$data_opr_id,$data_balance,$timestamp,$ipay_uuid,$orderid,$environment,$db_insert_id
      )); 



        $status="1";
        $statuscode = "ERR";
        $message = $IPAY_status;
        $data_status = "FAILED";
        $userresp_data = array(
                              "sp_key"=>$sp_key,
                              "opening_bal"=>$user_opening_bal,
                              "pdrs_id"=>$db_insert_id,
                              "amount"=>$amount,
                              "amount_txn"=>$amount,
                              "account_no"=>$account_no,
                              "txn_mode"=>$txn_mode,
                              "status"=>$data_status,
                              "opr_id"=>$opr_id,
                              "balance"=>$user_balance
                            );
        $this->custom_response($status,$statuscode,$message,$userresp_data,$timestamp,$pdrs_uuid,$orderid,$environment);
    }
    else if($data_status == "FAILED")
    {
        $this->db->query("
          update aeps_request set 
            resp_statuscode=?,
            resp_status=?,
            resp_opening_bal=?,resp_ipay_id=?,resp_amount=?,resp_amount_txn=?,resp_account_no=?,resp_txn_mode=?,resp_txn_status=?,resp_opr_id=?,resp_balance=?,resp_timestamp=?,resp_ipay_uuid=?,resp_orderid=?,resp_environment=? where Id = ?",array(
        $IPAY_statuscode,$IPAY_status,$data_opening_bal,$data_ipay_id,$data_amount,$data_amount_txn,$data_account_no,$data_txn_mode,$data_status,$data_opr_id,$data_balance,$timestamp,$ipay_uuid,$orderid,$environment,$db_insert_id
      )); 



        $status="1";
        $statuscode = "ERR";
        $message = $IPAY_status;
        $data_status = "FAILED";
        $userresp_data = array(
                              "sp_key"=>$sp_key,
                              "opening_bal"=>$user_opening_bal,
                              "pdrs_id"=>$db_insert_id,
                              "amount"=>$amount,
                              "amount_txn"=>$amount,
                              "account_no"=>$account_no,
                              "txn_mode"=>$txn_mode,
                              "status"=>$data_status,
                              "opr_id"=>$opr_id,
                              "balance"=>$user_balance
                            );
        $this->custom_response($status,$statuscode,$message,$userresp_data,$timestamp,$pdrs_uuid,$orderid,$environment);

    }
    else if($data_status == "SUCCESS")
    {
        $this->db->query("
          update aeps_request set 
            resp_statuscode=?,
            resp_status=?,
            resp_opening_bal=?,resp_ipay_id=?,resp_amount=?,resp_amount_txn=?,resp_account_no=?,resp_txn_mode=?,resp_txn_status=?,resp_opr_id=?,resp_balance=?,resp_timestamp=?,resp_ipay_uuid=?,resp_orderid=?,resp_environment=? where Id = ?",array(
        $IPAY_statuscode,$IPAY_status,$data_opening_bal,$data_ipay_id,$data_amount,$data_amount_txn,$data_account_no,$data_txn_mode,$data_status,$data_opr_id,$data_balance,$timestamp,$ipay_uuid,$orderid,$environment,$db_insert_id
      ));


        if($sp_key == "BAP")
        {
            $status="0";
            $statuscode = "TXN";
            $message = $IPAY_status;
            $userresp_data = array(
                                  "sp_key"=>$sp_key,
                                  "opening_bal"=>"",
                                  "pdrs_id"=>$db_insert_id,
                                  "amount"=>$data_amount,
                                  "amount_txn"=>$data_amount_txn,
                                  "account_no"=>$data_account_no,
                                  "txn_mode"=>$data_txn_mode,
                                  "status"=>$data_status,
                                  "opr_id"=>$data_opr_id,
                                  "balance"=>$data_balance
                                );
            $this->custom_response($status,$statuscode,$message,$userresp_data,$timestamp,$pdrs_uuid,$orderid,$environment);
        }
        else if($sp_key == "SAP")
        {
            $st = $Data["mini_statement"]["item"];
            

            $add_date = $this->common->getDate();
            $ip = $this->common->getRealIpAddr();
            $infomsg="Mini Statement Load Successfully";
                    
                  $log = json_encode(  array (
            'status' => 'success',
            'type' => 'MS',
            'bal' => $data_balance,
            'data' =>$st,
            'opid' => $data_opr_id,
            'smsg'=>$IPAY_status,
                'infomsg' => $infomsg
              ))
              ."\n\n";
            
                    
            $resp_arr =   array (
                                'status' => 'success',
                                'type' => 'MS',
                                'bal' => $data_balance,
                                'data' =>$st,
                                'opid' => $data_opr_id,
                                'smsg'=>$IPAY_status,
                                'infomsg' => $infomsg
                              );
            echo json_encode($resp_arr);exit;
                    
                
        }
        else if($sp_key == "WAP")
        {
          $company_id = 292;


          $commission = 0;
          $commission_amount = 0;
          $commission_type = "PER";
          $max_commission = 0;


          $userinfo = $rsltusercheck;
          $commission_amount = $this->getChargeValue($userinfo,$amount);
          $commission_type = "PER";
            
          
            $this->db->query("update aeps_request set commission = ? where Id = ?",array($commission_amount,$db_insert_id));

            $description = "AEPS : ".$aadhaar_uid." | ".$data_account_no." | ".$data_opr_id;
            $this->load->model("Ewallet_aeps");
            $this->Ewallet_aeps->AepsCreditEntry($user_id,$amount,$commission_amount,$db_insert_id,$description);

            $status="0";
            $statuscode = "TXN";
            $message = $IPAY_status;
            $userresp_data = array(
                                  "sp_key"=>$sp_key,
                                  "opening_bal"=>"",
                                  "pdrs_id"=>$db_insert_id,
                                  "amount"=>$data_amount,
                                  "amount_txn"=>$data_amount_txn,
                                  "account_no"=>$data_account_no,
                                  "txn_mode"=>$data_txn_mode,
                                  "status"=>$data_status,
                                  "opr_id"=>$data_opr_id,
                                  "balance"=>$data_balance
                                );
            $this->custom_response($status,$statuscode,$message,$userresp_data,$timestamp,$pdrs_uuid,$orderid,$environment);
        }



    }
  }  
}

}


                          }
                          else
                          {
                              $status = "1";
                              $statuscode = "ERR";
                              $message = "Request Token";
                              //$message = "Request From Invalid Ip [".$this->common->getRealIpAddr()."]";
                              $this->custom_response($status,$statuscode,$message);                   
                          }
                         
                  }
                  else
                  {
                      $status = "1";
                      $statuscode = "ERR";
                      $message = "Account Deactive.";
                      $this->custom_response($status,$statuscode,$message);          
                  }
              }
              else
              {
                  $status = "1";
                  $statuscode = "ERR";
                  $message = "Invalid Access";
                  $this->custom_response($status,$statuscode,$message);     
              }
          }
          else
          {
              $status = "1";
              $statuscode = "ERR";
              $message = "Invalid Username or Password";
              $this->custom_response($status,$statuscode,$message);
          }


      
        /*
        
        $dt='<PidData>
   <Data type="X">MjAyMC0wOS0yNVQxMToyMTo0MdrXiTru0yDpbjxKXsXozymVKXJQw0RehenSNVDY82glXN0JxS2umgJG8h/Il1lSMhIsinupkiiKKXVweOG/z8WC2N6pr45hMdBnyNsn281N94DQ+EZstteqilfRnbUXHkN2geBv0Ph7eQecVAfj/PRELwHfX6ut46jjVxs8tKwsfEGq/Vn9pRz41Kwpv4zrfxKpSDgjhHcJpDPzTIzPjo9ZD6HjON8IDMYK5AA+Vxhw//4F140K4XbuQbsvvVuwCPT3LBswmAyHLJxx9x7Pfl2y1aJHRG974IwAfZlqDUszGD0kdct5275Z1dLFwZ2IUmshx84yrws/F0d+avGX0iH+2D2LGuSWfEQmZx71nPoCMsMiRqOkKYUgoCxR7apLK7WRP/wOq6stl68DLV9Hhnnm9on4NiyJP9GjDvLBiQLyrytnHt6VonaKDFI2aTXyDnjaUJkHOwAyqcWdkNogmno9ETR+ArGJ6wnnjUGuAaabEid14TaDaoRDk3gFmmGChk2y2SBsd/yJFREle17cpGcFM2Iuw2mQPz3fHA4vPC0jUtaWMv8LGaIvRPeORUpUsw7t5tJ6GFK+48EJv9BogFbzWPHyIe+9MYbB1LvDwSX6XwAFnPmdZjCbHMWHh0DUI+4OSwub6OzFIOszniOJT1zyGb67jmhOMWpuRAEJuaL6+WEfbrcC8NYyku5jccVsRqLNWn6BpHx6nGku1H8wwu1pdh9ZpRsESJAoOQ3lHJIcfynnKuRVTMFf/KEI3RUcS8lBzLzwRvCuNWUnSUKiQal9a+7LV7UaBdTAz9QU/ptH8spKUxNInletR+Zo+sEJEqBNQWQyB/7Z0WYnqtpGfLCwy/fOzQmEereNYzWj3itHZ3KG4miCZ3t+QR7yf3ubvLqD9XkJWjKxUgK0E1ZHEIJXXJ5Fm/Gn83aFSM7PLnPIWpYtWndzaJtXQvLwMYunvs8UUczwk9YcjQzq6umXKJgiCwh2yoSAcaaiLm1o9AKxK3klyxcmlOrGNHAmvAfX21Ztp7N03+rb/cnHzURxV8vDBt+oq83Qr0SFYYhkEAAG3cPCQxrrldZS/gUEkwKlSn8zC36G</Data>
   <DeviceInfo dc="a0cc1672-d83d-43b9-bce7-2a63dfd5c5b3" dpId="MANTRA.MSIPL" mc="MIIEGTCCAwGgAwIBAgIGAXTA/qNfMA0GCSqGSIb3DQEBCwUAMIHpMSowKAYDVQQDEyFEUyBNYW50cmEgU29mdGVjaCBJbmRpYSBQdnQgTHRkIDUxTTBLBgNVBDMTREIgMjAzIFNoYXBhdGggSGV4YSBvcHBvc2l0ZSBHdWphcmF0IEhpZ2ggQ291cnQgUyBHIEhpZ2h3YXkgQWhtZWRhYmFkMRIwEAYDVQQJEwlBaG1lZGFiYWQxEDAOBgNVBAgTB0d1amFyYXQxEjAQBgNVBAsTCVRlY2huaWNhbDElMCMGA1UEChMcTWFudHJhIFNvZnRlY2ggSW5kaWEgUHZ0IEx0ZDELMAkGA1UEBhMCSU4wHhcNMjAwOTI0MTYyNzMyWhcNMjAxMDI0MTY0MjI3WjCBsDEkMCIGCSqGSIb3DQEJARYVc3VwcG9ydEBtYW50cmF0ZWMuY29tMQswCQYDVQQGEwJJTjEQMA4GA1UECBMHR1VKQVJBVDESMBAGA1UEBxMJQUhNRURBQkFEMQ4wDAYDVQQKEwVNU0lQTDEeMBwGA1UECxMVQmlvbWV0cmljIE1hbnVmYWN0dXJlMSUwIwYDVQQDExxNYW50cmEgU29mdGVjaCBJbmRpYSBQdnQgTHRkMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvCk9kRZZQhS5rVsJI9yt54eKH5DgSkyB6tswxZ971oX6cGScfGcghCOmv5YQnDfKS1kTNDLE9fSzAunCMYDzoXXufTKgSpNevhWp6QzhE2stIkt15iOOdORmYbKLE1FyKKUtFw3NMi4sPdTuG6HbQilHRh88VECBMLI71NMGqRLSVXTRrwXPDYeenzfrFKCXAu5j89Tz08E88JbyZQNXHg6IHwWSKeTGfTqxgrL/eQAi88YNVzv+Np6HTyO7tMG1+dcZtDRcQJElOnz6AG6YcAxkcpVfYJF05/aVN1IMdMAOJ3E9i12oQYV3HvScjgM9+WwXo62RsjcpEf/YZCUYXQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQAR9as7ixnJwTOTQ/VZsLef0gyZv7x3QuItG33yiaVMJniuoBXPPEXtU+WIDmLIF+pR53IyYwMueELeCERYwiuHwBr34bHI6I8R//XdV/VPqajxfUzELlcZX1z+BuGdbzwV2o69b2woPlmuqE1yHyXbZ007aMZB8hjBtg29ld19UcChZEQtUKEwurohfcykMnNW1PGis3sDxZE46giNHnKKIXkQoRPa4/Z98mJfC+aoH0v+JrmVcDp5MkkZWpAwPX1bJIpPD9/XN8U2tbs0RCIXs/dFZyzxJHda6HL31Oo1SC9eL0vVnJKkCpoEbImwnRjuc0MJd59V5++qbvhk77Ni" mi="MFS100" rdsId="MANTRA.AND.001" rdsVer="1.0.4">
      <additional_info>
         <Param name="srno" value="0357836"/>
         <Param name="sysid" value="868494033714094"/>
         <Param name="ts" value="2020-09-25T11:21:43+05:30"/>
      </additional_info>
   </DeviceInfo>
   <Hmac>iEtdSQc23E6V6PeYuGJYLKGpua7Yziq0a9nSzHb7wmVweHQ9TlbKGcuPUoUgm/ZS</Hmac>
   <Resp errCode="0" errInfo="Capture Success" fCount="1" fType="0" iCount="0" iType="0" nmPoints="32" pCount="0" pType="0" qScore="78"/>
   <Skey ci="20221021">SEyLGIBJxBwn+/4wr97VXLMSZa4aFjeSmiTTsurzIzsIK9DtLfzdRDwYwr6rnKXsinjfP8qz38T8s7jB/x0qzqkmoAMTg1fLvAqoPBcdzGrEqLqKpkqJxUQ2TbUgr5TR5BYW6ioofvW/twszOMJi90S4OkR7yhYqjk+QJPRC0iqeaV7B7yyusxjbACfdG0x9o9aD5rATTZYgYeY0An+hbKI5QSzCLGhENLW/6f6Te3ctcPyq7HhmSs2flgUa7jtwGSmMFQHUhNjiM6XtzRoSilVjHnzzkbHfVnj5oKKnw6yPqnFbQY8K5GMH5/8ob6rss01f6FbmflsrHagGc1JtGw==</Skey>
</PidData>';
*/


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
//  $add_date = $this->common->getDate();
//  $ip = $this->common->getRealIpAddr();

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
private function getChargeValue($userinfo,$amount)
  {
    
    
    $groupinfo = $this->db->query("select * from tblgroup where Id = ?",array($userinfo->row(0)->scheme_id));
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