<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Success_payment extends CI_Controller {

	public function resplog($data)
	{
		$date = $this->common->getMySqlDate();
		$filename = $date."payu.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $this->common->getDate()." >> ".$data."\n", 'a+');
write_file($filename, $this->common->getRealIpAddr()." >> \n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
	}
	public function index()
	{	error_reporting(1);
	    	ini_set('display_errors',1);
	    	
	    	
	    	
	    //	print_r($post);exit;
	    	
		    $res = '';
		 
		    $this->resplog("post : ".json_encode($this->input->post()));
		    $this->resplog("get : ".json_encode($this->input->get()));
			$json = file_get_contents('php://input');
		    $this->resplog("    input : ".$json );
		    
		    
		   // $postdata = '{"isConsentPayment":"0","mihpayid":"10305355399","mode":"NB","status":"success","unmappedstatus":"captured","key":"ImRLeo","txnid":"1588882724029","amount":"1.00","addedon":"2020-05-08 01:48:51","productinfo":"Recharge","firstname":"System Retailer","lastname":"","address1":"","address2":"","city":"","state":"","country":"","zipcode":"","email":"newrcname@gmail.com","phone":"8238232303","udf1":"","udf2":"","udf3":"","udf4":"","udf5":"","udf6":"","udf7":"","udf8":"","udf9":"","udf10":"","hash":"1a6f1ad6dd09c336f133b3c759a1c33afdd6306d4c066b320c0022fb060a84a2eb4f79f959bd1fcf889ed6f13c38018b96db84e0b80671af20327440cdbd64e9","field1":"","field2":"","field3":"","field4":"","field5":"","field6":"","field7":"","field8":"Transaction Completed Successfully","field9":"Paid","PG_TYPE":"SBINB","encryptedPaymentId":"DB173E30ABCC1B0F49A844147FAC417C","bank_ref_num":"IGAIOPGTN2","bankcode":"SBIB","error":"E000","error_Message":"No Error","amount_split":"{\"PAYU\":\"1.00\"}","payuMoneyId":"319824350","net_amount_debit":"1"}';
	    	//$_POST = (array)json_decode($postdata);
		    
		    $this->resplog("Start");
		    
		//print_r();exit;
		
		    $status=$_POST["status"];
			$firstname=$_POST["firstname"];
			$amount=$_POST["amount"];
			$txnid=$_POST["txnid"];
			$posted_hash=$_POST["hash"];
			$key=$_POST["key"];
			$productinfo=$_POST["productinfo"];
			$email=$_POST["email"];
			//$salt="e5iIg1jwi8";
			$salt="ywsZBgg1";
			
			
			
			///othre important inputs
			$field8 = $_POST["field8"];//Transaction Completed Successfully
			$field9 = $_POST["field9"];//PAID
		    $additionalCharges = $_POST["additionalCharges"];// 0.25  optional parameter
		    $mihpayid = $_POST["mihpayid"];// 9942601697
		    $PG_TYPE = $_POST["PG_TYPE"];//ICICI
		    $encryptedPaymentId = $_POST["encryptedPaymentId"];//93FDA82331C419CC3A50C2C12F918737
		    $bank_ref_num = $_POST["bank_ref_num"];//1932709088
		    $bankcode = $_POST["bankcode"];//ICIB
		    $error  = $_POST["error"];//E000
		    $error_Message = $_POST["error_Message"];//E000
		    $amount_split = $_POST["amount_split"];//{"PAYU":"11.25"}
		    $payuMoneyId = $_POST["payuMoneyId"];/*{"paymentId":305615388,"splitIdMap":[{"amount":11.00,"splitPaymentId":305615389,"merchantId":6576792,"splitId":"Ripra Agency"}]}*/
		    $net_amount_debit = $_POST["net_amount_debit"];//11.25
		    
		    $this->resplog("step 1");
		//echo $txnid;exit;
		    $UID_rslt = $this->db->query("select * from payu_transactions where txnid = ?",array($txnid));
		    if($UID_rslt->num_rows() == 1)
		    {
		        $this->resplog("step 2");
		        $UID_db_status = $UID_rslt->row(0)->status;
	            $UID_db_Amount = $UID_rslt->row(0)->Amount;
	            //var_dump($amount == $UID_db_Amount);exit;
	            if($amount == $UID_db_Amount)
	            {
	                $this->resplog("step 3");
	                if($UID_db_status == "pending")
	                {
	                    $this->resplog("step 4");
	                    $this->db->query("
        	                update 
        	                payu_transactions 
        	                set 
        	                    status = ?,
        	                    RESP_field9 = ?,
        	                    RESP_additionalCharges = ?,
        	                    RESP_mihpayid = ?,
        	                    RESP_PG_TYPE = ?,
        	                    RESP_encryptedPaymentId = ?,
        	                    RESP_bank_ref_num = ?,
        	                    RESP_bankcode = ?,
        	                    RESP_error = ?,
        	                    RESP_error_Message = ?,
        	                    RESP_amount_split = ?,
        	                    RESP_payuMoneyId = ?,
        	                    RESP_net_amount_debit = ?,
        	                    update_datetime = ?,
        	                    update_ip = ?
        	                    where Id = ?
        	                    ",
        	                    array(
        	                        $status,
        	                        $field9,$additionalCharges,$mihpayid,
        	                        $PG_TYPE,$encryptedPaymentId,$bank_ref_num,
        	                        $bankcode,$error,$error_Message,
        	                        $amount_split,$payuMoneyId,$net_amount_debit,
        	                        $this->common->getDate(),$this->common->getRealIpAddr(),
        	                        $UID_rslt->row(0)->Id
        	                        ));
        	               $this->resplog("step 5");
        	                        
        	                if($status != "success")
                		    {
                		        $this->resplog("step 6");
                		        echo " Transaction ".$status;exit;
                		    }
                		    If (isset($_POST["additionalCharges"])) 
                			{
                			    $this->resplog("step 7");
                				   $additionalCharges=$_POST["additionalCharges"];
                				   $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;    
                			}
                			else 
                			{	  
                			    $this->resplog("step 8");
                				$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
                			}
                			$this->resplog("step 9");
                			 $hash = hash("sha512", $retHashSeq);
        					 $this->resplog("HASH : ".$hash."     posted_hash=".$posted_hash);
        					 if ($hash != $posted_hash) 
        					 {
        					     $this->resplog("step 10");
        						echo "Invalid Transaction. Please try again";
        					 }
        					 else 
        					 {
        					     $this->resplog("step 11");
        					 	 $this->resplog("Before Insert");
        					 	$this->load->model("Insert_model");
        					 	$description = "Onlien Payment ".$bank_ref_num."  ".$PG_TYPE."  ".$payuMoneyId."  ".$bankcode."  ".$txnid;
        					 	$this->Insert_model->tblewallet_Payment_CrDrEntry($UID_rslt->row(0)->user_id,1,$amount,"Wallet",$description,$txnid);
        						
        						$res=  "<html>";
        							$res.= "<head>";
        							$res.= "</head>";
        							$res.= '<body style="color:#FFF;font-weight:bold" >';
        							$res.= '<div id="mydiv" style="height:800px;text-align: left;">';
        							 $res.= "<h3>Thank You. Your order status is ". $status .".</h3>";
        							 $res.= "<h4>Your Transaction ID for this transaction is ".$txnid.".</h4>";  
           							
        							$res.= '</div>';
        							$res.= "</body>";
        						$res.= "</html>";
        						$res.='<style>
                                          body
                                          {
                                          margin:0;
                                          padding:0;
                                          }
                                          #mydiv {
                                          height:400px;
                                          position: relative;
                                          background-color: #a5c339; /* for demonstration */
                                        }
                                        .ajax-loader {
                                          position: absolute;
                                          left: 50%;
                                          top: 50%;
                                          margin-left: -32px; /* -1 * image width / 2 */
                                          margin-top: -32px; /* -1 * image height / 2 */
                                        }
                                          </style>'; 
                                           $res.="<script language=\"javascript\">
                                           $('#mydiv').css(\"height\", $(document).height());
                                          </script>";
                                          echo $res;exit;    
        						
        					 }
	                }
	            }
		    }
		
		
		
		
		
		
		
		
		
		    exit;

            $salt = "ywsZBgg1"; # salt value need to be picked from your database
            
            $amount = $_POST["amount"]; # amount need to be picked up from your database
            
            
            $reverseHash = $this->generateReverseHash();
           // echo  $_POST["hash"]."<br>".$reverseHash;exit;
            if ($_POST["hash"] == $reverseHash)
            {
                # transaction Succeeded
                # do the required javascript task
                echo ("Transaction Succeeded & Verified");
                //$this->successCallbackToApp($_POST);
            }
            else
            {
                # transaction is tempered
                # handle it as required
                echo ("<br>");
                echo "\nInvalid transaction--";
            }

            # For iOS Success

      
	}
	public function successCallbackToApp($payuResponse)
    {
	$appResponse->response = http_build_query($payuResponse);
    $appResponseInJSON = json_encode($appResponse);

    
    $res= "" . http_build_query($payuResponse);
    $res= strval($res);

    echo '<script type="text/javascript">';
    // For WKWebview
    echo'if (typeof window.webkit.messageHandlers.observe.postMessage == "function")';
    echo "{ window.webkit.messageHandlers.observe.postMessage({'onSuccess':JSON.stringify($appResponseInJSON)}); }";
    // For UIWebView
    echo 'else { function payu_merchant_js_callback() { PayU.onSuccess("' .$res.'");  } }';
    echo '</script>';
}

    # Function to generate reverse hash
    public function generateReverseHash()
    {
        global $salt;
        global $amount;
        if ($_POST["additional_charges"] != null)
        {
    
            $reversehash_string = $_POST["additional_charges"] . "|" . $salt . "|" . $_POST["status"] . "||||||" . $_POST["udf5"] . "|" . $_POST["udf4"] . "|" . $_POST["udf3"] . "|" . $_POST["udf2"] . "|" . $_POST["udf1"] . "|" . $_POST["email"] . "|" . $_POST["firstname"] . "|" . $_POST["productinfo"] . "|" . $amount . "|" . $_POST["txnid"] . "|" . $_POST["key"];
    
        }
        else
        {
            $reversehash_string = $salt . "|" . $_POST["status"] . "||||||" . $_POST["udf5"] . "|" . $_POST["udf4"] . "|" . $_POST["udf3"] . "|" . $_POST["udf2"] . "|" . $_POST["udf1"] . "|" . $_POST["email"] . "|" . $_POST["firstname"] . "|" . $_POST["productinfo"] . "|" . $amount . "|" . $_POST["txnid"] . "|" . $_POST["key"];
    
        }
        $status = $_POST["status"];
        $salt = "ywsZBgg1";
        $MERCHANT_KEY = $_POST["key"];
        $txnid = $_POST["txnid"];
        $amount = $_POST["amount"];
        $productinfo = $_POST["productinfo"];
        $business_name = $_POST["firstname"];
        $email = $_POST["email"];
        
        
        //$hash_string = "$MERCHANT_KEY|$txnid|$amount|$productinfo|$business_name|$email|||||||||||";
        
        $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$business_name.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$MERCHANT_KEY;
        //echo $hash_string;exit;
        //  echo($reversehash_string);
        //$reverseHash = strtolower(hash("sha512", $hash_string));
        $hash = strtolower(hash('sha512', $retHashSeq));
    
        return $hash;
    }

}