<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payment_request extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('FOSUserType') != "FOS") 
		{ 
			redirect(base_url().'login'); 
		}
		$start_row = $this->uri->segment(3);
		$per_page = $this->common_value->getPerPage();
		if(trim($start_row) == ""){$start_row = 0;}
		$this->load->model('Payment_request_model');
		$result = $this->Payment_request_model->get_payment_request($this->session->userdata('FOSId'));
		$total_row = $result->num_rows();		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."FOS/payment_request/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_payment'] = $this->Payment_request_model->get_payment_request_limited($start_row,$per_page,$this->session->userdata('FOSId'));
		$this->view_data['message'] =$this->msg;
		$this->load->view('FOS/payment_request_view',$this->view_data);		
	}
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('FOSUserType') != "FOS") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 
		{ 
		
			$data['message']='';				
			if($this->input->post("btnSubmit") == 'Submit')
			{								
				$ddlpaymenttype = $this->input->post("ddlpaymenttype",TRUE);
				$txtAmount = $this->input->post("txtAmount",TRUE);
				$txtTid = $this->input->post("txtTid",TRUE);
				$txtRemarks = $this->input->post("txtRemarks",TRUE);
				$user_id =$this->session->userdata("FOSId");								
				$add_date = $this->common->getDate();
				$ipaddress = $this->common->getRealIpAddr();
				$rsltpayreq = $this->db->query("select * from tblautopayreq where user_id = ? and amount = ?  and status = 'Pending' ",array($user_id,$txtAmount));
				if($rsltpayreq->num_rows() > 0)
				{
					echo "Payment Request Already Exist Of This Amount , Try Different Amount";exit;	
				}
				else
				{
					$this->db->query("insert into tblautopayreq(user_id,amount,payment_type,transaction_id,client_remark,status,add_date,ipaddress) values(?,?,?,?,?,?,?,?) ",array($user_id,$txtAmount,$ddlpaymenttype,$txtTid,$txtRemarks,'Pending',$add_date,$ipaddress));
					$msg = $this->session->userdata("FOSBusinessName").' request for '.$txtAmount.' transfer in '.$ddlpaymenttype.'  with ref.branch '.$txtTid;
					//9137732050
					$this->load->model("Sms");
					$userinfo = $this->db->query("select * from tblusers where user_id = 1");
					$this->Sms->ExecuteSMSApi($userinfo->row(0)->mobile_no,$msg);
				echo "Your Request Submit Successfully";exit;
					
				}
				
				
			}			
			else
			{
				$user=$this->session->userdata('FOSUserType');
				if(trim($user) == 'FOS')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
	
}