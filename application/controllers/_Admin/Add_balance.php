<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_balance extends CI_Controller {
	

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
		//error_reporting(E_ALL);
		//ini_set('display_errors',1);
	//	$this->db->db_debug = TRUE;
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
				
				$this->load->model("Common_methods");
				$userinfo = $this->db->query("select user_id,businessname,username,usertype_name,flatcomm,mobile_no from tblusers where user_id = ?",array($hidid));
				if($ddlaction == "ADD")
				{
				    $flatcom = floatval($userinfo->row(0)->flatcomm);
				  
				    $cr_user_id = $hidid;
				    $dr_user_id = 1;
					$description = "Admin To ".$userinfo->row(0)->businessname;
					$payment_type = "CASH";
					
					$ewrslt = $this->Insert_model->tblewallet_Payment_CrDrEntry($hidid,1,$txtAmount,$txtRemark,$description,$payment_type);
					if($ewrslt == true)
					{
					    $this->load->model("Sms");
            			$this->Sms->receiveBalance($userinfo,$txtAmount);
					    $flatcom = floatval($userinfo->row(0)->flatcomm);
            			$usertype_name = $userinfo->row(0)->usertype_name;
            			if($usertype_name == "MasterDealer" or $usertype_name == "Distributor" or $usertype_name == "SuperDealer" or $usertype_name == "Agent")
            			{
            				if($flatcom > 0)
            				{
            					$actfcom = ((floatval($txtAmount) * $flatcom)/100);
            					$this->Insert_model->tblewallet_Payment_Cr_Admin($cr_user_id,$dr_user_id,$actfcom,"Commission  ".$flatcom." %",$description,$payment_type);
            				}
            			}
					}
				}
				else if($ddlaction == "REVERT")
				{
					$description = "Admin To ".$userinfo->row(0)->businessname;
					$payment_type = "CASH";
					$this->Insert_model->tblewallet_Payment_CrDrEntry(1,$hidid,$txtAmount,$txtRemark,$description,$payment_type);
				}
				if($userinfo->row(0)->usertype_name == "MasterDealer")
				{
					redirect(base_url()."_Admin/md_list?crypt=".$this->Common_methods->encrypt("MyData"));
				}
				else if($userinfo->row(0)->usertype_name == "Distributor")
				{
					redirect(base_url()."_Admin/distributor_list?crypt=".$this->Common_methods->encrypt("MyData"));
				}
				else if($userinfo->row(0)->usertype_name == "APIUSER")
				{
					redirect(base_url()."_Admin/UserList?crypt=".$this->Common_methods->encrypt("MyData"));
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
						$this->load->view("_Admin/add_balance_view",$this->view_data);
					}
					
				}
				
			}
		}
	}	
}