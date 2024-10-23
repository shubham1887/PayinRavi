<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_template extends CI_Controller {
	
	
	
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
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
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
			    
			    //print_r($this->input->post());exit;
			    
			    $txtREGISTRATION = $this->input->post("txtREGISTRATION",TRUE);
				$txtBALANCE_ADD = $this->input->post("txtBALANCE_ADD",TRUE);
				$txtBALANCE_REVERT = $this->input->post("txtBALANCE_REVERT",TRUE);
				$txtDMRBALANCE_ADD = $this->input->post("txtDMRBALANCE_ADD",TRUE);
				$txtDMRBALANCE_REVERT = $this->input->post("txtDMRBALANCE_REVERT",TRUE);
				$OTP = $this->input->post("txtOTP",TRUE);
				
				
				$chkis_sms_REGISTRATION = $this->input->post("chkis_sms_REGISTRATION",TRUE);
				$chkis_sms_BALANCE_ADD = $this->input->post("chkis_sms_BALANCE_ADD",TRUE);
				$chkis_sms_BALANCE_REVERT = $this->input->post("chkis_sms_BALANCE_REVERT",TRUE);
				$chkis_sms_DMRBALANCE_ADD = $this->input->post("chkis_sms_DMRBALANCE_ADD",TRUE);
				$chkis_sms_DMRBALANCE_REVERT = $this->input->post("chkis_sms_DMRBALANCE_REVERT",TRUE);
				$chkis_sms_OTP = $this->input->post("chkis_sms_OTP",TRUE);
				
			
				
				$chkis_notification_REGISTRATION = $this->input->post("chkis_notification_REGISTRATION",TRUE);
				$chkis_notification_BALANCE_ADD = $this->input->post("chkis_notification_BALANCE_ADD",TRUE);
				$chkis_notification_BALANCE_REVERT = $this->input->post("chkis_notification_BALANCE_REVERT",TRUE);
				$chkis_notification_DMRBALANCE_ADD = $this->input->post("chkis_notification_DMRBALANCE_ADD",TRUE);
				$chkis_notification_DMRBALANCE_REVERT = $this->input->post("chkis_notification_DMRBALANCE_REVERT",TRUE);
				$chkis_notification_OTP = $this->input->post("chkis_notification_OTP",TRUE);
				
				
			    $this->db->query("update sms_templates set str_template = ?,is_sms = ?,is_notification = ? where template_name = 'REGISTRATION' and host_id = 1",array($txtREGISTRATION,$chkis_sms_REGISTRATION,$chkis_notification_REGISTRATION));
				$this->db->query("update sms_templates set str_template = ?,is_sms = ?,is_notification = ? where template_name = 'BALANCE_ADD' and host_id = 1",array($txtBALANCE_ADD,$chkis_sms_BALANCE_ADD,$chkis_notification_BALANCE_ADD));
				$this->db->query("update sms_templates set str_template = ?,is_sms = ?,is_notification = ? where template_name = 'BALANCE_REVERT' and host_id = 1",array($txtBALANCE_REVERT,$chkis_sms_BALANCE_REVERT,$chkis_notification_BALANCE_REVERT));
				$this->db->query("update sms_templates set str_template = ?,is_sms = ?,is_notification = ? where template_name = 'DMRBALANCE_ADD' and host_id = 1",array($txtDMRBALANCE_ADD,$chkis_sms_DMRBALANCE_ADD,$chkis_notification_DMRBALANCE_ADD));
				$this->db->query("update sms_templates set str_template = ?,is_sms = ?,is_notification = ? where template_name = 'DMRBALANCE_REVERT' and host_id = 1",array($txtDMRBALANCE_REVERT,$chkis_sms_DMRBALANCE_REVERT,$chkis_notification_DMRBALANCE_REVERT));
				$this->db->query("update sms_templates set str_template = ?,is_sms = ?,is_notification = ? where template_name = 'OTP' and host_id = 1",array($OTP,$chkis_sms_OTP,$chkis_notification_OTP));
				
				redirect(base_url()."_Admin/Sms_template");
			}
		
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
    				$this->view_data['pagination'] = "";
            		
            		$REGISTRATION_rslt = $this->db->query("select str_template,is_sms,is_notification from sms_templates where template_name = 'REGISTRATION' and host_id = 1");
            		$BALANCE_ADD_rslt = $this->db->query("select str_template,is_sms,is_notification from sms_templates where template_name = 'BALANCE_ADD' and host_id = 1");
            		$BALANCE_REVERT_rslt = $this->db->query("select str_template,is_sms,is_notification from sms_templates where template_name = 'BALANCE_REVERT' and host_id = 1");
            		$DMRBALANCE_ADD_rslt = $this->db->query("select str_template,is_sms,is_notification from sms_templates where template_name = 'DMRBALANCE_ADD' and host_id = 1");
            		$DMRBALANCE_REVERT_rslt = $this->db->query("select str_template,is_sms,is_notification from sms_templates where template_name = 'DMRBALANCE_REVERT' and host_id = 1");
            		$OTP_rslt = $this->db->query("select str_template,is_sms,is_notification from sms_templates where template_name = 'OTP' and host_id = 1");
            		
            	    
            	    
				   
            		
            		$this->view_data["REGISTRATION"] = $REGISTRATION_rslt;
            		$this->view_data["BALANCE_ADD"] = $BALANCE_ADD_rslt;
            		$this->view_data["BALANCE_REVERT"] = $BALANCE_REVERT_rslt;
            		$this->view_data["DMRBALANCE_ADD"] = $DMRBALANCE_ADD_rslt;
            		$this->view_data["DMRBALANCE_REVERT"] = $DMRBALANCE_REVERT_rslt;
            		$this->view_data["OTP"] = $OTP_rslt;
            		
            		$this->view_data['message'] =$this->msg;
            		$this->load->view('_Admin/Sms_template_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
}