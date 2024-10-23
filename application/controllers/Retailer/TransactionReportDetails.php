<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TransactionReportDetails extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('AgentUserType') != "Agent") 
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
    }
    public function gethoursbetweentwodates($fromdate,$todate)
	{
		 $now_date = strtotime (date ($todate)); // the current date 
		$key_date = strtotime (date ($fromdate));
		$diff = $now_date - $key_date;
		return round(abs($diff) / 60,2);
	}
	public function ViewReceipt()
	{
		if(isset($_GET["id"]))
		{
			$Id = intval(trim($this->input->get("id")));
			
			$dmr_result = $this->db->query("select * from mt3_transfer where Id = ? and user_id = ?",array($Id,$this->session->userdata("AgentId")));



			$opening_balance = 0;
			$clossing_balance = 0;
			$ew_result = $this->db->query("select balance,debit_amount from tblewallet2 where dmr_id = ? and user_id = ? order by Id",array($Id,$this->session->userdata("AgentId")));
			//print_r($ew_result->result());exit;
			if($ew_result->num_rows() >= 1)
			{
				$opening_balance = $ew_result->row(0)->balance + $ew_result->row(0)->debit_amount;
				$clossing_balance = $ew_result->row($ew_result->num_rows()-1)->balance;
			}
			

			$this->view_data["message"] = "";
			$this->view_data["dmr_result"] = $dmr_result;
			$this->view_data["opening_balance"] = $opening_balance;
			$this->view_data["clossing_balance"] = $clossing_balance;
			$this->load->view("Retailer/TransactionReportDetails_view",$this->view_data);
		}
	}
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
								
			
				$user=$this->session->userdata('AgentUserType');
				if(trim($user) == 'Agent')
				{
					if(isset($_GET["Id"]))
					{
						$Id = trim($this->input->get("Id"));
						$dmr_result = $this->db->query("select * from mt3_transfer where Id = ? and user_id = ?",array($Id,$this->session->userdata("AgentId")));



						$opening_balance = 0;
						$clossing_balance = 0;
						$ew_result = $this->db->query("select balance,debit_amount from tblewallet2 where dmr_id = ? and user_id = ? order by Id",array($Id,$this->session->userdata("AgentId")));
						//print_r($ew_result->result());exit;
						if($ew_result->num_rows() >= 1)
						{
							$opening_balance = $ew_result->row(0)->balance + $ew_result->row(0)->debit_amount;
							$clossing_balance = $ew_result->row($ew_result->num_rows()-1)->balance;
						}
						

						$this->view_data["message"] = "";
						$this->view_data["dmr_result"] = $dmr_result;
						$this->view_data["opening_balance"] = $opening_balance;
						$this->view_data["clossing_balance"] = $clossing_balance;
						$this->load->view("Retailer/TransactionReportDetails_view",$this->view_data);
					}
					else if(isset($_GET["unique_id"]))
					{
						$Id = trim($this->input->get("unique_id"));
						$dmr_result = $this->db->query("select * from mt3_transfer where unique_id = ? and user_id = ?",array($Id,$this->session->userdata("AgentId")));



						$opening_balance = 0;
						$clossing_balance = 0;
						$ew_result = $this->db->query("select balance,debit_amount from tblewallet2 where dmr_id = ? and user_id = ? order by Id",array($dmr_result->row(0)->Id,$this->session->userdata("AgentId")));
						//print_r($ew_result->result());exit;
						if($ew_result->num_rows() >= 1)
						{
							$opening_balance = $ew_result->row(0)->balance + $ew_result->row(0)->debit_amount;
							$clossing_balance = $ew_result->row($ew_result->num_rows()-1)->balance;
						}
						

						$this->view_data["message"] = "";
						$this->view_data["dmr_result"] = $dmr_result;
						$this->view_data["opening_balance"] = $opening_balance;
						$this->view_data["clossing_balance"] = $clossing_balance;
						$this->load->view("Retailer/TransactionReportDetails_view",$this->view_data);
					}		
				}
				else
				{redirect(base_url().'login');}																								
			
		} 
	}
}