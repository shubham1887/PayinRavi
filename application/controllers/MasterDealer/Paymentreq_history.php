<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Paymentreq_history extends CI_Controller {
	
	
	private $msg='';
	
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('MdUserType') != "MasterDealer") 
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
			
				$user_id = $this->session->userdata("MdId");
				$this->view_data['from'] = $from_date;
				$this->view_data['to'] = $to_date;
				$this->view_data['pagination'] = NULL;
				$this->view_data['result_mdealer'] = $this->db->query("select * from tblautopayreq where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ?",array($user_id,$from_date,$to_date));
				$this->view_data['flagopenclose'] =1;
				$this->view_data['message'] =$this->msg;
				$this->load->view('MasterDealer/paymentreq_history_view',$this->view_data);		
			}					
			
			else
			{
				$user=$this->session->userdata('MdUserType');
				if(trim($user) == 'MasterDealer')
				{
				$this->load->model("Report");
				$today_date = $this->common->getMySqlDate();
				
			
				$user_id = $this->session->userdata("MdId");
				$this->view_data['from'] = $today_date;
				$this->view_data['to'] = $today_date;
				$this->view_data['pagination'] = NULL;
				$this->view_data['result_mdealer'] = $this->db->query("select * from tblautopayreq where user_id = ? and Date(add_date) >= ? and Date(add_date) <= ?",array($user_id,$today_date,$today_date));
				$this->view_data['flagopenclose'] =1;
				$this->view_data['message'] =$this->msg;
				$this->load->view('MasterDealer/paymentreq_history_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}		
	
}