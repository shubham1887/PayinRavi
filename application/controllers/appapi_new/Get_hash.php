<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_hash extends CI_Controller {

	public function logentry($data)
	{
		$date = $this->common->getMySqlDate();
		$filename = $date."gethash.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $this->common->getDate()." >> ".$data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
	}
	public function index()
	{	
	error_reporting(-1);
	ini_set('display_errors',1);
	$this->db->db_debug = TRUE;
		
		$this->logentry(serialize($this->input->post()));
		
		
	
		if(isset($_GET["username"]) and isset($_GET["password"]))
		{
		    $username = substr(trim($_GET["username"]),0,10);
		    $password = substr(trim($_GET["password"]),0,20);
		    $userinfo = $this->db->query("select a.*,b.emailid from tblusers a left join tblusers_info b on a.user_id = b.user_id where a.username = ? and a.password = ?",array($username,$password));
		    if($userinfo->num_rows() == 1)
		    {
		        $user_id = $userinfo->row(0)->user_id;
		        //$business_name = $userinfo->row(0)->businessname;
		       // $emailid = $userinfo->row(0)->emailid;
		        //$emailid = "newrcname@gmail.com";
		        if(isset($_POST["key"]) and isset($_POST["amount"]) and isset($_POST["txnid"]) and isset($_POST["email"]) and isset($_POST["productinfo"]) and isset($_POST["firstname"]) and isset($_POST["udf1"]) and isset($_POST["udf2"]) and isset($_POST["udf3"]) and isset($_POST["udf4"])  and isset($_POST["udf5"]))
				{
					$key = "ImRLeo";
					$amount = trim($_POST["amount"]);
					$txnid = trim($_POST["txnid"]);
					$email = trim($_POST["email"]);
					$emailid = $email;
					$productinfo = trim($_POST["productinfo"]);
					$firstname = trim($_POST["firstname"]);
					$udf1 = "";
					$udf2 = "";
					$udf3 = "";
					$udf4 = "";
					$udf5 = "";
					
					$remark = "";
    				if($amount > 0 and $amount <= 200000)
    		        {
    		            $MERCHANT_KEY = $key;
            			$SALT = "ywsZBgg1";
            			$PAYU_MerchantId = 4952266;
            			//$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    			        
    			        $insertdata = $this->db->query("
    			                                        insert into payu_transactions
    			                                        (user_id,add_date,ipaddress,business_name,emaild,PAYU_MerchantId,Amount,remark,MERCHANT_KEY,SALT,txnid,status) 
    			                                        values(?,?,?,?,?,?,?,?,?,?,?,?)",
    			                                        array(
    			                                            $user_id,$this->common->getDate(),$this->common->getRealIpAddr(),$firstname,
    			                                            $emailid,$PAYU_MerchantId,$amount,$remark,
    			                                            $MERCHANT_KEY,$SALT,$txnid,"pending"
    			                                        ));
    			        if($insertdata == true)
    			        {
    			            $insert_id = $this->db->insert_id();
    			            $SALT = "ywsZBgg1";
        					$Remark = "Recharge";
        					$MERCHANT_KEY = $key;
        					$business_name = $firstname;
        					$productinfo = $productinfo;
        					$hash = '';
        					
        					
        					
        					$firstSplitArr = 
            				                array
            				                (
            				                    "name"=>$userinfo->row(0)->businessname, 
            				                    "value"=>$amount, 
            				                    "description"=>"Recharge", 
            				                    "commission"=>"0",
            				                    "UID"=>$insert_id,
            				                    "AgentId"=>$user_id
            				                );
            
                            $paymentPartsArr = array($firstSplitArr);	
                            $finalInputArr = array("paymentParts" => $paymentPartsArr);
                            $Prod_info2 = json_encode($finalInputArr);
                            
                            
        					
        					$hash_string = "$MERCHANT_KEY|$txnid|$amount|$productinfo|$business_name|$email|||||||||||";
        					
        					$hash_string .= $SALT;
        					$this->logentry("Hash String : ".$hash_string);
        					$hash = strtolower(hash('sha512', $hash_string));
        					$this->logentry("Hash : ".$hash);
        					$straresp = array("payment_hash"=>$hash);
        					echo json_encode($straresp);exit;
        					//echo $hash;exit;
    			            
    			            
    			            
    			            
    			        }
    		        }
					
					
					
				
					
					
				}
				else
				{
					echo "Invalid Parameter";exit;
				}
		    }
		}
			
				
					
	}

}