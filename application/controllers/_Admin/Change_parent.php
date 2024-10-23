<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_parent extends CI_Controller {
	
	
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
        $this->load->model("Users_model");
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
                $this->view_data["userdata"] = $this->getUserForAutocompleteTextBox();			    
			    $this->view_data['message']  = "ALL";
				$this->load->view('_Admin/Change_parent_view',$this->view_data);	
																								
			}
		} 
	}
	private function getUserForAutocompleteTextBox()
	{
	   // error_reporting(-1);
	   // ini_set('display_errors',1);
	   // $this->db->db_debug = TRUE;
	    //if(isset($_POST["inputdata"]))
	    //{
	        $users = '';
	        //$inputdata = trim($this->input->post("inputdata"));
	        //$inputdata = '%'.$inputdata.'%';
	        $rsltusers = $this->db->query("select businessname,mobile_no,usertype_name,balance from tblusers where usertype_name != 'Admin' order by businessname");
	        foreach($rsltusers->result() as $rwuser)
	        {
	            $users.=str_replace(",","",$rwuser->businessname)." - ".$rwuser->mobile_no." - ".$rwuser->usertype_name." - ₹".$rwuser->balance."@@";
	        }
	        return $users;
	    //}
	}
}