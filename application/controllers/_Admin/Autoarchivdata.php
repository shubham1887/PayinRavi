<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autoarchivdata extends CI_Controller {
	
	private $msg='';
	
	public function getpreviousdate()
	{
		$date = $this->common->getMySqlDate();
		$date1 = str_replace('-', '/', $date);
		$preciusday = date('Y-m-d',strtotime($date1 . "-4 days"));
		return date_format(date_create($preciusday),'Y-m-d');
	}
	public function index() 
	{	
			
				$txtToDate = $this->getpreviousdate();
				$date = $this->common->getMySqlDate();
				//$txtToDate = "2018-12-17";
				$date1= strtotime($txtToDate);
				$date2= strtotime($date);
				$secs = $date1 - $date2;// == return sec in difference
				$days = $secs / 86400;
			//	echo $txtToDate."   ";
	//	echo $days;exit;
				
				if($days = -4)
				{
					$querypayment  = 'INSERT INTO jantrech_archive.tblpayment(
					tblpayment.payment_id,
					tblpayment.payment_master_id,
					tblpayment.cr_user_id,
					tblpayment.amount,
					tblpayment.payment_type,
					tblpayment.dr_user_id,
					tblpayment.bank_id,
					tblpayment.status,
					tblpayment.remark,
					tblpayment.add_date,
					tblpayment.edit_date,
					tblpayment.ipaddress,
					tblpayment.transaction_type,
					tblpayment.payment_date,
					tblpayment.payment_time,
					tblpayment.ref_id)
	select 
		jantrech_db.tblpayment.payment_id,
		jantrech_db.tblpayment.payment_master_id,
		jantrech_db.tblpayment.cr_user_id,
		jantrech_db.tblpayment.	amount,
		jantrech_db.tblpayment.payment_type,
		jantrech_db.tblpayment.dr_user_id,
		jantrech_db.tblpayment.bank_id,
		jantrech_db.tblpayment.status,
		jantrech_db.tblpayment.remark,
		jantrech_db.tblpayment.add_date,
		jantrech_db.tblpayment.edit_date,
		jantrech_db.tblpayment.ipaddress,
		jantrech_db.tblpayment.transaction_type,
		jantrech_db.tblpayment.payment_date,
		jantrech_db.tblpayment.payment_time,
		jantrech_db.tblpayment.ref_id 
		from jantrech_db.tblpayment where Date(jantrech_db.tblpayment.add_date) <= ?';
	
	$queryewallet  = 'INSERT INTO jantrech_archive.tblewallet(
	tblewallet.Id,
	tblewallet.user_id,
	tblewallet.payment_id,
	tblewallet.recharge_id,
	tblewallet.transaction_type,
	tblewallet.payment_type,
	tblewallet.remark,
	tblewallet.description,
	tblewallet.add_date,
	tblewallet.credit_amount,
	tblewallet.debit_amount,
	tblewallet.balance,
	tblewallet.ipaddress,
	tblewallet.dmr_id) 
	
	select 
	jantrech_db.tblewallet.Id,
	jantrech_db.tblewallet.user_id,
	jantrech_db.tblewallet.payment_id,
	jantrech_db.tblewallet.recharge_id,
	jantrech_db.tblewallet.transaction_type,
	jantrech_db.tblewallet.payment_type,
	jantrech_db.tblewallet.remark,
	jantrech_db.tblewallet.description,
	jantrech_db.tblewallet.add_date,
	jantrech_db.tblewallet.credit_amount,
	jantrech_db.tblewallet.debit_amount,
	jantrech_db.tblewallet.balance,
	jantrech_db.tblewallet.ipaddress,
	jantrech_db.tblewallet.dmr_id
	
	from jantrech_db.tblewallet where Date(jantrech_db.tblewallet.add_date) <= ?';
	
	$queryrecharge  = 'INSERT INTO jantrech_archive.tblrecharge(
	
	tblrecharge.recharge_id,
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
	tblrecharge.mobile_no,
	tblrecharge.user_id,
	tblrecharge.add_date,
	tblrecharge.edit_date,
	tblrecharge.ipaddress,
	tblrecharge.recharge_status,
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
	tblrecharge.AdminCommPer,
	tblrecharge.AdminComm,
	tblrecharge.FosId,
	tblrecharge.FosComPer,
	tblrecharge.FosComm,
	tblrecharge.order_id,
	tblrecharge.lapubalance,
	tblrecharge.lapunumber,
	tblrecharge.state_id
	
	) 
	SELECT 
	
	jantrech_db.tblrecharge.recharge_id,
	jantrech_db.tblrecharge.company_id,
	jantrech_db.tblrecharge.amount,
	jantrech_db.tblrecharge.commission_amount,
	jantrech_db.tblrecharge.commission_per,
	jantrech_db.tblrecharge.MdId,
	jantrech_db.tblrecharge.MdComPer,
	jantrech_db.tblrecharge.MdComm,
	jantrech_db.tblrecharge.DId,
	jantrech_db.tblrecharge.DComPer,
	jantrech_db.tblrecharge.DComm,
	jantrech_db.tblrecharge.mobile_no,
	jantrech_db.tblrecharge.user_id,
	jantrech_db.tblrecharge.add_date,
	jantrech_db.tblrecharge.edit_date,
	jantrech_db.tblrecharge.ipaddress,
	jantrech_db.tblrecharge.recharge_status,
	jantrech_db.tblrecharge.transaction_id,
	jantrech_db.tblrecharge.operator_id,
	jantrech_db.tblrecharge.recharge_by,
	jantrech_db.tblrecharge.ExecuteBy,
	jantrech_db.tblrecharge.balance,
	jantrech_db.tblrecharge.reverted,
	jantrech_db.tblrecharge.debited,
	jantrech_db.tblrecharge.ewallet_id,
	jantrech_db.tblrecharge.retry,
	jantrech_db.tblrecharge.update_time,
	jantrech_db.tblrecharge.updated_by,
	jantrech_db.tblrecharge.update_ip,
	jantrech_db.tblrecharge.AdminCommPer,
	jantrech_db.tblrecharge.AdminComm,
	jantrech_db.tblrecharge.FosId,
	jantrech_db.tblrecharge.FosComPer,
	jantrech_db.tblrecharge.FosComm,
	jantrech_db.tblrecharge.order_id,
	jantrech_db.tblrecharge.lapubalance,
	jantrech_db.tblrecharge.lapunumber,
	jantrech_db.tblrecharge.state_id
	
	
	from jantrech_db.tblrecharge where Date(jantrech_db.tblrecharge.add_date) <= ?';
	
	
	if($this->db->query($queryewallet,array($txtToDate)))
	{
		$this->db->query('delete from jantrech_db.tblewallet where Date(add_date) <= ?',array($txtToDate));
	}
	if($this->db->query($querypayment,array($txtToDate)))
	{
		$this->db->query('delete from jantrech_db.tblpayment where Date(add_date) <= ?',array($txtToDate));
	}

	if($this->db->query($queryrecharge,array($txtToDate)))
	{
		$this->db->query('delete from jantrech_db.tblrecharge where Date(add_date) <= ?',array($txtToDate));
		echo 'Data Archived Successfully';exit;
	}
	
				}
				else
				{
					echo 'You Can Only Archiv Data That Are Older Than 30 Days';exit;
				}
				
				//echo $date1->diff($date2)->("%d");exit;

				
			
		
	}	

}