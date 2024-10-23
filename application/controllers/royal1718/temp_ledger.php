<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Temp_ledger extends CI_Controller {

    function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
		
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
	
			$rslt_bank_ledger = $this->db->query("select * from templedger_ravikant order by Id");
			$this->view_data["data"] = $rslt_bank_ledger;
		
			$this->view_data["from"] = "";
			$this->view_data["to"] = "";
			$this->view_data["description"] = "";
			$this->view_data["ddlaccount"] = "";
			$this->view_data["ddlType"] = "ALL";
			$this->load->view("Admin/temp_ledger_view",$this->view_data);
		
		
	}
	
}

