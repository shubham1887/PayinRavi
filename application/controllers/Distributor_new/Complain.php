<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Complain extends CI_Controller {
		 
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('DistUserType') != "Distributor") 
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
		



		// ini_set('display_errors',1);
		// error_reporting(-1);
		// $this->db->debug = TRUE;
    }
 	public function getBalance()
	{		
		
		$balance = $this->Common_methods->getAgentBalance($this->session->userdata("DistId"));	
		echo $balance;
	}
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
		$config['base_url'] = base_url()."Retailer/complain/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_complain'] = $this->db->query("select * from tblcomplain where user_id = ? order by complain_id desc limit ?,?",array($this->session->userdata("DistId"),$start_row,$per_page));
		$this->view_data['message'] =$this->msg;
		$this->view_data['cmpl_flag'] =0;
		$this->load->view('Distributor_new/complain_view',$this->view_data);		
	}
	public function GetRechargeDetails() 
	{
		if ($this->session->userdata('DistUserType') != "Distributor") 
		{ 
			echo "";exit; 
		}	
		
		$tranID = $this->input->get("trandID");
		$this->load->model('Complain_model');
		$result_recharge =	$this->Complain_model->GetRechargeResult($tranID);
		if($result_recharge->num_rows() == 1)
		{
		echo'<table cellpadding="3" cellspacing="3" border="0">
    <tr>
    <th style="width:250px;" align="right">Company : </th><td align="left">'.$result_recharge->row(0)->company_name.'</td></tr>
    <tr><th align="right">Mobile No : </th><td align="left">'.$result_recharge->row(0)->mobile_no.'</td></tr>
    <tr><th align="right">Amount : </th><td align="left">'.$result_recharge->row(0)->amount.'</td></tr>
    <tr><th align="right">Recharge Date : </th><td align="left">'.$result_recharge->row(0)->recharge_date.'</td></tr>
    <tr><th align="right">Recharge Time : </th><td align="left">'.$result_recharge->row(0)->recharge_time.'</td>    </tr>
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
			if(isset($_POST["txt_frm_date"]) and isset($_POST["txt_to_date"]))
			{
			
				$from = $this->input->post('txt_frm_date',true);
				$to = $this->input->post('txt_to_date',true);
				$word = $this->input->post('txtmob',true);
			}
			
			else
			{
				$user=$this->session->userdata('DistUserType');
				if(trim($user) == 'Distributor')
				{
					// error_reporting(-1);
					// ini_set('display_errors',1);
					// $this->db->db_debug= TRUE;
					$from = $to = $this->common->getMySqlDate();
					$rslt = $this->db->query("SELECT 

					b.mobile_no,b.amount,b.recharge_status,b.add_date as rec_date,b.update_time,b.operator_id,
					d.company_name,
					a.complain_id
					,a.user_id,a.complain_date,a.complainsolve_date,a.message,a.response_message,a.complain_status FROM `tblcomplain` a left join tblrecharge b on a.recharge_id = b.recharge_id
					left join tblcompany d on b.company_id = d.company_id 
					where a.user_id = ?",array($this->session->userdata("DistId")));
					
					
					$this->view_data["result_all"] = $rslt;


					$this->view_data["from"] = $from;
					$this->view_data["to"] = $to;
					$this->view_data["word"] = "";

					//print_r($this->view_data["recharge_all"]->result());exit;
					$this->load->view("Distributor_new/complain_view",$this->view_data);


				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
}