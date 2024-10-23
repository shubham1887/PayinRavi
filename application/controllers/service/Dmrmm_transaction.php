<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmrmm_transaction extends CI_Controller {


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
			$MTLOGIN = $this->session->userdata("MT_LOGGED_IN");
			$MTSENDERMOBILE = $this->session->userdata("SenderMobile");
			$MTAGENTID = $this->session->userdata("MT_USER_ID");
			$user_id = $this->session->userdata("AgentId");
			
			
			if($MTLOGIN == true and $MTAGENTID == $user_id and strlen($MTSENDERMOBILE) == 10)
			{
			//	$mt_rslt = $this->db->query("select mt_access from tblusers where user_id = ?",array($this->session->userdata("AgentId") ));
			$mt_rslt = 	$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no,mt_access,txn_password from tblusers where user_id = ?",array($user_id));
			
				if($mt_rslt->num_rows() == 1)
				{
					$mtaccess = $mt_rslt->row(0)->mt_access;
					if($mtaccess == '1')
					{
						$user=$this->session->userdata('AgentUserType');			
						if(trim($user) == 'Agent')
						{
						    
						    $rsltcommon = $this->db->query("select * from common where param = 'DMRSERVICE'");
						    if($rsltcommon->num_rows() == 1)
						    {
						        $is_service = $rsltcommon->row(0)->value;
						    	if($is_service == "DOWN")
						    	{
						    	    $resp_arr = array(
        								"message"=>"Service Temporarily Down",
        								"status"=>1,
        								"statuscode"=>"ERR",
        								);
        						$this->session->set_flashdata("MESSAGEBOXTYPE","FAILURE");
        						$this->session->set_flashdata("MESSAGEBOX","Service Temporarily Down");
									$this->view_data["MESSAGEBOX"] = "Service Temporarily Down";
									redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("getcustomerinfo"));
						    	}
						    }
						    
						    
							$txtNumber = $MTSENDERMOBILE;
							$user_id = $this->session->userdata("AgentId");
							//$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no from tblusers where user_id = ?",array($user_id));
							
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
									    
										if(isset($_POST["crypt_d1"]) and isset($_POST["crypt_d2"]) and isset($_POST["crypt_d3"]))
										{
										   
											$txtBeneId = $this->Common_methods->decrypt(trim($this->input->post("crypt_d1")));
											$txtRemitterId = $this->Common_methods->decrypt(trim($this->input->post("crypt_d2")));
											$txtTransType = $this->Common_methods->decrypt(trim($this->input->post("crypt_d3")));
											
											// error_reporting(E_ALL);
                                           // ini_set('display_errors', 1);
                                           // $this->db->debug = TRUE;
									//	echo $txtRemitterId.'   '.$txtBeneId."<br>";
											$checkbeneexist = $this->db->query("select * from mt3_beneficiary_register_temp 
																	where remitter_mobile = ? and RESP_beneficiary_id = ? and status = 'SUCCESS' 
																	order by Id desc limit 1 ",array(
																	$txtRemitterId,$txtBeneId));
											if($checkbeneexist->num_rows() == 0)
											{
											    $checkbeneexist = $this->db->query("select * from mt3_beneficiary_register_temp 
																	where remitter_mobile = ? and mm_id = ? and status = 'SUCCESS' 
																	order by Id desc limit 1 ",array(
																	$txtRemitterId,$txtBeneId));
											    if($checkbeneexist == 1)
											    {
											        $this->db->query("update mt3_beneficiary_register_temp set RESP_beneficiary_id = ? , API = 'MASTERMONEY' where Id = ?",array($txtBeneId,$checkbeneexist->row(0)->Id));
											    }
											}
															//		print_r($checkbeneexist->num_rows());exit;
											if($checkbeneexist->num_rows() > 0)
											{
											    
												$this->view_data["benedata"] = $checkbeneexist;
												$this->view_data["remitter_id"] = trim($this->input->post("crypt_d2"));
												$this->view_data["bene_id"] = trim($this->input->post("crypt_d1"));
												$this->view_data["transtype"] = trim($this->input->post("crypt_d3"));
												$this->load->view("Retailer/dmrmm_transaction_view",$this->view_data);
												
											}
											else
											{
											    
												$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
												$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Invalid Beneficiary Data");
												redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));	
											}	
										}
										else if(isset($_POST["crypt_d4"]) and isset($_POST["crypt_d5"]) and isset($_POST["crypt_d6"]) and isset($_POST["formaction"]))
										{
										
											$txtBeneId = $this->Common_methods->decrypt($this->Common_methods->decrypt(trim($this->input->post("crypt_d4"))));
											$txtRemitterId = $this->Common_methods->decrypt($this->Common_methods->decrypt(trim($this->input->post("crypt_d5"))));
											$txtTransType = $this->Common_methods->decrypt($this->Common_methods->decrypt(trim($this->input->post("crypt_d6"))));
											$formaction = trim($this->input->post("formaction"));
											$hidencrdata = trim($this->input->post("hidencrdata"));
											$txtAmount = floatval(trim($this->input->post("txtAmount")));
											$txtRemark = trim($this->input->post("txtRemark"));
											$txtTpin = trim($this->input->post("txtTpin"));
											
											if($txtTpin != $userinfo->row(0)->txn_password)
											{
											    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
												$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Please Enter Valid Tpin");
												redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));	
											}
											else
											{
											    if($formaction == "CNFTXN")
    											{
    												
    												$balance = $this->Ew2->getAgentBalance($user_id);
    												if($balance >= ($txtAmount + 20))
    												{
    													$checkbeneexist = $this->db->query("select * from mt3_beneficiary_register_temp 
    																	where remitter_mobile = ? and RESP_beneficiary_id = ? and status = 'SUCCESS' and API = 'MASTERMONEY' 
    																	order by Id desc limit 1",array(
    																	$txtRemitterId,$txtBeneId));
    													if($checkbeneexist->num_rows() > 0)
    													{
    														$this->view_data["benedata"] = $checkbeneexist;
    														
    														$this->view_data["bene_id"] = trim($this->input->post("crypt_d4"));
    														$this->view_data["remitter_id"] = trim($this->input->post("crypt_d5"));
    														$this->view_data["transtype"] = trim($this->input->post("crypt_d6"));
    														$this->view_data["Amount"] = $this->Common_methods->encrypt(trim($this->input->post("txtAmount")));
    														$this->view_data["Remark"] = $this->Common_methods->encrypt(trim($this->input->post("txtRemark")));
    														
    														$this->load->view("Retailer/dmrmm_cnftransaction_view",$this->view_data);
    														
    													}
    													else
    													{
    														$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
    														$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Invalid Beneficiary Data");
    														redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));	
    													}	
    												}
    												else
    												{
    														$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
    														$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: InSufficiant Balance");
    														redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));	
    												}			
    											}   
											}
										}
										else
										{
										    
											$this->view_data["message"] = "";
											$this->load->view("Retailer/dmrmm_transaction_view",$this->view_data);
										}	
									}
									else
									{
										$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
										$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Internal Server Error. Please Try Later...");
										redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));	
									}
								}
								else
								{
									$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
									$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Your Account Deactivated By Admin");
									redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));
								}
							}
							else
							{
								$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
								$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Session Expired. Please try Login Again");
								redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));
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
						redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("Mydata"));
					}
				}
				else
				{
					$this->session->set_userdata("MTLOGIN",false);
					$this->session->set_userdata("MTSENDERMOBILE","");
					$this->session->set_userdata("MTAGENTID","");
					$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
					$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Unauthorized Access");
					redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("Mydata"));
				}
			}
			else
			{
				$this->session->set_userdata("MTLOGIN",false);
				$this->session->set_userdata("MTSENDERMOBILE","");
				$this->session->set_userdata("MTAGENTID","");
				$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
				$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: User Data Not Match");
				redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("Mydata"));
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
				$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no,mt_access from tblusers where user_id = ?",array($user_id));
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