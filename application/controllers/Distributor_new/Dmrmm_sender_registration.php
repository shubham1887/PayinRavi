<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmrmm_sender_registration extends CI_Controller {
	
	
	private $msg='';
	
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
				$this->output->set_header("Pragma: no-cache"); 
		if($this->session->userdata('DistUserType') != "Distributor") 
		{ 
			redirect(base_url().'login'); 
		} 
	/*	$userinfo = $this->db->query("select mt_accept,mt_transo from tblusers where user_id = ?",array($this->session->userdata("DistId")));
		if($userinfo->row(0)->mt_transo != 'yes')
		{
			redirect(base_url()."Retailer/recharge_home");
		}
		if ($this->session->userdata('MT_LOGGED_IN') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}*/
		if($this->input->post("hidaction") == "Registration")
		{
			$hidsession_id = trim($this->input->post("hidsession_id"));
			$txtFirstName = trim($this->input->post("txtFirstName"));
			$txtLastName = trim($this->input->post("txtLastName"));
			$txtPincode = trim($this->input->post("txtPincode"));
			$txtMobileNumber = trim($this->input->post("txtMobileNumber"));
			$user_id = $this->session->userdata("DistId");
			
			
			
			$formdata = array(
			"hidsession_id"=>$hidsession_id,
			"txtFirstName"=>$txtFirstName,
			"txtMobileNumber"=>$txtMobileNumber
			);
///////////////////////////////////////////////////////



		
			$user_id = $this->session->userdata("DistId");
			$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
			
		
			
			$this->load->model("Mastermoney");
			$response = $this->Mastermoney->remitter_registration2($txtMobileNumber,$txtFirstName,$txtLastName,$txtPincode,$userinfo);
			//print_r($response);exit;
			
			/*  
			stdClass Object ( [message] => success [status] => 0 [insert_id] => 1740043 )
			
			*/
			$json_obj = json_decode($response);
			
			if(isset($json_obj->message) and isset($json_obj->status))
			{
				
				
					$message = trim((string)$json_obj->message);
					$status = trim((string)$json_obj->status);
					if($status == "0")
					{
						$this->session->set_userdata("SenderMobile",$txtMobileNumber);
						$this->session->set_userdata("MT_USER_ID",$user_id);
						$this->view_data["message"] = "";
						
						$this->view_data["MESSAGEBOX_MESSAGETYPE"] = "SUCCESS";
						$this->view_data["MESSAGEBOX_MESSAGEBODY"] = $message;
						redirect(base_url()."Retailer/dmrmm_validate_sender?crypt=".$this->Common_methods->encrypt("getcustomerinfo"));
					}
					
			}
			
				
		}
		else
		{
		    $sender_mobile = $this->session->flashdata("f_sendermobile");
		    if(isset($_GET["crypt1"]))
		    {
		        $sender_mobile= $this->Common_methods->decrypt($this->input->get("crypt1"));
		    }
		    
			$this->view_data["message"] = "";
			$this->view_data["MESSAGEBOX_MESSAGETYPE"] = "";
			$this->view_data["MESSAGEBOX_MESSAGEBODY"] = "";
			$this->view_data["txtFirstName"] = "";
			$this->view_data["txtMobileNumber"] = $sender_mobile;
			$this->load->view("Distributor_new/dmrmm_sender_registration_view",$this->view_data);
		}
		
			 
	}	

	private function loging($api,$data)
	{
		$date = $this->common->getMySqlDate();
		$filename ="./MTXML/".$api.$date.".xml";
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