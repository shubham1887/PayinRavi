<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cashfree_redirect extends CI_Controller {
	public function logentry($data)
	{

		$filename = "inlogs/cashfree_callback.txt";
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

		exit;
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
		 $post_response = json_encode($this->input->post());
		 $this->logentry($post_response);

		// $response = '{"orderId":"ORDER10","orderAmount":"5.00","referenceId":"784034544","txStatus":"SUCCESS","paymentMode":"UPI","txMsg":"00::Transaction is Successful","txTime":"2022-02-25 19:22:29","signature":"xgJYQZIbq0un1hNb+NpCuL8xoUjNJV1AjWk9BYaDlGM="}';

		 //$_POST = (array)json_decode($response);
		 $secretkey = "51491cf0cf26081fdf422052d674204708f5fbaf";
		 $orderId = $_POST["orderId"];
		 $orderAmount = $_POST["orderAmount"];
		 $referenceId = $_POST["referenceId"];
		 $txStatus = $_POST["txStatus"];
		 $paymentMode = $_POST["paymentMode"];
		 $txMsg = $_POST["txMsg"];
		 $txTime = $_POST["txTime"];
		 $signature = $_POST["signature"];

		$data = $orderId.$orderAmount.$referenceId.$txStatus.$paymentMode.$txMsg.$txTime;


		 $hash_hmac = hash_hmac('sha256', $data, $secretkey, true) ;
		 $computedSignature = base64_encode($hash_hmac);
		 if ($signature == $computedSignature) 
		 {

		 	$orderId = str_replace("ORDER", "", $orderId);
		 	/*$orderinfo = $this->db->query("select * from cashfree_order where Id = ?",array($orderId));
		 	if($orderinfo->num_rows() == 1)
		 	{
		 		$user_id = $orderinfo->row(0)->user_id;
		 		$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
		 		$checkduplicate = $this->db->query("insert into cashfree_rrn_locking(rrn,amount,add_date,ipaddress) values(?,?,?,?)",array($referenceId,$orderAmount,$this->common->getDate(),$this->common->getRealIpAddr()));
			 	if($checkduplicate == true)
			 	//if(true)
			 	{
			 		$cr_user_id = $userinfo->row(0)->user_id;
				    $dr_user_id = 1;
					$description = "Admin To ".$userinfo->row(0)->businessname;
					$admin_remark = "";
					$is_revert = false;
					$payment_received = $orderAmount;
					$acc_parent_id = 1;
					$acc_child_id = $userinfo->row(0)->user_id;

					$amount = $orderAmount;
					$txtRemark = "PG : ".$paymentMode." | ".$referenceId." | ".$txMsg;
					$ddlpaymentType = $paymentMode;

					//$ewrslt = $this->Insert_model->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$amount,$txtRemark,$description,$ddlpaymentType,$admin_remark,$is_revert,$payment_received,$acc_parent_id,$acc_child_id);
			 	}
		 	}
		 	*/
		 	
		 }
		 else
		 {
		 	
		 }
		 	$this->view_data["orderId"] = $orderId;
		 	$this->view_data["orderAmount"] = $orderAmount;
		 	$this->view_data["referenceId"] = $referenceId;
		 	$this->view_data["txStatus"] = $txStatus;
		 	$this->view_data["paymentMode"] = $paymentMode;
		 	$this->view_data["txMsg"] = $txMsg;
		 	$this->view_data["txTime"] = $txTime;
		 	$this->view_data["signature"] = $signature;
		 	$this->view_data["data"] = $data;
		 	$this->view_data["hash_hmac"] = $hash_hmac;
		 	$this->view_data["computedSignature"] = $computedSignature;

		 	$this->load->view("Retailer/Cashfree_redirect_view",$this->view_data);
		
	}	
}
