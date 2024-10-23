<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Apiresponse extends CI_Controller {
	
	
	public function index() 
	{
		
		
		$TXNID = $_GET["TXNID"];
		$TRANSTYPE = $_GET["TRANSTYPE"];
		$ACCOUNTID = $_GET["ACCOUNTID"];
		$path = $TXNID."#".$ACCOUNTID."#".$TRANSTYPE;
		if($TRANSTYPE == "s")
		{
			$status = "Success";
		}
		else if($TRANSTYPE = "f")
		{
			$status == "Failure";
			$this->refundOfAcountReportEntry($ACCOUNTID);
			
		}
		$str_query = "update tblrecharge set operator_id = ? ,recharge_status= ? where transaction_id = ?";
		$rslt = $this->db->query($str_query,array($TXNID,$status,$ACCOUNTID));
		$filename = "test.txt";
	
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");
		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, "DATA : ".$path."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
	
	}	
	public function refundOfAcountReportEntry($txnid)
	{
		$rsltrech = $this->db->query("select reverted,debited,recharge_id,transaction_id,ewallet_id from tblrecharge where transaction_id = '$txnid'");
		if($rsltrech->num_rows() > 0)
		{
			$ewalletarr = explode(",",$rsltrec->row(0)->ewallet_id);
			$ewallet_id = $ewalletarr[1];	
			$debited = $rsltrec->row(0)->debited;
			if($rsltrec->row(0)->reverted == "no")
			{
				$rslt = $this->db->query("select * from tblewallet where Id = '$ewallet_id'");
				if($rslt->num_rows() == 1)
				{
					$user_id = $rslt->row(0)->user_id;
					$this->load->model("Tblcompany_methods");
					$debit_amount = $rslt->row(0)->debit_amount;
					$transaction_type = "Recharge_Refund";
					$cr_amount = $debit_amount;
					$recid = $rslt->row(0)->recharge_id;
					$Description = "Refund : ".$rslt->row(0)->description;
					$this->Insert_model->tblewallet_Recharge_CrEntry($user_id,$recid,$transaction_type,$cr_amount,$Description);
					$this->db->query("update tblrecharge set reverted = 'yes',revert_description = ? where recharge_id = ?",array($Description,$recid));
				}
			}
		}
		
		
	}
}