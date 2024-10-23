<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_settings extends CI_Controller {
	
	
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
				$from_date = $this->input->post("txtFrom",TRUE);
				$to_date = $this->input->post("txtTo",TRUE);
				$ddldb = $this->input->post("ddldb",TRUE);
				$ddlpaymenttype = $this->input->post("ddlpaymenttype",TRUE);
				//echo $ddlpaymenttype;exit;
				$user_id = 1;
				$this->view_data['pagination'] = NULL;
				
				$this->view_data['result_mdealer'] = $this->AccountLedger_getReport(1,$from_date,$to_date,$ddlpaymenttype,$ddldb);
				$this->view_data['message'] =$this->msg;
				
			
				
				$this->view_data['totalcredit'] =$this->gettotalcredit($user_id,$from_date,$to_date,$ddldb);
				$this->view_data['totaldebit'] =$this->gettotaldebit($user_id,$from_date,$to_date,$ddldb);
				$this->view_data['from_date']  = $from_date;
				$this->view_data['to_date']  = $to_date;
				$this->view_data['ddldb']  = $ddldb;
				$this->view_data['ddlpaymenttype']  = $ddlpaymenttype;
				$this->load->view('_Admin/account_report_view',$this->view_data);		
			}					
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$from_date = $to_date  = $this->common->getMySqlDate();
					$this->view_data['pagination'] = NULL;
					$this->view_data['result_mdealer'] = $this->AccountLedger_getReport(1,$from_date,$to_date,"ALL","LIVE");
					$this->view_data['message'] =$this->msg;
					$rsltcredit = $this->db->query("select IFNULL(Sum(credit_amount),0) as total from tblewallet where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array(1,$from_date,$to_date));
					$rsltdebit = $this->db->query("select IFNULL(Sum(debit_amount),0) as total from tblewallet where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ? ",array(1,$from_date,$to_date));
					$this->view_data['totalcredit'] =$rsltcredit->row(0)->total;
					$this->view_data['totaldebit'] =$rsltdebit->row(0)->total;
					$this->view_data['from_date']  = $from_date;
					$this->view_data['to_date']  = $to_date;
					$this->view_data['ddldb']  = "LIVE";
					$this->view_data['ddlpaymenttype']  = "ALL";
					$this->load->view('_Admin/site_settings_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
}