<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class EditUser extends CI_Controller {
	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
        $this->load->model("Service_model");
    }
	function is_logged_in() 
    {
		if ($this->session->userdata('MdUserType') != "MasterDealer") 
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

		if ($this->session->userdata('MdUserType') != "MasterDealer") 
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
				$parentid =  $this->session->userdata("MdId");	

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
				$StateName = $this->input->post("StatesName",TRUE);
				$CityName = $this->input->post("CityName",TRUE);				
				
				
				$EmailID = $this->input->post("EmailID",TRUE);				
				
				$UserId = $this->Common_methods->decrypt($this->input->post("hidUserId",TRUE));			


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
				$usertype_name = "Agent";
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
				



				$user_info = $this->db->query("select * from tblusers where user_id = ? and parentid = ?",array($UserId,$parentid));
				if($user_info->num_rows() == 1)
				{
				    
				    $groupinfo = $this->db->query("select * from tblgroup where groupfor = 'Agent' and (user_id = ? or user_id = 1) and Id = ?",array($parentid,$scheme_id));
				    if($groupinfo->num_rows() == 1)
				    {
				        
        				$parent_info = $this->db->query("select user_id,businessname,usertype_name,status from tblusers where user_id = ?",array(intval($parentid)));
        				if($parent_info->num_rows() ==1 )
        				{
        					if($parent_info->row(0)->usertype_name == "MasterDealer")
        					{
        					
        									$rsltupdate = $this->db->query("update tblusers 
        										set 
        										
        										state_id = ?,
        										city_id = ?,
        										scheme_id = ?
        										where user_id = ?
        
        									",array($state_id,$city_id,$scheme_id,$UserId));	
        									if($rsltupdate == true)
        									{
        									    //echo $User_id;exit;
        										$rsltupdate = $this->db->query("update tblusers_info 
        										set 
        										postal_address = ?,
        										pincode = ?,
        										pan_no = ?,
        										aadhar_number = ?,
        										emailid = ?
        										where user_id = ?
        
        									",array($ShopAddress,$pincode,$pan_no,$aadhar,$emailid,$UserId));	
        										$this->session->set_flashdata('message', 'Retailer Account details updated successfully.');



        										$this->session->set_flashdata('MESSAGEBOXTYPE', "success");
												$this->session->set_flashdata('MESSAGEBOX',"Retailer Account details updated successfully.");
        										redirect(base_url()."MasterDealer_new/UserList");
        									}
        									else
        									{
        										$this->session->set_flashdata('message', 'Retailer Account details updated successfully.');
        										$this->session->set_flashdata('MESSAGEBOXTYPE', "success");
												$this->session->set_flashdata('MESSAGEBOX',"Retailer Account details updated successfully.");
        										redirect(base_url()."MasterDealer_new/UserList");
        									}
        								
        							
        					}
        					else
        					{
        						$this->session->set_flashdata('MESSAGEBOXTYPE', "error");
								$this->session->set_flashdata('MESSAGEBOX',"Invalid Parent Selection.");
        						$this->session->set_flashdata('message', 'Invalid Parent Selection.');
        						redirect(base_url()."MasterDealer_new/UserList");
        					}
        				}
        				else
        				{
        					$this->session->set_flashdata('MESSAGEBOXTYPE', "error");
							$this->session->set_flashdata('MESSAGEBOX',"Invalid Parent Selection.");
        					$this->session->set_flashdata('message', 'Invalid Parent Selection.');
        					redirect(base_url()."MasterDealer_new/UserList");
        				}
				    }
				    else
				    {
				    	$this->session->set_flashdata('MESSAGEBOXTYPE', "error");
						$this->session->set_flashdata('MESSAGEBOX',"Invalid Group Selection.");
				        $this->session->set_flashdata('message', 'Invalid Group.');
						redirect(base_url()."MasterDealer_new/UserList");
				    }
				}
				else
				{
					$this->session->set_flashdata('MESSAGEBOXTYPE', "error");
					$this->session->set_flashdata('MESSAGEBOX',"Invalid User");
				    $this->session->set_flashdata('message', 'Invalid User.');
					redirect(base_url()."MasterDealer_new/UserList");
				}
				
			}
			else
			{
				if(isset($_GET["UserId"]))
				{
					$child_id = $this->Common_methods->decrypt(trim($this->input->get("UserId")));
					$parentid = $this->session->userdata("MdId");
					$child_info = $this->db->query("
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
													a.state_id,a.city_id,
													a.scheme_id,
													state.state_name,
													city.city_name,
													p.businessname as parent_name,
													p.username as parent_username,
													a.grouping,
													a.mt_access,
													a.dmr_group,
													g.group_name,
													info.emailid,
													info.pan_no,
													info.aadhar_number as aadhar,
													info.postal_address,
													info.pincode
													from tblusers a 
													left join tblusers_info info on a.user_id = info.user_id
													left join tblstate state on a.state_id = state.state_id
													left join tblcity city on a.city_id = city.city_id
													left join tblusers p on a.parentid = p.user_id
													left join tblgroup	g on a.scheme_id = g.Id
													where 
													a.usertype_name = 'Agent' and a.user_id = ?  and a.parentid = ?
													order by a.businessname",array($child_id,$this->session->userdata("MdId")));
					if($child_info->num_rows() == 1)
					{
						$reg_data = array(
						'FirstName'=>$child_info->row(0)->businessname,
						'MiddleName'=>"",
						'LastName'=>"",
						'ContactNo'=>$child_info->row(0)->mobile_no,
						'PanCardNo'=>$child_info->row(0)->pan_no,
						'AadharNo'=>$child_info->row(0)->aadhar,
						'gst'=>"",
						'contact_person'=>$child_info->row(0)->businessname,
						'ShopAddress'=>$child_info->row(0)->postal_address,
						'PermanentAddress'=>$child_info->row(0)->postal_address,
						'PinCode'=>$child_info->row(0)->pincode,
						'StateName'=>$child_info->row(0)->state_id,
						'CityName'=>$child_info->row(0)->city_id,
						'UserId'=>$child_info->row(0)->user_id,
						'EmailID'=>$child_info->row(0)->emailid,
						'Pattern'=>$child_info->row(0)->scheme_id,
						'UserType'=>$child_info->row(0)->usertype_name,
						);	
						
						$data['regData'] = $reg_data;	
						$data['message']='';
						$this->load->view('MasterDealer_new/EditUser_view',$data);}
					}	
				}
		} 			
	}
	public function BindState()
	{
		
	}
}
?>