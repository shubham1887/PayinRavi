<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Razorpay_payout_test extends CI_Controller {
	public function __construct() {
		parent::__construct();		
		echo APPPATH.'third_party/razorpay_payout/Razorpay.php';
	}
	public function index()
	{
			$orderData = [
			    'receipt'         => 'rcptid_11',
			    'amount'          => 1, // 39900 rupees in paise
			    'currency'        => 'INR'
			];

			$razorpayOrder = $api->order->create($orderData);
			echo $razorpayOrder;exit;
	}	
}
