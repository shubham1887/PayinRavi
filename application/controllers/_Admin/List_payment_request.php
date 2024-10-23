<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class List_payment_request extends CI_Controller {

	

	

	private $msg='';

	public function pageview()

	{

		$start_row = $this->uri->segment(4);

		$per_page = $this->common_value->getPerPage();

		if(trim($start_row) == ""){$start_row = 0;}

		$this->load->model('List_payment_request_model');

		$result = $this->List_payment_request_model->get_payment_request();

		$total_row = $result->num_rows();		

		$this->load->library('pagination');

		$config['base_url'] = base_url()."_Admin/list_payment_request/pageview";

		$config['total_rows'] = $total_row;

		$config['per_page'] = $per_page; 

		$this->pagination->initialize($config); 

		$this->view_data['pagination'] = $this->pagination->create_links();

		$this->view_data['result_payment'] = $this->List_payment_request_model->get_payment_request_limited($start_row,$per_page);

		$this->view_data['message'] =$this->msg;

		$this->load->view('_Admin/list_payment_request_view',$this->view_data);		

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

			if($this->input->post("hidAction") == "Perform")

			{					

				$user_id = $this->input->post("hidUserID",TRUE);

				$status = $this->input->post("hidStatus",TRUE);	

				$id = $this->input->post("hidID",TRUE);					

				$Amount = $this->input->post("hidAmount",TRUE);					

				$BankCharge = $this->input->post("hidBankCharge",TRUE);									

				$Remark = $this->input->post("hidRemark",TRUE);					

				$bank_id = $this->input->post("hidBankID",TRUE);

				$remark_details = $this->input->post("hidRemark_details",TRUE);

				

				$this->load->model('List_payment_request_model');

				if($this->List_payment_request_model->updateStatus($user_id,$status,$id,$Amount,$BankCharge,$Remark,$bank_id,$remark_details) == true)

				{

					$this->session->set_flashdata('message', 'Your Action Submit Successfully.');

					redirect(base_url()."_Admin/list_payment_request");

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