<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accountreport2 extends CI_Controller {
	
	
	private $msg='';
	
	
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
			if($this->input->post('btnSearch') == "Search")
			{
			
				$from_date = $this->input->post("txtFrom",TRUE);
				$to_date = $this->input->post("txtTo",TRUE);
				$ddltype = $this->input->post("ddltype",TRUE);
				
				$user_id = $this->session->userdata("SdId");
				$this->view_data['from'] = $from_date;
				$this->view_data['to'] = $to_date;
				$this->view_data['pagination'] = NULL;
				$this->view_data['ddltype'] = $ddltype;
				$this->view_data['result_mdealer'] = $this->AccountLedger_getReport($user_id,$from_date,$to_date,$ddltype);
				$this->view_data['flagopenclose'] =1;
				$this->view_data['message'] =$this->msg;
				$this->load->view('SuperDealer/accountreport2_view',$this->view_data);		
			}					
			
			else
			{
				$user=$this->session->userdata('SdUserType');
				if(trim($user) == 'SuperDealer')
				{
			
				$today_date = $this->common->getMySqlDate();
				
			
				$user_id = $this->session->userdata("SdId");
				$this->view_data['from'] = $today_date;
				$this->view_data['to'] = $today_date;
				$this->view_data['pagination'] = NULL;
				$this->view_data['result_mdealer'] = $this->AccountLedger_getReport($user_id,$today_date,$today_date);
				$this->view_data['flagopenclose'] =1;
				$this->view_data['message'] =$this->msg;
					$this->view_data['ddltype'] ="ALL";
				$this->load->view('SuperDealer/accountreport2_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}
	private function AccountLedger_getReport($user_id,$from_date,$to_date,$type = "ALL")
	{
	
		
			$str_query = "select tblewallet2.*,(select a.balance  from tblewallet2 a where a.user_id = '$user_id' and DATE(a.add_date) < '$from_date' order by a.id desc limit 1) as openingBalance,(select tblpayment2.add_date from tblpayment2 where tblpayment2.payment_id = tblewallet2.payment_id) as payment_date,(select businessname from tblusers where tblusers.user_id = (select cr_user_id from tblpayment2 where tblpayment2.payment_id = tblewallet2.payment_id)) as bname,(select username from tblusers where tblusers.user_id = (select cr_user_id from tblpayment2 where tblpayment2.payment_id = tblewallet2.payment_id)) as username,(select usertype_name from tblusers where tblusers.user_id = (select cr_user_id from tblpayment2 where tblpayment2.payment_id = tblewallet2.payment_id)) as usertype from tblewallet2 where user_id = '$user_id' and DATE(add_date) >= '$from_date' and DATE(add_date) <= '$to_date' and
			if(? != 'ALL',tblewallet2.transaction_type = ?,true) 
			order by tblewallet2.Id desc";
			$rslt = $this->db->query($str_query,array($type,$type));
			return $rslt;
		
		
	}	
}