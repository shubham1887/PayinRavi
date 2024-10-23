<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Archivdata extends CI_Controller {  
	
	private $msg='';
	public function pageview()
	{  
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		$this->load->model('Bank_model');
		
      



		$this->view_data['pagination'] = NULL;
		$this->view_data['result_bank'] = $this->Bank_model->get_bank();
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/archivdata_view',$this->view_data);		
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
		{ 
			$data['message']='';				
			if($this->input->post("btnSubmit") == "Submit")
			{
			
				$txtToDate = $this->input->post("txtToDate",TRUE);
				$date = $this->common->getMySqlDate();
				$date1= strtotime($txtToDate);
				$date2= strtotime($date);
				$secs = $date1 - $date2;// == return sec in difference
				$days = $secs / 86400;
			//	echo $days;exit;
				if($days <= -35)
				{
					$querypayment  = 'INSERT INTO maharshi_archivdata.tblpayment(tblpayment.payment_id,tblpayment.payment_master_id,tblpayment.cr_user_id,tblpayment.	amount,tblpayment.payment_type,tblpayment.dr_user_id,tblpayment.bank_id,tblpayment.status,tblpayment.remark,tblpayment.add_date,tblpayment.edit_date,tblpayment.ipaddress,tblpayment.transaction_type,tblpayment.payment_date,tblpayment.payment_time,tblpayment.ref_id)
	select maharshi_db.tblpayment.payment_id,maharshi_db.tblpayment.payment_master_id,maharshi_db.tblpayment.cr_user_id,
	maharshi_db.tblpayment.	amount,maharshi_db.tblpayment.payment_type,maharshi_db.tblpayment.dr_user_id,maharshi_db.tblpayment.bank_id,maharshi_db.tblpayment.status,maharshi_db.tblpayment.remark,maharshi_db.tblpayment.add_date,maharshi_db.tblpayment.edit_date,maharshi_db.tblpayment.ipaddress,maharshi_db.tblpayment.transaction_type,maharshi_db.tblpayment.payment_date,maharshi_db.tblpayment.payment_time,maharshi_db.tblpayment.ref_id from maharshi_db.tblpayment where Date(maharshi_db.tblpayment.add_date) <= ?';
	
	
	
	
	
	$queryewallet  = 'INSERT INTO maharshi_archivdata.tblewallet(
	    tblewallet.Id,
	    tblewallet.checkpoint,
	    tblewallet.checkpoint_date,
	    tblewallet.checkpoint_ip,
	    tblewallet.checkpoing_bal,
	    tblewallet.user_id,
	    tblewallet.payment_id,
	    tblewallet.recharge_id,
	    tblewallet.transaction_type,
	    tblewallet.payment_type,
	    tblewallet.remark,
	    tblewallet.description,
	    tblewallet.add_date,
	    tblewallet.edit_date,
	    tblewallet.credit_amount,
	    tblewallet.debit_amount,
	    tblewallet.balance,
	    tblewallet.ipaddress,
	    tblewallet.tds,
	    tblewallet.serviceTax,
	    tblewallet.airbook_id
	    ) 
	    select  maharshi_db.tblewallet.Id,
	            maharshi_db.tblewallet.checkpoint,
	            maharshi_db.tblewallet.checkpoint_date,
	            maharshi_db.tblewallet.checkpoint_ip,
	            maharshi_db.tblewallet.checkpoing_bal,
	            maharshi_db.tblewallet.user_id,
	            maharshi_db.tblewallet.payment_id,
	            maharshi_db.tblewallet.recharge_id,
	            maharshi_db.tblewallet.transaction_type,
	            maharshi_db.tblewallet.payment_type,
	            maharshi_db.tblewallet.remark,
	            maharshi_db.tblewallet.description,
	            maharshi_db.tblewallet.add_date,
	            maharshi_db.tblewallet.edit_date,
	            maharshi_db.tblewallet.credit_amount,
	            maharshi_db.tblewallet.debit_amount,
	            maharshi_db.tblewallet.balance,
	            maharshi_db.tblewallet.ipaddress,
	            maharshi_db.tblewallet.tds,
	            maharshi_db.tblewallet.serviceTax,
	            maharshi_db.tblewallet.airbook_id 
	            
	            from maharshi_db.tblewallet where Date(maharshi_db.tblewallet.add_date) <= ?';
	
	$queryrecharge  = 'INSERT INTO maharshi_archivdata.tblrecharge
	(
	    tblrecharge.recharge_id,
	    tblrecharge.custname,
	    tblrecharge.company_id,
	    tblrecharge.amount,
	    tblrecharge.commission_amount,
	    tblrecharge.commission_per,
	    tblrecharge.MdId,
	    tblrecharge.MdComPer,
	    tblrecharge.MdComm,
	    tblrecharge.DId,
	    tblrecharge.DComPer,
	    tblrecharge.DComm,
	    tblrecharge.MdCom_Given,
	    tblrecharge.MdCom_Revert,
	    tblrecharge.DCom_Given,
	    tblrecharge.DCom_Revert,
	    tblrecharge.mobile_no,
	    tblrecharge.user_id,
	    tblrecharge.add_date,
	    tblrecharge.edit_date,
	    tblrecharge.ipaddress,
	    tblrecharge.recharge_status,
	    tblrecharge.order_id,
	    tblrecharge.transaction_id,
	    tblrecharge.operator_id,
	    tblrecharge.recharge_by,
	    tblrecharge.ExecuteBy,
	    tblrecharge.balance,
	    tblrecharge.reverted,
	    tblrecharge.debited,
	    tblrecharge.ewallet_id,
	    tblrecharge.retry,
	    tblrecharge.update_time,
	    tblrecharge.updated_by,
	    tblrecharge.update_ip,
	    tblrecharge.smssent,
	    tblrecharge.AdminCommPer,
	    tblrecharge.AdminComm) 
	SELECT 
	

        tblrecharge.recharge_id,
        tblrecharge.custname,
        tblrecharge.company_id,
        tblrecharge.amount,
        tblrecharge.commission_amount,
        tblrecharge.commission_per,
        tblrecharge.MdId,
        tblrecharge.MdComPer,
        tblrecharge.MdComm,
        tblrecharge.DId,
        tblrecharge.DComPer,
        tblrecharge.DComm,
        tblrecharge.MdCom_Given,
        tblrecharge.MdCom_Revert,
        tblrecharge.DCom_Given,
        tblrecharge.DCom_Revert,
        tblrecharge.mobile_no,
        tblrecharge.user_id,
        tblrecharge.add_date,
        tblrecharge.edit_date,
        tblrecharge.ipaddress,
        tblrecharge.recharge_status,
        tblrecharge.order_id,
        tblrecharge.transaction_id,
        tblrecharge.operator_id,
        tblrecharge.recharge_by,
        tblrecharge.ExecuteBy,
        tblrecharge.balance,
        tblrecharge.reverted,
        tblrecharge.debited,
        tblrecharge.ewallet_id,
        tblrecharge.retry,
        tblrecharge.update_time,
        tblrecharge.updated_by,
        tblrecharge.update_ip,
        tblrecharge.smssent,
        tblrecharge.AdminCommPer,
        tblrecharge.AdminComm


	
	 from maharshi_db.tblrecharge where Date(maharshi_db.tblrecharge.add_date) <= ?';
	
	
	if($this->db->query($queryewallet,array($txtToDate)))
	{
		$this->db->query('delete from maharshi_db.tblewallet where Date(add_date) <= ?',array($txtToDate));
	}
	if($this->db->query($querypayment,array($txtToDate)))
	{
		$this->db->query('delete from maharshi_db.tblpayment where Date(add_date) <= ?',array($txtToDate));
	}

		if($this->db->query($queryrecharge,array($txtToDate)))
		{
			$this->db->query('delete from maharshi_db.tblrecharge where Date(add_date) <= ?',array($txtToDate));
			$this->db->query('update maharshi_db.common set value = ? where param="ARCHIVDATE"',array($txtToDate));
			$this->msg ='Data Archived Successfully';
			$this->pageview();
		}
	
				}
				else
				{
					$this->msg ='You Can Only Archiv Data That Are Older Than 45 Days';
					$this->pageview();
				}
				
				//echo $date1->diff($date2)->("%d");exit;

				
			}
					
			else
			{
				
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																					
			}
		}
	}	
	public function insertzeroentry()
	{
		$date = $this->common->getMySqlDate();
		$rlst = $this->db->query("select * from tblusers where user_id not in (select user_id from tblewallet where Date(add_date) = ?)",array($date));
		foreach($rlst->result() as $row)
		{
	
			$this->load->model("Insert_model");
			$this->Insert_model->tblewallet_Recharge_CrDrEntry($row->user_id,0,"PAYMENT",0,0,"Balance Carry Forward");
		}
		
	}
	
}