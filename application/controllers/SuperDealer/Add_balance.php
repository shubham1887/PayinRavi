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
	 	if($this->session->userdata('SdUserType') != "SuperDealer") 
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
		
		$host_id = $host_id = $this->Common_methods->getHostId($this->white->getDomainName());	
		if($this->session->userdata('SdUserType') != "SuperDealer") 
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
			
			$this->load->model("Common_methods");
			$userinfo = $this->db->query("select user_id,businessname,username,usertype_name from tblusers where user_id = ? and host_id = ?",array($hidid,$this->session->userdata("SdId")));
			if($userinfo->num_rows() == 1)
			{
				if($ddlaction == "ADD")
				{
					$description = $this->session->userdata("DistBusinessName")." To ".$userinfo->row(0)->businessname;
					$payment_type = "CASH";
					$cr_user_id = $userinfo->row(0)->user_id;
					$response = $this->Common_methods->DealerAddBalance($this->session->userdata("SdId"),$cr_user_id,$txtAmount,$txtRemark);	
				//echo $response ;exit;
					$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","warning");
					$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY",$response);
				}
				else if($ddlaction == "REVERT")
				{
					$cr_user_id = $this->session->userdata("SdId");
					$dr_user_id = $userinfo->row(0)->user_id;
					$description = $userinfo->row(0)->businessname." To ".$this->session->userdata("DistBusinessName");
					$payment_type = "CASH";
					$response = $this->Common_methods->DealerRevertBalance($dr_user_id,$cr_user_id,$txtAmount);	
					$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","warning");
					$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY",$response);
					
				}
			}
			if($userinfo->row(0)->usertype_name == "FOS" )
			{
			    redirect(base_url()."SuperDealer/fos_list?crypt=".$this->Common_methods->encrypt("MyData"));
			}
			if($userinfo->row(0)->usertype_name == "MasterDealer" )
			{
			    redirect(base_url()."SuperDealer/md_list?crypt=".$this->Common_methods->encrypt("MyData"));
			}
			if($userinfo->row(0)->usertype_name == "Distributor" )
			{
			    redirect(base_url()."SuperDealer/dist_list?crypt=".$this->Common_methods->encrypt("MyData"));
			}
			else
			{
			    redirect(base_url()."SuperDealer/agent_list?crypt=".$this->Common_methods->encrypt("MyData"));    
			}
			
		}
		else
		{
			if(isset($_GET["encrid"]))
			{
				$encrid = $this->Common_methods->decrypt(trim($_GET["encrid"]));
				
				$userinfo = $this->db->query("select user_id,businessname,username,usertype_name,add_date from tblusers where user_id = ? and host_id = ?",array($encrid,$this->session->userdata("SdId")));
				if($userinfo->num_rows() == 1)
				{
					$this->view_data["message"] = "";
					$this->view_data["userinfo"] = $userinfo;
					$this->load->view("SuperDealer/add_balance_view",$this->view_data);
				}
				
			}
			
		}
		}
	}	
}