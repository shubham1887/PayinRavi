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
	 	if ($this->session->userdata('DistUserType') != "Distributor") 
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
		if(isset($_POST["ddlaction"]) and isset($_POST["txtAmount"]) and isset($_POST["txtRemark"]) ) 	
		{
			$ddlaction = trim($this->input->post("ddlaction"));
			$txtAmount = trim($this->input->post("txtAmount"));
			$txtRemark = trim($this->input->post("txtRemark"));
			$hidid = trim($this->input->post("hidid"));
			
			$this->load->model("Common_methods");
			$userinfo = $this->db->query("select user_id,businessname,username,usertype_name from tblusers where user_id = ? and parentid = ?",array($hidid,$this->session->userdata("DistId")));
			if($userinfo->num_rows() == 1)
			{
				if($ddlaction == "ADD")
				{
					$description = $this->session->userdata("DistBusinessName")." To ".$userinfo->row(0)->businessname;
					$payment_type = "CASH";
					$cr_user_id = $userinfo->row(0)->user_id;
					$response = $this->Common_methods->DealerAddBalance($this->session->userdata("DistId"),$cr_user_id,$txtAmount,$txtRemark);	
				}
				else if($ddlaction == "REVERT")
				{
					$amount = intval($txtAmount);
					$cr_user_id = $this->session->userdata("DistId");
					$dr_user_id = $userinfo->row(0)->user_id;
					$description = $userinfo->row(0)->businessname." To ".$this->session->userdata("DistBusinessName");
					$payment_type = "CASH";
					$response = $this->Common_methods->DealerRevertBalance($dr_user_id,$cr_user_id,$amount);	
					
				}
			}
			if($userinfo->row(0)->usertype_name == "FOS" )
			{
			    redirect(base_url()."Distributor/fos_list?crypt=".$this->Common_methods->encrypt("MyData"));
			}
			else
			{
			    redirect(base_url()."Distributor/agent_list?crypt=".$this->Common_methods->encrypt("MyData"));    
			}
			
		}
		else
		{
			if(isset($_GET["encrid"]))
			{
				$encrid = $this->Common_methods->decrypt(trim($_GET["encrid"]));
				
				$userinfo = $this->db->query("select user_id,businessname,username,usertype_name,add_date from tblusers where user_id = ? and parentid = ?",array($encrid,$this->session->userdata("DistId")));
				if($userinfo->num_rows() == 1)
				{
					$this->view_data["message"] = "";
					$this->view_data["userinfo"] = $userinfo;
					$this->load->view("Distributor/add_balance_view",$this->view_data);
				}
				
			}
			
		}
		
	}	
}