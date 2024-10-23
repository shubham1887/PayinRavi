<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topuphistory extends CI_Controller {
	
	
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
			
				$user_id = $this->session->userdata("SdId");
				$this->view_data['from'] = $from_date;
				$this->view_data['to'] = $to_date;
				$this->view_data['pagination'] = NULL;
				$this->view_data['result_mdealer'] = $this->AccountLedger_getReport($user_id,$from_date,$to_date);
				$this->view_data['flagopenclose'] =1;
				$this->view_data['message'] =$this->msg;
				$this->load->view('SuperDealer/topuphistory_view',$this->view_data);		
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
				$this->load->view('SuperDealer/topuphistory_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	private function AccountLedger_getReport($user_id,$from_date,$to_date)
	{
	
		$str_query = "
			select 
			    a.Id,
			    a.add_date,
			    a.user_id,
			    a.transaction_type,
			    a.payment_type,
			    a.credit_amount,
			    a.debit_amount,
			    a.balance,
			    a.recharge_id,
			    a.payment_id,
			    a.description,
			    a.remark,
			    pay.cr_user_id,
			    pay.dr_user_id,
			    dr.businessname as dr_businessname,
			    dr.username as dr_username,
			    dr.usertype_name as dr_usertype_name,
			    cr.businessname as cr_businessname,
			    cr.username as cr_username,
			    cr.usertype_name as cr_usertype_name
			    from tblewallet a
			    left join tblpayment pay on a.payment_id = pay.payment_id
			    left join tblusers cr on pay.cr_user_id = cr.user_id
			    left join tblusers dr on pay.dr_user_id = dr.user_id
			    where a.transaction_type = 'PAYMENT' and a.user_id = ? and Date(a.add_date) >= ? and Date(a.add_date) <= ?
			";
			$rslt = $this->db->query($str_query,array($user_id,$from_date,$to_date));
			return $rslt;
		
	}
}