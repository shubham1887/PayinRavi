<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BankReport extends CI_Controller {
	
	
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
				error_reporting(-1);
				ini_set('display_errors',1);
				$this->db->db_debug = TRUE;
				$from = $this->input->post("txtFrom",TRUE);
				$to = $this->input->post("txtTo",TRUE);
				$ddlbank = $this->input->post("ddlbank",TRUE);
				$ddluser = $this->input->post("txtUser",TRUE);

				$this->view_data['result_bank'] = $this->db->query("
					SELECT * FROM `RoyalBank` 
					where 
					BankName = ? and 
					TxnDate BETWEEN ? and ? and
					if(? != '',(party_name1 = ? or party_name2 = ?),true)
					 ",array($ddlbank,$from,$to,$ddluser,$ddluser,$ddluser));
				$this->view_data['message'] =$this->msg;
				
			
				
				$this->view_data['totalcredit'] =0;//$this->gettotalcredit($user_id,$from_date,$to_date,$ddldb);
				$this->view_data['totaldebit'] =0;//$this->gettotaldebit($user_id,$from_date,$to_date,$ddldb);
				$this->view_data['from']  = $from;
				$this->view_data['to']  = $to;
				$this->view_data['ddlbank']  = $ddlbank;
				$this->view_data['ddluser']  = $ddluser;
				$this->load->view('_Admin/BankReport_view',$this->view_data);		
			}					
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$from = $to = $this->common->getMySqlDate();
					$this->view_data['from']  = $from;
					$this->view_data['to']  = $to;
					$this->view_data['ddldb']  = "LIVE";
					$this->view_data['txtUser']  = "";
					$this->load->view('_Admin/BankReport_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}
	public function setValues()
	{
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
		$Id = $this->input->post("Id");
		$value = $this->input->post("value");
		$field = $this->input->post("field");
		if($field == "PARTY2")
		{
			$this->db->query("update RoyalBank set party_name2 = ? where Id = ?",array($value,$Id));
			echo "DONE";exit;
		}
		if($field == "PARTY1")
		{
			$this->db->query("update RoyalBank set party_name1 = ? where Id = ?",array($value,$Id));
			echo "DONE";exit;
		}
		
	}
}