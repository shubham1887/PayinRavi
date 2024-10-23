<?php
class Cashfree_model extends CI_Model 
{ 
   
	function _construct()
	{
	   
		  // Call the Model constructor
		  parent::_construct();

	}



    public function payout_log($user_id,$request,$response,$payout_id)
    {
        $rslt = $this->db->query("insert into payout_reqresp(add_date,ipaddress,user_id,request,response,payout_id) values(?,?,?,?,?,?)",
            array($this->common->getDate(),$this->common->getRealIpAddr(),$user_id,$request,$response,$payout_id));
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////                  ///////////////////////////////////////////////////
//////////////////////////////////////////    L O G I N G   ////////////////////////////////////////////////////
/////////////////////////////////////////                  /////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	private function loging($methiod,$request,$response,$json_resp,$username)
	{
		//return "";
		//echo $methiod." <> ".$request." <> ".$response." <> ".$json_resp." <> ".$username;exit;
		$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
		"username: ".$username.PHP_EOL.
		"Request: ".$request.PHP_EOL.
        "Response: ".$response.PHP_EOL.
		"Downline Response: ".$json_resp.PHP_EOL.
        "Method: ".$methiod.PHP_EOL.
        "-------------------------".PHP_EOL;
		
		
		//echo $log;exit;
		$filename ='inlogs/'.$methiod.'log_'.date("j.n.Y").'.txt';
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		
//Save string to log, use FILE_APPEND to append.
		file_put_contents('inlogs/'.$methiod.'log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
		
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//*************************************** L O G I N G    E N D   H E R E *************************************//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function generate_payout_authorize_token()
    {
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
                $this->db->query("update cashfree_payout_auth_token set auth_token = ? where Id = 1",array($json_obj->data->token));
                return $json_obj->data->token;
            }
        }



    }
    public function payout_authorize_token_verify()
    {

            $current_token_result = $this->db->query("select auth_token from cashfree_payout_auth_token where  Id = 1");
            if($current_token_result->num_rows() == 1)
            {
                $current_token = $current_token_result->row(0)->auth_token;
            }
            else
            {
                $current_token = "";
            }




        $url = 'https://payout-gamma.cashfree.com';

        $authorize_url = $url.'/payout/v1/verifyToken';
        $header = array(
                "Accept: application/json",
                "X-Client-Id:CF107636C8CVSCRG1A0QGEN8IPE0",
                "X-Client-Secret:53c7c5527582402f45c38dfe125858b646c7622c",
                "Authorization:Bearer ".$current_token
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
        {"status":"SUCCESS","subCode":"200","message":"Token is valid"}
        */
        $json_obj = json_decode($buffer);
        if(isset($json_obj->status))
        {
            $status =$json_obj->status;
            if($status == "SUCCESS")
            {
                return $current_token;
            }
            else
            {
                $current_token = $this->generate_payout_authorize_token();
                return $current_token;
            }
        }
        else
        {
            $current_token = $this->generate_payout_authorize_token();
            return $current_token;
        }
    }




    public function getBalance()
    {
        $url = 'https://payout-gamma.cashfree.com';

        $authorize_url = $url.'/payout/v1/getBalance';

        $header = array(
                "Accept: application/json",
                "X-Client-Id:CF107636C8CVSCRG1A0QGEN8IPE0",
                "X-Client-Secret:53c7c5527582402f45c38dfe125858b646c7622c",
                "Authorization:Bearer ".$this->payout_authorize_token_verify()
        );
        //echo "Headers : ";
        //print_r($header);

        $ch = curl_init();      
        curl_setopt($ch,CURLOPT_URL,  $authorize_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $buffer = curl_exec($ch);       
        curl_close($ch);        
        /*
{"status":"SUCCESS","subCode":"200","message":"Ledger balance for the account","data":{"balance":"200000","availableBalance":"200000.00"}}
        */

        $json_obj = json_decode($buffer);
        if(isset($json_obj->status))
        {
            if($json_obj->status == "SUCCESS")
            {
               
                return $json_obj->data->availableBalance;
            }
        }



    }




    public function self_withdrawal()
    {



        $url = 'https://payout-gamma.cashfree.com';

        $authorize_url = $url.'/payout/v1/selfWithdrawal';
        $header = array(
                "Accept: application/json",
                "X-Client-Id:CF107636C8CVSCRG1A0QGEN8IPE0",
                "X-Client-Secret:53c7c5527582402f45c38dfe125858b646c7622c",
                "Authorization:Bearer ".$this->payout_authorize_token_verify()
        );

            print_r($header);
            echo "<br>";

        $postparams = array(
                "withdrawalId"=>"TEST_1",
                "amount"=>1,
                "remarks"=>"test withdrawal"
        );
        $postparams = json_encode($postparams);


            echo $postparams."<br><br>";

        $ch = curl_init();      
        curl_setopt($ch,CURLOPT_URL,  $authorize_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$postparams);
        $buffer = curl_exec($ch);       
        curl_close($ch);   

        echo $buffer;exit;
        /*
        {"status":"ERROR","message":"Remarks can have only numbers,alphabets and whitespaces","statusCode":"400"}


        {
  "status": "SUCCESS",
  "message": "Request submitted successfully. Withdrawal Id : W55",
  "statusCode": "200"
}



        */
        $json_obj = json_decode($buffer);
        if(isset($json_obj->status))
        {
            $status =$json_obj->status;
            if($status == "SUCCESS")
            {
                return $current_token;
            }
            else
            {
                $current_token = $this->generate_payout_authorize_token();
                return $current_token;
            }
        }
        else
        {
            $current_token = $this->generate_payout_authorize_token();
            return $current_token;
        }
    }




    public function add_bene($bene_name,$bankAccount,$ifsc,$userinfo)
    {

        $add_date = $this->common->getDate();
        $ipaddress = $this->common->getRealIpAddr();
        $user_id = $userinfo->row(0)->user_id;
        $email = "support@payin.co.in";
        $phone = $userinfo->row(0)->mobile_no;
        $bankAccount = $bankAccount;
        $address1 = "Thana Naka Road";
        $city = "Mumbai";
        $state = "Maharashtra";
        $pincode = "410206";
        $resp_bene_id = "";
        $status = "Pending";



        $rslt_insert = $this->db->query("insert into cashfree_payout_bene(add_date, ipaddress, user_id, bane_name, email, phone, bankAccount, ifsc, address1, city, state, pincode, resp_bene_id, status) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
            array($add_date, $ipaddress, $user_id, $bene_name, $email, $phone, $bankAccount, $ifsc, $address1, $city, $state, $pincode, $resp_bene_id, $status));
        if($rslt_insert == true)
        {
            $insert_id = $this->db->insert_id();
            $url = 'https://payout-gamma.cashfree.com';

            $authorize_url = $url.'/payout/v1/addBeneficiary';
            $header = array(
                    "Accept: application/json",
                    "X-Client-Id:CF107636C8CVSCRG1A0QGEN8IPE0",
                    "X-Client-Secret:53c7c5527582402f45c38dfe125858b646c7622c",
                    "Authorization:Bearer ".$this->payout_authorize_token_verify()
            );

             //   print_r($header);
               // echo "<br>";

            $postparams = array(
                    "beneId"=>$insert_id,
                    "name"=>$bene_name,
                    "email"=>$email,
                    "phone"=>$phone,
                    "bankAccount"=>$bankAccount,
                    "ifsc"=>$ifsc,
                    "address1"=>$address1,
                    "city"=>$city,
                    "state"=>$state,
                    "pincode"=>$pincode,
            );
            $postparams = json_encode($postparams);


              //  echo $postparams."<br><br>";exit;

            $ch = curl_init();      
            curl_setopt($ch,CURLOPT_URL,  $authorize_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$postparams);
            $buffer = curl_exec($ch);       
            curl_close($ch);   

            //echo $buffer;exit;
            $json_obj = json_decode($buffer);
            if(isset($json_obj->status))
            {
                $status =$json_obj->status;
                $message =$json_obj->message;
                if($status == "SUCCESS")
                {
                   $this->db->query("update cashfree_payout_bene status = 'SUCCESS',response_message=? where Id = ?",array($message,$insert_id));
                   $resp_array = array(
                        "status"=>0,
                        "message"=>$message,
                        "statuscode"=>"TXN",
                        "bene_id"=>$insert_id
                   );
                   echo json_encode($resp_array);
                }
                else
                {
                    $this->db->query("update cashfree_payout_bene status = ?,response_message=? where Id = ?",array($status,$message,$insert_id));
                    $resp_array = array(
                        "status"=>1,
                        "message"=>$message,
                        "statuscode"=>"ERR",
                        "bene_id"=>$insert_id
                   );
                   echo json_encode($resp_array);
                }
            }
            else
            {
                $this->db->query("update cashfree_payout_bene status = ?,response_message=? where Id = ?",array("FAILURE","Unknown Response",$insert_id));
                $resp_array = array(
                        "status"=>1,
                        "message"=>"Unknown Response",
                        "statuscode"=>"ERR",
                        "bene_id"=>$insert_id
                   );
                   echo json_encode($resp_array);
            }
        }

        
        /*
        {"status":"SUCCESS","subCode":"200","message":"Beneficiary added successfully"}

        */
        
    }


    public function getbenelist($bene_id,$userinfo)
    {

        $add_date = $this->common->getDate();
        $ipaddress = $this->common->getRealIpAddr();
        $user_id = $userinfo->row(0)->user_id;
       
            $url = 'https://payout-gamma.cashfree.com';

            $authorize_url = $url.'/payout/v1/getBeneficiary/'.$bene_id;
            $header = array(
                    "Accept: application/json",
                    "X-Client-Id:CF107636C8CVSCRG1A0QGEN8IPE0",
                    "X-Client-Secret:53c7c5527582402f45c38dfe125858b646c7622c",
                    "Authorization:Bearer ".$this->payout_authorize_token_verify()
            );

               // print_r($header);
                //echo "<br>";

           


              //  echo $postparams."<br><br>";exit;

            $ch = curl_init();      
            curl_setopt($ch,CURLOPT_URL,  $authorize_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $buffer = curl_exec($ch);       
            curl_close($ch);   

           // echo $buffer;exit;

        

        
        /*
        {"status":"SUCCESS","subCode":"200","message":"Details of beneficiary","data":{"beneId":"4","name":"Ravikant","email":"support@payin.co.in","phone":"8080623623","address1":"Thana Naka Road","address2":"","city":"Mumbai","state":"Maharashtra","pincode":"410206","bankAccount":"31360591069","ifsc":"SBIN0002661","status":"VERIFIED","maskedCard":null,"vpa":"","addedOn":"2022-02-26 17:07:07"}}

        */
        $json_obj = json_decode($buffer);
        if(isset($json_obj->status))
        {
            $status =$json_obj->status;
            if($status == "SUCCESS")
            {
                $data = $json_obj->data;
                $resp_array = array(
                        "beneId"=>$data->beneId,
                        "name"=>$data->name,
                        "phone"=>$data->phone,
                        "bankAccount"=>$data->bankAccount,
                        "ifsc"=>$data->ifsc,
                        "status"=>$data->status,
                );
                echo json_encode($resp_array);exit;

            }
            else
            {
                $resp_array = array(
                        "status"=>1,
                        "statuscode"=>"ERR",
                        "message"=>$json_obj->message
                );
                echo json_encode($resp_array);exit;
            }
        }
        else
        {
            $resp_array = array(
                        "status"=>1,
                        "statuscode"=>"ERR",
                        "message"=>"No Record Found"
                );
                echo json_encode($resp_array);exit;
        }
    }



    public function delete_bene($bene_id,$userinfo)
    {

         

        $url = 'https://payout-gamma.cashfree.com';

        $authorize_url = $url.'/payout/v1/removeBeneficiary';
        $header = array(
                "Accept: application/json",
                "X-Client-Id:CF107636C8CVSCRG1A0QGEN8IPE0",
                "X-Client-Secret:53c7c5527582402f45c38dfe125858b646c7622c",
                "Authorization:Bearer ".$this->payout_authorize_token_verify()
        );


        $postparams = array("beneId"=>$bene_id);
        $postdata = json_encode($postparams);

        $ch = curl_init();      
        curl_setopt($ch,CURLOPT_URL,  $authorize_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$postdata);
        $buffer = curl_exec($ch);       
        curl_close($ch);   

        /*
        {"status":"SUCCESS","subCode":"200","message":"Token is valid"}
        */
        $json_obj = json_decode($buffer);
        if(isset($json_obj->status))
        {
            $status =$json_obj->status;
            if($status == "SUCCESS")
            {
                $this->db->query("update cashfree_payout_bene set status = 'DELETED' where Id = ?",array($bene_id));
                $resp_array = array(
                    "status"=>0,
                    "statuscode"=>"TXN",
                    "message"=>$json_obj->message
                );
                echo json_encode($resp_array);
            }
            else
            {
                $resp_array = array(
                    "status"=>1,
                    "statuscode"=>"ERR",
                    "message"=>$json_obj->message
                );
                echo json_encode($resp_array);
            }
        }
        else
        {
            $resp_array = array(
                    "status"=>1,
                    "statuscode"=>"ERR",
                    "message"=>"Some Error Occured"
                );
            echo json_encode($resp_array);
        }
    }



    public function transfer($bene_name,$bankAccount,$ifsc,$userinfo)
    {

        $add_date = $this->common->getDate();
        $ipaddress = $this->common->getRealIpAddr();
        $user_id = $userinfo->row(0)->user_id;
        $email = "support@payin.co.in";
        $phone = $userinfo->row(0)->mobile_no;
        $bankAccount = $bankAccount;
        $address1 = "Thana Naka Road";
        $city = "Mumbai";
        $state = "Maharashtra";
        $pincode = "410206";
        $resp_bene_id = "";
        $status = "Pending";



        $rslt_insert = $this->db->query("insert into cashfree_payout_bene(add_date, ipaddress, user_id, bane_name, email, phone, bankAccount, ifsc, address1, city, state, pincode, resp_bene_id, status) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
            array($add_date, $ipaddress, $user_id, $bene_name, $email, $phone, $bankAccount, $ifsc, $address1, $city, $state, $pincode, $resp_bene_id, $status));
        if($rslt_insert == true)
        {
            $insert_id = $this->db->insert_id();
            $url = 'https://payout-gamma.cashfree.com';

            $authorize_url = $url.'/payout/v1/addBeneficiary';
            $header = array(
                    "Accept: application/json",
                    "X-Client-Id:CF107636C8CVSCRG1A0QGEN8IPE0",
                    "X-Client-Secret:53c7c5527582402f45c38dfe125858b646c7622c",
                    "Authorization:Bearer ".$this->payout_authorize_token_verify()
            );

             //   print_r($header);
               // echo "<br>";

            $postparams = array(
                    "beneId"=>$insert_id,
                    "name"=>$bene_name,
                    "email"=>$email,
                    "phone"=>$phone,
                    "bankAccount"=>$bankAccount,
                    "ifsc"=>$ifsc,
                    "address1"=>$address1,
                    "city"=>$city,
                    "state"=>$state,
                    "pincode"=>$pincode,
            );
            $postparams = json_encode($postparams);


              //  echo $postparams."<br><br>";exit;

            $ch = curl_init();      
            curl_setopt($ch,CURLOPT_URL,  $authorize_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$postparams);
            $buffer = curl_exec($ch);       
            curl_close($ch);   

            //echo $buffer;exit;
            $json_obj = json_decode($buffer);
            if(isset($json_obj->status))
            {
                $status =$json_obj->status;
                $message =$json_obj->message;
                if($status == "SUCCESS")
                {
                   $this->db->query("update cashfree_payout_bene status = 'SUCCESS',response_message=? where Id = ?",array($message,$insert_id));
                   $resp_array = array(
                        "status"=>0,
                        "message"=>$message,
                        "statuscode"=>"TXN",
                        "bene_id"=>$insert_id
                   );
                   echo json_encode($resp_array);
                }
                else
                {
                    $this->db->query("update cashfree_payout_bene status = ?,response_message=? where Id = ?",array($status,$message,$insert_id));
                    $resp_array = array(
                        "status"=>1,
                        "message"=>$message,
                        "statuscode"=>"ERR",
                        "bene_id"=>$insert_id
                   );
                   echo json_encode($resp_array);
                }
            }
            else
            {
                $this->db->query("update cashfree_payout_bene status = ?,response_message=? where Id = ?",array("FAILURE","Unknown Response",$insert_id));
                $resp_array = array(
                        "status"=>1,
                        "message"=>"Unknown Response",
                        "statuscode"=>"ERR",
                        "bene_id"=>$insert_id
                   );
                   echo json_encode($resp_array);
            }
        }

        
        /*
        {"status":"SUCCESS","subCode":"200","message":"Beneficiary added successfully"}

        */
        
    }

}

?>