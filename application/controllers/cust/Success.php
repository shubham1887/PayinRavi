<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Success extends CI_Controller {
    public function testview()
    {
        $this->view_data["UID"] = 44;
		 $this->view_data["AgentId"] = 5;
		 
		 $this->load->view("cust/success_view",$this->view_data);
    }
	public function resplog($data)
	{
		$date = $this->common->getMySqlDate();
		$filename = "inlogs/payu.txt";
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
		  //  error_reporting(-1);
		  //  ini_set('display_errors',1);
		  //  $this->db->db_debug = TRUE;
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache"); 
			
			
			
			$this->resplog(json_encode($this->input->post()));
			//$resp = '{"isConsentPayment":"0","mihpayid":"10459763791","mode":"NB","status":"success","unmappedstatus":"captured","key":"qeWXbnpq","txnid":"abb744feb948f8baac66","amount":"2.00","additionalCharges":"0.05","addedon":"2020-06-04 16:56:58","productinfo":"{\"paymentParts\":[{\"name\":\"kamlesh soni\",\"value\":2,\"merchantId\":\"6576792\",\"description\":\"Recharge\",\"commission\":\"0\",\"UID\":45,\"AgentId\":\"5\"}]}","firstname":"kamlesh soni","lastname":"","address1":"","address2":"","city":"","state":"","country":"","zipcode":"","email":"kamleshsoni111@gmail.com","phone":"9924160199","udf1":"","udf2":"","udf3":"","udf4":"","udf5":"","udf6":"","udf7":"","udf8":"","udf9":"","udf10":"","hash":"46fb67a7db7ed3a70174ff219b4b883542615fb491aa0a1eb75034bbca797b0c75a3cce19886241c0c0f5ff08496a63607519432067610b389e432499f235b07","field1":"","field2":"","field3":"","field4":"","field5":"","field6":"","field7":"","field8":"","field9":"Transaction Completed Successfully","PG_TYPE":"ICICI","encryptedPaymentId":"A7AC0AC52D3E8592AE0350AEA05ACC8D","bank_ref_num":"2001177543","bankcode":"ICIB","error":"E000","error_Message":"No Error","amount_split":"{\"PAYU\":\"2.05\"}","payuMoneyId":"{\"paymentId\":326215051,\"splitIdMap\":[{\"amount\":2.00,\"splitPaymentId\":326215053,\"merchantId\":6576792,\"splitId\":\"kamlesh soni\"}]}","net_amount_debit":"2.05"}';
			//$_POST = (array)json_decode($resp);
			//print_r($_POST);exit;
			
			$status=$_POST["status"];
			$firstname=$_POST["firstname"];
			$amount=$_POST["amount"];
			$txnid=$_POST["txnid"];
			$posted_hash=$_POST["hash"];
			$key=$_POST["key"];
			$productinfo=$_POST["productinfo"];
			$email=$_POST["email"];
			//$salt="e5iIg1jwi8";
			$salt="XOP387AvHy";
			
			
			
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
    	        //$merchantId = $paymentParts->merchantId;
    	        $description = $paymentParts->description;
    	        $UID = $paymentParts->UID;
    	        $AgentId = $paymentParts->AgentId;
    	        
    	        $UID_rslt = $this->db->query("select * from payu_transactions where Id = ? and user_id = ?",array($UID,$AgentId));
    	        //print_r( $UID_rslt->result());exit;
    	        if($UID_rslt->num_rows() == 1)
    	        {
    	            
    	            $user_id = $AgentId;
    	            $UID_db_status = $UID_rslt->row(0)->status;
    	            $UID_db_Amount = $UID_rslt->row(0)->Amount;
    	            //var_dump($amount == $UID_db_Amount);exit;
    	            if($amount == $UID_db_Amount)
    	            {
    	                
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
        	                $this->resplog("insertion update done : ");
        	                //echo $status;exit;
        	                
        	                if($status != "success")
                		    {
                		        echo " Transaction ".$status;exit;
                		    }
                		    
                	         
                	           // if ($this->session->userdata('user_type') != "Agent")
                	           if(false)
                    			{ 
                    				
                    			} 
                    			else
                    			{
                    			    $this->resplog("step before  additionalCharges: ");
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
                					     $add_date = $this->common->getDate();
                					     $ipaddress = $this->common->getRealIpAddr();
                					     $remark = $field9;
                					     $txtTid = $bank_ref_num;
                					    
                					     echo "<h2 style='color:#F00;margin:0 auto'>Payment Done Successfully. Updated Withing 1 Hour</h2>";exit;
                					
                						
                					 }
                    			}
                	            
                	        
        	            }
    	            }
    	            
    	             
    	        }
    	    }
    	    
		
	  
	}

}