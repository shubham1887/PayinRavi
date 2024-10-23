<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daybook extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('MdUserType') != "MasterDealer") 
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
		



		ini_set('display_errors',1);
		error_reporting(-1);
		$this->db->debug = TRUE;
    }
 	public function getBalance()
	{		
		
		$balance = $this->Common_methods->getAgentBalance($this->session->userdata("MdId"));	
		echo $balance;
	}
	public function commonfunction()
	{	
		if ($this->session->userdata('AgentLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		$from = $this->session->userdata("from");
		$to = $this->session->userdata("to");
		
		
		$user = $this->session->userdata("MdId");
		
		
		
		
		
		$this->view_data['fromdate'] =$from; 
		$this->view_data['todate'] =$to; 
			
		$rslt_sf = $this->db->query("SELECT 
										a.recharge_status,
										Sum(a.amount) as total
										FROM tblrecharge a 
										where 
										Date(a.add_date) >= ? and  Date(a.add_date) <= ? and user_id = ?
										 group by a.recharge_status ",array($from,$to,$user));
		
		
		
		$totalsuccess = 0;
		$totalfailure = 0;
		$totalpending = 0;
		$totalcommission = 0;
			
		if($rslt_sf->num_rows() > 0)
		{
			foreach($rslt_sf->result() as $row)
			{
				if($row->recharge_status == "Success")
				{
					$totalsuccess = $row->total;	
				
				}
				if($row->recharge_status == "Failure")
				{
					$totalfailure = $row->total;	
				}
				if($row->recharge_status == "Pending")
				{
					$totalpending = $row->total;	
				}
			}
	
		}
	
		
		$this->view_data['totalRecahrge'] =$totalsuccess;
		$this->view_data['totalpRecahrge'] =$totalpending;
		$this->view_data['totalfRecahrge'] =$totalfailure;
		
		$this->view_data['from'] =$from;
		$this->view_data['to'] =$to;
		
		
		$this->view_data["summary"] = $this->getsummary($from,$to);
		
		
		$this->view_data['message'] =$this->msg;
		$this->load->view('MasterDealer_new/daybook_view',$this->view_data);			
	
	}	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 





/*

Array ( [ddl_status] => [Operator] => [txtmob] => [txt_frm_date] => 2020-10-23 [txt_to_date] => 2020-10-23 [btntype] => LIVE )
*/


		if ($this->session->userdata('AgentLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}				
		else if(isset($_POST["txt_frm_date"]) and isset($_POST["txt_to_date"]))
		{
		
			$from = $this->input->post('txt_frm_date',true);
			$to = $this->input->post('txt_to_date',true);
			
			
			
			$this->session->set_userdata("from",$from);
			$this->session->set_userdata("to",$to);
			
			$this->commonfunction();					
		}
		
		else 
		{ 						
				$user=$this->session->userdata('MdUserType');
				if(trim($user) == 'MasterDealer')
				{		
					$date = $this->common->getMySqlDate();								
					$this->session->set_userdata("from",$date);
					$this->session->set_userdata("to",$date);
					$this->commonfunction();	
				}
				else
				{redirect(base_url().'login');}																								
		} 
	}
	private function getsummary($from,$to)
	{
		/////openging balance code
		$opening_balance = 0;
		$user_id = $this->session->userdata("MdId");
		$opening_rslt = $this->db->query("select balance from tblewallet where user_id = ? and Date(add_date) < ? order by Id desc limit 1",array($user_id,$from));
		if($opening_rslt->num_rows() == 1)
		{
			$opening_balance = $opening_rslt->row(0)->balance;
		}


		/////clossing balance code
		$clossing_balance = 0;
		$user_id = $this->session->userdata("MdId");
		$clossing_rslt = $this->db->query("select balance from tblewallet where user_id = ? and Date(add_date) <= ? order by Id desc limit 1",array($user_id,$to));
		if($clossing_rslt->num_rows() == 1)
		{
			$clossing_balance = $clossing_rslt->row(0)->balance;
		}


		/////purchase
		$total_purchase = 0;
		$total_transfer = 0;
		$user_id = $this->session->userdata("MdId");
		$purchase_rslt = $this->db->query("select IFNULL(Sum(credit_amount),0) as total_purchase,IFNULL(Sum(debit_amount),0) as total_transfer from tblewallet where transaction_type = 'PAYMENT' and user_id = ? and Date(add_date) BETWEEN  ? and ?  order by Id desc limit 1",array($user_id,$from,$to));
		if($purchase_rslt->num_rows() == 1)
		{
			$total_purchase = $purchase_rslt->row(0)->total_purchase;
			$total_transfer = $purchase_rslt->row(0)->total_transfer;
		}





		////dmt transaction
		$total_dmt = 0;
		$totalcharge = 0;
		$rslt_dmt = $this->db->query("
					select IFNULL(Sum(Amount),0) as total,IFNULL(Sum(Charge_Amount),0) as totalcharge,count(Id) as totalcount,Status from mt3_transfer 
					where 
					user_id = ? and
					(Status = 'SUCCESS' or Status = 'PENDING') and
					Date(add_date) BETWEEN ? and ? ",array($user_id,$from,$to));
		if($rslt_dmt->num_rows() == 1)
		{
			$total_dmt = $rslt_dmt->row(0)->total;
			$totalcharge = $rslt_dmt->row(0)->totalcharge;
		}



		////recharge query

		$totalrecharge = 0;
		$totalcommission = 0;
		$recharge_rslt = $this->db->query("select IFNULL(Sum(amount),0) as totalrecharge,IFNULL(Sum(commission_amount),0) as totalcommission from tblrecharge where user_id = ? and Date(add_date) BETWEEN ? and ? and (recharge_status = 'Success' or recharge_status = 'Pending')",array($user_id,$from,$to));
		if($recharge_rslt->num_rows() == 1)
		{
			$totalrecharge = 	$recharge_rslt->row(0)->totalrecharge;
			$totalcommission = 	$recharge_rslt->row(0)->totalcommission;
		}


		$purchase = 0;

		$str = '<table class="table table-bordered">
					<tr>
						<th>Opening</th>
						<th>Purchase</th>
						<th>Revert</th>
						<th>Recharge</th>
						<th>Commission</th>

						<th>DMT</th>
						<th>DMT Charge</th>

						<th>Clossing</th>
					</tr>
					<tr>
						<th>'.$opening_balance.'</th>
						<th>'.$total_purchase.'</th>
						<th>'.$total_transfer.'</th>
						<th>'.$totalrecharge.'</th>
						<th>'.$totalcommission.'</th>

						<th>'.$total_dmt.'</th>
						<th>'.$totalcharge.'</th>

						<th>'.$clossing_balance.'</th>
					</tr>
				</table>';
			return $str;


	}
	
	}