<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank_ifsc extends CI_Controller {
	
	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
		if ($this->session->userdata('ausertype') != "Admin") 
		{ 
			redirect(base_url().'login'); 
		} 
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		//$start_row = $this->uri->segment(3);
		//$per_page = $this->common_value->getPerPage();
		//if(trim($start_row) == ""){$start_row = 0;}
		//$result = $this->db->query("select count(Id) as total from tbldefaultifsc");
		//$total_row = $result->row(0)->total;		
		//$this->load->library('pagination');
		//$config['base_url'] = base_url()."_Admin/bank_ifsc/pageview";
		//$config['total_rows'] = $total_row;
		//$config['per_page'] = $per_page; 
		//$this->pagination->initialize($config); 
		$this->view_data['pagination'] =""; //$this->pagination->create_links();
		$this->view_data['result_group'] = $this->db->query("select * from tbldefaultifsc order by bank_name ");
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/bank_ifsc_view',$this->view_data);		
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
			$data['message']='';		
			
			if($this->input->post("btnSubmit") == "Submit")
			{
				$BankName = $this->input->post("txtBankName",TRUE);
				$IFSC = $this->input->post("txtIFSC",TRUE);
				$add_date = $this->common->getDate();
				$check = $this->db->query("select * from tbldefaultifsc where bank_name = ?",array($BankName));
				if($check->num_rows() < 1)
				{
					$this->db->query("insert into tbldefaultifsc(bank_name,IFSC,add_date ) values(?,?,?)",array($BankName,$IFSC,$add_date));
				}
				
				
				
				$this->pageview();
			}
			else if($this->input->post("btnSubmit") == "Update")
			{
				
				$BankName = $this->input->post("txtBankName",TRUE);
				$IFSC = $this->input->post("txtIFSC",TRUE);
				$hidID = $this->input->post("hidID",TRUE);
				$add_date = $this->common->getDate();
				$check = $this->db->query("select * from tbldefaultifsc where Id = ?",array($IFSC));
				
				if($check->num_rows() == 1)
				{
					$this->db->query("update tbldefaultifsc set bank_name = ?,IFSC = ? where Id = ?",array($BankName,$IFSC,$this->common->getDate(),$hidID));
				}
				
				
				
				$this->pageview();
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
}