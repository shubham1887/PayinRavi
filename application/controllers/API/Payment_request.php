<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_request extends CI_Controller {
	
	
	private $msg='';
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('ApiUserType') != "APIUSER") 
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
				$user_id =$this->session->userdata("ApiId");		
				$ddlwallettype = $this->input->post("ddlwallettype",TRUE);					
				$add_date = $this->common->getDate();
				$ipaddress = $this->common->getRealIpAddr();
				$rsltpayreq = $this->db->query("select * from tblautopayreq where user_id = ? and amount = ?  and status = 'Pending' ",array($user_id,$txtAmount));
				if($rsltpayreq->num_rows() > 0)
				{
					echo "Payment Request Already Exist Of This Amount , Try Different Amount";exit;	
				}
				else
				{
					$this->db->query("insert into tblautopayreq(user_id,amount,payment_type,transaction_id,status,add_date,ipaddress,remark,wallet_type) values(?,?,?,?,?,?,?,?,?) ",array($user_id,$txtAmount,$ddlpaymenttype,$txtTid,'Pending',$add_date,$ipaddress,$txtRemarks,$ddlwallettype));
					
					//$msg = $this->session->userdata("ApiBusinessName").' request for '.$txtAmount.' transfer in '.$ddlpaymenttype.'  with ref.branch '.$txtTid;
					//9137732050
					//$this->load->model("Sms");
					//$userinfo = $this->db->query("select * from tblusers where user_id = 1");
					//$this->Sms->ExecuteSMSApi($userinfo,$msg);
						echo "Your Request Submit Successfully";exit;
				}
				
				
			}			
			else
			{
				$user=$this->session->userdata('ApiUserType');
				if(trim($user) == 'APIUSER')
				{
					$this->view_data['message'] =$this->msg;
					$this->load->view('API/payment_request_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
	
}