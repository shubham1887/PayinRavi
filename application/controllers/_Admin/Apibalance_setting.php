<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apibalance_setting extends CI_Controller {
	
	
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
			$data['message']='';
		//	print_r($this->input->post());exit;
			if($this->input->post("btnSubmit") == "Submit")
			{
			    
				$ddlapi = $this->input->post("ddlapi",TRUE);
				$txtUrl = $this->input->post("txtUrl",TRUE);
				$txtStartWord = $this->input->post("txtStartWord",TRUE);				
				$txtEndWord = $this->input->post("txtEndWord",TRUE);				
			    $rsltcheck = $this->db->query("select * from r_api_getbalance_settings where api_id = ?",array($ddlapi));
			    if($rsltcheck->num_rows() == 0)
			    {
			        $this->db->query("insert into r_api_getbalance_settings(add_date,ipaddress,api_id,balance_url,balancebefore_text,balance_after_text) values(?,?,?,?,?,?)",array($this->common->getDate(),$this->common->getRealIpAddr(),$ddlapi,$txtUrl,$txtStartWord,$txtEndWord));
			    }
			    else
			    {
			        
			    }
			    redirect(base_url().'_Admin/apibalance_setting');
			}
		
			else if( $this->input->post("hidValue") && $this->input->post("action") ) 
			{				
				$apiID = $this->input->post("hidValue",TRUE);
			
			    $this->db->query("delete from r_api_getbalance_settings where Id = ?",array($apiID));
			     redirect(base_url().'_Admin/apibalance_setting');
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
					$this->view_data['pagination'] = "";
					$this->view_data['result_api'] = $this->db->query("select a.*,b.api_name from r_api_getbalance_settings a left join tblapi b on a.api_id = b.api_id order by b.api_name");
					$this->view_data['message'] =$this->msg;
					$this->load->view('_Admin/apibalance_setting_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
}