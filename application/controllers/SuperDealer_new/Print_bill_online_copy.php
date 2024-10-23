<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Print_bill_online_copy extends CI_Controller {


	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
		/*if ($this->session->userdata('user_type') != "SuperDealer" and $this->session->userdata('auser_type') != "Admin") 
		{ 
			redirect(base_url().'login'); 
		} */
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
	    if(isset($_GET["idstr"]))	
		{
			$Id = $this->Common_methods->decrypt($_GET["idstr"]);
		}
		else
		{
				redirect(base_url());
		}

		$rslt = $this->db->query("SELECT a.Id,a.user_id,a.add_date,a.service_no,a.customer_mobile,a.customer_name,a.dueamount,a.duedate,a.billnumber,a.billdate,a.billperiod,
		a.company_id,a.bill_amount,a.status,a.opr_id,a.charged_amt,a.resp_status,a.res_code,a.debit_amount,a.credit_amount,a.option1,
		b.company_name,s.service_name,
		c.businessname,c.username,c.mobile_no 
		FROM `tblbills` a 
		left join tblcompany b on a.company_id = b.company_id
		left join tblservice s on b.service_id = s.service_id
left join tblusers c on a.user_id = c.user_id
where a.Id = ?",array($Id));
	
	$this->view_data["data"] = $rslt;
	$this->load->view("SuperDealer_new/print_bill_online_copy_view",$this->view_data);
	
		
	}
	
	
}	