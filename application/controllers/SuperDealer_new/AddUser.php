<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AddUser extends CI_Controller {
	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
        $this->load->model("Service_model");
    }
	function is_logged_in() 
    {
		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		} 
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
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

		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}  
		else 
		{ 
		$data['message']='';	
		if(isset($_POST["FirstName"]) and isset($_POST["MiddleName"]) and isset($_POST["LastName"]))
		{
			/*
			Array ( 
			[__RequestVerificationToken] => lqhZGW2Q63NueCU43LDw7_MAIVAeWk553vTxvvM8cFZ9RkJkXx3NuWtk6_eoSdkqaDrVSIFCYxgrPCkC59K9vLNAg8jOwgL-4KgcmkoHU_s1 
			[UserType] => Agent 
			[Pattern] => 64 
			[FirstName] => Ravikant 
			[MiddleName] => laxmanbhai 
			[LastName] => chavda [PanCardNo] => AIMPC2133L [ContactNo] => 8238232303 [EmailID] => ravikantchavda365@gmail.com [AadharNo] => 123412341234 [ShopAddress] => ahmedabad [PermanentAddress] => ahmedabad [PinCode] => 380001 [StateName] => 20 [CityName] => 104 [BankName] => undefined [AccountNo] => 199500100000577 [IFSCCode] => PUNB0096400 )
			*/
				$parentid =  $this->session->userdata("SdId");	

				$Pattern = $this->input->post("Pattern",TRUE);
	
				$FirstName = $this->input->post("FirstName",TRUE);
				$MiddleName = $this->input->post("MiddleName",TRUE);
				$LastName = $this->input->post("LastName",TRUE);

				
				$ContactNo = $this->input->post("ContactNo",TRUE);	
				$PanCardNo = $this->input->post("PanCardNo",TRUE);	
				$AadharNo = $this->input->post("AadharNo",TRUE);	
				$gst = "";	
				
				$ShopAddress = $this->input->post("ShopAddress",TRUE);	
				$PermanentAddress = $this->input->post("PermanentAddress",TRUE);				
				$PinCode = $this->input->post("PinCode",TRUE);
				$StateName = $this->input->post("StateName",TRUE);
				$CityName = $this->input->post("CityName",TRUE);				
				
				
				$EmailID = $this->input->post("EmailID",TRUE);				
				

				$username = $ContactNo;
				$pan_no = $PanCardNo;
				$aadhar = $AadharNo;
				$contact_person = $FirstName;
				$pincode = $PinCode;
				$state_id = $StateName;
				$city_id = $CityName;
				$mobile_no = $ContactNo;
				$emailid = $EmailID;
				$txtBDate = "";

				$scheme_id = $Pattern;												
				$downline_scheme = 0;	
				$downline_scheme2 = 0;	
				$usertype_name = "MasterDealer";
				$status = 0;
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
				if($this->Common_methods->findMobileExists($mobile_no))
				{	
					
						$response = $this->Insert_model->tblusers_registration_Entry($parentid,$FirstName,$ShopAddress,$pincode,$state_id,$city_id,$contact_person,$mobile_no,$emailid,$usertype_name,$status,$scheme_id,$username,$password,$aadhar,$pan_no,$gst,$downline_scheme,$downline_scheme2,$txtBDate,$service_array,$MiddleName,$LastName);


					
						
						$jsonobj = json_decode($response);
						
						if(isset($jsonobj->message) and isset($jsonobj->status))
						{ 
							$message = trim((string)$jsonobj->message);
							$status = trim((string)$jsonobj->status);
							if($status == "0")
							{
								$this->session->set_flashdata('MESSAGEBOXTYPE', "success");
								$this->session->set_flashdata('MESSAGEBOX', $message);
								redirect("SuperDealer_new/AddUser");
							}
							else
							{
								$this->session->set_flashdata('MESSAGEBOXTYPE', "error");
								$this->session->set_flashdata('MESSAGEBOX', $message);
								redirect("SuperDealer_new/AddUser");
							}
						}
				}
				else //If mobile no exist then Give message
				{	

					$reg_data = array(
					'FirstName'=>$FirstName,
					'MiddleName'=>$MiddleName,
					'LastName'=>$LastName,
					'ContactNo'=>$ContactNo ,
					'PanCardNo'=>$PanCardNo,
					'AadharNo'=>$AadharNo,
					'gst'=>"",
					'contact_person'=>$contact_person,
					'ShopAddress'=>$ShopAddress,
					'PermanentAddress'=>$PermanentAddress,
					'PinCode'=>$PinCode,
					'StateName'=>$StateName,
					'CityName'=>$CityName,
					
					'EmailID'=>$EmailID,
					'Pattern'=>$Pattern,
				);	
					$data['flag'] = 'mobileExist';
					$data['regData'] = $reg_data;					
					$data['message'] = $ContactNo." - Mobile no already registered.";
					$data['MESSAGEBOXTYPE'] = "error";
					$data['MESSAGEBOX'] =  $ContactNo." - Mobile no already registered.";
				
					$this->load->view('SuperDealer_new/AddUser_view',$data);
				}
			
			}
			else
			{
				$reg_data = array(
					'FirstName'=>"",
					'MiddleName'=>"",
					'LastName'=>"",
					'ContactNo'=>"" ,
					'PanCardNo'=>"",
					'AadharNo'=>"",
					'gst'=>"",
					'contact_person'=>"",
					'ShopAddress'=>"",
					'PermanentAddress'=>"",
					'PinCode'=>"",
					'StateName'=>"",
					'CityName'=>"",
					
					'EmailID'=>"",
					'Pattern'=>"",
				);	
						$data['flag'] = 'mobileExist';
						$data['regData'] = $reg_data;	
				$data['message']='';
				$this->load->view('SuperDealer_new/AddUser_view',$data);}
		} 			
	}
	public function BindState()
	{
		
	}
}
?>