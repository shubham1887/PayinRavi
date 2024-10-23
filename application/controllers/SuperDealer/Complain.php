<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Complain extends CI_Controller {
		 
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}	
		
		$start_row = $this->uri->segment(3);
		$per_page = $this->common_value->getPerPage();
		if(trim($start_row) == ""){$start_row = 0;}
		
		$result = $this->db->query("select complain_id from tblcomplain where user_id = ?",array($this->session->userdata("SdId")));
		$total_row = $result->num_rows();		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."/complain/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_complain'] = $this->db->query("select * from tblcomplain where user_id = ? order by complain_id desc limit ?,?",array($this->session->userdata("SdId"),$start_row,$per_page));
		$this->view_data['message'] =$this->msg;
		$this->view_data['cmpl_flag'] =0;
		$this->load->view('SuperDealer/complain_view',$this->view_data);	
				
	}
	
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
			$data['message']='';				
			if($this->input->post("btnSubmit") == "Submit")
			{
				//print_r($this->input->post());exit;
				$Subject = $this->input->post("ddlcomp_tyoe",TRUE);
				$Message = $this->input->post("txtMessage",TRUE);
				if($this->input->post("ddlcomp_tyoe") == "Recharge Id")
				{
					$recharge_id = $this->input->post("recharge_id",TRUE);
				}
				else
				{
					$recharge_id = NULL;
				}
				
					
				$date = $this->common->getMySqlDate();
		$user_id = $this->session->userdata('MdId');
		$str_query = "insert into tblcomplain(user_id,complain_date,complain_status,message,complain_type,recharge_id) values(?,?,?,?,?,?)";
		$result = $this->db->query($str_query,array($user_id,$date,'Pending',$Message,$Subject,$recharge_id));
			$this->load->model("Sms");	
		$this->Sms->complainsms($userinfo->row(0)->username,$userinfo->row(0)->businessname);			
				$this->session->set_flashdata('message', 'Complain Details Submited Successfully.');
				redirect(base_url()."/complain");				
			}
			
			else
			{
				$user=$this->session->userdata('SdUserType');
				if(trim($user) == 'SuperDealer')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
}