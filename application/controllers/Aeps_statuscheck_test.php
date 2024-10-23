<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aeps_statuscheck_test extends CI_Controller 
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


$requestId = "Req20220308163408";

$base_url = 'https://pass-api-staging.paytmbank.com';
$url = $base_url.'/api/bfs/fulfillment/order/int/v2/status?requestId=Req20220308163408';


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