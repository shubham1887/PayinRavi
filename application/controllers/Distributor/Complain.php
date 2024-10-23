<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Complain extends CI_Controller {
		 
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('DistUserType') != "Distributor") 
		{ 
			redirect(base_url().'login'); 
		}	
		
		$start_row = $this->uri->segment(3);
		$per_page = $this->common_value->getPerPage();
		if(trim($start_row) == ""){$start_row = 0;}
		
		$result = $this->db->query("select complain_id from tblcomplain where user_id = ?",array($this->session->userdata("DistId")));
		$total_row = $result->num_rows();		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."Distributor/complain/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_complain'] = $this->db->query("select * from tblcomplain where user_id = ? order by complain_id desc limit ?,?",array($this->session->userdata("DistId"),$start_row,$per_page));
		$this->view_data['message'] =$this->msg;
		$this->view_data['cmpl_flag'] =0;
		$this->load->view('Distributor/complain_view',$this->view_data);	
				
	}
	public function GetRechargeDetails() 
	{
		if ($this->session->userdata('DistUserType') != "Distributor") 
		{ 
			echo "";exit; 
		}	
		
		$tranID = $this->input->get("trandID");
	
		$result_recharge =	$this->Complain_model->GetRechargeResult($tranID);
		if($result_recharge->num_rows() == 1)
		{
		echo'<table cellpadding="3" cellspacing="3" border="0">
    <tr>
    <th style="width:250px;" align="right">Company : </th><td align="left">'.$result_recharge->row(0)->company_name.'</td></tr>
    <tr><th align="right">Mobile No : </th><td align="left">'.$result_recharge->row(0)->mobile_no.'</td></tr>
    <tr><th align="right">Amount : </th><td align="left">'.$result_recharge->row(0)->amount.'</td></tr>
    <tr><th align="right">Recharge Date : </th><td align="left">'.$result_recharge->row(0)->add_date.'</td></tr>
    <tr><th align="right">Recharge Time : </th><td align="left"></td>    </tr>
    <tr><th align="right">Status : </th><td align="left">';
		if($result_recharge->row(0)->recharge_status == "Pending") { echo '<span class="orange">Pending</span>'; }  
		if($result_recharge->row(0)->recharge_status == 'Success') { echo '<span class="green">Success</span>'; }  
		if($result_recharge->row(0)->recharge_status == 'Failure') { echo '<span class="red">Failure</span>'; } 
echo '</td>    
    </tr>';
		echo '</table>';
		}
		else{echo "<span style='color:#F00;font-size:14px;'>No Data found.</span>";}
	}
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
		$user_id = $this->session->userdata('DistId');
		$str_query = "insert into tblcomplain(user_id,complain_date,complain_status,message,complain_type,recharge_id) values(?,?,?,?,?,?)";
		$result = $this->db->query($str_query,array($user_id,$date,'Pending',$Message,$Subject,$recharge_id));
			$this->load->model("Sms");	
		$this->Sms->complainsms($userinfo->row(0)->username,$userinfo->row(0)->businessname);			
				$this->session->set_flashdata('message', 'Complain Details Submited Successfully.');
				redirect(base_url()."Distributor/complain");				
			}
			
			else
			{
				$user=$this->session->userdata('DistUserType');
				if(trim($user) == 'Distributor')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
}