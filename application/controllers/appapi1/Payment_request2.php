<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_request2 extends CI_Controller {
	private function logentry($data)
	{
		
	}
	public function index()
	{ 
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
	   $resp = json_encode($this->input->post());
	    $get = json_encode($this->input->get());
	   $this->logentry("post".$resp);
	      $this->logentry($get);
		
		
			if(isset($_GET['username']) && isset($_GET['pwd']) && isset($_GET["payment_type"]) && isset($_GET["amount"])  && isset($_GET["txnId"])   && isset($_GET["Remark"])   && isset($_GET["type"])    && isset($_GET["bank_id"]))
			{
			    $username = $_GET['username'];
			    $pwd =  $_GET['pwd'];
			    $payment_type =  $_GET['payment_type'];
			   
			    $amount =  $_GET['amount'];
			    $txnId =  $_GET['txnId'];
			    $Remark =  $_GET['Remark'];
			    $type = $_GET["type"];
                $bank_id= 0;
                if(isset($_GET["bank_id"]))
                {
                    $bank_id = intval(trim($this->input->get("bank_id")));
                }

                $host_id = $this->Common_methods->getHostId($this->white->getDomainName());
                $userinfo = $this->db->query("select user_id,parentid,businessname,username,status,mobile_no,usertype_name,password from tblusers where username = ? and password = ? and host_id = ?",array($username,$pwd,$host_id));
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
                    $parentid = $userinfo->row(0)->parentid;

                    if($usertype_name == "Agent")
                    {
                        $parent_info = $this->db->query("select user_id,usertype_name,parentid from tblusers where user_id = ?",array($parentid));
                        if($parent_info->num_rows() == 1)
                        {
                            $parent_type = $parent_info->row(0)->usertype_name;
                            if($parent_type == "Distributor")
                            {
                                $MdId = $parent_info->row(0)->parentid;
                                $check_CREATE_GROUP_rights = $this->db->query("select user_id from access_rights_alloted where user_id = ? and rights_id = (select Id from access_rights where rights_name = 'BLOCK_DOWNLINE_PAYREQ')",array($MdId));
                                if($check_CREATE_GROUP_rights->num_rows() == 1)
                                {
                                     $resparray = array(
                                                'message'=>'Payment Request Failed',
                                                'status'=>1
                                                );
                                    echo json_encode($resparray);exit;
                                }
                            }
                        }    
                    }
                    else if($usertype_name == "Distributor")
                    {
                       $MdId = $userinfo->row(0)->parentid;
                       $check_CREATE_GROUP_rights = $this->db->query("select user_id from access_rights_alloted where user_id = ? and rights_id = (select Id from access_rights where rights_name = 'BLOCK_DOWNLINE_PAYREQ')",array($MdId));
                        if($check_CREATE_GROUP_rights->num_rows() == 1)
                        {
                             $resparray = array(
                                        'message'=>'Payment Request Failed',
                                        'status'=>1
                                        );
                            echo json_encode($resparray);exit;
                        }
                    }

                    




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
                                    if (false)
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
                                        if ($bank_id != null) {
                                            // code...
                                        
                                         
                                        $resp_insert = $this->db->query("insert into tblautopayreq
                                            (
                                            user_id,amount,payment_type,
                                            transaction_id,status,add_date,ipaddress,
                                            client_remark,wallet_type,host_id,
                                            admin_bank_account_id,request_to_user_id) 
                                        values(?,?,?,?,?,?,?,?,?,?,?,?) ",array($user_id,$amount,$payment_type,trim($txnId),'Pending',$add_date,$ipaddress,$Remark,$type,$host_id,$bank_id,1));
                                
                                    if($resp_insert == true)
                                    {
                                        $resparray = array(
                                                'message'=>'Your Request Submit Successfully',
                                                'status'=>0
                                                );
                                        echo json_encode($resparray);exit;
                                    }
                                    else
                                    {
                                        $resparray = array(
                                                'message'=>'Some Error Occured. Try After Some Time',
                                                'status'=>1
                                                );
                                        echo json_encode($resparray);exit;
                                    }
                                        //  $msg = $this->session->userdata("DistBusinessName").' request for '.$amount.' transfer in '.$payment_type.'  with ref.branch '.$txnId;
                                            //9137732050
                                        //  $this->load->model("Sms");
                                        //  $userinfo = $this->db->query("select * from tblusers where user_id = 1");
                                                
                                                echo "Your Request Submit Successfully";exit;
                                    } 
                                     else
                                    {
                                        $resparray = array(
                                                'message'=>'Bank select required',
                                                'status'=>1
                                                );
                                        echo json_encode($resparray);exit;
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
			else
			{echo 'Paramenter is missing 2';exit;}			
	
	
	}	
}
