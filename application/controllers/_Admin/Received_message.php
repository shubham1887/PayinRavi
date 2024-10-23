<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Received_message extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{
		
		$fromdate = $this->session->userdata("FromDate");
		$todate = $this->session->userdata("ToDate");
		
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		$start_row = intval($this->uri->segment(4));
		$per_page =25;
		if(trim($start_row) == ""){$start_row = 0;}
		$this->load->model('List_recharge_model');
		$rslt_all = $this->db->query("select Id,user_id from longcode,tblusers where Date(longcode.add_date) = ? and tblusers.mobile_no  = longcode.number",array($fromdate));
	//	print_r($rslt_all->result());exit;
		$result =  $rslt_all;
		$total_row = $result->num_rows();		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/received_message/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['numrows'] =$total_row; 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$rslt  =  $this->db->query("select longcode.*,user_id,username,businessname from longcode,tblusers where Date(longcode.add_date) >= ? and Date(longcode.add_date) <= ? and tblusers.mobile_no = longcode.number order by Id desc limit ?,?",array($fromdate,$todate,$start_row,$per_page));
		//print_r($rslt->result());exit;
		$this->view_data['result_messages'] =$rslt;
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/received_message_view',$this->view_data);			
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
			if($this->input->post('btnSearch'))
			{
				$txtFrom = $this->input->post('txtFromDate',true);
				$txtFrom = $this->input->post('txtToDate',true);
				$txtId = $this->input->post("txtId",TRUE);
				$this->view_data['pagination'] =NULL;
				if($txtId == '' or $txtId == NULL)
				{
					$this->view_data['result_messages'] = $this->db->query("select longcode.*,businessname,username,user_id from longcode,tblusers where tblusers.mobile_no = longcode.number and Date(longcode.add_date)  >= ?  and Date(longcode.add_date) <= ? order by Id desc",array($txtFrom,$txtTo));
				}
				else
				{
					$this->view_data['result_messages'] = $this->db->query("select longcode.*,businessname,username,user_id from longcode,tblusers where tblusers.mobile_no = longcode.number and Date(longcode.add_date)  >= ?  and Date(longcode.add_date) <= ? and tblusers.username = ? order by Id desc",array($txtFrom,$txtFrom,$txtId));
				}
				
				$this->view_data['message'] =$this->msg;
				$this->load->view('_Admin/received_message_view',$this->view_data);								
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
					$todaydate = $this->common->getMySqlDate();
				$this->session->set_userdata("FromDate",$todaydate);
				$this->session->set_userdata("ToDate",$todaydate);
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	
	
}