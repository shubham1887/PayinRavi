<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AddDmtBalance extends CI_Controller {
	

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
        				$userinfo = $this->db->query("select user_id,businessname,username,usertype_name,flatcomm2,mobile_no from tblusers where mobile_no = ?",array($Mobile));
        				if($userinfo->num_rows() == 1)
        				{
        				    $cr_user_id = $userinfo->row(0)->user_id;
        				    $dr_user_id = 1;
        					$description = "Admin To ".$userinfo->row(0)->businessname;
        					$ddlpaymentType = "CASH";
        					
        					$ewrslt = $this->Ew2->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$amount,$txtRemark,$description,$ddlpaymentType);
        					if($ewrslt == true)
        					{
        					    $this->load->model("Sms");
                    			$this->Sms->receiveBalance($userinfo,$amount);
                    			if($chkflatcomm == "yes")
                    			{
                    			    $flatcom = floatval($userinfo->row(0)->flatcomm2);
                    			   // echo $flatcom;exit;
                        			$usertype_name = $userinfo->row(0)->usertype_name;
                        			if($usertype_name == "MasterDealer" or $usertype_name == "Distributor" or $usertype_name == "SuperDealer")
                        			{
                        				if($flatcom > 0)
                        				{
                        					$payment_type = "FLAT_COMM";
                        					$actfcom = ((floatval($amount) * $flatcom)/100);
                        					$tds = (($actfcom * 5)/100);
                        					$actfcom_aftertds = $actfcom - $tds;
                        					//echo $tds."   ".$actfcom_aftertds;exit;
                        					$this->Ew2->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$actfcom_aftertds,"Commission  ".$flatcom." %",$description,$payment_type,$tds);
                        				}
                        			}
                    			}
        					    
        					}
        					
            				 $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
                    		 $MESSAGEBOX_MESSAGETYPE = $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Balance Added Successfully");
                    	
        				    redirect(base_url()."_Admin/AddDmtBalance?crypt=".$this->Common_methods->encrypt("MyData"));
        				}
        				else
        				{
        				    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
                		    $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","No User Found");
        				    redirect(base_url()."_Admin/AddDmtBalance?crypt=".$this->Common_methods->encrypt("MyData"));
        				}
    				}
    				else
    				{
    				    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
            		    $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Invalid Amount Entered");
    				    redirect(base_url()."_Admin/AddDmtBalance?crypt=".$this->Common_methods->encrypt("MyData"));
    				}
				}
				else
				{
				     //Invalid Mobile Number Entered
				     $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
        		     $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Invalid Mobile Number Entered");
    				 redirect(base_url()."_Admin/AddDmtBalance?crypt=".$this->Common_methods->encrypt("MyData"));
				}
				
				
				
				
			    	
			}
			else
			{
			    $this->view_data["userdata"] = $this->getUserForAutocompleteTextBox();
				$this->view_data["message"] = "";
				$this->load->view("_Admin/AddDmtBalance_view",$this->view_data);	
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
	        $rsltusers = $this->db->query("select user_id,businessname,mobile_no,usertype_name,balance from tblusers order by businessname");
	        foreach($rsltusers->result() as $rwuser)
	        {
	            $users.=str_replace(",","",$rwuser->businessname)." - ".$rwuser->mobile_no." - ".$rwuser->usertype_name." - ₹".$this->Ew2->getAgentBalance($rwuser->user_id)."@@";
	        }
	        return $users;
	    //}
	}
}