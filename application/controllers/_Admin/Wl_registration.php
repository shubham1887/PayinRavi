<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Wl_registration extends CI_Controller {
	
	public function index()
	{						
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			$data['message']='';	

		if($this->input->post("btnSubmit")){
				$distributer_name = $this->input->post("txtDistname",TRUE);	
				$parentid = $this->Userinfo_methods->getAdminId();	
				$pan_no = $this->input->post("txtpanNo",TRUE);	
				$contact_person = $this->input->post("txtSiteTitle",TRUE);
				$postal_address = $this->input->post("txtPostalAddr",TRUE);				
				$pincode = $this->input->post("txtPin",TRUE);
				$state_id = $this->input->post("ddlState",TRUE);
				$city_id = $this->input->post("ddlCity",TRUE);				
				$mobile_no = $this->input->post("txtMobNo",TRUE);
				$landline = $this->input->post("txtLandNo",TRUE);
				
				$emailid = $this->input->post("txtEmail",TRUE);				
				$SiteTitle = $this->input->post("txtSiteTitle",TRUE);				
												
				$scheme_id = 0;
				$usertype_name = "WL";
				$ustatus = 1;
				$username = $this->Common_methods->getNewUserId($usertype_name);
				$password = $this->common->GetPassword();
				if($this->Common_methods->findMobileExists($mobile_no))
				{				
					$response = $this->Insert_model->tblusers_registration_Entry($parentid,$distributer_name,$postal_address,$pincode,$state_id,$city_id,$contact_person,$mobile_no,$emailid,$usertype_name,$ustatus,$scheme_id,$username,$password);
					$jsonobj = json_decode($response);
					if(isset($jsonobj->message) and isset($jsonobj->status))
					{
						$message = trim((string)$jsonobj->message);
						$status = trim((string)$jsonobj->status);
						if($status == "0")
						{
							$this->session->set_flashdata('MESSAGEBOXTYPE', "success");
							$this->session->set_flashdata('MESSAGEBOX', $message);
							redirect("_Admin/admin_d_registration");
						}
						else
						{
							$this->session->set_flashdata('MESSAGEBOXTYPE', "warning");
							$this->session->set_flashdata('MESSAGEBOX', $message);
							redirect("_Admin/admin_d_registration");
						}
					}
				}
				else //If mobile no exist then Give message
				{	$reg_data = array(
					'distributer_name'=>$distributer_name,
					'parentid'=>$parentid ,
					'pan_no'=>$pan_no,
					'contact_person'=>$contact_person,
					'postal_address'=>$postal_address,
					'pincode'=>$pincode,
					'state_id'=>$state_id,
					'city_id'=>$city_id,
					'mobile_no'=>$mobile_no,
					'landline'=>$landline,
					'emailid'=>$emailid,
				);	
					$data['flag'] = 'mobileExist';
					$data['regData'] = $reg_data;	
					$data['message'] = $mobile_no." - Mobile no already registered.";
					$this->load->view('_Admin/wl_registration_view',$data);
				}
			
			}else
		{
			$reg_data = array(
					'distributer_name'=>'',
					'parentid'=>'' ,
					'pan_no'=>'',
					'contact_person'=>'',
					'postal_address'=>'',
					'pincode'=>'',
					'state_id'=>'',
					'city_id'=>'',
					'mobile_no'=>'',
					'landline'=>'',
					'retailer_type_id'=>'',
					'emailid'=>'',
					'stateCode'=>'',
					'scheme_id'=>'',
					'working_limit'=>''
				);	
					$data['flag'] = 'mobileExist';
					$data['regData'] = $reg_data;	
			$data['message']='';
			$this->load->view('_Admin/wl_registration_view',$data);}
	} 			
	}
}
?>