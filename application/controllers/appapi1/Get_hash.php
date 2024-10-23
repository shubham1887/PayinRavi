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
	
		
		$this->logentry(json_encode($this->input->get()));
		
		
		if(isset($_GET["username"]) and isset($_GET["password"]))
		{
			$username = trim($_GET["username"]);
			$pwd = trim($_GET["password"]);
			$userinfo = $this->db->query("select * from tblusers where username = ? and password = ?",array($username,$pwd));
			if($userinfo->num_rows()  == 1)
			{
			    
			    /*
			    http://www.jantaestore.com/appapi1/get_hash?
			    username=5151121537&
			    password=648922&
			    key=ImRLeo&
			    amount=10.0&
			    txnid=1588504970445&
			    email=xyz@gmail.com&
			    productinfo=product_info&
			    firstname=firstname&
			    udf1=&
			    udf2=&
			    udf3=&
			    udf4=&
			    udf5=
			    
			    */
					$user_id = $userinfo->row(0)->user_id;
					if(isset($_GET["key"]) and isset($_GET["amount"]) and isset($_GET["txnid"]) and isset($_GET["email"]) and isset($_GET["productinfo"]) and isset($_GET["firstname"]) and isset($_GET["udf1"]) and isset($_GET["udf2"]) and isset($_GET["udf3"]) and isset($_GET["udf4"])  and isset($_GET["udf5"]) )
					{
						$key = trim($_GET["key"]);
						$amount = trim($_GET["amount"]);
						$txnid = trim($_GET["txnid"]);
						$email = trim($_GET["email"]);
						$productinfo = trim($_GET["productinfo"]);
						$firstname = trim($_GET["firstname"]);
						$udf1 = "";
						$udf2 = "";
						$udf3 = "";
						$udf4 = "";
						$udf5 = "";
						//$user_credentials = trim($_GET["user_credentials"]);
						
						
						
						$SALT = "YYTBtl5hDI";
						$Remark = "Recharge";
						$MERCHANT_KEY = $key;
						$business_name = $firstname;
						$productinfo = $productinfo;
						$hash = '';
						$hash_string = "$MERCHANT_KEY|$txnid|$amount|$productinfo|$business_name|$email|||||||||||";
						
						$hash_string .= $SALT;
						$this->logentry("Hash String : ".$hash_string);
						$hash = strtolower(hash('sha512', $hash_string));
						$this->logentry("Hash : ".$hash);
						$straresp = array("payment_hash"=>$hash);
						echo json_encode($straresp);exit;
					//echo $hash;exit;
						
						
					}
					else
					{
						echo "Invalid Parameter";exit;
					}
			}
			else
			{
				echo "Invalid User Id password";exit;	
			}
		}
		else
		{
			echo "parameter missing";exit;
		}
	
		exit;
		 
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache"); 
			
			$status=$_GET["status"];
			$firstname=$_GET["firstname"];
			$amount=$_GET["amount"];
			$txnid=$_GET["txnid"];
			$posted_hash=$_GET["hash"];
			$key=$_GET["key"];
			$productinfo=$_GET["productinfo"];
			//$productinfo = $this->Common_methods->encrypt($user_id.",".$Amount.",".$company_id.",".$MobileNo.",".$rbRecharge.",".$cust_name.",".$isCredit);
			
			
			
			$productinfo2 = $this->Common_methods->decrypt($productinfo);
			$arr = explode(",",$productinfo2);
			$user_id = $arr[0];
			$Amount = $arr[1];
			$company_id = $arr[2];
			$Mobile = $arr[3];
			$rbRecharge = $arr[4];
			$cust_name = $arr[5];
			$isCredit = $arr[6];
			
			$email=$_GET["email"];
			//testing
			//$salt="e5iIg1jwi8";
			//live
			$salt="YYTBtl5hDI";
			
			
			If (isset($_GET["additionalCharges"])) 
			{
				   $additionalCharges=$_GET["additionalCharges"];
				   $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;    
			}
			else 
			{	  
				$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
			}
					 $hash = hash("sha512", $retHashSeq);
					 if ($hash != $posted_hash) 
					 {
						echo "Invalid Transaction. Please try again";
					 }
					 else 
					 {
					 	$user_info = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
						$circle_code = "*";
						$rechargeBy = "WEB";
						$company_info = $this->db->query("select * from tblcompany where company_id = ?",array($company_id));
						if($company_info->num_rows() == 1)
						{
							$service_id = $company_info->row(0)->service_id;
							$recharge_type = "Mobile";
							if($service_id == 1)
							{
								$recharge_type = "Mobile";
							}
							if($service_id == 2)
							{
								$recharge_type = "DTH";
							}
							if($service_id == 3)
							{
								$recharge_type = "Postpaid";
							}
							
							
							$this->load->model("Insert_model");
							$this->Insert_model->tblewallet_Payment_CrDrEntry($user_id,1,$amount,"Wallet",$txnid,"cash");
							$this->load->model("Do_recharge_model");
							$response = $this->Do_recharge_model->ProcessRecharge($user_info,$circle_code,$company_id,$Amount,$Mobile,$recharge_type,$service_id,$rechargeBy,$cust_name,$isCredit,$rbRecharge,$otherdata = NULL);
							redirect("http://deziremoney.com/test/ptest");
							
							
						}
					 	
						
					 }         
	}

}