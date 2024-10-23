<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {
	
	public function index()
	{ 
		if($this->session->userdata('ausertype') == "Admin")
		{
			$this->session->unset_userdata('adminid');
			$this->session->unset_userdata('aloggedin');		
			$this->session->unset_userdata('ausertype');
			$this->session->unset_userdata('abusinessname');
			$this->session->unset_userdata('ausername');
			$this->session->unset_userdata('Redirect');
			redirect(base_url()."login");
		}
	}	
}
