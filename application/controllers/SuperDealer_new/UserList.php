<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class UserList extends CI_Controller {
	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
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
	public function index()
	{						
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}  
		else 
		{ 
			$data['message']='';	

			if($this->input->post("btnSubmit"))
			{
	
				$distributer_name = $this->input->post("txtDistname",TRUE);
				$parentid =  $this->session->userdata("SdId");	
				$username = $this->input->post("txtMobNo",TRUE);	
				$pan_no = $this->input->post("txtpanNo",TRUE);	
				$aadhar = $this->input->post("txtAadhar",TRUE);	
				$gst = $this->input->post("txtGst",TRUE);	
				$contact_person = $this->input->post("txtConPer",TRUE);
				$postal_address = $this->input->post("txtPostalAddr",TRUE);				
				$pincode = $this->input->post("txtPin",TRUE);
				$state_id = $this->input->post("ddlState",TRUE);
				$city_id = $this->input->post("ddlCity",TRUE);				
				$mobile_no = $this->input->post("txtMobNo",TRUE);
				$txtBDate = $this->input->post("txtBDate",TRUE);
				$emailid = $this->input->post("txtEmail",TRUE);				
				$stateCode = $this->input->post("hidStateCode",TRUE);
				$scheme_id = $this->input->post("ddlSchDesc",TRUE);												
				$downline_scheme = 0;	
				$downline_scheme2 = 0;	
				$usertype_name = "Agent";
				$status = 0;
			
				$password = $this->common->GetPassword();
				if($this->Common_methods->findMobileExists($mobile_no))
				{	
					
						$response = $this->Insert_model->tblusers_registration_Entry($parentid,$distributer_name,$postal_address,$pincode,$state_id,$city_id,$contact_person,$mobile_no,$emailid,$usertype_name,$status,$scheme_id,$username,$password,$aadhar,$pan_no,$gst,$downline_scheme,0,$txtBDate);
						
						$jsonobj = json_decode($response);
						
						if(isset($jsonobj->message) and isset($jsonobj->status))
						{ 
							$message = trim((string)$jsonobj->message);
							$status = trim((string)$jsonobj->status);
							if($status == "0")
							{
								$this->session->set_flashdata('MESSAGEBOXTYPE', "success");
								$this->session->set_flashdata('MESSAGEBOX', $message);
								redirect("Distributor/agent_registration");
							}
							else
							{
								$this->session->set_flashdata('MESSAGEBOXTYPE', "warning");
								$this->session->set_flashdata('MESSAGEBOX', $message);
								redirect("Distributor/agent_registration");
							}
						}
				}
				else //If mobile no exist then Give message
				{	
					$reg_data = array(
					'distributer_name'=>$distributer_name,
					'username'=>$username ,
					'parentid'=>$parentid ,
					'pan_no'=>$pan_no,
					'aadhar'=>$aadhar,
					'gst'=>$gst,
					'contact_person'=>$contact_person,
					'postal_address'=>$postal_address,
					'pincode'=>$pincode,
					'state_id'=>$state_id,
					'city_id'=>$city_id,
					'mobile_no'=>$mobile_no,
					'emailid'=>$emailid,
					'stateCode'=>$stateCode,
					'scheme_id'=>$scheme_id,
				);	
					$data['flag'] = 'mobileExist';
					$data['regData'] = $reg_data;					
					$data['message'] = $mobile_no." - Mobile no already registered.";
					$data['MESSAGEBOXTYPE'] = "danger";
					$data['MESSAGEBOX'] =  $mobile_no." - Mobile no already registered.";
				
					$this->load->view('SuperDealer_new/agent_registration_view',$data);
				}
			
			}
			else
			{
				$this->view_data['result_dealer'] = $this->db->query("
		select 
		a.user_id,
		a.parentid,
		a.businessname,
		a.mobile_no,
		a.usertype_name,
		a.add_date,
		a.status,
		a.username,
		a.password,
		a.txn_password,
		a.kyc,
		state.state_name,
		city.city_name,
		p.businessname as parent_name,
		p.username as parent_username,
		a.grouping,
		a.mt_access,
		a.dmr_group,
		g.group_name,
		info.emailid
		from tblusers a 
		left join tblusers_info info on a.user_id = info.user_id
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		left join tblgroup	g on a.scheme_id = g.Id
		where 
		a.usertype_name = 'Distributor'  and a.parentid = ?
		order by a.businessname",array($this->session->userdata("SdId")));
				$this->load->view('SuperDealer_new/UserList_view',$this->view_data);
			}
		} 			
	}
}
?>