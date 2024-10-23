<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmrmm_bene_registration extends CI_Controller {


	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('MdUserType') != "MasterDealer") 
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
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
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
		if ($this->session->userdata('MdUserType') != "MasterDealer") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			$user_id = $this->session->userdata("MdId");
			
			
			
			$MTLOGIN = $this->session->userdata("MT_LOGGED_IN");
			$MTSENDERMOBILE = $this->session->userdata("SenderMobile");
			$MTMdId = $this->session->userdata("MT_USER_ID");
		
			
			$user_id = $this->session->userdata("MdId");
			if($MTLOGIN == true and strlen($MTSENDERMOBILE) == 10)
			{
				$mt_rslt = 	$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no,mt_access from tblusers where user_id = ?",array($user_id));
				if($mt_rslt->num_rows() == 1)
				{
					$mtaccess = $mt_rslt->row(0)->mt_access;
					if($mtaccess == '1')
					{
						$user=$this->session->userdata('MdUserType');			
						if(trim($user) == 'MasterDealer')
						{
							
								
									$txtNumber = $MTSENDERMOBILE;
								
								//	$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no from tblusers where user_id = ?",array($user_id));
									if($userinfo->num_rows() == 1)
									{
										$status = $userinfo->row(0)->status;
										$user_id = $userinfo->row(0)->user_id;
										$businessname = $userinfo->row(0)->businessname;
										$username = $userinfo->row(0)->username;
									
										$mobile_no = $userinfo->row(0)->mobile_no;
										$usertype_name = $userinfo->row(0)->usertype_name;
										
										if($status == '1')
										{
											
											if(ctype_digit($txtNumber))
											{
											    
											   
												if(isset($_POST["hidformaction"]) and isset($_POST["txtbeneName"]) and isset($_POST["txtAccountNo"]) and isset($_POST["txtIfsc"]))
												{
												
													$hidformaction = trim($this->input->post("hidformaction"));
													$benificiary_name = trim($this->input->post("txtbeneName"));
													$benificiary_account_no = trim($this->input->post("txtAccountNo"));
													$benificiary_ifsc = trim($this->input->post("txtIfsc"));
													$benificiary_mobile = trim($this->input->post("txtMobile"));
													$bank_id = $this->input->post("ddlbank");
													
													if($hidformaction == "BENEREGISTRATION")
													{
													    $remitter_id = $MTSENDERMOBILE;
														$this->load->model("Mastermoney");
														$jsonresp =  $this->Mastermoney->add_benificiary($remitter_id,$benificiary_name,$benificiary_mobile,$benificiary_account_no,$benificiary_ifsc,$bank_id,$userinfo);
														
														
														echo $jsonresp;exit;
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
														
														$RemitterMobile = $MTSENDERMOBILE;
													    $this->load->model("Mastermoney");
														$jsonresp =  $this->Mastermoney->delete_bene($RemitterMobile,$bene_id,$userinfo);
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
													//	echo $benificiary_account_no."  ".$benificiary_ifsc;exit;
														$bank_code = $this->input->post("ddlbank");
														$remitter_id = $MTSENDERMOBILE;
														$this->load->model("Mastermoney");
														$jsonresp =  $this->Mastermoney->verify_bene($remitter_id,$benificiary_account_no,$benificiary_ifsc,$bank_code,$userinfo);
														echo $jsonresp;exit;
														
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
														echo $jsonresp;exit;
														$jsonarr = json_decode($jsonresp);
														echo $jsonarr;exit;
													}
													
													
													
												}
												else
												{
													$this->view_data["message"] = "";
													$this->load->view("MasterDealer_new/dmrmm_bene_registration_view",$this->view_data);
												}
													
													
											}
											else
											{
												
												$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
												$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Internal Server Error. Please Try Later...");
												redirect(base_url()."Retailer/dmr2_home?crypt=".$this->Common_methods->encrypt("MyData"));	
											}
										}
										else
										{
											$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
											$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Your Account Deactivated By Admin");
											redirect(base_url()."Retailer/dmr2_home?crypt=".$this->Common_methods->encrypt("MyData"));
										}
									
									}
									else
									{
										$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
										$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Session Expired. Please try Login Again");
										redirect(base_url()."Retailer/dmr2_home?crypt=".$this->Common_methods->encrypt("MyData"));
									}
								
						} 
					}
					else
					{
						$this->session->set_userdata("MTLOGIN",false);
						$this->session->set_userdata("MTSENDERMOBILE","");
						$this->session->set_userdata("MTMdId","");
						$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
						$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Unauthorized Access");
						redirect(base_url()."Retailer/dmr2_home?crypt=".$this->Common_methods->encrypt("Mydata"));
					}
				}
				else
				{
					$this->session->set_userdata("MTLOGIN",false);
					$this->session->set_userdata("MTSENDERMOBILE","");
					$this->session->set_userdata("MTMdId","");
					$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
					$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Unauthorized Access");
					redirect(base_url()."Retailer/dmr2_home?crypt=".$this->Common_methods->encrypt("Mydata"));
				}
			}
			else
			{
				$this->session->set_userdata("MTLOGIN",false);
				$this->session->set_userdata("MTSENDERMOBILE","");
				$this->session->set_userdata("MTMdId","");
				$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
				$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: User Data Not Match");
				redirect(base_url()."Retailer/dmr2_home?crypt=".$this->Common_methods->encrypt("Mydata"));
			}
		
			
			
			
			
			
		}
	}
	public function getAccountvalidate()
	{
		$user_id = $this->session->userdata("MdId");
		$MTLOGIN = $this->session->userdata("MTLOGIN");
		$MTSENDERMOBILE = $this->Common_methods->decrypt($this->session->userdata("MTSENDERMOBILE"));
		$MTMdId = $this->Common_methods->decrypt($this->session->userdata("MTMdId"));
		if(isset($_POST["bid"]))
		{
			$beneid = trim($_POST["bid"]);
			$checkbeneexist = $this->db->query("select RESP_remitter_id,benificiary_account_no,benificiary_ifsc from mt3_beneficiary_register_temp 
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
	public function getbeneinfo()
	{
		if(isset($_GET["ifsc"]))
		{
			$ifsc = trim($_GET["ifsc"]);
			$rslt = $this->db->query("SELECT * FROM `totalbankdetail` where IFSC = ?",array($ifsc));
			if($rslt->num_rows() == 1)
			{
				echo '<div>';
				echo '<table id="tblbankinfo" class="table table-bordered" style="width:400px;">';
				echo '<tr>';
					echo '<td><b>Bank</b></td><td>'.$rslt->row(0)->Bank_Name.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td><b>Branch</b></td><td>'.$rslt->row(0)->Branch_Name.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td><b>Address</b></td><td>'.$rslt->row(0)->Address.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td><b>City</b></td><td>'.$rslt->row(0)->City.' '.$rslt->row(0)->District.'</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td><b>State</b></td><td>'.$rslt->row(0)->State.'</td>';
				echo '</tr>';
				echo '</table>';
				echo '</div>';
			}
		}
	}
}	