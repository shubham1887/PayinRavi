<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Operator_report extends CI_Controller {
private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {

       if($this->session->userdata('SdLoggedIn') != TRUE) 
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
	if($this->input->post('btnSearch'))
	{

		$from = $this->input->post('txtFrom',true);
		$to = $this->input->post('txtTo',true);
		
		$ddldb = $this->input->post('ddldb',true);
		$user_id = $this->session->userdata('SdId');			
		$this->load->model('Agent_report_model');
		
					$str_query = "select count(recharge_id) as totalcount, Sum(amount) as Total,Sum(DComm) as Commission,
					(select company_name from tblcompany where tblcompany.company_id = tblrecharge.company_id) as company_name,
					(select IFNULL(Sum(a.amount),0) from tblrecharge a where a.company_id = tblrecharge.company_id and a.user_id = tblrecharge.user_id and a.recharge_status = 'Failure' and Date(a.add_date) >= ? and Date(a.add_date) <= ?) as Failure,
					(select IFNULL(Sum(a.amount),0) from tblrecharge a where a.company_id = tblrecharge.company_id and a.user_id = tblrecharge.user_id and a.recharge_status = 'Success' and Date(a.add_date) >= ? and Date(a.add_date) <= ?) as Success,
					(select IFNULL(Sum(a.amount),0) from tblrecharge a where a.company_id = tblrecharge.company_id and a.user_id = tblrecharge.user_id and a.recharge_status = 'Pending' and Date(a.add_date) >= ? and Date(a.add_date) <= ?) as Pending,
					(select IFNULL(Sum(p.amount),0) from tblrecharge p where p.company_id = tblrecharge.company_id and p.user_id = ? and p.recharge_status = 'Pending' and Date(p.add_date) >= ? and Date(p.add_date) <= ?) as Pending 
					from tblrecharge where Date(add_date) >=? and Date(add_date) <=?  and tblrecharge.user_id IN(select user_id from tblusers where parentid = ?) group by company_id";
		$rslt = $this->db->query($str_query,array($from,$to,$from,$to,$from,$to,$user_id,$from,$to,$from,$to,$user_id));
				$this->view_data['result_all'] = $rslt;
		$this->view_data['from'] =$from;
		$this->view_data['to'] =$to;
		
		$this->view_data['ddldb'] =$ddldb;
		
		$this->view_data['message'] =$this->msg;
		$this->load->view('SuperDealer/operator_report_view',$this->view_data);								
	}
	else 
	{ 						
			$from = $this->common->getMySqlDate();
			$to = $from;
			$user_id = $this->session->userdata('SdId');			
			$this->load->model('Agent_report_model');
			
			$str_query = "select count(recharge_id) as totalcount, Sum(amount) as Total,Sum(commission_amount) as Commission,(select company_name from tblcompany where tblcompany.company_id = tblrecharge.company_id) as company_name,(select IFNULL(Sum(a.amount),0) from tblrecharge a where a.company_id = tblrecharge.company_id and a.user_id = ? and a.recharge_status = 'Failure' and Date(a.add_date) >= ? and Date(a.add_date) <= ?) as Failure,(select IFNULL(Sum(p.amount),0) from tblrecharge p where p.company_id = tblrecharge.company_id and p.user_id = ? and p.recharge_status = 'Pending' and Date(p.add_date) >= ? and Date(p.add_date) <= ?) as Pending from tblrecharge where Date(add_date) >=? and Date(add_date) <=? and tblrecharge.recharge_status = 'Success' and tblrecharge.user_id = ? group by company_id";
		$rslt = $this->db->query($str_query,array($user_id,$from,$to,$user_id,$from,$to,$from,$to,$user_id));
			
			//print_r($rslt->result());exit;
				$this->view_data['result_all'] = $rslt;
			
			$this->view_data['from'] =$from;
			$this->view_data['to'] =$to;
			$this->view_data['ddldb'] ="LIVE";
			$this->view_data['message'] =$this->msg;
			$this->load->view('SuperDealer/operator_report_view',$this->view_data);				
																								
		} 
	}	
}