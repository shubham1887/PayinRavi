<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Smsapi extends CI_Controller {

	

	

	

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
// 		error_reporting(-1);
// 		ini_set('display_errors',1);
// 		$this->db->db_debug = TRUE;
    }
    function clear_cache()
    {
        $this->load->model("Api_model");
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
	public function pageview()
	{
		$this->view_data['result_api'] = $this->db->query("select * from smsapi");
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/smsapi_view',$this->view_data);		
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
			
				$ApiName = $this->input->post("txtAPIName",TRUE);
				$UserName = str_replace(";","",$this->input->post("txtUserName",TRUE));
				$add_date = $this->common->getDate();
				$ip = $this->common->getRealIpAddr();
				$this->db->query("insert into smsapi(apiname,url,add_date,ipaddress) values(?,?,?,?)",array($ApiName,$UserName,$add_date,$ip));
					$this->msg ="Api Add Successfully.";
					$this->pageview();
				
			}
			else if($this->input->post("btnSubmit") == "Update")
			{				
			    
				$apiID = $this->input->post("hidID",TRUE);
				$ApiName = $this->input->post("txtAPIName",TRUE);
				$UserName = $this->input->post("txtUserName",TRUE);
				$this->db->query("update smsapi set apiname= ?,url=? where Id = ?",array($ApiName,$UserName,$apiID));
					$this->msg ="Api Update Successfully.";
					$this->pageview();
								
			}
			else if( $this->input->post("hidValue") && $this->input->post("action") ) 
			{				
				$apiID = $this->input->post("hidValue",TRUE);
				$this->db->query("delete from smsapi  where Id = ?",array($apiID));
					$this->msg ="Api Delete Successfully.";
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