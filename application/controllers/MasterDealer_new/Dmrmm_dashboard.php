<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmrmm_dashboard extends CI_Controller {
	
	
	private $msg='';
	
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
    } 
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
				$this->output->set_header("Pragma: no-cache"); 
				
		/*$userinfo = $this->db->query("select mt_accept,mt_transo from tblusers where user_id = ?",array($this->session->userdata("MdId")));
		if($userinfo->row(0)->mt_transo != 'yes')
		{
			redirect(base_url()."Retailer/recharge_home");
		}
		if ($this->session->userdata('MT_LOGGED_IN') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}*/
		
		if($this->input->post("txtMobileNO"))
		{
			
				//$SessionID = $this->session->userdata("SessionID");
			
				//$ResponseCode = $this->session->userdata("ResponseCode");
				//$ResponseMessage = $this->session->userdata("ResponseMessage");
				//$MT_USER_ID = $this->session->userdata("MT_USER_ID");
				$txtMobileNo = $this->input->post("txtMobileNO");
				
				$user_id = $this->session->userdata("MdId");
				$userinfo = $this->db->query("select user_id,usertype_name,status,username from tblusers where user_id = ? order by user_id",array($user_id));
				
				
			    $this->load->model("Mastermoney");
				$resp = $this->Mastermoney->remitter_details($txtMobileNo,$userinfo);
              
				$jsonobj = json_decode($resp);

				if(isset($jsonobj->message) and isset($jsonobj->status) and isset($jsonobj->statuscode))
				{
					$message = trim((string)$jsonobj->message);
					$status = trim((string)$jsonobj->status);
					$statuscode = trim((string)$jsonobj->statuscode);
					if($status == "0" and $statuscode == "37")
					{

						//resend otp here
						$respresendotp = $this->Eko->resend_otp($txtMobileNo,$userinfo);
						$jsonobj1 = json_decode($respresendotp);

						if(isset($jsonobj1->message) and isset($jsonobj1->status) and isset($jsonobj1->statuscode))
						{
							$message1 = trim((string)$jsonobj1->message);
							$status1 = trim((string)$jsonobj1->status);
							$statuscode1 = trim((string)$jsonobj1->statuscode);

							if($status1 == "0" and  $statuscode1 == "321")
							{
								$this->session->set_userdata("SenderMobile",$txtMobileNo);
								$this->session->set_userdata("MT_USER_ID",$user_id);
								redirect(base_url()."Retailer/validate_sender?crypt=".$this->Common_methods->encrypt("dmr2_dashboard"));
							}
						}
					}
					else if($status == "0")
					{
					   
                       
							$data = $jsonobj->data;
							$beneficiary = $jsonobj->beneficiary;
							
							$this->session->set_userdata("SenderMobile",$txtMobileNo);
							$this->session->set_userdata("MT_USER_ID",$user_id);
							$this->session->set_userdata("MT_LOGGED_IN",TRUE);
						
							$this->view_data["benelist"] = $beneficiary;
							$this->view_data["data"] = $data;
							$this->load->view("MasterDealer_new/dmrmm_dashboard_view",$this->view_data);


					}
				}
			
		}
		
		else
		{
			$txtMobileNo = $this->session->userdata("SenderMobile");
			$MT_LOGGED_IN = $this->session->userdata("MT_LOGGED_IN");
			if($MT_LOGGED_IN == true)
			{
			
					$user_id = $this->session->userdata("MdId");
					$userinfo = $this->db->query("select user_id,usertype_name,status,username from tblusers where user_id = ?",array($user_id));
                   // if($userinfo->row(0)->username == "110001")
                   if(true)
                    {
                       
                        $this->load->model("Mastermoney");
    					$resp = $this->Mastermoney->remitter_details($txtMobileNo,$userinfo);
                      
    					$jsonobj = json_decode($resp);
    
    					if(isset($jsonobj->message) and isset($jsonobj->status) and isset($jsonobj->statuscode))
    					{
    						$message = trim((string)$jsonobj->message);
    						$status = trim((string)$jsonobj->status);
    						$statuscode = trim((string)$jsonobj->statuscode);
    						if($status == "0" and $statuscode == "37")
    						{
    
    							//resend otp here
    							$respresendotp = $this->Mastermoney->resend_otp($txtMobileNo,$userinfo);
    							$jsonobj1 = json_decode($respresendotp);
    
    							if(isset($jsonobj1->message) and isset($jsonobj1->status) and isset($jsonobj1->statuscode))
    							{
    								$message1 = trim((string)$jsonobj1->message);
    								$status1 = trim((string)$jsonobj1->status);
    								$statuscode1 = trim((string)$jsonobj1->statuscode);
    
    								if($status1 == "0" and  $statuscode1 == "321")
    								{
    									$this->session->set_userdata("SenderMobile",$txtMobileNo);
    									$this->session->set_userdata("MT_USER_ID",$user_id);
    									redirect(base_url()."Retailer/validate_sender?crypt=".$this->Common_methods->encrypt("dmr2_dashboard"));
    								}
    							}
    						}
    						else if($status == "0")
    						{
    						   
                               
    								$data = $jsonobj->remitter;
    								$beneficiary = $jsonobj->beneficiary;
    								
    								$this->session->set_userdata("SenderMobile",$txtMobileNo);
    								$this->session->set_userdata("MT_USER_ID",$user_id);
    								$this->session->set_userdata("MT_LOGGED_IN",TRUE);
    							
    								$this->view_data["benelist"] = $beneficiary;
    								$this->view_data["data"] = $data;
    								$this->load->view("MasterDealer_new/dmrmm_dashboard_view",$this->view_data);
    
    
    						}
    					}
                    }
                    else
                    {
                        $this->load->model("Eko");
    					$resp = $this->Eko->remitter_details($txtMobileNo,$userinfo);
    
    					$jsonobj = json_decode($resp);
    
    					if(isset($jsonobj->message) and isset($jsonobj->status) and isset($jsonobj->statuscode))
    					{
    						$message = trim((string)$jsonobj->message);
    						$status = trim((string)$jsonobj->status);
    						$statuscode = trim((string)$jsonobj->statuscode);
    						if($status == "0" and $statuscode == "37")
    						{
    
    							//resend otp here
    							$respresendotp = $this->Eko->resend_otp($txtMobileNo,$userinfo);
    							$jsonobj1 = json_decode($respresendotp);
    
    							if(isset($jsonobj1->message) and isset($jsonobj1->status) and isset($jsonobj1->statuscode))
    							{
    								$message1 = trim((string)$jsonobj1->message);
    								$status1 = trim((string)$jsonobj1->status);
    								$statuscode1 = trim((string)$jsonobj1->statuscode);
    
    								if($status1 == "0" and  $statuscode1 == "321")
    								{
    									$this->session->set_userdata("SenderMobile",$txtMobileNo);
    									$this->session->set_userdata("MT_USER_ID",$user_id);
    									redirect(base_url()."Retailer/validate_sender?crypt=".$this->Common_methods->encrypt("dmr2_dashboard"));
    								}
    							}
    						}
    						else if($status == "0")
    						{
    
    								$data = $jsonobj->data;
    								$this->session->set_userdata("SenderMobile",$txtMobileNo);
    								$this->session->set_userdata("MT_USER_ID",$user_id);
    								$this->session->set_userdata("MT_LOGGED_IN",TRUE);
    							
    								//get beneficiary detail
    								$respbene = $this->Eko->get_sender_bene($txtMobileNo,$userinfo);
    								$jsonobj_bene = json_decode($respbene);
    								
    							
    								$this->view_data["benelist"] = $jsonobj_bene;
    								$this->view_data["data"] = $data;
    								$this->load->view("MasterDealer_new/dmr2_dashboard_view",$this->view_data);
    
    
    						}
    					}
                    }

					
		
			}
			else
			{
				redirect(base_url()."Retailer/recharge_home?idstr=".$this->Common_methods->encrypt("Ravikant"));
			}
			
		}
		
			 
	}	
	public function getAccountvalidate()
	{
		$user_id = $this->session->userdata("MdId");
		$MTLOGIN = $this->session->userdata("MTLOGIN");
		$MTSENDERMOBILE = $this->Common_methods->decrypt($this->session->userdata("MTSENDERMOBILE"));
		$SenderMobile = $this->session->userdata("SenderMobile");
		
		$MTMdId = $this->Common_methods->decrypt($this->session->userdata("MTMdId"));
		if(isset($_POST["bid"]))
		{
			$beneid = trim($_POST["bid"]);
		//	echo $beneid;exit;
			$checkbeneexist = $this->db->query("select * from mt3_beneficiary_register_temp 
																	where RESP_beneficiary_id = ? and status = 'SUCCESS' 
																	order by Id desc limit 1",array(
																	$beneid));
																	
			//print_r($checkbeneexist->result());exit;
																
			if($checkbeneexist->num_rows() > 0)
			{
				
				$remitter_mobile = $checkbeneexist->row(0)->remitter_mobile;
			
				$benificiary_account_no = $checkbeneexist->row(0)->benificiary_account_no;
				$benificiary_ifsc = $checkbeneexist->row(0)->benificiary_ifsc;
				$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
				
			
			       $rsltsinfo = $this->db->query("SELECT * FROM `mt3_beneficiary_register_temp` where benificiary_ifsc = ? and benificiary_account_no = ? and API = 'MASTERMONEY' and remitter_mobile = ? and status = 'SUCCESS' order by Id desc limit 1",array($benificiary_ifsc,$benificiary_account_no,$remitter_mobile));
			      
				   if($rsltsinfo->num_rows() == 1)
				   {
				       
				      
				       $remitter_mobile = $rsltsinfo->row(0)->remitter_mobile;
				       $beneid = $RESP_beneficiary_id = $rsltsinfo->row(0)->RESP_beneficiary_id;
    				   $userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
        			   $this->load->model("Mastermoney");
        			   //echo $remitter_mobile." ".$benificiary_account_no." ".$benificiary_ifsc." ".$beneid;exit;
        			   echo $this->Mastermoney->verify_bene($SenderMobile,$benificiary_account_no,$benificiary_ifsc,$beneid,$userinfo);
				   } 
				   
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
	private function loging($Method,$data)
	{
	    return "";
		$date = $this->common->getMySqlDate();
		$filename ="./MTXML/".$Method.$date.".xml";
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
	
    public function checkduplicate($user_id,$number)
    {
    	$add_date = $this->common->getMySqlDate();
    	$ip ="asdf";
    	$rslt = $this->db->query("insert into tbremoveduplication (user_id,add_date,number,ip) values(?,?,?,?)",array($user_id,$add_date,$number,$ip));
    	  if($rslt == "" or $rslt == NULL)
    	  {
    		return false;
    	  }
    	  else
    	  {
    	  	return true;
    	  }
    }
	public function checksender_mastermoney()
	{
	    
	    
	   //  echo "yes";exit;
	        $MTSENDERMOBILE = $this->session->userdata("SenderMobile");
	       // echo $MTSENDERMOBILE;exit;
	        $this->load->model("Mastermoney");
    	    $user_id = $this->session->userdata("MdId");
    	    
    	    /*if($this->checkduplicate($MTSENDERMOBILE,"PAYTMOTP") == false)
    	    {
    	        echo "yes";exit;
    	    }*/
    	    
    	    $userinfo = $this->db->query("select a.user_id,a.businessname,a.username,a.status,a.usertype_name,a.mobile_no,a.parentid,a.mt_access,a.txn_password,a.service,p.client_ip as mastermoney from tblusers a left join tblusers p on a.parentid = p.user_id where a.user_id = ?",array($user_id));
    	    
    	    if($userinfo->num_rows() == 1)
    	    {
    	        $mastermoney = $userinfo->row(0)->mastermoney;
    	        if($mastermoney == '1')
    	        {
    	            $resp = $this->Mastermoney->checksenderexist_yes_no($MTSENDERMOBILE,$userinfo);
    	          
    	            echo $resp;        
    	        }
    	        else
    	        {
    	            echo "yes";
    	        }
    	    }
	    
	    
	}
	public function sendererg_mastermoney()
	{
	    if(isset($_POST["OTP"]))
	    {
	        $SenderMobile = $this->session->userdata("SenderMobile");
	        $otp = trim($_POST["OTP"]);
	        
	        $Remitterinfo = $this->db->query("select * from mt3_remitter_registration where mobile = ?",array($SenderMobile));
	       
	        if($Remitterinfo->num_rows() >= 1)
	        {
	            $this->load->model("Mastermoney");
	            $name = $Remitterinfo->row(0)->name;
	            $lastname = $Remitterinfo->row(0)->lastname;
	            $pincode = $Remitterinfo->row(0)->pincode;
	            $user_id = $this->session->userdata("MdId");
        	    $userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
        	 
    	        echo $this->Mastermoney->remitter_registration($SenderMobile,$name,$lastname,$pincode,$otp,$userinfo);
    	        
    	        
	        }
	        else
	        {
	            echo "NO";
	        }
	    }
	    else
	    {
	        echo "NO";
	    }
	}
	
}