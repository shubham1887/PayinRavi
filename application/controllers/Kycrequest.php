<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kycrequest extends CI_Controller {
	
	
	private $msg='';
	
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('TempAgentUserType') != "Agent") 
        { 
            redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
        }
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

		if ($this->session->userdata('TempAgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
		}				
		else 		
		{ 	
		   if(isset($_POST["hidstatus"]))
		   {
		       //print_r($this->input->post());exit;
		       $hidstatus = $this->input->post("hidstatus");
		       $hidrechargeid = $this->input->post("hidrechargeid");
			   $hidremark = $this->input->post("hidremark");
		       $documentinfo = $this->db->query("select a.user_id,a.status,b.mobile_no from mpay_documents.documents a left join tblusers b on a.user_id = b.user_id where a.user_id = ?",array($hidrechargeid));
		       if($documentinfo->num_rows() == 1)
		       {
		            $doc_status = $documentinfo ->row(0)->status;
		            $user_id = $documentinfo ->row(0)->user_id;
		            $mobile_no = $documentinfo ->row(0)->mobile_no;
		            if($doc_status == "PENDING")
		            {
		                if($hidstatus == "REJECTED")
		                {
		                    $this->db->query("update tblusers set kyc = 'no' where user_id = ?",array( $user_id));
		                    $this->db->query("delete from  mpay_documents.documents where user_id = ?",array( $user_id));
		                    
		                    
		                    $smsMessage= "Dear Business Partner your KYC has been Rejected due to ".$hidremark.".Thanks MasterPay.pro";
		                    $this->common->ExecuteSMSApi($mobile_no,$smsMessage);
		                    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
		                    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","Kyc Request Rejected Successfully");
		                    redirect(base_url()."_Admin/kycrequest_list");
		                }
		                else if($hidstatus == "APPROVED")
		                {
		                    $this->db->query("update mpay_documents.documents set status = 'APPROVED',approve_date = ? where user_id = ?",array( $this->common->getDate(),$user_id));
		                    $this->db->query("update tblusers set kyc = 'yes' where user_id = ?",array( $user_id));
		                    
		                    $smsMessage= "Dear Business Partner your KYC has been approved, now you can start DMT business.Thanks MasterPay.pro";
		                    $this->common->ExecuteSMSApi($mobile_no,$smsMessage);
		                    
		                    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
		                    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","Kyc Request Approved Successfully");
		                    redirect(base_url()."_Admin/kycrequest_list");
		                }
		               
		                
		            }
		            else
		            {
		                 $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
	                    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","Kyc Request Not Pending");
	                    redirect(base_url()."_Admin/kycrequest_list");
		            }
		            
		            
		       }
		       else
		       {
		           $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
	               $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","Kyc Request Not Found");
		       }
		       
		       
		   }
		   else if($this->input->post('txtPanNo') and $this->input->post('txtAadhar'))
		   {
			        $user_id = $this->session->userdata("TempAgentId");
			        
			        $PANnumber = $this->input->post("txtPanNo");
			        $Aadharynumber = $this->input->post("txtAadhar");
			        $image1 = false;
					$image2 = false;
					$image3 = false;
					$image4 = false;
					$image5 = false;
					$image6 = false;
					$image7 = false;
					$image8 = false;
					
					
					$pan = "no";
					$aadhar_front = "no";
					$aadhar_back = "no";
					$cancel_cheqe = "no";
					$application_from1 = "no";
					$application_from2 = "no";
					$schedule_c = "no";
					$govproff = "no";
					$checque = "no";
					
					$pancard_image = "";
					$aadhar_front_image = "";
					$aadhar_back_image = "";
					$application_form1_image = "";
					$application_form2_image = "";
					$schedule_c_image = "";
					$govproff_image = "";
					$checque_image = "";
					
					putenv("TZ=Asia/Calcutta");
					date_default_timezone_set('Asia/Calcutta');
					$date = date("Y-m-d H:i:s");
		    	    if (is_uploaded_file($_FILES['image']['tmp_name'])) 
            	    {
            	        $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
                        $expensions= array("jpeg","jpg","png", "JPEG","JPG", "PNG");
                        if(in_array($file_ext,$expensions)=== false)
                        {
                             $errors[]="extension not allowed, please choose a JPEG or PNG file.";
                             $this->session->set_flashdata("message","extension not allowed, please choose a JPEG or PNG file") ;
							//redirect(base_url()."Retailer/kycrequest?crypt=".$this->Common_methods->encrypt("MyData"));   
                        }
                        else
                        {
                            
                            if (!file_exists('uploads/'.$user_id)) 
                            {
                                mkdir('uploads/'.$user_id, 0777, true);
                            }
                            $uploads_dir = "uploads/".$user_id."/pancard".$this->common->getDate().$_FILES["image"]["name"];
                            $tmp_name = $_FILES['image']['tmp_name'];
                            $pic_name = $_FILES['image']['name'];
                            $response .= "\nFile Name : ".$_FILES['image']['name'];
                            move_uploaded_file($tmp_name, $uploads_dir);
                            $response .= "\nFile Uploaded Successfully to the server";
                            $pan_image_path =  $uploads_dir;
                            $image1 = true;    
    						$pan = "yes";
                        }
            	        
						
            	       
                    }
					if (is_uploaded_file($_FILES['image_front']['tmp_name'])) 
            	    {
            	        $file_ext=strtolower(end(explode('.',$_FILES['image_front']['name'])));
                        $expensions= array("jpeg","jpg","png", "JPEG","JPG", "PNG");
                        if(in_array($file_ext,$expensions)=== false)
                        {
                             $errors[]="extension not allowed, please choose a JPEG or PNG file.";
                             $this->session->set_flashdata("message","extension not allowed, please choose a JPEG or PNG file") ;
							//redirect(base_url()."Retailer/kycrequest?crypt=".$this->Common_methods->encrypt("MyData"));   
                        }
                        else
                        {
                            
                            $aadhar_front = "yes";
                            $response .= "\nFile Found";
                            
                            
                            if (!file_exists('uploads/'.$user_id)) 
                            {
                                mkdir('uploads/'.$user_id, 0777, true);
                            }
                            $uploads_dir = "uploads/".$user_id."/aadhar_front".$this->common->getDate().$_FILES["image_front"]["name"];
                            $tmp_name = $_FILES['image_front']['tmp_name'];
                            $pic_name = $_FILES['image_front']['name'];
                            $response .= "\nFile Name : ".$_FILES['image_front']['name'];
                            move_uploaded_file($tmp_name, $uploads_dir);
                            $response .= "\nFile Uploaded Successfully to the server";
                            
                            $aadhar_front_image_path =  $uploads_dir;
                            $image2 = true;
    						$aadhar_front = "yes";
                        }
            	        
            	       
                    }
					if (is_uploaded_file($_FILES['image_back']['tmp_name'])) 
            	    {
            	        $file_ext=strtolower(end(explode('.',$_FILES['image_back']['name'])));
                        $expensions= array("jpeg","jpg","png", "JPEG","JPG", "PNG");
                        if(in_array($file_ext,$expensions)=== false)
                        {
                             $errors[]="extension not allowed, please choose a JPEG or PNG file.";
                             $this->session->set_flashdata("message","extension not allowed, please choose a JPEG or PNG file") ;
						//	redirect(base_url()."Retailer/kycrequest?crypt=".$this->Common_methods->encrypt("MyData"));   
                        }
                        else
                        {
                           
                            $response .= "\nFile Found";
                            
                            
                            if (!file_exists('uploads/'.$user_id)) 
                            {
                                mkdir('uploads/'.$user_id, 0777, true);
                            }
                            $uploads_dir = "uploads/".$user_id."/aadhar_front".$this->common->getDate().$_FILES["image_back"]["name"];
                            $tmp_name = $_FILES['image_back']['tmp_name'];
                            $pic_name = $_FILES['image_back']['name'];
                            $response .= "\nFile Name : ".$_FILES['image_back']['name'];
                            move_uploaded_file($tmp_name, $uploads_dir);
                            $response .= "\nFile Uploaded Successfully to the server";
                            
                            $aadhar_back_image_path =  $uploads_dir;
                           
                            
                            
                            
    						$image3 = true;
    						$aadhar_back = "yes";
                        }
						
            	       
                    }
				    if (is_uploaded_file($_FILES['cancheq']['tmp_name'])) 
                    {
                        $file_ext=strtolower(end(explode('.',$_FILES['cancheq']['name'])));
                        $expensions= array("jpeg","jpg","png", "JPEG","JPG", "PNG");
                        if(in_array($file_ext,$expensions)=== false)
                        {
                             $errors[]="extension not allowed, please choose a JPEG or PNG file.";
                             $this->session->set_flashdata("message","extension not allowed, please choose a JPEG or PNG file") ;
                        }
                        else
                        {
                            $response .= "\nFile Found";
                            
                            
                            if (!file_exists('uploads/'.$user_id)) 
                            {
                                mkdir('uploads/'.$user_id, 0777, true);
                            }
                            $uploads_dir = "uploads/".$user_id."/cancheq".$this->common->getDate().$_FILES["cancheq"]["name"];
                            $tmp_name = $_FILES['cancheq']['tmp_name'];
                            $pic_name = $_FILES['cancheq']['name'];
                            $response .= "\nFile Name : ".$_FILES['cancheq']['name'];
                            move_uploaded_file($tmp_name, $uploads_dir);
                            $response .= "\nFile Uploaded Successfully to the server";
                            
                            $path_cancheq = $uploads_dir;
                            
                            $image8 = true;
                            $checque = "yes";
                        }  
                    }
				   
				    
				    if($pan == "yes" )	
					{
					    $rsltinert = $this->db->query("insert into mpay_documents.documents(user_id,doc_type,document_number,docum,add_date,ipaddress,image_path)
						values(?,?,?,?,?,?,?)",
										array(
										    $user_id,
										    "PANCARD",
											$PANnumber,
											$pancard_image,
											$date,
											$this->common->getRealIpAddr(),
											$pan_image_path
										));
					}
					if($aadhar_front == "yes" )	
					{
					    
					    
					    
					    $rsltinert = $this->db->query("insert into mpay_documents.documents(user_id,doc_type,document_number,docum,add_date,ipaddress,image_path)
						values(?,?,?,?,?,?,?)",
										array(
										    $user_id,
										    "AADHAR_FRONT",
											$Aadharynumber,
											$aadhar_front_image,
											$date,
											$this->common->getRealIpAddr(),
											$aadhar_front_image_path
										));
					}
					if($aadhar_back == "yes")	
					{
					    $rsltinert = $this->db->query("insert into mpay_documents.documents(user_id,doc_type,document_number,docum,add_date,ipaddress,image_path)
						values(?,?,?,?,?,?,?)",
										array(
										    $user_id,
										    "AADHAR_BACK",
											$Aadharynumber,
											$aadhar_back_image,
											$date,
											$this->common->getRealIpAddr(),
											$aadhar_back_image_path
										));
					}
					if($checque == "yes")   
                    {
                        $rsltinert = $this->db->query("insert into mpay_documents.documents(user_id,doc_type,docum,add_date,ipaddress,image_path)
                        values(?,?,?,?,?,?)",
                                        array(
                                            $user_id,
                                            "CANCHEQUE",
                                            $checque_image,
                                            $date,
                                            $this->common->getRealIpAddr(),
                                            $path_cancheq
                                        ));
                    }
					
					
					    
					    
					    
					$this->session->set_flashdata("message","KYC Uploaded");				
					redirect(base_url()."kycrequest");
				
				    
				    
			}					
			
			else
			{
				$user=$this->session->userdata('TempAgentUserType');
				if(trim($user) == 'Agent')
				{
				   
				    $user_id= $this->session->userdata("TempAgentId");
				    $docarray = array();
				    $rsltuserdoc = $this->db->query("select * from mpay_documents.documents where user_id = ? and status !='REJECTED'",array($user_id));
				    foreach($rsltuserdoc->result() as $rwdoc)
				    {
				        $docarray[$rwdoc->doc_type] = $rwdoc;
				    }
					$this->view_data['message'] =$this->msg;
					$this->view_data['docdata'] =$docarray;
					$this->load->view('kycrequest_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
}