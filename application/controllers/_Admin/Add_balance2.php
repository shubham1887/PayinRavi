<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_balance2 extends CI_Controller {
	

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
		
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{
			if(isset($_POST["ddlaction"]) and isset($_POST["txtAmount"]) and isset($_POST["txtRemark"]) ) 	
			{
				$ddlaction = trim($this->input->post("ddlaction"));
				$txtAmount = intval(trim($this->input->post("txtAmount")));
				$txtRemark = trim($this->input->post("txtRemark"));
				$hidid = intval(trim($this->input->post("hidid")));
				

				if($txtAmount > 0)
				{
					$this->load->model("Ew2");
					$userinfo = $this->db->query("select user_id,businessname,username,usertype_name,flatcomm2 from tblusers where user_id = ?",array($hidid));
					if($userinfo->num_rows() == 1)
					{
						if($ddlaction == "ADD")
						{
							$flatcomm2 = floatval($userinfo->row(0)->flatcomm2);
							$cr_user_id = $userinfo->row(0)->user_id;
							$description = "Admin To ".$userinfo->row(0)->businessname;
							$payment_type = "CASH";
							
							$this->Ew2->tblewallet_Payment_CrEntry_From_Admin($hidid,1,$txtAmount,$txtRemark,$description,$payment_type);

							$this->load->model("Sms");
            				$this->Sms->receiveBalance($userinfo,$txtAmount);

							if($flatcomm2 > 0)
		    				{ 	
		    					$payment_type = "Commission";

		    					$actfcom = ((floatval($txtAmount) * $flatcomm2)/100);
		    					$tds = (($actfcom * 5)/100);

		    					$com_remark = "Commission  ".$flatcomm2." %  Tds : ".$tds;
		    					$actfcom_after_tds = $actfcom - $tds;
		    					
		    					$this->Ew2->tblewallet_Payment_CrEntry_From_Admin($cr_user_id,1,$actfcom_after_tds,$com_remark,$description,$payment_type);
		    				}
						}
						else if($ddlaction == "REVERT")
						{
							$description = "Admin To ".$userinfo->row(0)->businessname;
							$payment_type = "CASH";
							$this->Ew2->tblewallet_Payment_DrEntry_From_Admin(1,$hidid,$txtAmount,$txtRemark,$description,$payment_type);
						}
						if($userinfo->row(0)->usertype_name == "MasterDealer")
						{
							redirect(base_url()."_Admin/md_list?crypt=".$this->Common_methods->encrypt("MyData"));
						}
						else if($userinfo->row(0)->usertype_name == "Distributor")
						{
							redirect(base_url()."_Admin/distributor_list?crypt=".$this->Common_methods->encrypt("MyData"));
						}
						else
						{
							redirect(base_url()."_Admin/agent_list?crypt=".$this->Common_methods->encrypt("MyData"));
						}	
					}
					else
					{
						redirect(base_url()."_Admin/agent_list?crypt=".$this->Common_methods->encrypt("MyData"));	
					}
					
				}
				else
				{
					redirect(base_url()."_Admin/agent_list?crypt=".$this->Common_methods->encrypt("MyData"));	
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
						$this->load->view("_Admin/add_balance2_view",$this->view_data);
					}
					
				}
				
			}
		}
	}	
}