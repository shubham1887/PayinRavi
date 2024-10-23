<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topuphistory extends CI_Controller {
	
	
	private $msg='';
	
	
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
			if($this->input->post('btnSearch') == "Search")
			{
			
				$from_date = $this->input->post("txtFrom",TRUE);
				$to_date = $this->input->post("txtTo",TRUE);
			
				$user_id = $this->session->userdata("DistId");
				$this->view_data['from'] = $from_date;
				$this->view_data['to'] = $to_date;
				$this->view_data['pagination'] = NULL;
				$this->view_data['result_mdealer'] = $this->AccountLedger_getReport($user_id,$from_date,$to_date);
				$this->view_data['flagopenclose'] =1;
				$this->view_data['message'] =$this->msg;
				$this->load->view('Distributor/topuphistory_view',$this->view_data);		
			}					
			
			else
			{
				$user=$this->session->userdata('DistUserType');
				if(trim($user) == 'Distributor')
				{
				
				$today_date = $this->common->getMySqlDate();
				
			
				$user_id = $this->session->userdata("DistId");
				$this->view_data['from'] = $today_date;
				$this->view_data['to'] = $today_date;
				$this->view_data['pagination'] = NULL;
				$this->view_data['result_mdealer'] = $this->AccountLedger_getReport($user_id,$today_date,$today_date);
				$this->view_data['flagopenclose'] =1;
				$this->view_data['message'] =$this->msg;
				$this->load->view('Distributor/topuphistory_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	private function AccountLedger_getReport($user_id,$from_date,$to_date)
	{
	
		$rsltcommon = $this->db->query("select * from common where param = 'ARCHIVDATE'");
		$archivdate = $rsltcommon->row(0)->value;
		if($from_date <= $archivdate and $to_date <= $archivdate)
		{
			$str_query = "select tblewallet.*,(select tblpayment.add_date from gofullrc_archiv.tblpayment where tblpayment.payment_id = tblewallet.payment_id) as payment_date,(select businessname from tblusers where tblusers.user_id = (select cr_user_id from gofullrc_archiv.tblpayment where tblpayment.payment_id = tblewallet.payment_id)) as bname,(select username from tblusers where tblusers.user_id = (select cr_user_id from gofullrc_archiv.tblpayment where tblpayment.payment_id = tblewallet.payment_id)) as username,(select usertype_name from tblusers where tblusers.user_id = (select cr_user_id from gofullrc_archiv.tblpayment where tblpayment.payment_id = tblewallet.payment_id)) as usertype from gofullrc_archiv.tblewallet where user_id = '$user_id' and DATE(add_date) >= '$from_date' and DATE(add_date) <= '$to_date' and transaction_type = 'PAYMENT' order by tblewallet.Id desc";
			$rslt = $this->db->query($str_query);
			return $rslt;
					

		}
		else if($from_date <= $archivdate and $to_date > $archivdate)
		{
		}
		else if($from_date > $archivdate and $to_date > $archivdate)
		{
			$str_query = "select tblewallet.*,(select tblpayment.add_date from tblpayment where tblpayment.payment_id = tblewallet.payment_id) as payment_date,(select businessname from tblusers where tblusers.user_id = (select cr_user_id from tblpayment where tblpayment.payment_id = tblewallet.payment_id)) as bname,(select username from tblusers where tblusers.user_id = (select cr_user_id from tblpayment where tblpayment.payment_id = tblewallet.payment_id)) as username,(select usertype_name from tblusers where tblusers.user_id = (select cr_user_id from tblpayment where tblpayment.payment_id = tblewallet.payment_id)) as usertype from tblewallet where user_id = '$user_id' and DATE(add_date) >= '$from_date' and DATE(add_date) <= '$to_date' and transaction_type = 'PAYMENT' order by tblewallet.Id desc";
			$rslt = $this->db->query($str_query);
			return $rslt;
		}
		
	}
}