<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agentlogout extends CI_Controller {
	
	public function index()
	{ 
		if($this->session->userdata('SdUserType') == "MasterDealer")
		{
			$this->session->unset_userdata('SdId');
			$this->session->unset_userdata('AgentParentId');		
			$this->session->unset_userdata('AgentLoggedIn');
			$this->session->unset_userdata('AgentBusinessName');
			$this->session->unset_userdata('AgentFirstTimeLogin');
			$this->session->unset_userdata('AgentSchemeId');
			$this->session->unset_userdata('AgentIsAPI');
			$this->session->unset_userdata('Redirect');
			$this->session->unset_userdata('SdUserType');		
			$data['message']='';
			redirect(base_url()."login");	
		}
	}	
}
