<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kycrequest_list extends CI_Controller {
	
	
	private $msg='';
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
			if(isset($_POST["hidstatus"]) and isset($_GET["id"]))
		   {
		       //print_r($this->input->post());exit;
		       $hidstatus = $this->input->post("hidstatus");
		       $hidrechargeid = $this->input->post("hidrechargeid");
			   $hidremark = $this->input->post("hidremark");
		       $documentinfo = $this->db->query("select a.Id,a.user_id,a.status,b.mobile_no from mpay_documents.documents a left join tblusers b on a.user_id = b.user_id where a.Id = ?",array($hidrechargeid));
		       //print_r($documentinfo->result());exit;
		       if($documentinfo->num_rows() == 1)
		       {
		            $doc_status = $documentinfo ->row(0)->status;
		            $user_id = $documentinfo ->row(0)->user_id;
		            $mobile_no = $documentinfo ->row(0)->mobile_no;
		            if($doc_status == "PENDING" or $doc_status == "")
		            {
		                //echo $hidstatus;exit;
		                if($hidstatus == "REJECTED")
		                {
		                    
		                   
		                    $this->db->query("update  mpay_documents.documents set status = 'Rejected',ramark = ? where Id = ? ",array($hidremark, $documentinfo->row(0)->Id));
		                    
		                    
		                    $smsMessage= "Dear Business Partner your KYC has been Rejected due to ".$hidremark.".Thanks DezireMoney";
		                    //$this->common->ExecuteSMSApi($mobile_no,$smsMessage);
		                    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
		                    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","Kyc Request Rejected Successfully");
		                    redirect(base_url()."_Admin/kycrequest_list?id=".$this->input->get("id"));
		                }
		                else if($hidstatus == "APPROVED")
		                {
		                    $this->db->query("update mpay_documents.documents set status = 'APPROVED',approve_date = ?,ramark = ? where Id = ?",array( $this->common->getDate(),$hidremark,$documentinfo->row(0)->Id));
		                    
		                    $smsMessage= "Dear Business Partner your KYC has been approved, now you can start DMT business.Thanks DezireMoney";
		                    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
		                    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","Kyc Request Approved Successfully");
		                     redirect(base_url()."_Admin/kycrequest_list?id=".$this->input->get("id"));
		                }
		               
		                
		            }
		            else
		            {
		                 $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
	                    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","Kyc Request Not Pending");
	                   redirect(base_url()."_Admin/kycrequest_list?id=".$this->input->get("id"));
		            }
		            
		            
		       }
		       else
		       {
		           $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
	               $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","Kyc Request Not Found");
		       }
		       
		       
		   }					
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$this->view_data['result_recharge'] = $this->db->query("
					SELECT 
					    a.image_path,a.Id,a.user_id,a.add_date,a.status,a.doc_type,a.docum ,a.document_number,a.ramark,
					    b.businessname,b.usertype_name,b.mobile_no
					    from mpay_documents.documents a  
					    left join tblusers b on a.user_id = b.user_id
					    where 
					    (a.status = 'PENDING' or a.status = '') 
					    
					    order by a.add_date");
					$this->view_data['message'] =$this->msg;
					$this->load->view('_Admin/kycrequest_list_view',$this->view_data);			
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
}