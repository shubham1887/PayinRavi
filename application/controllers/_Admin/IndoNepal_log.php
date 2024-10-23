<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class IndoNepal_log extends CI_Controller {
	
	
	private $msg='';
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
	public function pageview()
	{
		$word = "";
		$fromdate = $this->session->userdata("FromDate");
		$todate = $this->session->userdata("ToDate");
		$txtNumId = $this->session->userdata("txtNumId");
		
		$start_row = $this->uri->segment(4);
		$per_page =50;
		if(trim($start_row) == ""){$start_row = 0;}
		$strchecklike = '%'.$txtNumId.'%';
		$like1 = '%'.$txtNumId.'%';
		$countrslt = $this->db->query("
		select count(Id) as total 
		from indonepal_logs 
		where 
		Date(add_date) >= ? and 
		Date(add_date) <= ? and
		if(? != '',(request like ? or response like ?),true)
		",
		array($fromdate,$todate,$txtNumId,$like1,$like1));
		$total_row = $countrslt->row(0)->total;
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/IndoNepal_log/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->load->database();
        $this->db->reconnect();
		
		
		$this->view_data['txtNumId'] =$txtNumId; 
		$this->view_data['from'] =$fromdate; 
		$this->view_data['to'] =$todate; 
		
		
		$this->view_data['result_recharge'] = $this->db->query("
		select * from indonepal_logs 
		where 
		Date(add_date) >= ? and 
		Date(add_date) <= ? and
		if(? != '',(request like ? or response like ? or action_methods = ?),true)
		order by Id desc limit ?,?",array($fromdate,$todate,$txtNumId,$like1,$like1,$like1,intval($start_row),intval($per_page)));	
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/IndoNepal_log_view',$this->view_data);			
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
				
				$this->session->set_userdata("FromDate",$Fromdate);
				$this->session->set_userdata("ToDate",$Todate);
				$this->session->set_userdata("txtNumId",$txtNumId);
				
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
					
					$this->pageview();
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
}