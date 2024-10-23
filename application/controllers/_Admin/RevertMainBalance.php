<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RevertMainBalance extends CI_Controller {
	

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
// 		error_reporting(-1);
// 		ini_set('display_errors',1);
// 		$this->db->db_debug = TRUE;
    }
    function clear_cache()
    {
        $this->load->model("Api_model");
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
	public function index() 
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{
		    
			if(isset($_POST["txtAgentMobile"]) and isset($_POST["txtAmount"]) and isset($_POST["txtReceivedAmount"]) and isset($_POST["txtRemark"]) ) 	
			{
				$txtAgentMobile = trim($this->input->post("txtAgentMobile"));
				$txtAmount = intval(trim($this->input->post("txtAmount")));
				$txtReceivedAmount = trim($this->input->post("txtReceivedAmount"));
				$txtRemark = substr(trim($this->input->post("txtRemark")),0,120);
				$ddlpaymentType = trim($this->input->post("ddlpaymentType"));
				$chkflatcomm = trim($this->input->post("chkflatcomm"));
				$amount = floatval($txtAmount);
				$Mobile = $txtAgentMobile;
				if(strlen($Mobile) == 10)
				{
				    if($amount > 0)
    				{
    				    $this->load->model("Common_methods");
        				$userinfo = $this->db->query("select user_id,businessname,username,usertype_name,flatcomm,mobile_no from tblusers where mobile_no = ?",array($Mobile));
        				if($userinfo->num_rows() == 1)
        				{
        				    $dr_user_id = $userinfo->row(0)->user_id;
        				    $cr_user_id = 1;
        					$description = "Revert From :".$userinfo->row(0)->businessname." To Admin";
        					$ddlpaymentType = "CASH";
        					
        					$ewrslt = $this->Insert_model->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$amount,$txtRemark,$description,$ddlpaymentType);
        					if($ewrslt == true)
        					{
        					    $this->load->model("Sms");
                    			$this->Sms->revertBalance($userinfo,$amount);
                    			if($chkflatcomm == "yes")
                    			{
                    			    $flatcom = floatval($userinfo->row(0)->flatcomm);
                        			$usertype_name = $userinfo->row(0)->usertype_name;
                        			if($usertype_name == "MasterDealer" or $usertype_name == "Distributor" or $usertype_name == "SuperDealer")
                        			{
                        				if($flatcom > 0)
                        				{
                        					$actfcom = ((floatval($amount) * $flatcom)/100);
                        					$this->Insert_model->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$actfcom,"Commission  ".$flatcom." %",$description,$payment_type);
                        				}
                        			}
                    			}
        					    
        					}
        					
            				 $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
                    		 $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Balance Added Successfully");
                    	
        				    redirect(base_url()."_Admin/RevertMainBalance?crypt=".$this->Common_methods->encrypt("MyData"));
        				}
        				else
        				{
        				    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
                		    $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","No User Found");
        				    redirect(base_url()."_Admin/RevertMainBalance?crypt=".$this->Common_methods->encrypt("MyData"));
        				}
    				}
    				else
    				{
    				    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
            		    $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Invalid Amount Entered");
    				    redirect(base_url()."_Admin/RevertMainBalance?crypt=".$this->Common_methods->encrypt("MyData"));
    				}
				}
				else
				{
				     //Invalid Mobile Number Entered
				     $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
        		     $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Invalid Mobile Number Entered");
    				 redirect(base_url()."_Admin/RevertMainBalance?crypt=".$this->Common_methods->encrypt("MyData"));
				}
				
				
				
				
			    	
			}
			else
			{
			    $this->view_data["userdata"] = $this->getUserForAutocompleteTextBox();
				$this->view_data["message"] = "";
				$this->load->view("_Admin/RevertMainBalance_view",$this->view_data);	
			}
		}
	}
	private function getUserForAutocompleteTextBox()
	{
	   // error_reporting(-1);
	   // ini_set('display_errors',1);
	   // $this->db->db_debug = TRUE;
	    //if(isset($_POST["inputdata"]))
	    //{
	        $users = '';
	        //$inputdata = trim($this->input->post("inputdata"));
	        //$inputdata = '%'.$inputdata.'%';
	        $rsltusers = $this->db->query("select businessname,mobile_no,usertype_name,balance from tblusers order by businessname");
	        foreach($rsltusers->result() as $rwuser)
	        {
	            $users.=str_replace(",","",$rwuser->businessname)." - ".$rwuser->mobile_no." - ".$rwuser->usertype_name." - ₹".$rwuser->balance."@@";
	        }
	        return $users;
	    //}
	}
}