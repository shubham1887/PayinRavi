<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_bank_details extends CI_Controller {
	
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		$start_row = $this->uri->segment(3);
		$per_page = $this->common_value->getPerPage();
		$user_id = $this->session->userdata('id');
		if(trim($start_row) == ""){$start_row = 0;}
		$this->load->model('Admin_bank_details_model');
		$result = $this->Admin_bank_details_model->get_bank($user_id);
		$total_row = $result->num_rows();		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."admin_bank_details/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_bank'] = $this->Admin_bank_details_model->get_bank_limited($start_row,$per_page,$user_id);
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/admin_bank_details_view',$this->view_data);		
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
				$bank_id = $this->input->post("ddlBank",TRUE);
				$ifsc_code = $this->input->post("txtIfscCode",TRUE);
				$account_number = $this->input->post("txtAccountNo",TRUE);
				$branch_name = $this->input->post("txtBranchName",TRUE);
				$user_id = $this->session->userdata('id');
				$this->load->model('Insert_model');
				if($this->Insert_model->tbluser_bank_Entry($bank_id,$ifsc_code,$account_number,$branch_name,$user_id) == true)
				{
					$this->msg ="Bank Name Add Successfully.";
					$this->pageview();
				}
				else
				{
					
				}
			}
			else if($this->input->post("btnSubmit") == "Update")
			{				
				$user_bank_id = $this->input->post("hidID",TRUE);
				$bankId = $this->input->post("ddlBank",TRUE);
				$ifsc = $this->input->post("txtIfscCode",TRUE);
				$accountno = $this->input->post("txtAccountNo",TRUE);
				$branch = $this->input->post("txtBranchName",TRUE);
				$user_id = $this->session->userdata('id');				
				$this->load->model('Admin_bank_details_model');
				if($this->Admin_bank_details_model->update($bankId,$ifsc,$accountno,$branch,$user_bank_id,$user_id) == true)
				{
					$this->msg ="Bank Name Update Successfully.";
					$this->pageview();
				}
				else
				{
					
				}				
			}
			else if( $this->input->post("hidValue") && $this->input->post("action") ) 
			{
				
				$bankID = $this->input->post("hidValue",TRUE);
				$this->load->model('Admin_bank_details_model');
				if($this->Admin_bank_details_model->delete($bankID) == true)
				{
					$this->msg ="Bank Name Delete Successfully.";
					$this->pageview();
				}
				else
				{
					
				}				
			}			
			else
			{
				//$user=$this->session->userdata('ausertype');
				//if(trim($user) == 'Admin')
				//{
				$this->pageview();
				//}
				//else
				//{redirect(base_url().'login');}																					
			}
		}
	}	
}