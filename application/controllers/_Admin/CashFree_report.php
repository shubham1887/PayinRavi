<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CashFree_report extends CI_Controller {
	
	
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
			if($this->input->post('btnSearch') == "Search")
			{
				$from = $this->input->post("txtFrom",TRUE);
				$to = $this->input->post("txtTo",TRUE);
				$ddlmode = $this->input->post("ddlmode",TRUE);
				$this->view_data['message'] =$this->msg;

				$this->view_data['pagination'] = NULL;
				$this->view_data['result_mdealer'] = $this->Cashfree_getReport($from,$to,$ddlmode);
				$this->view_data['message'] =$this->msg;
				
				$this->view_data["summary"] = $this->Cashfree_getSummary($from,$to,$ddlmode);
				
				$this->view_data['from']  = $from;
				$this->view_data['to']  = $to;
				$this->view_data['ddlmode']  = $ddlmode;
				$this->load->view('_Admin/CashFree_report_view',$this->view_data);	
			}					
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$from = $to  = $this->common->getMySqlDate();
					$ddlmode = "ALL";
					$this->view_data['message'] =$this->msg;

					$this->view_data['pagination'] = NULL;
					$this->view_data['result_mdealer'] = $this->Cashfree_getReport($from,$to,$ddlmode);
					$this->view_data['message'] =$this->msg;
					
					$this->view_data["summary"] = $this->Cashfree_getSummary($from,$to,$ddlmode);
					
					$this->view_data['from']  = $from;
					$this->view_data['to']  = $to;
					$this->view_data['ddlmode']  = $ddlmode;
					$this->load->view('_Admin/CashFree_report_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	private function Cashfree_getReport($from,$to,$ddlmode)
	{
	   // error_reporting(-1);
	   // ini_set('display_errors',1);
	   // $this->db->db_debug = TRUE;
	   
	        $str_query = "
			SELECT a.Id,a.add_date,a.user_id,a.webhook_type,a.order_id,a.order_amount,a.order_currency,a.cf_payment_id,a.payment_status,a.payment_amount,a.payment_currency,a.payment_message,a.payment_time,a.bank_reference,a.payment_group,a.card_number,a.card_network,a.card_type,a.card_country,a.card_bank_name,
			b.businessname,b.mobile_no,b.usertype_name
			FROM `cashfree_callbackdata` a
			left join tblusers b on a.user_id = b.user_id
			where 
		
			DATE(a.add_date) >= ? and 
			DATE(a.add_date) <= ? and
			if(? != 'ALL',a.payment_group = ?,true)
			";
			$rslt = $this->db->query($str_query,array($from,$to,$ddlmode,$ddlmode));
		//	print_r($rslt->result());exit;
			return $rslt;
	    
			
		
	}

	private function Cashfree_getSummary($from,$to,$ddlmode)
	{
	   // error_reporting(-1);
	   // ini_set('display_errors',1);
	   // $this->db->db_debug = TRUE;
	   

		$all_total = 0;
		$total_upi = 0;
		$total_debit_card = 0;
		$total_prepaid_card = 0;
		$total_wallet = 0;

		$total_credit_card = 0;
		$total_net_banking = 0;
	        
			$rslt = $this->db->query("
			SELECT IFNULL(Sum(a.payment_amount),0) as totalAmount,a.payment_status,a.payment_group
			FROM `cashfree_callbackdata` a
			left join tblusers b on a.user_id = b.user_id
			where 
		
			DATE(a.add_date) BETWEEN ? and ? and
			if(? != 'ALL',a.payment_group = ?,true)

			group by a.payment_group
			",array($from,$to,$ddlmode,$ddlmode));
			if($rslt->num_rows() >= 1)
			{
				foreach($rslt->result() as $rw)
				{
					$all_total += $rw->totalAmount;
					if($rw->payment_group == "upi")
					{
						$total_upi += $rw->totalAmount;
					}
					if($rw->payment_group == "debit_card")
					{
						$total_debit_card += $rw->totalAmount;
					}
					if($rw->payment_group == "wallet")
					{
						$total_wallet += $rw->totalAmount;
					}
					if($rw->payment_group == "credit_card")
					{
						$total_credit_card += $rw->totalAmount;
					}
					if($rw->payment_group == "net_banking")
					{
						$total_net_banking += $rw->totalAmount;
					}


						


					
				}
			}

			$resp_array = array(
				"UPI"=>$total_upi,
				"WALLET"=>$total_wallet,
				"DEBIT_CARD"=>$total_debit_card,
				"CREDIT_CARD"=>$total_credit_card,
				"NET_BANKING"=>$total_net_banking,
				"TOTAL"=>$all_total
			);

			return $resp_array;
	    
			
		
	}

}