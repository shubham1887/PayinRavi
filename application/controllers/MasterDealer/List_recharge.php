<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_recharge extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{
	
		$fromdate = $this->session->userdata("FromDate");
		$todate = $this->session->userdata("ToDate");
		$user_id = $this->session->userdata('MdId');
		if ($this->session->userdata('MdLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		$start_row = $this->uri->segment(4);
		$per_page =50;
		if(trim($start_row) == ""){$start_row = 0;}
		$this->load->model('List_recharge_model');
		
			
		$result = $this->db->query("select count(a.recharge_id) as total 
		from tblrecharge a 
		left join tblusers b on a.user_id = b.user_id
		left join tblusers dist on b.parentid = dist.user_id 
		left join tblusers md on dist.parentid = md.user_id 
		where 
		Date(a.add_date) >= ? and Date(a.add_date) <= ? and
		md.user_id = ?
		
		",array($fromdate,$todate,$user_id));
		
		$total_row = $result->row(0)->total;		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."MasterDealer/list_recharge/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['numrows'] =$total_row; 
		$this->view_data['pagination'] = $this->pagination->create_links();
		
		
			
	    $result2 = $this->db->query("
	    select 
    	    a.recharge_id,
    	    a.mobile_no,a.company_id,a.amount,a.add_date,a.recharge_status,a.recharge_by,a.operator_id,
    	    b.businessname,
    	    b.username,
    	    b.usertye_name,
    	    c.company_name
		from tblrecharge a 
		left join tblusers b on a.user_id = b.user_id
		left join tblcompany c on a.company_id = c.company_id
		left join tblusers dist on b.parentid = dist.user_id 
		left join tblusers md on dist.parentid = md.user_id 
		where 
		Date(a.add_date) >= ? and Date(a.add_date) <= ? and
		md.user_id = ?
		
		",array($fromdate,$todate,$user_id));
		$this->view_data['result_recharge'] = $result2;
		
		
		
		
		$this->view_data['totalRecahrge'] ="";
		$this->view_data['totalpRecahrge'] ="";
		$this->view_data['totalfRecahrge'] ="";
		
		$this->view_data['message'] =$this->msg;
		$this->load->view('MasterDealer/list_recharge_view',$this->view_data);	
	
	}
	
	public function index() 
	{
	
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 
            error_reporting(E_ALL);
            ini_set("display_errors",1);

		if ($this->session->userdata('MdLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			if($this->input->post('btnSearch'))
			{
				$Fromdate = $this->input->post('txtFromDate',true);
				$Todate = $this->input->post('txtToDate',true);
				$this->session->set_userdata("FromDate",$Fromdate);
				$this->session->set_userdata("ToDate",$Todate);
				$this->pageview();
				/*$this->load->model('List_recharge_model');
				$this->view_data['pagination'] = NULL;
				$this->view_data['result_recharge'] = $this->List_recharge_model->get_recharge_bydate($Fromdate,$Todate);
				$this->view_data['message'] =$this->msg;
				$this->load->view('list_recharge_view',$this->view_data);	*/							
			}
			else
			{
				if ($this->session->userdata('MdLoggedIn') != TRUE) 
				{ 
					redirect(base_url().'login'); 
				}		
				else
				{
					$todaydate = $this->common->getMySqlDate();
					$this->session->set_userdata("FromDate",$todaydate);
					$this->session->set_userdata("ToDate",$todaydate);
					$this->pageview();
				}
				
					
				
			}
		} 
	}	
	
	
}