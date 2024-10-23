<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function index()
	{ 
	
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
#$rslt = $this->db->query("select * from tblusers");
#print_r($rslt->result());exit;		
		if($this->input->post("txtUsername") and $this->input->post("txtPassword"))
		{
			$username  = $this->input->post("txtUsername");
			$password  = $this->input->post("txtPassword");
			
			$rsltuserinfo = $this->db->query("select 
				a.web_logintoken,
				a.kyc,
				a.terms_and_conditions,
				a.parentid,a.username,a.scheme_id,a.user_id,a.businessname,a.usertype_name,a.mobile_no,a.status ,a.mt_access,a.balance,info.pincode,
			info.emailid,info.postal_address,info.aadhar_number,info.pan_no,info.gst_no,g.group_name
			from tblusers a 
			left join tblusers_info info on a.user_id = info.user_id
			left join tblgroup g on a.scheme_id = g.Id
			where a.mobile_no = ? and a.password = ?",array($username,$password));
			if($rsltuserinfo->num_rows() == 1)
			{
				
				if($rsltuserinfo->row(0)->usertype_name == "Admin")
				{
				
					$data = array(
					'adminid' => 1,
					'aloggedin' => true,
					'ausertype' => "Admin",
					'abusinessname' => "Admin",
					'ausername' => "admin",
					'Redirect'=>base_url()."_Admin/site_admin"
					);
					$this->session->set_userdata($data);
					redirect(base_url()."_Admin/Dashboard");
				}
				else if($rsltuserinfo->row(0)->usertype_name == "WEBSITE")	
				{
				   
					$data = array(
					'WebId' => $rsltuserinfo->row(0)->user_id,
					'WebParentId' => $rsltuserinfo->row(0)->parentid,
					'WebLoggedIn' => true,
					'WebUserType' => $rsltuserinfo->row(0)->usertype_name,
					'WebUserName' => $rsltuserinfo->row(0)->username,
					'WebBusinessName' => $rsltuserinfo->row(0)->businessname,
					'WebSchemeId'=>$rsltuserinfo->row(0)->scheme_id,
					'WebGroupName'=>$rsltuserinfo->row(0)->group_name,
					'WebMT_Access'=>$rsltuserinfo->row(0)->mt_access,
					'WebMobile'=>$rsltuserinfo->row(0)->mobile_no,
					'WebBalance'=>$rsltuserinfo->row(0)->balance,
					'Webpostal_address'=>$rsltuserinfo->row(0)->postal_address,
					'Webpincode'=>$rsltuserinfo->row(0)->pincode,
					'Webaadhar_number'=>$rsltuserinfo->row(0)->aadhar_number,
					'Webpan_no'=>$rsltuserinfo->row(0)->pan_no,
					'Webgst_no'=>$rsltuserinfo->row(0)->gst_no,
					'Webemailid'=>$rsltuserinfo->row(0)->emailid,
					'AdminId'=>1,
					'ReadOnly'=>false,
					'Redirect'=>base_url()."WEB/Home",
					);
					$this->session->set_userdata($data);
					redirect(base_url()."WEB/Home");
					 
				}
				else if($rsltuserinfo->row(0)->usertype_name == "Agent")	
				{
				   

					$terms_and_conditions = $rsltuserinfo->row(0)->terms_and_conditions;
					$kyc = $rsltuserinfo->row(0)->kyc;
					$web_logintoken = $rsltuserinfo->row(0)->web_logintoken;
					if($terms_and_conditions == "yes" and $kyc == "yes")
					{

						//set_cookie('AUTHENTICATE',"asdfasdfasdfsdf",time()+86400); 

						$client_cookie = $this->input->cookie('AUTHENTICATE', TRUE);


						//echo $client_cookie."|".$web_logintoken;exit;

						if($client_cookie == $web_logintoken)
						//if(true)
						{
							$data = array(
							'AgentId' => $rsltuserinfo->row(0)->user_id,
							'AgentParentId' => $rsltuserinfo->row(0)->parentid,
							'AgentLoggedIn' => true,
							'AgentUserType' => $rsltuserinfo->row(0)->usertype_name,
							'AgentUserName' => $rsltuserinfo->row(0)->username,
							'AgentBusinessName' => $rsltuserinfo->row(0)->businessname,
							'AgentSchemeId'=>$rsltuserinfo->row(0)->scheme_id,
							'AgentGroupName'=>$rsltuserinfo->row(0)->group_name,
							'AgentMT_Access'=>$rsltuserinfo->row(0)->mt_access,
							'AgentMobile'=>$rsltuserinfo->row(0)->mobile_no,
							'AgentBalance'=>$rsltuserinfo->row(0)->balance,
							'Agentpostal_address'=>$rsltuserinfo->row(0)->postal_address,
							'Agentpincode'=>$rsltuserinfo->row(0)->pincode,
							'Agentaadhar_number'=>$rsltuserinfo->row(0)->aadhar_number,
							'Agentpan_no'=>$rsltuserinfo->row(0)->pan_no,
							'Agentgst_no'=>$rsltuserinfo->row(0)->gst_no,
							'Agentemailid'=>$rsltuserinfo->row(0)->emailid,
							'AdminId'=>1,
							'ReadOnly'=>false,
							'Redirect'=>base_url()."Retailer/Dashboard",
							);
							$this->session->set_userdata($data);


							$this->db->query("insert into tbllogin_history(user_id,add_date,ipaddress) values(?,?,?)",
												array($rsltuserinfo->row(0)->user_id,$this->common->getDate(),$this->common->getRealIpAddr()));


							redirect(base_url()."Retailer/Dashboard");
						}
						else
						{
							$otp = $this->common->getOTP();
							$this->db->query("update tblusers set login_otp = ? where user_id = ?",array($otp,$rsltuserinfo->row(0)->user_id));
							$otp_msg = 'OTP:'.$otp.' for user verification';
							$this->common->ExecuteSMSApi($rsltuserinfo->row(0)->mobile_no,$otp_msg);

							$cookie_str = $this->Common_methods->generateRandomString(32);
							$cookie= array(

						           'name'   => 'AUTHOTP_COOKIE',
						           'value'  => $cookie_str,                            
						           'expire' => 600,                                                               
						           'secure' => FALSE

						       );

					        $this->input->set_cookie($cookie);

					        $this->db->query("insert into login_attempts(user_id,otp,AUTHOTP_COOKIE,add_date,ipaddress) values(?,?,?,?,?)",array($rsltuserinfo->row(0)->user_id,$otp,$cookie_str,$this->common->getDate(),$this->common->getRealIpAddr()));
					        $insert_id = $this->db->insert_id();
							$this->view_data["UserId"] = $this->Common_methods->encrypt($rsltuserinfo->row(0)->user_id);
							$this->view_data["insert_id"] = $this->Common_methods->encrypt($insert_id);
							$this->view_data["message"] = "";
							$this->load->view("VerifyOtp_view",$this->view_data);
						}
					}
					else
					{
						$data = array(
							'TempAgentId' => $rsltuserinfo->row(0)->user_id,
							'TempAgentParentId' => $rsltuserinfo->row(0)->parentid,
							'TempAgentLoggedIn' => true,
							'TempAgentUserType' => $rsltuserinfo->row(0)->usertype_name,
							'TempAgentUserName' => $rsltuserinfo->row(0)->username,
							'TempAgentBusinessName' => $rsltuserinfo->row(0)->businessname,
							'TempAgentSchemeId'=>$rsltuserinfo->row(0)->scheme_id,
							'TempAgentGroupName'=>$rsltuserinfo->row(0)->group_name,
							'TempAgentMT_Access'=>$rsltuserinfo->row(0)->mt_access,
							'TempAgentMobile'=>$rsltuserinfo->row(0)->mobile_no,
							'TempAgentBalance'=>$rsltuserinfo->row(0)->balance,
							'TempAgentpostal_address'=>$rsltuserinfo->row(0)->postal_address,
							'TempAgentpincode'=>$rsltuserinfo->row(0)->pincode,
							'TempAgentaadhar_number'=>$rsltuserinfo->row(0)->aadhar_number,
							'TempAgentpan_no'=>$rsltuserinfo->row(0)->pan_no,
							'TempAgentgst_no'=>$rsltuserinfo->row(0)->gst_no,
							'TempAgentemailid'=>$rsltuserinfo->row(0)->emailid,
							'TempAdminId'=>1,
							'TempReadOnly'=>false
							);
							$this->session->set_userdata($data);

							if($terms_and_conditions == "yes")
							{
								redirect(base_url()."kycrequest");
							}
							else
							{
								redirect(base_url()."TermsAndConditions");
							}

							
					}


					
					 
				}
				else if($rsltuserinfo->row(0)->usertype_name == "Distributor")	
				{
					//print_r("herer");exit;
					$terms_and_conditions = $rsltuserinfo->row(0)->terms_and_conditions;
					$kyc = $rsltuserinfo->row(0)->kyc;
					$web_logintoken = $rsltuserinfo->row(0)->web_logintoken;

					$client_cookie = $this->input->cookie('AUTHENTICATE', TRUE);
					if($client_cookie == $web_logintoken)
					{
						$data = array(
						'DistId' => $rsltuserinfo->row(0)->user_id,
						'DistParentId' => $rsltuserinfo->row(0)->parentid,
						'DistLoggedIn' => true,
						'DistUserType' => $rsltuserinfo->row(0)->usertype_name,
						'DistUserName' => $rsltuserinfo->row(0)->username,
						'DistBusinessName' => $rsltuserinfo->row(0)->businessname,
						'DistSchemeId'=>$rsltuserinfo->row(0)->scheme_id,
						'DistGroupName'=>$rsltuserinfo->row(0)->group_name,
						'DistMT_Access'=>$rsltuserinfo->row(0)->mt_access,
						'DistMobile'=>$rsltuserinfo->row(0)->mobile_no,
						'DistBalance'=>$rsltuserinfo->row(0)->balance,
						'Distpostal_address'=>$rsltuserinfo->row(0)->postal_address,
						'Distpincode'=>$rsltuserinfo->row(0)->pincode,
						'Distaadhar_number'=>$rsltuserinfo->row(0)->aadhar_number,
						'Distpan_no'=>$rsltuserinfo->row(0)->pan_no,
						'Distgst_no'=>$rsltuserinfo->row(0)->gst_no,
						'Distemailid'=>$rsltuserinfo->row(0)->emailid,
						'AdminId'=>1,
						'ReadOnly'=>false,
						'Redirect'=>base_url()."Distributor_new/Dashboard",
						);
						
						$this->session->set_userdata($data);
						redirect(base_url()."Distributor_new/Dashboard");
					}
					else
					{
						$otp = $this->common->getOTP();
						$this->db->query("update tblusers set login_otp = ? where user_id = ?",array($otp,$rsltuserinfo->row(0)->user_id));
						$otp_msg = 'OTP:'.$otp.' for user verification';
						$this->common->ExecuteSMSApi($rsltuserinfo->row(0)->mobile_no,$otp_msg);

						$cookie_str = $this->Common_methods->generateRandomString(32);
						$cookie= array(

					           'name'   => 'AUTHOTP_COOKIE',
					           'value'  => $cookie_str,                            
					           'expire' => 600,                                                               
					           'secure' => FALSE

					       );

				        $this->input->set_cookie($cookie);

				        $this->db->query("insert into login_attempts(user_id,otp,AUTHOTP_COOKIE,add_date,ipaddress) values(?,?,?,?,?)",array($rsltuserinfo->row(0)->user_id,$otp,$cookie_str,$this->common->getDate(),$this->common->getRealIpAddr()));
				        $insert_id = $this->db->insert_id();
						$this->view_data["UserId"] = $this->Common_methods->encrypt($rsltuserinfo->row(0)->user_id);
						$this->view_data["insert_id"] = $this->Common_methods->encrypt($insert_id);
						$this->view_data["message"] = "";
						$this->load->view("VerifyOtp_view",$this->view_data);
					}
				}
				else if($rsltuserinfo->row(0)->usertype_name == "FOS")	
				{
					   
					$data = array(
					'FOSId' => $rsltuserinfo->row(0)->user_id,
					'FOSParentId' => $rsltuserinfo->row(0)->parentid,
					'FOSLoggedIn' => true,
					'FOSUserName' => $rsltuserinfo->row(0)->username,
					'FOSUserType' => $rsltuserinfo->row(0)->usertype_name,
					'FOSBusinessName' => $rsltuserinfo->row(0)->businessname,
					'FOSSchemeId'=>$rsltuserinfo->row(0)->scheme_id,
					'AdminId'=>1,
					'ReadOnly'=>false,
					'Redirect'=>base_url()."FOS/agent_list",
					);
					 
					$this->session->set_userdata($data);
					redirect(base_url()."FOS/agent_list");
					 
				}
				else if($rsltuserinfo->row(0)->usertype_name == "MasterDealer")	
				{
					  
					$data = array(
					'MdId' => $rsltuserinfo->row(0)->user_id,
					'MdParentId' => $rsltuserinfo->row(0)->parentid,
					'MdLoggedIn' => true,
					'MdUserType' => $rsltuserinfo->row(0)->usertype_name,
					'MdUserName' => $rsltuserinfo->row(0)->username,
					'MdBusinessName' => $rsltuserinfo->row(0)->businessname,
					'MdSchemeId'=>$rsltuserinfo->row(0)->scheme_id,
					'MdGroupName'=>$rsltuserinfo->row(0)->group_name,
					'MdMT_Access'=>$rsltuserinfo->row(0)->mt_access,
					'MdMobile'=>$rsltuserinfo->row(0)->mobile_no,
					'MdBalance'=>$rsltuserinfo->row(0)->balance,
					'Mdpostal_address'=>$rsltuserinfo->row(0)->postal_address,
					'Mdpincode'=>$rsltuserinfo->row(0)->pincode,
					'Mdaadhar_number'=>$rsltuserinfo->row(0)->aadhar_number,
					'Mdpan_no'=>$rsltuserinfo->row(0)->pan_no,
					'Mdgst_no'=>$rsltuserinfo->row(0)->gst_no,
					'Mdemailid'=>$rsltuserinfo->row(0)->emailid,
					'AdminId'=>1,
					'ReadOnly'=>false,
					'Redirect'=>base_url()."MasterDealer_new/Dashboard",
					);
					 $this->session->set_userdata($data);
					redirect(base_url()."MasterDealer_new/Dashboard");
					 
					
				}
				else if($rsltuserinfo->row(0)->usertype_name == "SuperDealer")	
				{
					
					  
					$data = array(
					'SdId' => $rsltuserinfo->row(0)->user_id,
					'SdParentId' => $rsltuserinfo->row(0)->parentid,
					'SdLoggedIn' => true,
					'SdUserType' => $rsltuserinfo->row(0)->usertype_name,
					'SdUserName' => $rsltuserinfo->row(0)->username,
					'SdBusinessName' => $rsltuserinfo->row(0)->businessname,
					'SdSchemeId'=>$rsltuserinfo->row(0)->scheme_id,
					'SdGroupName'=>$rsltuserinfo->row(0)->group_name,
					'SdMT_Access'=>$rsltuserinfo->row(0)->mt_access,
					'SdMobile'=>$rsltuserinfo->row(0)->mobile_no,
					'SdBalance'=>$rsltuserinfo->row(0)->balance,
					'Sdpostal_address'=>$rsltuserinfo->row(0)->postal_address,
					'Sdpincode'=>$rsltuserinfo->row(0)->pincode,
					'Sdaadhar_number'=>$rsltuserinfo->row(0)->aadhar_number,
					'Sdpan_no'=>$rsltuserinfo->row(0)->pan_no,
					'Sdgst_no'=>$rsltuserinfo->row(0)->gst_no,
					'Sdemailid'=>$rsltuserinfo->row(0)->emailid,
					'AdminId'=>1,
					'ReadOnly'=>false,
					'Redirect'=>base_url()."SuperDealer/agent_list",
					);
				
					
					$this->session->set_userdata($data);
					redirect(base_url()."SuperDealer/agent_list");
				}
				else if($rsltuserinfo->row(0)->usertype_name == "APIUSER")
				{
					$data = array(
					'ApiId' => $rsltuserinfo->row(0)->user_id,
					'ApiLoggedIn' => true,
					'ApiSchemeId'=>$rsltuserinfo->row(0)->scheme_id,
					'ApiUserType' => $rsltuserinfo->row(0)->usertype_name,
					'ApiBusinessName' => $rsltuserinfo->row(0)->businessname,
					'ApiUserName' => $rsltuserinfo->row(0)->mobile_no,
					'ApiEmail' => $rsltuserinfo->row(0)->emailid,
					'ApiPostalAddress' => $rsltuserinfo->row(0)->postal_address,
					'AdminId'=>1,
					);
					$this->session->set_userdata($data);
					redirect(base_url()."API/recharge_history");
				}
				else
				{
					redirect(base_url()."login");
				}
				
			}
			else
			{
				redirect(base_url()."login");
			}
			
		}
		else if(isset($_POST["txtOtp"]) and isset($_POST["hidCrypt"]))
		{
			$txtOtp = trim($this->input->post("txtOtp"));
			$login_attempt_id = $this->Common_methods->decrypt(trim($this->input->post("hidCrypt")));
			$hidUid = $this->Common_methods->decrypt(trim($this->input->post("hidUid")));
			$auth_cookie = $this->input->cookie('AUTHOTP_COOKIE', TRUE);




			$rsltLoginAttempt = $this->db->query("select Id,otp,user_id from login_attempts where Id = ? and user_id = ? and status = 'PENDING' and AUTHOTP_COOKIE = ?",array($login_attempt_id,$hidUid,$auth_cookie));
			if($rsltLoginAttempt->num_rows() == 1)
			{
				$Id = $rsltLoginAttempt->row(0)->Id;
				$db_otp = $rsltLoginAttempt->row(0)->otp;
				$user_id = $rsltLoginAttempt->row(0)->user_id;
				if($db_otp == $txtOtp)
				{

					$this->db->query("update login_attempts set status = 'SUCCESS' where Id = ?",array($Id));
					$cookie_str = $this->Common_methods->generateRandomString(32);
					$cookie= array(

						//web_logintoken
				           'name'   => 'AUTHENTICATE',
				           'value'  => $cookie_str,
				           'expire' => time()+86400,                                                               
				           'secure' => FALSE

				       );

			        $this->input->set_cookie($cookie);
			        $this->db->query("update tblusers set web_logintoken = ? where user_id = ?",array($cookie_str,$user_id));


					$rsltuserinfo = $this->db->query("select 
						a.web_logintoken,
						a.kyc,
						a.terms_and_conditions,
						a.parentid,a.username,a.scheme_id,a.user_id,a.businessname,a.usertype_name,a.mobile_no,a.status ,a.mt_access,a.balance,info.pincode,
					info.emailid,info.postal_address,info.aadhar_number,info.pan_no,info.gst_no,g.group_name
					from tblusers a 
					left join tblusers_info info on a.user_id = info.user_id
					left join tblgroup g on a.scheme_id = g.Id
					where a.user_id = ?",array($user_id));
					if($rsltuserinfo->num_rows() == 1)
					{
						
						if($rsltuserinfo->row(0)->usertype_name == "Admin")
						{
							$data = array(
							'adminid' => 1,
							'aloggedin' => true,
							'ausertype' => "Admin",
							'abusinessname' => "Admin",
							'ausername' => "admin",
							'Redirect'=>base_url()."_Admin/site_admin"
							);
							$this->session->set_userdata($data);
							redirect(base_url()."_Admin/Dashboard");
						}
						else if($rsltuserinfo->row(0)->usertype_name == "WEBSITE")	
						{
						   
							$data = array(
							'WebId' => $rsltuserinfo->row(0)->user_id,
							'WebParentId' => $rsltuserinfo->row(0)->parentid,
							'WebLoggedIn' => true,
							'WebUserType' => $rsltuserinfo->row(0)->usertype_name,
							'WebUserName' => $rsltuserinfo->row(0)->username,
							'WebBusinessName' => $rsltuserinfo->row(0)->businessname,
							'WebSchemeId'=>$rsltuserinfo->row(0)->scheme_id,
							'WebGroupName'=>$rsltuserinfo->row(0)->group_name,
							'WebMT_Access'=>$rsltuserinfo->row(0)->mt_access,
							'WebMobile'=>$rsltuserinfo->row(0)->mobile_no,
							'WebBalance'=>$rsltuserinfo->row(0)->balance,
							'Webpostal_address'=>$rsltuserinfo->row(0)->postal_address,
							'Webpincode'=>$rsltuserinfo->row(0)->pincode,
							'Webaadhar_number'=>$rsltuserinfo->row(0)->aadhar_number,
							'Webpan_no'=>$rsltuserinfo->row(0)->pan_no,
							'Webgst_no'=>$rsltuserinfo->row(0)->gst_no,
							'Webemailid'=>$rsltuserinfo->row(0)->emailid,
							'AdminId'=>1,
							'ReadOnly'=>false,
							'Redirect'=>base_url()."WEB/Home",
							);
							$this->session->set_userdata($data);
							redirect(base_url()."WEB/Home");
							 
						}
						else if($rsltuserinfo->row(0)->usertype_name == "Agent")	
						{
						   

							$terms_and_conditions = $rsltuserinfo->row(0)->terms_and_conditions;
							$kyc = $rsltuserinfo->row(0)->kyc;
							$web_logintoken = $rsltuserinfo->row(0)->web_logintoken;
							if($terms_and_conditions == "yes" and $kyc == "yes")
							{

									$data = array(
									'AgentId' => $rsltuserinfo->row(0)->user_id,
									'AgentParentId' => $rsltuserinfo->row(0)->parentid,
									'AgentLoggedIn' => true,
									'AgentUserType' => $rsltuserinfo->row(0)->usertype_name,
									'AgentUserName' => $rsltuserinfo->row(0)->username,
									'AgentBusinessName' => $rsltuserinfo->row(0)->businessname,
									'AgentSchemeId'=>$rsltuserinfo->row(0)->scheme_id,
									'AgentGroupName'=>$rsltuserinfo->row(0)->group_name,
									'AgentMT_Access'=>$rsltuserinfo->row(0)->mt_access,
									'AgentMobile'=>$rsltuserinfo->row(0)->mobile_no,
									'AgentBalance'=>$rsltuserinfo->row(0)->balance,
									'Agentpostal_address'=>$rsltuserinfo->row(0)->postal_address,
									'Agentpincode'=>$rsltuserinfo->row(0)->pincode,
									'Agentaadhar_number'=>$rsltuserinfo->row(0)->aadhar_number,
									'Agentpan_no'=>$rsltuserinfo->row(0)->pan_no,
									'Agentgst_no'=>$rsltuserinfo->row(0)->gst_no,
									'Agentemailid'=>$rsltuserinfo->row(0)->emailid,
									'AdminId'=>1,
									'ReadOnly'=>false,
									'Redirect'=>base_url()."Retailer/Dashboard",
									);
									$this->session->set_userdata($data);
									$this->db->query("insert into tbllogin_history(user_id,add_date,ipaddress) values(?,?,?)",
												array($rsltuserinfo->row(0)->user_id,$this->common->getDate(),$this->common->getRealIpAddr()));
									redirect(base_url()."Retailer/Dashboard");
								
							}
							else
							{
								$data = array(
									'TempAgentId' => $rsltuserinfo->row(0)->user_id,
									'TempAgentParentId' => $rsltuserinfo->row(0)->parentid,
									'TempAgentLoggedIn' => true,
									'TempAgentUserType' => $rsltuserinfo->row(0)->usertype_name,
									'TempAgentUserName' => $rsltuserinfo->row(0)->username,
									'TempAgentBusinessName' => $rsltuserinfo->row(0)->businessname,
									'TempAgentSchemeId'=>$rsltuserinfo->row(0)->scheme_id,
									'TempAgentGroupName'=>$rsltuserinfo->row(0)->group_name,
									'TempAgentMT_Access'=>$rsltuserinfo->row(0)->mt_access,
									'TempAgentMobile'=>$rsltuserinfo->row(0)->mobile_no,
									'TempAgentBalance'=>$rsltuserinfo->row(0)->balance,
									'TempAgentpostal_address'=>$rsltuserinfo->row(0)->postal_address,
									'TempAgentpincode'=>$rsltuserinfo->row(0)->pincode,
									'TempAgentaadhar_number'=>$rsltuserinfo->row(0)->aadhar_number,
									'TempAgentpan_no'=>$rsltuserinfo->row(0)->pan_no,
									'TempAgentgst_no'=>$rsltuserinfo->row(0)->gst_no,
									'TempAgentemailid'=>$rsltuserinfo->row(0)->emailid,
									'TempAdminId'=>1,
									'TempReadOnly'=>false
									);
									$this->session->set_userdata($data);

									if($terms_and_conditions == "yes")
									{
										redirect(base_url()."kycrequest");
									}
									else
									{
										redirect(base_url()."TermsAndConditions");
									}

									
							}


							
							 
						}
						else if($rsltuserinfo->row(0)->usertype_name == "Distributor")	
						{
							   
						$data = array(
							'DistId' => $rsltuserinfo->row(0)->user_id,
							'DistParentId' => $rsltuserinfo->row(0)->parentid,
							'DistLoggedIn' => true,
							'DistUserType' => $rsltuserinfo->row(0)->usertype_name,
							'DistUserName' => $rsltuserinfo->row(0)->username,
							'DistBusinessName' => $rsltuserinfo->row(0)->businessname,
							'DistSchemeId'=>$rsltuserinfo->row(0)->scheme_id,
							'DistGroupName'=>$rsltuserinfo->row(0)->group_name,
							'DistMT_Access'=>$rsltuserinfo->row(0)->mt_access,
							'DistMobile'=>$rsltuserinfo->row(0)->mobile_no,
							'DistBalance'=>$rsltuserinfo->row(0)->balance,
							'Distpostal_address'=>$rsltuserinfo->row(0)->postal_address,
							'Distpincode'=>$rsltuserinfo->row(0)->pincode,
							'Distaadhar_number'=>$rsltuserinfo->row(0)->aadhar_number,
							'Distpan_no'=>$rsltuserinfo->row(0)->pan_no,
							'Distgst_no'=>$rsltuserinfo->row(0)->gst_no,
							'Distemailid'=>$rsltuserinfo->row(0)->emailid,
							'AdminId'=>1,
							'ReadOnly'=>false,
							'Redirect'=>base_url()."Distributor_new/Dashboard",
							);
							
							$this->session->set_userdata($data);
							redirect(base_url()."Distributor_new/Dashboard");
							 
						}
						else if($rsltuserinfo->row(0)->usertype_name == "FOS")	
						{
							   
							$data = array(
							'FOSId' => $rsltuserinfo->row(0)->user_id,
							'FOSParentId' => $rsltuserinfo->row(0)->parentid,
							'FOSLoggedIn' => true,
							'FOSUserName' => $rsltuserinfo->row(0)->username,
							'FOSUserType' => $rsltuserinfo->row(0)->usertype_name,
							'FOSBusinessName' => $rsltuserinfo->row(0)->businessname,
							'FOSSchemeId'=>$rsltuserinfo->row(0)->scheme_id,
							'AdminId'=>1,
							'ReadOnly'=>false,
							'Redirect'=>base_url()."FOS/agent_list",
							);
							 
							$this->session->set_userdata($data);
							redirect(base_url()."FOS/agent_list");
							 
						}
						else if($rsltuserinfo->row(0)->usertype_name == "MasterDealer")	
						{
							  
							$data = array(
							'MdId' => $rsltuserinfo->row(0)->user_id,
							'MdParentId' => $rsltuserinfo->row(0)->parentid,
							'MdLoggedIn' => true,
							'MdUserType' => $rsltuserinfo->row(0)->usertype_name,
							'MdUserName' => $rsltuserinfo->row(0)->username,
							'MdBusinessName' => $rsltuserinfo->row(0)->businessname,
							'MdSchemeId'=>$rsltuserinfo->row(0)->scheme_id,
							'MdGroupName'=>$rsltuserinfo->row(0)->group_name,
							'MdMT_Access'=>$rsltuserinfo->row(0)->mt_access,
							'MdMobile'=>$rsltuserinfo->row(0)->mobile_no,
							'MdBalance'=>$rsltuserinfo->row(0)->balance,
							'Mdpostal_address'=>$rsltuserinfo->row(0)->postal_address,
							'Mdpincode'=>$rsltuserinfo->row(0)->pincode,
							'Mdaadhar_number'=>$rsltuserinfo->row(0)->aadhar_number,
							'Mdpan_no'=>$rsltuserinfo->row(0)->pan_no,
							'Mdgst_no'=>$rsltuserinfo->row(0)->gst_no,
							'Mdemailid'=>$rsltuserinfo->row(0)->emailid,
							'AdminId'=>1,
							'ReadOnly'=>false,
							'Redirect'=>base_url()."MasterDealer/agent_list",
							);
							 $this->session->set_userdata($data);
							redirect(base_url()."MasterDealer/agent_list");
							 
							
						}
						else if($rsltuserinfo->row(0)->usertype_name == "SuperDealer")	
						{
							
							  
							$data = array(
							'SdId' => $rsltuserinfo->row(0)->user_id,
							'SdParentId' => $rsltuserinfo->row(0)->parentid,
							'SdLoggedIn' => true,
							'SdUserType' => $rsltuserinfo->row(0)->usertype_name,
							'SdUserName' => $rsltuserinfo->row(0)->username,
							'SdBusinessName' => $rsltuserinfo->row(0)->businessname,
							'SdSchemeId'=>$rsltuserinfo->row(0)->scheme_id,
							'SdGroupName'=>$rsltuserinfo->row(0)->group_name,
							'SdMT_Access'=>$rsltuserinfo->row(0)->mt_access,
							'SdMobile'=>$rsltuserinfo->row(0)->mobile_no,
							'SdBalance'=>$rsltuserinfo->row(0)->balance,
							'Sdpostal_address'=>$rsltuserinfo->row(0)->postal_address,
							'Sdpincode'=>$rsltuserinfo->row(0)->pincode,
							'Sdaadhar_number'=>$rsltuserinfo->row(0)->aadhar_number,
							'Sdpan_no'=>$rsltuserinfo->row(0)->pan_no,
							'Sdgst_no'=>$rsltuserinfo->row(0)->gst_no,
							'Sdemailid'=>$rsltuserinfo->row(0)->emailid,
							'AdminId'=>1,
							'ReadOnly'=>false,
							'Redirect'=>base_url()."SuperDealer/agent_list",
							);
						
							
							$this->session->set_userdata($data);
							redirect(base_url()."SuperDealer/agent_list");
						}
						else if($rsltuserinfo->row(0)->usertype_name == "APIUSER")
						{
							$data = array(
							'ApiId' => $rsltuserinfo->row(0)->user_id,
							'ApiLoggedIn' => true,
							'ApiSchemeId'=>$rsltuserinfo->row(0)->scheme_id,
							'ApiUserType' => $rsltuserinfo->row(0)->usertype_name,
							'ApiBusinessName' => $rsltuserinfo->row(0)->businessname,
							'ApiUserName' => $rsltuserinfo->row(0)->mobile_no,
							'ApiEmail' => $rsltuserinfo->row(0)->emailid,
							'ApiPostalAddress' => $rsltuserinfo->row(0)->postal_address,
							'AdminId'=>1,
							);
							$this->session->set_userdata($data);
							redirect(base_url()."API/recharge_history");
						}
						else
						{
							redirect(base_url()."login");
						}
						
					}
					else
					{
						redirect(base_url()."login");
					}		
				}
			}
			else
			{
				redirect(base_url()."login");
			}


			echo $txtOtp."   ".$hidCrypt."   ".$hidUid."   ".$auth_cookie;exit;
			print_r($this->input->post());exit;

		}
		else
		{
			$this->load->view("Login_view");
		}
	}	
}
