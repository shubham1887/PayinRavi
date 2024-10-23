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
		// error_reporting(-1);
		// ini_set('display_errors',1);
		// $this->db->db_debug = TRUE;
		$this->logentry(json_encode($this->input->get()));
		//http://www.palash.co.in/appapi1/add_retailer?username=&pwd=&name=&mobile=&email=&address=&pincode=&aadhar=&panno=&pin=
		//,=
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
                $aadhar = $_GET['adhar'];
                $pan = $_GET['pan'];	
                if(isset($_GET['bdate']))
                {
                    $bdate =  trim($_GET['bdate']);  
                }
                $host_id = 1;
				$userinfo = $this->db->query("select * from tblusers where username = ?  and password = ? ",array($username,$pwd));
				if($userinfo->num_rows() == 1)
				{
				    $scheme_id = $userinfo->row(0)->downline_scheme;
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
										
										if($pusertype_name == "MasterDealer")
										{
											$usertype_name = "Distributor";
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
										}
										$status = 1;
										
										$working_limit = 0;
										$username =$mobile;
				                        $password = $this->common->GetPassword();
										$AIR=$MOBILE=$DTH=$GPRS=$SMS=$WEB="yes";
										
										 $gst = $downline_scheme = $downline_scheme2 = 0;


										  $this->load->model("Service_model");
							            $service_rslt = $this->Service_model->getServices();
							            foreach($service_rslt->result() as $ser)
							            {
							                $service_array[$ser->service_name] = "on";
							            }
							            
										
				                            $response = $this->Insert_model->tblusers_registration_Entry($parent_id,$name,$postal_address,$pincode,$state_id,$city_id,$contact_person,$mobile_no,$emailid,$usertype_name,$status,$scheme_id,$username,$password,$aadhar,$pan,$gst,$downline_scheme,$downline_scheme2,$bdate,$service_array);
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
