<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Language_model extends CI_Model{
	function __construct()
	{
			parent::__construct();
	}
	public function set_lang($lang=""){
		$this->eng_lang();
	}
	private function eng_lang(){
		define("MIS_PARA","There are some missing parameter.");
		define("WRONG_LOGIN_METHOD","Wrong method.");
		define("SUCCESS_LOGIN","Welcome to MasterPay.");
		define("FAIL_TOKEN","Login token error.");
		define("ANOTHER_TOKEN","Someone else trying to login from another device.");
		define("LOGIN_OTP","We have sent you otp on your registered mobile.");
		define("INACTIVE_LOGIN","Your account is deactivated, contact your Administrator.");
		define("WRONG_UPASS","Invalid UserId or Password.");
		define("WRONG_USER_MOBILE","We have not any user registered with this mobile no.");
		define("WRONG_MOBILE_LENGTH","Please enter valid mobile number.");
		define("WRONG_WHATSAPP_LENGTH","Please enter valid whatsapp number.");
		define("WRONG_PINCODE_LENGTH","Please enter valid pincode.");
		define("PASSWORD_SENT_MOBILE","We have sent you Password on Your Registered Mobile Number.");
		define("WRONG_OTP","Invalid OTP.");
		define("FORGOT_OTP_SUCCESS","Please enter new password.");
		define("WRONG_INPUT","There are some wrong input.");
		define("PASSWORD_CHANGE_SUCCESS","Your password has been changed successfully.");
		define("COMMON_SUCCESS_MSG","Thank you. We have received your request, our sales team will contact you soon.");
		define("COMMON_ERROR_MSG","There are some error!");
		define("TECH_ERROR_MSG","There are some technical error!");
		define("INVALID_AMOUNT","Please enter valid amount.");
		define("INVALID_TPIN","Please enter valid Tpin.");
		define("UNAUTH_ERROR","You are not authorized user.");
		define("CONTACT_SPROVIDER","Please contact your service provider.");
		define("RECHARGE_SUBMIT","Recharge Request Submitted Successfully.");
		define("PAYMENT_SUCESSFULLY","Payment successfully.");
		define("INSUFFICIANT_BALANCE","You don't have Sufficient balance!");
		define("PIN_CHANGED","Your Tpin has been changed successfully.");
		define("INVALID_PASS","Please enter valid old password.");
		define("PASS_CHANGED","Your password has been changed successfully.");
		define("PARENTID_DONE","Parent ID updated successfully.");
		define("WRONG_USER","There is no user registered with given username!");
		define("WRONG_DATE","Please enter valid date.");
		define("WRONG_EMAIL","Please enter valid email.");
		define("WRONG_COMPANY","Please select valid operator.");
		define("PROFILE_UPDATE","Your profile has been updated successfully.");
	}
}