<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listapiclosing extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{ 
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		$start_row = $this->uri->segment(3);
		$per_page = $this->common_value->getPerPage();
		if(trim($start_row) == ""){$start_row = 0;}
	
		$result_count = $this->db->query("select count(Id) as total from tblapiclosingbalance");
		$total_row = $result_count->row(0)->total;		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/listapiclosing/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['rslt'] =  $this->db->query("select * from tblapiclosingbalance order by Id desc limit ?,?",array($start_row,$per_page));
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/listapiclosing_view',$this->view_data);		
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
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
					$this->pageview();
				}
				else
				{redirect(base_url().'login');}																								
		} 
	}
	
}