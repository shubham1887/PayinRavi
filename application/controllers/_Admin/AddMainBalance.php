<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AddMainBalance extends CI_Controller {
	

	private $msg='';
	public function payment_duplication($cr_user_id,$dr_user_id,$amount)
	{
		putenv("TZ=Asia/Calcutta");
		date_default_timezone_set('Asia/Calcutta');
		$add_date = date("Y-m-d H");	

		 $rslt = $this->db->query("insert into locking_payment_duplication (cr_user_id,dr_user_id,add_date,ipaddress,amount) values(?,?,?,?,?)",array($cr_user_id,$dr_user_id,$add_date,$this->common->getRealIpAddr(),$amount));
		  if($rslt == "" or $rslt == NULL)
		  {
			return false;
		  }
		  else
		  {
			return true;
		  }
	}
	public function index() 
	{
		// error_reporting(E_ALL);
		// ini_set('display_errors',1);
		// $this->db->db_debug = TRUE;
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
				$userinfo = $this->db->query("select user_id,businessname,username,usertype_name,flatcomm,mobile_no from tblusers where mobile_no = ?",array($Mobile));
				//print_r($userinfo->result());exit;

				if(strlen($Mobile) == 10)
				{
				    if($amount > 0)
    				{
    				    $this->load->model("Common_methods");
        				
        				if($userinfo->num_rows() == 1)
        				{
        				    $cr_user_id = $userinfo->row(0)->user_id;
        				    $dr_user_id = 1;
        					$description = "Admin To ".$userinfo->row(0)->businessname;
        					$admin_remark = "";
        					$is_revert = false;
        					$payment_received = $txtReceivedAmount;
        					$acc_parent_id = 1;
        					$acc_child_id = $userinfo->row(0)->user_id;

        					if($this->payment_duplication($cr_user_id,$dr_user_id,$amount))
        					{
        						$ewrslt = $this->Insert_model->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$amount,$txtRemark,$description,$ddlpaymentType,$admin_remark,$is_revert,$payment_received,$acc_parent_id,$acc_child_id);
	        					if($ewrslt == true)
	        					//if(true)
	        					{
	        					    $this->load->model("Sms");
	                     			$this->Sms->receiveBalance($userinfo,$txtAmount);
	                    			if($chkflatcomm == "yes")
	                    			{
	                    			    $flatcom = floatval($userinfo->row(0)->flatcomm);
	                        			$usertype_name = $userinfo->row(0)->usertype_name;
	                        			if($usertype_name == "MasterDealer" or $usertype_name == "Distributor" or $usertype_name == "APIUSER"  or $usertype_name == "Agent")
	                        			{
	                        				if($flatcom > 0)
	                        				{
	                        					$actfcom = ((floatval($amount) * $flatcom)/100);
	                        					$admin_remark = "";
	                        					$this->Insert_model->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$actfcom,"Commission  ".$flatcom." %",$description,$ddlpaymentType,$admin_remark);
	                        				}
	                        			}
	                    			}
	        					    
	        					}
	        					
	            				 $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
	                    		 $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Balance Added Successfully");
	                    	
	        				    redirect(base_url()."_Admin/AddMainBalance?crypt=".$this->Common_methods->encrypt("MyData"));	
        					}
        					else
        					{
        						$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
	                		    $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Duplicate Payment.Please try differet amount or try after  1 hour");
	        				    redirect(base_url()."_Admin/AddMainBalance?crypt=".$this->Common_methods->encrypt("MyData"));		
        					}
        					
        				}
        				else
        				{
        				    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
                		    $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","No User Found");
        				    redirect(base_url()."_Admin/AddMainBalance?crypt=".$this->Common_methods->encrypt("MyData"));
        				}
    				}
    				else
    				{


    						$this->load->model("Credit_master");
							$acc_parent_id = 1;
							$acc_child_id = $userinfo->row(0)->user_id;
							$acc_credit_amount = 0;
							$creditrevert = 0;
							$remark = $txtRemark;
							$payment_received = $txtReceivedAmount; 
							$add_date = $this->common->getDate();
							$this->Credit_master->credit_entry($acc_parent_id,$acc_child_id,$acc_credit_amount,$creditrevert,$payment_received,$remark,$add_date);	
							


    				    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
            		    $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Transaction Done");
    				    redirect(base_url()."_Admin/AddMainBalance?crypt=".$this->Common_methods->encrypt("MyData"));
    				}
				}
				else
				{
				     //Invalid Mobile Number Entered
				     $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
        		     $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Invalid Mobile Number Entered");
    				 redirect(base_url()."_Admin/AddMainBalance?crypt=".$this->Common_methods->encrypt("MyData"));
				}
				
				
				
				
			    	
			}
			else
			{
			    $this->view_data["userdata"] = $this->getUserForAutocompleteTextBox();
				$this->view_data["message"] = "";
				$this->load->view("_Admin/AddMainBalance_view",$this->view_data);	
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
	            $users.=str_replace(",","",$rwuser->businessname)." ^-^ ".$rwuser->mobile_no." ^-^ ".$rwuser->usertype_name." ^-^ ₹".$rwuser->balance." ^-^ ".$outstanding."@@";
	        }
	        return $users;
	    //}
	}
}