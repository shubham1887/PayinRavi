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
	 	if ($this->session->userdata('AgentUserType') != "Agent") 
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

		if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			$this->view_data['result_all'] = false;
			$this->view_data['message'] =$this->msg;
			$this->load->view('Retailer/Transaction_view',$this->view_data);			
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
          if(isset($json_obj->Fromdate) and isset($json_obj->Todate) and isset($json_obj->Category)  and isset($json_obj->Subcategory) and
            isset($json_obj->Operator))
          {

            $from =  date_format(date_create(trim((string)$json_obj->Fromdate)),'Y-m-d');
            $to =  date_format(date_create(trim((string)$json_obj->Todate)),'Y-m-d');

		$str_query ="
				select 

				'Recharge' as ServiceType,
				'' as OrderId1,
				Date(a.add_date) as TxnDate,
				TIME(a.add_date) as  TxnTime,
				Date(a.add_date) as UpdateOn,
				TIME(a.add_date) as  UpdateOnTime,
				b.mobile_no as CustomerNumber,
				b.recharge_id as RefId,
				a.Id as OrderID,
				'' as IfscCode,
				'' as AccountNo,
				'' as PayMode,
				b.amount as TxnAmount,
				'' as Charges,
				b.commission_amount as Margin,
				'' as GST,
				'' as TDS,
				(b.amount - b.commission_amount) as TotalAmount,
				b.recharge_status as TxnStatus,
				'' as Reason,
				'' as UTRNo,
				'' as ServiceId,
				b.operator_id as OperatorId,
				'' as OpeningBalance,
				a.balance as ClosingBalance,
				(a.balance + a.debit_amount - a.credit_amount) as OpeningBal,
			a.debit_amount as Debit,
				a.credit_amount as Credit,
				a.balance as ClosingBal,
			b.mobile_no as num,
				a.description as NarrationText,



				a.Id,
				a.balance,
				a.credit_amount,
				a.debit_amount,
				a.description,
				a.remark,
				a.add_date,
				a.user_id,
				a.transaction_type,


				b.edit_date, 
				b.update_time,
				b.recharge_id,
				b.mobile_no,
				b.amount,
				b.recharge_status,
				b.add_date as recharge_date,
				b.operator_id,
				b.commission_amount,
				b.commission_per,
				b.recharge_by,
				c.company_name as Provider,
				u.businessname,
				u.username
				from tblewallet a
				left join tblrecharge b on a.recharge_id = b.recharge_id
				left join tblcompany c on b.company_id = c.company_id
				left join tblusers u on a.user_id = u.user_id 
				where 
				Date(b.add_date)>=? and 
				Date(b.add_date)<= ? and 
				a.user_id=?  
				order by a.Id desc";		
				$result = $this->db->query($str_query,array($from,$to,$this->session->userdata("AgentId")));
				

				if($result->num_rows() > 0)
				{

		$rslt_sf = $this->db->query("SELECT 
							a.recharge_status,
							Sum(a.amount) as total
							FROM tblrecharge a 
							where 
							Date(a.add_date) >= ? and  Date(a.add_date) <= ? and user_id = ?
							 group by a.recharge_status ",array($from,$to,$this->session->userdata("AgentId")));
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
	   
	   	if(isset($_GET["fromDate"]) and isset($_GET["toDate"]))
		{
			ini_set('memory_limit', '-1');
			$from = date_format(date_create(trim($_GET["fromDate"])),'Y-m-d');
			$to = date_format(date_create(trim($_GET["toDate"])),'Y-m-d');
			//echo $from."  ".$to;exit;
			$user_id = $this->session->userdata("AgentId");
			$data = array();
			
			
			
				$str_query = "select 
		
        		a.ewallet_id,
        		a.recharge_id,
        		a.mobile_no,
        		a.state_id,
        		a.amount,
        		a.recharge_status,
        		a.transaction_id,
        		a.amount,
        		a.user_id,
        		a.ExecuteBy,
				a.commission_amount,
        		a.add_date,
        		a.update_time,
        		a.operator_id,
        		a.recharge_by,
        		a.lapubalance,
        		c.company_name,
        		b.businessname,b.username,
				parent.businessname as parent_businessname,
				parent.username as parent_username,
				state.state_name,
				state.code as statecode
        		from tblrecharge a 
        		left join tblusers b on a.user_id = b.user_id 
				left join tblusers parent on b.parentid = parent.user_id
				left join tblcompany c on a.company_id = c.company_id 
				left join tblstate state on a.state_id = state.state_id
				 where 
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ? and 
				 a.user_id = ?
				order by recharge_id";
		$rslt = $this->db->query($str_query,array($from,$to,$user_id));
		//echo $rslt->num_rows();exit;
			
				
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"recharge_id" => $rw->recharge_id, 
									"operatorId" =>$rw->operator_id, 
									"add_date" =>$rw->add_date, 
									"update_time" =>$rw->update_time, 
									"businessname" =>$rw->businessname, 
									"username" =>$rw->username, 
									"company_name" => $rw->company_name, 
									"mobile_no" =>$rw->mobile_no, 
									"Amount" =>$rw->amount, 
									"Recharge By" =>$rw->recharge_by, 
									"Recharge Status" =>$rw->recharge_status, 
									"Ret.Comm" =>$rw->commission_amount, 
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
    $fileName = "recharge_list From ".$from." To  ".$to.".xls";
    
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