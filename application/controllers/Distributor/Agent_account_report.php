<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Agent_account_report extends CI_Controller {
	
	
	private $msg='';
	
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('DistLoggedIn') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			if($this->input->post('btnSearch') == "Search")
			{
				$this->load->model("Report");
				$from_date = $this->input->post("txtFrom",TRUE);
				$to_date = $this->input->post("txtTo",TRUE);
				$user_id = $this->input->post("ddlUser",TRUE);
			
				$this->view_data['from'] = $from_date;
				$this->view_data['to'] = $to_date;
				$this->view_data['user'] = $user_id;
				$this->view_data['pagination'] = NULL;
				$this->view_data['totalPending'] = $this->Common_methods->getTotalPandingRecharge($user_id);
				$this->view_data['result_mdealer'] = $this->AccountLedger_getReport($user_id,$from_date,$to_date);
				$this->view_data['flagopenclose'] =1;
				$this->view_data['message'] =$this->msg;
				$this->load->view('Distributor/agent_account_report_view',$this->view_data);		
			}					
			
			else
			{
				$user=$this->session->userdata('DistUserType');
				if(trim($user) == 'Distributor')
				{
				$this->load->model("Report");
				$today_date = $this->common->getMySqlDate();
				
				$this->view_data['from'] = $today_date;
				$this->view_data['to'] = $today_date;
				$this->view_data['user'] = "0";
				$this->view_data['pagination'] = NULL;
				$this->view_data['totalPending'] =false;
				$this->view_data['result_mdealer'] = false;
				$this->view_data['flagopenclose'] =false;
				$this->view_data['message'] =$this->msg;
				$this->load->view('Distributor/agent_account_report_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}
	public function dataexport()
	{
		if ($this->session->userdata('DistLoggedIn') != TRUE) 
		{ 
			echo false; exit;
		}
		if(isset($_GET["from"]) and isset($_GET["to"]) and isset($_GET["user"]))
		{
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
			$user = trim($_GET["user"]);
			$parent_id = $this->session->userdata("DistId");
			$userinfo = $this->db->query("select user_id from tblusers where user_id = ? and parentid = ?",array($user,$parent_id));
			if($userinfo->num_rows() == 1)
			{
				$this->load->model("Report");
				$result_mdealer = $this->Report->AccountLedger_getReport($user,$from,$to);
				echo '<table border=1><tr><th >BName</th><th >Payment Date</th><th>Payment / Recharge Id</th><th>Payment From</th><th>Transaction type</th><th>Transaction Id</th><th>Company Name</th><th>Number</th><th >Amount</th><th>Status</th><th>Credit Amount</th><th>Debit Amount</th><th>Balance</th></tr>';

				if($result_mdealer->num_rows() > 0)
				{
					$i = 0;
					foreach($result_mdealer->result() as $result) 	
					{
					
					$user_id= $result->user_id;
					$userinfo = $this->db->query("select businessname,username from tblusers where user_id = ?",array($user_id));
						echo '<tr>';
						$company_name = "";
						$recAmount = "";
						$mobile_no = "";
						$recharge_status = "";
						$operator_id = "";
						$transaction_id = "";
						$today_date = $this->common->getMySqlDate();
						if($result->payment_id > 0)
						{
							 $payment_id = $result->payment_id;
							 $payment_info = $this->Common_methods->getPaymentInfo($payment_id);
							 if($result->transaction_type == "PAYMENT")
							 {
								 $payment_from = $payment_info->row(0)->dr_usercode;
								 if($payment_from == 0)
								 {
									 $payment_from = "RenaCyber";
								 }
							 }
							 else
							 {
								 $payment_from = "";
							 }
				 		}
						 else if($result->transaction_type == "SMSCHARGE")
						 {
							 $payment_id = 0;
							 $payment_from = "";
						 }
						  else if($result->transaction_type == "Recharge")
						 {
							 $payment_id = $result->recharge_id;
							 $recinfo = $this->db->query("select tblrecharge.recharge_id,tblrecharge.add_date,tblrecharge.recharge_status,tblrecharge.amount,tblrecharge.transaction_id,tblrecharge.operator_id,tblrecharge.mobile_no,(select company_name from tblcompany where tblcompany.company_id = tblrecharge.company_id) as company_name from tblrecharge where tblrecharge.recharge_id = ?",array($result->recharge_id));
							 $company_name = $recinfo->row(0)->company_name;
							 $recAmount = $recinfo->row(0)->amount;
							 $mobile_no = $recinfo->row(0)->mobile_no;
							 $recharge_date = $recinfo->row(0)->mobile_no;
							  $transaction_id = $recinfo->row(0)->transaction_id;
							   $operator_id = $recinfo->row(0)->operator_id;
							  $recharge_status = $recinfo->row(0)->recharge_status;
							 $payment_from = "";
							 $payment_from_usertype = "";
						 }
						 else
						 {
							$payment_id = 0;
							$payment_from = "";
						 }
				 		 $date = date_create($result->add_date);
			
						echo ' <td >'.$userinfo->row(0)->businessname.'</td>
						<td>'.$result->add_date.'</td>
						 <td >'.$payment_id.'</td>
						  <td>'.$payment_from.'</td>
						 
						  <td>'.$result->transaction_type.'</td>
						  <td>'.$operator_id.'</td>
						
						  <td >'.$company_name.'</td>
						  <td >'.$mobile_no.'</td>
						  <td >'.$recAmount.'</td>
						   <td >'.$recharge_status.'</td>
						
						 <td>'.$result->credit_amount.'</td>
						  <td>'.$result->debit_amount.'</td>
						  <td>'.$result->balance.'</td>
						  <td >
						  
						</td>
 						</tr>';

							$i++;
					} 
				} 
			}
			else
			{
				echo "No Data";exit;
			}
		}
	}	
	private function AccountLedger_getReport($user_id,$from_date,$to_date)
	{
	
		$rsltcommon = $this->db->query("select * from common where param = 'ARCHIVDATE'");
		$archivdate = $rsltcommon->row(0)->value;
		if($from_date <= $archivdate and $to_date <= $archivdate)
		{
			$str_query = "select tblewallet.*,(select a.balance  from gofullrc_maindb.tblewallet a where a.user_id = '$user_id' and DATE(a.add_date) < '$from_date' order by a.id desc limit 1) as openingBalance,(select tblpayment.add_date from gofullrc_maindb.tblpayment where tblpayment.payment_id = tblewallet.payment_id) as payment_date,(select businessname from tblusers where tblusers.user_id = (select cr_user_id from gofullrc_maindb.tblpayment where tblpayment.payment_id = tblewallet.payment_id)) as bname,(select username from tblusers where tblusers.user_id = (select cr_user_id from gofullrc_maindb.tblpayment where tblpayment.payment_id = tblewallet.payment_id)) as username,(select usertype_name from tblusers where tblusers.user_id = (select cr_user_id from gofullrc_maindb.tblpayment where tblpayment.payment_id = tblewallet.payment_id)) as usertype from gofullrc_maindb.tblewallet where user_id = '$user_id' and DATE(add_date) >= '$from_date' and DATE(add_date) <= '$to_date' order by tblewallet.Id desc";
			$rslt = $this->db->query($str_query);
			return $rslt;
					

		}
		else if($from_date <= $archivdate and $to_date > $archivdate)
		{
		}
		else if($from_date > $archivdate and $to_date > $archivdate)
		{
			$str_query = "select tblewallet.*,(select a.balance  from tblewallet a where a.user_id = '$user_id' and DATE(a.add_date) < '$from_date' order by a.id desc limit 1) as openingBalance,(select tblpayment.add_date from tblpayment where tblpayment.payment_id = tblewallet.payment_id) as payment_date,(select businessname from tblusers where tblusers.user_id = (select cr_user_id from tblpayment where tblpayment.payment_id = tblewallet.payment_id)) as bname,(select username from tblusers where tblusers.user_id = (select cr_user_id from tblpayment where tblpayment.payment_id = tblewallet.payment_id)) as username,(select usertype_name from tblusers where tblusers.user_id = (select cr_user_id from tblpayment where tblpayment.payment_id = tblewallet.payment_id)) as usertype from tblewallet where user_id = '$user_id' and DATE(add_date) >= '$from_date' and DATE(add_date) <= '$to_date' order by tblewallet.Id desc";
			$rslt = $this->db->query($str_query);
			return $rslt;
		}
		
	}	
}