<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller 
{
	 public function __construct()
    {        
        parent::__construct();
    } 
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */ 
	public function index()
	{
	
	   error_reporting(E_ALL);
ini_set('display_errors', 1);
	
	
		$userinfo = $this->db->query("select * from tblusers where user_id = 2");
		//print_r($userinfo->result());exit;
		$mobile_no = "8238232303";
		$name = "Ravikant";
		$lname = "Chavda";
		$address1 = "";
		$address2 = "";
		$pincode = 380001;
		$requset_id = 0;
		$pin = "409033";
		$bank = "";

		$this->load->model("Bankit");
		echo $this->Bankit->transfer_status("1093989");EXIT;



		//$this->load->model("Paytm");
		//echo $this->Paytm->verify_bene("8238232303","31360591069","SBIN0002661",$bank,$userinfo);EXIT;


		$this->load->model("Dezire");
		$resp = $this->Dezire->remitter_login($mobile_no,$pin,$userinfo);
		print_r($resp);exit;
		echo $this->Dezire->verify_bene("8238232303","0964000102016012","PUNB0096400",0,$userinfo);EXIT;


		$this->load->model("Bankit");
		//echo $this->Bankit->BankList();exit;
		$this->load->model("Bankit");
		$mobile_no = '8000012334';
		$name = "Nirmal";
		$lname = "Patel";
		//echo $this->Bankit->remitter_registration_auto($mobile_no,$name,$lname,$userinfo);exit;
		
		$mobile_no = "7016515852";
		$bene_name = "Keyur";
		$bene_mobile="7016515852";
		$acc_no = "34966017049";
		$ifsc="SBIN0001266";
		$bank= "91";
		//AES_21119129
		//echo $this->Bankit->add_benificiary($mobile_no,$bene_name,$bene_mobile,$acc_no,$ifsc,$bank,$userinfo);exit;
		//echo $this->Bankit->add_benificiary($mobile_no,$bene_name,$bene_mobile,$acc_no,$ifsc,$bank,$userinfo);exit;
		$beneficiary_array = $this->db->query("select * from beneficiaries where account_number = '34966017049' and IFSC = 'SBIN0001266' and sender_mobile = '7016515852' and is_bankit = 'yes'");
		$amount = 107;
		$mode = "NEFT";
		$order_id = "test101";
		//echo $this->Bankit->transfer($mobile_no,$beneficiary_array,$amount,$mode,$userinfo,$order_id);
		
		$acc_no = "0964000102016012";
		$ifsc = "PUNB0096400";
		$ver_resp = $this->Bankit->verify_bene($mobile_no,$acc_no,$ifsc,$userinfo);
		var_dump($ver_resp);
		
		exit;
		$mobile_no ="8866628967";
		$name = "keyur";$lname = "hudka";
		//echo $this->Bankit->remitter_registration_auto($mobile_no,$name,$lname,$userinfo);exit;
		$senderID = 314;
		
		
		exit;
	//	echo $this->Dezire->BankList();exit;
		//echo $this->Dezire->forgotpin($mobile_no);exit;
		$bene_name = "ravikant";
		$bene_mobile = "8238232303";
		$acc_no = "31360591069";
		$ifsc = "SBIN0002661";
		$bank = "";
		$bank_id = "";
		$pin = "966731";
		echo $this->Dezire->remitter_login($mobile_no,$pin,$userinfo);
		echo "<hr>";exit;
		echo $this->Dezire->add_benificiary($mobile_no,$senderID,$bene_name,$bene_mobile,$acc_no,$ifsc,$bank,$bank_id,$userinfo);exit;
		
		//echo $this->Dezire->getbenelist($mobile_no,$userinfo);exit;
		
		echo $this->Dezire->remitter_details($mobile_no,$senderID,$userinfo);exit;
		
		//echo $this->Dezire->remitter_registration($mobile_no,$name,$lname,$address1,$address2,$pincode,$requset_id,$otp,$userinfo);exit;
	
		$this->load->model("Paytm");
		//echo $this->Paytm->getBalance();exit;
		
		echo $this->Paytm->remitter_details_limit($mobile_no,$userinfo);exit;
		//echo $this->Eko->remitter_details($mobile_no,$userinfo);exit;
		$limit = 10;
		$offset = 0;
		$mobile_no = "8238232303";
		//echo $this->Paytm->getbenelist($mobile_no,$userinfo,$limit,$offset);
		echo $this->Paytm->remitter_registration_getotp($mobile_no,$userinfo);
	}
}
