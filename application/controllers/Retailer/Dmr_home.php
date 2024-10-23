<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr_home extends CI_Controller {

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
			$mt_rslt = $this->db->query("select mt_access from tblusers where user_id = ?",array($this->session->userdata("AgentId") ));
			if($mt_rslt->num_rows() == 1)
			{
				$mtaccess = $mt_rslt->row(0)->mt_access;
				if($mtaccess != '1')
				{
					redirect(base_url()."Retailer/recharge_home?crypt=".$this->Common_methods->encrypt("Mydata"));
				}
			}
			
			
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache"); 
			$user=$this->session->userdata('AgentUserType');			
			if(trim($user) == 'Agent')
			{
				if(isset($_POST["hidencrdata"]) and isset($_POST["txtNumber"]))
				{
					//9999999991
					//360880
					//error_reporting(-1);
					//ini_set('display_errors',1);
					//$this->db->db_debug = TRUE;
					
					$hidencrdata = $this->Common_methods->decrypt($this->input->post("hidencrdata"));
				
					if($hidencrdata == $this->session->userdata("session_id"))
					{
						$txtNumber = trim($this->input->post("txtNumber",TRUE));
						$user_id = $this->session->userdata("AgentId");
						$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no from tblusers where user_id = ?",array($user_id));
						if($userinfo->num_rows() == 1)
						{
							$status = $userinfo->row(0)->status;
							$user_id = $userinfo->row(0)->user_id;
							$business_name = $userinfo->row(0)->businessname;
							$username = $userinfo->row(0)->username;
							$emailid = "";
							$mobile_no = $userinfo->row(0)->mobile_no;
							$usertype_name = $userinfo->row(0)->usertype_name;
							if($status == '1')
							{
								if(ctype_digit($txtNumber))
								{
									
										$this->load->model("Instapay");
										$jsonresp =  $this->Instapay->remitter_details($txtNumber,$userinfo);
										$jsonarr = json_decode($jsonresp);
										//print_r($jsonarr );exit;
										if(isset($jsonarr->status) and isset($jsonarr->statuscode))
										{
											$status = 	trim((string)$jsonarr->status);
											$statuscode = 	trim((string)$jsonarr->statuscode);
											if($status == "0")
											{
												/*{"message":"OTP sent successfully","status":0,"statuscode":"TXN","remitter":{"is_verified":0,"id":"2651680"},"beneficiary":""}*/
												$remitter_id = $jsonarr->remitter->id;
												$is_verified = $jsonarr->remitter->is_verified;
												if($is_verified == "0")
												{
												    $this->session->set_userdata("MTLOGIN",false);
    												$this->session->set_userdata("REMITTERID",$this->Common_methods->encrypt($remitter_id));
    												$this->session->set_userdata("MTSENDERMOBILE",$this->Common_methods->encrypt($txtNumber));
    												$this->session->set_userdata("MTAGENTID",$this->Common_methods->encrypt($user_id));
    												redirect(base_url()."Retailer/dmr_validate_sender?crypt=".$this->Common_methods->encrypt("getcustomerinfo"));
												}
												else
												{
												    $this->session->set_userdata("MTLOGIN",true);
    												$this->session->set_userdata("REMITTERID",$this->Common_methods->encrypt($remitter_id));
    												$this->session->set_userdata("MTSENDERMOBILE",$this->Common_methods->encrypt($txtNumber));
    												$this->session->set_userdata("MTAGENTID",$this->Common_methods->encrypt($user_id));
    												redirect(base_url()."Retailer/dmr_dashboard?crypt=".$this->Common_methods->encrypt("getcustomerinfo"));
												}
												
												
											}
											else
											{
													$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
													$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Sender Not Found");
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
						$this->load->view('Retailer/dmr_home_view',$this->view_data);
				}
			} 
		}
	}
}	