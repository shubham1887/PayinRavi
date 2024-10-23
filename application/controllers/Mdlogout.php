<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdlogout extends CI_Controller {
	
	public function index()
	{ 
		if($this->session->userdata('MdUserType') == "MasterDealer")
		{
			$this->session->unset_userdata('MdId');
			$this->session->unset_userdata('MdParentId');		
			$this->session->unset_userdata('MdLoggedIn');
			$this->session->unset_userdata('MdBusinessName');
			$this->session->unset_userdata('MdFirstTimeLogin');
			$this->session->unset_userdata('MdSchemeId');
			$this->session->unset_userdata('MdIsAPI');
			$this->session->unset_userdata('Redirect');
			$this->session->unset_userdata('MdUserType');		
			$data['message']='';
			redirect("login");
		}
	}	
}
