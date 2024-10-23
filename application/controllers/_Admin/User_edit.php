<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_edit extends CI_Controller {
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
        $this->load->model("Service_model");
        $this->load->model("User_update_model");

        $this->load->model("Api_model");
        // error_reporting(-1);
        // ini_set('display_errors',1);
        // $this->db->db_debug = TRUE;
    }
	public function process()
	{
		$this->index();
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
			if($this->input->post("btnSubmit"))
			{		
			    
				$Dealername = $this->input->post("txtDistname",TRUE);
				$pan_no = $this->input->post("txtpanNo",TRUE);	
				$con_per = $this->input->post("txtConPer",TRUE);		
				$Parent_id = 1;		
				$Address = $this->input->post("txtPostalAddr",TRUE);				
				$Pin = $this->input->post("txtPin",TRUE);
				$State = $this->input->post("ddlState",TRUE);
				$City = $this->input->post("ddlCity",TRUE);				
				$MobNo = $this->input->post("txtMobNo",TRUE);
				$BDate = $this->input->post("txtBDate",TRUE);	
				
				$Email = $this->input->post("txtEmail",TRUE);				
				$stateCode = $this->input->post("hidStateCode",TRUE);
				
				$Scheme_id = $this->input->post("ddlSchDesc",TRUE);																
				$User_id = $this->input->post("hiduserid",TRUE);				
				$aadhar_number =$this->input->post("txtAadhar",TRUE);
				
				$gst_no =$this->input->post("txtgst",TRUE);
				$contact_person = $this->input->post("txtConPer",TRUE);
				$landline = "";
				
				$txtCallbackUrl =$this->input->post("txtCallbackUrl",TRUE);
				$txtIp1 =$this->input->post("txtIp1",TRUE);
				$txtIp2 =$this->input->post("txtIp2",TRUE);
				$txtIp3 =$this->input->post("txtIp3",TRUE);
				$txtIp4 =$this->input->post("txtIp4",TRUE);
				
				
				$flatcomm = $this->input->post("txtW1FlatComm",TRUE);
				$flatcomm2 = $this->input->post("txtW2FlatComm",TRUE);
				if($flatcomm > 5)
				{
				    $flatcomm = 0;
				}
				if($flatcomm2 > 5)
				{
				    $flatcomm2 = 0;
				}
				
				
				
				$service_array = array();
				$service_rslt = $this->Service_model->getServices();
				foreach($service_rslt->result() as $ser)
				{
				    if(isset($_POST["chk".$ser->service_name]))
				    {
				       $service_array[$ser->service_name] = trim($_POST["chk".$ser->service_name]);
				    }
				}
				
				$downline_scheme=$downline_scheme2=0;
				$resp = $this->User_update_model->tblusers_registration_Entry($Parent_id,$Dealername,$Address,$Pin,$State,$City,$contact_person,$MobNo,$Email,$Scheme_id,$aadhar_number,$pan_no,$gst_no,$downline_scheme,$downline_scheme2,$BDate,$service_array,$flatcomm,$flatcomm2,$User_id,0,0);
				if(isset($resp["status"]) and isset($resp["message"]))
				{
				    $status = $resp["status"];
				    $message = $resp["message"];
				    
				    if($status == "0")
				    {
				        
				        
				        $this->db->query("update tblusers_info set call_back_url = ?,client_ip = ?,client_ip2 = ?,client_ip3 = ?,client_ip4 = ? where user_id = ?",array($txtCallbackUrl,$txtIp1,$txtIp2,$txtIp3,$txtIp4,$User_id));
				        
				        $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
				        $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY",$message);
				        redirect(base_url()."_Admin/User_edit?id=".$this->Common_methods->encrypt($User_id));
				    }
				    else
				    {
				        $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
				        $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY",$message);
				        redirect(base_url()."_Admin/User_edit?id=".$this->Common_methods->encrypt($User_id));
				    }
				    
				    /*
				    f($this->session->flashdata("MESSAGEBOX_MESSAGETYPE") == "FAILURE" and $this->session->flashdata("MESSAGEBOX_MESSAGEBODY") 
				    */
				}
				else
				{
				    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
			        $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","User Update Failed");
			        redirect(base_url()."_Admin/User_edit?id=".$this->Common_methods->encrypt($User_id));
				}
				
				
			}
			else
			{
					$this->load->view('_Admin/User_edit_view',$data);
			}
		} 			
	}
}
