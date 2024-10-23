<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_document extends CI_Controller {
	
	
	private $msg='';
	
	public function index() 
	{
	
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('ApiUserType') != "APIUSER") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			
				$user=$this->session->userdata('ApiUserType');
				if(trim($user) == 'APIUSER')
				{
					$this->view_data["message"] = "";
					$this->load->view('API/api_document_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																								
			
		} 
	}	
	
}