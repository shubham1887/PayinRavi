<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operatorwisereport extends CI_Controller {
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
	public function index() 
	{	
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 
		if($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}
		else if($this->input->post("btnSearch"))
		{
			$from = $this->input->post("txtFromDate");
			$to = $this->input->post("txtToDate");
		
			$str_query = "select 
			                count(a.recharge_id) as totalcount, 
			                Sum(a.amount) as Total,
			                Sum(a.commission_amount) as Commission,
			                Sum(a.MdComm) as MdComm,
			                Sum(a.DComm) as DComm,
			                b.company_name 
			                from tblrecharge  a
			                left join tblcompany b on a.company_id = b.company_id
			                left join tblusers c on a.user_id = c.user_id
			                where 
			                c.host_id = ? and
			                Date(a.add_date) >=? and 
			                Date(a.add_date) <=? and 
			                a.recharge_status = 'Success' 
			                group by a.company_id";
		    $rslt = $this->db->query($str_query,array($this->session->userdata("SdId"),$from,$to));
			
			
		$this->view_data["result_recharge"] = $rslt;
		$this->view_data["from"] = $from;
		$this->view_data["to"] = $to;
		$this->load->view("SuperDealer/operator_wise_report_view",$this->view_data);
		
		}
		else
		{
			$this->view_data["from"] = "";
			$this->view_data["to"] = "";
			$this->view_data["ddlapi"] = "";
			$this->view_data["result_recharge"] = false;
			$this->load->view("SuperDealer/operator_wise_report_view",$this->view_data);
		}
	}	
}