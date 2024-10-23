<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Razorpay_getDetail extends CI_Controller {
	function __construct()
	{
		parent:: __construct();
		$this->clear_cache();
		$this->load->model("Razorpay");
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
	public function index()
	{ 

		//http://mastercash.co.in/appapi1/Razorpay_getDetail?username=&pwd=&amount=		
			if(isset($_GET['username']) && isset($_GET['pwd']) && isset($_GET['amount']))
			{
				$username = substr(trim($this->input->get('username')),0,10);
				$pwd =  substr(trim($this->input->get('pwd')),0,20);
				$amount =  intval(trim($this->input->get('amount')));
				if($amount >= 1)
				{
					if($amount <= 10000)
					{
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
							    $merchant_order_id = 'WeB'.substr(hash('sha256',mt_rand().microtime()),0,5).'Rozerpay'; //time();
							    $rsltinsert = $this->db->query("insert into tbl_razorpay_order(user_id,order_id,amount,payment_from,add_date,ipaddress) values(?,?,?,?,?,?)",array($user_id,$merchant_order_id,$amount,"ANDROID",$this->common->getDate(),$this->common->getRealIpAddr()));
							    if($rsltinsert == true)
							    {
							    	$insert_id = $this->db->insert_id();
							    	$response = $this->Razorpay->order($amount,$merchant_order_id);
							    	//echo $response;exit;
							    	/*
							    	{"id":"order_I42YIqviTJHbiu","entity":"order","amount":100000,"amount_paid":0,"amount_due":100000,"currency":"INR","receipt":"WeB18311Rozerpay","offer_id":null,"status":"created","attempts":0,"notes":[],"created_at":1633084309}
							    	*/
							    	$resp_obj = json_decode($response);
							    	if(isset($resp_obj->id) and isset($resp_obj->entity)  and isset($resp_obj->amount)  and isset($resp_obj->status))
							    	{
							    		$resp_id = $resp_obj->id;
							    		$resp_entity = $resp_obj->entity;
							    		$resp_amount = $resp_obj->amount;
							    		$resp_amount_paid = $resp_obj->amount_paid;
							    		$resp_amount_due = $resp_obj->amount_due;
							    		$resp_currency = $resp_obj->currency;
							    		$resp_receipt = $resp_obj->receipt;
							    		$resp_offer_id = "";
							    		if(isset($resp_obj->offer_id))
							    		{
							    				$resp_offer_id = $resp_obj->offer_id;	
							    		}
							    		
							    		$resp_status = $resp_obj->status;
							    		$resp_attempts = $resp_obj->attempts;
							    		$resp_notes = json_encode($resp_obj->notes);
										$resp_created_at = $resp_obj->created_at;

							    		$update_result = $this->db->query("update tbl_razorpay_order set resp_id = ?,resp_entity = ?,resp_amount = ?,resp_amount_paid = ?,resp_amount_due = ?,resp_currency = ?,resp_receipt = ?,resp_offer_id = ?,resp_status = ?,resp_attempts = ?,resp_notes = ?,resp_created_at = ? where Id = ?",array($resp_id,$resp_entity,$resp_amount,$resp_amount_paid,$resp_amount_due,$resp_currency,$resp_receipt,$resp_offer_id,$resp_status,$resp_attempts,$resp_notes,$resp_created_at,$insert_id));
							    		if($update_result == true)
							    		{
							    			if($resp_status == "created")
							    			{
							    				$RAZOR_KEY_ID = $this->Razorpay->getRAZOR_KEY_ID();
										    	$resparray = array(
												'status'=>0,
												'message'=>'SUCCESS',
												'data'=>array(
																"RAZORPAY_KEYID"=>$RAZOR_KEY_ID,
																"order_id"=>$resp_id,
																"EmailId"=>"support@payin.co.in",
																"Mobile"=>$username,
																"amount"=>($amount * 100),
															)
												);
												echo json_encode($resparray);exit; 
							    			}
							    			else
							    			{
												$resparray = array(
													'status'=>1,
													'message'=>'Some Error Occured 3.Please Try Again'
												);
												echo json_encode($resparray);exit;   	
							    			}
							    		}
							    		else
							    		{
							    			$resparray = array(
												'status'=>1,
												'message'=>'Some Error Occured 2.Please Try Again'
												);
											echo json_encode($resparray);exit;   				
							    		}
							    	}
							    	else
							    	{
							    		$resparray = array(
										'status'=>1,
										'message'=>'Unknown Response From Server.Please Try Again'
										);
										echo json_encode($resparray);exit;   			
							    	}
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
						$resparray = array("status"=>"1","message"=>"Maximum Limit For Add Money is 100000");
						echo json_encode($resparray);exit;
					}
				}
				else
				{
					$resparray = array("status"=>"1","message"=>"Minimum Limit For Add Money is 1000");
					echo json_encode($resparray);exit;

				}
			}
			else
			{
				echo 'Paramenter is missing';exit;
			}
	}	
}
