<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payment_request extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('DistUserType') != "Distributor") 
		{ 
			redirect(base_url().'login'); 
		}
		$start_row = $this->uri->segment(3);
		$per_page = $this->common_value->getPerPage();
		if(trim($start_row) == ""){$start_row = 0;}
		$this->load->model('Payment_request_model');
		$result = $this->Payment_request_model->get_payment_request($this->session->userdata('DistId'));
		$total_row = $result->num_rows();		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."Distributor/payment_request/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_payment'] = $this->Payment_request_model->get_payment_request_limited($start_row,$per_page,$this->session->userdata('DistId'));
		$this->view_data['message'] =$this->msg;
		$this->load->view('Distributor/payment_request_view',$this->view_data);		
	}
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('DistUserType') != "Distributor") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 
		{ 
		
			$data['message']='';				
			if($this->input->post("btnSubmit") == 'Submit')
			{		
				//print_r($this->input->post());exit;
				$ddlpaymenttype = $this->input->post("ddlpaymenttype",TRUE);
				$txtAmount = $this->input->post("txtAmount",TRUE);
				$txtTid = $this->input->post("txtTid",TRUE);
				$txtRemarks = $this->input->post("txtRemarks",TRUE);
				$user_id =$this->session->userdata("DistId");								
				$add_date = $this->common->getDate();
				$ipaddress = $this->common->getRealIpAddr();
				$rsltpayreq = $this->db->query("select * from tblautopayreq where user_id = ? and amount = ?  and status = 'Pending' ",array($user_id,$txtAmount));
				if($rsltpayreq->num_rows() > 0)
				{
					$this->session->set_flashdata("message","Payment Request Already Exist Of This Amount , Try Different Amount") ;
					redirect(base_url()."Distributor/payment_request?crypt=".$this->Common_methods->encrypt("MyData"));
				}
				else
				{
					if($ddlpaymenttype == "SBI_CASH" or $ddlpaymenttype == "ICICI_CASH" or $ddlpaymenttype == "AXIS_CASH" or $ddlpaymenttype == "UNION_BANK_CASH")
					{
						if(isset($_FILES["file"])) 
						{
							if ($_FILES["file"]["error"] > 0) 
							{
								$this->session->set_flashdata("message","Please Upload Cash Receipt") ;
								redirect(base_url()."Distributor/payment_request?crypt=".$this->Common_methods->encrypt("MyData"));
							}
							else 
							{

								if (file_exists($_FILES["file"]["name"])) 
								{
									unlink($_FILES["file"]["name"]);
								}
								if (!file_exists("uploads/".$this->common->getMySqlDate())) 
								{
									mkdir("uploads/".$this->common->getMySqlDate());
								}
								$storagename = "uploads/".$this->common->getMySqlDate()."/".$_FILES["file"]["name"];
								move_uploaded_file($_FILES["file"]["tmp_name"],  $storagename);
								$uploadedStatus = 1;
								
								$this->db->query("insert into tblautopayreq(user_id,amount,payment_type,transaction_id,client_remark,status,add_date,ipaddress,image_url) values(?,?,?,?,?,?,?,?,?) ",array($user_id,$txtAmount,$ddlpaymenttype,$txtTid,$txtRemarks,'Pending',$add_date,$ipaddress,$storagename));
								$this->session->set_flashdata("message","Your Request Submit Successfully") ;
								redirect(base_url()."Distributor/payment_request?crypt=".$this->Common_methods->encrypt("MyData"));

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							}

						} 
						else
						{
							$this->session->set_flashdata("message","Please Upload Cash Receipt") ;
							redirect(base_url()."Distributor/payment_request?crypt=".$this->Common_methods->encrypt("MyData"));
						}
					}
					else
					{
						$this->db->query("insert into tblautopayreq(user_id,amount,payment_type,transaction_id,client_remark,status,add_date,ipaddress) values(?,?,?,?,?,?,?,?) ",array($user_id,$txtAmount,$ddlpaymenttype,$txtTid,$txtRemarks,'Pending',$add_date,$ipaddress));
						$this->session->set_flashdata("message","Your Request Submit Successfully") ;
						redirect(base_url()."Distributor/payment_request?crypt=".$this->Common_methods->encrypt("MyData"));
						
					}
					
				}
				
				
			}			
			else
			{
				$user=$this->session->userdata('DistUserType');
				if(trim($user) == 'Distributor')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
	
}