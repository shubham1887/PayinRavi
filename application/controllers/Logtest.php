<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Logtest extends CI_Controller { 
    private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->clear_cache();
		 error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $this->db->db_debug = TRUE;
        $this->load->model("Paytm");
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
    public function test_by_id()
    {
        $Id = 45076;
        $this->load->model("RazorpayPayout_model");
        $json_resp = $this->RazorpayPayout_model->Transfer_Api_call_only($Id);
        print_r($json_resp);exit;
    }
    public function razorpay_statuscheck()
    {
        $order_id = "WeB5cb5dRozerpay";
        $this->load->model("Razorpay");
        $response = $this->Razorpay->order_status($order_id);
        echo $response;exit;
    }
    public function parsemsg()
    {
        $str = '{"id":"pout_JOJz2aWQWA2aZC","entity":"payout","fund_account_id":"fa_JOJz2V9ory6bFs","fund_account":{"id":"fa_JOJz2V9ory6bFs","entity":"fund_account","contact_id":"cont_JOJz2OZMcJVtRv","contact":{"id":"cont_JOJz2OZMcJVtRv","entity":"contact","name":"Ravikant","contact":"8238232303","email":"ravikantchavda365@gmail.com","type":"vendor","reference_id":"12341","batch_id":null,"active":true,"notes":{"notes_key_1":"Tea, Earl Grey, Hot","notes_key_2":"Tea, Earl Grey\u2026 decaf."},"created_at":1651049584},"account_type":"bank_account","bank_account":{"ifsc":"SBIN0002661","bank_name":"State Bank of India","name":"ravikant","notes":[],"account_number":"31360591069"},"batch_id":null,"active":true,"created_at":1651049584},"amount":200,"currency":"INR","notes":{"notes_key_1":"Beam me up Scotty","notes_key_2":"Engage"},"fees":0,"tax":0,"status":"processing","purpose":"refund","utr":null,"mode":"IMPS","reference_id":"Acme Transaction ID 12345","narration":"Acme Corp Fund Transfer","batch_id":null,"failure_reason":null,"created_at":1651049584,"fee_type":"free_payout","queueing_details":{"reason":null,"description":null},"status_details":{"reason":null,"description":null,"source":null},"merchant_id":"FvQQcgb9k1IBAB","status_details_id":null}';



        $json_obj = json_decode($str);
       // print_r($json_obj);exit;
        if(isset($json_obj->id))
        {
            $Id = $json_obj->id;
            $payout_id  = $Id;
            $fund_account_id = $json_obj->fund_account_id;
            $fund_account_id = $json_obj->fund_account_id;
            $fund_account_obj = $json_obj->fund_account;

            $contact_id = $fund_account_obj->contact_id;

            $status = $json_obj->status;
            $utr = $json_obj->utr;

            if($status == "processing")
            {
                sleep(2);
                $status_resp = $this->payoutstatuscheck($payout_id);
                $status_obj = json_decode($status_resp);
                if(isset($status_obj->status))
                {
                    $resp_status = $status_obj->status;
                    $resp_utr = $status_obj->utr;
                    $resp_msg  = $status_obj->status_details->description;
                    echo $resp_status."#".$resp_utr."#".$resp_msg;exit;
                }

            }
            else
            {
                echo $status;exit;
            }

        }

    }
    public function payouttest()
    {
        /*
curl -u <YOUR_KEY>:<YOUR_SECRET> \-X POST https://api.razorpay.com/v1/payouts \-H "Content-Type: application/json" \-d '{    "account_number": "7878780080316316",    "amount": 1000000,    "currency": "INR",    "mode": "NEFT",    "purpose": "refund",    "fund_account": {        "account_type": "bank_account",        "bank_account": {            "name": "Gaurav Kumar",            "ifsc": "HDFC0001234",            "account_number": "1121431121541121"        },        "contact": {            "name": "Gaurav Kumar",            "email": "gaurav.kumar@example.com",            "contact": "9876543210",            "type": "vendor",            "reference_id": "Acme Contact ID 12345",            "notes": {                "notes_key_1": "Tea, Earl Grey, Hot",                "notes_key_2": "Tea, Earl Grey… decaf."            }        }    },    "queue_if_low_balance": true,    "reference_id": "Acme Transaction ID 12345",    "narration": "Acme Corp Fund Transfer",    "notes": {        "notes_key_1": "Beam me up Scotty",        "notes_key_2": "Engage"    }}'
        */
    $url = 'https://api.razorpay.com/v1/payouts';

     

        $header = array(
                "Content-Type: application/json"
        );

        $request_array = array(
            "account_number"=>"3434598639772989",
            "amount"=>"200",
            "currency"=>"INR",
            "mode"=>"IMPS",
            "purpose"=>"refund",
            "fund_account"=>array(
                            "account_type"=>"bank_account",
                            "bank_account"=>array(
                                                "name"=>"ravikant",
                                                "ifsc"=>"ICIC0002661",
                                                "account_number"=>"31360591069"
                                                    ),
                            "contact"=>array(
                                                "name"=>"Ravikant",
                                                "email"=>"ravikantchavda365@gmail.com",
                                                "contact"=>"8238232303",
                                                "type"=>"vendor",
                                                "reference_id"=>"12342",
                                                "notes"=>array(
                                                                    "notes_key_1"=>"Tea, Earl Grey, Hot",
                                                                    "notes_key_2"=>"Tea, Earl Grey… decaf.",
                                                                )
                                            )
                                ),
            "queue_if_low_balance"=>true,
            "reference_id"=>"12341",
            "narration"=>"Acme Corp Fund Transfer",
            "notes"=>array(
                                                                    "notes_key_1"=>"Beam me up Scotty",
                                                                    "notes_key_2"=>"Engage",
                                                                )
        );

    $postparams = '{"account_number":"3434598639772989","amount":1700,"currency":"INR","mode":"IMPS","purpose":"refund","fund_account":{"account_type":"bank_account","bank_account":{"name":"sams strategy pvt ltd","ifsc":"SBIN0000001","account_number":"38787055929"},"contact":{"name":"sams strategy pvt ltd","email":"mpayonline7@gmail.com","contact":"9820458677","type":"vendor","reference_id":"45077","notes":{"notes_key_1":"Tea, Earl Grey, Hot","notes_key_2":"Tea, Earl Grey\u2026 decaf."}}},"queue_if_low_balance":true,"reference_id":"aabc 45077","narration":"Acme Corp Fund Transfer","notes":{"notes_key_1":"Beam me up Scotty","notes_key_2":"Engage"}}';
        $ch = curl_init();      
        curl_setopt($ch,CURLOPT_URL,  $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERPWD, "rzp_live_nni3kXz0xCLW7i:vwOLdHL9XX4rAM5d6nYDqX32");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$postparams);
        $buffer = curl_exec($ch);       
        curl_close($ch);  
        $json_obj = json_decode($buffer);
        print_r($json_obj);exit;
        if(isset($json_obj->id))
        {
            $Id = $json_obj->id;
            $payout_id  = $Id;
            $fund_account_id = $json_obj->fund_account_id;
            $fund_account_id = $json_obj->fund_account_id;
            $fund_account_obj = $json_obj->fund_account;

            $contact_id = $fund_account_obj->contact_id;

            $status = $json_obj->status;
            $utr = $json_obj->utr;

            if($status == "processing")
            {
                sleep(3);
                $status_resp = $this->payoutstatuscheck($payout_id);
                $status_obj = json_decode($status_resp);
                if(isset($status_obj->status))
                {
                    $resp_status = $status_obj->status;
                    $resp_utr = $status_obj->utr;
                    $resp_msg  = $status_obj->status_details->description;
                    echo $resp_status."#".$resp_utr."#".$resp_msg;exit;
                }
                else
                {
                    echo $resp_status."#".$utr."#";exit;
                }

            }
            else
            {
                echo $status;exit;
            }

        }

    }
    public function payoutstatuscheck()
    {
        $payout_id = 'pout_JOKMBS1Sepz1B5';
        
        $url = 'https://api.razorpay.com/v1/payouts/'.$payout_id;
        $ch = curl_init();      
        curl_setopt($ch,CURLOPT_URL,  $url);
      
        curl_setopt($ch, CURLOPT_USERPWD, "rzp_live_nni3kXz0xCLW7i:vwOLdHL9XX4rAM5d6nYDqX32");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      
        $buffer = curl_exec($ch);       
        curl_close($ch);  
        echo $buffer;
    }
    public function payout_test_cashfree()
    {
        $userinfo = $this->db->query("select * from tblusers where username = '8080623623'");
            $this->load->model("cashfree_model");
                $bane_name = "Ravikant";
                $bankAccount = "31360591069";
                $ifsc = "SBIN0002661";

           // echo $this->cashfree_model->payout_authorize_token();exit;
           // echo $this->cashfree_model->payout_authorize_token_verify();exit;
            //echo $this->cashfree_model->getBalance();
          //  echo $this->cashfree_model->self_withdrawal();
           // echo $this->cashfree_model->add_bene($bane_name,$bankAccount,$ifsc,$userinfo);
                $bene_id = 4;
                   // echo $this->cashfree_model->getbenelist($bene_id,$userinfo);
                $this->cashfree_model->delete_bene($bene_id,$userinfo);

        exit;
        $url = 'https://payout-gamma.cashfree.com';

        $authorize_url = $url.'/payout/v1/authorize';

        $header = array(
                "Accept: application/json",
                "X-Client-Id:CF107636C8CVSCRG1A0QGEN8IPE0",
                "X-Client-Secret:53c7c5527582402f45c38dfe125858b646c7622c"
        );

        $ch = curl_init();      
        curl_setopt($ch,CURLOPT_URL,  $authorize_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,"");
        $buffer = curl_exec($ch);       
        curl_close($ch);        

            /*
{
"status":"SUCCESS",
"subCode":"200",
"message":"Token generated",
"data":
{
        "token":"ab9JCVXpkI6ICc5RnIsICN4MzUIJiOicGbhJye.abQfigEVVF0XJBVQUV1TZFEUiojIiV3ciwyNzATM3gTN0YTM6ICdhlmIsczM2EzN4UDN2EjOiAHelJCLiMzMuMTMy4iM14CN2EjI6ICcpJCLlNHbhZmOis2Ylh2QlJXd0Fmbnl2ciwSN5UzMzEjOiQWS05WdvN2YhJCLiATRQlEOOV0RRBTQxckUDNlVDhzQ2MjN3ATMGNkI6ICZJRnbllGbjJye.abjcljrYJ-BiklrrbI_7c2G9dQHvTtOjJnR3Vc5-40mc9KQ5fxQLwhX7ojhwsB8RgJ",
        "expiry":1645871637
}
}
            */
        
        //echo $buffer;exit;

        $json_obj = json_decode($buffer);
        if(isset($json_obj->status))
        {
            if($json_obj->status == "SUCCESS")
            {
                return $json_obj->data->token;
            }
        }



    }
    public function getApiName($apiname,$api_id,$remittermobile,$amount,$userinfo)
    {

       // echo $apiname;exit;
        if($apiname == "PAYTM")
        {
            $paytm_limit = $this->Paytm->remitter_details_limit($remittermobile,$userinfo);
            if($paytm_limit >= $amount)
            {
                $API_NAME = "PAYTM";
            }
            else
            {
                $API_NAME = "HOLD";
            }   
        }
        else if($apiname == "AIRTEL")
        {
          
            $this->load->model("Airtel_model");
            $airtel_limit = $this->Airtel_model->getSenderLimit_airtel($remittermobile);    
            if($airtel_limit >= $amount)
            {
                $API_NAME = "AIRTEL";
            }
            else
            {
                $API_NAME = "HOLD";
            }   
        }
        else if($apiname == "ZPULS")
        {
            $this->load->model("Api_model");
            $zpbalance = $this->Api_model->getBalance($api_id);
           // echo $zpbalance;exit;
            if($zpbalance > ($amount + 15))
            {
                $this->load->model("Zpuls_model");
                $zplimit = $this->Zpuls_model->getsenderlimit($remittermobile);
                if($zplimit >= $amount)
                {
                    $API_NAME = "ZPULS";
                }       
                else
                {
                    $API_NAME = "HOLD";
                }
            }
            else
            {
                $API_NAME = "HOLD";
            }
        }
        else 
        {
            $API_NAME = "HOLD";
        }
        return $API_NAME;
    }
    public function getaepsbank()
    {

            $this->load->model("Paytm_aeps");
            echo $this->Paytm_aeps->fetchIIN();exit;
        exit;
        $remittermobile = "7303275233";
        $userinfo = $this->db->query("select * from tblusers where mobile_no = '8080623623'");
        $amount = "5000";
        $api_info = $this->db->query("select 
                                                a.Id,
                                                a.api_name,
                                                a.priority,
                                                a.is_dmt,
                                                a.is_active
                                                from api_configuration  a 
                                                
                                                where a.is_dmt = 'yes' and a.is_active = 'yes' order by a.priority");

        foreach($api_info->result() as $rwapi)
        {
            $API_NAME = $this->getApiName($rwapi->api_name,$rwapi->Id,$remittermobile,$amount,$userinfo);
            echo $rwapi->api_name." >> ".$API_NAME."<br>";
            if($API_NAME != "HOLD")
            {
                break;
            }
        }
        echo $API_NAME;exit;
        
    }
}
