<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetBillAmount extends CI_Controller {
	public function logentry($data)
	{
	/*	$filename = "temp.txt";
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
	    
	    /*
	    {"ddlcity":"Ahmedabad","customer_mobile":"8238232303","mcode":"TPE","username":"9287398237","option2":"","pwd":"12345","option1":"","serviceno":"500185702"}
	    */
		$this->logentry(json_encode($this->input->get()));
		$this->logentry(json_encode($this->input->post()));
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd'])   && isset($_GET['mcode']) && isset($_GET['serviceno']) && isset($_GET['customer_mobile']) && isset($_GET['option1']))
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
				$txnpwd = $_GET['txnpwd'];
				$mcode = $_GET['mcode'];
				$serviceno =  $_GET['serviceno'];
				$customer_mobile = $_GET['customer_mobile'];
				$option1 = $_GET['option1'];
			    	
			 	if($mcode == "TPE")
			 	{
			 	    
			 	    
                   if(isset($_GET['option1']))
                   {
                        $option1 = $_GET['option1'];    
                        if($option1 == "Ahmedabad")
                        {
                            $mcode = "TYE";
                        }
                         if($option1 == "Surat")
                        {
                            $mcode = "TWE";
                        }
                   }	    
			 	}
			 	if($mcode == "WBSEDCL")
			 	{
			 	    $mcode = "WWE";
			 	}
			 	
			 	//echo $mcode;exit;
               $host_id = $this->Common_methods->getHostId($this->white->getDomainName());
				$user_info = $this->db->query("select * from tblusers where username = ?  and password = ? and host_id = ?",array($username,$pwd,$host_id));
				if($user_info->row(0)->usertype_name == "Agent" or $user_info->row(0)->usertype_name == "Distributor" or $user_info->row(0)->usertype_name == "MasterDealer")
				{
					
					$company_info = $this->db->query("select * from tblcompany where mcode = ?",array($mcode));
					if($company_info->num_rows() == 1)
					{
					   
						$this->load->model("Instapay");
						$response = $this->Instapay->recharge_transaction_validate2($user_info,$mcode,$company_info->row(0)->company_id,"",$serviceno,$customer_mobile,$option1);
						//recharge_transaction_validate2($user_info,$mcode,0,0,$serviceno,$customer_mobile,$option1);
						echo $response;exit;
					}
					else
					{
						$resp_arr = array(
									"message"=>"Operator Configuration Missing",
									"status"=>1,
									"statuscode"=>"CONF",
								);
						$json_resp =  json_encode($resp_arr);
					}
				}	
				else
				{
					$resp_arr = array(
									"message"=>"Unauthorised Access",
									"status"=>1,
									"statuscode"=>"AUTH",
								);
						$json_resp =  json_encode($resp_arr);
				}
			
			}
			else
			{echo 'Paramenter is missing';exit;}		
		}
		else if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_POST['username']) && isset($_POST['pwd'])   && isset($_POST['mcode']) && isset($_POST['serviceno']) && isset($_POST['customer_mobile']) && isset($_POST['option1']))
			{
				$username = $_POST['username'];
				$pwd =  $_POST['pwd'];
				
				$mcode = $_POST['mcode'];
				$serviceno =  $_POST['serviceno'];
				$customer_mobile = $_POST['customer_mobile'];
				$option1 = $_POST['option1'];
			    if($mcode == "TPE")
			 	{
			 	    
			 	    
                   if(isset($_POST['ddlcity']))
                   {
                        $option1 = $_POST['ddlcity'];    
                        if($option1 == "Ahmedabad")
                        {
                            $mcode = "TYE";
                        }
                         if($option1 == "Surat")
                        {
                            $mcode = "TWE";
                        }
                   }	    
			 	}
			 	
			 	
			 
				$user_info = $this->db->query("select * from tblusers where  username = ? and password = ?",array($username,$pwd));
			
				if($user_info->row(0)->usertype_name == "Agent")
				{
					
					$company_info = $this->db->query("select * from tblcompany where mcode = ?",array($mcode));
					if($company_info->num_rows() == 1)
					{
					    
						$this->load->model("Instapay");
						$response = $this->Instapay->recharge_transaction_validate2($user_info,$mcode,$company_info->row(0)->company_id,"",$serviceno,$customer_mobile,$option1);
						//recharge_transaction_validate2($user_info,$mcode,0,0,$serviceno,$customer_mobile,$option1);
						$this->logentry(json_encode($response));
						echo $response;exit;
					}
					else
					{
						$resp_arr = array(
									"message"=>"Operator Configuration Missing",
									"status"=>1,
									"statuscode"=>"CONF",
								);
						$json_resp =  json_encode($resp_arr);
					}
				}	
				else
				{
					$resp_arr = array(
									"message"=>"Unauthorised Access",
									"status"=>"1",
									"statuscode"=>"ERR",
								);
						$json_resp =  json_encode($resp_arr);
						echo $json_resp;exit;
				}
			
			}
			else
			{echo 'Paramenter is missing';exit;}		
		}
		else
		{
			echo 'Paramenter is missing';exit;
		}
		
		
		
	}	
	public function getCompanyIdByProvider($operatorcode)
	{
		$rslt = $this->db->query("select company_id from tblcompany where mcode = ?",array($operatorcode));
		if($rslt->num_rows() >= 1)
		{
			return $rslt->row(0)->company_id;
		}
		else
		{
			return false;
		}
	}
	function check_login($username,$password)
	{
		$str_query = "select user_id,status from tblusers where username=? and password=?";
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
}