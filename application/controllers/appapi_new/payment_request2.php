<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_request2 extends CI_Controller {
	private function logentry($data)
	{
		
	}
	public function index()
	{ 
	   $resp = json_encode($this->input->post());
	    $get = json_encode($this->input->get());
	   $this->logentry("post".$resp);
	      $this->logentry($get);
		
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd']))
			{
			    $username = $_GET['username'];
			    $pwd =  $_GET['pwd'];
			    $payment_type =  $_GET['payment_type'];
			   
			    $amount =  $_GET['amount'];
			    $txnId =  $_GET['txnId'];
			    $Remark =  $_GET['Remark'];
			    $type = $_GET["type"];
			}
			else
			{echo 'Paramenter is missing 2';exit;}			
		}
	    else if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
		    //username=&pwd=&payment_type=&amount=&txnId=&Remark=
			if(isset($_GET['username']) && isset($_GET['pwd']) && isset($_GET['payment_type']) && isset($_GET['amount'])  && isset($_GET['txnId'])  && isset($_GET['Remark']))
			{
			    $username = $_GET['username'];
			    $pwd =  $_GET['pwd'];
			    $payment_type =  $_GET['payment_type'];
			   
			    $amount =  $_GET['amount'];
			    $txnId =  $_GET['txnId'];
			    $Remark =  $_GET['Remark'];
			    $type = $_GET["type"];
			}
			else
			{echo 'Paramenter is missing 2';exit;}			
		}
		else
		{
			echo 'Paramenter is missing';exit;
		}
		$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
		$userinfo = $this->db->query("select user_id,businessname,username,status,mobile_no,usertype_name,password from tblusers where username = ? and password = ? and host_id = ?",array($username,$pwd,$host_id));
		//print_r($userinfo->result());exit;
		if($userinfo->num_rows() == 1)
		{
			$status = $userinfo->row(0)->status;
			$business_name = $userinfo->row(0)->businessname;
			$username = $userinfo->row(0)->username;
			$mobile_no = $userinfo->row(0)->mobile_no;
			$usertype_name = $userinfo->row(0)->usertype_name;
			$password = $userinfo->row(0)->password;
			$user_id = $userinfo->row(0)->user_id;
			$txnId = trim($txnId);
			  $this->logentry($business_name);
			if($status == '1')
			{
			 
			 
			    if($usertype_name == "Distributor" or $usertype_name == "MasterDealer" or $usertype_name == "SuperDealer" or $usertype_name == "FOS" or $usertype_name == "Agent")
        		{
        		      					
        				$add_date = $this->common->getDate();
        				$ipaddress = $this->common->getRealIpAddr();
        				$rsltpayreq = $this->db->query("select * from tblautopayreq where (user_id = ? and amount = ?  and status = 'Pending') ",array($user_id,$amount));
        				if($rsltpayreq->num_rows() > 0)
        				{
        				        	$resparray = array(
                        				'message'=>'Payment Request Already Exist Of This Amount , Try Different Amount',
                        				'status'=>1
                        				);
                        				echo json_encode($resparray);exit;
        				
        				}
        				else
        				{
        				    if (true)
    				    	{
    				    	     $this->logentry("Cash");
    				    	    $response = "";
                        	    $response .= "Start";
                        	    
                        	    //echo "file : ".$_FILES['receipt']['tmp_name'];exit;
                        	    if (is_uploaded_file($_FILES['receipt']['tmp_name'])) 
                        	    {
                        	        
                        	        $file_ext=strtolower(end(explode('.',$_FILES['receipt']['name'])));
                                    $expensions= array("jpeg","jpg","png", "JPEG","JPG", "PNG");
                                    if(in_array($file_ext,$expensions)=== false)
                                    {
                                        $resparray = array(
                                				'message'=>'extension not allowed, please choose a JPEG or PNG file.',
                                				'status'=>1
                                				);
                                		echo json_encode($resparray);exit;
                                     
                                    }
                                    else
                                    {
                                        $response .= "\nFile Found";
                                        
                                        
                                        if (!file_exists('uploads/'.$this->common->getMySqlDate())) 
                                        {
                                            mkdir('uploads/'.$this->common->getMySqlDate(), 0777, true);
                                        }
                                        $uploads_dir = "uploads/".$this->common->getMySqlDate()."/".$user_id.$this->common->getDate().$_FILES["receipt"]["name"];
                                        $tmp_name = $_FILES['receipt']['tmp_name'];
                                        $pic_name = $_FILES['receipt']['name'];
                                        $response .= "\nFile Name : ".$_FILES['receiptb']['name'];
                                        move_uploaded_file($tmp_name, $uploads_dir);
                                        $response .= "\nFile Uploaded Successfully to the server";
                                        
                                        
                                        $this->db->query("insert into tblautopayreq(user_id,amount,payment_type,transaction_id,status,add_date,ipaddress,remark,image_url,wallet_type) 
                                        values(?,?,?,?,?,?,?,?,?,?) ",
            				            array($user_id,$amount,$payment_type,trim($txnId),'Pending',$add_date,$ipaddress,$Remark,$uploads_dir,$type));
            					        $resparray = array(
                                				'message'=>'Your Request Submitted Successfully',
                                				'status'=>0
                                				);
                                		echo json_encode($resparray);  exit; 
                                    }     
                                }
                                else
                                {
                                    $response .= "\nFile Not Found Named --- > bill";
                                     $resparray = array(
                                				'message'=>'File not Found',
                                				'status'=>1
                                				);
                                	echo json_encode($resparray);exit;
                                }
                        	      
    				    	}
    				    	else
    				    	{
    				    	        $rsltpayreq = $this->db->query("select Id from tblautopayreq where transaction_id = ? ",array($txnId));
                    				if($rsltpayreq->num_rows() > 0)
                    				{
                    				    $resparray = array(
                        				'message'=>'Payment Request For This Transaction Id Already Exist',
                        				'status'=>1
                        				);
                        				echo json_encode($resparray);exit;
                    				
                    				}
                    				else
                    				{
                    			        $this->db->query("insert into tblautopayreq(user_id,amount,payment_type,transaction_id,status,add_date,ipaddress,remark,wallet_type) 
                    			        values(?,?,?,?,?,?,?,?,?) ",array($user_id,$amount,$payment_type,trim($txnId),'Pending',$add_date,$ipaddress,$Remark,$type));
    					
                    				//	$msg = $this->session->userdata("DistBusinessName").' request for '.$amount.' transfer in '.$payment_type.'  with ref.branch '.$txnId;
                    					//9137732050
                    				//	$this->load->model("Sms");
                    				//	$userinfo = $this->db->query("select * from tblusers where user_id = 1");
                    				    $resparray = array(
                        				'message'=>'Your Request Submit Successfully',
                        				'status'=>0
                        				);
                        				echo json_encode($resparray);exit;
                    					echo "Your Request Submit Successfully";exit;	        
                    				}
    				    	}
        				        
        				    
        					
        					
        				}
        			       
        		} 
			 
			    
        	
				
			}
			else
			{
				$resparray = array(
				'message'=>'Your account is deactivated. contact your Administrator',
				'status'=>1
				);
				echo json_encode($resparray);exit;
			}
		}
		else
		{
			$resparray = array(
				'message'=>'Invalid UserId or Password',
				'status'=>1
				);
				echo json_encode($resparray);exit;
		}
	
	
	}	
}
