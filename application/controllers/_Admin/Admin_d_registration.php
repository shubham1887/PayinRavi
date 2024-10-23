<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Admin_d_registration extends CI_Controller {
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('ausertype') != "Admin") 
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
        $this->load->model("Service_model");
        // error_reporting(-1);
        // ini_set('display_errors',1);
        // $this->db->db_debug = TRUE;
    }
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
	        
				$distributer_name = $this->input->post("txtDistname",TRUE);

				$FirstName = $this->input->post("txtFirstName",TRUE);
				$MiddleName = $this->input->post("txtMiddleName",TRUE);
				$LastName = $this->input->post("txtLastName",TRUE);




				$parentid = $this->input->post("ddlparent",TRUE);	
			
				$username = $this->input->post("txtMobNo",TRUE);	
				$emailid = $this->input->post("txtEmail",TRUE);	
				$postal_address = $this->input->post("txtPostalAddr",TRUE);
				$pincode = $this->input->post("txtPin",TRUE);
				
				$state_id = $this->input->post("ddlState",TRUE);
				$city_id = $this->input->post("ddlCity",TRUE);
				
				$W1FlatComm = $this->input->post("txtW1FlatComm",TRUE);
				$W2FlatComm = $this->input->post("txtW2FlatComm",TRUE);
				
				
				$pan_no = $this->input->post("txtpanNo",TRUE);	
				$contact_person = $this->input->post("txtConPer",TRUE);
				$aadhar = $this->input->post("txtAadhar",TRUE);	
				$gst = $this->input->post("txtGst",TRUE);	
				$scheme_id = $this->input->post("ddlSchDesc",TRUE);
						
				$txtBDate = $this->input->post("txtBDate",TRUE);		
				
				
				$chkMobile = $this->input->post("chkMobile",TRUE);
				$chkDth = $this->input->post("chkDth",TRUE);
				$chkPostpaid = $this->input->post("chkPostpaid",TRUE);
				$chkElectricity = $this->input->post("chkElectricity",TRUE);
				$chkGas = $this->input->post("chkGas",TRUE);
				$chkInsurance = $this->input->post("chkInsurance",TRUE);
				$chkLoan_Repayment = $this->input->post("chkLoan_Repayment",TRUE);
				$chkWater = $this->input->post("chkWater",TRUE);
			    $stateCode = "";
				$service_array = array();
				$service_rslt = $this->Service_model->getServices();
				foreach($service_rslt->result() as $ser)
				{
				    if(isset($_POST["chk".$ser->service_name]))
				    {
				       $service_array[$ser->service_name] = trim($_POST["chk".$ser->service_name]);
				    }
				}
				
			
				
        	    											
				$downline_scheme = 0;	
				$downline_scheme2 = 0;	
				$usertype_name = "Distributor";
				$status = 0;
			
				$password = $this->common->GetPassword();
				
				$mobile_no = $username;
				if($this->Common_methods->findMobileExists($mobile_no))
				{	
					
						$response = $this->Insert_model->tblusers_registration_Entry($parentid,$distributer_name,$postal_address,$pincode,$state_id,$city_id,$contact_person,$mobile_no,$emailid,$usertype_name,$status,$scheme_id,$username,$password,$aadhar,$pan_no,$gst,$downline_scheme,0,$txtBDate,$service_array,$FirstName,$MiddleName,$LastName);
						
						$jsonobj = json_decode($response);
						
						if(isset($jsonobj->message) and isset($jsonobj->status))
						{ 
							$message = trim((string)$jsonobj->message);
							$status = trim((string)$jsonobj->status);
							if($status == "0")
							{
								$this->session->set_flashdata('MESSAGEBOXTYPE', "SUCCESS");
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
				
					$this->load->view('_Admin/admin_d_registration_view',$data);
				}
			
			}
		else
		{
			$reg_data = array(
					'distributer_name'=>'',
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
			$this->load->view('_Admin/admin_d_registration_view',$data);}
	    }
	}
	private function updateservices()
	{
	    
	}
}
?>