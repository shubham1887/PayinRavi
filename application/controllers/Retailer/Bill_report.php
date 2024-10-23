<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bill_report extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
		}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login'); 
		} 			
		else if(isset($_POST['txtFrom']) and isset($_POST['txtTo']))
		{
			$from = $this->input->post('txtFrom',true);
			
			$fromf = date_format(date_create($from),'Y-m-d');
			//$fromf = date_format(date_create($from),'Y-m-d');
			
			
			$to = $this->input->post('txtTo',true);
			
			$tof = date_format(date_create($to),'Y-m-d');
			
			
		//	echo $fromf."   ".$tof;exit;
			
			$status = $this->input->post('ddlType',true);
			$user_id = $this->session->userdata('AgentId');			
		
			$this->view_data['result_all'] = $this->db->query("SELECT a.Id,a.user_id,a.add_date,a.service_no,a.customer_mobile,a.customer_name,a.dueamount,a.duedate,a.billnumber,a.billdate,a.billperiod,a.company_id,a.bill_amount,a.status,a.opr_id,a.charged_amt,a.resp_status,a.res_code,a.debit_amount,a.credit_amount,a.option1,b.company_name,c.businessname,c.username FROM `tblbills` a left join tblcompany b on a.company_id = b.company_id
left join tblusers c on a.user_id = c.user_id
where a.user_id = ? and Date(a.add_date) >= ? and Date(a.add_date) <= ? order by a.Id desc ",array($user_id,$fromf,$tof));
		


			//print_r($this->view_data['result_all']->result());exit;
			$this->view_data['message'] =$this->msg;
			$this->view_data['from'] =$from;
			$this->view_data['to'] =$to;
			$this->view_data['type'] =$status;
			$this->load->view('Retailer/bill_report_view',$this->view_data);								
		}
		else 
		{ 						
				$user=$this->session->userdata('AgentUserType');
				if(trim($user) == 'Agent')
				{										
					$from = date_format(date_create($this->common->getMySqlDate()),'m/d/Y');
					
					$fromf = date_format(date_create($from),'Y-m-d');
					$to = $from;
					$tof = $fromf;
					$status = "ALL";
					$user_id = $this->session->userdata('AgentId');			
					
					$this->view_data['result_all'] = $this->db->query("SELECT a.Id,a.user_id,a.add_date,a.service_no,a.customer_mobile,a.customer_name,a.dueamount,a.duedate,a.billnumber,a.billdate,a.billperiod,a.company_id,a.bill_amount,a.status,a.opr_id,a.charged_amt,a.resp_status,a.res_code,a.debit_amount,a.credit_amount,a.option1,b.company_name,c.businessname,c.username FROM `tblbills` a left join tblcompany b on a.company_id = b.company_id
left join tblusers c on a.user_id = c.user_id
where a.user_id = ? and Date(a.add_date) >= ? and Date(a.add_date) <= ? order by a.Id desc",array($user_id,$fromf,$tof));
					
					$this->view_data['message'] =$this->msg;
					$this->view_data['from'] =$from;
					$this->view_data['to'] =$to;
					$this->view_data['type'] =$status;
					$this->load->view('Retailer/bill_report_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																								
		} 
	}	
}