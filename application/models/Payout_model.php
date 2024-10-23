<?php
class Payout_model extends CI_Model 
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

    public function get_casfree_bene_id($user_id,$bankAccount,$ifsc)
    {
        $rslt = $this->db->query("select Id from cashfree_payout_bene where user_id = ? and bankAccount = ? and ifsc = ? and status = 'SUCCESS' order by Id desc limit 1",array($user_id,$bankAccount,$ifsc));
        if($rslt->num_rows() == 1)
        {
            return $rslt->row(0)->Id;
        }
        return false;
    }
    public function payout($account_number,$account_name,$ifsc,$bank_id,$amount,$mode,$order_id,$userinfo)
    {
         $this->load->model("Ewallet_aeps");
        
            $user_id = $userinfo->row(0)->user_id;
            $username = $userinfo->row(0)->mobile_no;
            $businessname = $userinfo->row(0)->businessname;
            $amount = intval($amount);
            
            if($amount > 0 and $amount <= 200000)
            {
                $balance = $this->Ewallet_aeps->getAgentBalance($user_id);
                if($balance >= $amount)
                {
                       $transaction_charge = 7;
                       
                       $rsltinsert = $this->db->query("insert into payout_requests(user_id,add_date,ipaddress,sp_key,external_ref,credit_account,credit_rmn,ifs_code,bene_name,credit_amount,upi_mode,vpa,latitude,longitude,endpoint_ip,remarks,mode,transaction_charge,order_id) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                            array($user_id,$this->common->getDate(),$this->common->getRealIpAddr(),"DPN","",$account_number,"",$ifsc,$account_name,$amount,"","","23.022505","72.571365",$this->common->getRealIpAddr(),$username,$mode,$transaction_charge,$order_id));
                        if($rsltinsert == true)
                        {
                            $insert_id= $this->db->insert_id();
                            $external_ref = "PAYOUT".$insert_id;
                            $this->db->query("update payout_requests set external_ref = ? where Id = ?",array($external_ref ,$insert_id));

                            $cr_user_id = 1;
                            $dr_user_id = $user_id;
                            $description = "PAYOUT >> Admin To ".$businessname;
                            $payment_type = "PAYOUT";

                            $payout_id = $insert_id;
                            
                            
                            $ewrslt = $this->Ewallet_aeps->PayoutDebitEntry($user_id,$amount,$transaction_charge,$payout_id,$description);
                            if($ewrslt == true)
                            {



//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////  START    PAYOUT API CODE /////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////                              
//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////// start payout api call ////////////////////////////////////////////////


/*
 "username"=> "9820458677",
  "password"=> "939017",
  "apitoken"=> "338784719030350728463082207282",
*/
  $API = 'PDRS';
if($API == "PDRS")
{
    $url = 'https://pdrs.online/webapi/Payout';
    $req = array(
                "username"=> "9820458677",
                "password"=> "939017",
                "apitoken"=> "338784719030350728463082207282",
                "request"=>array(
                                    "account_number"=>$account_number,
                                    "account_name"=>$account_name,
                                    "ifsc"=>$ifsc,
                                    "amount"=>$amount,
                                    "mode"=>$mode,
                                    "order_id"=>"PAYOUT".$insert_id
                                )
        );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Accept: application/json'
    ));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req));
    curl_setopt($ch, CURLOPT_URL, $url);
    $buffer = $response = $buffer = curl_exec($ch);
    curl_close($ch);
    $this->load->model("Errorlog");
    $this->Errorlog->httplog($url.">>".json_encode($req),$buffer);
    $json_obj = json_decode($buffer);
    if(isset($json_obj->message) and isset($json_obj->status) and isset($json_obj->statuscode) )
    {
            $message = $json_obj->message;
            $status = $json_obj->status;
            $statuscode = $json_obj->statuscode;
            if($statuscode == "TXN")
            {
                $data = $json_obj->data;
                $tid = trim((string)$data->tid);
                $bank_ref_num = trim((string)$data->opr_id);
                $recipient_name = trim((string)$data->name);
                $this->db->query("update payout_requests set status = 'Success',bank_ref_no=?,resp_bene_name=?,UNIQUEID=? where Id = ?",array($bank_ref_num,$recipient_name,$tid,$insert_id));

                 $resp_arr = array(
                                            "message"=>"TRANSACTION DONE SUCCESSFULLY",
                                            "status"=>0,
                                            "statuscode"=>"TXN",
                                            "data"=>array(
                                                "tid"=>$insert_id,
                                                "ref_no"=>$tid,
                                                "opr_id"=>$bank_ref_num,
                                                "name"=>$recipient_name,
                                                "amount"=>$amount,
                                                "txn_status"=>"Success"
                                            )
                                        );
                        $json_resp =  json_encode($resp_arr);
                        return $json_resp;

            }
            else if($statuscode == "ERR")
            {
                $tid = "";
                $bank_ref_num = "";
                $recipient_name = "";
                $this->db->query("update payout_requests set status = 'Failure',bank_ref_no=?,resp_bene_name=?,UNIQUEID=? where Id = ?",array($bank_ref_num,$recipient_name,$tid,$insert_id));

                $this->Ewallet_aeps->PayoutCreditEntry($user_id,$amount,$transaction_charge,$payout_id,$description);

                 $resp_arr = array(
                                            "message"=>"TRANSACTION FAILED",
                                            "status"=>1,
                                            "statuscode"=>"ERR",
                                            "data"=>array(
                                                "tid"=>$insert_id,
                                                "ref_no"=>$tid,
                                                "opr_id"=>$bank_ref_num,
                                                "name"=>$recipient_name,
                                                "amount"=>$amount,
                                                "txn_status"=>"Failure"
                                            )
                                        );
                        $json_resp =  json_encode($resp_arr);
                        return $json_resp;

            }
            else
            {
                $data = "";
                $tid = "";
                $bank_ref_num = "";
                $recipient_name = "";
               

                 $resp_arr = array(
                                            "message"=>"TRANSACTION UNDER PENDING PROCESS",
                                            "status"=>0,
                                            "statuscode"=>"TUP",
                                            "data"=>array(
                                                "tid"=>$insert_id,
                                                "ref_no"=>$tid,
                                                "opr_id"=>$bank_ref_num,
                                                "name"=>$recipient_name,
                                                "amount"=>$amount,
                                                "txn_status"=>"Pending"
                                            )
                                        );
                        $json_resp =  json_encode($resp_arr);
                        return $json_resp;

            }
    }
}
else
{
    $this->load->model("Cashfree_model");
    $url = 'https://payout-gamma.cashfree.com';

    $authorize_url = $url.'/payout/v1.2/requestTransfer';
    
    $header = array(
            "Accept: application/json",
            "X-Client-Id:CF107636C8CVSCRG1A0QGEN8IPE0",
            "X-Client-Secret:53c7c5527582402f45c38dfe125858b646c7622c",
            "Authorization:Bearer ".$this->Cashfree_model->payout_authorize_token_verify()
    );

             //   print_r($header);
               // echo "<br>";

            $postparams = array(
                    "beneId"=>$this->get_casfree_bene_id($user_id,$account_number,$ifsc),
                    "amount"=>$amount,
                    "transferId"=>$insert_id
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
            /*
{
  "status":"SUCCESS", 
  "subCode":"200", 
  "message":"Transfer completed successfully", 
  "data": 
  {
    "referenceId":"10023",
    "utr":"P16111765023806",
    "acknowledged": 1
  }
}
            */
            $json_obj = json_decode($buffer);
            if(isset($json_obj->status))
            {
                $status =$json_obj->status;
                $message =$json_obj->message;
                if($status == "SUCCESS")
                {
                    $utr = $json_obj->data->utr;
                    $tid = trim((string)$json_obj->data->referenceId);
                    $bank_ref_num = $utr;
                    $recipient_name = "";
                    $this->db->query("update payout_requests set status = 'Success',bank_ref_no=?,resp_bene_name=?,UNIQUEID=? where Id = ?",array($bank_ref_num,$account_name,$tid,$insert_id));

                     $resp_arr = array(
                                            "message"=>"TRANSACTION DONE SUCCESSFULLY",
                                            "status"=>0,
                                            "statuscode"=>"TXN",
                                            "data"=>array(
                                                "tid"=>$insert_id,
                                                "ref_no"=>$tid,
                                                "opr_id"=>$bank_ref_num,
                                                "name"=>$account_name,
                                                "amount"=>$amount,
                                                "txn_status"=>"Success"
                                            )
                                        );
                        $json_resp =  json_encode($resp_arr);
                        return $json_resp;
                }
                else if($status == "ERROR")
                {
                    $tid = "";
                    $bank_ref_num = "";
                    $recipient_name = "";
                    $this->db->query("update payout_requests set status = 'Failure',bank_ref_no=?,resp_bene_name=?,UNIQUEID=? where Id = ?",array($bank_ref_num,$account_name,$tid,$insert_id));

                    $this->Ewallet_aeps->PayoutCreditEntry($user_id,$amount,$transaction_charge,$payout_id,$description);

                    $resp_arr = array(
                                            "message"=>"TRANSACTION FAILED",
                                            "status"=>1,
                                            "statuscode"=>"ERR",
                                            "data"=>array(
                                                "tid"=>$insert_id,
                                                "ref_no"=>$tid,
                                                "opr_id"=>$bank_ref_num,
                                                "name"=>$recipient_name,
                                                "amount"=>$amount,
                                                "txn_status"=>"Failure"
                                            )
                                        );
                    $json_resp =  json_encode($resp_arr);
                    return $json_resp; 
                }
            }
}










///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// END PAYOUT API CALL /////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX//
//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX//
//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX//
//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX//
//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX//
///////////////////////////////////////////////////////////////////////////////////////////////









                            }
                            else
                            {
                                $resp_array = array(
                                        "status"=>"1",
                                        "statuscode"=>"ERR",
                                        "message"=>"Some Error Occured. Please Try Again..",

                                    );
                                return json_encode($resp_array);
                            }
                        }
                        else
                        {
                            $resp_array = array(
                                        "status"=>"1",
                                        "statuscode"=>"ERR",
                                        "message"=>"Some Error Occured. Please Try Again",

                                    );
                            return json_encode($resp_array);
                        }

                    
                }
                else
                {
                    $resp_array = array(
                                        "status"=>"1",
                                        "statuscode"=>"ERR",
                                        "message"=>"Internal Server Error..",

                                    );
                    return json_encode($resp_array);
                }
            }
            else
            {
                $resp_array = array(
                                        "status"=>"1",
                                        "statuscode"=>"ERR",
                                        "message"=>"Invalid Amount",

                                    );
                return json_encode($resp_array);
            }
            
        
        
    }

}

?>