<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Print_in_online_copy extends CI_Controller {


	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
		/*if ($this->session->userdata('user_type') != "Agent" and $this->session->userdata('auser_type') != "Admin") 
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
		if(isset($_GET["Id"]))	
		{
			$Id = trim($this->input->get("Id"));
		}
		else
		{
		   // $Id = 12;
				redirect(base_url());
		}

     //   echo $Id;exit;
		    $rslt = $this->db->query("SELECT 
              a.Id, a.user_id, a.add_date, a.ipaddress, a.CustomerId, a.SenderName, a.SenderGender, 
              a.SenderDoB, a.SenderAddress, a.SenderPhone, a.SenderMobile, a.SenderCity, 
              a.SenderIdType,a.SenderIdNumber,
              a.SenderDistrict, a.SenderState, a.SenderNationality, a.Employer, a.SenderIDType, 
              a.SenderIDNumber, a.ReceiverId, a.ReceiverName, a.ReceiverGender, a.ReceiverAddress, 
              a.ReceiverMobile, a.ReceiverCity, a.SendCountry, a.PayoutCountry, a.PaymentMode, 
              a.CollectedAmount, a.ServiceCharge, a.SendAmount, a.SendCurrency, a.PayAmount, 
              a.PayCurrency, a.ExchangeRate, a.BankBranchId, a.AccountNumber, a.AccountType, 
              a.NewAccountRequest, a.PartnerPinNo, a.IncomeSource, a.RemittanceReason, 
              a.Relationship, a.CSPCode, a.OTPProcessId, a.OTP, a.status, a.response, 
              a.update_datetime, a.update_ip, a.Charge_Amount, a.debited, a.reverted, 
              a.balance, a.debit_amount, a.aCode, a.aMessage, 
              a.aTrnsactionId, a.aPinNo, a.verify_status, a.verify_response, a.verify_code ,
              b.businessname,b.username,b.mobile_no,
              info.postal_address
            FROM indonepal_transaction a
            left join tblusers b on a.user_id = b.user_id
            left join tblusers_info info on a.user_id = info.user_id
 where a.user_id = ? and a.Id = ? order by Id",array($this->session->userdata("AgentId"),$Id));





            
		

		
	
	//print_r($rslt->result());exit;
	$this->view_data["data"] = $rslt;
	$this->load->view("Retailer/print_in_online_copy_view",$this->view_data);
	
		
	}
	
	
}	