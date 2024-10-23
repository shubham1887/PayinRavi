<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sent_sms extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		$start_row = intval($this->uri->segment(4));
		$per_page = $this->common_value->getPerPage();
		if(trim($start_row) == ""){$start_row = 0;}
		
		$date = $this->common->getMySqlDate();
		
		$result = $this->db->query("select count(Id)as total from tblsentsms where Date(add_date) = ?",array($date));
		
		$total_row = $result->row(0)->total;		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/sent_sms/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_sms'] = $this->db->query("select a.*,b.businessname,b.username,b.user_id from tblsentsms a
			left join tblusers b on a.toNumber = b.mobile_no where   Date(a.add_date) = ? order by a.Id desc limit ?,?",array($date,$start_row,$per_page));
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/sent_sms_view',$this->view_data);		
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
				$txtId = $this->input->post("txtId",TRUE);
				$this->view_data['pagination'] =NULL;
				if($txtId == '' or $txtId == NULL)
				{
					$this->view_data['result_sms'] = $this->db->query("select a.*,b.businessname,b.username,b.user_id from tblsentsms a
						left join tblusers b on a.toNumber = b.mobile_no
			 where Date(a.add_date)  BETWEEN ?  and ? order by a.Id desc",array($txtFrom,$txtTo));
				}
				else
				{
					$this->view_data['result_sms'] = $this->db->query("select a.*,b.businessname,b.username,b.user_id from tblsentsms a
						left join tblusers b on a.toNumber = b.mobile_no
						where Date(a.add_date)  BETWEEN ?  and ? and b.username = ? order by a.Id desc",array($txtFrom,$txtTo,$txtId));
				}
				
				$this->view_data['message'] =$this->msg;
				$this->load->view('_Admin/sent_sms_view',$this->view_data);		
				
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
	
}