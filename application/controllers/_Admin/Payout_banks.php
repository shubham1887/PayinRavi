<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payout_banks extends CI_Controller {
	
	
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
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
        ini_set('display_errors',1);
    }
	public function index()  
	{
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			$rslt = $this->db->query("
				select a.* ,b.bank_name,
				u.businessname,u.mobile_no as username
				from payout_banks a 
				left join dmr_banks b on a.bank_id = b.Id
				left join tblusers u on a.user_id = u.user_id
				order by a.user_id");
			$this->view_data["result_data"]=$rslt;
			$this->load->view("_Admin/Payout_banks_view",$this->view_data);		
		} 
	}
	public function updatastatus()
	{
		if(isset($_POST["Id"]) and isset($_POST["status"]) )
		{
			$Id = intval(trim($this->input->post("Id")));
			$status = trim($this->input->post("status"));
			$rslt = $this->db->query("update payout_banks set status = ? where Id = ?",array($status,$Id));
			if($rslt == true)
			{
				$resp_array = array(
					"status"=>"0",
					"message"=>"Status Update Done",
					"statuscode"=>"TXN"
				);
				echo json_encode($resp_array);exit;
			}

		}
	}	
}