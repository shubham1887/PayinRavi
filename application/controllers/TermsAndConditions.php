<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TermsAndConditions extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('TempAgentUserType') != "Agent") 
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
    public function gethoursbetweentwodates($fromdate,$todate)
	{
		 $now_date = strtotime (date ($todate)); // the current date 
		$key_date = strtotime (date ($fromdate));
		$diff = $now_date - $key_date;
		return round(abs($diff) / 60,2);
	}
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('TempAgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	

			if(isset($_POST["accept_terms"]) )
			{

				$user_id = $this->session->userdata("TempAgentId");
				$accept_terms = $this->input->post("accept_terms");
				
				if($accept_terms == "yes")
				{
					$this->db->query("update tblusers set terms_and_conditions = 'yes' where user_id = ?",array($user_id));
					$user_info = $this->db->query("select kyc,terms_and_conditions from tblusers where user_id = ?",array($user_id));
					$kyc = $user_info->row(0)->kyc;
					if($kyc == "yes")
					{
						$rsltuserinfo = $this->db->query("select 
											a.kyc,
											a.terms_and_conditions,
											a.parentid,a.username,a.scheme_id,a.user_id,a.businessname,a.usertype_name,a.mobile_no,a.status ,a.mt_access,a.balance,info.pincode,
										info.emailid,info.postal_address,info.aadhar_number,info.pan_no,info.gst_no,g.group_name
										from tblusers a 
										left join tblusers_info info on a.user_id = info.user_id
										left join tblgroup g on a.scheme_id = g.Id
										where a.user_id = ? and a.usertype_name = 'Agent'",array($user_id));
						if($rsltuserinfo->num_rows() == 1)
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
							'AgentKyc' => $rsltuserinfo->row(0)->kyc,
							'Agentterms_and_conditions' => $rsltuserinfo->row(0)->terms_and_conditions,
							'AdminId'=>1,
							'ReadOnly'=>false,
							'Redirect'=>base_url()."Retailer/recharge_home",
							);
							$this->session->set_userdata($data);
							redirect(base_url()."Retailer/recharge_home");
						}
					}
					else
					{
						redirect(base_url()."kycrequest");	
					}
					
				}
				else
				{
					redirect(base_url()."TermsAndConditions");
				}
			}					
			
			else
			{
				$user=$this->session->userdata('TempAgentUserType');
				if(trim($user) == 'Agent')
				{
					$user_id = $this->session->userdata("TempAgentId");
					$user_info = $this->db->query("select terms_and_conditions from tblusers where user_id = ?",array($user_id));
					$terms_and_conditions = $user_info->row(0)->terms_and_conditions;
					$this->view_data["message"] = "";
					$this->view_data["terms_and_conditions"] = $terms_and_conditions;
					$this->load->view("TermsAndConditions_view",$this->view_data);
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}
}