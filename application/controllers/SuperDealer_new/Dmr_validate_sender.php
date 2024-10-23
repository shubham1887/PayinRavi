<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr_validate_sender extends CI_Controller {
	
	
	private $msg='';
	
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
				$this->output->set_header("Pragma: no-cache"); 
		
		
		if($this->input->post("hidaction") == "VALIDATESENDER")
		{
	
	
	    //REMITTERID,MTSENDERMOBILE
			$txtMobileNo = $this->Common_methods->decrypt($this->session->userdata("MTSENDERMOBILE"));
			$REMITTERID = $this->Common_methods->decrypt($this->session->userdata("REMITTERID"));
			$user_id = $this->session->userdata("SdId");
			$txtOTP = trim($this->input->post("txtOTP"));
			$add_date = $this->common->getDate();
			$ipaddress = $this->common->getRealIpAddr();
			$userinfo = $this->db->query("select user_id,username,mobile_no,usertype_name,status,add_date,businessname from tblusers where user_id = ?",array($user_id));
			
			$this->load->model("Instapay");
			$resp = $this->Instapay->remitter_validate_otp($REMITTERID,$txtMobileNo,$txtOTP,$userinfo);
			$jsonobj = json_decode($resp);
			if(isset($jsonobj->message) and isset($jsonobj->status) and isset($jsonobj->statuscode))
			{
				$message = trim((string)$jsonobj->message);
				$status = trim((string)$jsonobj->status);
				$statuscode = trim((string)$jsonobj->statuscode);
				if($status == "0")
				{
					$this->session->set_userdata("MTLOGIN",TRUE);
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
			$this->load->view("SuperDealer_new/dmr_validate_sender_view",$this->view_data);
				
		}
		else
		{
			redirect(base_url()."Retailer/recharge_home?crypt=".$this->Common_methods->encrypt("validate_sender"));
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