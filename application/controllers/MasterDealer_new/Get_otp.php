<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_otp extends CI_Controller {
	
	

	public function index() 
	{
		if($this->session->userdata("MdUserType") == "MasterDealer")
		{
			echo "OTP : ".$this->Userinfo_methods->getOTP($this->session->userdata("MdId"));
		}	
		else
		{
			redirect(base_url());
		}
	}	
}