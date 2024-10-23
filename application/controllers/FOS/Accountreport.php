<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accountreport extends CI_Controller {
	
	
	private $msg='';
	
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('FOSUserType') != "FOS") 
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
			
				$user_id = $this->session->userdata("FOSId");
				$this->view_data['from'] = $from_date;
				$this->view_data['to'] = $to_date;
				$this->view_data['pagination'] = NULL;
				$this->view_data['totalPending'] = $this->Common_methods->getTotalPandingRecharge($user_id);
				$this->view_data['result_mdealer'] = $this->AccountLedger_getReport($user_id,$from_date,$to_date);
				$this->view_data['flagopenclose'] =1;
				$this->view_data['message'] =$this->msg;
				$this->load->view('FOS/accountreport_view',$this->view_data);		
			}					
			
			else
			{
				$user=$this->session->userdata('FOSUserType');
				if(trim($user) == 'FOS')
				{
				$this->load->model("Report");
				$today_date = $this->common->getMySqlDate();
				
			
				$user_id = $this->session->userdata("FOSId");
				$this->view_data['from'] = $today_date;
				$this->view_data['to'] = $today_date;
				$this->view_data['pagination'] = NULL;
				$this->view_data['totalPending'] = $this->Common_methods->getTotalPandingRecharge($user_id);
				$this->view_data['result_mdealer'] = $this->AccountLedger_getReport($user_id,$today_date,$today_date);
				$this->view_data['flagopenclose'] =1;
				$this->view_data['message'] =$this->msg;
				$this->load->view('FOS/accountreport_view',$this->view_data);		
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
		a.payment_id,
		a.recharge_id,
		a.transaction_type,
		a.description,
		a.remark,
		a.credit_amount,
		a.debit_amount,
		a.balance,
		cr.businessname as cr_businessname,
		cr.username as cr_username,
		dr.businessname as dr_businessname,
		dr.username as dr_username
		from tblewallet a
		left join tblpayment pay on a.payment_id = pay.payment_id
		left join tblusers cr on pay.cr_user_id = cr.user_id
		left join tblusers dr on pay.dr_user_id = dr.user_id
		where 
		a.user_id = ? and 
		DATE(a.add_date) >= ? and DATE(a.add_date) <= ? order by a.Id desc";
			$rslt = $this->db->query($str_query,array($user_id,$from_date,$to_date));
			return $rslt;
		
		
	}	
}