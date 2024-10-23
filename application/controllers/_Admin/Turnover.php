<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Turnover extends CI_Controller {
	public function index()
	{
		if($this->session->userdata("aloggedin") != true)
		{
			redirect(base_url()."login");
		}
		if($this->input->post("btnSearch"))
		{
			$from = $this->input->post("txtFromDate");
			$to = $this->input->post("txtToDate");
			$str_query = "select Date(add_date) as tdate,IFNULL(sum(amount),0) as Success,(select IFNULL(sum(amount),0)  from tblrecharge a  where a.recharge_status = 'Failure' and Date(a.add_date) =Date(tblrecharge.add_date) ) as Failure,(select count(d.recharge_id)  from tblrecharge d  where d.recharge_status = 'Failure' and Date(d.add_date) =Date(tblrecharge.add_date) ) as Failurecount,(select count(e.recharge_id)  from tblrecharge e  where e.recharge_status = 'Success' and Date(e.add_date) =Date(tblrecharge.add_date) ) as Successcount from tblrecharge where recharge_status = 'Success' and Date(add_date) >= '$from' and Date(add_date) <= '$to' group by Date(add_date) order by Date(add_date) desc";
		$rslt = $this->db->query($str_query);
		$this->view_data["result_recharge"] = $rslt;
		$this->load->view("_Admin/turnover_view",$this->view_data);
		
		}
		else
		{
			$this->view_data["result_recharge"] = false;
			$this->load->view("_Admin/turnover_view",$this->view_data);
		}
		
	}	
}
