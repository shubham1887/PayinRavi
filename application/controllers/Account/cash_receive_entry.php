<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cash_receive_entry extends CI_Controller 
{
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('alogged_in') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		
		$this->view_data['pagination'] = "";
		$this->view_data['result_group'] = $this->db->query("select tblusers.*,(select REMAINING_DEBT from ACCOUNTING_DEBTORS_ACCOUNT a where a.USER_ID = tblusers.user_id order by Id desc limit 1) as REMAINING_DEBT from tblusers where user_id IN (select user_id from tbldebtors ) order by username ");
		$this->view_data['message'] =$this->msg;
		$this->view_data['cash'] =0.00;//$this->getCashOnHand();
		
		$this->load->view('Account/cash_receive_entry_view',$this->view_data);		
	}
	
	public function index()
	{	
$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('alogged_in') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			if($this->input->post("btnSubmit") == "Submit")
			{
				
				$ddluser = trim($this->input->post("ddluser",TRUE));
				$ddlttype = trim($this->input->post("ddlttype",TRUE));
				$txtAmount = trim($this->input->post("txtAmount",TRUE));
				$txtRemark = trim($this->input->post("txtRemark",TRUE));
				$add_date = $this->common->getDate();
				
				if($ddlttype == "CASH")
				{
					$balance = $this->getbalance($ddluser);
				
					$USER_ID = $ddluser;
					$TRANSACTION_TYPE = "CASH";
					$DESCRIPTION="CASH";
					$REMARK = $txtRemark;
					$RECEIVED_CASH=$txtAmount;
					$GIVEN_DEBT = 0;
					$REMAINING_DEBT = $balance + $RECEIVED_CASH;
				
					$DEBT_GIVEN_DATE = "";
					$CASH_RECEIVED_DATE = $add_date;
					$ADD_DATE =$add_date;
					$IPADDRESS = $this->common->getRealIpAddr();
					$this->db->query("insert into ACCOUNTING_DEBTORS_ACCOUNT(USER_ID,TRANSACTION_TYPE,DESCRIPTION,REMARK,RECEIVED_CASH,GIVEN_DEBT,REMAINING_DEBT,DEBT_GIVEN_DATE,CASH_RECEIVED_DATE,ADD_DATE,IPADDRESS) values (?,?,?,?,?,?,?,?,?,?,?)",array($USER_ID,$TRANSACTION_TYPE,$DESCRIPTION,$REMARK,$RECEIVED_CASH,$GIVEN_DEBT,$REMAINING_DEBT,$DEBT_GIVEN_DATE,$CASH_RECEIVED_DATE,$ADD_DATE,$IPADDRESS));
					$newid = $this->db->insert_id();
					//echo $newid;exit;
					$yrl = base_url()."Account/debtors_report?user_id=".$USER_ID;
					redirect($yrl);
				}
				
				
				$this->pageview();
			}
			
			else
			{
				$user=$this->session->userdata('auser_type');
				if(trim($user) == 'Admin')
				{
					$this->pageview();		
				}
				else
				{redirect(base_url().'login');}
			}
			
		} 
	}
	private function getbalance($user_id)	
	{
		$rslt = $this->db->query("select REMAINING_DEBT from ACCOUNTING_DEBTORS_ACCOUNT where USER_ID = ? order by Id desc limit 1",array($user_id));
		if($rslt->num_rows() == 1)
		{
			return $rslt->row(0)->REMAINING_DEBT;
		}
		else
		{
			return 0;
		}
	}
}
