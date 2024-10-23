<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class User_registration extends CI_Controller {
	
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

		if($this->input->post("btnSubmit"))
		{
			$this->load->model("Service_model");
		   error_reporting(-1);
		   ini_set('display_errors',1);
		   $this->db->db_debug = TRUE;

				$txtApiName = $this->input->post("txtApiName",TRUE);
				$txtConPer = $this->input->post("txtConPer",TRUE);	
				$txtPostalAddr = $this->input->post("txtPostalAddr",TRUE);	
				$txtPin = $this->input->post("txtPin",TRUE);	
				$ddlState = $this->input->post("ddlState",TRUE);	
				$ddlCity = $this->input->post("ddlCity",TRUE);	
				$txtMobNo = $this->input->post("txtMobNo",TRUE);
				$txtEmail = $this->input->post("txtEmail",TRUE);				
				$txtpanNo = $this->input->post("txtpanNo",TRUE);
				$txtAadhar = $this->input->post("txtAadhar",TRUE);
				$txtGst = $this->input->post("txtGst",TRUE);				
				$ddlSchDesc = $this->input->post("ddlSchDesc",TRUE);
				$usertype_name = 'APIUSER';


				$service_array = array();
				$service_rslt = $this->Service_model->getServices();
				foreach($service_rslt->result() as $ser)
				{
				    if(isset($_POST["chk".$ser->service_name]))
				    {
				       $service_array[$ser->service_name] = trim($_POST["chk".$ser->service_name]);
				    }
				}
				

				$password = $this->common->GetPassword();
				if($this->Common_methods->findMobileExists($txtMobNo))
				{	
					//($parentid,$distributer_name,$postal_address,$pincode,$state_id,$city_id,$contact_person,$mobile_no,$emailid,$usertype_name,$status,$scheme_id,$username,$password,$aadhar,$pan,$gst,$downline_scheme=0,$downline_scheme2=0,$BDate = "",$DomainName = "")
						$response = $this->Insert_model->tblusers_registration_Entry(1,$txtApiName,$txtPostalAddr,$txtPin,$ddlState,$ddlCity,$txtConPer,$txtMobNo,$txtEmail,$usertype_name,1,$ddlSchDesc,$txtMobNo,$password,$txtAadhar,$txtpanNo,$txtGst,0,0,"",$service_array);
						
						$jsonobj = json_decode($response);
						
						if(isset($jsonobj->message) and isset($jsonobj->status))
						{ 
							$message = trim((string)$jsonobj->message);
							$status = trim((string)$jsonobj->status);
							if($status == "0")
							{
								$this->session->set_flashdata('MESSAGEBOXTYPE', "success");
								$this->session->set_flashdata('MESSAGEBOX', $message);
								redirect("_Admin/User_registration");
							}
							else
							{
								$this->session->set_flashdata('MESSAGEBOXTYPE', "warning");
								$this->session->set_flashdata('MESSAGEBOX', $message);
								redirect("_Admin/User_registration");
							}
						}
				}
				else //If mobile no exist then Give message
				{	
					$reg_data = array(
					'api_name'=>$txtApiName,
					'pan_no'=>$txtpanNo,
					'aadhar'=>$txtAadhar,
					'gst'=>$txtGst,
					'contact_person'=>$txtConPer,
					'postal_address'=>$txtPostalAddr,
					'pincode'=>$txtPin,
					'state_id'=>$ddlState,
					'city_id'=>$ddlCity,
					'mobile_no'=>$txtMobNo,
					'emailid'=>$txtEmail,
					'scheme_id'=>$ddlSchDesc,
				);	
					$data['flag'] = 'mobileExist';
					$data['regData'] = $reg_data;					
					$data['message'] = $txtMobNo." - Mobile no already registered.";
					$data['MESSAGEBOXTYPE'] = "danger";
					$data['MESSAGEBOX'] =  $txtMobNo." - Mobile no already registered.";
				
					$this->load->view('_Admin/User_registration_view',$data);
				}
			
			}
		else
		{
			$reg_data = array(
					'api_name'=>'',
					'parentid'=>'' ,
					'username'=>'' ,
					'pan_no'=>'',
					'aadhar'=>'',
					'gst'=>'',
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
			$this->load->view('_Admin/User_registration_view',$data);}
	} 			
	}
}
?>