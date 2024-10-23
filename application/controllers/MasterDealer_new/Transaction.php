<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('MdUserType') != "MasterDealer") 
{ 
redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
    public function gethoursbetweentwodates($fromdate,$todate)
	{
		 $now_date = strtotime (date ($todate)); // the current date 
		$key_date = strtotime (date ($fromdate));
		$diff = $now_date - $key_date;
		return round(abs($diff) / 60,2);
	}
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('MdUserType') != "MasterDealer") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			$this->view_data['result_all'] = false;
			$this->view_data['message'] =$this->msg;
			$this->load->view('MasterDealer_new/Transaction_view',$this->view_data);			
		} 
	}
	public function SubRptTransaction()
	{
		header('Content-Type: application/json');


		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
		 $response = file_get_contents('php://input');
          $json_obj = json_decode($response);
          if(isset($json_obj->Fromdate) and isset($json_obj->Todate) )
          {
//echo "herere";exit;
            $from =  date_format(date_create(trim((string)$json_obj->Fromdate)),'Y-m-d');
            $to =  date_format(date_create(trim((string)$json_obj->Todate)),'Y-m-d');



		$str_query ="
				select 

				CASE a.debit_amount 
				  	WHEN 0 THEN 'PaymentCredit'
				 	ELSE 'CrBalance'
				END as Provider,

				'Wallet' as ServiceType,
				a.Id as RefId,
				a.payment_id as OrderId1,
				a.payment_id as OrderID,
				Date(a.add_date) as TxnDate,
				TIME(a.add_date) as  TxnTime,
				Date(a.add_date) as UpdateOn,
				TIME(a.add_date) as  UpdateOnTime,
				CONCAT(cr.businessname,'~',cr.username) as CustomerNumber,
				
				'NA' as IfscCode,
				'NA' as AccountNo,
				'NA' as PayMode,
				p.amount as TxnAmount,
				'0' as Charges,
				'0' as Margin,
				'0' as GST,
				'0' as TDS,
				p.amount as TotalAmount,
				'Success' as TxnStatus,
				'Transaction success.' as Reason,
				'NA' as UTRNo,
				'' as ServiceId,
				'' as OperatorId,
				dr.businessname as RTUsername,

				'0' as AdCommAmt,
				'0' as AdChargeAmt,
				'0' as MdCommAmt,
				'0' as MdChargeAmt,
				'0' as ZbpCommAmt,
				'0' as ZbpChargeAmt,
				'0' as OpeningBalance,
				a.balance as ClosingBalance
				from tblewallet a
				left join tblpayment p on a.payment_id = p.payment_id
				left join tblusers cr on p.cr_user_id = cr.user_id 
				left join tblusers dr on p.dr_user_id = dr.user_id
				left join tblusers u on a.user_id = u.user_id 
				where 
				Date(a.add_date)>=? and 
				Date(a.add_date)<= ? and 
				a.user_id=?  
				order by a.Id desc";		
				$result = $this->db->query($str_query,array($from,$to,$this->session->userdata("MdId")));
				

				if($result->num_rows() > 0)
				{

		$rslt_sf = $this->db->query("SELECT 
							a.recharge_status,
							Sum(a.amount) as total
							FROM tblrecharge a 
							where 
							Date(a.add_date) >= ? and  Date(a.add_date) <= ? and user_id = ?
							 group by a.recharge_status ",array($from,$to,$this->session->userdata("MdId")));
		$totalsuccess = 0;
		$totalfailure = 0;
		$totalpending = 0;
		$totalcommission = 0;
		if($rslt_sf->num_rows() > 0)
		{
			foreach($rslt_sf->result() as $row)
			{
				if($row->recharge_status == "Success")
				{
					$totalsuccess = $row->total;	
				
				}
				if($row->recharge_status == "Failure")
				{
					$totalfailure = $row->total;	
				}
				if($row->recharge_status == "Pending")
				{
					$totalpending = $row->total;	
				}
			}
	
		}







						$resp_array = array(
							"StatusCode"=>1,
							"Message"=>"SUCCESS",
							"Total"=>0,
							"Success"=>$totalsuccess,
							"Pending"=>$totalpending,
							"Failure"=>$totalfailure,
							"Reversal"=>0,
							"Data"=>$result->result()
					);
					echo json_encode($resp_array);exit;
				}
				else
				{
					$resp_array = array(
			"StatusCode"=>2,
			"Message"=>"Data Not Found.",
			"Total"=>0,
			"Success"=>0,
			"Pending"=>0,
			"Failure"=>0,
			"Reversal"=>0,
			"Data"=>null
		);
		echo json_encode($resp_array);exit;
				}



		
	}
	}


	private function AccountLedger_getReport($user_id,$from_date,$to_date,$ddldb,$start_row,$per_page)
	{
	    
	      
    		//echo $from_date."   ".$to_date;exit;
    		  
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
    			a.dmr_id,
    			a.bill_id,
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
    			from tblewallet a 
    			left join tblpayment pay on a.payment_id = pay.payment_id
    			left join tblusers cr on pay.cr_user_id = cr.user_id
    			left join tblusers dr on pay.dr_user_id = dr.user_id
    			where 
    		
    			a.user_id = ? and 
    			DATE(a.add_date) >= ? and 
    			DATE(a.add_date) <= ?
    			order by a.Id desc limit ?,? ";
        		$rslt = $this->db->query($str_query,array($user_id,$from_date,$to_date,intval($start_row),intval($per_page)));
        	
        		return $rslt;
    		
	    
		
	}
	private function AccountLedger_getReport_rows($user_id,$from_date,$to_date,$ddldb)
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
	public function TransactionExport()
	{
	   error_reporting(-1);
	   ini_set('display_errors',1);
	   $this->db->db_debug = TRUE;
	   	if(isset($_GET["fromDate"]) and isset($_GET["toDate"]))
		{
			ini_set('memory_limit', '-1');
			$from = date_format(date_create(trim($_GET["fromDate"])),'Y-m-d');
			$to = date_format(date_create(trim($_GET["toDate"])),'Y-m-d');
			//echo $from."  ".$to;exit;
			$user_id = $this->session->userdata("MdId");
			$data = array();
			
			
			
				$str_query = "select 
		
        		a.payment_id,
        		a.add_date,
        		a.transaction_type,
        		a.payment_type,
        		a.remark,
        		a.description,
        		a.credit_amount,
        		a.debit_amount,
        		a.balance,
        		a.user_id,
				a.recharge_id,
        		c.company_name,
        		b.businessname,b.username,
        		cr.businessname as cr_businessname,
        		cr.username as cr_username,
        		cr.usertype_name as cr_usertype_name,

        		dr.businessname as dr_businessname,
        		dr.username as dr_username,
        		dr.usertype_name as dr_usertype_name,
        		r.mobile_no,
        		r.amount,
        		r.recharge_status,
        		r.operator_id,
        		r.commission_amount,
        		r.DComm,
        		r.MdComm

        		from tblewallet a

        		left join tblrecharge r on a.recharge_id = r.recharge_id
        		left join tblcompany c on c.company_id = r.company_id
        		left join tblusers b on r.user_id = b.user_id 

        		left join tblpayment p on a.payment_id = p.payment_id 
				left join tblusers cr on p.cr_user_id = cr.user_id         		
				left join tblusers dr on p.dr_user_id = dr.user_id         		
				 where 
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ? and 
				 a.user_id = ?
				order by a.Id";
		$rslt = $this->db->query($str_query,array($from,$to,$user_id));
		//echo $rslt->num_rows();exit;
			
				
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"PaymentId" => $rw->payment_id, 
									"DateTime" =>$rw->add_date, 
									"Type" =>$rw->transaction_type, 
									"PaymentType" =>$rw->payment_type, 
									"paymentFrom" =>$rw->dr_businessname, 
									"PaymentTo" =>$rw->cr_businessname, 

									"CreditAmount" =>$rw->credit_amount, 
									"DebitAmount" =>$rw->debit_amount, 
									"Balance" =>$rw->balance, 

									"company_name" => $rw->company_name, 
									"mobile_no" =>$rw->mobile_no, 
									"Amount" =>$rw->amount, 
									"Recharge Status" =>$rw->recharge_status, 
									"Commission" =>$rw->DComm, 
								);
					
					
					
					array_push( $data,$temparray);
					$i++;
	}
	function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
    
    // file name for download
    $fileName = "Transaction From ".$from." To  ".$to.".xls";
    
    // headers for download
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header("Content-Type: application/vnd.ms-excel");
    
    $flag = false;
    foreach($data as $row) {
        if(!$flag) {
            // display column names as first row
            echo implode("\t", array_keys($row)) . "\n";
            $flag = true;
        }
        // filter data
        array_walk($row, 'filterData');
        echo implode("\t", array_values($row)) . "\n";
    }
    
    exit;				
		}
		else
		{
			echo "parameter missing";exit;
		}
	}
}