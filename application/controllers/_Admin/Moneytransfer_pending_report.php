<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Moneytransfer_pending_report extends CI_Controller {  
	public function index() 
	{ 
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		
			
			$str_query ="select tblmoneytransfer.*,(select businessname from tblusers where tblusers.user_id = tblmoneytransfer.user_id ) as business_name from tblmoneytransfer where status='Pending' order by Id desc";		
			$result = $this->db->query($str_query);
			
			
			$this->view_data['result_bilreport'] = $result;
			$this->view_data['message'] = NULL;
			$this->load->view('_Admin/moneytransfer_pending_report_view',$this->view_data);	
		
	}
	public function paymoneyTransfer()
	{
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache");

		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			
			$id = $this->input->post("hidid");
			$hidstatus = $this->input->post("hidstatus");
			$hidremark = $this->input->post("hidremark");
			//echo $id;exit;
			$rsltbl = $this->db->query("select * from tblmoneytransfer where Id = ?",array($id));
			if($rsltbl->row(0)->reverted != "yes")
			{
				if($rsltbl->num_rows() > 0 and $hidstatus == "Failure")
				{
					$amount = $rsltbl->row(0)->debit_amount;
					$cr_amount = $amount;
					$monet_date = $rsltbl->row(0)->add_date;
					$user_id = $rsltbl->row(0)->user_id;
					$transaction_type ="MoneyTransfer_Refund";
					$Description = "MoneyTransfer_Refund : Request On Date : ".$monet_date."  | Transfer ID :".$id;
					$this->load->model("Insert_model");
					$this->Insert_model->tblewallet_MoneyTransfer_CrEntry($user_id,$id,$transaction_type,$cr_amount,$Description);	
					$rev_date = $this->common->getDate();
					$rev_ip = $this->common->getRealIpAddr();
					$this->db->query("update tblmoneytransfer set reverted='yes',revert_date=?,rev_ipaddress=?, status = ?, response = ? where Id = ?",array($rev_date,$rev_ip,$hidstatus,$hidremark,$id));
					
					//$mobile = $rsltbl->row(0)->mobile;
//					$operator = $rsltbl->row(0)->operator;
//					$custid = $rsltbl->row(0)->custid;
//					//$sms = "Dear sir Your Bill Payment of ".$operator." ".$custid." for Rs. ".$amount." FAILED Refund of Rs. ".$amount." done Queries? Call Now. 1234567890  Onepay";
//					//$this->ExecuteSMSApi($mobile,$sms);
//					
//					$rslagent = $this->db->query("select mobile_no from tblusers where user_id = ?",array($user_id));
//					$agent_mobile = $rslagent->row(0)->mobile_no;
//					$this->load->model('Common_methods');
//					$balance = $this->Common_methods->getAgentBalance($user_id);
//					$agentsms = "Dear sir Bill Payment of ".$operator." with Cust ID ".$custid." for Rs. ".$amount." FAILED and Amount ".$cr_amount." credit into your account. your new balace is ".$balance.". Sonu Sales";
					//$this->ExecuteSMSApi($agent_mobile,$agentsms);
					
				}
				if($rsltbl->num_rows() > 0 and $hidstatus == "Success")
				{
					//$amount = $rsltbl->row(0)->amount;
//					$user_id = $rsltbl->row(0)->user_id;
//					$mobile = $rsltbl->row(0)->mobile;
//					$operator = $rsltbl->row(0)->operator;
//					$custid = $rsltbl->row(0)->custid;
					//$sms = "Dear sir Your Bill Payment of ".$operator." ".$custid." for Rs. ".$amount." Was Successful paid. Onepay";
					//$this->ExecuteSMSApi($mobile,$sms);
					
					
				}
				$this->db->query("update tblmoneytransfer set  status = ?, remark = ? where Id = ?",array($hidstatus,$hidremark,$id));
			}
			else
			{
				$this->db->query("update tblmoneytransfer set  status = ?, remark = ? where Id = ?",array($hidstatus,$hidremark,$id));
			}
			
			
			
			redirect("_Admin/moneytransfer_pending_report");																
		} 
	}	
	public function ExecuteSMSApi($mobile_no,$message)
	{
	$ID = 'weqeqew';
	$Pwd = 'eqwe';
	$PhNo = $mobile_no;
	$Text = rawurlencode($message); 
	$url="http://vibgyortel.in/apps/sendsms.jsp?user=$ID&password=$Pwd&mobiles=$PhNo&sms=$Text";	
	$data = file_get_contents($url); 
	return $data;
	} 
}
