<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Print_dmr_online_copy extends CI_Controller {


	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
		/*if ($this->session->userdata('user_type') != "MasterDealer" and $this->session->userdata('auser_type') != "Admin") 
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
	//error_reporting(-1);
//	ini_set('display_errors',1);
//	$this->db->db_debug = TRUE;
		if(isset($_GET["idstr"]))	
		{
			$Id = $this->Common_methods->decrypt($_GET["idstr"]);
		}
		else
		{
		   // $Id = 12;
				redirect(base_url());
		}


        
		    $rslt =$this->db->query("SELECT a.bank_id,bank.bank_name,a.unique_id,a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock,
b.businessname,b.username,
info.postal_address,b.mobile_no

FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id
left join tblusers_info info on a.user_id = info.user_id
left join dezire_banklist bank on a.bank_id = bank.Id

 where a.Id = ? order by a.Id desc",array($Id));
 //print_r( $rslt->result());exit;
            
		

		
	
	//print_r($rslt->result());exit;
	$this->view_data["data"] = $rslt;
	$this->load->view("MasterDealer_new/print_dmr_online_copy_view",$this->view_data);
	
		
	}
	
	
}	