<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_bills extends CI_Controller {
	
	
	private $msg='';
	private function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		$start_row = intval($this->uri->segment(4));
		$per_page = $this->common_value->getPerPage();
		if(trim($start_row) == ""){$start_row = 0;}
		$this->load->model('List_complain_model');
		$result = $this->db->query("select Id from tblbillpay");
		
		$total_row = $result->num_rows();		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/list_bills/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_complain'] = $this->db->query("select tblbillpay.*,businessname,username,usertype_name from tblbillpay,tblusers where tblusers.user_id = tblbillpay.user_id order by Id desc limit ?,?",array($start_row,$per_page));
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/list_bills_view',$this->view_data);		
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
			if($this->input->post('btnSearch') == "Search")
			{
				$txtFrom = $this->input->post("txtFrom",TRUE);
				$txtTo = $this->input->post("txtTo",TRUE);
				
				$result =$this->db->query("select tblbillpay.*,businessname,username,usertype_name from tblbillpay,tblusers where tblusers.user_id = tblbillpay.user_id and Date(tblbillpay.add_date) >= ? and Date(tblbillpay.add_date) <= ? order by Id desc",array($txtFrom,$txtTo));		
				$this->view_data['result_complain'] = $result;
				$this->view_data['message'] =$this->msg;
				$this->view_data['pagination'] = NULL;
				$this->load->view('_Admin/list_bills_view',$this->view_data);						
			}					
			else if($this->input->post('hidaction') == "Set")
			{	
			//	print_r($this->input->post());exit;		
									
				$status = $this->input->post("hidstatus",TRUE);
				$Id = $this->input->post("hidid",TRUE);
				$response_message = $this->input->post("hidresponse",TRUE);		
						
				if($status == 'Solved')
				{
					
					$billinfo = $this->db->query("select * from tblbillpay where Id = ? and status = 'Pending' and debited = 'yes' and reverted = 'no'",array($Id));
					if($billinfo->num_rows() == 1)
					{
						$this->db->query("update tblbillpay set status = 'Success',admin_remark = ?,bilpaydate = ? where Id = ?",array($response_message,$this->common->getDate(),$Id));
						$this->msg="Action Submit Successfully.";
						$this->pageview();	
					}
					
				}
				else if($status == 'Unsolved')
				{
					$user_id = $this->session->userdata('adminid');
					$billinfo = $this->db->query("select * from tblbillpay where Id = ? and status = 'Pending' and debited = 'yes' and reverted = 'no'",array($Id));
					if($billinfo->num_rows() == 1)
					{
						
						$this->db->query("update tblbillpay set status = 'Failure',admin_remark = ?,bilpaydate = ? where Id = ?",array($response_message,$this->common->getDate(),$Id));
						$cr_amount =$billinfo->row(0)->amount + 10;
						$Description = "REVERT BILL PAYMENT :: ".$billinfo->row(0)->company_name." | ".$billinfo->row(0)->amount." | ".$billinfo->row(0)->cust_name." | BILL ID = ".$Id;
						$this->tblewallet_CrEntry($billinfo->row(0)->user_id,$Id,$cr_amount,$Description);
						$this->msg="Action Submit Successfully.";
						$this->pageview();	
					}
					
				}
				else
				{
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
	private function tblewallet_CrEntry($user_id,$billid,$cr_amount,$Description)
	{
		$transaction_type = "PAYMENT";
		$str_checkdebited = $this->db->query("select debited from tblbillpay where Id = ?",array($billid));
		if($str_checkdebited->row(0)->debited == "yes")
		{
			$this->load->library("common");
			$add_date = $this->common->getDate();
			$date = $this->common->getMySqlDate();
	
			$old_balance = $this->Common_methods->getCurrentBalance($user_id);
			$current_balance = $old_balance + $cr_amount;
			
			$str_query = "insert into  tblewallet(user_id,transaction_type,credit_amount,balance,description,add_date)
			values(?,?,?,?,?,?)";
			$reslut = $this->db->query($str_query,array($user_id,$transaction_type,$cr_amount,$current_balance,$Description,$add_date));
			$ewallet_id = $this->db->insert_id();
			$rslt_updtrec = $this->db->query("update tblbillpay set debited='no',reverted='yes', revertid = CONCAT_WS(',',revertid,?) where Id = ?",array($ewallet_id,$billid));
			return true;
		}
		
		return true;
	}
}