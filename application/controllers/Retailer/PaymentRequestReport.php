<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PaymentRequestReport extends CI_Controller {
	
	
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


        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
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

			
			if(isset($_POST["fromDate"]) and isset($_POST["toDate"]))
			{
			
				$from = date_format(date_create($this->input->post('fromDate',true)),'Y-m-d');
				$to = date_format(date_create($this->input->post('toDate',true)),'Y-m-d');
					
    			$rslt_data = $this->db->query("SELECT 
bank.bank_name,
IFNULL(admin_bank_acc.account_name,'') as account_name ,
IFNULL(admin_bank_acc.account_number,'') as account_number,
IFNULL(admin_bank_acc.ifsc,'') as ifsc,
IFNULL(admin_bank_acc.branch,'') as branch,
a.Id,a.user_id,a.amount,a.payment_type,a.transaction_id,
a.status,a.add_date,a.client_remark,a.wallet_type,
a.admin_bank_account_id,a.CashType,a.request_to_user_id,
Concat(req_to.businessname,'-',req_to.usertype_name) as Request_to
FROM `tblautopayreq`  a
left join tblusers req_to on a.request_to_user_id = req_to.user_id
left join creditmaster_banks admin_bank_acc on a.admin_bank_account_id = admin_bank_acc.Id
left join tblbank bank on admin_bank_acc.bank_id = bank.bank_id
where a.user_id = ? and Date(a.add_date) BETWEEN ? and ? order by a.Id desc",array($this->session->userdata("AgentId"),$from,$to));
    			
			   
			 $this->view_data["result_date"] = $rslt_data;
			 $this->view_data["from"] = $this->input->post('fromDate',true);
			 $this->view_data["to"] = $this->input->post('toDate',true);
			 $this->load->view("Retailer/PaymentRequestReport_view",$this->view_data);

			}					
			
			else
			{
				$user=$this->session->userdata('AgentUserType');
				if(trim($user) == 'Agent')
				{
				
					$today_date = date_format(date_create($this->common->getMySqlDate()),'m/d/Y');
					$this->view_data["result_date"] = false;
			 		$this->view_data["from"] = $today_date;
			 		$this->view_data["to"] = $today_date;
			    	$this->load->view("Retailer/PaymentRequestReport_view",$this->view_data);
				}
				else
				{redirect(base_url().'login');}																								
			}
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
				$result = $this->db->query($str_query,array($from,$to,$this->session->userdata("DistId")));
				

				if($result->num_rows() > 0)
				{
						$resp_array = array(
							"StatusCode"=>1,
							"Message"=>"SUCCESS",
							"Total"=>0,
							"Success"=>0,
							"Pending"=>0,
							"Failure"=>0,
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
	public function dataexport()
	{
	   
	
		if(isset($_GET["from"]) and isset($_GET["to"]))
		{
		    error_reporting(-1);
		    ini_set('display_errors',1);
		    $this->db->db_debug = TRUE;
			ini_set('memory_limit', '-1');
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
		
			$data = array();
			
		
		
			    $str_query = "select 
		
        		a.Id,
        		a.add_date,
        		a.description,
        		a.remark,
        		a.credit_amount,
        		a.debit_amount,
        		a.balance,
        		a.payment_id,
        		a.user_id,
				pay.cr_user_id,
				pay.dr_user_id,
				cr.businessname as cr_businessname,
				cr.username as cr_username,
				cr.usertype_name  as cr_usertype_name,
				dr.businessname as dr_businessname,
				dr.username as dr_username,
				dr.usertype_name  as dr_usertype_name,
				p.businessname as parent_name,
				p.username as parent_username,
				p.mobile_no as parent_mobile,
				p.usertype_name as parent_type
				
        		from tblewallet a 
        		left join tblusers b on a.user_id = b.user_id 
        		
        		
				left join tblpayment pay on a.payment_id = pay.payment_id
				left join tblusers cr on pay.cr_user_id = cr.user_id
				left join tblusers dr on pay.dr_user_id = dr.user_id
				left join tblusers p on cr.parentid = p.user_id
				
				
				
				 where 
				 a.user_id = ? and
				 Date(a.add_date) >= ? and
				 Date(a.add_date) <= ?
				 order by Id";
		$rslt = $this->db->query($str_query,array($this->session->userdata("DistId"),$from,$to));
			
			
				
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"add_date" => date_format(date_create($rw->add_date),'d-m-Y h:i:s A'), 
								    "Description" =>$rw->description, 
									"Remark" =>$rw->remark,
								    "CreditAmount" => $rw->credit_amount, 
									"DebitAmount" =>$rw->debit_amount, 
									"Balance" =>$rw->balance, 
									
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
    $fileName = "Account Ledger Report From ".$from." To  ".$to.".xls";
    
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