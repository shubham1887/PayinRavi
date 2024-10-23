<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Success extends CI_Controller {

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
	{	
	//	echo "Stopped By Admin";exit;
		    $res = '';
		 
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache"); 
			
			
			
			$this->resplog(json_encode($this->input->post()));
			
			
			
				$status=$_POST["status"];
			$firstname=$_POST["firstname"];
			$amount=$_POST["amount"];
			$txnid=$_POST["txnid"];
			$posted_hash=$_POST["hash"];
			$key=$_POST["key"];
			$productinfo=$_POST["productinfo"];
			$email=$_POST["email"];
			//$salt="e5iIg1jwi8";
			$salt="YYTBtl5hDI";
			
			
				$res=  "<html>";
            							$res.= "<head>";
            							$res.= "</head>";
            							$res.= '<body style="color:#FFF;font-weight:bold" onLoad="submitPayuForm()">';
            							$res.= '<div id="mydiv" style="height:800px;text-align: center;">';
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
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		
			
			
			
			///othre important inputs
			$field9 = $_POST["field9"];//Transaction Completed Successfully
		    $additionalCharges = $_POST["additionalCharges"];// 0.25
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
		    
		    
		   
		    
		    
		
		    $productinfo = $_POST["productinfo"];//{"paymentParts":[{"name":"Ripra Agency","value":"4","merchantId":"6576792","description":"Recharge","commission":"0","UID":13,"AgentId":"7"}]}
    	  
    	    $productinfo_obj = json_decode($productinfo);
    	    if(isset($productinfo_obj->paymentParts))
    	    {
    	        $paymentParts = $productinfo_obj->paymentParts[0];
    	        $merchantId = $paymentParts->merchantId;
    	        $description = $paymentParts->description;
    	        $UID = $paymentParts->UID;
    	        $AgentId = $paymentParts->AgentId;
    	        
    	        $UID_rslt = $this->db->query("select * from payu_transactions where Id = ? and user_id = ?",array($UID,$AgentId));
    	       // print_r( $UID_rslt->result());exit;
    	        if($UID_rslt->num_rows() == 1)
    	        {
    	            $UID_db_status = $UID_rslt->row(0)->status;
    	            $UID_db_Amount = $UID_rslt->row(0)->Amount;
    	            //var_dump($amount == $UID_db_Amount);exit;
    	            if($amount == $UID_db_Amount)
    	            {
    	              //  echo $UID_db_status;exit;
    	                if($UID_db_status == "pending")
        	            {
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
        	                        $UID
        	                        ));
        	                
        	                //echo $status;exit;
        	                
        	                if($status != "success")
                		    {
                		        echo " Transaction ".$status;exit;
                		    }
        	                if($merchantId == "6576792")
                	        {
                	         
                	           // if ($this->session->userdata('user_type') != "Agent")
                	           if(true)
                    			{ 
                    				
                    			} 
                    			else
                    			{
                    			    
                        			If (isset($_POST["additionalCharges"])) 
                        			{
                        				   $additionalCharges=$_POST["additionalCharges"];
                        				   $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;    
                        			}
                        			else 
                        			{	  
                        				$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
                        			}
                        					 $hash = hash("sha512", $retHashSeq);
                					 $this->resplog("HASH : ".$hash."     posted_hash=".$posted_hash);
                					 if ($hash != $posted_hash) 
                					 {
                						echo "Invalid Transaction. Please try again";
                					 }
                					 else 
                					 {
                					 	 $this->resplog("Before Insert");
                					 	$this->load->model("Insert_model");
                					 	$this->Insert_model->tblewallet_Payment_CrDrEntry($this->session->userdata("id"),1,$amount,"Wallet",$txnid,"cash");
                						 $this->resplog("After Insert");
                						$res=  "<html>";
                							$res.= "<head>";
                							$res.= "</head>";
                							$res.= '<body style="color:#FFF;font-weight:bold" onLoad="submitPayuForm()">';
                							$res.= '<div id="mydiv" style="height:800px;text-align: center;">';
                							 $res.= "<h3>Thank You. Your order status is ". $status .".</h3>";
                							 $res.= "<h4>Your Transaction ID for this transaction is ".$txnid.".</h4>";
                							 $res.= "<h4>Please Wait............Redirecting...</h4>";  
                   							
                							$res.= '</div>';
                							$res.= "</body>";
                						$res.= "</html>";
                						
                					 }   
                					 $res.='
                					 <script language="javascript" src="../js/jquery-1.4.4.js" type="text/javascript"></script>
                                     <script>
                                    
                                    	function submitPayuForm() {
                                        
                                        window.setTimeout(function(){
                                    
                                            // Move to a new location or you can do something else
                                            window.location.href = "../Retailer/online_payments";
                                    
                                        }, 5000);
                                    
                                        }
                                      </script>';
                    			}
                	            
                	        }
                	        else
                	        {
                	            $this->resplog(serialize($this->input->post()));
                    			If (isset($_POST["additionalCharges"])) 
                    			{
                    				   $additionalCharges=$_POST["additionalCharges"];
                    				   $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;    
                    			}
                    			else 
                    			{	  
                    				$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
                    			}
                    					 $hash = hash("sha512", $retHashSeq);
            					 $this->resplog("HASH : ".$hash."     posted_hash=".$posted_hash);
            					 if ($hash != $posted_hash) 
            					 {
            						echo "Invalid Transaction. Please try again";
            					 }
            					 else 
            					 {
            					 	 $this->resplog("Before Insert");
            					 
            						 $this->resplog("After Insert");
            						$res=  "<html>";
            							$res.= "<head>";
            							$res.= "</head>";
            							$res.= '<body style="color:#FFF;font-weight:bold" onLoad="submitPayuForm()">';
            							$res.= '<div id="mydiv" style="height:800px;text-align: center;">';
            							 $res.= "<h3>Thank You. Your order status is ". $status .".</h3>";
            							 $res.= "<h4>Your Transaction ID for this transaction is ".$txnid.".</h4>";
            							 
               							
            							$res.= '</div>';
            							$res.= "</body>";
            						$res.= "</html>";
            						
            					 }   
            					 $res.='
            					 <script language="javascript" src="../js/jquery-1.4.4.js" type="text/javascript"></script>
                                 ';
                	        }  
        	            }
    	            }
    	            
    	             
    	        }
    	    }
    	    
		
		
		
        			
  
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