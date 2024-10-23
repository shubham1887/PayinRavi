<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr_bene_registration extends CI_Controller {


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
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			$user_id = $this->session->userdata("AgentId");
			$MTLOGIN = $this->session->userdata("MTLOGIN");
			$MTSENDERMOBILE = $this->Common_methods->decrypt($this->session->userdata("MTSENDERMOBILE"));
			$MTAGENTID = $this->Common_methods->decrypt($this->session->userdata("MTAGENTID"));
			$REMITTERID = $this->Common_methods->decrypt($this->session->userdata("REMITTERID"));
			
			
			if($MTLOGIN == true and $MTAGENTID == $user_id and strlen($MTSENDERMOBILE) == 10)
			{
				$mt_rslt = $this->db->query("select mt_access from tblusers where user_id = ?",array($this->session->userdata("AgentId") ));
				if($mt_rslt->num_rows() == 1)
				{
					$mtaccess = $mt_rslt->row(0)->mt_access;
					if($mtaccess == '1')
					{
						$user=$this->session->userdata('AgentUserType');			
						if(trim($user) == 'Agent')
						{
							
								
									$txtNumber = $MTSENDERMOBILE;
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
												
											
												/*echo $_POST["hidformaction"]."<br>";
												echo $_POST["txtbeneName"]."<br>";
												echo $_POST["txtAccountNo"]."<br>";
												echo $_POST["txtIfsc"]."<br>";
												echo $_POST["txtMobile"]."<br>";exit;*/
												if(isset($_POST["hidformaction"]) and isset($_POST["txtbeneName"]) and isset($_POST["txtAccountNo"]) and isset($_POST["txtIfsc"]) and isset($_POST["txtMobile"]))
												{
													
													$hidformaction = trim($this->input->post("hidformaction"));
													$benificiary_name = trim($this->input->post("txtbeneName"));
													$benificiary_account_no = trim($this->input->post("txtAccountNo"));
													$benificiary_ifsc = trim($this->input->post("txtIfsc"));
													$benificiary_mobile = trim($this->input->post("txtMobile"));
													
													if($hidformaction == "BENEREGISTRATION")
													{
														$remitter_id = $REMITTERID;
														$this->load->model("Instapay");
														$jsonresp =  $this->Instapay->beneficiary_register($remitter_id,$benificiary_name,$benificiary_mobile,$benificiary_ifsc,$benificiary_account_no,$userinfo);
														$jsonarr = json_decode($jsonresp);
														echo $jsonarr;exit;
													}
													else if($hidformaction == "OTPBENEREGISTRATION")
													{
														$bene_id = trim($this->input->post("hidbeneid"));
														$otp = trim($this->input->post("txtotp"));
														$remitter_id = $REMITTERID;
														$this->load->model("Instapay");
														$jsonresp =  $this->Instapay->beneficiary_register_validate($remitter_id,$bene_id,$otp,$userinfo);
														$jsonarr = json_decode($jsonresp);
														echo $jsonarr;exit;
													}
													else if($hidformaction == "RESENDOTPBENEREGISTRATION")
													{
														$bene_id = trim($this->input->post("hidbeneid"));
														$remitter_id = $REMITTERID;
														$this->load->model("Instapay");
														$jsonresp =  $this->Instapay->beneficiary_resend_otp($remitter_id,$bene_id,$userinfo);
														$jsonarr = json_decode($jsonresp);
														echo $jsonarr;exit;
													}
													else if($hidformaction == "BENEDELETE")
													{
														$bene_id = trim($this->input->post("hidbeneid"));
														$remitter_id = $REMITTERID;
														$this->load->model("Instapay");
														$jsonresp =  $this->Instapay->beneficiary_remove($remitter_id,$bene_id,$userinfo);
														$jsonarr = json_decode($jsonresp);
														echo $jsonarr;exit;
													}
													else if($hidformaction == "OTPBENEDELETE")
													{
														$bene_id = trim($this->input->post("hidbeneid"));
														$otp = trim($this->input->post("txtotp"));
														$remitter_id = $REMITTERID;
														$this->load->model("Instapay");
														$jsonresp =  $this->Instapay->beneficiary_remove_validate($remitter_id,$bene_id,$otp,$userinfo);
														$jsonarr = json_decode($jsonresp);
														echo $jsonarr;exit;
													}
													if($hidformaction == "BENEVERIFICATION")
													{
														$remitter_id = $REMITTERID;
														$this->load->model("Instapay");
														$jsonresp =  $this->Instapay->account_validate($remitter_id,$txtNumber,$benificiary_account_no,$benificiary_ifsc,$userinfo);
														
														$jsonarr = json_decode($jsonresp);
														echo $jsonarr;exit;
													}
													
												}
												else if(isset($_POST["hidformaction"])  and isset($_POST["txtAccountNo"]) and isset($_POST["txtIfsc"]))
												{
													echo "herer";exit;
													$hidformaction = trim($this->input->post("hidformaction"));
													$benificiary_account_no = trim($this->input->post("txtAccountNo"));
													$benificiary_ifsc = trim($this->input->post("txtIfsc"));
													if($hidformaction == "BENEVERIFICATION")
													{
														$remitter_id = $REMITTERID;
														$this->load->model("Instapay");
														$jsonresp =  $this->Instapay->beneficiary_register($remitter_id,$benificiary_name,$benificiary_mobile,$benificiary_ifsc,$benificiary_account_no,$userinfo);
														$jsonarr = json_decode($jsonresp);
														echo $jsonarr;exit;
													}
													
													
													
												}
												else
												{
													$this->view_data["message"] = "";
													$this->load->view("Retailer/dmr_bene_registration_view",$this->view_data);
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
					}
					else
					{
						$this->session->set_userdata("MTLOGIN",false);
						$this->session->set_userdata("MTSENDERMOBILE","");
						$this->session->set_userdata("MTAGENTID","");
						$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
						$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Unauthorized Access");
						redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("Mydata"));
					}
				}
				else
				{
					$this->session->set_userdata("MTLOGIN",false);
					$this->session->set_userdata("MTSENDERMOBILE","");
					$this->session->set_userdata("MTAGENTID","");
					$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
					$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Unauthorized Access");
					redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("Mydata"));
				}
			}
			else
			{
				$this->session->set_userdata("MTLOGIN",false);
				$this->session->set_userdata("MTSENDERMOBILE","");
				$this->session->set_userdata("MTAGENTID","");
				$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
				$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: User Data Not Match");
				redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("Mydata"));
			}
		
			
			
			
			
			
		}
	}
	public function getAccountvalidate()
	{
		$user_id = $this->session->userdata("AgentId");
		$MTLOGIN = $this->session->userdata("MTLOGIN");
		$MTSENDERMOBILE = $this->Common_methods->decrypt($this->session->userdata("MTSENDERMOBILE"));
		$MTAGENTID = $this->Common_methods->decrypt($this->session->userdata("MTAGENTID"));
		if(isset($_POST["bid"]))
		{
			$beneid = trim($_POST["bid"]);
			$checkbeneexist = $this->db->query("select * from mt3_beneficiary_register_temp 
																	where RESP_beneficiary_id = ? and status = 'SUCCESS' 
																	order by Id desc limit 1",array(
																	$beneid));
			if($checkbeneexist->num_rows() > 0)
			{
				$remittermobile = $MTSENDERMOBILE;
				$remitter_id = $checkbeneexist->row(0)->RESP_remitter_id;
				$benificiary_account_no = $checkbeneexist->row(0)->benificiary_account_no;
				$benificiary_ifsc = $checkbeneexist->row(0)->benificiary_ifsc;
				$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
				$this->load->model("Instapay");
				echo $this->Instapay->account_validate($remitter_id,$remittermobile,$benificiary_account_no,$benificiary_ifsc,$userinfo);
			}
			else
			{
				$resp_arr = array(
										"message"=>"Beneficiary Not Found",
										"status"=>1,
										"statuscode"=>"RNF",
									);
				$json_resp =  json_encode($resp_arr);
				echo $json_resp;exit;
			}
		}
		else
		{
				$resp_arr = array(
										"message"=>"Invalid Operation",
										"status"=>1,
										"statuscode"=>"ERR",
									);
				$json_resp =  json_encode($resp_arr);
				echo $json_resp;exit;
		}
	}
}	