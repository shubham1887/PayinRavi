<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Print_receipt extends CI_Controller {
	
	
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

		if ($this->session->userdata('DistUserType') != "Distributor") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	

			if(isset($_GET["cruptid"]))
			{
				error_reporting(-1);
				ini_set('display_errors',1);
				$this->db->db_debug = TRUE;
				$criptid = $this->Common_methods->decrypt($this->input->get("cruptid"));

				$recinfo = $this->db->query("select a.operator_id,a.amount,a.recharge_id,a.add_date,a.mobile_no,a.recharge_status,b.company_name,a.commission_amount,c.businessname,c.mobile_no as usermobile,'' as emailid from tblrecharge a left join tblcompany b on a.company_id = b.company_id
				left join tblusers c on a.user_id = c.user_id where a.recharge_id = ? and a.user_id = ?",array($criptid,$this->session->userdata("DistId")));
				if($recinfo->num_rows() == 1)
				{
					$this->view_data["data"] = $recinfo;
					$this->load->view("Distributor_new/print_receipt_view",$this->view_data);		
				}
			}

			
		} 
	}	
	
	
}