<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_contact extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{
		$this->load->model('List_contact_model');
		$result = $this->db->query("select * from tbl_enquiry order by Id desc");
		$this->view_data['result_contact'] = $result;
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/list_contact_view',$this->view_data);		
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