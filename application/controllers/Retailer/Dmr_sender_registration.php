<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr_sender_registration extends CI_Controller {

	 public function get_string_between($string, $start, $end)
	 { 
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}
	public function index()
	{	
		if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			/*$mt_rslt = $this->db->query("select mt_access from tblusers where user_id = ?",array($this->session->userdata("AgentId") ));
			if($mt_rslt->num_rows() == 1)
			{
				$mtaccess = $mt_rslt->row(0)->mt_access;
				if($mtaccess != '1')
				{
					redirect(base_url()."Retailer/recharge_home?crypt=".$this->Common_methods->encrypt("Mydata"));
				}
			}*/
			
			
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache"); 
			$user=$this->session->userdata('AgentUserType');			
			if(trim($user) == 'Agent')
			{
				if(isset($_POST["hidencrdata"]) and isset($_POST["txtMobile"]) and isset($_POST["txtName"]) and isset($_POST["txtPincode"]))
				{
					//9999999991
					//360880
					$hidencrdata = $this->Common_methods->decrypt($this->input->post("hidencrdata"));
					$txtNumber = trim($this->input->post("txtMobile"));
					$txtName = trim($this->input->post("txtName"));
					$txtPincode = trim($this->input->post("txtPincode"));
					$txtSName = trim($this->input->post("txtSName"));
					if($hidencrdata == $this->session->userdata("session_id"))
					{
						$user_id = $this->session->userdata("AgentId");
						$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,emailid,mobile_no from tblusers where user_id = ?",array($user_id));
						if($userinfo->num_rows() == 1)
						{
							$status = $userinfo->row(0)->status;
							$user_id = $userinfo->row(0)->user_id;
							$businessname = $userinfo->row(0)->businessname;
							$username = $userinfo->row(0)->username;
							
							$emailid = $userinfo->row(0)->emailid;
							$mobile_no = $userinfo->row(0)->mobile_no;
							$usertype_name = $userinfo->row(0)->usertype_name;
							if($status == '1')
							{
								if(ctype_digit($txtNumber))
								{
									
										$this->load->model("Instapay");
										$jsonresp =  $this->Instapay->remitter_registration($txtNumber,$txtName,$txtPincode,$txtSName,$userinfo);
										
										$jsonarr = json_decode($jsonresp);
										
										if(isset($jsonarr->status) and isset($jsonarr->statuscode))
										{
											$status = 	trim((string)$jsonarr->status);
											$statuscode = 	trim((string)$jsonarr->statuscode);
											if($status == "0")
											{
												$remitter_id = trim((string)$jsonarr->remitter_id);
												$this->session->set_userdata("MTLOGIN",true);
												$this->session->set_userdata("REMITTERID",$this->Common_methods->encrypt($remitter_id));
												$this->session->set_userdata("MTSENDERMOBILE",$this->Common_methods->encrypt($txtNumber));
												$this->session->set_userdata("MTAGENTID",$this->Common_methods->encrypt($user_id));
												redirect(base_url()."Retailer/dmr_dashboard?crypt=".$this->Common_methods->encrypt("MyData"));
											}
											else
											{
													$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
													$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: ".$status);
													redirect(base_url()."Retailer/dmr_sender_registration?crypt=".$this->Common_methods->encrypt("MyData"));	
											}
										}
										else
										{
												$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
												$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Your Account Deactivated By Admin");
												redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("MyData"));
										}
										
								}
								else
								{
									$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
									$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Internal Server Error. Please Try Later...");
									redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("MyData"));	
								}
							}
							else
							{
								$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
								$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Your Account Deactivated By Admin");
								redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("MyData"));
							}
						
						}
						else
						{
							$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
							$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Session Expired. Please try Login Again");
							redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("MyData"));
						}
					}
					else
					{
							$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
							$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Invalid Request");
							redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("MyData"));
					}
				}	
				else
				{		
				
						$this->view_data['message'] ="";
						$this->load->view('Retailer/dmr_sender_registration_view',$this->view_data);
				}
			} 
		}
	}
}	