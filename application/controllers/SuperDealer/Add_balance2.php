<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_balance2 extends CI_Controller {
	

	private $msg='';
	public function index() 
	{
		
		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{
			if(isset($_POST["ddlaction"]) and isset($_POST["txtAmount"]) and isset($_POST["txtRemark"]) ) 	
			{
				$ddlaction = trim($this->input->post("ddlaction"));
				$txtAmount = trim($this->input->post("txtAmount"));
				$txtRemark = trim($this->input->post("txtRemark"));
				$hidid = trim($this->input->post("hidid"));
				$dr_user_id = $this->session->userdata("SdId");
				
				$this->load->model("Ew2");
				$userinfo = $this->db->query("select user_id,businessname,username,usertype_name from tblusers where user_id = ?",array($hidid));
				if($ddlaction == "ADD")
				{
				    $wallet2 = $this->Ew2->getAgentBalance($dr_user_id);
    				if(floatval($wallet2) >= floatval($txtAmount))
    				{
    					    $description = $this->session->userdata("DistBusinessName")." To ".$userinfo->row(0)->businessname;
        					$payment_type = "CASH";
        					$this->Ew2->tblewallet_Payment_CrDrEntry($hidid,$dr_user_id,$txtAmount,$txtRemark,$description,$payment_type);
    				}
					
				}
				else if($ddlaction == "REVERT")
				{
				    $wallet2 = $this->Ew2->getAgentBalance($userinfo->row(0)->user_id);
				    if(floatval($wallet2) >= floatval($txtAmount))
				    {
				        $description = $userinfo->row(0)->businessname." To ".$userinfo->row(0)->businessname;
    					$payment_type = "CASH";
    					$this->Ew2->tblewallet_Payment_CrDrEntry($this->session->userdata("SdId"),$hidid,$txtAmount,$txtRemark,$description,$payment_type);    
				    }
					
				}
				if($userinfo->row(0)->usertype_name = 'MasterDealer')
				{
				    redirect(base_url()."SuperDealer/md_list?crypt=".$this->Common_methods->encrypt("MyData"));    
				}
				else if($userinfo->row(0)->usertype_name = 'Distributor')
				{
				    redirect(base_url()."SuperDealer/distributor_list?crypt=".$this->Common_methods->encrypt("MyData"));    
				}
				else if($userinfo->row(0)->usertype_name = 'Agent')
				{
				    redirect(base_url()."SuperDealer/agent_list?crypt=".$this->Common_methods->encrypt("MyData"));    
				}
				
				
				
			}
			else
			{
				if(isset($_GET["encrid"]))
				{
					$encrid = $this->Common_methods->decrypt(trim($_GET["encrid"]));
					$userinfo = $this->db->query("select user_id,businessname,username,usertype_name,add_date from tblusers where user_id = ?",array($encrid));
					if($userinfo->num_rows() == 1)
					{
						$this->view_data["message"] = "";
						$this->view_data["userinfo"] = $userinfo;
						$this->load->view("SuperDealer/add_balance2_view",$this->view_data);
					}
					
				}
				
			}
		}
	}	
}