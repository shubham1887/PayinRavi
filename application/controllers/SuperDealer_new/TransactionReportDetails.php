<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TransactionReportDetails extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('SdUserType') != "SuperDealer") 
{ 
redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
    public function gethoursbetweentwodates($fromdate,$todate)
	{
		 $now_date = strtotime (date ($todate)); // the current date 
		$key_date = strtotime (date ($fromdate));
		$diff = $now_date - $key_date;
		return round(abs($diff) / 60,2);
	}
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
								
			
				$user=$this->session->userdata('SdUserType');
				if(trim($user) == 'MasterDealer')
				{
					if(isset($_GET["Id"]))
					{
						$Id = trim($this->input->get("Id"));
						$dmr_result = $this->db->query("select * from mt3_transfer where Id = ? and user_id = ?",array($Id,$this->session->userdata("SdId")));
						$this->view_data["message"] = "";
						$this->view_data["dmr_result"] = $dmr_result;
						$this->load->view("SuperDealer_new/TransactionReportDetails_view",$this->view_data);
					}		
				}
				else
				{redirect(base_url().'login');}																								
			
		} 
	}
}