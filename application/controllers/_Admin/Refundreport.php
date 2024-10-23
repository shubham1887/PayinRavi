<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Refundreport extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{
		$word = "";
		$fromdate = $this->session->userdata("FromDate");
		$todate = $this->session->userdata("ToDate");
		$txtNumId = $this->session->userdata("txtNumId");
		$ddluser  = $this->session->userdata("ddluser");
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		$start_row = $this->uri->segment(4);
		$per_page =500;
		if(trim($start_row) == ""){$start_row = 0;}
		
		
		$total_row_result = $this->db->query("select count(a.Id) as total from tblewallet a left join tblrecharge b on a.recharge_id = b.recharge_id where a.transaction_type ='Recharge_Refund' and Date(a.add_date) = ? and if(? != 'ALL',a.user_id = ?,true) and if(? != '',b.mobile_no = ?,true)",array($fromdate,$ddluser,$ddluser,$txtNumId,$txtNumId));
		$total_row = $total_row_result->row(0)->total;
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/refundreport/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->load->database();
                $this->db->reconnect();
		
		
		$this->view_data['txtNumId'] =$txtNumId; 
		$this->view_data['from'] =$fromdate; 
		$this->view_data['to'] =$todate; 
		$this->view_data['ddluser'] =$ddluser; 
		$this->view_data['result_recharge'] = $this->db->query("select a.Id,a.transaction_type,a.user_id,a.credit_amount,a.debit_amount,a.balance,a.user_id,a.add_date,b.mobile_no,b.add_date as recharge_date,b.amount,b.company_id,b.recharge_status,b.recharge_id,b.transaction_id,b.operator_id,b.recharge_by,b.ExecuteBy,c.company_name,d.businessname from tblewallet a 
left join tblrecharge b on a.recharge_id = b.recharge_id 
join tblcompany c on b.company_id = c.company_id
join tblusers d on a.user_id = d.user_id

 where a.transaction_type ='Recharge_Refund' and Date(a.add_date) = ? and if(? != 'ALL',a.user_id = ?,true) and if(? != '',b.mobile_no = ?,true)",array($fromdate,$ddluser,$ddluser,$txtNumId,$txtNumId));
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/refundreport_view',$this->view_data);			
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
			if($this->input->post('btnSubmit'))
			{
			
				$Fromdate = $this->input->post('txtFromDate',true);
				$Todate = $this->input->post('txtToDate',true);
				$txtNumId = $this->input->post('txtNumId',true);
				$ddluser = $this->input->post('ddluser',true);
				$this->session->set_userdata("FromDate",$Fromdate);
				$this->session->set_userdata("ToDate",$Todate);
				$this->session->set_userdata("txtNumId",$txtNumId);
				$this->session->set_userdata("ddluser",$ddluser);
				$this->pageview();
									
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$todaydate = $this->common->getMySqlDate();
					$this->session->set_userdata("FromDate",$todaydate);
					$this->session->set_userdata("ToDate",$todaydate);
					$this->session->set_userdata("txtNumId","");
					$this->session->set_userdata("ddluser","ALL");
					$this->pageview();
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	
	
		
}