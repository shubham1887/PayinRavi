<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {
	
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		
		
		$this->view_data['pagination'] = NULL;
		$this->view_data['result_common'] = $this->db->query("select * from common where param = 'maxrecamount'");
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/settings_view',$this->view_data);		
	}

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
			if($this->input->post("btnSubmit") == "Submit")
			{
				$txtMaxRecAmount = $this->input->post("txtMaxRecAmount");
				$this->db->query("update common set  value = ? where param = 'maxrecamount'",array($txtMaxRecAmount));
				$this->pageview();
			}
			
			
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																					
			}
		}
	}	
}