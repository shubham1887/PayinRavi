<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Razorpay_callback extends CI_Controller {
	public function checknull($data)
	{
		if($data == null or $data == NULL)
		{
			return "";
		}
		else
		{
			return $data;
		}
	}
	public function logentry($data)
	{

		$filename = "inlogs/razorpay_callback.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $this->common->getDate()."\n", 'a+');
write_file($filename, $this->common->getRealIpAddr()."\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
	}
	public function index2()
	{
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
		//secret= jTTGTjuC8GHhqNn1oAWGoNImIxuWPq5e
		$php_response = file_get_contents('php://input');
 		$response = json_encode($this->input->get());
 		$post_response = json_encode($this->input->get());
 		$this->logentry($response);
 		$this->logentry($post_response);

 		$this->logentry("php input :: ".$php_response);


 	/*	 $php_response = '{"entity":"event","account_id":"acc_FvQQcgb9k1IBAB","event":"payment.captured","contains":["payment"],"payload":{"payment":{"entity":{"id":"pay_JJxg78GAlwMmFl","entity":"payment","amount":1000,"currency":"INR","status":"captured","order_id":null,"invoice_id":null,"international":false,"method":"upi","amount_refunded":0,"refund_status":null,"captured":true,"description":"Order # WeB5cb5dRozerpay","card_id":null,"bank":null,"wallet":null,"vpa":"8238232303@ybl","email":"ravikantchavda365@gmail.com","contact":"+918238232303","notes":{"soolegal_order_id":"WeB5cb5dRozerpay"},"fee":5,"tax":0,"error_code":null,"error_description":null,"error_source":null,"error_step":null,"error_reason":null,"acquirer_data":{"rrn":"210649339504"},"created_at":1650097674}}},"created_at":1650097709}';

*/

 		$json_obj = json_decode($php_response);
		
		if(isset($json_obj->entity))	
		{
			$entity = $json_obj->entity;
			

			$this->logentry("setp 1");
			$account_id = $json_obj->account_id;
			$event = $json_obj->event;


			if($event == "order.paid" or $event == "payment.captured" )
			{

			}
			else
			{
				echo "";exit;
			}
			
			if(isset($json_obj->payload))
			{
				$this->logentry("setp 2");
				$payload = $json_obj->payload;	
				
				if(isset($payload->payment))
				{
					$this->logentry("setp 3");
					$payment = $payload->payment;	
					if(isset($payment->entity))
					{
						$paymententity = $payment->entity;

						$payment_id = $this->checknull($paymententity->id);
						$payment_entity = $this->checknull($paymententity->entity);
						$payment_amount = $this->checknull($paymententity->amount);
						$payment_currency = $this->checknull($paymententity->currency);
						$payment_status = $this->checknull($paymententity->status);
						$payment_order_id = $this->checknull($paymententity->order_id);
						$payment_invoice_id = $this->checknull($paymententity->invoice_id);
						$payment_international = $this->checknull($paymententity->international);
						$payment_method = $this->checknull($paymententity->method);
						$payment_amount_refunded = $this->checknull($paymententity->amount_refunded);
						$payment_refund_status = $this->checknull($paymententity->refund_status);
						$payment_captured = $this->checknull($paymententity->captured);
						$payment_description = $this->checknull($paymententity->description);
						$payment_card_id = $this->checknull($paymententity->card_id);
						$payment_bank = $this->checknull($paymententity->bank);
						$payment_wallet = $this->checknull($paymententity->wallet);
						$payment_vpa = $this->checknull($paymententity->vpa);
						$payment_email = $this->checknull($paymententity->email);
						$payment_contact = $this->checknull($paymententity->contact);
						$payment_fee = $this->checknull($paymententity->fee);

						$payment_tax = $this->checknull($paymententity->tax);
						$payment_error_code = $this->checknull($paymententity->error_code);
						$payment_error_description = $this->checknull($paymententity->error_description);
						$payment_error_source = $this->checknull($paymententity->error_source);
						$payment_error_step = $this->checknull($paymententity->error_step);
						$payment_error_reason = $this->checknull($paymententity->error_reason);
						$payment_acquirer_data = $paymententity->acquirer_data;

						$rrn = "";
						if(isset($payment_acquirer_data->rrn))
						{
							$rrn = $this->checknull($payment_acquirer_data->rrn);
						}

						$this->logentry("setp 4");

						$payment_created_at = $paymententity->created_at;


					}
				}


				$order_id = false;
				$order_entity = "";
				$order_amount = "";
				$order_amount_paid = "";
				$order_currency = "";
				$order_receipt = "";
				$order_offer_id = "";
				$order_status = "";
				$order_attempts = "";
				$order_created_at = "";
				if(isset($payload->order))
				{
					$this->logentry("setp 5");
					$order = $payload->order;	
					if(isset($order->entity))
					{
						$this->logentry("setp 6");
						$orderentity = $order->entity;

						$order_id = $this->checknull($orderentity->id);
						$order_entity = $this->checknull($orderentity->entity);
						$order_amount = $this->checknull($orderentity->amount);
						$order_amount_paid = $this->checknull($orderentity->amount_paid);
						$order_currency = $this->checknull($orderentity->currency);
						$order_receipt = $this->checknull($orderentity->receipt);
						$order_offer_id = $this->checknull($orderentity->offer_id);
						$order_status = $this->checknull($orderentity->status);
						$order_attempts = $this->checknull($orderentity->attempts);
						$order_created_at = $this->checknull($orderentity->created_at);
						

					}
				}

			//	echo $order_id;exit;
				$user_id = 0;

				if($order_id != false)
				{
					$orderInfo = $this->db->query("select * from tbl_razorpay_order where resp_id = ?",array($order_id));
					if($orderInfo->num_rows() == 1)
					{
						$user_id = $orderInfo->row(0)->user_id;
					}	
				}
				else
				{
					$orderInfo = $this->db->query("select * from tbl_razorpay where razorpay_payment_id = ?",array($payment_id));
					if($orderInfo->num_rows() == 1)
					{
						$user_id = $orderInfo->row(0)->user_id;
					}
				}
				
				$this->logentry("setp 7");
				//echo $user_id;exit;
				$add_date = $this->common->getDate();
				$ipaddress = $this->common->getRealIpAddr();

				$this->logentry("setp 8");
				$insertdata = $this->db->query("insert INTO razorpay_callback(add_date, ipaddress, entity, account_id, event, payment_id, payment_entity, payment_amount, payment_currency, payment_status, payment_order_id, payment_invoice_id, payment_international, payment_method, payment_amount_refunded, payment_refund_status, payment_captured, payment_description, payment_card_id, payment_bank, payment_wallet, payment_vpa, payment_email, payment_contact, payment_fee, payment_tax, payment_error_code, payment_error_description, payment_error_source, payment_error_step, payment_error_reason, rrn, payment_created_at, order_id, order_entity, order_amount, order_amount_paid, order_currency, order_receipt, order_offer_id, order_status, order_attempts, order_created_at, user_id) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($add_date, $ipaddress, $entity, $account_id, $event, $payment_id, $payment_entity, $payment_amount, $payment_currency, $payment_status, $payment_order_id, $payment_invoice_id, $payment_international, $payment_method, $payment_amount_refunded, $payment_refund_status, $payment_captured, $payment_description, $payment_card_id, $payment_bank, $payment_wallet, $payment_vpa, $payment_email, $payment_contact, $payment_fee, $payment_tax, $payment_error_code, $payment_error_description, $payment_error_source, $payment_error_step, $payment_error_reason, $rrn, $payment_created_at, $order_id, $order_entity, $order_amount, $order_amount_paid, $order_currency, $order_receipt, $order_offer_id, $order_status, $order_attempts, $order_created_at, $user_id));
				if($insertdata == true)
				{
					$this->logentry("setp 9");
					$insert_id = $this->db->insert_id();
					if($event == "order.paid" or $event == "payment.captured" )
					{
						if(( $order_status == "paid" or $payment_status == "captured") and $user_id > 1)
						{
							if(true)
					 		{
					 			$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
								$cr_user_id = $user_id;
			                    $dr_user_id = 1;
			                    $bank_reference = "";
			                    $description = "By PG ".$payment_method."";
			                    $payment_type = $payment_method;
			                   
			                    $group_id = $userinfo->row(0)->scheme_id;
			                    $pg_charge = $this->getPgCharge($group_id,$payment_method,$payment_amount);


			                    $txtRemark = "By PG ".$payment_method." REF:".$bank_reference;

			                   $checkduplicate = $this->db->query("insert into cashfree_rrn_locking(rrn,amount,add_date,ipaddress) values(?,?,?,?)",array($bank_reference,$payment_amount,$this->common->getDate(),$this->common->getRealIpAddr()));
			                    if($checkduplicate == true)
			                    {
			                    	//echo $cr_user_id."  |  ".$dr_user_id."  |  ".$order_amount."  |  ".$txtRemark."  |  ".$description."  |  ".$payment_type;exit;
			                    	$ewrslt = $this->Ew2->tblewallet_Payment_CrDrPG($cr_user_id,$dr_user_id,$payment_amount,$txtRemark,$description,$payment_type);

			                    	$txtRemark = "Payment Getway Charge : ".$pg_charge;
									$description = "Payment Getway charge debit : ".$pg_charge;		                    	

			                    	$ewrslt_charge = $this->Ew2->tblewallet_Payment_CrDrPG(1,$cr_user_id,$pg_charge,$txtRemark,$description,$payment_type);	
			                    }	
					 		}
		                    echo "OK";exit;	
						}
						
					}
					
				}
			}
			
		}





 		echo "OK";exit;
	}
	public function index()
	{
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
		//secret= jTTGTjuC8GHhqNn1oAWGoNImIxuWPq5e
		$php_response = file_get_contents('php://input');
 		$response = json_encode($this->input->get());
 		$post_response = json_encode($this->input->get());
 		$this->logentry($response);
 		$this->logentry($post_response);

 		$this->logentry("php input :: ".$php_response);


 		 // $php_response = '{"entity":"event","account_id":"acc_FvQQcgb9k1IBAB","event":"order.paid","contains":["payment","order"],"payload":{"payment":{"entity":{"id":"pay_JM0HgLU6MEu28a","entity":"payment","amount":100,"currency":"INR","status":"captured","order_id":"order_JM0HZQ7hzawure","invoice_id":null,"international":false,"method":"upi","amount_refunded":0,"refund_status":null,"captured":true,"description":"Pay with RazorPay","card_id":null,"bank":null,"wallet":null,"vpa":"shubhamchoudhary20.svc@okhdfcbank","email":"support@payin.co.in","contact":"+918080623623","notes":[],"fee":1,"tax":0,"error_code":null,"error_description":null,"error_source":null,"error_step":null,"error_reason":null,"acquirer_data":{"rrn":"211157388266"},"created_at":1650543531}},"order":{"entity":{"id":"order_JM0HZQ7hzawure","entity":"order","amount":100,"amount_paid":100,"amount_due":0,"currency":"INR","receipt":"WeB4e57eRozerpay","offer_id":null,"status":"paid","attempts":1,"notes":[],"created_at":1650543524}}},"created_at":1650543549}';



 		$json_obj = json_decode($php_response);
		
		if(isset($json_obj->entity))	
		{
			$entity = $json_obj->entity;
			

			$this->logentry("setp 1");
			$account_id = $json_obj->account_id;
			$event = $json_obj->event;


			if($event == "order.paid" or $event == "payment.captured" )
			{

			}
			else
			{
				echo "";exit;
			}
			
			if(isset($json_obj->payload))
			{
				$this->logentry("setp 2");
				$payload = $json_obj->payload;	
				
				if(isset($payload->payment))
				{
					$this->logentry("setp 3");
					$payment = $payload->payment;	
					if(isset($payment->entity))
					{
						$paymententity = $payment->entity;

						$payment_id = $this->checknull($paymententity->id);
						$payment_entity = $this->checknull($paymententity->entity);
						$payment_amount = $this->checknull($paymententity->amount);
						$payment_currency = $this->checknull($paymententity->currency);
						$payment_status = $this->checknull($paymententity->status);
						$payment_order_id = $this->checknull($paymententity->order_id);
						$payment_invoice_id = $this->checknull($paymententity->invoice_id);
						$payment_international = $this->checknull($paymententity->international);
						$payment_method = $this->checknull($paymententity->method);
						$payment_amount_refunded = $this->checknull($paymententity->amount_refunded);
						$payment_refund_status = $this->checknull($paymententity->refund_status);
						$payment_captured = $this->checknull($paymententity->captured);
						$payment_description = $this->checknull($paymententity->description);
						$payment_card_id = $this->checknull($paymententity->card_id);
						$payment_bank = $this->checknull($paymententity->bank);
						$payment_wallet = $this->checknull($paymententity->wallet);
						$payment_vpa = $this->checknull($paymententity->vpa);
						$payment_email = $this->checknull($paymententity->email);
						$payment_contact = $this->checknull($paymententity->contact);
						$payment_fee = $this->checknull($paymententity->fee);



						$card_name = "";
						$card_last4 = "";
						$card_network = "";
						$card_type = "";
						$card_issuer = "";
						$card_international = "";
						$card_emi = "";
						$card_sub_type = "";
						if(isset($paymententity->card))
						{
							$card_obj  = $paymententity->card;
							$card_name = $card_obj->name;
							$card_last4 = $card_obj->last4;
							$card_network = $card_obj->network;
							$card_type = $card_obj->type;
							$card_issuer = $card_obj->issuer;
							$card_international = $card_obj->international;
							$card_emi = $card_obj->emi;
							$card_sub_type = $card_obj->sub_type;

							if($card_type == "debit")
							{
								$payment_method = "debit_card";
							}
							if($card_type == "credit")
							{
								$payment_method = "credit_card";
							}
							if($card_type == "prepaid")
							{
								$payment_method = "prepaid_card";
							}
							if($card_network ==  "American Express")
							{
								$payment_method = "AMEX";
							}
						}


						$payment_tax = $this->checknull($paymententity->tax);
						$payment_error_code = $this->checknull($paymententity->error_code);
						$payment_error_description = $this->checknull($paymententity->error_description);
						$payment_error_source = $this->checknull($paymententity->error_source);
						$payment_error_step = $this->checknull($paymententity->error_step);
						$payment_error_reason = $this->checknull($paymententity->error_reason);
						$payment_acquirer_data = $paymententity->acquirer_data;

						$rrn = "";
						if(isset($payment_acquirer_data->rrn))
						{
							$rrn = $this->checknull($payment_acquirer_data->rrn);
						}

						$this->logentry("setp 4");

						$payment_created_at = $paymententity->created_at;


					}
				}


				$order_id = false;
				$order_entity = "";
				$order_amount = "";
				$order_amount_paid = "";
				$order_currency = "";
				$order_receipt = "";
				$order_offer_id = "";
				$order_status = "";
				$order_attempts = "";
				$order_created_at = "";
				if(isset($payload->order))
				{
					$this->logentry("setp 5");
					$order = $payload->order;	
					if(isset($order->entity))
					{
						$this->logentry("setp 6");
						$orderentity = $order->entity;

						$order_id = $this->checknull($orderentity->id);
						$order_entity = $this->checknull($orderentity->entity);
						$order_amount = $this->checknull($orderentity->amount);
						$order_amount_paid = $this->checknull($orderentity->amount_paid);
						$order_currency = $this->checknull($orderentity->currency);
						$order_receipt = $this->checknull($orderentity->receipt);
						$order_offer_id = $this->checknull($orderentity->offer_id);
						$order_status = $this->checknull($orderentity->status);
						$order_attempts = $this->checknull($orderentity->attempts);
						$order_created_at = $this->checknull($orderentity->created_at);
						

					}
				}

			//	echo $order_id;exit;
				$user_id = 0;

				if($order_id != false)
				{
					$orderInfo = $this->db->query("select * from tbl_razorpay_order where resp_id = ?",array($order_id));
					if($orderInfo->num_rows() == 1)
					{
						$user_id = $orderInfo->row(0)->user_id;
					}	
				}
				else
				{
					$orderInfo = $this->db->query("select * from tbl_razorpay where razorpay_payment_id = ?",array($payment_id));
					if($orderInfo->num_rows() == 1)
					{
						$user_id = $orderInfo->row(0)->user_id;
					}
				}
				
				$this->logentry("setp 7");
				//echo $user_id;exit;
				$add_date = $this->common->getDate();
				$ipaddress = $this->common->getRealIpAddr();

				$payment_amount  = ($payment_amount / 100);


				$this->logentry("setp 8");
				$insertdata = $this->db->query("insert INTO razorpay_callback(add_date, ipaddress, entity, account_id, event, payment_id, payment_entity, payment_amount, payment_currency, payment_status, payment_order_id, payment_invoice_id, payment_international, payment_method, payment_amount_refunded, payment_refund_status, payment_captured, payment_description, payment_card_id, payment_bank, payment_wallet, payment_vpa, payment_email, payment_contact, payment_fee, payment_tax, payment_error_code, payment_error_description, payment_error_source, payment_error_step, payment_error_reason, rrn, payment_created_at, order_id, order_entity, order_amount, order_amount_paid, order_currency, order_receipt, order_offer_id, order_status, order_attempts, order_created_at, user_id) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($add_date, $ipaddress, $entity, $account_id, $event, $payment_id, $payment_entity, $payment_amount, $payment_currency, $payment_status, $payment_order_id, $payment_invoice_id, $payment_international, $payment_method, $payment_amount_refunded, $payment_refund_status, $payment_captured, $payment_description, $payment_card_id, $payment_bank, $payment_wallet, $payment_vpa, $payment_email, $payment_contact, $payment_fee, $payment_tax, $payment_error_code, $payment_error_description, $payment_error_source, $payment_error_step, $payment_error_reason, $rrn, $payment_created_at, $order_id, $order_entity, $order_amount, $order_amount_paid, $order_currency, $order_receipt, $order_offer_id, $order_status, $order_attempts, $order_created_at, $user_id));
				if($insertdata == true)
				{
					$this->logentry("setp 9");
					$insert_id = $this->db->insert_id();
					if($event == "order.paid" or $event == "payment.captured" )
					{
						if(( $order_status == "paid" or $payment_status == "captured") and $user_id > 1)
						{
							if(true)
					 		{
					 			$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
								$cr_user_id = $user_id;
			                    $dr_user_id = 1;
			                    $bank_reference = "";
			                    $description = "By PG ".$payment_method."";
			                    $payment_type = $payment_method;
			                   
			                    $group_id = $userinfo->row(0)->scheme_id;
			                    $pg_charge = $this->getPgCharge($group_id,$payment_method,$payment_amount);


			                    $txtRemark = "By PG ".$payment_method." REF:".$bank_reference;

			                  // $checkduplicate = $this->db->query("insert into cashfree_rrn_locking(rrn,amount,add_date,ipaddress) values(?,?,?,?)",array($payment_id,$payment_amount,$this->common->getDate(),$this->common->getRealIpAddr()));
			                    //if($checkduplicate == true)
			                    if(true)
			                    {
			                    	//echo $cr_user_id."  |  ".$dr_user_id."  |  ".$order_amount."  |  ".$txtRemark."  |  ".$description."  |  ".$payment_type;exit;
			                    	$ewrslt = $this->Ew2->tblewallet_Payment_CrDrPG($cr_user_id,$dr_user_id,$payment_amount,$txtRemark,$description,$payment_type);

			                    	$txtRemark = "Payment Getway Charge : ".$pg_charge;
									$description = "Payment Getway charge debit : ".$pg_charge;		                    	

			                    	$ewrslt_charge = $this->Ew2->tblewallet_Payment_CrDrPG(1,$cr_user_id,$pg_charge,$txtRemark,$description,$payment_type);	
			                    }	
					 		}
		                    echo "OK";exit;	
						}
						
					}
					
				}
			}
			
		}





 		echo "OK";exit;
	}
	public function getPgCharge($group_id,$payment_group,$amount)
	{
		$rslt = $this->db->query("SELECT * FROM `pg_charge` where group_id = ? and payment_group = ?",array($group_id,$payment_group));
		if($rslt->num_rows() >= 1)
		{
			return (($rslt->row(0)->charge * $amount)/100);
		}
		else
		{
			return ((4 * $amount)/100);
		}
		return 10;
	}	
}
