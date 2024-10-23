<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr_dashboard extends CI_Controller {


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
			$MTLOGIN = $this->session->userdata("MTLOGIN");
			$MTSENDERMOBILE = $this->Common_methods->decrypt($this->session->userdata("MTSENDERMOBILE"));
			$MTMdId = $this->Common_methods->decrypt($this->session->userdata("MTMdId"));
			
			
			if($MTLOGIN == true and $MTMdId == $user_id and strlen($MTSENDERMOBILE) == 10)
			{
				$mt_rslt = $this->db->query("select mt_access from tblusers where user_id = ?",array($this->session->userdata("MdId") ));
				if($mt_rslt->num_rows() == 1)
				{
					$mtaccess = $mt_rslt->row(0)->mt_access;
					if($mtaccess == '1')
					{
						$user=$this->session->userdata('MdUserType');			
						if(trim($user) == 'MasterDealer')
						{
							
								
									$txtNumber = $MTSENDERMOBILE;
									$user_id = $this->session->userdata("MdId");
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
													if(isset($jsonarr->status) and isset($jsonarr->statuscode))
													{
														$status = 	trim((string)$jsonarr->status);
														$statuscode = 	trim((string)$jsonarr->statuscode);
														if($status == "0")
														{
															$remitter_info = $jsonarr->remitter;
															$beneficiary_info = $jsonarr->beneficiary;
															$this->view_data["remitter_info"] = $remitter_info;
															$this->view_data["beneficiary_info"] = $beneficiary_info;
															$this->load->view("MasterDealer_new/dmr_dashboard_view",$this->view_data);
															
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
					}
					else
					{
						$this->session->set_userdata("MTLOGIN",false);
						$this->session->set_userdata("MTSENDERMOBILE","");
						$this->session->set_userdata("MTMdId","");
						$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
						$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Unauthorized Access");
						redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("Mydata"));
					}
				}
				else
				{
					$this->session->set_userdata("MTLOGIN",false);
					$this->session->set_userdata("MTSENDERMOBILE","");
					$this->session->set_userdata("MTMdId","");
					$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
					$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Unauthorized Access");
					redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("Mydata"));
				}
			}
			else
			{
				$this->session->set_userdata("MTLOGIN",false);
				$this->session->set_userdata("MTSENDERMOBILE","");
				$this->session->set_userdata("MTMdId","");
				$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
				$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: User Data Not Match");
				redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("Mydata"));
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