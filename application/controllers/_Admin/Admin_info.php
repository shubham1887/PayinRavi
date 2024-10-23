<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_info extends CI_Controller {
	
	
	
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
			
			if($this->input->post("btnSubmit") == "Submit")
			{
			    error_reporting(-1);
			    ini_set('display_errors',1);
			    $this->db->db_debug = TRUE;
				$txtCustomerCare = $this->input->post("txtCustomerCare",TRUE);
				$txtEmail = $this->input->post("txtEmail",TRUE);
				$txtOfficeAddress = $this->input->post("txtOfficeAddress",TRUE);
				$txtCompanyInfo = $this->input->post("txtCompanyInfo",TRUE);
				$txtMessage = $this->input->post("txtMessage",TRUE);
				
				
				$show_template = $this->input->post("chkshowtemplate",TRUE);
				$ddltemplate = (string)$this->input->post("ddltemplate",TRUE);
			
			    $txtMplanKey = (string)$this->input->post("txtMplanKey",TRUE);



			    $txtUPI_ID = (string)$this->input->post("txtUPI_ID",TRUE);
			    $txtUPI_PARTYNAME = (string)$this->input->post("txtUPI_PARTYNAME",TRUE);


			    $chkstop_success_recharge_reroot = (string)$this->input->post("chkstop_success_recharge_reroot",TRUE);


			    
				$this->db->query("update admininfo set value = ? where param = 'stop_success_recharge_reroot' and host_id = 1",array($chkstop_success_recharge_reroot));

				
				$this->db->query("update admininfo set value = ? where param = 'CustomerCare' and host_id = 1",array($txtCustomerCare));
				$this->db->query("update admininfo set value = ? where param = 'EmailId' and host_id = 1",array($txtEmail));
				$this->db->query("update admininfo set value = ? where param = 'OfficeAddress' and host_id = 1",array($txtOfficeAddress));
				$this->db->query("update admininfo set value = ? where param = 'CompanyInfo' and host_id = 1",array($txtCompanyInfo));
				$this->db->query("update admininfo set value = ? where param = 'Message' and host_id = 1",array($txtMessage));
				
				$this->db->query("update admininfo set value = ? where param = 'web_template_id' and host_id = 1",array($ddltemplate));
				$this->db->query("update admininfo set value = ? where param = 'show_template' and host_id = 1",array($show_template));
				$this->db->query("update admininfo set value = ? where param = 'MPLAN_KEY' and host_id = 1",array($txtMplanKey));


				$this->db->query("update admininfo set value = ? where param = 'UPI_ID' and host_id = 1",array($txtUPI_ID));
				$this->db->query("update admininfo set value = ? where param = 'UPI_PARTY_NAME' and host_id = 1",array($txtUPI_PARTYNAME));
				
				redirect(base_url()."_Admin/admin_info");
			}
		
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
    				$this->view_data['pagination'] = "";
            		$CustomerCare_rslt = $this->db->query("select value from admininfo where param = 'CustomerCare' and host_id = 1");
            		$EmailId_rslt = $this->db->query("select value from admininfo where param = 'EmailId' and host_id = 1");
            		$OfficeAddress_rslt = $this->db->query("select value from admininfo where param = 'OfficeAddress' and host_id = 1");
            		$CompanyInfo_rslt = $this->db->query("select value from admininfo where param = 'CompanyInfo' and host_id = 1");
            		$Message_rslt = $this->db->query("select value from admininfo where param = 'Message' and host_id = 1");
            		
            	    $show_template_rslt = $this->db->query("select value from admininfo where param = 'show_template' and host_id = 1");
            		$ddltemplate_rslt = $this->db->query("select value from admininfo where param = 'web_template_id' and host_id = 1");
            	    $MplanKeyRslt = $this->db->query("select value from admininfo where param = 'MPLAN_KEY' and host_id = 1");

            	    $UPI_IDRslt = $this->db->query("select value from admininfo where param = 'UPI_ID' and host_id = 1");
            	    $UPI_PARTYNAMERslt = $this->db->query("select value from admininfo where param = 'UPI_PARTY_NAME' and host_id = 1");

            	    $chkstop_success_recharge_rerootRslt = $this->db->query("select value from admininfo where param = 'stop_success_recharge_reroot' and host_id = 1");
            	    


            	   
				   
            		
            		$this->view_data["MplanKey"] = $MplanKeyRslt->row(0)->value;
            		$this->view_data["CustomerCare"] = $CustomerCare_rslt->row(0)->value;
            		$this->view_data["EmailId"] = $EmailId_rslt->row(0)->value;
            		$this->view_data["OfficeAddress"] = $OfficeAddress_rslt->row(0)->value;
            		$this->view_data["CompanyInfo"] = $CompanyInfo_rslt->row(0)->value;
            		$this->view_data["Message"] = $Message_rslt->row(0)->value;

            		$this->view_data["Message"] = $Message_rslt->row(0)->value;
            		$this->view_data["Message"] = $Message_rslt->row(0)->value;
            		
            		$this->view_data["UPI_ID"] = $UPI_IDRslt->row(0)->value;
            		$this->view_data["UPI_PARTY_NAME"] = $UPI_PARTYNAMERslt->row(0)->value;
            		$this->view_data["stop_success_recharge_reroot"] = $chkstop_success_recharge_rerootRslt->row(0)->value;
            		
            		$this->view_data['message'] =$this->msg;
            		$this->load->view('_Admin/admin_info_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
}