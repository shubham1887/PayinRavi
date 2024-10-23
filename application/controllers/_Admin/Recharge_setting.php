<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recharge_setting extends CI_Controller {
	
	
	private $msg='';
	
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'adminlogin'); 
		}				
		else 		
		{
		
			$data['message']='';				
			if($this->input->post("btnSubmit") == "Submit")
			{
				$txtAmountFrom = $this->input->post("txtAmountFrom",TRUE);
				$txtAmountTo = $this->input->post("txtAmountTo",TRUE);
				$txtBalance = $this->input->post("txtBalance",TRUE);				
				$ddldudtype = $this->input->post("ddldudtype",TRUE);	
				$txtTransactions = $this->input->post("txtTransactions",TRUE);	
				$this->db->query("insert into tblamountrange(amount_from,amount_to,min_balance,status,type,min_transaction) values(?,?,?,?,?,?)",
				array($txtAmountFrom,$txtAmountTo,$txtBalance,"live",$ddldudtype,$txtTransactions));
				redirect(base_url()."_Admin/recharge_setting?crypt1=".$this->input->post("hidgroupname")."&crypt2=".$this->input->post("hidgroupid"));	
				
			}
			if($this->input->post("btnSubmit") == "Update")
			{
			    $Id = $this->input->post("hidId",TRUE);
				$txtAmountFrom = $this->input->post("txtAmountFrom",TRUE);
				$txtAmountTo = $this->input->post("txtAmountTo",TRUE);
				$txtBalance = $this->input->post("txtBalance",TRUE);				
				$ddldudtype = $this->input->post("ddldudtype",TRUE);	
				$txtTransactions = $this->input->post("txtTransactions",TRUE);	
				$this->db->query("update tblamountrange set amount_from = ?,amount_to = ?,min_balance = ?,type = ?,min_transaction = ? where Id = ?",
				array($txtAmountFrom,$txtAmountTo,$txtBalance,$ddldudtype,$txtTransactions,$Id));
				redirect(base_url()."_Admin/recharge_setting?crypt1=".$this->input->post("hidgroupname")."&crypt2=".$this->input->post("hidgroupid"));	
				
			}
			else if( $this->input->post("hidValue") && $this->input->post("action") ) 
			{	
				$Id = $this->input->post("hidValue",TRUE);
				$this->db->query("delete from tblamountrange where Id = ?",array($Id));	
				redirect(base_url()."_Admin/recharge_setting?crypt1=".$this->input->post("hidgroupname")."&crypt2=".$this->input->post("hidgroupid"));	
			}
			else
			{
			    $this->view_data["message"] = "";
			    $this->view_data["result_slabs"] = $this->db->query("select * from tblamountrange");
			    $this->load->view("_Admin/recharge_setting_view",$this->view_data);		
			}
		
		} 
	}
	public function togglestatus()
	{
	    if(isset($_GET["id"]) and isset($_GET["sts"]))
	    {
	        $Id = trim($_GET["id"]);
	        $status = trim($_GET["sts"]);
	        if($status == "live" or $status == "stopped")
	        {
	       
	            $this->db->query("update tblamountrange set status = ? where Id = ?",array($status,$Id));
	            echo "OK";exit;
	        }
	    }
	}
	
}