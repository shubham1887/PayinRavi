<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_commission extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{
	    error_reporting(-1);
	    ini_set('display_errors',1);
	    $this->db->db_debug = TRUE;
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		$this->load->model("Company_model");
		$this->view_data['pagination'] = NULL;
		$this->view_data['result_admin_comm'] = $this->Company_model->getAdminCommissionView();
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/admin_commission_view',$this->view_data);		
	}
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('ausertype') != "Admin") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			$data['message']='';				
			if($this->input->post("btnSubmit") == "Submit")
			{
				$txtApi1Comm = $this->input->post("txtApi1Comm",TRUE);
				$txtApi2Comm = $this->input->post("txtApi2Comm",TRUE);
				$txtApi3Comm = $this->input->post("txtApi3Comm",TRUE);
				$Company_id = $this->input->post("ddlcompany",TRUE);
				$rslt = $this->db->query("update tblcompany set api1_comm = ?, api2_comm = ?, api3_comm = ? where company_id = ?",array($txtApi1Comm,$txtApi2Comm,$txtApi3Comm,$Company_id));
				$this->msg ="Commission Add Successfully.";
				$this->pageview();
			}
			else if( $this->input->post("hidValue") && $this->input->post("action") ) 
			{				
				$apiID = $this->input->post("hidValue",TRUE);
				$this->load->model('Api_model');
				if($this->Api_model->delete($apiID) == true)
				{
					$this->msg ="Api Delete Successfully.";
					$this->pageview();
				}
				else
				{
					
				}				
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