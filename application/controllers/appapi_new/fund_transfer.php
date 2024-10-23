<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fund_transfer extends CI_Controller {
	private function logentry($data)
	{
		/*$filename = "fundrev.txt";
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

	public function addBalance()
	{
	   // error_reporting(E_ALL);
	    //$this->db->db_debug = TRUE;
	    //ini_set("display_errors",1);
	    $data = json_encode($this->input->get());
	     $this->logentry($data);
		//http://www.palash.co.in /appapi1/fund_transfer/addBalance?username=200001&pwd=912436&OthersId=110003&amount=1&remark=test&txnpwd=2779&type=Wallet1
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache"); 
		//addBalance?username=&pwd=&OthersId=&amount=
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_REQUEST['username']) && isset($_REQUEST['pwd']) && isset($_REQUEST['OthersId'])  && isset($_REQUEST['amount']))
			{
				$username = $_REQUEST['username'];
				$pwd =  $_REQUEST['pwd'];
				$othersId = $_REQUEST['OthersId'];
				$amount = $_REQUEST['amount'];
				$remark = $_REQUEST['remark'];
			//	$txnpwd = $_REQUEST['txnpwd'];
			}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else
		{
			if(isset($_GET['username']) && isset($_GET['pwd'])  && isset($_GET['OthersId'])  && isset($_GET['amount']))
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
				$othersId = $_GET['OthersId'];
				$amount = $_GET['amount'];
				$remark = $_GET['remark'];
				$type  = "Wallet1";
				if(isset($_GET['type']))
				{
				    $type = $_GET['type'];    
				}
				
				
				}
			else
			{echo 'Paramenter is missing';exit;}			
		}	
		if($amount < 0)
		{
			$resparray = array(
		            "status"=>1,
		            "message"=>"Invalid Amount"
		        );
		        echo json_encode($resparray);exit;
		}
		$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
		$userinfo = $this->db->query("select * from tblusers where username = ?  and password = ? and host_id = ?",array($username,$pwd,$host_id));
		if($userinfo->num_rows() == 1)
		{
			//$hostname = $userinfo->row(0)->hostname;
			$usertype_name = $userinfo->row(0)->usertype_name;
			
			if($usertype_name == "SuperDealer" or  $usertype_name == "MasterDealer" or $usertype_name == "Distributor" or $usertype_name == "FOS")
			{
				$cruserinfo = $this->db->query("select * from tblusers where username = ? and host_id = ?",array($othersId,$host_id));
				if($cruserinfo->num_rows() == 1)
				{
					$cr_usertype = $cruserinfo->row(0)->usertype_name;
					//$cr_hostname = $cruserinfo->row(0)->hostname;
					if($cr_usertype == "Agent" or $cr_usertype == "FOS" or $cr_usertype == "Distributor" or $cr_usertype == "MasterDealer")
					{
						//if($hostname == $cr_hostname)
						if(true)
						{
							
							$dr_user_id = $userinfo->row(0)->user_id;
							$cr_user_id = $cruserinfo->row(0)->user_id;
							if($type == "Wallet2")
							{
								$response = $this->Ew2->DealerAddBalance($dr_user_id,$cr_user_id,$amount,$remark);
								 $resparray = array(
                		            "status"=>0,
                		            "message"=>$response
                    		        );
                    		        echo json_encode($resparray);exit;	
							}
							else
							{
								
								$response = $this->Common_methods->DealerAddBalance($dr_user_id,$cr_user_id,$amount,$remark);
								$resparray = array(
                		            "status"=>0,
                		            "message"=>$response
                    		        );
                    		        echo json_encode($resparray);exit;			
							
							}
							
						}
						
					}
					
				}
				else
				{
				    $resparray = array(
		            "status"=>1,
		            "message"=>"Invalid User 1"
    		        );
    		        echo json_encode($resparray);exit;
				
				}	
			}
			else if($usertype_name == "WLMasterDealer" or $usertype_name == "WLDistributor")
			{
				$cruserinfo = $this->db->query("select * from tblusers where username = ?",array($othersId));
				if($cruserinfo->num_rows() == 1)
				{
					$cr_usertype = $cruserinfo->row(0)->usertype_name;
					$cr_hostname = $cruserinfo->row(0)->hostname;
					if($cr_usertype == "WLAgent" or $cr_usertype == "WLDistributor")
					{
						if($hostname == $cr_hostname)
						{
							$dr_user_id = $userinfo->row(0)->user_id;
							$cr_user_id = $cruserinfo->row(0)->user_id;
							$response = $this->Wlmethods->DealerAddBalance($dr_user_id,$cr_user_id,$amount,"");
							$resparray = array(
                				'Error'=>0,
                				'Message'=>$response
                				);
				            echo json_encode($resparray);exit;
				
						}
						
					}
					
				}	
				}
				else
				{
				    $resparray = array(
				'Error'=>1,
				'Message'=>'Invalid User'
				);
				echo json_encode($resparray);exit;
				}	
			
			
		}
		else
		{
		     $resparray = array(
				'Error'=>1,
				'Message'=>'Invalid Access'
				);
				echo json_encode($resparray);exit;
			echo "Invalid Access";exit;
		}
		
	}
	public function revertBalance()
	{
	    $data = json_encode($this->input->get());
	     $this->logentry($data);
		//http://www.PAY91.IN/appapi1/revertBalance?username=&pwd=&OthersId=&amount=&remark=&type=
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_REQUEST['username']) && isset($_REQUEST['pwd']) && isset($_REQUEST['OthersId'])  && isset($_REQUEST['amount']))
			{
				$username = $_REQUEST['username'];
				$pwd =  $_REQUEST['pwd'];
				$othersId = $_REQUEST['OthersId'];
				$amount = $_REQUEST['amount'];
				$remark = $_REQUEST['remark'];
				$type = $_REQUEST['type'];
			}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else
		{
			if(isset($_GET['username']) && isset($_GET['pwd'])  && isset($_GET['OthersId'])  && isset($_GET['amount']))
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
				$othersId = $_GET['OthersId'];
				$amount = $_GET['amount'];
				$remark = $_GET['remark'];
				$type = $_GET['type'];
				}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		
		
		if($amount < 0)
		{
			echo "Invalid Amount";exit;
		}
		$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
		$userinfo = $this->db->query("select * from tblusers where username = ? and password = ? and host_id = ?",array($username,$pwd,$host_id));
		if($userinfo->num_rows() == 1)
		{
			
			$usertype_name = $userinfo->row(0)->usertype_name;
			$userstatus = $userinfo->row(0)->status;
			if($userstatus == '1')
			{
			    if($usertype_name == "SuperDealer" or $usertype_name == "MasterDealer" or $usertype_name == "Distributor" or $usertype_name == "FOS")
    			{
    				$druserinfo = $this->db->query("select * from tblusers where username = ? and host_id = ?",array($othersId,$host_id));
    				if($druserinfo->num_rows() == 1)
    				{
    					$dr_usertype = $druserinfo->row(0)->usertype_name;
    					$dr_parentid = $druserinfo->row(0)->parentid;
    					if($dr_usertype == "Agent" or $dr_usertype == "Distributor" or $dr_usertype == "MasterDealer" or $dr_usertype == "FOS")
    					{
    						if(true)
    						{
    							$cr_user_id = $userinfo->row(0)->user_id;
    							$dr_user_id = $druserinfo->row(0)->user_id;
    							if($cr_user_id == $dr_parentid)
    							{
    							    
    							    
    							    if($type == "Wallet2")
    							    {
    							        $response = $this->Ew2->DealerRevertBalance($dr_user_id,$cr_user_id,$amount);
    								    $resparray = array(
                    		            "status"=>0,
                    		            "message"=>$response
                        		        );
                        		        echo json_encode($resparray);exit;
    							    }
    							    else
    							    {
    							        $response = $this->Common_methods->DealerRevertBalance($dr_user_id,$cr_user_id,$amount);
    								    $resparray = array(
                    		            "status"=>0,
                    		            "message"=>$response
                        		        );
                        		        echo json_encode($resparray);exit;
    							    }
    											
    							}
    							else
    							{
    							    	$resparray = array(
                    		            "status"=>1,
                    		            "message"=>"Invalid User"
                        		        );
                        		        echo json_encode($resparray);exit;
    							}
    						}
    						
    					}
    					else
    					{
    					    $resparray = array(
                    		            "status"=>1,
                    		            "message"=>"Invalid Access"
                        		        );
                        		        echo json_encode($resparray);exit;
    					}
    					
    				}
    				else
    				{
    					$resparray = array(
    		            "status"=>1,
    		            "message"=>"Invalid User"
        		        );
        		        echo json_encode($resparray);exit;
    				}	
    			}
    			else if($usertype_name == "WLMasterDealer" or $usertype_name == "WLDistributor")
    			{
    				$druserinfo = $this->db->query("select * from tblusers where username = ?",array($othersId));
    				if($druserinfo->num_rows() == 1)
    				{
    					$dr_usertype = $druserinfo->row(0)->usertype_name;
    					$dr_hostname = $druserinfo->row(0)->hostname;
    					$dr_parentid = $druserinfo->row(0)->parentid;
    					if($dr_usertype == "WLAgent" or $dr_usertype == "WLDistributor")
    					{
    						if($hostname == $dr_hostname)
    						{
    							$cr_user_id = $userinfo->row(0)->user_id;
    							$dr_user_id = $druserinfo->row(0)->user_id;
    							if($cr_user_id == $dr_parentid)
    							{
    								$response = $this->Wlmethods->DealerRevertBalance($dr_user_id,$cr_user_id,$amount,"");
    								$resparray = array(
    				'Error'=>0,
    				'Message'=>$response
    				);
    				echo json_encode($resparray);exit;
    										
    							}
    							
    						}
    						
    					}
    					
    				}
    				else
    				{
    					$resparray = array(
    				'Error'=>1,
    				'Message'=>'Invalid User'
    				);
    				echo json_encode($resparray);exit;
    				}	
    			}
    			else
    			{
    			    $resparray = array(
    		            "status"=>1,
    		            "message"=>"Invalid User"
        		        );
        		        echo json_encode($resparray);exit;
    			}
			}
			
			
		}
		else
		{
			$resparray = array(
				'Error'=>1,
				'Message'=>'Invalid Access'
				);
				echo json_encode($resparray);exit;
		}
		
	}
	
}
