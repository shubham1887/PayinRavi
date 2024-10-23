<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Distlogout extends CI_Controller {
	
	public function index()
	{ 
		if($this->session->userdata('DistUserType') == "Distributor")
		{
			$this->session->unset_userdata('DistId');
			$this->session->unset_userdata('DistParentId');		
			$this->session->unset_userdata('DistLoggedIn');
			$this->session->unset_userdata('DistBusinessName');
			$this->session->unset_userdata('DistFirstTimeLogin');
			$this->session->unset_userdata('DistSchemeId');
			$this->session->unset_userdata('DistIsAPI');
			$this->session->unset_userdata('Redirect');
			$this->session->unset_userdata('DistUserType');		
			$data['message']='';
			redirect(base_url()."login");	
		}
	}	
}
