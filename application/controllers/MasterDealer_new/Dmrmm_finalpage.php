<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmrmm_finalpage extends CI_Controller {


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
	   $this->db->db_debug = TRUE;
	   error_reporting(-1);
	   ini_set("display_errors",1);
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('MdUserType') != "MasterDealer") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			$MTLOGIN = $this->session->userdata("MT_LOGGED_IN");
			$MTSENDERMOBILE = $this->session->userdata("SenderMobile");
			$MTMdId = $this->session->userdata("MT_USER_ID");
			$user_id = $this->session->userdata("MdId");
			
			
			if($MTLOGIN == true and $MTMdId == $user_id and strlen($MTSENDERMOBILE) == 10)
			{
			    $mt_rslt = 	$userinfo = $this->db->query("select a.user_id,a.businessname,a.username,a.status,a.usertype_name,a.mobile_no,a.parentid,a.mt_access,a.txn_password,a.service,p.client_ip as mastermoney from tblusers a left join tblusers p on a.parentid = p.user_id where a.user_id = ?",array($user_id));
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
						//	$userinfo = $this->db->query("select user_id,parentid,businessname,username,status,usertype_name,mobile_no from tblusers where user_id = ?",array($user_id));
							if($userinfo->num_rows() == 1)
							{
							    $is_mastermoney = $userinfo->row(0)->mastermoney;
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
											$lastdmtuniqueid = $this->Common_methods->decrypt($this->input->get("crypt"));
											$success  = 0;
											$pending=0;
											$failure = 0;
											$total = 0;
											$alertclass = "";
											$alert_message = "";
											
											$rsltdata = $this->db->query("select * from mt3_transfer where unique_id = ? and user_id = ?",array($lastdmtuniqueid,$user_id));
											if($rsltdata->num_rows() >= 1)
											{
											    foreach($rsltdata->result() as $rw_s)
											    {
											        $status = $rw_s->Status;
											        if($status == "SUCCESS")
											        {
											            $success += $rw_s->Amount;
											        }
											        if($status == "PENDING")
											        {
											            $pending = $rw_s->Amount;
											        }
											        if($status == "FAILURE")
											        {
											            $failure = $rw_s->Amount;
											        }
											        $total += $rw_s->Amount;
											    }
											    if($total == $failure)
											    {
											        $alertclass = "danger";
											        $alert_message = "Transaction Failed";
											    }
											    else if($success > 0)
											    {
											        $alertclass = "success";
											        $alert_message = "Transaction Successfully Done";
											    }
											    else
											    {
											        $alertclass = "primary";
											        $alert_message = "Transactions Under Process";
											    }
											}
						                    $this->view_data["data"]=	$rsltdata;
						                    $this->view_data["alertclass"]=	$alertclass;
						                    $this->view_data["alert_message"]=	$alert_message;
						                    $this->load->view("MasterDealer_new/dmrmm_finalpage_view",$this->view_data);
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
						$this->session->set_userdata("MTMdId","");
						$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
						$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Unauthorized Access");
						redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("Mydata"));
					}
				}
				else
				{
					$this->session->set_userdata("MTLOGIN",false);
					$this->session->set_userdata("MTSENDERMOBILE","");
					$this->session->set_userdata("MTMdId","");
					$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
					$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Unauthorized Access");
					redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("Mydata"));
				}
			}
			else
			{
				$this->session->set_userdata("MTLOGIN",false);
				$this->session->set_userdata("MTSENDERMOBILE","");
				$this->session->set_userdata("MTMdId","");
				$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
				$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: User Data Not Match");
				redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("Mydata"));
			}	
		}
	}
}	