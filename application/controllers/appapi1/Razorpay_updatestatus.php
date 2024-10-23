<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Razorpay_updatestatus extends CI_Controller {
	function __construct()
	{
		parent:: __construct();
		$this->clear_cache();
		$this->load->model("Razorpay");
	}
	public function logentry($data)
	{

		$filename = "inlogs/razorpay_testlog_android.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
	}
	function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;





    }
    public function getPgCharge($group_id,$payment_group,$amount)
	{
		$rslt = $this->db->query("SELECT * FROM `pg_charge` where group_id = ? and payment_group = ?",array($group_id,$payment_group));
		if($rslt->num_rows() >= 1)
		{
			return (($rslt->row(0)->charge * $amount)/100);
		}
		return 0;
	}	
	public function index()
	{ 
		//echo "";exit;
		$getdata = json_encode($this->input->get());
		$this->logentry($getdata);
		//http://mastercash.co.in/appapi1/Razorpay_updatestatus?username=&pwd=&OrderId=&PaymentId=&Status=&code=&description=
			if(isset($_GET['username']) && isset($_GET['pwd']) && isset($_GET['OrderId'])  && isset($_GET['PaymentId'])  && isset($_GET['Status']))
			{
				$username = substr(trim($this->input->get('username')),0,10);
				$pwd =  substr(trim($this->input->get('pwd')),0,20);
				$OrderId =  trim($this->input->get('OrderId'));
				$PaymentId =  trim($this->input->get('PaymentId'));
				$Status =  trim($this->input->get('Status'));
				$sign =  trim($this->input->get('sign'));

				$code = "";
				$description = "";
				if(isset($_GET["code"]))
				{
					$code =  trim($this->input->get('code'));	
				}
				if(isset($_GET["description"]))
				{
					$description =  trim($this->input->get('description'));	
				}

				
				
					$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
					$userinfo = $this->db->query("select a.user_id,a.businessname,a.username,a.status,a.usertype_name,info.birthdate
					from tblusers  a 
					left join tblusers_info info on a.user_id = info.user_id
					where 
					a.username = ? and 
					a.password = ? 
					and a.host_id = ?",array($username,$pwd,$host_id));
					if($userinfo->num_rows() == 1)
					{
						$status = $userinfo->row(0)->status;
						$user_id = $userinfo->row(0)->user_id;
						$business_name = $userinfo->row(0)->businessname;
						$username = $userinfo->row(0)->username;
						$usertype_name = $userinfo->row(0)->usertype_name;
						$birthdate = $userinfo->row(0)->birthdate;
						if($status == '1')
						{
						   // $merchant_order_id = 'WeB'.substr(hash('sha256',mt_rand().microtime()),0,5).'Rozerpay'; //time();
						    $rsltcheck = $this->db->query(" SELECT * FROM `tbl_razorpay_order` where user_id = ? and resp_id = ?",array($user_id,$OrderId));
						    if($rsltcheck->num_rows() == 1)
						    {
						    	$insert_id = $rsltcheck->row(0)->Id;
						    	$amount = $rsltcheck->row(0)->amount;
						    	$credit_user_id = $rsltcheck->row(0)->user_id;
						    	$credit_amount = $amount;
						    	$my_merchant_trans_id = "";
						    	$my_merchant_order_id = "";

						    	$this->db->query("update tbl_razorpay_order set PaymentId=?,resp_status = ?,code = ?,description=? where Id = ?",array($PaymentId,$Status,$code,$description,$insert_id));


						    		$RAZOR_KEY_SECRET = $this->Razorpay->getRAZOR_KEY_SECRET();
									$hash = hash_hmac('sha256', $OrderId."|".$PaymentId, $RAZOR_KEY_SECRET);


									if($hash == $sign)
								//	if($Status == "Success")
									{
										if($Status == "Success")
										{

											 $description = "Razorpay : ".$credit_amount;
											 $remark = "Wallet Topup Through Rozarpay , Balace Credited :  ".$credit_amount;
	                    					$debit_user_id = 1;
	                    					$payment_type = "ONLINE";
								$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
								$cr_user_id = $user_id;
		                    		$dr_user_id = 1;
		                   		//	 $description = "By PG ".$payment_group." REF:".$bank_reference;
		                    	//	$payment_type = $payment_group;
		                   
		                   		//	 $group_id = $userinfo->row(0)->scheme_id;
		                    		//$pg_charge = $this->getPgCharge($group_id,$payment_group,$order_amount);

	                    					//$this->Insert_model->tblewallet_Payment_CrDrEntry($credit_user_id,$debit_user_id,$amount,$remark,$description,$payment_type);

	                    					//$ewrslt = $this->Ew2->tblewallet_Payment_CrDrPG($credit_user_id,$debit_user_id,$amount,$remark,$description,$payment_type);
										}
                    					

									}




							    	$resparray = array(
												'status'=>0,
												'message'=>'Response Updated Successfully'
												);
									echo json_encode($resparray);exit;   		
						    	
						    }
						    else
						    {
						 		$resparray = array(
								'status'=>1,
								'message'=>'Some Error Occured.Please Try Again'
								);
								echo json_encode($resparray);exit;   	
						    }
						   
						}
						else
						{
							$resparray = array(
							'status'=>1,
							'message'=>'Your account is deactivated. contact your Administrator'
							);
							echo json_encode($resparray);exit;
						}
					}
					else
					{
						$resparray = array(
							'status'=>1,
							'message'=>'Invalid UserId or Password'
							);
							echo json_encode($resparray);exit;
					}
				
				
			}
			else
			{
				echo 'Paramenter is missing';exit;
			}
	}	
}