<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Razorpay_payout_test extends CI_Controller {
	public function __construct() 
	{
		parent::__construct();		
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
			include APPPATH . 'third_party/razorpay_payout/Razorpay.php';
		
		
	}
	public function index()
	{
	

require(APPPATH."third_party/razorpay_payout/src/Api.php");
$api = new Api($keyId, $keySecret);

			$orderData = array(
			    'receipt'=>'rcptid_11',
			    'amount'=>1, 
			    'currency'=>'INR'
			);

			$razorpayOrder = $api->order->create($orderData);
			echo "Order : ".$razorpayOrder;exit;
	}

}
