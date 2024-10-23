<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Openingclosing extends CI_Controller {

	public function index()

	{

		$user=$this->session->userdata('ausertype');
		if(trim($user) == 'Admin')
		{
		if($this->input->post("btnSearch"))
		{
//			print_r($this->input->post());exit;
			$from = $this->input->post("txtFromDate");
			$usertype = $this->input->post("ddlusertype");
			$to = $this->input->post("txtToDate");
			$username = $this->input->post("txtUserId");
			
			if($username != "" or $username != NULL and $usertype != "ALL")
			{
				$userinfo = $this->db->query("select user_id from tblusers where username = ?",array($username));
				if($userinfo->num_rows() == 1)
				{
					$user_id = $userinfo->row(0)->user_id;
					//echo $user_id;exit;
					$str_query = "select tblusers.*,
					(SELECT IFNULL(Sum(credit_amount),0)  FROM `tblewallet`,tblrecharge where tblrecharge.recharge_id = tblewallet.recharge_id and transaction_type = 'Recharge_Refund' and Date(tblewallet.add_date) = '$from' and tblewallet.user_id = tblusers.user_id and Date(tblrecharge.add_date) != '$from') as postrefund,
					(select IFNULL(Sum(tblrecharge.amount),0) from tblrecharge where tblrecharge.user_id = tblusers.user_id and Date(tblrecharge.add_date) >= '$from' and Date(tblrecharge.add_date) <= '$to' and tblrecharge.recharge_status='Success') as TotalRecharge,(select IFNULL(Sum(tblrecharge.amount),0) from tblrecharge where tblrecharge.user_id = tblusers.user_id and Date(tblrecharge.add_date) >= '$from' and Date(tblrecharge.add_date) <= '$to' and tblrecharge.recharge_status='Pending') as TotalPending,(select IFNULL(Sum(tblrecharge.commission_amount),0) from tblrecharge where tblrecharge.user_id = tblusers.user_id and Date(tblrecharge.add_date) >= '$from' and Date(tblrecharge.add_date) <= '$to' and tblrecharge.recharge_status='Success') as commission_amount,(select balance from tblewallet where tblewallet.user_id = tblusers.user_id and Date(tblewallet.add_date) < '$from' order by Id desc limit 1) as openingbalance,(select balance from tblewallet where tblewallet.user_id = tblusers.user_id and Date(tblewallet.add_date) <= '$to' order by Id desc limit 1) as closingbalance,(select IFNULL(Sum(credit_amount),0) from tblewallet where tblewallet.user_id = tblusers.user_id and Date(tblewallet.add_date) >= '$from' and Date(tblewallet.add_date) <= '$to' and tblewallet.transaction_type = 'PAYMENT') as purchase,(select IFNULL(Sum(debit_amount),0) from tblewallet where tblewallet.user_id = tblusers.user_id and Date(tblewallet.add_date) >= '$from' and Date(tblewallet.add_date) <= '$to' and tblewallet.transaction_type = 'PAYMENT') as transfer  from tblusers where user_id = ? and usertype_name = '$usertype' ";
					
					$rslt = $this->db->query($str_query,array($user_id));
					
				}
				else
				{
					
				}
			}
			else if(($username == "" or $username == NULL) and $usertype == "All")
			{
				$str_query = "select tblusers.*,
				(SELECT IFNULL(Sum(credit_amount),0)  FROM `tblewallet`,tblrecharge where tblrecharge.recharge_id = tblewallet.recharge_id and transaction_type = 'Recharge_Refund' and Date(tblewallet.add_date) = '$from' and tblewallet.user_id = tblusers.user_id and Date(tblrecharge.add_date) != '$from') as postrefund,
				
				(select IFNULL(Sum(tblrecharge.amount),0) from tblrecharge where tblrecharge.user_id = tblusers.user_id and Date(tblrecharge.add_date) >= '$from' and Date(tblrecharge.add_date) <= '$to' and tblrecharge.recharge_status='Success') as TotalRecharge,(select IFNULL(Sum(tblrecharge.amount),0) from tblrecharge where tblrecharge.user_id = tblusers.user_id and Date(tblrecharge.add_date) >= '$from' and Date(tblrecharge.add_date) <= '$to' and tblrecharge.recharge_status='Pending') as TotalPending,(select IFNULL(Sum(tblrecharge.commission_amount),0) from tblrecharge where tblrecharge.user_id = tblusers.user_id and Date(tblrecharge.add_date) >= '$from' and Date(tblrecharge.add_date) <= '$to' and tblrecharge.recharge_status='Success') as commission_amount,(select balance from tblewallet where tblewallet.user_id = tblusers.user_id and Date(tblewallet.add_date) < '$from' order by Id desc limit 1) as openingbalance,(select balance from tblewallet where tblewallet.user_id = tblusers.user_id and Date(tblewallet.add_date) <= '$to' order by Id desc limit 1) as closingbalance,(select IFNULL(Sum(credit_amount),0) from tblewallet where tblewallet.user_id = tblusers.user_id and Date(tblewallet.add_date) >= '$from' and Date(tblewallet.add_date) <= '$to' and tblewallet.transaction_type = 'PAYMENT') as purchase,(select IFNULL(Sum(debit_amount),0) from tblewallet where tblewallet.user_id = tblusers.user_id and Date(tblewallet.add_date) >= '$from' and Date(tblewallet.add_date) <= '$to' and tblewallet.transaction_type = 'PAYMENT') as transfer  from tblusers where usertype_name = 'Agent' or usertype_name = 'Distributor' or usertype_name = 'MasterDealer' or usertype_name = 'APIUSER'";
				$rslt = $this->db->query($str_query);
			}
			else if(($username == "" or $username == NULL) and $usertype != "All")
			{
				$str_query = "select tblusers.*,
				(SELECT IFNULL(Sum(credit_amount),0)  FROM `tblewallet`,tblrecharge where tblrecharge.recharge_id = tblewallet.recharge_id and transaction_type = 'Recharge_Refund' and Date(tblewallet.add_date) = '$from' and tblewallet.user_id = tblusers.user_id and Date(tblrecharge.add_date) != '$from') as postrefund,
				(select IFNULL(Sum(tblrecharge.amount),0) from tblrecharge where tblrecharge.user_id = tblusers.user_id and Date(tblrecharge.add_date) >= '$from' and Date(tblrecharge.add_date) <= '$to' and tblrecharge.recharge_status='Success') as TotalRecharge,(select IFNULL(Sum(tblrecharge.amount),0) from tblrecharge where tblrecharge.user_id = tblusers.user_id and Date(tblrecharge.add_date) >= '$from' and Date(tblrecharge.add_date) <= '$to' and tblrecharge.recharge_status='Pending') as TotalPending,(select IFNULL(Sum(tblrecharge.commission_amount),0) from tblrecharge where tblrecharge.user_id = tblusers.user_id and Date(tblrecharge.add_date) >= '$from' and Date(tblrecharge.add_date) <= '$to' and tblrecharge.recharge_status='Success') as commission_amount,(select balance from tblewallet where tblewallet.user_id = tblusers.user_id and Date(tblewallet.add_date) < '$from' order by Id desc limit 1) as openingbalance,(select balance from tblewallet where tblewallet.user_id = tblusers.user_id and Date(tblewallet.add_date) <= '$to' order by Id desc limit 1) as closingbalance,(select IFNULL(Sum(credit_amount),0) from tblewallet where tblewallet.user_id = tblusers.user_id and Date(tblewallet.add_date) >= '$from' and Date(tblewallet.add_date) <= '$to' and tblewallet.transaction_type = 'PAYMENT') as purchase,(select IFNULL(Sum(debit_amount),0) from tblewallet where tblewallet.user_id = tblusers.user_id and Date(tblewallet.add_date) >= '$from' and Date(tblewallet.add_date) <= '$to' and tblewallet.transaction_type = 'PAYMENT') as transfer  from tblusers where usertype_name = '$usertype'";
				$rslt = $this->db->query($str_query);
			}
			
			else
			{
				$str_query = "select tblusers.*,
				(SELECT IFNULL(Sum(credit_amount),0)  FROM `tblewallet`,tblrecharge where tblrecharge.recharge_id = tblewallet.recharge_id and transaction_type = 'Recharge_Refund' and Date(tblewallet.add_date) = '$from' and tblewallet.user_id = tblusers.user_id and Date(tblrecharge.add_date) != '$from') as postrefund,
				(select IFNULL(Sum(tblrecharge.amount),0) from tblrecharge where tblrecharge.user_id = tblusers.user_id and Date(tblrecharge.add_date) >= '$from' and Date(tblrecharge.add_date) <= '$to' and tblrecharge.recharge_status='Success') as TotalRecharge,(select IFNULL(Sum(tblrecharge.amount),0) from tblrecharge where tblrecharge.user_id = tblusers.user_id and Date(tblrecharge.add_date) >= '$from' and Date(tblrecharge.add_date) <= '$to' and tblrecharge.recharge_status='Pending') as TotalPending,(select IFNULL(Sum(tblrecharge.commission_amount),0) from tblrecharge where tblrecharge.user_id = tblusers.user_id and Date(tblrecharge.add_date) >= '$from' and Date(tblrecharge.add_date) <= '$to' and tblrecharge.recharge_status='Success') as commission_amount,(select balance from tblewallet where tblewallet.user_id = tblusers.user_id and Date(tblewallet.add_date) < '$from' order by Id desc limit 1) as openingbalance,(select balance from tblewallet where tblewallet.user_id = tblusers.user_id and Date(tblewallet.add_date) <= '$to' order by Id desc limit 1) as closingbalance,(select IFNULL(Sum(credit_amount),0) from tblewallet where tblewallet.user_id = tblusers.user_id and Date(tblewallet.add_date) >= '$from' and Date(tblewallet.add_date) <= '$to' and tblewallet.transaction_type = 'PAYMENT') as purchase,(select IFNULL(Sum(debit_amount),0) from tblewallet where tblewallet.user_id = tblusers.user_id and Date(tblewallet.add_date) >= '$from' and Date(tblewallet.add_date) <= '$to' and tblewallet.transaction_type = 'PAYMENT') as transfer  from tblusers where usertype_name = 'Agent' or usertype_name = 'Distributor' or usertype_name = 'APIUSER'";
			

				$rslt = $this->db->query($str_query);
			}

			
//print_r($rslt->result());exit;
		$this->view_data["result_recharge"] = $rslt;
		$this->view_data["from"] = $from;
		$this->view_data["to"] = $to;
		$this->view_data["usertype"] = $usertype;
		$this->view_data["username"] = $username;
		$this->load->view("_Admin/openingclosing_view",$this->view_data);

		

		}
		else
		{
			$date = $this->common->getMySqlDate();
		
			$this->view_data["from"] = $date;
			$this->view_data["to"] = $date;
			$this->view_data["usertype"] = "ALL";
			$this->view_data["username"] = "";
			$this->view_data["result_recharge"] = false;

			$this->load->view("_Admin/openingclosing_view",$this->view_data);

		}
		}
		else
		{redirect(base_url().'login');}
		

		

	}	

}

