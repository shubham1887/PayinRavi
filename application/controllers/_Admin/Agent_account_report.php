<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agent_account_report extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('aloggedin') != TRUE) 
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

		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	//print_r($this->input->post());exit;
			if($this->input->post('btnSearch') == "Search")
			{
			    //print_r($this->input->post());exit;
				$from_date = $this->input->post("txtFrom",TRUE);
				$to_date = $this->input->post("txtTo",TRUE);
				$ddldb = $this->input->post("ddldb",TRUE);
			    $wallet = $this->input->post("ddlwallet",TRUE);
			    $username = $this->input->post("txtUserId",TRUE);
			    $transaction_type = $this->input->post("ddltransaction_type",TRUE);
			    
			    $this->view_data['from'] =$from_date; 
        		$this->view_data['to'] =$to_date; 
        		$this->view_data['ddlwallet'] =$wallet; 
        		$this->view_data['ddldb'] =$ddldb; 
        		$this->view_data['username'] =$username; 
        		$userinfo = $this->db->query("select * from tblusers where mobile_no = ? and host_id = 1",array($username));
        		if($userinfo->num_rows() == 1)
        		{
        		    $user_id = $userinfo->row(0)->user_id;
        		    $rows = $this->AccountLedger_getReport($user_id,$from_date,$to_date,$ddldb,$wallet,$transaction_type);   
        		    $this->view_data['result_mdealer'] = $rows;
        		}
        		
        		
        		
        		
        		$this->view_data['message'] =$this->msg;
        		$this->load->view('_Admin/agent_account_report_view',$this->view_data);			
			}					
			
			else
			{
				    $date = $this->common->getMySqlDate();
				    $this->view_data['from'] =$date; 
            		$this->view_data['to'] =$date; 
            		$this->view_data['ddlwallet'] =""; 
            		$this->view_data['ddldb'] ="LIVE"; 
            		
            		$this->view_data['result_mdealer'] = false;
            		$this->view_data['message'] ="";
            		$this->load->view('_Admin/agent_account_report_view',$this->view_data);		
																											
			}
		} 
	}	
	private function AccountLedger_getReport($user_id,$from_date,$to_date,$ddldb,$wallet,$transaction_type)
	{
	    
	   // echo $user_id."   ".$from_date."   ".$to_date."   ".$ddldb."   ".$wallet;exit;
	    if($wallet == "DMT")
	    {
	         if($ddldb == "ARCHIVE")
		    {
    			$str_query = "
    			select 
    			a.Id,
    			a.payment_id,
    			a.recharge_id,
    			a.dmr_id,
    			a.bill_id,
    			a.transaction_type,
    			a.payment_type,
    			a.credit_amount,
    			a.debit_amount,
    			a.balance,
    			a.description,
    			a.remark,
    			a.add_date,
    			cr.businessname as cr_businessname,
    			cr.username as cr_username,
    			cr.mobile_no as cr_mobile_no,
    			cr.usertype_name as cr_usertype_name,
    			dr.businessname as dr_businessname,
    			dr.username as dr_username,
    			dr.mobile_no as dr_mobile_no,
    			dr.usertype_name as dr_usertype_name
    			from jantrech_archive.tblewallet2 a 
    			left join tblusers cr on a.cr_user_id = cr.user_id
    			left join tblusers dr on a.dr_user_id = dr.user_id
    			where 
    			a.user_id = ? and 
    			DATE(a.add_date) >= ? and 
    			DATE(a.add_date) <= ?
    			order by a.Id";
        		$rslt = $this->db->query($str_query,array($user_id,$from_date,$to_date));
        		return $rslt;
    		}
    		else
    		{
    			$str_query = "
    			select 
    			a.Id,
    			a.payment_id,
    			a.recharge_id,
    			a.dmr_id,
    			a.bill_id,
    			a.transaction_type,
    			a.payment_type,
    			a.credit_amount,
    			a.debit_amount,
    			a.balance,
    			a.description,
    			a.remark,
    			a.add_date,
    			cr.businessname as cr_businessname,
    			cr.username as cr_username,
    			cr.mobile_no as cr_mobile_no,
    			cr.usertype_name as cr_usertype_name,
    			dr.businessname as dr_businessname,
    			dr.username as dr_username,
    			dr.mobile_no as dr_mobile_no,
    			dr.usertype_name as dr_usertype_name
    			from tblewallet2 a 
    			left join tblusers cr on a.cr_user_id = cr.user_id
    			left join tblusers dr on a.dr_user_id = dr.user_id
    			where 
    			a.user_id = ? and 
    			DATE(a.add_date) >= ? and 
    			DATE(a.add_date) <= ?
    			order by a.Id desc";
        		$rslt = $this->db->query($str_query,array($user_id,$from_date,$to_date));
        		return $rslt;
    		} 
	    }
	    else
	    {
	       if($ddldb == "ARCHIVE")
		    {
    			$str_query = "
    			select 
    			a.Id,
    			a.payment_id,
    			a.recharge_id,
    			a.transaction_type,
    			a.payment_type,
    			a.credit_amount,
    			a.debit_amount,
    			a.balance,
    			a.description,
    			a.remark,
    			a.add_date,
    			cr.businessname as cr_businessname,
    			cr.username as cr_username,
    			cr.mobile_no as cr_mobile_no,
    			cr.usertype_name as cr_usertype_name,
    			dr.businessname as dr_businessname,
    			dr.username as dr_username,
    			dr.mobile_no as dr_mobile_no,
    			dr.usertype_name as dr_usertype_name
    			from jantrech_archive.tblewallet a 
    			left join tblpayment pay on a.payment_id = pay.payment_id
    			left join tblusers cr on pay.cr_user_id = cr.user_id
    			left join tblusers dr on pay.dr_user_id = dr.user_id
    			where 
    			a.user_id = ? and 
    			DATE(a.add_date) >= ? and 
    			DATE(a.add_date) <= ?
    			order by a.Id desc";
        		$rslt = $this->db->query($str_query,array($user_id,$from_date,$to_date));
        		return $rslt;
    		}
    		else
    		{
    			$str_query = "
    			select 
    			a.Id,
    			a.payment_id,
    			a.recharge_id,
    			a.transaction_type,
    			a.payment_type,
    			a.credit_amount,
    			a.debit_amount,
    			a.balance,
    			a.description,
    			a.remark,
    			a.add_date,
    			act.businessname,
    			act.username,
    			act.mobile_no as agentmobile,
    			act.usertype_name,
    			cr.businessname as cr_businessname,
    			cr.username as cr_username,
    			cr.mobile_no as cr_mobile_no,
    			cr.usertype_name as cr_usertype_name,
    			dr.businessname as dr_businessname,
    			dr.username as dr_username,
    			dr.mobile_no as dr_mobile_no,
    			dr.usertype_name as dr_usertype_name
    			from tblewallet a 
    			left join tblusers act on a.user_id = act.user_id
    			left join tblpayment pay on a.payment_id = pay.payment_id
    			left join tblusers cr on pay.cr_user_id = cr.user_id
    			left join tblusers dr on pay.dr_user_id = dr.user_id
    			where 
    			a.user_id = ? and 
    			DATE(a.add_date) >= ? and 
    			DATE(a.add_date) <= ? and
    			if(? != 'ALL',a.transaction_type = ?,true)
    			order by a.Id desc";
        		$rslt = $this->db->query($str_query,array($user_id,$from_date,$to_date,$transaction_type,$transaction_type));
        		return $rslt;
    		}  
	    }
		
	}
	private function AccountLedger_getReport_rows($user_id,$from_date,$to_date,$ddldb,$wallet)
	{
	    if($wallet == "DMT")
	    {
	         if($ddldb == "ARCHIVE")
		    {
    			$str_query = "
    			select 
    			count(a.Id) as total
    			from jantrech_archive.tblewallet2 a 
    			where 
    			a.user_id = ? and 
    			DATE(a.add_date) >= ? and 
    			DATE(a.add_date) <= ?
    			order by a.Id desc";
        		$rslt = $this->db->query($str_query,array($user_id,$from_date,$to_date));
        		return $rslt->row(0)->total;
    		}
    		else
    		{
    			$str_query = "
    			select 
    			count(a.Id) as total
    			from tblewallet2 a 
    			where 
    			a.user_id = ? and 
    			DATE(a.add_date) >= ? and 
    			DATE(a.add_date) <= ?
    			order by a.Id";
        		$rslt = $this->db->query($str_query,array($user_id,$from_date,$to_date));
        		return $rslt->row(0)->total;
    		} 
	    }
	    else
	    {
	       if($ddldb == "ARCHIVE")
		    {
    			$str_query = "
    			select 
    			count(a.Id) as total
    			from jantrech_archive.tblewallet a 
    			where 
    			a.user_id = ? and 
    			DATE(a.add_date) >= ? and 
    			DATE(a.add_date) <= ?
    			order by a.Id desc";
        		$rslt = $this->db->query($str_query,array($user_id,$from_date,$to_date));
        		return $rslt->row(0)->total;
    		}
    		else
    		{
    			$str_query = "
    			select 
    			count(a.Id) as total
    			from tblewallet a 
    			where 
    			a.user_id = ? and 
    			DATE(a.add_date) >= ? and 
    			DATE(a.add_date) <= ?
    			order by a.Id desc";
        		$rslt = $this->db->query($str_query,array($user_id,$from_date,$to_date));
        		return $rslt->row(0)->total;
    		}  
	    }
		
	}
}