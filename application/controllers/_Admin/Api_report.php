<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_report extends CI_Controller {		
	private $msg='';	
	public function pageview()
	{
			$from = $this->session->userdata('from_date');
			$to = $this->session->userdata('to_date');
			$api = $this->session->userdata('ddlAPI');
//			$this->load->model('Api_report_model');
//			$this->view_data['result_api'] = $this->Api_report_model->get_recharge($from,$to,$api);
//			$this->view_data['message'] =$this->msg;
//			$this->load->view('api_report_view',$this->view_data);								
			
			
		$start_row = $this->uri->segment(4);
		$per_page = 4000;
		if(trim($start_row) == ""){$start_row = 0;}
		$this->load->model('Api_report_model');
		$result = $this->Api_report_model->get_recharge($from,$to,$api);
		$total_row = $result->num_rows();		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/api_report/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_api'] = $this->Api_report_model->get_recharge_limited($from,$to,$api,$start_row,$per_page);
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/api_report_view',$this->view_data);		
	}
	public function index() 
	{
		
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}		
		
		if($this->input->post("btnSubmit"))
		{
			$from = $this->input->post('txtFromDate',true);
			$to = $this->input->post('txtToDate',true);
			$api = $this->input->post('ddlapi',true);
//			$this->load->model('Api_report_model');
//			$this->view_data['result_api'] = $this->Api_report_model->get_recharge($from,$to,$api);
//			$this->view_data['message'] =$this->msg;
//			$this->load->view('api_report_view',$this->view_data);								
		$this->session->set_userdata('from_date', $this->input->post('txtFromDate'));
		$this->session->set_userdata('to_date', $this->input->post('txtToDate'));
		$this->session->set_userdata('ddlAPI', $this->input->post('ddlapi'));
			
			
		$start_row = $this->uri->segment(3);
		$per_page = 4000;
		if(trim($start_row) == ""){$start_row = 0;}
		$this->load->model('Api_report_model');
		$result = $this->Api_report_model->get_recharge($from,$to,$api);
		$total_row = $result->num_rows();		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."api_report/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_api'] = $this->Api_report_model->get_recharge_limited($from,$to,$api,$start_row,$per_page);
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/api_report_view',$this->view_data);		
			
			
		}
		else 
		{ 						
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{										
					$this->view_data['message']='';
					$this->load->view('_Admin/api_report_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																								
		} 
	}	
}