<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cashfree_callback extends CI_Controller {
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

		$filename = "inlogs/cashfree_callback2.txt";
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
	public function index()
	{
		/*
orderId=ORDER20&
orderAmount=2.00&
referenceId=784160049&
txStatus=SUCCESS&paymentMode=UPI&txMsg=00%3A%3ATransaction+is+Successful&txTime=2022-02-25+20%3A15%3A35&signature=2nBaTuIrJOLraAd1tNxy6Sf0SmfkH2OWNJhQ6%2FqQSMM%3D


php input :: {"data":{"order":{"order_id":"ORDER20","order_amount":2.00,"order_currency":"INR","order_tags":null},"payment":{"cf_payment_id":784160049,"payment_status":"SUCCESS","payment_amount":2.00,"payment_currency":"INR","payment_message":"00::Transaction is Successful","payment_time":"2022-02-25T20:15:35+05:30","bank_reference":"205655446639","auth_id":null,"payment_method":{"upi":{"channel":null,"upi_id":"8238232303@ybl"}},"payment_group":"upi"},"customer_details":{"customer_name":"Office+account","customer_id":null,"customer_email":"pavanchoudhary72.vc@gmail.com","customer_phone":"9699623623"}},"event_time":"2022-02-25T20:16:21+05:30","type":"PAYMENT_SUCCESS_WEBHOOK"}
		*/

		//secret= 1565151351154651njndf
		$php_response = file_get_contents('php://input');
 		$response = json_encode($this->input->get());
 		$post_response = json_encode($this->input->get());
 		$this->logentry($response);
 		$this->logentry($post_response);

 		$this->logentry("php input :: ".$php_response);

 		// error_reporting(-1);
 		// ini_set('display_errors',1);
 		// $this->db->db_debug = TRUE;

 		//$php_response = '{"data":{"order":{"order_id":"ORDER30","order_amount":1.00,"order_currency":"INR","order_tags":null},"payment":{"cf_payment_id":785408216,"payment_status":"SUCCESS","payment_amount":1.00,"payment_currency":"INR","payment_message":"00::Transaction is Successful","payment_time":"2022-02-26T12:55:40+05:30","bank_reference":"205707125465","auth_id":null,"payment_method":{"upi":{"channel":null,"upi_id":"tbadiyani@okicici"}},"payment_group":"upi"},"customer_details":{"customer_name":"Office+account","customer_id":null,"customer_email":"pavanchoudhary72.vc@gmail.com","customer_phone":"9699623623"}},"event_time":"2022-02-26T12:55:50+05:30","type":"PAYMENT_SUCCESS_WEBHOOK"}';

 		$json_obj = json_decode($php_response);
		
		if(isset($json_obj->data) and isset($json_obj->event_time) and isset($json_obj->type))	
		{
			$data = $json_obj->data;
			$event_time = $json_obj->event_time;
			$webhook_type = $json_obj->type;



			$order_id = "";
			$order_amount = "";
			$order_currency = "";
			$order_tags = "";


			$upi_id = "";
			$cf_payment_id = "";
			$payment_status = "";
			$payment_amount = "";
			$payment_currency = "";
			$payment_message = "";
			$payment_time = "";
			$bank_reference = "";
			$auth_id = "";
			$payment_method = "";
			$payment_group = "";

			$card_number = "";
			$card_network = "";
			$card_type = "";
			$card_country = "";
			$card_bank_name = "";

			$customer_name = "";
			$customer_id = "";
			$customer_email = "";
			$customer_phone = "";

			if(isset($data->order))
			{
				$order_detail = $data->order;
					$order_id = $order_detail->order_id;
					$order_amount = $order_detail->order_amount;
					$order_currency = $order_detail->order_currency;
					$order_tags = $this->checknull($order_detail->order_tags);



					$payment_detail = $data->payment;
					$cf_payment_id = $payment_detail->cf_payment_id;
					$payment_status = $payment_detail->payment_status;
					$payment_amount = $payment_detail->payment_amount;
					$payment_currency = $payment_detail->payment_currency;
					$payment_message = $payment_detail->payment_message;
					$payment_time = $payment_detail->payment_time;
					$bank_reference = $payment_detail->bank_reference;
					$auth_id = $this->checknull($payment_detail->auth_id);
					$payment_method = $payment_detail->payment_method;
					$payment_group = $payment_detail->payment_group;
					if($payment_group == "prepaid_card")
					{
						$card_detail = $payment_method->card;
							$card_number = $card_detail->card_number;
							$card_network = $card_detail->card_network;
							$card_type = $card_detail->card_type;
							$card_country = $card_detail->card_country;
							$card_bank_name = $card_detail->card_bank_name;

					}

					


				$customer_details_detail = $data->customer_details;
					$customer_name = $customer_details_detail->customer_name;
					$customer_id = $this->checknull($customer_details_detail->customer_id);
					$customer_email = $customer_details_detail->customer_email;
					$customer_phone = $customer_details_detail->customer_phone;
			}
			

			$add_date = $this->common->getDate();
			$ipaddress = $this->common->getRealIpAddr();
			$order_id = str_replace("ORDER", "", $order_id);




			$orderinfo = $this->db->query("select * from cashfree_order where Id = ?",array($order_id));
		 	if($orderinfo->num_rows() == 1)
		 	{
		 		$user_id = $orderinfo->row(0)->user_id;
		 		$rslt_insert = $this->db->query("insert into cashfree_callbackdata(add_date, ipaddress, user_id, event_time, webhook_type, order_id, order_amount, order_currency, order_tags, cf_payment_id, payment_status, payment_amount, payment_currency, payment_message, payment_time, bank_reference, auth_id, payment_method, payment_group,upi_id, card_number, card_network, card_type, card_country, card_bank_name, customer_name, customer_id, customer_email, customer_phone) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($add_date, $ipaddress, $user_id, $event_time, $webhook_type, $order_id, $order_amount, $order_currency, $order_tags, $cf_payment_id, $payment_status, $payment_amount, $payment_currency, $payment_message, $payment_time, $bank_reference, $auth_id, "", $payment_group,$upi_id, $card_number, $card_network, $card_type, $card_country, $card_bank_name, $customer_name, $customer_id, $customer_email, $customer_phone));

				if($rslt_insert == true)
				{
					$insert_id = $this->db->insert_id();
					if($webhook_type == "PAYMENT_SUCCESS_WEBHOOK" and $user_id > 1)
					{
						//if($this->common->getRealIpAddr() == "52.66.76.63")
						if(true)
				 		{
				 			$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
							$cr_user_id = $user_id;
		                    $dr_user_id = 1;
		                    $description = "By PG ".$payment_group." REF:".$bank_reference;
		                    $payment_type = $payment_group;
		                   
		                    $group_id = $userinfo->row(0)->scheme_id;
		                    $pg_charge = $this->getPgCharge($group_id,$payment_group,$order_amount);


		                    $txtRemark = "By PG ".$payment_group." REF:".$bank_reference;

		                   $checkduplicate = $this->db->query("insert into cashfree_rrn_locking(rrn,amount,add_date,ipaddress) values(?,?,?,?)",array($bank_reference,$order_amount,$this->common->getDate(),$this->common->getRealIpAddr()));
		                    if($checkduplicate == true)
		                    {
		                    	//echo $cr_user_id."  |  ".$dr_user_id."  |  ".$order_amount."  |  ".$txtRemark."  |  ".$description."  |  ".$payment_type;exit;
		                    	$ewrslt = $this->Ew2->tblewallet_Payment_CrDrPG($cr_user_id,$dr_user_id,$order_amount,$txtRemark,$description,$payment_type);

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
		return 0;
	}	
}
