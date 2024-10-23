<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_complain extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		$start_row = $this->uri->segment(3);
		$per_page = $this->common_value->getPerPage();
		if(trim($start_row) == ""){$start_row = 0;}
		$this->load->model('List_complain_model');
		$result = $this->List_complain_model->get_complain();
		
		$total_row = $result->num_rows();		
		echo $total_row;exit;
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/list_complain/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_complain'] = $this->List_complain_model->get_complain_limited($start_row,$per_page);
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/list_complain_view',$this->view_data);		
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
			if($this->input->post('SewarchBox'))
			{
			
				$SearchWord = $this->input->post("SewarchBox");
				$this->load->model("List_complain_model");
				$rslt = $this->List_complain_model->AjaxSearchComplain($SearchWord);
				$this->view_data['pagination'] = NULL;
				$this->view_data['result_complain'] = $rslt;
				$this->view_data['message'] =$this->msg;
				$this->load->view('_Admin/list_complain_view',$this->view_data);
			}
			else if($this->input->post('btnSearch') == "Search")
			{
				$txtFrom = $this->input->post("txtFrom",TRUE);
				$txtTo = $this->input->post("txtTo",TRUE);
				$this->load->model('List_complain_model');
				$result = $this->List_complain_model->Search($txtFrom,$txtTo);		
				$this->view_data['result_complain'] = $result;
				$this->view_data['message'] =$this->msg;
				$this->view_data['pagination'] = NULL;
				$this->load->view('_Admin/list_complain_view',$this->view_data);						
			}					
			else if($this->input->post('hidaction') == "Set")
			{								
				$status = $this->input->post("hidstatus",TRUE);
				$complain_id = $this->input->post("hidcomplainid",TRUE);
				$response_message = $this->input->post("hidresponse",TRUE);				
				$this->load->model('List_complain_model');
				$result = $this->List_complain_model->updateAction($status,$complain_id,$response_message);
				if($result == true)
				{
				if($status == 'Solved')
				{
				$user_id = $this->session->userdata('adminid');
				$user_info = $this->List_complain_model->GetUserInfoByComplain($complain_id);
				$this->load->library("common");				
/*$smsMessage = 
'Your Complaint ID - '.$complain_id.' is resolved.
Thank You.
www.allinrecharge.in';					
				$result_sms = $this->common->ExecuteSMSApi($this->common_value->getSMSUserName(),$this->common_value->getSMSPassword(),$user_info->row(0)->mobile_no,$smsMessage);*/
				}
					$this->msg="Action Submit Successfully.";
					$this->pageview();	
				}				
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$this->pageview();
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}
	public function searchComplain()
	{
		
	}
}