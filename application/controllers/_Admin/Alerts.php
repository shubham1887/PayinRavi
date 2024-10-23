<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alerts extends CI_Controller {
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
			$data['message']='';				
			if($this->input->post("btnSubmit"))
			{
				$Alerts =htmlentities($this->input->post("editor1"));
				$this->load->model('Alerts_model');
				if($this->Alerts_model->set($Alerts) == true)
				{
					$data['message'] = "Alerts Set Successfully.";				
					$this->load->view('_Admin/alerts_view',$data);
				}
				else
				{
					
				}
			}
			else
			{				
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$this->load->view('_Admin/alerts_view',$data);
				}
				else
				{redirect(base_url().'login');}					
				}
		} 
	}	
}