<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cash_entry extends CI_Controller {
	

	private $msg='';
	public function index() 
	{
		error_reporting(E_ALL);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{
		    
			if(isset($_POST["txtAgentMobile"]) and isset($_POST["txtReceivedAmount"]) and isset($_POST["txtRemark"]) ) 	
			{
				$txtAgentMobile = trim($this->input->post("txtAgentMobile"));
				$txtAmount = 0;
				$txtReceivedAmount = trim($this->input->post("txtReceivedAmount"));
				$txtRemark = substr(trim($this->input->post("txtRemark")),0,120);
				$ddlpaymentType = trim($this->input->post("ddlpaymentType"));
				$chkflatcomm = trim($this->input->post("chkflatcomm"));
				$amount = floatval($txtAmount);
				$Mobile = $txtAgentMobile;

				
				if(strlen($Mobile) == 10)
				{
				    if($txtReceivedAmount > 0)
    				{
    				    $this->load->model("Common_methods");
        				$userinfo = $this->db->query("select user_id,businessname,username,usertype_name,flatcomm,mobile_no from tblusers where mobile_no = ?",array($Mobile));
        				if($userinfo->num_rows() == 1)
        				{
        				    $cr_user_id = $userinfo->row(0)->user_id;
        				    $dr_user_id = 1;
        					$description = "Admin To ".$userinfo->row(0)->businessname;
        					$ddlpaymentType = "CASH";
        					$admin_remark = "";
        					$is_revert = false;
        					$payment_received = $txtReceivedAmount;
        					$acc_parent_id = 1;
        					$acc_child_id = $userinfo->row(0)->user_id;

        					$acc_credit_amount = 0;
        					$creditrevert = 0;
        					$payment_received = $txtReceivedAmount;

        					$remark = $txtRemark;
        					$add_date = $this->common->getDate();

        					$this->load->model("Credit_master");
        					$this->Credit_master->credit_entry($acc_parent_id,$acc_child_id,$acc_credit_amount,$creditrevert,$payment_received,$remark,$add_date);	
        					
            				 $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
                    		 $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Balance Added Successfully");
                    	
        				    redirect(base_url()."_Admin/Cash_entry?crypt=".$this->Common_methods->encrypt("MyData"));
        				}
        				else
        				{
        				    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
                		    $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","No User Found");
        				    redirect(base_url()."_Admin/Cash_entry?crypt=".$this->Common_methods->encrypt("MyData"));
        				}
    				}
    				else
    				{
    				    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
            		    $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Invalid Amount Entered");
    				    redirect(base_url()."_Admin/Cash_entry?crypt=".$this->Common_methods->encrypt("MyData"));
    				}
				}
				else
				{
				     //Invalid Mobile Number Entered
				     $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
        		     $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Invalid Mobile Number Entered");
    				 redirect(base_url()."_Admin/Cash_entry?crypt=".$this->Common_methods->encrypt("MyData"));
				}
				
				
				
				
			    	
			}
			else
			{
			    $this->view_data["userdata"] = $this->getUserForAutocompleteTextBox();
				$this->view_data["message"] = "";
				$this->load->view("_Admin/cash_entry_view",$this->view_data);	
			}
		}
	}
	private function getUserForAutocompleteTextBox()
	{
		$this->load->model("Credit_master");
	   // error_reporting(-1);
	   // ini_set('display_errors',1);
	   // $this->db->db_debug = TRUE;
	    //if(isset($_POST["inputdata"]))
	    //{
	        $users = '';
	        //$inputdata = trim($this->input->post("inputdata"));
	        //$inputdata = '%'.$inputdata.'%';
	        $rsltusers = $this->db->query("select user_id,businessname,mobile_no,usertype_name,balance from tblusers order by businessname");
	        foreach($rsltusers->result() as $rwuser)
	        {
	        	$outstanding = $this->Credit_master->getcredit(1,$rwuser->user_id);
	            $users.=str_replace(",","",$rwuser->businessname)." - ".$rwuser->mobile_no." - ".$rwuser->usertype_name." - ₹".$rwuser->balance." - ".$outstanding."@@";
	        }
	        return $users;
	    //}
	}
}