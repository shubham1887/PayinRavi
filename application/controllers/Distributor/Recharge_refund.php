<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recharge_refund extends CI_Controller {
	
	
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
				$this->view_data['from_date'] = $from_date;
				$this->view_data['to_date'] = $to_date;
				$this->view_data['pagination'] = NULL;
				$str_query = "select tblewallet.* from tblewallet where user_id = '$user_id' and DATE(add_date) >= '$from_date' and DATE(add_date) <= '$to_date' and transaction_type = 'RECHARGE_REFUND' order by tblewallet.Id desc";
		$rslt = $this->db->query($str_query);
				$this->view_data['result_mdealer'] = $rslt;
				$this->view_data['flagopenclose'] =1;
				$this->view_data['message'] =$this->msg;
				$this->load->view('Distributor/recharge_refund_view',$this->view_data);		
			}					
			else
			{
				$user=$this->session->userdata('DistUserType');
				if(trim($user) == 'Distributor')
				{
				$today_date = $this->common->getMySqlDate();
				
			
				$user_id = $this->session->userdata("DistId");
				$this->view_data['from_date'] = $today_date;
				$this->view_data['to_date'] = $today_date;
				$this->view_data['pagination'] = NULL;
				
				$str_query = "select tblewallet.* from tblewallet where user_id = '$user_id' and DATE(add_date) >= '$today_date' and DATE(add_date) <= '$today_date' and transaction_type = 'RECHARGE_REFUND' order by tblewallet.Id desc";
		$rslt = $this->db->query($str_query);
				
				$this->view_data['result_mdealer'] = $rslt;
				$this->view_data['flagopenclose'] =1;
				$this->view_data['message'] =$this->msg;
				$this->load->view('Distributor/recharge_refund_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
}