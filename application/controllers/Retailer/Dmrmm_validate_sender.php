<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmrmm_validate_sender extends CI_Controller {
	
	
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
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
				$this->output->set_header("Pragma: no-cache"); 
		
		
		if($this->input->post("hidaction") == "VALIDATESENDER")
		{
	
			$txtMobileNo = $this->session->userdata("SenderMobile");
			$MT_USER_ID = $this->session->userdata("MT_USER_ID");
			$user_id = $this->session->userdata("AgentId");
			$txtOTP = trim($this->input->post("txtOTP"));
			$add_date = $this->common->getDate();
			$ipaddress = $this->common->getRealIpAddr();
			$userinfo = $this->db->query("select user_id,username,mobile_no,usertype_name,status,add_date,businessname from tblusers where user_id = ?",array($user_id));
			
			$this->load->model("Mastermoney");
			$resp = $this->Mastermoney->remitter_resend_otp2($txtMobileNo,$txtOTP,$userinfo);
			$jsonobj = json_decode($resp);
			if(isset($jsonobj->message) and isset($jsonobj->status) and isset($jsonobj->statuscode))
			{
				$message = trim((string)$jsonobj->message);
				$status = trim((string)$jsonobj->status);
				$statuscode = trim((string)$jsonobj->statuscode);
				if($status == "0")
				{
					$this->session->set_userdata("MT_LOGGED_IN",TRUE);
				}
				$resp_arr = array(
					"message"=>$message,
					"status"=>$status
				);
				echo json_encode($resp_arr);exit;
			}
				
		}
		else if($this->Common_methods->decrypt($this->input->get("crypt")) == "getcustomerinfo")
		{
			
			
			$this->view_data["data"] = "";
			$this->load->view("Retailer/dmrmm_validate_sender_view",$this->view_data);
				
		}
		else
		{
			redirect(base_url()."Retailer/recharge_home?crypt=".$this->Common_methods->encrypt("validate_sender"));
		}
		
			 
	}	
	
	public function resendotp()
	{
	    $user_id = $this->session->userdata("AgentId");
	    $userinfo = $this->db->query("select user_id,username,mobile_no,usertype_name,status,add_date,businessname from tblusers where user_id = ?",array($user_id));
	    $mobile_no =  $this->session->userdata("SenderMobile");
	    $this->load->model("Mastermoney");
	    $resp = $this->Mastermoney->remitter_resend_otp($mobile_no,$userinfo);
	    $json_obj = json_decode($resp);
	    if(isset($json_obj->status) and isset($json_obj->message))
	    {
	        $status = $json_obj->status;
	        $message = $json_obj->message;
	        if($status == "0")
	        {
	            echo '<div class="alert success">Otp Sent Successfully.</div>';exit;
	        }
	        else
	        {
	            echo '<div class="alert alert-danger">'.$message.'</div>';exit;
	        }
	    }
	    else
	    {
	        echo '<div class="alert alert-danger">Some Error Occured. Please Try Again</div>';exit;
	    }
	}
	private function loging($method,$data)
	{
		$date = $this->common->getMySqlDate();
		$filename ="./MTXML/".$method.$date.".xml";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
		write_file($filename, "<date>".$date."</date>"."\n", 'a+');
		write_file($filename, $data."\n", 'a+');
	}
}