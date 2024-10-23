<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Moneytransfer_report extends CI_Controller {
	public function index() 
	{ 
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		if($this->input->post('btnSearch'))
		{
			//print_r($this->input->post());exit;
			$from = $this->input->post("txtFrom");
			$to = $this->input->post("txtTo");
			//echo $from .''.$to;exit;
			$word = $this->input->post("txtWord");
			if($word == "" or $word == NULL)
			{
			
			$str_query ="select tblmoneytransfer.*,(select businessname from tblusers where tblusers.user_id = tblmoneytransfer.user_id ) as business_name from tblmoneytransfer where Date(add_date) >=? and Date(add_date) <=? order by Id desc ";		
			$result = $this->db->query($str_query,array($from,$to));
			}
			else
			{
			
				$str_query ="select tblmoneytransfer.*,(select businessname from tblusers where tblusers.user_id = tblmoneytransfer.user_id ) as business_name from tblmoneytransfer where Date(add_date) >=? and Date(add_date) <=? and (custid = '$word' or operator ='$word' or user_id in (select user_id from tblusers where business_name like '%$word%')) order by Id desc ";		
			$result = $this->db->query($str_query,array($from,$to));
			}
			
			$this->view_data['result_complain'] = $result;
			$this->view_data['message'] = NULL;
			$this->load->view('_Admin/moneytransfer_report_view',$this->view_data);	
			
		}
		else
		{
			$date = $this->common->getMySqlDate();
				$str_query ="select tblmoneytransfer.*,(select businessname from tblusers where tblusers.user_id = tblmoneytransfer.user_id ) as business_name from tblmoneytransfer where Date(add_date) = ? order by Id desc ";		
			$result = $this->db->query($str_query,array($date));
			$this->view_data['result_complain'] = $result;
			$this->view_data['message'] = NULL;
			$this->load->view('_Admin/moneytransfer_report_view',$this->view_data);
		}
	}
	
}
