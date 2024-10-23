<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ParserAdd extends CI_Controller {
	
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
		
		$start_row = $this->uri->segment(3);
		$per_page = $this->common_value->getPerPage();
		if(trim($start_row) == ""){$start_row = 0;}
		$result = $this->db->query("select count(Id) as total from tblresponseparser");
		$total_row = $result->row(0)->total;		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/ParserAdd/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_group'] = $this->db->query("select a.* from tblresponseparser a   order by a.parser_name limit ?,?",array($start_row,$per_page));
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/ParserAdd_view',$this->view_data);		
	}
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('ausertype') != "Admin") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			$data['message']='';		
			
			if($this->input->post("HIDACTION") == "INSERT")
			{
				$GroupName = $this->input->post("txtGroupName",TRUE);
			    $add_date = $this->common->getDate();
				$check = $this->db->query("select * from tblresponseparser where parser_name = ?",array($GroupName));
			
				if($check->num_rows() < 1)
				{
					$this->db->query("insert into tblresponseparser(parser_name,add_date,ipaddress ) values(?,?,?)",array($GroupName,$add_date,$this->common->getRealIpAddr()));
				}
				
				
				
				$this->pageview();
			}
			else if($this->input->post("HIDACTION") == "UPDATE")
			{
				$hidPrimaryId = $this->input->post("hidPrimaryId",TRUE);
				$GroupName = $this->input->post("txtGroupName",TRUE);
				
				$txtMinBal = 0;
				$add_date = $this->common->getDate();
				$check = $this->db->query("select * from tblresponseparser where Id = ? ",array($hidPrimaryId));
				if($check->num_rows() == 1)
				{
					$this->db->query("update tblresponseparser set parser_name = ? where Id = ? ",array($GroupName,$hidPrimaryId));
				}
				$this->pageview();
			}
			else if($this->input->post("HIDACTION") == "DELETE")
			{
			    $hidPrimaryId = $this->input->post("hidPrimaryId",TRUE);
				$GroupName = $this->input->post("txtGroupName",TRUE);
			
				$txtMinBal = 0;
				$add_date = $this->common->getDate();
				$check = $this->db->query("select * from tblresponseparser where Id = ? ",array($hidPrimaryId));
				if($check->num_rows() == 1)
				{
					$this->db->query("delete from tblresponseparser where Id = ?",array($hidPrimaryId));
				}
				
				
				
				$this->pageview();
			}
			else
			{
				
				$this->pageview();
			}
		} 
	}	

}