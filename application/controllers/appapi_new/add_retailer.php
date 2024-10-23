<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_retailer extends CI_Controller {
		private function logentry($data)
	{
	/*	$filename = "adret.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');*/
	}
	public function index()
	{ 
		$this->logentry(json_encode($this->input->get()));
		//http://www.palash.co.in/appapi1/add_retailer?username=&pwd=&name=&mobile=&email=&address=&pincode=&aadhar=&panno=&pin=
		
			if(isset($_GET['username']) && isset($_GET['pwd']) && isset($_GET['name']) && isset($_GET['mobile']) && isset($_GET['email']))
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
				$name =  $_GET['name'];
				$mobile =  trim($_GET['mobile']);
				$email =  $_GET['email'];
			   	$state_id =  $_GET['state_id'];
                $city_id  =  $_GET['city_id'];	
                $bdate = "";
                if(isset($_GET['bdate']))
                {
                    $bdate =  trim($_GET['bdate']);  
                }
                $host_id =0;
				$userinfo = $this->db->query("select * from tblusers where username = ?  and password = ?",array($username,$pwd));
				if($userinfo->num_rows() == 1)
				{
					
					$pusertype_name = $userinfo->row(0)->usertype_name;
				
					$status = $userinfo->row(0)->status;
				
					if($pusertype_name == "MasterDealer" or $pusertype_name == "Distributor")
					{
						if($status == "1")
						{
							
								if(ctype_digit($mobile))
								{
									if(strlen($mobile) == 10)
									{
										$parent_id = $userinfo->row(0)->user_id;
										$distributer_name = $name;
										$postal_address = "";
										$pincode = "";
										
										$contact_person = $name;
										$mobile_no = $mobile;
										$landline = $retailer_type_id =0;
										$emailid = $email;
										$usertype_name = "Agent";
										$scheme_id = 0;
										if($pusertype_name == "MasterDealer")
										{
											$usertype_name = "Distributor";
											$scheme_id = 0;
										}
										else if($pusertype_name == "Distributor")
										{
										    
										    if(isset($_GET["usertype"]))
										    {
										        $usertype_name = trim($_GET["usertype"]);    
										        if($usertype_name == "AGENT")
										        {
										            $usertype_name ="Agent";    
										        }
										    }
										    else
										    {
										        $usertype_name ="Agent";    
										    }
											
											$scheme_id = 0;
										}
										$status = 1;
										
										$working_limit = 0;
										$username =$mobile;
				                        $password = $this->common->GetPassword();
										$AIR=$MOBILE=$DTH=$GPRS=$SMS=$WEB="yes";
										
										$aadhar = $pan = $gst = $downline_scheme = $downline_scheme2 = 0;
										
				                            $response = $this->Insert_model->tblusers_registration_Entry($parent_id,$name,$postal_address,$pincode,$state_id,$city_id,$contact_person,$mobile_no,$emailid,$usertype_name,$status,$scheme_id,$username,$password,$aadhar,$pan,$gst,$downline_scheme,$downline_scheme2);
											echo $response;exit;
				                            
									}
									else
									{
										$resparr = array(
											"message"=>"Please Enter 10 Digit Mobile Number",
											"status"=>1
											);
											echo json_encode($resparr);
									}
								}
								else
								{
									$resparr = array(
											"message"=>"Invalid Mobile Number",
											"status"=>1
											);
											echo  json_encode($resparr);
								}
							
						}
						else
						{
							$resparr = array(
											"message"=>"Your Account Deactivated By Administrator",
											"status"=>1
											);
											echo  json_encode($resparr);
						}
					}
					else if($pusertype_name == "FOS" )
					{
						if($status == "1")
						{
							
								if(ctype_digit($mobile))
								{
									if(strlen($mobile) == 10)
									{
										$parent_id = $userinfo->row(0)->user_id;
										$distributer_name = $name;
										$postal_address = "";
										$pincode = "";
										
										$contact_person = $name;
										$mobile_no = $mobile;
										$landline = $retailer_type_id =0;
										$emailid = $email;
										$usertype_name = "Agent";
										$scheme_id = 22;
										$status = 1;
										
										$working_limit = 0;
										$username =$mobile;
				                        $password = $this->common->GetPassword();
										$AIR=$MOBILE=$DTH=$GPRS=$SMS=$WEB="yes";
										
										$aadhar = $pan = $gst = $downline_scheme = $downline_scheme2 = 0;
										
				                            $response = $this->Insert_model->tblusers_registration_Entry($parent_id,$name,$postal_address,$pincode,$state_id,$city_id,$contact_person,$mobile_no,$emailid,$usertype_name,$status,$scheme_id,$username,$password,$aadhar,$pan,$gst,$downline_scheme,$downline_scheme2);
											echo $response;exit;
				                            
									}
									else
									{
										$resparr = array(
											"message"=>"Please Enter 10 Digit Mobile Number",
											"status"=>1
											);
											echo json_encode($resparr);
									}
								}
								else
								{
									$resparr = array(
											"message"=>"Invalid Mobile Number",
											"status"=>1
											);
											echo  json_encode($resparr);
								}
							
						}
						else
						{
							$resparr = array(
											"message"=>"Your Account Deactivated By Administrator",
											"status"=>1
											);
											echo  json_encode($resparr);
						}
					}
				
					else
					{
						$resparray = array(
    					'status'=>1,
    					'message'=>'Invalid User'
    					);
    					echo json_encode($resparray);exit;
					}	


				}
				
			}
			else if(isset($_POST['username']) && isset($_POST['pwd']) && isset($_POST['name']) && isset($_POST['mobile']) && isset($_POST['email']))
			{
				$username = $_POST['username'];
				$pwd =  $_POST['pwd'];
				$name =  $_POST['name'];
				$mobile =  trim($_POST['mobile']);
				$email =  $_POST['email'];
			
				$userinfo = $this->db->query("select * from tblusers where username = ?  and password = ?",array($username,$pwd));
				if($userinfo->num_rows() == 1)
				{
					
					$pusertype_name = $userinfo->row(0)->usertype_name;
				
					$status = $userinfo->row(0)->status;
				
					if($pusertype_name == "MasterDealer" or $pusertype_name == "Distributor")
					{
						if($status == "1")
						{
							
								if(ctype_digit($mobile))
								{
									if(strlen($mobile) == 10)
									{
										$parent_id = $userinfo->row(0)->user_id;
										$distributer_name = $name;
										$postal_address = "";
										$pincode = "";
										$state_id = $city_id = 0;
										$contact_person = $name;
										$mobile_no = $mobile;
										$landline = $retailer_type_id =0;
										$emailid = $email;
										$usertype_name = "Agent";
										$scheme_id = 0;
										if($pusertype_name == "MasterDealer")
										{
											$usertype_name = "Distributor";
											$scheme_id = 0;
										}
										$status = 1;
										
										$working_limit = 0;
										$username = $this->Common_methods->getNewUserId($usertype_name);
				                        $password = $this->common->GetPassword();
										$AIR=$MOBILE=$DTH=$GPRS=$SMS=$WEB="yes";
										
										
										
										$this->load->model('Admin_d_registration_model');	
				                        if($this->Admin_d_registration_model->find_mobile_exist($mobile_no))
				                        {
				                            $response = $this->Insert_model->tblusers_registration_Entry($parent_id,$distributer_name,$postal_address,$pincode,$state_id,$city_id,$contact_person,$mobile_no,$landline,$retailer_type_id,$emailid,$usertype_name,$status,$scheme_id,$working_limit,$username,$password,$working_limit,$AIR,$MOBILE,$DTH,$GPRS,$SMS,$WEB);
											$to = $emailid;
                        					$subject = $this->common_value->getSubject();					
                        					$message = $this->common_value->getEmailMessage($username,$password,$distributer_name);
                        					$from = $this->common_value->getFromEmail();
                        					$headers = "From:" . $from;
                        					$headers .= "\nContent-Type: text/html";
                        					mail($to,$subject,$message,$headers);				
                                            $smsMessage = 'Your account has been successfully created. User Name : '.$username.' Password : '.$password.' Royal Business';
                                            $tempid = "35574";
                        					$result_sms = $this->common->ExecuteSMSApi($this->common_value->getSMSUserName(),$this->common_value->getSMSPassword(),$mobile_no,$smsMessage);		
										    $resparr = array(
    											"message"=>"User Registered Successfully.",
    											"status"=>0
											);
											echo json_encode($resparr);
				                        }
				                        else
				                        {
				                            $resparr = array(
											"message"=>"Mobile Number Already Exist In The System",
											"status"=>1
											);
											echo json_encode($resparr);
				                        }
										    
									}
									else
									{
										$resparr = array(
											"message"=>"Please Enter 10 Digit Mobile Number",
											"status"=>1
											);
											echo json_encode($resparr);
									}
								}
								else
								{
									$resparr = array(
											"message"=>"Invalid Mobile Number",
											"status"=>1
											);
											echo  json_encode($resparr);
								}
							
						}
						else
						{
							$resparr = array(
											"message"=>"Your Account Deactivated By Administrator",
											"status"=>1
											);
											echo  json_encode($resparr);
						}
					}
				
						else
						{
							$resparray = array(
						'status'=>1,
						'message'=>'Invalid User'
						);
						echo json_encode($resparray);exit;
						}	


				}
				
			}
			else
			{echo 'Paramenter is missing';exit;}			
	
	
	}	
	
	private function check_login($username,$password)
	{
		$str_query = "select * from tblusers where username=? and password=?";
		$result = $this->db->query($str_query,array($username,$password));		
		if($result->num_rows() == 1)
		{
			
			if($result->row(0)->status == '1')
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}		
	}
	
	
	public function getstate()
	{
	    $rsltstate = $this->db->query("select state_id,state_name from tblstate order by state_name");
	    echo json_encode($rsltstate->result());exit;
	}
	public function getcity()
	{
	    if(isset($_GET["state_id"]))
	    {
	        $state_id = trim($_GET["state_id"]);
	        $city_result = $this->db->query("select city_id,city_name from tblcity where state_id = ?",array($state_id));
	        echo json_encode($city_result->result());exit;
	    }
	    else
	    {
	        
	    }
	    $rsltstate = $this->db->query("select state_id,state_name from tblstate order by state_name");
	    echo json_encode($rsltstate->result());exit;
	}
}
