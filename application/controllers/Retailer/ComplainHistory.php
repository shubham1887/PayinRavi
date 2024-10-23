<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ComplainHistory extends CI_Controller {
	
	
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
    public function gethoursbetweentwodates($fromdate,$todate)
	{
		 $now_date = strtotime (date ($todate)); // the current date 
		$key_date = strtotime (date ($fromdate));
		$diff = $now_date - $key_date;
		return round(abs($diff) / 60,2);
	}
	public function pageview()
	{
		$word = "";
		$user_id = $this->session->userdata("AgentId");
		
	
		$ddldb  = $this->session->userdata("ddldb");
		$fromdate = $this->session->userdata("FromDate");
	    $todate = $this->session->userdata("ToDate");    
		
		
		//echo $fromdate."   ".$todate."   ".$ddlwallet."   ".$ddldb;exit;
		
		$start_row = $this->uri->segment(4);
	//	echo $start_row;exit;
		$per_page =50;
		if(trim($start_row) == ""){$start_row = 0;}
		
		$total_row = $this->AccountLedger_getReport_rows($user_id,$fromdate,$todate,$ddldb);
		$this->load->library('pagination');
		$config['base_url'] = base_url()."Retailer/ComplainHistory/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		
		
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['from'] =$fromdate;
		$this->view_data['to'] =$todate;
		$this->view_data['ddldb'] =$ddldb;
	
		
		$rows = $this->AccountLedger_getReport($user_id,$fromdate,$todate,$ddldb,$start_row,$per_page);
		
		$this->view_data['result_all'] = $rows;
		$this->view_data['message'] =$this->msg;
		$this->load->view('Retailer/ComplainHistory_view',$this->view_data);			
	}
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			if(isset($_POST["Fromdate"]) and isset($_POST["Todate"]))
			{
			
				$from = date_format(date_create($this->input->post('Fromdate',true)),'Y-m-d');
				$to = date_format(date_create($this->input->post('Todate',true)),'Y-m-d');
			
    			$this->view_data['result_all'] = $this->db->query("select * from tblcomplain where user_id = ? and Date(complain_date) BETWEEN ? and ?",array($this->session->userdata("AgentId"),$from,$to));
			    	//print_r($this->view_data['result_all']->num_rows());exit;
					$this->view_data['message'] =$this->msg;
					$this->view_data['from'] =$this->input->post('Fromdate',true);
					$this->view_data['to'] =$this->input->post('Todate',true);
					$this->load->view('Retailer/ComplainHistory_view',$this->view_data);
			}					
			
			else
			{
				$user=$this->session->userdata('AgentUserType');
				if(trim($user) == 'Agent')
				{
					
					$today_date = $this->common->getMySqlDate();
				
			    	$this->view_data['result_all'] = $this->db->query("select * from tblcomplain where user_id = ? and Date(complain_date) = ?",array($this->session->userdata("AgentId"),$today_date));
			    	//print_r($this->view_data['result_all']->num_rows());exit;
					$this->view_data['message'] =$this->msg;
					$this->view_data['from'] =date_format(date_create($today_date),'m/d/Y');
					$this->view_data['to'] =date_format(date_create($today_date),'m/d/Y');;
					$this->load->view('Retailer/ComplainHistory_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}
}