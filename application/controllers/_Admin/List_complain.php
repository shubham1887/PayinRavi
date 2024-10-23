<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_complain extends CI_Controller {
	
	
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
		
		$result = $this->db->query("select complain_id from tblcomplain where complain_status != 'Pending'");
		
		$total_row = $result->num_rows();		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/list_complain/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_complain'] = $this->db->query("
		select 
		    a.*,
		    b.businessname,b.username,b.usertype_name 
		    from tblcomplain a
		    left join tblusers b on a.user_id = b.user_id
		    where a.complain_status != 'Pending'
		     order by a.complain_id desc limit ?,?",array($start_row,$per_page));
		$this->view_data['message'] =$this->msg;
		$this->view_data['from'] = "";
		$this->view_data['to'] = "";
		$this->load->view('_Admin/list_complain_view',$this->view_data);		
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
			if($this->input->post('SewarchBox'))
			{
			
				$SearchWord = $this->input->post("SewarchBox");
				$this->load->model("List_complain_model");
				$rslt = 
				$str_query = "select 
				a.*,b.businessname,b.username,b.usertype_name 
				from tblcomplain a 
				left join tblusers b on a.user_id = b.user_id 
				where  
				(a.complain_id=? or a.recharge_id=? or a.complain_date=? or b.businessname = ? or b.usertype_name = ? or a.complain_status = ? or b.username = ?) 
				and  a.complain_status != 'Pending'
				order by a.complain_date";
		        $rslt = $this->db->query($str_query,array($SearchWord,$SearchWord,$SearchWord,$SearchWord,$SearchWord,$SearchWord,$SearchWord));
				
				$this->view_data['pagination'] = NULL;
				$this->view_data['result_complain'] = $rslt;
				$this->view_data['message'] =$this->msg;
				$this->view_data['from'] = "";
				$this->view_data['to'] = "";
				$this->load->view('_Admin/list_complain_view',$this->view_data);
			}
			else if($this->input->post('btnSearch') == "Search")
			{
				$txtFrom = $this->input->post("txtFrom",TRUE);
				$txtTo = $this->input->post("txtTo",TRUE);
			error_reporting(-1);
			ini_set('dislay_errors',1);
			$this->db->db_debug = TRUE;
				 
				$str_query = "select 
				a.*,b.businessname,b.username,b.usertype_name 
				from tblcomplain a 
				left join tblusers b on a.user_id = b.user_id 
				where  
			    date(a.complain_date) between ? and ? 
				and  a.complain_status != 'Pending'
				order by a.complain_date";
		        $rslt = $this->db->query($str_query,array($txtFrom,$txtTo));
				
				$this->view_data['pagination'] = NULL;
				$this->view_data['from'] = $txtFrom;
				$this->view_data['to'] = $txtTo;
				$this->view_data['result_complain'] = $rslt;
				$this->view_data['message'] =$this->msg;
				$this->load->view('_Admin/list_complain_view',$this->view_data);					
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
	public function searchComplain()
	{
		
	}
}