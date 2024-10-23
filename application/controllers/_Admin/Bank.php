<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank extends CI_Controller {
	
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		$this->load->model('Bank_model');
		
		$this->view_data['pagination'] = NULL;
		$this->view_data['result_bank'] = $this->Bank_model->get_bank();
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/bank_view',$this->view_data);		
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
				$bankName = $this->input->post("txtBank",TRUE);
				$this->load->model('Bank_model');
				if($this->Bank_model->add($bankName) == true)
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
				$BankID = $this->input->post("hidID",TRUE);
				$BankName = $this->input->post("txtBank",TRUE);
				$this->load->model('Bank_model');
				if($this->Bank_model->update($BankID,$BankName) == true)
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
				$this->load->model('Bank_model');
				if($this->Bank_model->delete($bankID) == true)
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