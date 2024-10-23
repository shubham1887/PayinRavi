<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class site_admin extends CI_Controller {
	public function index()
	{	
$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			$user=$this->session->userdata('ausertype');
			if(trim($user) == 'Admin' or trim($user) == 'EMP')
			{
			$this->load->view('_Admin/super_admin_view');		 		
			}
			else
			{redirect(base_url().'login');}
		} 
	}
}
