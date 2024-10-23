<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admininfo extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if($this->session->userdata('SdUserType') != "SuperDealer") 
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

		if($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
		    if($this->input->post("btnSearch"))
		    {
		        $host_id = $this->session->userdata("SdId");
		        $txtCustomerCare = $this->input->post("txtCustomerCare");
		        $txtEmailId = $this->input->post("txtEmailId");
		        $txtOfficeAddress = $this->input->post("txtOfficeAddress");
		        $txtCompanyInfo = $this->input->post("txtCompanyInfo");
		        $txtMessage = $this->input->post("txtMessage");
		        $this->db->query("update admininfo set value = ? where param = 'CustomerCare' and host_id = ?",array($txtCustomerCare,$host_id));
		        $this->db->query("update admininfo set value = ? where param = 'EmailId' and host_id = ?",array($txtEmailId,$host_id));
		        $this->db->query("update admininfo set value = ? where param = 'OfficeAddress' and host_id = ?",array($txtOfficeAddress,$host_id));
		        $this->db->query("update admininfo set value = ? where param = 'CompanyInfo' and host_id = ?",array($txtCompanyInfo,$host_id));
		        $this->db->query("update admininfo set value = ? where param = 'Message' and host_id = ?",array($txtMessage,$host_id));
		        redirect(base_url()."SuperDealer/admininfo");
		    }
		    else
		    {
		        $host_id = $this->session->userdata("SdId");
		    	
		    	$CustomerCare_rslt = $this->db->query("select value from admininfo where param = 'CustomerCare' and host_id = ?",array($host_id));
        		$EmailId_rslt = $this->db->query("select value from admininfo where param = 'EmailId'  and host_id = ?",array($host_id));
        		$OfficeAddress_rslt = $this->db->query("select value from admininfo where param = 'OfficeAddress'  and host_id = ?",array($host_id));
        		$CompanyInfo_rslt = $this->db->query("select value from admininfo where param = 'CompanyInfo'  and host_id = ?",array($host_id));
        		$Message_rslt = $this->db->query("select value from admininfo where param = 'Message'  and host_id = ?",array($host_id));
        		$CustomerCare = $CustomerCare_rslt->row(0)->value;
        		$EmailId = $EmailId_rslt->row(0)->value;
        		$OfficeAddress = $OfficeAddress_rslt->row(0)->value;
        		$CompanyInfo = $CompanyInfo_rslt->row(0)->value;
        		$Message = $Message_rslt->row(0)->value;
        		
    		    $this->view_data['CustomerCare']  = $CustomerCare;
    		    $this->view_data['EmailId']  = $EmailId;
    		    $this->view_data['OfficeAddress']  = $OfficeAddress;
    		    $this->view_data['CompanyInfo']  = $CompanyInfo;
    		    $this->view_data['Message']  = $Message;
    			$this->load->view('SuperDealer/admininfo_view',$this->view_data);
		    }
		   
		    	
		} 
	}	
}